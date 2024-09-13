/**
 * Determines the appropriate text color (dark or light) based on the background color.
 *
 * This function converts a hexadecimal background color to its RGB components, applies gamma correction
 * to linearize the RGB values, calculates the luminance of the background color, and then returns 'dark'
 * or 'light' as the text color based on the luminance value.
 *
 * The gamma correction formula used to convert from gamma-corrected (sRGB) to linear values is:
 * C_linear = C <= 0.03928 ? C / 12.92 : ((C + 0.055) / 1.055) ** 2.4
 * where C is the normalized color component (0 to 1).
 *
 * The luminance L of the color is calculated using the gamma-corrected RGB values as follows:
 * L = 0.2126 * R_linear + 0.7152 * G_linear + 0.0722 * B_linear
 * where R_linear, G_linear, and B_linear are the linearized RGB values.
 *
 * If the luminance L is greater than or equal to 0.5, the function returns 'dark'; otherwise, it returns 'light'.
 *
 * @param {string} hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
 * @returns {string} Returns 'dark' or 'light' based on the luminance, or 'invalid' if the hex color code is invalid.
 */

function getTextColorBasedOnBackground(hex) {
    
    // Remove '#' if present
    hex = hex.replace('#', '');
    
    // Convert hex to RGB
    let r, g, b;
    if (hex.length === 6) {
        r = parseInt(hex.substring(0, 2), 16);
        g = parseInt(hex.substring(2, 4), 16);
        b = parseInt(hex.substring(4, 6), 16);
    } else if (hex.length === 3) {
        r = parseInt(hex[0] + hex[0], 16);
        g = parseInt(hex[1] + hex[1], 16);
        b = parseInt(hex[2] + hex[2], 16);
    } else {
        return 'invalid';
    }

    // Convert RGB to normalized values
    r = r / 255;
    g = g / 255;
    b = b / 255;

    // Apply gamma correction
    r = (r <= 0.03928) ? (r / 12.92) : ((r + 0.055) / 1.055) ** 2.4;
    g = (g <= 0.03928) ? (g / 12.92) : ((g + 0.055) / 1.055) ** 2.4;
    b = (b <= 0.03928) ? (b / 12.92) : ((b + 0.055) / 1.055) ** 2.4;

    // Calculate luminance
    const luminance = 0.2126 * r + 0.7152 * g + 0.0722 * b;

    // Determine text color based on luminance
    return (luminance >= 0.5) ? 'dark' : 'light';
}

/**
 * Lightens a given hexadecimal color by a specified percentage.
 *
 * This function takes a hexadecimal color code and a percentage value. It lightens the color
 * by increasing the RGB values based on the percentage, and returns the new color as a hexadecimal code.
 *
 * @param {string} hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
 * @param {number} percentage The percentage to lighten the color by (e.g., 20 for 20%).
 * @returns {string} The lightened color in hexadecimal format.
 */

function lightenColor(hex, percentage) {
    // Remove '#' if present
    hex = hex.replace('#', '');

    // Convert hex to RGB
    let r, g, b;
    if (hex.length === 6) {
        r = parseInt(hex.substring(0, 2), 16);
        g = parseInt(hex.substring(2, 4), 16);
        b = parseInt(hex.substring(4, 6), 16);
    } else if (hex.length === 3) {
        r = parseInt(hex[0] + hex[0], 16);
        g = parseInt(hex[1] + hex[1], 16);
        b = parseInt(hex[2] + hex[2], 16);
    } else {
        // Invalid hex color
        return `#${hex}`;
    }

    // Convert percentage to a decimal
    const factor = percentage / 100;

    // Lighten the RGB values
    r = Math.min(255, Math.round(r + (255 - r) * factor));
    g = Math.min(255, Math.round(g + (255 - g) * factor));
    b = Math.min(255, Math.round(b + (255 - b) * factor));

    // Convert RGB back to hex
    return `#${[r, g, b].map(x => x.toString(16).padStart(2, '0')).join('')}`;
}
