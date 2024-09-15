<?php

$context = Timber::context();

// Query all posts
$args = array(
    'post_type' => 'post',
    'posts_per_page' => -1  // -1 to show all posts
);
$context['posts'] = new Timber\PostQuery($args);

Timber::render(array('view/articles.twig'), $context);