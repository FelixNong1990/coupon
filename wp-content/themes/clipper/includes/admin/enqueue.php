<?php
/**
 * These are scripts used within the AppThemes admin pages
 *
 * @package AppThemes
 *
 */


// correctly load all the scripts so they don't conflict with plugins
function app_load_admin_scripts() {
	global $pagenow, $is_IE;

	wp_enqueue_style( 'thickbox' ); // needed for image upload

	wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/includes/admin/admin-scripts.js', array( 'jquery', 'media-upload', 'thickbox', 'jquery-ui-datepicker' ), '1.5' );

	if ( $is_IE ) // only load this support js when browser is IE
		wp_enqueue_script( 'excanvas', get_template_directory_uri() . '/includes/js/flot/excanvas.min.js', array( 'jquery' ), '0.8.1' );

	wp_enqueue_script( 'flot', get_template_directory_uri() . '/includes/js/flot/jquery.flot.min.js', array( 'jquery' ), '0.8.1' );
	wp_enqueue_script( 'flot-time', get_template_directory_uri() . '/includes/js/flot/jquery.flot.time.min.js', array( 'jquery', 'flot' ), '0.8.1' );


	/* Script variables */
	$params = array(
		'text_before_delete_tables' => __( 'WARNING: You are about to completely delete all Clipper database tables. Are you sure you want to proceed? (This cannot be undone)', APP_TD ),
		'text_before_delete_options' => __( 'WARNING: You are about to completely delete all Clipper configuration options from the wp_options database table. Are you sure you want to proceed? (This cannot be undone)', APP_TD ),
	);
	wp_localize_script( 'admin-scripts', 'clipper_admin_params', $params );


	wp_enqueue_style( 'jquery-ui-style' );

	// script for quick edit stores
	if ( $pagenow == 'edit-tags.php' && ( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == APP_TAX_STORE ) && ! isset( $_GET['action'] ) ) {
		wp_enqueue_script( 'quick-edit-stores-js', get_template_directory_uri() . '/includes/js/quick-edit-stores.js', array( 'jquery' ), '1.5' );
	}

}
add_action( 'admin_enqueue_scripts', 'app_load_admin_scripts' );

