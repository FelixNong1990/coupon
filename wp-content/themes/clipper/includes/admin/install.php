<?php
/**
 * Install script to insert default data.
 * Only run if theme is being activated
 *
 */


function clpr_install_theme() {

	// run the table install script
	clpr_tables_install();

	// insert the default values
	clpr_default_values();

	// create pages and assign templates
	clpr_create_pages();

	// create the default taxonomies
	clpr_create_taxonomies();

	// create the first default coupon
	clpr_first_coupon();

	// insert the default menu container
	app_create_default_menu();

	// assign default widgets to sidebars
	clpr_default_widgets();

	// flush the rewrite rules
	flush_rewrite_rules();

	// if fresh install, setup current database version, and do not process update
	if ( get_option( 'clpr_db_version' ) == false ) {

		// set blog and ads pages
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', CLPR_Coupons_Home::get_id() );
		update_option( 'page_for_posts', CLPR_Blog_Archive::get_id() );

		update_option( 'clpr_db_version', CLPR_DB_VERSION );
	}

}
add_action( 'appthemes_first_run', 'clpr_install_theme' );



// Create the theme database tables
function clpr_tables_install() {


	// create the recent search terms table

		$sql = "
					id int(11) NOT NULL AUTO_INCREMENT,
					terms varchar(50) NOT NULL,
					datetime datetime NOT NULL,
					hits int(11) NOT NULL,
					details text NOT NULL,
					PRIMARY KEY  (id),
					KEY datetimeindex (datetime)";

	scb_install_table( 'clpr_search_recent', $sql );


	// create the total search terms table

		$sql = "
					id int(11) NOT NULL AUTO_INCREMENT,
					terms varchar(50) NOT NULL,
					date date NOT NULL,
					count int(11) NOT NULL,
					last_hits int(11) NOT NULL,
					status tinyint(1) NOT NULL DEFAULT '0',
					PRIMARY KEY  (id,date)";

	scb_install_table( 'clpr_search_total', $sql );


	// create the meta table for the custom stores taxonomy

		$sql = "
					meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					stores_id bigint(20) unsigned NOT NULL default '0',
					meta_key varchar(255) DEFAULT NULL,
					meta_value longtext,
					PRIMARY KEY  (meta_id),
					KEY stores_id (stores_id),
					KEY meta_key (meta_key)";

	scb_install_table( 'clpr_storesmeta', $sql );


	// create the votes total table

		$sql = "
					id int(11) NOT NULL AUTO_INCREMENT,
					post_id int(11) NOT NULL,
					user_id int(11) NOT NULL,
					vote int(4) NOT NULL,
					ip_address varchar(15) NOT NULL,
					date_stamp datetime NOT NULL,
					PRIMARY KEY  (id)";

	scb_install_table( 'clpr_votes', $sql );


	// create the votes total table

		$sql = "
					id int(11) NOT NULL AUTO_INCREMENT,
					post_id int(11) NOT NULL,
					votes_up int(11) NOT NULL DEFAULT '0',
					votes_down int(11) NOT NULL DEFAULT '0',
					votes_total int(11) NOT NULL DEFAULT '0',
					last_update datetime NOT NULL,
					PRIMARY KEY  (id)";

	scb_install_table( 'clpr_votes_total', $sql );


}


function clpr_default_values() {

	// set the default new WP user role only if it's currently subscriber
	if ( get_option('default_role') == 'subscriber' )
		update_option('default_role', 'contributor');

	// check the "membership" box to enable wordpress registration
	if ( get_option('users_can_register') == 0 )
		update_option('users_can_register', 1);

}


// Create the Clipper pages and assign the templates to them
function clpr_create_pages() {
	global $wpdb;

	// About page
	// first check and make sure this page doesn't already exist
	$sql = "SELECT ID FROM $wpdb->posts WHERE post_name = %s LIMIT 1";
	$pagefound = $wpdb->get_var( $wpdb->prepare($sql, 'about') );

	if ( $wpdb->num_rows == 0 ) {

		// then create the edit item page
		$my_page = array(
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_author' => 1,
			'post_name' => 'about',
			'post_title' => 'About',
		);

		// Insert the page into the database
		$page_id = wp_insert_post($my_page);

	}

}


// create coupon types, coupon category, coupon tags, and store default values
function clpr_create_taxonomies() {

	// create coupon types
	$coupon_types = array(
		'Coupon Code',
		'Printable Coupon',
		'Promotion',
	);

	foreach( $coupon_types as $type ) {
		if ( ! $type_id = get_term_by( 'slug', sanitize_title( $type ), APP_TAX_TYPE ) )
			$ins_id = wp_insert_term( $type, APP_TAX_TYPE );
	}


	// create term for printable coupon images
	$image_tax = array(
		'slug' => 'printable-coupon',
	);
	if ( ! get_term_by( 'slug', 'printable-coupon', APP_TAX_IMAGE ) )
		wp_insert_term( 'Printable Coupon', APP_TAX_IMAGE, $image_tax );

}


// create a default coupon for demo purposes
function clpr_first_coupon() {

	$posts = get_posts( array( 'posts_per_page' => 1, 'post_type' => APP_POST_TYPE, 'no_found_rows' => true ) );

	if ( ! empty( $posts ) )
		return;

	$data = array(
		'post_title' => '10% Off Amazon',
		'post_content' => '<p>Great coupon from Amazon.com that gives 10% off any purchase. Can be used multiple times so make sure to take advantage of this deal often.</p><p>This is the default coupon created when Clipper is first installed. It is for demonstration purposes only and is not actually a 10% off Amazon.com coupon.</p>',
		'post_status' => 'publish',
		'post_author' => 1,
		'post_type' => APP_POST_TYPE,
	);

	$post_id = wp_insert_post( $data );

	if ( $post_id == 0 || is_wp_error( $post_id ) )
		return;

	// add meta data and category
	add_post_meta( $post_id, 'clpr_coupon_code', 'AMAZON10', true );
	add_post_meta( $post_id, 'clpr_expire_date', '2015-05-30', true );
	add_post_meta( $post_id, 'clpr_coupon_aff_url', 'http://www.amazon.com/?tag=20-ebt', true );
	add_post_meta( $post_id, 'clpr_votes_percent', '100', true );

	// give it an id number
	$clpr_item_id = clpr_generate_id();
	add_post_meta( $post_id, 'clpr_id', $clpr_item_id, true );

	// set the default coupon type
	wp_set_object_terms( $post_id, 'coupon-code', APP_TAX_TYPE, false );

	// set the default store taxonomy
	$store = appthemes_maybe_insert_term( 'Amazon.com', APP_TAX_STORE );
	clpr_update_store_meta( $store['term_id'], 'clpr_store_url', 'http://www.amazon.com' );
	wp_set_object_terms( $post_id, $store['term_id'], APP_TAX_STORE, false );

	// set the default category taxonomy
	wp_set_object_terms( $post_id, 'Electronics', APP_TAX_CAT, false );

	// set some default tags
	wp_set_object_terms( $post_id, array( 'Books', 'Online Store', 'Electronics' ), APP_TAX_TAG );

}

function app_create_default_menu() {

	$menus = array(
		'primary' => __( 'Header', APP_TD ),
		'secondary' => __( 'Footer', APP_TD ),
	);

	foreach( $menus as $location => $name ) {

		if ( has_nav_menu( $location ) )
			continue;

		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) )
			continue;

		wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title' => __( 'Home', APP_TD ),
				'menu-item-url' => home_url( '/' ),
				'menu-item-status' => 'publish',
		) );

		$page_ids = array(
			CLPR_Coupon_Submit::get_id(),
			CLPR_Coupon_Stores::get_id(),
			CLPR_Coupon_Categories::get_id(),
			CLPR_Blog_Archive::get_id(),
		);

		foreach ( $page_ids as $page_id ) {
			$page = get_post( $page_id );

			if ( ! $page )
				continue;

			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-type' => 'post_type',
				'menu-item-object' => 'page',
				'menu-item-object-id' => $page_id,
				'menu-item-title' => $page->post_title,
				'menu-item-url' => get_permalink( $page ),
				'menu-item-status' => 'publish',
			) );
		}

		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations[ $location ] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

}


function clpr_default_widgets() {
	list( $args ) = get_theme_support( 'app-versions' );

	if ( ! get_option( $args['option_key'] ) && $args['current_version'] == get_transient( APP_UPDATE_TRANSIENT ) ) {
	
		$sidebars_widgets = array(
			// Homepage
			'sidebar_home' => array(
				'custom-coupons' => array(
					'title' => __( 'Top Coupons', APP_TD ),
					'count' => 10,
				),
				'appthemes_facebook' => array(
					'title' => __( 'Facebook Friends', APP_TD ),
					'fid' => '137589686255438',
					'connections' => 8,
					'width' => 268,
					'height' => 290,
				),
			),
			// Page
			'sidebar_page' => array(
				'appthemes_facebook' => array(
					'title' => __( 'Facebook Friends', APP_TD ),
					'fid' => '137589686255438',
					'connections' => 8,
					'width' => 268,
					'height' => 290,
				),
				'rss' => array(
					'title' => __( 'AppThemes Blog', APP_TD ),
					'url' => 'http://feeds.feedburner.com/appthemes',
					'show_date' => 1,
					'items' => 5,
				),
			),
			// Blog
			'sidebar_blog' => array(
				'archives' => array(
					'title' => __( 'Archives', APP_TD ),
				),
				'rss' => array(
					'title' => __( 'AppThemes Blog', APP_TD ),
					'url' => 'http://feeds.feedburner.com/appthemes',
					'show_date' => 1,
					'items' => 5,
				),
			),
			// Coupon
			'sidebar_coupon' => array(
				'coupon-cats' => array(
					'title' => __( 'Coupon Categories', APP_TD ),
				),
				'popular-searches' => array(
					'title' => __( 'Popular Searches', APP_TD ),
					'count' => 10,
				),
				'custom-coupons' => array(
					'title' => __( 'Popular Coupons', APP_TD ),
					'count' => 10,
				),
			),
			// Store
			'sidebar_store' => array(
				'appthemes_facebook' => array(
					'title' => __( 'Facebook Friends', APP_TD ),
					'fid' => '137589686255438',
					'connections' => 8,
					'width' => 268,
					'height' => 290,
				),
				'custom-stores' => array(
					'title' => __( 'Popular Stores', APP_TD ),
					'number' => 10,
				),
				'tag_cloud' => array(
					'title' => __( 'Tags', APP_TD ),
					'taxonomy' => 'coupon_tag',
				),
			),
			// Submit
			'sidebar_submit' => array(
				'coupon-cats' => array(
					'title' => __( 'Coupon Categories', APP_TD ),
				),
				'custom-stores' => array(
					'title' => __( 'Popular Stores', APP_TD ),
					'number' => 10,
				),
			),
			// Login
			'sidebar_login' => array(),
			// User
			'sidebar_user' => array(),
			// Footer
			'sidebar_footer' => array(
				'coupon-cats' => array(
					'title' => __( 'Categories', APP_TD ),
				),
				'custom-stores' => array(
					'title' => __( 'Stores', APP_TD ),
					'number' => 10,
				),
				'coupon_tag_cloud' => array(
					'title' => __( 'Tags', APP_TD ),
					'taxonomy' => 'coupon_tag',
				),
			),
		);

		appthemes_install_widgets( $sidebars_widgets );

	}

}

