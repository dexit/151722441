<?php

/**
 * True if an the user can post a profile. If accounts are required, and reg is enabled, users can post (they signup at the same time).
 *
 * @return bool
 */
function dln_form_user_can_post_profile() {
	$can_post = true;
	
	if ( ! is_user_logged_in() ) {
		//if ( dln_form_user_requires_account() && ! dln_form_enable_registration() ) {
			$can_post = false;
		//}
	}
	
	return apply_filters( 'dln_form_user_can_post_profile', $can_post );
}