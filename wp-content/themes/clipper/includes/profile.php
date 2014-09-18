<?php
/**
 * Add more profile fields to the user
 *
 * Easy to add new fields to the user profile by just
 * creating your new section below and adding a new
 * update_user_meta line
 *
 * @since 1.0
 * @uses show_user_profile & edit_user_profile WordPress functions
 *
 * @param int $user User Object
 * @return bool True on successful update, false on failure.
 *
 */
function clpr_user_contact_methods( $methods ) {
	return array(
		'twitter_id' => __( 'Twitter', APP_TD ),
		'facebook_id' => __( 'Facebook', APP_TD ),
	);
}
add_action( 'user_contactmethods', 'clpr_user_contact_methods' );

function clpr_profile_fields_description( $field ) {
	$description = array(
		'twitter_id' => __( 'Enter your Twitter username without the URL.', APP_TD ),
		'facebook_id' => sprintf( __( "Enter your Facebook username without the URL. <br />Don't have one yet? <a target='_blank' href='%s'>Get a custom URL.</a>", APP_TD ), 'http://www.facebook.com/username/' ),
	);
	return isset( $description[ $field ] ) ? '<span class="description">' . $description[ $field ] . '</span>' : '';
}

