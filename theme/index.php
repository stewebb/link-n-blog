<?php 
    $dir_path = get_template_directory();
    $dir_uri = get_template_directory_uri();
    require_once($dir_path . "/includes/utils.php"); 
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= $dir_uri ?>/assets/images/LNB_Square.png" sizes="32x32" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <title><?php bloginfo('description'); ?> | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div id="app">
        <?php require_once($dir_path . "/includes/Navbar.php"); ?>

        <div class="container-fluid">

            <!-- Hero Section -->
            <div class="p-3 mb-3">
                <?= get_theme_mod('hero'); ?>
            </div>

            <!-- Main Content: Iterate all results -->
            <div class="row">  
                <?php $num_links = get_theme_mod('num_links', 3); ?>
                <?php for ($i = 1; $i <= $num_links; $i++) { ?>
                    <?php
                        $link_text = get_theme_mod("link_{$i}_text", "Link $i");
                        $image_url = get_theme_mod("link_{$i}_image");
                        $link_color = get_theme_mod("link_{$i}_color");
                    ?>

                    <!-- Div for each result -->
                    <div class="col-xl-3 col-lg-4 col-sm-6 menu-col">
                        <div class="link-item p-1">

                            <!-- Image -->
                            <div class="banner-container">
                                <img src="<?= $image_url ?>" alt="<?= $link_text ?>">
                            </div>

                            <!--
                            <span class="fw-bold text-primary" style="color:' . esc_attr($link_color) . '!important;">
                            -->

                            <?php 
                                $boxBgColor = lightenColor($link_color, 40);
                                //echo $boxBgColor;
                                $btnBgColor = getTextColorBasedOnBackground($boxBgColor); 
                            ?>

                            <!-- Overlay when hovered -->
                            <div class="overlay" 
                                onmouseover="this.style.backgroundColor='<?= $boxBgColor ?>';"
                                onmouseout="this.style.backgroundColor=='';"
                            >
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-<?= $btnBgColor ?>">
                                        Visit
                                    </button>

                                    <button type="button" class="btn btn-outline-<?= $btnBgColor ?>">
                                        About
                                    </button>

                                    <button type="button" class="btn btn-outline-<?= $btnBgColor ?>">
                                        Share
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                    
            </div>
        </div>
    </div>

<?php
/*
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
    */
?>

        <?php require_once($dir_path . "/includes/Footer.php"); ?>
        <?php wp_footer(); ?>
    </div>
</body>
</html>
