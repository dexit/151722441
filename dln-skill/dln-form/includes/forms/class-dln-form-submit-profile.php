<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Profile extends DLN_Form {
	
	public static $form_name = 'submit-profile';
	protected static $preview_profile;
	protected static $steps;
	protected static $step = 0;
	
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'process' ) );
		
		self::$steps = (array) apply_filters( 'submit_profile_steps', array(
			'submit' => array(
				'name'     => __( 'Submit Details', 'dln-skill' ),
				'view'     => array( __CLASS__, 'submit' ),
				'handler'  => array( __CLASS__, 'submit_handler' ),
				'priority' => 10
			),
		) );
	}
	
	/**
	 * Process function. all processing code if needed - can also change view if step is complete
	 */
	public static function process() {
		$keys = array_keys( self::$steps );
		
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['handler'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['handler'] );
		}
	}
	
	public static function submit() {
		global $post;
		
		self::init_fields();
		if ( is_user_logged_in() && empty( $_POST ) ) {
			$user = wp_get_current_user();
			
			if ( $user ) {
				foreach ( self::$fields as $group_key => $fields ) {
					foreach ( $fields as $key => $field ) {
						switch( $key ) {
							case 'first_name' :
								self::$fields[ $group_key ][ $key ]['value'] = $user->user_firstname;
								break;
							case 'last_name' :
								self::$fields[ $group_key ][ $key ]['value'] = $user->user_lastname;
								break;
							case 'email' :
								self::$fields[ $group_key ][ $key ]['value'] = $user->user_email;
								break;
						}
					}
				}
			}
			
			self::$fields = apply_filters( 'submit_profile_form_fields_get_profile_data', self::$fields, $user );
			
			wp_enqueue_script( 'dln-form-profile-submission' );
			
			dln_form_get_template( 'profile-submit.php', array(
				'form'               => self::$form_name,
				'action'             => self::get_action(),
				'profile_fields'     => self::get_fields( 'profile' ),
				'submit_button_text' => __( 'Create Profile For Free', 'dln-skill' )
			) );
		}
	}

	public static function submit_handler() {
		//try {
			self::init_fields();
			
			$values = self::get_posted_fields();
			
			if ( empty( $_POST['submit_profile'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_form_posted' ) )
				return;
			
			if ( is_wp_error( ( $return = self::validate_fields( $values ) ) ) )
				throw new Exception( $return->get_error_message() );
		//}
	}
	
	public static function init_fields() {
		if ( self::$fields )
			return;
		
		self::$fields = apply_filters( 'submit_profile_form_fields', array( 
			'profile' => array(
				'first_name' => array(
					'label'       => __( 'First Name', 'dln-skill' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'First Name is required', 'dln-skill' ),
					'priority'    => 1
				),
				'last_name' => array(
					'label'       => __( 'Last Name', 'dln-skill' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Last Name is required', 'dln-skill' ),
					'priority'    => 2
				),
				'email' => array(
					'label'       => __( 'Work Email', 'dln-skill' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Work Email is required', 'dln-skill' ),
					'priority'    => 3
				),
				'job_title' => array(
					'label'       => __( 'Job Title', 'dln-skill' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Job Title is required', 'dln-skill' ),
					'priority'    => 4
				),
				'company_title' => array(
					'label'       => __( 'Company', 'dln-skill' ),
					'type'        => 'text-search',
					'required'    => true,
					'placeholder' => __( 'Company is required', 'dln-skill' ),
					'priority'    => 5
				),
				'is_hr' => array(
					'label'    => __( 'I represent HR at my company', 'dln-skill' ),
					'type'     => 'checkbox',
					'priority' => 6
				)
			)
		 ) );
	}

	/**
	 * output function. Call the view handler.
	 */
	public static function output() {
		$keys = array_keys( self::$steps );
		
		self::show_errors();
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['view'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['view'] );
		}
	}

	protected static function get_posted_fields() {
		self::init_fields();
		
		$values = array();
		
		foreach ( self::$fields as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
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
		
		return $values;
	}
}
