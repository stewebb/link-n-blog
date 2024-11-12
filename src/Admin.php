<?php

namespace LinkNBlog;

//use Twig\Environment;
//use Twig\Loader\FilesystemLoader;

/**
 * Class Admin
 *
 * This class is responsible for managing the admin menu pages in the Link 'n' Blog plugin.
 */

class Admin
{
    /**
     * Constructor to initialize the admin menu setup.
     */
    public function __construct()
    {
        // Include required page files
        //$this->includePages();

        // Initialize admin menu
        add_action('admin_menu', [$this, 'registerAdminMenu']);
    }

    /**
     * Include the page files required for the plugin.
     */
    //private function includePages()
   // {
   //     include_once "page-list.php";
     //   include_once "page-details.php";
     //   include_once "page-categories.php";
     //   include_once "page-preview.php";
     //   include_once "page-settings.php";
    //}

    /**
     * Registers the main admin menu and submenu pages.
     */
    public function registerAdminMenu()
    {
        add_menu_page(
            "Link 'n' Blog",
            "Link 'n' Blog",
            'manage_options',
            'link-n-blog',
            [$this, 'linkListPage'],
            plugins_url('../assets/LNB_Square.svg', __FILE__),
            '99'
        );

        // Register submenus
        $this->registerSubmenus();
    }

    /**
     * Registers the submenus under the main menu.
     */
    private function registerSubmenus()
    {
        add_submenu_page(
            'link-n-blog',
            'Link List',
            'Link List',
            'manage_options',
            'link-n-blog',
            [$this, 'linkListPage']
        );

        add_submenu_page(
            'link-n-blog',
            'Add a Link',
            'Add a Link',
            'manage_options',
            'link-n-blog-details',
            [$this, 'linkDetailsPage']
        );

        add_submenu_page(
            'link-n-blog',
            'Categories',
            'Categories',
            'manage_options',
            'link-n-blog-categories',
            [$this, 'categoriesPage']
        );

        add_submenu_page(
            'link-n-blog',
            'Preview',
            'Preview',
            'manage_options',
            'link-n-blog-preview',
            [$this, 'previewPage']
        );

        add_submenu_page(
            'link-n-blog',
            'Settings',
            'Settings',
            'manage_options',
            'link-n-blog-settings',
            [$this, 'settingsPage']
        );
    }

    /**
     * Callback function for the Link List page.
     */
    //public function linkListPage()
    //{
    //    link_list_page(); // Calls the function defined in page-list.php
    //}

    /**
     * Callback function for the Link Details page.
     */
    //public function linkDetailsPage()
    //{
     //   link_details_page(); // Calls the function defined in page-details.php
    //}

    /**
     * Callback function for the Categories page.
     */
    //public function categoriesPage()
    //{
    //    categories_page(); // Calls the function defined in page-categories.php
    //}

    /**
     * Callback function for the Preview page.
     */
    //public function previewPage()
    //{
    //    preview_page(); // Calls the function defined in page-preview.php
    //}

    /**
     * Callback function for the Settings page.
     */
   // public function settingsPage()
    //{
    //    settings_page(); // Calls the function defined in page-settings.php
    //}
}

// Initialize the Admin class
//new Admin();
