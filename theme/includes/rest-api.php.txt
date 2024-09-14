<?php

// Valid constant names
//define("THEME_NAME",     "mytheme");

// Register REST API routes
add_action('rest_api_init', function () {
    // Route to get custom links
    register_rest_route('mytheme/v1', '/links/', array(
        'methods'  => 'GET',
        'callback' => 'mytheme_get_links',
    ));

    // Route to update custom links
    register_rest_route('mytheme/v1', '/links/', array(
        'methods'  => 'POST',
        'callback' => 'mytheme_update_links',
        'permission_callback' => function () {
            return current_user_can('edit_theme_options');
        },
    ));
});

// Callback to get custom links
function mytheme_get_links() {
    $num_links = get_theme_mod('num_links', 3);
    $links = array();

    for ($i = 1; $i <= $num_links; $i++) {
        $links[] = array(
            'text'      => get_theme_mod("link_{$i}_text", ''),
            'url'       => get_theme_mod("link_{$i}_url", ''),
            'internal'  => get_theme_mod("link_{$i}_internal", ''),
            'color'     => get_theme_mod("link_{$i}_color", '#E61F93'),
            'image'     => get_theme_mod("link_{$i}_image", ''),
        );
    }

    return new WP_REST_Response($links, 200);
}

// Callback to update custom links
function mytheme_update_links(WP_REST_Request $request) {
    $params = $request->get_json_params();
    $num_links = isset($params['num_links']) ? absint($params['num_links']) : 3;

    set_theme_mod('num_links', $num_links);

    for ($i = 1; $i <= $num_links; $i++) {
        if (isset($params["link_{$i}_text"])) {
            set_theme_mod("link_{$i}_text", sanitize_text_field($params["link_{$i}_text"]));
        }
        if (isset($params["link_{$i}_url"])) {
            set_theme_mod("link_{$i}_url", esc_url_raw($params["link_{$i}_url"]));
        }
        if (isset($params["link_{$i}_color"])) {
            set_theme_mod("link_{$i}_color", sanitize_hex_color($params["link_{$i}_color"]));
        }
        if (isset($params["link_{$i}_image"])) {
            set_theme_mod("link_{$i}_image", esc_url_raw($params["link_{$i}_image"]));
        }
    }

    return new WP_REST_Response('Links updated successfully', 200);
}
