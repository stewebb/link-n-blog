/**
 * This class provides methods to manipulate the brightness and contrast of a specific image.
 *
 * Methods include lightening and darkening the image based on a specified percentage.
 * Dependencies: None, but assumes ES6+ JavaScript environment and jQuery.
 *
 * The formulas used for lightening and darkening are:
 * - Lightening: \( brightness = 1 + \frac{percentage}{100} \)
 * - Darkening: \( brightness = 1 - \frac{percentage}{100} \)
 * Where:
 *  - \( brightness \) is the filter applied to control lightness or darkness.
 *  - \( percentage \) is the percentage by which to lighten or darken the image.
 */

class ImageManipulator {
    constructor(imgElement, adjustmentPercentage = 0, isLighten = true) {
        if (!(imgElement instanceof HTMLElement) || imgElement.tagName !== 'IMG') {
            throw new Error("Invalid image element provided.");
        }
        this.imgElement = imgElement;
        this.adjustmentPercentage = adjustmentPercentage;
        this.isLighten = isLighten;
    }

    /**
     * Gets the adjustment percentage value.
     * @returns {number} The percentage by which to adjust brightness and contrast.
     */
    getAdjustmentPercentage() {
        return this.adjustmentPercentage;
    }

    /**
     * Sets the adjustment percentage value.
     * @param {number} percentage The new percentage value.
     */
    setAdjustmentPercentage(percentage) {
        this.adjustmentPercentage = percentage;
    }

    /**
     * Gets the isLighten flag.
     * @returns {boolean} Whether the adjustment is to lighten the image.
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
     * Adjusts the brightness and contrast of the image.
     */
    applyAdjustment() {
        const brightness = this.isLighten
            ? 1 + this.adjustmentPercentage / 100
            : 1 - this.adjustmentPercentage / 100;

        const contrast = this.isLighten
            ? 1 + this.adjustmentPercentage / 200
            : 1 - this.adjustmentPercentage / 200;

        jQuery(this.imgElement).css('filter', `brightness(${brightness}) contrast(${contrast})`);
    }

    /**
     * Lightens the image by the set adjustment percentage.
     */
    lighten() {
        this.setIsLighten(true);
        this.applyAdjustment();
    }

    /**
     * Darkens the image by the set adjustment percentage.
     */
    darken() {
        this.setIsLighten(false);
        this.applyAdjustment();
    }
}

// Export the class if using modules
// export default ImageManipulator;
