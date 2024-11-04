<?php
/*
Plugin Name: Link 'n' Blog
Description: A plugin to manage custom post types with CRUD functionality.
Version: 1.0
Author: Steven Webb
*/

// Activate plugin
include_once(plugin_dir_path(__FILE__) . 'includes/activation.php');
register_activation_hook(__FILE__, 'lnb_create_database_tables');

include_once(plugin_dir_path(__FILE__) . 'admin/admin.php');

// Include other files
//include_once(plugin_dir_path(__FILE__) . 'includes/admin-page.php');
include_once(plugin_dir_path(__FILE__) . 'includes/post-type.php');
include_once(plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php');
//include_once(plugin_dir_path(__FILE__) . 'includes/crud-functions.php');