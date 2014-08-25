<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Report_Post_Type' ) ) :

class DLN_Report_Post_Type {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_filter( 'manage_edit-dln_report_columns',        array( $this, 'custom_edit_dln_report_columns' ) );
		add_action( 'manage_dln_report_posts_custom_column', array( $this, 'custom_dln_report_column' ), 10, 2 );
		
		add_filter( 'manage_edit-post_columns',          array( $this, 'custom_edit_post_columns' ) );
		add_action( 'manage_post_posts_custom_column',   array( $this, 'custom_post_column' ), 10, 2 );
		add_filter( 'manage_edit-post_sortable_columns', array( $this, 'custom_post_sortable_column' ) );
		
		add_action( 'pre_get_post', array( $this, 'pre_get_post_order_by' ) );
	}
		
	public static function custom_edit_post_columns( $columns ) {
		$columns['report_count'] = __( 'Report', DLN_ABE );
		
		return $columns;
	}
	
	public static function custom_post_column( $column, $post_id ) {
		switch ( $column ) {
			case 'report_count':
				if ( $post_id ) {
					$count = (int) get_post_meta( $post_id, 'dln_report_count', true );
						
					if ( ! is_wp_error( $count ) ) {
						echo $count;
					} else {
						echo '0';
					}
				} else {
					echo '0';
				}
				break;
		}
	}
	
	public static function custom_post_sortable_column( $columns ) {
		$columns['report_count'] = 'report_count';
		
		return $columns;
	}
	
	public static function pre_get_post_order_by( $query ) {
		if ( ! is_admin() )
			return;
		
		$orderby = $query->get( 'orderby' );
		
		switch ( $orderby ) {
			case 'report_count':
				$query->set( 'meta_key', 'dln_report_count' );
				$query->set( 'orderby', 'meta_value_num' );
			break;
		}
	}
	
	public static function custom_edit_dln_report_columns( $columns ) {
		$columns['report_category'] = __( 'Category', DLN_ABE );
		$columns['report_post']     = __( 'Post', DLN_ABE );
		$columns['report_ip']       = __( 'IP', DLN_ABE );
		
		return $columns;
	}
	
	public static function custom_dln_report_column( $column, $report_id ) {
		switch ( $column ) {
			case 'report_category':
				if ( $report_id ) {
					$cat_id = get_post_meta( $report_id, 'dln_report_post_id', true );
					$cat    = get_category( $cat_id );
					
					if ( ! is_wp_error( $cat ) ) {
						$link = get_category_link( $cat_id );
						echo '<a href="' . $link . '" target="_blank">' . $cat->name . '</a>';
					} else {
						echo '';
					}
				} else {
					echo '';
				}
			break;
			
			case 'report_post':
				if ( $report_id ) {
					$post_id = get_post_meta( $report_id, 'dln_report_post_id', true );
					
					if ( ! is_wp_error( $post_id ) ) {
						$link = get_permalink( $post_id );
						echo '<a href="' . $link . '" target="_blank">' . $post_id . '</a>';
					} else {
						echo '';
					}
				} else {
					echo '';
				}
			break;
			
			case 'report_ip':
				if ( $report_id ) {
					$ip = get_post_meta( $report_id, 'dln_report_user_ip', true );
					
					if ( ! is_wp_error( $ip ) ) {
						$link = get_permalink( $report_id );
						echo $ip;
					} else {
						echo '';
					}
				} else{
					echo '';
				}
			break;
		}
	}
	
}

DLN_Report_Post_Type::get_instance();

endif;