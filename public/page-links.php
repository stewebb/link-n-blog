<?php

function link_page( $grouped_links ): bool|string {
	ob_start();
	?>

        <pre>
            <?php print_r( $grouped_links ); ?>
        </pre>
    <script>
        const colorManipulator = new ColorManipulator('#000000', 90, true);

        function applyHoverColor(element, color) {
            colorManipulator.setColor(color);
            element.style.backgroundColor = colorManipulator.adjustColor();
        }

        function clearHoverColor(element) {
            element.style.backgroundColor = '';
        }
    </script>

    <div class="container">

		<?php

		foreach ( $grouped_links as $category => $links ) :
			?>
            <div class="row mb-3">
                <div class="col-12">
                    <h4 class="courgette-regular"
                        style="color: hsl(<?= $i ?>, 100%, 33%);">
						<?= ! empty( $category ) ? esc_html( $category ) : 'Uncategorized' ?>
                    </h4>
                </div>
				<?php foreach ( $links as $link ) : ?>
					<?php
					$display_text     = esc_html( $link->label_text ?? $link->link_name ?? '' );
					$link_color       = esc_attr( $link->color ?? "#000000" );
					$link_url         = esc_url( $link->url ?? 'javascript:void(0)' );
					$link_wp_page_url = ! empty( $link->wp_page_id ) ? esc_url( get_permalink( $link->wp_page_id ) ) : 'javascript:void(0)';
					$link_target      = esc_attr( $link->target ?? '_blank' );
					?>
                    <div class="col-xl-3 col-lg-4 col-sm-6 menu-col">
                        <div class="link-item">

                            <!-- Image -->
                            <div class="banner-container">
								<?php if ( empty( $link->cover_image_id ) ) : ?>
                                    <canvas id="link-<?= $link->id ?>" class="responsive-canvas"></canvas>
                                    <script>
                                        colorManipulator.setColor('<?= $link_color ?>');
                                        colorManipulator.setPercentage(75);
                                        (new PatternGenerator(colorManipulator.adjustColor()))
                                            .drawPattern('link-<?= $link->id ?>', '<?= $link->id ?>', 512, 512);
                                    </script>
                                    <span class="centered-text fw-bold"
                                          style="color:<?= $link_color ?>;">
                                                            <?= $display_text ?>
                                                        </span>
								<?php else : ?>
									<?= wp_get_attachment_image( $link->cover_image_id ); ?>
								<?php endif; ?>
                            </div>

                            <!-- Overlay when hovered -->
                            <div class="overlay"
                                 onmouseover="applyHoverColor(this, '<?= $link_color ?>')"
                                 onmouseout="clearHoverColor(this)">

                                <!-- Text -->
                                <div class="text-primary"
                                     style="color: <?= $link_color ?> !important;">
                                    <h4 class="fw-bold"><?= $display_text ?></h4>
                                </div>

                                <!-- Buttons -->
                                <div class="d-grid gap-0 col-6 mx-auto">
									<?php if ( ! empty( $link->url ) ) : ?>
                                        <button type="button" class="btn btn-outline-dark"
                                                onclick="window.open('<?= $link_url ?>', '<?= $link_target ?>')"
                                                style="color: <?= $link_color ?>; border-color: <?= $link_color ?>;"
                                                onmouseover="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';">
                                            Visit Site
                                        </button>
									<?php endif; ?>

									<?php if ( ! empty( $link->wp_page_id ) ) : ?>
                                        <button type="button" class="btn btn-outline-dark"
                                                onclick="window.open('<?= $link_wp_page_url ?>')"
                                                style="color: <?= $link_color ?>; border-color: <?= $link_color ?>;"
                                                onmouseover="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';">
                                            Learn More
                                        </button>
									<?php endif; ?>

                                    <button type="button" class="btn btn-outline-dark"
                                            style="color: <?= $link_color ?>; border-color: <?= $link_color ?>;"
                                            onmouseover="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';">
                                        Share
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
			<?php
			$i ++;
		endforeach;
		?>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.link-item').each(function (index, element) {
                const width = $(element).width();
                const height = $(element).height();
                $('.responsive-canvas').css({
                    'width': width + 'px',
                    'height': height + 'px'
                });
            });
        });
    </script>
	<?php
	return ob_get_clean();
}
