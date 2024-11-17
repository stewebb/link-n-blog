<?php

/**
 * Generate an HTML alert for a "not found" message.
 *
 * @param string $title The title of the alert.
 * @param string $description The description of the alert.
 *
 * @return string The generated HTML for the "not found" alert.
 */

function not_found_page( string $title, string $description ): string {
	return <<<HTML
    <div class="container mt-5">
        <div class="alert alert-secondary text-center" role="alert">
            <h4 class="alert-heading">{$title}</h4>
            <p>{$description}</p>
        </div>
    </div>
    HTML;
}
