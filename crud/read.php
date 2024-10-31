<?php

// Function to get paginated and sorted links data with category name
function get_link_list($page_num = 1, $per_page = 10, $sort_by = 'id', $sort_order = 'ASC'): array|object|null
{
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    // Sanitize and validate sort options
    $allowed_sort_by = ['id', 'link_name', 'category', 'hit_num'];
    $sort_by = in_array($sort_by, $allowed_sort_by) ? $sort_by : 'id';
    $sort_order = strtoupper($sort_order) === 'DESC' ? 'DESC' : 'ASC';

    $page_num = max($page_num, 1);
    $per_page = max($per_page, 1);

    // Calculate offset for pagination
    $offset = ($page_num - 1) * $per_page;

    // Query to get paginated and sorted links with the category name
    $sql = $wpdb->prepare(
        "
        SELECT l.id, l.link_name, l.category, l.hit_num, l.url, c.name AS category_name
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

// Function to get the total count of links for pagination
function get_link_count(): int
{
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';

    // Query to count all links
    $sql = "SELECT COUNT(*) FROM $table_links";

    return (int) $wpdb->get_var($sql);
}

function get_link_details_by_id($link_id) {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    $query = $wpdb->prepare("
        SELECT links.*, categories.name AS category_name
        FROM $table_links AS links
        LEFT JOIN $table_categories AS categories ON links.category = categories.id
        WHERE links.id = %d
    ", $link_id);

    return $wpdb->get_row($query);
}

function get_category_list() {
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $query = "SELECT id, name FROM $table_categories";
    return $wpdb->get_results($query);
}

function get_category_usage_count($category_id) {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $query = $wpdb->prepare("SELECT COUNT(*) FROM $table_links WHERE category = %d", $category_id);
    return $wpdb->get_var($query);
}

function get_all_links_grouped_by_category(): array {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    // Query to get all links with the category name
    $sql = "
        SELECT l.id, l.link_name, l.category, l.hit_num, l.url, c.name AS category_name
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category = c.id
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