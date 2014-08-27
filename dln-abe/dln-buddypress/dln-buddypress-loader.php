<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_BuddyPress_Loader {
	
	public static $instance;
	
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	}
	
	function __construct() {
		//add_action( 'init', array( $this, 'init' ) );
		add_action( 'dln_add_product', array( $this, 'create_product' ) );
	}
	
	public function create_product( $product_id = 0, $product_title = '', $author_id = 0 ) {
		// Validate activity data
		$user_id    = (int) $author_id;
		$product_id = (int) $product_id;
		
		// User link for product author
		$user_link = bbp_get_user_profile_link( $user_id );
		
		// Product
		$product_permalink = get_permalink( $product_id );
		$product_link      = '<a href="' . $product_permalink . '">' . $product_title . '</a>';
		
		// Activity action & text
		$activity_text   = sprintf( esc_html( '%1$s created the a new product %2$s', DLN_ABE ), $user_link, $product_permalink );
		
		// Compile and record the activity stream results
		$activity_id = self::record_activity( array(
			'id'            => null,
			'user_id'       => $user_id,
			'action'        => $activity_text,
			'content'       => null,
			'primary_link'  => $product_permalink,
			'type'          => 'dln_create_product',
			'item_id'       => $product_id,
			'recorded_time' => get_post_time( 'Y-m-d H:i:s', true, $product_id ),
			'hide_sitewide' => false
		) );
		
		// Add the activity entry ID as a meta value to the product
		if ( ! empty( $activity_id ) ) {
			update_post_meta( $product_id, '_dln_activity_id', $activity_id );
		}
	}
	
	private static function record_activity( $args = array() ) {
		
		// Default activity args
		$activity = bbp_parse_args( $args, array(
			'id'                => null,
			'user_id'           => bbp_get_current_user_id(),
			'type'              => '',
			'action'            => '',
			'item_id'           => '',
			'secondary_item_id' => '',
			'content'           => '',
			'primary_link'      => '',
			'component'         => $this->component,
			'recorded_time'     => bp_core_current_time(),
			'hide_sitewide'     => false
		), 'record_activity' );
		
		// Add the activity
		return bp_activity_add( $activity );
	}
}

$GLOBALS['dln_buddypress'] = DLN_BuddyPress_Loader::get_instance();