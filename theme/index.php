<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <title><?php bloginfo('description'); ?> | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <div id="app">
        <?php require_once(get_template_directory() . "/includes/Navbar.php"); ?>

        <div id="content">
    <?php
    // Fetch links from custom post type
    $args = array(
        'post_type' => 'link',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    $links = new WP_Query($args);
    
    if ($links->have_posts()) : ?>
        <ul class="link-list">
            <?php while ($links->have_posts()) : $links->the_post(); ?>
                <li>
                    <a href="<?php the_field('link_url'); ?>" target="_blank">
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>No links found.</p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>

        <?php require_once(get_template_directory() . "/includes/Footer.php"); ?>
        <?php wp_footer(); ?>
    </div>
</body>
</html>
