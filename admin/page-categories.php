<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');

function categories_page()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // TODO Nonce
        // TODO Get category by id
        // TODO If nor found, add it
        // TODO If found, update it
        // TODO Delete part
        // TODO Put update, delete into separate func

        // Add or update
        if (isset($_POST['update_category'])) {
            echo "<div class='updated'><p>Category updated successfully.</p></div>";
        }

        // Delete
        if (isset($_POST['delete_category'])) {
            echo "<div class='updated'><p>Category deleted successfully.</p></div>";
        }
    }
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Categories</h1>
        <hr class="wp-header-end">

        <div class="category-cards-container">
            <?php

            // Update
            $categories = get_category_list();
            if ($categories) {
                foreach ($categories as $category) {
                    ?>
                    <div class="category-card card">
                        <h2 class="card-title">
                            Category #<?php echo esc_html($category->id); ?>
                        </h2>

                        <form method="POST" action="">
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

            // Add
            ?>

            <div class="category-card card">
                <h2 class="card-title">
                    Add a category
                </h2>

                <form method="POST" action="">
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