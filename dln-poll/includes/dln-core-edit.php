<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Poll
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class DLN_Core_Edit {
	
	function DLN_Core_Edit() {
		add_action( 'init', array( &$this, 'handle_forms' ), 11 );
	}
	
	public function handle_forms() {
		if ( ! isset( $_REQUEST['_wpnonce'] ) )
			return;
		
		// Handle actions
		if ( isset( $_REQUEST['dln_delete'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'dln_delete' ) ) {
			$post = get_post( $_REQUEST['dln_delete'] );

			if ( $post && current_user_can( 'delete_post', $post->ID ) ) {
				if ( 'answer' == $post->post_type ) {
					wp_delete_post( $post->ID );
					$url = qa_get_url( 'single', $post->post_parent );
				} elseif ( 'question' == $post->post_type ) {
					wp_delete_post( $post->ID );
					$url = add_query_arg( 'dln_msg', 'deleted', dln_get_url( 'archive' ) );
				}
			}
		} elseif ( isset( $_POST['dln_action'] ) ) {
			$action = $_POST['dln_action'];
			var_dump($_POST);die();
			switch( $action ) {
				case 'edit_question':
					$url = $this->handle_question_editing();
					break;
				
				case 'edit_answer':
					$url = $this->handle_answer_editing();
					break;
			}
		} else {
			return;
		}
		
		if ( !$url ) {
			$url = add_query_arg( 'dln_error', 1, dln_get_url( 'archive' ) );
		}
		
		wp_redirect( $url );
		die;
	}
} 
$_dln_core_edit = new DLN_Core_Edit();