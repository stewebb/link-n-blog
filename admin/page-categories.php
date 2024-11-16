<?php

//require_once( plugin_dir_path( __FILE__ ) . '../model/links.php' );
//require_once( plugin_dir_path( __FILE__ ) . '../model/categories.php' );

// Update categories_page to ensure colors are added/modified
function categories_page(): void {

	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

		// Nonce Verification
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'category_action_nonce' ) ) {
			die( 'Security check failed' );
		}

		// Get category ID, name, and color
		$category_id   = ! empty( $_POST['category_id'] ) ? intval( $_POST['category_id'] ) : null;
		$category_name = ! empty( $_POST['category_name'] ) ? sanitize_text_field( $_POST['category_name'] ) : '';
		$color         = ! empty( $_POST['color'] ) ? sanitize_hex_color( $_POST['color'] ) : '';

		// Update or Add Category
		if ( isset( $_POST['update_category'] ) ) {

			// Update
			if ( $category_id ) {
				if ( lnb_update_category( $category_id, $category_name, $color ) ) {
					echo "<div class='notice notice-success'><p>Category updated successfully.</p></div>";
				} else {
					echo "<div class='notice notice-error'><p>Error updating category.</p></div>";
				}
			}

			// Add
			else {
				if ( lnb_add_category( $category_name, $color ) ) {
					echo "<div class='notice notice-success'><p>Category added successfully.</p></div>";
				} else {
					echo "<div class='notice notice-error'><p>Error adding category.</p></div>";
				}
			}
		}

		// Delete Category
		if ( isset( $_POST['delete_category'] ) && $category_id ) {
			if ( $category_id == 1 ) {
				echo "<div class='notice notice-error'><p>The category with ID 1 cannot be deleted.</p></div>";
			} else {

				// Check if category is used in links
				$usage_count = lnb_get_category_usage_count( $category_id );
				if ( $usage_count> 0 ) {
					echo "<div class='notice notice-error'><p>This category is used in $usage_count link(s).</p></div>";
				} else {
					echo lnb_delete_category( $category_id ) ? "<div class='notice notice-success'><p>Category deleted successfully.</p></div>" : "<div class='notice notice-error'><p>Error deleting category.</p></div>";
				}
			}
		}
	}
	?>

    <div class="wrap">
        <h1 class="wp-heading-inline">Manage Categories</h1>
        <hr class="wp-header-end">

        <div class="lnb-card-container">
			<?php

			// Display categories with update and delete options
			$categories = lnb_get_category_list();
			if ( $categories ) {
				foreach ( $categories as $category ) {
                    $usage_count = lnb_get_category_usage_count($category->id);
                    $usage_details = lnb_get_links_by_category($category->id);

                    $default_category = $category->id == 1;
                    $empty_category = $usage_count == 0;
					$cannot_be_deleted = $default_category || !$empty_category;
					?>

                    <div class="lnb-card" id="category-<?= esc_attr( $category->id ); ?>">
                        <form method="POST" action="">
							<?php wp_nonce_field( 'category_action_nonce' ); ?>
                            <input type="hidden" name="category_id" value="<?= esc_attr( $category->id ); ?>">

                            <!-- Card Header with Category ID -->
                            <div class="lnb-card-header">
                                Category ID: <?= esc_attr( $category->id ); ?>
                                <?php

                                    // Show badges
                                    if($default_category) {
                                        echo '&nbsp;<span class="badge badge-primary">Default</span>';
                                    }
                                    if($empty_category) {
                                        echo '&nbsp;<span class="badge badge-secondary">Empty</span>';
                                    }
                                    if($cannot_be_deleted) {
                                        echo '&nbsp;<span class="badge badge-dark">Cannot be deleted</span>';
                                    }
                                ?>

                            </div>

                            <!-- Card Body with Form Details -->
                            <div class="lnb-card-body">
                                <table class="form-table">

                                    <!-- Name -->
                                    <tr>
                                        <th><label for="category-name-<?= esc_attr( $category->id ); ?>"><span
                                                        class="required">*&nbsp;</span>Name</label></th>
                                        <td>
                                            <input type="text" name="category_name"
                                                   id="category-name-<?= esc_attr( $category->id ); ?>"
                                                   value="<?= esc_attr( $category->name ); ?>" class="regular-text"
                                                   required>
                                        </td>
                                    </tr>

                                    <!-- Color -->
                                    <tr>
                                        <th><label for="color-<?= esc_attr( $category->id ); ?>"><span class="not-required">*&nbsp;</span>Color</label>
                                        </th>
                                        <td>
                                            <input type="text" name="color" id="color-<?= esc_attr( $category->id ); ?>"
                                                   value="<?= esc_attr( $category->color ); ?>"
                                                   class="regular-text color-picker">
                                        </td>
                                    </tr>

                                    <!-- Created At -->
                                    <tr>
                                        <th><label><span class="not-required">*&nbsp;</span>Created At</label></th>
                                        <td><?= esc_html( $category->created_at ); ?></td>
                                    </tr>

                                    <!-- Updated At -->
                                    <tr>
                                        <th><label><span class="not-required">*&nbsp;</span>Updated At</label></th>
                                        <td><?= esc_html( $category->updated_at ); ?></td>
                                    </tr>

                                    <!-- Usage Count -->
                                    <tr>
                                        <th><label><span class="not-required">*&nbsp;</span>Usage Count</label></th>
                                        <td><?= esc_html( $usage_count ); ?> links</td>
                                    </tr>

                                    <!-- Usage Details -->
                                    <tr>
                                        <th><label><span class="not-required">*&nbsp;</span>Usage Details</label></th>
                                        <td>
			                                <?php
			                                if ( empty( $usage_details ) ) {
				                                echo "<span class='text-light-gray'>N/A</span>";
			                                } else {
				                                echo "<ul class='usage-details-list'>";
				                                foreach ( $usage_details as $usage_detail ) {
					                                echo "<li class='usage-detail-item'>";
					                                echo "<strong>ID:</strong> <a href='admin.php?page=link-n-blog-details&id=" . $usage_detail->id . "'>" . $usage_detail->id . "</a> | ";
					                                echo "<strong>Name:</strong> " . esc_html($usage_detail->link_name);
					                                echo "</li>";
				                                }
				                                echo "</ul>";
			                                }
			                                ?>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <!-- Card Actions -->
                            <div class="lnb-card-actions">
                                <button type="submit" name="update_category" class="button button-primary">Update</button>
                                <button type="submit" name="delete_category" class="button button-danger"
                                        onclick="return confirm('Are you sure you want to delete this category?');"
			                        <?= $cannot_be_deleted ? 'disabled' : ''; ?>>
                                    Delete
                                </button>
                            </div>

                        </form>
                    </div>
					<?php
				}
			}
			?>

            <!-- Add a New Category -->
            <div class="lnb-card add-new-category">
                <div class="lnb-card-header" style="color: #2271b1;">
                    Add a New Category
                </div>
                <div class="lnb-card-body">
                    <form method="POST" action="">
				        <?php wp_nonce_field( 'category_action_nonce' ); ?>
                        <input type="hidden" name="category_id">
                        <table class="form-table">

                            <!-- Name -->
                            <tr>
                                <th><label for="category_name"><span class="required">*&nbsp;</span>Name</label></th>
                                <td><input type="text" name="category_name" id="category_name" class="regular-text"
                                           placeholder="Enter category name" required></td>
                            </tr>

                            <!-- Color -->
                            <tr>
                                <th scope="row"><label for="color"><span class="not-required">*&nbsp;</span>Color</label>
                                </th>
                                <td>
                                    <input type="text" name="color" id="color" value="" class="regular-text color-picker"/>
                                </td>
                            </tr>
                        </table>
                        <p class="submit inline-buttons">
                            <button type="submit" name="update_category" class="button button-primary">Add</button>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        jQuery(document).ready(function () {
            initializeColorPicker();
        });
    </script>
	<?php
}
?>
