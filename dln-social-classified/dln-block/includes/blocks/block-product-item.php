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
						'id'    => 'item_title',
						'value' => __( 'Sample Title', DLN_CLF )
					),
					array(
						'id'    => 'item_desc',
						'value' => ''
					)
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
	
	public static function render_html() {
		self::init_fields();
		
		DLN_Blocks::block_load_frontend_assets();
		DLN_Blocks::block_get_template(
			'add-product-item.php',
			array(
				'fields'     => self::$fields,
				'fashion_id' => self::$fashion_id
			)
		);
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