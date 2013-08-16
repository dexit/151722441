<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'dln_core_set_charset' ) )
{
	function dln_core_set_charset()
	{
		global $wpdb;
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		return ! empty( $wpdb->charset ) ?  "DEFAULT CHARACTER SET {$wpdb->charset}" : "";
	}
}

if ( ! function_exists( 'dln_core_install' ) )
{
	function dln_core_install()
	{
		global $dln_db_version;
		// Install DLN Notifications
		dln_core_install_notification();
		add_option( 'dln_db_version', $dln_db_version );
	} 
}

if ( ! function_exists( 'dln_core_install_notification' ) )
{
	function dln_core_install_notification()
	{
		$sql 				= array();
		$charset_collate	= dln_core_set_charset();
		$dln_prefix			= dln_core_get_table_prefix();

		$sql[] = "CREATE TABLE {$dln_prefix}dln_notifications (
	  		    id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  		    bp_id bigint(20) NOT NULL,
			    user_id bigint(20) NOT NULL,
			    item_id bigint(20) NOT NULL,
			    secondary_item_id bigint(20),
	  		    component_name varchar(75) NOT NULL,
			    component_action varchar(75) NOT NULL,
	  		    date_notified datetime NOT NULL,
			    is_new bool NOT NULL DEFAULT 0,
		        KEY item_id (item_id),
			    KEY secondary_item_id (secondary_item_id),
			    KEY user_id (user_id),
			    KEY is_new (is_new),
			    KEY component_name (component_name),
	 	   	    KEY component_action (component_action),
			    KEY useritem (user_id,is_new)
		       ) {$charset_collate};";

		dbDelta( $sql );
	}
}

if ( ! function_exists( 'dln_core_db_check_update' ) )
{
	function dln_core_db_check_update()
	{
		global $dln_db_version;
		if ( get_option( 'dln_db_version' ) != $dln_db_version )
		{
			dln_core_install();
		}
	}
}
add_action( 'plugins_loaded', 'dln_core_db_check_update' );