<?php

define( 'DLN_SCALE_VERSION', '1.0.0' );

function dln_theme_scripts() {
    if ( ! is_admin() ) {
        wp_enqueue_script( 'jquery' );
        
        wp_enqueue_script( 'dln-scale-app-js', get_template_directory_uri() . '/assets/js/app.v1.js', array( 'jquery' ), DLN_SCALE_VERSION, true );
        wp_enqueue_style( 'dln-scale-app-css', get_template_directory_uri() . '/assets/css/app.v1.css', null, DLN_SCALE_VERSION );
        wp_enqueue_style( 'dln-style-css', get_template_directory_uri() . '/assets/css/dln-style.css', null, DLN_SCALE_VERSION );
        
        //wp_localize_script( 'dln-frontend-app-js', 'DLN_Vars', array( 
        //    'root_url' => get_template_directory_uri() . '/assets/'
        //) );
    }
}
add_action( 'wp_enqueue_scripts', 'dln_theme_scripts' );
