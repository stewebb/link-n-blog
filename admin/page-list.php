<?php

require_once(plugin_dir_path(__FILE__) . '../model/links.php');
require_once(plugin_dir_path(__FILE__) . '../model/groups.php');

// Helper function to generate table headers with sorting links
function generate_sortable_header($column_name, $sort_field, $current_sort_by, $current_sort_order, $page_num, $group_id): string
{
	$new_sort_order = $current_sort_order === 'ASC' ? 'DESC' : 'ASC';
	$is_current_sort = $sort_field === $current_sort_by;

	// Choose arrow symbol based on current sorting order
	$sort_symbol = '';
	if ($is_current_sort) {
		$sort_symbol = $current_sort_order === 'ASC' ? ' ▲' : ' ▼';
	}

	return "<th scope='col' class='" . ($is_current_sort ? 'sorted ' . strtolower($current_sort_order) : '') . "'>
                <a href='?page=link-n-blog&sort_by=$sort_field&sort_order=$new_sort_order&page_num=$page_num&group_id=$group_id'>
                    $column_name $sort_symbol
                </a>
            </th>";
}

// Function to display the link list page in the admin panel with pagination and sorting
function link_list_page(): void
{
	$page_num = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
	$sort_by = $_GET['sort_by'] ?? 'id';
	$sort_order = $_GET['sort_order'] ?? 'ASC';
	$per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 25;
	$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;

	// Retrieve the paginated, sorted links data
	$links = lnb_get_link_list($page_num, $per_page, $sort_by, $sort_order, $group_id);
    $groups = lnb_get_group_list();

	// Calculate total pages
	$total_items = lnb_get_link_count($group_id);
	$total_pages = ceil($total_items / $per_page);

	// Group the links by group_id to calculate rowspans
	$group_counts = [];
	$unique_groups = [];

	foreach ($links as $link) {
		$group_counts[$link->group_id] = ($group_counts[$link->group_id] ?? 0) + 1;

		// Ensure unique group_id and group_name mapping
		if (!isset($unique_groups[$link->group_id])) {
			$unique_groups[$link->group_id] = $link->group_name;
		}
	}

	// Calculate unique background colors for each group based on HSV color space
	$group_colors = [];
	foreach ($unique_groups as $ug_id => $ug_name) {

		// Concatenate group_id and group_name
		$concat_string = "id={$ug_id}, name={$ug_name}";

		// Generate hue from concatenated string
		$hue = crc32($concat_string) % 360;
		$group_colors[$ug_id] = [
			'primary' => "hsl($hue, 70%, 90%)",     // Light pastel based on hue
			'secondary' => "rgb(248, 248, 248)",    // Fixed light gray
			'tertiary' => "hsl($hue, 50%, 30%)"     // Dark color for the group name column
		];
	}
	?>

    <div class="wrap">
        <h1 class="wp-heading-inline">Link List</h1>
        <hr class="wp-header-end mb-3">

        <!-- Group and Per Page Selector Container -->
        <div class="selectors-container">

            <!-- Group Selector -->
            <div class="group-selector">
                <form method="GET">
                    <input type="hidden" name="page" value="link-n-blog">
                    <label for="group_id">Filter by Group:</label>
                    <select name="group_id" id="group_id" onchange="this.form.submit()">
                        <option value="0" <?= ($group_id == 0) ? 'selected' : '' ?>>All Groups</option>
					    <?php foreach ($groups as $group): ?>
                            <option value="<?= $group->id ?>" <?= $group->id == $group_id ? 'selected' : '' ?>>
							    <?= esc_html($group->name) ?>
                            </option>
					    <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Per Page Selector -->
            <div class="per-page-selector">
                <form method="GET">
                    <input type="hidden" name="page" value="link-n-blog">
                    <label for="per_page">Links per page:</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()">
					    <?php foreach ([10, 25, 50, 100] as $count): ?>
                            <option value="<?= $count ?>" <?= $count === $per_page ? 'selected' : '' ?>><?= $count ?></option>
					    <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>


        <table class="widefat fixed table-view-list">
            <thead>
            <tr>
                <th scope="col">Group</th>
	            <?= generate_sortable_header('ID', 'id', $sort_by, $sort_order, $page_num, $group_id); ?>
	            <?= generate_sortable_header('Name', 'link_name', $sort_by, $sort_order, $page_num, $group_id); ?>
	            <?= generate_sortable_header('Display', 'display', $sort_by, $sort_order, $page_num, $group_id); ?>
                <th scope="col">Cover Image</th>
	            <?= generate_sortable_header('Category', 'category', $sort_by, $sort_order, $page_num, $group_id); ?>
	            <?= generate_sortable_header('Hit Num', 'hit_num', $sort_by, $sort_order, $page_num, $group_id); ?>
            </tr>
            </thead>

            <tbody>
            <?php if ($links): ?>
                <?php
                $last_group_id = null;
                $row_index = 0;

                foreach ($links as $link):

                    // Check if we're in a new group and reset row index
                    if ($link->group_id !== $last_group_id) {
                        $row_index = 0; // Reset row index for alternating colors
                    }

                    // Choose color based on row index for striping effect
                    $background_color = $group_colors[$link->group_id][$row_index % 2 === 0 ? 'primary' : 'secondary'];
                    ?>

                    <tr style="background-color: <?= $background_color; ?>;">

                        <!-- Group cell with color background (only display once per group) -->
                        <?php if ($link->group_id !== $last_group_id): ?>
                            <td rowspan="<?= $group_counts[$link->group_id]; ?>"
                                style="background-color: <?= $group_colors[$link->group_id]['tertiary']; ?>; color: white;">
                                <strong><?= esc_html($link->group_name); ?></strong>
                            </td>
                            <?php $last_group_id = $link->group_id; // Update last group after rendering group cell ?>
                        <?php endif; ?>

                        <!-- ID -->
                        <td>
                            <a href="admin.php?page=link-n-blog-details&id=<?= esc_attr($link->id) ?>">
                                <?= esc_html($link->id) ?>
                            </a>
                        </td>

                        <!-- Name -->
                        <td>
                            <div class="color-block" style="background-color: <?= esc_attr($link->color) ?>;">
                                <span class="color-hex"><?= esc_html($link->color) ?></span>
                            </div>

                            <a class="row-title" href="<?= esc_attr($link->url) ?>" target="_blank">
                                <strong><?= esc_html($link->link_name) ?></strong>
                                <span class="dashicons dashicons-external"></span>
                            </a>
                        </td>

                        <!-- Display -->
                        <td>
                            <?php
                            if ($link->display > 0) {
                                $badge_text = 'N & L';
                                $badge_class = 'badge-primary';
                            } elseif ($link->display == 0) {
                                $badge_text = 'N';
                                $badge_class = 'badge-secondary';
                            } else {
                                $badge_text = 'H';
                                $badge_class = 'badge-dark';
                            }
                            ?>
                            <span class="badge <?= esc_attr($badge_class); ?>"><?= esc_html($badge_text); ?></span>
                        </td>

                        <!-- Cover Image -->
                        <td>
                            <?php if ($link->cover_image_id): ?>
                                <?= wp_get_attachment_image($link->cover_image_id, [100, 100]); ?>
                            <?php else: ?>
                                <span class="text-gray">N/A</span>
                            <?php endif; ?>
                        </td>

                        <!-- Category -->
                        <td>
                            <?= !empty($link->category_name) ? esc_html($link->category_name) : '<span class="text-gray">Uncategorized</span>' ?>
                        </td>

                        <!-- Hit Num -->
                        <td><?= esc_html($link->hit_num) ?></td>
                    </tr>
                    <?php $row_index++; // Increment row index for the next row ?>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="8">No links found.</td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>

        <!-- Total Links Count -->
        <div class="total-links mt-3">
            <p><strong>Total Links:</strong> <?= $total_items ?></p>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <ul class="pagination-links">

                <!-- Previous Button -->
                <li>
                    <?php if ($page_num > 1): ?>
                        <a href="?page=link-n-blog&page_num=<?= max(1, $page_num - 1) ?>&per_page=<?= $per_page ?>&sort_by=<?= esc_attr($sort_by) ?>&sort_order=<?= esc_attr($sort_order) ?>"
                           class="button">Prev</a>
                    <?php else: ?>
                        <span class="button disabled">Prev</span>
                    <?php endif; ?>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <a href="?page=link-n-blog&page_num=<?= $i ?>&per_page=<?= $per_page ?>&sort_by=<?= esc_attr($sort_by) ?>&sort_order=<?= esc_attr($sort_order) ?>"
                           class="button <?= $i == $page_num ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li>
                    <?php if ($page_num < $total_pages): ?>
                        <a href="?page=link-n-blog&page_num=<?= min($total_pages, $page_num + 1) ?>&per_page=<?= $per_page ?>&sort_by=<?= esc_attr($sort_by) ?>&sort_order=<?= esc_attr($sort_order) ?>"
                           class="button">Next</a>
                    <?php else: ?>
                        <span class="button disabled">Next</span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>

    </div>
    <?php
}
?>
