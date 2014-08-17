<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Block' ) ) {
	/**
	 * Abstract DLN_Form class.
	 *
	 * @abstract
	 */
	abstract class DLN_Block {
	
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
	
	}
}
