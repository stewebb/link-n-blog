<?php
function hello_world_theme_enqueue_styles() {
    wp_enqueue_style('MSX', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'hello_world_theme_enqueue_styles');
