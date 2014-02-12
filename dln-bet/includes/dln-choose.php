<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Bet
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class DLN_Choose {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
	
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'init' ) );
		// Ajax
		add_action( 'wp_ajax_dln_add_choose', array( $this, 'ajax_add_choose' ) );
		add_action( 'wp_ajax_nopriv_dln_add_choose', array( $this, 'ajax_add_choose' ) );
		add_action( 'wp_ajax_dln_delete_choose', array( $this, 'ajax_delete_choose' ) );
		add_action( 'wp_ajax_nopriv_dln_delete_choose', array( $this, 'ajax_delete_choose' ) );
		add_action( 'wp_ajax_dln_add_bet', array( $this, 'ajax_add_bet' ) );
		add_action( 'wp_ajax_nopriv_dln_add_bet', array( $this, 'ajax_add_bet' ) );
	}
	
	public function init() {
	
	}
	
	public function ajax_add_choose() {
		check_ajax_referer( 'dln-add-choose', '_ajax_nonce' );
		$pid = (int) $_POST['post_id'];
		if ( empty( $pid ) )
			die(0);
		$post = get_post( $pid );
		
		// Create draft choose
		$draft = array(
			'post_title' => '',
			'post_content' => '',
			'post_status' => 'draft',
			'post_type' => 'dln_choose',
			'post_parent' => $pid,
			'post_author' => get_current_user_id()
		);
		$draft_id = wp_insert_post( $draft );
		
		$arr_result = array();
		$arr_result['id'] = $draft_id;
		$arr_result['action'] = 'dln_add_choose';
		$arr_result['html'] = self::render_row_choose_html( $draft_id, '', '' );
		echo json_encode( $arr_result );
		exit();
	}
	
	public function ajax_delete_choose() {
		check_ajax_referer( 'dln-delete-choose', '_ajax_nonce' );
		$pid = (int) $_POST['post_id'];
		if ( empty( $pid ) )
			die(0);
		wp_delete_post( $pid, true );
		
		$arr_result = array();
		$arr_result['id'] = $pid;
		$arr_result['action'] = 'dln_delete_choose';
		echo json_encode( $arr_result );
		exit();
	}
	
	public function ajax_add_bet() {
		check_ajax_referer( 'dln-add-bet', '_ajax_nonce' );
		$pid     = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : '';
		$user_id = isset( $_POST['user_id'] ) ? (int) $_POST['user_id'] : '';
		if ( empty( $pid ) || empty( $user_id ) )
			die(0);
		$multiple = str_replace( ',' , '.', $multiple );
		$multiple = isset( $_POST['multiple'] ) ? $_POST['multiple'] : '';
		$multiple = floatval( $multiple );
		
		$cost = str_replace( ',' , '.', $cost );
		$cost = isset( $_POST['cost'] ) ? $_POST['cost'] : '';
		$cost = intval( $cost );
		
	}
	
	public static function update_choose_multiple( $parent_id, $multiple = 0 ) {
		$multiple = str_replace( ',' , '.', $multiple);
		$multiple = floatval( $multiple );
		update_post_meta( $parent_id, 'choose_multiple', $multiple );
	}
	
	public static function delete_choose_parent_id( $parent_id ) {
		if ( $parent_id ) {
			// Delete post relate dln_match
			$args = array(
				'post_type'   => 'dln_choose',
				'post_parent' => $parent_id,
			);
			$posts = get_posts( $args );
			if ( is_array( $posts ) ) {
				foreach ($posts as $post) {
					wp_delete_post( $post->ID, true);
				}
			}
		}
	}
	
	public static function render_row_choose_html( $id, $title = '', $multiple = '' ) {
		$html_row = '';
		if ( $id ) {
			$html_row .= '<tr id="choose-row-' .$id. '">';
			$html_row .= '<td><input class="choose-title" type="text" value="' .$title. '" size="20" id="choose_data[' .$id. '][title]" name="choose_data[' .$id. '][title]"></td>';
			$html_row .= '<td><input class="choose-multiple" type="number" step="any" value="' .$multiple. '" size="20" id="choose_data[' .$id. '][multiple]" name="choose_data[' .$id. '][multiple]"></td>';
			$html_row .= '<td><a href="' .get_edit_post_link( $id ). '" target="_blank">' .__( 'Link', DLN_BET_SLUG ). '</a></td>';
			$html_row .= '<td>';
			//$html_row .= 	'<a class="choose-update" class="button" href="#" data-id="' .$id. '">' .__( 'Update', DLN_BET_SLUG ). '</a>';
			$html_row .= 	'<a class="choose-delete" class="button" href="#" data-id="' .$id. '">' .__( 'Delete', DLN_BET_SLUG ). '</a>';
			//$html_row .= 	'<a class="choose-status" class="button" href="#" data-id="' .$id. '">' .__( 'Unsave', DLN_BET_SLUG ). '</a>';
			$html_row .= '</td>';
			$html_row .= '</tr>';
		}
		return $html_row;
	}
	
}
$_dln_choose = DLN_Choose::get_instance();