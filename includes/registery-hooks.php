<?php
/**
 * Registry Hooks for Listing Engine Frontend.
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register LEF Admin Menu and Submenus.
 */
function lef_register_admin_menus() {
	// Add main menu "LEF" below Comments. Comments corresponds to position 25, so we use 26.
	add_menu_page(
		'Listing Engine Frontend',          // Page title
		'LEF',                              // Menu title
		'manage_options',                   // Capability
		'lef-main-menu',                    // Menu slug
		'lef_render_main_page',             // Callback function
		'dashicons-admin-generic',          // Icon
		26                                  // Position
	);

	// Add submenu "Database" under "LEF"
	add_submenu_page(
		'lef-main-menu',                    // Parent slug
		'Database Management',              // Page title
		'Database',                         // Menu title
		'manage_options',                   // Capability
		'lef-database',                     // Menu slug
		'lef_render_database_page'          // Callback function
	);
	
	// Remove the duplicate "LEF" submenu that WordPress auto-creates
	remove_submenu_page( 'lef-main-menu', 'lef-main-menu' );
}
add_action( 'admin_menu', 'lef_register_admin_menus' );

/**
 * Callback for Main Menu Page (Fallback if needed, though removed above, it's good practice)
 */
function lef_render_main_page() {
	echo '<div class="wrap"><h1>Listing Engine Frontend Dashboard</h1><p>Welcome to LEF Management.</p></div>';
}

/**
 * Callback for Database Submenu Page
 */
function lef_render_database_page() {
	$template_path = LEF_PLUGIN_DIR . 'backend/template/database.php';
	
	if ( file_exists( $template_path ) ) {
		require_once $template_path;
	} else {
		echo '<div class="wrap"><div class="error"><p>Database template not found.</p></div></div>';
	}
}
