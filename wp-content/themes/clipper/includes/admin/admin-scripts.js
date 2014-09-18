/*
 * Admin jQuery functions
 * Written by AppThemes
 *
 * Built for use with the jQuery library
 * http://jquery.com
 *
 * Version 1.0
 *
 */


jQuery(document).ready(function() {

	/* strip out all the auto classes since they create a conflict with the calendar */
	jQuery('#tabs-wrap').removeClass('ui-tabs ui-widget ui-widget-content ui-corner-all');
	jQuery('ul.ui-tabs-nav').removeClass('ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all');
	jQuery('div#tabs-wrap div').removeClass('ui-tabs-panel ui-widget-content ui-corner-bottom');

	/* initialize the datepicker feature */
	jQuery(".datepicker").datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });

	/* clear text field, hide image preview */
	jQuery(".delete_button").click(function(el) {
		var id = jQuery(this).attr("rel");
		jQuery("#" + id).val("");
		jQuery("#" + id + "_image img").hide();
	});

});


/* Used for deleting theme database tables */
function clpr_confirmBeforeDeleteTables() {
	return confirm(clipper_admin_params.text_before_delete_tables);
}


/* Used for deleting theme options */
function clpr_confirmBeforeDeleteOptions() {
	return confirm(clipper_admin_params.text_before_delete_options);
}

