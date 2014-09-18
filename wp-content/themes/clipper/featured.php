<?php
/**
 * The featured slider on the home page
 *
 */
?>

<?php if ( $featured = clpr_get_featured_slider_coupons() ) : ?>

	<div class="featured-slider">

		<div class="gallery-t">&nbsp;</div>

		<div class="gallery-c">

			<div class="gallery-holder">

				<div class="prev"></div>

				<div class="slide">

					<div class="slide-contain">

						<ul class="slider">

							<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>

								<li>

									<div class="image">

										<a href="<?php the_permalink(); ?>"><img src="<?php echo clpr_get_store_image_url( $post->ID, 'post_id', 160 ); ?>" alt="" /></a>

									</div>

									<span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>

								</li>

							<?php endwhile; ?>

						</ul>

					</div>

				</div>

				<div class="next"></div>

			</div>

		</div>

		<div class="featured-button">

			<span class="button-l">&nbsp;</span>

			<h1><?php _e( 'Featured Coupons', APP_TD ); ?></h1>

			<span class="button-r">&nbsp;</span>

		</div>

		<div class="gallery-b">&nbsp;</div>

	</div>

<?php endif; ?>

<?php wp_reset_postdata(); ?>
