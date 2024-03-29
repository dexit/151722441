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
		add_shortcode( 'dln_photo_submit', array( $this, 'shortcode_dln_photo_submit' ) );
		add_shortcode( 'dln_photo_listing', array( $this, 'shortcode_dln_photo_listing' ) );
		add_shortcode( 'dln_profile_edit', array( $this, 'shortcode_dln_profile_edit' ) );
	}
	
	public function load_posted_form() {
		if ( ! empty( $_GET['dln_form'] ) ) {
			echo self::get_block( sanitize_title( $_GET['dln_form'] ) );
			die();
		}
	}
	
	public function shortcode_dln_photo_submit() {
		return self::get_block( 'photo-submit' );
	}
	
	public function shortcode_dln_photo_listing() {
		return self::get_block( 'photo-listing' );
	}
	
	public function shortcode_dln_profile_edit() {
		return self::get_block( 'profile-edit' );
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
		if ( ! class_exists( 'DLN_Block' ) )
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
		
		wp_enqueue_style( 'dln-block-photo-css' );
		wp_enqueue_script( 'dln-jquery-unveil-js' );
		wp_enqueue_script( 'dln-helper-product-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/helpers/product-helper.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'dln-helper-social-js', DLN_ABE_PLUGIN_URL . '/assets/dln-abe/js/helpers/social-helper.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script(
			'dln-helper-social-js',
			'dln_abe_params',
			array(
				'site_url'     => site_url(),
				'fb_app_id'    => FB_APP_ID,
				'fb_url'       => FB_REDIRECT_URI,
				'insta_app_id' => INSTA_APP_ID,
				'insta_url'    => INSTA_REDIRECT_URI,
				'dln_ajax_url' => admin_url( 'admin-ajax.php' ),
				'indicator'    => '<div class="indicator show"><span class="spinner spinner3"></span></div>',
				'language'     => array(
					'error_empty_message'     => __( 'Please enter your message!', DLN_ABE ),
					'label_fb_setting'    => __( 'Setup facebook account', DLN_ABE ),
					'label_insta_setting' => __( 'Setup instagram account', DLN_ABE ),
				),
				'dln_nonce'                => wp_create_nonce( DLN_ABE_NONCE ),
				'dln_nonce_save_product'   => wp_create_nonce( DLN_ABE_NONCE . '_save_product' ),
				'dln_nonce_download_image' => wp_create_nonce( DLN_ABE_NONCE . '_download_image_from_url' )
			)
		);
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
