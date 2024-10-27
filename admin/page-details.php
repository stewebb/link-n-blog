<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');
require_once(plugin_dir_path(__FILE__) . '../crud/create.php'); // Assuming create.php has functions for adding/updating links

function page_lnb_details(): void
{
    ?>
    <div class="wrap">
        <h1><?php echo isset($_GET['id']) ? 'Edit Link' : 'Add New Link'; ?></h1>

        <?php
        $is_edit_mode = isset($_GET['id']) && !empty($_GET['id']);
        $link_data = [
            'link_name' => '',
            'label_text' => '',
            'category' => '',
            'url' => '',
            'target' => '_self', // Default target option
            'color' => '#000000', // Default color
            'cover_image_id' => ''
        ];

        if ($is_edit_mode) {
            $link_id = intval($_GET['id']);
            $link_details = get_link_details_by_id($link_id);

            if ($link_details) {
                // Populate form fields with link details
                $link_data = [
                    'link_id' => $link_id,
                    'link_name' => esc_html($link_details->link_name),
                    'label_text' => esc_html($link_details->label_text),
                    'category' => esc_html($link_details->category_name),
                    'url' => esc_url($link_details->url),
                    'target' => esc_html($link_details->target),
                    'color' => esc_html($link_details->color),
                    'cover_image_id' => intval($link_details->cover_image_id),
                    'created_at' => esc_html($link_details->created_at),
                    'updated_at' => esc_html($link_details->updated_at)
                ];
            } else {
                echo '<div class="notice notice-error"><p>Link not found.</p></div>';
                return;
            }
        }

        // Display the form
        ?>
        <form method="post" action="">
            <table class="form-table">
                <?php if ($is_edit_mode): ?>
                    <tr>
                        <th scope="row"><label for="link_id">Link ID</label></th>
                        <td><input type="text" id="link_id" value="<?php echo $link_data['link_id']; ?>" class="regular-text" disabled /></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th scope="row"><label for="link_name">Link Name</label></th>
                    <td><input type="text" name="link_name" id="link_name" value="<?php echo $link_data['link_name']; ?>" class="regular-text" required /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="label_text">Label Text</label></th>
                    <td><input type="text" name="label_text" id="label_text" value="<?php echo $link_data['label_text']; ?>" class="regular-text" required /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="category">Category</label></th>
                    <td><input type="text" name="category" id="category" value="<?php echo $link_data['category']; ?>" class="regular-text" required /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="url">URL</label></th>
                    <td><input type="url" name="url" id="url" value="<?php echo $link_data['url']; ?>" class="regular-text" required /></td>
                </tr>
                <tr>
                    <th scope="row">Target</th>
                    <td>
                        <p>
                            <label><input type="radio" name="target" value="_self" <?php checked($link_data['target'], '_self'); ?>> _self (Same Tab)</label>
                        </p>
                        <p>
                            <label><input type="radio" name="target" value="_blank" <?php checked($link_data['target'], '_blank'); ?>>_blank (New Tab)</label>
                        </p>

                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="color">Color</label></th>
                    <td><input type="text" name="color" id="color" value="<?php echo $link_data['color']; ?>" class="regular-text color-picker" /></td>
                </tr>
                <tr>
                    <th scope="row">Cover Image</th>
                    <td>
                        <input type="hidden" name="cover_image_id" id="cover_image_id" value="<?php echo $link_data['cover_image_id']; ?>" />
                        <button type="button" class="button" id="select-cover-image">Select Cover Image</button>
                        <div id="cover-image-preview">
                            <?php if ($link_data['cover_image_id']): ?>
                                <?php echo wp_get_attachment_image($link_data['cover_image_id'], 'thumbnail'); ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php if ($is_edit_mode): ?>
                    <tr>
                        <th scope="row">Created At</th>
                        <td><input type="text" value="<?php echo $link_data['created_at']; ?>" class="regular-text" disabled /></td>
                    </tr>
                    <tr>
                        <th scope="row">Updated At</th>
                        <td><input type="text" value="<?php echo $link_data['updated_at']; ?>" class="regular-text" disabled /></td>
                    </tr>
                <?php endif; ?>
            </table>
            <?php submit_button($is_edit_mode ? 'Update Link' : 'Add New Link'); ?>
        </form>

        <?php
        // Handle form submission for adding/updating the link
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $link_data = [
                'link_name' => sanitize_text_field($_POST['link_name']),
                'label_text' => sanitize_text_field($_POST['label_text']),
                'category' => sanitize_text_field($_POST['category']),
                'url' => esc_url_raw($_POST['url']),
                'target' => sanitize_text_field($_POST['target']),
                'color' => sanitize_hex_color($_POST['color']),
                'cover_image_id' => intval($_POST['cover_image_id']),
            ];

            if ($is_edit_mode) {
                $updated = update_link($link_id, $link_data); // Ensure update_link function is defined in create.php
                if ($updated) {
                    echo '<div class="notice notice-success is-dismissible"><p>Link updated successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error is-dismissible"><p>Failed to update link.</p></div>';
                }
            } else {
                $inserted = add_new_link($link_data); // Ensure add_new_link function is defined in create.php
                if ($inserted) {
                    echo '<div class="notice notice-success is-dismissible"><p>New link added successfully!</p></div>';
                } else {
                    echo '<div class="notice notice-error is-dismissible"><p>Failed to add new link.</p></div>';
                }
            }
        }
        ?>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Initialize the color picker
            $('.color-picker').wpColorPicker();

            // Media library image selector
            $('#select-cover-image').on('click', function(e) {
                e.preventDefault();
                const imageFrame = wp.media({
                    title: 'Select or Upload Cover Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                imageFrame.on('select', function() {
                    const attachment = imageFrame.state().get('selection').first().toJSON();
                    $('#cover_image_id').val(attachment.id);
                    $('#cover-image-preview').html('<img src="' + attachment.sizes.thumbnail.url + '" />');
                });
                imageFrame.open();
            });
        });
    </script>

    <?php
}
?>
