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
	return get_terms( DLN_COMPANY_TYPE_SLUG, array(
		'orderby'       => 'name',
		'order'         => 'ASC',
		'hide_empty'    => false,
	) );
}

function get_employ_number_options() {
	return get_terms( DLN_EMPLOYEE_NUMBER_SLUG, array(
		'orderby'       => 'ID',
		'order'         => 'ASC',
		'hide_empty'    => false,
	) );
}

function get_open_status() {
	return array(
		'normal_hours'  => __( 'Normal hours', DLN_POINT_SLUG ),
		'coming_soon'   => __( 'Coming soon', DLN_POINT_SLUG ),
		'temp_closed'   => __( 'Temporarily closed', DLN_POINT_SLUG ),
		'season_closed' => __( 'Seasonally closed', DLN_POINT_SLUG ),
	);
}

function get_first_option( $arr ) {
	foreach ( $arr as $key => $value ) {
		if ( ! is_array( $key ) )
			return $key;
	}
}

function dln_get_point_price_range() {
	return get_terms( 'dln_point_price', array(
		'orderby'       => 'ID',
		'order'         => 'ASC',
		'hide_empty'    => false,
	) );
}

function dln_get_point_list_foods() {
	return get_terms( 'dln_point_foods', array(
		'orderby'       => 'name',
		'order'         => 'ASC',
		'hide_empty'    => false,
	) );
}

function dln_get_point_list_feature() {
	return get_terms( 'dln_point_special_feature', array(
		'orderby'       => 'name',
		'order'         => 'ASC',
		'hide_empty'    => false,
	) );
}

function dln_form_user_can_post_point() {
	$can_post = true;
	
	if ( ! is_user_logged_in() ) {
		//if ( dln_form_user_requires_account() && ! dln_form_enable_registration() ) {
		$can_post = false;
		//}
	}
	
	return apply_filters( 'dln_form_user_can_post_point', $can_post );
}
