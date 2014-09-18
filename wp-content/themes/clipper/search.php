<?php

if ( $clpr_options->search_stats )
	appthemes_save_search();
?>

<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="head">
				<h2><?php printf( __( "Search for '%s' returned %s results", APP_TD ), trim( get_search_query() ), $wp_query->found_posts ); ?></h2>
			</div> <!-- end head -->

			<?php if ( have_posts() ) : ?>

				<?php get_template_part( 'loop', 'search' ); ?>

			<?php else : ?>

				<div class="blog">
					<div class="pad10"></div>
					<h3><?php printf( __( 'Sorry, no coupons could be found for "%s".', APP_TD ), trim( get_search_query() ) ); ?></h3>
					<div class="pad75"></div>
				</div> <!-- end blog -->

			<?php endif; ?>

		</div> <!-- end box-holder -->

	</div> <!-- end content-box -->

</div> <!-- end content -->

<?php get_sidebar( 'coupon' ); ?>
