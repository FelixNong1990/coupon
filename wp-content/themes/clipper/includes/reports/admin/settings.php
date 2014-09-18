<?php

/**
 * Defines the Reports Settings Administration Panel
 */
class APP_Reports_Settings_Admin extends APP_Conditional_Tabs_Page {

	/**
	 * Sets up the page
	 * @return void
	 */
	function setup() {
		$this->textdomain = APP_TD;

		$this->args = array(
			'page_title' => __( 'Reports Settings', APP_TD ),
			'menu_title' => __( 'Reports Settings', APP_TD ),
			'page_slug' => 'app-reports-settings',
			'parent' => 'app-dashboard',
			'screen_icon' => 'options-general',
			'admin_action_priority' => 11,
			'conditional_parent' => appthemes_reports_get_args( 'admin_top_level_page' ),
			'conditional_page' => appthemes_reports_get_args( 'admin_sub_level_page' ),
		);
	}


	function conditional_create_page() {
		$top_level = appthemes_reports_get_args( 'admin_top_level_page' );
		$sub_level = appthemes_reports_get_args( 'admin_sub_level_page' );

		if ( ! $top_level &&  ! $sub_level )
			return true;
		else
			return false;
	}


	function init_tabs() {

		$this->tabs->add( 'reports', __( 'Reports', APP_TD ) );

		$fields = array(
			array(
				'title' => __( 'Registered Users Only', APP_TD ),
				'name' => array( 'reports', 'users_only' ),
				'type' => 'checkbox',
				'desc' => __( 'Yes', APP_TD ),
				'tip' => __( 'Only allow registered users to report problems.', APP_TD ),
			),
			array(
				'title' => __( 'Send Report Email', APP_TD ),
				'name' => array( 'reports', 'send_email' ),
				'type' => 'checkbox',
				'desc' => __( 'Yes', APP_TD ),
				'tip' => __( 'Send me an email when a problem has been reported.', APP_TD ),
			),
			array(
				'title' => __( 'Report Post Options', APP_TD ),
				'desc' => '<br />' . __( 'Options for the reports select field. One per line.', APP_TD ),
				'type' => 'textarea',
				'sanitize' => array( $this, 'report_options_clean' ),
				'name' => array( 'reports', 'post_options' ),
				'extra' => array(
					'style' => 'width: 500px; height: 200px;'
				),
				'tip' => __( 'Enter the different options you want available for the report feature. Enter one per line.', APP_TD ),
			),
		);

		if ( appthemes_reports_get_args( 'users' ) ) {
			$fields[] = array(
				'title' => __( 'Report User Options', APP_TD ),
				'desc' => '<br />' . __( 'Options for the reports select field. One per line.', APP_TD ),
				'type' => 'textarea',
				'sanitize' => array( $this, 'report_options_clean' ),
				'name' => array( 'reports', 'user_options' ),
				'extra' => array(
					'style' => 'width: 500px; height: 200px;'
				),
				'tip' => __( 'Enter the different options you want available for the report feature. Enter one per line.', APP_TD ),
			);
		}

		$this->tab_sections['reports']['general'] = array(
			'title' => __( 'Reports Settings', APP_TD ),
			'fields' => $fields,
		);

	}


	function report_options_clean( $string ) {
		$string = str_replace( array( "\r\n", "\r" ), "\n", $string );
		$string = str_replace( "\t", "", $string );
		$string = appthemes_clean( $string );

		return $string;
	}


}

