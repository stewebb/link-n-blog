<?php

// Register the shortcode
add_shortcode('lnb',function ($atts) {
	$atts = shortcode_atts(['id' => 0], $atts, 'lnb');
	$group_id = intval($atts['id']);
	$grouped_links = lnb_get_all_links_grouped_by_category($group_id);

	// For now, just print_r the results
	ob_start(); // Start output buffering
	echo '<pre>';
	print_r($grouped_links);
	echo '</pre>';
	return ob_get_clean();
});
