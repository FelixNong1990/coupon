<div id="sidebar">

	<?php appthemes_before_sidebar_widgets(); ?>

	<?php if ( ! dynamic_sidebar( 'sidebar_store' ) ) : ?>

		<!-- no dynamic sidebar so don't do anything -->

	<?php endif; ?>

	<?php appthemes_after_sidebar_widgets(); ?>

</div> <!-- #sidebar -->
