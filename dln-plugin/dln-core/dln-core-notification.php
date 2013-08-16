<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DLN_Core_Notification' ) )
{
	class DLN_Core_Notification
	{
		
		/**
		 * The notification id
		 *
		 * @var integer
		 */
		var $id;
		
		/**
		 * The buddypress notification id
		 *
		 * @var integer
		 */
		var $bp_id;
		
		/**
		 * The ID to which the notification relates to within the component.
		 *
		 * @var integer
		 */
		var $item_id;
		
		/**
		 * The secondary ID to which the notification relates to within the component.
		 *
		 * @var integer
		 */
		var $secondary_item_id = null;
		
		/**
		 * The user ID for who the notification is for.
		 *
		 * @var integer
		 */
		var $user_id;
		
		/**
		 * The name of the component that the notification is for.
		 *
		 * @var string
		 */
		var $component_name;
		
		/**
		 * The action within the component which the notification is related to.
		 *
		 * @var string
		 */
		var $component_action;
		
		/**
		 * The date the notification was created.
		 *
		 * @var string
		 */
		var $date_notified;
		
		/**
		 * Is the notification new or has it already been read.
		 *
		 * @var boolean
		 */
		var $is_new;
		
		/**
		 * Constructor
		 *
		 * @param integer $id
		 */
		function __construct( $id = 0 ) {
			if ( !empty( $id ) ) {
				$this->id = $id;
				$this->populate();
			}
		}
		
		/**
		 * Update or insert notification details into the database.
		 *
		 * @global BuddyPress $bp The one true BuddyPress instance
		 * @global wpdb $wpdb WordPress database object
		 * @return bool Success or failure
		 */
		function save()
		{
			global $wpdb;
			$dln	= DLNPlugin::instance();
			
			$sql 	= $wpdb->prepare( "INSERT INTO {$dln->core->table_name_notifications} ( bp_id, item_id, secondary_item_id, user_id, component_name, component_action, date_notified, is_new ) VALUES ( %d, %d, %d, %d, %s, %s, %s, %d )" , $this->id, $this->item_id, $this->secondary_item_id, $this->user_id, $this->component_name, $this->component_action, $this->date_notified, $this->is_new );
			
			if ( !$result = $wpdb->query( $sql ) )
				return false;
			$this->id = $wpdb->insert_id;
			
			return true;
		}
		
		/**
		 * Fetches all the notifications in the database for a specific user.
		 *
		 * @global BuddyPress $bp The one true BuddyPress instance
		 * @global wpdb $wpdb WordPress database object
		 * @param integer $user_id User ID
		 * @param string $status 'is_new' or 'all'
		 * @return array Associative array
		 * @static
		 */
		function get_all_for_user( $user_id, $status = 'is_new' ) {
			global $wpdb;
			$dln	= DLNPlugin::instance();
		
			$is_new = ( 'is_new' == $status ) ? ' AND is_new = 1 ' : '';
			return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$dln->core->table_name_notifications} WHERE user_id = %d {$is_new}", $user_id ) );
		}
	}	
}
