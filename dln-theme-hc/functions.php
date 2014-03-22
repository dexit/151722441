<?php

function dln_get_notifications_objects() {
	if ( ! is_user_logged_in() ) {
		return false;
	}

	$notifications = BP_Notifications_Notification::get( array(
		'user_id'        => bp_loggedin_user_id(),
		'is_new'         => '1',
		'component_name' => bp_notifications_get_registered_components(),
	) );
	
	if ( ! $notifications )
		return;
	
	$count_m = $count_f = $count_a = 0;
	$arr_m = $arr_f = $arr_a = array();
	foreach ( $notifications as $i => $nof ) {
		switch ( $nof->component_name ) {
			case 'messages':
				$count_m++;
				$arr_m[] = $nof;
				break;
			case 'friends':
				$count_f++;
				$arr_f[] = $nof;
				break;
		}
	}
	
	$result = array();
	$result['messages'] = array( 
		'nof_count' => $count_m,
		'nof_arr'   => $arr_m
	);
	$result['friends'] = array(
		'nof_type'  => 'friends',
		'nof_count' => $count_f,
		'nof_arr'   => $arr_f
	);
	return $result;
}


