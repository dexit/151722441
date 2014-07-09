<?php

include_once 'aes_fast.php';
include_once 'cryptoHelpers.php';

class DLN_Helper_Decrypt {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}

	public static function encrypt( $plaintext, $key ){
	
		// Set up encryption parameters.
		$plaintext_utf8 = utf8_encode( $plaintext );
		$inputData      = cryptoHelpers::convertStringToByteArray( $plaintext );
		$keyAsNumbers   = cryptoHelpers::toNumbers( bin2hex($key ) );
		$keyLength      = count( $keyAsNumbers );
		$iv             = cryptoHelpers::generateSharedKey( 16 );
	
		$encrypted = AES::encrypt(
			$inputData,
			AES::modeOfOperation_CBC,
			$keyAsNumbers,
			$keyLength,
			$iv
		);
	
		// Set up output format (space delimeted "plaintextsize iv cipher")
		$retVal = $encrypted['originalsize'] . " "
			. cryptoHelpers::toHex( $iv ) . " "
				. cryptoHelpers::toHex( $encrypted['cipher'] );
	
		return $retVal;
	}
	
	public static function get_decrypt() {
		if ( empty( $_POST['code'] ) ) return false;
		$code       = trim( $_POST['code'] );
		$code       = str_replace( '-', ' ', $code );
		$code       = self::decrypt( $code, '1451989' );
		$arr_inputs = explode( '|', $code );
		$date       = isset( $arr_inputs[1] ) ? $arr_inputs[1] : '';
		$date       = (int) ( $date / 1000 );
		if ( ! empty( $arr_inputs[0] ) && $arr_inputs[0] == 'welovehochiminhpresident' ) {
			$ip = self::get_current_ip();
			if ( self::get_phrase_request( $code, $ip ) ) {
				return false;
			} else {
				self::save_request_db( $date, $code, $ip );
				return true;
			}
			
		} else {
			return false;
		}
	}
	
	private static function get_phrase_request( $code, $ip ) {
		if ( ! $code ) return false;
		
		global $wpdb;
		$sql    = $wpdb->prepare( "SELECT code FROM {$wpdb->dln_phrase_request} WHERE code = %s AND ip = %s", $code, $ip );
		$result = $wpdb->get_results( $sql, ARRAY_A );
		
		return $result;
	}
	
	private static function save_request_db( $date, $code, $ip ) {
		global $wpdb;
		$data = array(
			'ip'   => $ip,
			'date' => date( 'Y-m-d H:i:s', $date ),
			'code' => $code
		);
		$wpdb->insert( $wpdb->dln_phrase_request, $data );
	}
	
	public static function get_current_ip() {
		if (isset($_SERVER)) {
		
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				return $_SERVER["HTTP_X_FORWARDED_FOR"];
		
			if (isset($_SERVER["HTTP_CLIENT_IP"]))
				return $_SERVER["HTTP_CLIENT_IP"];
		
			return $_SERVER["REMOTE_ADDR"];
		}
		
		if (getenv('HTTP_X_FORWARDED_FOR'))
			return getenv('HTTP_X_FORWARDED_FOR');
		
		if (getenv('HTTP_CLIENT_IP'))
			return getenv('HTTP_CLIENT_IP');
		
		return getenv('REMOTE_ADDR');
	}
	
	public static function decrypt( $input, $key ){
	
		// Split the input into its parts
		$cipherSplit = explode( " ", $input);
		$originalSize = intval( $cipherSplit[0] );
		$iv = cryptoHelpers::toNumbers( $cipherSplit[1] );
		$cipherText = $cipherSplit[2];
	
		// Set up encryption parameters
		$cipherIn = cryptoHelpers::toNumbers( $cipherText );
		$keyAsNumbers = cryptoHelpers::toNumbers( bin2hex( $key ) );
		$keyLength = count( $keyAsNumbers );
	
		$decrypted = AES::decrypt(
			$cipherIn,
			$originalSize,
			AES::modeOfOperation_CBC,
			$keyAsNumbers,
			$keyLength,
			$iv
		);
	
		// Byte-array to text.
		$hexDecrypted = cryptoHelpers::toHex( $decrypted );
		$retVal = pack( "H*" , $hexDecrypted );
	
		return $retVal;
	}
	
}

//var_dump( DLN_Helper_Decrypt::decrypt( '24 be563e26467accc1253a93c76da1c43f64431781c5af92bfce3b33ea08110f95 70f8cbb438a5859eae19737f7ddb8ae0f275688b743d88ec199aabf3f8cd6178', '1451989' ) );die();