<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Match_Comment {
	
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
		add_action( 'admin_menu', array( $this, 'register_menu_comment' ) );
		add_filter( 'manage_edit-comments_columns', array( $this, 'register_column_comment' ) );
		add_action( 'manage_comments_custom_column', array( $this, 'dln_comment_column_row' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array($this, 'load_admin_style_comment' ) );
	}	
	
	public function load_admin_style_comment() {
		wp_enqueue_style( 'admin_style_comment', DLN_MATCH_PLUGIN_URL . '/admin/assets/css/admin.css', false, DLN_VERSION );
	}
	
	public static function register_menu_comment() {
		add_submenu_page( 'edit.php?post_type=dln_match', __('Comments', DLN_MATCH_SLUG), __('Comments', DLN_MATCH_SLUG), 'edit_posts', 'edit-comments.php?post_type=dln_match');
		/*$singular = __( 'Comment', DLN_MATCH_SLUG );
		$plural = $singular . 's';
		$menu = 'Match';
		$args = array(
			'show_ui' => true,
			'public' => true,
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions'),
			'label' => $plural,
			'labels' => self::post_type_labels( $singular, $plural, $menu ),
			'has_archive'  => TRUE,
			'show_in_menu' => 'edit.php?post_type=dln_match',
			'rewrite'      => array(
				'slug'       => 'dln_match',
				'with_front' => FALSE,
			),
			'supports'     => array('title', 'editor'),
			'hierarchical' => TRUE
		);
		register_post_type( 'dln_comment', $args );*/
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

	public function register_column_comment($columns) {
		$columns['like_count'] = __( 'Like Count', DLN_MATCH_SLUG );
		return $columns;
	}
	
	public function dln_comment_column_row( $column, $comment_id ) {
		if ( ! $comment_id )
			return;
		if ( $column == 'like_count' ) {
			$like_count = get_comment_meta( $comment_id, 'total_like' );
			$like_count = intval( $like_count );
			
			echo '<span>' . $like_count . '</span>';
		}
	}
}
