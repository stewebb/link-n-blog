<?php

// Update category
function lnb_update_category($category_id, $category_name): mysqli_result|bool|int|null
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->update($table_categories, ['name' => $category_name], ['id' => $category_id], ['%s'], ['%d']);
}