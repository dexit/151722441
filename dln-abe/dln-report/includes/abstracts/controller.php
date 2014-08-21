<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Controller' ) ) {
	
	/**
	 * Abstract DLN_Form class.
	 *
	 * @abstract
	 */
	abstract class DLN_Controller {
	
		protected static $fields;
		protected static $errors = array();
	
		/**
		 * Add an error
		 * @param string $error
		*/
		public static function add_error( $error ) {
			self::$errors[] = $error;
		}
	
		/**
		 * Show errors
		 */
		public static function show_errors() {
			foreach ( self::$errors as $error ) {
				if ( $error instanceof WP_Error ) {
					echo '<div class="dln-error">' . $error->get_error_message() . '</div>';
				}
			}
			self::$errors = null;
		}
	
		/**
		 * Get action
		 *
		 * @return string
		 */
		public static function get_action() {
			return self::$action;
		}
	
		public static function controller_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
			if ( $args && is_array( $args ) )
				extract( $args );
		
			include( self::controller_locate_template( $template_name, $template_path, $default_path ) );
		}
		
		public static function controller_locate_template( $template_name, $template_path = '', $default_path = '' ) {
			if ( ! $template_path )
				$template_path = 'dln_report';
			if ( ! $default_path )
				$default_path = DLN_ABE_PLUGIN_DIR . '/dln-report/includes/views/';
		
			$template = locate_template(
				array(
					trailingslashit( $template_path ) . $template_name,
					$template_name,
				)
			);
		
			// Get default template
			if ( ! $template )
				$template = $default_path . $template_name;
		
			// Return what we found
			return apply_filters( 'dln_report_locate_template', $template, $template_name, $template_path );
		}
	}
}
