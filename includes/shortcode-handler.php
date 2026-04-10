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
 * Register the shortcodes.
 */
function lef_register_shortcodes() {
	add_shortcode( 'listing_engine_view', 'lef_render_list_view' );
	add_shortcode( 'selected_list_view', 'lef_render_selected_list_view' );
	add_shortcode( 'premium_search_bar', 'lef_render_premium_search_bar' );
}
add_action( 'init', 'lef_register_shortcodes' );

/**
 * Render the Premium Search Bar.
 * @return string The rendered HTML.
 */
function lef_render_premium_search_bar() {
	ob_start();
	
	$template_path = LEF_PLUGIN_DIR . 'frontend/template/search-bar.php';
	
	if ( file_exists( $template_path ) ) {
		include $template_path;
	} else {
		echo '<p>Search bar template not found.</p>';
	}
	
	return ob_get_clean();
}

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

/**
 * Render the Selected List View.
 * 
 * @param array $atts Shortcode attributes.
 * @return string The rendered HTML.
 */
function lef_render_selected_list_view( $atts ) {
	$atts = shortcode_atts( array(
		'view'     => 'grid',
		'count'    => 10,
		'location' => '',
		'type'     => '',
	), $atts, 'selected_list_view' );

	ob_start();
	
	// Include the template.
	$template_path = LEF_PLUGIN_DIR . 'frontend/template/selected-list-view.php';
	
	if ( file_exists( $template_path ) ) {
		// Pass attributes to the template.
		set_query_var( 'lef_selected_atts', $atts );
		include $template_path;
	} else {
		echo '<p>Template not found: ' . esc_html( $template_path ) . '</p>';
	}
	
	return ob_get_clean();
}

