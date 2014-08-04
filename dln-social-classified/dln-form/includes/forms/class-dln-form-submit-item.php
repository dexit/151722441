<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Item extends DLN_Form {
	
	public static $fields;
	public static $fashion_id = 0;
	
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
			/*array(
				'image_upload' => array(
					'label'        => '',
					'type'         => 'shortcode',
					'value'        => '[dln_upload theme="true"]',
				),
				'title' => array(
					'label'       => __( 'Title', DLN_CLF ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => __( 'e.g: Red Zara Dress', DLN_CLF ),
				),
				'item_type' => array(
					'label'       => __( 'Condition', DLN_CLF ),
					'type'        => 'select',
					'class'       => 'dln-selectize',
					'required'    => true,
					'options'     => self::item_types(),
				),
				'brand_name' => array(
					'label'       => __( 'Brand Name', DLN_CLF ),
					'type'        => 'brand',
					'required'    => false,
					'placeholder' => __( 'Typing to search...', DLN_CLF ),
				),
				'description' => array(
					'label'       => __( 'Describe your item', DLN_CLF ),
					'type'        => 'textarea',
					'required'     => true,
					'placeholder' => __( 'e.g. a #greatblouse for your own style #vintage #hollister', DLN_CLF ),
				),
				'marterial' => array(
					'label'       => __( 'Material', DLN_CLF ),
					'type'        => 'textarea',
					'required'     => false,
					'placeholder' => __( 'e.g. 60% cotton, 40% polyester', DLN_CLF ),
				),
				'reason' => array(
					'label'       => __( 'Reason', DLN_CLF ),
					'type'        => 'textarea',
					'required'    => false,
					'placeholder' => __( 'Everything has a story, even clothes! Tell us the story of your item. Material, measurements – what makes it special!', DLN_CLF ),
				),
				'color' => array(
					'label'       => __( 'Please choose up to 2 colors', DLN_CLF ),
					'type'        => 'color-selector',
					'required'    => false,
				),
				'category' => array(
					'label'       => __( 'Select category for your item', DLN_CLF ),
					'type'        => 'fs-category',
					'required'    => false,
				),
				'payment' => array(
					'label'       => __( 'Payment method', DLN_CLF ),
					'type'        => 'paymethod',
					'required'    => false,
				)
			)*/
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
	
	public static function render_page() {
		self::init_fields();
		
		DLN_Form_Functions::load_frontend_assets();
		DLN_Form_Functions::form_get_template(
			'submit-item.php',
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