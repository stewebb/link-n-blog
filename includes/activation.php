<?php

// Register the activation hook
function create_database_tables(): void
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $table_links = $wpdb->prefix . 'lnb_links';

    // SQL to create wp_lnb_categories table
    $sql_categories = "CREATE TABLE IF NOT EXISTS $table_categories (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // SQL to create wp_lnb_links table
    $sql_links = "CREATE TABLE IF NOT EXISTS $table_links (
        id INT NOT NULL AUTO_INCREMENT,
        link_name VARCHAR(255) NOT NULL,
        label_text VARCHAR(255),
        category INT,
        wp_page_id BIGINT UNSIGNED,
        url VARCHAR(2083) NOT NULL,
        target ENUM('_self', '_blank') DEFAULT '_blank',
        color VARCHAR(7),
        cover_image_id BIGINT UNSIGNED,
        hit_num INT DEFAULT 0,
        last_visit DATETIME NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (category) REFERENCES $table_categories(id)
        ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // Include WordPress's dbDelta function
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute the SQL to create tables
    dbDelta($sql_categories);
    dbDelta($sql_links);
}
