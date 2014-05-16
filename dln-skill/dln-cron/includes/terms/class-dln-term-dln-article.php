<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Term_Article {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		add_action( 'manage_dln_article_posts_custom_column', array( $this, 'column_prepare_folder_display' ), 10, 2 );
		add_filter( 'manage_edit-dln_article_columns', array( $this, 'column_header_dln_source' ), 10, 1 );
		add_filter( 'manage_edit-dln_article_sortable_columns', array( $this, 'sortable_column_dln_article' ), 10, 1 );
		add_filter( 'pre_get_posts', array( $this, 'sortable_column_dln_article_clause' ), 10, 1 );
		add_filter( 'posts_clauses', array( $this, 'sortable_column_dln_article_clauses' ), 10, 2 );
	}
	
	public function column_prepare_folder_display( $custom_column, $post_id ) {
		if ( $custom_column != 'dln_publish_date_column' && $custom_column != 'dln_share_count_column'
			&& $custom_column != 'dln_like_count_column' && $custom_column != 'dln_comment_count_column'
			&& $custom_column != 'dln_total_count_column' && $custom_column != 'dln_comments_fbid_column' ) return '';
		
		if ( ! $post_id ) return '';
		
		switch ( $custom_column ) {
			case 'dln_publish_date_column':
				$html = get_post_meta( $post_id , 'dln_publish_date' , true ); 
				break;
			case 'dln_share_count_column':
				$html = get_post_meta( $post_id , 'dln_share_count' , true ); 
				break;
			case 'dln_like_count_column':
				$html = get_post_meta( $post_id , 'dln_like_count' , true );
				break;
			//case 'dln_comment_count_column':
			//	$html = get_post_meta( $post_id , 'dln_comment_count' , true );
			//	break;
			case 'dln_total_count_column':
				$html = get_post_meta( $post_id , 'dln_total_count' , true );
				break;
			case 'dln_comments_fbid_column':
				$html = get_post_meta( $post_id , 'dln_comments_fbid' , true );
				break;
		}
		echo esc_html( $html );
	}
	
	public function column_header_dln_source( $columns ) {
		$columns['dln_publish_date_column']  = __('Publish Date', DLN_SKILL );
		$columns['dln_share_count_column']   = __('FB Share', DLN_SKILL );
		$columns['dln_like_count_column']    = __('FB Like', DLN_SKILL );
		//$columns['dln_comment_count_column'] = __('FB Comment', DLN_SKILL );
		$columns['dln_total_count_column']   = __('FB Total', DLN_SKILL );
		
		unset( $columns['author'] );
		if ( isset( $_GET['show_category'] ) && $_GET['show_category'] == '1' ) {
			return $columns;			
		} else {
			unset( $columns['categories'] );			
		}
		
		if ( isset( $_GET['show_fbid'] ) && $_GET['show_fbid'] == 1 ) {
			$columns['dln_comments_fbid_column']   = __('FB ID', DLN_SKILL );
		} 
		
		return $columns;
	}
	
	public function sortable_column_dln_article( $sortable_columns ) {
		$sortable_columns[ 'dln_publish_date_column' ]  = 'dln_publish_date';
		$sortable_columns[ 'dln_share_count_column' ]   = 'dln_share_count';
		$sortable_columns[ 'dln_like_count_column' ]    = 'dln_like_count';
		//$sortable_columns[ 'dln_comment_count_column' ] = 'dln_comment_count';
		$sortable_columns[ 'dln_total_count_column' ]   = 'dln_total_count';
		
		return $sortable_columns;
	}
	
	public function sortable_column_dln_article_clause( $query ) {
		if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
			switch( $orderby ) {
				case 'dln_publish_date':
					$query->set( 'meta_key', 'dln_publish_date' );
					$query->set( 'orderby', 'meta_value' );
					break;
				case 'dln_share_count_column':
					$query->set( 'meta_key', 'dln_share_count' );
					$query->set( 'orderby', 'meta_value' );
					break;
				case 'dln_like_count':
					$query->set( 'meta_key', 'dln_like_count' );
					$query->set( 'orderby', 'meta_value' );
					break;
				//case 'dln_comment_count':
				//	$query->set( 'meta_key', 'dln_comment_count' );
				//	$query->set( 'orderby', 'meta_value' );
				//	break;
			}
		}
	}
	
	public function sortable_column_dln_article_clauses( $pieces, $query ) {
		global $wpdb;
		if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
		
			// Get the order query variable - ASC or DESC
			$order = strtoupper( $query->get( 'order' ) );
		
			// Make sure the order setting qualifies. If not, set default as ASC
			if ( ! in_array( $order, array( 'ASC', 'DESC' ) ) )
				$order = 'ASC';
		
			switch( $orderby ) {
				case 'dln_total_count':
					$pieces[ 'join' ] .= " LEFT JOIN $wpdb->postmeta wp_rd ON wp_rd.post_id = {$wpdb->posts}.ID AND wp_rd.meta_key = 'dln_total_count'";
					$pieces[ 'orderby' ] = "ABS( wp_rd.meta_value ) $order, " . $pieces[ 'orderby' ];
					break;
				case 'dln_share_count':
					$pieces[ 'join' ] .= " LEFT JOIN $wpdb->postmeta wp_rd ON wp_rd.post_id = {$wpdb->posts}.ID AND wp_rd.meta_key = 'dln_share_count'";
					$pieces[ 'orderby' ] = "ABS( wp_rd.meta_value ) $order, " . $pieces[ 'orderby' ];
					break;
				case 'dln_like_count':
					$pieces[ 'join' ] .= " LEFT JOIN $wpdb->postmeta wp_rd ON wp_rd.post_id = {$wpdb->posts}.ID AND wp_rd.meta_key = 'dln_like_count'";
					$pieces[ 'orderby' ] = "ABS( wp_rd.meta_value ) $order, " . $pieces[ 'orderby' ];
					break;
				}
			}
		
			return $pieces;
	}
	
}

DLN_Term_Article::get_instance();