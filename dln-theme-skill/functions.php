<?php

function dln_theme_skill_scripts() {
    if ( is_front_page() ) {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
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