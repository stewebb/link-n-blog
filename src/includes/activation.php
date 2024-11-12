<?php

/**
 * LNB Plugin Database Setup and Integrity Enforcement
 *
 * This class provides the necessary database setup and integrity checks for the LNB (Link 'n' Blog) plugin.
 * It creates the required tables in the WordPress database, inserts default entries, and enforces data integrity
 * through triggers and application logic.
 */

class LNB_Database_Setup
{
    private $wpdb;
    private string $table_categories;
    private string $table_groups;
    private string $table_links;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_categories = $wpdb->prefix . 'lnb_categories';
        $this->table_groups = $wpdb->prefix . 'lnb_groups';
        $this->table_links = $wpdb->prefix . 'lnb_links';
    }

    /**
     * Registers the activation hook to create necessary database tables,
     * insert default entries, and add triggers to prevent deletion of these entries.
     */
    public function setup(): void
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $this->createCategoriesTable();
        $this->createGroupsTable();
        $this->createLinksTable();
        $this->insertDefaultCategory();
        $this->insertDefaultGroup();
        $this->addPreventDeleteTriggers();
    }

    /**
     * Creates the wp_lnb_categories table.
     */
    private function createCategoriesTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_categories} (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            color VARCHAR(7) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        dbDelta($sql);
    }

    /**
     * Creates the wp_lnb_groups table.
     */
    private function createGroupsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_groups} (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            disabled BOOLEAN NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        dbDelta($sql);
    }

    /**
     * Creates the wp_lnb_links table.
     */
    private function createLinksTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_links} (
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
            FOREIGN KEY (category) REFERENCES {$this->table_categories}(id) ON DELETE SET NULL,
            FOREIGN KEY (group_id) REFERENCES {$this->table_groups}(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        dbDelta($sql);
    }

    /**
     * Inserts the default "unCategorized" category if it doesn't exist.
     */
    private function insertDefaultCategory(): void
    {
        $this->wpdb->query(
            $this->wpdb->prepare(
                "INSERT IGNORE INTO {$this->table_categories} (id, name, color, created_at, updated_at)
                VALUES (%d, %s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
                1, 'unCategorized', '#000000'
            )
        );
    }

    /**
     * Inserts the default "Default Group" if it doesn't exist.
     */
    private function insertDefaultGroup(): void
    {
        $this->wpdb->query(
            $this->wpdb->prepare(
                "INSERT IGNORE INTO {$this->table_groups} (id, name, disabled, created_at, updated_at)
                VALUES (%d, %s, %d, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
                1, 'Default Group', 0
            )
        );
    }

    /**
     * Adds triggers to prevent deletion of rows with id = 1 in categories and groups.
     */
    private function addPreventDeleteTriggers(): void
    {
        $trigger_category = "CREATE TRIGGER prevent_delete_uncategorized
            BEFORE DELETE ON {$this->table_categories}
            FOR EACH ROW
            BEGIN
                IF OLD.id = 1 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Cannot delete the uncategorized category';
                END IF;
            END;";

        $trigger_group = "CREATE TRIGGER prevent_delete_default_group
            BEFORE DELETE ON {$this->table_groups}
            FOR EACH ROW
            BEGIN
                IF OLD.id = 1 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Cannot delete the Default Group';
                END IF;
            END;";

        $this->wpdb->query($trigger_category);
        $this->wpdb->query($trigger_group);
    }
}


?>
