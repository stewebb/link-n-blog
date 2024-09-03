<?php

    function mytheme_setup() {
        add_theme_support('custom-logo', array(
            'width'      => 200,
            'height'     => 100,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }

    function hello_world_theme_enqueue_styles() {
        wp_enqueue_style('MSX', get_stylesheet_uri());
    }

    function mytheme_customize_register($wp_customize) {
        // Add a section for custom links
        $wp_customize->add_section('homepage_links_section', array(
            'title'    => __('Homepage Links', 'mytheme'),
            'priority' => 30,
        ));
    
        // Add settings for each link
        for ($i = 1; $i <= 5; $i++) {
            $wp_customize->add_setting("link_{$i}_url", array(
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
    
            $wp_customize->add_control("link_{$i}_url", array(
                'label'    => __("Link $i URL", 'mytheme'),
                'section'  => 'homepage_links_section',
                'type'     => 'url',
            ));
    
            $wp_customize->add_setting("link_{$i}_text", array(
                'default' => "Link $i",
                'sanitize_callback' => 'sanitize_text_field',
            ));
    
            $wp_customize->add_control("link_{$i}_text", array(
                'label'    => __("Link $i Text", 'mytheme'),
                'section'  => 'homepage_links_section',
                'type'     => 'text',
            ));
        }
    }
    add_action('customize_register', 'mytheme_customize_register');



    add_action('after_setup_theme', 'mytheme_setup');
    //add_action('after_setup_theme', 'mytheme_setup');


    //function hello_world_theme_enqueue_styles() {
    //    // Correctly enqueue the stylesheet from /includes/Common.css
    //    wp_enqueue_style('mytheme-style', get_template_directory_uri() . '/includes/Common.css');
    //}

    //add_action('wp_enqueue_scripts', 'hello_world_theme_enqueue_styles');

    // The enqueue function
    //add_action('wp_enqueue_scripts', function() {
    //    //echo get_template_directory_uri();
    //    wp_enqueue_style('mytheme-style', get_stylesheet_directory_uri() . '/styles/Common.css');
    //});

    add_action('wp_enqueue_scripts', function() {
        wp_enqueue_style('MSX', get_stylesheet_uri());
    });
?>