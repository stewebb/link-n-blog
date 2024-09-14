<?php
/*
Template Name: Articles Page
*/

$context = Timber::context();

// Query all posts
$args = array(
    'post_type' => 'post',
    'posts_per_page' => -1  // -1 to show all posts
);
$context['posts'] = new Timber\PostQuery($args);

$templates = array('view/articles.twig');

Timber::render($templates, $context);