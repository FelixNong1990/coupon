<?php
/**
 * The Template for displaying all single coupons.
 *
 * @package AppThemes
 * @subpackage Clipper
 * @since 1.0
 */
?>


<div id="content">

	<?php do_action( 'appthemes_notices' ); ?>

	<?php appthemes_before_loop(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php appthemes_stats_update( $post->ID ); //records the page hit ?>

			<?php appthemes_before_post(); ?>

			<div <?php post_class('content-box'); ?> id="post-<?php the_ID(); ?>">

				<div class="box-holder">

					<div class="blog">

						<?php appthemes_before_post_title(); ?>

						<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

						<?php appthemes_after_post_title(); ?>

						<div class="content-bar">
						<?php
							// Get the expiration date and format it for display
							$expire_date = get_post_meta( $post->ID, 'clpr_expire_date', true );
							if ( ! empty( $expire_date ) ) {
								$expire_date = __( ' - Expires: ', APP_TD ) . clpr_get_expire_date( $post->ID, 'display' );
							}
						?>
							<p class="meta"><span><?php echo get_the_date( get_option( 'date_format' ) ); ?> <?php echo $expire_date; ?></span> <i><?php echo get_the_term_list( $post->ID, APP_TAX_CAT, '', '<span class="sep">, </span>', '' ); ?></i></p>
							<p class="comment-count"><?php comments_popup_link( __( '0 Comments', APP_TD ), __( '1 Comment', APP_TD ), __( '% Comments', APP_TD ) ); ?></p>

						</div>

						<div class="head-box">

							<div class="store-holder">
								<div class="store-image">
									<a href="<?php echo appthemes_get_custom_taxonomy( $post->ID, APP_TAX_STORE, 'slug' ); ?>"><img src="<?php echo clpr_get_store_image_url( $post->ID, 'post_id', 110 ); ?>" alt="" /></a>
								</div>
							</div>

							<?php clpr_vote_box_badge( $post->ID ); ?>

							<div class="coupon-main">

								<?php clpr_coupon_code_box(); ?>

								<div class="clear"></div>

								<div class="store-info"><a href="<?php echo appthemes_get_custom_taxonomy($post->ID, APP_TAX_STORE, 'slug'); ?>"><?php echo appthemes_get_custom_taxonomy($post->ID, APP_TAX_STORE, 'name'); ?></a> </div>


							</div> <!-- #coupon-main -->

						</div> <!-- #head-box -->

						<div class="text-box">

							<h2><?php _e( 'Coupon Details', APP_TD ); ?></h2>

							<?php appthemes_before_post_content(); ?>

							<?php the_content(); ?>

							<?php clpr_edit_coupon_link(); ?>

							<?php clpr_reset_coupon_votes_link(); ?>

							<?php appthemes_after_post_content(); ?>

						</div>

						<div class="text-footer">

							<div class="tags"><?php _e( 'Tags:', APP_TD ); ?> <?php if ( get_the_term_list($post->ID, APP_TAX_TAG) ) echo get_the_term_list($post->ID, APP_TAX_TAG, '', '&nbsp;', '' ); else echo __( 'None', APP_TD ); ?></div>

							<?php if ( $clpr_options->stats_all && current_theme_supports( 'app-stats' ) ) { ?>
								<div class="stats"><?php appthemes_stats_counter($post->ID); ?></div>
							<?php } ?>

							<div class="clear"></div>

						</div>

						<div class="user-bar">

							<?php if ( comments_open() ) comments_popup_link( '<span>' . __( 'Leave a comment', APP_TD ) . '</span>', '<span>' . __( 'Leave a comment', APP_TD ) . '</span>', '<span>' . __( 'Leave a comment', APP_TD ) . '</span>', 'leave', '' ); ?>

							<?php // assemble the text and url we'll pass into each social media share link
								$social_text = urlencode(strip_tags(get_the_title() . ' ' . __( 'coupon from', APP_TD ) . ' ' . get_bloginfo('name'))); 
								$social_url = urlencode(get_permalink($post->ID));
							?>

							<ul class="social">

								<li><a class="rss" href="<?php echo get_post_comments_feed_link(get_the_ID()); ?>" rel="nofollow"><?php _e( 'Coupon Comments RSS', APP_TD ); ?></a></li>									
								<li><a class="twitter" href="http://twitter.com/home?status=<?php echo $social_text; ?>+-+<?php echo $social_url; ?>" rel="nofollow" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a></li>
								<li><a class="facebook" href="javascript:void(0);" onclick="window.open('http://www.facebook.com/sharer.php?t=<?php echo $social_text; ?>&amp;u=<?php echo $social_url; ?>','doc', 'width=638,height=500,scrollbars=yes,resizable=auto');" rel="nofollow"><?php _e( 'Facebook', APP_TD ); ?></a></li>
								<li><a class="digg" href="http://digg.com/submit?phase=2&amp;url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" rel="nofollow" target="_blank"><?php _e( 'Digg', APP_TD ); ?></a></li>

							</ul>

						</div> <!-- #user-bar -->

					</div> <!-- #blog -->

				</div> <!-- #box-holder -->

			</div> <!-- #content-box -->

			<?php appthemes_after_post(); ?>

			<?php comments_template(); ?>

	<?php endwhile; ?>


		<?php appthemes_after_endwhile(); ?>


	<?php else: ?>


		<?php appthemes_loop_else(); ?>


		<div class="blog">

			<h3><?php _e( 'Sorry, no coupons yet.', APP_TD ); ?></h3>

		</div> <!-- #blog -->


	<?php endif; ?>

	<?php appthemes_after_loop(); ?>

</div> <!-- #content -->

<?php get_sidebar( 'coupon' ); ?>
