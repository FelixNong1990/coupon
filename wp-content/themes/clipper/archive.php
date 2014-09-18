
<div id="content">

	<?php if ( have_posts() ) the_post(); ?>

	<?php rewind_posts(); ?>

	<div class="content-box">

		<div class="box-holder">

			<div class="head">

				<h2 class="archive">
					<?php if ( is_day() ) : ?>
						<?php _e( 'Archive for', APP_TD ); ?> <?php the_time('F jS, Y'); ?>
					<?php elseif ( is_month() ) : ?>
						<?php _e( 'Archive for', APP_TD ); ?> <?php the_time('F, Y'); ?>
					<?php elseif ( is_year() ) : ?>
						<?php _e( 'Archive for', APP_TD ); ?> <?php the_time('Y'); ?>
					<?php elseif ( is_category() ) : ?>
						<?php _e( 'Archive for', APP_TD ); ?> <?php single_cat_title(); ?>
					<?php elseif ( is_tag() ) : ?>
						<?php printf( __( 'Posts Tagged with', APP_TD ) ); ?> &ldquo;<?php single_tag_title(); ?>&rdquo;
					<?php elseif ( is_author() ) : ?>
						<?php _e( 'Author Archive', APP_TD ); ?>
					<?php else : ?>
						<?php _e( 'Archive', APP_TD ); ?>
					<?php endif; ?>
				</h2>

			</div> <!-- #head -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->

	<?php get_template_part( 'loop' ); ?>

</div><!-- #content -->

<?php get_sidebar( 'coupon' ); ?>
