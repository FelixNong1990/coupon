<?php

/**
 * Reserved for any theme-specific hooks
 * For general AppThemes hooks, see framework/kernel/hooks.php
 *
 * @since 1.1
 * @uses add_action() calls to trigger the hooks.
 *
 */


/**
 * called in the submit-coupon-form.php file
 *
 * @since 1.1
 *
 */
function clipper_coupon_form( $post = false ) {
	do_action( 'clipper_coupon_form', $post );
}


/**
 * called in theme-login.php to hook into custom login page head
 *
 * @since 1.3.1
 *
 */
function clpr_do_login_head() {
	do_action( 'login_head' );
}


/**
 * called in theme-login.php to hook into custom login page footer
 *
 * @since 1.3.1
 *
 */
function clpr_do_login_footer() {
	do_action( 'login_footer' );
}


