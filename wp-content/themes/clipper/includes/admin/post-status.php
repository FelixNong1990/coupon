<?php
/**
 * Display post submit form fields.
 *
 * Temporary hack until WP will fully support custom post statuses
 *
 * @since 1.2.3
 *
 * @param object $post
 */
function clpr_post_submit_meta_box($post) {
	global $action, $wp_version;

	$post_type = $post->post_type;
	$post_type_object = get_post_type_object($post_type);
	$can_publish = current_user_can($post_type_object->cap->publish_posts);
?>
<div class="submitbox" id="submitpost">

<div id="minor-publishing">

<?php // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key ?>
<div style="display:none;">
<?php submit_button( __( 'Save', APP_TD ), 'button', 'save' ); ?>
</div>

<div id="minor-publishing-actions">
<div id="save-action">
<?php if ( 'publish' != $post->post_status && 'future' != $post->post_status && 'pending' != $post->post_status && 'unreliable' != $post->post_status )  { ?>
<input <?php if ( 'private' == $post->post_status ) { ?>style="display:none"<?php } ?> type="submit" name="save" id="save-post" value="<?php esc_attr_e( 'Save Draft', APP_TD ); ?>" tabindex="4" class="button button-highlighted" />
<?php } elseif ( 'pending' == $post->post_status && $can_publish ) { ?>
<input type="submit" name="save" id="save-post" value="<?php esc_attr_e( 'Save as Pending', APP_TD ); ?>" tabindex="4" class="button button-highlighted" />
<?php } ?>

<?php if ( version_compare($wp_version, '3.4.2', '<=') ) { ?>
<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="draft-ajax-loading" alt="" />
<?php } else { ?>
<span class="spinner"></span>
<?php } ?>
</div>

<div id="preview-action">
<?php
if ( 'publish' == $post->post_status || 'unreliable' == $post->post_status ) {
	$preview_link = esc_url( get_permalink( $post->ID ) );
	$preview_button = __( 'Preview Changes', APP_TD );
} else {
	$preview_link = get_permalink( $post->ID );
	if ( is_ssl() )
		$preview_link = str_replace( 'http://', 'https://', $preview_link );
	$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
	$preview_button = __( 'Preview', APP_TD );
}
?>
<a class="preview button" href="<?php echo $preview_link; ?>" target="wp-preview" id="post-preview" tabindex="4"><?php echo $preview_button; ?></a>
<input type="hidden" name="wp-preview" id="wp-preview" value="" />
</div>

<div class="clear"></div>
</div><?php // /minor-publishing-actions ?>

<div id="misc-publishing-actions">

<div class="misc-pub-section<?php if ( !$can_publish ) { echo ' misc-pub-section-last'; } ?>"><label for="post_status"><?php _e( 'Status:', APP_TD ); ?></label>
<span id="post-status-display">
<?php
switch ( $post->post_status ) {
	case 'private':
		_e( 'Privately Published', APP_TD );
		break;
	case 'publish':
		_e( 'Published', APP_TD );
		break;
	case 'unreliable':
		_e( 'Unreliable', APP_TD );
		break;
	case 'future':
		_e( 'Scheduled', APP_TD );
		break;
	case 'pending':
		_e( 'Pending Review', APP_TD );
		break;
	case 'draft':
	case 'auto-draft':
		_e( 'Draft', APP_TD );
		break;
}
?>
</span>
<?php if ( 'publish' == $post->post_status || 'private' == $post->post_status || $can_publish || 'unreliable' == $post->post_status ) { ?>
<a href="#post_status" <?php if ( 'private' == $post->post_status ) { ?>style="display:none;" <?php } ?>class="edit-post-status hide-if-no-js" tabindex='4'><?php _e( 'Edit', APP_TD ); ?></a>

<div id="post-status-select" class="hide-if-js">
<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ('auto-draft' == $post->post_status ) ? 'draft' : $post->post_status); ?>" />
<select name='post_status' id='post_status' tabindex='4'>
<?php if ( 'publish' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php _e( 'Published', APP_TD ); ?></option>
<?php elseif ( 'private' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'private' ); ?> value='publish'><?php _e( 'Privately Published', APP_TD ); ?></option>
<?php elseif ( 'future' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'future' ); ?> value='future'><?php _e( 'Scheduled', APP_TD ); ?></option>
<?php else : ?>
<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php _e( 'Published', APP_TD ); ?></option>
<?php endif; ?>

<option<?php selected( $post->post_status, 'unreliable' ); ?> value='unreliable'><?php _e( 'Unreliable', APP_TD ); ?></option>
<option<?php selected( $post->post_status, 'pending' ); ?> value='pending'><?php _e( 'Pending Review', APP_TD ); ?></option>
<?php if ( 'auto-draft' == $post->post_status ) : ?>
<option<?php selected( $post->post_status, 'auto-draft' ); ?> value='draft'><?php _e( 'Draft', APP_TD ); ?></option>
<?php else : ?>
<option<?php selected( $post->post_status, 'draft' ); ?> value='draft'><?php _e( 'Draft', APP_TD ); ?></option>
<?php endif; ?>
</select>
 <a href="#post_status" class="save-post-status hide-if-no-js button"><?php _e( 'OK', APP_TD ); ?></a>
 <a href="#post_status" class="cancel-post-status hide-if-no-js"><?php _e( 'Cancel', APP_TD ); ?></a>
</div>

<?php } ?>
</div><?php // /misc-pub-section ?>

<div class="misc-pub-section " id="visibility">
<?php _e( 'Visibility:', APP_TD ); ?> <span id="post-visibility-display"><?php

if ( 'private' == $post->post_status ) {
	$post->post_password = '';
	$visibility = 'private';
	$visibility_trans = __( 'Private', APP_TD );
} elseif ( !empty( $post->post_password ) ) {
	$visibility = 'password';
	$visibility_trans = __( 'Password protected', APP_TD );
} elseif ( $post_type == 'post' && is_sticky( $post->ID ) ) {
	$visibility = 'public';
	$visibility_trans = __( 'Public, Sticky', APP_TD );
} else {
	$visibility = 'public';
	$visibility_trans = __( 'Public', APP_TD );
}

echo esc_html( $visibility_trans ); ?></span>
<?php if ( $can_publish ) { ?>
<a href="#visibility" class="edit-visibility hide-if-no-js"><?php _e( 'Edit', APP_TD ); ?></a>

<div id="post-visibility-select" class="hide-if-js">
<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="<?php echo esc_attr($post->post_password); ?>" />
<?php if ($post_type == 'post'): ?>
<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky" <?php checked(is_sticky($post->ID)); ?> />
<?php endif; ?>
<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="<?php echo esc_attr( $visibility ); ?>" />


<input type="radio" name="visibility" id="visibility-radio-public" value="public" <?php checked( $visibility, 'public' ); ?> /> <label for="visibility-radio-public" class="selectit"><?php _e( 'Public', APP_TD ); ?></label><br />
<?php if ( $post_type == 'post' && current_user_can( 'edit_others_posts' ) ) : ?>
<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky" <?php checked( is_sticky( $post->ID ) ); ?> tabindex="4" /> <label for="sticky" class="selectit"><?php _e( 'Stick this post to the front page', APP_TD ); ?></label><br /></span>
<?php endif; ?>
<input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php checked( $visibility, 'password' ); ?> /> <label for="visibility-radio-password" class="selectit"><?php _e( 'Password protected', APP_TD ); ?></label><br />
<span id="password-span"><label for="post_password"><?php _e( 'Password:', APP_TD ); ?></label> <input type="text" name="post_password" id="post_password" value="<?php echo esc_attr($post->post_password); ?>" /><br /></span>
<input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php checked( $visibility, 'private' ); ?> /> <label for="visibility-radio-private" class="selectit"><?php _e( 'Private', APP_TD ); ?></label><br />

<p>
 <a href="#visibility" class="save-post-visibility hide-if-no-js button"><?php _e( 'OK', APP_TD ); ?></a>
 <a href="#visibility" class="cancel-post-visibility hide-if-no-js"><?php _e( 'Cancel', APP_TD ); ?></a>
</p>
</div>
<?php } ?>

</div><?php // /misc-pub-section ?>

<?php
// translators: Publish box date format, see http://php.net/date
$datef = __( 'M j, Y @ G:i', APP_TD );
if ( 0 != $post->ID ) {
	if ( 'future' == $post->post_status ) { // scheduled for publishing at a future date
		$stamp = __( 'Scheduled for: <b>%1$s</b>', APP_TD );
	} else if ( 'publish' == $post->post_status || 'private' == $post->post_status || 'unreliable' == $post->post_status ) { // already published
		$stamp = __( 'Published on: <b>%1$s</b>', APP_TD );
	} else if ( '0000-00-00 00:00:00' == $post->post_date_gmt ) { // draft, 1 or more saves, no date specified
		$stamp = __( 'Publish <b>immediately</b>', APP_TD );
	} else if ( time() < strtotime( $post->post_date_gmt . ' +0000' ) ) { // draft, 1 or more saves, future date specified
		$stamp = __( 'Schedule for: <b>%1$s</b>', APP_TD );
	} else { // draft, 1 or more saves, date specified
		$stamp = __( 'Publish on: <b>%1$s</b>', APP_TD );
	}
	$date = date_i18n( $datef, strtotime( $post->post_date ) );
} else { // draft (no saves, and thus no date specified)
	$stamp = __( 'Publish <b>immediately</b>', APP_TD );
	$date = date_i18n( $datef, strtotime( current_time('mysql') ) );
}

if ( $can_publish ) : // Contributors don't get to choose the date of publish ?>
<div class="misc-pub-section curtime misc-pub-section-last">
	<span id="timestamp">
	<?php printf($stamp, $date); ?></span>
	<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" tabindex='4'><?php _e( 'Edit', APP_TD ); ?></a>
	<div id="timestampdiv" class="hide-if-js"><?php touch_time(($action == 'edit'),1,4); ?></div>
</div><?php // /misc-pub-section ?>
<?php endif; ?>

<?php do_action('post_submitbox_misc_actions'); ?>
</div>
<div class="clear"></div>
</div>

<div id="major-publishing-actions">
<?php do_action('post_submitbox_start'); ?>
<div id="delete-action">
<?php
if ( current_user_can( "delete_post", $post->ID ) ) {
	if ( !EMPTY_TRASH_DAYS )
		$delete_text = __( 'Delete Permanently', APP_TD );
	else
		$delete_text = __( 'Move to Trash', APP_TD );
	?>
<a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
} ?>
</div>

<div id="publishing-action">
<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="ajax-loading" alt="" />
<?php
if ( !in_array( $post->post_status, array('publish', 'future', 'private', 'unreliable') ) || 0 == $post->ID ) {
	if ( $can_publish ) :
		if ( !empty($post->post_date_gmt) && time() < strtotime( $post->post_date_gmt . ' +0000' ) ) : ?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Schedule', APP_TD ); ?>" />
		<?php submit_button( __( 'Schedule', APP_TD ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
<?php	else : ?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Publish', APP_TD ); ?>" />
		<?php submit_button( __( 'Publish', APP_TD ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
<?php	endif;
	else : ?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Submit for Review', APP_TD ); ?>" />
		<?php submit_button( __( 'Submit for Review', APP_TD ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
<?php
	endif;
} else { ?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Update', APP_TD ); ?>" />
		<input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="<?php esc_attr_e( 'Update', APP_TD ); ?>" />
<?php
} ?>
</div>
<div class="clear"></div>
</div>
</div>

<?php
}


// add into header script for quick/bulk edit coupons
function statuses_quick_edit_script() {
	global $pagenow;

	if ( $pagenow != 'edit.php' || isset( $_GET['action'] ) )
		return;

	if ( ! isset( $_GET['post_type'] ) || $_GET['post_type'] != APP_POST_TYPE )
		return;
?>
	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {

		if ( jQuery('select[name="_status"]').length > 0 ) {
			clpr_append_to_dropdown('select[name="_status"]');
			// Refresh the custom status dropdowns everytime Quick Edit is loaded
			jQuery('#the-list a.editinline').bind( 'click', function() {
				clpr_append_to_dropdown('#the-list select[name="_status"]');
			} );
		}

		function clpr_append_to_dropdown( id ) {
			// Add "Unreliable" status to quick-edit
			if ( id == 'select[name="_status"]' ) {
				jQuery(id).append( jQuery('<option></option')
					.attr('value', 'unreliable')
					.text('Unreliable')
				);
			}
		}

	});
	//]]>
	</script>
<?php
}
add_action( 'admin_head', 'statuses_quick_edit_script', 10, 1 );

