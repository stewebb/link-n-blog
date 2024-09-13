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
            'show_in_menu' => true,
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
    // Add nonce for security
    wp_nonce_field('save_custom_link_meta_data', 'custom_link_nonce');

    // Retrieve meta box values or fallback to customizer defaults
    $description = get_post_meta($post->ID, '_description', true);
    $category = get_post_meta($post->ID, '_category', true) ?: get_theme_mod('custom_link_default_category', 'Uncategorized');
    $internal_pages = get_post_meta($post->ID, '_internal_pages', true);
    $external_link = get_post_meta($post->ID, '_external_link', true);
    $img = get_post_meta($post->ID, '_img', true) ?: get_theme_mod('custom_link_default_img', '');

    // Output the form fields for meta box
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
    // Verify nonce
    if (!isset($_POST['custom_link_nonce']) || !wp_verify_nonce($_POST['custom_link_nonce'], 'save_custom_link_meta_data')) {
        return;
    }

    // Verify user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save meta data
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

// Add Customizer Settings for Default Category and Image
function custom_links_customize_register($wp_customize) {

    // Add a section for Custom Links
    $wp_customize->add_section('custom_links_section', array(
        'title' => __('Custom Links Settings'),
        'priority' => 30,
    ));

    // Add a setting for Default Category
    $wp_customize->add_setting('custom_link_default_category', array(
        'default' => 'Uncategorized',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Control for Default Category
    $wp_customize->add_control('custom_link_default_category_control', array(
        'label' => __('Default Category'),
        'section' => 'custom_links_section',
        'settings' => 'custom_link_default_category',
        'type' => 'text',
    ));

    // Add a setting for Default Image URL
    $wp_customize->add_setting('custom_link_default_img', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Control for Default Image URL
    $wp_customize->add_control('custom_link_default_img_control', array(
        'label' => __('Default Image URL'),
        'section' => 'custom_links_section',
        'settings' => 'custom_link_default_img',
        'type' => 'url',
    ));
}
add_action('customize_register', 'custom_links_customize_register');
