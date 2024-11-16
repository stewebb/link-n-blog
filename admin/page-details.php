<?php

//require_once(plugin_dir_path(__FILE__) . '../model/links.php');
//require_once(plugin_dir_path(__FILE__) . '../model/categories.php');
//require_once(plugin_dir_path(__FILE__) . '../model/groups.php');

function link_details_page(): void
{
    $categories = lnb_get_category_list();
    $groups = lnb_get_group_list();

    $pages_posts = get_posts([
        'post_type' => ['post', 'page'],
        'post_status' => 'publish',
        'numberposts' => -1
    ]);

    // Link data initialization
    $is_edit_mode = !empty($_GET['id']);
    $link_data = [
        'display' => 1,
        'link_name' => '',
        'label_text' => '',
        'category' => '',
        'group' => '',
        'url' => '',
        'target' => '_self',
        'color' => '',
        'cover_image_id' => '',
        'wp_page_id' => '',
        'hit_num' => 0,
        'last_visit' => ''
    ];

    if ($is_edit_mode) {
        $link_id = intval($_GET['id']);
        $link_details = lnb_get_link_details_by_id($link_id);
        if ($link_details) {
            $link_data = [
                'display' => intval($link_details->display),
                'link_id' => $link_id,
                'link_name' => esc_html($link_details->link_name),
                'label_text' => esc_html($link_details->label_text),
                'category' => esc_html($link_details->category_name),
                'group' => esc_html($link_details->group_name),
                'url' => esc_url($link_details->url),
                'target' => esc_html($link_details->target),
                'color' => esc_html($link_details->color),
                'cover_image_id' => intval($link_details->cover_image_id),
                'wp_page_id' => intval($link_details->wp_page_id),
                'hit_num' => intval($link_details->hit_num),
                'last_visit' => esc_html($link_details->last_visit),
                'created_at' => esc_html($link_details->created_at),
                'updated_at' => esc_html($link_details->updated_at)
            ];
        }
    }
    ?>
    <div class="wrap">
        <h1><?= isset($_GET['id']) ? 'Edit Link' : 'Add New Link'; ?></h1>

        <form method="post" action="">
            <input type="hidden" name="action" value="save">
            <?php if ($is_edit_mode): ?>
                <input type="hidden" name="link_id" value="<?= $link_data['link_id']; ?>">
            <?php endif; ?>

            <table class="form-table">

                <!-- ID -->
                <?php if ($is_edit_mode): ?>
                    <tr>
                        <th scope="row"><label for="link_id"><span class="not-required">*&nbsp;</span>Link ID</label>
                        </th>
                        <td><?= $link_data['link_id']; ?></td>
                    </tr>
                <?php endif; ?>

                <!-- Groups -->
                <tr>
                    <th scope="row"><label for="group"><span class="required">*&nbsp;</span>Group</label></th>
                    <td>
                        <select name="group" id="group" required>
                            <?php foreach ($groups as $group): ?>
                                <option value="<?= $group->id; ?>" <?= selected($link_data['group'], $group->name, false); ?>>
                                    <?= esc_html($group->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <!-- Display Options -->
                <tr>
                    <th scope="row"><span class="required">*&nbsp;</span>Display</th>
                    <td>
                        <p><label><input type="radio" name="display"
                                         value="1" <?= checked($link_data['display'], '1'); ?>> Name and Link(s)</label>
                        </p>
                        <p><label><input type="radio" name="display"
                                         value="0" <?= checked($link_data['display'], '0'); ?>> Name only</label></p>
                        <p><label><input type="radio" name="display"
                                         value="-1" <?= checked($link_data['display'], '-1'); ?>> Hidden</label></p>
                    </td>
                </tr>


                <!-- Link Name -->
                <tr>
                    <th scope="row"><label for="link_name"><span class="required">*&nbsp;</span>Link Name</label></th>
                    <td>
                        <input type="text" name="link_name" id="link_name" value="<?= $link_data['link_name']; ?>"
                               class="regular-text" required/>
                    </td>
                </tr>

                <!-- Label Text -->
                <tr>
                    <th scope="row"><label for="label_text"><span class="not-required">*&nbsp;</span>Label Text</label>
                    </th>
                    <td>
                        <input type="text" name="label_text" id="label_text" value="<?= $link_data['label_text']; ?>"
                               class="regular-text"/>
                        <p class="description">Leave blank to use the link name as the label text.</p>
                    </td>
                </tr>

                <!-- Category -->
                <tr>
                    <th scope="row"><label for="category"><span class="required">*&nbsp;</span>Category</label></th>
                    <td>
                        <select name="category" id="category">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id; ?>" <?= selected($link_data['category'], $category->name, false); ?>>
                                    <?= esc_html($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <!-- WordPress Page -->
                <tr>
                    <th scope="row"><label for="wp_page_id"><span class="not-required">*&nbsp;</span>WordPress
                            Page</label></th>
                    <td>
                        <select name="wp_page_id" id="wp_page_id">
                            <option value="">Keep it blank...</option>
                            <?php foreach ($pages_posts as $page_post): ?>
                                <option value="<?= $page_post->ID; ?>" <?= selected($link_data['wp_page_id'], $page_post->ID, false); ?>>
                                    <?= esc_html($page_post->post_title); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <!-- URL -->
                <tr>
                    <th scope="row"><label for="url"><span class="not-required">*&nbsp;</span>URL</label></th>
                    <td>
                        <input type="url" name="url" id="url" value="<?= $link_data['url']; ?>" class="regular-text"/>
                    </td>
                </tr>

                <!-- Target -->
                <tr>
                    <th scope="row"><span class="not-required">*&nbsp;</span>Target</th>
                    <td>
                        <p><label><input type="radio" name="target"
                                         value="_self" <?= checked($link_data['target'], '_self'); ?>> Same Tab</label>
                        <p><label><input type="radio" name="target"
                                         value="_blank" <?= checked($link_data['target'], '_blank'); ?>> New Tab</label>
                        </p>
                    </td>
                </tr>

                <!-- Color -->
                <tr>
                    <th scope="row"><label for="color"><span class="not-required">*&nbsp;</span>Color</label></th>
                    <td>
                        <input type="text" name="color" id="color" value="<?= $link_data['color']; ?>"
                               class="regular-text color-picker"/>
                    </td>
                </tr>

                <!-- Cover Image -->
                <tr>
                    <th scope="row"><span class="not-required">*&nbsp;</span>Cover Image</th>
                    <td>
                        <div class="mb-3">
                            <input type="hidden" name="cover_image_id" id="cover_image_id"
                                   value="<?= $link_data['cover_image_id']; ?>"/>
                            <button type="button" class="button" id="select-cover-image">Select Cover Image</button>
                        </div>
                        <div id="cover-image-preview">
                            <?php if ($link_data['cover_image_id']): ?>
                                <?= wp_get_attachment_image($link_data['cover_image_id']); ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>

                <?php if ($is_edit_mode): ?>

                    <!-- Hit Number -->
                    <tr>
                        <th scope="row"><label for="hit_num"><span class="not-required">*&nbsp;</span>Hit Number</label>
                        </th>
                        <td><?= $link_data['hit_num'] ?></td>
                    </tr>

                    <!-- Last Visit -->
                    <tr>
                        <th scope="row"><label for="last_visit"><span class="not-required">*&nbsp;</span>Last
                                Visit</label></th>
                        <td><?= !empty($link_data['last_visit']) ? $link_data['last_visit'] : "Never" ?></td>
                    </tr>

                    <!-- Created At -->
                    <tr>
                        <th scope="row"><label for="created_at"><span class="not-required">*&nbsp;</span>Created
                                At</label></th>
                        <td><?= $link_data['created_at'] ?></td>
                    </tr>

                    <!-- Updated At -->
                    <tr>
                        <th scope="row"><label for="updated_at"><span class="not-required">*&nbsp;</span>Updated
                                At</label></th>
                        <td><?= $link_data['updated_at'] ?></td>
                    </tr>
                <?php endif; ?>

            </table>

            <div class="inline-buttons">
                <?php submit_button($is_edit_mode ? 'Update Link' : 'Add New Link'); ?>
                <p class="submit">
                    <a href="admin.php?page=link-n-blog" class="button button-secondary">Back to List</a>
                </p>
                <?php if ($is_edit_mode): ?>
                    <p class="submit">
                        <?php
                        submit_button(
                            'Delete',
                            'delete button-danger',
                            'delete_action',
                            false,
                            [
                                'onclick' => "if(confirm('Are you sure you want to delete this link? This action cannot be undone.')) { document.getElementById('delete-action').value='delete'; document.getElementById('link-details-form').submit(); }"
                            ]
                        );
                        ?>
                    </p>
                <?php endif; ?>
            </div>

            <input type="hidden" name="delete_action" value="" id="delete-action">
        </form>

        <?php
        // Handling form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $link_data = [
                'display' => intval($_POST['display']),
                'link_name' => sanitize_text_field($_POST['link_name']),
                'label_text' => sanitize_text_field($_POST['label_text']),
                'category' => sanitize_text_field($_POST['category']),
                'group' => sanitize_text_field($_POST['group']),
                'url' => esc_url_raw($_POST['url']),
                'wp_page_id' => intval($_POST['wp_page_id']),
                'target' => sanitize_text_field($_POST['target']),
                'color' => sanitize_hex_color($_POST['color']),
                'cover_image_id' => intval($_POST['cover_image_id']),
            ];

            // Delete
            if (isset($_POST['delete_action']) && $_POST['delete_action'] === 'delete') {
                $link_id_to_delete = intval($_POST['link_id']);
                $deleted = lnb_delete_link($link_id_to_delete);

                echo $deleted ? '<div class="notice notice-success is-dismissible"><p>Link deleted successfully!</p></div>' : '<div class="notice notice-error is-dismissible"><p>Failed to delete link.</p></div>';
            } // Edit
            elseif ($is_edit_mode) {
                $updated = lnb_update_link($link_id, $link_data);
                echo $updated ? '<div class="notice notice-success is-dismissible"><p>Link updated successfully!</p></div>' :
                    '<div class="notice notice-error is-dismissible"><p>Failed to update link.</p></div>';
            } // Insert
            else {
                $inserted = lnb_add_new_link($link_data);
                echo $inserted ? '<div class="notice notice-success is-dismissible"><p>New link added successfully!</p></div>' :
                    '<div class="notice notice-error is-dismissible"><p>Failed to add new link.</p></div>';
            }
        }
        ?>
    </div>

    <script>
        jQuery(document).ready(function () {
            initializeColorPicker();
            initializeCoverImagePicker();
        });
    </script>

    <?php
}

?>