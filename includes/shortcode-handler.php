<?php
/**
 * Shortcode Handler for Listing Engine Frontend.
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the [listing_engine_view] shortcode.
 */
function lef_register_shortcodes() {
	add_shortcode( 'listing_engine_view', 'lef_render_list_view' );
}
add_action( 'init', 'lef_register_shortcodes' );

/**
 * Render the List View.
 *
 * @return string The rendered HTML.
 */
function lef_render_list_view() {
	ob_start();
	
	// Include the template.
	$template_path = LEF_PLUGIN_DIR . 'frontend/template/list-view.php';
	
	if ( file_exists( $template_path ) ) {
		include $template_path;
	} else {
		echo '<p>Template not found.</p>';
	}
	
	return ob_get_clean();
}

