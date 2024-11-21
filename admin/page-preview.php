<?php

function preview_page(): void {

	$group_id  = isset( $_GET['group_id'] ) ? intval( $_GET['group_id'] ) : 1;
	$groups    = lnb_get_group_list();
	$shortcode = '[lnb id=' . $group_id . ']';
	?>

    <div class="wrap">
        <h1 class="wp-heading-inline">Preview</h1>
        <hr class="wp-header-end mb-3">

        <div class="selectors-container">

            <!-- Group Selector -->
            <div class="group-selector">
                <form method="GET" action="<?= esc_url( admin_url( 'admin.php' ) ); ?>">
                    <input type="hidden" name="page" value="link-n-blog-preview">
                    <label for="group_id">Select a Group:</label>
                    <select name="group_id" id="group_id" onchange="this.form.submit()">
						<?php foreach ( $groups as $group ): ?>
                            <option value="<?= esc_attr( $group->id ); ?>" <?= selected( $group->id, $group_id, false ); ?>>
								<?= esc_html( $group->name ); ?>
                            </option>
						<?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Shortcode -->
            <div class="per-page-selector">
                Shortcode: &nbsp;<code><?= $shortcode ?></code>
            </div>
        </div>
    </div>

    <?= do_shortcode($shortcode); ?>

	<?php
}

?>