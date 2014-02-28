<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Job_Form_Submit_Freelance extends DLN_Job_Form {
	
	public static $form_name = 'submit-freelance';
	protected static $job_id;
	protected static $preview_job;
	protected static $steps;
	protected static $step = 0;
	
	public static function init() {
		add_action( 'wp', array( $this, 'process' ) );
		
		self::$steps = (array) apply_filters( 'submit_job_steps', array(
			'submit' => array(
				'name'     => __( 'Submit Details', DLN_SLUG ),
				'view'     => array( $this, 'submit' ),
				'handler'  => array( $this, 'submit_handler' ),
				'priority' => 10
			),
			'preview' => array(
				'name'     => __( 'Preview', DLN_SLUG ),
				'view'     => array( $this, 'preview' ),
				'handler'  => array( $this, 'preview_handler' ),
				'priority' => 20
			)
		) );
		
		uasort( self::$steps, array( $this, 'sort_by_priority' ) );
		
		// Get step/job
		if ( isset( $_POST['step'] ) ) {
			self::$step = is_numeric( $_POST['step'] ) ? max( absint( $_POST['step'] ), 0 ) : array_search( $_POST['step'], array_keys( self::$steps ) );
		} elseif ( ! empty( $_GET['step'] ) ) {
			self::$step = is_numeric( $_GET['step'] ) ? max( absint( $_GET['step'] ), 0 ) : array_search( $_GET['step'], array_keys( self::$steps ) );
		}
		self::$job_id = ! empty( $_REQUEST['job_id'] ) ? absint( $_REQUEST[ 'job_id' ] ) : 0;
		
		// Validate job ID if set
		if ( self::$job_id && ! in_array( get_post_status( self::$job_id ), apply_filters( 'dln_job_valid_submit_job_statuses', array( 'preview' ) ) ) ) {
			self::$job_id = 0;
			self::$step   = 0;
		}
	}
	
	public static function init_fields() {
		
	}
	
	public static function submit() {
		global $dln_job, $post;
		
		self::init_fields();
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
	
	/**
	 * Sort array by priority value
	 */
	protected static function sort_by_priority( $a, $b ) {
		return $a['priority'] - $b['priority'];
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
	
}
