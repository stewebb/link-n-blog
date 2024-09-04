<?php
function lighten_color($hex, $percent) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = min(255, max(0, $r + ($r * $percent)));
    $g = min(255, max(0, $g + ($g * $percent)));
    $b = min(255, max(0, $b + ($b * $percent)));

    return sprintf("#%02x%02x%02x", $r, $g, $b);
}
?>

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

        <div class="container-fluid">
            <!-- Hero Section -->
            <div class="p-3 mb-3">
                <?= get_theme_mod('hero'); ?>
            </div>

            <div class="row">
                
                    
                    
            <?php
                $num_links = get_theme_mod('num_links', 3);
                for ($i = 1; $i <= $num_links; $i++) {
                    $link_text = get_theme_mod("link_{$i}_text", "Link $i");
                    $image_url = get_theme_mod("link_{$i}_image");
                    $link_color = get_theme_mod("link_{$i}_color");

                    echo '<div class="col-xl-3 col-lg-4 col-sm-6 menu-col">';
                    echo '<div class="link-item p-1">';
                    if (!empty($image_url)) {
                        echo '<div class="banner-container">';
                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($link_text) . '">';
                        echo '</div>';
                    }
                    ?>
                    <div class="overlay">
                        <button class="btn btn-primary">Button 1</button>
                        <button class="btn btn-secondary">Button 2</button>
                        <button class="btn btn-success">Button 3</button>
                    </div>
                    <?php
                    echo '<span class="fw-bold" style="color:' . esc_attr($link_color) . ';">' . esc_attr($link_text) . '</span>';
                    echo '</div>'; // Close .link-item
                    echo '</div>'; // Close .col-xl-3
                }
            ?>

                    
                
            </div>
        </div>
    </div>

<?php
//$num_links = get_theme_mod('num_links', 3); // Default to 3 if not set

if ($num_links > 0) {
    echo '<ul class="homepage-links">';

    for ($i = 1; $i <= $num_links; $i++) {
        $link_url = get_theme_mod("link_{$i}_url");
        $link_text = get_theme_mod("link_{$i}_text", "Link $i");
        $internal_link = get_theme_mod("link_{$i}_internal");
        $description = get_theme_mod("link_{$i}_description");
        $image_url = get_theme_mod("link_{$i}_image");

        if (!empty($link_url) || !empty($internal_link)) {
            echo '<li class="homepage-link-item">';

            // Image
            if (!empty($image_url)) {
                echo '<div class="homepage-link-image">';
                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($link_text) . '">';
                echo '</div>';
            }

            // Link
            echo '<a href="' . esc_url($link_url) . '"';
            if (!empty($internal_link)) {
                echo ' data-internal-link="' . esc_attr($internal_link) . '"';
            }
            echo '>' . esc_html($link_text) . '</a>';

            // Description
            if (!empty($description)) {
                echo '<p class="homepage-link-description">' . esc_html($description) . '</p>';
            }

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
