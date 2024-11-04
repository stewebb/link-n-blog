<?php

// Add category
function lnb_add_category($category_name): mysqli_result|bool|int|null
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->insert($table_categories, ['name' => $category_name], ['%s']);
}