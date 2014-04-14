<?php

if ( ! defined( 'WPINC' ) ) { die; }

abstract class DLN_Source {
	
	public static $xpath = '';
	
	public static function load_rss_source( $rss_url = '' ) {
		if ( ! $rss_url )
			return;
		
		if ( ! self::check_url( $rss_url ) )
			return;
		
		$source      = file_get_contents( $rss_url );
		$doc         = new DOMDocument();
		$content     = @$doc->loadHTML( $result );
		self::$xpath = new DOMXPath( $doc );
	}
	
	public static function get_nodes( $rss_url = '', $xpath_query = '' ) {
		if ( ! $xpath_query )
			return;
		
		if ( ! self::$xpath )
			return;
		
		$xnodes = self::$xpath->query( $xpath_query );
		
		return $xnodes;
	}
	
	private static function check_url( $html ){
		return $result = preg_replace(
			'%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s',
			'<a href="$1">$1</a>',
			$html
		);
	}
	
}
