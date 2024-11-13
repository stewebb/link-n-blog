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
     * Initialize the enqueue setup.
     *
     * @return void
     */
    public static function init(): void
    {
        add_action('admin_enqueue_scripts', [self::class, 'enqueueAdminAssets']);
    }

    /**
     * Enqueues the main styles and scripts used in the admin panel.
     *
     * @return void
     */
    public static function enqueueAdminAssets(): void
    {
        self::enqueueCoreStyles();
        self::enqueueCoreScripts();
        self::conditionallyEnqueueScripts();
    }

    /**
     * Enqueues the core styles for the admin panel.
     *
     * @return void
     */
    private static function enqueueCoreStyles(): void
    {
        wp_enqueue_style(
            'admin-css',
            plugins_url('../assets/admin-styles.css', __FILE__)
        );

        wp_enqueue_style('wp-color-picker');
    }

    /**
     * Enqueues the core scripts for the admin panel.
     *
     * @return void
     */
    private static function enqueueCoreScripts(): void
    {
        wp_enqueue_script(
            'admin-script',
            plugins_url('../assets/admin-scripts.js', __FILE__),
            ['jquery'],
            '1.0',
            false
        );

        wp_enqueue_script('wp-color-picker');
        wp_enqueue_media();
    }

    /**
     * Conditionally enqueues scripts based on the current admin page.
     *
     * @return void
     */
    private static function conditionallyEnqueueScripts(): void
    {
        global $hook_suffix;

        switch ($hook_suffix) {
            case 'link-n-blog_page_link-n-blog-link-list':
                self::enqueueLinkListScripts();
                break;
            case 'link-n-blog_page_link-n-blog-details':
                self::enqueueLinkDetailsScripts();
                break;
            case 'link-n-blog_page_link-n-blog-categories':
                self::enqueueCategoriesScripts();
                break;
            case 'link-n-blog_page_link-n-blog-preview':
                self::enqueuePreviewScripts();
                break;
            // Add more cases as needed
        }
    }

    /**
     * Enqueues scripts for the Link List page.
     *
     * @return void
     */
    private static function enqueueLinkListScripts(): void
    {
        // Example placeholder for Link List page scripts
        /*
        wp_enqueue_script(
            'link-list-script',
            plugins_url('js/link-list.js', __FILE__),
            ['jquery'],
            '1.0',
            true
        );
        */
    }

    /**
     * Enqueues scripts for the Add a Link page.
     *
     * @return void
     */
    private static function enqueueLinkDetailsScripts(): void
    {
        // Example placeholder for Add a Link page scripts
    }

    /**
     * Enqueues scripts for the Categories page.
     *
     * @return void
     */
    private static function enqueueCategoriesScripts(): void
    {
        /*
        wp_enqueue_script(
            'categories-script',
            plugins_url('js/categories.js', __FILE__),
            ['jquery'],
            '1.0',
            true
        );
        */
    }

    /**
     * Enqueues styles and scripts for the Preview page.
     *
     * @return void
     */
    private static function enqueuePreviewScripts(): void
    {
        wp_enqueue_style(
            'admin-preview-css',
            plugins_url('../assets/admin-preview.css', __FILE__)
        );

        wp_enqueue_script(
            'admin-color-script',
            plugins_url('../assets/ColorManipulator.js', __FILE__),
            ['jquery'],
            '1.0',
            true
        );

        wp_enqueue_script(
            'admin-image-script',
            plugins_url('../assets/ImageManipulator.js', __FILE__),
            ['jquery'],
            '1.0',
            true
        );
    }
}