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
    constructor(hex, percentage = 0, isLighten = true) {
        this.setColor(hex);
        this.percentage = percentage;
        this.isLighten = isLighten;
    }

    /**
     * Sets the color to be manipulated.
     *
     * @param {string} hex The hexadecimal color code (e.g., "#ff5733" or "ff5733").
     */

    setColor(hex) {
        this.hex = hex.replace('#', '');
    }

    /**
     * Gets the percentage value.
     * @returns {number} The percentage by which to lighten or darken.
     */

    getPercentage() {
        return this.percentage;
    }

    /**
     * Sets the percentage value.
     * @param {number} percentage The new percentage value.
     */

    setPercentage(percentage) {
        this.percentage = percentage;
    }

    /**
     * Gets the isLighten flag.
     * @returns {boolean} Whether the adjustment is to lighten the color.
     */

    getIsLighten() {
        return this.isLighten;
    }

    /**
     * Sets the isLighten flag.
     * @param {boolean} isLighten The new isLighten value.
     */

    setIsLighten(isLighten) {
        this.isLighten = isLighten;
    }

    /**
     * Adjusts the color based on the current percentage and isLighten settings.
     * @returns {string} The adjusted color in hexadecimal format.
     */

    adjustColor() {
        return this.adjustColorBrightness(this.hex, this.percentage, this.isLighten);
    }

    /**
     * Lightens the current color by the specified percentage.
     * @param {number} percentage Optional percentage to lighten the color.
     * @returns {string} The lightened color in hexadecimal format.
     */

    lighten(percentage = this.percentage) {
        this.isLighten = true;
        this.percentage = percentage;
        return this.adjustColor();
    }

    /**
     * Darkens the current color by the specified percentage.
     * @param {number} percentage Optional percentage to darken the color.
     * @returns {string} The darkened color in hexadecimal format.
     */

    darken(percentage = this.percentage) {
        this.isLighten = false;
        this.percentage = percentage;
        return this.adjustColor();
    }

    /**
     * Adjusts the brightness of the color by lightening or darkening.
     *
     * @param {string} hex The hexadecimal color code.
     * @param {number} percentage The percentage to adjust the brightness by.
     * @param {boolean} isLighten Determines if the adjustment is to lighten (true) or darken (false).
     * @returns {string} The adjusted color in hexadecimal format.
     */

    adjustColorBrightness(hex, percentage, isLighten) {
        let { r, g, b } = this.hexToRgb(hex);
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

        return this.rgbToHex(r, g, b);
    }

    /**
     * Converts a hexadecimal color to an RGB object.
     *
     * @param {string} hex The hexadecimal color code.
     * @returns {Object} An object containing the red, green, and blue values.
     */

    hexToRgb(hex) {
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
            throw new Error("Invalid hex color format.");
        }
        return { r, g, b };
    }

    /**
     * Converts RGB values to a hexadecimal color string.
     *
     * @param {number} r Red component (0-255).
     * @param {number} g Green component (0-255).
     * @param {number} b Blue component (0-255).
     * @returns {string} The color in hexadecimal format.
     */

    rgbToHex(r, g, b) {
        return `#${[r, g, b].map(x => x.toString(16).padStart(2, '0')).join('')}`;
    }
}
