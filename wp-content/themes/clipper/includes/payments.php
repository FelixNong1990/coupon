<?php

add_action( 'pending_to_publish', 'clpr_handle_moderated_transaction' );

add_action( 'appthemes_transaction_completed', 'clpr_handle_transaction_completed' );
add_action( 'appthemes_transaction_activated', 'clpr_handle_coupon_listing' );

function clpr_handle_transaction_completed( $order ) {
	global $clpr_options;

	$coupon_id = _clpr_get_order_coupon_id( $order );
	$coupon_url = get_permalink( $coupon_id );
	$order_url = get_permalink( $order->get_id() );

	if ( ! $clpr_options->coupons_require_moderation ) {
		$order->activate();
		if ( ! is_admin() )
			clpr_js_redirect( $coupon_url );
		return;
	} else {
		clpr_update_post_status( $coupon_id, 'pending' );
		if ( ! is_admin() )
			clpr_js_redirect( $order_url );
		return;
	}
}

function clpr_handle_moderated_transaction( $post ) {

	if ( $post->post_type != APP_POST_TYPE )
		return;

	$orders_post = _appthemes_orders_get_connected( $post->ID );
	if ( ! $orders_post->posts ){
		return;
	}

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order || $order->get_status() !== APPTHEMES_ORDER_COMPLETED )
		return;

	add_action( 'save_post', 'clpr_activate_moderated_transaction', 11 );
}

function clpr_activate_moderated_transaction( $post_id ) {

	$orders_post = _appthemes_orders_get_connected( $post_id );
	if ( ! $orders_post->posts ) {
		return;
	}

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order || $order->get_status() !== APPTHEMES_ORDER_COMPLETED )
		return;

	$order->activate();

}

function clpr_handle_coupon_listing( $order ) {

	foreach( $order->get_items( CLPR_COUPON_LISTING_TYPE ) as $item ) {

		clpr_update_post_status( $item['post_id'], 'publish' );
	}

}

function _clpr_get_order_coupon_id( $order ) {
	$item = $order->get_item();
	return $item['post_id'];
}

function clpr_js_redirect( $url, $message = '' ) {
	if ( empty( $message ) )
		$message = __( 'Continue', APP_TD );

	echo html( 'a', array( 'href' => $url ), $message );
	echo html( 'script', 'location.href="' . $url . '"' );
}

function clpr_payments_is_enabled() {
	global $clpr_options;

	if ( ! current_theme_supports( 'app-payments' ) || ! current_theme_supports( 'app-price-format' ) )
		return false;

	if ( ! $clpr_options->charge_coupons || ! is_numeric( $clpr_options->coupon_price ) )
		return false;

	return true;
}

function clpr_have_pending_payment( $post_id ) {

	if ( ! clpr_payments_is_enabled() )
		return false;

	$orders_post = _appthemes_orders_get_connected( $post_id );
	if ( ! $orders_post->posts )
		return false;

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order || ! in_array( $order->get_status(), array( APPTHEMES_ORDER_PENDING, APPTHEMES_ORDER_FAILED ) ) )
		return false;

	return true;
}

function clpr_get_order_permalink( $post_id ) {

	if ( ! clpr_payments_is_enabled() )
		return;

	$orders_post = _appthemes_orders_get_connected( $post_id );
	if ( ! $orders_post->posts )
		return;

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order )
		return;

	return get_permalink( $order->get_id() );
}

function clpr_get_order_gateway_name( $order ) {

	if ( ! clpr_payments_is_enabled() )
		return;

	$gateway_id = $order->get_gateway();

	if ( ! empty( $gateway_id ) ) {
		$gateway = APP_Gateway_Registry::get_gateway( $gateway_id );
		if ( $gateway ) {
			$gateway_name = $gateway->display_name( 'admin' );
		} else {
			$gateway_name = __( 'Unknown', APP_TD );
		}
	} else {
		$gateway_name = __( 'Undecided', APP_TD );
	}

	return $gateway_name;
}

function clpr_display_ordered_items( $order ) {

	if ( ! clpr_payments_is_enabled() )
		return;

	$items = $order->get_items();

	foreach( $items as $item ) {
		if ( ! APP_Item_Registry::is_registered( $item['type'] ) ) {
			$item_title = __( 'Unknown', APP_TD );
		} else {
			$item_title = APP_Item_Registry::get_title( $item['type'] );
		}
		echo html( 'div', $item_title );
	}

}

