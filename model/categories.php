<?php

/**
 *  Categories
 */

/*************************************
 *                Create             *
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

/*************************************
 *                Delete             *
 ************************************/
