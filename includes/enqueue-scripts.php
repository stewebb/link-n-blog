<?php

// Enqueue admin styles
function hw_custom_admin_styles() {
    wp_enqueue_style('hw-admin-css', plugins_url('../assets/admin-styles.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'hw_custom_admin_styles');
