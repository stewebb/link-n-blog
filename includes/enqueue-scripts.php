<?php

// Enqueue admin styles and conditionally enqueue scripts
add_action('admin_enqueue_scripts', function (): void {
    // Enqueue admin styles
    wp_enqueue_style(
        'admin-css',
        plugins_url('../assets/admin-styles.css', __FILE__)
    );

    // Enqueue WordPress color picker and media uploader
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_media();

    // Conditionally enqueue scripts based on admin page
    global $hook_suffix;

    // Link List page
    if ($hook_suffix === 'link-n-blog_page_link-n-blog-link-list') {
        //wp_enqueue_script(
        //    'link-list-script',
        //    plugins_url('js/link-list.js', __FILE__),
        //    ['jquery'],
        //    '1.0',
        //    true
        //);
    }

    // Add a Link page
    elseif ($hook_suffix === 'link-n-blog_page_link-n-blog-details') {
        wp_enqueue_script(
            'admin-link-details-script',
            plugins_url('../assets/admin-link-details.js', __FILE__),
            ['jquery'],
            '1.0',
            true
        );
    }

    // Categories page
    elseif ($hook_suffix === 'link-n-blog_page_link-n-blog-categories') {
        //wp_enqueue_script(
        //    'categories-script',
        //    plugins_url('js/categories.js', __FILE__),
        //    ['jquery'],
        //    '1.0',
        //    true
        //);
    }

    // Preview page
    elseif ($hook_suffix === 'link-n-blog_page_link-n-blog-preview') {
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
    }
});

//add_action('admin_enqueue_scripts', 'lnb_admin_styles');
