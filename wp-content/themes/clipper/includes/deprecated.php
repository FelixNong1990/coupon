<?php
/**
 *
 * Holding Deprecated functions oldest at the bottom (delete and clean as needed)
 * @package Clipper
 * @author AppThemes
 *
 */


/**
 * Constants.
 *
 * @deprecated 1.5
 */
define( 'THE_POSITION', 3 );
define( 'FAVICON', get_template_directory_uri() . '/images/site_icon.png' );


/**
 * Feed url related to currently browsed page.
 *
 * @deprecated 1.4
 * @deprecated Use appthemes_get_feed_url()
 * @see appthemes_get_feed_url()
 */
if ( ! function_exists( 'clpr_get_feed_url' ) ) {
	function clpr_get_feed_url() {
		_deprecated_function( __FUNCTION__, '1.4', 'appthemes_get_feed_url()' );

		return appthemes_get_feed_url();
	}
}


/**
 * Return store image url with specified size.
 *
 * @deprecated 1.4
 * @deprecated Use clpr_get_store_image_url()
 * @see clpr_get_store_image_url()
 */
if ( ! function_exists( 'clpr_store_image' ) ) {
	function clpr_store_image( $post_id, $tax_name, $tax_arg, $width, $store_url ) {
		_deprecated_function( __FUNCTION__, '1.4', 'clpr_get_store_image_url()' );

		if ( ! $post_id && is_tax( APP_TAX_STORE ) ) {
			$term = get_queried_object();
			return clpr_get_store_image_url( $term->term_id, 'term_id', $width );
		} else {
			return clpr_get_store_image_url( $post_id, 'post_id', $width );
		}

	}
}


/**
 * Return coupon outgoing url.
 *
 * @deprecated 1.4
 * @deprecated Use clpr_get_coupon_out_url()
 * @see clpr_get_coupon_out_url()
 */
if ( ! function_exists( 'get_clpr_coupon_url' ) ) {
	function get_clpr_coupon_url( $post ) {
		_deprecated_function( __FUNCTION__, '1.4', 'clpr_get_coupon_out_url()' );

		return clpr_get_coupon_out_url( $post );
	}
}


/**
 * Was creating admin dashboard.
 *
 * @deprecated 1.5
 * @see CLPR_Theme_Dashboard
 */
function app_dashboard() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was creating admin general settings page.
 *
 * @deprecated 1.5
 * @see CLPR_Theme_Settings_General
 */
function app_settings() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was creating admin emails settings page.
 *
 * @deprecated 1.5
 * @see CLPR_Theme_Settings_Emails
 */
function app_emails() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was updating admin settings.
 *
 * @deprecated 1.5
 */
function appthemes_update_options( $options ) {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was generating admin settings fields.
 *
 * @deprecated 1.5
 */
function appthemes_admin_fields( $options ) {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was generating admin system info page.
 *
 * @deprecated 1.5
 */
function app_system_info() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Returns default currency code.
 *
 * @deprecated 1.5
 * @see $clpr_options
 */
function clpr_get_default_currency_code() {
	global $clpr_options;

	_deprecated_function( __FUNCTION__, '1.5' );

	return $clpr_options->currency_code;
}


/**
 * Was generating default header menu.
 *
 * @deprecated 1.5
 */
function clpr_primary_nav_menu() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was generating default footer menu.
 *
 * @deprecated 1.5
 */
function clpr_footer_nav_menu() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Gets the transient array holding all the post ids the visitor has voted for.
 *
 * @deprecated 1.5
 */
function clpr_vote_transient() {
	_deprecated_function( __FUNCTION__, '1.5', 'appthemes_get_visitor_transient()' );

	return appthemes_get_visitor_transient( 'visitor_votes' );
}


/**
 * RSS blog feed for the dashboard page.
 *
 * @deprecated 1.5
 */
function appthemes_dashboard_appthemes() {
	_deprecated_function( __FUNCTION__, '1.5' );
	$rss_feed = 'http://feeds2.feedburner.com/appthemes';
	wp_widget_rss_output( $rss_feed, array( 'items' => 10, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1 ) );
}


/**
 * RSS twitter feed for the dashboard page.
 *
 * @deprecated 1.5
 */
function appthemes_dashboard_twitter() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * RSS forum feed for the dashboard page.
 *
 * @deprecated 1.5
 */
function appthemes_dashboard_forum() {
	_deprecated_function( __FUNCTION__, '1.5' );
	$rss_feed = 'http://forums.appthemes.com/external.php?type=RSS2';
	wp_widget_rss_output( $rss_feed, array( 'items' => 5, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1 ) );
}


/**
 * tinyMCE text editor.
 *
 * @deprecated 1.5.1
 */
function clpr_tinymce( $width = 420, $height = 300 ) {
	_deprecated_function( __FUNCTION__, '1.5.1', 'wp_editor()' );

	return;
}

