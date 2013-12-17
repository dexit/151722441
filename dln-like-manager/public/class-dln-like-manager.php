<?php
/**
 * @package   DLN_Like_Manager
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

/**
 * This class should be work with font-end side.
 *
 * @package   DLN_Like_Manager
 * @author    dinhln <lenhatdinh@gmail.com> - i - 3:37:54 PM
 */
class DLN_Like_Manager {

	/**
	 * Plugin version, used for style and script files references.
	 *
	 * @since    1.0.0
	 *
	 * @var      const
	 */
	const VERSION = '1.0.0';
	
	/**
	 * Slug of plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected $plugin_slug = 'dln-like-manager';
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected static $instance = null;
	
	/**
	 * Initialize the plugin by setting localization and loading public scripts.
	 * 
	 * @since 	 1.0.0
	 * 
	 * @return   void
	 */
	private function __construct() {
		
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Activate plugin when new blog is added
		//add_action( '' );
		
		// Load public style and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		// Define custon functionality
		add_action( '@TODO', array( $this, 'action_method_name' ) );
		add_action( '@TODO', array( $this, 'filter_method_name' ) );
		
		$this->include_files();

		// Add shortcodes
		$shortcodes = DLN_Like_Shortcode::get_instance();
	}
	
	/**
	 * Return the plugin slug.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   string
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug; 
	}
	
	/**
	 * Return an instance of this class.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   object
	 */
	public static function get_instance() {
		
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	/**
	 * Fire when the plugin is activated.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public static function activate( $network_wide ) {
		
	}
	
	/**
	 * Fire when the plugin is deactivated.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public static function deactive( $network_wide ) {
		
	}
	
	/**
	 * Load the plugin text domain for translation.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function load_plugin_textdomain() {
	
		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR )  . $domain . '/' . $domain . '-' . $locale . '.mo');
		
	}
	
	/**
	 * Require includes files.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	private function include_files() {
	
		// require includes files
		$files = glob( plugin_dir_path( __FILE__ ) . 'includes/*.php' );
		foreach ( $files as $file ) {
		    require_once( $file );
		};
		
	}
	
	/**
	 * Register and enqueue public style sheet.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}
	
	/**
	 * Register and enqueue public JavaScript.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-scripts', plugins_url( 'assets/js/public.js', __FILE__ ), array(), self::VERSION );
	}
	
	/**
	 * All fontend actions.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function action_method_name() {
	
	}
	
	/**
	 * All frontend filters.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function filter_method_name() {
	
	}
}
