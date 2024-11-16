<?php

function preview_page(): void
{
    // Retrieve all grouped links
    //$grouped_links = lnb_get_all_links_grouped_by_category(1);
    echo do_shortcode('[lnb id=1]');
    ?>

    <style>
        .preview-container {
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
        }
    </style>

    <div class="wrap">
        <h1 class="wp-heading-inline">Preview</h1>
        <hr class="wp-header-end">

        <div class='notice notice-info'>
            <p>This page currently includes only basic styling. You can enhance it with custom styles in your theme’s
                stylesheet.</p>
        </div>

        <?php if (!empty($grouped_links)): ?>
            <?php foreach ($grouped_links as $category => $links): ?>
                <h2><?= esc_html($category) ?></h2>

                <div class="preview-container menu-row">
                    <?php foreach ($links as $link): ?>
                        <div class="link-item menu-col">

                            <!-- Background: Image or Color -->
                            <?php if ($link->cover_image_id): ?>
                                <div class="banner-container">
                                    <?= wp_get_attachment_image($link->cover_image_id, 'full') ?>
                                </div>
                            <?php else: ?>
                                <div class="banner-container" data-color="<?= esc_attr($link->color) ?>"></div>
                            <?php endif; ?>
                            <!--
                            <div class="banner-container">
                                <img src="<?= esc_url($link->cover_image_id) ?>" alt="Banner for <?= esc_html($link->link_name) ?>" />
                                <div class="centered-text"><?= esc_html($link->link_name) ?></div>
                            </div>
                            <div class="content-container">
                                <p>Hits: <?= esc_html($link->hit_num) ?></p>
                                <p>URL: <a href="<?= esc_url($link->url) ?>" target="_blank"><?= esc_url($link->url) ?></a></p>
                            </div>
                            -->

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No links available for preview.</p>
        <?php endif; ?>
    </div>

    <script>
        jQuery(document).ready(function () {

            // Set a fallback color if the color option is not set.
            const defaultColor = '#e070a7';

            const colorManipulator = new ColorManipulator('#fff');
            colorManipulator.setPercentage(60);
            colorManipulator.setIsLighten(true);

            jQuery('.banner-container').each(function () {
                const baseColor = jQuery(this).data('color');
                colorManipulator.setColor(baseColor ? baseColor : defaultColor);
                jQuery(this).css('background-color', colorManipulator.adjustColor());
            });
        });

        jQuery(document).ready(function () {
            // Select all images within .image-container elements and apply adjustments
            jQuery('.banner-container img').each(function () {
                // Initialize the ImageManipulator for each image with a 20% adjustment
                //const imageManipulator = new ImageManipulator(this, 50);

                // Lighten the image
                //imageManipulator.lighten();

                // To darken the image instead, you can do:
                // imageManipulator.darken();
            });
        });

    </script>

    <?php
}
