<?php
 

$GLOBALS['designtab'] = true;

// DEFAULT VALUES TO STOP CONFUSION
if(get_option('ppt_layout_width') == ""){

update_option("ppt_layout_width","content");
update_option("ppt_layout_columns","2");
update_option("ppt_homepage_columns","2");
update_option("ppt_listing_columns","2"); 
update_option("ppt_footer_columns","3");
update_option("ppt_article_columns","2");
update_option("display_liststyle","list");
update_option("PPT_slider","off");
}



	$fontsA = array();
 
	$fontsA["anton"]['google'] = true;
	$fontsA["anton"]['name'] = '"Anton", arial, serif';
 
	$fontsA["arial"]['google'] = false;
	$fontsA["arial"]['name'] = 'Arial, "Helvetica Neue", Helvetica, sans-serif';	
 
	$fontsA["arial_black"]['google'] = false;
	$fontsA["arial_black"]['name'] = '"Arial Black", "Arial Bold", Arial, sans-serif';	
 
	$fontsA["arial_narrow"]['google'] = false;
	$fontsA["arial_narrow"]['name'] = '"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif';
 
	$fontsA["cabin"]['google'] = true;
	$fontsA["cabin"]['name'] = 'Cabin, Arial, Verdana, sans-serif';
 
	$fontsA["cantarell"]['google'] = true;
	$fontsA["cantarell"]['name'] = 'Cantarell, Candara, Verdana, sans-serif';
 
	$fontsA["cardo"]['google'] = true;
	$fontsA["cardo"]['name'] = 'Cardo, "Times New Roman", Times, serif';
 
	$fontsA["courier_new"]['google'] = false;
	$fontsA["courier_new"]['name'] = 'Courier, Verdana, sans-serif';
 
	$fontsA["crimson_text"]['google'] = true;
	$fontsA["crimson_text"]['name'] = '"Crimson Text", "Times New Roman", Times, serif';
 
	$fontsA["cuprum"]['google'] = true;
	$fontsA["cuprum"]['name'] = '"Cuprum", arial, serif';
 
	$fontsA["dancing_script"]['google'] = true;
	$fontsA["dancing_script"]['name'] = '"Dancing Script", arial, serif';
 
	$fontsA["droid_sans"]['google'] = true;
	$fontsA["droid_sans"]['name'] = '"Droid Sans", "Lucida Grande", Tahoma, sans-serif';
 
	$fontsA["droid_mono"]['google'] = true;
	$fontsA["droid_mono"]['name'] = '"Droid Sans Mono", Consolas, Monaco, Courier, sans-serif';
 
	$fontsA["droid_serif"]['google'] = true;
	$fontsA["droid_serif"]['name'] = '"Droid Serif", Calibri, "Times New Roman", serif';
 
	$fontsA["georgia"]['google'] = false;
	$fontsA["georgia"]['name'] = 'Georgia, "Times New Roman", Times, serif';
 
	$fontsA["im_fell_dw_pica"]['google'] = true;
	$fontsA["im_fell_dw_pica"]['name'] = '"IM Fell DW Pica", "Times New Roman", serif';
 
	$fontsA["im_fell_english"]['google'] = true;
	$fontsA["im_fell_english"]['name'] = '"IM Fell English", "Times New Roman", serif';
 
	$fontsA["inconsolata"]['google'] = true;
	$fontsA["inconsolata"]['name'] = '"Inconsolata", Consolas, Monaco, Courier, sans-serif';
 
	$fontsA["inconsolata"]['google'] = true;
	$fontsA["inconsolata"]['name'] = '"Josefin Sans Std Light", "Century Gothic", Verdana, sans-serif';
 
	$fontsA["kreon"]['google'] = true;
	$fontsA["kreon"]['name'] = 'Kreon:300,400,700" kreon, georgia,serif';
 
	$fontsA["lato"]['google'] = true;
	$fontsA["lato"]['name'] = '"Lato", arial, serif';
 
	$fontsA["lobster"]['google'] = true;
	$fontsA["lobster"]['name'] = 'Lobster, Arial, sans-serif';
 
	$fontsA["lora"]['google'] = true;
	$fontsA["lora"]['name'] = '"Lora", georgia, serif';
 
	$fontsA["merriweather"]['google'] = true;
	$fontsA["merriweather"]['name'] = 'Merriweather, georgia, times, serif';
 
	$fontsA["molengo"]['google'] = true;
	$fontsA["molengo"]['name'] = 'Molengo, "Trebuchet MS", Corbel, Arial, sans-serif';	
 
	$fontsA["nobile"]['google'] = true;
	$fontsA["nobile"]['name'] = 'Nobile, Corbel, Arial, sans-serif';
 
	$fontsA["ofl_sorts_mill_goudy"]['google'] = true;
	$fontsA["ofl_sorts_mill_goudy"]['name'] = '"OFL Sorts Mill Goudy TT", Georgia, serif';
 
	$fontsA["old_standard"]['google'] = true;
	$fontsA["old_standard"]['name'] = '"Old Standard TT", "Times New Roman", Times, serif';
 
	$fontsA["reenie_beanie"]['google'] = true;
	$fontsA["reenie_beanie"]['name'] = '"Reenie Beanie", Arial, sans-serif';
 
	$fontsA["tangerine"]['google'] = true;
	$fontsA["tangerine"]['name'] = 'Tangerine, "Times New Roman", Times, serif';
 
	$fontsA["times_new_roman"]['google'] = false;
	$fontsA["times_new_roman"]['name'] = '"Times New Roman", Times, Georgia, serif';
 
	$fontsA["trebuchet_ms"]['google'] = false;
	$fontsA["trebuchet_ms"]['name'] = '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif';
 
	$fontsA["verdana"]['google'] = false;
	$fontsA["verdana"]['name'] = 'Verdana, sans-serif';
 
	$fontsA["vollkorn"]['google'] = true;
	$fontsA["vollkorn"]['name'] = 'Vollkorn, Georgia, serif';
 
	$fontsA["yanone"]['google'] = true;
	$fontsA["yanone"]['name'] = '"Yanone Kaffeesatz", Arial, sans-serif';
 
	$fontsA["american_typewriter"]['google'] = false;
	$fontsA["american_typewriter"]['name'] = '"American Typewriter", Georgia, serif';
 
	$fontsA["andale"]['google'] = false;
	$fontsA["andale"]['name'] = '"Andale Mono", Consolas, Monaco, Courier, "Courier New", Verdana, sans-serif';
 
	$fontsA["baskerville"]['google'] = false;
	$fontsA["baskerville"]['name'] = 'Baskerville, "Times New Roman", Times, serif';
 
	$fontsA["bookman_old_style"]['google'] = false;
	$fontsA["bookman_old_style"]['name'] = '"Bookman Old Style", Georgia, "Times New Roman", Times, serif';
 
	$fontsA["calibri"]['google'] = false;
	$fontsA["calibri"]['name'] = 'Calibri, "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif';
 
	$fontsA["cambria"]['google'] = false;
	$fontsA["cambria"]['name'] = 'Cambria, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["candara"]['google'] = false;
	$fontsA["candara"]['name'] = 'Candara, Verdana, sans-serif';
 
	$fontsA["century_gothic"]['google'] = false;
	$fontsA["century_gothic"]['name'] = '"Century Gothic", "Apple Gothic", Verdana, sans-serif';
 
	$fontsA["century_schoolbook"]['google'] = false;
	$fontsA["century_schoolbook"]['name'] = '"Century Schoolbook", Georgia, "Times New Roman", Times, serif';
 
	$fontsA["consolas"]['google'] = false;
	$fontsA["consolas"]['name'] = 'Consolas, "Andale Mono", Monaco, Courier, "Courier New", Verdana, sans-serif';
 
	$fontsA["constantia"]['google'] = false;
	$fontsA["constantia"]['name'] = 'Constantia, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["Corbel"]['google'] = false;
	$fontsA["Corbel"]['name'] = 'Corbel, "Lucida Grande", "Lucida Sans Unicode", Arial, sans-serif';
 
	$fontsA["franklin_gothic"]['google'] = false;
	$fontsA["franklin_gothic"]['name'] = '"Franklin Gothic Medium", Arial, sans-serif';
 
	$fontsA["garamond"]['google'] = false;
	$fontsA["garamond"]['name'] = 'Garamond, "Hoefler Text", "Times New Roman", Times, serif';
 
	$fontsA["gill_sans"]['google'] = false;
	$fontsA["gill_sans"]['name'] = '"Gill Sans MT", "Gill Sans", Calibri, "Trebuchet MS", sans-serif';
 
	$fontsA["helvetica"]['google'] = false;
	$fontsA["helvetica"]['name'] = '"Helvetica Neue", Helvetica, Arial, sans-serif';
 
	$fontsA["hoefler"]['google'] = false;
	$fontsA["hoefler"]['name'] = '"Hoefler Text", Garamond, "Times New Roman", Times, sans-serif';
 
	$fontsA["lucida_bright"]['google'] = false;
	$fontsA["lucida_bright"]['name'] = '"Lucida Bright", Cambria, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["lucida_grande"]['google'] = false;
	$fontsA["lucida_grande"]['name'] = '"Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif';
 
	$fontsA["palatino"]['google'] = false;
	$fontsA["palatino"]['name'] = '"Palatino Linotype", Palatino, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["rockwell"]['google'] = false;
	$fontsA["rockwell"]['name'] = 'Rockwell, "Arial Black", "Arial Bold", Arial, sans-serif';
 
	$fontsA["tahoma"]['google'] = false;
	$fontsA["tahoma"]['name'] = 'Tahoma, Geneva, Verdana, sans-serif';
 
if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; } 

global $PPT,$PPTDesign;
PremiumPress_Header(); 


 
 

$layouttypes = get_option('ppt_layout_styles');
if(!is_array($layouttypes)){ $layouttypes = array(); } 
 

?>
 
<script type="text/javascript">        
  jQuery(document).ready(
    function()
    {
		jQuery.fn.jPicker.defaults.images.clientPath='<?php echo PPT_FW_IMG_URI; ?>picker/';

      jQuery('.Multiple').jPicker();
	  
    });
	
 
	jQuery(function() {
	
	
	// there's the gallery and the trash
	var $gallery = jQuery( "#gallery" ), $trash = jQuery( "#trash" );
	
	jQuery( "#trash" ).sortable();
	
	// let the gallery items be draggable
	jQuery( "li", $gallery ).draggable({
			cancel: "a.ui-icon", // clicking an icon won't initiate dragging
			revert: "invalid", // when not dropped, the item will revert back to its initial position
			containment: jQuery( "#demo-frame" ).length ? "#demo-frame" : "document", // stick to demo-frame if present
			helper: "clone",
			cursor: "move"
		});
		
		// let the trash be droppable, accepting the gallery items
		$trash.droppable({
			accept: "#gallery > li",
			activeClass: "ui-state-highlight",
			drop: function( event, ui ) {
				deleteImage( ui.draggable );
			}
		});
		
		// let the gallery be droppable as well, accepting items from the trash
		$gallery.droppable({
			accept: "#trash li",
			activeClass: "custom-state-active",
			drop: function( event, ui ) {
				recycleImage( ui.draggable );
			}
		});
		
// image deletion function
		var recycle_icon = "";
		function deleteImage( $item ) {
			$item.fadeOut(function() {
				var $list = jQuery( "ul", $trash ).length ?
					jQuery( "ul", $trash ) :
					jQuery( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $trash );

				$item.find( "a.ui-icon-trash" ).remove();
				$item.append( recycle_icon ).appendTo( $list ).fadeIn(function() {
					$item
						//.animate({ width: "48px" })
						//.find( "img" )
							//.animate({ height: "36px" });
				});
			});
		}
		
		// image recycle function
		var trash_icon = "";
		function recycleImage( $item ) {
			$item.fadeOut(function() {
			
				$item
					.find( "a.ui-icon-refresh" )
						.remove()
					.end()
					.css( "width", "300px")
					.append( trash_icon )
					.find( "img" )
						.css( "height", "40px" )
					.end()
					.appendTo( $gallery )
					.fadeIn();
			});
		}
		
		 
		
	});
 	
	</script>


<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script type="text/javascript">
 function ChangeCatLogo(){
 ChangeImgBlock('catlogo');
 formfield = jQuery('#catlogo').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;	
}
function ChangeImgBlock(divname){
document.getElementById("imgIdblock").value = divname;
} 

jQuery(document).ready(function() {
 
 
jQuery('#upload_logo').click(function() {
 ChangeImgBlock('logo');
 formfield = jQuery('#logo').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?><?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?><?php } ?>);
 return false;
});

jQuery('#upload_bigsearchbg').click(function() {
 ChangeImgBlock('bigsearchbg');
 formfield = jQuery('#bigsearchbg').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?><?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?><?php } ?>);
 return false;
});


 
 jQuery('#upload_fav').click(function() {
 ChangeImgBlock('fav');
 formfield = jQuery('#fav').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#headerbg1').click(function() {
 ChangeImgBlock('headerbg');
 formfield = jQuery('#headerbg').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?><?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?><?php } ?>);
 return false;
});
 
 jQuery('#upload_h1').click(function() {
 ChangeImgBlock('h1');
 formfield = jQuery('#h1').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});
 
jQuery('#upload_h2').click(function() {
 ChangeImgBlock('h2');
 formfield = jQuery('#h2').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
}); 

jQuery('#upload_h3').click(function() {
 ChangeImgBlock('h3');
 formfield = jQuery('#h3').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h4').click(function() {
 ChangeImgBlock('h4');
 formfield = jQuery('#h4').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h5').click(function() {
 ChangeImgBlock('h5');
 formfield = jQuery('#h5').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h6').click(function() {
 ChangeImgBlock('h6');
 formfield = jQuery('#h6').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src'); 
 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
 tb_remove();
}


window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src'); 
 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
 tb_remove();
} 

});

</script>


 
  







 

             
 

<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_1.png" align="middle"> Display Settings</h3>	  						 
<ul>

	<li><a rel="premiumpress_tab1" href="#" class="active">Layout</a></li>
	<li><a rel="premiumpress_tab6" href="#">Home Page</a></li>
    <?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){ ?>
    <li><a rel="premiumpress_tab3" href="#">Store Settings</a></li>
  
    <?php } ?>
    
	<li><a rel="premiumpress_tab2" href="#">Search/Listing Page</a></li>
     
   	<li><a rel="premiumpress_tab4" href="#">Taxonomies</a></li> 
     <li><a rel="premiumpress_tab5" href="#">Sliders</a></li>     
</ul>
</div>
<style>
select { border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; }
</style>







 
<div id="DisplayImages" style="display:none;"></div><input type="hidden" id="searchBox1" name="searchBox1" value="" />







<div id="premiumpress_tab1" class="content">
<form method="post" name="designform1"  id="designform1" target="_self" > 
<input name="submitted" type="hidden" value="yes" /> 
<input type="hidden" value="" name="showThisTab" id="showThisTab" />



<div class="grid400-left">

<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Website Layout
<a href="http://www.premiumpress.com/tutorial/website-layout/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>
</h3>

</div>
 
<div class="ppt-form-line clearfix">	

<input type="hidden" id="ppt_layout_width" name="adminArray[ppt_layout_width]" value="<?php echo get_option("ppt_layout_width"); ?>" />	
<ul class="ppt_layout_columns">
<li <?php if(get_option("ppt_layout_width") =="full"){echo"class='active'";} ?> style="margin-left:50px;"><a href="javascript:document.getElementById('ppt_layout_width').value='full';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/w2.png"  /></a></li>
<li <?php if(get_option("ppt_layout_width") =="content"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_layout_width').value='content';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/w1.png"  /></a></li>
</ul>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line clearfix">	
<p>Page Column Layout</p>	
<input type="hidden" id="ppt_layout_columns" name="adminArray[ppt_layout_columns]" value="<?php echo get_option("ppt_layout_columns"); ?>" />
<ul class="ppt_layout_columns">
<li <?php if(get_option("ppt_layout_columns") =="0"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_layout_columns').value=0;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col1.png"  /></a></li>
<li <?php if(get_option("ppt_layout_columns") =="1"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_layout_columns').value=1;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col2.png" /></a></li>
<li <?php if(get_option("ppt_layout_columns") =="2"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_layout_columns').value=2;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col3.png" /></a></li>
<li <?php if(get_option("ppt_layout_columns") =="3"){echo"class='active last'";}else{ echo 'class="last"';} ?>><a href="javascript:document.getElementById('ppt_layout_columns').value=3;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col4.png" /></a></li>  
</ul>
<div class="clearfix"></div>
</div>

<?php if(!file_exists(TEMPLATEPATH."/themes/".get_option('theme')."/_homepage.php") || get_option("display_default_homepage") =="1" ){ ?>

<div class="ppt-form-line clearfix">	
<p>Home Page Column Layout</p>	
<input type="hidden" id="ppt_homepage_columns" name="adminArray[ppt_homepage_columns]" value="<?php echo get_option("ppt_homepage_columns"); ?>" />
<ul class="ppt_layout_columns">
<li <?php if(get_option("ppt_homepage_columns") =="0"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_homepage_columns').value=0;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col1.png"  /></a></li>
<li <?php if(get_option("ppt_homepage_columns") =="1"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_homepage_columns').value=1;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col2.png" /></a></li>
<li <?php if(get_option("ppt_homepage_columns") =="2"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_homepage_columns').value=2;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col3.png" /></a></li>
<li <?php if(get_option("ppt_homepage_columns") =="3"){echo"class='active last'";}else{ echo 'class="last"';} ?>><a href="javascript:document.getElementById('ppt_homepage_columns').value=3;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col4.png" /></a></li>  
</ul>
<div class="clearfix"></div>
</div>
<?php } ?>

<div class="ppt-form-line clearfix">	
<p>Listing Page Column Layout</p>	
<input type="hidden" id="ppt_listing_columns" name="adminArray[ppt_listing_columns]" value="<?php echo get_option("ppt_listing_columns"); ?>" />
<ul class="ppt_layout_columns">
<li <?php if(get_option("ppt_listing_columns") =="0"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_listing_columns').value=0;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col1.png"  /></a></li>
<li <?php if(get_option("ppt_listing_columns") =="1"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_listing_columns').value=1;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col2.png" /></a></li>
<li <?php if(get_option("ppt_listing_columns") =="2"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_listing_columns').value=2;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col3.png" /></a></li>
<li <?php if(get_option("ppt_listing_columns") =="3"){echo"class='active last'";}else{ echo 'class="last"';} ?>><a href="javascript:document.getElementById('ppt_listing_columns').value=3;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col4.png" /></a></li>  
</ul>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line clearfix">	
<p>Article Page Column Layout</p>	
<input type="hidden" id="ppt_articlecolumns" name="adminArray[ppt_articlecolumns]" value="<?php echo get_option("ppt_articlecolumns"); ?>" />
<ul class="ppt_layout_columns">
<li <?php if(get_option("ppt_articlecolumns") =="0"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_articlecolumns').value=0;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col1.png"  /></a></li>
<li <?php if(get_option("ppt_articlecolumns") =="1"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_articlecolumns').value=1;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col2.png" /></a></li>
<li <?php if(get_option("ppt_articlecolumns") =="2"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_articlecolumns').value=2;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col3.png" /></a></li>
<li <?php if(get_option("ppt_articlecolumns") =="3"){echo"class='active last'";}else{ echo 'class="last"';} ?>><a href="javascript:document.getElementById('ppt_articlecolumns').value=3;document.getElementById('leftw').value='';document.getElementById('rightw').value='';document.getElementById('middlew').value='';document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col4.png" /></a></li>  
</ul>
<div class="clearfix"></div>
</div>


<div class="ppt-form-line">	
<p>Footer Column Layout</p>	
<input type="hidden" id="ppt_footer_columns" name="adminArray[ppt_footer_columns]" value="<?php echo get_option("ppt_footer_columns"); ?>" />
<ul class="ppt_layout_columns">
<li <?php if(get_option("ppt_footer_columns") =="0"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_footer_columns').value=0;document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col1.png"  /></a></li>
<li <?php if(get_option("ppt_footer_columns") =="1"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_footer_columns').value=1;document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col2.png" /></a></li>
<li <?php if(get_option("ppt_footer_columns") =="2"){echo"class='active'";} ?>><a href="javascript:document.getElementById('ppt_footer_columns').value=2;document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col3.png" /></a></li>
<li <?php if(get_option("ppt_footer_columns") =="3"){echo"class='active last'";}else{ echo 'class="last"';} ?>><a href="javascript:document.getElementById('ppt_footer_columns').value=3;document.designform1.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/col4.png" /></a></li>  
</ul>
<div class="clearfix"></div>
</div>

 
 
</fieldset>

</div>

<div class="grid400-left last">

<fieldset>

<div class="titleh"><h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" />General Website Styles
<a href="http://www.premiumpress.com/tutorial/general-website-styles/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>
</h3></div>

<div style="display:none;" id="basic1"> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Website Logo</span>
 <input name="adminArray[logo_url]" id="logo" type="text" class="ppt-forminput"  value="<?php echo get_option("logo_url"); ?>" />
<div class="clearfix"></div>            
<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','logo');" type="button"   value="View Images" style="margin-left:140px;"  />
<input id="upload_logo" type="button" size="36" name="upload_logo" value="Upload Image"  />
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">.favicon Icon  <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is a Fav Icon?</b><br />A favicon (short for favorites icon), also known as a shortcut icon, website icon, URL icon, or bookmark icon is a 16x16 or 32x32 pixel square icon associated with a particular website or webpage. It is displayed next to your website name in the browser address bar.<br /><br />More information on fav icons can be <a href='http://en.wikipedia.org/wiki/Favicon' target='_blank'>found here.</a>  &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
<input name="adminArray[faviconLink]" type="text" class="ppt-forminput" value="<?php echo get_option("faviconLink"); ?>" id="fav"  />
<div class="clearfix"></div>
<input id="upload_fav" type="button" size="36" name="upload_fav" value="Upload FavIcon" style="margin-left:140px;"  />

</div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Content Border</span>	 
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['wrapper'])){ echo $layouttypes['wrapper']['bg']; } ?>" name="ppt_layout_style[wrapper][bg]" style="height:25px;"  /> 
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;">
Width: <input type="text" value="<?php if(isset($layouttypes['wrapper'])){  if($layouttypes['wrapper']['border-width'] == ""){ echo 1; }else{ echo $layouttypes['wrapper']['border-width']; }  } ?>" name="ppt_layout_style[wrapper][border-width]" style="height:25px; width:30px;"  /> PX
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;">
Custom CSS: <input type="text" value="<?php if(isset($layouttypes['wrapper'])){  echo $layouttypes['wrapper']['custom']; } ?>" name="ppt_layout_style[wrapper][custom]" style="height:25px;"  /> 

 </div> 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Background Color</span>	 
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['body'])){ echo $layouttypes['body']['bg']; } ?>" name="ppt_layout_style[body][bg]" style="height:25px;" /><br />
<a href="themes.php?page=custom-background" style="margin-left:140px;">Background Image</a>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Font Family</span>	 
<select name="ppt_layout_style[body][font]" style="width:200px;font-size:12px;">
<option value="">--------------</option>
<?php foreach($fontsA as $key=>$val){   ?>
<option value="<?php echo $key; ?>" <?php if($layouttypes['body']['font'] == $key){ echo "selected=selected"; }; ?>><?php echo $val['name']; ?></option>

<?php   } ?>
				 
               
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Column Widths</span>	 
Left Sidebar <input type="text" id="leftw" value="<?php if(isset($layouttypes['sidebar']['leftw']) && $layouttypes['sidebar']['leftw'] != ""){ echo $layouttypes['sidebar']['leftw']; }else{ if(get_option("ppt_layout_columns") == 3){ echo "200px"; }else{ echo "260px"; } } ?>" name="ppt_layout_style[sidebar][leftw]" style="width:60px;" /><br />
<span style="margin-left:140px;">Middle <input type="text" id="middlew" value="<?php if(isset($layouttypes['sidebar']['middlew']) && $layouttypes['sidebar']['middlew'] != ""){ echo $layouttypes['sidebar']['middlew']; }else{ if(get_option("ppt_layout_columns") == 0){ echo "960px"; }elseif(get_option("ppt_layout_columns") == 3){ echo "540px"; }else{ echo "670px"; } } ?>" name="ppt_layout_style[sidebar][middlew]" style="width:60px;" /></span><br />
<span style="margin-left:140px;">Right Sidebar <input type="text" value="<?php if(isset($layouttypes['sidebar']['rightw']) && $layouttypes['sidebar']['rightw'] != ""){ echo $layouttypes['sidebar']['rightw']; }else{ if(get_option("ppt_layout_columns") == 3){ echo "200px"; }else{ echo "260px"; } } ?>" id="rightw" name="ppt_layout_style[sidebar][rightw]" style="width:60px;" /></span><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Header Color</span>	 
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['header'])){ echo $layouttypes['header']['bg']; } ?>" name="ppt_layout_style[header][bg]" style="height:25px;" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Header Image</span>	 

<input value="<?php if(isset($layouttypes['header'])){ echo $layouttypes['header']['image']; } ?>" name="ppt_layout_style[header][image]" id="headerbg" type="text" class="ppt-forminput"  />
<div class="clearfix"></div>
<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','headerbg');" type="button"   value="View Images" style="margin-left:140px;"  />
<input id="headerbg1" type="button" size="36" name="headerbg1" value="Upload Image"  />
<br />
<select name="ppt_layout_style[header][image-repeat]" style="width:150px;font-size:12px; margin-left:140px;">
<option value="repeat" <?php if($layouttypes['header']['image-repeat'] == "repeat"){ echo "selected=selected"; }; ?>>Repeat</option> 			 
 <option value="no-repeat" <?php if($layouttypes['header']['image-repeat'] == "no-repeat"){ echo "selected=selected"; }; ?>>No Repeat</option> 
 <option value="repeat-y" <?php if($layouttypes['header']['image-repeat'] == "repeat-y"){ echo "selected=selected"; }; ?>>Repeat Y</option> 
 <option value="repeat-x" <?php if($layouttypes['header']['image-repeat'] == "repeat-x"){ echo "selected=selected"; }; ?>>Repeat X</option>              
</select>
<br />
<span style="margin-left:140px; font-size:11px;color:#666;">
Custom CSS: <input type="text" value="<?php if(isset($layouttypes['header'])){  echo $layouttypes['header']['custom']; } ?>" name="ppt_layout_style[header][custom]" style="height:25px;"  />
</span>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Page Color</span>	 
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['page'])){ echo $layouttypes['page']['bg']; } ?>" name="ppt_layout_style[page][bg]" style="height:25px;" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Content Color</span>	 
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['content'])){ echo $layouttypes['content']['bg']; } ?>" name="ppt_layout_style[content][bg]" style="height:25px;" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Primary Text</span>
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['text'])){ echo $layouttypes['text']['main']; } ?>" name="ppt_layout_style[text][main]" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Heading Text</span>
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['text'])){ echo $layouttypes['text']['h1']; } ?>" name="ppt_layout_style[text][h1]" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Link Text</span>
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['text'])){ echo $layouttypes['text']['a']; } ?>" name="ppt_layout_style[text][a]" /><br />
<div class="clearfix"></div>
</div> 
 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Button Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['button']['from']; ?>" name="ppt_layout_style[button][from]" style="height:25px;margin-right:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="Multiple" type="hidden" value="<?php echo $layouttypes['button']['to']; ?>" name="ppt_layout_style[button][to]" style="height:25px;" /> 
<div class="clearfix" ></div>
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Button Text</span>
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['text'])){ echo $layouttypes['button']['text']; } ?>" name="ppt_layout_style[button][text]"  /><br />
<div class="clearfix"></div>
</div> 
 
<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>
</div>



<a href="javascript:void(0);" onclick="toggleLayer('basic1');" class="ppt_layout_showme">Show/Hide Options</a>

</fieldset>


<fieldset>

<div class="titleh"><h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a3.gif" style="float:left; margin-right:8px;" />Navigation / Menu Bar Styles
<a href="http://www.premiumpress.com/tutorial/navigation-menu-bar-styles/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>
</h3></div>
<div style="display:none;" id="basic2"> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Menu Bar Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['nav']['from']; ?>" name="ppt_layout_style[nav][from]" style="height:25px;margin-right:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="Multiple" type="hidden" value="<?php echo $layouttypes['nav']['to']; ?>" name="ppt_layout_style[nav][to]" style="height:25px;" /> 
<div class="clearfix" ></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Menu Text Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['nav']['text']; ?>" name="ppt_layout_style[nav][text]" style="height:25px;"  /> 
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;"><input name="ppt_layout_style[nav][text-shawdow]"  <?php if($layouttypes['nav']['text-shawdow']  ==1){ echo"checked=checked"; } ?> type="checkbox" value="1" />
  Text Shadow</span>
</div> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Menu Drop Down Background Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['nav']['dropbg']; ?>" name="ppt_layout_style[nav][dropbg]" style="height:25px;"  /> 
<div class="clearfix"></div>
<div style="margin-left:140px;">
Hover Color
<input class="Multiple" type="text" value="<?php echo $layouttypes['nav']['dropbgh']; ?>" name="ppt_layout_style[nav][dropbgh]" style="height:25px; width:50px;"  /> 
</div>
</div> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Menu Drop Down Text Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['nav']['droptext']; ?>" name="ppt_layout_style[nav][droptext]" style="height:25px;"  /> 
<div class="clearfix"></div>
</div> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Menu Custom CSS</span>	 
 <input type="text" value="<?php echo $layouttypes['nav']['custom']; ?>" name="ppt_layout_style[nav][custom]" class="ppt-forminput" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Sub Nav</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['submenubar']['bg']; ?>" name="ppt_layout_style[submenubar][bg]" style="height:25px;"  /> 
<div class="clearfix"></div>

<?php $thisTheme = get_option('theme');

if(strpos(strtolower($thisTheme),"-simple-") === false){ 

?>
<br /><span style="margin-left:140px; font-size:11px;color:#666;"><input name="ppt_layout_style[submenubar][hide]"  <?php if($layouttypes['submenubar']['hide']  ==1){ echo"checked=checked"; } ?> type="checkbox" value="1" />  Hide Sub Menu  (completely)</span>
<br /><span style="margin-left:140px; font-size:11px;color:#666;"><input name="ppt_layout_style[submenubar][search]"  <?php if($layouttypes['submenubar']['search']  ==1){ echo"checked=checked"; } ?> type="checkbox" value="1" />  Hide Search Fields (show pages instead)</span>

<br /><span style="margin-left:140px; font-size:11px;color:#666;"><input name="ppt_layout_style[submenubar][hidecat]"  <?php if($layouttypes['submenubar']['hidecat']  ==1){ echo"checked=checked"; } ?> type="checkbox" value="1" />  Hide Category List </span>
<br /><span style="margin-left:140px; font-size:11px;color:#666;"><input name="ppt_layout_style[submenubar][loginlogout]"  <?php if($layouttypes['submenubar']['loginlogout']  ==1){ echo"checked=checked"; } ?> type="checkbox" value="1" />  Hide  Login/Logout Options</span>

<?php } ?>

</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Sub Nav Text</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['submenubar']['text']; ?>" name="ppt_layout_style[submenubar][text]" style="height:25px;"  /> 
<div class="clearfix"></div>
</div>
<?php  if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){  ?>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Multiple Currency</span>	 
	 
<select name="adminArray[display_subnav_currency]" class="ppt-forminput">
<option value="yes" <?php if(get_option("display_subnav_currency") =="yes"){ print "selected";} ?>>Show Drop Down in Submenu</option>
<option value="no" <?php if(get_option("display_subnav_currency") =="no"){ print "selected";} ?>>Hide</option>
</select> 

<div class="clearfix" ></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Language Flags</span>	 
 
<select name="adminArray[display_subnav_flags]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_subnav_flags") =="yes"){ print "selected";} ?>>Show Drop Down in Submenu</option>
				<option value="no" <?php if(get_option("display_subnav_flags") =="no"){ print "selected";} ?>>Hide Flags</option>
			</select>
<select name="adminArray[display_subnav_flags_type]" class="ppt-forminput" style="margin-left:140px;">
				<option value="yes" <?php if(get_option("display_subnav_flags_type") =="yes"){ print "selected";} ?>>Google Translation</option>
				<option value="no" <?php if(get_option("display_subnav_flags_type") =="no"){ print "selected";} ?>>Custom Language Files</option>
			</select>

<div class="clearfix" ></div>
</div>
<?php } ?>


<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>



</div>

<a href="nav-menus.php" class="ppt_layout_showme fr">Edit Menu Items</a>
<a href="javascript:void(0);" onclick="toggleLayer('basic2');" class="ppt_layout_showme">Show/Hide Options</a>


</fieldset>


<fieldset>

<div class="titleh"><h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a4.gif" style="float:left; margin-right:8px;" /> Object Box / Item Box Styles
<a href="http://www.premiumpress.com/tutorial/object-box-item-box-styles/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>

</h3></div>
<div style="display:none;" id="basic7"> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Border Color</span>	 
<input class="Multiple" type="text" value="<?php if(isset($layouttypes['itembox'])){ echo $layouttypes['itembox']['border-bg']; } ?>" name="ppt_layout_style[itembox][border-bg]" style="height:25px;"  /> 
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;">
Width: <input type="text" value="<?php if(isset($layouttypes['itembox'])){  if($layouttypes['itembox']['border-width'] == ""){ echo 1; }else{ echo $layouttypes['itembox']['border-width']; }  } ?>" name="ppt_layout_style[itembox][border-width]" style="height:25px; width:30px;"  /> PX
<div class="clearfix"></div>
</div> 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext"> Background Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['itembox']['bg']; ?>" name="ppt_layout_style[itembox][bg]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix" ></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext"> Hover Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['itembox']['hover']; ?>" name="ppt_layout_style[itembox][hover]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix" ></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Title Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['itembox']['from']; ?>" name="ppt_layout_style[itembox][from]" style="height:25px;margin-right:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="Multiple" type="hidden" value="<?php echo $layouttypes['itembox']['to']; ?>" name="ppt_layout_style[itembox][to]" style="height:25px;" /> 
<div class="clearfix" ></div>
</div>



<div class="ppt-form-line">	
<span class="ppt-labeltext">Text Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['itembox']['text']; ?>" name="ppt_layout_style[itembox][text]" style="height:25px;"  /> 
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;"><input name="ppt_layout_style[itembox][text-shawdow]"  <?php if($layouttypes['itembox']['text-shawdow']  ==1){ echo"checked=checked"; } ?> type="checkbox" value="1" />
  Text Shadow</span>
</div>

<?php  if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){  ?>

<h3>Search/Gallery Page Products</h3>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Product Border</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['gallery']['border-bg'];  ?>" name="ppt_layout_style[gallery][border-bg]" style="height:25px;"  /> 
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;">
Border Width: <input type="text" value="<?php if(isset($layouttypes['gallery'])){  if($layouttypes['gallery']['border-width'] == ""){ echo 5; }else{ echo $layouttypes['gallery']['border-width']; }  } ?>" name="ppt_layout_style[gallery][border-width]" style="height:25px; width:30px;"  /> PX
<div class="clearfix"></div>

<span class="ppt-labeltext">Featured Product Border</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['gallery']['featured-border-bg'];  ?>" name="ppt_layout_style[gallery][featured-border-bg]" style="height:25px;"  /> 
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;">
Border Width: <input type="text" value="<?php if(isset($layouttypes['gallery'])){  if($layouttypes['gallery']['featured-border-width'] == ""){ echo 5; }else{ echo $layouttypes['gallery']['featured-border-width']; }  } ?>" name="ppt_layout_style[gallery][featured-border-width]" style="height:25px; width:30px;"  /> PX
<div class="clearfix"></div>

<span class="ppt-labeltext">Hover Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['hover']; ?>" name="ppt_layout_style[gallery][hover]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div>

 

 <div class="ppt-form-line">	
<span class="ppt-labeltext">Product Title Text</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['text']; ?>" name="ppt_layout_style[gallery][text]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Price Box Background</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['price-bg']; ?>" name="ppt_layout_style[gallery][price-bg]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div><br />
<span class="ppt-labeltext">Price Text Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['price-text']; ?>" name="ppt_layout_style[gallery][price-text]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div> 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Add-To-Cart Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['cart']; ?>" name="ppt_layout_style[gallery][cart]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div> 

<h3>Buy Button on Product Page</h3>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Background Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['single']['buy-bg']; ?>" name="ppt_layout_style[single][buy-bg]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Text Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['single']['buy-bg-text']; ?>" name="ppt_layout_style[single][buy-bg-text]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div> 
<?php } ?>

<?php  if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "directorypress"){  ?>
<h3>Featured Listings</h3>

 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Background</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['gallery']['featured-bg'];  ?>" name="ppt_layout_style[gallery][featured-bg]" style="height:25px;"  /> 
<div class="clearfix"></div></div>
 <div class="ppt-form-line">	
<span class="ppt-labeltext">Border Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['featured-bordercolor']; ?>" name="ppt_layout_style[gallery][featured-bordercolor]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Text Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['featured-text']; ?>" name="ppt_layout_style[gallery][featured-text]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Button Background Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['featured-button-bg']; ?>" name="ppt_layout_style[gallery][featured-button-bg]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Button Text Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['gallery']['featured-button-bgtxt']; ?>" name="ppt_layout_style[gallery][featured-button-bgtxt]" style="height:25px;margin-right:100px;" /> 
<div class="clearfix"></div>
</div>
<?php } ?>
 
<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>
</div>
 
<a href="javascript:void(0);" onclick="toggleLayer('basic7');" class="ppt_layout_showme">Show/Hide Options</a>


</fieldset>

 

 
<fieldset>

<div class="titleh"><h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a5.gif" style="float:left; margin-right:8px;" /> Footer Styles

<a href="http://www.premiumpress.com/tutorial/footer-styles/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>

</h3></div>
<div style="display:none;" id="basic3"> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Footer Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['footer']['bg']; ?>" name="ppt_layout_style[footer][bg]" style="height:25px;" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Link Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['footer']['a']; ?>" name="ppt_layout_style[footer][a]" style="height:25px;" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Text Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['footer']['text']; ?>" name="ppt_layout_style[footer][text]" style="height:25px;" /><br />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Footer Credits</span>	 
 <select name="adminArray[removecopyright]" class="ppt-forminput" title="Here you on/off the 'developed by PremiumPress' credits in the footer.">
				<option value="yes" <?php if(get_option("removecopyright") =="yes"){ print "selected";} ?>>Removed Footer Notice </option>
				<option value="no" <?php if(get_option("removecopyright") == "no"){ print "selected";} ?>>Show Notice (Thank You)</option>
			</select>
<div class="clearfix"></div>
</div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Copyright Text</span>	 
 <input name="adminArray[copyright]" type="text" class="ppt-forminput" value="<?php echo get_option("copyright"); ?>"  title="Here you enter your own copyright information which will be displayed in the website footer." />
<div class="clearfix"></div>
</div>



<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>
</div>
<a href="javascript:void(0);" onclick="toggleLayer('basic3');" class="ppt_layout_showme">Show/Hide Options</a>
</fieldset>


<?php if(get_option("PPT_slider") =="off"){ }else{ ?>
<fieldset>

<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a6.gif" style="float:left; margin-right:8px;" /> Slider Styles

<a href="http://www.premiumpress.com/tutorial/sliders/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>

</h3></div>

<div style="display:none;" id="basic8"> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Background Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['slider']['bg']; ?>" name="ppt_layout_style[slider][bg]" style="height:25px;"  /> 
<div class="clearfix"></div>
</div> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Content Border</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['slider']['border-color'];  ?>" name="ppt_layout_style[slider][border-color]" style="height:25px;"  /> 
<div class="clearfix"></div>
<br /><span style="margin-left:140px; font-size:11px;color:#666;">
Width: <input type="text" value="<?php if(isset($layouttypes['slider'])){  if($layouttypes['slider']['border-width'] == ""){ echo 1; }else{ echo $layouttypes['slider']['border-width']; }  } ?>" name="ppt_layout_style[slider][border-width]" style="height:25px; width:30px;"  /> PX
<div class="clearfix"></div>
</div> 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Normal Slider Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['slider']['from']; ?>" name="ppt_layout_style[slider][from]" style="height:25px;margin-right:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="Multiple" type="hidden" value="<?php echo $layouttypes['slider']['to']; ?>" name="ppt_layout_style[slider][to]" style="height:25px;" /> 
<div class="clearfix" ></div>
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Normal Text Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['slider']['text']; ?>" name="ppt_layout_style[slider][text]" style="height:25px;"  /> 
<div class="clearfix"></div>
</div> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Active Slider Color</span>	 
 <input class="Multiple" type="hidden" value="<?php echo $layouttypes['slider']['afrom']; ?>" name="ppt_layout_style[slider][afrom]" style="height:25px;margin-right:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="Multiple" type="hidden" value="<?php echo $layouttypes['slider']['ato']; ?>" name="ppt_layout_style[slider][ato]" style="height:25px;" /> 
<div class="clearfix" ></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Active Text Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['slider']['atext']; ?>" name="ppt_layout_style[slider][atext]" style="height:25px;"  /> 
<div class="clearfix"></div>
</div> 

<p><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></p>


</div> 
<a href="javascript:void(0);" onclick="toggleLayer('basic8');" class="ppt_layout_showme">Show/Hide Options</a>
 
</fieldset>
<?php } ?>


<fieldset>

<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a7.gif" style="float:left; margin-right:8px;" /> Custom Styles

<a href="http://www.premiumpress.com/tutorial/custom-styles/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>

</h3></div>

<div style="display:none;" id="basic4"> 

<div class="ppt-form-line">	
<p><b>Add your own &lt;HEAD&gt; data below</b></p>
<textarea name="adminArray[ppt_custom_metatags]" type="text" style="width:100%;height:150px;" class="ppt-forminput"><?php echo stripslashes(get_option("ppt_custom_metatags")); ?></textarea><br />
<p>If your adding CSS include  &lt;style&gt; css here &lt;/style&gt;</p>
 <p class="ppnote" style="width:95%">Anything you add into the box above will be displayed within you &lt;HEAD&gt; tags. </p>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<p><b>Add your own FOOTER; data below</b></p>
<textarea name="adminArray[ppt_custom_footertags]" type="text" style="width:100%;height:150px;" class="ppt-forminput"><?php echo stripslashes(get_option("ppt_custom_footertags")); ?></textarea><br />
 <p class="ppnote" style="width:95%">Anything you add into the box above will be displayed within you footer before the &lt;/BODY&gt;. </p>
<div class="clearfix"></div>
</div>

<p><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></p>


</div>
<a href="javascript:void(0);" onclick="toggleLayer('basic4');" class="ppt_layout_showme">Show/Hide Options</a>
</fieldset>


<fieldset>

<div class="titleh"><h3>Example Color Pallets - Click to activate</h3></div>
<p>Click to apply preset colors. Note: will overwrite your current settings.</p>
<ul class="ppt_layout_columns">
 
<li><a href="javascript:document.getElementById('chosencolor').value=1;document.resettocolor.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/color1.png" /></a></li>  
<li><a href="javascript:document.getElementById('chosencolor').value=2;document.resettocolor.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/color2.png" /></a></li>  
<li><a href="javascript:document.getElementById('chosencolor').value=3;document.resettocolor.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/color3.png" /></a></li>  
<li><a href="javascript:document.getElementById('chosencolor').value=4;document.resettocolor.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/color4.png" /></a></li>  
<li><a href="javascript:document.getElementById('chosencolor').value=5;document.resettocolor.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/color5.png" /></a></li>  
<li><a href="javascript:document.getElementById('chosencolor').value=6;document.resettocolor.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/color6.png" /></a></li>  

</ul>
 
</fieldset>

 
<?php if(is_array($layouttypes) && !empty($layouttypes)){ ?>
 <fieldset >
<legend><strong>Download Styles Backup</strong></legend>
<p>Click the link below to download a ready formatted XML file with all of your styles so you can re-import later OR share with your friends. <img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/thumb_up.png" /></p>

<p><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/sdisplay.png" align="absmiddle" /> <a href="admin.php?page=display&dldesign=1">Download Styles File</a></p>
 
 
 <p><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/ssetup.png" align="absmiddle" /> <a href="#bota" onclick="toggleLayer('importstylefile');">Import Styles File</a></p>

 
 </fieldset>
<?php } ?> 

</div>
 

<div class="clearfix"></div>
<div class="savebarb clear">
<div class="clearfix"></div>
<p><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></p>
</div>
</form> 
<form method="post" target="_self" name="resettocolor" id="resettocolor" >
<input name="chosencolor" id="chosencolor" type="hidden" value="" /> 
</form> 
<form method="post" target="_self" >
<input name="ppt_layout_style_reset" type="hidden" value="1" />
<input  type="submit" value="Reset All Display Settings" class="button" style="float:right;padding:5px;cursor:pointer; margin-top:-40px;"/>
</form>  



<form method="post" target="_self" enctype="multipart/form-data" style="display:none;" id="importstylefile">
<input name="importdesign" type="hidden" value="1" />


<fieldset>

<div class="titleh"><h3>Import Theme Styles</h3></div>

<div class="ppt-form-line">	
<p><b>Select XML Styles File</b></p>
<input name="designfile" type="file" style="font-size:14px; width:200px;"   /> 
<div class="clearfix"></div>
</div>
 

<div class="ppt-form-line"><input  class="premiumpress_button" type="submit"  value="Import Styles" style="color:#fff;"/></div>

</fieldset>

</form>

<a name="bota"></a>  

<div class="clearfix"></div> 
</div>


 






 
 

















<div id="premiumpress_tab6" class="content">

<?php if( ( strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" || strtolower(PREMIUMPRESS_SYSTEM) == "bookingpress" ) && get_option("display_default_homepage") !="1"){ ?>
<form method="post" name="shopperpress1" id="shopperpress1" target="_self" >
<input name="admin_page" type="hidden" value="shopperpress_setup" />
<input name="submitted" type="hidden" value="yes" />
<div class="msg msg-info">
  <p>Many child themes have their own home page layouts, available images can be edited below. If you want to disable the child theme home page and use the system home page options instead, <b>tick the box</b>.
  
    <input type="checkbox" class="checkbox" name="display_default_homepage" value="1" <?php if(get_option("display_default_homepage") =="1"){ print "checked";} ?> onchange="document.shopperpress1.submit();" />
</p>
</div>
</form>



<form method="post" name="shopperpress" target="_self" >
<input name="submitted" type="hidden" value="yes" />
<input type="hidden" value="6" name="showThisTab" id="showThisTab" />

<?php

$b = array();
$b[1] = PPT_CUSTOM_STYLE_PATH."badge1.gif";
$b[2] = PPT_CUSTOM_STYLE_PATH."badge2.gif";
$b[3] = PPT_CUSTOM_STYLE_PATH."badge3.gif";
$b[4] = PPT_CUSTOM_STYLE_PATH."badge4.gif";
$b[5] = PPT_CUSTOM_STYLE_PATH."badge5.gif";
$b[6] = PPT_CUSTOM_STYLE_PATH."badge6.gif";
 
if(get_option("display_default_homepage") !="1"){



$loopme=1; $d=0;
while($loopme < 7){
 if(file_exists($b[$loopme])){ $size = getimagesize($b[$loopme]);   ?>

 
<fieldset style="float:left; width:380px; <?php if($d%2){ }else{ ?>margin-right:20px;<?php } ?>">
<div class="titleh"><h3>Home Page Image - <?php if(is_array($size)){ echo "Image Width: ".$size[0]."px / Height: ".$size[1]."px "; } ?></h3></div>

<div class="ppt-form-line">	
 <img src="<?php if(strlen(get_option("home_image_".$loopme)) > 1){ echo premiumpress_image_check(get_option("home_image_".$loopme),"full"); }else{ echo PPT_CUSTOM_STYLE_URL; ?>/badge<?php echo $loopme; ?>.gif<?php } ?>" alt="<?php echo get_option("home_title_".$loopme);  ?>" style="max-width:350px; max-height:200px;" />  
 </div>
 
<div id="imgSh<?php echo $d; ?>" style="display:none;">	  
    
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Image</span>

	<input name="adminArray[home_image_<?php echo $loopme; ?>]" id="h<?php echo $loopme; ?>" type="text" class="ppt-forminput" value="<?php echo get_option("home_image_".$loopme); ?>" />
            <img src="<?php echo PPT_FW_IMG_URI; ?>help.png" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br>The image you select here will replace the default one.<br> <?php if(is_array($size)){ echo "<br>Create a replacement image with the dimentions: Width: ".$size[0]."px / Height: ".$size[1]."px / Type: ".$size['mime'].""; } ?>.<br><br> Then upload it using the 'image manage' and select your newly uploaded image by clicking the '<img src=<?php echo $GLOBALS['template_url']; ?>/PPT/img/premiumpress/led-ico/find.png align=middle> view uploaded images' link. &quot;);"/>       
			 
 
 <input style="margin-left:140px;" onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','h<?php echo $loopme; ?>');" type="button"   value="View Images"  />
 <input id="upload_h<?php echo $loopme; ?>" type="button" size="36" name="upload_h<?php echo $loopme; ?>" value="Upload Image"  />
            
<div class="clearfix"></div>
</div>                
 
 
 <div class="ppt-form-line">	
<span class="ppt-labeltext">Clickable Link</span>	
<input name="adminArray[home_link_<?php echo $loopme; ?>]" type="text" class="ppt-forminput" value="<?php echo get_option("home_link_".$loopme); ?>" />
<div class="clearfix"></div>
</div>  
			
 <div class="ppt-form-line">	
<span class="ppt-labeltext">Image ALT</span>	
<input name="adminArray[home_title_<?php echo $loopme; ?>]" type="text" class="ppt-forminput" value="<?php echo get_option("home_title_".$loopme); ?>" />
<div class="clearfix"></div>
</div>       
            
	<p><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></p>	 
</div> 
<a href="javascript:void(0);" onclick="toggleLayer('imgSh<?php echo $d; ?>');" class="ppt_layout_showme" style="width:200px;">edit / change image</a>      
      
  
 </fieldset>   
   

 
 <?php $d++; } $loopme++; } } ?>
 
 
<div class="clearfix"></div>
 

<fieldset>

<div class="titleh"><h3>Home Page Product Display</h3></div>

<p><b>Home Page Text - <b>HTML Allowed</b></b></p>
<textarea name="adminArray[welcome_text]" type="text" style="width:800px;height:150px;"><?php echo stripslashes(get_option("welcome_text")); ?></textarea><br />
 

<div class="ppt-form-line">	
<p><b>Display Products</b></p>
<select name="adminArray[display_home_products]" style="width: 240px;  font-size:14px;">
				<option value="yes" <?php if(get_option("display_home_products") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_home_products") =="no"){ print "selected";} ?>>Hide</option>
			</select> 
<div class="clearfix"></div>
<p class="ppnote">Here you can show/hide product display on your home page.</p>

 <p><b>How Many?</b></p>
            
            <input name="adminArray[display_home_products_num]" value="<?php echo get_option("display_home_products_num"); ?>" class="txt" style="width:50px; font-size:14px;" type="text"> # Products
            
</div>


<div class="ppt-form-line">	
 
<p><b>Which Category?</b></p>

<?php $scat = get_option('display_home_products_cat'); ?>

 	<select name="adminArray[display_home_products_cat]"  style="width: 240px;  font-size:14px;">
	<option value=''>All Categories</option>
    <option value='featured' <?php if($scat == "featured"){ ?>selected=selected<?php } ?>>** All Featured Products Only **</option>
    <option value='choose' <?php if($scat == "choose"){ ?>selected=selected<?php } ?>>** All Product's I Choose **</option>
	<?php echo premiumpress_categorylist($scat,false,false,"category",0,true); ?>
</select>
<div class="clearfix"></div>
</div>

<?php if(get_option('display_home_products_cat') == "choose"){ ?>

    <p><b>Enter Post ID's Here</b></p>
            
            <input name="adminArray[display_home_products_IDs]" value="<?php echo get_option("display_home_products_IDs"); ?>" class="txt" style="width:240px; font-size:14px;" type="text"> <br> <small>e.g 1,2,3,4,5</small>
<?php } ?>  
 

<div class="ppt-form-line"><input  class="premiumpress_button" type="submit"  value="Save Changes" style="color:#fff;"/></div>

</fieldset>

 
 


            
            
            


 
 
<div class="clearfix"></div>
</form>




<?php }else{ ?>


<?php if(( strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" || strtolower(PREMIUMPRESS_SYSTEM) == "bookingpress" )){ ?>
<form method="post" name="shopperpress2" id="shopperpress2" target="_self" >
<input name="admin_page" type="hidden" value="shopperpress_setup" />
<input name="submitted" type="hidden" value="yes" />
<div class="msg msg-info">
  <p>Un tick this box to display the default child theme home page. 
    <input type="checkbox" class="checkbox" name="display_default_homepage" value="1" <?php if(get_option("display_default_homepage") =="1"){ print "checked";} ?> onchange="document.shopperpress2.submit();" />
</p>
</div>
</form>

<?php } ?>







<form method="post" name="designform55"  target="_self" > 
<input name="submitted" type="hidden" value="yes" /> 
<input type="hidden" value="6" name="showThisTab" id="showThisTab" />

<?php premiumpress_admin_display_objects_options(); // V7 HOOK ?>


<div id="optionschosenlisting" style="display:none;">

	<div class="grid400-left">
    
    <fieldset>

    <div class="titleh"><h3>Chosen Listing Options</h3></div>

    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Display Title</span>
    <input name="adminArray[ppt_object_chosenlisting_title]" type="text" class="ppt-forminput"  value="<?php echo get_option("ppt_object_chosenlisting_title");  ?>" /> 
	   
    <div class="clearfix"></div>
    </div> 
        
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Post ID's</span>
    <input name="adminArray[ppt_object_chosenlisting_ids]" type="text" class="ppt-forminput"  value="<?php echo get_option("ppt_object_chosenlisting_ids");  ?>" /> 
    <p class="ppnote">Seperate ID's with a comma. e.g. 1,2,3,4</p>	 	   
    <div class="clearfix"></div>
    </div>    
    
    
    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;"/>  </div>
 
	<a href="javascript:void(0);" onclick="toggleLayer('optionschosenlisting');" class="ppt_layout_showme">Show/Hide Options</a>
 
    
    </fieldset>
    
    </div>
    
</div>





<div id="optionsbigsearch" style="display:none;">

<div class="grid400-left">

<fieldset>
<div class="titleh"><h3>Search Box Options</h3></div>

     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Title</span>
    <input name="adminArray[ppt_object_bigsearch_title]" type="text" class="ppt-forminput"  value="<?php echo get_option("ppt_object_bigsearch_title");  ?>" /> 	 	   
    <div class="clearfix"></div>
    </div> 

     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Description Text</span>
    <textarea name="adminArray[ppt_object_bigsearch_desc]" type="text" class="ppt-forminput"><?php echo get_option("ppt_object_bigsearch_desc");  ?></textarea>
  	 	   
    <div class="clearfix"></div>
    </div> 
        
      <div class="ppt-form-line">	
    <span class="ppt-labeltext">Text Color</span>	 	 
    <input class="Multiple" type="text" value="<?php echo get_option('ppt_object_bigsearch_txtcolor');  ?>" name="adminArray[ppt_object_bigsearch_txtcolor]" style="height:25px;" />
    <div class="clearfix"></div>    
    </div> 
      
     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Background Color</span>	 	 
    <input class="Multiple" type="text" value="<?php echo get_option('ppt_object_bigsearch_color');  ?>" name="adminArray[ppt_object_bigsearch_color]" style="height:25px;" />
    <div class="clearfix"></div>    
    </div>
    
     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Background Image</span>	 	 
     <input name="adminArray[ppt_object_bigsearch_css]" type="text" id="bigsearchbg" class="ppt-forminput"  value="<?php echo get_option("ppt_object_bigsearch_css");  ?>" /> 
    <div class="clearfix"></div>
    
 <input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','bigsearchbg');" type="button"  value="View Images" style="margin-left:140px;"  />
<input id="upload_bigsearchbg" type="button" size="36" name="upload_bigsearchbg" value="Upload Image"  />   
    
    </div> 
    
    

<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;"/>  </div>
 
<a href="javascript:void(0);" onclick="toggleLayer('optionsctcats');" class="ppt_layout_showme">Show/Hide Options</a>
      

</fieldset>
</div>

</div>



 <?php if(strtolower(PREMIUMPRESS_SYSTEM) == "classifiedstheme"){ ?>
 
<div id="optionsctcats" style="display:none;">

<div class="grid400-left">

<fieldset>

<div class="titleh"><h3>Options</h3></div>

    <div class="ppt-form-line">	
    <span class="ppt-labeltext">New Listings Tab</span>	 	 
    <select name="adminArray[display_tabs_new]"class="ppt-forminput">
                    <option value="yes" <?php if(get_option("display_tabs_new") =="yes"){ print "selected";} ?>>Show</option>
                    <option value="no" <?php if(get_option("display_tabs_new") =="no"){ print "selected";} ?>>Hide</option>
                </select>
    <div class="clearfix"></div>
   Display <input name="adminArray[display_tabs_new_num]" type="text" style="width: 40px;" maxlength="3" value="<?php echo get_option("display_tabs_new_num"); ?>" /> Classifieds
                
    </div>  

 
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Popular Listings Tab</span>	 	 
<select name="adminArray[display_tabs_pop]"class="ppt-forminput">
                    <option value="yes" <?php if(get_option("display_tabs_pop") =="yes"){ print "selected";} ?>>Show</option>
                    <option value="no" <?php if(get_option("display_tabs_pop") =="no"){ print "selected";} ?>>Hide</option>
                </select>
    <div class="clearfix"></div>
  Display <input name="adminArray[display_tabs_pop_num]" type="text" style="width: 40px;" maxlength="3" value="<?php echo get_option("display_tabs_pop_num"); ?>" /> Classifieds            
    </div>                 
                
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Random Listings Tab</span>	 	 
<select name="adminArray[display_tabs_rnd]"class="ppt-forminput">
                    <option value="yes" <?php if(get_option("display_tabs_rnd") =="yes"){ print "selected";} ?>>Show</option>
                    <option value="no" <?php if(get_option("display_tabs_rnd") =="no"){ print "selected";} ?>>Hide</option>
                </select>
    <div class="clearfix"></div>
  Display <input name="adminArray[display_tabs_rnd_num]" type="text" style="width: 40px;" maxlength="3" value="<?php echo get_option("display_tabs_rnd_num"); ?>" /> Classifieds
                             
    </div> 
    
  	<p><b>Hidden Categories </b> - <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />Some times you may want to completely hide a category from dislay on your website, select a category here todo this.  &quot;);">what's this?</a></p>
 
    <select name="home_hidden_cats1_array[]" multiple="multiple" style="width:100%; height:150px;">
    <option value="0"></option>
      <?php echo premiumpress_categorylist(explode(",",get_option('home_hidden_cats1')),false,false,"category",0,true); ?>
    </select>
    <br /> <small>Hold Ctrl+Alt to select multiple</small>         
                
                    
 
<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;"/>  </div>
 
<a href="javascript:void(0);" onclick="toggleLayer('optionsctcats');" class="ppt_layout_showme">Show/Hide Options</a>
 
</fieldset>

</div><div class="grid400-left last">

 
</div>
<div class="clearfix"></div>
</div>

<?php } ?>




<div id="optionstabs" style="display:none;">

<div class="grid400-left">

<?php for($i=0; $i < 5; $i++){ ?>
<fieldset>

<div id="tabsid<?php echo $i; ?>" style="display:none;">
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Title 1 Title</span>	 	 
     <input name="adminArray[ppt_object_tabs_tab_title_<?php echo $i; ?>]" type="text" class="ppt-forminput"  value="<?php echo get_option("ppt_object_tabs_tab_title_".$i);  ?>" /> 
    <div class="clearfix"></div>
    </div>  
 
    
     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Content (accepts html)</span>	 	 
    <textarea class="ppt-forminput" style="height:200px;" name="adminArray[ppt_object_tabs_tab_content_<?php echo $i; ?>]"><?php echo stripslashes(get_option("ppt_object_tabs_tab_content_".$i));  ?></textarea>
    <div class="clearfix"></div>
    </div>   
   
     <p><b>Carousel Query String (Leave blank to disable)</b></p>
      <input name="adminArray[ppt_object_tabs_tab_query_<?php echo $i; ?>]" type="text" style="width:370px;" class="ppt-forminput"  value="<?php echo get_option("ppt_object_tabs_tab_query_".$i);  ?>" /><br />
   
    <p>A custom query is made up of the normal Wordpress post_query statements, for example, the featured listing query is;</p>
    <p><b>meta_key=featured&amp;meta_value=yes&amp;posts_per_page=25</b></p>
    <p> <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank">for more information click here.</a></p>  

    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;"/></div>  
  

</div>
<a href="javascript:void(0);" onclick="toggleLayer('tabsid<?php echo $i; ?>');" class="ppt_layout_showme" style="width:200px;">show/hide tab <?php $a = $i; $a++; echo $a; ?> options</a>
</fieldset>
<?php } ?>

<div class="clearfix"></div>
</div>


</div>











<div id="optionsmpvideo" style="display:none;">

<div class="grid400-left">

<fieldset>

<div class="titleh"><h3>Featured Video Options</h3></div>
<?php $vd = get_option('ppt_homepage_video'); ?>

<script type="application/javascript">
function ChageVideoType(type){
if(type == "youtube"){
jQuery('#videotype1').show();
jQuery('#videotype2').hide();
document.getElementById('videotypeextra').innerHTML= "<input type='hidden' name='reshowvideo' value='1' />";
}else{
jQuery('#videotype2').show();
jQuery('#videotype1').hide();
document.getElementById('videotypeextra').innerHTML= "";
}

}
</script>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Video Type</span>	 
<select name="ppt_homepage_video[type]" class="ppt-forminput" onchange="ChageVideoType(this.value);">
<option>----</option>
<option value="custom" <?php if($vd['type'] == "custom"){ echo "selected=selected"; } ?>>Custom Video</option>
<option value="youtube" <?php if($vd['type'] == "youtube"){ echo "selected=selected"; } ?>>Youtube Video</option>
</select>
<div class="clearfix"></div>
</div>


<div class="clearfix" id="videotypeextra"></div>

<div class="ppt-form-line" id="videotype2" <?php if($vd['type'] != "custom"){ ?>style="display:none;" <?php } ?>>	
<p>Enter Video Filename - Must be stored in your thumbs folder.</p>	 
<input name="ppt_homepage_video[filename]" id="videofilename" type="text" class="ppt-forminput"  value="<?php echo $vd['filename']; ?>" style="width:350px;"/> 
<div class="clearfix"></div>
<small>Supports FLV , F4V , MP4 , M4A , MOV , MP4V , 3GP, and 3G2</small><br />
<a style="text-decoration:underline;" href='javascript:void(0);' onclick="toggleLayer('DisplayImages'); add_video_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','videofilename');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/premiumpress/led-ico/find.png" align="middle"> View Video Files</a>
<br /><br />
Auto Start on page load?
<select name="ppt_homepage_video[autostart]" class="ppt-forminput">
<option>----</option>
<option value="yes" <?php if($vd['autostart'] == "yes"){ echo "selected=selected"; } ?>>Yes</option>
<option value="no" <?php if($vd['autostart'] == "no"){ echo "selected=selected"; } ?>>No</option>
</select>
<br /><br />
<input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;"/> 
</div>
 
<div class="ppt-form-line" id="videotype1" <?php if($vd['type'] != "youtube"){ ?>style="display:none;" <?php } ?>>	
<p>Enter YouTube Video Page Link - NOT the embed code.</p>	 
<input name="ppt_homepage_video[youtube]" id="v5" type="text" class="ppt-forminput"  value="<?php echo $vd['youtube']; ?>" style="width:350px;"/> 
<div class="clearfix"></div>
 
<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="Save Video Settings" style="color:white;"/>  
 
</div>
 </fieldset>

<input name="ppt_homepage_video[youtube-current]" id="v1" type="hidden" class="ppt-forminput"  value="<?php echo $vd['youtube'];; ?>" />
 

</div>
<div class="grid400-left last">
<?php if(  strlen($vd['youtube-image']) > 1 ){ ?>
<img src="<?php  echo $vd['youtube-image']; ?>" style="max-width:350px; max-height:350px; margin-left:60px;" id="youtubeImg"/>
<?php } ?>
</div>
<div class="clearfix"></div>

</div>





<div id="optionsmapme" style="display:none;">

    <div class="grid400-left">
    <fieldset>
    <div class="titleh"><h3>Google Map Options</h3></div>
    
    <script type="application/javascript">
	function ChageMapBox(type){
	
	if(type == "f"){document.getElementById('mapquery').value= "meta_key=featured&meta_value=yes&posts_per_page=25";	}
	if(type == "l"){document.getElementById('mapquery').value= "orderby=ID&order=desc&posts_per_page=25";	}
	 
	
	}
	</script>
    
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Predefined Queries</span>	 	 
    <select class="ppt-forminput" onchange="ChageMapBox(this.value);">
    <option>----</option>
    <option value="f">Featured Listings</option>
    <option value="l">Last Posts</option>
    </select>
    <div class="clearfix"></div>
    <small>Changing the value here will update the custom string below.</small>
    </div>      
    
    <p><b>Custom Search Query </b></p>
      <input name="adminArray[ppt_object_map_query]" id="mapquery" type="text"  class="ppt-forminput" style="width:370px;"  value="<?php if(get_option("ppt_object_map_query") == ""){ echo "meta_key=featured&meta_value=yes&posts_per_page=25"; }else{ echo get_option("ppt_object_map_query");}  ?>" /><br />
    <p class="ppnote">A custom query is made up of the normal Wordpress post_query statements. The query entered above will be used to get the markers for your map. <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank">LEarn how to create custom queries here.</a></p>
 
 
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Zoom Level</span>	 	 
     <input name="adminArray[ppt_object_map_zoom]" type="text" class="ppt-forminput" style="width:50px;" value="<?php if(get_option("ppt_object_map_zoom") == ""){ echo "5"; }else{ echo get_option("ppt_object_map_zoom");  } ?>" /> 
    <div class="clearfix"></div>
    </div>   
 
 
    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;"/></div>  
    
    <a href="javascript:void(0);" onclick="toggleLayer('optionsmapme');" class="ppt_layout_showme">close window</a>
    </fieldset>
    
    </div><div class="grid400-left last">
    
    
    </div><div class="clearfix"></div>
    
   
</div>



<div id="optionshometext" style="display:none;">

    <fieldset> 
    <div class="titleh"><h3>Custom Home Page Content</h3></div>
    <div class="ppt-form-line">	
    <?php  wp_editor(stripslashes(get_option("ppt_homepage_html")), 'adminArray[ppt_homepage_html]' ); ?>
    <div class="clearfix"></div></div>
    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>
     <a href="javascript:void(0);" onclick="toggleLayer('optionshometext');" class="ppt_layout_showme">close window</a>
    </fieldset>
    
</div>



<div id="optionswidget" style="display:none;">

<div class="grid400-left">
	<fieldset>
    <div class="titleh"><h3>Widget Display Options</h3></div>
    <p><b>Select Widget Bar To Include</b></p>    			
    <select name="adminArray[ppt_object_widget_bar]" class="ppt-forminput">    
    <option value="Home Page Widget Box" <?php if(get_option("ppt_object_widget_bar") =="Home Page Widget Box"){ print "selected";} ?>>Home Page Widget Box</option>
     <option value="Right Sidebar" <?php if(get_option("ppt_object_widget_bar") =="Right Sidebar"){ print "selected";} ?>>Right Sidebar</option>
    <option value="Left Sidebar (3 Column Layouts Only)" <?php if(get_option("ppt_object_widget_bar") =="Left Sidebar"){ print "selected";} ?>>Left Sidebar (3 Column Layouts Only)</option>
    <option value="Listing Page" <?php if(get_option("ppt_object_widget_bar") =="Listing Page"){ print "selected";} ?>>Listing Page</option>
    <option value="Pages Sidebar" <?php if(get_option("ppt_object_widget_bar") =="Pages Sidebar"){ print "selected";} ?>>Pages Sidebar</option>
    <option value="Article/FAQ Page Sidebar" <?php if(get_option("ppt_object_widget_bar") =="Article/FAQ Page Sidebar"){ print "selected";} ?>>Article/FAQ Page Sidebar</option>
    <option value="Footer Left Block (1/3)" <?php if(get_option("ppt_object_widget_bar") =="Footer Left Block (1/3)"){ print "selected";} ?>>Footer Left Block (1/3)</option>
    <option value="Footer Middle Block (2/3)" <?php if(get_option("ppt_object_widget_bar") =="Footer Middle Block (2/3)"){ print "selected";} ?>>Footer Middle Block (2/3)</option>
    <option value="Footer Right Block (3/3)" <?php if(get_option("ppt_object_widget_bar") =="Footer Right Block (3/3)"){ print "selected";} ?>>Footer Right Block (3/3)</option> 
    </select><br />
    <p class="ppnote">Select a widget bar and then add widgets as normal using the <a href="widgets.php">Wordpress widgets area</a>. The widgets you add will then appear on your home page.</p>                
    <div class="clearfix"></div>
    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div> 
	<a href="javascript:void(0);" onclick="toggleLayer('optionswidget');" class="ppt_layout_showme">close window</a>
	</fieldset>
    
</div><div class="grid400-left last" style="width:400px;">
<div class="videobox" id="videoboxxx1"> 
<a href="javascript:void(0);" onclick="PlayPPTVideo('4vIb-yx3N0k','videoboxxx1');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/13.jpg" align="absmiddle" /></a>
</div> 
</div>
<div class="clearfix"></div>
</div> 



<div id="optionscarousel" style="display:none;">

	<div class="grid400-left">
    
    <fieldset>

    <div class="titleh"><h3>Carousel Display Options</h3></div>
    <script type="application/javascript">
	function ChageCType(type){ if(type == "3"){ jQuery('#ctc').show(); }else{ jQuery('#ctc').hide(); } }
	</script>
    
     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Display Content</span>	 	 
	<select name="adminArray[ppt_object_carousel_query]" class="ppt-forminput" onchange="ChageCType(this.value);">
    <option value="1" <?php if(get_option("ppt_object_carousel_query") =="1"){ print "selected";} ?>>Featured Listings Only</option>
    <option value="2" <?php if(get_option("ppt_object_carousel_query") =="2"){ print "selected";} ?>>Latest Listings</option>
    <option value="3" <?php if(get_option("ppt_object_carousel_query") =="3"){ print "selected";} ?>>Custom Query</option>
    </select>
    <div class="clearfix"></div>
    <small><b>Note:</b> only listing with images will show.</small>
    </div> 
    
   
     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Padding Top</span>	 	 
    <select name="adminArray[ppt_object_carousel_query_padding]" class="ppt-forminput">
    <option value="1" <?php if(get_option("ppt_object_carousel_query_padding") =="1"){ print "selected";} ?>>Yes (10px Padding Top)</option>
    <option value="0" <?php if(get_option("ppt_object_carousel_query_padding") =="0"){ print "selected";} ?>>No (0px Padding Top)</option> 
    </select> 
    <div class="clearfix"></div>
    </div> 
    
    
    
    <div <?php if(get_option("ppt_object_carousel_query") != 3){ ?>style="display:none;"<?php } ?> id="ctc">
     <p><b>Custom Query String</b></p>
      <input name="adminArray[ppt_object_carousel_custom]" type="text" style="width:370px;" class="ppt-forminput"  value="<?php if(get_option("ppt_object_carousel_custom") == ""){ echo "meta_key=featured&meta_value=yes&posts_per_page=25"; }else{ echo get_option("ppt_object_carousel_custom");}  ?>" /><br />
    <p>A custom query is made up of the normal Wordpress post_query statements, for example, the featured listing query is;</p>
    <p><b>meta_key=featured&amp;meta_value=yes&amp;posts_per_page=25</b></p>
    <p> <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank">for more information click here.</a></p>
     </div>  
    
    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>  
	<a href="javascript:void(0);" onclick="toggleLayer('optionscarousel');" class="ppt_layout_showme">close window</a>
    
    </fieldset>
    
    </div><div class="grid400-left last">
    
    </div>
	<div class="clearfix"></div>

</div> 



<div id="optionsrecent" style="display:none;">

	<div class="grid400-left">
    
	<fieldset>
 <script type="application/javascript">
	function ChageBType(type){ if(type == "3"){ jQuery('#ctc1').show(); }else{ jQuery('#ctc1').hide(); } }
	</script>
    <div class="titleh"><h3>Recent Listings Display Options</h3></div> 
    
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Box Title</span>	 	 
     <input name="adminArray[ppt_object_recent_title]" type="text" class="ppt-forminput"  value="<?php echo get_option("ppt_object_recent_title");  ?>" /> 
    <div class="clearfix"></div>
    </div>   
    
    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Display Type</span>	 	 
<select name="adminArray[ppt_object_recent_type]" class="ppt-forminput" onchange="ChageBType(this.value);">
    <option value="1" <?php if(get_option("ppt_object_recent_type") =="1"){ print "selected";} ?>>Compact</option>
    <option value="2" <?php if(get_option("ppt_object_recent_type") =="2"){ print "selected";} ?>>Full</option>
    <option value="3" <?php if(get_option("ppt_object_recent_type") =="3"){ print "selected";} ?>>Custom Query</option>
    </select>    
    <?php /*
    	<div style="margin-left:140px;">
         <p><b># of listing to display</b></p>
         <input name="adminArray[ppt_object_recent_num]" type="text" style="width: 100px;  font-size:14px;" value="<?php if(get_option("ppt_object_recent_num") == ""){ echo "10"; }else{ echo get_option("ppt_object_recent_num"); } ?>" /><br />
        <small>a numeric value, for example: 5.</small>
        </div>
		*/ ?>
    </div>      
    
 <div <?php if(get_option("ppt_object_recent_type") != 3){ ?>style="display:none;"<?php } ?> id="ctc1">
 <div class="ppt-form-line">	
    
     <p><b>Custom Query String</b></p>
      <input name="adminArray[ppt_object_recent_custom]" type="text" class="ppt-forminput"  value="<?php if(get_option("ppt_object_recent_custom") == ""){ echo "meta_key=featured&meta_value=yes&posts_per_page=25"; }else{ echo get_option("ppt_object_recent_custom");}  ?>" /><br />
    <p>A custom query is made up of the normal Wordpress post_query statements, for example, the featured listing query is;</p>
    <p><b>meta_key=featured&amp;meta_value=yes&amp;posts_per_page=25</b></p>
    <p> <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank">for more information click here.</a></p>    
     </div>   
    </div>
    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div> 
	<a href="javascript:void(0);" onclick="toggleLayer('optionsrecent');" class="ppt_layout_showme">close window</a>
    
    </fieldset>
    
     </div><div class="grid400-left last">
    
    </div>
	<div class="clearfix"></div>   
    
</div>





<div id="options2columns" style="display:none;">
<fieldset style="padding:0px; padding-top:10px;">

    <div class="grid400-left">
    <p><b>Left Column Content</b> - Accepts HTML/Shortcodes</p>
        <textarea class="ppt-forminput" style="height:400px;width:350px;" name="adminArray[ppt_object_2columns_1]"><?php echo stripslashes(get_option("ppt_object_2columns_1"));  ?></textarea>
 
    </div>
    
    <div class="grid400-left last">
    <p><b>Right Column Content</b> - Accepts HTML/Shortcodes</p>
        <textarea class="ppt-forminput" style="height:400px;width:350px;" name="adminArray[ppt_object_2columns_2]"><?php echo stripslashes(get_option("ppt_object_2columns_2"));  ?></textarea>
 
    </div>

<div class="clearfix"></div>

 <div style="padding:10px;">
 
    <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;"/></div>  
    
    <a href="javascript:void(0);" onclick="toggleLayer('optionsmapme');" class="ppt_layout_showme">close window</a>
 
 </div>   
    
    
</fieldset>
</div>




<div id="optionscategories" style="display:none;">
<fieldset>
<div class="titleh"><h3>Categories Box Display Options</h3></div> 
 
<div class="grid400-left">

    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Box Title</span>	 	 
     <input name="adminArray[display_homecats_title]" type="text" class="ppt-forminput"  value="<?php echo get_option("display_homecats_title");  ?>" />
    <div class="clearfix"></div>
    </div> 

     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Display Type</span>	 	 
     <select name="adminArray[display_homecats_type]" class="ppt-forminput">
                    <option value="compact" <?php if(get_option("display_homecats_type") =="compact"){ print "selected";} ?>>Compact View - No Icons</option>
                    <option value="full" <?php if(get_option("display_homecats_type") =="full"){ print "selected";} ?>>Full View</option>
                </select>
    <div class="clearfix"></div>    
    </div> 

     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Category Order</span>	 	 
      <select name="adminArray[display_homecats_orderby]" class="ppt-forminput">
    
                    <option value="id" <?php if(get_option("display_homecats_orderby") =="id"){ print "selected";} ?>>ID (Ascending Order)</option>
                    <option value="id&order=desc" <?php if(get_option("display_homecats_orderby") =="id&order=desc"){ print "selected";} ?>>ID (Descending Order)</option>
                    
                    <option value="name" <?php if(get_option("display_homecats_orderby") =="name"){ print "selected";} ?>>Name (Ascending Order)</option>
                    <option value="name&order=desc" <?php if(get_option("display_homecats_orderby") =="name&order=desc"){ print "selected";} ?>>Name (Descending Order)</option>
                    
                    <option value="slug" <?php if(get_option("display_homecats_orderby") =="slug"){ print "selected";} ?>>Slug (Ascending Order)</option>
                    <option value="slug&order=desc" <?php if(get_option("display_homecats_orderby") =="slug&order=desc"){ print "selected";} ?>>Slug (Descending Order)</option>
    
                    <option value="count" <?php if(get_option("display_homecats_orderby") =="count"){ print "selected";} ?>>Count (Ascending Order)</option>
                    <option value="count&order=desc" <?php if(get_option("display_homecats_orderby") =="count&order=desc"){ print "selected";} ?>>Count (Descending Order)</option>
    
                                    
          </select>
    <div class="clearfix"></div>    
    </div> 
       
 
    
    
     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Display Sub Categories</span>	 	 
     <select name="adminArray[display_50_subcategories]" class="ppt-forminput">
                    <option value="yes" <?php if(get_option("display_50_subcategories") =="yes"){ print "selected";} ?>>Show Box</option>
                    <option value="no" <?php if(get_option("display_50_subcategories") =="no"){ print "selected";} ?>>Hide / Disable</option>
                </select>
    <div class="clearfix"></div>
     <div style="margin-left:140px;">#<input name="adminArray[display_homecats_num]" type="text" style="width: 80px;  font-size:14px;" class="ppt-forminput" value="<?php if(get_option("display_homecats_num") ==""){ echo "3"; }else{ echo get_option("display_homecats_num"); } ?>" /></div>
   
    <small>Show/Hide the list of sub categories under the main category title.</small>  
    </div>
  
      

</div><div class="grid300-left last">  
  
  	<p><b>Hidden Categories </b> - <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />Some times you may want to completely hide a category from dislay on your website, enter a category here todo this. &quot;);">what's this?</a></p>
 
    <select name="home_hidden_cats_array[]" multiple="multiple" style="width:100%; height:150px;">
    <option value="0"></option>
      <?php echo premiumpress_categorylist(explode(",",get_option('home_hidden_cats')),false,false,"category",0,true); ?>
    </select>
    <br /> <small>Hold Ctrl+Alt to select multiple</small>
  
            
</div> 

<div class="clearfix"></div>

<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>  
<a href="javascript:void(0);" onclick="toggleLayer('optionscategories');" class="ppt_layout_showme">close window</a>
 </form>
 
 </fieldset>            
</div> 








<div class="grid400-left">

<fieldset>
<div class="titleh"><h3>


<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Inactive Home Page Objects

<a href="http://www.premiumpress.com/tutorial/home-page-objects/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div>
 <p>Drag and Drop the objects you want to display home page.</p>

<div class="ppt-form-line">	

<?php 
$used_items = get_option('ppt_layout_block'); if($used_items == ""){ $used_items = array(); }

$ic =0;

$available_items[$ic]['name'] 	= "Category Block";
$available_items[$ic]['desc'] 	= "add categories to your home page";
$available_items[$ic]['icon'] 	= "block1.png";
$available_items[$ic]['id'] 		= "categories";
$available_items[$ic]['options']	= true;
$ic++;

$available_items[$ic]['name'] 	= "Website Listings";
$available_items[$ic]['desc'] 	= "display a block of your website listing";
$available_items[$ic]['icon'] 	= "block2.png";
$available_items[$ic]['id'] 		= "recent";
$available_items[$ic]['options']	= true;
$ic++;
$available_items[$ic]['name'] 	= "Basic Carousel";
$available_items[$ic]['desc'] 	= "add a carousel to your home page";
$available_items[$ic]['icon'] 	= "block3.png";
$available_items[$ic]['id'] 		= "carousel";
$available_items[$ic]['options']	= true;
$ic++;
$available_items[$ic]['name'] 	= "Attach Widget Bar";
$available_items[$ic]['desc'] 	= "attach one of your widget bars to your home page";
$available_items[$ic]['icon'] 	= "block5.png";
$available_items[$ic]['id'] 		= "widget";
$available_items[$ic]['options']	= true;
$ic++;
$available_items[$ic]['name'] 	= "Home Page Text";
$available_items[$ic]['desc'] 	= "add text to the home page";
$available_items[$ic]['icon'] 	= "block8.png";
$available_items[$ic]['id'] 		= "hometext";
$available_items[$ic]['options']	= true;
$ic++;
$available_items[$ic]['name'] 	= "Home Page Video";
$available_items[$ic]['desc'] 	= "add a video to your home page";
$available_items[$ic]['icon'] 	= "block10.png";
$available_items[$ic]['id'] 		= "mpvideo";
$available_items[$ic]['options']	= true;
$ic++;
$available_items[$ic]['name'] 	= "Google Map";
$available_items[$ic]['desc'] 	= "add a Google map on your home page";
$available_items[$ic]['icon'] 	= "block11.png";
$available_items[$ic]['id'] 		= "mapme";
$available_items[$ic]['options']	= true;
$ic++;
$available_items[$ic]['name'] 		= "Tab Display";
$available_items[$ic]['desc'] 		= "add custom tabs on your home page";
$available_items[$ic]['icon'] 		= "block_tabs.png";
$available_items[$ic]['id'] 		= "tabs";
$available_items[$ic]['options']	= true;
$ic++;

$available_items[$ic]['name'] 		= "Big Search Box";
$available_items[$ic]['desc'] 		= "add a search box to your home page";
$available_items[$ic]['icon'] 		= "bigsearch.png";
$available_items[$ic]['id'] 		= "bigsearch";
$available_items[$ic]['options']	= true;
$ic++;

$available_items[$ic]['name'] 		= "Chosen Listings";
$available_items[$ic]['desc'] 		= "pick and choose which listings to be displayed";
$available_items[$ic]['icon'] 		= "chosenlisting.png";
$available_items[$ic]['id'] 		= "chosenlisting";
$available_items[$ic]['options']	= true;
$ic++;

$available_items[$ic]['name'] 		= "2 Column Layout";
$available_items[$ic]['desc'] 		= "here you can add a two column layout";
$available_items[$ic]['icon'] 		= "2columns.png";
$available_items[$ic]['id'] 		= "2columns";
$available_items[$ic]['options']	= true;
$ic++;

if(strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){


$available_items[$ic]['name'] 	= "Google Map + Property";
$available_items[$ic]['desc'] 	= "attach one of your widget bars to your home page";
$available_items[$ic]['icon'] 	= "block6.png";
$available_items[$ic]['id'] 		= "rpmap";
$available_items[$ic]['options']	= false;
$ic++;
$available_items[$ic]['name'] 	= "Search Box";
$available_items[$ic]['desc'] 	= "attach one of your widget bars to your home page";
$available_items[$ic]['icon'] 	= "block7.png";
$available_items[$ic]['id'] 		= "rpsearch";
$available_items[$ic]['options']	= false;
$ic++;
 
}elseif(strtolower(PREMIUMPRESS_SYSTEM) == "classifiedstheme"){

$available_items[$ic]['name'] 	= "V6 Categories Block";
$available_items[$ic]['desc'] 	= "display the old style categories on your home page";
$available_items[$ic]['icon'] 	= "block12.png";
$available_items[$ic]['id'] 		= "ctcats";
$available_items[$ic]['options']	= true;
$ic++;
}

$available_items = premiumpress_admin_display_objects($available_items);
 
 
?>


<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
<?php foreach($available_items as $item){ if(!in_array($item['id'], $used_items)){ ?>
<li><div><img src="<?php if(strpos($item['icon'], "http://") === false) { echo $GLOBALS['template_url'].'/PPT/img/admin/new/'.$item['icon']; }else{ echo $item['icon'];  } ?>" /></div>
<h4><?php echo $item['name']; ?> </h4><?php echo $item['desc']; ?> <br /> 

<?php if($item['options']){ ?><a href="javascript:void(0);" onclick="toggleLayer('options<?php echo $item['id']; ?>');">show / edit options</a><?php } ?>

<input type="hidden" name="ppt_layout_block[]" value="<?php echo $item['id']; ?>"/></li>
<?php } } ?>
</ul>
<div class="clearfix"></div>
</div>

</fieldset> 


 

</div>
<div class="grid400-left last">

<fieldset>
<div class="titleh"><h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Active Home Page Objects</h3></div>
 
<form method="post" name="designform"  target="_self" > 
<input name="submitted" type="hidden" value="yes" />
<input name="ppt_droplist" type="hidden" value="yes" /> 
<input type="hidden" value="6" name="showThisTab" id="showThisTab" />

<div id="trash" class="ui-widget-content ui-state-default">
    
<?php if(is_array($used_items)){foreach($used_items as $thisone){ foreach($available_items as $item){ if($thisone == $item['id']){ ?>
    
<li><div><img src="<?php if(strpos($item['icon'], "http://") === false) { echo $GLOBALS['template_url'].'/PPT/img/admin/new/'.$item['icon']; }else{ echo $item['icon'];  } ?>"/></div>
<h4><?php echo $item['name']; ?></h4><?php echo $item['desc']; ?>
<input type="hidden" name="ppt_layout_block[]" value="<?php echo $item['id']; ?>"/><br />
<?php if($item['options']){ ?><a href="javascript:void(0);" onclick="toggleLayer('options<?php echo $item['id']; ?>');">show / edit options</a> <?php } ?>
</li>
<?php } } } } ?>
 
    
</div> 
<div class="clearfix"></div>
<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>
<small><b>Note:</b>You need to save the widgets before you can change their display order.</small>
</form>

</fieldset>
 

</div>
<div class="clearfix"></div>
 
 
 <?php } // end if shopperpress ?>
 
</div>




















<div id="premiumpress_tab2" class="content">
<form method="post" name="designform2"  id="designform2" target="_self" > 
<input name="submitted" type="hidden" value="yes" /> 
<input type="hidden" value="2" name="showThisTab" id="showThisTab" />



<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress" && isset($_POST['storeIDChanger']) && $_POST['storeIDChanger'] !=""){ $term = get_term( $_POST['storeIDChanger'], "store" );   ?>

 
<fieldset>
<div class="titleh"><h3>Customize <?php echo $term->name; ?></h3></div>
<p><b><?php echo $term->name; ?> - Store Icon</b> </p>  
<input name="adminArray[store_<?php echo $_POST['storeIDChanger']; ?>_logo]" id="logo" type="text" class="txt" style="width: 100%;font-size:14px;" value="<?php echo get_option('store_'.$_POST['storeIDChanger'].'_logo'); ?>" />
<p class="ppnote">Store icons are used with the 'store widget' only and displayed on the sidebar.</p>  
<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','logo');" type="button"   value="View Images"  />
<input id="upload_logo" type="button" size="36" name="upload_logo" value="Upload Image"  />
<p><br /><b><?php echo $term->name; ?> - Store Page Description</b> </p>   
<?php  wp_editor(stripslashes(get_option('store_'.$_POST['storeIDChanger'].'_desc')), 'adminArray[store_'.$_POST['storeIDChanger'].'_desc]' ); ?>
</fieldset>   
<?php } ?>


<div class="grid400-left">
 


<fieldset>

<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Search Results Display

<a href="http://www.premiumpress.com/tutorial/search-results-display/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "couponpress"){ ?> 
<div class="ppt-form-line">	

<input type="hidden" id="display_liststyle" name="adminArray[display_liststyle]" value="<?php echo get_option("display_liststyle"); ?>" />	
<ul class="ppt_layout_columns">
<li <?php if(get_option("display_liststyle") =="list"){echo"class='active'";} ?> style="margin-left:50px;"><a href="javascript:document.getElementById('display_liststyle').value='list';document.designform2.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/l2.png"  /></a></li>
<li <?php if(get_option("display_liststyle") =="gal"){echo"class='active'";} ?>><a href="javascript:document.getElementById('display_liststyle').value='gal';document.designform2.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/l1.png"  /></a></li>
</ul>
<div class="clearfix"></div>
</div>
<?php }else{ ?>
<input type="hidden" id="display_liststyle" name="adminArray[display_liststyle]" value="list" />	
<?php } ?>

 


<p class="ppnote" >Choose how the search results are displayed, in a list or as a gallery.</p>


<div class="ppt-form-line">     
<span class="ppt-labeltext">Listings Per Page</span>
	<input name="adminArray[posts_per_page]" type="text" class="ppt-forminput"  value="<?php $pp = get_option("posts_per_page"); if($pp == ""){ echo "12"; }else{  echo $pp; } ?>" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">     
<span class="ppt-labeltext">Articles Per Page</span>
	<input name="adminArray[articles_per_page]" type="text" class="ppt-forminput"  value="<?php $pp = get_option("articles_per_page"); if($pp == ""){ echo "6"; }else{  echo $pp; } ?>" /> 
<div class="clearfix"></div>
</div>  
 

<p class="ppnote">Here you choose how many listings to be displayed per page. Enter a numeric value such as 10,20,30</p>
 
<div class="ppt-form-line">     
<span class="ppt-labeltext">Display Order</span>
<select name="adminArray[display_defaultorder]" class="ppt-forminput">

<option value="date*desc" <?php if(get_option("display_defaultorder") =="date*desc"){ print "selected";} ?>>Date (Newest First)</option>
<option value="date*asc" <?php if(get_option("display_defaultorder") =="date*asc"){ print "selected";} ?>>Date (Newest Last)</option>

<?php /* ============================ ================================= */ if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "bookingpress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "realtorpress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "comparisonpress"){  ?>
<option value="meta_value&meta_key=price*desc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=price*desc"){ print "selected";} ?>>Price (Highest First)</option>
<option value="meta_value&meta_key=price*asc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=price*asc"){ print "selected";} ?>>Price (Lowest First) </option>
<?php } ?>

<?php /* ============================ ================================= */ if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress"){  ?>
<option value="meta_value&meta_key=pexpires*desc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=pexpires*desc"){ print "selected";} ?>>Coupon Expiry Date (Expiring Last) </option>
<option value="meta_value&meta_key=pexpires*asc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=pexpires*asc"){ print "selected";} ?>>Coupon Expiry Date (Expiring Soon) </option>
<?php } ?>

<?php /* ============================ ================================= */ if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "auctionpress"){  ?>
<option value="meta_value&meta_key=pexpires*desc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=pexpires*desc"){ print "selected";} ?>>Auction Item Expiry Date (Expiring Last) </option>
<option value="meta_value&meta_key=pexpires*asc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=pexpires*asc"){ print "selected";} ?>>Auction Item Expiry Date (Expiring Soon) </option>
<?php } ?>

<option value="meta_value&meta_key=featured*desc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=featured*desc"){ print "selected";} ?>>Featured Listings (First)</option>
 
<option value="author*asc" <?php if(get_option("display_defaultorder") =="author*asc"){ print "selected";} ?>>Author (A-z) </option>
<option value="author*desc" <?php if(get_option("display_defaultorder") =="author*desc"){ print "selected";} ?>>Author (Z-a)</option>


<option value="title*asc" <?php if(get_option("display_defaultorder") =="title*asc"){ print "selected";} ?>>Product Title (A-z)</option>
<option value="title*desc" <?php if(get_option("display_defaultorder") =="title*desc"){ print "selected";} ?>>Product Title (Z-a)</option>

<option value="modified*asc" <?php if(get_option("display_defaultorder") =="modified*asc"){ print "selected";} ?>>Date Modified (Newest Last)</option>
<option value="modified*desc" <?php if(get_option("display_defaultorder") =="modified*desc"){ print "selected";} ?>>Date Modified (Newest First)</option>
  

<option value="ID*asc" <?php if(get_option("display_defaultorder") =="ID*asc"){ print "selected";} ?>>Wordpress POST ID (0 - 1)</option>
<option value="ID*desc" <?php if(get_option("display_defaultorder") =="ID*desc"){ print "selected";} ?>>Wordpress POST ID (1 - 0)</option>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) !== "shopperpress"){ ?>
<option value="meta_value&meta_key=packageID*desc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=packageID*desc"){ print "selected";} ?>>Upgrade Package ID (1 - 8)</option>
<option value="meta_value&meta_key=packageID*asc" <?php if(get_option("display_defaultorder") =="meta_value&meta_key=packageID*asc"){ print "selected";} ?>>Upgrade Package ID (8 - 1) </option>
<?php } ?>


<option value="rand*asc" <?php if(get_option("display_defaultorder") =="rand*asc"){ print "selected";} ?>>Random Display</option>
 </select>
<div class="clearfix"></div>
<?php if(get_option("display_defaultorder") =="meta_value&meta_key=featured*desc"){ ?><p class="ppnote"><b>Note</b> Featured listings will show above all other listings and are not included in the 'results per page' calculations.</p><?php } ?>
 
</div>
 
 
	 
<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress"){ ?> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Coupon Hover Effect</span>	 
<select name="adminArray[couponpress_search_hover]" class="ppt-forminput">
<option value="on" <?php if(get_option("couponpress_search_hover") == "on"){ echo "selected='selected'"; } ?>>Show Buttons When Hovering</option>
<option value="always" <?php if(get_option("couponpress_search_hover") == "always"){ echo "selected='selected'"; } ?>>Always Show (no hover)</option>
<option value="off" <?php if(get_option("couponpress_search_hover") == "off"){ echo "selected='selected'"; } ?>>Hide/ Do Not Show</option>
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">iFrame</span>	 
<select name="adminArray[couponpress_iframe]" class="ppt-forminput">
<option value="on" <?php if(get_option("couponpress_iframe") == "on"){ echo "selected='selected'"; } ?>>Enabled</option>
<option value="off" <?php if(get_option("couponpress_iframe") == "off"){ echo "selected='selected'"; } ?>>Disabled</option> 
</select>
<div class="clearfix"></div>
</div>
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Coupon Display</span>	 
<select name="adminArray[system]" class="ppt-forminput">
<option value="clicktoreveal" <?php if(get_option("system") == "clicktoreveal"){ echo "selected='selected'"; } ?>>Click To Reveal</option>
<option value="normal" <?php if(get_option("system") == "normal"){ echo "selected='selected'"; } ?>>Click To Copy</option>
<option value="link" <?php if(get_option("system") == "link"){ echo "selected='selected'"; } ?>>Link Display</option>
</select> 
<div class="clearfix"></div>
</div>	

<div class="ppt-form-line">	
<span class="ppt-labeltext">Rating System</span>	 
<select name="adminArray[couponpress_didwork]" class="ppt-forminput">
<option value="on" <?php if(get_option("couponpress_didwork") == "on"){ echo "selected='selected'"; } ?>>Show</option>
<option value="off" <?php if(get_option("couponpress_didwork") == "off"){ echo "selected='selected'"; } ?>>Hide</option>
</select>
<div class="clearfix"></div>
</div>	

<div class="ppt-form-line">	
<span class="ppt-labeltext">Print Icon</span>	 
<select name="adminArray[couponpress_printbtn]" class="ppt-forminput">
<option value="on" <?php if(get_option("couponpress_printbtn") == "on"){ echo "selected='selected'"; } ?>>Show</option>
<option value="off" <?php if(get_option("couponpress_printbtn") == "off"){ echo "selected='selected'"; } ?>>Hide</option>
</select>
<div class="clearfix"></div>
</div>	
      
<?php } ?>
 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Sub Categories</span>	 
<select name="adminArray[display_sub_categories]" class="ppt-forminput">
				 <option value="yes" <?php if(get_option("display_sub_categories") =="yes"){ print "selected";} ?>>Show </option>
				<option value="no" <?php if(get_option("display_sub_categories") =="no"){ print "selected";} ?>>Hide</option>
                
			</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Save Search/ Email Alert</span>	 
<select name="adminArray[display_gallery_saveoptions]" class="ppt-forminput">
<option value="yes" <?php if(get_option("display_gallery_saveoptions") =="yes"){ print "selected";} ?>>Show </option>
<option value="no" <?php if(get_option("display_gallery_saveoptions") =="no"){ print "selected";} ?>>Hide</option>
</select>
<div class="clearfix"></div>
</div>

<?php /*
<div class="ppt-form-line">	
<span class="ppt-labeltext">"Comments" Link</span>	 
<select name="adminArray[display_search_comments]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_search_comments") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_search_comments") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>
*/ ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Tags</span>	 
<select name="adminArray[display_search_tags]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_search_tags") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_search_tags") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress"){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">"View Website" Link</span>	 
<select name="adminArray[display_search_publisher]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_search_publisher") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_search_publisher") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>
<?php } ?>

<p><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" onclick="document.getElementById('showThisTab').value=2" /></p>


</fieldset>


</div>
 
<div class="grid400-left last">



<fieldset>

<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Listing Page Display Options

<a href="http://www.premiumpress.com/tutorial/listing-page-display-options/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div>

<p class="ppnote">Here you decide which objects to display on the main listing page</p>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(PREMIUMPRESS_SYSTEM) != "couponpress" && strtolower(PREMIUMPRESS_SYSTEM) != "auctionpress" && strtolower(PREMIUMPRESS_SYSTEM) != "agencypress" ){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Contact Form</span>	 
<select name="adminArray[display_contactform]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_contactform") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_contactform") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div><br />
<input type="checkbox" name="email_forward_enabled" value="1" <?php if(get_option("email_forward_enabled") ==1){ echo "checked"; } ?> style="margin-left:140px;"> <span>Send all messages to the admins.</span>

</div>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){ ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Call Now (Number)</span>	 
<input type="text" name="adminArray[display_rp_number]" value="<?php echo get_option("display_rp_number"); ?>" class="ppt-forminput">
 <div class="clearfix"></div>
</div>
 
<?php } ?>

<?php } ?>

 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Comments Box</span>	 
<select name="adminArray[display_single_comments]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_single_comments") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_single_comments") =="no"){ print "selected";} ?>>Hide</option>
			</select>
<div class="clearfix"></div>
</div>
 

<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "auctionpress" && get_option('addthisusername') != "off" && strtolower(PREMIUMPRESS_SYSTEM) != "agencypress" ){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Social Booking Tools</span>	 
<select name="adminArray[display_social]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_social") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_social") =="no"){ print "selected";} ?>>Hide</option>
			</select>
<div class="clearfix"></div>
</div>
<?php }else{ ?>
<input name="adminArray[display_social]" value="no" type="hidden">
<?php } ?>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress" ){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Bid Incremental Value</span>	 
<input type="text" style="width:40px;" name="adminArray[auctionpress_minbidvalue]" value="<?php echo get_option("auctionpress_minbidvalue"); ?>">  (default. $0.99)

<div class="clearfix"></div>
</div>
 
<?php } ?>


<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(PREMIUMPRESS_SYSTEM) != "agencypress" ){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Listing Information</span>	 
<select name="adminArray[display_listinginfo]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_listinginfo") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_listinginfo") =="no"){ print "selected";} ?>>Hide</option>
			</select>
<div class="clearfix"></div>
</div>
<?php }else{ ?>

<input type="hidden" name="adminArray[display_listinginfo]" value="no">
<?php } ?>
<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress" || strtolower(PREMIUMPRESS_SYSTEM) == "comparisonpress"){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Related Products</span>	 
<select name="adminArray[display_single_related]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_single_related") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_single_related") =="no"){ print "selected";} ?>>Hide</option>
			</select>
<div class="clearfix"></div>
</div>
 
<?php } ?>

 <?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "employeepress"){   ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Visitor Applications

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>This option will allow visitors to post job applications on the listing page.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</span>	
<select name="adminArray[employeepress_visitorreg]" class="ppt-forminput">
			<option value="" <?php if(get_option("employeepress_visitorreg") ==""){ print "selected";} ?>>No</option>
			<option value="1" <?php if(get_option("employeepress_visitorreg") =="1"){ print "selected";} ?>>Yes</option>
			</select>
<div class="clearfix"></div>
</div>
<?php } ?>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Related Products</span>	 
<select name="adminArray[display_single_related]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_single_related") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_single_related") =="no"){ print "selected";} ?>>Hide</option>
			</select>
<div class="clearfix"></div>
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Wishlist</span>	 
<select name="adminArray[display_wishlist]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_wishlist") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_wishlist") =="no"){ print "selected";} ?>>Hide</option>
			</select>
<div class="clearfix"></div>
</div>
<!--
<div class="ppt-form-line">	
<span class="ppt-labeltext">Image Slider</span>	 
<select name="adminArray[display_single_slider]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_single_slider") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_single_slider") =="no"){ print "selected";} ?>>Hide</option>
			</select>
<div class="clearfix"></div>
</div-->
<?php } ?>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress"){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Related Coupons</span>	 
<select name="adminArray[display_related_coupons]" class="ppt-forminput">
<option value="yes" <?php if(get_option("display_related_coupons") =="yes"){ print "selected";} ?>>Show</option>
<option value="no" <?php if(get_option("display_related_coupons") =="no"){ print "selected";} ?>>Hide</option>
</select>
<div class="clearfix"></div>
</div> 
<?php } ?>	

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress"){ ?> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Claim Listing</span>	 
<select name="adminArray[display_claim_listing]" class="ppt-forminput">
<option value="yes" <?php if(get_option("display_claim_listing") =="yes"){ print "selected";} ?>>Show</option>
<option value="no" <?php if(get_option("display_claim_listing") =="no"){ print "selected";} ?>>Hide</option>
</select>
<div class="clearfix"></div>
</div> 
<?php } ?>	


 
<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div> 
 </fieldset>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress" || strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){ ?> 
<fieldset>

<div class="titleh"><h3>Custom Display Fields</h3></div>

<p class="ppnote">Here you can choose the dislay fields for your search/gallery page.</p>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Custom Display 1</span>	 
<input type="text" name="adminArray[display_custom_display1]" value="<?php echo get_option("display_custom_display1"); ?>" class="ppt-forminput"> <br />
<select name="adminArray[display_custom_value1]" class="ppt-forminput" style="margin-left:140px;"><option value="">--hide field---</option><?php echo GetCustomFieldList(get_option("display_custom_value1")); ?></select> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Custom Display 2</span>	 
<input type="text" name="adminArray[display_custom_display2]" value="<?php echo get_option("display_custom_display2"); ?>" class="ppt-forminput"> <br />
<select name="adminArray[display_custom_value2]" class="ppt-forminput" style="margin-left:140px;"><option value="">--hide field---</option><?php echo GetCustomFieldList(get_option("display_custom_value2")); ?></select> 
<div class="clearfix"></div>
</div>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){ ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Custom Display 2</span>	 
<input type="text" name="adminArray[display_custom_display3]" value="<?php echo get_option("display_custom_display3"); ?>" class="ppt-forminput"> <br />
<select name="adminArray[display_custom_value3]" class="ppt-forminput" style="margin-left:140px;"><option value="">--hide field---</option><?php echo GetCustomFieldList(get_option("display_custom_value3")); ?></select> 
<div class="clearfix"></div>
</div>
 
<?php } ?>

<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div> 


</fieldset>

<?php } ?>



   
 
 <?php if(strtolower(PREMIUMPRESS_SYSTEM) == "moviepress" ){ ?> 

<fieldset><div class="titleh"> <h3>Video Teaser</h3></div> 

<p class="ppnote">The video teaser will allow the visitor to watch the video for XX seconds before it disappears.</p>

  
<div class="ppt-form-line">     
<span class="ppt-labeltext">Enable Teaser</span><input type="checkbox" name="teaser_enabled" value="1" <?php if(get_option("teaser_enabled") ==1){ echo "checked"; } ?>>
<div class="clearfix"></div>
</div>   

<div class="ppt-form-line">     
<span class="ppt-labeltext">Teaser Timer</span>
<input type="text" name="adminArray[teaser_timer]" class="ppt-forminput" style="width:100px;" value="<?php echo get_option('teaser_timer') ?>">
<div class="clearfix"></div>
<small>Enter a value in seconds to display the video before the below teaser message is displayed., e.g. 10000</small>
</div> 


<div class="ppt-form-line">     
<p>Teaser Message</p>
<textarea name="adminArray[teaser_text]" cols="" rows="" style=" font-size:14px; height:200px; width:380px;" class="ppt-forminput"><?php echo stripslashes(get_option("teaser_text")); ?></textarea>
<div class="clearfix"></div>
<small>This is the text that appears to the user when the timer has been reached.</small>
</div> 
 
 <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div> 

</fieldset>


<?php } ?>


<fieldset>

<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a3.gif" style="float:left; margin-right:8px;" />  
My Account</h3></div>

 <p class="ppnote">These options refer to the display options on the users account page.</p>
 
 <div class="ppt-form-line">	
<span class="ppt-labeltext">My Account Details</span>	 
<select name="adminArray[display_myaccount_accountdetails]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_myaccount_accountdetails") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_myaccount_accountdetails") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>


<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "moviepress"){ ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">My Messages</span>	 
<select name="adminArray[display_myaccount_messages]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_myaccount_messages") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_myaccount_messages") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>



<div class="ppt-form-line">	
<span class="ppt-labeltext">Purchase History</span>	 
<select name="adminArray[display_myaccount_purchasehistory]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_myaccount_purchasehistory") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_myaccount_purchasehistory") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>


<div class="ppt-form-line">	
<span class="ppt-labeltext"><?php if(strtolower(PREMIUMPRESS_SYSTEM) == "agencypress"){ echo 'Friends/Hotlist'; }else{ echo 'My Favorites'; } ?></span>	 
<select name="adminArray[display_myaccount_fav]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_myaccount_fav") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_myaccount_fav") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>

<?php } ?>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "agencypress"){ ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext"> Wink System</span>	 
<select name="adminArray[display_myaccount_wink]" class="ppt-forminput">
          <option value="yes" <?php if(get_option("display_myaccount_wink") =="yes"){ print "selected";} ?> >Show</option>
          <option value="no" <?php if(get_option("display_myaccount_wink") =="no"){ print "selected";} ?>>Hide</option>
        </select>
<div class="clearfix"></div>
</div>
<?php } ?>
 
 <div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" /></div>  
 
</fieldset>
</div>

<div class="clearfix"></div>
</form>
</div>



<form method="post" target="_self" id="StoreIDChange" name="StoreIDChange" >
 <input type="hidden" value="" name="showThisTab" id="showThisTab1" />
<input name="storeIDChanger" id="storeIDChanger" type="hidden" value="" /> 
</form>




 








 































<?php  $sliderData = get_option("slider_array");  ?>

<div id="premiumpress_tab5" class="content">


<div class="grid400-left">
<form method="post" name="designform4"  target="_self" > 
<input name="submitted" type="hidden" value="yes" /> 
<input type="hidden" value="5" name="showThisTab" id="showThisTab" />
 

<fieldset>

<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Slider Options

<a href="http://www.premiumpress.com/tutorial/sliders/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div>


<div class="ppt-form-line">	
<p>Select a slider to be displayed on the home page.</p>	
<input type="hidden" id="PPT_slider_style" name="adminArray[PPT_slider_style]" value="<?php echo get_option("PPT_slider_style"); ?>" />
<input type="hidden" id="PPT_slider" name="adminArray[PPT_slider]" value="<?php echo get_option("PPT_slider"); ?>" />


<ul class="ppt_layout_columns"> 

<li <?php if(get_option("PPT_slider") =="off"){echo"class='active'";} ?>><a href="javascript:document.getElementById('PPT_slider').value='off';document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s0.png"  /></a></li>

<li <?php if(get_option("PPT_slider") =="s2" && get_option("PPT_slider_style") =="1"){echo"class='active'";} ?>><a href="javascript:document.getElementById('PPT_slider').value='s2';document.getElementById('PPT_slider_style').value=1;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/sh.png" /></a></li>
 

<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="1"){echo"class='active'";} ?>><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=1;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s1.png" /></a></li>

<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="2"){echo"class='active'";} ?>><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=2;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s2.png" /></a></li>

<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="3"){echo"class='active'";} ?> style="margin-top:10px;"><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=3;document.designform4.submit();" ><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s3.png" /></a></li>

<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="4"){echo"class='active'";} ?> style="margin-top:10px;"><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=4;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s4.png" /></a></li>

<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="5"){echo"class='active'";} ?> style="margin-top:10px;"><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=5;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s2.png" /></a></li>

<?php /*
<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="7"){echo"class='active'";} ?> style="margin-top:10px;"><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=7;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s7.png" /></a></li>
 */ ?>
 
<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="8"){echo"class='active'";} ?> style="margin-top:10px;"><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=8;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s8.png" /></a></li>

<li <?php if(get_option("PPT_slider") =="s1" && get_option("PPT_slider_style") =="9"){echo"class='active'";} ?> style="margin-top:10px;"><a href="javascript:document.getElementById('PPT_slider').value='s1';document.getElementById('PPT_slider_style').value=9;document.designform4.submit();"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/new/s9.png" /></a></li>
   
</ul>
<div class="clearfix"></div>
</div>
 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Content Source</span>	

      <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>Content Source</b><br /><br />Here you tell the system which content to display in your slider, either content you add manually or the featured posts.<br/><br><b>Featured Posts</b><br><br>These are listing that you have selected as featured, you do this by editing any of your posts/listings/products and select them as featured. .&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
<select name="adminArray[PPT_slider_items]" class="ppt-forminput">
				<option value="manual" <?php if(get_option("PPT_slider_items") =="manual"){ print "selected";} ?>>Manually Configure Slides</option> 
                <option value="featured" <?php if(get_option("PPT_slider_items") =="featured"){ print "selected";} ?>>Use Featured Posts</option>  
                <option value="new" <?php if(get_option("PPT_slider_items") =="new"){ print "selected";} ?>>Use Latest Posts</option>
                <option value="custom" <?php if(get_option("PPT_slider_items") =="custom"){ print "selected";} ?>>Custom Post Query</option>
			</select>
<div class="clearfix"></div>
</div>

<?php if(get_option("PPT_slider_items") =="custom"){ ?>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Custom Post Query</span>	 
<input type="text" class="ppt-forminput" name="adminArray[PPT_slider_items_customquery]" value="<?php $cdd = get_option('PPT_slider_items_customquery'); if($cdd ==""){ echo "meta_key=featured&meta_value=yes"; }else{ echo $cdd; } ?>"  /> 
<div class="clearfix"></div>
</div>
 

<?php }  ?>
 

<?php if(get_option("PPT_slider") =="s2"){ ?>
<div class="ppt-form-line">
<span class="ppt-labeltext">Display Text</span>	
<select name="adminArray[PPT_slider2_text]" class="ppt-forminput">
<option value="yes" <?php if(get_option("PPT_slider2_text") =="yes"){ print "selected";} ?>>Yes</option> 
<option value="no" <?php if(get_option("PPT_slider2_text") =="no"){ print "selected";} ?>>No</option>  
</select>
</div>
<?php }  ?>
            
<?php if(get_option("PPT_slider_style") =="7"){ ?>
<div class="ppt-form-line">	<p>Slider 7 Description</p> <small>HTML Accepted</small> <br /> <textarea name="adminArray[PPT_slider_7_description]" id="pps4" style="width: 100%; height:200px;  font-size:14px;" class="txt"><?php echo stripslashes(get_option("PPT_slider_7_description")); ?></textarea></div>
<?php }  ?>

<?php if(get_option("PPT_slider_style") =="8"){ ?>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Background Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['slider8']['bg']; ?>" name="ppt_layout_style[slider8][bg]" style="height:25px;"  /> 
<div class="clearfix"></div>
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Text Color</span>	 
<input class="Multiple" type="text" value="<?php echo $layouttypes['slider8']['text']; ?>" name="ppt_layout_style[slider8][text]" style="height:25px;"  /> 
<div class="clearfix"></div>
</div> 

<?php }  ?>

<p><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" onclick="document.getElementById('showThisTab').value=5" /></p>

</fieldset>

</form>
</div>

<div class="grid400-left last">


<?php if(get_option("PPT_slider_style") =="9" && get_option("PPT_slider") =="s1" ){ ?>

<fieldset>
<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Custom Text/HTML

 
</h3></div>

<form method="post"  target="_self" > 
<input name="submitted" type="hidden" value="yes" /> 
<input type="hidden" value="5" name="showThisTab" id="showThisTab" />
 
<div class="ppt-form-line">	
<p>Enter text and/or html code below and it will be displayed on the home page. (<a href="http://codex.wordpress.org/Shortcode_API" target="_blank">Supports WordPress Shortcodes</a>) </p> 
<textarea name="adminArray[PPT_slider9_content]"  class="ppt-forminput" style="width:100%;height:275px;" ><?php echo stripslashes(get_option("PPT_slider9_content")); ?></textarea>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" /></div>  
  
 
 </form>

</fieldset>
<?php }else{ ?>

<fieldset>
<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Add New Slider Item

<a href="http://www.premiumpress.com/tutorial/sliders/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div>

 <form method="post" target="_self" >
<input name="admin_slider" type="hidden" value="slider" />
<input type="hidden" name="ppsedit" value="<?php if(isset($_POST['eslider'])){ echo $_POST['eslider']; }else{ echo "";} ?>">
<input type="hidden" value="5" name="showThisTab" id="showThisTab" />

<div id="addslide" <?php if(!isset($_POST['eslider'])){ ?>style="display:none;"<?php } ?>>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Title</span>	 
<input type="text" name="s1" id="pps1"   class="ppt-forminput" <?php if(isset($_POST['eslider'])){?> value="<?php echo $sliderData[$_POST['eslider']]['s1']; ?>" <?php } ?> />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Short Description</span>	 
<textarea name="s3" id="pps3" class="ppt-forminput" ><?php if(isset($_POST['eslider'])){ echo $sliderData[$_POST['eslider']]['s3'];  } ?></textarea>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Main Description</span>	 
<textarea name="s4" id="pps4" class="ppt-forminput"><?php if(isset($_POST['eslider'])){ echo $sliderData[$_POST['eslider']]['s4'];  } ?></textarea>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Image</span>	 
<input type="text" name="s2" id="pps2" class="ppt-forminput" <?php if(isset($_POST['eslider'])){?> value="<?php echo $sliderData[$_POST['eslider']]['s2']; ?>" <?php } ?> />
<div class="clearfix"></div>
     
<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script type="text/javascript">

function ChangeImgBlock(divname){
document.getElementById("imgIdblock").value = divname;
}
jQuery(document).ready(function() {
 
 jQuery('#upload_sliderimage').click(function() {
 ChangeImgBlock('pps2');
 formfield = jQuery('#pps2').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src'); 
 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
 tb_remove();
} 
});
</script>
<input id="upload_sliderimage" type="button" size="36" name="upload_sliderimage" value="Upload Image" style="margin-left:150px;"  />
<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','pps2');" type="button"   value="View Images"  />

</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Click able Link</span>	 
<input type="text" name="s5" id="pps5" class="ppt-forminput" <?php if(isset($_POST['eslider'])){?> value="<?php echo $sliderData[$_POST['eslider']]['s5']; ?>" <?php }else{ ?>value="http://"<?php } ?> /> 
<div class="clearfix"></div>
</div>
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Order</span>	 
<select id="pps6" name="s6" class="ppt-forminput"><?php if(isset($_POST['eslider'])){?><option><?php echo $sliderData[$_POST['eslider']]['order']; ?></option><?php } ?><?php $i=1; while($i<20){echo '<option>'.$i.'</option>';  $i++; } ?></select>
<div class="clearfix"></div>
</div>
<p><input class="premiumpress_button" type="submit" value="<?php if(!isset($_POST['eslider'])){ ?>Create New Slide<?php }else{ ?>Save Changes<?php } ?>" style="color:white;" onclick="document.getElementById('showThisTab').value=5" /></p>
</div>
<a href="javascript:void(0);" onclick="toggleLayer('addslide');" class="ppt_layout_showme">Show/Hide Options</a>
</form>

</fieldset> 
<div id="PPT-sliderbox"></div>


<?php if(is_array($sliderData) && count($sliderData) > 0 ){  ?>

<fieldset>
<div class="titleh"><h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a3.gif" style="float:left; margin-right:8px;" /> Manage Slides

<a href="http://www.premiumpress.com/tutorial/sliders/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div>



<?php $sortedSlider = $PPTDesign->array_sort($sliderData, 'order', SORT_ASC); 
$counter=0; foreach($sortedSlider as $hh => $slide){   ?> 

<div class="ppt-form-line">	
<a href="javascript:void(0);" onclick="document.getElementById('delslider').value=<?php echo $slide['id']; ?>;document.editslider.submit();" style="padding:5px; background:#ffb9ba; border:1px solid #bd2e2f; color:red; float:right;">Delete&nbsp;</a>
<a href="javascript:void(0);" onclick="document.getElementById('eslider').value=<?php echo $slide['id']; ?>;document.editslider.submit();" style="padding:5px; background:#dcffe1; border:1px solid #57b564; color:green; float:right; margin-right:10px;"> Edit &nbsp;&nbsp;</a> 

<p><b><?php echo $slide['s1']; ?></b></p> 
<p><?php echo $slide['s3']; ?>  <small>/ display order: <?php echo $slide['order']; ?> / <a href="<?php echo $slide['s5']; ?>" target="_blank">test link</a></small></p>
 

<div class="clearfix"></div>
</div>
<?php $counter++; } ?>
 
</fieldset><?php } ?>

<form method="post" target="_self" id="editslider" name="editslider" >
<input type="hidden" value="5" name="showThisTab" id="showThisTab" />
<input name="eslider" id="eslider" type="hidden" value="" />
<input name="delslider" id="delslider" type="hidden" value="" />
</form>   
<form method="post" target="_self" >
<input name="admin_slider" type="hidden" value="reset" />
<input class="button" type="submit" value="Reset Slider (Delete All Slides)" onclick="document.getElementById('showThisTab').value=5"/>
</form>                    
<?php } ?>




</div>




<div class="clearfix"></div> 

 
</div>



 
<div id="premiumpress_tab3" class="content">
<form method="post" name="shopperpress" target="_self" >
<input name="submitted" type="hidden" value="yes" />
<input type="hidden" value="3" name="showThisTab" id="showThisTab" />
<div class="grid400-left"> 
 
 
<fieldset>
<div class="titleh"> <h3>Shopping Cart Setup</h3></div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Quantity Control</span>	
<select name="adminArray[display_ignoreQTY]" class="ppt-forminput">				
				<option value="yes" <?php if(get_option("display_ignoreQTY") =="yes"){ print "selected";} ?>>Enable -  Manage Stock Levels</option>
                <option value="no" <?php if(get_option("display_ignoreQTY") =="no"){ print "selected";} ?>>Disable - I'm not managing stock Levels</option>
			</select>
<div class="clearfix"></div>
<p class="ppnote">This will setup shopperpress to monitor and prevent stock being oversold. Note. requires you to provide valid stock levels within products.</p>
</div>
           
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Credit Purchase Options</span>	
<select name="adminArray[display_credit_options]" class="ppt-forminput">				
				<option value="yes" <?php if(get_option("display_credit_options") =="yes"){ print "selected";} ?>>Yes</option>
                <option value="no" <?php if(get_option("display_credit_options") =="no"){ print "selected";} ?>>No - Disabled</option>
			</select>
            
<div class="clearfix"></div>
<p class="ppnote">Credits are used in download stores, if you are not creating a download store then you can disable this option..</p>
</div>  
 
<div class="ppt-form-line">	<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" /></div>  
     
</fieldset>            
 
 

</div>
<div class="grid400-left last">
<fieldset>
<div class="titleh"> <h3>Currency Options</h3></div>


<div class="ppt-form-line">     
<span class="ppt-labeltext">Display Currency</span>
<input type="text" name="adminArray[currency_code]" class="ppt-forminput" style="width: 200px; font-size:14px;;" value="<?php echo get_option("currency_code"); ?>"> <small>USD</small>
<div class="clearfix"></div>
</div>  
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Symbol</small></span>	 
<input name="adminArray[currency_symbol]" type="text" class="ppt-forminput" value="<?php echo get_option("currency_symbol"); ?>" />  <small>$</small>
<div class="clearfix" ></div>
</div>   
 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Caption </span>	 
<input name="adminArray[currency_caption]" type="text" class="ppt-forminput" value="<?php echo get_option("currency_caption"); ?>" />  
<div class="clearfix" ></div><small>e.g: US Dollars ($)</small>
</div>    
<input name="adminArray[currency_value]" type="hidden" class="ppt-forminput" value="1" /> 

 
<p class="ppnote1"><b>Note.</b> Payment currency codes are setup separately within the <a href="admin.php?page=payments" style="text-decoration:underline;">payments area here</a></p>


<div class="ppt-form-line">     
<span class="ppt-labeltext">Symbol Position</span>
<select name="adminArray[display_currency_position]" class="ppt-forminput">
				<option value="l" <?php if(get_option("display_currency_position") =="l"){ print "selected";} ?>>Left (e.g. $100)</option>
				<option value="r" <?php if(get_option("display_currency_position") =="r"){ print "selected";} ?>>Right (e.g. 100$)</option>				
			</select>
<div class="clearfix"></div>
</div>  
 
 
  
  <div class="ppt-form-line">     
<span class="ppt-labeltext">Display Price Format (Round Up/Down)</span>
<select name="adminArray[display_currency_format]" class="ppt-forminput">
				<option value="0" <?php if(get_option("display_currency_format") =="0"){ print "selected";} ?>>0 (e.g. $100)</option>
				<option value="1" <?php if(get_option("display_currency_format") =="1"){ print "selected";} ?>>1 (e.g. $100.0)</option>	
                <option value="2" <?php if(get_option("display_currency_format") =="2"){ print "selected";} ?>>2 (e.g. $100.00) Recommended</option>
                 <option value="3" <?php if(get_option("display_currency_format") =="3"){ print "selected";} ?>>3 (e.g. $100.000)</option>
                 <option value="4" <?php if(get_option("display_currency_format") =="4"){ print "selected";} ?>>4 (e.g. $100.0000)</option>
                  
                 		
			</select>
<div class="clearfix"></div>
</div>  

<div class="ppt-form-line">     
<span class="ppt-labeltext">Separator Type</span>
<select name="adminArray[display_currency_separator]" class="ppt-forminput">
				<option value="." <?php if(get_option("display_currency_separator") =="."){ print "selected";} ?>>$100.00 (dot)</option>
				<option value="," <?php if(get_option("display_currency_separator") ==","){ print "selected";} ?>>$100,00 (comma)</option>				
			</select>
<div class="clearfix"></div>
</div>          
 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Price Display</span>	 
<select name="adminArray[display_pricetag]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_pricetag") =="yes"){ print "selected";} ?>>Show to all visitors</option>
<option value="member" <?php if(get_option("display_pricetag") =="member"){ print "selected";} ?>>Show only to registered users</option>
				<option value="no" <?php if(get_option("display_pricetag") =="no"){ print "selected";} ?>>Hide Completely</option>
                <option value="yesvat" <?php if(get_option("display_pricetag") =="yesvat"){ print "selected";} ?>>Show including VAT (XX%)</option>
			</select>

<div class="clearfix" ></div>
</div>

<?php if(get_option("display_pricetag") =="yesvat"){  ?>

<div class="ppt-form-line">	
<span class="ppt-labeltext">VAT XXX%</small></span>	 
<input name="adminArray[display_pricetag_percent]" type="text" class="ppt-forminput" value="<?php if(get_option("display_pricetag_percent") == ""){ echo "20"; }else{ echo get_option("display_pricetag_percent"); } ?>" />  <small>%</small>
<div class="clearfix" ></div>
</div>

<?php } ?>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Multiple Currency</span>	 
	 
<select name="adminArray[display_subnav_currency]" class="ppt-forminput">
<option value="yes" <?php if(get_option("display_subnav_currency") =="yes"){ print "selected";} ?>>Show Drop Down in Submenu</option>
<option value="no" <?php if(get_option("display_subnav_currency") =="no"){ print "selected";} ?>>Hide</option>
</select> 

<div class="clearfix" ></div>
</div>
<?php if(get_option("display_subnav_currency") =="yes"){  ?>
<br />
<div class="msg msg-info">
  <p>If you are using the GBP pound or EUR euro, please enter the HTML value for the pound symbol for correct display. The HTML value is  <b>&amp;pound;</b> or <b>&amp;euro;</b> simply copy and paste the text into the symbol box below.
</p>
</div>
 
<?php $a=1; while($a < 5){  if($a> 0){ $etc = "_".$a; }else{ $etc =""; }  ?>

<div id="cureency<?php echo $a; ?>" style="display:none;">
<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Caption <br /><small>e.g: US Dollars ($)</small></span>	 
<input name="adminArray[currency_caption<?php echo $etc; ?>]" type="text" class="ppt-forminput" value="<?php echo get_option("currency_caption".$etc); ?>" /> 
<div class="clearfix" ></div>
</div>            
<?php if($a > 0){ ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Currency Code<br /><small> e.g: USD</small></span>	 
<input name="adminArray[currency_code<?php echo $etc; ?>]" type="text" class="ppt-forminput" value="<?php echo get_option("currency_code".$etc); ?>" /> 
<div class="clearfix" ></div>
</div>
<?php } ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Currency Symbol<br /> <small>e.g: $</small></span>	 
<input name="adminArray[currency_symbol<?php echo $etc; ?>]" type="text" class="ppt-forminput" value="<?php echo htmlentities(get_option("currency_symbol".$etc)); ?>" /> 
<div class="clearfix" ></div>
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Exchange Rate</span>	 
<input name="adminArray[currency_value<?php echo $etc; ?>]" type="text" class="txt" class="ppt-forminput" value="<?php echo htmlentities(get_option("currency_value".$etc)); ?>" />    
<div class="clearfix" ></div>
</div>
</div>

<a href="javascript:void(0);" onclick="toggleLayer('cureency<?php echo $a; ?>');" class="ppt_layout_showme" style="width:380px;">Show/Hide Options - <?php echo get_option("currency_caption".$etc); ?></a>
       

<?php $a++; } ?>
<?php } ?>
<div class="ppt-form-line">	<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" /></div>  
  
</fieldset>


</div>
<div class="clearfix"></div>

</form> 
</div>



<div id="premiumpress_tab4" class="content">

<form method="post"  target="_self" >
<input name="submitted" type="hidden" value="yes" />
<input type="hidden" value="4" name="showThisTab" id="showThisTab" />
<div class="grid400-left">

 
<fieldset>
<div class="titleh"> <h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Custom Taxonomies

<a href="http://www.premiumpress.com/tutorial/custom-taxonomies/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div>

<?php 
$taxArray = get_option("ppt_custom_tax");
$dd=0; 
while($dd < 13){
if($dd == 1 || ( isset($taxArray[$dd]['title']) && $taxArray[$dd]['title'] !="" ) ){
echo '<div id="tax'.$dd.'">';
}else{
echo '<div id="tax'.$dd.'" style="display:none;">';
}

$nottkeys = array('location','store','network');
$keyname = $taxArray[$dd]['name'];

if(in_array($keyname,$nottkeys)){
$keyname = $keyname."_1";
}

echo '<div class="ppt-form-line"><span class="ppt-labeltext">Taxonomy '.$dd.'</span>
		 Title: 
		<input name="ppt_custom_tax['.$dd.'][title]" type="text" class="ppt-forminput" value="'.$taxArray[$dd]['title'].'" style="width:200px;" />
		<div class="clearfix"></div>
		<div style="margin-left:140px;">Key&nbsp; &nbsp; 
		<input name="ppt_custom_tax['.$dd.'][name]" type="text" class="ppt-forminput" value="'.$keyname.'"  style="width:100px;" /></div>';
		
		if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" ){ 
		
		echo '<div class="ppt-form-line"> Show on submission form
		<select name="ppt_custom_tax['.$dd.'][show]" class="ppt-forminput" style="width:100px;">
		<option value="yes"'; if($taxArray[$dd]['show'] =="yes"){ print "selected";}  echo '>Yes</option>
		<option value="no"'; if($taxArray[$dd]['show'] =="no"){ print "selected";} echo '>No</option>
		</select> 
		</div>	';
		
		}
			
		
		echo '<div class="clearfix"></div></div>'; ?> 
	 

<div id="bb<?php echo $dd; ?>" <?php $c = $dd+1; if( ($dd==0 ) || (isset($taxArray[$dd]['title']) && isset($taxArray[$c]['title']) && $taxArray[$dd]['title'] != "" && $taxArray[$c]['title'] !="" )){ echo "style='display:none;'"; } ?>> 
<div class="ppt-form-line">	<a href="javascript:void(0);" onclick="toggleLayer('tax<?php echo $dd+1; ?>');jQuery('#bb<?php echo $dd; ?>').hide();" class="button-primary">Add New Taxonomy </a><div class="clearfix"></div> 
</div></div></div>



<?php $dd++; } ?>
<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;" /></p>
</fieldset>


</div><div class="grid400-left last">  
<div class="videobox" id="taxvideo" style="margin-bottom:10px;"> 
<a href="javascript:void(0);" onclick="PlayPPTVideo('1JQz8vg_mZ0','taxvideo');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/12.jpg" align="absmiddle" /></a>
</div>        
   
</div> 
          		
</fieldset>	

</form>

</div> 
<div class="clearfix"></div>
</div>