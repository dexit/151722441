<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Photo_Post_Type' ) ) :

class DLN_Photo_Post_Type {

	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_filter( 'manage_edit-dln_photo_columns',        array( $this, 'custom_edit_dln_photo_columns' ) );
		add_action( 'manage_dln_photo_posts_custom_column', array( $this, 'custom_dln_photo_column' ), 10, 2 );
	}
	
	public static function custom_edit_dln_photo_columns( $columns ) {
		$arr_columns = array();
		foreach ( $columns as $key => $value ) {
			if ( $key == 'cb' ) {
				$arr_columns[$key] = $value;
				$arr_columns['photo_thumbnail'] = __( 'Thumbnail', DLN_ABE );
			} else {
				$arr_columns[$key] = $value;
			}
		}
		return $arr_columns;
	}
	
	public static function custom_dln_photo_column( $column, $post_id ) {
		switch ( $column ) {
			case 'photo_thumbnail':
				if ( $post_id ) {
					$url = get_post_meta( $post_id, 'dln_pic_url', true );
	
					if ( ! is_wp_error( $url ) ) {
						echo '<img class="dln-thumbnail" src="' . $url . '" />';
					} else {
						echo '0';
					}
				} else {
					echo '0';
				}
				break;
		}
	}
	
}

DLN_Photo_Post_Type::get_instance();

endif;