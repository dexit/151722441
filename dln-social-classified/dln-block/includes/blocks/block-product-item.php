<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Product_Item extends DLN_Block {
	
	public static $fields;
	public static $fashion_id = 0;
	public static $action;
	
	public static function init() {
		
	}
	
	public static function init_fields() {
		if ( self::$fields )
			retuirn;
		
		self::$fields = apply_filters(
			'dln_submit_item_fields',
			
			array(
				'basic' => array(
					array(
						'id'          => 'product_title',
						'label'       => __( 'Title', DLN_CLF ),
						'type'        => 'text',
						'value'       => '',
						'placeholder' => __( 'Product Title', DLN_CLF ),
						'required'    => true,
					),
					array(
						'id'          => 'product_category',
						'label'       => __( 'Category', DLN_CLF ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'value'       => '',
						'options'     => self::get_category_options(),
						'required'    => true,
					),
					/*array(
						'id'          => 'product_brand',
						'label'       => __( 'Brand', DLN_CLF ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'value'       => '',
						'options'     => self::get_brand_options(),
					),*/
					array(
						'id'          => 'product_price',
						'label'       => __( 'Price', DLN_CLF ),
						'type'        => 'text-append',
						'value'       => '',
						'placeholder' => __( '', DLN_CLF ),
						'required'    => true,
						'append'      => __( '.000 vnđ', DLN_CLF )
					),
					/*array(
						'id'          => 'product_color',
						'label'       => __( 'Color', DLN_CLF ),
						'type'        => 'select',
						'class'       => 'dln-selectize',
						'value'       => '',
						'options'     => self::get_color_options(),
						'multiple'    => true,
					),*/
					array(
						'id'          => 'product_desc',
						'label'       => __( 'Description', DLN_CLF ),
						'type'        => 'textarea',
						'class'       => 'dln-textntag',
						'value'       => '',
						'rows'        => '6',
						'required'    => true,
					),
					array(
						'id'          => 'product_gift',
						'label'       => __( 'Send a gift', DLN_CLF ),
						'type'        => 'checkbox',
						'value'       => '',
					),
					array(
						'id'          => 'product_swap',
						'label'       => __( 'Allow swap', DLN_CLF ),
						'type'        => 'checkbox',
						'value'       => '',
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
		self::load_frontend_assets();
		DLN_Blocks::block_get_template(
			'add-product-item.php',
			array(
				'fields'     => self::$fields,
				'fashion_id' => self::$fashion_id
			)
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_script( 'dln-parsley-js' );
		
	}
	
	private static function get_category_options() {
		$categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'order_by' => 'term_id' ) );
		if ( empty( $categories ) || ! empty( $categories->errors ) ) {
			$result = new WP_Error( '500', __( 'Product Categories Not Found!', DLN_CLF ) );
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
	
	private static function get_brand_options() {
		$brands = get_terms( 'dln_product_brand', array( 'hide_empty' => false, 'order_by' => 'name' ) );
		if ( empty( $brands ) || ! empty( $brands->errors ) ) {
			$result = new WP_Error( '500', __( 'Product Brands Not Found!', DLN_CLF ) );
			print( $result->get_error_message() );
			return null;
		}
		$options = array();
		if ( ! empty( $brands ) ) {
			foreach ( $brands as $i => $brand ) {
				$options[ $brand->term_id ] = $brand->name;
			}
		}
		
		return $options;
	}
	
	private static function get_color_options() {
		$colors = get_terms( 'dln_product_color', array( 'hide_empty' => false, 'order_by' => 'name' ) );
		if ( empty( $colors ) || ! empty( $colors->errors ) ) {
			$result = new WP_Error( '500', __( 'Product Colors Not Found!', DLN_CLF ) );
			print( $result->get_error_message() );
			return null;
		}
		$options = array();
		if ( ! empty( $colors ) ) {
			foreach ( $colors as $i => $color ) {
				$options[ $color->term_id ] = $color->name;
			}
		}
		
		return $options;
	}
	
	private static function item_types() {
		return array(
			'new'          => __( 'New', DLN_CLF ),
			'mint'         => __( 'Mint', DLN_CLF ),
			'satisfactory' => __( 'Satisfactory', DLN_CLF ),
			'very-good'    => __( 'Very Good', DLN_CLF ),
			'average'      => __( 'Average', DLN_CLF )
		);
	}
}