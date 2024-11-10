<?php

/*************************************
 *                Links              *
 ************************************/

/**
 * Inserts a new link into the wp_lnb_links table.
 *
 * @param array $link_data The data of the new link to add.
 * @return bool True on success, false on failure.
 */
function lnb_add_new_link(array $link_data): bool {
    global $wpdb;

    // Insert new link data
    return $wpdb->insert(
        'wp_lnb_links',
        [
            'link_name' => $link_data['link_name'],
            'label_text' => $link_data['label_text'],
            'category' => $link_data['category'] > 0 ? $link_data['category'] : null,
            'url' => $link_data['url'],
            'wp_page_id' => $link_data['wp_page_id'],
            'target' => $link_data['target'],
            'color' => $link_data['color'],
            'cover_image_id' => $link_data['cover_image_id'],
            'display' => $link_data['display'],  // New 'display' field
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql'),
        ],
        [
            '%s', '%s', '%d', '%s', '%d', '%s', '%s', '%d', '%d', '%s', '%s'
        ]
    );
}

/*************************************
 *             Categories            *
 ************************************/

/**
 * Add a new category with a specified name and color.
 *
 * This function inserts a new category into the 'lnb_categories' table with the provided
 * category name and color. It returns the ID of the inserted row on success, or false on failure.
 *
 * @param string $category_name The name of the new category to add.
 * @param string $color The color associated with the category.
 *
 * @return mysqli_result|bool|int|null The ID of the inserted category on success, false on failure, or null if no rows affected.
 * @global wpdb $wpdb WordPress database access object.
 *
 */

function lnb_add_category(string $category_name, string $color): mysqli_result|bool|int|null
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->insert(
        $table_categories,
        ['name' => $category_name, 'color' => $color],
        ['%s', '%s']
    );
}