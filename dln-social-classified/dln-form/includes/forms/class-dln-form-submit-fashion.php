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
		
		self::$steps = (array) apply_filters( 'submit_profile_steps', array(
			'submit' => array(
				'name'     => __( 'Submit Classified', DLN_CLF ),
				'view'     => array( __CLASS__, 'submit' ),
				'handler'  => array( __CLASS__, 'submit_handler' ),
				'priority' => 10
			),
			'submit_thankyou' => array(
				'name'     => __( 'Thank you', DLN_CLF ),
				'view'     => array( __CLASS__, 'submit_thankyou' ),
				'priority' => 20
			),
		) );
		
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
		
		DLN_Form_Functions::form_get_template( 'fashion-submit.php', array(
			'page_title'         => $page_title,
			'page_description'   => $page_desc,
			'form'               => self::$form_name,
			'action'             => self::get_action(),
			'fashion_fields'     => self::get_fields( 'fashion' ),
			'fashion_id'         => self::$fashion_id,
			'step'               => self::$step,
			'submit_button'      => __( 'Sell now', DLN_CLF )
		) );
	}
	
	public static function submit_handler() {
		try {
			if ( empty( $_POST['submit_fashion'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_form_posted' ) )
				return;
			
			self::init_fields();
			
			if ( ! empty( $_POST['fashion_id'] ) ) {
				$exclude_fields = array( 'company_website', 'company_type', 'employ_number', 'company_address' );
				$values = self::get_posted_fields( $exclude_fields );
				$return = self::validate_fields( $values, $exclude_fields );
			} else {
				$values = self::get_posted_fields();
				$return = self::validate_fields( $values );
			}
			
			if ( is_wp_error( ( $return ) ) )
				throw new Exception( $return->get_error_message() );
			
			if ( ! is_user_logged_in() )
				throw new Exception( __( 'You must be signed in to post a new item.', DLN_CLF ) );
			if ( empty( $_POST['fashion_id'] ) ) {
				self::$cache_fields = $values;
				self::$step         = 1;
			} else {
				// Update user profile
				self::update_fashion_data( $values );
			}
			
		} catch ( Exception $e ) {
			self::add_error( $e->getMessage() );
			self::reset();
			return;
		}
	}
	
	protected static function update_fashion_data( $values ) {
		$user_id = get_current_user_id();
		
		$post = array(
			'post_author'  => $user_id,
			'post_content' => '',
			'post_status'  => 'pending',
			'post_title'   => $product->part_num,
			'post_parent'  => '',
			'post_type'    => 'product',
		
		);
		//Create post
		$post_id = wp_insert_post( $post, $wp_error );
		if( $post_id ){
			$attach_id = get_post_meta( $product->parent_id, '_thumbnail_id', true );
			add_post_meta( $post_id, '_thumbnail_id', $attach_id );
		}
		wp_set_object_terms( $post_id, 'Races', 'product_cat' );
		wp_set_object_terms( $post_id, 'simple', 'product_type' );
		
		
		
		update_post_meta( $post_id, '_visibility', 'visible' );
		update_post_meta( $post_id, '_stock_status', 'instock' );
		update_post_meta( $post_id, 'total_sales', '0' );
		update_post_meta( $post_id, '_downloadable', 'yes' );
		update_post_meta( $post_id, '_virtual', 'yes' );
		update_post_meta( $post_id, '_regular_price', '1' );
		update_post_meta( $post_id, '_sale_price', '1' );
		update_post_meta( $post_id, '_purchase_note', '' );
		update_post_meta( $post_id, '_featured', 'no' );
		update_post_meta( $post_id, '_weight', '' );
		update_post_meta( $post_id, '_length', '' );
		update_post_meta( $post_id, '_width', '' );
		update_post_meta( $post_id, '_height', '' );
		update_post_meta( $post_id, '_sku', '' );
		update_post_meta( $post_id, '_product_attributes', array() );
		update_post_meta( $post_id, '_sale_price_dates_from', '' );
		update_post_meta( $post_id, '_sale_price_dates_to', '' );
		update_post_meta( $post_id, '_price', '1' );
		update_post_meta( $post_id, '_sold_individually', '' );
		update_post_meta( $post_id, '_manage_stock', 'no' );
		update_post_meta( $post_id, '_backorders', 'no' );
		update_post_meta( $post_id, '_stock', '' );
		
		
		if ( $user_id ) {
			update_user_meta( $user_id, '_item_type',  $values['fashion']['item_type'] );
			update_user_meta( $user_id, '_brand_name', $values['fashion']['brand_name'] );
			update_user_meta( $user_id, '_marterial',  $values['fashion']['marterial'] );
			update_user_meta( $user_id, '_reason',     $values['fashion']['reason'] );
			update_user_meta( $user_id, '_fashion_id', self::$fashion_id );
		}
		self::$step = 2;
	
		do_action( 'dln_form_update_profile_data', self::$company_id, $values );
	}
	
	public static function init_fields() {
		if ( self::$fields )
			return;
	
		self::$fields = apply_filters( 'submit_fashion_form_fields', array(
			'fashion' => array(
				'title' => array(
					'label'       => __( 'Title', DLN_CLF ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'e.g: Red Zara Dress', DLN_CLF ),
					'priority'    => 1
				),
				'item_type' => array(
					'label'       => __( 'Condition', DLN_CLF ),
					'type'        => 'select',
					'class'       => 'dln-selectize',
					'required'    => true,
					'options'     => self::item_types(),
					'priority'    => 2
				),
				'brand_name' => array(
					'label'       => __( 'Brand Name', DLN_CLF ),
					'type'        => 'text-search',
					'required'    => false,
					'placeholder' => __( 'Typing to search...', DLN_CLF ),
					'priority'    => 4
				),
				'description' => array(
					'label'       => __( 'Describe your item', DLN_CLF ),
					'type'        => 'textarea',
					'required'     => true,
					'placeholder' => __( 'e.g. a #greatblouse for your own style #vintage #hollister', DLN_CLF ),
					'priority'    => 5
				),
				'marterial' => array(
					'label'       => __( 'Material', DLN_CLF ),
					'type'        => 'textarea',
					'required'     => false,
					'placeholder' => __( 'e.g. 60% cotton, 40% polyester', DLN_CLF ),
					'priority'    => 6
				),
				'reason' => array(
					'label'       => __( 'Reason', DLN_CLF ),
					'type'        => 'textarea',
					'required'     => false,
					'placeholder' => __( 'Everything has a story, even clothes! Tell us the story of your item. Material, measurements – what makes it special!', DLN_CLF ),
					'priority'    => 7
				),
			),
			'company' => array(
				'company_website' => array(
					'label'       => __( 'Website', DLN_CLF ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Website is required', DLN_CLF ),
					'priority'    => 1
				),
			)
		) );
	}
	
	public static function process() {
		$keys = array_keys( self::$steps );
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['handler'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['handler'] );
		}
	}
	
	public static function output() {
		DLN_Form_Functions::load_frontend_assets();
		
		$keys = array_keys( self::$steps );
		
		self::show_errors();
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['view'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['view'] );
		}
	}
	
	protected static function get_posted_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? sanitize_text_field( trim( stripslashes( $_POST[ $key ] ) ) ) : '';
	}
	
	protected static function validate_fields( $values, $exclude_fields = array() ) {
		foreach( $values as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				if ( ! in_array( $key, $exclude_fields ) && isset( $field['required'] ) && empty( $values[ $group_key ][ $key ] ) ) {
					return new WP_Error( 'validation-error', sprintf( __( '%s is a required field', 'dln-skill' ), $field['label'] ) );
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
						$fields[ $group_key ][ $key ]['value'] = $_POST[$key];
					}
				}
			}
		}
	
		return $fields;
	}
	
	private static function item_types() {
		return array (
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