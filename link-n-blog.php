<?php

/**
 * Plugin Name: Link 'n' Blog
 * Plugin URI: https://github.com/stewebb/link-n-blog
 * Description: Adds custom functionality to enhance WordPress site features.
 * Version: 1.0.0
 * Author: Steven Webb
 * Author URI: https://stewebb.net
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 */

// Helpers
include_once(plugin_dir_path(__FILE__) . 'includes/helpers.php');
include_once( plugin_dir_path( __FILE__ ) . 'includes/enqueue.php' );

// Models
include_once( plugin_dir_path( __FILE__ ) . 'model/categories.php' );
include_once( plugin_dir_path( __FILE__ ) . 'model/groups.php' );
include_once( plugin_dir_path( __FILE__ ) . 'model/links.php' );

// Activation
include_once(plugin_dir_path(__FILE__) . 'includes/activation.php');
register_activation_hook(__FILE__, 'lnb_create_database_tables');

// Public and admin pages
include_once(plugin_dir_path(__FILE__) . 'public/public.php');
include_once(plugin_dir_path(__FILE__) . 'admin/admin.php');

//echo lnb_has_shortcode() ? "Yes" : "No";
