<?php
// Template Name: Coupons Home Template


// Featured Slider
if ( $clpr_options->featured_slider )
	get_template_part( 'featured' );

$post_status = ( $clpr_options->exclude_unreliable ) ? array( 'publish' ) : array( 'publish', 'unreliable' );
?>

<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="head">

				<h2><?php _e( 'New Coupons', APP_TD ); ?></h2>

				<div class="counter"><?php printf( _n( 'There are currently %s active coupon', 'There are currently %s active coupons', clpr_count_posts( APP_POST_TYPE, $post_status ), APP_TD ), '<span>' . clpr_count_posts( APP_POST_TYPE, $post_status ) . '</span>'); ?></div>

			</div> <!-- #head -->

			<?php
				// show all coupons and setup pagination
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				query_posts( array( 'post_type' => APP_POST_TYPE, 'post_status' => $post_status, 'ignore_sticky_posts' => 1, 'paged' => $paged ) );
			?>

			<?php get_template_part( 'loop', 'coupon' ); ?>

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->

</div><!-- #container -->

<?php get_sidebar( 'home' ); ?>
