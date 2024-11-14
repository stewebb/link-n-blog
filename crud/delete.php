<?php

/*************************************
 *                Links              *
 ************************************/

/**
 * Delete a specific link by its ID.
 *
 * This function deletes a link from the 'lnb_links' table based on
 * the provided link ID. It returns the number of rows affected on success,
 * or false on failure.
 *
 * @param int $link_id The ID of the link to delete.
 *
 * @return int|false The number of rows affected, or false on failure.
 * @global wpdb $wpdb WordPress database access object.
 */

/*
function lnb_delete_link(int $link_id): int|false
{
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    return $wpdb->delete($table_links, ['id' => $link_id], ['%d']);
}
*/
/*************************************
 *             Categories            *
 ************************************/

/**
 * Delete a specific category by its ID.
 *
 * This function deletes a category from the 'lnb_categories' table based on
 * the provided category ID. It returns the number of rows affected on success,
 * or false on failure.
 *
 * @param int $category_id The ID of the category to delete.
 *
 * @return mysqli_result|bool|int|null The number of rows affected, false on failure, or null if no rows affected.
 *@global wpdb $wpdb WordPress database access object.
 *
 */

function lnb_delete_category(int $category_id): mysqli_result|bool|int|null
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->delete($table_categories, ['id' => $category_id], ['%d']);
}

/*************************************
 *               Groups              *
 ************************************/