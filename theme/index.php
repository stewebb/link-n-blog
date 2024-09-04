<?php

/**
 * Determines the appropriate text color (black or white) based on the background color.
 *
 * This function converts a hexadecimal background color to its RGB components, applies gamma correction
 * to linearize the RGB values, calculates the luminance of the background color, and then returns 'black'
 * or 'white' as the text color based on the luminance value.
 *
 * The gamma correction formula used to convert from gamma-corrected (sRGB) to linear values is:
 *
 * \[
 * C_{\text{linear}} = \begin{cases}
 * \frac{C}{12.92} & \text{if } C \leq 0.03928 \\
 * \left(\frac{C + 0.055}{1.055}\right)^{2.4} & \text{if } C > 0.03928
 * \end{cases}
 * \]
 *
 * Where \( C \) is the normalized color component (0 to 1), and \( C_{\text{linear}} \) is the gamma-corrected
 * color component.
 *
 * The luminance \( L \) of the color is calculated using the gamma-corrected RGB values as follows:
 *
 * \[
 * L = 0.2126 \times R_{\text{linear}} + 0.7152 \times G_{\text{linear}} + 0.0722 \times B_{\text{linear}}
 * \]
 *
 * Where \( R_{\text{linear}} \), \( G_{\text{linear}} \), and \( B_{\text{linear}} \) are the linearized RGB values.
 *
 * If the luminance \( L \) is greater than or equal to 0.5, the function returns 'black'; otherwise, it returns 'white'.
 *
 * @param string $hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
 * @return string|false Returns 'black' or 'white' based on the luminance, or `false` if the hex color code is invalid.
 */


function getTextColorBasedOnBackground($hex) {
    // Remove '#' if present
    $hex = ltrim($hex, '#');
    
    // Convert hex to RGB
    if (strlen($hex) == 6) {
        list($r, $g, $b) = str_split($hex, 2);
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
    } elseif (strlen($hex) == 3) {
        list($r, $g, $b) = str_split($hex, 1);
        $r = hexdec($r . $r);
        $g = hexdec($g . $g);
        $b = hexdec($b . $b);
    } else {
        // Invalid hex color
        return false;
    }
    
    // Convert RGB to normalized values
    $r = $r / 255;
    $g = $g / 255;
    $b = $b / 255;

    // Apply gamma correction
    $r = ($r <= 0.03928) ? ($r / 12.92) : pow(($r + 0.055) / 1.055, 2.4);
    $g = ($g <= 0.03928) ? ($g / 12.92) : pow(($g + 0.055) / 1.055, 2.4);
    $b = ($b <= 0.03928) ? ($b / 12.92) : pow(($b + 0.055) / 1.055, 2.4);

    // Calculate luminance
    $luminance = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;

    // Determine text color based on luminance
    return ($luminance >= 0.5) ? 'black' : 'white';
}

/**
 * Lightens a given hexadecimal color by a specified percentage.
 *
 * This function takes a hexadecimal color code and a percentage value. It lightens the color
 * by increasing the RGB values based on the percentage, and returns the new color as a hexadecimal code.
 *
 * @param string $hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
 * @param float $percentage The percentage to lighten the color by (e.g., 20 for 20%).
 * @return string The lightened color in hexadecimal format.
 */
function lightenColor($hex, $percentage) {
    // Remove '#' if present
    $hex = ltrim($hex, '#');

    // Convert hex to RGB
    if (strlen($hex) == 6) {
        list($r, $g, $b) = str_split($hex, 2);
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
    } elseif (strlen($hex) == 3) {
        list($r, $g, $b) = str_split($hex, 1);
        $r = hexdec($r . $r);
        $g = hexdec($g . $g);
        $b = hexdec($b . $b);
    } else {
        // Invalid hex color
        return $hex;
    }

    // Convert percentage to a decimal
    $percentage = $percentage / 100;

    // Lighten the RGB values
    $r = min(255, round($r + (255 - $r) * $percentage));
    $g = min(255, round($g + (255 - $g) * $percentage));
    $b = min(255, round($b + (255 - $b) * $percentage));

    // Convert RGB back to hex
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

                    <div class="overlay" 
                        onmouseover="this.style.backgroundColor='<?=lightenColor($link_color, 40) ?>';"
                        onmouseout="this.style.backgroundColor=='';"
                    >
                        <?php $bgcolor = getTextColorBasedOnBackground($link_color); ?>
                        <button class="btn" style="border: 1px solid <?= $bgcolor ?>; color: <?= $bgcolor ?>;">Custom Button</button>
                    </div>
                    <?php
                    echo '<span class="fw-bold text-primary" style="color:' . esc_attr($link_color) . '!important;">' . esc_attr($link_text) . '</span>';
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
