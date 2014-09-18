
<div id="content">

	<?php appthemes_before_page_loop(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php appthemes_before_page(); ?>

			<div class="content-box">

				<div class="box-holder">

					<div class="blog">

						<?php appthemes_before_page_title(); ?>

						<h1><?php the_title(); ?></h1>

						<?php appthemes_after_page_title(); ?>

						<?php appthemes_before_page_content(); ?>

						<div class="text-box">

							<?php the_content(); ?>

						</div>

						<?php appthemes_after_page_content(); ?>

					</div> <!-- #blog -->

				</div> <!-- #box-holder -->

			</div> <!-- #content-box -->

			<?php appthemes_after_page(); ?>

		<?php endwhile; ?>

			<?php appthemes_after_page_endwhile(); ?>

	<?php else: ?>

		<?php appthemes_page_loop_else(); ?>

	<?php endif; ?>

	<?php appthemes_after_page_loop(); ?>

	<?php if ( comments_open() ) comments_template(); ?>

</div> <!-- #content -->

<?php get_sidebar( 'page' ); ?>
