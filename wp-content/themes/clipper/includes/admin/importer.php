<?php

class CLPR_Importer extends APP_Importer {

	function setup() {
		parent::setup();

		$this->args['admin_action_priority'] = 11;
		add_filter( 'appthemes_importer_import_row_data', array( $this, 'prevent_duplicate' ), 10, 1 );
	}

	function prevent_duplicate( $data ) {
		if ( ! empty( $data['post_meta']['clpr_id'] ) ) {
			if ( clpr_get_listing_by_ref( $data['post_meta']['clpr_id'] ) ) {
				return false;
			}
		}

		return $data;
	}

}


function clpr_csv_importer() {
	$fields = array(
		'coupon_title'       => 'post_title',
		'coupon_description' => 'post_content',
		'coupon_excerpt'     => 'post_excerpt',
		'coupon_status'      => 'post_status',
		'author'             => 'post_author',
		'date'               => 'post_date',
		'slug'               => 'post_name'
	);

	$args = array(
		'taxonomies'     => array( 'coupon_category', 'coupon_tag', 'coupon_type', 'stores' ),

		'custom_fields'  => array(
			'coupon_code'        => 'clpr_coupon_code',
			'expire_date'        => 'clpr_expire_date',
			'print_url'          => 'clpr_print_url',
			'id'                 => 'clpr_id',
			'coupon_aff_url'     => 'clpr_coupon_aff_url',
			'clpr_votes_down'    => array( 'default' => '0' ),
			'clpr_votes_up'      => array( 'default' => '0' ),
			'clpr_votes_percent' => array( 'default' => '100' )
		),

		'tax_meta' => array(
			'stores' => array(
				'store_aff_url' => 'clpr_store_aff_url',
				'store_url'     => 'clpr_store_url',
				'store_desc'    => 'clpr_store_desc',
			)
		)
	);

	$args = apply_filters( 'clpr_csv_importer_args', $args );

	appthemes_add_instance( array( 'CLPR_Importer' => array( 'coupon', $fields, $args ) ) );
}
add_action( 'wp_loaded', 'clpr_csv_importer' );

