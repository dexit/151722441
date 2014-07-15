<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Fashion extends DLN_Form {
	
	public static $form_name         = 'submit-fashion';
	protected static $steps;
	protected static $step           = 0;
	protected static $fashion_id     = 0;
	protected static $fashion_fields = null;
	
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
		if ( $user_id ) {
			update_user_meta( $user_id, '_first_name', $values['profile']['first_name'] );
			update_user_meta( $user_id, '_last_name', $values['profile']['last_name'] );
			update_user_meta( $user_id, '_work_email', $values['profile']['work_email'] );
			update_user_meta( $user_id, '_job_title', $values['profile']['job_title'] );
			update_user_meta( $user_id, '_is_hr', $values['profile']['is_hr'] );
			update_user_meta( $user_id, '_company_id', self::$company_id );
		}
		self::$step = 2;
	
		do_action( 'dln_form_update_profile_data', self::$company_id, $values );
	}
	
	public static function init_fields() {
		if ( self::$fields )
			return;
	
		self::$fields = apply_filters( 'submit_fashion_form_fields', array(
			'common' => array(
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
					'required'    => true,
					'options'     => self::item_types(),
					'priority'    => 2
				),
				'brand_name' => array(
					'label'       => __( 'Brand Name', DLN_CLF ),
					'type'        => 'text-search',
					'required'    => false,
					'placeholder' => __( 'Typing to search...', DLN_CLF ),
					'priority'    => 5
				),
				'description' => array(
					'label'       => __( 'Describe your item', DLN_CLF ),
					'type'        => 'text-area',
					'require'     => true,
					'placeholder' => __( 'e.g. a #greatblouse for your own style #vintage #hollister', DLN_CLF ),
				),
				'marterial' => array(
					'label'       => __( 'Material', DLN_CLF ),
					'type'        => 'text-area',
					'require'     => false,
					'placeholder' => __( 'e.g. 60% cotton, 40% polyester', DLN_CLF ),
				),
				'reason' => array(
					'label'       => __( 'Reason', DLN_CLF ),
					'type'        => 'text-area',
					'require'     => false,
					'placeholder' => __( 'Everything has a story, even clothes! Tell us the story of your item. Material, measurements – what makes it special!', DLN_CLF ),
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
				'company_type' => array(
					'label'       => __( 'Company Type', DLN_CLF ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::company_types(),
					'placeholder' => __( 'Company Type is required', DLN_CLF ),
					'priority'    => 2
				),
				'employ_number' => array(
					'label'       => __( 'Number of Employees', DLN_CLF ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::employ_number(),
					'placeholder' => __( 'Number of Employees is required', DLN_CLF ),
					'priority'    => 3
				),
				'company_address' => array(
					'label'       => __( 'Company Address', DLN_CLF ),
					'type'        => 'text-search',
					'required'    => true,
					'placeholder' => __( 'Company Address is required', DLN_CLF ),
					'priority'    => 4
				)
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
}