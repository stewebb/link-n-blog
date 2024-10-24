<?php

// Hook to add menu
add_action('admin_menu', 'hw_add_admin_page');

// Function to add admin page
function hw_add_admin_page() {
    add_menu_page(
        "Link 'n' Blog",
        "Link 'n' Blog",
        'manage_options',
        'link-n-blog',
        'hw_display_admin_page',
        plugins_url('../assets/LNB_Square.svg', __FILE__),
        '99'
    );
}

// Function to display content on the admin page
function hw_display_admin_page() {
    echo '<h1>Hello World from the Admin Page!</h1>';
    echo '<p>This is a simple admin page for the Hello World plugin.</p>';
}
