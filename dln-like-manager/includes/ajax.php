<?php
/**
 * @package   DLN_Like_Ajax
 * @author    DinhLN <lenhatdinh@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.facebook.com/lenhatdinh
 * @copyright 2013 by DinhLN
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class endpoint for listener ajax request.
 *
 * @package   DLN_Like_Ajax
 * @author    dinhln <lenhatdinh@gmail.com> - i - 11:17:53 AM
 */
class DLN_Like_Ajax {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      protected
	 */
	protected static $instance = null;
	
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
	 * Initialize the plugin by setting localization and loading public scripts.
	 * 
	 * @since 	 1.0.0
	 * 
	 * @return   void
	 */
	private function __construct() {
		//if ( isset( $_POST['login_submit'] ) && $_POST['login_submit'] == 'ajax' &&
			if ( isset( $_POST['action'] ) && $_POST['action'] == 'social_login' ) {
			$this->social_login_process();
		}
	}
	
	/**
	 * Function process social login.
	 * 
	 * @since    1.0.0
	 * 
	 * @return   void
	 */
	public function social_login_process( $is_ajax = FALSE ) {
		if ( isset( $_REQUEST['redirect_to'] ) && $_REQUEST['redirect_to'] != '' ) {
			$redirect_to     = $_REQUEST['redirect_to'];
			// Redirect to https if user wants ssl
			if ( isset( $secure_cookie ) && $secure_cookie && false !== strpos( $redirect_to, 'wp-admin' ) ) {
				$redirect_to = preg_replace( '|^http://|', 'https://', $redirect_to );
			}
		} else {
			$redirect_to     = admin_url();
		}
		$redirect_to         = apply_filters( 'social_login_redirect_to', $redirect_to );

		$social_login_provider     = $_REQUEST['social_login_provider'];
		$dln_provider_identity_key = 'social_login_' . $social_login_provider . '_id';
		$dln_provided_signature    =  $_REQUEST['social_login_signature'];
		
		switch( $social_login_provider ) {
			case 'facebook':
				$user_login                = '';
				$username                  = '';
				$dln_provider_identity     = '';
				$dln_provider_identity_key = '';
				$dln_email                 = '';
				$dln_first_name            = '';
				$dln_last_name             = '';
				$dln_profile_url           = '';
				DLN_Like_Helpers::verify_signature( $_REQUEST['social_login_access_token'], $dln_provided_signature, $redirect_to );
				$fb_object                 = json_decode( DLN_Like_Helpers::curl_get_contents( "https://graph.facebook.com/me?access_token=" . $_REQUEST['social_login_access_token'] ) );
				if ( isset( $fb_object->{'id'} ) ) {
					$dln_provider_identity = $fb_object->{'id'};
				} else {
					die($fb_object);
				}
				if ( isset( $fb_object->{'email'} ) ) {
					$dln_email             = $fb_object->{'email'};
				}
				if ( isset( $fb_object->{'first_name'} ) ) {
					$dln_first_name        = $fb_object->{'first_name'};
				}
				if ( isset( $fb_object->{'last_name'} ) ) {
					$dln_last_name         = $fb_object->{'last_name'};
				}
				if ( isset( $fb_object->{'username'} ) ) {
					$username              = $fb_object->{'username'};
				}
				if ( isset( $fb_object->{'link'} ) ) {
					$dln_profile_url       = $fb_object->{'link'};
					$dln_name              = $dln_first_name . ' ' . $dln_last_name;
					$user_login            = ( $username ) ? strtolower( $username ) : $dln_email;
				}
				break;
		}
		
		// Cookies used to display welcome message if already signed in recently using some provider
		setcookie("social_login_current_provider", $social_login_provider, time() + 3600, SITECOOKIEPATH, COOKIE_DOMAIN, false, true );
		
		// Get user by meta
		$user_id        = DLN_Like_Helpers::get_user_by_meta( $dln_provider_identity_key, $dln_provider_identity );
		if ( $user_id ) {
			$user_data  = get_userdata( $user_id );
			$user_login = $user_data->user_login;
		} elseif ( $user_id = email_exists( $dln_email ) ) { // User not found by provider identity, check by email
			// update fbid metadata
			update_user_meta( $user_id, $dln_provider_identity_key, $dln_provider_identity );
			$user_data  = get_userdata( $user_id );
			$user_login = $user_data->user_login;
		} else { // Create new user and associate provider identity
			if ( username_exists( $user_login ) )
				$user_login = apply_filters( 'social_login_username_exists', strtolower( "dln_". md5( $social_login_provider . $dln_provider_identity ) ) );
			$userdata = array( 'user_login' => $user_login, 'user_email' => $dln_email, 'first_name' => $dln_first_name, 'last_name' => $dln_last_name, 'user_url' => $dln_profile_url, 'user_pass' => wp_generate_password() );
			// Create a new user
			$user_id  = wp_insert_user( $userdata );
			// update fbid metadata
			if ( $user_id && is_integer( $user_id ) )
				update_user_meta( $user_id, $dln_provider_identity_key, $dln_provider_identity );
		}
		if ( $user_id instanceof WP_Error ) {
			var_dump( $user_id );die();
		}
		if ( $dln_provider_identity ) {
			$tbl_user     = DLN_Class_Model_User::get_instance();
			$exist_ui     = $tbl_user->get_user( $user_id );
			$access_token = $_REQUEST[ 'social_login_access_token' ];
			if ( ! $exist_ui ) {
				$tbl_user->add_user( $user_id, $dln_provider_identity, $access_token );
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
}
