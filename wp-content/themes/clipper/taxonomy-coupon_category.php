<?php $term = get_queried_object(); ?>

<div id="content">


	<div class="content-box">

		<div class="box-holder">

			<div class="store">

				<div class="text-box">
					<a class="rss-link" href="<?php echo get_term_feed_link($term->term_id, $taxonomy); ?>" rel="nofollow" target="_blank"><?php _e( 'Coupon Category RSS', APP_TD ); ?></a>
					<h1><?php printf( __( 'Coupons in the "%s" category', APP_TD ), $term->name ); ?></h1>
					<div class="desc"><?php echo term_description(); ?></div>
				</div> <!-- #text-box -->

				<div class="clr"></div>

			</div> <!-- #store -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->


	<div class="content-box">

		<div class="box-holder">

			<div class="head">

				<h2><?php _e( 'Active Coupons', APP_TD ); ?></h2>

				<?php
					// show all active coupons for this category and setup pagination
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					query_posts( array(
						'post_type' => APP_POST_TYPE,
						'post_status' => 'publish',
						APP_TAX_CAT => $term->slug,
						'ignore_sticky_posts' => 1,
						'paged' => $paged
					) );

					// singular or plural for counter
					$foundtxt = _n( 'Currently %s active coupon', 'Currently %s active coupons', $wp_query->found_posts, APP_TD );
				?>

				<div class="counter"><?php printf( $foundtxt, '<span>' . $wp_query->found_posts . '</span>' ); ?></div>

			</div> <!-- #head -->

			<?php get_template_part( 'loop', 'coupon' ); ?>

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->


	<div class="content-box">

		<div class="box-holder">

			<div class="head">

				<h2><?php _e( 'Unreliable Coupons', APP_TD ); ?></h2>

				<?php
					// show all unreliable coupons for this category and setup pagination
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					query_posts( array(
						'post_type' => APP_POST_TYPE,
						'post_status' => 'unreliable',
						APP_TAX_CAT => $term->slug,
						'ignore_sticky_posts' => 1,
						'paged' => $paged
					) );

					// singular or plural for counter
					$foundtxt = _n( 'Currently %s unreliable coupon', 'Currently %s unreliable coupons', $wp_query->found_posts, APP_TD );
					?>

				<div class="counter-red"><?php printf( $foundtxt, '<span>' . $wp_query->found_posts . '</span>' ); ?></div>

			</div> <!-- #head -->

			<?php get_template_part( 'loop', 'coupon' ); ?>

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->


</div><!-- #container -->

<?php wp_reset_query(); ?>

<?php get_sidebar( 'coupon' ); ?>
