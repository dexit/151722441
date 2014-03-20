<?php

if ( ! defined( 'WPINC' ) ) { die; }

require_once 'class-facebook-helper.php';

class DLN_Facebook {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		define( 'FB_APP_ID', get_option( 'dln_fb_app_id' ) );
		define( 'FB_SECRET', get_option( 'dln_fb_secret' ) );
		
		//add options page, setup menu, etc.. - backend
		add_action( 'admin_menu', array( $this, 'fb_setting_menu' ) );
		add_action( 'admin_init', array( $this, 'fb_register_setting' ) );
		
		if ( FB_APP_ID == '' || FB_SECRET == '' ) {
			add_action( 'admin_notices', array( $this, 'notice_fb_setting_missing' ) );
		} else {
			add_action( 'init', array( $this, 'fb_header' ) );
			add_action( 'wp_footer', array( $this, 'fb_footer' ) );
			add_action( 'wp_ajax_send_access_token', array( $this, 'ajax_send_access_token' ) );
			add_action( 'wp_ajax_nopriv_send_access_token', array( $this, 'ajax_send_access_token' ) );
			add_action( 'admin_print_footer_scripts', array( $this, 'fb_footer' ) );
			add_filter( 'logout_url', array( $this, 'fb_logout_url' ) );
			add_shortcode( 'dln_fb_login', array( $this, 'shortcode_dln_fb_login' ) );
		}
		
	}
	
	public function ajax_send_access_token() {
		global $wpdb;
		check_ajax_referer( 'dln-get-user-fb', 'security' );
		$access_token = isset( $_POST['access_token'] ) ? $_POST['access_token'] : '';
		
		if ( ! $access_token )
			die(0);
		
		$user = json_decode( @file_get_contents( 'https://graph.facebook.com/me?access_token=' . $access_token ) );
		
		if( ! empty( $user ) ) {
			if( ! isset( $user->email ) || empty( $user->email ) ) {
				do_action('fb_connect_get_email_error');
			}
		
			$existing_user = $wpdb->get_var( 'SELECT DISTINCT `u`.`ID` FROM `' . $wpdb->users . '` `u` JOIN `' . $wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $user->id . '" ) OR user_email = "' . $user->email . '" OR (`m`.`meta_key` = "fb_email" AND `m`.`meta_value` = "' . $user->email . '" )  LIMIT 1 ' );

			$arr_data = new stdClass;
			$arr_data->works      = isset( $user->work ) ? $user->work : '';
			$arr_data->educations = isset( $user->education ) ? $user->education : ''; 
			$arr_data->location   = isset( $user->location ) ? $user->location : '';
			$arr_data->hometown   = isset( $user->hometown ) ? $user->hometown : '';
			$arr_data->birthday   = isset( $user->birthday ) ? $user->birthday : '';
			$arr_data->bio        = isset( $user->bio ) ? $user->bio : '';
			if( $existing_user > 0 ) {
				$fb_uid = get_user_meta( $existing_user, 'fb_uid', true );
				if( ! $fb_uid ) {
					update_user_meta( $existing_user, 'fb_uid', $user->id );
					DLN_Facebook_Helper::update_fb_all_meta( $existing_user, $arr_data, $user->id );
				}
				
				$user_info = get_userdata( $existing_user );
				do_action( 'fb_connect_fb_same_email' );
				wp_set_auth_cookie( $existing_user, true, false );
				do_action( 'wp_login', $user_info->user_login );
				echo '1';
				die();
			} else {
				do_action( 'fb_connect_fb_new_email' );
				//sanitize username
				$username = sanitize_user( $user->first_name, true );
	
				//check if username is taken
				//if so - add something in the end and check again
				$i='';
				while( username_exists( $username . $i ) ) {
					$i = absint( $i );
					$i++;
				}
	
				//this will be new user login name
				$username = $username . $i;
	
				//put everything in nice array
				$userdata = array(
					'user_pass'		=>	wp_generate_password(),
					'user_login'	=>	$username,
					'user_nicename'	=>	$username,
					'user_email'	=>	$user->email,
					'display_name'	=>	$user->name,
					'nickname'		=>	$username,
					'first_name'	=>	$user->first_name,
					'last_name'		=>	$user->last_name,
					'role'			=>	'subscriber'
				);
				$userdata = apply_filters( 'fb_connect_new_userdata', $userdata, $user );
				//create new user
				$new_user = absint( wp_insert_user( $userdata ) );
				do_action( 'fb_connect_new_user', $new_user );
				//if user created succesfully - log in and reload
				if( $new_user > 0 ) {
					update_user_meta( $new_user, 'fb_uid', $user->id );
					DLN_Facebook_Helper::update_fb_all_meta( $new_user, $arr_data, $user->id );
					
					$user_info = get_userdata( $new_user );
					wp_set_auth_cookie( $new_user, true, false );
					do_action( 'wp_login', $user_info->user_login );
					//wp_redirect( wp_get_referer() );
					echo '1';
					die();
				} else {
					die(0);
				}
			}
		}
	}
	
	public function fb_logout_url($url){
		return $url;
	}
	
	public function fb_header() {
		wp_enqueue_script( 'fb_js_libs', 'http://connect.facebook.net/en_US/all.js', array('jquery') );
	}
	
	public function fb_footer(){
		wp_enqueue_script( 'dln_facebook_handle', plugins_url( 'assets/js/facebook-handle.js', __FILE__ ), 'jquery', DLN_SKILL_VERSION, true );
		$vars = array(
			'ajaxurl'      => admin_url( 'admin-ajax.php' ),
			'fb_app_id'    => FB_APP_ID,
			'is_logged_in' => is_user_logged_in(),
			'nonce'        => wp_create_nonce( 'dln-get-user-fb' ),
		);
		wp_localize_script( 'dln_facebook_handle', 'dln_vars', $vars );
		?>
		<div id="fb-root"></div>
		<?php
	}
	
	public function fb_setting_menu() {
		add_options_page( 'Facebook Connect Setting', 'Facebook Connect', 'manage_options', 'dln_fb_options', array( $this, 'dln_fb_options' ) );
	}
	
	public function fb_register_setting() {
		register_setting( 'dln_fb_settings', 'dln_fb_app_id' );
		register_setting( 'dln_fb_settings', 'dln_fb_secret' );
	}
	
	public function dln_fb_options() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Facebook Connect', 'dln-skill' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'dln_fb_settings' ); ?>
				
				<table class="form-table">
					<tr>
					<?php printf(__('Already registered? Find your keys in your <a target="_blank" href="%2$s">%1$s Application List</a>', 'dln-skill'), 'Facebook', 'http://www.facebook.com/developers/apps.php'); ?>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Facebook Application API ID:', 'dln-skill' ); ?></th>
						<td><input type="text" name="dln_fb_app_id" value="<?php echo get_option( 'dln_fb_app_id' ); ?>" /></td>
					</tr>
					 
					<tr valign="top">
						<th scope="row"><?php _e( 'Faceook Application secret:', 'dln-skill' ); ?></th>
						<td><input type="text" name="dln_fb_secret" value="<?php echo get_option( 'dln_fb_secret' ); ?>" /></td>
					</tr>
				</table>
				
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			
			</form>
		</div>
		<?php
	}
	
	public function notice_fb_setting_missing() {
		?>
		<div class="error">
			<p><?php printf( __( 'Facebook Connect plugin is almost ready. To start using Facebook Connect <strong>you need to set your Facebook Application API ID and Faceook Application secret</strong>. You can do that in <a href="%1s">Facebook Connect settings page</a>.', 'wpsc' ), admin_url( 'options-general.php?page=dln_fb_options' ) ) ?></p>
		</div> 
		<?php
	}
	
	public function shortcode_dln_fb_login( $atts ){
		global $wpdb;
		extract( shortcode_atts( array (
			'size'         => 'medium',
			'login_text'   => __( 'Login', 'dln-skill'),
			'logout_text'  => __( 'Logout', 'dln-skill'),
			'connect_text' => __( 'Connect', 'dln-skill')
		), $atts ) );
	
		//only show facebook connect when user is not logged in
		//if( is_user_logged_in() ) {
			//do_action('fb_connect_button_nofb_wp');
			?>
			<a id="loginButton" class="button" href="#" ><?php echo $connect_text; ?></a>
			<?php
		/*} else {
			if( $cookie ) {
				//this should never happen, because there is login process on 
				//INIT and by this time you should either be loged in or have new user created and loged in
				do_action('fb_connect_button_fb_nowp');
				_e('Facebook Connect error: login process failed!', 'wp-facebook-connect');
			} else {
				do_action('fb_connect_button_nofb_nowp');
				?>
				<fb:login-button perms="<?php echo implode(',', $perms); ?>" size="<?php echo $size; ?>" >
					<?php echo $login_text; ?>
				</fb:login-button>
				<?php
			}
		}*/
	}
	
}

DLN_Facebook::get_instance();
