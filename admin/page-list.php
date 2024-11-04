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
function link_list_page(): void
{
    $page_num = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
    $sort_by = $_GET['sort_by'] ?? 'id';
    $sort_order = $_GET['sort_order'] ?? 'ASC';
    $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;

    // Retrieve the paginated, sorted links data
    $links = lnb_get_link_list($page_num, $per_page, $sort_by, $sort_order);

    // Calculate total pages
    $total_items = lnb_get_link_count();
    $total_pages = ceil($total_items / $per_page);
    $split_symbol = '&nbsp;<span class="text-light-gray">|</span>&nbsp;';

    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Link List</h1>
        <a href="admin.php?page=link-n-blog-details" class="page-title-action">Add New</a>
        <hr class="wp-header-end">

        <!-- Per Page Selector -->
        <div class="per-page-selector mb-3">
            <form method="GET" style="display: inline;">
                <input type="hidden" name="page" value="link-n-blog">
                <label for="per_page">Links per page:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()">
                    <?php foreach ([10, 20, 50] as $count): ?>
                        <option value="<?= $count ?>" <?= $count === $per_page ? 'selected' : '' ?>><?= $count ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

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
                            <a class="row-title" href="<?= esc_attr($link->url) ?>" target="_blank">
                                <strong><?= esc_html($link->link_name) ?></strong>
                                <span class="dashicons dashicons-external"></span>
                            </a>
                        </td>
                        <td>
                            <?= !empty($link->category_name) ? esc_html($link->category_name) : '<span class="text-light-gray">Uncategorized</span>' ?>
                        </td>
                        <td><?= esc_html($link->hit_num) ?></td>
                        <td>
                            <a href="admin.php?page=link-n-blog-details&id=<?= esc_attr($link->id) ?>"
                               class="button-link">Edit</a><?= $split_symbol; ?>
                            <a href="admin.php?page=link-n-blog-details&id=<?= esc_attr($link->id) ?>"
                               class="button-link">Delete</a>
                            <!--
                            <?= $split_symbol; ?>
                            <a href="<?= esc_attr($link->url) ?>" target="_blank" class="button-link">Visit</a>
                            -->
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
                    <?php if ($i == 1 || $i == $total_pages || ($i >= $page_num - 1 && $i <= $page_num + 1)): ?>
                        <li>
                            <a href="?page=link-n-blog&page_num=<?= $i ?>&per_page=<?= $per_page ?>&sort_by=<?= esc_attr($sort_by) ?>&sort_order=<?= esc_attr($sort_order) ?>"
                               class="button <?= $i == $page_num ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php elseif ($i == 2 || $i == $total_pages - 1): ?>
                        <li><span class="button disabled">...</span></li>
                    <?php endif; ?>
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
