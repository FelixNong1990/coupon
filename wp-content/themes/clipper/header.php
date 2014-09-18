
<div id="header">

	<div class="shadow">&nbsp;</div>

	<div class="holder">

		<div class="frame">

			<div class="panel">

				<?php wp_nav_menu( array( 'menu_id' => 'nav', 'theme_location' => 'primary', 'container' => '', 'fallback_cb' => false ) ); ?>

				<div class="bar">

					<ul class="social">

						<li><a class="rss" href="<?php echo appthemes_get_feed_url(); ?>" rel="nofollow" target="_blank"><?php _e( 'RSS', APP_TD ); ?></a></li>

						<?php if ( ! empty( $clpr_options->facebook_id ) ) { ?>
							<li><a class="facebook" href="<?php echo appthemes_make_fb_profile_url( $clpr_options->facebook_id ); ?>" rel="nofollow" target="_blank"><?php _e( 'Facebook', APP_TD ); ?></a></li>
						<?php } ?>

						<?php if ( ! empty( $clpr_options->twitter_id ) ) { ?>
							<li><a class="twitter" href="http://twitter.com/<?php echo stripslashes( $clpr_options->twitter_id ); ?>" rel="nofollow" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a></li>
						<?php } ?>

					</ul>

					<ul class="add-nav">

						<?php clpr_login_head(); ?>

					</ul>

				</div>

			</div>

			<div class="header-bar">

				<?php get_search_form(); ?>

				<div id="logo">

				<?php if ( $clpr_options->use_logo ) { ?>

					<a href="<?php echo home_url('/'); ?>" title="<?php bloginfo( 'description' ); ?>">
						<img src="<?php if ( ! empty( $clpr_options->logo_url ) ) echo $clpr_options->logo_url; else { echo appthemes_locate_template_uri('images/logo.png'); } ?>" alt="<?php bloginfo( 'name' ); ?>" />
					</a>

				<?php } else { ?>

					<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
					<div class="description"><?php bloginfo( 'description' ); ?></div>

				<?php } ?>

				</div>

			</div>

		</div> <!-- #frame -->

	</div> <!-- #holder -->

</div> <!-- #header -->
