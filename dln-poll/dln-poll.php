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

// Define constant
define ( 'DLN_POLL_WP_VERSION', '3.8' );
define ( 'DLN_POLL_VERSION', '1.0.0' );
define ( 'DLN_POLL_PATH', plugin_dir_path ( __FILE__ ) );
define ( 'DLN_POLL_URL', plugins_url ( '', __FILE__ ) );
define ( 'DLN_POLL_PLUGIN_FILE', plugin_basename ( __FILE__ ) );
define ( 'DLN_POLL_PLUGIN_DIR', plugin_basename ( dirname ( __FILE__ ) ) );
define ( 'DLN_POLL_INC', DLN_POLL_PATH . 'inc' );
define ( 'DLN_SLUG', 'dln-poll' );
define ( 'DLN_SLUG_ROOT','questions' );
define ( 'DLN_SLUG_ASK', 'ask' );
define ( 'DLN_SLUG_EDIT', 'edit' );
define ( 'DLN_SLUG_CATEGORIES', 'categories' );
define ( 'DLN_SLUG_TAGS', 'tags' );
define ( 'DLN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) . '/' );
define ( 'DLN_DEFAULT_TEMPLATE_DIR', 'dln-templates' );

require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/functions-template.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-core.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-core-edit.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-question.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/dln-answer.php' );
