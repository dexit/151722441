<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   DLN_Bet
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name:       DLN_Bet
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

// Define constant
define ( 'DLN_BET_WP_VERSION', '3.8' );
define ( 'DLN_BET_VERSION', '1.0.0' );
define ( 'DLN_BET_PATH', plugin_dir_path ( __FILE__ ) );
define ( 'DLN_BET_URL', plugins_url ( '', __FILE__ ) );
define ( 'DLN_BET_PLUGIN_FILE', plugin_basename ( __FILE__ ) );
define ( 'DLN_BET_PLUGIN_DIR', plugin_basename ( dirname ( __FILE__ ) ) );
define ( 'DLN_BET_INC', DLN_BET_PATH . 'inc' );
define ( 'DLN_BET_SLUG', 'dln-bet' );
define ( 'DLN_SLUG_QUESTION','dln_match' );
define ( 'DLN_SLUG_CHOOSE','dln_choose' );

// The full url to the plugin directory
if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || $_SERVER['SERVER_PORT'] == '443') {
	define( 'DLN_BET_PLUGIN_URL', preg_replace('/^http:/', 'https:', WP_PLUGIN_URL) . '/' . basename( dirname( __FILE__ ) ) . '/' );
} else {
	define( 'DLN_BET_PLUGIN_URL', WP_PLUGIN_URL . '/' . basename( dirname( __FILE__ ) ) . '/' );
}

require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-dbschema.php' );
register_activation_hook( __FILE__, array( 'DLN_Schema', 'activate' ) );
register_activation_hook( __FILE__, array( 'DLN_Schema', 'deactivate' ) );

require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-match.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-choose.php' );
