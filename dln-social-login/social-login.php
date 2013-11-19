<?php
/*
Plugin Name: DLN Social Login
Plugin URI: http://www.facebook.com/lenhatdinh
Description: Login Facebook account and get user informations.
Version: 0.1
Author: Brent Shepherd
Author URI: http://www.facebook.com/lenhatdinh
License: GPL2
 */

/**
 * 
 */
function dln_setup_db() {
	global $wpdb;
	
	if( @is_file( ABSPATH . '/wp-admin/includes/upgrade.php' ) )
		include_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	else
		die( __( 'We have problem finding your \'/wp-admin/upgrade-functions.php\' and \'/wp-admin/includes/upgrade.php\'', 'social_login' ) );
	
	if ( ! empty( $wpdb->charset ) )
		$db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	if ( ! empty( $wpdb->collate ) )
		$db_charset_collate .= " COLLATE $wpdb->collate";
	
	$table = $wpdb->base_prefix . 'dln_users';
	$sql = "CREATE TABLE $table (
	id bigint(20) unsigned NOT NULL auto_increment,
	userid bigint(35) NOT NULL default '0',
	fbid varchar(35) NULL,
	access_token text NULL,
	crawl bool DEFAULT 0,
	PRIMARY KEY  (id)
	) ENGINE=MyISAM $db_charset_collate;";
	dbDelta( $sql );
}

/**
 * Check technical requirements are fulfilled before activating.
 **/
function dln_activate(){
	if ( !function_exists( 'register_post_status' ) || !function_exists( 'curl_version' ) || !function_exists( 'hash' ) || version_compare( PHP_VERSION, '5.1.2', '<' ) ) {
		deactivate_plugins( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );
		if ( !function_exists( 'register_post_status' ) )
			wp_die( sprintf( __( "Sorry, but you can not run Social Connect. It requires WordPress 3.0 or newer. Consider <a href='http://codex.wordpress.org/Updating_WordPress'>upgrading</a> your WordPress installation, it's worth the effort.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'social_connect'), admin_url( 'plugins.php' ) ), 'social-connect' );
		elseif ( !function_exists( 'curl_version' ) )
			wp_die( sprintf( __( "Sorry, but you can not run Social Connect. It requires the <a href='http://www.php.net/manual/en/intro.curl.php'>PHP libcurl extension</a> be installed. Please contact your web host and request libcurl be <a href='http://www.php.net/manual/en/intro.curl.php'>installed</a>.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'social_connect'), admin_url( 'plugins.php' ) ), 'social-connect' );
		elseif ( !function_exists( 'hash' ) )
			wp_die( sprintf( __( "Sorry, but you can not run Social Connect. It requires the <a href='http://www.php.net/manual/en/intro.hash.php'>PHP Hash Engine</a>. Please contact your web host and request Hash engine be <a href='http://www.php.net/manual/en/hash.setup.php'>installed</a>.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'social_connect'), admin_url( 'plugins.php' ) ), 'social-connect' );
		else
			wp_die( sprintf( __( "Sorry, but you can not run Social Connect. It requires PHP 5.1.2 or newer. Please contact your web host and request they <a href='http://www.php.net/manual/en/migration5.php'>migrate</a> your PHP installation to run Social Connect.<br/><a href=\"%s\">Return to Plugins Admin page &raquo;</a>", 'social_connect'), admin_url( 'plugins.php' ) ), 'social-connect' );
	}
	do_action( 'dln_activation' );
	dln_setup_db();
}
register_activation_hook( __FILE__, 'dln_activate' );

require_once( dirname( __FILE__ ) . '/constants.php' );
require_once( dirname( __FILE__ ) . '/utils.php' );
require_once( dirname( __FILE__ ) . '/assets.php' );
require_once( dirname( __FILE__ ) . '/admin.php' );
require_once( dirname( __FILE__ ) . '/ui.php' );

function dln_social_login_process_login( $is_ajax = false ) {
	if ( isset( $_REQUEST[ 'redirect_to' ] ) && $_REQUEST[ 'redirect_to' ] != '' ) {
		$redirect_to = $_REQUEST[ 'redirect_to' ];
		// Redirect to https if user wants ssl
		if ( isset( $secure_cookie ) && $secure_cookie && false !== strpos( $redirect_to, 'wp-admin') )
			$redirect_to = preg_replace( '|^http://|', 'https://', $redirect_to );
	} else {
		$redirect_to = admin_url();
	}
	
	$redirect_to = apply_filters( 'social_login_redirect_to', $redirect_to );
	
	$social_login_provider = $_REQUEST[ 'social_login_provider' ];
	$dln_provider_identity_key = 'social_login_' . $social_login_provider . '_id';
	$dln_provided_signature =  $_REQUEST[ 'social_login_signature' ];
	
	switch( $social_login_provider ) {
		case 'facebook':
			$user_login = $username = $dln_provider_identity = $dln_provider_identity_key = $dln_email = $dln_first_name = $dln_last_name = $dln_profile_url = '';
			social_login_verify_signature( $_REQUEST[ 'social_login_access_token' ], $dln_provided_signature, $redirect_to );
			$fb_json = json_decode( dln_curl_get_contents("https://graph.facebook.com/me?access_token=" . $_REQUEST[ 'social_login_access_token' ]) );
			if ( isset( $fb_json->{ 'id' } ) ) {
				$dln_provider_identity = $fb_json->{ 'id' };
			} else {
				die($fb_json);
			}
			if ( isset( $fb_json->{ 'email' } ) ) {
				$dln_email = $fb_json->{ 'email' };
			}
			if ( isset( $fb_json->{ 'first_name' } ) ) {
				$dln_first_name = $fb_json->{ 'first_name' };
			}
			if ( isset( $fb_json->{ 'last_name' } ) ) {
				$dln_last_name = $fb_json->{ 'last_name' };
			}
			if ( isset( $fb_json->{ 'username' } ) ) {
				$username = $fb_json->{ 'username' };
			}
			if ( isset( $fb_json->{ 'link' } ) ) {
				$dln_profile_url = $fb_json->{ 'link' };
				$dln_name = $dln_first_name . ' ' . $dln_last_name;
				$user_login = ($username) ? strtolower( $username ) : $dln_email;
			}
			break;
	}

	// Cookies used to display welcome message if already signed in recently using some provider
	setcookie("social_login_current_provider", $social_login_provider, time()+3600, SITECOOKIEPATH, COOKIE_DOMAIN, false, true );
	
	// Get user by meta
	$user_id = social_login_get_user_by_meta( $dln_provider_identity_key, $dln_provider_identity );
	if ( $user_id ) {
		$user_data  = get_userdata( $user_id );
		$user_login = $user_data->user_login;
	} elseif ( $user_id = email_exists( $dln_email ) ) { // User not found by provider identity, check by email
		update_user_meta( $user_id, $dln_provider_identity_key, $dln_provider_identity );
	
		$user_data  = get_userdata( $user_id );
		$user_login = $user_data->user_login;
	
	} else { // Create new user and associate provider identity
		if ( username_exists( $user_login ) )
			$user_login = apply_filters( 'social_login_username_exists', strtolower("dln_". md5( $social_login_provider . $dln_provider_identity ) ) );
	
		$userdata = array( 'user_login' => $user_login, 'user_email' => $dln_email, 'first_name' => $dln_first_name, 'last_name' => $dln_last_name, 'user_url' => $dln_profile_url, 'user_pass' => wp_generate_password() );
	
		// Create a new user
		$user_id = wp_insert_user( $userdata );
	
		if ( $user_id && is_integer( $user_id ) )
			update_user_meta( $user_id, $dln_provider_identity_key, $dln_provider_identity );
	}
	if ( $user_id instanceof WP_Error ) {
		var_dump($user_id);die();
	}
	if ( $dln_provider_identity ) {
		$exist_ui = dln_get_field( 'dln_users', 'fbid', "userid={$user_id}" );
		$access_token = $_REQUEST[ 'social_login_access_token' ];
		if ( ! $exist_ui ) {
			dln_insert_field( 'dln_users', "(`userid`, `fbid`, `access_token`, `crawl`) VALUES({$user_id}, '{$dln_provider_identity}', '{$access_token}', 0)" );
		}
	}
	
	wp_set_auth_cookie( $user_id );
	
	do_action( 'social_login_login', $user_login );
	
	if ( $is_ajax )
		echo '{"redirect":"' . $redirect_to . '"}';
	else
		wp_safe_redirect( $redirect_to );
	exit();
}

// Hook to 'login_form_' . $action
add_action( 'login_form_social_login', 'dln_social_login_process_login');

function dln_ajax_login() {
	if ( isset( $_POST[ 'login_submit' ] ) && $_POST[ 'login_submit' ] == 'ajax' &&
		isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'social_login' ) {
		dln_social_login_process_login( true );
	}
}

add_action( 'init', 'dln_ajax_login' );