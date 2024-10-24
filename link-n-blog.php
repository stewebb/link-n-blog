<?php
/*
Plugin Name: Link 'n' Blog
Description: A plugin to manage custom post types with CRUD functionality.
Version: 1.0
Author: Your Name
*/

include_once(plugin_dir_path(__FILE__) . 'admin/admin.php');

// Include other files
//include_once(plugin_dir_path(__FILE__) . 'includes/admin-page.php');
include_once(plugin_dir_path(__FILE__) . 'includes/post-type.php');
include_once(plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php');
include_once(plugin_dir_path(__FILE__) . 'includes/crud-functions.php');