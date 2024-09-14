<?php

// Add a custom section for homepage links in the Customizer
add_action('customize_register', function($wp_customize) {

    // Add a section for custom links
    $wp_customize->add_section('homepage_links_section', array(
        'title'    => __('Homepage Links', 'mytheme'),
        'priority' => 30,
    ));

    // Register the HTML editor setting
    $wp_customize->add_setting('hero_html', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',  // Ensures the content is safe for HTML output
    ));

    // Add the HTML editor control
    $wp_customize->add_control(new WP_Customize_Code_Editor_Control(
        $wp_customize,
        'hero_html',
        array(
            'label'     => __('Hero HTML', 'mytheme'),
            'section'   => 'homepage_links_section',  // Ensure this is the correct section ID
            'settings'  => 'hero_html',
            'code_type' => 'text/html',
        )
    ));


    // Add setting for the number of links
    $wp_customize->add_setting('num_links', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('num_links', array(
        'label'    => __('Number of Links', 'mytheme'),
        'section'  => 'homepage_links_section',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10,
            'step' => 1,
        ),
    ));

    // Add additional controls (for example, text, url, image, color)
    $num_links = get_theme_mod('num_links', 3);
    for ($i = 1; $i <= $num_links; $i++) {

        // Text
        $wp_customize->add_setting("link_{$i}_text", array(
            'default'           => "Link $i",
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("link_{$i}_text", array(
            'label'    => __("Text #{$i}", 'mytheme'),
            'section'  => 'homepage_links_section',
            'type'     => 'text',
        ));

        // Add Setting for Category
        $wp_customize->add_setting("link_{$i}_category", array(
            'default'           => '',  // Set default value
            'sanitize_callback' => 'sanitize_text_field',  // Use a suitable sanitization function
        ));

        // Add Control for Category
        $wp_customize->add_control("link_{$i}_category", array(
            'label'    => __("Category #{$i}", 'mytheme'),
            'section'  => 'homepage_links_section',
            'type'     => 'text',  // You can change this to 'select' if you have predefined categories
        ));

        // URL
        $wp_customize->add_setting("link_{$i}_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("link_{$i}_url", array(
            'label'    => __("External Link #{$i}", 'mytheme'),
            'section'  => 'homepage_links_section',
            'type'     => 'url',
        ));

        // Color
        $wp_customize->add_setting("link_{$i}_color", array(
            'default'           => '#E61F93',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "link_{$i}_color", array(
            'label'    => __("Link Color #{$i}", 'mytheme'),
            'section'  => 'homepage_links_section',
            'settings' => "link_{$i}_color",
        )));

        // Image
        $wp_customize->add_setting("link_{$i}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            "link_{$i}_image",
            array(
                'label'    => __("Image #{$i}", 'mytheme'),
                'section'  => 'homepage_links_section',
                'settings' => "link_{$i}_image",
            )
        ));  
    }
});
