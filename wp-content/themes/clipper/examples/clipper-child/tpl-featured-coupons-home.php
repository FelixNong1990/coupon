<?php
// Template Name: Featured Coupons Home Template

// NOTE: This is just example of modifying template files,
// remove it from your child theme if you don't wish to have that homepage.

// show all featured coupons and setup pagination
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
query_posts( array(
	'post_type' => APP_POST_TYPE,
	'ignore_sticky_posts' => 1,
	'meta_key' => 'clpr_featured',
	'meta_value' => '1',
	'paged' => $paged
) );

// singular or plural for counter
$foundtxt = _n( 'There are currently %s featured coupon', 'There are currently %s featured coupons', $wp_query->found_posts, APP_TD );
?>


<div id="content">


	<div class="content-box">

			<div class="box-holder">

				<div class="head">
					<h2><?php _e( 'Featured Coupons', APP_TD ); ?></h2>
					<div class="counter"><?php printf( $foundtxt, '<span>' . $wp_query->found_posts . '</span>' ); ?></div>
				</div> <!-- #head -->

				<?php get_template_part( 'loop', 'coupon' ); ?>

			</div> <!-- #box-holder -->

	</div> <!-- #content-box -->


</div><!-- #content -->

<?php get_sidebar( 'home' ); ?>
