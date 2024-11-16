<?php

include_once "page-list.php";
include_once "page-details.php";
include_once "page-groups.php";
include_once "page-categories.php";
include_once "page-preview.php";
include_once "page-settings.php";

add_action('admin_menu', function () {

    add_menu_page(
        "Link 'n' Blog",
        "Link 'n' Blog",
        'manage_options',
        'link-n-blog',
        'link_list_page',
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
        'link_list_page'
    );

    // Link details sub-menu
    add_submenu_page(
        'link-n-blog',
        'Add a Link',
        'Add a Link',
        'manage_options',
        'link-n-blog-details',
        'link_details_page'
    );

    // Groups sub-menu
    add_submenu_page(
        'link-n-blog',
        'Groups',
        'Groups',
        'manage_options',
        'link-n-blog-groups',
        'groups_page'
    );

    // Categories sub-menu
    add_submenu_page(
        'link-n-blog',
        'Categories',
        'Categories',
        'manage_options',
        'link-n-blog-categories',
        'categories_page'
    );

    // Preview sub-menu
    add_submenu_page(
        'link-n-blog',
        'Preview',
        'Preview',
        'manage_options',
        'link-n-blog-preview',
        'preview_page'
    );

    // Settings sub-menu
    add_submenu_page(
        'link-n-blog',
        'Options & Helps',
        'Options & Helps',
        'manage_options',
        'link-n-blog-settings',
        'settings_page'
    );

	// Helps sub-menu
	//add_submenu_page(
	//	'link-n-blog',
	//	'Helps',
	//	'Helps',
	//	'manage_options',
	//	'link-n-blog-helps',
	//	'helps_page'
	//);
});