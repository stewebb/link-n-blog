<?php

/*************************************
 *                Links              *
 ************************************/

function update_link($link_id, $link_data) {
    global $wpdb;

    // Update existing link data
    $result = $wpdb->update(
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
            'updated_at' => current_time('mysql'),
        ],
        [ 'id' => $link_id ],
        [
            '%s', '%s', '%d', '%s', '%d', '%s', '%s', '%d', '%s'
        ],
        [ '%d' ]
    );

    return $result;
}


/*************************************
 *             Categories            *
 ************************************/

/**
 * Update the name and color of a specific category.
 *
 * This function updates the 'name' and 'color' of a category in the 'lnb_categories' table
 * based on the provided category ID. It returns the number of rows affected on success,
 * or false on failure.
 *
 * @param int $category_id The ID of the category to update.
 * @param string $category_name The new name for the category.
 * @param string $color The new color for the category.
 *
 * @return mysqli_result|bool|int|null The number of rows affected, false on failure, or null if no rows affected.
 * @global wpdb $wpdb WordPress database access object.
 *
 */

function lnb_update_category(int $category_id, string $category_name, string $color): mysqli_result|bool|int|null {
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->update(
        $table_categories,
        ['name' => $category_name, 'color' => $color],
        ['id' => $category_id],
        ['%s', '%s'],
        ['%d']
    );
}
