<?php
/*
Plugin Name: Link 'n' Blog
Description: A
Version: 1.0
Author: Your Name
*/

// Hook to add menu
add_action('admin_menu', 'hw_add_admin_page');

// Function to add admin page
function hw_add_admin_page() {
    add_menu_page(
        "Link 'n' Blog",      // Page title
        "Link 'n' Blog",             // Menu title
        'manage_options',          // Capability
        'hello-world',             // Menu slug
        'hw_display_admin_page',   // Callback function
        plugins_url('LNB_Square.svg', __FILE__), // Path to PNG icon
        '99'                          // Position
    );
}

// Function to display content on the admin page
function hw_display_admin_page() {
    echo '<h1>Hello World from the Admin Page!</h1>';
    echo '<p>This is a simple admin page for the Hello World plugin.</p>';
}

function hw_custom_admin_styles() {
    wp_enqueue_style('hw-admin-css', plugins_url('admin-styles.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'hw_custom_admin_styles');