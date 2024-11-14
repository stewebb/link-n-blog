<?php

/**
 *  Links
 */

/*************************************
 *                Create             *
 ************************************/

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

/*************************************
 *                Delete             *
 ************************************/
