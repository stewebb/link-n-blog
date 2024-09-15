<?php

// Add theme support for custom logo
function mytheme_setup() {
    add_theme_support('custom-logo', array(
        'width'      => 200,
        'height'     => 100,
        'flex-width' => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'mytheme_setup');

// Register custom menus
//function register_my_custom_menus() {
//    register_nav_menus(array(
//        'your_custom_menu_location' => __('Custom Menu'),
//    ));
//}
//add_action('init', 'register_my_custom_menus');

add_action('init', function() {
    register_nav_menu('primary', __('Primary Menu'));
});

//function custom_rewrite_rule() {
//    add_rewrite_rule('^articles/', 'index.php?pagename=articles', 'top');
//}
//add_action('init', 'custom_rewrite_rule', 10, 0);


// Enqueue styles
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('LNB_styles', get_template_directory_uri() . '/assets/css/lnb.min.css', array(), '1.0.0', 'all');
});

// Enqueue scripts
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() .'/assets/js/bootstrap.min.js', array('jquery'), null, true);
    wp_enqueue_script('LNB_scripts', get_template_directory_uri() . '/assets/js/lnb.min.js', array(), '1.0.0', true);
});

//add_action('wp_enqueue_scripts', function() {
//    
//});

add_action('after_switch_theme', function () {
    $page_title = 'Articles';
    $page_template = 'page-articles.php';

    // Check if the page already exists
    $page_check = get_page_by_title($page_title);
    if (!isset($page_check->ID)) {

        // Create post object
        $new_page = array(
            'post_title'   => 'Articles',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'page',
        );

        // Insert the page into the database
        $new_page_id = wp_insert_post($new_page);

        // Assign the custom template to the new page
        if (!empty($page_template)) {
            update_post_meta($new_page_id, '_wp_page_template', $page_template);
        }
    }
});