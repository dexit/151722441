<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Admin_PostType {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'init', array( $this, 'dln_company_status_filters' ) );
	}
	
	public function dln_company_status_filters() {
		$types = self::get_company_status();
		foreach ( $types as $name => $type ) {
			register_post_status( $name, array(
				'label'       => $type,
				'private'     => true,
				'_builtin'    => true, /* internal use only. */
				'label_count' => _n_noop( $type . ' <span class="count">(%s)</span>', $type . ' <span class="count">(%s)</span>' ),
			) );
		}
	}
	
	public static function get_company_status() {
		return (array) apply_filters( 'dln_form_company_status', array(
			'company_pending'      => __( 'Company Pending', 'dln-skill' ),
			'company_publish'      => __( 'Company Published', 'dln-skill' ),
			'company_ban'          => __( 'Company Banned', 'dln-skill' ),
		) );
	}
	
}

DLN_Form_Admin_PostType::get_instance();