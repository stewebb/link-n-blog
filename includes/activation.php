<?php

/**
 * Registers the activation hook to create necessary database tables for the LNB plugin,
 * and inserts default "unCategorized" category and "Default Group" entries.
 *
 * @return void
 */
function lnb_create_database_tables(): void
{
    global $wpdb;

    // Define table names with prefix
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_groups = $wpdb->prefix . 'lnb_groups';

    // SQL to create wp_lnb_categories table
    $sql_categories = "CREATE TABLE IF NOT EXISTS $table_categories (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        color VARCHAR(7) DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // SQL to create wp_lnb_groups table
    $sql_groups = "CREATE TABLE IF NOT EXISTS $table_groups (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        disabled BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // SQL to create wp_lnb_links table
    $sql_links = "CREATE TABLE IF NOT EXISTS $table_links (
        id INT NOT NULL AUTO_INCREMENT,
        link_name VARCHAR(255) NOT NULL,
        label_text VARCHAR(255),
        category INT,
        group_id INT,
        wp_page_id BIGINT UNSIGNED,
        url VARCHAR(2083) NOT NULL,
        target ENUM('_self', '_blank') DEFAULT '_blank',
        color VARCHAR(7),
        cover_image_id BIGINT UNSIGNED,
        hit_num INT DEFAULT 0,
        last_visit DATETIME NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        display TINYINT NOT NULL DEFAULT 1,
        PRIMARY KEY (id),
        FOREIGN KEY (category) REFERENCES $table_categories(id) ON DELETE SET NULL,
        FOREIGN KEY (group_id) REFERENCES $table_groups(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    // Include WordPress's dbDelta function
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Execute the SQL to create tables
    dbDelta($sql_categories);
    dbDelta($sql_groups);
    dbDelta($sql_links);

    // Insert the default "unCategorized" category with id = 0 if it doesn't exist
    $wpdb->query(
        $wpdb->prepare(
            "INSERT IGNORE INTO $table_categories (id, name, color, created_at, updated_at) 
             VALUES (%d, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
            0, 'unCategorized', '#000000'
        )
    );

    // Insert the default "Default Group" with id = 0 if it doesn't exist
    $wpdb->query(
        $wpdb->prepare(
            "INSERT IGNORE INTO $table_groups (id, name, disabled, created_at, updated_at) 
             VALUES (%d, %s, %d, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
            0, 'Default Group', 0
        )
    );
}
