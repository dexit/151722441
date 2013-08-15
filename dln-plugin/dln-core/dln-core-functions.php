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