<?php

// Register custom post type
function my_crud_plugin_custom_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'My Items',
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-list-view',
    );
    register_post_type('my_item', $args);
}
add_action('init', 'my_crud_plugin_custom_post_type');
