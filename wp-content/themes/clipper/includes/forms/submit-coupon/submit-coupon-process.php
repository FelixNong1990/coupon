<?php
/**
 * Submit Coupon Form Process
 * Function processes the submit coupon form
 * used in tpl-submit-coupon.php
 *
 * @version 2.0
 * @author AppThemes
 *
 */


// see if the form has been submitted
if ( isset($_POST['submitted']) ) {

	if ( ! $errors )
		$errors = new WP_Error();

	$renew_id = ( isset( $_GET['renew'] ) ) ? $_GET['renew'] : false;

	// put the field names we expect into an array so we can check later
	$fields = array(
		'post_title',
		'clpr_store_name',
		'clpr_new_store_name',
		'clpr_new_store_url',
		'cat',
		'coupon_type_select',
		'clpr_coupon_code',
		'clpr_coupon_aff_url',
		'clpr_expire_date',
		'post_content',
		'tags_input'
	);

	// match the field names with the posted values
	// this process is to prevent unexpected field values from being passed in
	foreach( $fields as $field ) {
		$posted[ $field ] = isset( $_POST[ $field ] ) ? appthemes_clean( $_POST[ $field ] ) : '';
	}

	// check to see if html is allowed
	if ( ! $clpr_options->allow_html )
		$posted['post_content'] = appthemes_filter( $posted['post_content'] );

	// do some simple server-side error checking
	if ( $posted['post_title'] == '' )
		$errors->add( 'empty_post_title', __( 'Please enter a coupon title.', APP_TD ) );

	if ( $posted['post_content'] == '' )
		$errors->add( 'empty_coupon_desc', __( 'Please enter a coupon description.', APP_TD ) );

	if ( ! clpr_is_valid_expiration_date( $posted['clpr_expire_date'] ) )
		$errors->add( 'invalid_expire_date', __( 'Invalid coupon expiration date.', APP_TD ) );


	// display the reCaptcha error msg if it's been enabled
	if ( current_theme_supports( 'app-recaptcha' ) ) {
		list( $options ) = get_theme_support( 'app-recaptcha' );

		require_once( $options['file'] );

		// check and make sure the reCaptcha values match
		$resp = recaptcha_check_answer( $options['private_key'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'] );

		if ( ! $resp->is_valid )
			$errors->add( 'invalid_recaptcha', __( 'The reCaptcha anti-spam response was incorrect.', APP_TD ) );
	}

	// process the coupon upload if one has been submitted and coupon type is printable
	if ( $posted['coupon_type_select'] == 'printable-coupon' ) {

		if ( isset($_FILES['coupon-upload']) && !empty($_FILES['coupon-upload']['name']) ) {
			include_once(ABSPATH . 'wp-admin/includes/file.php');
			include_once(ABSPATH . 'wp-admin/includes/image.php');

			$posted['coupon-upload-name'] = $_FILES['coupon-upload']['name'];

			// make sure the file uploaded is an approved type (i.e. jpg, png, gif, etc)
			$allowed = explode(',', $clpr_options->submit_file_types );
			$extension = strtolower(pathinfo($_FILES['coupon-upload']['name'], PATHINFO_EXTENSION));
			if ( !in_array($extension, $allowed) )
				$errors->add( 'incorrect_file_type', __( 'Invalid file type.', APP_TD ) );

			// start the upload process
			$file = wp_handle_upload( $_FILES['coupon-upload'], array( 'test_form' => false ) );

			// return any errors from the upload process
			if ( !isset($file['error']) ) {
				$posted['coupon-upload'] = $file['url'];
				$posted['coupon-upload-type'] = $file['type'];
				$posted['coupon-upload-file'] = $file['file'];
			} else {
				$errors->add( 'submit_file', __( 'Error: ', APP_TD ) . $file['error'] . '' );
			}
		}
	}

	$errors = apply_filters( 'clpr_coupon_validate_fields', $errors );

	if ( clpr_payments_is_enabled() )
		$errors = apply_filters( 'appthemes_validate_purchase_fields', $errors );

	// if there are errors, then show the messages with a go back link
	if ($errors && sizeof($errors)>0 && $errors->get_error_code()) {

		// there's an error so stop processing the new coupon submission
		// and display the errors below
		$complete = 1;

	} else {
		// no errors so process the new coupon

		// set the post status variable
		if ( ! $clpr_options->coupons_require_moderation && ! clpr_payments_is_enabled() )
			$status = 'publish';
		else
			$status = 'pending';

		// if submitted coupon isn't from a registered user, use the admin as the author
		if( empty($user_ID) )
			$user_ID = 1;

		// setup post array values
		$data = array(
			'post_title' => appthemes_filter( $posted['post_title'] ),
			'post_content' => $posted['post_content'],
			'post_status' => $status,
			'post_author' => $user_ID,
			'post_type' => APP_POST_TYPE
		);

		// create the new coupon
		if ( $renew_id ) {
			$data['ID'] = $renew_id;
			$data['post_date'] = current_time('mysql');
			$data['post_date_gmt'] = current_time('mysql', 1);
			$post_id = wp_update_post( $data );
		} else {
			$post_id = wp_insert_post( $data );
		}

		// was the post created?
		if ( $post_id == 0 || is_wp_error($post_id) )
			wp_die( __( 'Error: Unable to create entry.', APP_TD ) );

		// if renew coupon - delete all old post meta
		if ( $renew_id ) {
			$custom_field_keys = get_post_custom_keys( $renew_id );
			$preserve_meta = array( 'clpr_daily_count', 'clpr_total_count', 'clpr_coupon_aff_clicks', 'clpr_votes_up', 'clpr_votes_down', 'clpr_votes_percent' );
			foreach( $custom_field_keys as $custom_key ) {
				if ( ! in_array( $custom_key, $preserve_meta ) )
					delete_post_meta( $renew_id, $custom_key );
			}
		} else {
			// set stats to zero so we at least have some data
			add_post_meta($post_id, 'clpr_daily_count', '0', true);
			add_post_meta($post_id, 'clpr_total_count', '0', true);
			add_post_meta($post_id, 'clpr_coupon_aff_clicks', '0', true);
			add_post_meta($post_id, 'clpr_votes_up', '0', true);
			add_post_meta($post_id, 'clpr_votes_down', '0', true);
			add_post_meta($post_id, 'clpr_votes_percent', '100', true);
		}

		// add meta data to the new coupon
		add_post_meta($post_id, 'clpr_coupon_code', $posted['clpr_coupon_code'], true);
		add_post_meta($post_id, 'clpr_coupon_aff_url', $posted['clpr_coupon_aff_url'], true);
		add_post_meta($post_id, 'clpr_expire_date', $posted['clpr_expire_date'], true);
		add_post_meta($post_id, 'clpr_featured', '', true);
		add_post_meta($post_id, 'clpr_sys_userIP', appthemes_get_ip(), true);

		// set the coupon type
		wp_set_object_terms($post_id, $posted['coupon_type_select'], APP_TAX_TYPE, false);

		//add the tags
		if ( !empty($posted['tags_input']) ) {
			$new_tags = appthemes_clean_tags($posted['tags_input']);
			$new_tags = explode(',', $new_tags);
			wp_set_post_terms($post_id, $new_tags, APP_TAX_TAG, false);
		}

		// attach the coupon categories
		$post_into_cats = array();

		if ( $posted['cat'] > 0 )
			$post_into_cats[] = get_term_by('id', $posted['cat'], APP_TAX_CAT)->slug;

		if ( sizeof($post_into_cats) > 0 )
			wp_set_object_terms($post_id, $post_into_cats, APP_TAX_CAT);

		// create new or associate existing store to the coupon
		if ( $posted['clpr_store_name'] == 'add-new' ) {
			// insert the new store
			wp_set_object_terms($post_id, ucwords(strtolower($posted['clpr_new_store_name'])), APP_TAX_STORE);

			// grab the new store id so we can attach the new url field to it
			$term = get_term_by('name', $posted['clpr_new_store_name'], APP_TAX_STORE);
			//$clpr_new_store_url = apply_filters( 'pre_user_url', $posted['clpr_new_store_url'] );
			clpr_update_store_meta( $term->term_id, 'clpr_store_url', apply_filters( 'pre_user_url', $posted['clpr_new_store_url'] ) );

			// check if new stores require moderation before going live
			if ( $clpr_options->stores_require_moderation )
				clpr_update_store_meta( $term->term_id, 'clpr_store_active', 'no' );

		} else {
			wp_set_object_terms($post_id, (int)$posted['clpr_store_name'], APP_TAX_STORE);
		}

		// give the coupon a unique ID (todo: move to action hook)
		$clpr_item_id = clpr_generate_id();
		add_post_meta($post_id, 'clpr_id', $clpr_item_id, true);


		// if it's a printable coupon link the uploaded image to the new coupon
		if ( isset($_FILES['coupon-upload']) && !empty($_FILES['coupon-upload']['name']) ) {

			// Remove old assigned printable coupons
			clpr_remove_printable_coupon( $post_id );

			$name_parts = pathinfo($posted['coupon-upload-name']);
			$name = trim( $name_parts['filename']);

			$url = $posted['coupon-upload'];
			$type = $posted['coupon-upload-type'];
			$file = $posted['coupon-upload-file'];
			$title = $name;
			$content = '';

			// use image exif/iptc data for title and caption defaults if possible
			if ( $image_meta = @wp_read_image_metadata($file) ) {
				if ( trim($image_meta['title']) )
					$title = $image_meta['title'];
				if ( trim($image_meta['caption']) )
					$content = $image_meta['caption'];
			}

			// setup the attachment array
			$attachment = array_merge( array(
				'post_mime_type' => $type,
				'guid' => $url,
				'post_parent' => $post_id,
				'post_title' => $title,
				'post_content' => $content,
			), array() );

			// Save the data
			$id = wp_insert_attachment( $attachment, $file, $post_id );
			if ( ! is_wp_error( $id ) ) {
				wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
				wp_set_object_terms( $id, 'printable-coupon', APP_TAX_IMAGE, false );
			}
		}

		// send new notification email to admin
		if ( $clpr_options->new_ad_email )
			app_new_submission_email($post_id);

		// if not submitted by admin or unregistered user send coupon owner a summary email
		if ( $user_ID != 1 && $clpr_options->nc_custom_email ) {
			if ($status == 'pending')
				clpr_owner_new_coupon_email($post_id);
			else
			  clpr_owner_new_published_coupon_email($post_id);
		}

		if ( clpr_payments_is_enabled() ) {
			$price = $clpr_options->coupon_price;
			$order = appthemes_new_order();
			$order->add_item( CLPR_COUPON_LISTING_TYPE, $price, $post_id );
			do_action( 'appthemes_create_order', $order );
		}

	}
}

?>

<div class="blog">

<?php 
// houston we have errors
if ( isset($complete) && $complete == 1 ) {
?>

<h1><?php _e( 'Error(s) Found', APP_TD ); ?></h1>

	<div class="text-box">

		<div class="text-holder">

		<?php
			echo '<ul class="errors">';
			foreach ($errors->errors as $error) {
				echo '<li>'.$error[0].'</li>';
			}
			echo '</ul>';
		?>

		<p><?php printf( __( 'Please <a href="#" %s>go back</a> and fix the error(s).', APP_TD ), "onclick='history.go(-1);return false;'" ); ?></p>

		<div class="pad75"></div>

		</div>

	</div>

<?php
} elseif ( clpr_payments_is_enabled() ) {
?>

	<h1><?php _e( 'Payment', APP_TD ); ?></h1>

	<div class="text-box">

		<div class="text-holder">

			<p><?php _e( 'Please wait while we redirect you to our payment page.', APP_TD ); ?></p>
			<p><small><?php _e( '(Click the button below if you are not automatically redirected within 5 seconds.)', APP_TD ); ?></small></p>

			<?php clpr_js_redirect( $order->get_return_url(), __( 'Continue to Payment', APP_TD ) ); ?>

			<div class="pad75"></div>

		</div>

	</div>

<?php
} else {
?>

	<h1><?php _e( 'Thanks for Sharing!', APP_TD ); ?></h1>

	<div class="text-box">

		<div class="text-holder">

			<p><?php _e( 'Your coupon has successfully been submitted.', APP_TD ); ?></p>

			<div class="pad75"></div>

		</div>

	</div>

<?php } ?>

</div> <!-- #blog -->
