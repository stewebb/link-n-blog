<?php

/**
 *  Links
 */

/*************************************
 *                Create             *
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
            'category_id' => $link_data['category'] > 0 ? $link_data['category'] : null,
            'group_id' => $link_data['group'] > 0 ? $link_data['group'] : null,
            'url' => $link_data['url'],
            'wp_page_id' => $link_data['wp_page_id'],
            'target' => $link_data['target'],
            'color' => $link_data['color'],
            'cover_image_id' => $link_data['cover_image_id'],
            'display' => $link_data['display'],
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql'),
        ],
        [
            '%s', '%s', '%d', '%d', '%s', '%d', '%s', '%s', '%d', '%d', '%s', '%s'
        ]
    );
}

/*************************************
 *                Read               *
 ************************************/

/**
 * Retrieve a paginated and sorted list of links organized by group ID along with their group and category names.
 *
 * This function fetches links from the 'lnb_links' table, joining the 'lnb_categories'
 * table to include the category name and the 'lnb_groups' table to include the group name.
 * It allows sorting by specific fields and paginates the results based on the page number and items per page.
 *
 * @param int $page_num The page number for pagination. Defaults to 1.
 * @param int $per_page The number of items to display per page. Defaults to 10.
 * @param string $sort_by The column by which to sort the results within each group. Allowed values: 'id', 'link_name', 'category_id', 'hit_num'. Defaults to 'id'.
 * @param string $sort_order The sort order within each group. Allowed values: 'ASC' or 'DESC'. Defaults to 'ASC'.
 * @param int|null $group_id The group ID to filter by. If null or empty, no filtering by group_id is applied.
 *
 * @return array|object|null The result set of links with group and category names as an array or object on success, null on failure.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_get_link_list(int $page_num = 1, int $per_page = 10, string $sort_by = 'id', string $sort_order = 'ASC', ?int $group_id = null): array|object|null
{
	global $wpdb;
	$table_links = $wpdb->prefix . 'lnb_links';
	$table_categories = $wpdb->prefix . 'lnb_categories';
	$table_groups = $wpdb->prefix . 'lnb_groups'; // Assuming 'lnb_groups' is the table for groups

	// Sanitize and validate sort options
	$allowed_sort_by = ['id', 'link_name', 'category_id', 'hit_num'];
	$sort_by = in_array($sort_by, $allowed_sort_by) ? $sort_by : 'id';
	$sort_order = strtoupper($sort_order) === 'DESC' ? 'DESC' : 'ASC';

	$page_num = max($page_num, 1);
	$per_page = max($per_page, 1);

	// Calculate offset for pagination
	$offset = ($page_num - 1) * $per_page;

	// Start building the query
	$query = "
        SELECT l.*, 
               c.name AS category_name, c.color AS category_color,
               g.name AS group_name, g.disabled AS group_disabled
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category_id = c.id
        LEFT JOIN $table_groups AS g ON l.group_id = g.id
    ";

	// Add a WHERE clause if group_id is provided
	$where_clause = '';
	if (!empty($group_id) && $group_id > 0) {
		$where_clause = $wpdb->prepare("WHERE l.group_id = %d", $group_id);
	}

	// Complete the query with sorting and pagination
	$query .= "
        $where_clause
        ORDER BY l.group_id, l.$sort_by $sort_order
        LIMIT %d OFFSET %d
    ";

	// Prepare and execute the query
	$sql = $wpdb->prepare($query, $per_page, $offset);
	return $wpdb->get_results($sql);
}

/**
 * Retrieve details of a specific link by its ID, including the category and group names.
 *
 * This function fetches a single link record from the 'lnb_links' table, joining
 * the 'lnb_categories' and 'lnb_groups' tables to include the category and group names.
 * It returns detailed information about the link, such as the link name, category, group,
 * URL, and other metadata.
 *
 * @param int $link_id The ID of the link to retrieve.
 *
 * @return object|array|null The link details as an object or array on success, null on failure or if not found.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_get_link_details_by_id(int $link_id): object|array|null {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $table_groups = $wpdb->prefix . 'lnb_groups';

    $query = $wpdb->prepare("
        SELECT links.*, 
               categories.name AS category_name, 
               groups.name AS group_name
        FROM $table_links AS links
        LEFT JOIN $table_categories AS categories ON links.category_id = categories.id
        LEFT JOIN $table_groups AS groups ON links.group_id = groups.id
        WHERE links.id = %d
    ", $link_id);

    return $wpdb->get_row($query);
}

/**
 * Retrieve the total count of links for pagination.
 *
 * This function counts the total number of links in the 'lnb_links' table,
 * optionally filtered by a specific group ID.
 *
 * @param int|null $group_id The group ID to filter by. If null, count all links.
 * @global wpdb $wpdb WordPress database access object.
 *
 * @return int The total count of links.
 */

function lnb_get_link_count(?int $group_id = null): int {
	global $wpdb;
	$table_links = $wpdb->prefix . 'lnb_links';

	// Base query to count links
	$sql = "SELECT COUNT(*) FROM $table_links";

	// Add WHERE clause if a group_id is provided
	if (!is_null($group_id) && $group_id > 0) {
		$sql .= $wpdb->prepare(" WHERE group_id = %d", $group_id);
	}

	return (int) $wpdb->get_var($sql);
}

/**
 * Retrieve the IDs and names of links associated with a specific category.
 *
 * This function fetches the 'id' and 'name' of each link in the 'lnb_links' table
 * that belong to a given category. Useful for listing links in a category or further processing.
 *
 * @param int $category_id The ID of the category to fetch links for.
 *
 * @return array|null An array of objects with 'id' and 'name' of each link on success, or null on failure.
 * @global wpdb $wpdb WordPress database access object.
 */


function lnb_get_links_by_category(int $category_id): ?array {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $query = $wpdb->prepare("SELECT id, link_name FROM $table_links WHERE category_id = %d", $category_id);
    return $wpdb->get_results($query);
}

/**
 * Retrieve the IDs and names of links associated with a specific group.
 *
 * This function fetches the 'id' and 'name' of each link in the 'lnb_links' table
 * that belong to a given group. Useful for listing links in a group or further processing.
 *
 * @param int $group_id The ID of the group to fetch links for.
 *
 * @return array|null An array of objects with 'id' and 'name' of each link on success, or null on failure.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_get_links_by_group(int $group_id): ?array {
	global $wpdb;
	$table_links = $wpdb->prefix . 'lnb_links';
	$query = $wpdb->prepare("SELECT id, link_name FROM $table_links WHERE group_id = %d", $group_id);
	return $wpdb->get_results($query);
}

/**
 * Retrieve all links grouped by their respective categories.
 *
 * This function fetches all links from the 'lnb_links' table, joining the 'lnb_categories'
 * and 'lnb_groups' tables to include the category and group details. It then groups the
 * links by category, with links having no category assigned to "Uncategorized".
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @param int $group_id The ID of the group to filter by.
 * @return array An associative array where keys are category names and values are arrays of links in each category.
 */

function lnb_get_all_links_grouped_by_category(int $group_id): array {
	global $wpdb;
	$table_links = $wpdb->prefix . 'lnb_links';
	$table_categories = $wpdb->prefix . 'lnb_categories';
	$table_groups = $wpdb->prefix . 'lnb_groups';

	// Query to get all links with the category and group details
	$sql = $wpdb->prepare("
        SELECT l.id, l.link_name, l.label_text, l.cover_image_id, l.target, l.wp_page_id, l.color, l.category_id, l.hit_num, l.url, 
               c.name AS category_name
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category_id = c.id
        LEFT JOIN $table_groups AS g ON c.group_id = g.id
        WHERE g.id = %d AND g.disabled = 0
    ", $group_id);

	$links = $wpdb->get_results($sql);

	// Group links by category
	$grouped_links = [];
	foreach ($links as $link) {
		$category = $link->category_name ?? "Uncategorized";
		$grouped_links[$category][] = $link;
	}

	return $grouped_links;
}


/*************************************
 *                Update             *
 ************************************/

/**
 * Updates an existing link in the wp_lnb_links table.
 *
 * @param int $link_id The ID of the link to update.
 * @param array $link_data The updated data for the link.
 *
 * @return int|false The number of rows affected, or false on error.
 */

function lnb_update_link(int $link_id, array $link_data): bool|int
{
    global $wpdb;
	return $wpdb->update(
	    'wp_lnb_links',
	    [
	        'link_name' => $link_data['link_name'],
	        'label_text' => $link_data['label_text'],
	        'category_id' => $link_data['category'] > 0 ? $link_data['category'] : null,
	        'group_id' => $link_data['group'] > 0 ? $link_data['group'] : null,  // New 'group' field
	        'url' => $link_data['url'],
	        'wp_page_id' => $link_data['wp_page_id'],
	        'target' => $link_data['target'],
	        'color' => $link_data['color'],
	        'cover_image_id' => $link_data['cover_image_id'],
	        'display' => $link_data['display'],
	        'updated_at' => current_time('mysql'),
	    ],
	    [ 'id' => $link_id ],
	    [
	        '%s', '%s', '%d', '%d', '%s', '%d', '%s', '%s', '%d', '%d', '%s'
	    ],
	    [ '%d' ]
	);
}

/*************************************
 *                Delete             *
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

function lnb_delete_link(int $link_id): int|false
{
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    return $wpdb->delete($table_links, ['id' => $link_id], ['%d']);
}