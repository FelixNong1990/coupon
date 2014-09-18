<?php
// Template Name: Store Template

?>



<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Browse by Store', APP_TD ); ?></h1>

				<div class="text-box">

					<?php echo clpr_stores_list(); ?>

				</div>

			</div> <!-- #blog -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->

</div>

<?php get_sidebar( 'store' ); ?>
