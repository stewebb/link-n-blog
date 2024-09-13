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
        return 'dark';
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
    return ($luminance >= 0.5) ? 'dark' : 'light';
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