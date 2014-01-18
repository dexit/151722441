<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   DLN_Poll
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name:       DLN_Poll
 * Plugin URI:        @TODO
 * Description:       @TODO
 * Version:           1.0.0
 * Author:            @TODO
 * Author URI:        @TODO
 * Text Domain:       plugin-name-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/<owner>/<repo>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

// Define constant
define ( 'DLN_POLL_WP_VERSION', '3.8' );
define ( 'DLN_POLL_VERSION', '1.0.0' );
define ( 'DLN_POLL_PATH', plugin_dir_path ( __FILE__ ) );
define ( 'DLN_POLL_URL', plugins_url ( '', __FILE__ ) );
define ( 'DLN_POLL_PLUGIN_FILE', plugin_basename ( __FILE__ ) );
define ( 'DLN_POLL_PLUGIN_DIR', plugin_basename ( dirname ( __FILE__ ) ) );
define ( 'DLN_POLL_INC', DLN_POLL_PATH . 'inc' );

// Setup database table name
global $wpdb;
$wpdb->dln_poll_logs                 = $wpdb->prefix . 'dln_poll_logs';
$wpdb->dln_poll_voters               = $wpdb->prefix . 'dln_poll_voters';
$wpdb->dln_poll_voters_custom_fields = $wpdb->prefix . 'dln_poll_votes_custom_fields';
$wpdb->dln_poll_bans                 = $wpdb->prefix . 'dln_poll_bans';

require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-db-schema.php' );
add_action( 'plugin_loaded', array( 'DLN_Poll_Schema', 'get_instance' ) );

/*
 * @TODO:
 *
 * - replace `class-plugin-name.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-dln-poll.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace DLN_Poll with the name of the class defined in
 *   `class-plugin-name.php`
 */
register_activation_hook( __FILE__, array( 'DLN_Poll', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'DLN_Poll', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace DLN_Poll with the name of the class defined in
 *   `class-plugin-name.php`
 */
add_action( 'plugins_loaded', array( 'DLN_Poll', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name-admin.php` with the name of the plugin's admin file
 * - replace DLN_Poll_Admin with the name of the class defined in
 *   `class-plugin-name-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-dln-poll-admin.php' );
	add_action( 'plugins_loaded', array( 'DLN_Poll_Admin', 'get_instance' ) );

}
