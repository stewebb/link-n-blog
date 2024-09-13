<?php

if ( ! class_exists( 'Timber' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure the Timber plugin is activated.</p></div>';
    });
    return;
}

class StarterSite extends Timber\Site {
    public function __construct() {
        add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
        add_filter( 'timber/context', array( $this, 'add_to_context' ) );
        add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
        parent::__construct();
    }

    public function theme_supports() {
        add_theme_support( 'post-thumbnails' );
    }

    public function add_to_context( $context ) {
        $context['foo'] = 'bar';

        $context['menu'] = new Timber\Menu();
        $context['home_url'] = home_url();
        $context['is_custom_logo'] = has_custom_logo();
        if (function_exists('the_custom_logo') && has_custom_logo()) {
            $context['custom_logo'] = new Timber\Image(get_theme_mod('custom_logo'));
        } else {
            $context['default_logo_url'] = get_template_directory_uri() . '/assets/images/LNB_Square.png';
        }

        // Footer
        $context['current_year'] = date('Y');
        $context['blog_name'] = get_bloginfo('name');
        
        // Hero
        $context['hero'] = get_theme_mod('hero_html', 'Default hero content');

        // Links
        $num_links = get_theme_mod('num_links', 3);
        $context['links'] = [];

        for ($i = 1; $i <= $num_links; $i++) {
            $link = new stdClass();
            $link->text = get_theme_mod("link_{$i}_text", "Link {$i}");
            $link->image_url = get_theme_mod("link_{$i}_image", '');
            $link->color = get_theme_mod("link_{$i}_color", '');
    
            // Color manipulation functions should be handled in PHP
            //$link->boxBgColor = lightenColor($link->color, 40); // Assume you have a function `lightenColor`
            //$link->btnBgColor = getTextColorBasedOnBackground($link->boxBgColor); // Assume you have a function `getTextColorBasedOnBackground`
    
            $context['links'][] = $link;
        }

        

        return $context;
    }

    public function add_to_twig( $twig ) {
        $twig->addExtension( new Twig\Extension\StringLoaderExtension() );
        return $twig;
    }
}

new StarterSite();
