<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'dln_get_current_notification' ) )
{	
	function dln_get_current_notification()
	{		
		if ( ! function_exists( 'bp_core_get_notifications_for_user' ) || ! function_exists( 'bp_loggedin_user_id' ) )
		{
			print_r( 'Buddy Press not run!' );
			return false;
		}
		if ( !is_user_logged_in() )
			return false;
		$notifications = dln_core_get_notifications_for_user( bp_loggedin_user_id(), 'object_fb' );
		
		return $notifications;
	}
}