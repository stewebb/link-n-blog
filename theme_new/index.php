<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header(); // Include header.php

// WP_Query to fetch custom links
$args = array(
    'post_type' => 'custom_link',
    'posts_per_page' => -1,
);
$custom_links = new WP_Query($args);

if ($custom_links->have_posts()) :
    while ($custom_links->have_posts()) : $custom_links->the_post();
        // Retrieve post meta values
        $description = get_post_meta(get_the_ID(), '_description', true);
        $category = get_post_meta(get_the_ID(), '_category', true) ?: get_theme_mod('custom_link_default_category', 'Uncategorized');
        $internal_pages = get_post_meta(get_the_ID(), '_internal_pages', true);
        $external_link = get_post_meta(get_the_ID(), '_external_link', true);
        $img = get_post_meta(get_the_ID(), '_img', true) ?: get_theme_mod('custom_link_default_img', '');

        ?>

        <div class="custom-link">
            <h2><?php the_title(); ?></h2>
            <p><strong>Description:</strong> <?php echo esc_html($description); ?></p>
            <p><strong>Category:</strong> <?php echo esc_html($category); ?></p>
            <p><strong>Internal Pages:</strong> <?php echo esc_html($internal_pages); ?></p>
            <p><strong>External Link:</strong> <a href="<?php echo esc_url($external_link); ?>" target="_blank"><?php echo esc_url($external_link); ?></a></p>
            <?php if ($img) : ?>
                <p><img src="<?php echo esc_url($img); ?>" alt="<?php the_title(); ?>"></p>
            <?php endif; ?>
        </div>

    <?php
    endwhile;
else :
    echo '<p>No links found.</p>';
endif;

wp_reset_postdata(); // Reset the query

get_footer(); // Include footer.php
