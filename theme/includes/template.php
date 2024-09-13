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
        $context['current_year'] = date('Y');
        $context['blog_name'] = get_bloginfo('name');
        return $context;
    }

    public function add_to_twig( $twig ) {
        $twig->addExtension( new Twig\Extension\StringLoaderExtension() );
        return $twig;
    }
}

new StarterSite();
