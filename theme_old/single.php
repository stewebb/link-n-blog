<?php
$context = Timber::context();
$post = Timber::get_post();
$context['post'] = $post;

Timber::render('view/single.twig', $context);
