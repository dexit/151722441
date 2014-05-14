<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Cron_Terms {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		// Require terms
		include( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/terms/class-dln-term-helper.php' );
		include( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/terms/class-dln-term-dln-source.php' );
		include( DLN_SKILL_PLUGIN_DIR . '/dln-cron/includes/terms/class-dln-term-dln-article.php' );
	}
}

DLN_Cron_Terms::get_instance();