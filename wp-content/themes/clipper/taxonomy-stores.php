<?php
$term = get_queried_object();
$stores_url = esc_url( clpr_get_store_meta( $term->term_id, 'clpr_store_url', true ) );
$url_out = clpr_get_store_out_url( $term );
?>

<div id="content">


	<div class="content-box">

		<div class="box-holder">

			<div class="store">

				<div class="text-box">

					<div class="thumb-wrap">
						<a href="<?php echo $url_out; ?>"><img class="store-thumb" src="<?php echo clpr_get_store_image_url( $term->term_id, 'term_id', 150 ); ?>" alt="" /></a>
					</div>

					<div class="info">
						<a class="rss-link" href="<?php echo get_term_feed_link($term->term_id, $taxonomy); ?>" rel="nofollow" target="_blank"><?php _e( 'Store RSS', APP_TD ); ?></a>
						<h1><?php echo $term->name; ?></h1>
						<div class="desc"><?php echo term_description(); ?></div>
						<p class="store-url"><a href="<?php echo $url_out; ?>" target="_blank"><?php echo $stores_url; ?></a></p>
					</div> <!-- #info -->

				</div> <!-- #text-box -->

				<div class="clr"></div>

				<div class="adsense">
					<?php appthemes_advertise_content(); ?>
				</div> <!-- #adsense -->

			</div> <!-- #store -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->


	<div class="content-box">

		<div class="box-holder">

			<div class="head">

				<h2><?php _e( 'Active Coupons', APP_TD ); ?></h2>

				<?php
					// show all active coupons for this store and setup pagination
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					query_posts( array(
						'post_type' => APP_POST_TYPE,
						'post_status' => 'publish',
						APP_TAX_STORE => $term->slug,
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
					// show all unreliable coupons for this store and setup pagination
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					query_posts( array(
						'post_type' => APP_POST_TYPE,
						'post_status' => 'unreliable',
						APP_TAX_STORE => $term->slug,
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


</div><!-- #content -->

<?php wp_reset_query(); ?>

<?php get_sidebar( 'store' ); ?>
