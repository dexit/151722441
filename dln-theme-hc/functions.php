<?php

function dln_get_notifications_objects() {
	if ( ! is_user_logged_in() ) {
		return false;
	}

	$notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
	var_dump($notifications);die();
	$count         = ! empty( $notifications ) ? count( $notifications ) : 0;
	$alert_class   = (int) $count > 0 ? 'pending-count alert' : 'count no-alert';
	$menu_title    = '<span id="ab-pending-notifications" class="' . $alert_class . '">' . number_format_i18n( $count ) . '</span>';
	$menu_link     = trailingslashit( bp_loggedin_user_domain() . bp_get_notifications_slug() );
	
	
}