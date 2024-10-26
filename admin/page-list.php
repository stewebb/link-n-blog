<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');

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
        <h1 class="wp-heading-inline">
            Link List&nbsp;
            <a class="button button-secondary" href="admin.php?page=link-n-blog-details">Add New</a>
        </h1>
        <hr class="wp-header-end">

        <table class="widefat fixed striped">
            <thead>
            <tr>
                <th scope="col">
                    <a href="?page=link-n-blog&sort_by=id&sort_order=<?= $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>&page_num=<?= $page_num ?>">ID</a>
                </th>
                <th scope="col">
                    <a href="?page=link-n-blog&sort_by=link_name&sort_order=<?= $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>&page_num=<?= $page_num ?>">Name</a>
                </th>
                <th scope="col">
                    <a href="?page=link-n-blog&sort_by=category&sort_order=<?= $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>&page_num=<?= $page_num ?>">Category</a>
                </th>
                <th scope="col">
                    <a href="?page=link-n-blog&sort_by=category&sort_order=<?= $sort_order === 'ASC' ? 'DESC' : 'ASC' ?>&page_num=<?= $page_num ?>">Hit Num</a>
                </th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($links): ?>
                <?php foreach ($links as $link): ?>
                    <tr>
                        <td><?= $link->id ?></td>
                        <td>
                            <a href="admin.php?page=link-n-blog-details&id=<?= $link->id ?>"><?= $link->link_name ?></a>
                        </td>
                        <td>
                            <?= $link->category_name ?? '<span class="text-light-gray">Uncategorized</span>' ?>
                        </td>
                        <td>
                            <a href="<?= esc_url($link->hit_num) ?>" target="_blank"><?= esc_html($link->hit_num) ?></a>
                        </td>
                        <td>
                            <a href="admin.php?page=link-n-blog-details&id=<?= $link->id ?>">Edit</a>
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
            <?php if ($page_num > 1): ?>
                <a href="?page=link-n-blog&page_num=<?= $page_num - 1 ?>&sort_by=<?= $sort_by ?>&sort_order=<?= $sort_order ?>" class="button">Previous</a>
            <?php endif; ?>
            <span>Page <?= $page_num ?></span>
            <a href="?page=link-n-blog&page_num=<?= $page_num + 1 ?>&sort_by=<?= $sort_by ?>&sort_order=<?= $sort_order ?>" class="button">Next</a>
        </div>
    </div>
    <?php
}
