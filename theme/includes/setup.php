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

// Enqueue styles
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('LNB_styles', get_template_directory_uri() . 'assets/css/lnb.min.css', array(), '1.0.0', 'all');
});

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('LNB_utils', get_template_directory_uri() . 'assets/js/utils.js', array(), '1.0.0', true);
});