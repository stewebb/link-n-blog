<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');


function categories_page()
{
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Categories</h1>
        <hr class="wp-header-end">

        <div class="category-cards-container" style="">
            <?php
            $categories = get_category_list();
            if ($categories) {
                foreach ($categories as $category) {
                    ?>
                    <div class="category-card card">
                        <h2 class="card-title" style="margin: 0 0 10px;">Category #<?php echo esc_html($category->id); ?></h2>

                        <!--
                        <label for="category-name-<?php echo esc_attr($category->id); ?>">Name:</label>
                        -->

                        <div class="mb-3">
                            <input type="text" id="category-name-<?php echo esc_attr($category->id); ?>" value="<?php echo esc_attr($category->name); ?>" style="width: 100%;">
                        </div>
                        <button onclick="updateCategory(<?php echo esc_js($category->id); ?>)" class="button button-primary">Update</button>
                        <button onclick="deleteCategory(<?php echo esc_js($category->id); ?>)" class="button button-secondary">Delete</button>
                    </div>
                    <?php
                }
            } else {
                ?>
                <p>No categories found.</p>
                <?php
            }
            ?>
        </div>
    </div>

    <script type="text/javascript">
        function updateCategory(categoryId) {
            const nameInput = document.getElementById(`category-name-${categoryId}`);
            const categoryName = nameInput.value;

            if (!categoryName) {
                alert("Category name cannot be empty!");
                return;
            }

            const data = {
                action: 'update_category_name',
                category_id: categoryId,
                category_name: categoryName,
                _ajax_nonce: '<?php echo wp_create_nonce('update_category_nonce'); ?>'
            };

            jQuery.post(ajaxurl, data, function(response) {
                if (response.success) {
                    alert("Category updated successfully!");
                } else {
                    alert("Error updating category: " + response.data);
                }
            });
        }
    </script>
    <?php
}