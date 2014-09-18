<?php

class CLPR_Blog_Archive extends APP_View_Page {

	function __construct() {
		parent::__construct( 'index.php', __( 'Blog', APP_TD ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}
}


class CLPR_Coupons_Home extends APP_View_Page {

	function __construct() {
		parent::__construct( 'front-page.php', __( 'Coupon Listings', APP_TD ) );
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


class CLPR_Coupon_Categories extends APP_View_Page {

	function __construct() {
		parent::__construct( 'tpl-coupon-cats.php', __( 'Categories', APP_TD ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}
}


class CLPR_Coupon_Stores extends APP_View_Page {

	function __construct() {
		parent::__construct( 'tpl-stores.php', __( 'Stores', APP_TD ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}
}


class CLPR_Coupon_Submit extends APP_View_Page {

	function __construct() {
		parent::__construct( 'tpl-submit-coupon.php', __( 'Share Coupon', APP_TD ) );

		// adds custom css class for submit coupon menu item
		add_filter( 'wp_nav_menu_objects', array( $this, 'menu_item_css' ), 10, 2 );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}

	function menu_item_css( $items, $args ) {
		foreach ( $items as $key => $item ) {
			if ( $item->object_id == self::get_id() ) {
				$item->classes[] = 'menu-arrow';
			}
		}

		return $items;
	}

	function template_redirect() {
		// redirect to dashboard if can't renew
		if ( isset( $_GET['renew'] ) )
			self::can_renew_coupon();

		// this is needed for IE to work with the go back button
		header( "Cache-control: private" );
		// add js files to wp_head. tiny_mce and validate
		add_action( 'wp_enqueue_scripts', 'clpr_load_form_scripts' );

	}

	static function can_renew_coupon() {
		if ( ! isset( $_GET['renew'] ) ) {
			return;
		}

		if ( ! is_numeric( $_GET['renew'] ) || $_GET['renew'] != preg_replace( '/[^0-9]/', '', $_GET['renew'] ) ) {
			appthemes_add_notice( 'renew-invalid-id', __( 'You can not relist this coupon. Invalid ID of coupon.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		$post = get_post( $_GET['renew'] );
		if ( ! $post ) {
			appthemes_add_notice( 'renew-invalid-id', __( 'You can not relist this coupon. Invalid ID of coupon.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		if ( ! in_array( $post->post_status, array( 'draft' ) ) ) {
			appthemes_add_notice( 'renew-not-expired', __( 'You can not relist this coupon. Coupon is not expired.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		$expire_date = clpr_get_expire_date( $post->ID, 'time' ) + ( 24 * 3600 ); // + 24h, coupons expire in the end of day
		if ( $expire_date > current_time( 'timestamp' ) ) {
			appthemes_add_notice( 'renew-not-expired', __( 'You can not relist this coupon. Coupon is not expired.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

	}

}


class CLPR_Edit_Item extends APP_View_Page {

	private $error;

	function __construct() {
		parent::__construct( 'tpl-edit-item.php', __( 'Edit Item', APP_TD ) );
		add_action( 'init', array( $this, 'update' ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}

	function update() {
		global $clpr_options;

		if ( ! isset( $_POST['action'] ) || 'clpr-edit-item' != $_POST['action'] || ! current_user_can( 'edit_posts' ) )
			return;

		check_admin_referer( 'clpr-edit-item' );

		// needed for image uploading and deleting to work
		include_once (ABSPATH . 'wp-admin/includes/file.php');
		include_once (ABSPATH . 'wp-admin/includes/image.php');

		if ( isset( $_POST['clpr_expire_date'] ) && ! clpr_is_valid_expiration_date( $_POST['clpr_expire_date'] ) )
			$this->error[] = __( 'Invalid coupon expiration date.', APP_TD );

		$file_data = false;
		$is_printable = ( isset( $_POST['coupon_type_select'] ) && $_POST['coupon_type_select'] == 'printable-coupon' );
		if ( empty( $this->error ) && $is_printable && isset( $_FILES['coupon-upload'] ) && ! empty( $_FILES['coupon-upload']['name'] ) ) {

			// make sure the file uploaded is an approved type (i.e. jpg, png, gif, etc)
			$allowed = explode( ',', $clpr_options->submit_file_types );
			$extension = strtolower( pathinfo( $_FILES['coupon-upload']['name'], PATHINFO_EXTENSION ) );
			if ( ! in_array( $extension, $allowed ) )
				$this->error[] = __( 'Invalid file type.', APP_TD );

			if ( empty( $this->error ) ) {
				$file = wp_handle_upload( $_FILES['coupon-upload'], array( 'test_form' => false ) );
				if ( ! isset( $file['error'] ) ) {
					$file_data['coupon-upload-url'] = $file['url'];
					$file_data['coupon-upload-type'] = $file['type'];
					$file_data['coupon-upload-file'] = $file['file'];
					$file_data['coupon-upload-name'] = $_FILES['coupon-upload']['name'];
					$name_parts = pathinfo( $_FILES['coupon-upload']['name'] );
					$file_data['coupon-upload-filename'] = trim( $name_parts['filename'] );
				} else {
					$this->error[] = sprintf( __( 'Error: %s', APP_TD ), $file['error'] );
				}
			}

		}

		$this->error = apply_filters( 'clpr_coupon_validate_fields', $this->error );

		// update the coupon
		$post_id = ( empty( $this->error ) ) ? clpr_update_listing() : false;
		if ( ! $post_id )
			$this->error[] = __( 'There was an error trying to update your coupon.', APP_TD );

		// if it's a printable coupon, upload image
		if ( empty( $this->error ) && $file_data ) {

			// Remove old assigned printable coupons
			clpr_remove_printable_coupon( $post_id );

			$title = $file_data['coupon-upload-filename'];
			$content = '';

			// use image exif/iptc data for title and caption defaults if possible
			if ( $image_meta = @wp_read_image_metadata( $file_data['coupon-upload-file'] ) ) {
				if ( trim( $image_meta['title'] ) )
					$title = $image_meta['title'];
				if ( trim( $image_meta['caption'] ) )
					$content = $image_meta['caption'];
			}

			$attachment = array(
				'post_mime_type' => $file_data['coupon-upload-type'],
				'guid' => $file_data['coupon-upload-url'],
				'post_parent' => $post_id,
				'post_title' => $title,
				'post_content' => $content,
			);

			$attachment_id = wp_insert_attachment($attachment, $file_data['coupon-upload-file'], $post_id);
			if ( ! is_wp_error( $attachment_id ) ) {
				wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $file_data['coupon-upload-file'] ) );
				wp_set_object_terms( $attachment_id, 'printable-coupon', APP_TAX_IMAGE, false );
			} else {
				$this->error[] = __( 'There was an error while adding printable coupon.', APP_TD );
			}

		}

	}

	function template_redirect() {
		appthemes_auth_redirect_login(); // if not logged in, redirect to login page
		nocache_headers();

		// redirect to dashboard if can't edit coupon
		self::can_edit_coupon();

		// add js files to wp_head. tiny_mce and validate
		add_action( 'wp_enqueue_scripts', 'clpr_load_form_scripts' );

	}

	static function can_edit_coupon() {
		global $current_user, $clpr_options;

		if ( ! isset( $_GET['aid'] ) || $_GET['aid'] != appthemes_numbers_only( $_GET['aid'] ) ) {
			appthemes_add_notice( 'edit-invalid-id', __( 'You can not edit this coupon. Invalid ID of a coupon.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		if ( ! $clpr_options->coupon_edit ) {
			appthemes_add_notice( 'edit-disabled', __( 'You can not edit this coupon. Editing is currently disabled.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		$post = get_post( $_GET['aid'] );
		if ( ! $post ) {
			appthemes_add_notice( 'edit-invalid-id', __( 'You can not edit this coupon. Invalid ID of a coupon.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		if ( $post->post_status == 'pending' ) {
			appthemes_add_notice( 'edit-pending', __( 'You can not edit this coupon. Coupon is not yet approved.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		if ( $post->post_type != APP_POST_TYPE ) {
			appthemes_add_notice( 'edit-invalid-type', __( 'You can not edit this coupon. This is not a coupon.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		if ( $post->post_author != $current_user->ID ) {		
			appthemes_add_notice( 'edit-invalid-author', __( "You can not edit this coupon. It's not your coupon.", APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

		$expire_time = clpr_get_expire_date( $post->ID, 'time' ) + ( 24 * 3600 ); // + 24h, coupons expire in the end of day
		if ( current_time( 'timestamp' ) > $expire_time && $post->post_status == 'draft' ) {
			appthemes_add_notice( 'edit-expired', __( 'You can not edit this coupon. Coupon is expired.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}

	}

	function notices() {
		if ( ! empty( $this->error ) ) {
			foreach( $this->error as $error ) {
				appthemes_display_notice( 'error', $error );
			}
		} elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'clpr-edit-item' ) {
			appthemes_display_notice( 'success', __( 'Your coupon has been successfully updated.', APP_TD ) . ' <a href="' . CLPR_DASHBOARD_URL . '">' . __( 'Return to my dashboard', APP_TD ) . '</a>' );
		}
	}
}


class CLPR_User_Dashboard extends APP_View_Page {

	function __construct() {
		parent::__construct( 'tpl-dashboard.php', __( 'Dashboard', APP_TD ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}

	function template_redirect() {
		global $wpdb, $current_user;
		appthemes_auth_redirect_login(); // if not logged in, redirect to login page
		nocache_headers();

		$allowed_actions = array( 'pause', 'restart', 'delete' );

		if ( ! isset( $_GET['action'] ) || ! in_array( $_GET['action'], $allowed_actions ) )
			return;

		if ( ! isset( $_GET['aid'] ) || ! is_numeric( $_GET['aid'] ) )
			return;

		$d = trim( $_GET['action'] );
		$aid = appthemes_numbers_only( $_GET['aid'] );

		// make sure author matches coupon, and coupon exist
		$sql = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID = %d AND post_author = %d AND post_type = %s", $aid, $current_user->ID, APP_POST_TYPE );
		$post = $wpdb->get_row( $sql );
		if ( $post == null )
			return;

		if ( $d == 'pause' ) {
			wp_update_post( array( 'ID' => $aid, 'post_status' => 'draft' ) );
			appthemes_add_notice( 'paused', __( 'Your coupon has been paused.', APP_TD ), 'success' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();

		} elseif ( $d == 'restart' ) {
			wp_update_post( array( 'ID' => $aid, 'post_status' => 'publish' ) );
			appthemes_add_notice( 'restarted', __( 'Your coupon has been restarted.', APP_TD ), 'success' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();

		} elseif ( $d == 'delete' ) {
			clpr_delete_coupon( $aid );
			appthemes_add_notice( 'deleted', __( 'Your coupon has been deleted.', APP_TD ), 'success' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();

		}

	}

}


class CLPR_User_Orders extends APP_View_Page {

	function __construct() {
		parent::__construct( 'tpl-user-orders.php', __( 'My Orders', APP_TD ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}

	function template_redirect() {
		// if not logged in, redirect to login page
		appthemes_auth_redirect_login();

		// if payments disabled, redirect to dashboard
		if ( ! clpr_payments_is_enabled() ) {
			appthemes_add_notice( 'payments-disabled', __( 'Payments are currently disabled. You cannot purchase anything.', APP_TD ), 'error' );
			wp_redirect( CLPR_DASHBOARD_URL );
			exit();
		}
	}

}


class CLPR_User_Profile extends APP_User_Profile {

	function __construct() {
		APP_View_Page::__construct( 'tpl-profile.php', __( 'Profile', APP_TD ) );
		add_action( 'init', array( $this, 'update' ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}

}


class CLPR_Coupon_Single extends APP_View {

	function condition() {
		return is_singular( APP_POST_TYPE );
	}

	function notices() {
		$status = get_post_status( get_queried_object() );

		if ( $status == 'pending' )
			appthemes_display_notice( 'success', __( 'This coupon listing is currently pending and must be approved by an administrator.', APP_TD ) );
	}
}

