<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Profile extends DLN_Form {
	
	public static $form_name = 'submit-profile';
	protected static $preview_profile;
	protected static $steps;
	protected static $step = 0;
	protected static $company_id = 0;
	protected static $cache_fields = null;
	
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'process' ) );
		
		self::$steps = (array) apply_filters( 'submit_profile_steps', array(
			'submit' => array(
				'name'     => __( 'Submit Details', 'dln-skill' ),
				'view'     => array( __CLASS__, 'submit' ),
				'handler'  => array( __CLASS__, 'submit_handler' ),
				'priority' => 10
			),
			'submit_company' => array(
				'name'     => __( 'Submit Details', 'dln-skill' ),
				'view'     => array( __CLASS__, 'submit_company' ),
				'handler'  => array( __CLASS__, 'submit_company_handler' ),
				'priority' => 20
			) 
		) );
		
		uasort( self::$steps, array( __CLASS__, 'sort_by_priority' ) );
		
		// Get step/job
		if ( isset( $_POST['step'] ) ) {
			self::$step = is_numeric( $_POST['step'] ) ? max( absint( $_POST['step'] ), 0 ) : array_search( $_POST['step'], array_keys( self::$steps ) );
		} elseif ( ! empty( $_GET['step'] ) ) {
			self::$step = is_numeric( $_GET['step'] ) ? max( absint( $_GET['step'] ), 0 ) : array_search( $_GET['step'], array_keys( self::$steps ) );
		}
		self::$company_id = ! empty( $_REQUEST['company_id'] ) ? absint( $_REQUEST[ 'company_id' ] ) : 0;
		
		// Validate job ID if set
		if ( self::$company_id && ! in_array( get_post_status( self::$company_id ), apply_filters( 'job_manager_valid_submit_job_statuses', array( 'preview' ) ) ) ) {
			self::$company_id = 0;
			self::$step   = 0;
		}
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
	
	public static function submit_company() {
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
				
			dln_form_get_template( 'profile-company-submit.php', array(
			'form'               => self::$form_name,
			'action'             => self::get_action(),
			'profile_fields'     => self::get_fields( 'profile' ),
			'company_id'         => self::$company_id,
			'step'               => self::$step,
			'submit_button_text' => __( 'Create Profile For Free', 'dln-skill' )
			) );
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
				'company_id'         => self::$company_id,
				'step'               => self::$step,
				'submit_button_text' => __( 'Create Profile For Free', 'dln-skill' )
			) );
		}
	}

	public static function submit_handler() {
		try {
			if ( empty( $_POST['submit_profile'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_form_posted' ) )
				return;
		
			self::init_fields();
			
			$values = self::get_posted_fields();
			
			if ( is_wp_error( ( $return = self::validate_fields( $values ) ) ) )
				throw new Exception( $return->get_error_message() );
			
			if ( ! is_user_logged_in() )
				throw new Exception( __( 'You must be signed in to post a new profile.', 'dln-skill' ) );
			
			if ( empty( $_POST['company_id'] ) ) {
				self::$cache_fields = $values;
				self::$step = 1;
			}
		} catch ( Exception $e ) {
			self::add_error( $e->getMessage() );
			return;
		}
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
					'priority' => 7
				)
			),
			'company' => array(
				'company_website' => array(
					'label'       => __( 'Website', 'dln-skill' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Website is required', 'dln-skill' ),
					'priority'    => 1
				),
				'company_type' => array(
					'label'       => __( 'Company Type', 'dln-skill' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::company_types(),
					'placeholder' => __( 'Company Type is required', 'dln-skill' ),
					'priority'    => 2
				),
				'employ_number' => array(
					'label'       => __( 'Number of Employees', 'dln-skill' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::employ_number(),
					'placeholder' => __( 'Number of Employees is required', 'dln-skill' ),
					'priority'    => 3
				),
				'company_address' => array(
					'label'       => __( 'Company Address', 'dln-skill' ),
					'type'        => 'text-search',
					'required'    => true,
					'placeholder' => __( 'Company Address is required', 'dln-skill' ),
					'priority'    => 4
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

	public static function company_types() {
		$options = array();
		$terms = get_company_types_options();
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
		return $options;
	}
	
	public static function employ_number() {
		$options = get_employ_number_options();
		return $options;
	}
	
	/**
	 * Get the value of a posted field
	 * 
	 * @param  string $key
	 * @param  array $field
	 * 
	 * @return string
	 */
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
	
	/**
	 * Get the value of a posted field
	 * @param  string $key
	 * @param  array $field
	 * @return string
	 */
	protected static function get_posted_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? sanitize_text_field( trim( stripslashes( $_POST[ $key ] ) ) ) : '';
	}
	
	
	/**
	 * Validate the posted fields
	 *
	 * @return bool on success, WP_ERROR on failure
	 */
	protected static function validate_fields( $values ) {
		foreach( $values as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				if ( $field['required'] && empty( $values[ $group_key ][ $key ] ) ) {
					return new WP_Error( 'validation-error', sprintf( __( '%s is a required field', 'dln-skill' ), $field['label'] ) );
				}
			}
		}
		
		return apply_filters( 'submit_profile_form_validate_fields', true, self::$fields, $values );
	}
}
