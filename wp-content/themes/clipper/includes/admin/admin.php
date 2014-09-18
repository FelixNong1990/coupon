<?php


/**
 * Adds and removes meta boxes on the coupon edit admin page.
 *
 * @return void
 */
function clpr_setup_meta_box() {

	add_meta_box( 'coupon-meta-box', __( 'Coupon Meta Fields', APP_TD ), 'clpr_custom_fields_meta_box', APP_POST_TYPE, 'normal', 'high' );

	remove_meta_box( 'tagsdiv-stores', APP_POST_TYPE, 'core' );
	remove_meta_box( 'coupon_typediv', APP_POST_TYPE, 'core' );

	remove_meta_box( 'postexcerpt', APP_POST_TYPE, 'normal' );
	remove_meta_box( 'authordiv', APP_POST_TYPE, 'normal' );

	//custom post statuses
	//temporary hack until WP will fully support custom post statuses
	remove_meta_box( 'submitdiv', APP_POST_TYPE, 'core' );
	add_meta_box( 'submitdiv', __( 'Publish', APP_TD ), 'clpr_post_submit_meta_box', APP_POST_TYPE, 'side', 'high' );

}
add_action( 'admin_menu', 'clpr_setup_meta_box' );


/**
 * Displays the coupon meta fields in a custom meta box.
 *
 * @return void
 */
function clpr_custom_fields_meta_box() {
	global $post;

	// use nonce for verification
	wp_nonce_field( 'coupon_meta', 'coupon_meta_wpnonce', false, true );
?>

	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {

		var formfield;

		// upload printable coupon image
		jQuery('input#upload_image_button').click(function() {
			formfield = jQuery(this).attr('rel');
			tb_show('', 'media-upload.php?post_id=<?php echo $post->ID; ?>&amp;type=image&amp;TB_iframe=true');
			return false;
		});

		window.original_send_to_editor = window.send_to_editor;

		// send the uploaded image url to the field
		window.send_to_editor = function(html) {
			if ( formfield ) {
				var s = jQuery('img',html).attr('class'); // get the class with the image id
				var imageID = parseInt(/wp-image-(\d+)/.exec(s)[1], 10); // now grab the image id from the wp-image class
				var imgurl = jQuery('img',html).attr('src'); // get the image url
				var imgoutput = '<a href="' + imgurl + '" target="_blank"><img src="' + imgurl + '" /></a>'; //get the html to output for the image preview

				jQuery('#clpr_print_url').val(imgurl); // return the image url to the field
				jQuery('input[name=clpr_print_imageid]').val(imageID); // return the image url to the field
				jQuery('#clpr_print_url').siblings('.upload_image_preview').slideDown().html(imgoutput); // display the uploaded image thumbnail
				tb_remove();
				formfield = null;
			} else {
				window.original_send_to_editor(html);
			}
		}

		// show the coupon code or upload coupon field based on type select box
		jQuery('select#coupon_meta_dropdown').change(function() {
			if (jQuery(this).val() == 'coupon-code') {
				jQuery('tr#ctype-' + jQuery(this).val()).fadeIn('fast');
				jQuery('tr#ctype-coupon-code input').addClass('required');
				jQuery('tr#ctype-printable-coupon input').removeClass('required invalid');
				jQuery('tr#ctype-printable-coupon').hide();
			} else if (jQuery(this).val() == 'printable-coupon') {
				jQuery('tr#ctype-' + jQuery(this).val()).fadeIn('fast');
				jQuery('tr#ctype-printable-coupon input').addClass('required');
				jQuery('tr#ctype-coupon-code input').removeClass('required invalid');
				jQuery('tr#ctype-coupon-code').hide();
			} else {
				jQuery('tr.ctype').hide();
				jQuery('tr.ctype input').removeClass('required invalid');
			}
		}).change();

	});
	//]]>
	</script>


	<table class="form-table coupon-meta-table">

			<tr>
				<th style="width:20%"><label for="cp_sys_ad_conf_id"><?php _e( 'Coupon Info:', APP_TD ); ?></label></th>
				<td class="coupon-conf-id">
					<div id="coupon-id"><div id="keyico"></div><?php _e( 'Coupon ID: ', APP_TD ); ?><span>&nbsp;<?php echo esc_html( get_post_meta( $post->ID, 'clpr_id', true ) ); ?>&nbsp;</span></div>
					<div id="coupon-stats"><div id="statsico"></div><?php _e( 'Views Today: ', APP_TD ); ?><strong><?php echo esc_html( get_post_meta( $post->ID, 'clpr_daily_count', true ) ); ?></strong> | 
						<?php _e( 'Views Total: ', APP_TD ); ?><strong><?php echo esc_html( $pvs = get_post_meta( $post->ID, 'clpr_total_count', true ) ); ?></strong>
					</div>

					<div id="coupon-stats"><div id="clicksico"></div>
						<?php _e( 'Clicks: ', APP_TD ); ?><strong><?php echo esc_html( $cts = get_post_meta( $post->ID, 'clpr_coupon_aff_clicks', true ) ); ?></strong> |
						<?php _e( 'CTR: ', APP_TD ); ?><strong><?php $ctr = ( $pvs > 0 ? ( $cts / $pvs * 100 ) : 0 ); echo number_format_i18n( $ctr, 2 ); ?>%</strong>
					</div>
				</td>
			</tr>

			<tr>
				<th style="width:20%"><label><?php _e( 'Coupon Votes:', APP_TD ); ?></label></th>
				<td><?php clpr_votes_chart(); ?></td>
			</tr>

			<tr>
				<th style="width:20%"><label><?php _e( 'Submitted By:', APP_TD ); ?></label></th>
				<td style="line-height:3.4em;">
					<?php
						$author_id = empty( $post->post_author ) ? get_current_user_id() : $post->post_author;
						// show the gravatar for the author
						echo get_avatar( $post->post_author, '48', '' );

						// show the author drop-down box 
						wp_dropdown_users( array(
							'who' => 'authors',
							'name' => 'post_author_override',
							'selected' => $author_id,
							'include_selected' => true,
						) );

						// display the author display name 
						$author = get_userdata( $author_id );
						echo '<br /><a href="user-edit.php?user_id=' . $author->ID . '">' . $author->display_name . '</a>';
					?>
				</td>
			</tr>

			<tr>
				<th colspan="2" style="padding:0px;">&nbsp;</th>
			</tr>

			<tr>
				<th style="width:20%"><label><?php _e( 'Coupon Type:', APP_TD ); ?></label></th>
				<td><input type="hidden" name="coupon_type" value="0" />
				<?php
				// Get all taxonomy terms
				$terms = get_terms( APP_TAX_TYPE, array( 'hide_empty' => 0 ) );
				$object_terms = wp_get_object_terms( $post->ID, APP_TAX_TYPE );
				?>

				<select name="coupon_type" id="coupon_meta_dropdown">
				<?php
				foreach ( $terms as $term ) {
					if ( ! is_wp_error( $object_terms ) && ! empty( $object_terms ) && ! strcmp( $term->slug, $object_terms[0]->slug ) )
						echo "<option value='" . $term->slug . "' selected>" . $term->name . "</option>\n";
					else
						echo "<option value='" . $term->slug . "'>" . $term->name . "</option>\n";
				}
				?>
				</select></td>
			</tr>

			<tr id="ctype-coupon-code" class="ctype">
				<th style="width:20%"><label><?php _e( 'Coupon Code:', APP_TD ); ?></label></th>
				<td><input type="text" name="clpr_coupon_code" class="text" value="<?php echo get_post_meta( $post->ID, 'clpr_coupon_code', true ); ?>" /></td>
			</tr>

			<tr id="ctype-printable-coupon" class="ctype">
				<th style="width:20%"><label><?php _e( 'Printable Coupon URL:', APP_TD ); ?></label></th>
				<td>
					<input type="text" readonly name="clpr_print_url" id="clpr_print_url" class="upload_image_url text" value="<?php clpr_get_coupon_image( 'thumb-med', 'url' ) ; ?>" />
					<input id="upload_image_button" class="upload_button button" rel="clpr_print_url" type="button" value="<?php _e( 'Add Image', APP_TD ); ?>" />
					<p class="small"><?php _e( 'Click the "Add Image" button to upload or add from the "Media Library". Then click the "Insert into Post" button.', APP_TD ); ?></p>
					<div class="upload_image_preview"><?php clpr_get_coupon_image('thumb-large'); ?></div>
					<input type="text" class="hide" id="imageid" name="clpr_print_imageid" value="" />
				</td>
			</tr>

			<tr>
				<th style="width:20%"><label><?php _e( 'Destination URL:', APP_TD ); ?></label></th>
				<td><input type="text" name="clpr_coupon_aff_url" class="text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'clpr_coupon_aff_url', true ) ); ?>" /></td>
			</tr>

			<tr>
				<th style="width:20%"><label><?php _e( 'Display URL:', APP_TD ); ?></label></th>
				<td><input type="text" readonly class="text" value="<?php echo esc_html( home_url( "coupon/$post->post_name/$post->ID" ) ); ?>" /></td>
			</tr>

			<tr>
				<th style="width:20%"><label><?php _e( 'Expiration Date:', APP_TD ); ?></label></th>
				<td><input type="text" name="clpr_expire_date" class="datepicker" value="<?php echo get_post_meta( $post->ID, 'clpr_expire_date', true ); ?>" /></td>
			</tr>

			<tr>
				<th style="width:20%"><label for="clpr_featured"><?php _e( 'Featured Coupon:', APP_TD ); ?></label></th>
				<td><input type="hidden" name="clpr_featured" value="0" />
			<span class="checkbox-wrap"><input type="checkbox" name="clpr_featured" value="1" <?php if ( get_post_meta( $post->ID, 'clpr_featured', true ) ) { echo "checked"; }?> class="checkbox" /></span>
			<p><?php _e( 'Show this coupon in the home page slider', APP_TD ); ?></p></td>
			</tr>

			<tr>
				<th style="width:20%"><label><?php _e( 'Submitted from IP:', APP_TD ); ?></label></th>
				<td><?php echo esc_html( get_post_meta( $post->ID, 'clpr_sys_userIP', true ) ); ?></td>
			</tr>

		</table>

<?php
}


/**
 * Saves all meta values on the coupon.
 *
 * @param int $post_id
 *
 * @return void
 */
function clpr_save_meta_box( $post_id ) {
	global $post;

	// make sure something has been submitted from our nonce
	if ( ! isset( $_POST['coupon_meta_wpnonce'] ) )
		return $post_id;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( ! wp_verify_nonce( $_POST['coupon_meta_wpnonce'], 'coupon_meta' ) )
		return $post_id;

	// verify if this is an auto save routine.
	// if it is our form and it has not been submitted, dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	// lastly check to make sure this user has permissions to save post fields
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return $post_id;


	// enter each field name here so we can update on save (except for taxonomies)
	$metafields = array(
		'clpr_coupon_code' => $_POST['clpr_coupon_code'],
		'clpr_print_url' => $_POST['clpr_print_url'],
		'clpr_expire_date' => $_POST['clpr_expire_date'],
		'clpr_featured' => $_POST['clpr_featured'],
		'clpr_print_imageid' => $_POST['clpr_print_imageid'],
		'clpr_coupon_aff_url' => $_POST['clpr_coupon_aff_url'],
	);


	// if printable coupon then clear coupon code
	if ( $_POST['coupon_type'] == 'printable-coupon' )
		$metafields['clpr_coupon_code'] = '';

	// loop through all custom meta fields and update values
	foreach ( $metafields as $name => $value ) {
		update_post_meta( $post_id, $name, $value );
	}

	// now update the coupon type drop-downs
	wp_set_object_terms( $post_id, $_POST['coupon_type'], APP_TAX_TYPE );

	// there's a new printable coupon image so let's delete the old and associate the new
	if ( $attach_id = $_POST['clpr_print_imageid'] ) {

		// get all the print coupons associated with the coupon. there should only be one
		$images = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', APP_TAX_IMAGE => 'printable-coupon' ) );

		// now removes object term in any existing attachments for this coupon
		if ( $images ) {
			foreach ( $images as $attachment_id => $attachment ) {
				wp_set_object_terms( $attachment_id, NULL, APP_TAX_IMAGE, false );
			}
		}

		// associate it to the coupon. set the image post_parent column to the coupon post id
		wp_update_post( array( 'ID' => $attach_id, 'post_parent' => $post_id ) );
		wp_set_object_terms( $attach_id, 'printable-coupon', APP_TAX_IMAGE, false );

	}


	// give the coupon a unique ID if it's a new coupon
	if ( ! get_post_meta( $post->ID, 'clpr_id', true ) ) {
		$clpr_item_id = clpr_generate_id();
		add_post_meta( $post_id, 'clpr_id', $clpr_item_id, true );
	}

	// set the IP address if it's a new coupon
	if ( ! get_post_meta( $post->ID, 'clpr_sys_userIP', true ) ) {
		add_post_meta( $post_id, 'clpr_sys_userIP', appthemes_get_ip(), true );
	}

	// set stats to zero so we at least have some data
	if ( ! get_post_meta( $post->ID, 'clpr_daily_count', true ) ) {
		add_post_meta( $post_id, 'clpr_daily_count', '0', true );
	}

	if ( ! get_post_meta( $post->ID, 'clpr_total_count', true ) ) {
		add_post_meta( $post_id, 'clpr_total_count', '0', true );
	}

	if ( ! get_post_meta( $post->ID, 'clpr_coupon_aff_clicks', true ) ) {
		add_post_meta( $post_id, 'clpr_coupon_aff_clicks', '0', true );
	}

	if ( ! get_post_meta( $post->ID, 'clpr_votes_percent', true ) ) {
		add_post_meta( $post_id, 'clpr_votes_percent', '100', true );
	}

	if ( ! get_post_meta( $post->ID, 'clpr_votes_down', true ) ) {
		add_post_meta( $post_id, 'clpr_votes_down', '0', true );
	}

	if ( ! get_post_meta( $post->ID, 'clpr_votes_up', true ) ) {
		add_post_meta( $post_id, 'clpr_votes_up', '0', true );
	}

}
add_action( 'save_post', 'clpr_save_meta_box' );


/**
 * Displays the custom url meta field for the stores taxonomy
 *
 * @param object $tag
 * @param string $taxonomy
 *
 * @return void
 */
function clpr_edit_stores( $tag, $taxonomy ) {
	$the_store_url = clpr_get_store_meta( $tag->term_id, 'clpr_store_url', true );
	$the_store_aff_url = clpr_get_store_meta( $tag->term_id, 'clpr_store_aff_url', true );
	$the_store_active = clpr_get_store_meta( $tag->term_id, 'clpr_store_active', true );
	$store_featured = clpr_get_store_meta( $tag->term_id, 'clpr_store_featured', true );
	$the_store_aff_url_clicks = clpr_get_store_meta( $tag->term_id, 'clpr_aff_url_clicks', true );
	// $clpr_store_image_url = clpr_get_store_meta( $tag->term_id, 'clpr_store_image_url', true );
	$clpr_store_image_id = clpr_get_store_meta( $tag->term_id, 'clpr_store_image_id', true );
	$clpr_store_image_preview = clpr_get_store_image_url( $tag->term_id, 'term_id', 75 );
?>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_store_url"><?php _e( 'Store URL', APP_TD ); ?></label></th>
		<td>
			<input type="text" name="clpr_store_url" id="clpr_store_url" value="<?php echo $the_store_url; ?>"/><br />
			<p class="description"><?php _e( 'The URL for the store (i.e. http://www.website.com)', APP_TD ); ?></p>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_store_aff_url"><?php _e( 'Destination URL', APP_TD ); ?></label></th>
		<td>
			<input type="text" name="clpr_store_aff_url" id="clpr_store_aff_url" value="<?php echo $the_store_aff_url; ?>"/><br />
			<p class="description"><?php _e( 'The affiliate URL for the store (i.e. http://www.website.com/?affid=12345)', APP_TD ); ?></p>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_store_aff_url_cloaked"><?php _e( 'Display URL', APP_TD ); ?></label></th>
		<td><?php echo clpr_get_store_out_url( $tag ); ?></td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_aff_url_clicks"><?php _e( 'Clicks', APP_TD ); ?></label></th>
		<td><?php echo esc_attr( $the_store_aff_url_clicks ); ?></td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_store_active"><?php _e( 'Store Active', APP_TD ); ?></label></th>
		<td>
			<select class="postform" id="clpr_store_active" name="clpr_store_active" style="min-width:125px;">
				<option value="yes" <?php selected( $the_store_active, 'yes' ); ?>><?php _e( 'Yes', APP_TD ); ?></option>
				<option value="no" <?php selected( $the_store_active, 'no' ); ?>><?php _e( 'No', APP_TD ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_store_featured"><?php _e( 'Store Featured', APP_TD ); ?></label></th>
		<td>
			<input type="checkbox" value="1" name="clpr_store_featured" <?php checked( $store_featured ); ?>> <span class="description"><?php _e( 'Yes', APP_TD ); ?></span>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_store_url"><?php _e( 'Store Screenshot', APP_TD ); ?></label></th>
		<td>
			<span class="thumb-wrap">
				<a href="<?php echo $the_store_url; ?>" target="_blank"><img class="store-thumb" src="<?php echo clpr_get_store_image_url( $tag->term_id, 'term_id', 250 ); ?>" alt="" /></a>
			</span>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="clpr_store_image_id"><?php _e( 'Store Image', APP_TD ); ?></label></th>
		<td>
			<div id="stores_image" style="float:left; margin-right:15px;"><img src="<?php echo $clpr_store_image_preview; ?>" /></div>
			<div style="line-height:75px;">
				<input type="hidden" name="clpr_store_image_id" id="clpr_store_image_id" value="<?php echo $clpr_store_image_id; ?>" />
				<button type="submit" class="button" id="button_add_image" rel="clpr_store_image_url"><?php _e( 'Add Image', APP_TD ); ?></button>
				<button type="submit" class="button" id="button_remove_image"><?php _e( 'Remove Image', APP_TD ); ?></button>
			</div>
			<div class="clear"></div>
			<p class="description"><?php _e( 'Choose custom image for the store.', APP_TD ); ?></p>
			<p class="description"><?php _e( 'Leave blank if you want use image generated by store URL.', APP_TD ); ?></p>
		</td>
	</tr>
	<script type="text/javascript">
	//<![CDATA[	
	jQuery(document).ready(function() {

		var formfield;

		if ( ! jQuery('#clpr_store_image_id').val() ) {
			jQuery('#button_remove_image').hide();
		} else {
			jQuery('#button_add_image').hide();
		}

		jQuery( document ).on('click', '#button_add_image', function() {
			formfield = jQuery(this).attr('rel');
			tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;taxonomy=<?php echo APP_TAX_STORE; ?>&amp;TB_iframe=true');
			return false;
		});

		jQuery( document ).on('click', '#button_remove_image', function() {
			jQuery('#stores_image img').attr('src', '<?php echo appthemes_locate_template_uri('images/clpr_default.jpg'); ?>');
			jQuery('#clpr_store_image_id').val('');
			jQuery('#button_remove_image').hide();
			jQuery('#button_add_image').show();
			return false;
		});

		window.original_send_to_editor = window.send_to_editor;

		window.send_to_editor = function(html) {
			if ( formfield ) {
				var imageClass = jQuery('img', html).attr('class');
				var imageID = parseInt(/wp-image-(\d+)/.exec(imageClass)[1], 10);
				var imageURL = jQuery('img', html).attr('src');

				jQuery('input[name=clpr_store_image_id]').val(imageID);
				jQuery('#stores_image img').attr('src', imageURL);
				jQuery('#button_remove_image').show();
				jQuery('#button_add_image').hide();
				tb_remove();
				formfield = null;
			} else {
				window.original_send_to_editor(html);
			}
		}

	});
	//]]>
	</script>

<?php
}
add_action( APP_TAX_STORE . '_edit_form_fields', 'clpr_edit_stores', 10, 2 );


/**
 * Saves the store url custom meta field
 *
 * @param int $term_id
 * @param int $tt_id
 *
 * @return void
 */
function clpr_save_stores( $term_id, $tt_id ) {
	if ( ! $term_id )
		return;

	if ( isset( $_POST['clpr_store_image_id'] ) && is_numeric( $_POST['clpr_store_image_id'] ) )
		clpr_update_store_meta( $term_id, 'clpr_store_image_id', $_POST['clpr_store_image_id'] );

	if ( isset( $_POST['clpr_store_url'] ) )
		clpr_update_store_meta( $term_id, 'clpr_store_url', $_POST['clpr_store_url'] );

	if ( isset( $_POST['clpr_store_aff_url'] ) )
		clpr_update_store_meta( $term_id, 'clpr_store_aff_url', $_POST['clpr_store_aff_url'] );

	if ( isset( $_POST['clpr_store_active'] ) )
		clpr_update_store_meta( $term_id, 'clpr_store_active', $_POST['clpr_store_active'] );

	if ( isset( $_POST['clpr_store_featured'] ) )
		clpr_update_store_meta( $term_id, 'clpr_store_featured', $_POST['clpr_store_featured'] );
	else
		clpr_delete_store_meta( $term_id, 'clpr_store_featured' );

	delete_transient( 'clpr_hidden_stores_ids' );
	delete_transient( 'clpr_featured_stores_ids' );
}
add_action( 'edited_' . APP_TAX_STORE, 'clpr_save_stores', 10, 2 );


/**
 * Sets the stores taxonomy headers
 *
 * @param array $columns
 *
 * @return array
 */
function clpr_stores_column_headers( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'clpr_store_image' => __( 'Image', APP_TD ),
		'name' => __( 'Name', APP_TD ),
		'short_description' => __( 'Description', APP_TD ),
		'clpr_store_url' => __( 'Store URL', APP_TD ),
		'clpr_store_aff_url' => __( 'Destination URL', APP_TD ),
		'slug' => __( 'Slug', APP_TD ),
		'clpr_store_featured' => __( 'Featured', APP_TD ),
		'clpr_store_active' => __( 'Active', APP_TD ),
		'posts' => __( 'Coupons', APP_TD ),
		//'clpr_store_clicks' => __( 'Clicks', APP_TD )
	);	

	return $columns;	
}
add_filter( 'manage_edit-' . APP_TAX_STORE . '_columns', 'clpr_stores_column_headers', 10, 1 );


/**
 * Returns content for the custom store columns
 *
 * @param string $row_content
 * @param string $column_name
 * @param int $term_id
 *
 * @return string
 */
function clpr_stores_column_row( $row_content, $column_name, $term_id ) {
	global $taxonomy;

	switch( $column_name ) {

		case 'clpr_store_image':
			return '<img class="store-thumb" src="' . clpr_get_store_image_url( $term_id, 'term_id', 75 ) . '" />';
			break;

		case 'short_description':
			$string = strip_tags( term_description( $term_id, $taxonomy ) );
			if ( strlen( $string ) > 250 )
				$string = mb_substr( $string, 0, 250 ) . '...';
			return $string;
			break;

		case 'clpr_store_url':
			return clpr_get_store_meta( $term_id, 'clpr_store_url', true );
			break;

		case 'clpr_store_aff_url':
			return clpr_get_store_meta( $term_id, 'clpr_store_aff_url', true );
			break;

		case 'clpr_store_active':
			$store_active = clpr_get_store_meta( $term_id, 'clpr_store_active', true );
			if ( $store_active == 'no' )
				return '<span class="active-no">' . __( 'No', APP_TD ) . '</span>';
			else
				return '<span class="active-yes">' . __( 'Yes', APP_TD ) . '</span>';
			break;

		case 'clpr_store_featured':
			$store_featured = clpr_get_store_meta( $term_id, 'clpr_store_featured', true );
			if ( ! $store_featured )
				return '<span class="active-no">' . __( 'No', APP_TD ) . '</span>';
			else
				return '<span class="active-yes">' . __( 'Yes', APP_TD ) . '</span>';
			break;

		case 'clpr_store_clicks':
			$clicks = clpr_get_store_meta( $term_id, 'clpr_aff_url_clicks', true );
			$clicks = $clicks ? $clicks : 0;
			return $clicks;
			break;

		default:
			break;

	}

}
add_filter( 'manage_' . APP_TAX_STORE . '_custom_column', 'clpr_stores_column_row', 10, 3 );


/**
 * Registers the short_description column as sortable
 *
 * @param array $columns
 *
 * @return array
 */
function clpr_column_stores_sortable( $columns ) {
	$columns['short_description'] = 'description';
	return $columns;
}
add_filter( 'manage_edit-' . APP_TAX_STORE . '_sortable_columns', 'clpr_column_stores_sortable' );


/**
 * Saves the store url on the edit-tags.php create page
 *
 * @param int $term_id
 * @param int $tt_id
 *
 * @return void
 */
function create_stores( $term_id, $tt_id ) {
	if ( ! $term_id )
		return;

	if ( isset( $_POST['clpr_store_image_id'] ) && is_numeric( $_POST['clpr_store_image_id'] ) )
		clpr_update_store_meta( $term_id, 'clpr_store_image_id', $_POST['clpr_store_image_id'] );

	if ( isset( $_POST['clpr_store_url'] ) )
		clpr_update_store_meta( $term_id, 'clpr_store_url', $_POST['clpr_store_url'] );

}
add_action( 'created_' . APP_TAX_STORE, 'create_stores', 10, 3 );


/**
 * Sets columns for coupon listing on edit.php page
 *
 * @param array $columns
 *
 * @return array
 */
function clpr_edit_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Coupon Title', APP_TD ),
		'author' => __( 'Submitted By', APP_TD ),
		APP_TAX_STORE => __( 'Store Name', APP_TD ),
		APP_TAX_CAT => __( 'Categories', APP_TD ),
		APP_TAX_TYPE => __( 'Coupon Type', APP_TD ),
		'coupon_code' => __( 'Coupon', APP_TD ),
		'comments' => '<div class="vers"><img alt="" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>',
		'date' => __( 'Date', APP_TD ),
		'expire_date' => __( 'Expiration Date', APP_TD ),
		'votes' => __( 'Votes', APP_TD ),
		'clicks' => __( 'Clicks / Views', APP_TD ),
		'ctr' => __( 'CTR', APP_TD )
	);

	return $columns;
}
add_filter( 'manage_edit-' . APP_POST_TYPE . '_columns', 'clpr_edit_columns' );


/**
 * Registers custom columns as sortable
 *
 * @param array $columns
 *
 * @return array
 */
function clpr_column_sortable( $columns ) {
	$columns['coupon_code'] = 'coupon_code';
	$columns['expire_date'] = 'expire_date';
	return $columns;
}
add_filter( 'manage_edit-' . APP_POST_TYPE . '_sortable_columns', 'clpr_column_sortable' );


/**
 * Sets how the columns sorting should work
 *
 * @param array $vars
 *
 * @return array
 */
function clpr_column_orderby( $vars ) {

	if ( isset( $vars['orderby'] ) ) {
		switch ( $vars['orderby'] ) {
			case 'coupon_code' :
				$vars = array_merge( $vars, array( 'meta_key' => 'clpr_coupon_code', 'orderby' => 'meta_value' ) );
				break;
			case 'expire_date' :
				$vars = array_merge( $vars, array( 'meta_key' => 'clpr_expire_date', 'orderby' => 'meta_value' ) );
				break;
		}
	}

	return $vars;
}
add_filter( 'request', 'clpr_column_orderby' );


/**
 * Displays the values for each coupon column on edit.php page
 *
 * @param string $column
 *
 * @return void
 */
function clpr_custom_columns( $column ) {
	global $post;

	$coupon_type = appthemes_get_custom_taxonomy($post->ID, APP_TAX_TYPE, 'slug_name');
	switch ( $column ) {
		// Store and type for WP to store
		case APP_TAX_STORE :
			echo get_the_term_list($post->ID, APP_TAX_STORE, '', ', ', '');
			break;

		case APP_TAX_CAT :
			echo get_the_term_list($post->ID, APP_TAX_CAT, '', ', ', '');
			break;

		case APP_TAX_TYPE :
			echo get_the_term_list($post->ID, APP_TAX_TYPE, '', ', ', '');
			break;

		//describe the other fields for WP to store
		case 'coupon_code':
			if ( $coupon_type == 'coupon-code' )
				echo esc_html( get_post_meta($post->ID, 'clpr_coupon_code', true) );
			elseif ( $coupon_type == 'printable-coupon' )
				clpr_get_coupon_image( 'thumb-med' );
			else
				_e( 'No code', APP_TD );
			break;

		case 'expire_date':
			echo clpr_get_expire_date( $post->ID, 'display' );
			break;

		case 'votes':
			clpr_votes_chart();
			break;

		case 'clicks':
			$clicks = (int) get_post_meta($post->ID, 'clpr_coupon_aff_clicks', true);
			$views = (int) get_post_meta($post->ID, 'clpr_total_count', true);
			echo number_format_i18n($clicks) . ' / <strong>' . number_format_i18n($views). '</strong>';
			break;

		case 'ctr':
			$clicks = (int) get_post_meta($post->ID, 'clpr_coupon_aff_clicks', true);
			$views = (int) get_post_meta($post->ID, 'clpr_total_count', true);
			$ctr = ($views > 0 ? ($clicks/$views*100) : 0);
			echo number_format_i18n($ctr, 2).'%';
			break;
	}
}
add_action( 'manage_posts_custom_column', 'clpr_custom_columns' );


/**
 * Adds extra columns to the users overview.
 *
 * @param array $columns
 *
 * @return array
 */
function clpr_manage_users_columns( $columns ) {
	$columns['coupons'] = __( 'Coupons', APP_TD );

	return $columns;
}
add_filter( 'manage_users_columns', 'clpr_manage_users_columns' );


/**
 * Returns extra columns content to the users overview.
 *
 * @param string $r
 * @param string $column_name
 * @param int $user_id
 *
 * @return string
 */
function clpr_manage_users_custom_column( $r, $column_name, $user_id ) {
	global $wp_list_table, $coupons_counts;

	if ( $column_name == 'coupons' ) {
		if ( ! isset( $coupons_counts ) )
			$coupons_counts = count_many_users_posts( array_keys( $wp_list_table->items ), APP_POST_TYPE );

		if ( ! isset( $coupons_counts[ $user_id ] ) )
			$coupons_counts[ $user_id ] = 0;

		if ( $coupons_counts[ $user_id ] > 0 ) {
			$url = add_query_arg( array( 'post_type' => APP_POST_TYPE, 'author' => $user_id ), admin_url( 'edit.php' ) );
			$r .= html( 'a', array( 'href' => $url, 'class' => 'edit', 'title' => esc_attr__( 'View coupons by this author', APP_TD ) ), $coupons_counts[ $user_id ] );
		} else {
			$r .= 0;
		}
	}

	return $r;
}
add_filter( 'manage_users_custom_column', 'clpr_manage_users_custom_column', 10, 3 );


/**
 * Displays extra fields in the create store admin page.
 *
 * @param object $tag
 *
 * @return void
 */
function add_store_extra_fields( $tag ) {
?>

	<div class="form-field">
		<label for="clpr_store_url"><?php _e( 'Store URL', APP_TD ); ?></label>
		<input type="text" name="clpr_store_url" id="clpr_store_url" value="" />
		<p class="description"><?php _e( 'The URL for the store (i.e. http://www.website.com)', APP_TD ); ?></p>
	</div>

	<div class="form-field">
		<label for="clpr_store_image_id"><?php _e( 'Store Image', APP_TD ); ?></label>
		<div id="stores_image" style="float:left; margin-right:15px;"><img src="<?php echo appthemes_locate_template_uri('images/clpr_default.jpg'); ?>" width="75px" height="75px" /></div>
		<div style="line-height:75px;">
			<input type="hidden" name="clpr_store_image_id" id="clpr_store_image_id" value="" />
			<button type="submit" class="button" id="button_add_image" rel="clpr_store_image_url"><?php _e( 'Add Image', APP_TD ); ?></button>
			<button type="submit" class="button" id="button_remove_image"><?php _e( 'Remove Image', APP_TD ); ?></button>
		</div>
		<div class="clear"></div>
		<p class="description"><?php _e( 'Choose custom image for the store.', APP_TD ); ?></p>
		<p class="description"><?php _e( 'Leave blank if you want use image generated by store URL.', APP_TD ); ?></p>
	</div>
	<script type="text/javascript">
	//<![CDATA[	
	jQuery(document).ready(function() {

		var formfield;

		if ( ! jQuery('#clpr_store_image_id').val() ) {
			jQuery('#button_remove_image').hide();
		} else {
			jQuery('#button_add_image').hide();
		}

		jQuery( document ).on('click', '#button_add_image', function() {
			formfield = jQuery(this).attr('rel');
			tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;taxonomy=<?php echo APP_TAX_STORE; ?>&amp;TB_iframe=true');
			return false;
		});

		jQuery( document ).on('click', '#button_remove_image', function() {
			jQuery('#stores_image img').attr('src', '<?php echo appthemes_locate_template_uri('images/clpr_default.jpg'); ?>');
			jQuery('#clpr_store_image_id').val('');
			jQuery('#button_remove_image').hide();
			jQuery('#button_add_image').show();
			return false;
		});

		window.original_send_to_editor = window.send_to_editor;

		window.send_to_editor = function(html) {
			if ( formfield ) {
				var imageClass = jQuery('img', html).attr('class');
				var imageID = parseInt(/wp-image-(\d+)/.exec(imageClass)[1], 10);
				var imageURL = jQuery('img', html).attr('src');

				jQuery('input[name=clpr_store_image_id]').val(imageID);
				jQuery('#stores_image img').attr('src', imageURL);
				jQuery('#button_remove_image').show();
				jQuery('#button_add_image').hide();
				tb_remove();
				formfield = null;
			} else {
				window.original_send_to_editor(html);
			}
		}

	});
	//]]>
	</script>

<?php
}
add_action( APP_TAX_STORE . '_add_form_fields', 'add_store_extra_fields', 10, 2 );


/**
 * Removes 'From URL' tab in media uploader, need local image for stores.
 *
 * @param array $tabs
 *
 * @return array
 */
function clpr_stores_media_remove_from_url_tab( $tabs ) {

	if ( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == APP_TAX_STORE )
		unset( $tabs['type_url'] );

	return $tabs;
}
add_filter( 'media_upload_tabs', 'clpr_stores_media_remove_from_url_tab' );


/**
 * Removes media library tab to escape assignment second time the same printable coupon.
 *
 * @param array $tabs
 *
 * @return array
 */
function clpr_remove_media_library_tab( $tabs ) {
	if ( isset( $_REQUEST['post_id'] ) ) {
		$post_type = get_post_type( $_REQUEST['post_id'] );
		if ( APP_POST_TYPE == $post_type )
			unset( $tabs['library'] );
	}

	return $tabs;
}
add_filter( 'media_upload_tabs', 'clpr_remove_media_library_tab' );


/**
 * Displays fields in quick edit store mode.
 *
 * @param string $column_name
 * @param object $screen
 * @param string $name
 *
 * @return void
 */
function clpr_quick_edit_values( $column_name, $screen, $name = null ) {

	if ( $name != APP_TAX_STORE ) 
		return;

	if ( $column_name == 'clpr_store_url' ) {
?>
	<fieldset>
		<div class="inline-edit-col">
		
			<label>
				<span class="title"><?php _e( 'Store URL', APP_TD ); ?></span>
				<span class="input-text-wrap"><input type="text" name="clpr_store_url" class="ptitle" value="" /></span>
			</label>
		
		</div>
	</fieldset>
<?php
	}
	if ( $column_name == 'clpr_store_aff_url' ) {
?>
	<fieldset>
		<div class="inline-edit-col">
		
			<label>
				<span class="title"><?php _e( 'Destination URL', APP_TD ); ?></span>
				<span class="input-text-wrap"><input type="text" name="clpr_store_aff_url" class="ptitle" value="" /></span>
			</label>
		
		</div>
	</fieldset>
<?php
	}
	if ( $column_name == 'clpr_store_active' ) {
?>
	<fieldset>
		<div class="inline-edit-col">
		
			<label>
				<span class="title"><?php _e( 'Active', APP_TD ); ?></span>
				<span class="input-text-wrap">
					<select class="postform" id="clpr_store_active" name="clpr_store_active" style="min-width:125px;">
						<option value="yes"><?php _e( 'Yes', APP_TD ); ?></option>
						<option value="no"><?php _e( 'No', APP_TD ); ?></option>
					</select>
				</span>
			</label>
			
		</div>
	</fieldset>
<?php
	}
	if ( $column_name == 'clpr_store_featured' ) {
?>
	<fieldset>
		<div class="inline-edit-col">
		
			<label>
				<span class="title"><?php _e( 'Featured', APP_TD ); ?></span>
				<span class="input-text-wrap">
					<input type="checkbox" value="1" name="clpr_store_featured" > <?php _e( 'Yes', APP_TD ); ?>
				</span>
			</label>
			
		</div>
	</fieldset>
<?php
	}

}
add_action( 'quick_edit_custom_box', 'clpr_quick_edit_values', 10, 3 );


class CLPR_Listing_Publish_Moderation extends APP_Meta_Box {

	public function __construct() {

		if ( ! isset( $_GET['post'] ) || get_post_status( $_GET['post'] ) != 'pending' )
			return;

		parent::__construct( 'listing-publish-moderation', __( 'Moderation Queue', APP_TD ), APP_POST_TYPE, 'side', 'high' );
	}

	function display( $post ) {

		echo html( 'p', array(), __( 'You must approve this coupon before it can be published.', APP_TD ) );

		echo html( 'input', array(
			'type' => 'submit',
			'class' => 'button-primary',
			'value' => __( 'Accept', APP_TD ),
			'name' => 'publish',
			'style' => 'padding-left: 30px; padding-right: 30px; margin-right: 20px; margin-left: 15px;',
		) );

		echo html( 'a', array(
			'class' => 'button',
			'style' => 'padding-left: 30px; padding-right: 30px;',
			'href' => get_delete_post_link( $post->ID ),
		), __( 'Reject', APP_TD ) );

		echo html( 'p', array(
			'class' => 'howto'
		), __( 'Rejecting a Coupon sends it to the trash.', APP_TD ) );

	}

}

