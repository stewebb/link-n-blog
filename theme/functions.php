<?php
    //class DividerControl extends \WP_Customize_Control {
    //    public $type = 'divider';
    //
    //    public function render_content() {
    //        if ($this->label) {
    //            echo "<hr />";
    //            echo "<b><center>" . esc_html($this->label) . "</center></b>";
    //        }
    //    }
    //}

    add_action('customize_register', function($wp_customize) {

        // Add a section for custom links
        $wp_customize->add_section('homepage_links_section', array(
            'title'    => __('Homepage Links', 'mytheme'),
            'priority' => 30,
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

        // Add a setting for the hero section
        $wp_customize->add_setting('hero', array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        ));

        $wp_customize->add_control('hero', array(
            'label'         => __('Hero Section', 'mytheme'),
            'description'   => __('HTML is supported.', 'mytheme'),
            'section'       => 'homepage_links_section',
            'type'          => 'textarea',
        ));

        $num_links = get_theme_mod('num_links', 3);
        for ($i = 1; $i <= $num_links; $i++) {

            // Add a divider
            //$wp_customize->add_setting('divider', array(
            //    'default'           => '',
            //    'sanitize_callback' => 'wp_kses_post',
            //));
        
            //$wp_customize->add_control(new DividerControl($wp_customize, 'divider', array(
            //    'label'    => __("Link #{$i}", 'mytheme'),
            //    'section'  => 'homepage_links_section',
            //)));

            // Text Setting
            $wp_customize->add_setting("link_{$i}_text", array(
                'default'           => "Link $i",
                'sanitize_callback' => 'sanitize_text_field',
            ));
                
            $wp_customize->add_control("link_{$i}_text", array(
                'label'    => __("Text #{$i}", 'mytheme'),
                'section'  => 'homepage_links_section',
                'type'     => 'text',
            ));

            // External Link Setting
            $wp_customize->add_setting("link_{$i}_url", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control("link_{$i}_url", array(
                'label'    => __("External Link #{$i}", 'mytheme'),
                'section'  => 'homepage_links_section',
                'type'     => 'url',
            ));

            // Internal Link Setting
            $wp_customize->add_setting("link_{$i}_internal", array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control("link_{$i}_internal", array(
                'label'    => __("Internal Blog Link #{$i}", 'mytheme'),
                'section'  => 'homepage_links_section',
                'type'     => 'text',
                'description' => __('Internal link (e.g., /about or /blog)', 'mytheme'),
            ));

            // Color picker setting
            $wp_customize->add_setting("link_{$i}_color", array(
                'default'           => '#E61F93', // Default color
                'sanitize_callback' => 'sanitize_hex_color', // Sanitize as hex color
            ));

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "link_{$i}_color", array(
                'label'    => __("Link Color #{$i}", 'mytheme'),
                'section'  => 'homepage_links_section',
                'settings' => "link_{$i}_color",
                'description' => __('Choose a color for the link.', 'mytheme'),
            )));

            // Description Setting
            //$wp_customize->add_setting("link_{$i}_description", array(
            //    'default'           => '',
            //    'sanitize_callback' => 'sanitize_textarea_field',
            //));

            //$wp_customize->add_control("link_{$i}_description", array(
            //    'label'    => __("Description #{$i}", 'mytheme'),
            //    'section'  => 'homepage_links_section',
            //    'type'     => 'textarea',
            //));

            // Cover Image Setting
            $wp_customize->add_setting("link_{$i}_image", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "link_{$i}_image", array(
                'label'    => __("Cover Picture #{$i}", 'mytheme'),
                'section'  => 'homepage_links_section',
                'settings' => "link_{$i}_image",
            )));
        }
    });

    

   

    add_action('after_setup_theme', 'mytheme_setup');

    

    function mytheme_setup() {
        add_theme_support('custom-logo', array(
            'width'      => 200,
            'height'     => 100,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }
    

    add_action('after_setup_theme', 'mytheme_setup');


    // Enqueue styles
    add_action('wp_enqueue_scripts', function() {
        $dir_uri = get_stylesheet_uri();
        wp_enqueue_style('LNB', $dir_uri);
        //wp_enqueue_style('Navbar', $dir_uri . '/styles/Navbar.css');
        //wp_enqueue_style('Footer', $dir_uri . '/styles/Footer.css');
        //wp_enqueue_style('LinkItem', $dir_uri . '/styles/LinkItem.css');
    });

    function register_my_custom_menus() {
        register_nav_menus(array(
            'your_custom_menu_location' => __('Custom Menu'),
        ));
    }
    add_action('init', 'register_my_custom_menus');
?>