<?php
/*
Plugin Name: Link 'n' Blog
Description: TODO
Version: 1.0
Author: Steven Webb
*/

require_once __DIR__ . '/vendor/autoload.php';

// Activation file
include_once plugin_dir_path(__FILE__) . 'src/includes/activation.php';

// Admin pages
include_once plugin_dir_path(__FILE__) . 'src/admin/admin.php';

// Enqueue scripts
include_once plugin_dir_path(__FILE__) . 'src/includes/enqueue-scripts.php';


// Activate plugin
//include_once(plugin_dir_path(__FILE__) . 'includes/activation.php');

// Usage: instantiate the class and call setup method during plugin activation
//$lnbDatabaseSetup = new LNB_Database_Setup();
//register_activation_hook(__FILE__, [$lnbDatabaseSetup, 'setup']);


//register_activation_hook(__FILE__, 'lnb_create_database_tables');

// Register the 'helloworld' shortcode
//function helloworld_shortcode() {
//    return "<p>Hello, World!</p>";
//}
//add_shortcode('helloworld', 'helloworld_shortcode');

// Admin pages
//include_once(plugin_dir_path(__FILE__) . 'admin/admin.php');

// Include other files
//include_once(plugin_dir_path(__FILE__) . 'includes/post-type.php');
//include_once(plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php');
