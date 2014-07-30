<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Form_Admin_PostType {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		//add_action( 'init', array( $this, 'register_post_types_fashion' ), 5 );
		add_action( 'init', array( $this, 'dln_company_status_filters' ) );
		
		add_filter( 'product_type_selector', array( $this, 'register_product_type_fashion' ) );
	}
	
	public function register_product_type_fashion( $types ) {
		$types['fashion'] = __( 'Fashion', DLN_CLF );
		return $types; 
	}
	
	public static function register_post_types_fashion() {
		if ( post_type_exists( 'dln_fashion' ) )
			return;
		
		$permalinks        = get_option( 'woocommerce_permalinks' );
		$fashion_permalink = empty( $permalinks['fashion_base'] ) ? _x( 'fashion', 'slug', DLN_CLF ) : $permalinks['fashion_base'];
		
		register_post_type(
			'dln_fashion', 
			apply_filters(
				'dln_classified_register_post_type_fashion',
				array(
					'labels' => array(
						'name'                  => __( 'Fashions', DLN_CLF ),
						'singular_name'         => __( 'Fashion', DLN_CLF ),
						'menu_name'             => __( 'Fashions', DLN_CLF ),
						'add_new' 				=> __( 'Add Fashion', DLN_CLF ),
						'add_new_item' 			=> __( 'Add New Fashion', DLN_CLF ),
						'edit' 					=> __( 'Edit', DLN_CLF ),
						'edit_item' 			=> __( 'Edit Fashion', DLN_CLF ),
						'new_item' 				=> __( 'New Fashion', DLN_CLF ),
						'view' 					=> __( 'View Fashion', DLN_CLF ),
						'view_item' 			=> __( 'View Fashion', DLN_CLF ),
						'search_items' 			=> __( 'Search Fashions', DLN_CLF ),
						'not_found' 			=> __( 'No Fashions found', DLN_CLF ),
						'not_found_in_trash' 	=> __( 'No Fashions found in trash', DLN_CLF ),
						'parent' 				=> __( 'Parent Fashion', DLN_CLF )
					),
					'description' 			=> __( 'This is where you can add new fashion items to your store.', DLN_CLF ),
					'public' 				=> true,
					'show_ui' 				=> true,
					'capability_type' 		=> 'dln_fashion',
					'map_meta_cap'			=> true,
					'publicly_queryable' 	=> true,
					'exclude_from_search' 	=> false,
					'hierarchical' 			=> false, // Hierarchical causes memory issues - WP loads all records!
					'rewrite' 				=> $fashion_permalink ? array( 'slug' => untrailingslashit( $fashion_permalink ), 'with_front' => false, 'feeds' => true ) : false,
					'query_var' 			=> true,
					'supports' 				=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields', 'page-attributes' ),
					'has_archive' 			=> ( $shop_page_id = wc_get_page_id( 'shop' ) ) && get_page( $shop_page_id ) ? get_page_uri( $shop_page_id ) : 'shop',
					'show_in_nav_menus' 	=> true,
				)
			)
		);
	}
	
	public function dln_company_status_filters() {
		$types = self::get_company_status();
		foreach ( $types as $name => $type ) {
			register_post_status(
				$name,
				array(
					'label'       => $type,
					'private'     => true,
					'_builtin'    => true, /* internal use only. */
					'label_count' => _n_noop( $type . ' <span class="count">(%s)</span>', $type . ' <span class="count">(%s)</span>' ),
				)
			);
		}
	}
	
	public static function get_company_status() {
		return (array) apply_filters(
			'dln_form_company_status',
			array(
				'company_pending'      => __( 'Company Pending', 'dln-skill' ),
				'company_publish'      => __( 'Company Published', 'dln-skill' ),
				'company_ban'          => __( 'Company Banned', 'dln-skill' ),
			) 
		);
	}
	
}

DLN_Form_Admin_PostType::get_instance();