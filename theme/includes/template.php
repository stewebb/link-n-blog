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
        //$context['foo'] = 'bar';

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

        /*
        for ($i = 1; $i <= $num_links; $i++) {
            $link = new stdClass();
            $link->text = get_theme_mod("link_{$i}_text", "Link {$i}");
            $link->category = get_theme_mod("link_{$i}_category", '');
            $link->image_url = get_theme_mod("link_{$i}_image", '');
            $link->color = get_theme_mod("link_{$i}_color", '');

            $context['links'][] = $link;
        }
            */

            $grouped_links = [];
for ($i = 1; $i <= $num_links; $i++) {
    $link = new stdClass();
    $link->text = get_theme_mod("link_{$i}_text", "Link {$i}");
    $link->category = get_theme_mod("link_{$i}_category", '');
    $link->image_url = get_theme_mod("link_{$i}_image", '');
    $link->color = get_theme_mod("link_{$i}_color", '');

    // Grouping links by category
    if (!isset($grouped_links[$link->category])) {
        $grouped_links[$link->category] = [];
    }
    $grouped_links[$link->category][] = $link;
}

// Pass the grouped links to the context
$context['grouped_links'] = $grouped_links;


        

        return $context;
    }

    public function add_to_twig( $twig ) {
        $twig->addExtension( new Twig\Extension\StringLoaderExtension() );
        return $twig;
    }
}

new StarterSite();
