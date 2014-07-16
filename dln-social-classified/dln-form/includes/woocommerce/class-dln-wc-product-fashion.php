<?php

if ( ! defined( 'WPINC' ) ) { die; }

class WC_Product_Fashion extends WC_Product {

	public function __construct( $product ) {
		$this->product_type = 'dln_fashion';

		parent::__construct( $product );
	}

}
