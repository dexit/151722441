<?php

class DLN_JSON_Money {
	
	protected $servers;
	
	public function __construct( WP_JSON_ResponseHandler $server ) {
		header("Access-Control-Allow-Origin: *");
		$this->server = $server;
	}
	
	public function register_routes( $routes ) {
		$money_routes = array(
			'/money' => array (
				array( array( $this, 'get_money' ), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
			)
		);
		
		return array_merge( $routes, $money_routes );
	}
	
	function get_money() {
		$data = null;
		if ( isset( $_POST['data'] ) ) {
			$data = json_decode( stripslashes( $_POST['data'] ), ARRAY_N );
		}
		if ( empty( $data ) ) {
			return new WP_Error( 'json_money_invalid_data', __( 'Invalid data parameters.' ), array( 'status' => 404 ) );
		}
		
		$user_id = null;
		if ( ! empty( $data['user_id'] ) ) {
			$user_id = (int) $data['user_id'];
		} else {
			return new WP_Error( 'json_money_invalid_id', __( 'Invalid user ID parameters.' ), array( 'status' => 404 ) );
		}
		
		$cred = get_user_meta( $user_id, 'mycred_default' );
		return $cred;
	}
	
}
