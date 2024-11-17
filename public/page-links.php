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

    <div class="<?= esc_attr( $portfolio_expert_page_container ); ?> mt-5 mb-5 pt-5 pb-5">
        <div class="row">
            <div class="col-lg-12">
                <main id="primary" class="site-main">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <!-- Page Header -->
						<?php if ( $portfolio_expert_page_header == 'show' || ( $portfolio_expert_page_header == 'hide-home' && ! is_front_page() ) ) : ?>
                            <header class="entry-header page-header my-projects">
                                <h1><?= $lnb_label ?></h1>
                            </header>
						<?php endif; ?>
						<?php portfolio_expert_post_thumbnail(); ?>

                        <!-- Page Content -->
                        <div class="entry-content">

							<?php if ( function_exists( "lnb_get_all_links_grouped_by_category" ) ): ?>
								<?php
								$grouped_links = lnb_get_all_links_grouped_by_category();
								$categoryCount = count( $grouped_links );
								$colorInterval = (int) ( 360 / max( $categoryCount, 1 ) );
								$i             = 0;
								?>

								<?php foreach ( $grouped_links as $category => $links ): ?>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <h4 class="courgette-regular"
                                                style="color: hsl(<?= $i * $colorInterval ?>, 100%, 33%);">
												<?= ! empty( $category ) ? esc_html( $category ) : 'Uncategorized' ?>
                                            </h4>
                                        </div>

										<?php foreach ( $links as $link ): ?>

											<?php
											$display_text     = empty( $link->label_text ) ? esc_html( $link->link_name ?? '' ) : esc_html( $link->label_text );
											$link_color       = esc_attr( $link->color ?? "#000000" );
											$link_url         = esc_url( $link->url ?? 'javascript:void(0)' );
											$link_wp_page_url = ! empty( $link->wp_page_id ) ? esc_url( get_permalink( $link->wp_page_id ) ) : 'javascript:void(0)';
                                            $link_target      = esc_attr( $link->target ?? '_blank' );
											?>

                                            <div class="col-xl-3 col-lg-4 col-sm-6 menu-col">
                                                <div class="link-item">

                                                    <!-- Image -->
                                                    <div class="banner-container">
														<?php if ( empty( $link->cover_image_id ) ): ?>
                                                            <canvas id="link-<?= $link->id ?>"
                                                                    class="responsive-canvas"></canvas>
                                                            <script>
                                                                colorManipulator.setColor('<?= $link_color ?>');
                                                                colorManipulator.setPercentage(75);
                                                                (new PatternGenerator(colorManipulator.adjustColor())).drawPattern('link-<?= $link->id ?>', '<?= $link->id ?>', 512, 512);
                                                            </script>
                                                            <span class="centered-text fw-bold"
                                                                  style="color:<?= $link_color ?>;">
                                                            <?= $display_text ?>
                                                        </span>
														<?php else: ?>
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
	                                                        <?php if (!empty($link->url)): ?>
                                                                <button type="button" class="btn btn-outline-dark"
                                                                        onclick="if (confirm('Are you sure you want to open <?= $link_url ?>?')) window.open('<?= $link_url ?>', '<?= $link_target ?>')"
                                                                        style="color: <?= $link_color ?>;border-color: <?= $link_color ?>;"
                                                                        onmouseover="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';"
                                                                        onfocus="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                                        onblur="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';"
                                                                >
                                                                    Visit Site
                                                                </button>
	                                                        <?php endif; ?>

															<?php if ( ! empty( $link->wp_page_id ) ): ?>
                                                                <button type="button" class="btn btn-outline-dark"
                                                                        onclick="window.open('<?= $link_wp_page_url ?>')"
                                                                        style="color: <?= $link_color ?>;border-color: <?= $link_color ?>;"
                                                                        onmouseover="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';"
                                                                        onfocus="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                                        onblur="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';"
                                                                >
                                                                    Learn More
                                                                </button>
															<?php endif; ?>

                                                            <button type="button" class="btn btn-outline-dark"
                                                                    style="color: <?= $link_color ?>;border-color: <?= $link_color ?>;"
                                                                    onmouseover="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';"
                                                                    onfocus="this.style.backgroundColor='<?= $link_color ?>'; this.style.color='#ffffff';"
                                                                    onblur="this.style.backgroundColor='transparent'; this.style.color='<?= $link_color ?>';"
                                                            >
                                                                Share
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
										<?php endforeach; ?>
                                    </div>

									<?php $i ++; ?>
								<?php endforeach; ?>
							<?php else: ?>
                                <div class="alert alert-danger mt-3">
                                    <strong>Link 'n' Blog</strong> plugin is not installed or activated.
                                </div>
							<?php endif; ?>


                        </div>
                    </article>

                </main>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            $('.link-item').each(function (index, element) {
                var width = $(element).width();
                var height = $(element).height();
                $('.responsive-canvas').css({
                    'width': width + 'px',
                    'height': height + 'px'
                });
            });
        });
    </script>