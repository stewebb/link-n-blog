<?php

include_once "page-links.php";
include_once "page-not-found.php";

// Register the shortcode
add_shortcode('lnb',function ($atts) {
	$atts = shortcode_atts(['id' => 0], $atts, 'lnb');
	$group_id = intval($atts['id']);

	// Get group
	$group = lnb_get_group_by_id($group_id);
	if (empty($group)) {
		return not_found_page(
			"Group Not Found",
			"The group with <b>ID=" . htmlspecialchars($group_id, ENT_QUOTES, 'UTF-8') . "</b> could not be found."
		);
	}

	// Check if the group is disabled
	if ($group->disabled == 1) {
		return not_found_page(
			"Group Disabled",
			"The group <b>" . htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8') . "</b> is currently disabled."
		);
	}

	// Fetch links grouped by category
	$grouped_links = lnb_get_all_links_grouped_by_category($group_id);
	if (empty($grouped_links)) {
		return not_found_page(
			"No Links Found",
			"No links are associated with the group <b>" . htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8') . "</b>."
		);
	}

	return link_page($group, $grouped_links);
});

/*
add_action('wp', function() {
	$current_post = get_post();

	if ($current_post && has_shortcode($current_post->post_content, 'lnb')) {
		echo "Shortcode is loaded!";
	} else {
		echo "Shortcode is not loaded.";
	}
});
*/