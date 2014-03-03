<?php

if ( ! defined( 'WPINC' ) ) { die; }

/**
 * DLN_Facebook class.
 */
class DLN_Facebook {
	
	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'login_head', array( $this, 'add_stylesheets' ) );
		add_action( 'wp_head',    array( $this, 'add_stylesheets' ) );
		add_action( 'login_head', array( $this, 'add_javascripts' ) );
		add_action( 'wp_head',    array( $this, 'add_javascripts' ) );
		
		add_action( 'login_form',          array( $this, 'render_form_login' ) );
		add_action( 'register_form',       array( $this, 'render_form_login' ) );
		add_action( 'after_signup_form',   array( $this, 'render_form_login' ) );
		add_action( 'social_login_form',   array( $this, 'render_form_login' ) );
		// Hook to 'login_form_' . $action
		add_action( 'login_form_social_login', array( $this, 'process_login' ) );
		add_action( 'init', array( $this, 'ajax_login' ) );
		add_action( 'wp_footer', 'render_login_page_uri' );
	}
	
	public static function ajax_login() {
		if ( isset( $_POST[ 'login_submit' ] ) && $_POST[ 'login_submit' ] == 'ajax' &&
		isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'social_login' ) {
			self::process_login( true );
		}
	}
	
	public static function process_login( $is_ajax = false ) {
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
				self::verify_signature( $_REQUEST[ 'social_login_access_token' ], $dln_provided_signature, $redirect_to );
				$fb_json = json_decode( DLN_Helpers::curl_get_contents("https://graph.facebook.com/me?access_token=" . $_REQUEST[ 'social_login_access_token' ]) );
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
		$user_id = self::get_user_by_meta( $dln_provider_identity_key, $dln_provider_identity );
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
			$exist_ui = self::get_field( 'dln_users', 'fbid', "userid={$user_id}" );
			$access_token = $_REQUEST[ 'social_login_access_token' ];
			if ( ! $exist_ui ) {
				$table  = 'dln_users';
				$values = "(`userid`, `fbid`, `access_token`, `crawl`) VALUES({$user_id}, '{$dln_provider_identity}', '{$access_token}', 0)";
				global $wpdb;
				$table = $wpdb->prefix . $table;
				$wpdb->get_row( "INSERT INTO {$table} {$values}" );
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
	
	public static function get_field( $table = '', $key = '', $where = '' ) {
		if ( ! $table || ! $key || ! $where )
			return null;
		global $wpdb;
		$table = $wpdb->prefix . $table;
		$result = $wpdb->get_row( "SELECT * FROM {$table} WHERE {$where}" );
		return $result;
	}
	
	public static function get_user_by_meta( $meta_key, $meta_value ) {
		global $wpdb;
	
		$sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
		return $wpdb->get_var( $wpdb->prepare( $sql, $meta_key, $meta_value ) );
	}
	
	public static function add_stylesheets(){
		if( !wp_style_is( 'dln-facebook-login', 'registered' ) ) {
			wp_register_style( 'dln-facebook-login', DLN_PUSHNEWS_URL . '/assets/css/style.css' );
			//wp_register_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/smoothness/jquery-ui.css' );
		}
	
		if ( did_action( 'wp_print_styles' ) ) {
			wp_print_styles( 'dln-facebook-login' );
			wp_print_styles( 'jquery-ui' );
		} else {
			wp_enqueue_style( 'dln-facebook-login' );
			wp_enqueue_style( 'jquery-ui' );
		}
	}
	
	public static function add_javascripts(){
		if( ! wp_script_is( 'dln-facebook-js', 'registered' ) ) {
			wp_register_script( 'dln-facebook-js', DLN_PUSHNEWS_URL . '/assets/js/login.js' );
			$scope = get_option( 'social_login_facebook_permission' );
			$scope = ( $scope ) ? $scope : 'email';
			$args = array( 'scope' => $scope );
			wp_localize_script( 'dln-facebook-js', 'dln_vars', $args );
		}
		wp_print_scripts( 'jquery' );
		wp_print_scripts( 'jquery-ui-core' );
		wp_print_scripts( 'jquery-ui-dialog' );
		wp_print_scripts( 'dln-facebook-js' );
	}
	
	public static function render_login_page_uri() {
		$social_login_login_form_uri = get_option( 'social_login_login_form_uri' );
		$social_login_login_form_uri = ( $social_login_login_form_uri ) ? $social_login_login_form_uri : site_url( 'wp-login.php', 'login_post' );
		?>
		<input type="hidden" id="social_login_login_form_uri" value="<?php echo $social_login_login_form_uri ?>" />
		<?php
	}
	
	public static function render_form_login( $args = NULL ) {
	
		if( $args == NULL )
			$display_label = true;
		elseif ( is_array( $args ) )
		extract( $args );
	
		if( !isset( $images_url ) )
			$images_url = DLN_PUSHNEWS_URL . '/assets/img/';
		?>
		<div class="social_login_ui <?php if( strpos( $_SERVER['REQUEST_URI'], 'wp-signup.php' ) ) echo 'mu_signup'; ?>">
			<?php if( $display_label !== false ) : ?>
				<div style="margin-bottom: 3px;"><label><?php _e( 'Connect with', 'social_login' ); ?>:</label></div>
			<?php endif; ?>
			<div class="social_login_form" title="Social Connect">
				<a href="javascript:void(0);" title="Facebook" class="social_login_login_facebook"><img alt="Facebook" src="<?php echo $images_url . 'facebook_32.png' ?>" /></a>
			</div>
	
			<?php
		$social_login_provider = isset( $_COOKIE['social_login_current_provider']) ? $_COOKIE['social_login_current_provider'] : '';
	
	?>
		<div id="social_login_facebook_auth">
			<input type="hidden" name="client_id" value="<?php echo get_option( 'social_login_facebook_api_key' ); ?>" />
			<input type="hidden" name="redirect_uri" value="<?php echo urlencode( DLN_PUSHNEWS_URL . '/facebook/callback.php' ); ?>" />
		</div>
	</div> <!-- End of social_login_ui div -->
	<?php
	}
	
	public static function generate_signature( $data ) {
		return hash( 'SHA256', AUTH_KEY . $data );
	}
	
	public static function verify_signature( $data, $signature, $redirect_to ) {
		$generated_signature = self::generate_signature( $data );
	
		if( $generated_signature != $signature ) {
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	public static function activate() {
		self::setup_table_dln_users();
	}
	
	public static function setup_table_dln_users() {
		global $wpdb;
		
		$charset_collate = '';
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
		
		$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}dln_users'");
		if (!count($tables))
			$wpdb->query("CREATE TABLE {$wpdb->prefix}dln_users (
			id bigint(20)  NOT NULL auto_increment,
			userid bigint(35) default NULL,
			fbid varchar(255) default NULL,
			access_token text default NULL,
			crawl tinyint(1) default '0',
			PRIMARY KEY	(id)
		) $charset_collate;");
	}
}
new DLN_Facebook();