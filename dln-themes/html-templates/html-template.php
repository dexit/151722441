<?php
if ( ! class_exists( 'DLN_Html_Template' ) )
{
	class DLN_Html_Template
	{
		private static $instance;
		private $theme_dir;
		
		private function __construct() { /* Do nothing here */ }
		
		public static function instance()
		{
			if ( ! isset( self::$instance ) )
			{
				self::$instance = new DLN_Html_Template;
				self::$instance->constants();
				self::$instance->includes();
			}
			return self::$instance;
		}
		
		private function constants()
		{
			// Path and URL
			if ( ! defined( 'DLN_THEME_DIR' ) )
			{
				define( 'DLN_THEME_DIR', trailingslashit( WP_CONTENT_DIR . '/themes/dln-theme' ) );
			}
			
			$this->theme_dir = DLN_THEME_DIR;
		}
		
		private function includes()
		{
			require( $this->theme_dir . '/html-templates/sidebar/dln-slidebar-helper.php' );
			require( $this->theme_dir . '/html-templates/sidebar/dln-slidebar-html.php' );
		} 
	} 
}