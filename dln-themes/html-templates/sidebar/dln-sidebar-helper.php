<?php
if ( ! function_exists( 'dln_get_count_current_notification' ) ) {
	
	function dln_get_count_current_notification() {
		
		if ( ! function_exists( 'bp_core_get_notifications_for_user' ) || ! function_exists( 'bp_loggedin_user_id' ) ) {
			print_r( 'Buddy Press not run!' );
			return false;
		}
		
		if ( !is_user_logged_in() )
		return false;

		$notifications = bp_core_get_notification( bp_loggedin_user_id() );
		$count         = !empty( $notifications ) ? count( $notifications ) : 0;
		var_dump($notifications);
		echo $count;
	}
	
}