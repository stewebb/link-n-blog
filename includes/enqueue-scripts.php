<?php

// Enqueue admin styles
function hw_custom_admin_styles() {
    wp_enqueue_style('hw-admin-css', plugins_url('../assets/admin-styles.css', __FILE__));

    // Enqueue WordPress color picker
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    // Enqueue WordPress media uploader
    wp_enqueue_media();

}
add_action('admin_enqueue_scripts', 'hw_custom_admin_styles');
