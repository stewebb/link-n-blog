<?php

// Delete category
function lnb_delete_category($category_id): mysqli_result|bool|int|null
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->delete($table_categories, ['id' => $category_id], ['%d']);
}