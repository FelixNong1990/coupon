/*
 * jQuery functions
 * Written by AppThemes
 *
 * Built for use with the jQuery library
 * http://jquery.com
 *
 * Version 1.0
 *
 * Left .js uncompressed so it's easier to customize
 */

jQuery(document).ready(function(){
	jQuery('#the-list').on('click', 'a.editinline', function(){
		var tag_id = jQuery(this).closest('tr').attr('id');
		var clpr_store_url = jQuery('.clpr_store_url', '#'+tag_id).text();
		var clpr_store_aff_url = jQuery('.clpr_store_aff_url', '#'+tag_id).text();

		jQuery(':input[name="clpr_store_url"]', '.inline-edit-row').val(clpr_store_url);
		jQuery(':input[name="clpr_store_aff_url"]', '.inline-edit-row').val(clpr_store_aff_url);

		if ( jQuery('#'+tag_id+' .clpr_store_featured .active-yes').length != 0 ) {
			jQuery(':input[name="clpr_store_featured"]', '.inline-edit-row').prop('checked', true);
		} else {
			jQuery(':input[name="clpr_store_featured"]', '.inline-edit-row').prop('checked', false);
		}

		if ( jQuery('#'+tag_id+' .clpr_store_active .active-yes').length != 0 ) {
			jQuery('select[name="clpr_store_active"] option', '.inline-edit-row').removeAttr('selected').filter('[value="yes"]').attr('selected', 'selected');
		} else {
			jQuery('select[name="clpr_store_active"] option', '.inline-edit-row').removeAttr('selected').filter('[value="no"]').attr('selected', 'selected');
		}

	});
});

