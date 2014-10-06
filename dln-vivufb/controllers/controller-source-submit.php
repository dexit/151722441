<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Controller_Source_Submit {
	
	public static $fields;
	public static $action;
	
	public static function init() { }
	
	public static function init_fields() {
		if ( self::$fields )
			retuirn;
		
		self::$fields = apply_filters(
			'dln_submit_product_fields',
			
			array(
				'basic' => array(
					array(
						'id'    => 'source_link',
						'label' => __( 'FB Link', DLN_VVF ),
						'type'  => 'fetch-source',
						'value' => '',
						'placeholder' => __( 'FB Link', DLN_VVF )
					),
					array(
						'id'    => 'source_title',
						'label' => __( 'Title', DLN_VVF ),
						'type'  => 'text',
						'value' => '',
						'placeholder' => __( 'Source Title', DLN_VVF )
					),
					array(
						'id'          => 'source_category',
						'label'       => __( 'Category', DLN_PRO ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'value'       => '',
						'options'     => self::get_category_options(),
						'required'    => true,
					),
					array(
						'id'          => 'source_tag',
						'label'       => __( 'Tag', DLN_PRO ),
						'type'        => 'select',
						'class'       => 'dln-selectize-create',
						'value'       => '',
						'options'     => self::get_tag_options(),
						'required'    => false,
						'multiple'    => true
					),
				)
			)
		);
	}
	
	public static function validate_fields( $group_field = '', $fields = array() ) {
		if ( empty( self::$fields ) ) {
			self::get_fields();
		}
		
		if ( empty( self::$fields[ $group_field ] ) ) {
			return null;
		}
		
		$arr_results  = array();
		$group_fields = self::$fields[ $group_field ];		
		if ( is_array( $fields ) ) {
			foreach( $fields as $i => $field ) {
				foreach ( $group_fields as $j => $default_field ) {
					if ( $field['id'] == $default_field['id'] ) {
						$arr_results[] = $field;
					}
				}
			}
		}
		
		return apply_filter( 'dln_form_submit_item_validate_fields', $arr_results, $group_field, $fields );
	}
	
	public static function get_field( $group_field = '', $field_id = '', $value = array() ) {
		if ( empty( self::$fields ) ) {
			self::init_fields();
		}
		if ( empty( self::$fields[ $group_field ] ) )
			return null;
		
		$group_fields = self::$fields[ $group_field ];
		$field_return = null;
		foreach ( $group_fields as $i => $field ) {
			if ( $field_id == $field['id'] ) {
				$field_return = $field;
				if ( ! empty( $value ) ) {
					$field_return['value'] = $value;
				}
			}
		}
		
		DLN_Common_Template::get_template( 'fields/' . $field_return['type'] . '-field.php', array( 'field' => $field_return ) );
	}
	
	public static function render() {
		self::init_fields();
		
		DLN_Common_Template::load_frontend_assets();
		//DLN_Controller_Product_Submit::load_frontend_assets();
		
		DLN_Common_Template::get_template(
			'view-source-submit.php',
			array(
				'fields'     => self::$fields
			)
		);
	}
	
	private static function get_category_options() {
		$categories = get_terms( 'source_cat', array( 'hide_empty' => false, 'order_by' => 'term_id' ) );
		if ( empty( $categories ) || ! empty( $categories->errors ) ) {
			$result = new WP_Error( '500', __( 'Categories Not Found!', DLN_VVF ) );
			return $result;
		}
		$options = array();
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $i => $category ) {
				$options[ $category->term_id ] = $category->name;
			}
		}
		return $options;
	}
	
	private static function get_tag_options() {
		$terms = get_terms( 'source_tag', array( 'hide_empty' => false, 'order_by' => 'term_id' ) );
		
		$options = array();
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $i => $term ) {
				$options[ $term->name ] = $term->name;
			}
		}
		
		return $options;
	}
	
	private static function load_frontend_assets() {
	}
}