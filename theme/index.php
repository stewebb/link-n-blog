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

    
        <!--
        <div class="event-item disabled" role="button" tabindex="0" aria-disabled="true">
    
    <-- Banner --
    <div class="banner-container">
        <img src="path-to-banner-image.jpg" alt="Event Name" style="width: 100%; height: auto;" />
    </div>

    <-- Brief info --
    <div class="px-3 pt-3 pb-1">
        <h5 class="fw-bold text-secondary" id="eventNameLabel">Event Name</h5>

        <-- Time --
        <div class="small mb-1">
            <i class="fa-regular fa-clock fa-fw" aria-label="Time"></i>&nbsp;Event Time
        </div>

        <-- Location --
        <div class="small mb-1">
            <i class="fa-solid fa-location-dot fa-fw" aria-label="Location"></i>&nbsp;Event Location
        </div>

        <-- Organizer --
        <div class="small mb-1">
            <i class="fa-solid fa-users fa-fw" aria-label="Organizer"></i>&nbsp;Event Organizer
        </div>

        <-- Short description --
        <div class="small mb-1">
            <i class="fa-regular fa-comment fa-fw" aria-label="Short description"></i>&nbsp;Short Description
        </div>
        
        <-- Ticket Info --
        <div class="small mb-1">
            <-- Ticket info placeholder --
            Ticket Information
        </div>
    </div>

    <-- Like button --
    <div class="d-flex justify-content-center mb-3">
        <-- Favorite icon placeholder --
        <span class="favorite-icon"></span>
    </div>
</div>

        -->

        <div class="container-fluid">

            <!-- Hero Section -->
            <div class="p-3 mb-3">
                <?= get_theme_mod('hero'); ?>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 menu-col">
            <?php
                $num_links = get_theme_mod('num_links', 3);
                for ($i = 1; $i <= $num_links; $i++) {
                    $link_text = get_theme_mod("link_{$i}_text", "Link $i");
                    $image_url = get_theme_mod("link_{$i}_image");

                    echo '<div class="link-item p-1" role="button" tabindex="0" aria-disabled="true">';
                    if (!empty($image_url)) {
                        echo '<div class="banner-container">';
                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($link_text) . '">';
                        echo '</div>';
                    }
                    echo '  <span class="text-primary fw-bold">' . esc_attr($link_text) . '</span>';
                    echo '</div>';
                }
                
            ?>

            
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
