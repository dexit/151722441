<?php
/**
 * Plugin Name.
 *
 * @package   DLN_Polls
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package DLN_Polls
 * @author  Your Name <email@example.com>
 */
class DLN_Polls {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * @TODO - Rename "plugin-name" to the name your your plugin
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'dln-polls';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Add Custom post type
		add_action( 'init', array( $this, 'custom_post_type' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( '@TODO', array( $this, 'action_method_name' ) );
		add_filter( '@TODO', array( $this, 'filter_method_name' ) );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

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
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// @TODO: Define your action hook callback here
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// @TODO: Define your filter hook callback here
	}

	public function custom_post_type() {
		$labels = array(
				'name' => _x( 'Questions', 'post type general name', 'dln-polls' ),
				'singular_name' => _x( 'Question', 'post type singular name', 'dln-polls' ),
				'add_new' => __( 'Add New Question', 'dln-polls' ),
				'add_new_item' => __( 'Add New Question', 'dln-polls' ),
				'edit_item' => __( 'Edit Question', 'dln-polls' ),
				'new_item' => __( 'New Question', 'dln-polls' ),
				'view_item' => __( 'View Question', 'dln-polls' ),
				'search_items' => __( 'Search Questions', 'dln-polls' ),
				'not_found' => __( 'No questions found.', 'dln-polls' ),
				'not_found_in_trash' => __( 'No questions found in Trash.', 'dln-polls' ),
				'menu_name' => __( 'Questions', 'dln-polls' ),
		);
		$args = array(
				'labels' => $labels,
				'description' => 'Câu hỏi',
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'show_ui' => true,
				'menu_position' => 20,
				'menu_icon' => null,
				'capability_type' => post,
				'hierarchical' => true,
				'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', ),
				'taxonomies' => array('category', 'dln_tag', ),
				'rewrite' => true,
				'query_var' => true,
				'can_export' => true,
				'show_in_nav_menus' => false,
		);
		register_post_type('dln_question', $args);
		
		$labels = array(
				'name' => _x( 'Answers', 'post type general name', 'dln-polls' ),
				'singular_name' => _x( 'Answer', 'post type singular name', 'dln-polls' ),
				'add_new' => __( 'Add New Answer', 'dln-polls' ),
				'add_new_item' => __( 'Add New Answer', 'dln-polls' ),
				'edit_item' => __( 'Edit Answer', 'dln-polls' ),
				'new_item' => __( 'New Answer', 'dln-polls' ),
				'view_item' => __( 'View Answer', 'dln-polls' ),
				'search_items' => __( 'Search Answer', 'dln-polls' ),
				'not_found' => __( 'No answers found.', 'dln-polls' ),
				'not_found_in_trash' => __( 'No answers found in Trash.', 'dln-polls' ),
				'menu_name' => __( 'Answers', 'dln-polls' ),
		);
		$args = array(
				'labels' => $labels,
				'description' => 'Trả lời',
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'show_ui' => true,
				'menu_position' => 20,
				'menu_icon' => null,
				'capability_type' => post,
				'hierarchical' => true,
				'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes', ),
				'taxonomies' => array(),
				'rewrite' => true,
				'query_var' => true,
				'can_export' => true,
				'show_in_nav_menus' => false,
		);
		register_post_type('dln_answer', $args);
		
		$labels = array(
				'name' => _x( 'Question Tags', 'taxonomy general name' ),
				'singular_name' => _x( 'Question Tag', 'taxonomy singular name' ),
				'search_items' => __( 'Search Question Tags' ),
				'popular_items' => __( 'Popular Question Tags' ),
				'all_items' => __( 'All Question Tags' ),
				'edit_items' => __( 'Edit Question Tags' ),
				'update_item' => __( 'Update Question Tags' ),
				'add_new_item' => __( 'Add New Question Tag' ),
				'new_item_name' => __( 'New Question Tag' ),
				'separate_items_with_commas' => __( 'Separate question tags with commas' ),
				'add_or_remove_items' => __( 'Add or remove question tags' ),
				'choose_from_most_used' => __( 'Choose from the most used question tags' ),
				'menu_name' => __( 'Question Tags' ),
		);
		$args = array(
				'labels' => $labels,
				'public' => true,
				'show_in_nav_menus' => false,
				'show_ui' => true,
				'show_tagcloud' => true,
				'hierarchical' => false,
				'rewrite' => true,
				'query_var' => true,
		);
		register_taxonomy('dln_tag', array('dln_question', ), $args);
	}
	
}
