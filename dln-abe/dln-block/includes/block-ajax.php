<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Block_Ajax' ) ) :

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
		
		add_action( 'wp_ajax_dln_save_product_data',              array( $this, 'dln_save_product_data' ) );
		add_action( 'wp_ajax_nopriv_dln_save_product_data',       array( $this, 'dln_save_product_data' ) );
		add_action( 'wp_ajax_dln_add_product',                    array( $this, 'dln_add_product' ) );
		add_action( 'wp_ajax_nopriv_dln_add_product',             array( $this, 'dln_add_product' ) );
		add_action( 'wp_ajax_dln_fetch_images_from_url',          array( $this, 'dln_fetch_images_from_url' ) );
		add_action( 'wp_ajax_nopriv_dln_fetch_images_from_url',   array( $this, 'dln_fetch_images_from_url' ) );
		add_action( 'wp_ajax_dln_download_image_from_url',        array( $this, 'dln_download_image_from_url' ) );
		add_action( 'wp_ajax_nopriv_dln_download_image_from_url', array( $this, 'dln_download_image_from_url' ) );
		add_action( 'wp_ajax_dln_load_block_modal',               array( $this, 'dln_load_block_modal' ) );
		add_action( 'wp_ajax_nopriv_dln_load_block_modal',        array( $this, 'dln_load_block_modal' ) );
		add_action( 'wp_ajax_dln_listing_image_facebook',         array( $this, 'dln_listing_image_facebook' ) );
		add_action( 'wp_ajax_nopriv_dln_listing_image_facebook',  array( $this, 'dln_listing_image_facebook' ) );
		add_action( 'wp_ajax_dln_listing_image_instagram',        array( $this, 'dln_listing_image_instagram' ) );
		add_action( 'wp_ajax_nopriv_dln_listing_image_instagram', array( $this, 'dln_listing_image_instagram' ) );
		add_action( 'wp_ajax_dln_save_photo',                     array( $this, 'dln_save_photo' ) );
		add_action( 'wp_ajax_nopriv_dln_save_photo',              array( $this, 'dln_save_photo' ) );
		add_action( 'wp_ajax_dln_save_topic',                     array( $this, 'dln_save_topic' ) );
		add_action( 'wp_ajax_nopriv_dln_save_topic',              array( $this, 'dln_save_topic' ) );
		add_action( 'wp_ajax_dln_comment_photo',                  array( $this, 'dln_comment_photo' ) );
		add_action( 'wp_ajax_nopriv_dln_comment_photo',           array( $this, 'dln_comment_photo' ) );
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
								$images[] = array(
									'id'         => $image->id,
									'picture'    => $image->images->low_resolution->url,
									'full_url'   => $image->data->images->standard_resolution->url,
								);
							}
						}
					}
						
					$max_id = '';
					if ( ! empty( $obj->pagination->next_max_id ) ) {
						$max_id = $obj->pagination->next_max_id;
					}
					
					$arr_result = array( 'status' => 'success', 'images' => $images, 'max_id' => $max_id  );
					
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
								$images[] = array(
									'id'          => $image->id,
									'picture'     => $image->source,
									'full_url'    => $image->images[0]->source,
								);
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
	
	public function dln_save_photo() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$pic_url = isset( $_POST['pic_url'] ) ? $_POST['pic_url'] : '';
			$message = isset( $_POST['message'] ) ? $_POST['message'] : '';
			$perm    = isset( $_POST['perm'] ) ? $_POST['perm'] : 'public';
			$post_fb = isset( $_POST['post_fb'] ) ? $_POST['post_fb'] : '';
			
			$user_id = get_current_user_id();
			$message = esc_html( $message );
			$title   = wp_trim_words( $message );
			
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
					'post_title'   => $title,
					'post_status'  => 'publish',
					'post_type'    => 'dln_photo',
					'post_author'  => $user_id,
					'post_content' => $message
				);
				$post_id = wp_insert_post( $args );
				
				if ( $post_id ) {
					update_post_meta( $post_id, 'dln_pic_url', $pic_url );
					update_post_meta( $post_id, 'dln_perm', $perm );
					
					if ( ! empty( $fb_user_id ) ) {
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
	
	public function dln_comment_photo() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$post_id    = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : '';
			$message    = isset( $_POST['message'] ) ? $_POST['message'] : '';
			$cmt_parent = isset( $_POST['cmt_parent'] ) ? (int) $_POST['cmt_parent'] : '';
			
			$user_id = get_current_user_id();
			$message = esc_html( $message );
			
			if ( ! empty( $message ) && ! empty( $user_id ) && ! empty( $post_id ) ) {
				$user  = wp_get_current_user();
				$data = array(
					'comment_post_ID'      => $post_id,
					'comment_author'       => $user->user_login,
					'comment_author_email' => $user->user_email,
					'comment_content'      => $message,
					'comment_parent'       => $cmt_parent,
				);
				
				if ( ! DLN_Block_Cache::add_cache( $data ) ) {
					exit('0');
					return null;
				}
				
				$cmt_id     = wp_new_comment( $data );
				$arr_result = json_encode( array( 'comment_id' => $cmt_id, 'data' => $data ) );
				exit( $arr_result );
			}
		}
		exit('0');
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
		exit('0');
	}
	
	public function dln_download_image_from_url() {
		check_ajax_referer( DLN_ABE_NONCE . '_download_image_from_url', 'security' );
		$data = isset( $_POST['data'] ) ? $_POST['data'] : '';
		
		$image_data  = isset( $data['image_data'] ) ? $data['image_data'] : '';
		
		if ( $image_data ) {
			$image_data = json_decode( stripcslashes( $image_data ) );
		}
		
		foreach ( $image_data as $i => $image ) {
			// Get external id
			$external_id = '';
			if ( $image ) {
				$external_id = isset( $image->id ) ? $image->id : '';
			}
			$url = isset( $image->url ) ? $image->url : '';
			
			if ( ! empty( $url ) && filter_var($url, FILTER_VALIDATE_URL) !== false && ! empty( $external_id ) ) {
				// Check external image exists in system
				global $wpdb;
					
				$wpdb->postmeta;
				$sql    = $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s", array( esc_sql( '_dln_external_id' ), esc_sql( $external_id ) ) );
				$result = $wpdb->get_row($sql);
					
				if ( ! empty( $result->post_id ) ) {
					$id = $result->post_id;
				} else {
					$name     = basename( $url );
					$tmp_name = WP_CONTENT_DIR . '/uploads/dln_product_cache/' . $name;
						
					$implementation = _wp_image_editor_choose();
					$editor         = new $implementation( $url );
					$loaded         = $editor->load();
						
					if ( is_wp_error( $loaded ) )
						return $loaded;
						
					$editor->set_quality( 100 );
					$editor->resize( DLN_MAX_IMAGE_SIZE, DLN_MAX_IMAGE_SIZE, false );
					$editor->save( $tmp_name );
						
					$file_array = array(
						'name'     =>  basename( $url ),
						'tmp_name' => $tmp_name,
					);
						
					// Check for download errors
					if ( is_wp_error( $tmp_name ) ) {
						@unlink( $file_array['tmp_name'] );
						return $tmp_name;
					}
						
					$id = media_handle_sideload( $file_array, 0 );
					// Check for handle sideload errors.
					if ( is_wp_error( $id ) ) {
						@unlink( $file_array['tmp_name'] );
						return $id;
					}
						
					update_post_meta( $id, '_dln_external_id', $external_id );
					$user_ids     = get_post_meta( $id, '_dln_user_used', true );
					$arr_user_ids = array();
					if ( $user_ids ) {
						$arr_user_ids = json_decode( $user_ids );
					}
					$user_id  = get_current_user_id();
					if ( $user_id && is_array( $arr_user_ids ) ) {
						$arr_user_ids[] = $user_id;
						update_post_meta( $id, '_dln_user_used', json_encode( $arr_user_ids ) );
					}
				}
					
				$attachment_url = wp_get_attachment_image_src( $id, array( DLN_MAIN_IMAGE_SIZE, DLN_MAIN_IMAGE_SIZE ) );
				$attachment_url = ( count( $attachment_url ) ) ? $attachment_url[0] : DLN_DEFAULT_IMAGE;
					
				// Build img data
				$img_data = esc_attr( serialize( array( 'type' => 'local', 'external_id' => $id ) ) );
					
				
				
			}
		}
		
		$result = array( 'status' => 'success', 'img_url' => $attachment_url, 'img_data' => $img_data );
		echo json_encode( $result );
		exit();
	}
	
	public function dln_add_product() {
		check_ajax_referer( DLN_ABE_NONCE . '_save_product', 'security' );
		$data = isset( $_POST['data'] ) ? $_POST['data'] : '';
		
		/*if ( ! DLN_Block_Cache::add_cache( $data ) ) {
			exit( '0' );
			return null;
		}*/
		
		$image_data       = isset( $data['image_data'] ) ? $data['image_data'] : '';
		$product_title    = isset( $data['product_title'] ) ? $data['product_title'] : '';
		$product_category = isset( $data['product_cat'] ) ? (int) $data['product_cat'] : '';
		$product_tag      = isset( $data['product_tag'] ) ? $data['product_tag'] : '';
		$product_price    = isset( $data['product_price'] ) ? $data['product_price'] : '';
		$product_desc     = isset( $data['product_desc'] ) ? $data['product_desc'] : '';
		$product_attrs    = isset( $data['product_attrs'] ) ? $data['product_attrs'] : '';
		
		if ( ! empty( $product_title ) && ! empty( $product_category ) && ! empty( $product_price ) && ! empty( $product_desc ) ) {
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
				// Insert the attachment
				if ( ! empty( $image_data ) ) {
					$image_data     = json_decode( $image_data );
					$product_images = array();
					$is_local       = false;
					
					if ( ! empty( $image_data ) && is_array( $image_data ) ) {
						foreach ( $image_data as $i => $data ) {
							$type        = isset( $data['type'] ) ? $data['type'] : '';
							$external_id = isset( $data['external_id'] ) ? $data['external_id'] : '';
							
							if ( $type && $external_id ) {
								switch ( $type ) {
									case 'local':
										$product_images[] = $external_id;
										$is_local         = true;
									break;
									
									case 'facebook':
										// Get facebook photo information
										$fb_access_token = get_user_meta( $user_id, 'dln_facebook_access_token', true );
							
										$url = 'https://graph.facebook.com/v2.1/' . $external_id . '?access_token=' . $fb_access_token;
										$obj = @file_get_contents( $url );
										$obj = ( ! empty( $obj ) ) ? json_decode( $obj ) : '';
							
										if ( ! empty( $obj->images ) ) {
											$product_images[] = array(
												'external_id'  => $obj->id,
												'thumb_url'    => $obj->images[count( $obj->images ) - 1]->source,
												'standard_url' => $obj->source,
												'full_url'     => $obj->images[0]->source,
												'full_height'  => $obj->images[0]->height,
												'full_width'   => $obj->images[0]->width,
											);
										}
									break;
									
									case 'instagram':
										// Get instagram photo information
										$insta_access_token = get_user_meta( $user_id, 'dln_instagram_access_token', true );
										
										$url = 'https://api.instagram.com/v1/media/' . $external_id . '?access_token=' . $insta_access_token;
										$obj = @file_get_contents( $url );
										$obj = ( ! empty( $obj ) ) ? json_decode( $obj ) : '';
										
										if ( ! empty( $obj->data->images ) ) {
											
											$product_images[] = array(
												'external_id'  => $obj->data->id,
												'thumb_url'    => $obj->data->images->thumbnail->url,
												'standard_url' => $obj->data->images->low_resolution->url,
												'full_url'     => $obj->data->images->standard_resolution->url,
												'full_height'  => $obj->data->images->standard_resolution->height,
												'full_width'   => $obj->data->images->standard_resolution->width,
											);
										}
									break;
								}
							}
						}
						
						if ( $is_local ) {
							// Update product image local
							
							if ( count( $product_images ) >= 1 ) {
								// Check has product image
								
								if ( ! empty( $product_images[0] ) ) {
									// Update thumbnail
									update_post_meta( $post_id, '_thumbnail_id', (int) $product_images[0] );
									unset( $product_images[0] );
								}
								
								if ( count( $product_images ) ) {
									// Update image gallery
									$gallery_ids = implode( ',', $product_images );
									update_post_meta( $post_id, '_product_image_gallery', $gallery_ids );
								}
							}
						} else {
							update_post_meta( $post_id, '_dln_product_images', json_encode( $product_images ) );
						}
					}
				}
				
				wp_set_object_terms( $post_id, $product_category, 'product_cat' );
				wp_set_object_terms( $post_id, 'dln_fashion', 'dln_fashion' );
				wp_set_object_terms( $post_id, $product_tag, 'product_tag' );
				$product_price = ( ! empty( $product_price ) ) ? (int) $product_price : 0;
				$product_price .= '000';
				update_post_meta( $post_id, '_price', $product_price );
				
				self::process_product_attributes( $post_id, $product_attrs );
				
				do_action( 'dln_add_product', $post_id, $product_title, $user_id );
			}
			echo $post_id;
			exit();
		}
		exit( '0' );
	}
	
	private static function process_product_attributes( $post_id, $product_atts ) {
		if ( empty( $product_atts ) || ! is_array( $product_atts ) ) 
			return false;
		
		foreach ( $product_atts as $i => $attr ) {
			$name  = ( ! empty( $attr['name'] ) ) ? $attr['name'] : '';
			$value = ( ! empty( $attr['value'] ) ) ? $attr['value'] : '';
			if ( ! $name || ! $value )
				return;
			
			// Update post terms
			if ( taxonomy_exists( $name ) ) {
				wp_set_object_terms( $post_id, $value, $name );
			}
			
			$attributes[ $name ] = array(
				'name' 			=> wc_clean( $name ),
				'value' 		=> $value,
				'position' 		=> $i,
				'is_visible' 	=> 1,
				'is_variation' 	=> 0,
				'is_taxonomy' 	=> 1
			);
		}
		update_post_meta( $post_id, '_product_attributes', $attributes );
	}
	
	/*private function validate_product_fields( $product_fields ) {
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
	}*/
	
	/*private static function validate_perm( $perm = 'publish' ) {
		if ( ! $perm )
			return null;
		
		if ( ! in_array( $perm, array( 'public', 'private' ) ) ) {
			$perm = 'public';
		}
		
		return $perm;
	}*/
	
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

endif;