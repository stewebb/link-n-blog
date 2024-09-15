<?php

    $context = Timber::context();

    $timber_post = new Timber\Post();
    $context['post'] = $timber_post;

    //$templates = array('view/index.twig' );
    //wp_nav_menu(array('theme_location' => 'primary'));

    Timber::render(array('view/home.twig'), $context );
?>