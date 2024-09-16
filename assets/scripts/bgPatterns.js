// utils.js

function bgPatterns(seed, color) {
    const pattern = Trianglify({
        width: 800,
        height: 600,
        seed: seed,
        xColors: color,  // You can pass a specific color or a color palette
    });

    return pattern.toCanvas(); // Returns a Canvas element
}