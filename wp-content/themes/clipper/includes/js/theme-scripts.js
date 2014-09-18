/*
 * jQuery functions
 * Written by AppThemes
 *
 * Built for use with the jQuery library
 * http://jquery.com
 *
 * Version 1.5
 *
 * Left .js uncompressed so it's easier to customize
 */


jQuery(document).ready(function() {

	/* convert header menu into select list on mobile devices */
	if ( jQuery.isFunction( jQuery.fn.tinyNav ) ) {
		jQuery('#header .menu').tinyNav({
			active: 'current-menu-item',
			header: clipper_params.text_mobile_navigation
		});
	}

	/* makes the tables responsive */
	if ( jQuery.isFunction( jQuery.fn.footable ) ) {
		jQuery('.footable').footable();
	}

	/* initialize the datepicker for forms */
	jQuery('#couponForm .datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: 0
	});

	/* initialize the form validation */
	if ( jQuery.isFunction(jQuery.fn.validate) ) {
		jQuery("#couponForm, #loginForm, #commentForm").validate({
			ignore: '.ignore',
			errorClass: "invalid",
			errorElement: "div",
			rules: {
				'post_content': {
					minlength: 15
				}
			}
		});
	}

	/* hide flash elements on ColorBox load */
	jQuery(document).bind("cbox_open", function() {
		jQuery('object, embed, iframe').css({'visibility':'hidden'});
	});
	jQuery(document).bind("cbox_closed", function() {
		jQuery('object, embed, iframe').css({'visibility':'inherit'});
	});

	if ( jQuery.isFunction( jQuery.fn.jCarouselLite ) ) {
		jQuery(".slide-contain").jCarouselLite({
			btnNext: ".next",
			btnPrev: ".prev",
			visible: ( jQuery(window).width() <= 1024 ) ? 4 : 5,
			pause: true,
			auto: true,
			timeout: 2800,
			speed: 1100,
			easing: "easeOutQuint" // for different types of easing, see easing.js
		});

		jQuery(".store-widget-slider").jCarouselLite({
			vertical: true,
			visible: 2,
			pause: true,
			auto: true,
			timeout: 2800,
			speed: 1100
		});
	}
	/* assign the ColorBox event to elements */
	if ( jQuery.isFunction(jQuery.colorbox) ) {
		jQuery( document ).on('click', 'a.mini-comments', function() {
			var postID = jQuery(this).data('rel');
			jQuery.colorbox({
				href: clipper_params.ajax_url + "?action=comment-form&id=" + postID,
				rel: function(){ return jQuery(this).data('rel'); },
				transition:'fade'
			});
			return false;
		});

		jQuery( document ).on('click', 'a.mail', function() {
			var postID = jQuery(this).data('id');
			jQuery.colorbox({
				href: clipper_params.ajax_url + "?action=email-form&id=" + postID,
				transition:'fade'
			});
			return false;
		});


		jQuery( document ).on('click', '.coupon_type-coupon-code a.coupon-code-link', function() {
			var couponcode = jQuery(this).data('clipboard-text');
			var linkID = jQuery(this).attr('id');
			jQuery(this).fadeOut('fast').html('<span>' + couponcode + '</span>').fadeIn('fast');
			jQuery(this).parent().next().hide();
			jQuery.colorbox({
				href: clipper_params.ajax_url + "?action=coupon-code-popup&id=" + linkID,
				transition:'fade',
				maxWidth:'100%',
				onLoad: function() {
					if ( clipper_params.is_mobile ) {
						jQuery('#cboxOverlay, #wrapper').hide();
					}
				},
				onComplete: function() {
					ZeroClipboard.config( { moviePath: clipper_params.templateurl + '/includes/js/zeroclipboard/ZeroClipboard.swf' } );
					var clip = new ZeroClipboard( jQuery('#copy-button') );
					clip.on( 'complete', function( client, args ) {
						jQuery("#copy-button").html(clipper_params.text_copied);
					});
					clip.on( 'mouseover', function( client ) {
						jQuery("#copy-button").addClass('hover');
					});
					clip.on( 'mouseout', function( client ) {
						jQuery("#copy-button").removeClass('hover');
					});
					clip.on( 'noflash', function( client ) {
						jQuery("#copy-button").remove();
					});
					clip.on( 'wrongflash', function( client ) {
						jQuery("#copy-button").remove();
					});
				},
				onCleanup: function() {
					ZeroClipboard.destroy();
					if ( clipper_params.is_mobile ) {
						jQuery('#wrapper').show();
					}
				}
			});
			return false;
		});

	}

	jQuery( document ).on('click', 'a.show-comments', function() {
		var postID = jQuery(this).data('rel');
		jQuery("#comments-" + postID ).slideToggle(400, 'easeOutBack');
		return false;		
	});

	jQuery( document ).on('click', 'a.share', function() {
		jQuery(this).next(".drop").slideToggle(400, 'easeOutBack');
		return false;		
	});


	jQuery(".coupon-code-link").each(function() {
		jQuery(this).removeAttr('title');
	});

	jQuery( document ).on('mouseover', 'a.coupon-code-link', function() {
		jQuery(this).parent().next().show();
	});

	jQuery( document ).on('mouseout', 'a.coupon-code-link', function() {
		jQuery(this).parent().next().hide();
	});



	// show the new store name and url fields if "add new" option is selected
	jQuery("#store_name_select").change(function() {
		if (jQuery(this).val() == 'add-new') {
			jQuery('li.new-store').fadeIn('fast');
			jQuery('li.new-store input').addClass('required');
			jQuery('li#new-store-url input').addClass('url');
		} else {
			jQuery('li.new-store').hide();
			jQuery('li.new-store input').removeClass('required invalid');
			jQuery('li#new-store-url input').removeClass('url');
		}
	}).change();

   // show the coupon code or upload coupon field based on type select box
	jQuery('#coupon_type_select').change(function() {	
		if (jQuery(this).val() == 'coupon-code') {
			jQuery('li#ctype-coupon-code').fadeIn('fast');
			jQuery('li#ctype-coupon-code input').addClass('required');
			jQuery('li#ctype-printable-coupon input').removeClass('required invalid');
			jQuery('li#ctype-printable-coupon').hide();
			jQuery('li#ctype-printable-coupon-preview').hide();
		} else if (jQuery(this).val() == 'printable-coupon') {
			jQuery('li#ctype-printable-coupon').fadeIn('fast');
			jQuery('li#ctype-printable-coupon-preview').fadeIn('fast');
			if ( ! jQuery('li#ctype-printable-coupon-preview') )
				jQuery('li#ctype-printable-coupon input').addClass('required');
			jQuery('li#ctype-coupon-code input').removeClass('required invalid');
			jQuery('li#ctype-coupon-code').hide();
		} else {
			jQuery('li.ctype').hide();
			jQuery('li.ctype input').removeClass('required invalid');
		}
	}).change();

	// toggle reports form
	jQuery(".reports_form_link a").on( "click", function() {
		jQuery(this).parents('li').next().children('.reports_form').slideToggle( 400, 'easeOutBack' );
		return false;
	});

});


// used for the search box default text
function clearAndColor(el, e2) {
	//grab the current fields value and set a variable
	if (el.defaultValue==el.value) el.value = "";
	//Change the form fields text color
	if (el.style) el.style.color = "#333";

}


// used for the search box default text
function reText(el){
	//Change the form fields text color
	if (el.style) el.style.color = "#ccc";
	if (el.value== "") el.value = el.defaultValue;
}


jQuery(function() {
		
	jQuery( ".newtag" ).autocomplete({
		source: function( request, response ) {
			jQuery.ajax({
				url: clipper_params.ajax_url + "?action=ajax-tag-search-front&tax=" + clipper_params.app_tax_store,
				dataType: "json",
				data: {
					term: request.term
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					//alert('ERROR!: '+ errorThrown);
					//alert('ERROR!: '+ textStatus);
					//alert('ERROR!: '+ XMLHttpRequest);
				},
				success: function( data ) {
					response( jQuery.map( data, function( item ) {
						return {
							term: item,
							value: item.name
						}
					}));
				}
			});
		},
		minLength: 2,
		select: function(event, ui) {
			// alert (ui.item.term.slug);
			storeurl = ui.item.term.clpr_store_url;
			if (storeurl != 0) {
				jQuery(".clpr_store_url").html('<a href="' + storeurl + '" target="_blank">' + storeurl + '<br /><img src="' + ui.item.term.clpr_store_image_url + '" class="screen-thumb" /></a><input type="hidden" name="clpr_store_id" value="' + ui.item.term.term_id + '" /><input type="hidden" name="clpr_store_slug" value="' + ui.item.term.slug + '" />');
			}	
		}
	});
		
	jQuery( ".newtag" ).keydown(function(event) {
		if (jQuery("#clpr_store_url").length == 0) {
			jQuery(".clpr_store_url").html('<input type="text" class="text" id="clpr_store_url" name="clpr_store_url" value="http://" />');
		}			
	});
		
		
	jQuery( document ).on('click', 'button.comment-submit', function() {
		
		var comment_post_ID = jQuery(this).next().val();
		var postURL = clipper_params.ajax_url + "?action=post-comment";
		var author = jQuery('input#author-' + comment_post_ID).val();
		var email = jQuery('#email-' + comment_post_ID).val();
		var url = jQuery('#url-' + comment_post_ID).val();
		var comment = jQuery('#comment-' + comment_post_ID).val();				
		
		var postData = 'author=' + author 
			+ '&email=' + email 
			+ '&url=' + url 
			+ '&comment=' + comment 
			+ '&comment_post_ID=' + comment_post_ID ;
		
		// alert(postData);
		
		jQuery.ajax({
			beforeSend: function() {
				return jQuery("#commentform-" + comment_post_ID).validate({
					errorClass: "invalid",
					errorElement: "div"
				}).form();
			},
			type: 'POST',
			data: postData,
			url: postURL,
			dataType: "json",
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert('Error: '+ errorThrown + ' - '+ textStatus + ' - '+ XMLHttpRequest);
			},
			success: function( data ) {
				
				if (data.success == true) {
					//jQuery('.comment-form .post-box').html('<div class="head"><h3>Thanks!</h3></div><div class="text-box"><p>Your comment will appear shortly.</p></div>');
					jQuery.colorbox.close();
					
					if (jQuery("#comments-" + comment_post_ID + " .comments-mini").length == 0 ) {
						jQuery("#comments-" + comment_post_ID).append("<div class='comments-box coupon'><ul class='comments-mini'>" + data.comment + "</ul></div>").fadeOut('slow').fadeIn('slow');
					} else {
						jQuery("#comments-" + comment_post_ID + " .comments-mini").prepend(data.comment).fadeOut('slow').fadeIn('slow');
					}
					
					// update the comment count but delay it a bit
					setTimeout(function() {
						jQuery("#post-" + comment_post_ID + " a.show-comments span").html(data.count).fadeOut('slow').fadeIn('slow');
					}, 2000);
					
				} else {
					jQuery('.comment-form .post-box').html('<div class="head"><h3>Error</h3></div><div class="text-box"><p>' + data.message + '</p></div>');
					jQuery.colorbox.resize();
				}				
			}
		});		
	 
	  return false;			
	});
	
	
	// send the coupon via email pop-up form
	jQuery( document ).on('click', 'button.send-email', function() {
	 
		var post_ID = jQuery(this).next().val();
		var postURL = clipper_params.ajax_url + "?action=send-email";
		var author = jQuery('#author-' + post_ID).val();
		var	email = jQuery('#email-' + post_ID).val();
		var	recipients = jQuery('#recipients-' + post_ID).val();
		var	message = jQuery('#message-' + post_ID).val();
		
		var postData = 'author=' + author 
			+ '&email=' + email 
			+ '&recipients=' + recipients 
			+ '&message=' + message 
			+ '&post_ID=' + post_ID ;
		
		// alert (postData);
		
		jQuery.ajax({
			beforeSend: function() {
				return jQuery("#commentform-" + post_ID).validate({
					errorClass: "invalid",
					errorElement: "div"
				}).form();
			},
			type: 'POST',
			data: postData,
			url: postURL,
			dataType: "json",
			success: function( data ) {

				jQuery('.comment-form .post-box').html('<div class="head"><h3>' + clipper_params.text_sent_email + '</h3></div><div class="text-box"></div>');

				jQuery.each(data, function(i, val){						
					if (val.success == true){
						jQuery('.comment-form .post-box .text-box').append('<p>' + clipper_params.text_shared_email_success + ': ' + val.recipient + '</p>');
						jQuery.colorbox.resize();
					} else {
						jQuery('.comment-form .post-box .text-box').append('<p>' + clipper_params.text_shared_email_failed + ': ' + val.recipient + '.</p>');
						jQuery.colorbox.resize();
					}
				});				
			}
		});
		
	 
	  return false;
	});
		
});

// coupon ajax vote function. calls clpr_vote_update() in voting.php 
function thumbsVote(postID, userID, elementID, voteVal, afterVote) {
	var postData = 'vid=' + voteVal + '&uid=' + userID + '&pid=' + postID;
	var theTarget = document.getElementById(elementID);	// pass in the vote_# css id so we know where to update

	jQuery.ajax({
			target: theTarget,
			type: 'POST',
			beforeSend: function() {
				jQuery('#loading-' + postID).fadeIn('fast'); // show the loading image
				jQuery('#ajax-' + postID).fadeOut('fast'); // fade out the vote buttons
			},
			data: postData,
			url: clipper_params.ajax_url + "?action=ajax-thumbsup",
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert('Error: '+ errorThrown + ' - '+ textStatus + ' - '+ XMLHttpRequest);
			},
			success: function( data, statusText ) {
				theTarget.innerHTML = afterVote;
				jQuery('#post-' +postID + ' span.percent').html(data).fadeOut('slow').fadeIn('slow');
			}			
		});	
	
	return false;		
}

// coupon ajax reset votes function. calls clpr_reset_coupon_votes_ajax() in voting.php
function resetVotes(postID, elementID, afterReset) {
	var postData = 'pid=' + postID;
	var theTarget = document.getElementById(elementID);	// pass in the reset_# css id so we know where to update

	jQuery.ajax({
			target: theTarget,
			type: 'POST',
			data: postData,
			url: clipper_params.ajax_url + "?action=ajax-resetvotes",
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert('Error: '+ errorThrown + ' - '+ textStatus + ' - '+ XMLHttpRequest);
			},
			success: function( data, statusText ) {
				theTarget.innerHTML = afterReset;
			}
		});

	return false;	
}
