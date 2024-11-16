<?php

// Check if the content contains the `[lnb id=...]` shortcode
function lnb_has_shortcode(): bool {
	global $post;

	// Function to detect the `[lnb id=...]` shortcode pattern
	$shortcode_pattern = '/\[lnb\s+id=[\'"]?\d+[\'"]?\]/';

	// Check for admin pages
	if (is_admin()) {
		$screen = get_current_screen();

		// In admin, retrieve the content of the current post being edited
		if ($screen && isset($_GET['post'])) {
			$post = get_post((int) $_GET['post']);
		}
	}

	// Check if post content matches the shortcode pattern
	return $post && preg_match($shortcode_pattern, $post->post_content ?? '');
}


// Enqueue public pages assets via shortcode
add_action('wp_enqueue_scripts', function (): void {


	if (lnb_has_shortcode()) {
		// Enqueue local Bootstrap CSS
		wp_enqueue_style(
			'bootstrap-css',
			plugins_url('../assets/bootstrap.min.css', __FILE__)
		);

		// Enqueue your custom styles for public pages
		wp_enqueue_style(
			'link-n-blog-public-css',
			plugins_url('../assets/public-styles.css', __FILE__)
		);

		// Enqueue local Bootstrap JS
		wp_enqueue_script(
			'bootstrap-js',
			plugins_url('../assets/bootstrap.bundle.min.js', __FILE__),
			['jquery'],
			'5.3.0-alpha1',
			true
		);

		// Enqueue your custom scripts for public pages
		wp_enqueue_script(
			'link-n-blog-public-js',
			plugins_url('../assets/public-scripts.js', __FILE__),
			['jquery'],
			'1.0',
			true
		);
	}
});

// Enqueue admin styles and conditionally enqueue scripts
add_action('admin_enqueue_scripts', function (): void {
	// Custom admin assets
	wp_enqueue_style(
		'admin-css',
		plugins_url('../assets/admin-styles.css', __FILE__)
	);
	wp_enqueue_script(
		'admin-script',
		plugins_url('../assets/admin-scripts.js', __FILE__),
		['jquery'],
		'1.0',
		true
	);

	// WordPress pickers
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('wp-color-picker');
	wp_enqueue_media();

	// Conditionally enqueue scripts based on admin page
	global $hook_suffix;

	switch ($hook_suffix) {
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
});



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