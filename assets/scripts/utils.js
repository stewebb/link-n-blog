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
