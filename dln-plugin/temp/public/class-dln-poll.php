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

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package DLN_Poll
 * @author  Your Name <email@example.com>
 */
class DLN_Poll {

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
	protected $plugin_slug = 'dln-poll';

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
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_events_metaboxes' ) );
		add_action( 'option_rewrite_rules', array(&$this, 'check_rewrite_rules') );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( '@TODO', array( $this, 'action_method_name' ) );
		add_filter( '@TODO', array( $this, 'filter_method_name' ) );

	}

	public function init() {
		global $wp, $wp_rewrite;
		
		// Ask page
		$wp->add_query_var( 'dln_ask' );
		$this->add_rewrite_rule( DLN_SLUG_ROOT . '/' . DLN_SLUG_ASK . '/?$', array (
			'dln_ask' => 1
		) );
		
		// Ask page
		$wp->add_query_var( 'dln_edit' );
		$this->add_rewrite_rule( DLN_SLUG_ROOT . '/' . DLN_SLUG_EDIT . '/?$', array (
				'dln_ask' => 1
		) );
		
		// Has to come before the 'question' post type definition
		register_taxonomy( 'dln_question_category', 'dln_question', array(
			'hierarchical' => true,
			'rewrite' => array( 'slug' => DLN_SLUG_ROOT . '/' . DLN_SLUG_CATEGORIES, 'with_front' => false ),
		
			'capabilities' => array(
				'manage_terms' => 'edit_others_questions',
				'edit_terms' => 'edit_others_questions',
				'delete_terms' => 'edit_others_questions',
				'assign_terms' => 'edit_published_questions'
			),
			'labels' => array(
				'name' => __( 'Question Categories', DLN_SLUG ),
				'singular_name' => __( 'Question Category', DLN_SLUG ),
				'search_items' => __( 'Search Question Categories', DLN_SLUG ),
				'all_items' => __( 'All Question Categories', DLN_SLUG ),
				'parent_item' => __( 'Parent Question Category', DLN_SLUG ),
				'parent_item_colon' => __( 'Parent Question Category:', DLN_SLUG ),
				'edit_item' => __( 'Edit Question Category', DLN_SLUG ),
				'update_item' => __( 'Update Question Category', DLN_SLUG ),
				'add_new_item' => __( 'Add New Question Category', DLN_SLUG ),
				'new_item_name' => __( 'New Question Category Name', DLN_SLUG ),
			)
		) );
		
		// Has to come before the 'question' post type definition
		register_taxonomy( 'dln_question_tag', 'dln_question', array(
			'rewrite' => array( 'slug' => DLN_SLUG_ROOT . '/' . DLN_SLUG_TAGS, 'with_front' => false ),
		
			'capabilities' => array(
				'manage_terms' => 'edit_others_questions',
				'edit_terms' => 'edit_others_questions',
				'delete_terms' => 'edit_others_questions',
				'assign_terms' => 'edit_published_questions'
			),
		
			'labels' => array(
				'name'			=> __( 'Question Tags', DLN_SLUG ),
				'singular_name'	=> __( 'Question Tag', DLN_SLUG ),
				'search_items'	=> __( 'Search Question Tags', DLN_SLUG ),
				'popular_items'	=> __( 'Popular Question Tags', DLN_SLUG ),
				'all_items'		=> __( 'All Question Tags', DLN_SLUG ),
				'edit_item'		=> __( 'Edit Question Tag', DLN_SLUG ),
				'update_item'	=> __( 'Update Question Tag', DLN_SLUG ),
				'add_new_item'	=> __( 'Add New Question Tag', DLN_SLUG ),
				'new_item_name'	=> __( 'New Question Tag Name', DLN_SLUG ),
				'separate_items_with_commas'	=> __( 'Separate question tags with commas', DLN_SLUG ),
				'add_or_remove_items'			=> __( 'Add or remove question tags', DLN_SLUG ),
				'choose_from_most_used'			=> __( 'Choose from the most used question tags', DLN_SLUG ),
			)
		) );
		
		$args = array(
			'public' => true,
			'rewrite' => array( 'slug' => QA_SLUG_ROOT, 'with_front' => false ),
			'has_archive' => true,
		
			'capability_type' => 'question',
			'capabilities' => array(
				'read' => 'read_questions',
				'edit_posts' => 'edit_published_questions',
				'delete_posts' => 'delete_published_questions',
			),
			'map_meta_cap' => true,
	
			'supports' => array( 'title', 'editor', 'author', 'comments', 'revisions' ),
		
			'labels' => array(
				'name'			=> __('Questions', DLN_SLUG),
				'singular_name'	=> __('Question', DLN_SLUG),
				'add_new'		=> __('Add New', DLN_SLUG),
				'add_new_item'	=> __('Add New Question', DLN_SLUG),
				'edit_item'		=> __('Edit Question', DLN_SLUG),
				'new_item'		=> __('New Question', DLN_SLUG),
				'view_item'		=> __('View Question', DLN_SLUG),
				'search_items'	=> __('Search Questions', DLN_SLUG),
				'not_found'		=> __('No questions found.', DLN_SLUG),
				'not_found_in_trash'	=> __('No questions found in trash.', DLN_SLUG),
			)
		);
		
		register_post_type( 'dln_question', $args );
	}
	
	public function add_rewrite_rule( $regex, $args, $position = 'top' ) {
		global $wp, $wp_rewrite;
	
		$result = add_query_arg( $args, 'index.php' );
		add_rewrite_rule( $regex, $result, $position );
	}
	
	public function check_rewrite_rules($value) {
		//prevent an infinite loop
		if ( !post_type_exists( 'question' ) )
			return $value;
	
		if (!is_array($value))
			$value = array();
	
		$array_key = QA_SLUG_ROOT . '/' . QA_SLUG_ASK . '/?$';
		if ( !array_key_exists($array_key, $value) ) {
			$this->flush_rules();
		}
		return $value;
	}
	
	/**
	 * Flush rewrite rules when the plugin is activated.
	 */
	public function flush_rules() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
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
		
		DLN_Poll_Schema::create_poll_database();
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
	
	public function add_events_metaboxes() {
		add_meta_box('wpt_events_location', 'Event Location', 'wpt_events_location', 'dln_question', 'normal', 'high');
	}
	
}
