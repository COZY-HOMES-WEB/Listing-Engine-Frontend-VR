<?php
/**
 * Asset Loader for Listing Engine Frontend.
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Global and Conditional Assets.
 */
function lef_enqueue_assets() {
	// 1. Enqueue Global CSS (variables only).
	wp_enqueue_style(
		'lef-global-styles',
		LEF_PLUGIN_URL . 'global-assets/css/global.css',
		array(),
		filemtime( LEF_PLUGIN_DIR . 'global-assets/css/global.css' )
	);

	// 2. Enqueue Global Component Assets (Toaster & Confirmation).
	lef_enqueue_global_components();

	// 3. Conditional Assets for Shortcodes.
	global $post;
	if ( is_a( $post, 'WP_Post' ) ) {
		// Assets for [listing_engine_view]
		if ( has_shortcode( $post->post_content, 'listing_engine_view' ) ) {
			wp_enqueue_style(
				'lef-list-view',
				LEF_PLUGIN_URL . 'frontend/assets/css/list-view.css',
				array( 'lef-global-styles' ),
				filemtime( LEF_PLUGIN_DIR . 'frontend/assets/css/list-view.css' )
			);

			wp_enqueue_script(
				'lef-list-view-js',
				LEF_PLUGIN_URL . 'frontend/assets/js/list-view.js',
				array( 'jquery' ),
				filemtime( LEF_PLUGIN_DIR . 'frontend/assets/js/list-view.js' ),
				true
			);
		}

		// Assets for [selected_list_view]
		if ( has_shortcode( $post->post_content, 'selected_list_view' ) ) {
			wp_enqueue_style(
				'lef-selected-view',
				LEF_PLUGIN_URL . 'frontend/assets/css/selected-list-view.css',
				array( 'lef-global-styles' ),
				filemtime( LEF_PLUGIN_DIR . 'frontend/assets/css/selected-list-view.css' )
			);

			wp_enqueue_script(
				'lef-selected-view-js',
				LEF_PLUGIN_URL . 'frontend/assets/js/selected-list-view.js',
				array( 'jquery' ),
				filemtime( LEF_PLUGIN_DIR . 'frontend/assets/js/selected-list-view.js' ),
				true
			);
		}

		// Pass localized data to JS (if either script is enqueued)
		if ( wp_script_is( 'lef-list-view-js', 'enqueued' ) || wp_script_is( 'lef-selected-view-js', 'enqueued' ) ) {
			wp_localize_script( 
				wp_script_is( 'lef-list-view-js', 'enqueued' ) ? 'lef-list-view-js' : 'lef-selected-view-js', 
				'lefData', 
				array(
					'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
					'pluginUrl' => LEF_PLUGIN_URL,
				)
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'lef_enqueue_assets' );

/**
 * Enqueue Global Components.
 */
function lef_enqueue_global_components() {
	// Toaster.
	wp_enqueue_style(
		'lef-toaster',
		LEF_PLUGIN_URL . 'global-assets/css/toaster.css',
		array(),
		filemtime( LEF_PLUGIN_DIR . 'global-assets/css/toaster.css' )
	);
	wp_enqueue_script(
		'lef-toaster-js',
		LEF_PLUGIN_URL . 'global-assets/js/toaster.js',
		array(),
		filemtime( LEF_PLUGIN_DIR . 'global-assets/js/toaster.js' ),
		true
	);

	// Confirmation.
	wp_enqueue_style(
		'lef-confirmation',
		LEF_PLUGIN_URL . 'global-assets/css/confirmation.css',
		array(),
		filemtime( LEF_PLUGIN_DIR . 'global-assets/css/confirmation.css' )
	);
	wp_enqueue_script(
		'lef-confirmation-js',
		LEF_PLUGIN_URL . 'global-assets/js/confirmation.js',
		array(),
		filemtime( LEF_PLUGIN_DIR . 'global-assets/js/confirmation.js' ),
		true
	);
}
