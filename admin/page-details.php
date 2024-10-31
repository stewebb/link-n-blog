<?php

require_once(plugin_dir_path(__FILE__) . '../crud/read.php');
require_once(plugin_dir_path(__FILE__) . '../crud/create.php');

function link_details_page(): void
{
    $categories = get_category_list();

    // Retrieve WordPress posts and pages for the wp_page_id dropdown
    $pages_posts = get_posts([
        'post_type' => ['post', 'page'],
        'post_status' => 'publish',
        'numberposts' => -1
    ]);

    ?>
    <div class="wrap">
        <h1><?= isset($_GET['id']) ? 'Edit Link' : 'Add New Link'; ?></h1>

        <?php
        $is_edit_mode = isset($_GET['id']) && !empty($_GET['id']);
        $link_data = [
            'link_name' => '',
            'label_text' => '',
            'category' => '',
            'url' => '',
            'target' => '_self',
            'color' => '#000000',
            'cover_image_id' => '',
            'wp_page_id' => '',
            'hit_num' => 0,
            'last_visit' => ''
        ];

        if ($is_edit_mode) {
            $link_id = intval($_GET['id']);
            $link_details = get_link_details_by_id($link_id);

            if ($link_details) {
                $link_data = [
                    'link_id' => $link_id,
                    'link_name' => esc_html($link_details->link_name),
                    'label_text' => esc_html($link_details->label_text),
                    'category' => esc_html($link_details->category_name),
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
            } else {
                echo '<div class="notice notice-error"><p>Link not found.</p></div>';
                return;
            }
        }

        ?>

        <form method="post" action="">
            <table class="form-table">
                <?php if ($is_edit_mode): ?>
                    <tr>
                        <th scope="row"><label for="link_id">Link ID</label></th>
                        <td><?= $link_data['link_id']; ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <th scope="row"><label for="link_name">Link Name</label></th>
                    <td>
                        <input type="text" name="link_name" id="link_name" value="<?= $link_data['link_name']; ?>"
                               class="regular-text" required/>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="label_text">Label Text</label></th>
                    <td>
                        <input type="text" name="label_text" id="label_text" value="<?= $link_data['label_text']; ?>"
                               class="regular-text" required/>
                        <p class="description">Leave blank to use the link name as the label text.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="category">Category</label></th>
                    <td>
                        <select name="category" id="category">
                            <option value="0" <?= selected($link_data['category'], 'Uncategorized', false); ?>>
                                Uncategorized
                            </option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id; ?>" <?= selected($link_data['category'], $category->name, false); ?>>
                                    <?= esc_html($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="url">URL</label></th>
                    <td>
                        <input type="url" name="url" id="url" value="<?= $link_data['url']; ?>" class="regular-text"
                               required/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="wp_page_id">WordPress Page</label></th>
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
                <tr>
                    <th scope="row">Target</th>
                    <td>
                        <label><input type="radio" name="target"
                                      value="_self" <?= checked($link_data['target'], '_self'); ?>> Same Tab</label><br>
                        <label><input type="radio" name="target"
                                      value="_blank" <?= checked($link_data['target'], '_blank'); ?>> New Tab</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="color">Color</label></th>
                    <td>
                        <input type="text" name="color" id="color" value="<?= $link_data['color']; ?>"
                               class="regular-text color-picker"/>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Cover Image</th>
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
                    <tr>
                        <th scope="row"><label for="hit_num">Hit Number</label></th>
                        <td><?= $link_data['hit_num'] ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="last_visit">Last Visit</label></th>
                        <td><?= !empty($link_data['last_visit']) ? $link_data['last_visit'] : "Never" ?></td>
                    </tr>
                <?php endif; ?>
            </table>
            <?php submit_button($is_edit_mode ? 'Update Link' : 'Add New Link'); ?>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $link_data = [
                'link_name' => sanitize_text_field($_POST['link_name']),
                'label_text' => sanitize_text_field($_POST['label_text']),
                'category' => sanitize_text_field($_POST['category']),
                'url' => esc_url_raw($_POST['url']),
                'wp_page_id' => intval($_POST['wp_page_id']),
                'target' => sanitize_text_field($_POST['target']),
                'color' => sanitize_hex_color($_POST['color']),
                'cover_image_id' => intval($_POST['cover_image_id']),
            ];

            if ($is_edit_mode) {
                $updated = update_link($link_id, $link_data);
                echo $updated ? '<div class="notice notice-success is-dismissible"><p>Link updated successfully!</p></div>' :
                    '<div class="notice notice-error is-dismissible"><p>Failed to update link.</p></div>';
            } else {
                $inserted = add_new_link($link_data);
                echo $inserted ? '<div class="notice notice-success is-dismissible"><p>New link added successfully!</p></div>' :
                    '<div class="notice notice-error is-dismissible"><p>Failed to add new link.</p></div>';
            }
        }
        ?>
    </div>

    <!--
    <script>

    </script>
    -->
    <?php
}

?>
