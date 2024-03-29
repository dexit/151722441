<?php

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Abstract DLN_Form class.
 *
 * @abstract
 */
abstract class DLN_Form {

	protected static $fields;
	protected static $action;
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
		foreach ( self::$errors as $error )
			echo '<div class="dln-error">' . $error . '</div>';
	}

	/**
	 * Get action
	 *
	 * @return string
	 */
	public static function get_action() {
		return self::$action;
	}

	/**
	 * get_fields function.
	 *
	 * @access public
	 * @param mixed $key
	 * @return array
	 */
	public static function get_fields( $key ) {
		if ( empty( self::$fields[ $key ] ) )
			return array();

		$fields = self::$fields[ $key ];

		uasort( $fields, __CLASS__ . '::priority_cmp' );

		return $fields;
	}

	/**
	 * priority_cmp function.
	 *
	 * @access private
	 * @param mixed $a
	 * @param mixed $b
	 * @return void
	 */
	public static function priority_cmp( $a, $b ) {
	    if ( $a['priority'] == $b['priority'] )
	        return 0;
	    return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
	}
	
}