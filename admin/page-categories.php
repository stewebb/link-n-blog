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
                if (update_category($category_id, $category_name)) {
                    echo "<div class='updated'><p>Category updated successfully.</p></div>";
                } else {
                    echo "<div class='error'><p>Error updating category.</p></div>";
                }
            } else {
                if (add_category($category_name)) {
                    echo "<div class='updated'><p>Category added successfully.</p></div>";
                } else {
                    echo "<div class='error'><p>Error adding category.</p></div>";
                }
            }
        }

        // TODO: Delete Category

        if (isset($_POST['delete_category']) && $category_id) {
            if (delete_category($category_id)) {
                echo "<div class='updated'><p>Category deleted successfully.</p></div>";
            } else {
                echo "<div class='error'><p>Error deleting category.</p></div>";
            }
        }
    }
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Categories</h1>
        <hr class="wp-header-end">

        <div class="category-cards-container">
            <?php
            // Display categories with update and delete options
            $categories = get_category_list();
            if ($categories) {
                foreach ($categories as $category) {
                    ?>
                    <div class="category-card card">
                        <h2 class="card-title">
                            Category #<?php echo esc_html($category->id); ?>
                        </h2>

                        <form method="POST" action="">
                            <?php wp_nonce_field('category_action_nonce'); ?>
                            <input type="hidden" name="category_id" value="<?php echo esc_attr($category->id); ?>">
                            <div class="mb-3">
                                <input type="text" name="category_name" class="full-width" placeholder="Update category name" value="<?php echo esc_attr($category->name); ?>" required>
                            </div>
                            <button type="submit" name="update_category" class="button button-primary">Update</button>
                            <button type="submit" name="delete_category" class="button button-secondary">Delete</button>
                        </form>
                    </div>
                    <?php
                }
            }

            // Add a new category
            ?>
            <div class="category-card card">
                <h2 class="card-title">Add a category</h2>

                <form method="POST" action="">
                    <?php wp_nonce_field('category_action_nonce'); ?>
                    <input type="hidden" name="category_id">
                    <div class="mb-3">
                        <input type="text" name="category_name" class="full-width" placeholder="Input category name" required>
                    </div>
                    <button type="submit" name="update_category" class="button button-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
    <?php
}