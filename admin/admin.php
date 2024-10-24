<?php

include_once "page-list.php";
include_once "page-settings.php";

add_action('admin_menu', function () {

    add_menu_page(
        "Link 'n' Blog",
        "Link 'n' Blog",
        'manage_options',
        'link-n-blog',
        'page_lnb_list',
        plugins_url('../assets/LNB_Square.svg', __FILE__),
        '99'
    );

    // Link list sub-menu
    add_submenu_page(
        'link-n-blog',           // Parent slug
        'Link List',             // Page title
        'Link List',             // Menu title
        'manage_options',        // Capability
        'link-n-blog',           // Menu slug (reuse the parent slug for the main page)
        'page_lnb_list'     // Function that renders the page
    );

    // Settings sub-menu
    add_submenu_page(
        'link-n-blog',           // Parent slug
        'Settings',              // Page title
        'Settings',              // Menu title
        'manage_options',        // Capability
        'link-n-blog-settings',  // Menu slug for this submenu page
        'page_lnb_settings'      // Function that renders the settings page
    );
});