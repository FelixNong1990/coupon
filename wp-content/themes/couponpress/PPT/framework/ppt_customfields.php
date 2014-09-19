<?php


/* =============================================================================
  PREMIUMPRESS ADMIN HEADER
   ========================================================================== */

function premiumpress_customfields_box() {

	global $post, $pagenow;
	
	if($pagenow == "widgets.php"){ return; } 
 
	if( function_exists( 'add_meta_box' )) {

		wp_register_style( 'lightbox', PPT_PATH.'js/lightbox/jquery.lightbox.css');
		wp_enqueue_style( 'lightbox' );
		
		wp_register_script( 'lightbox', PPT_PATH.'js/lightbox/jquery.lightbox.js');
		wp_enqueue_script( 'lightbox' );
		
		wp_register_style( 'fancyboxCSS', PPT_PATH.'css/css.admin.edit.css');
		wp_enqueue_style( 'fancyboxCSS' );	
		
		wp_register_style( 'msgbox', PPT_PATH.'js/msgbox/jquery.msgbox.css');
		wp_enqueue_style( 'msgbox' );
			
		wp_register_script( 'msgbox', PPT_PATH.'js/msgbox/jquery.msgbox.js');
		wp_enqueue_script( 'msgbox' );
			
		wp_register_script( 'tabs', PPT_PATH.'js/jquery.admin.tabs.js');
		wp_enqueue_script( 'tabs' );     
	 
		wp_register_script( 'date-pick', PPT_PATH.'js/jquery.date.js');
		wp_enqueue_script( 'date-pick' );  
	 
		wp_register_script( 'date-pick1', PPT_PATH.'js/jquery.date_pick.js');
		wp_enqueue_script( 'date-pick1' ); 
		
		wp_register_style( 'date-pick', PPT_PATH.'css/css.date.css');
		wp_enqueue_style( 'date-pick' );
		
		// CHOSEN
		wp_register_style( 'chosen', PPT_PATH.'js/jquery.chosen.css');
		wp_enqueue_style( 'chosen' );
	
		wp_register_script( 'chosen', PPT_PATH.'js/jquery.chosen.min.js');
		wp_enqueue_script( 'chosen' ); 
		
		// ADD IN NEW META BOXES
		add_meta_box( 'premiumpress_customfields_0', __( 'Listing Options', 'sp' ), 'premiumpress_listing', 'post', 'normal', 'high' ); 
		add_meta_box( 'premiumpress_customfields_3', __( 'Compared Product Options', 'sp' ), 'premiumpress_compare', 'ppt_compare', 'normal', 'high' );  
	
		// RELATED PRODUCTS FIELDS
		if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" || strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress"){	
			add_meta_box( 'premiumpress_new_4', __( 'Related Products', 'sp' ), 'premiumpress_relatedproducts', 'post', 'side', 'low' );
		}
		if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){
		add_meta_box( 'premiumpress_customfields_5', __( 'Page Access', 'sp' ), 'premiumpress_pageaccess', 'page', 'normal', 'high' ); 
		}
		
		// REMOVE THUMBNAIL FROM POSTS
		remove_meta_box('postexcerpt', 'post', 'normal');
		remove_meta_box('postexcerpt', 'article_type', 'normal');
	 	//remove_meta_box('customfields', 'post', 'normal');
	}
}

 

function ppt_custom_admin_head() {

	global $post, $pagenow; $extrabit = ""; $endbit = "";
 
	// ONLY REQUIRED FOR POSTS/ARTICLES
	if(!isset($post->post_type) || ($post->post_type != "post" && $post->post_type != "article_type" && $post->post_type != "page" )){ return; }
 	
	if($post->post_type == "post"){
	
	echo '<style type="text/css">';
	echo '.sorting-indicator { display:none !important; }';
    echo 'table #image { width:80px; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/simages.png) 8px 8px no-repeat; border-right:1px solid #ddd; border-left:1px solid #ddd; }';
	echo 'table #qty { width:80px; padding-left:26px; background:url('.get_template_directory_uri().'/PPT/img/admin/cqty.png) 8px 8px no-repeat; border-right:1px solid #ddd;  } ';
	echo 'table #bids { width:80px; padding-left:26px; background:url('.get_template_directory_uri().'/PPT/img/admin/auctionpress.png) 8px 8px no-repeat; border-right:1px solid #ddd;  } ';

	echo 'table #found { width:100px; padding-left:26px; background:url('.get_template_directory_uri().'/PPT/img/admin/comparisonpress.png) 8px 8px no-repeat; border-right:1px solid #ddd;  } ';

	echo 'table #title { width:25%; padding-left:26px; background:url('.get_template_directory_uri().'/PPT/img/admin/ctitle.png) 8px 8px no-repeat;   }';
	echo 'table #rptype { width:10%; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/chouse.png) 8px 8px no-repeat; border-right:1px solid #ddd;   }';
	echo 'table #cptype { width:10%; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/cptype.png) 8px 8px no-repeat; border-right:1px solid #ddd;   }';
	
	echo 'table #pak { width:15%; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/cpak.png) 8px 8px no-repeat; border-right:1px solid #ddd;   }';
	echo 'table #categories { width:10%; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/ccat.png) 8px 8px no-repeat;    }';

	echo 'table #price { width:70px; padding-left:26px; background:url('.get_template_directory_uri().'/PPT/img/admin/cprice.png) 8px 8px no-repeat; border-right:1px solid #ddd;  }';
	echo 'table #hits { width:60px; padding-left:26px; background:url('.get_template_directory_uri().'/PPT/img/admin/c1.png) 8px 8px no-repeat; border-right:1px solid #ddd;  }';

	echo 'table #ID { 100px; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/cid.png) 8px 8px no-repeat;border-right:1px solid #ddd;  }';
	echo 'table #SKU { 100px; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/csku.png) 8px 8px no-repeat;border-right:1px solid #ddd;  }';

	echo 'table #date { width:100px; padding-left:26px; background:url('.get_template_directory_uri().'/PPT/img/admin/cdate.png) 8px 8px no-repeat;  }';

	echo '.column-price, .column-hits, .column-qty, .column-bids  { width:100px; font-size:10px; text-align:center; border-right:1px solid #ddd !important; } .column-SKU, .column-found, .column-title,.column-categories,.column-pak, .column-cptype, .column-ID,.column-rptype{ border-right:1px solid #ddd !important; } ';
	echo 'table #userphoto { width:60px;  }';
	echo '.column-image { border-right:1px solid #ddd !important; border-left:1px solid #ddd !important; align:center; } .column-image { width:80px !important; } .column-image img { margin-left:auto; margin-right:auto; display:block; }';
    //echo '#hits { width:80px; padding-left:30px; background:url('.get_template_directory_uri().'/PPT/img/admin/simages.png) 8px 10px no-repeat; }';
	
	// PHOTO
	echo '.pptphoto { max-width:50px; max-height:50px; }';
	//SKU
	echo '.column-ID, .column-SKU { width:60px; font-size:10px !important; text-align:center; } .column-found { text-align:center; }'; 
    echo '</style>';
	
	}elseif($post->post_type == "page"){
	echo '<style type="text/css">#postimagediv { display:none; }</style>';
	
	}  
		 
 
 

?>
<script language="javascript">
jQuery(function(){

<?php

if($post->post_type != "page" && $post->post_type != "article_type"){
// ADD SKU TO SIDEBAR
$usku = get_post_meta($post->ID, 'SKU', true); if($usku == ""){ $usku = $post->ID; }

?>
jQuery('#misc-publishing-actions').before('<div class="misc-pub-section"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/csku.png" style="float:left; margin-right:5px;margin-top:5px;" /> SKU: <input type="text" name="field[SKU]" value="<?php echo $usku;  ?>"  style="font-size:11px;width:200px;"/></div>');
<?php } ?> 
 
jQuery('#premiumpress_customfields_0').before('<?php echo $extrabit."".$endbit; ?><div class="clearfix"></div>');


<?php
if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){ $abit = ""; }elseif($post->post_type =="post"){
$abit ='<b>Tagline</b> (Optional - Displayed under the title on selected templates)<br /><input type="text" name="field[tagline]" value="'.get_post_meta($post->ID, 'tagline', true).'" style="width:98%;">';
}

if($post->post_type != "page"){
?>

jQuery('#titlewrap').after('<div class="updated below-h2" style="padding:8px;width:98%;margin-top:20px;"><?php echo $abit; ?><p><b>Short Description</b> (Required - Displayed on the search results page)</p><textarea rows="1" cols="40" name="excerpt" tabindex="3" id="excerpt"><?php 

$ee = preg_replace( '/\s+/', ' ',trim(strip_tags($post->post_excerpt)));

echo $ee; ?></textarea></div>');
<?php } ?>

});
</script>
<?php
}






/* =============================================================================
  PAGEACCESS  // VERSION 7.1.1+
   ========================================================================== */

function premiumpress_pageaccess(){

global $post, $PPT;  $nArray = array('tpl-myaccount.php','tpl-add.php','tpl-articles.php','tpl-callback.php','tpl-checkout.php','tpl-edit.php','tpl-faq.php','tpl-messages.php','tpl-myaccount.php','tpl-people.php','tpl-taxonomy.php');

	if(isset($post->page_template) && in_array($post->page_template,$nArray)){ 
	echo "Page access is disabled when using this page template.";
	}else{
 
	//1. GET PACKAGE DATA	
	$nnewpakarray 	= array();
	$packagedata 	= get_option('ppt_membership');
	if(is_array($packagedata) && isset($packagedata['package']) ){ foreach($packagedata['package'] as $val){		
		$nnewpakarray[] =  $val['ID'];		
	} }
	
	//2. GET POST - PACKAGE DATA
	$postpackagedata 	= get_post_meta($post->ID, 'package_access', true);
	if(!is_array($postpackagedata)){ $postpackagedata = array(0); }
	
	?>    
	
	<label style="font-size:11px; line-height:30px;"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/pakicon.png" align="absmiddle" alt="nr" /> Here you can select which membership packages can view this page. <a href="http://www.premiumpress.com/tutorial/membership-packages/?TB_iframe=true&width=640&height=838" class="thickbox">Learn More Here</a></label>
    
    
	<select name="package_access[]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="0" <?php if(in_array(0,$postpackagedata)){ echo "selected=selected"; } ?>>All Package Access</option>
    <?php 
	$i=0;
	if(is_array($packagedata) && isset($packagedata['package']) ){
	foreach($packagedata['package'] as $package){	
		
		if(is_array($postpackagedata) && in_array($package['ID'],$postpackagedata)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']." ( package ID: ".$package['ID'].")</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']." ( package ID: ".$package['ID'].")</option>";		
		}
		
	$i++;		
	} } // end foreach
	
    ?>
	</select>
    <br /><small>Hold CTRL to select multiple packages. </small> <br /> <small><a href="admin.php?page=membership">edit membership packages here</a></small> 
 
 

<?php  } }

/* =============================================================================
  RELATED PRODUCTS // SIDEBAR // VERSION 7.1.1+
   ========================================================================== */

function premiumpress_relatedproducts(){

global $post, $PPT;
?>
<!-- START OUTPUT -->
<div style="margin: -6px -10px -8px; padding: 0 -10px"> 
<div class="misc-pub-section">
<p style="font-size:11px;">Enter item ID's seperated with a comma to display a list of related products for this item.</p>
<?php
 
echo '<input type="text" name="field[related]" value="'.get_post_meta($post->ID, 'related', true).'"  style="width:100%; font-size:11px;"  />
<div class="clearfix"></div></div>';				
	
 ?>

 <div class="misc-pub-section-last" style="padding:10px;">
<input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="Update Related Products">		 
</div>		
 

</div><!-- end wrapper -->
<!-- END OUTPUT -->
<?php 

}
 
 
 

 
/* =============================================================================
  COMPARED PRODUCTS INTEGRATION
   ========================================================================== */

function premiumpress_compare(){

global $post, $PPT;
$type = get_post_meta($post->ID, 'type', true);

echo '<input type="hidden" name="sp_noncename" id="sp_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />'; ?>
 
<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script type="application/javascript">
function ChangeImgBlock(divname){document.getElementById("imgIdblock").value = divname;}

jQuery(document).ready(function() {
jQuery('#upload_g_image').click(function() {
 ChangeImgBlock('g_image');
 formfield = jQuery('#g_image').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});
window.original_send_to_editor = window.send_to_editor;
window.send_to_editor = function(html) {

	if(document.getElementById("imgIdblock").value !=""){
	
	 imgurl = jQuery('img',html).attr('src'); 
	 cvbalue = document.getElementById(document.getElementById("imgIdblock").value).value;
	 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
	 document.getElementById("imgIdblock").value = "";
	 tb_remove();
	 
	} else {
	
	  window.original_send_to_editor(html);
	
	}   
} 

 
 
});

function PPMsgBox(text){jQuery.msgbox(text, {  type: "info",   buttons: [    {type: "submit", value: "OK"}  ]}, function(result) {  });} 			

</script>
<?php

echo '<script type="text/javascript">jQuery(document).ready(function(){ jQuery(\'.lightbox\').lightbox(); });</script>';
		
echo '<div id="DisplayImages" style="display:none;"></div><input type="hidden" id="searchBox1" name="searchBox1" value="" />'; 


//echo '<div class="grid400-left" style="margin-left:-5px; margin-right:5px;">';
 
	
		echo '<div style="width:48%;height:40px; margin-bottom:10px; float:left;">';
		
		if(isset($_GET['pid'])){ 
		$pD = $_GET['pid'];
		}else{
		$pD = get_post_meta($post->ID, 'pID', true);
		}
		
		echo '<div class="ppt-form-line"><span class="ppt-labeltext">' . __("Parent Product ID ", 'sp' ) . ' <a href="javascript:void(0);" onmouseover="this.style.cursor=\'pointer\';" 
onclick="PPMsgBox(&quot;Enter the POST ID for the product that your setting up the comparison for. &quot;);"><img src="'.PPT_FW_IMG_URI.'help.png" style="float:right;" /></a></span>';
		echo '<input type="text" name="field[pID]" value="'.$pD.'" class="ppt-forminput" style="width:150px;"/> ';
		echo '</div> <div class="clearfix"></div>';
		
		echo '</div><div class="clearfix"></div>';
		
		

		echo '<div style="width:48%;height:40px; margin-bottom:10px; float:left;">';
		
		echo '<div class="ppt-form-line"><span class="ppt-labeltext">Regular Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[price]" value="'.get_post_meta($post->ID, 'price', true).'" class="ppt-forminput" style="width:150px;"/> ';
		echo '</div> <div class="clearfix"></div>';
		
		echo '</div>';
	
		echo '<div style="width:48%;height:40px; margin-bottom:10px; float:left;">';
		
		echo '<div class="ppt-form-line"><span class="ppt-labeltext">Old Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[old_price]" value="'.get_post_meta($post->ID, 'old_price', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '</div> <div class="clearfix"></div>';
		
		echo '</div> '; 
		
		
		echo '<div class="clearfix"></div><div style="width:48%;height:40px; margin-bottom:10px; float:left;">';
		
		echo '<div class="ppt-form-line"><span class="ppt-labeltext">' . __("Buy Link / Affiliate Link", 'sp' ) . '</span>';
		echo '<input type="text" name="field[buy_link]" value="'.get_post_meta($post->ID, 'buy_link', true).'" class="ppt-forminput" style="width:350px;"/>';
		echo '</div> <div class="clearfix"></div>';
		
		echo '</div> ';
		
 


//echo '</div><div class="grid400-left last">';

 if(strlen(get_post_meta($post->ID, 'image', true)) > 3){
 
 
	 echo "<div style='width:350px; padding:10px;display:block;'>".premiumpress_image($post->ID,"",array('alt' => $post->post_title,  'width' => '110', 'height' => '110', 'style' => 'max-height:150px; max-width:150px; margin:auto auto; display:block;' ))."</div><div class='clearfix'></div>";
} 

echo '<div class="ppt-form-line"><span class="ppt-labeltext">Image</span>';
echo '<input type="text" name="field[image]" id="g_image" value="'.get_post_meta($post->ID, 'image', true).'" class="ppt-forminput"/> ';

?>

 
<input style="margin-left:140px;" type="button" class="button tagadd" size="36"   value="View Images" onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','g_image');" />
 
        
<input id="upload_g_image" type="button" class="button tagadd" size="36" name="upload_g_image" value="Upload New Image" />
 </div>
<?php

//echo '</div><div class="clearfix"></div>';

}
 
































































/* =============================================================================
  LISTING INTEGRATION
   ========================================================================== */
 
function premiumpress_listing(){

	global $post, $PPT;
	
	if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){
 
	
		$ThisPack 	= get_post_meta($post->ID, 'packageID', true);
		$packdata 	= get_option("packages");
		$cf1 		= get_option("customfielddata"); 
		$tdC =1;  
		
		$couponType = get_post_meta($post->ID, 'type', true);
 		
	} 

// Use nonce for verification ... ONLY USE ONCE!
echo '<input type="hidden" name="sp_noncename" id="sp_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
  
echo'<script type="text/javascript" charset="utf-8">
Date.firstDayOfWeek = 0;
Date.format = \'yyyy-mm-dd\';
jQuery(function()
{
	jQuery(\'.date-pick\').datePicker()
	jQuery(\'#start-date\').bind(
		\'dpClosed\',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				jQuery(\'#end-date\').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	jQuery(\'#end-date\').bind(
		\'dpClosed\',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				jQuery(\'#start-date\').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
});
function PPMsgBox(text){
		jQuery.msgbox(text, {  type: "info",   buttons: [    {type: "submit", value: "OK"}  ]}, function(result) {  });
		
		} 			
</script>        
';

echo '<script type="text/javascript">jQuery(document).ready(function(){ jQuery(\'.lightbox\').lightbox(); });</script>';

// OPENS UP TO DISPLAY IMAGES + VIDEOS
echo '<div id="DisplayImages" style="display:none;"></div><input type="hidden" id="searchBox1" name="searchBox1" value="" />'; 


 
?>
 
 
 
<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script>

function ChangeImgBlock(divname){
document.getElementById("imgIdblock").value = divname;
}

jQuery(document).ready(function() {

jQuery('#upload_g_featured_image').click(function() {
 ChangeImgBlock('g_featured_image');
 formfield = jQuery('#g_featured_image').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_g_image').click(function() {
 ChangeImgBlock('g_image');
 formfield = jQuery('#g_image').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

<?php $a=0; while($a < 21){ ?>

jQuery('#upload_galimg<?php echo $a; ?>').click(function() {
 ChangeImgBlock('galimg<?php echo $a; ?>');
 formfield = jQuery('#galimg<?php echo $a; ?>').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
}); 
<?php $a++; } ?>	
 
jQuery('#upload_g_images').click(function() {
 ChangeImgBlock('g_images');
 formfield = jQuery('#g_images').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
}); 
 

window.original_send_to_editor = window.send_to_editor;
window.send_to_editor = function(html) {

	if(document.getElementById("imgIdblock").value !=""){
	
	 imgurl = jQuery('img',html).attr('src'); 
	 cvbalue = document.getElementById(document.getElementById("imgIdblock").value).value;
	 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl+","+cvbalue);
	 document.getElementById("imgIdblock").value = "";
	 tb_remove();
	 
	} else {
	
	  window.original_send_to_editor(html);
	
	}   
}



});
</script>


        

<script type="text/javascript">jQuery(function(){jQuery(".ppt_customfields").LeTabs();});</script>




<div id="ppt-tabs" class="ppt_customfields oldlook">

<div id="ppt-tabs_tab_container">

    
   
    <a class="enabled">Details</a>
    <a class="enabled">Images</a>
     <?php if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){ ?>
    <a class="enabled">Membership Access</a>
    <?php } ?>
    
    <?php premiumpress_admin_post_custom_title(); ?> 

</div><!-- end ppt-tabs_tab_container -->

<div id="ppt-tabs_content_container" style="height: 100%; ">

	<div id="ppt-tabs_content_inner">
    
  







<!-- ***********************************************************
CUSTOM SUBMISSION FIELDS
*************************************************************** -->


<div class="ppt-tabs_content" style="left: -750px;">


<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){ ?>

<?php if(get_option('pak_enabled') == 1){ ?>
<div class="misc-pub-section">
<span class="ppt-labeltext">Submission Package: </span>   
<?php
echo '<select name="field[packageID]" class="ppt-forminput">
<option value="">---------</option>';
		
		$pp=1; 
		$ThisPack = get_post_meta($post->ID, 'packageID', true);		
		while($pp < 10){		
		if(isset($packdata[$pp]['name']) && strlen($packdata[$pp]['name']) > 0){ echo '<option value="'.$pp.'"'; if($ThisPack == $pp){ echo 'selected'; } echo '>'.$packdata[$pp]['name'].'</option>'; }
		$pp++;
		}	
		echo '</select>';
?>
</div>
<?php $ppfh = get_post_meta($post->ID, 'purchaseprice', true); if($ppfh != ""){ ?>
<div class="misc-pub-section">
<span class="ppt-labeltext">Purchased Price: </span>
<?php echo '<input type="text" name="field[purchaseprice]" value="'.get_post_meta($post->ID, 'purchaseprice', true).'" class="ppt-forminput" />'; ?>
</div>
<?php } } ?>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress"){ ?>
<div class="misc-pub-section">
<span class="ppt-labeltext">Reciprocal link:</span>
<?php echo '<input type="text" name="field[reclink]" value="'.get_post_meta($post->ID, 'reclink', true).'" class="ppt-forminput" />'; ?>
</div>
<?php } ?>

 


<?php 

 
 	

if(strtolower(PREMIUMPRESS_SYSTEM) == "moviepress"){

 
	 
	
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Video Duration ", 'sp' ) . '</span>';
		echo '<input type="text" name="field[duration]" value="'.get_post_meta($post->ID, 'duration', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '</div> <div class="clearfix"></div>';
		

	
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Video Filename</span>';
		echo '<input type="text" name="field[filename]" id="g_filename" value="'.get_post_meta($post->ID, 'filename', true).'"class="ppt-forminput" /><br /> ';

		?>
        
        
        
		<a href='javascript:void(0);' onclick="toggleLayer('DisplayImages'); add_video_next(0,'<?php echo get_option("imagestorage_path"); ?>videos/','<?php echo get_option("imagestorage_link"); ?>videos/','g_filename');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/premiumpress/led-ico/find.png" align="middle"> View Video Files</a> <a href="admin.php?page=images&tab=nw&lightbox[iframe]=true&lightbox[width]=400&lightbox[height]=250"  class="lightbox" target="_blank" style="margin-left:50px;"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/premiumpress/led-ico/monitor.png" align="middle"> Upload Video </a> 
		<br /><br /><div class="clearfix"></div>
        
        
        
		<?php
		
		
		echo ' <div class="clearfix"></div> </div>';
		
	 
	
	 
   
} // if moviepress
 
		
		
		
		
		
	if(strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){
	
 			
	  	echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Property Price ", 'sp' ) . '</span>';
		echo get_option('currency_code').'<input type="text" name="field[price]" value="'.get_post_meta($post->ID, 'price', true).'" class="ppt-forminput" /><div class="clearfix"></div></div>';

	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Beds <small>(numeric value)</small>", 'sp' ) . '</span>';
		echo '<input type="text" name="field[bedrooms]" value="'.get_post_meta($post->ID, 'bedrooms', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '<div class="clearfix"></div></div>';

	 	
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Baths <small>(numeric value)</small>", 'sp' ) . '</span>';
		echo '<input type="text" name="field[bathrooms]" value="'.get_post_meta($post->ID, 'bathrooms', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '<div class="clearfix"></div></div>';
		
		
		
 		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Property Type ", 'sp' ) . '</span>';
		echo '<select name="field[propertytype]" class="ppt-forminput"><option value="houses"';
		
		if(get_post_meta($post->ID, 'propertytype', true) == "houses"){ echo 'selected'; }
		echo '>Houses</option>';
		
		echo '<option value="flats"';
		if(get_post_meta($post->ID, 'propertytype', true) == "flats"){ echo 'selected'; }
		echo '>Flats / Apartments</option>';
		
		echo '<option value="bungalows"';
		if(get_post_meta($post->ID, 'propertytype', true) == "bungalows"){ echo 'selected'; }
		echo '>Bungalows</option>';
		
		echo '<option value="land"';
		if(get_post_meta($post->ID, 'propertytype', true) == "land"){ echo 'selected'; }
		echo '>Land</option>'; 
		
		echo '<option value="commercial"';
		if(get_post_meta($post->ID, 'propertytype', true) == "commercial"){ echo 'selected'; }
		echo '>Commercial Property</option>';
		
		echo '<option value="other"';
		if(get_post_meta($post->ID, 'other', true) == "other"){ echo 'selected'; }
		echo '>Other</option>';
		
 	
		
		echo '</select></div> ';		
 	 
 		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Listing Type ", 'sp' ) . '</span>';
		echo '<select name="field[listtype]" class="ppt-forminput"><option value="sale"';
		if(get_post_meta($post->ID, 'listtype', true) == "sale"){ echo 'selected'; }
		echo '>For Sale</option>';
		
		echo '<option value="rent"';
		if(get_post_meta($post->ID, 'listtype', true) == "rent"){ echo 'selected'; }
		echo '>For Rent (long term - monthly)</option>';
		
		echo '<option value="rent-short"';
		if(get_post_meta($post->ID, 'listtype', true) == "rent-short"){ echo 'selected'; }
		echo '>For Rent (short term - weekly)</option>';
 
		echo '<option value="lease"';
		if(get_post_meta($post->ID, 'listtype', true) == "lease"){ echo 'selected'; }
		echo '>For Lease</option>';		
		
		echo '<option value="rent-buy"';
		if(get_post_meta($post->ID, 'listtype', true) == "rent-buy"){ echo 'selected'; }
		echo '>Rent To Buy</option>';	
		
		echo '</select></div> ';
	 
		
	 	echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Listing Status ", 'sp' ) . '</span>';
		echo '<select name="field[liststatus]" class="ppt-forminput">';
 
		echo '<option value="active"';
		if(get_post_meta($post->ID, 'liststatus', true) == "active"){ echo 'selected'; }
		echo '>Active</option>';	
		
		echo '<option value="sold"';
		if(get_post_meta($post->ID, 'liststatus', true) == "sold"){ echo 'selected'; }
		echo '>Sold</option>';		

		echo '<option value="rented"';
		if(get_post_meta($post->ID, 'liststatus', true) == "rented"){ echo 'selected'; }
		echo '>Rented</option>';	

		echo '<option value="leased"';
		if(get_post_meta($post->ID, 'liststatus', true) == "leased"){ echo 'selected'; }
		echo '>Leased</option>';
		
		echo '<option value="pending"';
		if(get_post_meta($post->ID, 'liststatus', true) == "pending"){ echo 'selected'; }
		echo '>Contract Pending</option>';
		
		echo '<option value="vacation"';
		if(get_post_meta($post->ID, 'liststatus', true) == "vacation"){ echo 'selected'; }
		echo '>vacation property</option>';
		 
		
		echo '</select><div class="clearfix"></div></div> ';
	 
		
		}
		
		
		
		if(strtolower(PREMIUMPRESS_SYSTEM) == "employeepress"){	
		
		
		$JobVisible = get_post_meta($post->ID, 'visible', true);
		
		  
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Visibility", 'sp' ) . '</span>';
		echo '<select name="field[visible]" class="ppt-forminput"><option ';
				
		if($JobVisible == "public"){ echo "selected=selected"; }		
		echo ' value="public">Public</option><option ';		
		if($JobVisible == "private"){ echo "selected=selected"; }		
 	
		echo ' value="private">Private (Members Only)</option>	 
		</select><div class="clearfix"></div></div>';
		
	 
		$JobType = get_post_meta($post->ID, 'positiontype', true);
		
	  
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Position Type", 'sp' ) . '</span>';
		echo '<select name="field[positiontype]" class="ppt-forminput"><option ';
				
		echo '<option '; if($JobType == "fulltime"){ echo "selected=selected"; } echo ' value="fulltime">Full-time</option>	';  
		
		echo '<option '; if($JobType == "parttime"){ echo "selected=selected"; } echo ' value="parttime">Part-time</option>	';
		
		echo '<option '; if($JobType == "contract"){ echo "selected=selected"; } echo ' value="contract">Contract</option>	';
		
		echo '<option '; if($JobType == "internship"){ echo "selected=selected"; } echo ' value="internship">Internship</option>	';
		
		echo '<option '; if($JobType == "temporary"){ echo "selected=selected"; } echo ' value="temporary">Temporary</option>	';
		  
		echo '</select><div class="clearfix"></div></div>';
 	
		$JobType = get_post_meta($post->ID, 'paytype', true);
		
		 echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Salary Type", 'sp' ) . '</span>';
		echo '<select name="field[paytype]" class="ppt-forminput"><option ';
				
		echo '<option '; if($JobType == "hourly"){ echo "selected=selected"; } echo ' value="hourly">Hourly</option>	'; 
			
		echo '<option '; if($JobType == "fixed-monthly"){ echo "selected=selected"; } echo ' value="fixed-monthly">Fixed Price (Monthly)</option>	';		
		echo '<option '; if($JobType == "fixed-yearly"){ echo "selected=selected"; } echo ' value="fixed-yearly">Fixed Price (Yearly)</option>	';		
		echo '<option '; if($JobType == "budget"){ echo "selected=selected"; } echo ' value="budget">Budget</option>	';		
		 
		echo '</select><div class="clearfix"></div></div>';
 	
		$JobType = get_post_meta($post->ID, 'jobtype', true);
		
		  
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Job Type", 'sp' ) . '</span>';
		echo '<select name="field[jobtype]" class="ppt-forminput"><option ';
				
		echo '<option '; if($JobType == "bid"){ echo "selected=selected"; } echo ' value="bid">Bidding</option>	'; 
			
		echo '<option '; if($JobType == "resume"){ echo "selected=selected"; } echo ' value="resume">Resumes</option>	';		
		 
		echo '</select><div class="clearfix"></div></div>';
	 	
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Salary  (Hourly Rate)", 'sp' ) . '</span>';
		echo '<input type="text" name="field[hourly_value]" value="'.get_post_meta($post->ID, 'hourly_value', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '</div> <div class="clearfix"></div>';
	 
		
		
		$JobStart = get_post_meta($post->ID, 'starting', true);
	 	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Position Available From", 'sp' ) . '</span>';
		echo '<select name="field[starting]" class="ppt-forminput"><option ';
				
		if($JobStart == "hourly"){ echo "selected=selected"; }		
		echo ' value="immediately">immediately</option><option ';		
		if($JobStart == "date"){ echo "selected=selected"; }		
 	
		echo ' value="date">specific date (below)</option>	 
		</select><div class="clearfix"></div></div>';
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Salary (Fixed)", 'sp' ) . '</span>';
		echo '<input type="text" name="field[salary]" value="'.get_post_meta($post->ID, 'salary', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '</div> <div class="clearfix"></div>';
	 	
		
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Start Date", 'sp' ) . '</span>';		
		echo '<input type="text" name="field[starting_date]" id="start-date" class="date-pick dp-applied" value="'.get_post_meta($post->ID, 'starting_date', true).'" class="ppt-forminput" /><div class="clearfix"></div><small>Format yyyy-mm-dd</small></div>';
		
		}


		if(strtolower(PREMIUMPRESS_SYSTEM) == "comparisonpress"){		
		


		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Regular Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[price]" value="'.get_post_meta($post->ID, 'price', true).'" class="ppt-forminput" style="width:150px;"/> ';
		echo '</div> <div class="clearfix"></div>';
		
	 	
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Old Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[old_price]" value="'.get_post_meta($post->ID, 'old_price', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '</div> <div class="clearfix"></div>';
		
	 	 
 		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Buy Link", 'sp' ) . '</span>';
		echo '<input type="text" name="field[link]" value="'.get_post_meta($post->ID, 'link', true).'" class="ppt-forminput"/>';
		echo '<div class="clearfix"></div></div>';

	 	
		}
		
				
		if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress"){		
		
	 	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Listing Status", 'sp' ) . '</span>';
		echo '<select name="field[bid_status]" class="ppt-forminput">';		
		
		echo '<option value="open"';
		if(get_post_meta($post->ID, 'bid_status', true) == "option"){ echo 'selected'; }
		echo '>Active (Open for bids)</option>';	
		
		echo '<option value="closed"';
		if(get_post_meta($post->ID, 'bid_status', true) == "closed"){ echo 'selected'; }
		echo '>Temporary Closed (Visible but bidding is disabled)</option>';	
		
		echo '<option value="payment"';
		if(get_post_meta($post->ID, 'bid_status', true) == "payment"){ echo 'selected'; }
		echo '>Pending Payment (Auction ended, winner accepted)</option>';	
		
		echo '<option value="finished"';
		if(get_post_meta($post->ID, 'bid_status', true) == "finished"){ echo 'selected'; }
		echo '>Finished (Auction Ended & Payment Completed)</option>';
 
		echo '</select><div class="clearfix"></div></div>';
		

	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Visibility", 'sp' ) . '</span>';
		echo '<select name="field[display]" class="ppt-forminput">
		<option '.$d1.' value="public">Public - Visible to everyone</option>
		<option '.$d2.' value="private">Private - Members Only</option></select><div class="clearfix"></div></div>';
		


	 
		$buynowonly = get_post_meta($post->ID, 'buynowonly', true);
		
	  
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Buy Now Only", 'sp' ) . '</span>';
		echo '<select name="field[buynowonly]" class="ppt-forminput"><option ';
				
		echo '<option '; if($buynowonly == "yes"){ echo "selected=selected"; } echo ' value="yes">Yes</option>	'; 
			
		echo '<option '; if($buynowonly == "no"){ echo "selected=selected"; } echo ' value="no">No</option>	';		
		 	
		echo '</select><div class="clearfix"></div></div>';		 
		
			 
	
		$makeoffer = get_post_meta($post->ID, 'makeoffer', true);
		
	  
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Make Offer", 'sp' ) . '</span>';
		echo '<select name="field[makeoffer]" class="ppt-forminput"><option ';
				
		echo '<option '; if($makeoffer == "yes"){ echo "selected=selected"; } echo ' value="yes">Yes</option>	'; 
			
		echo '<option '; if($makeoffer == "no"){ echo "selected=selected"; } echo ' value="no">No</option>	';		
		 
		 	echo '<option '; if($makeoffer == "pending"){ echo "selected=selected"; } echo ' value="pending">Pending Offer (waiting user acceptance)</option>	';
			
		echo '</select><div class="clearfix"></div></div>';


		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Current Price  ", 'sp' ) . '</span>';
		echo get_option('currency_symbol').'<input type="text" name="field[price_current]" value="'.get_post_meta($post->ID, 'price_current', true).'" class="ppt-forminput" /><div class="clearfix"></div></div>';
 
 		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Reserve Price ", 'sp' ) . '</span>';
		echo get_option('currency_symbol').'<input type="text" name="field[price_reserve]" value="'.get_post_meta($post->ID, 'price_reserve', true).'" class="ppt-forminput" /><div class="clearfix"></div></div>';
 	
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("BIN Price", 'sp' ) . '</span>';
		echo get_option('currency_symbol').'<input type="text" name="field[price_bin]" value="'.get_post_meta($post->ID, 'price_bin', true).'" class="ppt-forminput" /><div class="clearfix"></div></div>';
 	
	

	
	
	/*	echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Bid Count ", 'sp' ) . '</span>';
		echo '<input type="text" name="field[bid_count]" value="'.get_post_meta($post->ID, 'bid_count', true).'" class="ppt-forminput" /><div class="clearfix"></div></div>';
	  			
	
	 	
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Hightest Bidder ", 'sp' ) . '</span>';
		echo '<input type="text" name="field[bidder_username]" value="'.get_post_meta($post->ID, 'bidder_username', true).'" class="ppt-forminput" /><div class="clearfix"></div></div>';
		
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Bidder User ID", 'sp' ) . '</span>';
		echo '<input type="text" name="field[bidder_ID]" value="'.get_post_meta($post->ID, 'bidder_ID', true).'" class="ppt-forminput" style="width:150px;"  />
		<div class="clearfix"></div></div>';				
	*/
		 
		
	 	
		}

	if(strtolower(PREMIUMPRESS_SYSTEM) == "dealspress"){	

		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Regular Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[price]" value="'.get_post_meta($post->ID, 'price', true).'" class="ppt-forminput" style="width:150px;"/> ';
		echo '</div> <div class="clearfix"></div>';
		
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Discount</span>';
		echo '%<input type="text" name="field[discount]" value="'.get_post_meta($post->ID, 'discount', true).'" class="ppt-forminput" style="width:150px;"/> ';
		echo '</div> <div class="clearfix"></div>';
		
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Start Date", 'sp' ) . '</span>';		
		echo '<input type="text" name="field[starts]" id="start-date" class="date-pick dp-applied" value="'.get_post_meta($post->ID, 'starts', true).'" class="ppt-forminput" /><div class="clearfix"></div><small>Format yyyy-mm-dd</small></div>';
		 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("End Date", 'sp' ) . '</span>';
		echo '<input type="text" name="field[pexpires]" id="end-date" class="date-pick dp-applied" value="'.htmlentities(get_post_meta($post->ID, 'pexpires', true)).'" class="ppt-forminput" /><div class="clearfix"></div><small>Format yyyy-mm-dd</small></div>'; 
	}		
	if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress"){	
		
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Website Link", 'sp' ) . '</span>';
		echo '<input type="text" name="field[url]" value="'.get_post_meta($post->ID, 'url', true).'" class="ppt-forminput"/>';	
		echo '<div class="clearfix"></div></div>';	
	
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Affiliate Link", 'sp' ) . '</span>';
		echo '<input type="text" name="field[link]" value="'.get_post_meta($post->ID, 'link', true).'" class="ppt-forminput"/>';
		echo '<div class="clearfix"></div></div>';	
		
 
	
	}
		
		if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress"){
		
	 	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Coupon Type", 'sp' ) . '</span>';
		echo '<select name="field[type]" class="ppt-forminput"><option ';		
		if($couponType == "coupon"){ echo "selected=selected"; }		
		echo ' value="coupon">Coupon</option><option ';		
		if($couponType == "print"){ echo "selected=selected"; }		
		echo ' value="print">Printable Coupon</option><option ';		
		if($couponType == "offer"){ echo "selected=selected"; }		
		echo ' value="offer">Offer</option>	 
		</select></div>';
		
 
 	
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Coupon Code ", 'sp' ) . '</span>';
		echo '<input type="text" name="field[code]" value="'.get_post_meta($post->ID, 'code', true).'" class="ppt-forminput" /><div class="clearfix"></div></div>';	
		
		 
			 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Affiliate Link", 'sp' ) . '</span>';
		echo '<input type="text" name="field[link]" value="'.get_post_meta($post->ID, 'link', true).'" class="ppt-forminput"/>';
		echo '<div class="clearfix"></div></div>';	
		
	 	
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Start Date", 'sp' ) . '</span>';		
		echo '<input type="text" name="field[starts]" id="start-date" class="date-pick dp-applied" value="'.get_post_meta($post->ID, 'starts', true).'" class="ppt-forminput" /><div class="clearfix"></div><small>Format yyyy-mm-dd</small></div>';
		 
		
		 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("End Date", 'sp' ) . '</span>';
		echo '<input type="text" name="field[pexpires]" id="end-date" class="date-pick dp-applied" value="'.htmlentities(get_post_meta($post->ID, 'pexpires', true)).'" class="ppt-forminput" /><div class="clearfix"></div><small>Format yyyy-mm-dd</small></div>'; 
		
		 
	 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Website Link", 'sp' ) . '</span>';
		echo '<input type="text" name="field[url]" value="'.get_post_meta($post->ID, 'url', true).'" class="ppt-forminput"/>';	
		echo '<div class="clearfix"></div></div>';	
	
 	 
		
		}
		
		if(strtolower(PREMIUMPRESS_SYSTEM) == "classifiedstheme"){
		
		
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Regular Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[price]" value="'.get_post_meta($post->ID, 'price', true).'" class="ppt-forminput" style="width:150px;"/> ';
		echo '</div> <div class="clearfix"></div>';
 		 
		 $itemstatus = get_post_meta($post->ID, 'itemstatus', true);
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Item Status", 'sp' ) . '</span>';
		echo '<select name="field[itemstatus]" class="ppt-forminput"><option ';		
		if($itemstatus == "active"){ echo "selected=selected"; }		
		echo ' value="active">Available</option><option ';		
		if($itemstatus == "sold"){ echo "selected=selected"; }		
		echo ' value="sold">Item Sold</option>	 
		</select><div class="clearfix"></div></div>';
		
		
		 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Affiliate Link", 'sp' ) . '</span>';
		echo '<input type="text" name="field[link]" value="'.get_post_meta($post->ID, 'link', true).'" class="ppt-forminput"/>';
		echo '<div class="clearfix"></div></div>';			
	 
		 
		}
 
 


$ThisPack 	= get_post_meta($post->ID, 'packageID', true);
		$packdata 	= get_option("packages");
		$cf1 		= get_option("customfielddata"); 
		$tdC =1; 
?>
 
<?php

 	$i=0; while($i < 50){
	 
		
		if(isset($cf1[$i]['name']) && strlen($cf1[$i]['name']) > 0 && $cf1[$i]['fieldtitle'] != 1){ 		
			$Value= get_post_meta($post->ID, $cf1[$i]['key'], true);
			
			// make package string
			$td = "";
			if(isset($cf1[$i]['pack1']) && $cf1[$i]['pack1'] == 1){ $td .= strip_tags($packdata[1]['name'])."<br />"; }
			if(isset($cf1[$i]['pack2']) && $cf1[$i]['pack2'] == 1){ $td .= strip_tags($packdata[2]['name'])."<br />"; }
			if(isset($cf1[$i]['pack3']) && $cf1[$i]['pack3'] == 1){ $td .= strip_tags($packdata[3]['name'])."<br />"; }
			if(isset($cf1[$i]['pack4']) && $cf1[$i]['pack4'] == 1){ $td .= strip_tags($packdata[4]['name'])."<br />"; }
			if(isset($cf1[$i]['pack5']) && $cf1[$i]['pack5'] == 1){ $td .= strip_tags($packdata[5]['name'])."<br />"; }
			if(isset($cf1[$i]['pack6']) && $cf1[$i]['pack6'] == 1){ $td .= strip_tags($packdata[6]['name'])."<br />"; }
			if(isset($cf1[$i]['pack7']) && $cf1[$i]['pack7'] == 1){ $td .= strip_tags($packdata[7]['name'])."<br />"; }
			if(isset($cf1[$i]['pack8']) && $cf1[$i]['pack8'] == 1){ $td .= strip_tags($packdata[8]['name'])."<br />"; }
			if($td == ""){ $td = "<span style='color:red;'>No Packages Selected</span>"; }
			

			 		
			echo '<div class="misc-pub-section"> <span class="ppt-labeltext">' .stripslashes($cf1[$i]['name'])."</span> ";
			
			 echo '<a href="javascript:void(0);" onmouseover="this.style.cursor=\'pointer\';" 
onclick="PPMsgBox(&quot;<p>This field will be displayed for the following packages</p><p>'.$td.'</p>&quot;);"><img src="'.PPT_FW_IMG_URI.'help.png" style="float:right;" /></a>
			
			 <br>'; 
			 
			
			switch($cf1[$i]['type']){
				 case "textarea": {
					echo '<textarea class="adfields" name="'.$cf1[$i]['key'].'" class="ppt-forminput" style="width:98%;">';
					echo $Value;
					echo '</textarea>';
				 } break;
				 
				  // added in 7.1.1 (1st sep)
				 case "check": { 
				 
					// DEFAULT VALUE
					$listval = explode("|",$Value );
					$STRING = "<br>";
					 $listvalues = explode(",",$cf1[$i]['value']);					 
					
					 foreach($listvalues as $value){ 
						if(is_array($listval) && in_array($value,$listval) ){ 
						$STRING .= '<span class="shortcheckedwrap" style="float:left;width:200px; margin-bottom:10px;"><input type="checkbox" name="custom['.$i.'][value][]" class="shortchecked"  value="'.$value.'" checked=checked> '.$value."</span>"; 
						}else{
						$STRING .= '<span class="shortcheckedwrap" style="float:left;width:200px; margin-bottom:10px;"><input type="checkbox" name="custom['.$i.'][value][]" class="shortchecked"  value="'.$value.'"> '.$value."</span>"; 
						}
					} // end foreach
					 
					 echo $STRING;
				 
				 
				 } break;				 
				 
				 case "list": {
					$listval = $Value; 
					$listvalues = explode(",",$cf1[$i]['value']);
					echo '<select name="'.$cf1[$i]['key'].'" class="ppt-forminput">';
					foreach($listvalues as $value){ 
					
					$value = stripslashes(stripslashes(stripslashes($value)));
						if($listval ==  $value){ 
						echo '<option value="'.$value.'" selected>'.$value.'</option>'; 
						}else{
						echo '<option value="'.$value.'">'.$value.'</option>'; 
						}
					}
					echo '</select>';		
		
				 } break;
				 default: {
					echo '<input type="text" class="ppt-forminput" name="'.$cf1[$i]['key'].'" size="55" maxlength="100" value="'.$Value.'">';
				 }	
				} 
				
				if($cf1[$i]['type'] == "check"){
				echo '<input type="hidden"  name="custom['.$i.'][name]" value="check" />';
				echo '<input type="hidden"  name="custom['.$i.'][name1]" value="'.$cf1[$i]['key'].'" />';
				}else{
				echo '<input type="hidden"  name="custom['.$i.'][name]" value="'.$cf1[$i]['key'].'" />';
				}

				echo '<div class="clearfix"></div>  </div>'; 
			}
			
			
		 
			$i++;
		}
?>


<div class="misc-pub-section">
<span class="ppt-labeltext">Map Address</span>
<?php
echo '<input type="text" name="field[map_location]" value="'.get_post_meta($post->ID, 'map_location', true).'" style="width:80%;font-size:16px;"   />';
?>
</div>	

<?php }else{ 




		 
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Regular Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[price]" value="'.get_post_meta($post->ID, 'price', true).'" class="ppt-forminput" style="width:150px;"/> ';
		echo '</div> <div class="clearfix"></div>';
		
	 	
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">Old Price ('.get_option('currency_symbol').')</span>';
		echo '<input type="text" name="field[old_price]" value="'.get_post_meta($post->ID, 'old_price', true).'" class="ppt-forminput" style="width:150px;"/>';
		echo '</div> <div class="clearfix"></div>';
		
		echo '<div class="misc-pub-section"><span class="ppt-labeltext">' . __("Quantity (QTY)", 'sp' ) . '<a href="javascript:void(0);" onmouseover="this.style.cursor=\'pointer\';" 
onclick="PPMsgBox(&quot;This is only used if you are managing stock levels. &quot;);"><img src="'.PPT_FW_IMG_URI.'help.png" style="float:right;" /></a></span>';
		echo '<input type="text" name="field[qty]" value="'.get_post_meta($post->ID, 'qty', true).'" class="ppt-forminput" style="width:150px;" />
		<div class="clearfix"></div></div>';
			 

		// PRODUCT TYPE
		$PT = get_post_meta($post->ID, 'file_type', true); 
		$endbit = '<div class="misc-pub-section"><span class="ppt-labeltext">Product Type:</span> ';
	
			$endbit .= '<select name="field[file_type]" style="width:150px;"><option value=""';
			if($PT == ""){ $endbit .= 'selected'; }
			$endbit .= '>Standard Product</option>';
			
			$endbit .= '<option value="affiliate"';
			if($PT == "affiliate"){ $endbit .= 'selected'; }
			$endbit .= '>Affiliate Product</option>';
			
			$endbit .= '<option value="free"';
			if($PT == "free"){ $endbit .= 'selected'; }
			$endbit .= '>Digital Download (Free)</option>';		 	
	
			$endbit .= '<option value="paid"';
			if($PT == "paid"){ $endbit .= 'selected'; }
			$endbit .= '>Digital Download (Paid Credits)</option>';	
			
			$endbit .= '<option value="cart"';
			if($PT == "cart"){ $endbit .= 'selected'; }
			$endbit .= '>Digital Download (Add To Cart)</option>';		
					
		$endbit .= '</select></div> <div class="clearfix"></div>';
		
		if($PT == "free" || $PT == "cart" || $PT == "paid"){
		
		$endbit .= '<div class="misc-pub-section"><span class="ppt-labeltext">Filename:</span> <input type="text" name="field[file]" value="'.get_post_meta($post->ID, 'file', true).'"  />';
		if(get_post_meta($post->ID, 'file', true) != ""){	
		$endbit .= '<a href="admin.php?page=setup&testdownloadID='.$post->ID.'" target="_blank" class="button tagadd">Test Download Link</a>';
		}
		$endbit .= '</div> <div class="clearfix"></div>';
		
		} 
		
		 
		
		echo $endbit;

 } ?>
</div>




<!-- ***********************************************************
IMAGE OPTIONS
*************************************************************** -->
<div class="ppt-tabs_content" style="left: -750px;">
 
 
<div class="misc-pub-section"> Display Image
     <?php 
if(strlen(get_post_meta($post->ID, 'image', true)) > 3){  
 
echo premiumpress_image($post->ID,"",array('alt' => $post->post_title,  'link' => 'self', 'link_class' => 'lightbox',   'style' => 'max-height:20px; max-width:20px; float:right; border:1px solid #ddd; padding:1px; margin-top:-7px;' ));
 
}  
 		
?>
    <input type="text" name="field[image]" id="g_image" value="<?php echo get_post_meta($post->ID, 'image', true); ?>"  style="font-size:11px;"/>
    
    <input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','g_image');" type="button" class="button tagadd" value="View Images"  >
    <input id="upload_g_image" type="button" class="button tagadd" size="36" name="upload_g_image" value="Upload Image" />
    
</div>
    

<div class="misc-pub-section"> Featured Image
<a href="javascript:void(0);" onmouseover="this.style.cursor=\'pointer\';" 
onclick="PPMsgBox(&quot;<p>The featured image is only used for the home page sliders and will replace the default image if set.</p>&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>/help.png" style="float:right;" /></a>
<input type="text" name="field[featured_image]" id="g_featured_image" value="<?php echo get_post_meta($post->ID, 'featured_image', true); ?>" style="font-size:11px;"/>
<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','g_featured_image');" type="button" class="button tagadd" value="View Images">       
  <input id="upload_g_featured_image" type="button" class="button tagadd" size="36" name="upload_g_featured_image" value="Upload Image" />

</div>       
      
<?php

$images = get_post_meta($post->ID, 'images', true);

if(strlen($images) > 1){ $mimg = explode(",",get_post_meta($post->ID, 'images', true));}else{ $images=""; $mimg=""; }
if(!is_array($mimg)){ $mimg= array(); }
$crrent_total = count($mimg);
$ff = 0;

while($ff < (20+$crrent_total) ){ 
		 
		if(isset($mimg[$ff]) && strlen($mimg[$ff]) > 3 || $ff < 1){
			echo '<div id="gbg'.$ff.'"> ';
		}else{
			echo '<div id="gbg'.$ff.'" style="display:none;"> '; // 
		}
			
		$num = $ff+1;
			
		if(isset($mimg[$ff]) && strlen(trim($mimg[$ff])) > 3){
			echo "<a href='".premiumpress_image_check($mimg[$ff],"full")."' class='lightbox'><img src='".premiumpress_image_check($mimg[$ff],"full")."' style='max-height:20px; max-width:20px; float:right; border:1px solid #ddd; padding:1px; margin-top:7px;'></a>";
		}
			
			
		echo '<div class="misc-pub-section">  Gallery Image '.$num;
		
		if(isset($mimg[$ff]) && strlen(trim($mimg[$ff])) > 3){
			$bv = $mimg[$ff];
			
		}else{
			$bv="";
		}  
			
		echo ' <input type="text" name="galimg[]" value="'.$bv.'" style="font-size:11px;" id="galimg'.$ff.'"/>';?>
		
		<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','galimg<?php echo $ff; ?>');" type="button" class="button tagadd" value="View Images"	>
		<input id="upload_galimg<?php echo $ff; ?>" type="button" class="button tagadd" size="36" name="upload_galimg<?php echo $ff; ?>" value="Upload Image" />
        
        
		<?php	
		 
		$trynext = $ff+1;
		if(isset($mimg[$trynext]) && strlen($mimg[$trynext]) > 3){ }else{
		$divH = $ff*100+400;
		
		echo ' </div>
		
		<div id="BUTCF'.$ff.'" class="misc-pub-section-last" style="padding:10px;">		
		 <a href="javascript:void(0);" onclick="toggleLayer(\'gbg'.$trynext.'\');toggleLayer(\'BUTCF'.$ff.'\');document.getElementById(\'ppt-tabs_content_container\').style.height = \''.$divH.'px\'"   class="button">Add New Gallery Image</a>
		';
		  
		}
		
		echo ' </div> </div>  ';		

$ff++;
}  // end while

?>
</div>









<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){ ?>
<!-- ***********************************************************
MEMBERSHIP ACCESS FIELDS
*************************************************************** -->


<div class="ppt-tabs_content" style="left: -750px;">
 

 
<?php
	//1. GET PACKAGE DATA	
	$nnewpakarray 	= array();
	$packagedata 	= get_option('ppt_membership');
	if(is_array($packagedata) && isset($packagedata['package']) ){ foreach($packagedata['package'] as $val){		
		$nnewpakarray[] =  $val['ID'];		
	} }
	
	//2. GET POST - PACKAGE DATA
	$postpackagedata 	= get_post_meta($post->ID, 'package_access', true);
	if(!is_array($postpackagedata)){ $postpackagedata = array(0); }
	
	?>    
	
	<label style="font-size:11px; line-height:30px;"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/pakicon.png" align="absmiddle" alt="nr" /> Here you can select which membership packages can view this listing. <a href="http://www.premiumpress.com/tutorial/membership-packages/?TB_iframe=true&width=640&height=838" class="thickbox">Learn More Here</a></label>
    
    
	<select name="package_access[]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="0" <?php if(in_array(0,$postpackagedata)){ echo "selected=selected"; } ?>>All Package Access</option>
    <?php 
	$i=0;
	if(is_array($packagedata) && isset($packagedata['package']) ){
	foreach($packagedata['package'] as $package){	
		
		if(is_array($postpackagedata) && in_array($package['ID'],$postpackagedata)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']." ( package ID: ".$package['ID'].")</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']." ( package ID: ".$package['ID'].")</option>";		
		}
		
	$i++;		
	} } // end foreach
	
    ?>
	</select>
    <br /><small>Hold CTRL to select multiple packages. </small> <br /> <small><a href="admin.php?page=membership">edit membership packages here</a></small> 
</div>
<?php } ?>
  
  
    
<?php premiumpress_admin_post_custom_content(); ?> 
 

 
</div></div> 

 
<p><input type="submit" value="Save Changes" class="button-primary"  /> 

       <a href="http://www.premiumpress.com/tutorial/theme-custom-fields/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
        

</p>
</div>
<div class="clearfix"></div>

 
<script type="text/javascript"> jQuery(".chzn-select").chosen(); jQuery(".chzn-select-deselect").chosen({allow_single_deselect:true}); </script>

<?php
 

} 
 
 

 





















 


 







 

function ppt_remove_columns($defaults) {

if(isset($_GET['post_type']) && $_GET['post_type'] !="post" ){

}else{

unset($defaults['title']);
unset($defaults['categories']);
unset($defaults['date']);
unset($defaults['comments']);
unset($defaults['author']);
unset($defaults['tags']);

}
 
    return $defaults;
}


function MoveProducts(){
?>
<form action="" method="post" name="movemenow" id="movemenow">
<input name="movePID" id="movePID" type="hidden" value="" />
<input name="movetoPID" id="movetoPID" type="hidden" value="" />
</form>
<?php

}
if(strtolower(PREMIUMPRESS_SYSTEM) == "comparisonpress"){
add_action('admin_footer', 'MoveProducts');
}


function HeaderPOSTData(){

	global $wpdb;
	// MOVE THE POST TO THE NEW SUB POST LOCATION
	if(isset($_POST['movePID']) && is_numeric($_POST['movePID']) ){
	 
	// UPDATE POST TYPE
	$SQL = "UPDATE $wpdb->posts SET post_type='ppt_compare' WHERE ID='".$_POST['movePID']."' LIMIT 1"; 
	mysql_query($SQL);
	add_post_meta($_POST['movePID'], 'pID', $_POST['movetoPID']);
	
	
	}

}




function ppt_custom_columns($defaults) { 

	if(isset($_GET['post_type']) && $_GET['post_type'] != "post" ){
	
		if($_GET['post_type'] == "ppt_compare"){
		
		//$defaults['image'] 		= 'Image';
		
		}
	
		return $defaults;
		
	}else{
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress"){
	
	$defaults['image'] 		= 'Image';
	$defaults['price'] 		= "Price";
	$defaults['hits'] 		= 'Views';
	$defaults['bids'] 		= "Bids";
	$defaults['title'] 		= 'Name';
 	$defaults['categories'] = 'Categories';	
    $defaults['apexpire'] 	= "Auction Status";
	$defaults['ID'] 		= "ID"; 
	$defaults['date'] 		= 'Date';	
 

	return $defaults;
	
	}	
	

 
	if(strtolower(PREMIUMPRESS_SYSTEM) == "employeepress1"){
	
	$defaults['title'] 		= 'Name';
	$defaults['eptype'] 	= 'Job Type';
	$defaults['epstatus'] 	= 'Job Status';
	$defaults['date'] 		= 'Date';
	return $defaults;
	
	}	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "comparisonpress"){
	
	$defaults['image'] 		= 'Image';
	$defaults['price'] 		= "Price";
	$defaults['hits'] 		= 'Views';
	$defaults['found'] 		= 'Similar';
	$defaults['title'] 		= 'Name';
 	$defaults['categories'] = 'Categories';	
	$defaults['ID'] 		= "ID"; 
	$defaults['SKU'] 		= 'SKU';
	$defaults['date'] 		= 'Date';	
	return $defaults;
	
	}	
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "resumepress"){
	
	$defaults['userphoto'] 		= 'Image';
	
	}else{
	
	$defaults['image'] 		= 'Image';
	
	}
	
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"  || strtolower(PREMIUMPRESS_SYSTEM) == "classifiedstheme" || strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" && get_option("display_ignoreQTY") == "yes"){ $defaults['qty'] 		= __('QTY');  }	 
	
	$defaults['price'] 		= "Price";
	}
	$defaults['hits'] 		= 'Views';	
	$defaults['title'] 		= 'Name';
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){
	$defaults['rptype'] 	= 'Listing Type';
	}
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress"){
	$defaults['cptype'] 	= 'Coupon Type';
	}
	
	$defaults['categories'] = 'Categories';
 
	
	if(strtolower(PREMIUMPRESS_SYSTEM) != "comparisonpress" && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && get_option('pak_enabled') == 1){ $defaults['pak'] 		= "Package"; }
	
	$defaults['ID'] 		= "ID";
	if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" ){
	$defaults['SKU'] 		= 'SKU';
	}
	
 
	
	$defaults['date'] 		= 'Date';
 		
	}
    return $defaults;
}


function price_column_register_sortable( $columns ) {
	$columns['ID'] 		= 'ID';
	$columns['hits'] 	= 'Views';
 	$columns['price'] 	= 'price';
	$columns['qty'] 	= 'qty';
 	$columns['cptype'] 	= 'cptype';
	$columns['found'] 	= 'found';
	$columns['bids'] 	= 'bid_count';
 
	return $columns;
}

function price_column_orderby( $vars ) {

	if ( isset( $vars['orderby'] ) ) {
	
	if('views' == $vars['orderby'] ){
	
		$vars = array_merge( $vars, array(	'meta_key' => 'hits','orderby' => 'meta_value_num',	'order' => $_GET['order']) );

	}elseif ( 'price' == $vars['orderby'] ){
	
		$vars = array_merge( $vars, array(	'meta_key' => 'price','orderby' => 'meta_value_num',	'order' => $_GET['order']) );
	
	}elseif ( 'qty' == $vars['orderby'] ){
	
		$vars = array_merge( $vars, array(	'meta_key' => 'qty','orderby' => 'meta_value_num',	'order' => $_GET['order']) );
		
	}elseif ( 'cptype' == $vars['orderby'] ){
	
		$vars = array_merge( $vars, array(	'meta_key' => 'type', 'order' => $_GET['order']) );
		
	}elseif ( 'found' == $vars['orderby'] ){
	
		$vars = array_merge( $vars, array(	'meta_key' => 'found', 'order' => $_GET['order']) );

	}elseif ( 'bid_count' == $vars['orderby'] ){
	
		$vars = array_merge( $vars, array(	'meta_key' => 'bid_count', 'order' => $_GET['order']) );
		
				
	}	
		
		
	}
 
	return $vars;
}

function premiumpress_custom_column($column_name, $post_id) {

global $wpdb, $PPT, $post; 
 
if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" || strtolower(PREMIUMPRESS_SYSTEM) != "comparisonpress"){ $PACKAGE_OPTIONS = get_option("packages"); }

// SWITCH THE LIST OF COLUMNS	

 
switch($column_name){

	case "title": {  } break; // automatic
	case "ID": {  echo $post_id; } break;	
	case "SKU": {  echo get_post_meta($post_id, "SKU", true); } break;	
	case "bids": {  echo get_post_meta($post_id, "bid_count", true); } break;	
	case "found": {  echo get_post_meta($post_id, "found", true);	
 
	echo "<br> <a href='post-new.php?post_type=ppt_compare&pid=".$post_id."' style='background-color:yellow;font-size:8px;'>Add Comparison</a>
	<input type='hidden' value='".$post_id."' name='moveme'>
	<input name='newcompareID' id='newcompareID".$post_id."' onfocus=\"this.value='';\" value='post ID' type='text' style='width:40px;font-size:9px;' />
	<input type='button' value='move' onclick=\"document.getElementById('movetoPID').value=document.getElementById('newcompareID".$post_id."').value;document.getElementById('movePID').value='".$post_id."';document.movemenow.submit();\"   />
	";
	 
	
	} break;
	
	case "eptype": { echo get_post_meta($post_id, "jobtype", true); } break;	
	case "epstatus": { echo get_post_meta($post_id, "jobstatus", true); } break;	

	
	case "rutype": { echo get_post_meta($post_id, "type", true); } break;
	
	case "price": {  
		
		if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress"){
		
		$price = get_post_meta($post_id, "price_current", true);
		echo premiumpress_price($price,$CurrencySymbol,get_option('display_currency_position'),1);
		
		}else{
		
		$CurrencySymbol = get_option("currency_symbol");
		$price = get_post_meta($post_id, "price", true);
		$old_price = get_post_meta($post_id, "old_price", true);
		
		if ( !empty( $price ) ) {
		
		echo premiumpress_price($price,$CurrencySymbol,get_option('display_currency_position'),1);
 
		if($old_price !=""){
		echo " <br /> <strike>".premiumpress_price($old_price,$CurrencySymbol,get_option('display_currency_position'),1)."</strike>";
		}
		} else {
			echo "Free!";
		}
		}	
	
	} break;
	
	case "cptype": {
	
		$couponType = get_post_meta($post_id, 'type', true);
		if($couponType == "coupon"){ echo "Coupon <br><small>".get_post_meta($post_id, 'code', true)."</small>"; }
		if($couponType == "print"){ echo "Printable Coupon"; }
		if($couponType == "offer"){ echo "Offer"; }
	
	} break;	
	case "rptype": {
	
		if(get_post_meta($post_id, 'listtype', true) == "sale"){ echo 'For Sale'; }	 
		else if(get_post_meta($post_id, 'listtype', true) == "rent"){ echo 'For Rent (long term)'; }		 
		else if(get_post_meta($post_id, 'listtype', true) == "rent-short"){ echo 'For Rent (short term )'; }		 
		else if(get_post_meta($post_id, 'listtype', true) == "lease"){ echo 'For Lease'; }
	 
	
	} break;
	
	case "qty": { 
	
		$qty = get_post_meta($post_id, "qty", true);
		if ( !empty( $qty ) ) { echo $qty." in Stock"; }else{ echo "<strike>out of stock</strike>"; }	
	
	} break;
	
	case "apexpire": { 
	 
		$bidStatus = get_post_meta($post_id, "bid_status", true);
		
		switch($bidStatus){
		
		case "open": {
		
			$expires = get_post_meta($post_id, "expires", true);
			 
			echo "<b>Active Auction</b><br />";
			if($expires !=""){
			print "<small style='color:green; font-size:13px;'>".$expires." day listing</small>";
			}	
		
		}  break;
		
		case "closed": {
		
		print "<b style='color:blue;'>Temporary Closed<br><small>(Visible but bidding is disabled)</small></b>";
		
		}  break;
		
		case "payment": {
		
		print "<b style='color:blue;'>Ended - Pending Delivery</b>";
		
		}  break;
		
		case "finished": {
			print "<b style='color:orange;'>Completed - Item Delivered</b>";
		}  break;
		
		 default: { echo $bidStatus; }
		}
		
	
	} break;
	
	case "pak": { 
	
			$pak = get_post_meta($post_id, "packageID", true);
			if ( !empty( $pak ) ) {

				print strip_tags($PACKAGE_OPTIONS[$pak]['name']);
			} else {
				echo 'No Package Set';  //No Taxonomy term defined
			}	
	
	} break;

	case "hits": { 
	 
	
		echo get_post_meta($post_id, "hits", true);
		
	} break;
	
	case "image": {	
	
		 
		echo "<a href='post.php?post=".$post_id."&action=edit'>".premiumpress_image($post_id,"",array('alt' => "",  'width' => '50', 'height' => '50', 'style' => 'max-height:50px; max-width:50px; padding:1px; border:1px solid #ddd;' ))."</a>";		 
	} break;
	
	case "userphoto": { 
	  
	  	// GET USER PHOTO
        $img = get_user_meta($post->post_author, "pptuserphoto",true);
		if($img == ""){
			$img = get_avatar($post->post_author,52);
		}else{
			$img = "<img src='".get_option('imagestorage_link').$img."' class='photo' alt='user ".$post->post_author."' style='max-width:50px; max-height:50px;' />";
		}
		 
		echo $img;
		
	} break;
	
	case "tax": {
	
	
	
	} break;
	
 	
	}	 // end switch

} 



function ppt_metabox() {

	global $post;
	
	$PPM = new PremiumPress_Membership;
	

	// Disallows things like attachments, revisions, etc...
	$safe_filter =				array( 'public' => true, 'show_ui' => true );

	// Allow to be filtered, just incase you really need to switch between
	// those crazy types of posts
	$args =						apply_filters( 'pts_metabox', $safe_filter );

	// Get the post types based on the above arguments
	$post_types =				get_post_types( (array)$args );
 	// Populate necessary post_type values
	$cur_post_type =			$post->post_type;
	$cur_post_type_object =		get_post_type_object( $cur_post_type );

	// Make sure the currently logged in user has the power
	$can_publish =				current_user_can( $cur_post_type_object->cap->publish_posts );
?>

<div class="misc-pub-section post-type-switcher">

	<label for="pts_post_type"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/import.png" style="float:left; margin-right:5px;" /> Post Type:</label>
    
	<span id="post-type-display"><?php echo $cur_post_type_object->label; ?></span>
    
<?php	if ( $can_publish ) : ?>
	<a href="javascript:void(0);" class="edit-post-type hide-if-no-js" onClick="jQuery('#post-type-select').show();">Edit</a>
	<div id="post-type-select" style="display:none;">
		<select name="pts_post_type" id="pts_post_type">
<?php
		foreach ( $post_types as $post_type ) {
		
		if($post_type == "ppt_alert" || $post_type == "ppt_message"){ continue; }
			$pt = get_post_type_object( $post_type );
			if ( current_user_can( $pt->cap->publish_posts ) ) :
?>
			<option value="<?php echo $pt->name; ?>"<?php if ( $cur_post_type == $post_type ) : ?>selected="selected"<?php endif; ?>><?php echo $pt->label; ?></option>
<?php
			endif;
		}
?>
		</select>
		<input type="hidden" name="hidden_post_type" id="hidden_post_type" value="<?php echo $cur_post_type; ?>" />
		<a href="#pts_post_type" class="save-post-type hide-if-no-js button" onClick="jQuery('#post-type-select').hide();alert('This will be updated when you save the post.')">OK</a>
		<a href="javascript:void(0);" onClick="jQuery('#post-type-select').hide();">Cancel</a>
 

<?php
	endif; ?>
    
    
</div> 


</div>


<?php 

if(  $post->post_type == "post" ){

if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){ ?>

    <div class="misc-pub-section">
    <img src="<?php echo PPT_FW_IMG_URI; ?>clock.png" style="float:left; margin-right:5px;margin-top:5px;" /> Expiry Period: 
    <?php
    echo '<input type="text" name="field[expires]" value="'.get_post_meta($post->ID, 'expires', true).'" style="width:50px;" /> Days';					
    ?>
    </div>
    
    
    <?php  $expp = get_post_meta($post->ID, 'expires', true); if(is_numeric($expp) && strlen($expp) > 0){ ?>
    <div class="misc-pub-section">
    <label><img src="<?php echo PPT_FW_IMG_URI; ?>clock_stop.png" style="float:left; margin-right:5px;" /> Expires:</label>     
    <b>
    <?php $EPDate = date('Y-m-d h:i:s',strtotime(date("Y-m-d h:i:s", strtotime($post->post_date )) . " +".get_post_meta($post->ID, 'expires', true)." days")); echo PPTFormatTime($EPDate);	?>
    </b>		 
    </div>
    <?php } ?>

<?php } ?>


<div class="misc-pub-section">
 <img src="<?php echo PPT_FW_IMG_URI; ?>star.png" style="float:left; margin-right:5px;margin-top:5px;" /> Featured: 
<?php
		// PRODUCT TYPE
		$endbit  = "";
	$FT = get_post_meta($post->ID, 'featured', true); 
 
		$endbit .= '<select name="field[featured]" style="width:150px;font-size:11px;">';
		
		$endbit .= '<option value="no"';
		if($FT == "no"){ $endbit .= 'selected'; }
		$endbit .= '>No (Standard)</option>';
		
		$endbit .= '<option value="yes"';
		if($FT == "yes"){ $endbit .= 'selected'; }
		$endbit .= '>Yes (Highlighted)</option>'; 
				
		$endbit .= '</select>'; 
 
	echo $endbit;
?>
</div>

<?php
if(get_post_meta($post->ID, 'featured', true) == "yes"){
	if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){  
	
	$endbit = '<div class="misc-pub-section"><img src="'.PPT_FW_IMG_URI.'startext.png" style="float:left; margin-right:5px;margin-top:5px;" /> Ribon Text: ';
	$endbit .= '<input type="text" name="field[ribbon]" value="'.get_post_meta($post->ID, 'ribbon', true).'"  style="width:150px;font-size:11px;"/>';
	$endbit .= '</div>';
	
	} else{
	if(strtolower(PREMIUMPRESS_SYSTEM) != "couponpress"){  
	$endbit = '<div class="misc-pub-section"><img src="'.PPT_FW_IMG_URI.'startext.png" style="float:left; margin-right:5px;margin-top:5px;" /> Featured Text: ';
	$endbit .= '<input type="text" name="field[featured_text]" value="'.get_post_meta($post->ID, 'featured_text', true).'"  style="width:150px;font-size:11px;"/>';
	$endbit .= '</div>';
	}
	}// end if SP
	echo $endbit;
}// end if featured = yes

?>



<?php

if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){

		

echo '<div class="misc-pub-section"><img src="'.PPT_FW_IMG_URI.'/admin/s1.png" style="float:left; margin-right:5px;margin-top:5px;" /> User Attachments'; 
echo '<a href="javascript:void(0);" onmouseover="this.style.cursor=\'pointer\';" 
onclick="PPMsgBox(&quot;This option will allow the user to attach a file to the item. This is typically used for custom websites such as t-shirt webistes where you may want the user to attach a file that will be used to create the t-shirt. &quot;);"><img src="'.PPT_FW_IMG_URI.'help.png" style="float:right;" /></a> ';

$uea = get_post_meta($post->ID, 'allowupload', true);
if($uea == "yes"){ $u1 = 'selected'; $u2=""; }else{$u1 = ''; $u2="selected"; } 
		
echo '<select name="field[allowupload]"  style="font-size:11px;">
		<option '.$u1.'>yes</option>
		<option '.$u2.'>no</option></select>';	
echo '</div>';
	 	
}
		
if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){ ?>

    <div class="misc-pub-section">
    <label><img src="<?php echo PPT_FW_IMG_URI; ?>admin/smembers.png" style="float:left; margin-right:5px;margin-top:5px;" /> Owners Email:</label> 
    <?php
        
        $loemail = get_post_meta($post->ID, 'email', true);
        if($loemail == ""){
        $loemail = get_the_author_meta( 'email', $post->post_author);
        }
         
        echo '<input type="text" name="field[email]" value="'.$loemail.'" /> ';
        
    ?>
    </div>

    <div class="misc-pub-section misc-pub-section-last">
    <label for="pts_post_type"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/email.png" style="float:left; margin-right:5px;" /> Send Email:</label>
    <select name="ppt_send_email" id="ppt_send_email" style="width:150px; font-size:11px;">
    <option value="0">---------</option>
    <?php echo $PPM->collections(0,$type="!=0"); ?></select>
    </select>		 
    </div>

<?php } ?>	








<?php }elseif($post->post_type == "page"){ // end if post type == post  	

		$page_width 		= get_post_meta($post->ID, 'width', true);
		if($page_width == ""){ $a1 = 'selected'; $a2=""; }else{$a1 = ''; $a2="selected"; } 
 
 echo '<style>#visibility { display:none; } </style>';
 
		echo '<div class="misc-pub-section misc-pub-section-last"><img src="'.PPT_FW_IMG_URI.'/admin/s1.png" style="float:left; margin-right:5px;margin-top:5px;" /> Page Width: </span>';
		echo '<select name="field[width]" style="font-size:11px;">
		<option value="" '.$a1.'>inherit from theme</option>
		<option value="full" '.$a2.'>full page</option></select></div>';
		
		
		switch($post->page_template){
		
			case "tpl-people.php": { 
			
			$role 		= get_post_meta($post->ID, 'role', true);
		echo '<div class="misc-pub-section misc-pub-section-last"><img src="'.PPT_FW_IMG_URI.'/admin/user_green.png" style="float:left; margin-right:5px;margin-top:5px;" /> User Role: </span>';
		echo '<select name="field[role]">';
		if($role != ""){ echo '<option value="'.$role.'" selected="selected" >'.$role.'</option>'; }
		
	echo '<option value="subscriber">Subscriber</option>
	<option value="administrator">Administrator</option>
	<option value="editor">Editor</option>
	<option value="author">Author</option>
	<option value="contributor">Contributor</option></select></div>';			
			
			} break;		
		
		}
		

  } // END IF
  
}


/* ============================ PREMIUM PRESS CUSTOM FIELD FUNCTION ======================== */

function premiumpress_postdata($post_id, $post) {

global $wpdb, $post;
		
	if ( isset($_POST['sp_noncename']) && !wp_verify_nonce( $_POST['sp_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
	}   
 
 
	// Is the user allowed to edit the post or page?
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post->ID ))
		return $post->ID;
	} else {
		if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	}
	
	

	$mydata = array();
 
	// CUSTOM FIELDS
	if(is_array($_POST['field']) && !empty($_POST['field']) ){
		foreach($_POST['field'] as $key=>$val){ 
			if(!is_array($val) && substr($val,-1) == ","){			
				$mydata[$key] = substr($val,0,-1);	
			}else{
				$mydata[$key] = $val;	
			}						
		}	
	}	
 
	// PACKAGE ACCESS
	if(isset($_POST['package_access'])){
 
	 update_post_meta($post->ID, "package_access", $_POST['package_access']);
	} 
	
	// CUSTOM FIELDS
	if(isset($_POST['custom']) && is_array($_POST['custom']) && !empty($_POST['custom']) ){
		foreach($_POST['custom'] as $in_array){	
			
			if($in_array['name'] == "check"){
			 
				if(is_array($in_array['value'])){
					$std = "";
					foreach($in_array['value'] as $valf){ $std.= $valf."|"; }				 	
				} 
				
				$mydata[$in_array['name1']] = $std;
			 
			}else{
			$mydata[$in_array['name']] = $_POST[$in_array['name']];	
			}	
			 	
		}	
	} 
	
	foreach ($mydata as $key => $value) {
		if( $post->post_type == 'revision' ) return;
		$value = implode(',', (array)$value); 
		if(get_post_meta($post->ID, $key, FALSE)) { 
			update_post_meta($post->ID, $key, $value);
		} else { 
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key);
	}
	
	// IMAGES	
	if(is_array($_POST['galimg'])){
	$sString = "";
	foreach($_POST['galimg'] as $img){ if(strlen($img) > 0){
	$sString .= $img.",";
	} }
	update_post_meta($post->ID, 'images', $sString);
	}
	
	
	if(isset($_POST['field']['qty'])){	
	  
		if(isset($_POST['custom_field1_required'])){ $pack1_v=1; }else{ $pack1_v=0; }
		 
		update_option("custom_field1_required", $pack1_v);
 
		if(isset($_POST['custom_field2_required'])){ $pack1_b=1; }else{ $pack1_b=0; }
		update_option("custom_field2_required", $pack1_b);
		 
		
		if(isset($_POST['custom_field3_required'])){ $pack1_b=1; }else{ $pack1_b=0; }
		update_option("custom_field3_required", $pack1_b);
		
		if(isset($_POST['custom_field4_required'])){ $pack1_b=1; }else{ $pack1_b=0; }
		update_option("custom_field4_required", $pack1_b);
		
		if(isset($_POST['custom_field5_required'])){ $pack1_b=1; }else{ $pack1_b=0; }
		update_option("custom_field5_required", $pack1_b);	
			
		if(isset($_POST['custom_field6_required'])){ $pack1_b=1; }else{ $pack1_b=0; }
		update_option("custom_field6_required", $pack1_b);			
		
	}
	
	
	// UPDATE POST DATA
	$update_options = $_POST['adminArray']; 
	if(is_array($update_options )){
	foreach($update_options as $key => $value){
		update_option( trim($key), trim($value) );
	} }

 	
	// CUSTOM SELECTION BOXES
	if(isset($_POST['adminArray'])){ 
	
		$f=1;
		while($f < 7){
		
			//customfielddata	
			$sString = "";
			if(isset($_POST['marks_cust_field'.$f]) && is_array($_POST['marks_cust_field'.$f]) ){ // 
				
				$o=0; 
				foreach($_POST['marks_cust_field'.$f] as $val){ 
					
					$sString .= trim($val).",";						 
					$o++;
				} // end foreach
					
			} // end if				
			
			update_post_meta($post->ID, 'customlist'.$f, $sString);
			$f++;
			 
		}  // end while
	
	}
	
	
	
	if(isset($_POST['pts_post_type']) && strlen($_POST['pts_post_type']) > 1){	
	 
		if(isset($post->post_type) && $post->post_type != $_POST['pts_post_type']){ 
			mysql_query("UPDATE ".$wpdb->prefix."posts SET post_type='".$_POST['pts_post_type']."' WHERE ID='".$post->ID."' LIMIT 1");
		}
	   
	}	
	
	// SEND EMAIL ADDED IN 7.1.1
	if(isset($_POST['ppt_send_email']) && $_POST['ppt_send_email'] != "0"){
	 
	  $_POST['title'] = $post->post_title;
	  $_POST['link'] = get_permalink($post->ID);
	  
	  if(isset($_POST['field']['email']) && strlen($_POST['field']['email']) > 1){
	  $std = $_POST['field']['email'];
	  }else{
	  $std = $post->post_author;
	  }
	  
	  SendMemberEmail($std, $_POST['ppt_send_email']);
	
	}

}

?>