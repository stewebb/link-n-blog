<?php

/**
 *  Categories
 */

/*************************************
 *                Create             *
 ************************************/

/*************************************
 *                Read               *
 ************************************/

/**
 * Retrieve a list of all categories.
 *
 * This function fetches all categories from the 'lnb_categories' table,
 * returning each category's ID and name. Useful for populating category
 * dropdowns or filter options.
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @return array|object|null The list of categories as an array or object on success, null on failure.
 */


function lnb_get_category_list(): array|object|null {
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $query = "SELECT * FROM $table_categories";
    return $wpdb->get_results($query);
}

/*************************************
 *                Update             *
 ************************************/

/*************************************
 *                Delete             *
 ************************************/
