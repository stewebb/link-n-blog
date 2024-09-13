<?php

// Register Custom Post Type for Custom Links
function register_custom_links_post_type() {
    register_post_type('custom_link',
        array(
            'labels' => array(
                'name' => __('Custom Links'),
                'singular_name' => __('Custom Link')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'custom-links'),
        )
    );
}
add_action('init', 'register_custom_links_post_type');


// Add Meta Boxes for Custom Link Fields
function custom_link_meta_boxes() {
    add_meta_box(
        'link_info',
        __('Link Information'),
        'link_meta_box_callback',
        'custom_link'
    );
}
add_action('add_meta_boxes', 'custom_link_meta_boxes');

// Meta Box Callback Function
function link_meta_box_callback($post) {
    $description = get_post_meta($post->ID, '_description', true);
    $category = get_post_meta($post->ID, '_category', true);
    $internal_pages = get_post_meta($post->ID, '_internal_pages', true);
    $external_link = get_post_meta($post->ID, '_external_link', true);
    $img = get_post_meta($post->ID, '_img', true);

    echo '<label for="description">Description</label>';
    echo '<textarea id="description" name="description">'. esc_textarea($description) .'</textarea>';

    echo '<label for="category">Category</label>';
    echo '<input type="text" id="category" name="category" value="'. esc_attr($category) .'" />';

    echo '<label for="internal_pages">Internal Pages (Comma-separated IDs)</label>';
    echo '<input type="text" id="internal_pages" name="internal_pages" value="'. esc_attr($internal_pages) .'" />';

    echo '<label for="external_link">External Link</label>';
    echo '<input type="url" id="external_link" name="external_link" value="'. esc_attr($external_link) .'" />';

    echo '<label for="img">Image URL</label>';
    echo '<input type="url" id="img" name="img" value="'. esc_attr($img) .'" />';
}

// Save Meta Box Data
function save_custom_link_meta_data($post_id) {
    if (isset($_POST['description'])) {
        update_post_meta($post_id, '_description', sanitize_text_field($_POST['description']));
    }
    if (isset($_POST['category'])) {
        update_post_meta($post_id, '_category', sanitize_text_field($_POST['category']));
    }
    if (isset($_POST['internal_pages'])) {
        update_post_meta($post_id, '_internal_pages', sanitize_text_field($_POST['internal_pages']));
    }
    if (isset($_POST['external_link'])) {
        update_post_meta($post_id, '_external_link', esc_url($_POST['external_link']));
    }
    if (isset($_POST['img'])) {
        update_post_meta($post_id, '_img', esc_url($_POST['img']));
    }
}
add_action('save_post', 'save_custom_link_meta_data');

add_action('wp_enqueue_scripts', function() {
    $dir_uri = get_stylesheet_uri();
    wp_enqueue_style('LNB', $dir_uri);
});