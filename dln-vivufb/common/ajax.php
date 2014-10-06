<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Common_Ajax {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'wp_ajax_dln_fetch_source',        array( $this, 'dln_fetch_source' ) );
		add_action( 'wp_ajax_nopriv_dln_fetch_source', array( $this, 'dln_fetch_source' ) );
		add_action( 'wp_ajax_dln_add_source',        array( $this, 'dln_add_source' ) );
		add_action( 'wp_ajax_nopriv_dln_add_source', array( $this, 'dln_add_source' ) );
	}
	
	private static function verified_nonce( $nonce = '' ) {
		if ( ! $nonce )
			return false;
		
		$decoded = '';
		$decoded = str_rot13( $nonce );
		
		if ( $decoded ) {
			$nonce = explode( '|', $decoded );
			$nonce = $nonce[0];
		}
		
		echo $nonce;
	}
	
	private static function result_format( $status = 'error', $content = '', $action = '' ) {
		if ( $action ) {
			return json_encode( array( 'status' => $status, 'content' => $content, 'action' => $action ) );
		} else {
			return json_encode( array( 'status' => $status, 'content' => $content ) );
		}
	}
	
	private static function get_app_access_token() {
		return FB_APP_ID . '|' . FB_SECRET;
	}
	
	private static function get_fb_data_link( $id, $obj, $is_full = false ) {
		if ( $id ) {
			$data_link->id    = $id;
			$data_link->name  = ( ! empty( $obj->$link->name ) ) ? $obj->$link->name : '';
			$data_link->link  = ( ! empty( $obj->$link->link ) ) ? $obj->$link->link : '';
				
			$likes               = ( ! empty( $obj->$link->likes ) ) ? (float) $obj->$link->likes : 0;
			$talking_about_count = ( ! empty( $obj->$link->talking_about_count ) ) ? (float) $obj->$link->talking_about_count : 0;
			$data_link->likes               = number_format( $likes, 0, '', ',' );
			$data_link->talking_about_count = number_format( $talking_about_count, 0, '', ',' );
			
			if ( $is_full ) {
				// Process tags
				$tags = array();
				if ( ! empty( $obj->$link->category ) ) {
					$tags = explode( '/', $obj->$link->category );
				}
				if ( ! empty( $obj->$link->location ) ) {
					if ( ! empty( $obj->$link->location->city ) ) {
						$tags[] = $obj->$link->location->city;
					}
					if ( ! empty( $obj->$link->location->country ) ) {
						$tags[] = $obj->$link->location->country;
					}
				}
				$data_link->tag = ( $tags ) ? implode( ',', $tags ) : '';
			}
			
			$data_link->category = ( ! empty( $obj->$link->category ) ) ? $obj->$link->category : '';
			$data_link->hometown = ( ! empty( $obj->$link->hometown ) ) ? $obj->$link->hometown : '';
			$data_link->cover    = ( ! empty( $obj->$link->cover->source ) ) ? $obj->$link->cover->source : '';
			$data_link->website  = ( ! empty( $obj->$link->website ) ) ? $obj->$link->website : '';
				
			// Process picture profile
			$picture_url = '';
			if ( ( ! empty( $obj->$link->username ) ) ) {
			$obj_url = json_decode( file_get_contents( 'https://graph.facebook.com/v2.1/' . $obj->$link->username . '/picture?redirect=0&height=200&type=normal&width=200' ) );
				if ( ! empty( $obj_url->data->url ) ) {
					$picture_url = $obj_url->data->url;
				}
			}
			$data_link->picture_url = $picture_url;
				
			// Process description
			$sub_desc = '';
			if ( ! empty( $obj->$link->description ) ) {
				$description = $obj->$link->description;
				$sub_desc    = wp_trim_words( $description, 50, '...' );
			}
			
			if ( empty( $sub_desc ) && ! empty( $obj->$link->about ) ) {
				$description = $obj->$link->about;
				$sub_desc    = wp_trim_words( $description, 50, '...' );
			}
			
			if ( $is_full ) {
				$data_link->desc = $description;
			}
			
			$data_link->sub_desc = esc_html( $sub_desc );
		}
		
		return $data_link;
	}
	
	public function dln_add_source() {
		if ( ! isset( $_POST['nonce_check'] ) ) {
			return false;
		}
		
		$nonce = $_POST['nonce_check'];
		
		if ( wp_verify_nonce( $nonce, DLN_VVF_NONCE ) ) {
			$data         = ( isset( $_POST['data'] ) ) ? $_POST['data'] : '';
			$title        = ( isset( $data['source_title'] ) ) ? $data['source_title'] : '';
			$link         = ( isset( $data['source_link'] ) ) ? $data['source_link'] : '';
			$category     = ( isset( $data['source_cat'] ) ) ? $data['source_cat'] : '';
			$tags         = ( isset( $data['source_tag'] ) ) ? $data['source_tag'] : '';
			$access_token = self::get_app_access_token();
			
			$data_link = new stdClass;
			if ( $link && $access_token ) {
				$obj = json_decode( file_get_contents( 'https://graph.facebook.com/v2.1?ids=' . $link . '&locale=vi_VN&access_token=' . $access_token ) );
				$id  = doubleval( $obj->$link->id );
			
				$data_link = self::get_fb_data_link( $id, $obj, true );
			}
			
			if ( $id && $title && $category && $data_link ) {
				$user_id = get_current_user_id();
				if ( ! $user_id ) {
					exit( '0' );
					return null;
				}
				
				$post = array(
					'post_author'  => $user_id,
					'post_content' => $data_link->desc,
					'post_status'  => 'pending',
					'post_title'   => $title,
					'post_parent'  => '',
					'post_type'    => 'dln_source',
				);
					
				//Create post
				$post_id = wp_insert_post( $post );
				
				if ( $post_id ) {
					wp_set_object_terms( $post_id, $category, 'source_cat' );
					wp_set_object_terms( $post_id, $tags, 'source_tag' );
					
					update_post_meta( $post_id, '_fb_page_id', $id );
					update_post_meta( $post_id, '_fb_page_website', $data_link->website );
					update_post_meta( $post_id, '_fb_page_cover', $data_link->cover );
					update_post_meta( $post_id, '_fb_page_likes', $data_link->likes );
					update_post_meta( $post_id, '_fb_page_talk', $data_link->talking_about_count );
				}
			}
		}
	}
	
	public function dln_fetch_source() {
		if ( ! isset( $_POST['nonce_check'] ) ) {
			return false;
		}
		
		$nonce = $_POST['nonce_check'];
		//$nonce = self::verified_nonce( $nonce );
		
		if ( wp_verify_nonce( $nonce, DLN_VVF_NONCE ) ) {
			$data         = ( isset( $_POST['data'] ) ) ? $_POST['data'] : '';
			$link         = ( isset( $data['source_link'] ) ) ? $data['source_link'] : '';
			$access_token = self::get_app_access_token();
			
			$data_link = new stdClass;
			if ( $link && $access_token ) {
				$obj = json_decode( file_get_contents( 'https://graph.facebook.com/v2.1?ids=' . $link . '&locale=vi_VN&access_token=' . $access_token ) );
				$id  = doubleval( $obj->$link->id );
				
				$data_link = self::get_fb_data_link( $id, $obj );
				$result    = self::result_format( 'success', $data_link );
				echo $result;
			}
			exit();
		}
		exit('0');
	}
	
}

DLN_Common_Ajax::get_instance();