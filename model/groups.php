<?php

/**
 *  Groups
 */

/*************************************
 *                Create             *
 ************************************/

/*************************************
 *                Read               *
 ************************************/

/**
 * Retrieve a list of all groups.
 *
 * This function fetches all groups from the 'lnb_groups' table,
 * returning each group's ID and name. Useful for populating group
 * dropdowns or filter options.
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @return array|object|null The list of groups as an array or object on success, null on failure.
 */

function lnb_get_group_list(): array|object|null {
    global $wpdb;
    $table_groups = $wpdb->prefix . 'lnb_groups';
    $query = "SELECT * FROM $table_groups";
    return $wpdb->get_results($query);
}


/*************************************
 *                Update             *
 ************************************/

/*************************************
 *                Delete             *
 ************************************/
