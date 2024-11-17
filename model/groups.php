<?php

/**
 *  Groups
 */

/*************************************
 *                Create             *
 ************************************/

/**
 * Add a new group with a specified name and enabled status.
 *
 * This function inserts a new group into the 'lnb_groups' table with the provided
 * group name and enabled status. The `enabled` parameter is internally converted
 * to the `disabled` field (inverse). It returns the ID of the inserted row on success,
 * or false on failure.
 *
 * @param string $group_name The name of the new group to add.
 * @param bool $enabled Whether the group should be enabled (true) or disabled (false).
 *
 * @return mysqli_result|bool|int|null The ID of the inserted group on success, false on failure, or null if no rows affected.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_add_group(string $group_name, bool $enabled): mysqli_result|bool|int|null
{
	global $wpdb;
	$table_groups = $wpdb->prefix . 'lnb_groups';
	$disabled = $enabled ? 0 : 1;

	return $wpdb->insert(
		$table_groups,
		[
			'name' => $group_name,
			'disabled' => $disabled
		],
		['%s', '%d']
	);
}

/*************************************
 *                Read               *
 ************************************/

/**
 * Retrieve a specific group by ID.
 *
 * This function fetches a group from the 'lnb_groups' table
 * based on the provided group ID. Useful for retrieving details
 * of a specific group for editing or display purposes.
 *
 * @global wpdb $wpdb WordPress database access object.
 *
 * @param int $group_id The ID of the group to retrieve.
 * @return object|null The group details as an object on success, null on failure.
 */

function lnb_get_group_by_id(int $group_id): ?object {
	global $wpdb;
	$table_groups = $wpdb->prefix . 'lnb_groups';
	$query = $wpdb->prepare("SELECT * FROM $table_groups WHERE id = %d", $group_id);
	return $wpdb->get_row($query);
}

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

/**
 * Retrieve the count of links associated with a specific group.
 *
 * This function counts the number of links in the 'lnb_links' table
 * that belong to a given group. Useful for determining the usage
 * or popularity of each group.
 *
 * @param int $group_id The ID of the group to count links for.
 *
 * @return string|null The count of links as a string on success, or null on failure.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_get_group_usage_count(int $group_id): ?string {
	global $wpdb;
	$table_links = $wpdb->prefix . 'lnb_links';
	$query = $wpdb->prepare("SELECT COUNT(*) FROM $table_links WHERE group_id = %d", $group_id);
	return $wpdb->get_var($query);
}

/*************************************
 *                Update             *
 ************************************/

/**
 * Update the name and enabled status of a specific group.
 *
 * This function updates the 'name' and 'disabled' status of a group in the 'lnb_groups' table
 * based on the provided group ID. It returns the number of rows affected on success,
 * or false on failure.
 *
 * @param int $group_id The ID of the group to update.
 * @param string $group_name The new name for the group.
 * @param bool $enabled The new enabled status for the group (true for enabled, false for disabled).
 *
 * @return mysqli_result|bool|int|null The number of rows affected, false on failure, or null if no rows affected.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_update_group(int $group_id, string $group_name, bool $enabled): mysqli_result|bool|int|null {
	global $wpdb;
	$table_groups = $wpdb->prefix . 'lnb_groups';
	$disabled = $enabled ? 0 : 1;

	return $wpdb->update(
		$table_groups,
		['name' => $group_name, 'disabled' => $disabled],
		['id' => $group_id],
		['%s', '%d'],
		['%d']
	);
}

/*************************************
 *                Delete             *
 ************************************/

/**
 * Delete a specific group by its ID.
 *
 * This function deletes a group from the 'lnb_groups' table based on
 * the provided group ID. It returns the number of rows affected on success,
 * or false on failure.
 *
 * @param int $group_id The ID of the group to delete.
 *
 * @return mysqli_result|bool|int|null The number of rows affected, false on failure, or null if no rows affected.
 * @global wpdb $wpdb WordPress database access object.
 */

function lnb_delete_group(int $group_id): mysqli_result|bool|int|null
{
	global $wpdb;
	$table_groups = $wpdb->prefix . 'lnb_groups';
	return $wpdb->delete($table_groups, ['id' => $group_id], ['%d']);
}
