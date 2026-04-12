<?php
/**
 * DB Schema for Listing Engine Frontend.
 * (Currently managed by external plugin)
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get schema definitions for listing engine tables.
 *
 * @return array Table schemas mapped by table name.
 */
function lef_get_db_schemas() {
	global $wpdb;
    
	$charset_collate = $wpdb->get_charset_collate();

	// Define all required tables and their queries here so that db handler can seamlessly execute them.
	$schemas = array(
		'wp_ls_reservation' => "CREATE TABLE wp_ls_reservation (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL,
            property_id bigint(20) unsigned NOT NULL,
            reserve_date date NOT NULL,
            total_guests int(11) NOT NULL,
            total_price decimal(10,2) NOT NULL,
            status varchar(20) NOT NULL DEFAULT 'pending',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;"
	);

	return $schemas;
}
