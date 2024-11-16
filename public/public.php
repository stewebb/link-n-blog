<?php

function helloworld_shortcode() {
    return "<p>Hello, World!</p>";
}
add_shortcode('helloworld', 'helloworld_shortcode');
