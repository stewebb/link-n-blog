<?php
function settings_page(): void
{
    ?>

    <div class="wrap">
        <h1 class="wp-heading-inline">Settings</h1>
        <hr class="wp-header-end">

        <form method="post" action="options.php">
            <?php
            // Display WordPress settings fields
            settings_fields('lnb-settings-group');
            do_settings_sections('lnb-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Example Setting</th>
                    <td><input type="text" name="example_setting" value="<?php echo esc_attr(get_option('example_setting')); ?>" /></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>

    <?php
}