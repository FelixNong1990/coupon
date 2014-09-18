<?php
/**
 * These are scripts used within the Clipper theme
 * To increase speed and performance, we only want to
 * load them when needed
 *
 * @package Clipper
 *
 */


// correctly load all the jquery scripts so they don't conflict with plugins
function clpr_load_scripts() {
	global $clpr_options;

	$protocol = is_ssl() ? 'https' : 'http';
	// load google cdn hosted libraries if enabled
	if ( $clpr_options->google_jquery ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', $protocol . '://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, '1.10.2' );
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-autocomplete' );

	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_script( 'jquery-ui-datepicker-lang' );

	wp_enqueue_script( 'jqueryeasing', get_template_directory_uri() . '/includes/js/easing.js', array( 'jquery' ), '1.3' );
	wp_enqueue_script( 'jcarousellite', get_template_directory_uri() . '/includes/js/jcarousellite.min.js', array( 'jquery' ), '1.8.5' );
	wp_enqueue_script( 'zeroclipboard', get_template_directory_uri() . '/includes/js/zeroclipboard/ZeroClipboard.min.js', array( 'jquery' ), '1.3.2' );
	wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/includes/js/theme-scripts.js', array( 'jquery', 'zeroclipboard' ), '1.5.1' );
	wp_enqueue_script( 'colorbox' );

	wp_enqueue_script( 'validate' );
	wp_enqueue_script( 'validate-lang' );

	// used to convert header menu into select list on mobile devices
	wp_enqueue_script( 'tinynav', get_template_directory_uri() . '/includes/js/jquery.tinynav.min.js', array( 'jquery' ), '1.1' );

	// used to transform tables on mobile devices
	wp_enqueue_script( 'footable' );

	// adds touch events to jQuery UI on mobile devices
	if ( wp_is_mobile() )
		wp_enqueue_script( 'jquery-touch-punch' );

	// only load the general.js if available in child theme
	if ( file_exists( get_stylesheet_directory() . '/general.js' ) )
		wp_enqueue_script( 'general', get_stylesheet_directory_uri() . '/general.js', array( 'jquery' ), '1.0' );

	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Script variables */
	$params = array(
		'app_tax_store' => APP_TAX_STORE,
		'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ),
		'templateurl' => get_template_directory_uri(),
		'is_mobile' => wp_is_mobile(),
		'text_copied' => __( 'Copied', APP_TD ),
		'text_mobile_navigation' => __( 'Navigation', APP_TD ),
		'text_before_delete_coupon' => __( 'Are you sure you want to delete this coupon?', APP_TD ),
		'text_sent_email' => __( 'Your email has been sent!', APP_TD ),
		'text_shared_email_success' => __( 'This coupon was successfully shared with', APP_TD ),
		'text_shared_email_failed' => __( 'There was a problem sharing this coupon with', APP_TD )
	);
	wp_localize_script( 'theme-scripts', 'clipper_params', $params );


	// enqueue reports scripts
	appthemes_reports_enqueue_scripts();

}
add_action( 'wp_enqueue_scripts', 'clpr_load_scripts' );


// load scripts required on coupon submission
function clpr_load_form_scripts() {

}


// load the css files correctly
function clpr_load_styles() {
	global $clpr_options;

	// Master (or child) Stylesheet
	wp_enqueue_style( 'at-main', get_stylesheet_uri() );

	// turn off stylesheets if customers want to use child themes
	if ( ! $clpr_options->disable_stylesheet ) {
		if ( $clpr_options->stylesheet ) {
			wp_enqueue_style( 'at-color', get_template_directory_uri() . '/styles/' . $clpr_options->stylesheet );
		} else {
			wp_enqueue_style( 'at-color', get_template_directory_uri() . '/styles/red.css' );
		}
	}

	// include the custom stylesheet
	if ( file_exists( get_stylesheet_directory() . '/styles/custom.css' ) )
		wp_enqueue_style( 'at-custom', get_stylesheet_directory_uri() . '/styles/custom.css' );

	wp_enqueue_style( 'colorbox' );

	wp_enqueue_style( 'jquery-ui-style' );

	// enqueue reports styles
	appthemes_reports_enqueue_styles();

}
add_action( 'wp_enqueue_scripts', 'clpr_load_styles' );

