/**
 * This class provides methods to manipulate the brightness of hexadecimal colors.
 *
 * Methods include lightening and darkening the color based on a specified percentage.
 */

class ColorManipulator {
    /**
     * Lightens a given hexadecimal color by a specified percentage.
     *
     * @param {string} hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
     * @param {number} percentage The percentage to lighten the color by (e.g., 20 for 20%).
     * @returns {string} The lightened color in hexadecimal format.
     */
    lightenColor(hex, percentage) {
        return this.adjustColorBrightness(hex, percentage, 'lighten');
    }

    /**
     * Darkens a given hexadecimal color by a specified percentage.
     *
     * @param {string} hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
     * @param {number} percentage The percentage to darken the color by (e.g., 20 for 20%).
     * @returns {string} The darkened color in hexadecimal format.
     */
    darkenColor(hex, percentage) {
        return this.adjustColorBrightness(hex, percentage, 'darken');
    }

    /**
     * Adjusts the brightness of a color either by lightening or darkening.
     *
     * @param {string} hex The hexadecimal color code.
     * @param {number} percentage The percentage to adjust the brightness by.
     * @param {string} mode Either "lighten" or "darken".
     * @returns {string} The adjusted color in hexadecimal format.
     */
    adjustColorBrightness(hex, percentage, mode) {
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
            // Return the original hex if it's invalid
            return `#${hex}`;
        }

        // Convert percentage to a decimal and determine factor based on mode
        const factor = percentage / 100;
        if (mode === 'lighten') {
            r = Math.min(255, Math.round(r + (255 - r) * factor));
            g = Math.min(255, Math.round(g + (255 - g) * factor));
            b = Math.min(255, Math.round(b + (255 - b) * factor));
        } else if (mode === 'darken') {
            r = Math.max(0, Math.round(r * (1 - factor)));
            g = Math.max(0, Math.round(g * (1 - factor)));
            b = Math.max(0, Math.round(b * (1 - factor)));
        }

        // Convert RGB back to hex
        return `#${[r, g, b].map(x => x.toString(16).padStart(2, '0')).join('')}`;
    }
}
