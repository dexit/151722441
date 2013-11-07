<?php
// Exit if accessed directly

if ( ! function_exists( 'bp_get_version' ) )
{
	var_dump('Error load BP version!');die();
}

if ( ! function_exists( 'dln_social_enqueue_styles' ) )
{
	function dln_social_enqueue_styles()
	{		
		if ( ! is_admin() )
		{
			wp_enqueue_style( 'dln-bootstrap', 	get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-responsive', get_template_directory_uri() . '/assets/bootstrap/css/responsive.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-fonts-glyphicons', get_template_directory_uri() . '/assets/fonts/glyphicons/css/glyphicons.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-fonts-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.min.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-main', get_template_directory_uri() . '/assets/css/style-default.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-social', get_template_directory_uri() . '/assets/css/dln-social.css', array(), bp_get_version() );
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'dln_social_enqueue_styles' );
}

if ( ! function_exists( 'dln_social_enqueue_scripts' ) )
{
	function dln_social_enqueue_scripts() 
	{
		if ( ! is_admin() )
		{
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-migrate' );
			wp_enqueue_script( 'dln-code-beautify', get_template_directory_uri() . '/assets/js-beautify/beautify.js', array( 'jquery' ), bp_get_version(), true );
			wp_enqueue_script( 'dln-code-beautify-html', get_template_directory_uri() . '/assets/js-beautify/beautify-html.js', array( 'jquery' ), bp_get_version(), true );
			wp_enqueue_script( 'dln-bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js' );
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'dln_social_enqueue_scripts' );
}

if ( ! function_exists( 'dln_disable_adminbar' ) )
{
	function dln_disable_adminbar()
	{
		if ( ! is_admin() )
		{
			if ( ! isset( $_GET['show_adminbar'] ) OR 'yes' != $_GET['show_adminbar'] )
			{
				add_filter( 'show_admin_bar', '__return_false' );
				$custom_css = '.show-admin-bar { display: none; }';
				wp_add_inline_style( 'custom-css', $custom_css );
			}
		}
	}
	
	add_action( 'init', 'dln_disable_adminbar', 9 );
}