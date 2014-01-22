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

class DLN_Question {
	
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
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
	}

	public function init() {
		
	}
	
	public function add_metabox() {
		add_meta_box('dln_metabox_answer', 'Answer', array( $this, 'dln_metabox_answer'), 'dln_question', 'normal', 'high');
	}
	
	public function dln_metabox_answer() {
		echo '123';
	}

	public function handle_question_editing() {
		global $wpdb;

		if ( !wp_verify_nonce( $_POST['_wpnonce'], 'qa_edit' ) )
			wp_die( __( 'Nonce error: It looks like you don\'t have permission to do that.', QA_TEXTDOMAIN ) );

		$question_id = (int) $_POST['question_id'];

		$question = array(
				'post_title' => trim( wp_strip_all_tags( $_POST['question_title'] ) ),
				'post_content' => trim( $_POST['question_content'] ),
		);

		if ( empty( $question['post_title'] ) || empty( $question['post_content'] ) )
			wp_die( __( 'Questions must have both a title and a body. Please use your browser\'s back button to edit your question.', QA_TEXTDOMAIN ) );

		// Check for duplicates
		if ( !$question_id ) {
			$dup_id = $wpdb->get_var( $wpdb->prepare( "
					SELECT ID
					FROM $wpdb->posts
					WHERE post_type = 'question'
					AND post_status = 'publish'
					AND (post_title = %s OR post_content = %s)
					LIMIT 1
					", $question['post_title'], $question['post_content'] ) );

			if ( $dup_id ) {
				wp_die( sprintf( __( 'It seems that this question was already asked. Click <a href="%s" target="_blank">here</a> to view it, if it is approved by the admin. If title or content of your question is the same as any of the previous questions, it is regarded as duplicate. Please use your browser\'s back button to edit your question.', QA_TEXTDOMAIN ), qa_get_url( 'single', $dup_id ) ) );
			}
		}

		$question_id = $this->_insert_post( $question_id, $question, array(
			'post_type' => 'question',
						'comment_status' => 'open',
				) );
	
		return qa_get_url( 'single', $question_id );
	}
	
}

$_dln_question = DLN_Question::get_instance();