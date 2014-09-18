<?php
/**
 * Submit Coupon Form
 * Function outputs the submit coupon form
 * used in tpl-submit-coupon.php
 *
 * @version 1.0
 * @author AppThemes
 *
 */

$step = 1;
$renew_id = ( isset( $_GET['renew'] ) ) ? $_GET['renew'] : false;
$renew = ( $renew_id ) ? get_post( $renew_id ) : false;
?>


<?php if ( ! $clpr_options->reg_required && ! $clpr_options->charge_coupons ) { ?>


	<?php clpr_show_coupon_form( false ); ?>


<?php } else { ?>


	<?php if ( is_user_logged_in() ) { ?>

		<?php clpr_show_coupon_form( $renew ); ?>

	<?php } else { ?>

		<div class="blog">

			<h1><?php _e( 'Login Required', APP_TD ); ?></h1>

			<div class="text-box">

				<div class="text-holder">

					<p><?php printf( __( 'You must be <a href="%s">logged in</a> before submitting coupons.', APP_TD ), wp_login_url() ); ?></p>

					<div class="pad75"></div>

				</div>

			</div>

		</div>

	<?php } ?>


<?php } ?>	
