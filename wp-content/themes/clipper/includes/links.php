<?php
/**
 * Manages the click thrus and redirects for 
 * coupon and store affiliate links
 *
 * @since 1.1
 * @package Clipper
 */


// create the rewrite rules
function clpr_rewrite_tag() {
	add_rewrite_tag( '%'.CLPR_STORE_REDIRECT_BASE_URL.'%', '([^&]+)' );
	add_rewrite_rule('^'.CLPR_STORE_REDIRECT_BASE_URL.'([^/]*)','index.php?store_slug=$matches[1]','top');

	add_rewrite_tag( '%'.CLPR_COUPON_REDIRECT_BASE_URL.'%', '([^&]+)' );
	add_rewrite_rule('^'.CLPR_COUPON_REDIRECT_BASE_URL.'([^/]*)/([^/]*)','index.php?coupon_slug=$matches[1]&coupon_id=$matches[2]','top');
}
add_action( 'init', 'clpr_rewrite_tag' );


function clpr_redirect_links( $wp ) {
	global $wp_rewrite;

	if ( $wp_rewrite->using_permalinks() ) {
		if ( isset( $wp->query_vars['store_slug'] ) )
			$target = clpr_redirect_store( $wp->query_vars['store_slug'] );

		if ( isset( $wp->query_vars['coupon_id'] ) )
			$target = clpr_redirect_coupon( $wp->query_vars['coupon_id'] );
	} else {
		if ( !empty( $_GET['redirect_store'] ) )
			$target = clpr_redirect_store( $_GET['redirect_store'] );

		if ( !empty( $_GET['redirect_coupon'] ) )
			$target = clpr_redirect_coupon( $_GET['redirect_coupon'] );
	}

	if ( !isset( $target ) )
		return;

	clpr_redirect( $target );
	die();
}
add_action( 'parse_request', 'clpr_redirect_links' );


function clpr_add_query_vars( $public_query_vars ) {
	$public_query_vars[] = "store_slug";
	$public_query_vars[] = "coupon_slug";
	$public_query_vars[] = "coupon_id";
	return $public_query_vars;
}
add_filter( 'query_vars', 'clpr_add_query_vars' );


// increments the store clicks meta field 
function clpr_redirect_store( $slug ) {
	$term = get_term_by( 'slug', $slug, APP_TAX_STORE );
	$target = clpr_get_store_meta( $term->term_id, 'clpr_store_aff_url', true );
	if ( ! $target )
		$target = clpr_get_store_meta( $term->term_id, 'clpr_store_url', true );

	$count = clpr_get_store_meta( $term->term_id, 'clpr_aff_url_clicks', true );
	if ( $count )
		$count++;
	else
		$count = 1;

	clpr_update_store_meta( $term->term_id, 'clpr_aff_url_clicks', $count );

	return $target;
}


// increments the coupon clicks meta field 
function clpr_redirect_coupon( $id ) {
	$target = get_post_meta( $id, 'clpr_coupon_aff_url', true );

	$count = get_post_meta( $id, 'clpr_coupon_aff_clicks', true );
	if ( $count )
		$count++;
	else
		$count = 1;

	update_post_meta( $id, 'clpr_coupon_aff_clicks', $count );

	return $target;
}


/**
 * Redirects to another page. wp_redirect() breaks affiliate links.
 *
 * @since 1.1
 *
 * @param string $location The path to redirect to.
 * @param int $status (optional) Status code to use.
 *
 * @return bool False if $location is not provided.
 */
function clpr_redirect( $location, $status = 301 ) {
	global $is_IIS;

	$location = apply_filters( 'wp_redirect', $location, $status );
	$status = apply_filters( 'wp_redirect_status', $status, $location );

	if ( ! $location )
		return false;

	$location = preg_replace( '|[^a-z0-9-~+_.?#=&;,/:%!\(\)\{\}\*]|i', '', $location );

	$location = wp_kses_no_null( $location );

	$strip = array( '%0d', '%0a', '%0D', '%0A' );
	$location = _deep_replace( $strip, $location );

	if ( ! $is_IIS && php_sapi_name() != 'cgi-fcgi' )
		status_header( $status );

	header( "Location: $location", true, $status );
}


/**
 * Returns store outgoing url.
 *
 * @since 1.4
 *
 * @param object $term A Stores Term object.
 * @param string $context (optional) How to escape url.
 *
 * @return string
 */
function clpr_get_store_out_url( $term, $context = 'display' ) {
	global $clpr_options;

	if ( ! is_object( $term ) )
		return;

	if ( $clpr_options->cloak_links ) {
		if ( get_option( 'permalink_structure' ) != '' ) {
			$url = home_url( CLPR_STORE_REDIRECT_BASE_URL . $term->slug );
		} else {
			$url = add_query_arg( array( 'redirect_store' => $term->slug ), home_url( '/' ) );
		}
	} else {
		$url = clpr_get_store_meta( $term->term_id, 'clpr_store_aff_url', true );
		if ( empty( $url ) ) {
			$url = clpr_get_store_meta( $term->term_id, 'clpr_store_url', true );
		}
	}

	$url = apply_filters( 'clpr_store_out_url', $url, $term );

	return esc_url( $url, null, $context );
}


/**
 * Returns coupon outgoing url.
 *
 * @since 1.4
 *
 * @param object $post A Post object.
 * @param string $context (optional) How to escape url.
 *
 * @return string
 */
function clpr_get_coupon_out_url( $post, $context = 'display' ) {
	global $clpr_options;

	if ( ! is_object( $post ) )
		return;

	$url = '';
	$aff_url = get_post_meta( $post->ID, 'clpr_coupon_aff_url', true );

	if ( $clpr_options->cloak_links && ! empty( $aff_url ) ) {
		if ( get_option( 'permalink_structure' ) != '' ) {
			$url = home_url( CLPR_COUPON_REDIRECT_BASE_URL . $post->post_name . '/' . $post->ID );
		} else {
			$url = add_query_arg( array( 'redirect_coupon' => $post->ID ), home_url( '/' ) );
		}
	} else {
		$store = wp_get_post_terms($post->ID, APP_TAX_STORE);
		if ( ! empty( $store ) && ! is_wp_error( $store ) )
			$url = clpr_get_store_out_url( $store[0], 'url' );
	}

	$url = apply_filters( 'clpr_coupon_out_url', $url, $post );

	return esc_url( $url, null, $context );
}

