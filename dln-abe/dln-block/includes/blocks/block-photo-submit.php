<?php

if ( ! defined( 'WPINC' ) ) { die; }

include_once( DLN_ABE_PLUGIN_DIR . '/dln-block/includes/helpers/helper-photo-tmpl.php' );

class DLN_Block_Photo_Submit extends DLN_Block {
	
	public static $fields;
	public static $action;
	
	public static function init() {
		
	}
	
	public static function init_fields() {
		if ( self::$fields )
			retuirn;
		
		self::$fields = apply_filters(
			'dln_submit_photo_fields',
			
			array(
				'basic' => array(
					array(
						'id'    => 'product_img',
						'label' => __( 'Photo', DLN_ABE ),
						'type'  => 'select-photo',
					),
					array(
						'id'          => 'product_title',
						'label'       => __( 'Title', DLN_ABE ),
						'type'        => 'text',
						'value'       => '',
						'placeholder' => __( 'Product Title', DLN_ABE ),
						'required'    => true,
					),
					array(
						'id'          => 'product_category',
						'label'       => __( 'Category', DLN_ABE ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'value'       => '',
						'options'     => self::get_category_options(),
						'required'    => true,
					),
					array(
						'id'          => 'product_price',
						'label'       => __( 'Price', DLN_ABE ),
						'type'        => 'text-append',
						'value'       => '',
						'placeholder' => __( '', DLN_ABE ),
						'required'    => true,
						'append'      => __( '.000 vnđ', DLN_ABE ),
						'input_type'  => 'number',
					),
					array(
						'id'    => 'product_desc',
						'label' => __( 'Description', DLN_ABE ),
						'type'  => 'textcomplete',
						'class' => 'dln-textcomplete',
						'value' => '',
						'rows'  => '4',
					),
					array(
						'id'          => 'photobabe_mood',
						'label'       => __( 'Mood', DLN_ABE ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'value'       => '',
						'options'     => array(),//self::get_photobabe_mood_options(),
					),
					array(
						'id'          => 'photobabe_perm',
						'label'       => __( 'Permission', DLN_ABE ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'value'       => '',
						'options'     => array(
							'public'  => __( 'Public', DLN_ABE ),
							'private' => __( 'Private', DLN_ABE ),
						),
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
		
		DLN_Blocks::block_get_template( 'fields/' . $field_return['type'] . '-field.php', array( 'field' => $field_return ) );
	}
	
	public static function render_html() {
		self::init_fields();
		
		DLN_Blocks::block_load_frontend_assets();
		DLN_Block_Photo_Submit::load_frontend_assets();
		
		DLN_Blocks::block_get_template(
			'photo-submit.php',
			array(
				'fields'     => self::$fields
			)
		);
	}
	
	private static function get_category_options() {
		$categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'order_by' => 'term_id' ) );
		if ( empty( $categories ) || ! empty( $categories->errors ) ) {
			$result = new WP_Error( '500', __( 'Product Categories Not Found!', DLN_ABE ) );
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
	
	private static function load_frontend_assets() {
		wp_enqueue_script( 'dln-block-product-submit-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/block-product-submit.js', array( 'jquery' ), '1.0.0', true );
	}
}