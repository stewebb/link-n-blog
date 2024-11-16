<?php

/**
 * Helper Functions
 */

/**
 * Generate a set of light and dark colors based on the group name.
 *
 * This utility function uses the CRC32 hash of the SHA-256 hash of the group name
 * to calculate a hue value, ensuring consistent color generation for a given name.
 * The generated colors are returned in HSL format.
 *
 * @param string $group_name The name of the group. This is used to derive the colors.
 *
 * @return array An associative array containing:
 *               - 'light' (string): A light pastel color in HSL format (e.g., "hsl(120, 70%, 90%)").
 *               - 'dark' (string): A dark color in HSL format suitable for text or contrasting elements.
 */

function lnb_get_group_colors( string $group_name ): array {

	$hue = crc32(hash('sha512', $group_name)) % 360;
	return [
		'light' => "hsl($hue, 70%, 90%)",
		'dark'  => "hsl($hue, 50%, 30%)"
	];
}
