<?php

/**
 * Plugin Name: Your Plugin Name
 * Description: A WordPress plugin that renders admin pages using Twig (without Composer).
 * Version: 1.0
 * Author: Your Name
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Timber\Timber;
//require __DIR__ . '/vendor/autoload.php';
class MyClass
{

}

echo class_exists('MyClass');
echo class_exists('Timber');

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
//error_log(class_exists('Timber') ? 'Timber is loaded' : 'Timber is NOT loaded');
//echo "hello";
//echo !class_exists( 'Timber');
//echo "world<br>";
// Ensure Timber is loaded
if (!class_exists( 'Timber' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin.</p></div>';
    } );
    return;
}

// Define the directory for Twig templates
function ccm_plugin_add_template_directory() {
    Timber::$dirname = array('views');
}
add_action('init', 'ccm_plugin_add_template_directory');

// Register the shortcode
function ccm_custom_block_shortcode($atts) {
    $args = shortcode_atts([
        'title' => 'Default Title',
        'content' => 'This is default content.',
    ], $atts);

    // Render the Twig template with passed arguments
    return Timber::compile('block.twig', $args);
}
add_shortcode('custom_block', 'ccm_custom_block_shortcode');

// Create an admin menu page
function ccm_add_admin_page() {
    add_menu_page(
        'My Custom Plugin',          // Page title
        'Custom Plugin',             // Menu title
        'manage_options',            // Capability
        'ccm_custom_plugin',         // Menu slug
        'ccm_render_admin_page',     // Callback function to render the page
        'dashicons-admin-generic',   // Icon
        25                           // Position in menu
    );
}
add_action('admin_menu', 'ccm_add_admin_page');

// Render the admin page using Timber
function ccm_render_admin_page() {
    // Check user capability
    if (!current_user_can('manage_options')) {
        return;
    }

    // Prepare data for the template
    $context = Timber::get_context();
    $context['title'] = 'My Custom Admin Page';
    $context['description'] = 'This is an admin page rendered with Timber and Twig.';

    // Render the admin page using a Twig template
    Timber::render('admin-page.twig', $context);
}
