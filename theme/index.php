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

    

        <?php
// Get the number of links from the Customizer
$num_links = get_theme_mod('num_links', 3); // Default to 3 if not set

if ($num_links > 0) {
    echo '<ul class="homepage-links">';

    for ($i = 1; $i <= $num_links; $i++) {
        $link_url = get_theme_mod("link_{$i}_url");
        $link_text = get_theme_mod("link_{$i}_text", "Link $i");

        if (!empty($link_url)) {
            echo '<li>';
            echo '<a href="' . esc_url($link_url) . '">' . esc_html($link_text) . '</a>';
            echo '</li>';
        }
    }

    echo '</ul>';
}
?>


        

        <?php require_once(get_template_directory() . "/includes/Footer.php"); ?>
        <?php wp_footer(); ?>
    </div>
</body>
</html>
