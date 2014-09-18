
<div id="content">

  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<div class="content-box">

			<div class="box-holder">

				<div class="store">

					<div class="text-box">

						<h1><?php the_title(); ?></h1>
						<p class="desc">
						<?php
							printf( __( '<span class="%1$s">By</span> %2$s', APP_TD ),
								'meta-prep meta-prep-author',
								sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
									get_author_posts_url( get_the_author_meta( 'ID' ) ),
									sprintf( esc_attr__( 'View all coupons by %s', APP_TD ), get_the_author() ),
									get_the_author()
								)
							);
						?>

							<span class="meta-sep">|</span>

						<?php
							printf( __( '<span class="%1$s">Uploaded</span> %2$s', APP_TD ),
								'meta-prep meta-prep-entry-date',
								sprintf( '<span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span>', esc_attr( get_the_time() ), get_the_date() )
							);

							if ( wp_attachment_is_image() ) {
								echo ' <span class="meta-sep">|</span> ';
								$metadata = wp_get_attachment_metadata();
								printf( __( 'Full size is %s pixels', APP_TD ),
									sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
										wp_get_attachment_url(),
										esc_attr( __( 'Link to full-size image', APP_TD ) ),
										$metadata['width'],
										$metadata['height']
									)
								);
							}
						?>

						<?php edit_post_link( __( 'Edit', APP_TD ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>

						</p>

					</div> <!-- #text-box -->

					<div class="clr"></div>

				</div> <!-- #store -->

			</div> <!-- #box-holder -->

		</div> <!-- #content-box -->


		<div class="content-box">

			<div class="box-holder">

				<div <?php post_class('item'); ?> id="post-<?php echo $post->ID; ?>">

					<div class="item-holder">

						<div class="item-frame">

						<?php if ( wp_attachment_is_image() ) : ?>

						<?php
							$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );

							foreach ( $attachments as $k => $attachment ) {
								if ( $attachment->ID == $post->ID )
									break;
							}

							$k++;
							// If there is more than 1 image attachment in a gallery
							if ( count( $attachments ) > 1 ) {
								if ( isset( $attachments[ $k ] ) )
									// get the URL of the next image attachment
									$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
								else
									// or get the URL of the first image attachment
									$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
							} else {
								// or, if there's only 1 image attachment, get the URL of the image
								$next_attachment_url = wp_get_attachment_url();
							}

							$attachment_width  = apply_filters( 'appthemes_attachment_size', 597 );
							$attachment_height = apply_filters( 'appthemes_attachment_height', 597 );
						?>

							<p class="attachment">
								<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); ?></a>
							</p>

							<div id="nav-below" class="navigation">

								<div class="next-prev"><?php previous_image_link( false, __( '&larr; prev', APP_TD ) ); ?>&nbsp;&nbsp;&nbsp;<?php next_image_link( false, __( 'next &rarr;', APP_TD ) ); ?></div>

							</div><!-- /nav-below -->

						<?php else : ?>

							<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>

						<?php endif; ?>


						</div> <!-- #item-frame -->

						<div class="item-footer">

						<?php if ( !empty( $post->post_parent ) ) : ?>

							<p class="page-title">
								<a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', APP_TD ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery">
									<?php printf( '<span class="meta-nav">' . __( '&larr; Return to %s', APP_TD ) . '</span>', get_the_title( $post->post_parent ) ); ?>
								</a>
							</p>

						<?php endif; ?>

						</div>

					</div>

				</div>

			</div> <!-- #box-holder -->

		</div> <!-- #content-box -->


	<?php endwhile; // end of the loop ?>

</div><!-- /content -->

<?php wp_reset_query(); ?>

<?php get_sidebar( 'coupon' ); ?>

