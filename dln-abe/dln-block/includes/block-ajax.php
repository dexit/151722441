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
		
		add_action( 'wp_ajax_dln_load_block_modal',               array( $this, 'dln_load_block_modal' ) );
		add_action( 'wp_ajax_nopriv_dln_load_block_modal',        array( $this, 'dln_load_block_modal' ) );
		add_action( 'wp_ajax_dln_listing_image_facebook',         array( $this, 'dln_listing_image_facebook' ) );
		add_action( 'wp_ajax_nopriv_dln_listing_image_facebook',  array( $this, 'dln_listing_image_facebook' ) );
		add_action( 'wp_ajax_dln_listing_image_instagram',        array( $this, 'dln_listing_image_instagram' ) );
		add_action( 'wp_ajax_nopriv_dln_listing_image_instagram', array( $this, 'dln_listing_image_instagram' ) );
	}
	
	public function dln_load_block_modal() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$block = isset( $_POST['block'] ) ? $_POST['block'] : '';
			if ( empty ( $block ) )
				exit('0');
			
			$modal_content = DLN_Blocks::get_block( sanitize_title( $block ) );
			
			$arr_result = array( 'status' => 'success', 'content' => $modal_content );
			echo json_encode( $arr_result );
			die();
		}
		exit('0');
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
	
	public function dln_listing_image_instagram() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$action_type = isset( $_POST['action_type'] ) ? $_POST['action_type'] : '';
			$max_id      = isset( $_POST['max_id'] ) ? $_POST['max_id'] : '';
			
			$user_id = get_current_user_id();
			if ( $user_id ) {
				$insta_access_token = get_user_meta( $user_id, 'dln_instagram_accesss_token', true );
				$insta_uid          = get_user_meta( $user_id, 'dln_instagram_user_id', true );
			
				if ( $insta_uid && $insta_access_token ) {
					switch( $action_type ) {
						case 'next':
							$url = 'https://api.instagram.com/v1/users/' . $insta_uid . '/feed?count=20&max_id=' . $max_id . 'access_token=' . $insta_access_token;
							break;
						case 'previous':
							$url = 'https://api.instagram.com/v1/users/' . $insta_uid . '/feed?count=20&max_id=' . $max_id . '&access_token=' . $insta_access_token;
							break;
						default:
							$url = 'https://api.instagram.com/v1/users/' . $insta_uid . '/feed?count=20&access_token=' . $insta_access_token;
							break;
					}
					$obj    = @file_get_contents( $url );
					$obj    = ( ! empty( $obj ) ) ? json_decode( $obj ) : '';
					$images = array();
					if ( ! empty( $obj->data ) && is_array( $obj->data ) ) {
						foreach ( $obj->data as $i => $image ) {
							if ( ! empty( $image->id ) && ! empty( $image->images->standard_resolution ) ) {
								$images[] = array( 'id' => $image->id, 'picture' => $image->images->standard_resolution );
							}
						}
					}
						
					$max_id = '';
					if ( ! empty( $obj->pagination->next_max_id ) ) {
						$max_id = $obj->pagination->next_max_id;
					}
					
					$arr_result = array( 'status' => 'success', 'images' => $images, 'max_id' => $max_id );
					
					echo json_encode( $arr_result );
					exit();
				}
			}
		}
		exit('0');
	}
	
	public function dln_listing_image_facebook() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$action_type = isset( $_POST['action_type'] ) ? $_POST['action_type'] : '';
			$page_code   = isset( $_POST['page_code'] ) ? $_POST['page_code'] : '';
			
			$user_id = get_current_user_id();
			if ( $user_id ) {
				$fb_access_token = get_user_meta( $user_id, 'dln_facebook_access_token', true );
				$fb_user_id      = get_user_meta( $user_id, 'dln_facebook_user_id', true );
				if ( $fb_user_id && $fb_access_token ) {
					switch( $action ) {
						case 'next':
							$url = 'https://graph.facebook.com/v2.0/' . $fb_user_id . '/photos/uploaded?limit=20&after=' . $page_code . '&access_token=' . $fb_access_token;
						break;
						
						case 'previous':
							$url = 'https://graph.facebook.com/v2.0/' . $fb_user_id . '/photos/uploaded?limit=20&before=' . $page_code . '&access_token=' . $fb_access_token;
						break;
						
						default:
							$url = 'https://graph.facebook.com/v2.0/' . $fb_user_id . '/photos/uploaded?limit=20&access_token=' . $fb_access_token;
						break;
					}
					$obj    = @file_get_contents( $url );
					$obj    = ( ! empty( $obj ) ) ? json_decode( $obj ) : '';
					$images = array();
					
					if ( ! empty( $obj->data ) && is_array( $obj->data ) ) {
						foreach ( $obj->data as $i => $image ) {
							if ( ! empty( $image->id ) && ! empty( $image->source ) ) {
								$images[] = array( 'id' => $image->id, 'picture' => $image->source );
							}
						}
					}
					
					$after = '';
					if ( ! empty( $obj->paging->cursors->after ) ) {
						// Process paging after
						$after = $obj->paging->cursors->after;
					}
					
					$before = '';
					if ( ! empty( $obj->paging->cursors->before ) ) {
						// Process paging before
						$before = $obj->paging->cursors->before;
					}
					
					$arr_result = array( 'status' => 'success', 'images' => $images, 'after' => $after, 'before' => $before );
					
					echo json_encode( $arr_result );
					exit();
				}
			}
		}
		exit('0');
	}
	
	public function dln_fetch_images_from_url() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$url = isset( $_POST['url'] ) ? $_POST['url'] : '';
			
			if ( ! empty( $url ) && filter_var( $url, FILTER_VALIDATE_URL ) !== false ) {
				$fetch_helper = DLN_Helper_Fetch::get_instance();
				$image_urls   = $fetch_helper->fetch_images_from_url( $url );
			}
			$image_urls = ( ! empty( $image_urls ) ) ? json_encode( $image_urls ) : '';
			exit( $image_urls );
		}
		exit();
	}
	
	public function dln_save_items() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$pic_url = isset( $_POST['pic_url'] ) ? $_POST['pic_url'] : '';
			$message = isset( $_POST['message'] ) ? $_POST['message'] : '';
			$perm    = isset( $_POST['perm'] ) ? $_POST['perm'] : 'public';
			$pic_url = ( ! empty( $pic_url ) && filter_var( $pic_url, FILTER_VALIDATE_URL ) !== false ) ? $pic_url : '';
			$user_id = get_current_user_id();
			
			
			if ( ! empty( $message ) && ! empty( $user_id ) ) {
				
				$data = array_merge( $pic_url, $message, $perm, $user_id );
				if ( ! DLN_Block_Cache::add_cache( $data ) ) {
					exit( '0' );
					return null;
				}
				
				$args = array(
					'post_status'  => 'publish',
					'post_type'    => 'dln_status',
					'post_author'  => $user_id,
					'post_content' => esc_html( $message )
				);
				$post_id = wp_insert_post( $args );
				
			}
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
