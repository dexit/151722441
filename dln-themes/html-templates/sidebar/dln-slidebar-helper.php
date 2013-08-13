<?php
if ( ! function_exists( 'dln_get_count_current_notification' ) ) {
	
	function dln_get_count_current_notification() {
		
		if ( ! function_exists( 'bp_core_get_notifications_for_user' ) || ! function_exists( 'bp_loggedin_user_id' ) ) {
			var_dump( 'Buddy Press not run!' );
			return false;
		}
		$count = !empty($notifications) ? count($notifications) : 0;
		
		echo $count;
	}
	
}