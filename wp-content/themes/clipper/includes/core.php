<?php

/**
 * Register custom post type and post status for coupons
 */
function clpr_register_post_types() {
	global $clpr_options;

	// register post type for coupons
	$labels = array(
		'name' => __( 'Coupons', APP_TD ),
		'singular_name' => __( 'Coupon', APP_TD ),
		'add_new' => __( 'Add New', APP_TD ),
		'add_new_item' => __( 'Add New Coupon', APP_TD ),
		'edit' => __( 'Edit', APP_TD ),
		'edit_item' => __( 'Edit Coupon', APP_TD ),
		'new_item' => __( 'New Coupon', APP_TD ),
		'view' => __( 'View Coupons', APP_TD ),
		'view_item' => __( 'View Coupon', APP_TD ),
		'search_items' => __( 'Search Coupons', APP_TD ),
		'not_found' => __( 'No coupons found', APP_TD ),
		'not_found_in_trash' => __( 'No coupons found in trash', APP_TD ),
		'parent' => __( 'Parent Coupon', APP_TD ),
	);

	$args = array(
		'labels' => $labels,
		'description' => __( 'This is where you can create new coupon listings on your site.', APP_TD ),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 8,
		'menu_icon' => appthemes_locate_template_uri( 'images/menu.png' ),
		'hierarchical' => false,
		'rewrite' => array( 'slug' => $clpr_options->coupon_permalink, 'with_front' => false ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky' ),
	);

	register_post_type( APP_POST_TYPE, $args );

	// register post status for unreliable coupons
	$status_args = array(
		'label' => __( 'Unreliable', APP_TD ),
		'label_count' => _n_noop( 'Unreliable <span class="count">(%s)</span>', 'Unreliable <span class="count">(%s)</span>', APP_TD ),
		'public' => true,
		'_builtin' => true,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
		'capability_type' => APP_POST_TYPE,
	);

	register_post_status( 'unreliable', $status_args );

}
add_action( 'init', 'clpr_register_post_types', 9 );


/**
 * Register taxonomies for coupons
 */
function clpr_register_taxonomies() {
	global $clpr_options;

	// register the category taxonomy for coupons
	$labels = array(
		'name' => __( 'Categories', APP_TD ),
		'singular_name' => __( 'Coupon Category', APP_TD ),
		'search_items' =>  __( 'Search Coupon Categories', APP_TD ),
		'all_items' => __( 'All Coupon Categories', APP_TD ),
		'parent_item' => __( 'Parent Coupon Category', APP_TD ),
		'parent_item_colon' => __( 'Parent Coupon Category:', APP_TD ),
		'edit_item' => __( 'Edit Coupon Category', APP_TD ),
		'update_item' => __( 'Update Coupon Category', APP_TD ),
		'add_new_item' => __( 'Add New Coupon Category', APP_TD ),
		'new_item_name' => __( 'New Coupon Category Name', APP_TD ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'show_ui' => true,
		'query_var' => true,
		'update_count_callback' => '_update_post_term_count',
		'rewrite' => array( 'slug' => $clpr_options->coupon_cat_tax_permalink, 'with_front' => false, 'hierarchical' => true ),
	);

	register_taxonomy( APP_TAX_CAT, APP_POST_TYPE, $args );

	// register the tag taxonomy for coupons
	$labels = array(
		'name' => __( 'Coupon Tags', APP_TD ),
		'singular_name' => __( 'Coupon Tag', APP_TD ),
		'search_items' =>  __( 'Search Coupon Tags', APP_TD ),
		'all_items' => __( 'All Coupon Tags', APP_TD ),
		'edit_item' => __( 'Edit Coupon Tag', APP_TD ),
		'update_item' => __( 'Update Coupon Tag', APP_TD ),
		'add_new_item' => __( 'Add New Coupon Tag', APP_TD ),
		'add_or_remove_items' => __( 'Add or remove Coupon Tags', APP_TD ),
		'separate_items_with_commas' => __( 'Separate Coupon Tags with commas', APP_TD ),
		'choose_from_most_used' => __( 'Choose from the most common Coupon Tags', APP_TD ),
		'new_item_name' => __( 'New Coupon Tag Name', APP_TD ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'show_ui' => true,
		'query_var' => true,
		'update_count_callback' => '_update_post_term_count',
		'rewrite' => array( 'slug' => $clpr_options->coupon_tag_tax_permalink, 'with_front' => false, 'hierarchical' => true ),
	);

	register_taxonomy( APP_TAX_TAG, APP_POST_TYPE, $args );

	// register the store taxonomy for coupons
	$labels = array(
		'name' => __( 'Stores', APP_TD ),
		'singular_name' => __( 'Store', APP_TD ),
		'search_items' =>  __( 'Search Stores', APP_TD ),
		'all_items' => __( 'All Stores', APP_TD ),
		'edit_item' => __( 'Edit Store', APP_TD ),
		'update_item' => __( 'Update Store', APP_TD ),
		'add_new_item' => __( 'Add New Store', APP_TD ),
		'add_or_remove_items' => __( 'Add or remove Stores', APP_TD ),
		'separate_items_with_commas' => __( 'Separate Stores with commas', APP_TD ),
		'choose_from_most_used' => __( 'Choose from the most common Stores', APP_TD ),
		'new_item_name' => __( 'New Store Name', APP_TD ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'show_ui' => true,
		'query_var' => true,
		'update_count_callback' => '_update_post_term_count',
		'rewrite' => array( 'slug' => $clpr_options->coupon_store_tax_permalink, 'with_front' => false, 'hierarchical' => true ),
	);

	register_taxonomy( APP_TAX_STORE, APP_POST_TYPE, $args );

	// register the type taxonomy for coupons
	$labels = array(
		'name' => __( 'Coupon Types', APP_TD ),
		'singular_name' => __( 'Coupon Type', APP_TD ),
		'search_items' =>  __( 'Search Coupon Types', APP_TD ),
		'all_items' => __( 'All Coupon Types', APP_TD ),
		'parent_item' => __( 'Parent Coupon Type', APP_TD ),
		'parent_item_colon' => __( 'Parent Coupon Type:', APP_TD ),
		'edit_item' => __( 'Edit Coupon Type', APP_TD ),
		'update_item' => __( 'Update Coupon Type', APP_TD ),
		'add_new_item' => __( 'Add New Coupon Type', APP_TD ),
		'new_item_name' => __( 'New Coupon Type Name', APP_TD ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'show_ui' => true,
		'query_var' => true,
		'update_count_callback' => '_update_post_term_count',
		'rewrite' => array( 'slug' => $clpr_options->coupon_type_tax_permalink, 'with_front' => false, 'hierarchical' => true ),
	);

	register_taxonomy( APP_TAX_TYPE, APP_POST_TYPE, $args );

	// register taxonomy for printable coupon images
	$labels = array(
		'name' => __( 'Coupon Images', APP_TD ),
		'singular_name' => __( 'Coupon Image', APP_TD ),
		'search_items' =>  __( 'Search Coupon Images', APP_TD ),
		'all_items' => __( 'All Coupon Images', APP_TD ),
		'parent_item' => __( 'Parent Coupon Image', APP_TD ),
		'parent_item_colon' => __( 'Parent Coupon Image:', APP_TD ),
		'edit_item' => __( 'Edit Coupon Image', APP_TD ),
		'update_item' => __( 'Update Coupon Image', APP_TD ),
		'add_new_item' => __( 'Add New Coupon Image', APP_TD ),
		'new_item_name' => __( 'New Coupon Image Name', APP_TD ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'public' => false,
		'show_ui' => false,
		'query_var' => true,
		'update_count_callback' => '_update_post_term_count',
		'rewrite' => array( 'slug' => $clpr_options->coupon_image_tax_permalink, 'with_front' => false, 'hierarchical' => false ),
	);

	register_taxonomy( APP_TAX_IMAGE, 'attachment', $args );

}
add_action( 'init', 'clpr_register_taxonomies', 8 );


/**
 * Register menus
 */
function clpr_register_menus() {

	register_nav_menu( 'primary', __( 'Primary Navigation', APP_TD ) );
	register_nav_menu( 'secondary', __( 'Footer Navigation', APP_TD ) );

}
add_action( 'after_setup_theme', 'clpr_register_menus' );


/**
 * Register sidebars
 */
function clpr_register_sidebars() {

	// Home Page
	register_sidebar( array(
		'name' => __( 'Home Page Sidebar', APP_TD ),
		'id' => 'sidebar_home',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="customclass"></div><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// Page
	register_sidebar( array(
		'name' => __( 'Page Sidebar', APP_TD ),
		'id' => 'sidebar_page',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// Blog
	register_sidebar( array(
		'name' => __( 'Blog Sidebar', APP_TD ),
		'id' => 'sidebar_blog',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// Coupon
	register_sidebar( array(
		'name' => __( 'Coupon Sidebar', APP_TD ),
		'id' => 'sidebar_coupon',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// Store
	register_sidebar( array(
		'name' => __( 'Store Sidebar', APP_TD ),
		'id' => 'sidebar_store',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// Submit Coupon Page
	register_sidebar( array(
		'name' => __( 'Submit Coupon Sidebar', APP_TD ),
		'id' => 'sidebar_submit',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// Login Pages
	register_sidebar( array(
		'name' => __( 'Login Sidebar', APP_TD ),
		'id' => 'sidebar_login',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// User
	register_sidebar( array(
		'name' => __( 'User Sidebar', APP_TD ),
		'id' => 'sidebar_user',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebox %2$s"><div class="sidebox-content">',
		'after_widget' => '</div><br clear="all" /><div class="sb-bottom"></div></div>',
		'before_title' => '<div class="sidebox-heading"><h2>',
		'after_title' => '</h2></div>',
	) );

	// Footer
	register_sidebar( array(
		'name' => __( 'Footer', APP_TD ),
		'id' => 'sidebar_footer',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="box customclass %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );

}
add_action( 'after_setup_theme', 'clpr_register_sidebars' );

