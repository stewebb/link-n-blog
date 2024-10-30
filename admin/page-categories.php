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

        // Delete Category
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
                    $usage_count = get_category_usage_count($category->id);
                    ?>
                    <div class="category-card card">
                        <form method="POST" action="">
                            <?php wp_nonce_field('category_action_nonce'); ?>
                            <input type="hidden" name="category_id" value="<?= esc_attr($category->id); ?>">


                            <h2 class="card-title">Edit category: <?= esc_attr($category->name);  ?></h2>
                            <!--
                            <p>Used in <?php echo esc_html($usage_count); ?> links</p>
                            -->

                            <table class="form-table">

                                <tr>
                                    <th scope="row">
                                        <label>Category ID</label>
                                    </th>
                                    <td><?= esc_attr($category->id) ?></td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        <label for="category-name-<?= esc_attr($category->id); ?>">Name</label>
                                    </th>
                                    <td>
                                        <input type="text" name="category_name" id="category-name-<?= esc_attr($category->id); ?>" value="<?=esc_attr($category->name); ?>" class="full-width" required>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                        <label>Usage Count</label>
                                    </th>
                                    <td>
                                        <?= esc_html($usage_count) ?> links
                                    </td>
                                </tr>
                            </table>

                            <p class="submit">
                                <button type="submit" name="update_category" class="button button-primary">Update</button>
                                <button type="submit" name="delete_category" class="button button-secondary">Delete</button>
                            </p>
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

                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="category_name">Name</label>
                            </th>
                            <td>
                                <input type="text" name="category_name" id="category_name" class="regular-text" placeholder="Input category name" required>
                            </td>
                        </tr>

                        <!--
                        <tr>
                            <th scope="row">
                                <label for="url">URL</label>
                            </th>
                            <td>
                                <input type="url" name="url" id="url" class="regular-text" placeholder="Input category URL" required>
                            </td>
                        </tr>
                        -->
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