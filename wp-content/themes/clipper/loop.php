<?php
/**
 * The loop that displays the blog posts.
 *
 * @package AppThemes
 * @subpackage Clipper
 *
 */


// hack needed for "<!-- more -->" to work with templates
// call before the loop
global $more;
$more = 0;
?>

<?php appthemes_before_blog_loop(); ?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( is_single() ) appthemes_stats_update( $post->ID ); //records the page hit on single blog page view ?>

		<?php appthemes_before_blog_post(); ?>

		<div <?php post_class('content-box'); ?> id="post-<?php the_ID(); ?>">

			<div class="box-holder">

				<div class="blog">

					<?php appthemes_before_blog_post_title(); ?>

					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

					<?php appthemes_after_blog_post_title(); ?>

					<?php appthemes_before_blog_post_content(); ?>

					<div class="text-box">

						<?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>

						<?php the_content( '<p>' . __( 'Continue reading &raquo;', APP_TD ) . '</p>' ); ?>

						<?php edit_post_link( __( 'Edit Post', APP_TD ), '<p class="edit">', '</p>' ); ?>

					</div>

					<?php appthemes_after_blog_post_content(); ?>

				</div>

			</div>

		</div>

		<?php appthemes_after_blog_post(); ?>


	<?php endwhile; ?>

	<?php appthemes_after_blog_endwhile(); ?>


<?php else: ?>


	<?php appthemes_blog_loop_else(); ?>

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'No Posts Found', APP_TD ); ?></h1>

				<div class="text-box">

					<?php _e( 'Sorry, no posts found.', APP_TD ); ?>

				</div>

			</div>

		</div>

	</div>


<?php endif; ?>

<?php appthemes_after_blog_loop(); ?>
