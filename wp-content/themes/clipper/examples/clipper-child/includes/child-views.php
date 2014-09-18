<?php

class Child_Featured_Coupons_Home extends APP_View_Page {

	function __construct() {
		parent::__construct( 'tpl-featured-coupons-home.php', __( 'Featured Coupons', APP_TD ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}

	function template_redirect() {
		global $wp_query;

		// if page on front, set back paged parameter
		if ( self::get_id() == get_option('page_on_front') ) {
			$paged = get_query_var('page');
			$wp_query->set( 'paged', $paged );
		}

	}
}

