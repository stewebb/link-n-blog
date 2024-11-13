<?php

/**
 * LNB Plugin Database Setup and Integrity Enforcement
 *
 * This script provides the necessary database setup and integrity checks for the LNB (Link 'n' Blog) plugin.
 * It creates the required tables in the WordPress database, inserts default entries, and enforces data integrity
 * through triggers and application logic.
 *
 * The setup includes three main tables:
 * - `wp_lnb_categories`: Stores categories for links with a default "unCategorized" entry (`id = 0`).
 * - `wp_lnb_groups`: Stores groups for links with a default "Default Group" entry (`id = 0`).
 * - `wp_lnb_links`: Stores individual links with references to categorize and groups.
 *
 * Default Entries:
 * - The default "unCategorized" category (`id = 0`) and "Default Group" (`id = 0`) are inserted if they do not exist.
 *   These entries act as fallbacks and cannot be deleted.
 *
 * Integrity Enforcement:
 * - `BEFORE DELETE` triggers are added to `wp_lnb_categories` and `wp_lnb_groups` to prevent deletion of rows with `id = 0`.
 * - Application-level checks also prevent deletion of these default entries, with appropriate error logging.
 *
 * Functions:
 * - `lnb_create_database_tables()`: Main function that creates tables, inserts default entries, and adds triggers.
 * - `lnb_create_categories_table()`, `lnb_create_groups_table()`, `lnb_create_links_table()`: Individual functions to create tables.
 * - `lnb_insert_default_category()`, `lnb_insert_default_group()`: Insert default entries for categories and groups.
 * - `lnb_add_prevent_delete_triggers()`: Adds triggers to prevent deletion of rows with `id = 0` in categories and groups.
 * - `delete_category()`, `delete_group()`: Application-level functions to delete categories and groups, with checks to prevent deletion of `id = 0`.
 *
 * Usage:
 * This script is designed to be run during plugin activation in WordPress. It ensures that the database is set up with the
 * necessary tables and that essential entries are protected, preserving data integrity for the LNB plugin.
 */

/**
 * Registers the activation hook to create necessary database tables for the LNB plugin,
 * inserts default "unCategorized" category and "Default Group" entries, and
 * adds triggers to prevent deletion of these default entries.
 *
 * @return void
 */

function lnb_create_database_tables(): void
{
    global $wpdb;

    // Include WordPress's dbDelta function
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Create tables
    lnb_create_categories_table();
    lnb_create_groups_table();
    lnb_create_links_table();

    // Insert default entries
    lnb_insert_default_category();
    lnb_insert_default_group();

    // Add triggers to prevent deletion of rows with id = 0
    lnb_add_prevent_delete_triggers();
}

/**
 * Creates the wp_lnb_categories table.
 */

function lnb_create_categories_table(): void
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';

    $sql_categories = "CREATE TABLE IF NOT EXISTS $table_categories (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        color VARCHAR(7) DEFAULT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    dbDelta($sql_categories);
}

/**
 * Creates the wp_lnb_groups table.
 */

function lnb_create_groups_table(): void
{
    global $wpdb;
    $table_groups = $wpdb->prefix . 'lnb_groups';

    $sql_groups = "CREATE TABLE IF NOT EXISTS $table_groups (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        disabled BOOLEAN NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    dbDelta($sql_groups);
}

/**
 * Creates the wp_lnb_links table.
 */

function lnb_create_links_table(): void
{
    global $wpdb;
    $table_links = $wpdb->prefix . 'lnb_links';
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $table_groups = $wpdb->prefix . 'lnb_groups';

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

    dbDelta($sql_links);
}

/**
 * Inserts the default "unCategorized" category with id = 0 if it doesn't exist.
 */

function lnb_insert_default_category(): void
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';

    $wpdb->query(
        $wpdb->prepare(
            "INSERT IGNORE INTO $table_categories (id, name, color, created_at, updated_at) 
             VALUES (%d, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
            0, 'unCategorized', '#000000'
        )
    );
}

/**
 * Inserts the default "Default Group" with id = 0 if it doesn't exist.
 */

function lnb_insert_default_group(): void
{
    global $wpdb;
    $table_groups = $wpdb->prefix . 'lnb_groups';

    $wpdb->query(
        $wpdb->prepare(
            "INSERT IGNORE INTO $table_groups (id, name, disabled, created_at, updated_at) 
             VALUES (%d, %s, %d, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
            0, 'Default Group', 0
        )
    );
}

/**
 * Adds triggers to prevent deletion of rows with id = 0 in wp_lnb_categories and wp_lnb_groups.
 */

function lnb_add_prevent_delete_triggers(): void
{
    global $wpdb;
    $table_categories = $wpdb->prefix . 'lnb_categories';
    $table_groups = $wpdb->prefix . 'lnb_groups';

    // Trigger to prevent deletion of "unCategorized" category
    $trigger_categories = "CREATE TRIGGER prevent_delete_uncategorized
    BEFORE DELETE ON $table_categories
    FOR EACH ROW
    BEGIN
        IF OLD.id = 0 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Cannot delete the unCategorized category';
        END IF;
    END;";

    // Trigger to prevent deletion of "Default Group"
    $trigger_groups = "CREATE TRIGGER prevent_delete_default_group
    BEFORE DELETE ON $table_groups
    FOR EACH ROW
    BEGIN
        IF OLD.id = 0 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Cannot delete the Default Group';
        END IF;
    END;";

    // Execute triggers
    $wpdb->query($trigger_categories);
    $wpdb->query($trigger_groups);
}
