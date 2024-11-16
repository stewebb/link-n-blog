<?php

//require_once( plugin_dir_path( __FILE__ ) . '../includes/helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . '../model/links.php' );
require_once( plugin_dir_path( __FILE__ ) . '../model/groups.php' );

// Groups Management Page
function groups_page(): void {
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

		// Nonce Verification
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'group_action_nonce' ) ) {
			die( 'Security check failed' );
		}

		// Handle Form Submissions
		$group_id   = ! empty( $_POST['group_id'] ) ? intval( $_POST['group_id'] ) : null;
		$group_name = ! empty( $_POST['group_name'] ) ? sanitize_text_field( $_POST['group_name'] ) : '';
		$enabled    = isset( $_POST['group_enabled'] ); // Checkbox: true if checked, false otherwise

		// Add or Update Group
		if ( isset( $_POST['update_group'] ) ) {

			// Update Existing Group
			if ( $group_id ) {
				$result = lnb_update_group( $group_id, $group_name, $enabled );
				if ( $result ) {
					echo "<div class='notice notice-success'><p>Group updated successfully.</p></div>";
				} else {
					echo "<div class='notice notice-error'><p>Error updating group.</p></div>";
				}
			}

            // Add New Group
			else {
				$result = lnb_add_group( $group_name, $enabled );
				if ( $result ) {
					echo "<div class='notice notice-success'><p>Group added successfully.</p></div>";
				} else {
					echo "<div class='notice notice-error'><p>Error adding group.</p></div>";
				}
			}
		}

		// Delete Group
		if ( isset( $_POST['delete_group'] ) && $group_id ) {
			if ( $group_id == 1 ) {
				echo "<div class='notice notice-error'><p>The group with ID 1 cannot be deleted.</p></div>";
			} else {
				$usage_count = lnb_get_group_usage_count( $group_id );
				if ( $usage_count > 0 ) {
					echo "<div class='notice notice-error'><p>This group is used in $usage_count link(s).</p></div>";
				} else {
					$result = lnb_delete_group( $group_id );
					if ( $result ) {
						echo "<div class='notice notice-success'><p>Group deleted successfully.</p></div>";
					} else {
						echo "<div class='notice notice-error'><p>Error deleting group.</p></div>";
					}
				}
			}
		}
	}

	?>

    <div class="wrap">
        <h1 class="wp-heading-inline">Manage Groups</h1>
        <hr class="wp-header-end">

        <div class="lnb-card-container">
			<?php
			// Fetch Groups and Display
			$groups = lnb_get_group_list();
			if ( $groups ) {
				foreach ( $groups as $group ) {
					$usage_count   = lnb_get_group_usage_count( $group->id );
					$usage_details = lnb_get_links_by_group( $group->id );
					$group_color   = lnb_get_group_colors( $group->name );

					$default_group     = $group->id == 1;
					$empty_group       = $usage_count == 0;
					$cannot_be_deleted = $default_group || ! $empty_group;
					$is_enabled        = ! $group->disabled;
					?>

                    <div class="lnb-card" id="group-<?= esc_attr( $group->id ); ?>">
                        <form method="POST" action="">
							<?php wp_nonce_field( 'group_action_nonce' ); ?>
                            <input type="hidden" name="group_id" value="<?= esc_attr( $group->id ); ?>">

                            <!-- Card Header with Group ID -->
                            <div class="lnb-card-header"
                                 style="background-color: <?= esc_attr( $group_color['light'] ) ?>;">
                                <div class="color-block"
                                     style="background-color: <?= esc_attr( $group_color['dark'] ) ?>;">
                                    <span class="color-hex"><?= esc_html( $group_color['dark'] ) ?></span>
                                </div>

                                <span <?php if ( $group->disabled ) {
									echo 'class="text-strikethrough" ';
								} ?>>
                                    Group ID: <?= esc_attr( $group->id ); ?>
                                </span>


								<?php

								// Show badges
								if ( $default_group ) {
									echo '&nbsp;<span class="badge badge-primary">Default</span>';
								}
								if ( $empty_group ) {
									echo '&nbsp;<span class="badge badge-secondary">Empty</span>';
								}
								if ( $cannot_be_deleted ) {
									echo '&nbsp;<span class="badge badge-dark">Cannot be deleted</span>';
								}
								?>
                            </div>

                            <!-- Card Body with Form Details -->
                            <div class="lnb-card-body">
                                <table class="form-table">

                                    <!-- Name -->
                                    <tr>
                                        <th><label for="group-name-<?= esc_attr( $group->id ); ?>"><span
                                                        class="required">*&nbsp;</span>Name</label></th>
                                        <td>
                                            <input type="text" name="group_name"
                                                   id="group-name-<?= esc_attr( $group->id ); ?>"
                                                   value="<?= esc_attr( $group->name ); ?>" class="regular-text"
                                                   required>
                                        </td>
                                    </tr>

                                    <!-- Enabled Checkbox -->
                                    <tr>
                                        <th><label for="group-enabled-<?= esc_attr( $group->id ); ?>"><span
                                                        class="required">*&nbsp;</span>Enabled</label>
                                        </th>
                                        <td>
                                            <input type="checkbox" name="group_enabled"
                                                   id="group-enabled-<?= esc_attr( $group->id ); ?>"
                                                   value="1" <?= $is_enabled ? 'checked' : ''; ?>>
                                        </td>
                                    </tr>

                                    <!-- Created At -->
                                    <tr>
                                        <th><label><span class="not-required">*&nbsp;</span>Created At</label></th>
                                        <td><?= esc_html( $group->created_at ); ?></td>
                                    </tr>

                                    <!-- Updated At -->
                                    <tr>
                                        <th><label><span class="not-required">*&nbsp;</span>Updated At</label></th>
                                        <td><?= esc_html( $group->updated_at ); ?></td>
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
													echo "<strong>Name:</strong> " . esc_html( $usage_detail->link_name );
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
                                <button type="submit" name="update_group" class="button button-primary">Update</button>
                                <button type="submit" name="delete_group" class="button button-danger"
                                        onclick="return confirm('Are you sure you want to delete this group?');"
									<?= $cannot_be_deleted ? 'disabled' : ''; ?>>Delete
                                </button>
                            </div>
                        </form>
                    </div>
				<?php }
			} ?>

            <!-- Add a New Group -->
            <div class="lnb-card add-new-group">
                <div class="lnb-card-header" style="color: #2271b1;">
                    Add a New Group
                </div>
                <div class="lnb-card-body">
                    <form method="POST" action="">
						<?php wp_nonce_field( 'group_action_nonce' ); ?>
                        <table class="form-table">
                            <!-- Name -->
                            <tr>
                                <th><label for="group_name">Name</label></th>
                                <td>
                                    <input type="text" name="group_name" id="group_name" class="regular-text" required>
                                </td>
                            </tr>

                            <!-- Enabled Checkbox -->
                            <tr>
                                <th><label for="group_enabled">Enabled</label></th>
                                <td>
                                    <input type="checkbox" name="group_enabled" id="group_enabled" value="1" checked>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <button type="submit" name="update_group" class="button button-primary">Add</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php
}

?>
