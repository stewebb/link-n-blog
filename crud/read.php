<?php

// Function to get paginated and sorted links data with category name
function get_lnb_links($page_num = 1, $per_page = 10, $sort_by = 'id', $sort_order = 'ASC'): array|object|null
{
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    // Sanitize and validate sort options
    $allowed_sort_by = ['id', 'link_name', 'category', 'hit_num'];
    $sort_by = in_array($sort_by, $allowed_sort_by) ? $sort_by : 'id';
    $sort_order = strtoupper($sort_order) === 'DESC' ? 'DESC' : 'ASC';

    // Calculate offset for pagination
    $offset = ($page_num - 1) * $per_page;

    // Query to get paginated and sorted links with the category name
    $sql = $wpdb->prepare(
        "
        SELECT l.id, l.link_name, l.category, l.hit_num, c.name AS category_name
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category = c.id
        ORDER BY l.$sort_by $sort_order
        LIMIT %d OFFSET %d
        ",
        $per_page,
        $offset
    );

    return $wpdb->get_results($sql);
}
