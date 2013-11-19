<?php
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php' );

function social_login_get_user_by_meta( $meta_key, $meta_value ) {
	global $wpdb;

	$sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
	return $wpdb->get_var( $wpdb->prepare( $sql, $meta_key, $meta_value ) );
}

function social_login_generate_signature( $data ) {
	return hash( 'SHA256', AUTH_KEY . $data );
}

function social_login_verify_signature( $data, $signature, $redirect_to ) {
	$generated_signature = social_login_generate_signature( $data );

	if( $generated_signature != $signature ) {
		wp_safe_redirect( $redirect_to );
		exit();
	}
}

function dln_curl_get_contents( $url ) {
	$curl = curl_init();
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $curl, CURLOPT_URL, $url );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

	$html = curl_exec( $curl );

	curl_close( $curl );

	return $html;
}

if ( ! function_exists( 'dln_get_field' ) ) {
	/**
	 * function to select in table
	 * 
	 * @param string $table
	 * @param string $key
	 * @param string $where
	 * @return NULL|Ambigous <mixed, NULL, multitype:>
	 */
	function dln_get_field( $table = '', $key = '', $where = '' ) {
		if ( ! $table || ! $key || ! $where )
			return null;
		global $wpdb;
		$table = $wpdb->prefix . $table;
		$result = $wpdb->get_row( "SELECT * FROM {$table} WHERE {$where}" );
		return $result;
	}
}

if ( ! function_exists( 'dln_update_field' ) ) {
	/**
	 * function to update data table
	 * 
	 * @param string $table
	 * @param string $set
	 * @param string $where
	 * @return NULL|Ambigous <mixed, NULL, multitype:>
	 */
	function dln_update_field( $table = '', $set = '', $where = '' ) {
		if ( ! $table || ! $set || ! $where )
			return null;
		global $wpdb;
		$table = $wpdb->prefix . $table;
		$result = $wpdb->get_row( "UPDATE {$table} SET {$set} WHERE {$where}" );
		return $result;
	}
}

if ( ! function_exists( 'dln_insert_field' ) ) {
	/**
	 * function to update data table
	 *
	 * @param string $table
	 * @param string $set
	 * @param string $where
	 * @return NULL|Ambigous <mixed, NULL, multitype:>
	 */
	function dln_insert_field( $table = '', $values = '' ) {
		if ( ! $table || ! $values )
			return null;
		global $wpdb;
		$table = $wpdb->prefix . $table;
		$result = $wpdb->get_row( "INSERT INTO {$table} {$values}" );
		return $result;
	}
}
