<?php

    // Add an admin menu for the settings page
    /*
    add_action('admin_menu', function() {
        add_options_page(
            'Manage Links',                // Page title
            'Manage Links',                // Menu title
            'manage_options',              // Capability
            'manage_links',               // Menu slug
            function() {                  // Callback function to display the settings page
                ?>
                <div class="wrap">
                    <h1>Manage Links</h1>
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('link_options_group');
                        do_settings_sections('manage_links');
                        submit_button();
                        ?>
                    </form>
                </div>
                <?php
            }
        );
    });
    
    */
    // Sanitize function for custom_links setting
    //function sanitize_textarea_field($input) {
    //    // Convert line breaks to HTML <br> tags
    //    return wp_kses_post($input);
    //}

    
    // Add Customizer settings and controls
    /*
    add_action('customize_register', function($wp_customize) {
    
        // Add a new section to the Customizer
        $wp_customize->add_section('custom_links_section', array(
            'title'    => __('Custom Links', 'yourtheme'),
            'priority' => 30, // Order of the section in the Customizer
        ));
    
        // Add a setting for the links
        $wp_customize->add_setting('custom_links', array(
            'default'           => array(),
            'sanitize_callback' => 'sanitize_textarea_field', // Custom sanitization function
        ));
    
        // Add a control for the links setting
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'custom_links_control', array(
            'label'    => __('Add Your Links', 'yourtheme'),
            'section'  => 'custom_links_section',
            'settings' => 'custom_links',
            'type'     => 'textarea', // Use 'textarea' for multiple links input
        )));
    });
    */
    
   
    
    /*
    function lnb_admin_register($wp_customize) {
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
    

    add_action('customize_register', 'lnb_admin_register');
    */

    /*
    add_action('customize_register', function($wp_customize) {
        // Add a section for custom links
        $wp_customize->add_section('homepage_links_section', array(
            'title'    => __('Homepage Links', 'mytheme'),
            'priority' => 30,
        ));

        $i = 1;
    
        
        // Add settings for each link
        //for ($i = 1; $i <= 5; $i++) {
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
        //}
    });
    */
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
    
        // Generate settings and controls based on the number of links
        $num_links = get_theme_mod('num_links', 3); // Default to 3 if not set
    
        for ($i = 1; $i <= $num_links; $i++) {
            // Add setting for each link URL
            $wp_customize->add_setting("link_{$i}_url", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
    
            $wp_customize->add_control("link_{$i}_url", array(
                'label'    => __("Link $i URL", 'mytheme'),
                'section'  => 'homepage_links_section',
                'type'     => 'url',
            ));
    
            // Add setting for each link text
            $wp_customize->add_setting("link_{$i}_text", array(
                'default'           => "Link $i",
                'sanitize_callback' => 'sanitize_text_field',
            ));
    
            $wp_customize->add_control("link_{$i}_text", array(
                'label'    => __("Link $i Text", 'mytheme'),
                'section'  => 'homepage_links_section',
                'type'     => 'text',
            ));
        }
    });
    

    /*
    add_action('customize_register', function($wp_customize) {
        $wp_customize->add_section('homepage_links_section', array(
            'title'    => __('Homepage Links', 'mytheme'),
            'priority' => 30,
        ));

        $wp_customize->add_setting("link_url", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
    });
    */



    add_action('after_setup_theme', 'mytheme_setup');

    /*
    function my_theme_settings_page() {
        echo "qqq";
    }

    function custom_links_admin()
    {
        add_options_page(
            'Manage Links',                // Page title
            'Manage Links',                // Menu title
            'manage_options',              // Capability
            'manage_links',               // Menu slug
            'my_theme_settings_page'
        );    
    
    }

    add_action('admin_menu', 'custom_links_admin'); 
    */

    function mytheme_setup() {
        add_theme_support('custom-logo', array(
            'width'      => 200,
            'height'     => 100,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }

    //function hello_world_theme_enqueue_styles() {
    //    wp_enqueue_style('MSX', get_stylesheet_uri());
    //}

    
    /*
    // Register Custom Post Type
    add_action('init', function() {
        $args = array(
            'public' => true,
            'label'  => 'Links',
            'supports' => array('title'),
            'menu_position' => 5,
            'show_in_rest' => true,
            'has_archive' => false,
        );
        register_post_type('link', $args);
    });
    
    // Add Meta Box
    add_action('add_meta_boxes', function() {
        add_meta_box(
            'link_url_meta_box',
            'Link URL',
            function($post) {
                $link_url = get_post_meta($post->ID, 'link_url', true);
                ?>
                <label for="link_url">URL:</label>
                <input type="text" id="link_url" name="link_url" value="<?php echo esc_attr($link_url); ?>" size="30" />
                <?php
            },
            'link',
            'normal',
            'high'
        );
    });
    
    // Save Meta Box Data
    add_action('save_post', function($post_id) {
        if (array_key_exists('link_url', $_POST)) {
            update_post_meta(
                $post_id,
                'link_url',
                sanitize_text_field($_POST['link_url'])
            );
        }
    });
    */


    add_action('after_setup_theme', 'mytheme_setup');


    //function lnb_enqueue_styles() {
    //    $dir_uri = get_template_directory_uri();
    //    wp_enqueue_style('Common', $dir_uri . '/styles/Common.css');
    //    wp_enqueue_style('Navbar', $dir_uri . '/styles/Navbar.css');
    //    wp_enqueue_style('Footer', $dir_uri . '/styles/Footer.css');
    //}
    //add_action('wp_enqueue_scripts', 'lnb_enqueue_styles');

    // Enqueue styles
    add_action('wp_enqueue_scripts', function() {
        $dir_uri = get_template_directory_uri();
        wp_enqueue_style('Common', $dir_uri . '/styles/Common.css');
        wp_enqueue_style('Navbar', $dir_uri . '/styles/Navbar.css');
        wp_enqueue_style('Footer', $dir_uri . '/styles/Footer.css');
    });
?>