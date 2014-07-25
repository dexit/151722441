<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( class_exists( 'WC_Product' ) ) {
	class WC_Product_Fashion extends WC_Product {
	
		public function __construct( $product ) {
			$this->product_type = 'dln_fashion';
	
			parent::__construct( $product );
		}
	
	}
}
