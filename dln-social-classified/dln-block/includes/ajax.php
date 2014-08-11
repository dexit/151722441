<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Ajax {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'wp_ajax_dln_save_product_data', array( $this, 'dln_save_product_data' ) );
		add_action( 'wp_ajax_nopriv_dln_save_product_data', array( $this, 'dln_save_product_data' ) );
	}
	
	public function dln_save_product_data() {
		if ( ! isset( $_POST[DLN_CLF_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_CLF_NONCE], DLN_CLF_NONCE ) ) {
			$image_ids        = isset( $_POST['dln_image_id'] ) ? $_POST['dln_image_id'] : '';
			$product_title    = isset( $_POST['dln_product_title'] ) ? $_POST['dln_product_title'] : '';
			$product_category = isset( $_POST['dln_product_category'] ) ? $_POST['dln_product_category'] : '';
			$product_price    = isset( $_POST['dln_product_price'] ) ? $_POST['dln_product_price'] : '';
			$product_desc     = isset( $_POST['dln_product_desc'] ) ? $_POST['dln_product_desc'] : '';
			$product_fields   = isset( $_POST['dln_product_fields'] ) ? $_POST['dln_product_fields'] : '';
			$product_fields   = self::validate_product_fields( $product_fields );
			
			if ( ! empty( $image_ids ) && ! empty( $product_title ) && ! empty( $product_category ) &&
				 ! empty( $product_price ) ) {
				
				 	
				 	$user_id     = get_current_user_id();
				 	$product_cat = ( ! empty( $_POST['dln_fs_category'] ) ) ? $_POST['dln_fs_category'] : 'UnFashionCat';
				 	
				 	$post = array(
				 			'post_author'  => $user_id,
				 			'post_content' => $values['fashion']['description'],
				 			'post_status'  => 'pending',
				 			'post_title'   => $values['fashion']['title'],
				 			'post_parent'  => '',
				 			'post_type'    => 'product',
				 	);
				 	//Create post
				 	$post_id = wp_insert_post( $post, $wp_error );
				 	if ( $post_id ) {
				 		$attach_id = get_post_meta( $product->parent_id, '_thumbnail_id', true );
				 		add_post_meta( $post_id, '_thumbnail_id', $attach_id );
				 	}
				 	wp_set_object_terms( $post_id, $product_cat, 'product_cat' );
				 	wp_set_object_terms( $post_id, 'fashion', 'product_type' );
				 	
				 	update_post_meta( $post_id, '_visibility', 'visible' );
				 	//update_post_meta( $post_id, '_stock_status', 'instock' );
				 	//update_post_meta( $post_id, 'total_sales', '0' );
				 	//update_post_meta( $post_id, '_downloadable', 'yes' );
				 	//update_post_meta( $post_id, '_virtual', 'yes' );
				 	update_post_meta( $post_id, '_regular_price', '1' );
				 	update_post_meta( $post_id, '_sale_price', '1' );
				 	update_post_meta( $post_id, '_purchase_note', '' );
				 	//update_post_meta( $post_id, '_featured', 'no' );
				 	//update_post_meta( $post_id, '_weight', '' );
				 	//update_post_meta( $post_id, '_length', '' );
				 	//update_post_meta( $post_id, '_width', '' );
				 	//update_post_meta( $post_id, '_height', '' );
				 	//update_post_meta( $post_id, '_sku', '' );
				 	//update_post_meta( $post_id, '_product_attributes', array() );
				 	//update_post_meta( $post_id, '_sale_price_dates_from', '' );
				 	//update_post_meta( $post_id, '_sale_price_dates_to', '' );
				 	update_post_meta( $post_id, '_price', '1' );
				 	//update_post_meta( $post_id, '_sold_individually', '' );
				 	//update_post_meta( $post_id, '_manage_stock', 'no' );
				 	//update_post_meta( $post_id, '_backorders', 'no' );
				 	//update_post_meta( $post_id, '_stock', '' );
				 	
				 	if ( $user_id ) {
				 		update_post_meta( $post_id, '_item_type',  $values['fashion']['item_type'] );
				 		update_post_meta( $post_id, '_brand_name', $values['fashion']['brand_name'] );
				 		update_post_meta( $post_id, '_marterial',  $values['fashion']['marterial'] );
				 		update_post_meta( $post_id, '_reason',     $values['fashion']['reason'] );
				 		update_post_meta( $post_id, '_fashion_id', self::$fashion_id );
				 		if ( ! empty( $_POST['dln_fs_payment_price'] ) ) {
				 			$price = esc_attr( $_POST['dln_fs_payment_price'] );
				 			$price = str_replace( ',', '', $price );
				 			$price = str_replace( '.', '', $price );
				 			$price = intval( $price );
				 			if ( ! empty( $price ) && is_numeric( $price ) ) {
				 				$price += '000';
				 				update_post_meta( $post_id, '_dln_payment_price', serialize( $price ) );
				 			}
				 		}
				 	}
			}
		}
	}
	
	private function validate_product_fields( $product_fields ) {
		if ( ! $product_fields )
			return null;
		$product_fields = json_decode( $product_fields );
		
		$arr_fields = array();
		if ( is_array( $product_fields ) ) {
			foreach ( $product_fields as $i => $field ) {
				if ( isset( $field['key'] ) && isset( $field['value'] ) ) {
					$arr_fields[] = array( 'key' => $field['key'], 'value' => $field['value'] );
				}
			}
		}
		
		return $arr_fields;
	}
	
}
