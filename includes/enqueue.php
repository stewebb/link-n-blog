<?php

function enqueue_public_assets() {
// Enqueue Bootstrap CSS
	wp_enqueue_style(
		'bootstrap-css',
		plugin_dir_url( __FILE__ ) . 'assets/css/bootstrap.min.css',
		[],
		'5.3.0'
	);

	// Enqueue Bootstrap JS
	wp_enqueue_script(
		'bootstrap-js',
		plugin_dir_url( __FILE__ ) . 'assets/js/bootstrap.bundle.min.js',
		[],
		'5.3.0',
		true
	);
}

add_action( 'wp', function () {
	$current_post = get_post();

	if ( $current_post && has_shortcode( $current_post->post_content, 'lnb' ) ) {
		// Enqueue Bootstrap CSS and JS
		add_action( 'wp_enqueue_scripts', function () {
			wp_enqueue_style(
				'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', [], '5.3.0' );
			wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [ 'jquery' ], '5.3.0', true );
		} );
	}
} );


// Enqueue admin styles and conditionally enqueue scripts
add_action( 'admin_enqueue_scripts', function (): void {

	// Custom admin assets
	wp_enqueue_style(
		'admin-css',
		plugins_url( '../assets/css/admin-styles.css', __FILE__ )
	);
	wp_enqueue_script(
		'admin-script',
		plugins_url( '../assets/js/admin-scripts.js', __FILE__ ),
		[ 'jquery' ],
		'1.0',
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
			// Enqueue scripts/styles specific to Preview page
			break;

		default:
			// No specific assets for other admin pages
			break;
	}
} );



/*
 *
	wp_enqueue_style(
		'admin-preview-css',
		plugins_url( '../assets/admin-preview.css', __FILE__ )
	);

	wp_enqueue_script(
		'admin-color-script',
		plugins_url( '../assets/ColorManipulator.js', __FILE__ ),
		[ 'jquery' ],
		'1.0',
		true
	);

	wp_enqueue_script(
		'admin-image-script',
		plugins_url( '../assets/ImageManipulator.js', __FILE__ ),
		[ 'jquery' ],
		'1.0',
		true
	);
	// TODO Remove jquery dependency
	*/