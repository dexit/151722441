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

	public static function get_fields( $key = '', $raw = false ) {
		if ( empty( self::$fields ) ) {
			self::init_fields();
		}
		if ( ! $key )
			return '';
		
		$html = '';
		if ( is_array( self::$fields ) ) {
			foreach ( self::$fields as $i => $field ) {
				if ( $field['id'] == $key ) {
					if ( $raw == false ) {
						$html .= '<div class="form-group fieldset-' . esc_attr_e( $key ) . '">';
						if ( $field['label'] ) {
							$html .= '<label class="' . esc_attr( $field['parent_key_class'] ) . ' control-label" for="' . esc_attr_e( $key ) . '">' . balanceTags( $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', DLN_CLF ) . '</small>' ) ) . '</label>';
						}
						$html .= '<div class="' . esc_attr( $field['parent_value_class'] ) . '">';
						$html .= DLN_Form_Functions::form_get_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) );
						$html .= '</div>';
						$html .= '</div>';
					} else {
						$html = DLN_Form_Functions::form_get_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) );
					}
				}
			}
		}
		return $html;
	}
}