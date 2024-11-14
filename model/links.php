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
 * Retrieve a paginated and sorted list of links grouped by group ID along with their category names.
 *
 * This function fetches links from the 'lnb_links' table, joining the 'lnb_categories'
 * table to include the category name. It allows sorting by specific fields and paginates
 * the results based on the page number and items per page.
 *
 * @param int $page_num The page number for pagination. Defaults to 1.
 * @param int $per_page The number of items to display per page. Defaults to 10.
 * @param string $sort_by The column by which to sort the results. Allowed values: 'id', 'link_name', 'category', 'hit_num'. Defaults to 'id'.
 * @param string $sort_order The sort order. Allowed values: 'ASC' or 'DESC'. Defaults to 'ASC'.
 *
 * @return array|object|null The result set of links with category names as an array or object on success, null on failure.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_get_link_list(int $page_num = 1, int $per_page = 10, string $sort_by = 'id', string $sort_order = 'ASC'): array|object|null
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

    // Query to get paginated and sorted links with the category name, grouped by group_id
    $sql = $wpdb->prepare(
        "
        SELECT l.*, c.name AS category_name
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category_id = c.id
        GROUP BY l.group_id
        ORDER BY l.$sort_by $sort_order
        LIMIT %d OFFSET %d
        ",
        $per_page,
        $offset
    );

    return $wpdb->get_results($sql);
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

    // Update existing link data
    $result = $wpdb->update(
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

    return $result;
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