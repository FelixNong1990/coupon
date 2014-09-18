<?php

/**
 * Note:
 * These functions register and enqueue the default scripts and styles for the Reports component 
 * Each theme should manually hook into these functions as needed to avoid enqueing on every page
 */

/**
 * Registers and enqueues the default scripts
 */
function appthemes_reports_enqueue_scripts() {

	wp_enqueue_script( 'app-reports', get_template_directory_uri() . '/includes/reports/scripts/reports.js', array( 'jquery' ), APP_REPORTS_VERSION, true );

	wp_localize_script( 'app-reports', 'app_reports', array(
		'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ),
		'images_url' => get_template_directory_uri() . '/includes/reports/images/',
	) );

}

/**
 * Registers and enqueue the default styles
 */
function appthemes_reports_enqueue_styles() {

	wp_enqueue_style( 'app-reports', get_template_directory_uri() . '/includes/reports/style.css', null, APP_REPORTS_VERSION );
}

