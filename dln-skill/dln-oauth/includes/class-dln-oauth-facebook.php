<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_OAuth_Facebook {
	
	protected $fb_app_id    = '1446113338979798';
	
	protected $fb_secret    = '0b996585ef99c01b4c486006a525e3d6';
	
	protected $redirect_uri = 'http://localhost/wp/oauth/facebook';
	
	protected $display      = 'popup';
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		if ( isset( $_GET['code'] ) && ! empty( $_GET['code'] ) ) {
			$this->process_code();
		} else {
			$this->process_request();
		}
	}
	
	protected function process_code() {
		$code        = $_GET['code'];
		$request_url = "https://graph.facebook.com/oauth/access_token?code={$code}&client_id={$this->fb_app_id}&client_secret={$this->fb_secret}&redirect_uri={$this->redirect_uri}";

		try {
			$data = file_get_contents( $request_url );
			parse_str( $data );
			if ( $access_token ) {
				// grant access token
				$request_url = "https://graph.facebook.com/oauth/access_token?client_id={$this->fb_app_id}&client_secret={$this->fb_secret}&grant_type=fb_exchange_token&fb_exchange_token={$access_token}";
				$data        = file_get_contents( $request_url );
				parse_str( $data );
				$user_infor  = json_decode( file_get_contents( "https://graph.facebook.com/me?access_token=" . $access_token ) );
				$user_infor->access_token = $access_token;
				$user_id     = $this->add_user( $user_infor );
				if ( $user_id ) {
					$uuid    = get_transient( 'dln_uuid' );
					update_user_meta( $user_id, 'dln_uuid', $uuid );
				}
				ob_start();
				?>
				 <script type="text/javascript">
				     window.close();
				</script>
				<?php
				$content = ob_get_clean();
				echo $content;
			}
		} catch (Exception $e) {
			var_dump($e);
		}
		
		exit();
	}
	
	protected function process_request() {
		// get uuid
		if ( isset( $_GET['uuid'] ) ) {
			set_transient( 'dln_uuid', $_GET['uuid'] );
		}
		$request_url = "https://www.facebook.com/dialog/oauth?client_id={$this->fb_app_id}&redirect_uri={$this->redirect_uri}&scope=email&response_type=code&display={$this->display}";
		
		wp_redirect( $request_url );
		exit();
	}
	
	protected function add_user( $user_data ) {
		if ( ! $user_data ) return 0;
		
		if ( isset( $user_data->email ) && ! empty( $user_data->email ) ) {
			// Check user has exists in system
			$user = get_user_by( 'email', $user_data->email );
			if ( $user )
				return $user->ID;
			
			// Process username
			$username = sanitize_user( $user_data->first_name, true );
			$i='';
			while( username_exists( $username . $i ) ) {
				$i = absint( $i );
				$i++;
			}
			$username = $username . $i;
			$password = wp_generate_password();
			
			
			if ( function_exists('bp_core_signup_user') ) {
				$user_login = '';
				$new_user = bp_core_signup_user( $username, $password, $user_data->email, array() );
				$data = array(
					'ID'            => $new_user,
					'user_nicename' => $username,
					'user_email'    => $user_data->email,
					'display_name'  => $user_data->name,
					'nickname'      => $username,
					'first_name'    => $user_data->first_name,
					'last_name'     => $user_data->last_name,
					'role'          => 'subscriber',
				);
				wp_update_user( $data );
				if ( $new_user ) {
					update_user_meta( $new_user, 'fb_uid', $user_data->id );
					update_user_meta( $new_user, 'link', $user_data->link );
					update_user_meta( $new_user, 'updated_time', $user_data->updated_time );
					update_user_meta( $new_user, 'fb_access_token', $user_data->access_token );
				}
			} else {
				$data = array(
					'user_pass'     => $password,
					'user_login'    => $username,
					'user_nicename' => $username,
					'user_email'    => $user_data->email,
					'display_name'  => $user_data->name,
					'nickname'      => $username,
					'first_name'    => $user_data->first_name,
					'last_name'     => $user_data->last_name,
					'role'          => 'subscriber',
					'user_status'   => '2'
				);
					
				$new_user = absint( wp_insert_user( $data ) );
				if ( $new_user ) {
					update_user_meta( $new_user, 'fb_uid', $user_data->id );
					update_user_meta( $new_user, 'link', $user_data->link );
					update_user_meta( $new_user, 'updated_time', $user_data->updated_time );
					update_user_meta( $new_user, 'fb_access_token', $user_data->access_token );
				}
			}
			
			return $new_user;
		}
		
		return 0;
	}
	
}

DLN_OAuth_Facebook::get_instance();