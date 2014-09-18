<?php
// Template Name: Blog Template

if ( ! defined( 'ABSPATH' ) )
	die();
?>


<div id="content">

	<?php get_template_part( 'loop' ); ?>

</div>

<?php get_sidebar( 'blog' ); ?>
