<?php
// Template Name: User Orders


$current_user = wp_get_current_user(); // grabs the user info and puts into vars
$display_user_name = clpr_get_user_name();
?>


<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php printf( __( "%s's Orders", APP_TD ), $display_user_name ); ?></h1>

				<div class="text-box">

					<?php do_action( 'appthemes_notices' ); ?>

					<p><?php _e( 'Below is your Order history. Click on one of the options to perform a specific task. If you have any questions, please contact the site administrator.', APP_TD ); ?></p>

					<div class="orders-legend">
					<?php
						echo html( 'h4', __( 'Statuses Legend:', APP_TD ) );
						echo html( 'span', html( 'strong', __( 'Pending:', APP_TD ) ) . ' ' . __( 'Order not processed.', APP_TD ) );
						echo html( 'span', html( 'strong', __( 'Failed:', APP_TD ) ) . ' ' . __( 'Order failed or manually canceled.', APP_TD ) );
						echo html( 'span', html( 'strong', __( 'Completed:', APP_TD ) ) . ' ' . __( 'Order processed succesfully but pending moderation before activation.', APP_TD ) );
						echo html( 'span', html( 'strong', __( 'Activated:', APP_TD ) ) . ' ' . __( 'Order processed succesfully and activated.', APP_TD ) );
					?>
					</div>

					<?php
						// setup the pagination and query
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						query_posts( array( 'posts_per_page' => 10, 'post_type' => APPTHEMES_ORDER_PTYPE, 'author' => $current_user->ID, 'paged' => $paged ) );

						if ( have_posts() ) {
					?>
					<table class="couponList footable">
						<thead>
							<tr>
								<th class="col1" data-class="expand"><?php _e( 'ID', APP_TD ); ?></th>
								<th class="col2"><?php _e( 'Order Summary', APP_TD ); ?></th>
								<th class="col3" data-hide="phone"><?php _e( 'Price', APP_TD ); ?></th>
								<th class="col4" data-hide="phone"><?php _e( 'Payment/Status', APP_TD ); ?></th>
								<th class="col5" data-hide="phone"><?php _e( 'Options', APP_TD ); ?></th>
							</tr>
						</thead>
						<tbody>

						<?php
							while ( have_posts() ) {
								the_post();
								$order = appthemes_get_order( $post->ID );
								
								$listing_id = _clpr_get_order_coupon_id( $order );
								$listing = get_post( $listing_id );
								if ( ! $listing )
									continue;
						?>

							<tr>
								<td class="col1">#<?php the_ID(); ?></td>
								<td class="col2">
									<?php echo html( 'a', array( 'href' => get_permalink( $listing_id ) ), get_the_title( $listing_id ) ); ?>
									<?php clpr_display_ordered_items( $order ); ?>
									<span class="clock"><span><?php the_time( get_option( 'date_format' ) ); ?></span></span>
								</td>
								<td class="text-center"><?php appthemes_display_price( $order->get_total() ); ?></td>
								<td class="text-center">
								<?php
									echo html( 'span', array( 'class' => 'order-gateway' ), clpr_get_order_gateway_name( $order ) );
									echo html( 'span', array( 'class' => 'order-status' ), $order->get_display_status() );
								?>
								</td>
								<td class="text-center">
								<?php
									if ( APPTHEMES_ORDER_PENDING == $order->get_status() )
										echo html( 'a', array( 'href' => get_permalink( $order->get_id() ) ), __( 'Pay now', APP_TD ) );
								?>
								</td>
							</tr>

						<?php } ?>

						</tbody>
					</table>

					<?php appthemes_pagination(); ?>

					<?php } else { ?>

						<div class="pad10"></div>
							<p class="text-center"><?php _e( 'You currently have no orders.', APP_TD ); ?></p>
						<div class="pad10"></div>

					<?php } ?>

					<?php wp_reset_query(); ?>

				</div> <!-- /text-box -->

			</div> <!-- /blog -->

		</div> <!-- /box-holder -->

	</div> <!-- #content-box -->

</div><!-- /content -->

<?php get_sidebar( 'user' ); ?>
