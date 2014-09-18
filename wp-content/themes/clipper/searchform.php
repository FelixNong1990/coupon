<?php $sq = get_search_query() ? get_search_query() : __( 'Search for coupon codes', APP_TD ); ?>

<div class="search-box">

	<div class="holder">

		<form method="get" class="search" id="searchform" action="<?php echo home_url('/'); ?>" >

			<fieldset>

				<div class="row">

					<div class="text">
						<input type="text" class="newtag" name="s" value="<?php _e( 'Search for coupon codes', APP_TD ); ?>" onfocus="clearAndColor(this)" onblur="reText(this)"/>
					</div>
					<div class="row">
						<button name="Search" value="Search" id="Search" title="<?php _e( 'Search', APP_TD ); ?>" type="submit" class="btn-submit"><span style="margin-top: -1px;"><?php _e( 'Search', APP_TD ); ?></span></button>
					</div>

				</div>

			</fieldset>

		</form>

	</div>

</div>
