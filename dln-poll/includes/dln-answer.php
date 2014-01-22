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

class DLN_Answer {
	
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
	}

	public function init() {
		$args = array(
			'show_ui' => true,
			'show_in_menu' => 'edit.php?post_type=dln_question',
			'rewrite' => false,
			'capability_type' => 'dln_answer',
			'capabilities' => array(
				'read' => 'read_answer',
				'edit_posts' => 'edit_published_answers',
				'delete_posts' => 'delete_published_answers'
			),
			'map_meta_cap' => true,
			'supports' => array( 'title', 'editor', 'author', 'revisions' ),
			'labels' => array(
				'name'			=> __('Answers', DLN_SLUG),
				'singular_name'	=> __('Answer', DLN_SLUG),
				'add_new'		=> __('Add New', DLN_SLUG),
				'add_new_item'	=> __('Add New Answer', DLN_SLUG),
				'edit_item'		=> __('Edit Answer', DLN_SLUG),
				'new_item'		=> __('New Answer', DLN_SLUG),
				'view_item'		=> __('View Answer', DLN_SLUG),
				'search_items'	=> __('Search Answers', DLN_SLUG),
				'not_found'		=> __('No answers found', DLN_SLUG),
				'not_found_in_trash'	=> __('No answers found in trash', DLN_SLUG),
			)
		);
		$args = apply_filters( 'dln_answer_register_post_type_args', $args );
		register_post_type( 'dln_answer', $args );
	}
	
}

$_dln_answer = DLN_Answer::get_instance();