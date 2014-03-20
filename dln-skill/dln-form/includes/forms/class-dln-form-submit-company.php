<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Company extends DLN_Form {
	
	public static $form_name = 'submit-company';
	protected static $company_id;
	protected static $preview_company;
	protected static $steps;
	protected static $step = 0;
	
	public static function init() {
		add_action( 'wp', array( $this, 'process' ) );
		
		self::$steps = (array) apply_filters( 'submit_company_steps', array(
			'submit' => array(
				'name'     => __( 'Submit Details', 'dln-skill' ),
				'view'     => array( $this, 'submit' ),
				'handler'  => array( $this, 'submit_handler' ),
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
			$company = get_post( self::$company_id );
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
			
			self::$fields = apply_filters( 'submit_company_form_fields_get_company_data', self::$fields, $user );
			
			wp_enqueue_script( 'dln-form-comany-submission' );
			
			dln_form_get_template( 'company-submit.php', array(
				'form'               => self::form_name,
				'company'            => self::get_company_id(),
				'action'             => self::get_action(),
				'profile_fields'     => self::get_fields( 'profile' ),
				'company_fields'     => self::get_fields( 'company' ),
				'submit_button_text' => __( 'Create Profile For Free', 'dln-skill' )
			) );
		}
	}
	
	public static function init_fields() {
		if ( self::$fields )
			return;
		
		self::$fields = apply_filters( 'submit_company_form_fields', array( 
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

	public static function get_company_id() {
		return absint( self::$company_id );
	}
}
