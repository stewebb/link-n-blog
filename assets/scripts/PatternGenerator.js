/**
 * PatternGenerator class to create and draw patterns on a canvas element using the Patternomaly library.
 * 
 * This class allows the generation of a variety of pattern-filled canvases. It utilizes the Patternomaly
 * library to draw complex canvas patterns. Each pattern is determined based on a seed string that influences 
 * which pattern is chosen. The choice of patterns includes geometric shapes and lines such as plus signs, crosses, dots, and more.
 *
 * Dependencies:
 * - Patternomaly 1.3.2: <script src="https://cdn.jsdelivr.net/npm/patternomaly@1.3.2/dist/patternomaly.js"></script>
 * - It is recommended to include a version of jQuery if DOM manipulation beyond simple canvas operations is required.
 * 
 * @constructor
 * @param {string} color - The base color used to fill the pattern. This should be a valid CSS color string.
 * 
 * @example
 * const patternGenerator = new PatternGenerator('#FF6347');
 * patternGenerator.drawPattern('myCanvas', 'exampleSeed');
 */

class PatternGenerator {

    /**
     * Creates an instance of PatternGenerator with a specified color.
     * @param {string} color - The color to use for the pattern fill.
     */

    constructor(color) {
        this.color = color;
        this.patterns = [
            'plus', 'cross', 'dash', 'cross-dash', 'dot', 
            'dot-dash', 'disc', 'ring', 'line', 'line-vertical', 
            'weave', 'zigzag', 'zigzag-vertical'
        ];
    }

    /**
     * Generates a simple hash from a string to use for pattern selection.
     * This hash function converts a string into a 32-bit integer hash.
     * 
     * @param {string} str - The string to hash.
     * @returns {number} A positive integer hash of the input string.
     */

    simpleHash(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            const char = str.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash |= 0; // Convert to 32bit integer
        }
        return Math.abs(hash);
    }

    /**
     * Selects a pattern based on a hashed seed string.
     * This method calculates a hash from the seed and uses it to select a pattern from the list.
     * 
     * @param {string} seed - The seed string to hash for pattern selection.
     * @returns {CanvasPattern} A CanvasPattern object filled with the selected pattern and color.
     */

    selectPattern(seed) {
        const hash = this.simpleHash(seed);
        const patternIndex = hash % this.patterns.length;
        return pattern.draw(this.patterns[patternIndex], this.color);
    }

    /**
     * Draws the selected pattern on a canvas.
     * This method retrieves a canvas by its ID, hashes a provided seed string, selects a pattern, and fills the canvas with it.
     * If the canvas is not found, logs an error to the console.
     * 
     * @param {string} canvasId - The ID of the canvas element on which to draw.
     * @param {string} seed - The seed string used to select the pattern.
     * @param {int} width - The width of the canvas.
     * @param {int} height - The height of the canvas.
     */

    drawPattern(canvasId, seed, width, height) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.error('Canvas with id "' + canvasId + '" not found.');
            return;
        }
        //const canvas_size = Math.max(canvas.width, canvas.height);

        const ctx = canvas.getContext('2d');
        ctx.fillStyle = this.selectPattern(seed);
        ctx.fillRect(0, 0, width, height);
        //console.log(canvas_size);
    }
}
