<?php

function dln_add_stylesheets(){
	if( !wp_style_is( 'social_login', 'registered' ) ) {
		wp_register_style( 'social_login', SOCIAL_LOGIN_PLUGIN_URL . '/assets/css/style.css' );
		wp_register_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/smoothness/jquery-ui.css' );
	}

	if ( did_action( 'wp_print_styles' ) ) {
		wp_print_styles( 'social_login' );
		wp_print_styles( 'jquery-ui' );
	} else {
		wp_enqueue_style( 'social_login' );
		wp_enqueue_style( 'jquery-ui' );
	}
}
add_action( 'login_head', 'dln_add_stylesheets' );
add_action( 'wp_head', 'dln_add_stylesheets' );


function dln_add_admin_stylesheets(){
	if( !wp_style_is( 'social_login', 'registered' ) ) {
		wp_register_style( 'social_login', SOCIAL_LOGIN_PLUGIN_URL . '/assets/css/style.css' );
	}

	if ( did_action( 'wp_print_styles' )) {
		wp_print_styles( 'social_login' );
	} else {
		wp_enqueue_style( 'social_login' );
	}
}
add_action( 'admin_print_styles', 'dln_add_admin_stylesheets' );

function dln_add_javascripts(){
	if( ! wp_script_is( 'social_login', 'registered' ) ) {
		wp_register_script( 'social_login', SOCIAL_LOGIN_PLUGIN_URL . '/assets/js/login.js' );
	}
	wp_print_scripts( 'jquery' );
	wp_print_scripts( 'jquery-ui-core' );
	wp_print_scripts( 'jquery-ui-dialog' );
	wp_print_scripts( 'social_login' );
	wp_print_scripts( 'social_login_ajax' );
}
add_action( 'login_head', 'dln_add_javascripts' );
add_action( 'wp_head', 'dln_add_javascripts' );

function dln_localize_js() {
	return array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'_nonce' => wp_create_nonce( 'dln_nonce_check' )
	);
}

function dln_add_js_page() {
	if ( is_page( 'moi-ban-be' ) || is_page( 'invite-friends' ) ) {
		if( ! wp_script_is( 'social-login-ajax', 'registered' ) ) {
			wp_register_script( 'social-login-ajax', SOCIAL_LOGIN_PLUGIN_URL . '/assets/js/ajax.js' );
		}
		wp_localize_script('social-login-ajax', 'DLN_Ajax', dln_localize_js());
		wp_print_scripts( 'jquery' );
		wp_print_scripts( 'jquery-ui-core' );
		wp_print_scripts( 'jquery-ui-dialog' );		
		wp_print_scripts( 'social-login-ajax' );
	}
	
}
add_action( 'wp_head', 'dln_add_js_page' );