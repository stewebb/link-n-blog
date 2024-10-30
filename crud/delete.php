<?php

// Delete category
function delete_category($category_id) {
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    return $wpdb->delete($table_categories, ['id' => $category_id], ['%d']);
}