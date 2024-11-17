<?php

include_once "page-not-found.php";

// Register the shortcode
add_shortcode('lnb',function ($atts) {
	$atts = shortcode_atts(['id' => 0], $atts, 'lnb');
	$group_id = intval($atts['id']);
	//$group = lnb_get_
	$grouped_links = lnb_get_all_links_grouped_by_category($group_id);

	// Empty check
	if(empty($grouped_links)) {
		not_found_page(1);
		return null;
	}

	// For now, just print_r the results
	ob_start(); // Start output buffering
	echo '<pre>';
	print_r($grouped_links);
	echo '</pre>';
	return ob_get_clean();
});

add_action('wp', function() {
	$current_post = get_post();

	if ($current_post && has_shortcode($current_post->post_content, 'lnb')) {
		echo "Shortcode is loaded!";
	} else {
		echo "Shortcode is not loaded.";
	}
});
