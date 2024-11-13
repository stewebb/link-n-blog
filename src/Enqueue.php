<?php

namespace LinkNBlog;

/**
 * Class Enqueue
 *
 * This class is responsible for enqueuing the necessary styles and scripts in the admin panel.
 */

class Enqueue
{

    /**
     * Initialize and enqueue all necessary styles and scripts based on the admin page.
     */

    public static function init(): void
    {
        add_action('admin_enqueue_scripts', function () {

            // Enqueue core styles
            wp_enqueue_style('admin-css', plugins_url('../assets/css/admin.css', __FILE__));
            wp_enqueue_style('wp-color-picker');

            // Enqueue core scripts
            wp_enqueue_script('admin-script', plugins_url('../assets/js/admin.js', __FILE__), ['jquery'], '1.0', false);
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_media();

            // Conditionally enqueue additional assets based on the current admin page
            global $hook_suffix;
            switch ($hook_suffix) {
                case 'link-n-blog_page_link-n-blog-link-list':
                    break;

                case 'link-n-blog_page_link-n-blog-details':
                    break;

                case 'link-n-blog_page_link-n-blog-categories':
                    break;

                case 'link-n-blog_page_link-n-blog-preview':
                    wp_enqueue_style('admin-preview-css', plugins_url('../assets/admin-preview.css', __FILE__));
                    wp_enqueue_script('admin-color-script', plugins_url('../assets/ColorManipulator.js', __FILE__), ['jquery'], '1.0', true);
                    wp_enqueue_script('admin-image-script', plugins_url('../assets/ImageManipulator.js', __FILE__), ['jquery'], '1.0', true);
                    break;

            }
        });
    }
}