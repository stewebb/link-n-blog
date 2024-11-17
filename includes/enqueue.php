<?php

function enqueue_public_assets(): void {

	// Custom public assets
	wp_enqueue_style(
		'link-item-css',
		plugin_dir_url( __FILE__ ) . '../assets/css/link-item.css'
	);

	wp_enqueue_script(
		'patternomaly-js',
		plugin_dir_url( __FILE__ ) . '../assets/js/patternomaly.min.js',
		[],
		'1.0.0',
		false
	);

	wp_enqueue_script(
		'pattern-generator-js',
		plugin_dir_url( __FILE__ ) . '../assets/js/PatternGenerator.js',
		['patternomaly-js'],
		'1.0.0',
		false
	);

	wp_enqueue_script(
		'color-manipulator-js',
		plugin_dir_url( __FILE__ ) . '../assets/js/ColorManipulator.js',
		[],
		'1.0.0',
		false
	);

	// Bootstrap
	wp_enqueue_style(
		'bootstrap-css',
		plugin_dir_url( __FILE__ ) . '../assets/css/bootstrap.min.css',
		[],
		'5.3.0'
	);

	wp_enqueue_script(
		'bootstrap-js',
		plugin_dir_url( __FILE__ ) . '../assets/js/bootstrap.bundle.min.js',
		[],
		'5.3.0',
		true
	);

	if (!is_admin()) {
		wp_enqueue_style('dashicons');
	}
}

add_action( 'wp', function () {
	$current_post = get_post();
	if ( $current_post && has_shortcode( $current_post->post_content, 'lnb' ) ) {
		enqueue_public_assets();
	}
} );

// Enqueue admin styles and conditionally enqueue scripts
add_action( 'admin_enqueue_scripts', function (): void {

	// Custom admin assets
	wp_enqueue_style(
		'admin-css',
		plugin_dir_url( __FILE__ ) . '../assets/css/admin-styles.css'
	);

	wp_enqueue_script(
		'admin-script',
		plugin_dir_url( __FILE__ ) . '../assets/js/admin-scripts.js',
		[ 'jquery' ],
		'1.0.0',
		true
	);

	// WordPress pickers
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_media();

	// Conditionally enqueue scripts based on admin page
	global $hook_suffix;

	switch ( $hook_suffix ) {
		// Link List page
		case 'link-n-blog_page_link-n-blog-link-list':
			// Enqueue scripts/styles specific to the Link List page
			break;

		// Add a Link page
		case 'link-n-blog_page_link-n-blog-details':
			// Enqueue scripts/styles specific to Add a Link page
			break;

		// Categories page
		case 'link-n-blog_page_link-n-blog-categories':
			// Enqueue scripts/styles specific to Categories page
			break;

		// Preview page
		case 'link-n-blog_page_link-n-blog-preview':
			enqueue_public_assets();
			break;

		default:
			// No specific assets for other admin pages
			break;
	}
} );