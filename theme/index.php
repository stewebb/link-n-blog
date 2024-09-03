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

        <main>
            <h1>Welcome to My Homepage</h1>
            <ul>
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    $url = get_theme_mod("link_{$i}_url");
                    $text = get_theme_mod("link_{$i}_text");

                    if ($url && $text) {
                        echo '<li><a href="' . esc_url($url) . '">' . esc_html($text) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </main>

        <?php require_once(get_template_directory() . "/includes/Footer.php"); ?>
        <?php wp_footer(); ?>
    </div>
</body>
</html>
