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
        // Theme support options here
        add_theme_support( 'post-thumbnails' );
    }

    public function add_to_context( $context ) {
        $context['foo'] = 'bar';
        $context['menu'] = new Timber\Menu();
        return $context;
    }

    public function add_to_twig( $twig ) {
        // Here you can add your own functions to Twig
        $twig->addExtension( new Twig\Extension\StringLoaderExtension() );
        return $twig;
    }
}

new StarterSite();

// Add theme support for custom logo
function mytheme_setup() {
    add_theme_support('custom-logo', array(
        'width'      => 200,
        'height'     => 100,
        'flex-width' => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'mytheme_setup');

// Register custom menus
function register_my_custom_menus() {
    register_nav_menus(array(
        'your_custom_menu_location' => __('Custom Menu'),
    ));
}
add_action('init', 'register_my_custom_menus');

// Enqueue styles
add_action('wp_enqueue_scripts', function() {
    $dir_uri = get_stylesheet_uri();
    wp_enqueue_style('LNB', $dir_uri);
});

/*
function LNB_enqueue_assets() {
    $build_dir = get_template_directory() . '/build/static';
    
    // Scan and enqueue CSS and JS file
    $js_files = glob($build_dir . '/js/*.js');
    $css_files = glob($build_dir . '/css/*.css');
    
    if (!empty($css_files)) {
        wp_enqueue_style('LNB_CSS', get_template_directory_uri() . '/build/static/css/' . basename($css_files[0]), array(), null);
    }

    if (!empty($js_files)) {
        wp_enqueue_script('LNB_JS', get_template_directory_uri() . '/build/static/js/' . basename($js_files[0]), array(), null, true);
    }
}
*/
//add_action('wp_enqueue_scripts', 'enqueue_react_assets');

/*
add_action('wp_enqueue_scripts', function() {
    // Path to the asset-manifest.json
    $manifest_path = get_template_directory() . '/build/asset-manifest.json';

    // Ensure the file exists
    if (file_exists($manifest_path)) {
        // Get the content of the asset-manifest.json
        $manifest = json_decode(file_get_contents($manifest_path), true);

        //echo(manifest)

        // Extract the entrypoints for CSS and JS
        $entrypoints = $manifest['entrypoints'];

        // Enqueue the CSS file from the entrypoints
        foreach ($entrypoints as $file) {
            if (strpos($file, '.css') !== false) {
                wp_enqueue_style(
                    'react-app-style',
                    get_template_directory_uri() . '/build/' . $file,
                    array(),
                    filemtime(get_template_directory() . '/build/' . $file)
                );
            }
        }

        // Enqueue the JS file from the entrypoints
        foreach ($entrypoints as $file) {
            if (strpos($file, '.js') !== false) {
                wp_enqueue_script(
                    'react-app',
                    get_template_directory_uri() . '/build/' . $file,
                    array(),
                    filemtime(get_template_directory() . '/build/' . $file),
                    true
                );
            }
        }
    }
});
*/