<?php

function dln_theme_skill_scripts() {
    if ( ! is_admin() ) {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'dln-frontend-modernizr-js', get_template_directory_uri() . '/assets/library/modernizr/js/modernizr.min.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'dln-frontend-ui-touch-js', get_template_directory_uri() . '/assets/library/jquery/js/jquery-ui-touch.min.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'dln-frontend-migrate-js', get_template_directory_uri() . '/assets/library/jquery/js/jquery-migrate.min.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'dln-frontend-bootstrap-js', get_template_directory_uri() . '/assets/library/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'dln-frontend-core-js', get_template_directory_uri() . '/assets/library/core/js/core.min.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'dln-frontend-magnific-js', get_template_directory_uri() . '/assets/plugins/magnific/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'dln-frontend-app-js', get_template_directory_uri() . '/assets/javascript/app.min.js', array( 'jquery' ), '1.0.0', true );
        wp_localize_script( 'dln-frontend-app-js', 'DLN_Vars', array( 
            'root_url' => get_template_directory_uri() . '/assets/'
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'dln_theme_skill_scripts' );

function dln_get_notifications() {
	if ( ! is_user_logged_in() ) {
		return false;
	}
	
	$notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
	
	if ( ! $notifications )
		return null;
	
	// Assign notification type
	foreach ( $notifications as $i => $nof ) {
		if ( isset( $nof->id ) ) {
			$componen_actions = bp_notifications_get_notification( $nof->id );
			switch( $componen_actions->component_name ) {
				case 'messages':
					$notifications[$i]->icon = 'ico-mail-send bgcolor-info';
					break;
				case 'friends':
					$notifications[$i]->icon = 'ico-user-plus bgcolor-success';
					break;
				default:
					$notifications[$i]->icon = 'ico-notification';
					break;
			}
		}
	}
	
	return $notifications;
}

function dln_get_avatar_link() {
	if ( ! bp_loggedin_user_id() )
		return '';
	$user_id = bp_loggedin_user_id();
	$link = bp_core_fetch_avatar( array(
			'item_id' => $user_id,
			'width'  => 40,
			'height' => 40,
			'class'  => 'img-circle',
			'alt'    => bp_core_get_user_displayname( $user_id )
		)
	);
	
	return $link;
}

function dln_template_blank_page() {
	if ( is_page_template( 'page-templates/blank-page.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'dln_template_blank_page' );