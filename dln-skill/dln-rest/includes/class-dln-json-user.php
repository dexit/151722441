<?php 

class DLN_JSON_User {
	
	protected $servers;
	
	public function __construct( WP_JSON_ResponseHandler $server ) {
		header("Access-Control-Allow-Origin: *");
		$this->server = $server;
	}
	
	public function register_routes( $routes ) {
		$user_routes = array (
			// User endpoints
			'/user' => array(
				array( array( $this, 'get_users' ),        WP_JSON_Server::READABLE ),
				array( array( $this, 'new_user' ),         WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
			),
			'/user/(?P<id>\d+)' => array(
				array( array( $this, 'get_user' ),         WP_JSON_Server::READABLE ),
				array( array( $this, 'edit_user' ),        WP_JSON_Server::EDITABLE | WP_JSON_Server::ACCEPT_JSON ),
				//array( array( $this, 'delete_user' ),      WP_JSON_Server::DELETABLE ),
			),
			'/user/login' => array(
				array( array( $this, 'auth_user' ),        WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON )
			),
			'/user/match' => array (
				array( array( $this, 'add_user_match' ),   WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON )
			),
		);
		return array_merge( $routes, $user_routes );
	}
	
	public function add_user_match() {
		$data = null;
		if ( isset( $_POST['data'] ) ) {
			$data = json_decode( stripslashes( $_POST['data'] ), ARRAY_N );
		}
		if ( empty( $data ) ) {
			return new WP_Error( 'json_user_invalid_data', __( 'Invalid data parameters.' ), array( 'status' => 404 ) );
		}
		if ( ! DLN_Helper_Decrypt::get_decrypt() ) {
			return new WP_Error( 'json_user_invalid_code', __( 'Invalid data verify code.' ), array( 'status' => 404 ) );
		}
		
		// Check params
		$required = array( 'match_id', 'user_id', 'money' );
		foreach ( $required as $arg ) {
			if ( empty( $data[ $arg ] ) ) {
				if ( isset( $_GET['debug'] ) && $_GET['debug'] == 'true' ) {
					return new WP_Error( 'json_missing_callback_param', sprintf( __( 'Missing parameter %s' ), $arg ), array( 'status' => 400 ) );
				} else {
					return new WP_Error( 'json_missing_callback_param', sprintf( __( 'Missing parameter!' ), $arg ), array( 'status' => 400 ) );
				}
			}
		}
		
		extract( $data );
		$limit = get_post_meta( $match_id, 'dln_limit_people' );
		$limit = (int) $limit;

		global $wpdb;
		$sql    = $wpdb->prepare( "SELECT COUNT(user_id) as count FROM {$wpdb->dln_match_user} WHERE match_id = %s", $match_id );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		if ( isset( $result['count'] ) && $result['count'] <= $limit ) {
			$current_time  = date( 'Y-m-d H:i:s', time() );
			$data = array(
				'match_id'    => (int) $match_id,
				'user_id'     => (int) $user_id,
				'money'       => (int) $money,
				'time_create' => $current_time
			);
			$int = $wpdb->insert( $wpdb->dln_match_user, $data );
			
			return $int;
		} else {
			return new WP_Error( 'json_user_limit', sprintf( __( "Can't add more user to match" ), $arg ), array( 'status' => 400 ) );
		}
	}
	
	public function get_users( $filter = array(), $context = 'view', $page = 1 ) {
		//if ( ! current_user_can( 'list_users' ) ) {
		//	return new WP_Error( 'json_user_cannot_list', __( 'Sorry, you are not allowed to list users.' ), array( 'status' => 403 ) );
		//}
	
		$args = array(
			'orderby' => 'user_login',
			'order'   => 'ASC'
		);
		$args = array_merge( $args, $filter );
	
		$args = apply_filters( 'json_user_query', $args, $filter, $context, $page );
	
		// Pagination
		$args['number'] = empty( $args['number'] ) ? 10 : absint( $args['number'] );
		$page           = absint( $page );
		$args['offset'] = ( $page - 1 ) * $args['number'];
	
		$user_query = new WP_User_Query( $args );
	
		if ( empty( $user_query->results ) ) {
			return array();
		}
	
		$struct = array();
	
		foreach ( $user_query->results as $user ) {
			$struct[] = $this->prepare_user( $user, $context );
		}
	
		return $struct;
	}
	
	public function get_user( $id, $context = 'view' ) {
		//$current_user_id = get_current_user_id();
	
		//if ( $current_user_id !== $id && ! current_user_can( 'list_users' ) ) {
		//	return new WP_Error( 'json_user_cannot_list', __( 'Sorry, you are not allowed to view this user.' ), array( 'status' => 403 ) );
		//}
	
		$user = get_userdata( $id );
	
		if ( empty( $user->ID ) ) {
			return new WP_Error( 'json_user_invalid_id', __( 'Invalid user ID.' ), array( 'status' => 400 ) );
		}
	
		return $this->prepare_user( $user, $context );
	}
	
	public function auth_user() {
		$data = $email = $password = $username = null;
		if ( isset( $_POST['data'] ) ) {
			$data = json_decode( stripslashes( $_POST['data'] ), ARRAY_N );
		}
		if ( empty( $data ) ) {
			return new WP_Error( 'json_money_invalid_data', __( 'Invalid data parameters.' ), array( 'status' => 404 ) );
		}
		
		$required = array( 'password', 'email' );
		
		foreach ( $required as $arg ) {
			if ( empty( $data[ $arg ] ) ) {
				if ( isset( $_GET['debug'] ) && $_GET['debug'] == 'true' ) {
					return new WP_Error( 'json_missing_callback_param', sprintf( __( 'Missing parameter %s' ), $arg ), array( 'status' => 400 ) );
				} else {
					return new WP_Error( 'json_missing_callback_param', sprintf( __( 'Missing parameter!' ), $arg ), array( 'status' => 400 ) );
				}
			}
		}
		
		if ( ! empty( $data['email'] ) ) {
			$email = $data['email'];
		}
		
		if ( ! empty( $data['password'] ) ) {
			$password = base64_decode( $data['password'] );
		}
		
		$user        = get_user_by( 'email', $email );
		$username    = $user->user_login;
		$user_result = wp_authenticate( $username, $password);
		
		return $user_result;
	}
	
	public function new_user() {
		$data = null;
		if ( isset( $_POST['data'] ) ) {
			$data = json_decode( stripslashes( $_POST['data'] ), ARRAY_N );
		}
		if ( empty( $data ) ) {
			return new WP_Error( 'json_money_invalid_data', __( 'Invalid data parameters.' ), array( 'status' => 404 ) );
		}
		if ( ! DLN_Helper_Decrypt::get_decrypt() ) {
			return new WP_Error( 'json_user_invalid_code', __( 'Invalid data verify code.' ), array( 'status' => 404 ) );
		}
		
		//if ( ! current_user_can( 'create_users' ) ) {
		//	return new WP_Error( 'json_cannot_create', __( 'Sorry, you are not allowed to create users.' ), array( 'status' => 403 ) );
		//}
	
		if ( ! empty( $data['ID'] ) ) {
			return new WP_Error( 'json_user_exists', __( 'Cannot create existing user.' ), array( 'status' => 400 ) );
		}
	
		$user_id = $this->insert_user( $data );
	
		if ( is_wp_error( $user_id ) ) {
			return $user_id;
		}
	
		$response = $this->get_user( $user_id );
	
		if ( ! $response instanceof WP_JSON_ResponseInterface ) {
			$response = new WP_JSON_Response( $response );
		}
	
		$response->set_status( 201 );
		$response->header( 'Location', json_url( '/users/' . $user_id ) );
	
		return $response;
	}
	
	public function edit_user( $id, $data, $_headers = array() ) {
		$id = absint( $id );
	
		if ( empty( $id ) ) {
			return new WP_Error( 'json_user_invalid_id', __( 'User ID must be supplied.' ), array( 'status' => 400 ) );
		}
	
		// Permissions check
		if ( ! current_user_can( 'edit_user', $id ) ) {
			return new WP_Error( 'json_user_cannot_edit', __( 'Sorry, you are not allowed to edit this user.' ), array( 'status' => 403 ) );
		}
	
		$user = get_userdata( $id );
		if ( ! $user ) {
			return new WP_Error( 'json_user_invalid_id', __( 'User ID is invalid.' ), array( 'status' => 400 ) );
		}
	
		$data['ID'] = $user->ID;
	
		// Update attributes of the user from $data
		$retval = $this->insert_user( $data );
	
		if ( is_wp_error( $retval ) ) {
			return $retval;
		}
	
		return $this->get_user( $id );
	}
	
	public function delete_user( $id, $force = false, $reassign = null ) {
		$id = absint( $id );
	
		if ( empty( $id ) ) {
			return new WP_Error( 'json_user_invalid_id', __( 'Invalid user ID.' ), array( 'status' => 400 ) );
		}
	
		// Permissions check
		if ( ! current_user_can( 'delete_user', $id ) ) {
			return new WP_Error( 'json_user_cannot_delete', __( 'Sorry, you are not allowed to delete this user.' ), array( 'status' => 403 ) );
		}
	
		$user = get_userdata( $id );
	
		if ( ! $user ) {
			return new WP_Error( 'json_user_invalid_id', __( 'Invalid user ID.' ), array( 'status' => 400 ) );
		}
	
		if ( ! empty( $reassign ) ) {
			$reassign = absint( $reassign );
	
			// Check that reassign is valid
			if ( empty( $reassign ) || $reassign === $id || ! get_userdata( $reassign ) ) {
				return new WP_Error( 'json_user_invalid_reassign', __( 'Invalid user ID.' ), array( 'status' => 400 ) );
			}
		} else {
			$reassign = null;
		}
	
		$result = wp_delete_user( $id, $reassign );
	
		if ( ! $result ) {
			return new WP_Error( 'json_cannot_delete', __( 'The user cannot be deleted.' ), array( 'status' => 500 ) );
		} else {
			return array( 'message' => __( 'Deleted user' ) );
		}
	}
	
	protected function insert_user() {
		$data = null;
		if ( isset( $_POST['data'] ) ) {
			$data = json_decode( stripslashes( $_POST['data'] ), ARRAY_N );
		}
		if ( empty( $data ) ) {
			return new WP_Error( 'json_money_invalid_data', __( 'Invalid data parameters.' ), array( 'status' => 404 ) );
		}
		
		$user = new stdClass;
	
		if ( ! empty( $data['ID'] ) ) {
			$existing = get_userdata( $data['ID'] );
	
			if ( ! $existing ) {
				return new WP_Error( 'json_user_invalid_id', __( 'Invalid user ID.' ), array( 'status' => 404 ) );
			}
	
			//if ( ! current_user_can( 'edit_user', $data['ID'] ) ) {
			//	return new WP_Error( 'json_user_cannot_edit', __( 'Sorry, you are not allowed to edit this user.' ), array( 'status' => 403 ) );
			//}
	
			$user->ID = $existing->ID;
			$update = true;
		} else {
			//if ( ! current_user_can( 'create_users' ) ) {
			//	return new WP_Error( 'json_cannot_create', __( 'Sorry, you are not allowed to create users.' ), array( 'status' => 403 ) );
			//}
	
			$required = array( 'username', 'password', 'email' );
	
			foreach ( $required as $arg ) {
				if ( empty( $data[ $arg ] ) ) {
					if ( isset( $_GET['debug'] ) && $_GET['debug'] == 'true' ) {
						return new WP_Error( 'json_missing_callback_param', sprintf( __( 'Missing parameter %s' ), $arg ), array( 'status' => 400 ) );
					} else {
						return new WP_Error( 'json_missing_callback_param', sprintf( __( 'Missing parameter!' ), $arg ), array( 'status' => 400 ) );
					}
				}
			}
	
			$update = false;
		}
	
		// Basic authentication details
		if ( isset( $data['username'] ) ) {
			$user->user_login = $data['username'];
		}
	
		if ( isset( $data['password'] ) ) {
			$user->user_pass = $data['password'];
		}
	
		// Names
		if ( isset( $data['name'] ) ) {
			$user->display_name = $data['name'];
		}
	
		if ( isset( $data['first_name'] ) ) {
			$user->first_name = $data['first_name'];
		}
	
		if ( isset( $data['last_name'] ) ) {
			$user->last_name = $data['last_name'];
		}
	
		if ( isset( $data['nickname'] ) ) {
			$user->nickname = $data['nickname'];
		}
	
		if ( ! empty( $data['slug'] ) ) {
			$user->user_nicename = $data['slug'];
		}
	
		// URL
		if ( ! empty( $data['URL'] ) ) {
			$escaped = esc_url_raw( $user->user_url );
	
			if ( $escaped !== $user->user_url ) {
				return new WP_Error( 'json_invalid_url', __( 'Invalid user URL.' ), array( 'status' => 400 ) );
			}
	
			$user->user_url = $data['URL'];
		}
	
		// Description
		if ( ! empty( $data['description'] ) ) {
			$user->description = $data['description'];
		}
	
		// Email
		if ( ! empty( $data['email'] ) ) {
			$user->user_email = $data['email'];
		}
	
		// Pre-flight check
		$user = apply_filters( 'json_pre_insert_user', $user, $data );
	
		if ( is_wp_error( $user ) ) {
			return $user;
		}
	
		$user_id = $update ? wp_update_user( $user ) : wp_insert_user( $user );
	
		if ( is_wp_error( $user_id ) ) {
			return $user_id;
		}
	
		$user->ID = $user_id;
	
		do_action( 'json_insert_user', $user, $data, $update );
	
		return $user_id;
	}
	
	protected function prepare_user( $user, $context = 'view' ) {
		$user_fields = array(
			'ID'          => $user->ID,
			'username'    => $user->user_login,
			'name'        => $user->display_name,
			'first_name'  => $user->first_name,
			'last_name'   => $user->last_name,
			'nickname'    => $user->nickname,
			'slug'        => $user->user_nicename,
			'URL'         => $user->user_url,
			'avatar'      => json_get_avatar_url( $user->user_email ),
			'description' => $user->description,
		);
	
		$user_fields['registered'] = date( 'c', strtotime( $user->user_registered ) );
	
		if ( $context === 'view' || $context === 'edit' ) {
			$user_fields['roles']        = $user->roles;
			$user_fields['capabilities'] = $user->allcaps;
			$user_fields['email']        = false;
		}
	
		if ( $context === 'edit' ) {
			// The user's specific caps should only be needed if you're editing
			// the user, as allcaps should handle most uses
			$user_fields['email']              = $user->user_email;
			$user_fields['extra_capabilities'] = $user->caps;
		}
	
		$user_fields['meta'] = array(
			'links' => array(
				'self' => json_url( '/user/' . $user->ID ),
				'archives' => json_url( '/user/' . $user->ID . '/posts' ),
			),
		);
	
		return apply_filters( 'json_prepare_user', $user_fields, $user, $context );
	}
	
}