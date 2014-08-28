<?php

if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'DLN_Member_Post_Type' ) ) :

class DLN_Member_Post_Type {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		// Custom columns
		add_filter( 'manage_users_columns',       array( $this, 'custom_user_column' )                );
		add_action( 'manage_users_custom_column', array( $this, 'custom_user_column_content' ), 10, 3 );
		
		// Sortable columns
		add_filter( 'manage_users_sortable_columns', array( $this, 'sortable_member_money_column' ) );
		add_action( 'pre_user_query',                array( $this, 'sort_by_member_money' ));
	}
	
	public function custom_user_column( $columns ) {
		if ( ! isset( $columns['dln_member_money'] ) ) {
			$columns['dln_member_money'] = __( 'Money', DLN_ABE );
		}
		return $columns;
	}
	
	public function custom_user_column_content( $value, $column_name, $user_id ) {
		if ( $column_name != 'dln_member_money' )
			return $value;
		
		$money = get_user_meta( $user_id, '_dln_member_money', true );
		$money = ( ! empty( $money ) ) ? (int) $money : 0;
		
		return $money;
	}
	
	public function sortable_member_money_column( $columns ) {
		$columns['dln_member_money'] = 'dln_member_money';
		
		return $columns;
	}
	
	public function sort_by_member_money( $query ) {
		if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ! function_exists( 'get_current_screen' ) ) return;
		$screen = get_current_screen();
		if ( $screen === NULL || $screen->id != 'users' ) return;
		
		if ( isset( $query->query_vars['orderby'] ) && $query->query_vars['orderby'] == 'dln_member_money' ) {
			global $wpdb;
			
			$order = 'ASC';
			if ( isset( $query->query_vars['order'] ) )
				$order = $query->query_vars['order'];
			
			$query->query_from .= "
			LEFT JOIN {$wpdb->usermeta}
			ON ({$wpdb->users}.ID = {$wpdb->usermeta}.user_id AND {$wpdb->usermeta}.meta_key = '_dln_member_money')";
			
			$query->query_orderby = "ORDER BY {$wpdb->usermeta}.meta_value+0 {$order} ";
		}
	}

}

DLN_Member_Post_Type::get_instance();

endif;