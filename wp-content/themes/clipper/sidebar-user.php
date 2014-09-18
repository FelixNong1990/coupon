<?php
global $current_user;

$display_user_name = clpr_get_user_name();
?>

<div id="sidebar">

	<?php appthemes_before_sidebar_widgets(); ?>


	<div class="sidebox" id="user-options">

		<div class="customclass"></div>

		<div class="sidebox-content">

			<div class="sidebox-heading"><h2><?php _e( 'User Options', APP_TD ); ?></h2></div>

			<div class="textwidget">
				<ul>
					<li><a href="<?php echo CLPR_DASHBOARD_URL; ?>"><?php _e( 'My Dashboard', APP_TD ); ?></a></li>
					<?php if ( clpr_payments_is_enabled() ) { ?><li><a href="<?php echo CLPR_ORDERS_URL; ?>"><?php _e( 'My Orders', APP_TD ); ?></a></li><?php } ?>
					<li><a href="<?php echo CLPR_PROFILE_URL; ?>"><?php _e( 'Edit Profile', APP_TD ); ?></a></li>
					<?php if (current_user_can('edit_others_posts')) { ?><li><a href="<?php echo admin_url(); ?>"><?php _e( 'WordPress Admin', APP_TD ); ?></a></li><?php } ?>
					<li><a href="<?php echo clpr_logout_url( home_url() ); ?>"><?php _e( 'Log Out', APP_TD ); ?></a></li>
				</ul>
			</div>

		</div> <!-- #sidebox-content -->

		<br clear="all" />

		<div class="sb-bottom"></div>

	</div> <!-- #sidebox -->


	<div class="sidebox" id="user-info">

		<div class="customclass"></div>

		<div class="sidebox-content">

			<div class="sidebox-heading"><h2><?php _e( 'Account Information', APP_TD ); ?></h2></div>

			<div class="textwidget">
				<div class="avatar"><?php appthemes_get_profile_pic($current_user->ID, $current_user->user_email, 60); ?></div>

				<ul class="user-info">
					<li><strong><a href="<?php echo get_author_posts_url($current_user->ID); ?>"><?php echo $display_user_name; ?></a></strong></li>
					<li><strong><?php _e( 'Member Since:', APP_TD ); ?></strong> <?php appthemes_get_reg_date($current_user->user_registered); ?></li>
					<li><strong><?php _e( 'Last Login:', APP_TD ); ?></strong> <?php appthemes_get_last_login($current_user->ID); ?></li>
				</ul>

				<ul class="user-details">
					<li><div class="emailico"></div><a href="mailto:<?php echo $current_user->user_email; ?>"><?php echo $current_user->user_email; ?></a></li>
					<li><div class="twitterico"></div><?php if ( $current_user->twitter_id ) { ?><a href="http://twitter.com/<?php echo urlencode($current_user->twitter_id); ?>" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a><?php } else { _e( 'N/A', APP_TD ); } ?></li>
					<li><div class="facebookico"></div><?php if ( $current_user->facebook_id ) { ?><a href="<?php echo appthemes_make_fb_profile_url( $current_user->facebook_id ); ?>" target="_blank"><?php _e( 'Facebook', APP_TD ); ?></a><?php } else { _e( 'N/A', APP_TD ); } ?></li>
					<li><div class="globeico"></div><?php if ( $current_user->user_url ) { ?><a href="<?php echo $current_user->user_url; ?>" target="_blank"><?php echo esc_url($current_user->user_url); ?></a><?php } else { _e( 'N/A', APP_TD ); } ?></li>
				</ul>
			</div>

		</div> <!-- #sidebox-content -->

		<br clear="all" />

		<div class="sb-bottom"></div>

	</div> <!-- #sidebox -->


	<div class="sidebox" id="user-stats">

		<div class="customclass"></div>

		<div class="sidebox-content">

			<div class="sidebox-heading"><h2><?php _e( 'Account Statistics', APP_TD ); ?></h2></div>

			<div class="textwidget">

				<ul class="user-stats">

				<?php
					// calculate the total count of live coupons for current user
					$post_count_live = $wpdb->get_var( $wpdb->prepare( "SELECT count(ID) FROM $wpdb->posts WHERE post_author = %d AND post_type = %s AND post_status IN ('publish', 'unreliable')", $current_user->ID, APP_POST_TYPE ) );
					$post_count_pending = $wpdb->get_var( $wpdb->prepare( "SELECT count(ID) FROM $wpdb->posts WHERE post_author = %d AND post_type = %s AND post_status = 'pending'", $current_user->ID, APP_POST_TYPE ) );
					$post_count_offline = $wpdb->get_var( $wpdb->prepare( "SELECT count(ID) FROM $wpdb->posts WHERE post_author = %d AND post_type = %s AND post_status = 'draft'", $current_user->ID, APP_POST_TYPE ) );
					$post_count_total = $post_count_live + $post_count_pending + $post_count_offline;
				?>

					<li class="couponLive"><?php _e( 'Live Coupons:', APP_TD ); ?> <strong><?php echo $post_count_live; ?></strong></li>
					<li class="couponPending"><?php _e( 'Pending Coupons:', APP_TD ); ?> <strong><?php echo $post_count_pending; ?></strong></li>
					<li class="couponOffline"><?php _e( 'Offline Coupons:', APP_TD ); ?> <strong><?php echo $post_count_offline; ?></strong></li>
					<li class="couponTotal"><?php _e( 'Total Coupons:', APP_TD ); ?> <strong><?php echo $post_count_total; ?></strong></li>

				</ul>

			</div>

		</div> <!-- #sidebox-content -->

		<br clear="all" />

		<div class="sb-bottom"></div>

	</div> <!-- #sidebox -->


	<?php if ( ! dynamic_sidebar( 'sidebar_user' ) ) : ?>

		<!-- no dynamic sidebar so don't do anything -->

	<?php endif; ?>

	<?php appthemes_after_sidebar_widgets(); ?>

</div> <!-- #sidebar -->
