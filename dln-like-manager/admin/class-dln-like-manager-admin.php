<?php
/**
 * Plugin Name.
 *
 * @package   Plugin_Name_Admin
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

class DLN_Like_Manager_Admin {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	
	/**
	 * Slug of the plugin
	 * 
	 * @since    1.0.0
	 * 
	 * @var      string
	 */
	public $plugin_slug = null;
	
	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		
		$plugin = DLN_Like_Manager::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		
		// Load admin style sheet and js.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		
		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		
		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links' . $plugin_basename, array( $this, 'add_action_links' ) );
		
		add_action( '@TODO', array( $this, 'action_method_name' ) );
		add_filter( '@TODO', array( $this, 'filter_method_name' ) );
	}
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		
		return self::$instance;
		
	}
	
	/**
	 * Register and enqueue admin-specific style sheet
	 * 
	 * @since	1.0.0
	 * 
	 * @return	null
	 */
	public function enqueue_admin_styles() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}
		
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug . '-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), DLN_Like_Manager::VERSION );
		}
	}
	
	/**
	 * Register and enqueue admin-specific JavaScript
	 * 
	 * @since 	1.0.0
	 * 
	 * @return  null
	 */
	public function enqueue_admin_scripts() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return ;
		}
		
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array(), DLN_Like_Manager::VERSION );
		}
	}
	
	/**
	* Register admin menu for plugin  add_plugin_admin_menu
	* 
	* @since 	1.0.0
	* 
	* @return   void
	*/
	public function add_plugin_admin_menu() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'DLN Like Manager', $this->plugin_slug ),
			__( 'Menu Text', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);
		
		add_action( 'admin_init', array( $this, 'register_setting_groups' ) );
		
	}
	
	/**
	 * Register admin setting groups.
	 *
	 * @since    1.0.0
	 *
	 * @return   void
	 */
	public function register_setting_groups() {
		register_setting( 'dln-like-manager-settings-group', 'dln_like_facebook_api_key' );
		register_setting( 'dln-like-manager-settings-group', 'dln_like_facebook_secret_key' );
		register_setting( 'dln-like-manager-settings-group', 'dln_like_facebook_permission' );
	}
	
	/**
	* Render the setting page for this plugin.
	* 
	* @since 	1.0.0
	* 
	* @return   void
	*/
	public function display_plugin_admin_page() {
	
		include_once( 'views/setting_options.php' );
		
	}
	
	/**
	* Add settings action link to the plugins page.
	* 
	* @since 	1.0.0
	* 
	* @return   void
	*/
	public function add_action_links( $links ) {
	
		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);
		
	}
	
	/**
	* Actions are point in the execution of a page or process.
	* 
	* @since 	1.0.0
	* 
	* @return   void
	*/
	public function action_method_name() {
	}
	
	/**
	 * Filters are point in the execution of a page or process.
	 *
	 * @since 	1.0.0
	 *
	 * @return   void
	 */
	public function filter_method_name() {
	}
	
}
