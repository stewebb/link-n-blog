<?php

// Add category
function add_category($category_name) {
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->insert($table_categories, ['name' => $category_name], ['%s']);
}