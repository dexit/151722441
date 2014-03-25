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

function get_company_types_options() {
	return get_terms( 'dln_company_type', array(
		'orderby'       => 'name',
		'order'         => 'ASC',
		'hide_empty'    => false,
	) );
}

function get_employ_number_options() {
	return array(
		'1_to_5'     => __( '1 to 5 Employees', 'dln-skill' ),
		'6_to_15'    => __( '6 to 15 Employees', 'dln-skill' ),
		'16_to_50'   => __( '16 to 50 Employees', 'dln-skill' ),
		'50_to_149'  => __( '50 to 149 Employees', 'dln-skill' ),
		'150_to_499' => __( '150 to 449 Employees', 'dln-skill' ),
		'500_to_999' => __( '500 to 999 Employees', 'dln-skill' ),
		'1000_plus'  => __( '1000+ Employees', 'dln-skill' ),
	);
}
