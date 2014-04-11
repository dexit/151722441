<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Point extends DLN_Form {
	public static $form_name = 'submit-point';
	protected static $preview_point;
	protected static $steps;
	protected static $step = 0;
	protected static $point_id = 0;
	
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'process' ) );
		
		self::$steps = (array) apply_filters( 'submit_profile_steps', array(
			'submit' => array(
				'name'     => __( 'Submit Point', 'dln-point' ),
				'view'     => array( __CLASS__, 'submit' ),
				'handler'  => array( __CLASS__, 'submit_handler' ),
				'priority' => 10
			),
			'submit_thankyou' => array(
				'name'     => __( 'Thank you', 'dln-point' ),
				'view'     => array( __CLASS__, 'submit_thankyou' ),
				'priority' => 30
			),
		) );
		
		// Get step/job
		if ( isset( $_POST['step'] ) ) {
			self::$step = is_numeric( $_POST['step'] ) ? max( absint( $_POST['step'] ), 0 ) : array_search( $_POST['step'], array_keys( self::$steps ) );
		} elseif ( ! empty( $_GET['step'] ) ) {
			self::$step = is_numeric( $_GET['step'] ) ? max( absint( $_GET['step'] ), 0 ) : array_search( $_GET['step'], array_keys( self::$steps ) );
		}
		
		self::$point_id = ! empty( $_REQUEST['point_id'] ) ? absint( $_REQUEST[ 'point_id' ] ) : 0;
	}
	
	public static function process() {
		$keys = array_keys( self::$steps );
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['handler'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['handler'] );
		}
	}
	
	public static function submit() {
		global $post;
		
		self::init_fields();
		$user         = get_current_user();
		self::$fields = self::validate_post_fields( self::$fields );
		self::$fields = apply_filters( 'submit_point_form_fields_get_point_data', self::$fields, $user );
		$page_title   = isset( self::$steps[self::$step]['name'] ) ? self::$steps[self::$step]['name'] : '';
		$page_desc    = isset( self::$steps[self::$step]['description'] ) ? self::$steps[self::$step]['description'] : '';
		
		wp_enqueue_script( 'dln-form-profile-submission' );
			
		dln_form_get_template( 'point-submit.php', array(
			'page_title'         => $page_title,
			'page_description'   => $page_desc,
			'form'               => self::$form_name,
			'action'             => self::get_action(),
			'point_fields'       => self::get_fields( 'point' ),
			'online_infor'       => self::get_fields( 'online_infor' ),
			'extra_fields'       => self::get_fields( 'extra_fields' ),
			'point_id'           => self::$point_id,
			'step'               => self::$step,
			'submit_button_text' => __( 'Create Point For Free', DLN_POINT_SLUG )
		) );
	}
	
	public static function init_fields() {
		if ( self::$fields )
			return;
	
		self::$fields = apply_filters( 'submit_profile_form_fields', array(
			'point' => array(
				'name' => array(
					'label'       => __( 'Name', DLN_POINT_SLUG ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Name is required', DLN_POINT_SLUG ),
					'priority'    => 1
				),
				'address' => array(
					'label'       => __( 'Address', DLN_POINT_SLUG ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Address is required', DLN_POINT_SLUG ),
					'priority'    => 2
				),
				'city' => array(
					'label'       => __( 'City', DLN_POINT_SLUG ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'City is required', DLN_POINT_SLUG ),
					'priority'    => 3
				),
				'zipcode' => array(
					'label'       => __( 'Zip', DLN_POINT_SLUG ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'Zip is required', DLN_POINT_SLUG ),
					'priority'    => 4
				),
				'open_status' => array(
					'label'       => __( 'Open Status', DLN_POINT_SLUG ),
					'type'        => 'radio',
					'required'    => true,
					'default'     => get_first_option( get_open_status() ),
					'options'     => get_open_status(),
					'priority'    => 5
				),
			),
			'online_infor' => array(
				'website' => array(
					'label'       => __( 'Website address (URL)', DLN_POINT_SLUG ),
					'type'        => 'text',
					'required'    => true,
					'default'     => get_site_url(),
					'placeholder' => __( 'Website address is required', DLN_POINT_SLUG ),
					'priority'    => 1
				),
				'fb_address' => array(
					'label'       => __( 'Facebook address (URL)', DLN_POINT_SLUG ),
					'type'        => 'text',
					'required'    => true,
					'default'     => 'http://www.facebook.com/pages/The-Pine-Box/299233916777600',
					'placeholder' => __( 'Facebook address is required', DLN_POINT_SLUG ),
					'priority'    => 2
				),
			),
			'extra_fields' => array(
				'price_range' => array(
					'label'       => __( 'Price range', DLN_POINT_SLUG ),
					'type'        => 'radio',
					'required'    => true,
					'default'     => get_first_option( self::get_point_price_range() ),
					'options'     => self::get_point_price_range(),
					'priority'    => 1
				),
				'list_food' => array(
					'label'       => __( 'List of food', DLN_POINT_SLUG ),
					'type'        => 'checkbox',
					'options'     => self::get_list_foods(),
					'required'    => true,
					'priority'    => 2
				),
				'special_feature' => array(
					'label'       => __( 'Special feature', DLN_POINT_SLUG ),
					'type'        => 'checkbox',
					'options'     => self::get_list_features(),
					'required'    => true,
					'priority'    => 3
				),
				'suggestion_comment' => array(
					'label'       => __( 'Suggestion', DLN_POINT_SLUG ),
					'type'        => 'textarea',
					'required'    => true,
					'placeholder' => __( 'Please note: Any text you enter in this field will <b>only</b> be seen by NDD staff. ', DLN_POINT_SLUG ),
					'priority'    => 5
				)
			)
		) );
	}
	
	public static function output() {
		dln_load_frontend_assets();
		
		$keys = array_keys( self::$steps );
		
		self::show_errors();
		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['view'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['view'] );
		}
	}
	
	private static function get_point_price_range() {
		$options = array();
		$terms = dln_get_point_price_range();
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
		return $options;
	}
	
	private static function get_list_foods() {
		$options = array();
		$terms = dln_get_point_list_foods();
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
		return $options;
	}
	
	private static function get_list_features() {
		$options = array();
		$terms = dln_get_point_list_feature();
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
		return $options;
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
}