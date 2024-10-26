<?php

// Function to get links data from the database, including category name
function get_lnb_links(): array|object|null
{
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    // Query to get links with the category name
    $sql = "
        SELECT l.id, l.link_name, l.label_text, l.category, c.name AS category_name, 
               l.wp_page_id, l.url, l.target, l.color, l.cover_image_id
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category = c.id
    ";

    return $wpdb->get_results($sql);
}
