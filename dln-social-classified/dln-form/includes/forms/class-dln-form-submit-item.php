<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Submit_Item extends DLN_Form {
	
	public static $fields;
	
	public static function init() {
		
	}
	
	public static function init_fields() {
		if ( self::$fields )
			retuirn;
		
		self::$fields = apply_filters(
			'dln_submit_item_fields',
			array(
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
			)
		);
	}
	
}