<?php

/*************************************
 *                Links              *
 ************************************/

/**
 * Retrieve a paginated and sorted list of links along with their category names.
 *
 * This function fetches links from the 'lnb_links' table, joining the 'lnb_categories'
 * table to include the category name. It allows sorting by specific fields and paginates
 * the results based on the page number and items per page.
 *
 * @param int $page_num   The page number for pagination. Defaults to 1.
 * @param int $per_page   The number of items to display per page. Defaults to 10.
 * @param string $sort_by The column by which to sort the results. Allowed values: 'id', 'link_name', 'category', 'hit_num'. Defaults to 'id'.
 * @param string $sort_order The sort order. Allowed values: 'ASC' or 'DESC'. Defaults to 'ASC'.
 *
 * @return array|object|null The result set of links with category names as an array or object on success, null on failure.
 *@global wpdb $wpdb     WordPress database access object.
 *
 */

/*
function lnb_get_link_list(int $page_num = 1, int $per_page = 10, string $sort_by = 'id', string $sort_order = 'ASC'): array|object|null {
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

    // Query to get paginated and sorted links with the category name
    $sql = $wpdb->prepare(
        "
        SELECT l.*, c.name AS category_name
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category_id = c.id
        ORDER BY l.$sort_by $sort_order
        LIMIT %d OFFSET %d
        ",
        $per_page,
        $offset
    );

    return $wpdb->get_results($sql);
}
*/
/**
 * Retrieve details of a specific link by its ID, including the category name.
 *
 * This function fetches a single link record from the 'lnb_links' table, joining
 * the 'lnb_categories' table to include the category name. It returns detailed information
 * about the link, such as the link name, category, URL, and other metadata.
 *
 * @param int $link_id The ID of the link to retrieve.
 *
 * @return object|array|null The link details as an object or array on success, null on failure or if not found.
 *@global wpdb $wpdb  WordPress database access object.
 *
 */

/*
function lnb_get_link_details_by_id(int $link_id): object|array|null {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    $query = $wpdb->prepare("
        SELECT links.*, categories.name AS category_name
        FROM $table_links AS links
        LEFT JOIN $table_categories AS categories ON links.category = categories.id
        WHERE links.id = %d
    ", $link_id);

    return $wpdb->get_row($query);
}
*/

/**
 * Retrieve the total count of links for pagination.
 *
 * This function counts the total number of links in the 'lnb_links' table.
 * It is useful for determining the total number of pages needed for pagination.
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @return int The total count of links.
 */

function lnb_get_link_count(): int {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';

    // Query to count all links
    $sql = "SELECT COUNT(*) FROM $table_links";

    return (int) $wpdb->get_var($sql);
}

/*************************************
 *             Categories            *
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

/*
function lnb_get_category_list(): array|object|null {
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $query = "SELECT * FROM $table_categories";
    return $wpdb->get_results($query);
}
*/

/**
 * Retrieve the count of links associated with a specific category.
 *
 * This function counts the number of links in the 'lnb_links' table
 * that belong to a given category. Useful for determining the usage
 * or popularity of each category.
 *
 * @param int $category_id The ID of the category to count links for.
 *
 * @return string|null The count of links as a string on success, or null on failure.
 *@global wpdb $wpdb WordPress database access object.
 *
 */

function lnb_get_category_usage_count(int $category_id): ?string {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $query = $wpdb->prepare("SELECT COUNT(*) FROM $table_links WHERE category = %d", $category_id);
    return $wpdb->get_var($query);
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
    $query = $wpdb->prepare("SELECT id, link_name FROM $table_links WHERE category = %d", $category_id);
    return $wpdb->get_results($query);
}

/**
 * Retrieve all links grouped by their respective categories.
 *
 * This function fetches all links from the 'lnb_links' table, joining the 'lnb_categories'
 * table to include the category name. It then groups the links by category, with links
 * having no category assigned to "Uncategorized".
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @return array An associative array where keys are category names and values are arrays of links in each category.
 */

function lnb_get_all_links_grouped_by_category(): array {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';

    // Query to get all links with the category name
    $sql = "
        SELECT l.id, l.link_name, l.label_text, l.cover_image_id, l.target, l.wp_page_id, l.color, l.category, l.hit_num, l.url, c.name AS category_name
        FROM $table_links AS l
        LEFT JOIN $table_categories AS c ON l.category = c.id
    ";

    $links = $wpdb->get_results($sql);

    // Group links by category
    $grouped_links = [];
    foreach ($links as $link) {
        $category = $link->category_name ?? "Uncategorized";
        $grouped_links[$category][] = $link;
    }

    return $grouped_links;
}

/**
 * Retrieve all uncategorized links.
 *
 * This function fetches all links from the 'lnb_links' table that have no assigned category,
 * returning only the link ID and name.
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @return array An array of uncategorized links, each represented as an associative array with 'id' and 'name' keys.
 */

function lnb_get_uncategorized_links(): array {
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';

    // Query to get uncategorized links (where category is NULL or 0)
    $query = "
        SELECT id, link_name
        FROM $table_links
        WHERE category IS NULL OR category = 0
    ";

    return $wpdb->get_results($query);

    //$uncategorized_items = $wpdb->get_results($sql, ARRAY_A);

    //return $uncategorized_items ?: [];
}

/*************************************
 *               Groups              *
 ************************************/