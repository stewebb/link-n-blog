<?php
/*
Plugin Name: Link 'n' Blog
Description: TODO
Version: 1.0
Author: Steven Webb
*/

// Activate plugin
include_once(plugin_dir_path(__FILE__) . 'includes/activation.php');
register_activation_hook(__FILE__, 'lnb_create_database_tables');

// Register the 'helloworld' shortcode
//function helloworld_shortcode() {
//    return "<p>Hello, World!</p>";
//}
//add_shortcode('helloworld', 'helloworld_shortcode');

// Admin pages
include_once(plugin_dir_path(__FILE__) . 'admin/admin.php');

// Include other files
include_once(plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php');
