<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');

// Function to display the link list page in the admin panel
function page_lnb_list(): void
{
    // Retrieve the links data
    $links = get_lnb_links();
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
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <!--
                <th scope="col">Label Text</th>
                <th scope="col">Category</th>
                <th scope="col">WP Page ID</th>
                -->

                <th scope="col">URL</th>

                <!--
                <th scope="col">Target</th>
                <th scope="col">Color</th>
                <th scope="col">Cover Image ID</th>
                -->
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($links): ?>
                <?php foreach ($links as $link): ?>
                    <tr>

                        <!-- ID -->
                        <td>
                            <?= $link->id ?>
                        </td>

                        <!-- Name -->
                        <td>
                            <a href="admin.php?page=link-n-blog-details&id=<?= $link->id ?>"><?= $link->link_name ?></a>
                        </td>

                        <!-- Label Text -->
                        <!--
                        <td>
                            <?= $link->label_text ?? '<span class="text-light-gray">Same as link name</span>'; ?>
                        </td>
                        -->

                        <!-- Category -->
                        <td>
                            <?= $link->category_name ?? '<span class="text-light-gray">Uncategorized</span>' ?>
                        </td>

                        <!-- WP Page ID -->
                        <!--
                        <td>
                            <?= $link->wp_page_id ?? '<span class="text-light-gray">N/A</span>' ?>
                        </td>
                        -->

                        <!-- URL -->
                        <td>
                            <a href="<?= $link->url ?>" target="_blank"><?= $link->url ?></a>
                        </td>

                        <!-- Target -->
                        <!--
                        <td>
                            <?= $link->target ?>
                        </td>

                        <td style="color: <?= esc_attr($link->color); ?>"><?= esc_html($link->color); ?></td>
                        <td><?= esc_html($link->cover_image_id); ?></td>
                        -->

                        <!-- Action -->
                        <td>
                            <a href="admin.php?page=link-n-blog-details&id=<?= $link->id ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No links found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
