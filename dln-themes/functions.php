<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'dln_require_files' ) )
{
	function dln_require_files()
	{
		
	}
}

if ( ! function_exists( 'dln_enqueue_styles' ) ) 
{
	function dln_enqueue_styles() 
	{
		if ( ! is_admin() ) 
		{
			wp_enqueue_style( 'dln-colorpicker', 		get_template_directory_uri() . '/assets/plugins/colorpicker/colorpicker.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-bootstrap', 			get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-font-style', 		get_template_directory_uri() . '/assets/css/fonts/ptsans/stylesheet.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-font-icons', 		get_template_directory_uri() . '/assets/css/fonts/icomoon/style.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-main-style', 		get_template_directory_uri() . '/assets/css/dln-style.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-icon-16', 			get_template_directory_uri() . '/assets/css/icons/icol16.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-icon-32', 			get_template_directory_uri() . '/assets/css/icons/icol32.css', array(), bp_get_version() );
			//wp_enqueue_style( 'dln-demo', 				get_template_directory_uri() . '/assets/css/demo.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-jquery-ui-all', 		get_template_directory_uri() . '/assets/jui/css/jquery.ui.all.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-jquery-ui-custom', 	get_template_directory_uri() . '/assets/jui/jquery-ui.custom.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-jquery-ui-custom', 	get_template_directory_uri() . '/assets/jui/jquery-ui.custom.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-main-theme', 		get_template_directory_uri() . '/assets/css/dln-theme.css', array(), bp_get_version() );
			//wp_enqueue_style( 'dln-themer', 			get_template_directory_uri() . '/assets/css/themer.css', array(), bp_get_version() );
			wp_enqueue_style( 'dln-styles', 			get_template_directory_uri() . '/assets/css/dln-styles.css', array(), bp_get_version() );
			
			wp_enqueue_script( 'dln-jquery',	  		get_template_directory_uri() . '/assets/js/libs/jquery-1.8.3.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-jquery-mousewheel',	get_template_directory_uri() . '/assets/js/libs/jquery.mousewheel.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-jquery-placeholder',get_template_directory_uri() . '/assets/js/libs/jquery.placeholder.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-custom-plugin',		get_template_directory_uri() . '/assets/custom-plugins/fileinput.js', array(), bp_get_version(), true );
			wp_enqueue_script( 'dln-jquery-ui',			get_template_directory_uri() . '/assets/jui/js/jquery-ui-1.9.2.min.js', array(), bp_get_version(), true );
			wp_enqueue_script( 'dln-jquery-custom',		get_template_directory_uri() . '/assets/jui/jquery-ui.custom.min.js', array(), bp_get_version(), true );
			wp_enqueue_script( 'dln-jquery-touch',		get_template_directory_uri() . '/assets/jui/js/jquery.ui.touch-punch.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin-table',		get_template_directory_uri() . '/assets/plugins/datatables/jquery.dataTables.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin',			get_template_directory_uri() . '/assets/plugins/flot/jquery.flot.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin-tooltip',	get_template_directory_uri() . '/assets/plugins/flot/plugins/jquery.flot.tooltip.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin-pie',		get_template_directory_uri() . '/assets/plugins/flot/plugins/jquery.flot.pie.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin-stack',		get_template_directory_uri() . '/assets/plugins/flot/plugins/jquery.flot.stack.min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin-resize',		get_template_directory_uri() . '/assets/plugins/flot/plugins/jquery.flot.resize.min.js', array(), bp_get_version(), true );
			wp_enqueue_script( 'dln-plugin-colorpicker',get_template_directory_uri() . '/assets/plugins/colorpicker/colorpicker-min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin-validate',	get_template_directory_uri() . '/assets/plugins/validate/jquery.validate-min.js', array(), bp_get_version(), true );
			//wp_enqueue_script( 'dln-plugin-winzard',	get_template_directory_uri() . '/assets/custom-plugins/wizard/wizard.min.js', array(), bp_get_version(), true );
			wp_enqueue_script( 'dln-bootstrap',			get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array(), bp_get_version(), true );
			wp_enqueue_script( 'dln-core',				get_template_directory_uri() . '/assets/js/core/mws.js', array(), bp_get_version(), true );
			wp_enqueue_script( 'dln-core-themer',		get_template_directory_uri() . '/assets/js/core/themer.js', array(), bp_get_version(), true );
			$data = array( 'site_url' => __( get_template_directory_uri() . '/assets/' ) );
			wp_localize_script( 'dln-core-themer', 'dln_var', $data );
		}
		
	}
	
	add_action( 'wp_enqueue_scripts', 'dln_enqueue_styles' );
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
				?>
				  <style type="text/css">
				    .show-admin-bar {
				      display: none;
				    }
				  </style>
				<?php
			}
		}
	}
	
	add_action( 'init', 'dln_disable_adminbar', 9 );
}