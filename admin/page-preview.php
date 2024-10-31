<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');

function preview_page(): void
{
    // Retrieve all grouped links
    $grouped_links = get_all_links_grouped_by_category();
    ?>

    <style>
        .preview-container {
            padding: 20px;
            background-color: #f1f1f1; /* Light gray for contrast */
            border-radius: 8px;
        }

        .link-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .link-preview-item {
            flex: 1 1 200px;
            max-width: 300px;
            padding: 15px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>

    <div class="wrap">
        <h1 class="wp-heading-inline">Preview</h1>
        <hr class="wp-header-end">

        <?php if (!empty($grouped_links)): ?>
            <?php foreach ($grouped_links as $category => $links): ?>
                <h2><?php echo esc_html($category); ?></h2>

                <div class="link-preview-container">
                    <?php foreach ($links as $link): ?>
                        <div class="link-preview-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                            <h3><?php echo esc_html($link->link_name); ?></h3>
                            <p>Hits: <?php echo esc_html($link->hit_num); ?></p>
                            <p>URL: <a href="<?php echo esc_url($link->url); ?>" target="_blank"><?php echo esc_url($link->url); ?></a></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No links available for preview.</p>
        <?php endif; ?>

    </div>

    <?php
}