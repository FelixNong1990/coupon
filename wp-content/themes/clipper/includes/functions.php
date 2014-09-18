<?php
/**
 * Core theme functions
 * This file is the backbone and includes all the core functions
 * Modifying this will void your warranty and could cause
 * problems with your instance. Proceed at your own risk!
 *
 *
 *
 * @author AppThemes
 * @package Clipper
 *
 */


/**
 * Filter short code [template-url]
 */
function filter_template_url( $text ) {
	return str_replace( '[template-url]', get_template_directory_uri(), $text );
}
add_filter( 'the_content', 'filter_template_url' );
add_filter( 'get_the_content', 'filter_template_url' );
add_filter( 'widget_text', 'filter_template_url' );


/* Replace Standard WP Menu Classes for cleaner CSS classes*/
function change_menu_classes( $css_classes, $item ) {
	$css_classes = str_replace( "current-menu-item", "active", $css_classes );
	$css_classes = str_replace( "current-menu-parent", "active", $css_classes );
	$css_classes = str_replace( "current-menu-ancestor", "active", $css_classes );

	return $css_classes;
}
add_filter( 'nav_menu_css_class', 'change_menu_classes', 10, 2 );


// display the register link in the header if enabled
function clpr_register( $before = '<li>', $after = '</li>', $echo = true ) {

	if ( ! is_user_logged_in() ) {
		if ( get_option('users_can_register') )
			$link = $before . '<a href="' . appthemes_get_registration_url() . '">' . __( 'Register', APP_TD ) . '</a>' . $after;
		else
			$link = '';
	} else {
		$link = $before . '<a href="' . CLPR_DASHBOARD_URL . '">' . __( 'My Dashboard', APP_TD ) . '</a>' . $after;
	}

	if ( $echo )
		echo apply_filters('register', $link);
	else
		return apply_filters('register', $link);
}

// display the login message in the header
function clpr_login_head() {

	if ( is_user_logged_in() ) {
		echo html( 'li', html_link( CLPR_DASHBOARD_URL, __( 'My Dashboard', APP_TD ) ) );
		echo html( 'li', html_link( clpr_logout_url( home_url() ), __( 'Log out', APP_TD ) ) );
	} else {
		echo html( 'li', html_link( appthemes_get_registration_url(), __( 'Register', APP_TD ) ) );
		echo html( 'li', html_link( wp_login_url(), __( 'Login', APP_TD ) ) );
	}

}

// return user name depend of account type
function clpr_get_user_name( $user = false ) {
	global $current_user;

	if ( ! $user && is_object( $current_user ) )
		$user = $current_user;
	else if ( is_numeric( $user ) )
		$user = get_userdata( $user );

	if ( is_object( $user ) ) {

		if ( 'fb-' == substr( $user->user_login, 0, 3 ) )
			$display_user_name = $user->display_name;
		else
			$display_user_name = $user->user_login;

		return $display_user_name;

	} else {
		return false;
	}
}

// return logout url depend of login type
function clpr_logout_url( $url = '' ) {

	if ( ! $url )
		$url = home_url();

	if ( is_user_logged_in() ) {
		return wp_logout_url( $url );
	} else {
		return false;
	}
}

// correct logout url in admin bar
function clpr_admin_bar_render() {
  global $wp_admin_bar;

  if ( is_user_logged_in() ) {
		$wp_admin_bar->remove_menu( 'logout' );
		$wp_admin_bar->add_menu( array(
			'parent' => 'user-actions',
			'id'     => 'logout',
			'title'  => __( 'Log out', APP_TD ),
			'href'   => clpr_logout_url(),
		) );
	}

}
add_action( 'wp_before_admin_bar_render', 'clpr_admin_bar_render' );

// return link to user dashboard page
function clpr_get_dashboard_url( $context = 'display' ) {
	if ( defined('CLPR_DASHBOARD_URL') )
		$url = CLPR_DASHBOARD_URL;
	else
		$url = get_permalink( CLPR_User_Dashboard::get_id() );

	return esc_url( $url, null, $context );
}

// return link to user profile page
function clpr_get_profile_url( $context = 'display' ) {
	if ( defined('CLPR_PROFILE_URL') )
		$url = CLPR_PROFILE_URL;
	else
		$url = get_permalink( CLPR_User_Profile::get_id() );

	return esc_url( $url, null, $context );
}

// return link to submit coupon page
function clpr_get_submit_coupon_url( $context = 'display' ) {
	$url = get_permalink( CLPR_Coupon_Submit::get_id() );

	return esc_url( $url, null, $context );
}

// creates edit coupon link, use only in loop
function clpr_edit_coupon_link() {
	global $post, $current_user, $clpr_options;

	if ( ! is_user_logged_in() )
		return;

	if ( current_user_can('manage_options') ) {
		edit_post_link( __( 'Edit Post', APP_TD ), '<p class="edit">', '</p>', $post->ID );
	} elseif( $clpr_options->coupon_edit && $post->post_author == $current_user->ID ) {
		$edit_link = add_query_arg( 'aid', $post->ID, CLPR_EDIT_URL );
		echo '<p class="edit"><a class="post-edit-link" href="' . $edit_link . '" title="' . __( 'Edit Coupon', APP_TD ).'">' . __( 'Edit Coupon', APP_TD ) . '</a></p>';
	}

}


// returns a total count of all posts based on status and post type
function clpr_count_posts( $post_type, $status_type = 'publish' ) {

	$count_total = 0;
	$count_posts = wp_count_posts( $post_type );

	if ( is_array( $status_type ) ) {
		foreach ( $status_type as $status ) {
			$count_total += $count_posts->$status;
		}
	} else {
		$count_total = $count_posts->$status_type;
	}

	return number_format( $count_total );
}


// returns expire date of coupon
function clpr_get_expire_date( $post_id, $format = 'raw') {
	$expire_date = get_post_meta( $post_id, 'clpr_expire_date', true );
	if ( empty( $expire_date ) )
		return '';

	switch( $format ) {
		case 'display':
			$expire_date = strtotime( $expire_date );
			$expire_date = date_i18n( get_option('date_format'), $expire_date );
			break;

		case 'time':
			$expire_date = strtotime( $expire_date );
			break;

		default://raw
			break;
	}

	return $expire_date;
}


// display the coupon submission form
function clpr_show_coupon_form( $post = false ) {
	$errors = new WP_Error();
?>

	<div class="blog">

		<h1><?php _e( 'Share a Coupon', APP_TD ); ?></h1>

		<div class="content-bar"></div>

		<div class="text-box-form">

			<p><?php _e( 'Complete the form below to share your coupon with us.', APP_TD ); ?></p>

		</div>

	</div> <!-- #blog -->

	<div class="post-box">

		<?php clipper_coupon_form( $post ); ?>

	</div> <!-- #post-box -->

<?php
}


// saves the coupon on the tpl-edit-item.php page template
function clpr_update_listing() {
	global $wpdb, $clpr_options;

	// put the field names we expect into an array
	$fields = array(
		'cid',
		'post_title',
		'coupon_store',
		'store_url',
		'coupon_cat',
		'coupon_type_select',
		'clpr_coupon_code',
		'clpr_expire_date',
		'clpr_coupon_aff_url',
		'post_content',
		'tags_input'
	);

	if ( isset($_POST['clpr_store_id']) )
		$fields[] = 'clpr_store_id';


	// match the field names with the posted values
	// this process is to prevent unexpected field values from being passed in
	foreach( $fields as $field )
		$posted[ $field ] = isset( $_POST[ $field ] ) ? appthemes_clean( $_POST[ $field] ) : '';

	// check to see if html is allowed
	if ( ! $clpr_options->allow_html )
		$posted['post_content'] = appthemes_filter( $posted['post_content'] );

	// setup post array values
	$data = array(
		'ID' => trim( $posted['cid'] ),
		'post_title' => appthemes_filter( $posted['post_title'] ),
		'post_content' => trim( $posted['post_content'] ),

	);

	//print_r($update_item).' <- new ad array<br>'; // for debugging

	// update the item and return the id
	$post_id = wp_update_post($data);


	if ( $post_id ) {

		// now update the coupon category
		// stupidly the cat id is passed in so we need to go back and grab the cat name before we can update it
		$cat_object = get_term_by('id', $posted['coupon_cat'], APP_TAX_CAT);
		wp_set_object_terms($post_id, $cat_object->name, APP_TAX_CAT);

		// set the coupon type
		if ( ! empty( $posted['coupon_type_select'] ) )
			wp_set_object_terms($post_id, $posted['coupon_type_select'], APP_TAX_TYPE, false);

		// update the tags
		if ( !empty($posted['tags_input']) ) {
			$new_tags = appthemes_clean_tags($posted['tags_input']);
			$new_tags = explode(',', $new_tags);
			wp_set_post_terms($post_id, $new_tags, APP_TAX_TAG, false);
		}

		// update meta data
		update_post_meta($post_id, 'clpr_coupon_code', $posted['clpr_coupon_code']);
		update_post_meta($post_id, 'clpr_coupon_aff_url', $posted['clpr_coupon_aff_url']);
		// check to see if pruning expired coupons is enabled
		if ( ! $clpr_options->prune_coupons )
			update_post_meta($post_id, 'clpr_expire_date', $posted['clpr_expire_date']);


		return $post_id;

	} else {
		// the ad wasn't updated so return false
		return false;

	}

}


// updates coupon status
function clpr_status_update($post_id, $post_status = null) {
	global $wpdb;

	$t = strtotime(date('d-m-Y'));
	$votes_down = get_post_meta($post_id, 'clpr_votes_down', true);
	$votes_percent = get_post_meta($post_id, 'clpr_votes_percent', true);
	$expire_date = get_post_meta($post_id, 'clpr_expire_date', true);
	if ( $expire_date != '' )
		$expire_date_time = clpr_get_expire_date( $post_id, 'time' );
	else
		$expire_date_time = 0;

	if ( !$post_status )
		$post_status = get_post_status($post_id);

	if ( ($votes_percent < 50 && $votes_down != 0) || ($expire_date_time < $t && $expire_date != '') ) {
		if ( $post_status == 'publish' )
			$wpdb->update($wpdb->posts, array( 'post_status' => 'unreliable' ), array( 'ID' => $post_id ) );
	} else {
		if ( $post_status == 'unreliable' )
			$wpdb->update($wpdb->posts, array( 'post_status' => 'publish' ), array( 'ID' => $post_id ) );
	}

}


// go get the taxonomy store url custom field
function clpr_store_url( $post_id, $tax_name, $tax_arg ) {
	$term_id = appthemes_get_custom_taxonomy( $post_id, $tax_name, $tax_arg );
	$the_store_url = clpr_get_store_meta( $term_id, 'clpr_store_url', true );
	return $the_store_url;
}


// return store image url with specified size
function clpr_get_store_image_url( $id, $type = 'post_id', $width = 110 ) {
	$store_url = false;
	$store_image_id = false;

	$sizes = array( 75 => 'thumb-med', 110 => 'post-thumbnail', 150 => 'thumb-store', 160 => 'thumb-featured', 250 => 'thumb-large-preview' );
	$sizes = apply_filters( 'clpr_store_image_sizes', $sizes );

	if ( ! array_key_exists( $width, $sizes ) )
		$width = 110;

	if ( ! isset( $sizes[ $width ] ) )
		$sizes[$width] = 'post-thumbnail';

	if ( $type == 'term_id' && $id ) {
		$store_url = clpr_get_store_meta( $id, 'clpr_store_url', true );
		$store_image_id = clpr_get_store_meta( $id, 'clpr_store_image_id', true );
	}

	if ( $type == 'post_id' && $id ) {
		$term_id = appthemes_get_custom_taxonomy( $id, APP_TAX_STORE, 'term_id' );
		$store_url = clpr_get_store_meta( $term_id, 'clpr_store_url', true );
		$store_image_id = clpr_get_store_meta( $term_id, 'clpr_store_image_id', true );
	}

	if ( is_numeric( $store_image_id ) ) {
		$store_image_src = wp_get_attachment_image_src( $store_image_id, $sizes[ $width ] );
		if ( $store_image_src )
			return $store_image_src[0];
	}

	if ( ! empty( $store_url ) ) {
		$store_image_url = "http://s.wordpress.com/mshots/v1/" . urlencode($store_url) . "?w=" . $width;
		return apply_filters( 'clpr_store_image', $store_image_url, $width, $store_url );
	} else {
		$store_image_url = appthemes_locate_template_uri('images/clpr_default.jpg');
		return apply_filters( 'clpr_store_default_image', $store_image_url, $width );
	}

}

// sets the thumbnail pic on the WP admin post
function clpr_set_ad_thumbnail( $post_id, $thumbnail_id ) {
	$thumbnail_html = wp_get_attachment_image( $thumbnail_id, 'thumbnail' );
	if ( ! empty( $thumbnail_html ) ) {
		update_post_meta( $post_id, '_thumbnail_id', $thumbnail_id );
	}
}


// checks if coupon listing have printable coupon
function clpr_has_printable_coupon( $post_id ) {
	// go see if any images are associated with the coupon and grab the first one
	$images = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', APP_TAX_IMAGE => 'printable-coupon', 'order' => 'ASC', 'orderby' => 'ID' ) );

	if ( $images )
		return true;

	$image_url = get_post_meta($post_id, 'clpr_print_url', true);
	if ( ! empty( $image_url ) )
		return true;

	return false;
}


// get the printable coupon image associated to the coupon
function clpr_get_printable_coupon( $post_id, $size = 'thumb-large', $return = 'html' ) {
	// go see if any images are associated with the coupon and grab the first one
	$images = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', APP_TAX_IMAGE => 'printable-coupon', 'order' => 'ASC', 'orderby' => 'ID' ) );

	if ( $images ) {

		// move over bacon
		$image = array_shift( $images );

		// get the coupon image
		$couponimg = wp_get_attachment_image( $image->ID, $size );

		// grab the large image for onclick
		$adlargearray = wp_get_attachment_image_src( $image->ID, 'large' );
		$img_large_url_raw = $adlargearray[0];

		if ( $couponimg ) {
			if ( $return == 'url' ) {
				return $img_large_url_raw;
			} elseif( $return == 'id' ) {
				return $image->ID;
			} else {
				return '<a href="'. $img_large_url_raw .'" target="_blank" title="'. the_title_attribute('echo=0') .'" class="preview" rel="'. $img_large_url_raw .'">'. $couponimg .'</a>';
			}
		}

	// if no image found, try to find in meta (coupons from importer)
	} else {
		$image_url = get_post_meta($post_id, 'clpr_print_url', true);
		if ( ! empty( $image_url ) ) {
			if ( $size == 'thumb-med' ) {
				$size_out = 'width="75" height="75" class="attachment-thumb-med"';
			} else {
				$size_out = 'width="180" height="180" class="attachment-thumb-large"';
			}

			if ( $return == 'url' ) {
				return $image_url;
			} elseif( $return == 'id' ) {
				return 'postmeta';
			} else {
				$post = get_post( $post_id );
				return '<a href="'. $image_url .'" target="_blank" title="'. $post->post_title .'" class="preview" rel="'. $image_url .'"><img '. $size_out .' title="'. $post->post_title .'" alt="'. $post->post_title .'" src="'. $image_url .'" /></a>';
			}
		}
	}

	return false;
}


// removes assigned to post printable coupons
function clpr_remove_printable_coupon( $post_id ) {
	// go see if any images are associated with the coupon
	$images = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', APP_TAX_IMAGE => 'printable-coupon', 'order' => 'ASC', 'orderby' => 'ID' ) );

	if ( $images ) {
		foreach( $images as $image ) {
			wp_set_object_terms( $image->ID, NULL, APP_TAX_IMAGE, false );
			wp_delete_attachment( $image->ID, true );
		}
	}

	delete_post_meta( $post_id, 'clpr_print_url' );
	delete_post_meta( $post_id, 'clpr_print_imageid' );

	return true;
}


// validate coupon expiration date, return bool
function clpr_is_valid_expiration_date( $date ) {
	if ( empty( $date ) )
		return false;

	if ( ! preg_match( "/^(\d{4})-(\d{2})-(\d{2})$/", $date, $date_parts ) ) // year, month, day
		return false;

	if ( ! checkdate( $date_parts[2], $date_parts[3], $date_parts[1] ) ) // month, day, year
		return false;

	$timestamp = strtotime( $date ) + ( 24 * 3600 ); // + 24h, coupons expire in the end of day
	if ( current_time( 'timestamp' ) > $timestamp )
		return false;

	return true;
}


// get the printable coupon image associated to the coupon, use only in loop
function clpr_get_coupon_image( $size = 'thumb-large', $return = 'html' ) {
	global $post;

	echo clpr_get_printable_coupon( $post->ID, $size, $return );
}


// get the coupon upload directory path
function clpr_upload_path( $pathdata ) {
	$subdir = '/coupons'.$pathdata['subdir'];
	$pathdata['path'] = str_replace($pathdata['subdir'], $subdir, $pathdata['path']);
	$pathdata['url'] = str_replace($pathdata['subdir'], $subdir, $pathdata['url']);
	$pathdata['subdir'] = str_replace($pathdata['subdir'], $subdir, $pathdata['subdir']);
	return $pathdata;
}


// return array of hidden stores ids
function clpr_hidden_stores() {
	global $wpdb;

	$hidden_stores = get_transient( 'clpr_hidden_stores_ids' );

	if ( empty( $hidden_stores ) || ! is_array( $hidden_stores ) ) {
		// get ids of all hidden stores
		$hidden_stores_query = "SELECT $wpdb->clpr_storesmeta.stores_id FROM $wpdb->clpr_storesmeta WHERE $wpdb->clpr_storesmeta.meta_key = %s AND $wpdb->clpr_storesmeta.meta_value = %s";
		$hidden_stores = $wpdb->get_col( $wpdb->prepare($hidden_stores_query, 'clpr_store_active', 'no') );
		set_transient( 'clpr_hidden_stores_ids', $hidden_stores, 60*60*24 ); // cache for 1 day
	}

	return $hidden_stores;
}


// return array of featured stores ids
function clpr_featured_stores() {
	global $wpdb;

	$featured_stores = get_transient( 'clpr_featured_stores_ids' );

	if ( empty( $featured_stores ) || ! is_array( $featured_stores ) ) {
		// get ids of all featured stores
		$featured_stores_query = "SELECT $wpdb->clpr_storesmeta.stores_id FROM $wpdb->clpr_storesmeta WHERE $wpdb->clpr_storesmeta.meta_key = %s AND $wpdb->clpr_storesmeta.meta_value = %s";
		$featured_stores = $wpdb->get_col( $wpdb->prepare( $featured_stores_query, 'clpr_store_featured', '1' ) );
		set_transient( 'clpr_featured_stores_ids', $featured_stores, 60*60*24 ); // cache for 1 day
	}

	return $featured_stores;
}


// print store links by most popular
function clpr_popular_stores($the_limit = 5, $before = '', $after = '') {
		global $wpdb;

		$hidden_stores = clpr_hidden_stores();
		$stores_array = get_terms( APP_TAX_STORE, array('orderby' => 'count', 'hide_empty' => 1, 'number' => $the_limit, 'exclude' => $hidden_stores ) );

		if ($stores_array && is_array($stores_array)):
				foreach ( $stores_array as $store ) {
						$link = get_term_link($store, APP_TAX_STORE);
						echo $before . '<a class="tax-link" href="'.$link.'">'.$store->name.'</a>'. $after;
				}
		endif;
}


// ajax auto-complete search for store name
function clpr_store_suggest() {
	global $wpdb;

	if ( !isset($_GET['tax']) )
		die('0');

	$taxonomy = $_GET['tax'];
	if ( !taxonomy_exists( $taxonomy ) )
		die('0');

	$s = $_GET['term']; // is this slashed already?

	if ( false !== strpos( $s, ',' ) ) {
		$s = explode( ',', $s );
		$s = end( $s );
	}

	$s = trim( $s );
	if ( strlen( $s ) < 2 )
		die; // require 2 chars for matching

	$sql = "SELECT t.slug FROM $wpdb->term_taxonomy AS tt INNER JOIN
		$wpdb->terms AS t ON tt.term_id = t.term_id
		WHERE tt.taxonomy = %s
		AND t.name LIKE ('%%" . esc_sql( like_escape( $s ) ) . "%%')
		LIMIT 50
		";


	$sql = $wpdb->prepare( $sql, $taxonomy );

	$terms = $wpdb->get_col($sql);


	// return the term details via json
	if ( empty( $terms ) ) {
		echo json_encode( $terms );
		die;
	} else {
		$i = 0;
		$results = array();
		foreach ( $terms as $term ) {

			$obj = get_term_by( 'slug', $term, $taxonomy );

			// Don't return stores with no active coupons or hidden stores
			if ( ( $obj->count < 1 ) || ( clpr_get_store_meta( $obj->term_id, 'clpr_store_active', true ) == 'no' ) )
				continue;

			$results[ $i ] = $obj;
			$results[ $i ]->clpr_store_url = clpr_get_store_meta( $results[ $i ]->term_id, 'clpr_store_url', true );
			$results[ $i ]->clpr_store_image_url = clpr_get_store_image_url( $results[ $i ]->term_id, 'term_id', 110 );
			$i++;

			// Limit to 5 search results
			if ( $i == 5 ) {
				break;
			}
		}
		echo json_encode( $results );
		die;
	}
}


// creates the charts on the dashboard
function clpr_dashboard_charts() {
	global $wpdb;

	$sql = "SELECT COUNT(post_title) as total, post_date FROM $wpdb->posts WHERE post_type = %s AND post_date > %s GROUP BY DATE(post_date) DESC";
	$results = $wpdb->get_results( $wpdb->prepare( $sql, APP_POST_TYPE, appthemes_mysql_date( current_time( 'mysql' ), -30 ) ) );

	$listings = array();

	// put the days and total posts into an array
	foreach ( (array) $results as $result ) {
		$the_day = date( 'Y-m-d', strtotime( $result->post_date ) );
		$listings[ $the_day ] = $result->total;
	}

	// setup the last 30 days
	for ( $i = 0; $i < 30; $i++ ) {
		$each_day = date( 'Y-m-d', strtotime( '-' . $i . ' days' ) );
		// if there's no day with posts, insert a goose egg
		if ( ! in_array( $each_day, array_keys( $listings ) ) )
			$listings[ $each_day ] = 0;
	}

	// sort the values by date
	ksort( $listings );

	// Get sales - completed orders with a cost
	$results = array();
	$currency_symbol = '$';
	if ( current_theme_supports( 'app-payments' ) ) {
		$sql = "SELECT sum( m.meta_value ) as total, p.post_date FROM $wpdb->postmeta m INNER JOIN $wpdb->posts p ON m.post_id = p.ID WHERE m.meta_key = 'total_price' AND p.post_status IN ( '" . APPTHEMES_ORDER_COMPLETED . "', '" . APPTHEMES_ORDER_ACTIVATED . "' ) AND p.post_date > %s GROUP BY DATE(p.post_date) DESC";
		$results = $wpdb->get_results( $wpdb->prepare( $sql, appthemes_mysql_date( current_time( 'mysql' ), -30 ) ) );
		$currency_symbol = APP_Currencies::get_current_symbol();
	}

	$sales = array();

	// put the days and total posts into an array
	foreach ( (array) $results as $result ) {
		$the_day = date( 'Y-m-d', strtotime( $result->post_date ) );
		$sales[ $the_day ] = $result->total;
	}

	// setup the last 30 days
	for ( $i = 0; $i < 30; $i++ ) {
		$each_day = date( 'Y-m-d', strtotime( '-' . $i . ' days' ) );
		// if there's no day with posts, insert a goose egg
		if ( ! in_array( $each_day, array_keys( $sales ) ) )
			$sales[ $each_day ] = 0;
	}

	// sort the values by date
	ksort( $sales );
?>

<div id="placeholder"></div>

<script type="text/javascript">
// <![CDATA[
jQuery(function () {

	var posts = [
		<?php
		foreach ( $listings as $day => $value ) {
			$sdate = strtotime( $day );
			$sdate = $sdate * 1000; // js timestamps measure milliseconds vs seconds
			$newoutput = "[$sdate, $value],\n";
			echo $newoutput;
		}
		?>
	];

	var sales = [
		<?php
		foreach ( $sales as $day => $value ) {
			$sdate = strtotime( $day );
			$sdate = $sdate * 1000; // js timestamps measure milliseconds vs seconds
			$newoutput = "[$sdate, $value],\n";
			echo $newoutput;
		}
		?>
	];


	var placeholder = jQuery("#placeholder");

	var output = [
		{
			data: posts,
			label: "<?php _e( 'New Coupons', APP_TD ); ?>",
			symbol: ''
		},
		{
			data: sales,
			label: "<?php _e( 'Total Sales', APP_TD ); ?>",
			symbol: '<?php echo $currency_symbol; ?>',
			yaxis: 2
		}
	];

	var options = {
		series: {
			lines: { show: true },
			points: { show: true }
		},
		grid: {
			tickColor:'#f4f4f4',
			hoverable: true,
			clickable: true,
			borderColor: '#f4f4f4',
			backgroundColor:'#FFFFFF'
		},
		xaxis: {
			mode: 'time',
			timeformat: "%m/%d"
		},
		yaxis: {
			min: 0
		},
		y2axis: {
			min: 0,
			tickFormatter: function(v, axis) {
				return "<?php echo $currency_symbol; ?>" + v.toFixed(axis.tickDecimals)
			}
		},
		legend: {
			position: 'nw'
		}
	};

	jQuery.plot(placeholder, output, options);

	// reload the plot when browser window gets resized
	jQuery(window).resize(function() {
		jQuery.plot(placeholder, output, options);
	});

	function showChartTooltip(x, y, contents) {
		jQuery('<div id="charttooltip">' + contents + '</div>').css( {
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 5,
			opacity: 1
		} ).appendTo("body").fadeIn(200);
	}

	var previousPoint = null;
	jQuery("#placeholder").bind("plothover", function (event, pos, item) {
		jQuery("#x").text(pos.x.toFixed(2));
		jQuery("#y").text(pos.y.toFixed(2));
		if (item) {
			if (previousPoint != item.datapoint) {
				previousPoint = item.datapoint;

				jQuery("#charttooltip").remove();
				var x = new Date(item.datapoint[0]), y = item.datapoint[1];
				var xday = x.getDate(), xmonth = x.getMonth()+1; // jan = 0 so we need to offset month
				showChartTooltip(item.pageX, item.pageY, xmonth + "/" + xday + " - <b>" + item.series.symbol + y + "</b> " + item.series.label);
			}
		} else {
			jQuery("#charttooltip").remove();
			previousPoint = null;
		}
	});
});
// ]]>
</script>

<?php
}


// email coupon social pop-up form
function clpr_email_form() {
	global $id, $post;

	$comment_author = '';
	$comment_author_email = '';
	$comment_author_url = '';

	$post = get_post( $_GET['id'] );


	if ( isset( $_COOKIE['comment_author_' . COOKIEHASH] ) ) {
		$comment_author = apply_filters( 'pre_comment_author_name', $_COOKIE['comment_author_' . COOKIEHASH] );
		$comment_author = stripslashes( $comment_author );
		$comment_author = esc_attr( $comment_author );
		$_COOKIE['comment_author_' . COOKIEHASH] = $comment_author;
	}

	if ( isset( $_COOKIE['comment_author_email_' . COOKIEHASH] ) ) {
		$comment_author_email = apply_filters( 'pre_comment_author_email', $_COOKIE['comment_author_email_' . COOKIEHASH] );
		$comment_author_email = stripslashes( $comment_author_email );
		$comment_author_email = esc_attr( $comment_author_email );
		$_COOKIE['comment_author_email_' . COOKIEHASH] = $comment_author_email;
	}

	if ( isset( $_COOKIE['comment_author_url_' . COOKIEHASH] ) ) {
		$comment_author_url = apply_filters( 'pre_comment_author_url', $_COOKIE['comment_author_url_' . COOKIEHASH] );
		$comment_author_url = stripslashes( $comment_author_url );
		$_COOKIE['comment_author_url_' . COOKIEHASH] = $comment_author_url;
	}

?>

	<div class="content-box comment-form">

		<div class="box-holder">

			<div class="post-box">

				<div class="head"><h3><?php _e( 'Email to a Friend:', APP_TD ); ?> &#8220;<?php the_title(); ?>&#8221;</h3></div>

				<div id="respond" class="email-wrap">

					<form action="/" method="post" id="commentform-<?php echo $post->ID; ?>" class="commentForm">

						<?php if ( is_user_logged_in() ) : global $user_identity; ?>

							<p><?php printf( __( 'Logged in as <a href="%1$s">%2$s</a>.', APP_TD ), CLPR_PROFILE_URL, $user_identity ); ?> <a href="<?php echo clpr_logout_url(get_permalink()); ?>"><?php _e( 'Log out &raquo;', APP_TD ); ?></a></p>

						<?php endif; ?>

						<p>
							<label><?php _e( 'Your Name:', APP_TD ); ?></label>
							<input type="text" class="text required" name="author" id="author-<?php echo $post->ID; ?>" value="<?php echo esc_attr($comment_author); ?>" />
						</p>

						<p>
							<label><?php _e( 'Your Email:', APP_TD ); ?></label>
							<input type="text" class="text required email" name="email" id="email-<?php echo $post->ID; ?>" value="<?php echo esc_attr($comment_author_email); ?>" />
						</p>

						<p>
							<label><?php _e( 'Recipients Email:', APP_TD ); ?></label>
							<input type="text" class="text required email" name="recipients" id="recipients-<?php echo $post->ID; ?>" value="" />
						</p>

						<p>
							<label><?php _e( 'Your Message:', APP_TD ); ?></label>
							<textarea cols="30" rows="10" name="message" class="commentbox required" id="message-<?php echo $post->ID; ?>"></textarea>
						</p>

						<p>
							<button type="submit" class="send-email btn submit" id="submit-<?php echo $_GET['id']; ?>" name="submitted" value="submitted"><?php _e( 'Send Email', APP_TD ); ?></button>
							<input type='hidden' name='post_ID' value='<?php echo $post->ID; ?>' class='post_ID' />
							<input type='hidden' name='submitted' value='submitted' />
						</p>

						<?php do_action( 'comment_form', $post->ID ); ?>

					</form>

				</div>

			</div>

		</div>

	</div>

<?php
die;
}


function clpr_send_email_ajax() {
	global $wpdb;

	nocache_headers();

	$post_ID = isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0;
	$post = get_post($post_ID);

	$errors = new WP_Error();

	$fields = array(
		'author',
		'email',
		'recipients',
		'message',
		'post_ID'
	);

	if ( isset($_POST['checking']) ) {
		$fields[] = 'checking';
	}

	// Get (and clean) data
	foreach ( $fields as $field ) {
		$posted[ $field ] = stripslashes( trim( $_POST[ $field ] ) );
	}

	// Check required fields
	$required = array(
		'author' => __( 'Your Name', APP_TD ),
		'email' => __( 'Your Email', APP_TD ),
		'recipients' => __( 'Recipients', APP_TD ),
	);


	foreach ( $required as $field => $name ) {
		if ( empty( $posted[ $field ] ) ) {
			$errors->add( 'submit_error', sprintf( __( '<strong>ERROR</strong>: &ldquo;%s&rdquo; is a required field.', APP_TD ), $name ) );
		}
	}

	//If there is no error, send the email
	if ( $errors && sizeof( $errors ) > 0 && $errors->get_error_code() ) {

		wp_die( __( 'Sorry, there was a problem.', APP_TD ) );

	} else {

		$from_name = $posted['author'];
		$from_email = $posted['email'];
		$the_message = $posted['message'];
		$post = get_post( $posted['post_ID'] );
		$posted['recipients'] = str_replace(' ', '', $posted['recipients']);
		$recipients = explode(',', $posted['recipients']);
		$link = get_permalink($post_ID);
		$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		$results = array();

		foreach ( $recipients as $recipient ) {

			if ( ! is_email( $recipient ) ) {
				$errors->add( 'submit_error', __( '<strong>ERROR</strong>: Please enter a valid email address.', APP_TD ) );
			} else {

				$mailto = $recipient;
				$subject = sprintf( __( '%1$s shared a coupon with you from %2$s', APP_TD ), $from_name, $blogname );

				$message  = html( 'p', __( 'Hi,', APP_TD ) ) . PHP_EOL;
				$message .= html( 'p', sprintf( __( '%s thought you might be interested in the following coupon.', APP_TD ), $from_name ) ) . PHP_EOL;
				$message .= html( 'p', sprintf( __( 'View coupon: %s', APP_TD ), $link ) ) . PHP_EOL;
				$message .= html( 'p', sprintf( __( 'Message: %s', APP_TD ), $the_message ) ) . PHP_EOL;
				$message .= html( 'p',
					__( 'Regards,', APP_TD ) . '<br />' .
					sprintf( __( 'Your %s Team', APP_TD ), $blogname ) . '<br />' .
					home_url( '/' )
				) . PHP_EOL;

				$email = array( 'to' => $mailto, 'subject' => $subject, 'message' => $message, 'from' => $from_email, 'from_name' => $from_name );
				$email = apply_filters( 'clpr_email_share_coupon', $email );

				APP_Mail_From::apply_once( array( 'email' => $email['from'], 'name' => $email['from_name'], 'reply' => true ) );
				appthemes_send_email( $email['to'], $email['subject'], $email['message'] );

				$results[ $recipient ]['success'] = true;
				$results[ $recipient ]['recipient'] = $recipient;
			}
		}

		echo json_encode( $results );

	}
	die;
}


// Provides joins for expired coupon filters
function clpr_expired_coupons_joins( $join, $wp_query ) {
	global $wpdb;

	if ( $wp_query->get( 'not_expired_coupons' ) || $wp_query->get( 'filter_unreliable' ) ) {
		$join .= " INNER JOIN $wpdb->postmeta AS exp1 ON ($wpdb->posts.ID = exp1.post_id) ";
		$join .= " INNER JOIN $wpdb->postmeta AS exp2 ON ($wpdb->posts.ID = exp2.post_id) ";

		// Only provide second join to queries that need it
		$join .= " INNER JOIN $wpdb->postmeta AS exp3 ON ($wpdb->posts.ID = exp3.post_id) ";
	}

	return $join;
}
add_filter( 'posts_join', 'clpr_expired_coupons_joins', 10, 2 );


// Filters out anything that isn't unreliable or expired
function clpr_filter_unreliable_coupons( $where, $wp_query ) {

	if ( ! $wp_query->get( 'filter_unreliable' ) )
		return $where;

	$not_zero = " ( exp1.meta_key = 'clpr_votes_down' AND CAST( exp1.meta_value AS SIGNED) NOT BETWEEN '0' AND '0' ) ";

	$low_percent = " ( exp2.meta_key = 'clpr_votes_percent' AND CAST( exp2.meta_value AS SIGNED ) BETWEEN '0' AND '50' ) ";

	$votes_match = " ( $low_percent AND $not_zero ) ";

	$expired = " ( exp3.meta_key = 'clpr_expire_date' AND exp3.meta_value < CURRENT_DATE() ) ";

	$not_empty = " ( exp3.meta_key = 'clpr_expire_date' AND exp3.meta_value != '' ) ";

	$expired_match = " ( $expired AND $not_empty ) ";

	$meta_matches = " ( $votes_match OR $expired_match )";

	$where .= " AND ( $meta_matches ) ";

	return $where;
}
add_filter( 'posts_where', 'clpr_filter_unreliable_coupons', 10, 2 );

// Filters out expired coupons
function clpr_not_expired_coupons_filter( $where, $wp_query ) {

	if ( $wp_query->get( 'not_expired_coupons' ) )
		$where .= " AND ( (exp1.meta_key = 'clpr_expire_date' AND exp1.meta_value >= CURRENT_DATE()) OR ( exp1.meta_key = 'clpr_expire_date' AND exp1.meta_value = '') )";

	return $where;
}
add_filter( 'posts_where', 'clpr_not_expired_coupons_filter', 10, 2 );


// Filters out non-expired coupons
function clpr_expired_coupons_filter( $where, $wp_query ) {
	global $wpdb;

	if ( $wp_query->get( 'expired_coupons' ) )
		$where .= " AND ($wpdb->postmeta.meta_key = 'clpr_expire_date' AND $wpdb->postmeta.meta_value < CURRENT_DATE())";

	return $where;
}
add_filter( 'posts_where', 'clpr_expired_coupons_filter', 10, 2 );


function clpr_coupon_prune() {
	global $clpr_options;

	$message = '';
	$links_list = '';
	$subject = __( 'Clipper Coupons Expired', APP_TD );

	if ( ! $clpr_options->prune_coupons )
		return;

	// Get all coupons with an expired date that have expired
	$args = array(
		'post_type' => APP_POST_TYPE,
		'expired_coupons' => true,
		'posts_per_page' => -1,
		'fields' => 'ids',
		'no_found_rows' => true,
		'meta_query' => array(
			array(
				'key' => 'clpr_expire_date',
				'value' => '',
				'compare' => '!=',
			)
		)
	);
	$expired = new WP_Query( $args );

	if ( isset( $expired->posts ) && is_array( $expired->posts ) ) {
		foreach ( $expired->posts as $post_id ) {
			wp_update_post( array( 'ID' => $post_id, 'post_status' => 'draft' ) );
			$links_list .= html( 'li', get_permalink( $post_id ) ) . PHP_EOL;
		}
	}

	$message .= html( 'p', __( 'Your cron job has run successfully. ', APP_TD ) ) . PHP_EOL;
	if ( empty( $links_list ) ) {
		$message .= html( 'p', __( 'No expired coupons were found.', APP_TD ) ) . PHP_EOL;
	} else {
		$message .= html( 'p', __( 'The following coupons expired and have been taken down from your website: ', APP_TD ) ) . PHP_EOL;
		$message .= html( 'ul', $links_list ) . PHP_EOL;
	}

	$message .= html( 'p', __( 'Regards,', APP_TD ) . '<br />' . __( 'Clipper', APP_TD ) ) . PHP_EOL;

	if ( $clpr_options->prune_coupons_email ) {
		$email = array( 'to' => get_option( 'admin_email' ), 'subject' => $subject, 'message' => $message );
		$email = apply_filters( 'clpr_email_admin_coupons_expired', $email );

		appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
	}
}
add_action( 'clpr_coupon_prune', 'clpr_coupon_prune' );


// Schedules a daily event to prune coupons who have expired
function clpr_schedule_coupon_prune() {
	if ( ! wp_next_scheduled( 'clpr_coupon_prune' ) )
		wp_schedule_event( time(), 'daily', 'clpr_coupon_prune' );
}
add_action( 'init', 'clpr_schedule_coupon_prune' );


// Displays coupon type/code box
if ( ! function_exists('clpr_coupon_code_box') ) :
	function clpr_coupon_code_box( $coupon_type = null ) {
		global $post, $clpr_options;

		if ( ! $coupon_type )
			$coupon_type = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_TYPE, 'slug_name' );

		// display additionsl info if coupon is expired
		clpr_display_expired_info( $post->ID );

		switch( $coupon_type ) {
			case 'printable-coupon':
?>
				<h5><?php _e( 'Code:', APP_TD ); ?></h5>
				<div class="couponAndTip">
					<div class="link-holder">
						<a href="<?php clpr_get_coupon_image('thumb-med', 'url'); ?>" id="coupon-link-<?php echo $post->ID; ?>" class="coupon-code-link" title="<?php _e( 'Click to Print', APP_TD ); ?>" target="_blank" data-clipboard-text="<?php _e( 'Print Coupon', APP_TD ); ?>"><span><?php _e( 'Print Coupon', APP_TD ); ?></span></a>
					</div> <!-- #link-holder -->
					<p class="link-popup"><span><?php _e( 'Click to print coupon', APP_TD ); ?></span></p>
				</div><!-- /couponAndTip -->
<?php
				break;

			case 'coupon-code':
?>
				<h5><?php _e( 'Code:', APP_TD ); ?></h5>
				<div class="couponAndTip">
					<div class="link-holder">
						<?php if ( $clpr_options->coupon_code_hide ) $button_text = __( 'Show Coupon Code', APP_TD ); else $button_text = wptexturize( get_post_meta( $post->ID, 'clpr_coupon_code', true ) ); ?>
						<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" id="coupon-link-<?php echo $post->ID; ?>" class="coupon-code-link" title="<?php _e( 'Click to copy &amp; open site', APP_TD ); ?>" target="_blank" data-clipboard-text="<?php echo wptexturize( get_post_meta( $post->ID, 'clpr_coupon_code', true ) ); ?>"><span><?php echo $button_text; ?></span></a>
					</div> <!-- #link-holder -->
					<p class="link-popup"><span><?php _e( 'Click to copy &amp; open site', APP_TD ); ?></span></p>
				</div><!-- /couponAndTip -->
<?php
				break;

			default:
?>
				<h5><?php _e( 'Promo:', APP_TD ); ?></h5>
				<div class="couponAndTip">
					<div class="link-holder">
						<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" id="coupon-link-<?php echo $post->ID; ?>" class="coupon-code-link" title="<?php _e( 'Click to open site', APP_TD ); ?>" target="_blank" data-clipboard-text="<?php _e( 'Click to Redeem', APP_TD ); ?>"><span><?php _e( 'Click to Redeem', APP_TD ); ?></span></a>
					</div> <!-- #link-holder -->
					<p class="link-popup"><span><?php _e( 'Click to open site', APP_TD ); ?></span></p>
				</div><!-- /couponAndTip -->
<?php
				break;
		} // end switch
	}
endif;


// load all page templates, setup cache, limits db queries
function clpr_load_all_page_templates() {
	$pages = get_posts( array(
		'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'posts_per_page' => -1,
		'no_found_rows' => true,
	) );

}


// updates post status
function clpr_update_post_status( $post_id, $new_status ) {
	wp_update_post( array(
		'ID' => $post_id,
		'post_status' => $new_status
	) );
}


// deletes coupon listing together with associated attachments, votes, stats, reports
function clpr_delete_coupon( $post_id ) {
	global $wpdb;

	$attachments_query = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type='attachment'", $post_id );
	$attachments = $wpdb->get_results( $attachments_query );

	// delete all associated attachments
	if ( $attachments )
		foreach( $attachments as $attachment )
			wp_delete_attachment( $attachment->ID, true );

	// delete all votes from tables
	$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->clpr_votes_total WHERE post_id = '%d'", $post_id ) );
	$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->clpr_votes WHERE post_id = '%d'", $post_id ) );

	// delete all stats from tables
	$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->clpr_pop_total WHERE postnum = '%d'", $post_id ) );
	$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->clpr_pop_daily WHERE postnum = '%d'", $post_id ) );

	// delete post and it's revisions, comments, meta
	if ( wp_delete_post( $post_id, true ) )
		return true;
	else
		return false;
}


// delete all search stats when the admin option has been selected
function clpr_reset_search_stats() {
	global $wpdb;

	// empty both search tables
	$wpdb->query( "TRUNCATE $wpdb->clpr_search_recent ;" );
	$wpdb->query( "TRUNCATE $wpdb->clpr_search_total ;" );

}


/**
 * Returns coupons which are marked as featured for slider
 *
 * @since 1.5
 *
 */
function clpr_get_featured_slider_coupons() {

	$args = array(
		'post_type' => APP_POST_TYPE,
		'post_status' => array( 'publish', 'unreliable' ),
		'meta_key' => 'clpr_featured',
		'meta_value' => '1',
		'posts_per_page' => 15,
		'orderby' => 'rand',
		'no_found_rows' => true,
		'suppress_filters' => false,
	);

	$args = apply_filters( 'clpr_featured_slider_args', $args );

	$featured = new WP_Query( $args );

	if ( ! $featured->have_posts() )
		return false;

	return $featured;
}


/**
 * Create terms list.
 *
 * @since 1.5
 *
 * @param array $args
 *
 * @return string
 */
function clpr_terms_list( $args = array() ) {

	$defaults = array(
		'taxonomy' => 'category',
		'exclude' => array(),
		'menu' => true,
		'count' => true,
		'top_link' => true,
		'class' => 'terms',
	);

	$options = wp_parse_args( (array) $args, $defaults );
	$options = apply_filters( 'clpr_terms_list_args', $options );

	$terms = get_terms( $options['taxonomy'], array( 'hide_empty' => 0, 'child_of' => 0, 'pad_counts' => 0, 'app_pad_counts' => 1 ) );

	$navigation = '';
	$list = '';
	$groups = array();

	if ( empty( $terms ) || ! is_array( $terms ) )
		return html( 'p', __( 'Sorry, but no terms were found.', APP_TD ) );

	// unset child terms
	foreach ( $terms as $key => $value ) {
		if ( $value->parent != 0 )
			unset( $terms[ $key ] );
	}

	foreach ( $terms as $term ) {
		$letter = mb_strtoupper( mb_substr( $term->name, 0, 1 ) );
		if ( is_numeric( $letter ) )
			$letter = '#';

		if ( ! empty( $letter ) )
			$groups[ $letter ][] = $term;
	}

	if ( empty( $groups ) )
		return;

	foreach ( $groups as $letter => $terms ) {
		$old_list = $list;
		$old_navigation = $navigation;
		$letter_items = false;

		$letter = apply_filters( 'the_title', $letter );
		$letter_id = ( preg_match( '/\p{L}/', $letter ) ) ? $letter : substr( md5( $letter ), 0, 5 ); // hash special chars
		$navigation .= html_link( '#' . $options['class'] . '-' . $letter_id, $letter );
		$top_link = ( $options['top_link'] ) ? html_link( '#top', __( 'Top', APP_TD ) . ' &uarr;' ) : '';

		$list .= '<h2 class="' . $options['class'] . '" id="' . $options['class'] . '-' . $letter_id . '">' . $letter . $top_link . '</h2>';
		$list .= '<ul class="' . $options['class'] . '">';

		foreach ( $terms as $term ) {
			if ( in_array( $term->term_id, $options['exclude'] ) )
				continue;

			$letter_items = true;
			$name = apply_filters( 'the_title', $term->name );
			$link = html_link( get_term_link( $term, $options['taxonomy'] ), $name );
			$count = ( $options['count'] ) ? ' (' . intval( $term->count ) . ')' : '';

			$list .= html( 'li', $link . $count );
		}

		$list .= '</ul>';

		if ( ! $letter_items ) {
			$list = $old_list;
			$navigation = $old_navigation;
		}
	}

	$navigation = html( 'div class="grouplinks"', $navigation );

	if ( $options['menu'] )
		$list = $navigation . $list;

	return $list;
}


/**
 * Create categories list.
 *
 * @since 1.5
 *
 * @return string
 */
function clpr_categories_list() {
	$args = array(
		'taxonomy' => APP_TAX_CAT,
		'class' => 'categories',
	);

	return clpr_terms_list( $args );
}


/**
 * Create stores list.
 *
 * @since 1.5
 *
 * @return string
 */
function clpr_stores_list() {
	$hidden_stores = clpr_hidden_stores();
	$args = array(
		'taxonomy' => APP_TAX_STORE,
		'exclude' => $hidden_stores,
		'class' => 'stores',
	);

	return clpr_terms_list( $args );
}


/**
 * Displays report coupon form.
 *
 * @return string
 */
function clpr_report_coupon( $echo = false ) {
	global $post;

	$form = appthemes_get_reports_form( $post->ID, 'post' );
	if ( ! $form )
		return;

	$content = '<li><div class="reports_wrapper"><div class="reports_form_link">';
	$content .= '<a href="#" class="problem">' . __( 'Report a Problem', APP_TD ) . '</a>';
	$content .= '</div></div></li>';
	$content .= '<li class="report">' . $form . '</li>';

	if ( $echo )
		echo $content;

	return $content;
}


/**
 * Add meta data field to a store.
 *
 * @since 1.5
 *
 * @param int $store_id Store ID.
 * @param string $meta_key Metadata name.
 * @param mixed $meta_value Metadata value. Must be serializable if non-scalar.
 * @param bool $unique Optional, default is false. Whether the same key should not be added.
 *
 * @return int|bool Meta ID on success, false on failure.
 */
function clpr_add_store_meta( $store_id, $meta_key, $meta_value, $unique = false ) {
	return add_metadata( APP_TAX_STORE, $store_id, $meta_key, $meta_value, $unique );
}


/**
 * Remove metadata matching criteria from a store.
 *
 * @since 1.5
 *
 * @param int $store_id Store ID
 * @param string $meta_key Metadata name.
 * @param mixed $meta_value Optional. Metadata value. Must be serializable if non-scalar.
 *
 * @return bool True on success, false on failure.
 */
function clpr_delete_store_meta( $store_id, $meta_key, $meta_value = '' ) {
	return delete_metadata( APP_TAX_STORE, $store_id, $meta_key, $meta_value );
}


/**
 * Retrieve store meta field for a store.
 *
 * @since 1.5
 *
 * @param int $store_id Store ID.
 * @param string $key Optional. The meta key to retrieve. By default, returns data for all keys.
 * @param bool $single Whether to return a single value.
 *
 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single is true.
 */
function clpr_get_store_meta( $store_id, $key = '', $single = false ) {
	return get_metadata( APP_TAX_STORE, $store_id, $key, $single );
}


/**
 * Update store meta field based on store ID.
 *
 * @since 1.5
 *
 * @param int $store_id Store ID.
 * @param string $meta_key Metadata key.
 * @param mixed $meta_value Metadata value. Must be serializable if non-scalar.
 * @param mixed $prev_value Optional. Previous value to check before removing.
 *
 * @return bool True on success, false on failure.
 */
function clpr_update_store_meta( $store_id, $meta_key, $meta_value, $prev_value = '' ) {
	return update_metadata( APP_TAX_STORE, $store_id, $meta_key, $meta_value, $prev_value );
}


/**
 * Displays additional information if coupon is expired.
 *
 * @since 1.5
 *
 * @param int $post_id Post ID.
 *
 * @return void
 */
function clpr_display_expired_info( $post_id ) {
	// do not show on taxonomy pages, there is Unreliable section
	if ( is_tax() )
		return;

	$expire_time = clpr_get_expire_date( $post_id, 'time' );
	if ( ! $expire_time )
		return;

	$expire_time += ( 24 * 3600 ); // + 24h, coupons expire in the end of day
	if ( $expire_time > current_time( 'timestamp' ) )
		return;

	echo html( 'div class="expired-coupon-info"', __( 'This offer has expired.', APP_TD ) );
}


/**
 * Displays coupon title or link - depend on settings.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_coupon_title() {
	global $clpr_options;

	if ( ! in_the_loop() )
		return;

	if ( $clpr_options->link_single_page ) {
		$title = ( mb_strlen( get_the_title() ) >= 87 ) ? mb_substr( get_the_title(), 0, 87 ) . '...' : get_the_title();
		$title_attr = sprintf( esc_attr__( 'View the "%s" coupon page', APP_TD ), the_title_attribute( 'echo=0' ) );
		echo html( 'a', array( 'href' => get_permalink(), 'title' => $title_attr ), $title );
	} else {
		the_title();
	}
}


/**
 * Displays coupon content or content preview - depend on settings.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_coupon_content() {
	global $post, $clpr_options;

	if ( ! in_the_loop() )
		return;

	if ( $clpr_options->link_single_page ) {
		$content = mb_substr( strip_tags( $post->post_content ), 0, 200 ) . '... ';
		$title_attr = sprintf( esc_attr__( 'View the "%s" coupon page', APP_TD ), the_title_attribute( 'echo=0' ) );
		echo $content . html( 'a', array( 'href' => get_permalink(), 'class' => 'more', 'title' => $title_attr ), __( 'more &rsaquo;&rsaquo;', APP_TD ) );
	} else {
		the_content();
	}
}


/**
 * Query popular coupons & posts.
 *
 * @since 1.5
 *
 */
class CLPR_Popular_Posts_Query extends WP_Query {

	public $stats;
	public $stats_table;
	public $today_date;

	function __construct( $args = array(), $stats = 'total' ) {
		global $wpdb;

		$this->stats = $stats;
		$this->stats_table = ( $stats == 'today' ) ? $wpdb->clpr_pop_daily : $wpdb->clpr_pop_total;
		$this->today_date = date( 'Y-m-d', current_time( 'timestamp' ) );

		$defaults = array(
			'post_type' => APP_POST_TYPE,
			'post_status' => 'publish',
			'paged' => ( get_query_var('paged') ) ? get_query_var('paged') : 1,
			'suppress_filters' => false,
		);
		$args = wp_parse_args( $args, $defaults );

		$args = apply_filters( 'clpr_popular_posts_args', $args );

		add_filter( 'posts_join', array( $this, 'posts_join' ) );
		add_filter( 'posts_where', array( $this, 'posts_where' ) );
		add_filter( 'posts_orderby', array( $this, 'posts_orderby' ) );

		parent::__construct( $args );

		// remove filters to don't affect any other queries
		remove_filter( 'posts_join', array( $this, 'posts_join' ) );
		remove_filter( 'posts_where', array( $this, 'posts_where' ) );
		remove_filter( 'posts_orderby', array( $this, 'posts_orderby' ) );
	}

	function posts_join( $sql ) {
		global $wpdb;
		return $sql . " INNER JOIN $this->stats_table ON ($wpdb->posts.ID = $this->stats_table.postnum) ";
	}

	function posts_where( $sql ) {
		global $wpdb;
		$sql = $sql . " AND $this->stats_table.postcount > 0 ";

		if ( $this->stats == 'today' )
			$sql .= " AND $this->stats_table.time = '$this->today_date' ";

		if ( $this->get( 'date_start' ) )
			$sql .= " AND $wpdb->posts.post_date > '" . $this->get( 'date_start' ) . "' ";

		return $sql;
	}

	function posts_orderby( $sql ) {
		return "$this->stats_table.postcount DESC";
	}

}


/**
 * Adds Open Graph meta tags.
 *
 * @since 1.5.1
 *
 */
class CLPR_Open_Graph extends APP_Open_Graph {

	public function __construct( $args = array() ) {
		global $clpr_options;

		if ( ! empty( $clpr_options->logo_url ) ) {
			$args['default_image'] = $clpr_options->logo_url;
		} else {
			$args['default_image'] = appthemes_locate_template_uri( 'images/logo.png' );
		}

		parent::__construct( $args );
	}

	public function get_image_url() {
		$image_url = '';
		$queried_object = get_queried_object();

		if ( is_singular( APP_POST_TYPE ) ) {
			$image_url = clpr_get_store_image_url( $queried_object->ID, 'post_id', 250 );
		} else if ( is_tax( APP_TAX_STORE ) ) {
			$image_url = clpr_get_store_image_url( $queried_object->term_id, 'term_id', 250 );
		} else {
			$image_url = parent::get_image_url();
		}

		if ( empty( $image_url ) ) {
			$image_url = $this->args['default_image'];
		}

		return $image_url;
	}

}


/**
 * Generates unique ID for coupons.
 * @since 1.5.1
 *
 * @return string
 */
function clpr_generate_id() {
	$id = uniqid( rand( 10, 1000 ), false );

	if ( clpr_get_listing_by_ref( $id ) ) {
		return clpr_generate_id();
	}

	return $id;
}


/**
 * Retrieves listing data by given reference ID.
 * @since 1.5.1
 *
 * @param string $reference_id An listing reference ID
 *
 * @return object|bool A listing object, boolean False otherwise
 */
function clpr_get_listing_by_ref( $reference_id ) {

	if ( empty( $reference_id ) || ! is_string( $reference_id ) )
		return false;

	$reference_id = appthemes_numbers_letters_only( $reference_id );

	$listing_q = new WP_Query( array(
		'post_type' => APP_POST_TYPE,
		'post_status' => 'any',
		'meta_key' => 'clpr_id',
		'meta_value' => $reference_id,
		'posts_per_page' => 1,
		'suppress_filters' => true,
		'no_found_rows' => true,
	) );

	if ( empty( $listing_q->posts ) )
		return false;

	return $listing_q->posts[0];
}


/**
 * Returns an array of settings for WP Editor used on the frontend.
 * @since 1.5.1
 *
 * @return array An array of WP Editor settings.
 */
function clpr_get_editor_settings() {
	$settings = array(
		'wpautop' => true,
		'media_buttons' => false,
		'textarea_rows' => 10,
		'editor_class' => 'required',
		'teeny' => false,
		'dfw' => true,
		'tinymce' => true,
		'quicktags' => array(
			'buttons' => 'strong,em,ul,ol,li,link,close',
		),
	);

	return $settings;
}


/**
 * Displays coupon code popup.
 *
 * @since 1.5.1
 *
 * @return void
 */
function clpr_coupon_code_popup() {
	if ( 'GET' != $_SERVER['REQUEST_METHOD'] ) {
		appthemes_display_notice( 'error', __( 'Sorry, only get method allowed.', APP_TD ) );
		die;
	}

	$post_id = isset( $_GET['id'] ) ? (int) appthemes_numbers_only( $_GET['id'] ) : 0;
	if ( $post_id < 1 ) {
		appthemes_display_notice( 'error', __( 'Sorry, item does not exist.', APP_TD ) );
		die;
	}

	$post = get_post( $post_id );
	if ( ! $post ) {
		appthemes_display_notice( 'error', __( 'Sorry, item does not exist.', APP_TD ) );
		die;
	}

	if ( $post->post_type != APP_POST_TYPE ) {
		appthemes_display_notice( 'error', __( 'Sorry, wrong item type.', APP_TD ) );
		die;
	}

	$coupon_type = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_TYPE, 'slug_name' );
	if ( $coupon_type != 'coupon-code' ) {
		appthemes_display_notice( 'error', __( 'Sorry, wrong item type.', APP_TD ) );
		die;
	}

	$coupon_code = wptexturize( get_post_meta( $post->ID, 'clpr_coupon_code', true ) );
?>

	<div class="content-box comment-form coupon-code-popup">

		<div class="box-holder">

			<div class="post-box">

				<div class="head"><h3><?php printf( __( 'Your %s coupon code:', APP_TD ), get_the_term_list( $post->ID, APP_TAX_STORE, ' ', ', ', '' ) ); ?></h3></div>

				<div id="respond">

					<div class="popup-code-copy">
						<div class="text"><?php echo esc_attr( $coupon_code ); ?></div>
						<button id="copy-button" class="btn submit" data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>" ><?php _e( 'Copy', APP_TD ); ?></button>
					</div>

					<div class="popup-code-info">
						<p><?php _e( 'Paste this code at checkout when you are done shopping.', APP_TD ); ?></p>
						<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" title="<?php _e( 'Click to open site', APP_TD ); ?>" target="_blank" ><?php _e( 'Open site', APP_TD ); ?></a>
					</div>

					<?php do_action( 'clpr_coupon_code_popup', $post->ID ); ?>

				</div>

			</div>

		</div>

	</div>

<?php
	die;
}
