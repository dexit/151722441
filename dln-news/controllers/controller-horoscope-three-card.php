<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Controller_HoroScope_Three_Card {
	
	public static $fields;
	public static $action;
	
	public static function init() { }
	
	public static function render() {
		self::load_frontend_assets();
	
		DLN_Helper_Template::get_template(
			'view-horoscope-three-card.php'
		);
	}
	
	private static function load_frontend_assets() {
		wp_enqueue_script( 'dln-jquery-modernizr-js', DLN_NEW_PLUGIN_URL . '/assets/3rd-party/jquery-baraja/modernizr.custom.js', array( 'jquery' ), DLN_NEW_VERSION, true );
		wp_enqueue_script( 'dln-jquery-baraja-js', DLN_NEW_PLUGIN_URL . '/assets/3rd-party/jquery-baraja/jquery.baraja.js', array( 'jquery' ), DLN_NEW_VERSION, true );
		wp_enqueue_script( 'dln-horo-three-card-js', DLN_NEW_PLUGIN_URL . '/assets/js/dln-horo-three-card.js', array( 'jquery' ), DLN_NEW_VERSION, true );
		
		wp_enqueue_style( 'dln-jquery-baraja-css', DLN_NEW_PLUGIN_URL . '/assets/3rd-party/jquery-baraja/baraja.css', null, DLN_NEW_VERSION );
		wp_enqueue_style( 'dln-horo-three-card-css', DLN_NEW_PLUGIN_URL . '/assets/css/horoscope-three-card.css', null, DLN_NEW_VERSION );
		
		wp_localize_script(
			'dln-horo-three-card-js',
			'dln_horo_params',
			array(
				'site_url'     => site_url(),
				'dln_ajax_url' => admin_url( 'admin-ajax.php' ),
				'language'     => array(
					'card_loading'     => __( 'Card loading', DLN_NEW ),
				),
				'dln_nonce'                => wp_create_nonce( DLN_NEW_NONCE )
			)
		);
	}
	
}