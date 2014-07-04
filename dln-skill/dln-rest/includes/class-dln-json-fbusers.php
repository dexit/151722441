<?php
 
class DLN_JSON_FBUsers {
	
	protected $servers;

	public function __construct( WP_JSON_ResponseHandler $server ) {
		header("Access-Control-Allow-Origin: *");
		$this->server = $server;
	}
	
	public function register_routes( $routes ) {
		$user_routes = array(
			'/fbusers' => array(
				array( array( $this, 'get_users' ), WP_JSON_Server::READABLE )
			),
			'/fbusers/(?P<id>\d+)' => array(
				array( array( $this, 'get_user' ), WP_JSON_Server::READABLE )
			)
		);
		
		return array_merge( $routes, $user_routes );
	}
	
	public function get_user( $id, $context = 'view' ) {
		$current_user_id = get_current_user_id();
		
		/*if ( $current_user_id !== $id && ! current_user_can( 'list_fbusers' ) ) {
			return new WP_Error( 'json_fbuser_cannot_list', __( 'Sorry, you are not allowed to view this user.' ), array( 'status' => 403 ) );
		}*/
		
		if ( ! $id ) return;
		
		$user = self::get_user_by_meta_data( 'dln_uuid', $id );
		
		if ( empty( $user->ID ) ) {
			return new WP_Error( 'json_fbuser_invalid_id', __( 'Invalid user ID' ), array( 'status' => 400 ) );
		}
		
		return $this->prepare_user( $user, $context );
	}
	
	protected function prepare_user( $user, $context = 'view' ) {
		$user_fields = array(
			'ID'     => $user->ID,
			'name'   => $user->display_name,
			'fb_uid' => $user->fb_uid,
			'email'  => $user->user_email
		);
		
		return apply_filters( 'json_prepare_fbuser', $user_fields, $user, $context );
	}
	
	protected function get_user_by_meta_data( $meta_key, $meta_value ) {
		// Query for users based on the meta data
		$user_query = new WP_User_Query(
			array(
				'meta_key'   => $meta_key,
				'meta_value' => $meta_value	
			)
		);
		
		// Get the results from the query, returning the first user
		$users = $user_query->get_results();
		
		return isset( $users[0] ) ? $users[0] : 0;
	}
	
}