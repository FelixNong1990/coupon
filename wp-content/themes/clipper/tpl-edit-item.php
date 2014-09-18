<?php
// Template Name: User Edit Item


$current_user = wp_get_current_user(); // grabs the user info and puts into vars

// get the ad id from the querystring.
$aid = appthemes_numbers_only( $_GET['aid'] );
// make sure the ad id is legit otherwise set it to zero which will return no results
if ( empty( $aid ) )
	$aid = 0;

?>

<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Edit Your Coupon', APP_TD ); ?></h1>

				<div class="post-box">

					<?php do_action( 'appthemes_notices' ); ?>

					<p><?php _e( 'Edit the fields below and click save to update your coupon. Your changes will be updated instantly on the site.', APP_TD ); ?></p>

					<?php query_posts( array( 'post_type' => APP_POST_TYPE, 'post_status' => 'publish, unreliable, pending, draft', 'author' => $current_user->ID, 'p' => $aid, 'no_found_rows' => true ) ); ?>

					<?php if ( have_posts() ) : ?>

						<?php while( have_posts() ) : the_post(); ?>

							<form action="" id="couponForm" method="post" class="post-form" enctype="multipart/form-data">

								<?php wp_nonce_field( 'clpr-edit-item' ); ?>

								<fieldset>

									<ol>

										<li>
											<label><?php _e( 'Store Name:', APP_TD ); ?></label>
											<p id="store-name"><?php echo $store_name = appthemes_get_custom_taxonomy($post->ID, APP_TAX_STORE, 'name'); ?></p>
										</li>

										<li>
											<label><?php _e( 'Coupon Title:', APP_TD ); ?> </label>
											<input type="text" class="text required" name="post_title" value="<?php echo esc_attr( $post->post_title ); ?>" />
										</li>

										<li>
											<?php $cat_id = appthemes_get_custom_taxonomy($post->ID, APP_TAX_CAT, 'term_id'); ?>
											<label><?php _e( 'Coupon Category:', APP_TD ); ?> </label>
											<?php wp_dropdown_categories('taxonomy='.APP_TAX_CAT.'&hierarchical=1&class=text required&name=coupon_cat&selected='.$cat_id.'&hide_empty=0'); ?>
										</li>

										<li>
											<label><?php _e( 'Coupon Type:', APP_TD ); ?> </label>
											<select id="coupon_type_select" name="coupon_type_select" class="text required">
												<?php
													$coupon_type_id = appthemes_get_custom_taxonomy($post->ID, APP_TAX_TYPE, 'term_id');
													$terms = get_terms( APP_TAX_TYPE, array( 'hide_empty' => 0 ) );
													foreach( $terms as $term ) {
														$selected = selected( $term->term_id, $coupon_type_id, false );
														echo '<option value="' . $term->slug . '" ' . $selected . '>' . $term->name . '</option>';
													}
												?>
											</select>
										</li>

										<li id="ctype-coupon-code" class="ctype">
											<label><?php _e( 'Coupon Code:', APP_TD ); ?> </label>
											<input type="text" class="text" id="ctype-coupon-code" name="clpr_coupon_code" value="<?php echo get_post_meta($post->ID, 'clpr_coupon_code', true); ?>"/>
										</li>

										<?php if ( clpr_has_printable_coupon( $post->ID ) ) { ?>
											<li id="ctype-printable-coupon-preview" class="ctype">
												<label><?php _e( 'Current Coupon:', APP_TD ); ?> </label>
												<?php echo clpr_get_printable_coupon( $post->ID ); ?>
											</li>
										<?php } ?>

										<li id="ctype-printable-coupon" class="ctype">
											<label><?php _e( 'Printed Coupon:', APP_TD ); ?> </label>
											<input type="file" class="fileupload text" name="coupon-upload" value="" />
										</li>

										<li>
											<label><?php _e( 'Destination URL:', APP_TD ); ?></label>
											<input type="text" class="text required" name="clpr_coupon_aff_url" value="<?php echo get_post_meta($post->ID, 'clpr_coupon_aff_url', true); ?>"/>
										</li>

										<li>
											<label><?php _e( 'Expiration Date:', APP_TD ); ?> </label>
											<input type="text" class="text required datepicker" name="clpr_expire_date" value="<?php echo get_post_meta($post->ID, 'clpr_expire_date', true); ?>" <?php disabled( $clpr_options->prune_coupons ); ?> />
										</li>

										<li>
											<label><?php _e( 'Tags:', APP_TD ); ?> </label>
											<input type="text" class="text" name="tags_input" value="<?php echo appthemes_get_all_taxonomy($post->ID, APP_TAX_TAG, '', ', '); ?>" />
											<p class="tip"><?php _e( 'Separate tags with commas', APP_TD ); ?></p>
										</li>

										<li class="description">
											<label for="post_content"><?php _e( 'Description:', APP_TD ); ?></label>
											<?php if ( $clpr_options->allow_html && ! wp_is_mobile() ) { ?>
												<?php wp_editor( $post->post_content, 'post_content', clpr_get_editor_settings() ); ?>
											<?php } else { ?>
												<textarea class="required" id="post_content" cols="30" rows="5" name="post_content"><?php echo esc_textarea( $post->post_content ); ?></textarea>
											<?php } ?>
										</li>

										<li>
											<button type="submit" class="btn edit" name="submit" value="<?php _e( 'Update Coupon &raquo;', APP_TD ); ?>"><?php _e( 'Update Coupon &raquo;', APP_TD ); ?></button>
										</li>

									</ol>

									<input type="hidden" name="action" value="clpr-edit-item" />
									<input type="hidden" name="cid" value="<?php echo $post->ID; ?>" />

								</fieldset>

							</form>

						<?php endwhile; ?>



					<?php else : ?>


						<div class="pad10"></div>

						<p class="text-center"><?php _e( 'You have entered an invalid coupon id or do not have permission to edit that coupon.', APP_TD ); ?></p>

						<div class="pad25"></div>


					<?php endif; ?>

					<?php wp_reset_query(); ?>

				</div> <!-- #post-box -->


			</div> <!-- #blog -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->


</div>

<?php get_sidebar( 'user' ); ?>
