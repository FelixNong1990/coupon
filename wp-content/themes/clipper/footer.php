<div id="footer">
	<div class="panel">

		<div class="panel-holder">

		<?php if ( ! dynamic_sidebar( 'sidebar_footer' ) ) : ?>

		<!-- no dynamic sidebar so don't do anything -->
		<div id="widgetized-area">

			<?php if ( ! dynamic_sidebar( 'widgetized-area' ) ) : ?>

				<div class="pre-widget">

					<p><strong><?php _e( 'Widgetized Area', APP_TD ); ?></strong></p>
					<p><?php _e( 'The footer is active and ready for you to add some widgets via the Clipper admin panel.', APP_TD ); ?></p>

				</div>

			<?php endif; ?>

		</div> <!-- widgetized-area -->

		<?php endif; ?>

		</div> <!-- panel-holder -->

	</div> <!-- panel -->

	<div class="bar">

		<div class="bar-holder">

			<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => '', 'depth' => 1, 'fallback_cb' => false ) ); ?>
			<p><?php _e( 'Copyright &copy;', APP_TD ); ?> <?php echo date('Y'); ?> | <a target="_blank" href="http://buzzgfx.com" title="<?php _e( 'BUZZGFX', APP_TD ); ?>"><?php _e( 'BUZZGFX', APP_TD ); ?></a> | <?php _e( 'Powered by', APP_TD ); ?> <a target="_blank" href="http://wordpress.org/" title="WordPress">WordPress</a></p>

		</div>

	</div>
</div> <!-- #footer -->
