<?php

class CLPR_Theme_System_Info extends APP_System_Info {


	function __construct( $args = array(), $options = null ) {

		parent::__construct( $args, $options );

		add_action( 'admin_notices', array( $this, 'admin_tools' ) );
	}


	public function admin_tools() {

		if ( ! empty( $_POST['clpr_tools']['delete_tables'] ) ) {
			appthemes_delete_db_tables();
		}

		if ( ! empty( $_POST['clpr_tools']['delete_options'] ) ) {
			appthemes_delete_all_options();
		}

	}


	function form_handler() {
		if ( empty( $_POST['action'] ) || ! $this->tabs->contains( $_POST['action'] ) )
			return;

		check_admin_referer( $this->nonce );

		if ( ! empty( $_POST['clpr_tools'] ) )
			return;
		else
			parent::form_handler();
	}


	protected function init_tabs() {
		parent::init_tabs();

		$this->tabs->add( 'clpr_tools', __( 'Advanced', APP_TD ) );

		$this->tab_sections['clpr_tools']['uninstall'] = array(
			'title' => __( 'Uninstall Theme', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Delete Database Tables', APP_TD ),
					'type' => 'submit',
					'name' => array( 'clpr_tools', 'delete_tables' ),
					'extra' => array(
						'class' => 'button-secondary',
						'onclick' => 'return clpr_confirmBeforeDeleteTables();',
					),
					'value' => __( 'Delete Clipper Database Tables', APP_TD ),
					'desc' =>
						'<br />' . __( 'Do you wish to completely delete all theme database tables?', APP_TD ) .
						'<br />' . __( 'Once you do this you will lose any custom fields, stores meta, etc that you have created.', APP_TD ),
				),
				array(
					'title' => __( 'Delete Config Options', APP_TD ),
					'type' => 'submit',
					'name' => array( 'clpr_tools', 'delete_options' ),
					'extra' => array(
						'class' => 'button-secondary',
						'onclick' => 'return clpr_confirmBeforeDeleteOptions();',
					),
					'value' => __( 'Delete Clipper Config Options', APP_TD ),
					'desc' =>
						'<br />' . __( 'Do you wish to completely delete all theme configuration options?', APP_TD ) .
						'<br />' . __( 'This will delete all values saved on the settings, pricing, etc admin pages from the wp_options database table.', APP_TD ),
				),
			),
		);


	}


	function page_footer() {
		parent::page_footer();
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	if ( $("form input[name^='clpr_tools']").length ) {
		$('form p.submit').html('');
	}
});
</script>
<?php
	}


}

