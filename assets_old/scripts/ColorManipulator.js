/**
 * This class provides methods to manipulate the brightness of hexadecimal colors.
 * 
 * Methods include lightening and darkening the color based on a specified percentage.
 * Dependencies: None, but assumes ES6+ JavaScript environment for proper function.
 *
 * The formulas used for lightening and darkening are:
 * - Lightening: \( C_{new} = C + (255 - C) \times \frac{percentage}{100} \)
 * - Darkening: \( C_{new} = C \times \left(1 - \frac{percentage}{100}\right) \)
 * Where:
 *  - \( C \) is the original color component (Red, Green, or Blue).
 *  - \( C_{new} \) is the adjusted color component.
 *  - \( percentage \) is the percentage by which to lighten or darken the color.
 */

class ColorManipulator {
    
    /**
     * Lightens a given hexadecimal color by a specified percentage.
     *
     * @param {string} hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
     * @param {number} percentage The percentage to lighten the color by (e.g., 20 for 20%).
     * @returns {string} The lightened color in hexadecimal format.
     */

    lighten(hex, percentage) {
        return this.adjustColorBrightness(hex, percentage, true);
    }

    /**
     * Darkens a given hexadecimal color by a specified percentage.
     *
     * @param {string} hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
     * @param {number} percentage The percentage to darken the color by (e.g., 20 for 20%).
     * @returns {string} The darkened color in hexadecimal format.
     */

    darken(hex, percentage) {
        return this.adjustColorBrightness(hex, percentage, false);
    }

    /**
     * Adjusts the brightness of a color either by lightening or darkening.
     *
     * @param {string} hex The hexadecimal color code.
     * @param {number} percentage The percentage to adjust the brightness by.
     * @param {boolean} isLighten Determines if the adjustment is to lighten (true) or darken (false).
     * @returns {string} The adjusted color in hexadecimal format.
     */

    adjustColorBrightness(hex, percentage, isLighten) {
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

        // Convert percentage to a decimal and determine factor based on isLighten
        const factor = percentage / 100;
        if (isLighten) {
            r = Math.min(255, Math.round(r + (255 - r) * factor));
            g = Math.min(255, Math.round(g + (255 - g) * factor));
            b = Math.min(255, Math.round(b + (255 - b) * factor));
        } else {
            r = Math.max(0, Math.round(r * (1 - factor)));
            g = Math.max(0, Math.round(g * (1 - factor)));
            b = Math.max(0, Math.round(b * (1 - factor)));
        }

        // Convert RGB back to hex
        return `#${[r, g, b].map(x => x.toString(16).padStart(2, '0')).join('')}`;
    }
}