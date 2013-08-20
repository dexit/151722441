<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'dln_core_get_table_prefix' ) )
{
	/**
	 * Allow filtering of database prefix. Intended for use in multinetwork installations.
	 *
	 * @global object $wpdb WordPress database object
	 * @return string Filtered database prefix
	 */
	function dln_core_get_table_prefix()
	{
		global $wpdb;
		
		return apply_filters( 'dln_core_get_table_prefix', $wpdb->base_prefix );
	}
}

if ( ! function_exists( 'dln_notification_save' ) )
{
	function dln_notification_save( $notification )
	{	
		if ( empty( $notification->date_notified ) )
			$date_notified = bp_core_current_time();
		
		$dln_notification					= new DLN_Core_Notification();
		$dln_notification->bp_id          	= $notification->id;
		$dln_notification->item_id          = $notification->item_id;
		$dln_notification->user_id          = $notification->user_id;
		$dln_notification->component_name   = $notification->component_name;
		$dln_notification->component_action = $notification->component_action;
		$dln_notification->date_notified    = $notification->date_notified;
		$dln_notification->is_new           = 1;
		$dln_notification->secondary_item_id 	= $notification->secondary_item_id;
		
		if ( $dln_notification->save() ) {
			return true;
		}
		
		return false;
	}
}
add_filter( 'dln_notification_save', 'dln_notification_save' );

if ( ! function_exists( 'dln_core_get_notifications_for_user' ) )
{
	function dln_core_get_notifications_for_user( $user_id, $format = 'simple' )
	{
		global $bp;

		$notifications         = DLN_Core_Notification::get_all_for_user( $user_id );
		
		$grouped_notifications = array(); // Notification groups
		$renderable            = array(); // Renderable notifications
	
		// Group notifications by component and component_action and provide totals
		for ( $i = 0, $count = count( $notifications ); $i < $count; ++$i ) {
			$notification = $notifications[$i];
			$grouped_notifications[$notification->component_name][$notification->component_action][] = $notification;
		}
		
		// Bail if no notification groups
		if ( empty( $grouped_notifications ) )
			return false;
	
		// Calculate a renderable output for each notification type
		foreach ( $grouped_notifications as $component_name => $action_arrays ) {
	
			// Skip if group is empty
			if ( empty( $action_arrays ) )
				continue;
	
			// Skip inactive components
			if ( !bp_is_active( $component_name ) )
				continue;
	
			// Loop through each actionable item and try to map it to a component
			foreach ( (array) $action_arrays as $component_action_name => $component_action_items ) {

				// Get the number of actionable items
				$action_item_count = count( $component_action_items );
				// Skip if the count is less than 1
				if ( $action_item_count < 1 )
					continue;
	
				// Callback function exists
				if ( isset( $bp->{$component_name}->notification_callback ) && is_callable( $bp->{$component_name}->notification_callback ) ) {
	
					// Function should return an object
					if ( 'object_fb' == $format )
					{
						foreach ( $component_action_items as $index => $notification_detail )
						{
							$content = call_user_func(
								$bp->{$component_name}->notification_callback,
								$component_action_name,
								$notification_detail->item_id,
								$notification_detail->secondary_item_id,
								1,
								'array'
							);
							
							// Create the object to be returned
							$notification_object = new stdClass;
							
							// Minimal backpat with non-compatible notification
							// callback functions
							if ( is_string( $content ) ) {
								$notification_object->content = $content;
								$notification_object->href    = bp_loggedin_user_domain();
							} else {
								$notification_object->content = $content['text'];
								$notification_object->href    = $content['link'];
							}
							
							// Get user avatar
							switch ( $component_action_name ) {
								case 'new_at_mention':
									$sender_id		= $notification_detail->secondary_item_id;
									$fullname	 	= bp_core_get_user_displayname( $sender_id );
									$notification_object->avatar	= bp_core_fetch_avatar( array( 
											'item_id' 	=> $sender_id, 
											'type'    	=> 'thumb', 
											'alt'	  	=> sprintf( __( 'Profile picture of %s', 'buddypress' ), $fullname ),
											'no_grav' 	=> true,
											'height'	=> '28',
											'width'		=> '28'
									 ) );
									break;
								default:
									$notification_object->avatar	= '';
									break;
							}
							
							$notification_object->id 			= $notification_detail->id;
							$notification_object->send_time 	= bp_core_time_since( $notification_detail->date_notified );
							$notification_object->type			= $notification_detail->component_name;
							$renderable[]            			= $notification_object;
						}
					}
					else if ( 'object' == $format ) {
	
						// Retrieve the content of the notification using the callback
						$content = call_user_func(
							$bp->{$component_name}->notification_callback,
							$component_action_name,
							$component_action_items[0]->item_id,
							$component_action_items[0]->secondary_item_id,
							$action_item_count,
							'array'
						);
	
						// Create the object to be returned
						$notification_object = new stdClass;
	
						// Minimal backpat with non-compatible notification
						// callback functions
						if ( is_string( $content ) ) {
							$notification_object->content = $content;
							$notification_object->href    = bp_loggedin_user_domain();
						} else {
							$notification_object->content = $content['text'];
							$notification_object->href    = $content['link'];
						}
	
						$notification_object->id = $component_action_items[0]->id;
						$renderable[]            = $notification_object;
	
					// Return an array of content strings
					} else {
						$content      = call_user_func( $bp->{$component_name}->notification_callback, $component_action_name, $component_action_items[0]->item_id, $component_action_items[0]->secondary_item_id, $action_item_count );
						$renderable[] = $content;
					}
	
				// @deprecated format_notification_function - 1.5
				} elseif ( isset( $bp->{$component_name}->format_notification_function ) && function_exists( $bp->{$component_name}->format_notification_function ) ) {
					$renderable[] = call_user_func( $bp->{$component_name}->format_notification_function, $component_action_name, $component_action_items[0]->item_id, $component_action_items[0]->secondary_item_id, $action_item_count );
				}
			}
		}
		//var_dump($renderable);die();
		// If renderable is empty array, set to false
		if ( empty( $renderable ) )
			$renderable = false;
	
		// Filter and return
		return apply_filters( 'dln_core_get_nofitications_for_user', $renderable, $user_id, $format );
	}
}

if ( ! function_exists( 'dln_core_get_user_avatar' ) )
{
	function dln_core_get_user_avatar()
	{
		$avatar = bp_core_fetch_avatar( array(
			'item_id' 	=> bp_displayed_user_id(),
			'type'    	=> 'thumb',
			'alt'	  	=> sprintf( __( 'Profile picture of %s', 'buddypress' ), bp_get_displayed_user_fullname() ),
			'no_grav' 	=> true
		) );
		
		return $avatar;
	}
}