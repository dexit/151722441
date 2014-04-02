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
			),
			'submit_thankyou' => array(
				'name'     => __( 'Thank you', 'dln-skill' ),
				'view'     => array( __CLASS__, 'submit_thankyou' ),
				'priority' => 30
			),
		) );
		
		uasort( self::$steps, array( __CLASS__, 'sort_by_priority' ) );
		
		// Get step/job
		if ( ! empty( $_GET['step'] ) ) {
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
		var_dump($_POST, self::$step);
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['handler'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['handler'] );
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
				'work_email' => array(
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
					'label'    => '',
					'type'     => 'checkbox',
					'options'  => array(
						'true' => __( 'I represent HR at my company', 'dln-skill' )
					),
					'required' => false,
					'priority' => 6
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
		$options = array();
		$terms = get_employ_number_options();
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
		return $options;
	}
	
	public static function submit() {
		global $post;
	
		self::init_fields();
		if ( is_user_logged_in() && empty( $_POST ) ) {
			$user = wp_get_current_user();
			
			if ( ! empty( $user ) ) {
				foreach ( self::$fields as $group_key => $fields ) {
					foreach ( $fields as $key => $field ) {
						switch( $key ) {
							case 'first_name' :
								self::$fields[ $group_key ][ $key ]['value'] = $user->user_firstname;
								break;
							case 'last_name' :
								self::$fields[ $group_key ][ $key ]['value'] = $user->user_lastname;
								break;
							case 'work_email' :
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
	
	public static function submit_company() {
		self::init_fields();
		
		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();
	
			if ( ! empty( $user ) && ! empty( self::$cache_fields ) ) {
				foreach ( self::$fields as $group_key => $fields ) {
					foreach ( $fields as $key => $field ) {
						switch( $key ) {
							case 'first_name' :
								self::$fields[ $group_key ][ $key ]['value'] = self::$cache_fields[$group_key]['first_name'];
								break;
							case 'last_name' :
								self::$fields[ $group_key ][ $key ]['value'] = self::$cache_fields[$group_key]['last_name'];
								break;
							case 'work_email' :
								self::$fields[ $group_key ][ $key ]['value'] = self::$cache_fields[$group_key]['work_email'];
								break;
							case 'job_title' :
								self::$fields[ $group_key ][ $key ]['value'] = self::$cache_fields[$group_key]['job_title'];
								break;
							case 'company_title' :
								self::$fields[ $group_key ][ $key ]['value'] = self::$cache_fields[$group_key]['company_title'];
								break;
							case 'is_hr' :
								self::$fields[ $group_key ][ $key ]['value'] = self::$cache_fields[$group_key]['is_hr'];
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
			'company_fields'     => self::get_fields( 'company' ),
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
	
			if ( ! empty( $_POST['company_id'] ) ) {
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
				throw new Exception( __( 'You must be signed in to post a new profile.', 'dln-skill' ) );
			if ( empty( $_POST['company_id'] ) ) {
				self::$cache_fields = $values;
				self::$step         = 1;
			} else {
				// Update user profile
				self::update_profile_data( $values );
			}
			
		} catch ( Exception $e ) {
			self::add_error( $e->getMessage() );
			self::reset();
			return;
		}
	}
	
	public static function submit_company_handler() {
		try {
			if ( empty( $_POST['submit_profile_company'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_form_posted' ) )
				return;
			
			self::init_fields();
	
			$values = self::get_posted_fields();
	
			if ( is_wp_error( ( $return = self::validate_fields( $values ) ) ) )
				throw new Exception( $return->get_error_message() );
	
			if ( ! is_user_logged_in() )
				throw new Exception( __( 'You must be signed in to post a new profile.', 'dln-skill' ) );
			
			if ( empty( $_POST['company_id'] ) ) {
				// Create company profile
				self::save_company( $values['profile']['company_title'], 'company_pending', $values );
				self::update_company_data( $values );
			} else {
				self::reset();
			}
			
			// Update user profile 
			self::update_profile_data( $values );
			
		} catch ( Exception $e ) {
			self::add_error( $e->getMessage() );
			self::reset();
			return;
		}
	}
	
	public static function reset() {
		self::$step = 0;
		self::$company_id = 0;
		self::$cache_fields = null;
		$_POST = null;
	} 
	
	/**
	 * Update or create a company profile from posted data
	 *
	 * @param  string $company_title
	 * @param  string $status
	 * @param  array $values
	 */
	protected static function save_company( $company_title, $status = 'pending', $values ) {
		$company_slug = array();
		
		// Prepend with company title
		$company_slug[] = $company_title;
		
		// Prepend with company address
		if ( ! empty( $values['company']['company_address'] ) )
			$company_slug[] = $values['company']['company_address'];
		
		$company_data = apply_filters( 'submit_profile_company_save_data', array( 
			'post_title'     => $company_title,
			'post_name'      => sanitize_title( implode( '-', $company_slug ) ),
			'post_content'   => '',
			'post_type'      => DLN_COMPANY_SLUG,
			'comment_status' => 'open'
		), $company_title, $status, $values );
		
		if ( $status )
			$company_data['post_status'] = $status;
		
		if ( self::$company_id ) {
			$company_data['ID'] = self::$company_id;
			wp_update_post( $company_data );
		} else {
			self::$company_id = wp_insert_post( $company_data );
		}
	}	
	
	/**
	 * Set company meta + terms based on posted values
	 *
	 * @param  array $values
	 */
	protected static function update_company_data( $values ) {
		wp_set_object_terms( self::$company_id, array( $values['company']['company_type'] ), DLN_COMPANY_TYPE_SLUG, false );
		
		wp_set_object_terms( self::$company_id, array( $values['company']['employ_number'] ), DLN_EMPLOYEE_NUMBER_SLUG, false );
		
		update_post_meta( self::$company_id, '_company_website', $values['company']['company_website'] );
		update_post_meta( self::$company_id, '_company_address', $values['company']['company_address'] );
		
		do_action( 'dln_form_update_company_data', self::$company_id, $values );
	}
	
	protected static function update_profile_data( $values ) {
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
	
	/**
	 * Get the value of a posted field
	 * 
	 * @param  string $key
	 * @param  array $field
	 * 
	 * @return string
	 */
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
	 * Get the value of a posted checkbox field
	 * @param  string $key
	 * @param  array $field
	 * @return array
	 */
	protected static function get_posted_checkbox_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? array_map( 'sanitize_text_field',  $_POST[ $key ] ) : array();
	}
	
	/**
	 * Get the value of a posted select field
	 * @param  string $key
	 * @param  array $field
	 * @return array
	 */
	protected static function get_posted_select_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? array_map( 'sanitize_text_field',  $_POST[ $key ] ) : array();
	}
	
	/**
	 * Validate the posted fields
	 *
	 * @return bool on success, WP_ERROR on failure
	 */
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

	protected static function sort_by_priority( $a, $b ) {
		return $a['priority'] - $b['priority'];
	}
}
