<?php
// Template Name: Share Coupon Template


global $posted, $user_ID;
$posted = array();
$errors = new WP_Error();

?>

<div id="content">

	<div class="content-box">

			<div class="box-holder">


				<?php

				// check and make sure the form was submitted from step1
				if ( isset( $_POST['submitted'] ) ) {

					include_once( get_template_directory() . '/includes/forms/submit-coupon/submit-coupon-process.php' );

				} else {

					include_once( get_template_directory() . '/includes/forms/submit-coupon/submit-coupon-form.php' );

				}
				?>


			</div>

	</div>

</div>

<?php get_sidebar( 'submit' ); ?>
