<?php

// Settings Page HTML
function settings_page(): void {
	?>

    <div class="wrap">
        <h1 class="wp-heading-inline">Settings</h1>
        <hr class="wp-header-end">

        <form method="post" action="options.php">
			<?php
			// Display WordPress settings fields
			settings_fields( 'lnb-settings-group' );
			do_settings_sections( 'lnb-settings-group' );
			?>
            <table class="form-table">
                <!-- Load Bootstrap Checkbox -->
                <tr valign="top">
                    <th scope="row">Load Bootstrap</th>
                    <td>
                        <input type="checkbox" name="load_bootstrap" value="1"
							<?php checked( 1, get_option( 'load_bootstrap', 1 ) ); ?> />
                    </td>
                </tr>

                <!-- Default Color Picker -->
                <tr valign="top">
                    <th scope="row">Default Color</th>
                    <td>
                        <input type="text" name="default_color"
                               value="<?php echo esc_attr( get_option( 'default_color', '#e070a7' ) ); ?>"
                               class="color-field"/>
                    </td>
                </tr>
            </table>

			<?php submit_button(); ?>
        </form>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            $('.color-field').wpColorPicker();
        });
    </script>


	<?php
}