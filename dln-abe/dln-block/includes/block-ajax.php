<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Block_Ajax {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		include( 'helpers/helper-fetch.php' );
		
		add_action( 'wp_ajax_dln_save_product_data',            array( $this, 'dln_save_product_data' ) );
		add_action( 'wp_ajax_nopriv_dln_save_product_data',     array( $this, 'dln_save_product_data' ) );
		add_action( 'wp_ajax_dln_fetch_images_from_url',        array( $this, 'dln_fetch_images_from_url' ) );
		add_action( 'wp_ajax_nopriv_dln_fetch_images_from_url', array( $this, 'dln_fetch_images_from_url' ) );
	}
	
	public function dln_save_product_data() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$data             = isset( $_POST['data'] ) ? $_POST['data'] : '';
			
			if ( ! DLN_Block_Cache::add_cache( $data ) ) {
				exit( '0' );
				return null;
			}
			
			$image_ids        = isset( $data['dln_image_id'] ) ? $data['dln_image_id'] : '';
			$product_title    = isset( $data['dln_product_title'] ) ? $data['dln_product_title'] : '';
			$product_category = isset( $data['dln_product_category'] ) ? $data['dln_product_category'] : '';
			$product_price    = isset( $data['dln_product_price'] ) ? $data['dln_product_price'] : '';
			$product_desc     = isset( $data['dln_product_desc'] ) ? $data['dln_product_desc'] : '';
			$product_fields   = isset( $data['dln_product_fields'] ) ? $data['dln_product_fields'] : '';
			$product_fields   = self::validate_product_fields( $product_fields );
			
			if ( ! empty( $image_ids ) && ! empty( $product_title ) && ! empty( $product_category ) &&
				 ! empty( $product_price ) ) {
				
			 	$user_id     = get_current_user_id();
			 	if ( ! $user_id ) {
			 		exit( '0' );
			 		return null;
			 	}
			 	
			 	$post = array(
		 			'post_author'  => $user_id,
		 			'post_content' => $product_desc,
		 			'post_status'  => 'pending',
		 			'post_title'   => $product_title,
		 			'post_parent'  => '',
		 			'post_type'    => 'product',
			 	);
			 	//Create post
			 	$post_id = wp_insert_post( $post );
			 	if ( $post_id ) {
			 		$attach_id = get_post_meta( $product->parent_id, '_thumbnail_id', true );
			 		add_post_meta( $post_id, '_thumbnail_id', $attach_id );
			 		wp_set_object_terms( $post_id, $product_category, 'product_cat' );
			 		$product_price = ( ! empty( $product_price ) ) ? (int) $product_price : 0;
			 		$product_price .= '000';
			 		update_post_meta( $post_id, '_price', $product_price );
			 			
			 		if ( ! empty( $product_fields ) && is_array( $product_fields ) ) {
			 			foreach ( $product_fields as $i => $field ) {
			 				if ( ! empty( $field['key'] ) && ! empty( $field['value'] ) ) {
								$key = sanitize_key( $field['key'] );
								$key = str_replace( '-', '_', $key );
								update_post_meta( $post_id, 'dln_post_meta_' . $key . '_key', $field['key'] );
								update_post_meta( $post_id, 'dln_post_meta_' . $key . '_value', $field['value'] );
			 				}
			 			}
			 		}
			 	}
			 	echo $post_id;
			 	exit( '1' );
			}
		}
		exit( '1' );
	}
	
	public function dln_fetch_images_from_url() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$url = isset( $_POST['url'] ) ? $_POST['url'] : '';
			
			if ( ! empty( $url ) && filter_var($url, FILTER_VALIDATE_URL) !== false ) {
				$fetch_helper = DLN_Helper_Fetch::get_instance();
				$image_urls   = $fetch_helper->fetch_images_from_url( $url );
			}
			$image_urls = ( ! empty( $image_urls ) ) ? json_encode( $image_urls ) : '';
			exit( $image_urls );
		}
		exit();
	}
	
	private function validate_product_fields( $product_fields ) {
		if ( empty( $product_fields ) )
			return null;
		
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

DLN_Block_Ajax::get_instance();
