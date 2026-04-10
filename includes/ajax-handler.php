<?php
/**
 * AJAX Handler for Listing Engine Frontend.
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle location and address suggestions for the search bar.
 */
function lef_handle_search_suggestions() {
	check_ajax_referer('lef_search_nonce', 'nonce');

	global $wpdb;
	$query = isset($_GET['query']) ? sanitize_text_field($_GET['query']) : '';

	if (empty($query)) {
		wp_send_json_success(array());
	}

	$results = array();

	// 1. Search in Locations
	$locations = $wpdb->get_results($wpdb->prepare(
		"SELECT name FROM {$wpdb->prefix}ls_location WHERE name LIKE %s LIMIT 5",
		'%' . $wpdb->esc_like($query) . '%'
	));

	foreach ($locations as $loc) {
		$results[] = array(
			'name' => $loc->name,
			'type' => 'Location'
		);
	}

	// 2. Search in Listing Addresses
	$addresses = $wpdb->get_results($wpdb->prepare(
		"SELECT address FROM {$wpdb->prefix}ls_listings WHERE address LIKE %s AND status = 'published' LIMIT 5",
		'%' . $wpdb->esc_like($query) . '%'
	));

	foreach ($addresses as $addr) {
		// Avoid duplicates if address matches a location name exactly
		$results[] = array(
			'name' => $addr->address,
			'type' => 'Property'
		);
	}

	// Deduplicate by name
	$unique_results = array();
	$seen_names = array();
	foreach ($results as $res) {
		if (! in_array($res['name'], $seen_names)) {
			$unique_results[] = $res;
			$seen_names[] = $res['name'];
		}
	}

	wp_send_json_success(array_slice($unique_results, 0, 10));
}
add_action('wp_ajax_lef_search_suggestions', 'lef_handle_search_suggestions');
add_action('wp_ajax_nopriv_lef_search_suggestions', 'lef_handle_search_suggestions');
