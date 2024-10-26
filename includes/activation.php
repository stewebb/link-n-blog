<?php

// Register the activation hook
function create_database_tables(): void
{

    //echo "hello";

    global $wpdb;
    $wpdb->show_errors();

    // Define table names
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
        url VARCHAR(2083),
        target ENUM('_self', '_blank') DEFAULT '_self',
        color VARCHAR(7),
        cover_image_id BIGINT UNSIGNED,
        PRIMARY KEY (id),
        FOREIGN KEY (category) REFERENCES $table_categories(id)
        ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // Include WordPress's dbDelta function
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute the SQL to create tables
    dbDelta($sql_categories);
    dbDelta($sql_links);
    //$wpdb->print_error();

    if ($wpdb->last_error) {
        error_log("Database error during plugin activation: " . $wpdb->last_error);
    } else {
        error_log("Plugin activated successfully - tables created or already exist.");
    }
}