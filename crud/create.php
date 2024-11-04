<?php

/*************************************
 *                Links              *
 ************************************/

/*************************************
 *             Categories            *
 ************************************/

/**
 * Add a new category with a specified name.
 *
 * This function inserts a new category into the 'lnb_categories' table with the provided
 * category name. It returns the ID of the inserted row on success, or false on failure.
 *
 * @param string $category_name The name of the new category to add.
 *
 * @return mysqli_result|bool|int|null The ID of the inserted category on success, false on failure, or null if no rows affected.
 *@global wpdb $wpdb WordPress database access object.
 *
 */

function lnb_add_category(string $category_name): mysqli_result|bool|int|null
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->insert($table_categories, ['name' => $category_name], ['%s']);
}