<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');

// Helper function to generate table headers with sorting links
function generate_sortable_header($column_name, $sort_field, $current_sort_by, $current_sort_order, $page_num): string
{
    $new_sort_order = $current_sort_order === 'ASC' ? 'DESC' : 'ASC';
    $is_current_sort = $sort_field === $current_sort_by;

    // Choose arrow symbol based on current sorting order
    $sort_symbol = '';
    if ($is_current_sort) {
        $sort_symbol = $current_sort_order === 'ASC' ? ' ▲' : ' ▼';
    }

    return "<th scope='col' class='" . ($is_current_sort ? 'sorted ' . strtolower($current_sort_order) : '') . "'>
                <a href='?page=link-n-blog&sort_by=$sort_field&sort_order=$new_sort_order&page_num=$page_num'>
                    $column_name $sort_symbol
                </a>
            </th>";
}

// Function to display the link list page in the admin panel with pagination and sorting
function page_lnb_list(): void
{
    $page_num = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
    $sort_by = $_GET['sort_by'] ?? 'id';
    $sort_order = $_GET['sort_order'] ?? 'ASC';
    $per_page = 10;

    // Retrieve the paginated, sorted links data
    $links = get_lnb_links($page_num, $per_page, $sort_by, $sort_order);

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Link List</h1>
        <a href="admin.php?page=link-n-blog-details" class="page-title-action">Add New</a>
        <hr class="wp-header-end">

        <table class="widefat fixed striped table-view-list">
            <thead>
            <tr>
                <?= generate_sortable_header('ID', 'id', $sort_by, $sort_order, $page_num); ?>
                <?= generate_sortable_header('Name', 'link_name', $sort_by, $sort_order, $page_num); ?>
                <?= generate_sortable_header('Category', 'category', $sort_by, $sort_order, $page_num); ?>
                <?= generate_sortable_header('Hit Num', 'hit_num', $sort_by, $sort_order, $page_num); ?>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($links): ?>
                <?php foreach ($links as $link): ?>
                    <tr>
                        <td><?= esc_html($link->id) ?></td>
                        <td>
                            <strong><a class="row-title" href="admin.php?page=link-n-blog-details&id=<?= esc_attr($link->id) ?>"><?= esc_html($link->link_name) ?></a></strong>
                        </td>
                        <td>
                            <?= !empty($link->category_name) ? esc_html($link->category_name) : '<span class="text-light-gray">Uncategorized</span>' ?>
                        </td>
                        <td>
                            <a href="<?= esc_url($link->hit_num) ?>" target="_blank"><?= esc_html($link->hit_num) ?></a>
                        </td>
                        <td>
                            <a href="admin.php?page=link-n-blog-details&id=<?= esc_attr($link->id) ?>" class="button-link">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No links found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="tablenav">
            <div class="tablenav-pages">
                <?php if ($page_num > 1): ?>
                    <a href="?page=link-n-blog&page_num=<?= $page_num - 1 ?>&sort_by=<?= esc_attr($sort_by) ?>&sort_order=<?= esc_attr($sort_order) ?>" class="button">Previous</a>
                <?php endif; ?>
                <span class="pagination-links">
                    <span>Page <?= esc_html($page_num) ?></span>
                </span>
                <a href="?page=link-n-blog&page_num=<?= $page_num + 1 ?>&sort_by=<?= esc_attr($sort_by) ?>&sort_order=<?= esc_attr($sort_order) ?>" class="button">Next</a>
            </div>
        </div>
    </div>
    <?php
}
