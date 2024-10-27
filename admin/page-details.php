<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');

function page_lnb_details(): void
{

    // Check if link_id is provided in the URL
    if (isset($_GET['id'])) {
        $link_id = intval($_GET['id']);
        $link_info = get_link_details_by_id($link_id);

        if ($link_info) {
            ?>
            <div class="wrap">
                <h1>Link Details</h1>

                <table class="form-table">
                    <tr>
                        <th>Link Name</th>
                        <td><?php echo esc_html($link_info->link_name); ?></td>
                    </tr>
                    <tr>
                        <th>Label Text</th>
                        <td><?php echo esc_html($link_info->label_text); ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo esc_html($link_info->category_name); ?></td>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <td><a href="<?php echo esc_url($link_info->url); ?>" target="_blank"><?php echo esc_url($link_info->url); ?></a></td>
                    </tr>
                    <tr>
                        <th>Target</th>
                        <td><?php echo esc_html($link_info->target); ?></td>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <td><span style="color: <?php echo esc_html($link_info->color); ?>"><?php echo esc_html($link_info->color); ?></span></td>
                    </tr>
                    <tr>
                        <th>Cover Image</th>
                        <td>
                            <?php if ($link_info->cover_image_id): ?>
                                <?php echo wp_get_attachment_image($link_info->cover_image_id, 'thumbnail'); ?>
                            <?php else: ?>
                                No cover image.
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Hit Count</th>
                        <td><?php echo esc_html($link_info->hit_num); ?></td>
                    </tr>
                    <tr>
                        <th>Last Visit</th>
                        <td><?php echo esc_html($link_info->last_visit); ?></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td><?php echo esc_html($link_info->created_at); ?></td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td><?php echo esc_html($link_info->updated_at); ?></td>
                    </tr>
                </table>

                <p>
                    <a href="<?php echo admin_url('admin.php?page=lnb-link-category-management'); ?>" class="button">Back to List</a>
                </p>
            </div>
            <?php
        } else {
            echo '<div class="notice notice-error"><p>Link not found.</p></div>';
        }
    } else {
        echo '<div class="notice notice-error"><p>No link ID provided.</p></div>';
    }
}