<?php

class APP_Report_Admin {

	protected $options = '';

	public function __construct( $options ) {

		$this->options = $options;

		add_filter( 'admin_comment_types_dropdown', array( $this, 'report_comment_type' ) );
		add_filter( 'comment_row_actions', array( $this, 'comment_row_actions' ), 10, 2 );
		add_action( 'init', array( $this, 'register_settings' ), 12 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		add_action( 'admin_menu', array( $this, 'reports_add_menu' ), 11 );
		add_action( 'post_comment_status_meta_box-options', array( $this, 'reports_closed_cb' ) );
	}

	/**
	 * Registers the settings page
	 * @return void
	 */
	function register_settings() {
		new APP_Reports_Settings_Admin( $this->options );
	}

	public function report_comment_type( $comment_types ) {

		$comment_types[ APP_REPORTS_CTYPE ] = __( 'Reports', APP_TD );

		return $comment_types;
	}

	// remove unnecessary comment actions
	public function comment_row_actions( $actions, $comment ) {

		if ( $comment->comment_type != APP_REPORTS_CTYPE )
			return $actions;

		foreach ( $actions as $action => $link ) {
			if ( ! in_array( $action, array( 'delete', 'trash', 'untrash' ) ) )
				unset( $actions[ $action ] );
		}

		return $actions;
	}

	// save the checkbox value on the edit post screen under "Discussion"
	public function save_post( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( ! isset ( $_POST['post_type'] ) )
			return;

		if ( ! current_user_can( 'edit_' . $_POST['post_type'], $post_id ) )
			return;

		$key = APP_REPORTS_P_STATUS_KEY;

		// checkbox ticked
		if ( isset ( $_POST[ $key ] ) )
			return update_post_meta( $post_id, $key, $_POST[ $key ] );

		// checkbox unticked
		delete_post_meta( $post_id, $key );
	}

	public function reports_add_menu() {
		$post_types = appthemes_reports_get_args( 'post_type' );
		foreach ( $post_types as $post_type ) {
			$page_parent = ( $post_type == 'post' ) ? 'edit.php' : 'edit.php?post_type=' . $post_type;
			if ( $post_type != 'post' )
				$page_parent = add_query_arg( array( 'post_type' => $post_type ), $page_parent );

			$page_comments = add_query_arg( array( 'comment_type' => APP_REPORTS_CTYPE, 'post_type' => $post_type ), 'edit-comments.php' );

			add_submenu_page( $page_parent, __( 'Reports', APP_TD ), __( 'Reports', APP_TD ), 'moderate_comments', $page_comments );
		}
	}

	// add a checkbox on the edit post screen under "Discussion"
	public function reports_closed_cb( $post ) {
	}

}

