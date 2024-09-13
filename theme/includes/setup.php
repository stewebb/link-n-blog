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
function register_my_custom_menus() {
    register_nav_menus(array(
        'your_custom_menu_location' => __('Custom Menu'),
    ));
}
add_action('init', 'register_my_custom_menus');

// Enqueue styles
add_action('wp_enqueue_scripts', function() {
    $dir_uri = get_stylesheet_uri();
    wp_enqueue_style('LNB', $dir_uri);
});