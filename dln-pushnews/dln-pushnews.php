<?php
/*
 Plugin Name: DLN Push News
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Like Management for fb, pinterest or youtube...
Version: 1.0.0
Author: Dinh Le Nhat
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
*/

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * DLN_Job class.
 */
if ( ! class_exists( 'DLN_PushNews' ) ) {
	class DLN_PushNews {
	
		/**
		 * Constructor - get the plugin hooked in and ready
		 */
		public function __construct() {
			// Define constants
			define( 'DLN_PUSHNEWS_VERSION', '1.0.0' );
			define( 'DLN_PUSHNEWS', 'dln-pushnews' );
			define( 'DLN_PUSHNEWS_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
			define( 'DLN_PUSHNEWS_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
	
			// Includes
			//include( 'includes/class-dln-job-extend-wpjm.php' );
			//include( 'includes/class-dln-job-forms.php' );
			//include( 'includes/class-dln-job-shortcodes.php' );
	
			//$this->forms = new DLN_Job_Forms();
	
			if ( is_admin() )
				include( 'includes/admin/class-dln-pushnews-admin.php' );
	
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
			//register_activation_hook( __FILE__, array( $this, 'deactivate' ) );
	
			if ( is_admin() )
				include( 'includes/admin/class-dln-pushnews-admin.php' );
			include( 'dln-helpers.php' );
			include( 'includes/class-dln-facebook.php' );
			/*include( 'dln-job-functions.php' );
			 include( 'dln-job-template.php' );
			include( 'includes/class-dln-job-post-types.php' );
			include( 'includes/class-dln-job-ajax.php' );
			include( 'includes/class-dln-job-shortcodes.php' );
			include( 'includes/class-dln-job-api.php' );
			include( 'includes/class-dln-job-forms.php' );
			include( 'includes/class-dln-job-geocode.php' );
	
			if ( is_admin() )
				include( 'includes/admin/class-dln-job-admin.php' );
	
			// Init classes
			$this->forms      = new WP_Job_Manager_Forms();
			$this->post_types = new WP_Job_Manager_Post_Types();
	
			// Activation - works with symlinks
			register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), array( $this->post_types, 'register_post_types' ), 10 );
			register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), create_function( "", "include_once( 'includes/class-wp-job-manager-install.php' );" ), 10 );
			register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), 'flush_rewrite_rules', 15 );
	
			// Actions
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'switch_theme', array( $this->post_types, 'register_post_types' ), 10 );
			add_action( 'switch_theme', 'flush_rewrite_rules', 15 );
			add_action( 'widgets_init', create_function( "", "include_once( 'includes/class-wp-job-manager-widgets.php' );" ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
			add_action( 'admin_init', array( $this, 'updater' ) );*/
		}
	
		/**
		 * Handle Updates
		 */
		//public function updater() {
		//if ( version_compare( JOB_MANAGER_VERSION, get_option( 'wp_job_manager_version' ), '>' ) )
		//include_once( 'includes/class-wp-job-manager-install.php' );
		//}
	
		/**
		* Localisation
		*/
		//public function load_plugin_textdomain() {
		//load_plugin_textdomain( 'wp-job-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		//}
	
		/**
		* Register and enqueue scripts and css
		 */
		public function frontend_scripts() {
		/*wp_register_script( 'wp-job-manager-ajax-filters', JOB_MANAGER_PLUGIN_URL . '/assets/js/ajax-filters.min.js', array( 'jquery' ), JOB_MANAGER_VERSION, true );
			wp_register_script( 'wp-job-manager-job-dashboard', JOB_MANAGER_PLUGIN_URL . '/assets/js/job-dashboard.min.js', array( 'jquery' ), JOB_MANAGER_VERSION, true );
		wp_register_script( 'wp-job-manager-job-application', JOB_MANAGER_PLUGIN_URL . '/assets/js/job-application.min.js', array( 'jquery' ), JOB_MANAGER_VERSION, true );
		wp_register_script( 'wp-job-manager-job-submission', JOB_MANAGER_PLUGIN_URL . '/assets/js/job-submission.min.js', array( 'jquery' ), JOB_MANAGER_VERSION, true );
	
		wp_localize_script( 'wp-job-manager-ajax-filters', 'job_manager_ajax_filters', array(
				'ajax_url' => admin_url('admin-ajax.php')
		) );
		wp_localize_script( 'wp-job-manager-job-dashboard', 'job_manager_job_dashboard', array(
				'i18n_confirm_delete' => __( 'Are you sure you want to delete this job?', 'wp-job-manager' )
		) );
	
		wp_enqueue_style( 'wp-job-manager-frontend', JOB_MANAGER_PLUGIN_URL . '/assets/css/frontend.css' );*/
		}
	
		public static function activate() {
			//self::setup_table_user_like();
			DLN_Facebook::activate();
		}
	
		private static function setup_table_user_like() {
		global $wpdb;
	
			if ( $id !== false)
				switch_to_blog( $id );
	
				$charset_collate = '';
				if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
				if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
	
				$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}dln_user_like'");
				if (!count($tables))
				$wpdb->query("CREATE TABLE {$wpdb->prefix}dln_user_like (
				ul_id bigint(20) unsigned NOT NULL auto_increment,
				user_id bigint(20) unsigned NOT NULL default '0',
				post_id bigint(20) unsigned NOT NULL default '0',
				post_type varchar(255) default NULL,
				like_amount int(20) unsigned NOT NULL default '0',
				like_date datetime,
				PRIMARY KEY	(ul_id)
			) $charset_collate;");
		}
	}
	
	$GLOBALS['dln_pushnews'] = new DLN_PushNews();
}


