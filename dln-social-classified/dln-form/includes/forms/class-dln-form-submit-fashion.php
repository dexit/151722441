<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Fashion extends DLN_Form {
	
	public static $form_name         = 'submit-fashion';
	protected static $steps;
	protected static $step           = 0;
	protected static $fashion_id     = 0;
	protected static $fashion_fields = null;
	protected static $cache_fields   = null;
	
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'process' ) );
		
		self::$steps = (array) apply_filters(
			'submit_profile_steps',
			array(
				'submit' => array(
					'name'     => __( 'Submit Classified', DLN_CLF ),
					'view'     => array( __CLASS__, 'submit' ),
					'handler'  => array( __CLASS__, 'submit_handler' ),
					'priority' => 10,
				),
				'submit_thankyou' => array(
					'name'     => __( 'Thank you', DLN_CLF ),
					'view'     => array( __CLASS__, 'submit_thankyou' ),
					'priority' => 20,
				),
			)
		);
		
		uasort( self::$steps, array( __CLASS__, 'sort_by_priority' ) );
		
		if ( isset( $_POST['step'] ) ) {
			self::$step = is_numeric( $_POST['step'] ) ? max( absint( $_POST['step'] ), 0 ) : array_search( $_POST['step'], array_keys( self::$steps ) );
		} elseif ( ! empty( $_GET['step'] ) ) {
			self::$step = is_numeric( $_GET['step'] ) ? max( absint( $_GET['step'] ), 0 ) : array_search( $_GET['step'], array_keys( self::$steps ) );
		}
		
		self::$fashion_id = ! empty( $_REQUEST['fashion_id'] ) ? absint( $_REQUEST[ 'fashion_id' ] ) : 0;
		
		if ( self::$fashion_id && ! in_array( get_post_status( self::$fashion_id ), apply_filters( 'job_manager_valid_submit_job_statuses', array( 'preview' ) ) ) ) {
			self::$fashion_id = 0;
			self::$step   = 0;
		}
	}
	
	public static function submit() {
		global $post;
		
		self::init_fields();
		self::$fields = self::validate_post_fields( self::$fields );
		$page_title   = isset( self::$steps[ self::$step ]['name'] )        ? self::$steps[ self::$step ]['name'] : '';
		$page_desc    = isset( self::$steps[ self::$step ]['description'] ) ? self::$steps[ self::$step ]['description'] : '';
		
		DLN_Form_Functions::form_get_template(
			'fashion-submit.php',
			array(
				'page_title'         => $page_title,
				'page_description'   => $page_desc,
				'form'               => self::$form_name,
				'action'             => self::get_action(),
				'fashion_fields'     => self::get_fields( 'fashion' ),
				'fashion_id'         => self::$fashion_id,
				'step'               => self::$step,
				'submit_button'      => __( 'Sell now', DLN_CLF )
			)
		);
	}
	
	public static function submit_handler() {
		try {
			if ( empty( $_POST['submit_fashion'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_form_posted' ) )
				return;
			
			self::init_fields();
			
			// Validate POST
			$exclude_fields = array( 
				'dln_fs_category'  => __( 'Category', DLN_CLF ), 
				'dln_fs_tag_sizes' => __( 'Tag Sizes', DLN_CLF ), 
				'brand_name'       => __( 'Brand Name', DLN_CLF ),
				'dln_payment_type' => __( 'Payment', DLN_CLF ),
			);
			$errors = array();
			foreach ( $exclude_fields as $i => $exclude ) {
				if ( empty( $_POST[$i] ) ) {
					$error = new WP_Error( 'validation-error', sprintf( __( '%s is a required field', DLN_CLF ), $exclude ) );
					self::add_error( $error );
				}
			}
			
			if ( ! empty( $_POST['fashion_id'] ) ) {
				$excludes = array( 'map' );
				$values = self::get_posted_fields();
				$errors[] = self::validate_fields( $values );
			} else {
				$values = self::get_posted_fields();
				$errors[] = self::validate_fields( $values );
			}
			
			if ( ! empty( $errors ) ) {
				foreach ( $errors as $i => $error ) {
					if ( $error instanceof WP_Error )
						echo "<p class='help-block'>" . esc_html( $error->get_error_message() ) . '</p>';
				}
			}
			
			if ( ! is_user_logged_in() )
				throw new Exception( __( 'You must be signed in to post a new item.', DLN_CLF ) );
			
			if ( ! empty( $errors ) ) {
				self::$cache_fields = $values;
				self::$step         = 0;
			} else {
				// Update user profile
				self::update_fashion_data( $values );
				self::$step         = 1;
			}
		} catch ( Exception $e ) {
			$error = new WP_Error( 'validation-error', __( '%s is a required field', DLN_CLF ) );
			self::add_error( $e->getMessage() );
			self::reset();
			return;
		}
	}
	
	protected static function update_fashion_data( $values ) {
		$user_id     = get_current_user_id();
		$product_cat = ( ! empty( $_POST['dln_fs_category'] ) ) ? $_POST['dln_fs_category'] : 'UnFashionCat';
		
		$post = array(
			'post_author'  => $user_id,
			'post_content' => $values['fashion']['description'],
			'post_status'  => 'pending',
			'post_title'   => $values['fashion']['title'],
			'post_parent'  => '',
			'post_type'    => 'product',
		);
		//Create post
		$post_id = wp_insert_post( $post, $wp_error );
		if ( $post_id ) {
			$attach_id = get_post_meta( $product->parent_id, '_thumbnail_id', true );
			add_post_meta( $post_id, '_thumbnail_id', $attach_id );
		}
		wp_set_object_terms( $post_id, $product_cat, 'product_cat' );
		wp_set_object_terms( $post_id, 'fashion', 'product_type' );
		
		// Process tag ids
		$tag_ids     = ( ! empty( $_POST['dln_fs_tag_sizes'] ) ) ? $_POST['dln_fs_tag_sizes'] : '';
		if ( $tag_ids ) {
			$arr_ids = array();
			$tag_ids = explode( ',', $tag_ids );
			foreach ( $tag_ids as $i => $id ) {
				$arr_ids[] = (int) $id;
			}
			wp_set_object_terms( $post_id, $arr_ids, 'fashion_size_tag' );
		}
		
		// Process brands
		if ( ! empty( $values['fashion']['brand_name'] ) ) {
			$brand = $values['fashion']['brand_name'];
			//if ( ! term_exists( $brand, 'dln_fs_brand' ) ) {
			//	$brand_id = wp_insert_term( $brand, 'dln_fs_brand' );
			//}
			wp_set_object_terms( $post_id, $brand, 'dln_fs_brand' );
		}
		
		update_post_meta( $post_id, '_visibility', 'visible' );
		//update_post_meta( $post_id, '_stock_status', 'instock' );
		//update_post_meta( $post_id, 'total_sales', '0' );
		//update_post_meta( $post_id, '_downloadable', 'yes' );
		//update_post_meta( $post_id, '_virtual', 'yes' );
		update_post_meta( $post_id, '_regular_price', '1' );
		update_post_meta( $post_id, '_sale_price', '1' );
		update_post_meta( $post_id, '_purchase_note', '' );
		//update_post_meta( $post_id, '_featured', 'no' );
		//update_post_meta( $post_id, '_weight', '' );
		//update_post_meta( $post_id, '_length', '' );
		//update_post_meta( $post_id, '_width', '' );
		//update_post_meta( $post_id, '_height', '' );
		//update_post_meta( $post_id, '_sku', '' );
		//update_post_meta( $post_id, '_product_attributes', array() );
		//update_post_meta( $post_id, '_sale_price_dates_from', '' );
		//update_post_meta( $post_id, '_sale_price_dates_to', '' );
		update_post_meta( $post_id, '_price', '1' );
		//update_post_meta( $post_id, '_sold_individually', '' );
		//update_post_meta( $post_id, '_manage_stock', 'no' );
		//update_post_meta( $post_id, '_backorders', 'no' );
		//update_post_meta( $post_id, '_stock', '' );
		
		if ( $user_id ) {
			update_post_meta( $post_id, '_item_type',  $values['fashion']['item_type'] );
			update_post_meta( $post_id, '_brand_name', $values['fashion']['brand_name'] );
			update_post_meta( $post_id, '_marterial',  $values['fashion']['marterial'] );
			update_post_meta( $post_id, '_reason',     $values['fashion']['reason'] );
			update_post_meta( $post_id, '_fashion_id', self::$fashion_id );
			
			if ( ! empty( $_POST['dln_fs_address'] ) ) {
				update_post_meta( $post_id, '_dln_fs_address', $_POST['dln_fs_address'] );
			}
			if ( ! empty( $_POST['dln_fs_lat'] ) ) {
				update_post_meta( $post_id, '_dln_fs_lat', $_POST['dln_fs_lat'] );
			}
			if ( ! empty( $_POST['dln_fs_lng'] ) ) {
				update_post_meta( $post_id, '_dln_fs_lng', $_POST['dln_fs_lng'] );
			}
			if ( ! empty( $_POST['dln_fs_color_selected'] ) ) {
				$color_ids = $_POST['dln_fs_color_selected'];
				$arr_ids   = array();
				$color_ids = explode( ',', $color_ids );
				foreach ( $color_ids as $i => $id ) {
					$arr_ids[] = (int) $id;
				}
				wp_set_object_terms( $post_id, $arr_ids, 'dln_fs_color' );
			}
			if ( ! empty( $_POST['dln_fs_payment_type'] ) ) {
				$types = $_POST['dln_fs_payment_type'];
				$types = explode( ',', $types );
				if ( is_array( $types ) && ! empty( $types ) ) {
					$arr_validate = array();
					foreach ( $types as $i => $type ) {
						switch ( $type ) {
							case 'gift':
								$arr_validate[] = 'gift';
								break;
							case 'sale':
								$arr_validate[] = 'sale';
								break;
							case 'swap':
								$arr_validate = array( 'swap' );
								break;
						}
					}
					
					update_post_meta( $post_id, '_dln_payment_type', serialize( $arr_validate ) );
				}
			}
			if ( ! empty( $_POST['dln_fs_payment_price'] ) ) {
				$price = esc_attr( $_POST['dln_fs_payment_price'] );
				$price = str_replace( ',', '', $price );
				$price = str_replace( '.', '', $price );
				$price = intval( $price );
				if ( ! empty( $price ) && is_numeric( $price ) ) {
					$price += '000';
					update_post_meta( $post_id, '_dln_payment_price', serialize( $price ) );
				}
			}
		}
		self::$step = 2;
	
		do_action( 'dln_form_update_profile_data', self::$fashion_id, $values );
	}
	
	public static function init_fields() {
		if ( self::$fields )
			return;
	
		self::$fields = apply_filters(
			'submit_fashion_form_fields',
			array(
				'fashion' => array(
					'image_upload' => array(
						'label'        => '',
						'type'         => 'shortcode',
						'value'        => '[dln_upload theme="true"]',
						'priority'     => 1,
						'parent_value_class' => 'col-xs-12',
					),
					'title' => array(
						'label'       => __( 'Title', DLN_CLF ),
						'type'        => 'text',
						'required'    => true,
						'placeholder' => __( 'e.g: Red Zara Dress', DLN_CLF ),
						'priority'    => 2,
					),
					'item_type' => array(
						'label'       => __( 'Condition', DLN_CLF ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'required'    => true,
						'options'     => self::item_types(),
						'priority'    => 3,
					),
					'brand_name' => array(
						'label'       => __( 'Brand Name', DLN_CLF ),
						'type'        => 'brand',
						'required'    => false,
						'placeholder' => __( 'Typing to search...', DLN_CLF ),
						'priority'    => 4,
					),
					'description' => array(
						'label'       => __( 'Describe your item', DLN_CLF ),
						'type'        => 'textarea',
						'required'     => true,
						'placeholder' => __( 'e.g. a #greatblouse for your own style #vintage #hollister', DLN_CLF ),
						'priority'    => 5,
					),
					'marterial' => array(
						'label'       => __( 'Material', DLN_CLF ),
						'type'        => 'textarea',
						'required'     => false,
						'placeholder' => __( 'e.g. 60% cotton, 40% polyester', DLN_CLF ),
						'priority'    => 6,
					),
					'reason' => array(
						'label'       => __( 'Reason', DLN_CLF ),
						'type'        => 'textarea',
						'required'    => false,
						'placeholder' => __( 'Everything has a story, even clothes! Tell us the story of your item. Material, measurements – what makes it special!', DLN_CLF ),
						'priority'    => 7,
					),
					/*'map' => array(
						'label'       => __( 'Address', DLN_CLF ),
						'type'        => 'geocomplete',
						'required'    => false,
						'priority'    => 8,
						'parent_value_class' => 'col-xs-12',
						'parent_key_class'   => 'col-xs-12 dln-text-left'
					),*/
					'category' => array(
						'label'       => __( 'Select category for your item', DLN_CLF ),
						'type'        => 'fs-category',
						'required'    => false,
						'priority'    => 9,
						'parent_value_class' => 'col-xs-12',
						'parent_key_class'   => 'col-xs-12 dln-text-left',
					),
					'color' => array(
						'label'       => __( 'Please choose up to 2 colors', DLN_CLF ),
						'type'        => 'color-selector',
						'required'    => false,
						'priority'    => 10,
						'parent_value_class' => 'col-xs-12',
						'parent_key_class'   => 'col-xs-12 dln-text-left',
					),
					'payment' => array(
						'label'       => __( 'Payment method', DLN_CLF ),
						'type'        => 'paymethod',
						'required'    => false,
						'priority'    => 11,
						'parent_value_class' => 'col-xs-12',
						'parent_key_class'   => 'col-xs-12 dln-text-left',
					)
				),
				'company' => array(
					'company_website' => array(
						'label'       => __( 'Website', DLN_CLF ),
						'type'        => 'text',
						'required'    => true,
						'placeholder' => __( 'Website is required', DLN_CLF ),
						'priority'    => 1,
					),
				)
			)
		);
	}
	
	public static function process() {
		if ( ! empty( self::$errors ) ) {
			self::output();
			return false;
		}
		$keys = array_keys( self::$steps );
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['handler'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['handler'] );
		}
	}
	
	public static function output() {
		DLN_Form_Functions::load_frontend_assets();
		
		$keys = array_keys( self::$steps );
		
		if ( ! empty( self::$errors ) || isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['view'] ) ) {
			self::show_errors();
			call_user_func( self::$steps[ $keys[ self::$step ] ]['view'] );
		}
	}
	
	protected static function get_posted_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? sanitize_text_field( trim( stripslashes( $_POST[ $key ] ) ) ) : '';
	}
	
	protected static function validate_fields( $values, $exclude_fields = array() ) {
		foreach ( $values as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				if ( ! in_array( $key, $exclude_fields ) && isset( $field['required'] ) && empty( $values[ $group_key ][ $key ] ) ) {
					$error = new WP_Error( 'validation-error', sprintf( __( '%s is a required field', DLN_CLF ), $field['label'] ) );
					self::add_error( $error );
				}
			}
		}
	
		return apply_filters( 'submit_profile_form_validate_fields', true, self::$fields, $values );
	}
	
	protected static function get_posted_fields( $exclude_fields = array() ) {
		self::init_fields();
	
		$values = array();
	
		foreach ( self::$fields as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				if ( ! in_array( $key, $exclude_fields ) ) {
					// Get the value
					$field_type = str_replace( '-', '_', $field['type'] );
						
					if ( method_exists( __CLASS__, "get_posted_{$field_type}_field" ) )
						$values[ $group_key ][ $key ] = call_user_func( __CLASS__ . "::get_posted_{$field_type}_field", $key, $field );
					else
						$values[ $group_key ][ $key ] = self::get_posted_field( $key, $field );
						
					// Set fields value
					self::$fields[ $group_key ][ $key ]['value'] = $values[ $group_key ][ $key ];
				}
			}
		}
	
		return $values;
	}
	
	private static function validate_post_fields( $fields ) {
		if ( ! empty( $_POST ) ) {
			foreach ( self::$fields as $group_key => $_fields ) {
				foreach ( $_fields as $key => $field ) {
					if ( isset( $_POST[$key] ) ) {
						$fields[ $group_key ][ $key ]['value'] = $_POST[ $key ];
					}
				}
			}
		}
	
		return $fields;
	}
	
	private static function item_types() {
		return array(
			'new'          => __( 'New', DLN_CLF ),
			'mint'         => __( 'Mint', DLN_CLF ),
			'satisfactory' => __( 'Satisfactory', DLN_CLF ),
			'very-good'    => __( 'Very Good', DLN_CLF ),
			'average'      => __( 'Average', DLN_CLF )
		);
	}

	protected static function sort_by_priority( $a, $b ) {
		return $a['priority'] - $b['priority'];
	}
}