<?php
/**
 * Registry Hooks for Listing Engine Frontend.
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─────────────────────────────────────────────────────────────
// Admin Menus Registration
// ─────────────────────────────────────────────────────────────

/* ==================== MENUS ==================== */

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
		'dashicons-building',               // Icon
		26                                  // Position
	);

	// Add submenu "Dashboard" under "LEF"
	add_submenu_page(
		'lef-main-menu',                    // Parent slug
		'Listing Engine Dashboard',         // Page title
		'Dashboard',                        // Menu title
		'manage_options',                   // Capability
		'lef-dashboard',                    // Menu slug
		'lef_render_dashboard_page'         // Callback function
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

	// Add submenu "Manage Reservations" under "LEF"
	add_submenu_page(
		'lef-main-menu',
		'Manage Reservations',
		'Manage Reservations',
		'manage_options',
		'lef-manage-reservations',
		'lef_render_manage_reservations_page'
	);
	
	// Remove the duplicate "LEF" submenu that WordPress auto-creates
	remove_submenu_page( 'lef-main-menu', 'lef-main-menu' );
}
add_action( 'admin_menu', 'lef_register_admin_menus' );

// ─────────────────────────────────────────────────────────────
// Admin Pages Callbacks
// ─────────────────────────────────────────────────────────────

/* ==================== PAGES ==================== */

/**
 * Callback for Main Menu Page (Fallback if needed, redirects to dashboard)
 */
function lef_render_main_page() {
	echo '<script>window.location.replace("admin.php?page=lef-dashboard");</script>';
}

/**
 * Callback for Dashboard Submenu Page
 */
function lef_render_dashboard_page() {
	$template_path = LEF_PLUGIN_DIR . 'backend/template/dashboard.php';
	
	if ( file_exists( $template_path ) ) {
		require_once $template_path;
	} else {
		echo '<div class="wrap"><div class="error"><p>Dashboard template not found.</p></div></div>';
	}
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

/**
 * Callback for Manage Reservations Submenu Page
 */
function lef_render_manage_reservations_page() {
	$template_path = LEF_PLUGIN_DIR . 'backend/template/manage-reservation-models/manage-reservation.php';
	
	if ( file_exists( $template_path ) ) {
		require_once $template_path;
	} else {
		echo '<div class="wrap"><div class="error"><p>Manage Reservations template not found.</p></div></div>';
	}
}
