<?php

// Register custom post type
add_action('init', function() {
    $args = array(
        'public' => true,
        'label'  => 'My Items',
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-list-view',
    );
    register_post_type('my_item', $args);
});
