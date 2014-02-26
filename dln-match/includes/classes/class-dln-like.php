<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Match_Like {
	
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
	}
	
	public static function register_like_comment() {
		$singular = __( 'Comment', DLN_MATCH_SLUG );
		$plural = $singular . 's';
		$menu = 'Match';
		$args = array(
			'show_ui' => true,
			'public' => true,
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions'),
			'label' => $plural,
			'labels' => self::post_type_labels( $singular, $plural, $menu ),
		);
		register_post_type( 'dln_like', $args );
	}
	
	/**
	 * Generate a set of labels for a post type
	 *
	 * @static
	 * @param string $singular
	 * @param string $plural
	 * @return array All the labels for the post type
	 */
	private static function post_type_labels($singular, $plural, $menu) {
		return array(
				'name' => $plural,
				'singular_name' => $singular,
				'add_new' => sprintf(__('Add %s', DLN_MATCH_SLUG), $singular),
				'add_new_item' => sprintf(__('Add New %s', DLN_MATCH_SLUG), $singular),
				'edit_item' => sprintf(__('Edit %s', DLN_MATCH_SLUG), $singular),
				'new_item' => sprintf(__('New %s', DLN_MATCH_SLUG), $singular),
				'all_items' => $plural,
				'view_item' => sprintf(__('View %s', DLN_MATCH_SLUG), $singular),
				'search_items' => sprintf(__('Search %s', DLN_MATCH_SLUG), $plural),
				'not_found' => sprintf(__('No %s found', DLN_MATCH_SLUG), $plural),
				'not_found_in_trash' => sprintf(__('No %s found in Trash', DLN_MATCH_SLUG), $plural),
				'menu_name' => $menu
		);
	}
}
$_dln_match_like = DLN_Match_Like::get_instance();