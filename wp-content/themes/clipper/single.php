<?php
/**
 * The Template for displaying all single blog posts.
 *
 * @package AppThemes
 * @subpackage Clipper
 */
?>


<div id="content">

	<?php get_template_part( 'loop' ); ?>

	<?php appthemes_advertise_content(); ?>

	<?php if ( comments_open() ) comments_template(); ?>

</div>

<?php get_sidebar( 'blog' ); ?>
