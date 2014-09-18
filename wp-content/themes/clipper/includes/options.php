<?php

$GLOBALS['clpr_options'] = new scbOptions( 'clpr_options', false, array(
	// Site Configuration
	'stylesheet' => 'red.css',
	'featured_slider' => 1,
	'use_logo' => 1,
	'logo_url' => '',
	'favicon_url' => '',
	'feedburner_url' => '',
	'twitter_id' => '',
	'facebook_id' => '',
	'google_analytics' => '',

	// Search Settings
	'search_stats' => 1,
	'search_ex_pages' => 1,
	'search_ex_blog' => 1,

	// Coupons Configuration
	'coupons_require_moderation' => 1,
	'stores_require_moderation' => 0,
	'prune_coupons' => 0,
	'reg_required' => 0,
	'coupon_edit' => 1,
	'coupon_code_hide' => 0,
	'exclude_unreliable' => 0,
	'link_single_page' => 1,
	'cloak_links' => 1,
	'allow_html' => 0,
	'stats_all' => 1,
	'submit_file_types' => 'png,gif,jpg,jpeg',

	// Pricing Options
	'charge_coupons' => 0,
	'coupon_price' => 5,
	'num_images' => 3,
	'max_image_size' => 1024,

	// Security Settings
	'admin_security' => 'read',

	// reCaptcha Settings
	'captcha_enable' => 0,
	'captcha_public_key' => '',
	'captcha_private_key' => '',
	'captcha_theme' => 'red',

	// Report Coupon Settings
	'reports' => array(
		'post_options' =>
			__( 'Invalid Coupon Code', APP_TD ) . "\n" .
			__( 'Expired Coupon', APP_TD ) . "\n" .
			__( 'Offensive Content', APP_TD ) . "\n" .
			__( 'Invalid Link', APP_TD ) . "\n" .
			__( 'Spam', APP_TD ) . "\n" .
			__( 'Other', APP_TD ),
		'user_options' => '',
		'users_only' => 0,
		'send_email' => 1,
	),

	// Ad (336x280)
	'adcode_336x280_enable' => 0,
	'adcode_336x280' => '',
	'adcode_336x280_url' => '',
	'adcode_336x280_dest' => '',

	// Advanced Options
	'disable_stylesheet' => 0,
	'debug_mode' => 0,
	'google_jquery' => 0,
	'disable_wp_login' => 0,
	'remove_wp_generator' => 0,
	'remove_admin_bar' => 0,

	// Custom Post Type & Taxonomy URLs
	'coupon_permalink' => 'coupon',
	'coupon_cat_tax_permalink' => 'coupon-category',
	'coupon_store_tax_permalink' => 'store',
	'coupon_type_tax_permalink' => 'coupon-type',
	'coupon_tag_tax_permalink' => 'coupon-tag',
	'coupon_image_tax_permalink' => 'coupon-image',

	// Store & Coupon Redirect URLs
	'coupon_redirect_base_url' => 'go',
	'store_redirect_base_url' => 'go-store',

	// Email Notifications
	'new_ad_email' => 1,
	'rp_send_email' => 1,
	'prune_coupons_email' => 0,
	'nu_admin_email' => 0,

	// New User Registration Email
	'nu_custom_email' => 0,
	'nu_from_name' => get_option( 'blogname' ),
	'nu_from_email' => get_option( 'admin_email' ),
	'nu_email_subject' => sprintf( __( 'Thank you for registering, %s', APP_TD ), '%username%' ),
	'nu_email_type' => 'text/plain',
	'nu_email_body' => 
		sprintf( __( 'Hi %s,', APP_TD ), '%username%' ) . PHP_EOL . PHP_EOL .
		sprintf( __( 'Welcome to %s!', APP_TD ), '%blogname%' ) . PHP_EOL . PHP_EOL .
		__( 'Below you will find your username and password which allows you to login to your user account.', APP_TD ) . PHP_EOL . PHP_EOL .
		'--------------------------' . PHP_EOL .
		sprintf( __( 'Username: %s', APP_TD ), '%username%' ) . PHP_EOL .
		sprintf( __( 'Password: %s', APP_TD ), '%password%' ) . PHP_EOL .
		'%loginurl%' . PHP_EOL .
		'--------------------------' . PHP_EOL . PHP_EOL .
		__( 'If you have any questions, please just let us know.', APP_TD ) . PHP_EOL . PHP_EOL .
		__( 'Best regards,', APP_TD ) . PHP_EOL .
		sprintf( __( 'Your %s Team', APP_TD ), '%blogname%' ) . PHP_EOL .
		'%siteurl%',

	// New Coupon Submission Email
	'nc_custom_email' => 1,
	'nc_from_name' => get_option( 'blogname' ),
	'nc_from_email' => get_option( 'admin_email' ),
	'nc_email_subject' => sprintf( __( 'Your coupon submission on %s', APP_TD ), '%blogname%' ),
	'nc_email_type' => 'text/plain',
	'nc_email_body' => 
		sprintf( __( 'Hi %s,', APP_TD ), '%username%' ) . PHP_EOL . PHP_EOL .
		__( 'Thank you for your recent submission.', APP_TD ) . ' ' .
		__( 'Your coupon has been received and will not appear live on our site until it has been approved.', APP_TD ) . ' ' .
		__( 'Below you will find a summary of your submission.', APP_TD ) . PHP_EOL . PHP_EOL .
		__( 'Coupon Details', APP_TD ) . PHP_EOL . PHP_EOL .
		'--------------------------' . PHP_EOL .
		sprintf( __( 'Title: %s', APP_TD ), '%title%' ) . PHP_EOL .
		sprintf( __( 'Coupon Code: %s', APP_TD ), '%code%' ) . PHP_EOL .
		sprintf( __( 'Category: %s', APP_TD ), '%category%' ) . PHP_EOL .
		sprintf( __( 'Store: %s', APP_TD ), '%store%' ) . PHP_EOL .
		sprintf( __( 'Description: %s', APP_TD ), '%description%' ) . PHP_EOL .
		'--------------------------' . PHP_EOL . PHP_EOL .
		__( 'You may check the status of your coupon(s) at anytime by logging into your dashboard.', APP_TD ) . PHP_EOL .
		'%dashurl%' . PHP_EOL . PHP_EOL .
		__( 'Best regards,', APP_TD ) . PHP_EOL .
		sprintf( __( 'Your %s Team', APP_TD ), '%blogname%' ) . PHP_EOL .
		'%siteurl%',

	// Payments & Gateways
	'currency_code' => 'USD',
	'currency_identifier' => 'symbol',
	'currency_position' => 'left',
	'thousands_separator' => ',',
	'decimal_separator' => '.',
	'tax_charge' => 0,
	'gateways' => array(
		'enabled' => array(),
	),

) );

