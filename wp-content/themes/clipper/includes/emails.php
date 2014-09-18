<?php
/**
 *
 * Emails that get called and sent out
 * @author AppThemes
 * @version 1.0
 * For wp_mail to work, you need the following:
 * settings SMTP and smtp_port need to be set in your php.ini
 * also, either set the sendmail_from setting in php.ini, or pass it as an additional header.
 *
 */


// send new coupon notification email to admin
function app_new_submission_email( $post_id ) {

	// get the post values
	$post = get_post( $post_id );
	if ( ! $post )
		return;

	$category = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_CAT, 'name' );
	$store = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_STORE, 'name' );
	$coupon_code = get_post_meta( $post->ID, 'clpr_coupon_code', true );

	$the_author = stripslashes( clpr_get_user_name( $post->post_author ) );
	$the_content = appthemes_filter( stripslashes( $post->post_content ) );
	$the_content = mb_substr( $the_content, 0, 150 ) . '...';

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject = __( 'New Coupon Submission', APP_TD );

	$message  = html( 'p', __( 'Dear Admin,', APP_TD ) ) . PHP_EOL;
	$message .= html( 'p', sprintf( __( 'The following coupon has just been submitted on your %s website.', APP_TD ), $blogname ) ) . PHP_EOL;
	$message .= html( 'p',
		__( 'Details', APP_TD ) . '<br />' .
		'-----------------' . '<br />' .
		sprintf( __( 'Title: %s', APP_TD ), $post->post_title ) . '<br />' .
		sprintf( __( 'Coupon Code: %s', APP_TD ), $coupon_code ) . '<br />' .
		sprintf( __( 'Category: %s', APP_TD ), $category ) . '<br />' .
		sprintf( __( 'Store: %s', APP_TD ), $store ) . '<br />' .
		sprintf( __( 'Author: %s', APP_TD ), $the_author ) . '<br />' .
		sprintf( __( 'Description: %s', APP_TD ), $the_content ) . '<br />' .
		'-----------------'
	) . PHP_EOL;
	$message .= html( 'p', sprintf( __( 'Preview: %s', APP_TD ), get_permalink( $post->ID ) ) ) . PHP_EOL;
	$message .= html( 'p', sprintf( __( 'Edit: %s', APP_TD ), get_edit_post_link( $post->ID, '' ) ) ) . PHP_EOL;
	$message .= html( 'p', __( 'Regards,', APP_TD ) . '<br />' . __( 'Clipper', APP_TD ) ) . PHP_EOL;

	$email = array( 'to' => get_option( 'admin_email' ), 'subject' => $subject, 'message' => $message );
	$email = apply_filters( 'clpr_email_admin_new_coupon', $email, $post_id );

	appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
}


// send new email to coupon owner
function clpr_owner_new_coupon_email( $post_id ) {
	global $clpr_options;

	// get the post values
	$post = get_post( $post_id );
	if ( ! $post )
		return;

	$category = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_CAT, 'name' );
	$store = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_STORE, 'name' );
	$coupon_code = get_post_meta( $post->ID, 'clpr_coupon_code', true );

	$the_title = stripslashes( $post->post_title );
	$the_code = stripslashes( $coupon_code );
	$the_cat = stripslashes( $category );
	$the_store = stripslashes( $store );

	$the_author = stripslashes( clpr_get_user_name( $post->post_author ) );
	$the_author_email = stripslashes( get_the_author_meta( 'user_email', $post->post_author ) );
	$the_slug = get_permalink( $post->ID );
	$the_content = appthemes_filter( stripslashes( $post->post_content ) );
	$the_content = mb_substr( $the_content, 0, 150 ) . '...';

	$the_status = stripslashes( $post->post_status );

	$dashurl = trailingslashit( CLPR_DASHBOARD_URL );

	// variables that can be used by admin to dynamically fill in email content
	$find = array( '/%username%/i', '/%blogname%/i', '/%siteurl%/i', '/%loginurl%/i', '/%useremail%/i', '/%title%/i', '/%code%/i', '/%category%/i', '/%store%/i', '/%description%/i', '/%dashurl%/i' );
	$replace = array( $the_author, get_bloginfo( 'name' ), home_url('/'), wp_login_url(), $the_author_email, $the_title, $the_code, $the_cat, $the_store, $the_content, $dashurl );

	$mailto = $the_author_email;

	// email contents start
	$from_name = strip_tags( $clpr_options->nc_from_name );
	$from_email = strip_tags( $clpr_options->nc_from_email );

	// search and replace any user added variable fields in the subject line
	$subject = stripslashes( $clpr_options->nc_email_subject );
	$subject = preg_replace( $find, $replace, $subject );
	$subject = preg_replace( "/%.*%/", "", $subject );

	// search and replace any user added variable fields in the body
	$message = stripslashes( $clpr_options->nc_email_body );
	$message = preg_replace( $find, $replace, $message );
	$message = preg_replace( "/%.*%/", "", $message );

	$email = array( 'to' => $mailto, 'subject' => $subject, 'message' => $message, 'from' => $from_email, 'from_name' => $from_name );
	$email = apply_filters( 'clpr_email_user_new_coupon', $email, $post_id );

	APP_Mail_From::apply_once( array( 'email' => $email['from'], 'name' => $email['from_name'] ) );
	if ( $clpr_options->nc_email_type == 'text/plain' ) {
		wp_mail( $email['to'], $email['subject'], $email['message'] );
	} else {
		appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
	}

}


// Send an email to coupon owner when the coupon has been approved
function clpr_notify_coupon_owner_email( $post ) {
	global $current_user;

	if ( $post->post_type != APP_POST_TYPE )
		return;

	// Check that the coupon was not approved by the owner
	if ( $post->post_author == $current_user->ID )
		return;

	$coupon_title = stripslashes( $post->post_title );

	$coupon_author = stripslashes( clpr_get_user_name( $post->post_author ) );
	$coupon_author_email = stripslashes( get_the_author_meta( 'user_email', $post->post_author ) );

	// check to see if ad is legacy or not
	if ( get_post_meta( $post->ID, 'email', true ) )
		$mailto = get_post_meta( $post->ID, 'email', true );
	else
		$mailto = $coupon_author_email;

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject = __( 'Your Coupon Has Been Approved', APP_TD );

	$message  = html( 'p', sprintf( __( 'Hi %s,', APP_TD ), $coupon_author ) ) . PHP_EOL;
	$message .= html( 'p', sprintf( __( 'Your coupon, "%s" has been approved and is now live on our site.', APP_TD ), $coupon_title ) ) . PHP_EOL;
	$message .= html( 'p', __( 'You can view your coupon by clicking on the following link:', APP_TD ) . '<br />' . get_permalink( $post->ID ) ) . PHP_EOL;
	$message .= html( 'p',
		__( 'Regards,', APP_TD ) . '<br />' .
		sprintf( __( 'Your %s Team', APP_TD ), $blogname ) . '<br />' .
		home_url( '/' )
	) . PHP_EOL;

	$email = array( 'to' => $mailto, 'subject' => $subject, 'message' => $message );
	$email = apply_filters( 'clpr_email_user_coupon_approved', $email, $post );

	appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
}
add_action( 'pending_to_publish', 'clpr_notify_coupon_owner_email', 10, 1 );
add_action( 'draft_to_publish', 'clpr_notify_coupon_owner_email', 10, 1 );
 
 
// Send an email to coupon owner when the coupon don't need moderation
function clpr_owner_new_published_coupon_email( $post_id ) {

	$post = get_post( $post_id );
	if ( ! $post )
		return;

	// Check that the coupon was not submitted by admin
	if ( $post->post_author == 1 )
		return;

	$coupon_title = stripslashes( $post->post_title );

	$coupon_author = stripslashes( clpr_get_user_name( $post->post_author ) );
	$coupon_author_email = stripslashes( get_the_author_meta( 'user_email', $post->post_author ) );

	// check to see if ad is legacy or not
	if ( get_post_meta( $post->ID, 'email', true ) )
		$mailto = get_post_meta( $post->ID, 'email', true );
	else
		$mailto = $coupon_author_email;

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject = sprintf( __( 'Your coupon submission on %s', APP_TD ), $blogname );

	$message  = html( 'p', sprintf( __( 'Hi %s,', APP_TD ), $coupon_author ) ) . PHP_EOL;
	$message .= html( 'p', __( 'Thank you for your recent submission.', APP_TD ) ) . PHP_EOL;
	$message .= html( 'p', sprintf( __( 'Your coupon, "%s" has been published and is now live on our site.', APP_TD ), $coupon_title ) ) . PHP_EOL;

	$message .= html( 'p', __( 'You can view your coupon by clicking on the following link:', APP_TD ) . '<br />' . get_permalink( $post->ID ) ) . PHP_EOL;
	$message .= html( 'p',
		__( 'Regards,', APP_TD ) . '<br />' .
		sprintf( __( 'Your %s Team', APP_TD ), $blogname ) . '<br />' .
		home_url( '/' )
	) . PHP_EOL;

	$email = array( 'to' => $mailto, 'subject' => $subject, 'message' => $message );
	$email = apply_filters( 'clpr_email_user_new_coupon_published', $email, $post_id );

	appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
}


// email that gets sent out to new users once they register
function app_new_user_notification( $user_id, $plaintext_pass = '' ) {
	global $clpr_options;

	$user = new WP_User( $user_id );

	$user_login = stripslashes( $user->user_login );
	$user_email = stripslashes( $user->user_email );

	// variables that can be used by admin to dynamically fill in email content
	$find = array( '/%username%/i', '/%password%/i', '/%blogname%/i', '/%siteurl%/i', '/%loginurl%/i', '/%useremail%/i' );
	$replace = array( $user_login, $plaintext_pass, get_option('blogname'), home_url('/'), wp_login_url(), $user_email );

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );

	// send the site admin an email everytime a new user registers
	if ( $clpr_options->nu_admin_email ) {
		$subject = sprintf( __( '[%s] New User Registration', APP_TD ), $blogname );

		$message  = html( 'p', sprintf( __( 'New user registration on your site %s:', APP_TD ), $blogname ) ) . PHP_EOL;
		$message .= html( 'p', sprintf( __( 'Username: %s', APP_TD ), $user_login ) ) . PHP_EOL;
		$message .= html( 'p', sprintf( __( 'E-mail: %s', APP_TD ), $user_email ) ) . PHP_EOL;

		$email = array( 'to' => get_option( 'admin_email' ), 'subject' => $subject, 'message' => $message );
		$email = apply_filters( 'clpr_email_admin_new_user', $email, $user_id, $plaintext_pass );

		appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
	}

	if ( empty( $plaintext_pass ) )
		return;

	// check and see if the custom email option has been enabled
	// if so, send out the custom email instead of the default WP one
	if ( $clpr_options->nu_custom_email ) {

		// email sent to new user starts here
		$from_name = strip_tags( $clpr_options->nu_from_name );
		$from_email = strip_tags( $clpr_options->nu_from_email );

		// search and replace any user added variable fields in the subject line
		$subject = stripslashes( $clpr_options->nu_email_subject );
		$subject = preg_replace( $find, $replace, $subject );
		$subject = preg_replace( "/%.*%/", "", $subject );

		// search and replace any user added variable fields in the body
		$message = stripslashes( $clpr_options->nu_email_body );
		$message = preg_replace( $find, $replace, $message );
		$message = preg_replace( "/%.*%/", "", $message );

		$email = array( 'to' => $user_email, 'subject' => $subject, 'message' => $message, 'from' => $from_email, 'from_name' => $from_name );
		$email = apply_filters( 'clpr_email_user_new_user_custom', $email, $user_id, $plaintext_pass );

		APP_Mail_From::apply_once( array( 'email' => $email['from'], 'name' => $email['from_name'] ) );
		if ( $clpr_options->nu_email_type == 'text/plain' ) {
			wp_mail( $email['to'], $email['subject'], $email['message'] );
		} else {
			appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
		}

	// send the default email to debug
	} else {
		$subject = sprintf( __( '[%s] Your username and password', APP_TD ), $blogname );

		$message  = html( 'p', sprintf( __( 'Username: %s', APP_TD ), $user_login ) ) . PHP_EOL;
		$message .= html( 'p', sprintf( __( 'Password: %s', APP_TD ), $plaintext_pass ) ) . PHP_EOL;
		$message .= html( 'p', wp_login_url() ) . PHP_EOL;

		$email = array( 'to' => $user_email, 'subject' => $subject, 'message' => $message );
		$email = apply_filters( 'clpr_email_user_new_user', $email, $user_id, $plaintext_pass );

		appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
	}

}


/**
 * Sends email with receipt to customer after completed purchase.
 *
 * @param object $order
 */
function clpr_send_receipt( $order ) {

	$recipient = get_user_by( 'id', $order->get_author() );

	$items_html = '';
	foreach ( $order->get_items() as $item ) {
		$ptype_obj = get_post_type_object( $item['post']->post_type );
		if ( ! $ptype_obj->public )
			continue;

		if ( $order->get_id() != $item['post']->ID ) {
			$items_html .= html( 'p', html_link( get_permalink( $item['post']->ID ), $item['post']->post_title ) );
		} else {
			$items_html .= html( 'p', APP_Item_Registry::get_title( $item['type'] ) );
		}
	}

	$table = new APP_Order_Summary_Table( $order );
	ob_start();
	$table->show();
	$table_output = ob_get_clean();

	$content = '';
	$content .= html( 'p', sprintf( __( 'Hello %s,', APP_TD ), $recipient->display_name ) );
	$content .= html( 'p', __( 'This email confirms that you have purchased the following items:', APP_TD ) );
	$content .= $items_html;
	$content .= html( 'p', __( 'Order Summary:', APP_TD ) );
	$content .= $table_output;

	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject = sprintf( __( '[%1$s] Receipt for your order #%2$d', APP_TD ), $blogname, $order->get_id() );

	$email = array( 'to' => $recipient->user_email, 'subject' => $subject, 'message' => $content );
	$email = apply_filters( 'clpr_email_user_receipt', $email, $order );

	appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
}
add_action( 'appthemes_transaction_completed', 'clpr_send_receipt' );


/**
 * Sends email with receipt to admin after completed purchase.
 *
 * @param object $order
 */
function clpr_send_admin_receipt( $order ) {
	global $clpr_options;

	if ( is_admin() && ! defined( 'DOING_AJAX' ) )
		return;

	$moderation = $clpr_options->coupons_require_moderation;

	$items_html = '';
	foreach ( $order->get_items() as $item ) {
		$ptype_obj = get_post_type_object( $item['post']->post_type );
		if ( ! $ptype_obj->public )
			continue;

		if ( $order->get_id() != $item['post']->ID ) {
			$items_html .= html( 'p', html_link( get_permalink( $item['post']->ID ), $item['post']->post_title ) );
		} else {
			$items_html .= html( 'p', APP_Item_Registry::get_title( $item['type'] ) );
		}
	}

	$table = new APP_Order_Summary_Table( $order );
	ob_start();
	$table->show();
	$table_output = ob_get_clean();

	$content = '';
	$content .= html( 'p', __( 'Dear Admin,', APP_TD ) );
	$content .= html( 'p', __( 'You have received payment for the following items:', APP_TD ) );
	$content .= $items_html;
	if ( $moderation )
		$content .= html( 'p', __( 'Please review submitted coupon listing, and approve it.', APP_TD ) );
	$content .= html( 'p', __( 'Order Summary:', APP_TD ) );
	$content .= $table_output;

	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject = sprintf( __( '[%1$s] Received payment for order #%2$d', APP_TD ), $blogname, $order->get_id() );

	$email = array( 'to' => get_option( 'admin_email' ), 'subject' => $subject, 'message' => $content );
	$email = apply_filters( 'clpr_email_admin_receipt', $email, $order );

	appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
}
add_action( 'appthemes_transaction_completed', 'clpr_send_admin_receipt' );


/**
 * Sends email notification to admin if payment failed.
 *
 * @param object $order
 */
function clpr_send_admin_failed_transaction( $order ) {

	if ( is_admin() && ! defined( 'DOING_AJAX' ) )
		return;

	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject = sprintf( __( '[%s] Failed Order #%s', APP_TD ), $blogname, $order->get_id() );

	$content = '';
	$content .= html( 'p', sprintf( __( 'Payment for the order #%s has failed.', APP_TD ), $order->get_id() ) );
	$content .= html( 'p', sprintf( __( 'Please <a href="%s">review this order</a>, and if necessary disable assigned services.', APP_TD ), get_edit_post_link( $order->get_id() ) ) );

	$email = array( 'to' => get_option( 'admin_email' ), 'subject' => $subject, 'message' => $content );
	$email = apply_filters( 'clpr_email_admin_transaction_failed', $email, $order );

	appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
}
add_action( 'appthemes_transaction_failed', 'clpr_send_admin_failed_transaction' );

