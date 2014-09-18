<?php
/**
 * Custom theme site search engine
 *
 * @version 1.0
 * @author AppThemes
 * @package Clipper
 *
 */



// search on custom fields
function clpr_search_join( $join ) {
	global $wpdb, $wp_query;

	if ( is_search() && isset( $_GET['s'] ) ) {

		$join  = " INNER JOIN $wpdb->term_relationships AS r ON ($wpdb->posts.ID = r.object_id) ";
		$join .= " INNER JOIN $wpdb->term_taxonomy AS x ON (r.term_taxonomy_id = x.term_taxonomy_id) ";
		$join .= " AND (x.taxonomy = '".APP_TAX_TAG."' OR x.taxonomy = '".APP_TAX_CAT."' OR x.taxonomy = '".APP_TAX_STORE."' OR 1=1) "; // the custom taxonomies

		// if a single category is selected, limit results to that cat only
		$catid = $wp_query->query_vars['cat'];

		if ( ! empty( $catid ) ) :

			// put the catid into an array
			(array) $include_cats[] = $catid;

			// get all sub cats of catid and put them into the array
			$descendants = get_term_children( (int) $catid, $tax_cat );

			foreach( $descendants as $key => $value )
				$include_cats[] = $value;

			// take catids out of the array and separate with commas
			$include_cats = "'" . implode("', '", $include_cats) . "'";

			// add the category filter to show anything within this cat or it's children
			$join .= " AND x.term_id IN ($include_cats) ";

		endif; // end category filter


		$join .= " INNER JOIN $wpdb->postmeta AS m ON ($wpdb->posts.ID = m.post_id) ";
		$join .= " INNER JOIN $wpdb->terms AS t ON x.term_id = t.term_id ";

		remove_filter( 'posts_join', 'clpr_search_join' );
	}

	return $join;
}


// search on custom fields
function clpr_search_where( $where ) {
	global $wpdb, $wp_query, $clpr_options, $app_custom_fields;

	$old_where = $where; // intercept the old where statement

	if ( is_search() && isset( $_GET['s'] ) ) {

		// put the custom fields into an array
		$customs = array();
		$customs = $app_custom_fields;

		$query = '';

		$var_q = stripslashes($_GET['s']);

		//empty the s parameter if set to default search text
		if ( __( 'Search for coupon codes', APP_TD ) == $var_q )
			$var_q = '';


		if ( isset( $_GET['sentence'] ) || $var_q == '' ) {
			$search_terms = array( $var_q );
		} else {
			preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $var_q, $matches);
			$search_terms = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
		}

		$n = isset( $_GET['exact'] ) ? '' : '%';
		$searchand = '';

		foreach( (array)$search_terms as $term ) {
			$term = addslashes_gpc($term);

			$query .= "{$searchand}(";
			$query .= "($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
			$query .= " OR ($wpdb->posts.post_content LIKE '{$n}{$term}{$n}')";
			$query .= " OR ((t.name LIKE '{$n}{$term}{$n}')) OR ((t.slug LIKE '{$n}{$term}{$n}'))";

// disable meta search as we will not find anything usefull there
//			foreach($customs as $custom) {
//				$query .= " OR (";
//				$query .= "(m.meta_key = '$custom')";
//				$query .= " AND (m.meta_value  LIKE '{$n}{$term}{$n}')";
//				$query .= ")";
//			}

			$query .= ")";
			$searchand = ' AND ';
		}

		$term = esc_sql( $var_q );
		if ( ! isset( $_GET['sentence'] ) && count( $search_terms ) > 1 && $search_terms[0] != $var_q ) {
			$query .= " OR ($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
			$query .= " OR ($wpdb->posts.post_content LIKE '{$n}{$term}{$n}')";
		}

		if ( ! empty( $query ) ) {

			$where = " AND ({$query}) AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'unreliable') ";

			// setup the array for post types
			$post_type_array = array();

			// always include the custom post type
			$post_type_array[] = APP_POST_TYPE;

			// check to see if we include blog posts
			if ( ! $clpr_options->search_ex_blog )
				$post_type_array[] = 'post';

			// check to see if we include pages
			if ( ! $clpr_options->search_ex_pages )
				$post_type_array[] = 'page';

			// build the post type filter sql from the array values
			$post_type_filter = "'" . implode("','",$post_type_array). "'";

			// return the post type sql to complete the where clause
			$where .= " AND ($wpdb->posts.post_type IN ($post_type_filter)) ";

		}

		remove_filter( 'posts_where', 'clpr_search_where' );
	}

	return $where;
}


// connect the custom search by groupby
function clpr_search_groupby( $groupby ) {
	global $wpdb, $wp_query;

	if ( is_search() && isset( $_GET['s'] ) ) {
		$groupby = "$wpdb->posts.ID";

		remove_filter( 'posts_groupby', 'clpr_search_groupby' );
	}

	return $groupby;
}


// load filters only on frontend
if ( ! is_admin() ) {
	add_filter( 'posts_join', 'clpr_search_join' );
	add_filter( 'posts_where', 'clpr_search_where' );
	add_filter( 'posts_groupby', 'clpr_search_groupby' );
}


