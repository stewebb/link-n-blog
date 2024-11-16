<?php

/**
 * Retrieve all links grouped by their respective categories.
 *
 * This function fetches all links from the 'lnb_links' table, joining the 'lnb_categories'
 * table to include the category name. It then groups the links by category, with links
 * having no category assigned to "Uncategorized".
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @return array An associative array where keys are category names and values are arrays of links in each category.
 */

/**
 * TODO:
 * Modify sql
 * add join lnb_groups on category_id,
 * add a where group id=x && group disabled = 0
 */

/*
function lnb_get_all_links_grouped_by_category(): array {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    // Query to get all links with the category name
    $sql = "
        SELECT l.id, l.link_name, l.label_text, l.cover_image_id, l.target, l.wp_page_id, l.color, l.category_id, l.hit_num, l.url, c.name AS category_name
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category_id = c.id
    ";

    $links = $wpdb->get_results($sql);

    // Group links by category
    $grouped_links = [];
    foreach ($links as $link) {
        $category = $link->category_name ?? "Uncategorized";
        $grouped_links[$category][] = $link;
    }

    return $grouped_links;
}
*/