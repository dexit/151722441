<?php

if ( ! defined( 'WPINC' ) ) { die; }

abstract class DLN_Source {

	public static $xpath = '';
	public static $file = 'crawl.log';
	
	public static function write_log( $log = '' ) {
		if ( ! $log )
			return;
		$path = DLN_SKILL_PLUGIN_DIR . "/dln-cron/logs/" . self::$file;
		file_put_contents( $path, $log, FILE_APPEND );
	}
	
	public static function get_nodes( $rss_url = '' ) {
		if ( ! $rss_url )
			return;
		
		if ( ! self::check_url( $rss_url ) )
			return;
		
		if (!($x = simplexml_load_file( $rss_url )))
            return;

		return $x;
	}
	
	private static function check_url( $html ){
		return $result = preg_replace(
			'%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s',
			'<a href="$1">$1</a>',
			$html
		);
	}
	
}
