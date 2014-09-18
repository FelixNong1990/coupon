<?php
/**
 * The loop that displays the coupons.
 *
 * @package AppThemes
 * @subpackage Clipper
 *
 */
global $clpr_options;
?>

<?php appthemes_before_loop(); ?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php appthemes_before_post(); ?>

		<div <?php post_class('item'); ?> id="post-<?php echo $post->ID; ?>">

			<div class="item-holder">

				<div class="item-frame">

					<div class="store-holder">
						<div class="store-image">
							<a href="<?php echo appthemes_get_custom_taxonomy( $post->ID, APP_TAX_STORE, 'slug' ); ?>"><img src="<?php echo clpr_get_store_image_url( $post->ID, 'post_id', 110 ); ?>" alt="" /></a>
						</div>
						<div class="store-name">
							<?php echo get_the_term_list( $post->ID, APP_TAX_STORE, ' ', ', ', '' ); ?>
						</div>
					</div>

					<?php clpr_vote_box_badge( $post->ID ); ?>

					<div class="item-panel">

						<?php clpr_coupon_code_box(); ?>

						<div class="clear"></div>

						<?php appthemes_before_post_title(); ?>

						<h3><?php clpr_coupon_title(); ?></h3>

						<?php appthemes_after_post_title(); ?>

						<?php appthemes_before_post_content(); ?>

						<p class="desc"><?php clpr_coupon_content(); ?></p>
	
						<?php appthemes_after_post_content(); ?>
									
					</div> <!-- #item-panel -->

					<div class="clear"></div>

					<div class="calendar">
						<ul>
							<li class="create"><?php echo appthemes_date_posted( $post->post_date ); ?></li>
							<li class="expire"><?php echo clpr_get_expire_date( $post->ID, 'display' ); ?></li>
						</ul>
					</div>

					<div class="taxonomy">
						<p class="category"><?php _e( 'Category:', APP_TD ); ?> <?php echo get_the_term_list( $post->ID, APP_TAX_CAT, ' ', ', ', '' ); ?></p>
						<p class="tag"><?php _e( 'Tags:', APP_TD ); ?> <?php echo get_the_term_list( $post->ID, APP_TAX_TAG, ' ', ', ', '' ); ?></p>
					</div>

				</div> <!-- #item-frame -->

				<div class="item-footer">

					<ul class="social">

						<li class="stats"><?php if ( $clpr_options->stats_all && current_theme_supports( 'app-stats' ) ) appthemes_stats_counter( $post->ID ); ?></li>
						<li><a class="share" href="#"><?php _e( 'Share', APP_TD ); ?></a>

							<div class="drop">

							<?php
								// assemble the text and url we'll pass into each social media share link
								$social_text = urlencode( strip_tags( get_the_title() . ' ' . __( 'coupon from', APP_TD ) . ' ' . get_bloginfo( 'name' ) ) );
								$social_url = urlencode( get_permalink( $post->ID ) );
							?>

								<ul>
									<li><a class="mail" href="#" data-id="<?php echo $post->ID; ?>" rel="nofollow"><?php _e( 'Email to Friend', APP_TD ); ?></a></li>
									<li><a class="facebook" href="javascript:void(0);" onclick="window.open('http://www.facebook.com/sharer.php?t=<?php echo $social_text; ?>&amp;u=<?php echo $social_url; ?>','doc', 'width=638,height=500,scrollbars=yes,resizable=auto');" rel="nofollow"><?php _e( 'Facebook', APP_TD ); ?></a></li>
									<li><a class="twitter" href="http://twitter.com/home?status=<?php echo $social_text; ?>+-+<?php echo $social_url; ?>" rel="nofollow" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a></li>
									<li><a class="digg" href="http://digg.com/submit?phase=2&amp;url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" rel="nofollow" target="_blank"><?php _e( 'Digg', APP_TD ); ?></a></li>
									<li><a class="reddit" href="http://reddit.com/submit?url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" rel="nofollow" target="_blank"><?php _e( 'Reddit', APP_TD ); ?></a></li>
								</ul>

							</div>

						</li>

						<li><?php clpr_comments_popup_link( '<span></span> ' . __( 'Comment', APP_TD ), '<span>1</span> ' . __( 'Comment', APP_TD ), __( '<span>%</span> Comments', APP_TD ), 'show-comments' ); // leave spans for ajax to work correctly ?></li>

						<?php clpr_report_coupon( true ); ?>

					</ul>

					<div id="comments-<?php echo $post->ID; ?>" class="comments-list">

						<p class="links"><span class="pencil"></span><?php if ( comments_open() ) clpr_comments_popup_link( __( 'Add a comment', APP_TD ), __( 'Add a comment', APP_TD ), __( 'Add a comment', APP_TD ), 'mini-comments' ); else echo '<span class="closed">' . __( 'Comments closed', APP_TD ) . '</span>'; ?><span class="minus"></span><?php clpr_comments_popup_link( __( 'Close comments', APP_TD ), __( 'Close comments', APP_TD ), __( 'Close comments', APP_TD ), 'show-comments' ); ?></p>

						<?php global $withcomments; $withcomments = 1; ?>

						<?php comments_template('/comments-mini.php'); ?>

					</div>


				</div>

			</div>

		</div>

		<?php appthemes_after_post(); ?>


<?php endwhile; ?>


	<?php appthemes_after_endwhile(); ?>


<?php else: ?>


	<?php appthemes_loop_else(); ?>


	<div class="blog">

		<h3><?php _e( 'Sorry, no coupons found', APP_TD ); ?></h3>

	</div> <!-- #blog -->


<?php endif; ?>

<?php appthemes_after_loop(); ?>
