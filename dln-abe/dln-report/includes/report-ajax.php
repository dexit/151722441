<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Report_Ajax' ) ) :

class DLN_Report_Ajax {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'wp_ajax_dln_get_modal_report_submit',        array( $this, 'get_modal_report_submit' ) );
		add_action( 'wp_ajax_nopriv_dln_get_modal_report_submit', array( $this, 'get_modal_report_submit' ) );
		add_action( 'wp_ajax_dln_save_report_item',             array( $this, 'save_report_item' ) );
		add_action( 'wp_ajax_nopriv_dln_save_report_item',      array( $this, 'save_report_item' ) );
	}
	
	public static function get_modal_report_submit() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$block = isset( $_POST['block'] ) ? $_POST['block'] : '';
			if ( empty ( $block ) )
				exit('0');
				
			$modal_content = DLN_Report_Loader::get_controller( sanitize_title( $block ) );
				
			$arr_result = array( 'status' => 'success', 'content' => $modal_content );
			echo json_encode( $arr_result );
			die();
		}
		exit('0');
	}
	
	public static function save_report_item() {
		if ( ! isset( $_POST[DLN_ABE_NONCE] ) || ! wp_verify_nonce( $_POST[DLN_ABE_NONCE], DLN_ABE_NONCE ) ) {
			$item_id  = isset( $_POST['report_item_id'] ) ? $_POST['report_item_id'] : '';
			$category = isset( $_POST['report_category'] ) ? (int) $_POST['report_category'] : '';
			$message  = isset( $_POST['report_reason'] ) ? $_POST['report_reason'] : '';
			
			$user_id  = get_current_user_id();
			$message  = esc_html( $message );
			$title    = wp_trim_words( $message, 20, '...' );
			
			if ( $user_id && $item_id && $category && $message && $title ) {
				$args = array(
					'post_title'     => $title,
					'post_status'    => 'pending',
					'post_type'      => 'dln_report',
					'post_author'    => $user_id,
					'post_content'   => $message,
					'post_category'  => array( $category ),
					'comment_status' => 'open',
				);
				$post_id = wp_insert_post( $args );
				
				if ( $post_id ) {
					// Get current user ip
					$ip = ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '';
					update_post_meta( $post_id, 'dln_report_post_id', $item_id );
					update_post_meta( $post_id, 'dln_report_user_ip', $ip );
					
					// Update count to post
					$count = (int) get_post_meta( $item_id, 'dln_count_report', true );
					if ( $count ) {
						update_post_meta( $item_id, 'dln_count_report', $count + 1 );
					}
				}
			}
			exit( $post_id );
		}
		exit('0');
	}
}

DLN_Report_Ajax::get_instance();

endif;