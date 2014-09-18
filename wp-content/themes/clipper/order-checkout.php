
<div id="content-fullwidth">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Order Summary', APP_TD ); ?></h1>

				<div class="text-box">

					<div class="text-holder">

						<div class="order-summary">

							<?php the_order_summary(); ?>

							<form action="<?php the_order_return_url(); ?>" method="POST">
								<p><?php _e( 'Please select a method for processing your payment:', APP_TD ); ?></p>
								<?php appthemes_list_gateway_dropdown(); ?>
								<button class="btn coupon" type="submit"><?php _e( 'Submit', APP_TD ); ?></button>
							</form>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>
