<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Blocks {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'init', array( $this, 'load_posted_form' ) );
		add_shortcode( 'dln_submit_photo', array( $this, 'shortcode_dln_submit_photo' ) );
	}
	
	public function load_posted_form() {
		if ( ! empty( $_GET['dln_form'] ) ) {
			echo self::get_block( sanitize_title( $_GET['dln_form'] ) );
			die();
		}
	}
	
	public function shortcode_dln_submit_photo() {
		return self::get_block( 'submit-photo' );
	}
	
	public static function get_block( $form_name ) {
		if ( $form = self::load_block_class( $form_name ) ) {
			ob_start();
			call_user_func( array( $form, 'render_html' ) );
			return ob_get_clean();
		}
	}
	
	public static function load_block_class( $form_name ) {
		// Load the form abtract
		if ( ! class_exists( 'DLN_Form' ) )
			include( 'abstracts/block.php' );
		
		// Now try to load the form_name
		$block_class = 'DLN_Block_' . str_replace( '-', '_', $form_name );
		$block_file  = DLN_ABE_PLUGIN_DIR . '/dln-block/includes/blocks/block-' . $form_name . '.php';
		
		if ( class_exists( $block_class ) )
			return $block_class;
		
		if ( ! file_exists( $block_file ) )
			return false;
		
		if ( ! class_exists( $block_class ) )
			include $block_file;
		
		// Init the form
		call_user_func( array( $block_class, 'init' ) );
		
		return $block_class;
	}
	
	public static function block_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) )
			extract( $args );
	
		include( self::block_locate_template( $template_name, $template_path, $default_path ) );
	}
	
	public static function block_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path )
			$template_path = 'dln_fashion';
		if ( ! $default_path )
			$default_path = DLN_ABE_PLUGIN_DIR . '/dln-block/includes/views/';
	
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);
	
		// Get default template
		if ( ! $template )
			$template = $default_path . $template_name;
	
		// Return what we found
		return apply_filters( 'dln_block_locate_template', $template, $template_name, $template_path );
	}
	
	public static function block_load_frontend_assets() {
		wp_enqueue_script( 'dln-bootstrap-js' );
		wp_enqueue_script( 'dln-selectize-js' );
		//wp_enqueue_script( 'dln-dropzone-js' );
		//wp_enqueue_script( 'dln-parsley-js' );
		//wp_enqueue_script( 'dln-steps-js' );
		//wp_enqueue_script( 'dln-form-submit-fashion-js' );
	
		wp_enqueue_style( 'dln-bootstrap-css' );
		wp_enqueue_style( 'dln-ui-element-css' );
		wp_enqueue_style( 'dln-ui-layout-css' );
		wp_enqueue_style( 'dln-selectize-css' );
		//wp_enqueue_style( 'dln-dropzone-css' );
		//wp_enqueue_style( 'dln-ico-font-css' );
		//wp_enqueue_style( 'dln-form-site-css' );
		//wp_enqueue_style( 'dln-steps-css' );
		
		//wp_enqueue_style( 'dln-summernote-css' );
		//wp_enqueue_style( 'dln-font-awesome-css' );
		//wp_enqueue_script( 'dln-summernote-js' );
		//wp_enqueue_script( 'dln-form-wysiwyg-js' );
	
	}
	
	public static function block_user_can_post_profile() {
		$can_post = true;
	
		if ( ! is_user_logged_in() ) {
			//if ( dln_form_user_requires_account() && ! dln_form_enable_registration() ) {
			$can_post = false;
			//}
		}
	
		return apply_filters( 'dln_block_user_can_post_profile', $can_post );
	}
	
}
