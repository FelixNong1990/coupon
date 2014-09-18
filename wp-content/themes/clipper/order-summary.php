
<div id="content-fullwidth">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Order Summary', APP_TD ); ?></h1>

				<div class="text-box">

					<?php do_action( 'appthemes_notices' ); ?>

					<div class="text-holder">

						<div class="order-summary">

							<?php
								the_order_summary();

								$order = get_order();
								$first_item = $order->get_item(0);
								$post_type_obj = get_post_type_object( $first_item['post']->post_type );
								$url = get_permalink( $first_item['post']->ID );
							?>
							<input type="submit" class="btn" value="<?php printf( __( 'Continue to %s', APP_TD ), $post_type_obj->labels->singular_name ); ?>" onClick="location.href='<?php echo $url; ?>';return false;">

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>
