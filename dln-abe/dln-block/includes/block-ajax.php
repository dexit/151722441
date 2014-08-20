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
		add_action( 'wp_ajax_dln_dln_save_items',                 array( $this, 'dln_save_items' ) );
		add_action( 'wp_ajax_nopriv_dln_save_items',              array( $this, 'dln_save_items' ) );
		add_action( 'wp_ajax_dln_dln_save_topic',                 array( $this, 'dln_save_topic' ) );
		add_action( 'wp_ajax_nopriv_dln_save_topic',              array( $this, 'dln_save_topic' ) );
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
	
	public function dln_listing_image_instagram() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$action_type = isset( $_POST['action_type'] ) ? $_POST['action_type'] : '';
			$max_id      = isset( $_POST['max_id'] ) ? $_POST['max_id'] : '';
			
			$user_id = get_current_user_id();
			if ( $user_id ) {
				$insta_access_token = get_user_meta( $user_id, 'dln_instagram_access_token', true );
				$insta_uid          = get_user_meta( $user_id, 'dln_instagram_user_id', true );
				
				if ( $insta_uid && $insta_access_token ) {
					switch( $action_type ) {
						case 'after':
							$url = 'https://api.instagram.com/v1/users/' . $insta_uid . '/media/recent/?count=20&max_id=' . $max_id . '&access_token=' . $insta_access_token;
						break;
						case 'before':
							$url = 'https://api.instagram.com/v1/users/' . $insta_uid . '/media/recent/?count=20&min_id=' . $max_id . '&access_token=' . $insta_access_token;
						break;
						default:
							$url = 'https://api.instagram.com/v1/users/' . $insta_uid . '/media/recent/?count=20&access_token=' . $insta_access_token;
						break;
					}
					$obj    = @file_get_contents( $url );
					$obj    = ( ! empty( $obj ) ) ? json_decode( $obj ) : '';
					$images = array();
					if ( ! empty( $obj->data ) && is_array( $obj->data ) ) {
						foreach ( $obj->data as $i => $image ) {
							if ( ! empty( $image->id ) && ! empty( $image->images->standard_resolution->url ) ) {
								$images[] = array( 'id' => $image->id, 'picture' => $image->images->standard_resolution->url );
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
					switch( $action_type ) {
						case 'after':
							$url = 'https://graph.facebook.com/v2.1/' . $fb_user_id . '/photos/uploaded?limit=20&after=' . $page_code . '&access_token=' . $fb_access_token;
						break;
						
						case 'before':
							$url = 'https://graph.facebook.com/v2.1/' . $fb_user_id . '/photos/uploaded?limit=20&before=' . $page_code . '&access_token=' . $fb_access_token;
						break;
						
						default:
							$url = 'https://graph.facebook.com/v2.1/' . $fb_user_id . '/photos/uploaded?limit=20&access_token=' . $fb_access_token;
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
			$post_fb = isset( $_POST['post_fb'] ) ? $_POST['post_fb'] : '';
			$user_id = get_current_user_id();
			
			// Validate picture
			$pic_url = self::validate_url_image( $pic_url );
			
			// Validate permission
			$perm = self::validate_perm( $perm );
			
			if ( ! empty( $message ) && ! empty( $user_id ) ) {
				$data = array(
					'pic_url' => $pic_url,
					'message' => esc_html( $message ),
					'perm'    => $perm,
					'user_id' => $user_id,
				);
				
				if ( ! DLN_Block_Cache::add_cache( $data ) ) {
					exit('0');
					return null;
				}
				
				// Post to facebook wall
				$fb_link = '';
				if ( $post_fb ) {
					$fb_access_token = get_user_meta( $user_id, 'dln_facebook_access_token', true );
					$fb_user_id      = get_user_meta( $user_id, 'dln_facebook_user_id', true );
					
					if ( $fb_access_token && $fb_user_id ) {
						$data = array(
							'url'     => $pic_url,
							'message' => $content,
						);	
						$url = 'https://graph.facebook.com/v2.1/' . $fb_user_id . '/photos?access_token=' . $fb_access_token;
						$options = array(
							'http' => array(
								'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
								'method'  => 'POST',
								'content' => http_build_query( $data ),
							)
						);
						$context = stream_context_create( $options );
						$fb_obj  = @file_get_contents( $url, false, $context );
						if ( $fb_obj && ! empty( $fb_obj->link ) ) {
							$fb_link = $fb_obj->link;
						}
					}
				}
				
				$args = array(
					'post_status'  => 'publish',
					'post_type'    => 'dln_status',
					'post_author'  => $user_id,
					'post_content' => esc_html( $message )
				);
				$post_id = wp_insert_post( $args );
				
				if ( $post_id ) {
					update_post_meta( $post_id, 'dln_pic_url', $pic_url );
					update_post_meta( $post_id, 'dln_perm', $perm );
					
					if ( $fb_uid ) {
						update_post_meta( $post_id, 'dln_fb_link', $fb_link );
					}
				}
				
				$args = array_merge( array( 'post_id' => $post_id ), $data );
				exit( json_encode( $args ) );
			}
		}
		exit('0');
	}
	
	public function dln_save_topic() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$pic_url  = isset( $_POST['pic_url'] ) ? $_POST['pic_url'] : '';
			$message  = isset( $_POST['message'] ) ? $_POST['message'] : '';
			$forum_id = isset( $_POST['forum_id'] ) ? (int) $_POST['forum_id'] : 0;
			$user_id  = get_current_user_id();
			
			// Validate picture
			$pic_url = self::validate_url_image( $pic_url );
			
			if ( ! empty( $message ) && ! empty( $user_id ) ) {
				$message = esc_html( $message );
				$data    = array(
					'pic_url'  => $pic_url,
					'message'  => $message,
					'user_id'  => $user_id,
					'forum_id' => $forum_id, 
				);
				
				if ( ! DLN_Block_Cache::add_cache( $data ) ) {
					exit('0');
					return null;
				}
				
				$title      = wp_trim_words( $message, 20, '...' );
				$topic_data = array(
					'post_title'   => $title,
					'post_content' => $message,
					'post_author'  => $user_id,
					'post_status'  => 'pending',
				);
				$topic_meta = array(
					'forum_id' => $forum_id,
				);
				$topic_id = bbp_insert_topic( $topic_data, $topic_meta );
				
				$args = array_merge( array( 'topic_id' => $topic_id ), $data );
				exit( json_encode( $args ) );
			}
		}
		exit('0');
	}
	
	private static function validate_perm( $perm = 'publish' ) {
		if ( ! $perm )
			return null;
		
		if ( ! in_array( $perm, array( 'public', 'private' ) ) ) {
			$perm = 'public';
		}
		
		return $perm;
	}
	
	private static function validate_url_image( $url = '' ) {
		if ( ! $url )
			return null;
		
		$url = ( ! empty( $url ) && filter_var( $url, FILTER_VALIDATE_URL ) !== false ) ? $url : '';
			
		if ( ! empty( $url ) ) {
			$url_headers = get_headers( $url, 1 );
		
			if( isset( $url_headers['Content-Type'] ) ){
				$type = strtolower( $url_headers['Content-Type'] );
		
				$valid_image_type = array();
				$valid_image_type['image/png']  = '';
				$valid_image_type['image/jpg']  = '';
				$valid_image_type['image/jpeg'] = '';
				$valid_image_type['image/gif']  = '';
		
				if( ! isset( $valid_image_type[ $type ] ) ){
					$url = null;
				}
			}
		}
		
		return $url;
	}
	
}

DLN_Block_Ajax::get_instance();
