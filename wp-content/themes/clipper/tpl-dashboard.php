<?php
// Template Name: User Dashboard


$current_user = wp_get_current_user(); // grabs the user info and puts into vars
$display_user_name = clpr_get_user_name();
?>


<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php printf( __( "%s's Dashboard", APP_TD ), $display_user_name ); ?></h1>

				<div class="text-box">

					<?php do_action( 'appthemes_notices' ); ?>

					<p><?php _e( 'Below you will find a listing of all your submitted coupons. Click on one of the options to perform a specific task. If you have any questions, please contact the site administrator.', APP_TD ); ?></p>

					<?php
						// setup the pagination and query
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						query_posts( array( 'posts_per_page' => 10, 'post_type' => APP_POST_TYPE, 'post_status' => 'publish, unreliable, pending, draft', 'author' => $current_user->ID, 'paged' => $paged ) );

						// build the row counter depending on what page we're on
						if ( $paged == 1 ) $i = 0; else $i = $paged * 10 - 10;
					?>

					<?php if ( have_posts() ) : ?>

						<table class="couponList footable">
							<thead>
								<tr>
									<th class="col1" data-class="expand">&nbsp;</th>
									<th class="col2"><?php _e( 'Title', APP_TD ); ?></th>
									<th class="col3" data-hide="phone"><?php _e( 'Views', APP_TD ); ?></th>
									<th class="col4" data-hide="phone"><?php _e( 'Status', APP_TD ); ?></th>
									<th class="col5" data-hide="phone"><?php _e( 'Options', APP_TD ); ?></th>
								</tr>
							</thead>
							<tbody>

							<?php while( have_posts() ) : the_post(); $i++; ?>

							<?php

								if ( get_post_meta( $post->ID, 'clpr_total_count', true ) )
									$ad_views = number_format( get_post_meta( $post->ID, 'clpr_total_count', true ) );
								else
									$ad_views = '-';


								// now let's figure out what the ad status and options should be
								// it's a live and published ad
								if ( $post->post_status == 'publish' || $post->post_status == 'unreliable' ) {

									$post_status = 'live';								
									$post_status_name = __( 'Live', APP_TD );								
									$fontcolor = '#33CC33';
									$postimage = 'icon-coupon-stop-small.png';
									$postalt =  __( 'Pause', APP_TD );
									$postaction = 'pause';

								// it's a pending ad which gives us several possibilities
								} elseif ( $post->post_status == 'pending' ) {

									if ( clpr_have_pending_payment( $post->ID ) ) {
										$post_status = 'pending_payment';
										$post_status_name = __( 'Awaiting payment', APP_TD );
										$fontcolor = '#C00202';
										$postimage = '';
										$postalt = '';
										$postaction = 'pending';
									} else {
										$post_status = 'pending';
										$post_status_name = __( 'Awaiting approval', APP_TD );
										$fontcolor = '#FF9900';
										$postimage = '';
										$postalt = '';
										$postaction = 'pending';
									}


								} elseif ( $post->post_status == 'draft' ) {

									$expire_date = clpr_get_expire_date( $post->ID, 'time' ) + ( 24 * 3600 ); // + 24h, coupons expire in the end of day

									// current date is past the expires date so mark ad ended
									if ( current_time( 'timestamp' ) > $expire_date ) {
										$post_status = 'ended';
										$post_status_name = __( 'Ended', APP_TD ) . '<br /><p class="small">(' . clpr_get_expire_date( $post->ID, 'display' ) . ')</p>';
										$fontcolor = '#666666';
										$postimage = '';
										$postalt = '';
										$postaction = 'ended';
									} else {
										// has been paused by owner
										$post_status = 'offline';
										$post_status_name = __( 'Offline', APP_TD );
										$fontcolor = '#bbbbbb';
										$postimage = 'icon-coupon-start-small.png';
										$postalt = __( 'Restart', APP_TD );
										$postaction = 'restart';
									}

								} else {
									$poststatus = '&mdash;';
								}
							?>

								<tr>
									<td class="col1"><?php echo $i; ?>.</td>
									<td class="col2">
										<h3 class="tplCouponTitle">

											<?php if ( $post_status == 'live' ) { ?>

												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

											<?php } else { ?>

												<?php the_title(); ?>

											<?php } ?>
										</h3>
										<div><span class="folder"><?php echo get_the_term_list(get_the_id(), APP_TAX_CAT, '', ', ', ''); ?></span> | <span class="clock"><span><?php the_time(get_option('date_format')); ?></span></span></div>
									</td>
									<td class="text-center"><?php echo $ad_views; ?></td>
									<td class="text-center"><span style="color:<?php echo $fontcolor; ?>;"><?php echo $post_status_name; ?></span></td>
									<td class="text-center">

										<?php

											if ( $post_status == 'pending' ) {

												echo '&mdash;';

											} elseif ( $post_status == 'pending_payment' ) {

												$order_url = clpr_get_order_permalink( $post->ID );
												echo html( 'a', array( 'href' => $order_url ), __( 'Pay now', APP_TD ) );

											} elseif ( $post_status == 'ended' ) {

												// relisting url
												$relist_url = add_query_arg( array( 'renew' => $post->ID ), CLPR_SUBMIT_URL );
												echo html( 'a', array( 'href' => $relist_url, 'title' => __( 'Relist Coupon', APP_TD ) ), __( 'Relist', APP_TD ) );

											} else {

												if ( $clpr_options->coupon_edit ) {
													$edit_url = add_query_arg( array( 'aid' => $post->ID ), CLPR_EDIT_URL );
													$edit_img = html( 'img', array( 'src' => appthemes_locate_template_uri( 'images/pencil-comment.png' ), 'class' => 'editOptions', 'title' => __( 'Edit Coupon', APP_TD ), 'alt' => __( 'Edit Coupon', APP_TD ) ) );
													echo html( 'a', array( 'href' => $edit_url, 'title' => __( 'Edit Coupon', APP_TD ) ), $edit_img ) . ' ';
												}

												$delete_url = add_query_arg( array( 'aid' => $post->ID, 'action' => 'delete' ), CLPR_DASHBOARD_URL );
												$delete_img = html( 'img', array( 'src' => appthemes_locate_template_uri( 'images/cross-circle.png' ), 'class' => 'editOptions', 'title' => __( 'Delete Coupon', APP_TD ), 'alt' => __( 'Delete Coupon', APP_TD ) ) );
												echo html( 'a', array( 'href' => $delete_url, 'onclick' => 'return confirm(clipper_params.text_before_delete_coupon);', 'title' => __( 'Delete Coupon', APP_TD ) ), $delete_img ) . ' ';

												$postaction_url = add_query_arg( array( 'aid' => $post->ID, 'action' => $postaction ), CLPR_DASHBOARD_URL );
												$postaction_img = html( 'img', array( 'src' => appthemes_locate_template_uri( 'images/' . $postimage ), 'class' => 'editOptions', 'title' => $postalt, 'alt' => $postalt ) );
												echo html( 'a', array( 'href' => $postaction_url, 'title' => $postalt ), $postaction_img ) . ' ';

											}

											if ( ! in_array( $post_status, array( 'live', 'offline' ) ) ) {
												$delete_url = add_query_arg( array( 'aid' => $post->ID, 'action' => 'delete' ), CLPR_DASHBOARD_URL );
												echo '<br />' . html( 'a', array( 'href' => $delete_url, 'onclick' => 'return confirm(clipper_params.text_before_delete_coupon);', 'title' => __( 'Delete Coupon', APP_TD ) ), __( 'Delete', APP_TD ) );
											}
										?>
									</td>
								</tr>

								<?php endwhile; ?>

							</tbody>
						</table>

						<?php appthemes_pagination(); ?>

					<?php else : ?>

						<div class="pad10"></div>
							<p class="text-center"><?php _e( 'You currently have no coupons.', APP_TD ); ?></p>
						<div class="pad10"></div>

					<?php endif; ?>

					<?php wp_reset_query(); ?>

				</div> <!-- /text-box -->

			</div> <!-- /blog -->

		</div> <!-- /box-holder -->

	</div> <!-- #content-box -->

</div><!-- /content -->

<?php get_sidebar( 'user' ); ?>
