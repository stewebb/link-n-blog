<?php

    $context = Timber::context();

    $timber_post = new Timber\Post();
    $context['post'] = $timber_post;

    $templates = array('view/index.twig' );

    //if ( is_home() ) {
    //    array_unshift( $templates, 'home.twig' );
    //} elseif ( is_single() ) {
    //    array_unshift( $templates, 'single.twig' );
    //}

    Timber::render( $templates, $context );
