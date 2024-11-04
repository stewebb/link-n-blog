<?php

require_once(plugin_dir_path(__FILE__) . '../crud/create.php');
require_once(plugin_dir_path(__FILE__) . '../crud/read.php');
require_once(plugin_dir_path(__FILE__) . '../crud/update.php');
require_once(plugin_dir_path(__FILE__) . '../crud/delete.php');

function categories_page()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Nonce Verification
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'category_action_nonce')) {
            die('Security check failed');
        }

        // Get category ID and name
        $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
        $category_name = !empty($_POST['category_name']) ? sanitize_text_field($_POST['category_name']) : '';

        // Update or Add Category
        if (isset($_POST['update_category'])) {
            if ($category_id) {
                if (lnb_update_category($category_id, $category_name)) {
                    echo "<div class='notice notice-success'><p>Category updated successfully.</p></div>";
                } else {
                    echo "<div class='notice notice-error'><p>Error updating category.</p></div>";
                }
            } else {
                if (lnb_add_category($category_name)) {
                    echo "<div class='notice notice-success'><p>Category added successfully.</p></div>";
                } else {
                    echo "<div class='notice notice-error'><p>Error adding category.</p></div>";
                }
            }
        }

        // Delete Category
        if (isset($_POST['delete_category']) && $category_id) {

            // Check if category is used in links
            if(lnb_get_category_usage_count($category_id) > 0) {
                echo "<div class='notice notice-error'><p>The category is used in $category_id link(s).</p></div>";
            }

            else {
                echo lnb_delete_category($category_id) ? "<div class='notice notice-success'><p>Category deleted successfully.</p></div>" : "<div class='notice notice-error'><p>Error deleting category.</p></div>";
            }

            //if (delete_category($category_id)) {
            //    echo "<div class='notice notice-success'><p>Category deleted successfully.</p></div>";
            //} else {
            //    echo "<div class='notice notice-error'><p>Error deleting category.</p></div>";
            //}
        }
    }
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Manage Categories</h1>
        <hr class="wp-header-end">

        <div class="category-cards-container">
            <?php
            // Display categories with update and delete options
            $categories = lnb_get_category_list();
            if ($categories) {
                foreach ($categories as $category) {
                    $usage_count = lnb_get_category_usage_count($category->id);
                    ?>
                    <div class="category-card">
                        <form method="POST" action="">
                            <?php wp_nonce_field('category_action_nonce'); ?>
                            <input type="hidden" name="category_id" value="<?= esc_attr($category->id); ?>">

                            <table class="form-table">
                                <tr>
                                    <th><label>Category ID</label></th>
                                    <td><?= esc_attr($category->id); ?></td>
                                </tr>
                                <tr>
                                    <th><label for="category-name-<?= esc_attr($category->id); ?>">Name</label></th>
                                    <td>
                                        <input type="text" name="category_name" id="category-name-<?= esc_attr($category->id); ?>" value="<?= esc_attr($category->name); ?>" class="regular-text" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label>Usage Count</label></th>
                                    <td><?= esc_html($usage_count); ?> links</td>
                                </tr>
                            </table>

                            <p class="submit">
                                <button type="submit" name="update_category" class="button button-primary">Update</button>
                                <button type="submit" name="delete_category" class="button"
                                        onclick="return confirm('Are you sure you want to delete this category?');"
                                    <?php echo $usage_count > 0 ? 'disabled' : ''; ?>>
                                    Delete
                                </button>
                            </p>

                        </form>
                    </div>
                    <?php
                }
            }
            ?>

            <!-- Add a New Category -->
            <div class="category-card add-new-category">
                <h2>Add a New Category</h2>
                <form method="POST" action="">
                    <?php wp_nonce_field('category_action_nonce'); ?>
                    <input type="hidden" name="category_id">
                    <table class="form-table">
                        <tr>
                            <th><label for="category_name">Name</label></th>
                            <td><input type="text" name="category_name" id="category_name" class="regular-text" placeholder="Enter category name" required></td>
                        </tr>
                    </table>
                    <p class="submit">
                        <button type="submit" name="update_category" class="button button-primary">Add</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>