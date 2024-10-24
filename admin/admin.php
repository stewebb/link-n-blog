<?php

include_once "page-list.php";
include_once "page-details.php";
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
        'link-n-blog',
        'Link List',
        'Link List',
        'manage_options',
        'link-n-blog',
        'page_lnb_list'
    );

    // Link details sub-menu
    add_submenu_page(
        'link-n-blog',
        'Add a Link',
        'Add a Link',
        'manage_options',
        'link-n-blog-details',
        'page_lnb_details'
    );

    // Settings sub-menu
    add_submenu_page(
        'link-n-blog',
        'Settings',
        'Settings',
        'manage_options',
        'link-n-blog-settings',
        'page_lnb_settings'
    );
});