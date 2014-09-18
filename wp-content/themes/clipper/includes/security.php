<?php
/**
 * Function to prevent visitors without admin permissions
 * to access the wordpress backend. If you wish to permit
 * others besides admins acces, change the user_level
 * to a different number.
 *
 * http://codex.wordpress.org/Roles_and_Capabilities#level_8
 */

function app_security_check() {
	global $clpr_options;

	$access_level = $clpr_options->admin_security;
	// if there's no value then give everyone access
	if ( empty( $access_level ) )
		$access_level = 'read';

	if ( defined( 'DOING_AJAX' ) || $access_level == 'disabled' )
		return;

	if ( current_user_can( $access_level ) )
		return;
?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>

		<head>
			<title><?php _e( 'Access Denied.', APP_TD ); ?></title>
			<link rel="stylesheet" href="<?php echo admin_url('css/install.css'); ?>" type="text/css" />
		</head>

		<body id="error-page">

			<p><?php _e( 'Access Denied. Your site administrator has blocked access to the WordPress back-office.', APP_TD ); ?></p>

		</body>

	</html>

<?php
	exit();
}
add_action( 'admin_init', 'app_security_check', 1 );

