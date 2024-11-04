<?php

/*************************************
 *                Links              *
 ************************************/

/*************************************
 *             Categories            *
 ************************************/

/**
 * Update the name of a specific category.
 *
 * This function updates the 'name' of a category in the 'lnb_categories' table
 * based on the provided category ID. It returns the number of rows affected on success,
 * or false on failure.
 *
 * @param int $category_id   The ID of the category to update.
 * @param string $category_name The new name for the category.
 *
 * @return mysqli_result|bool|int|null The number of rows affected, false on failure, or null if no rows affected.
 *@global wpdb $wpdb WordPress database access object.
 *
 */

function lnb_update_category(int $category_id, string $category_name): mysqli_result|bool|int|null {
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->update($table_categories, ['name' => $category_name], ['id' => $category_id], ['%s'], ['%d']);
}