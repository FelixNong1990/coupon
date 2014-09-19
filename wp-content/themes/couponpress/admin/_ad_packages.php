<?php global $PPT, $wpdb; PremiumPress_Header(); ?>


<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100">
	<div class="premiumpress_boxin">
		<div class="header">        
		<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_submission.png" align="middle"> Submission</h3> 
     							 
<ul>
	<li><a rel="premiumpress_tab1" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="1" && !isset($_GET['delc'])){ echo 'class="active"';}elseif(!isset($_POST['showThisTab'])){ echo 'class="active"'; } ?>>Setup Options</a></li>
	<li><a rel="premiumpress_tab2" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="2"){ echo 'class="active"';} ?>>Packages</a></li> 
     
    <li><a rel="premiumpress_tab5" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="5"){ echo 'class="active"';} ?>>Custom Fields</a></li>
  <li><a rel="premiumpress_tab6" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="6" || isset($_GET['delc']) ){ echo 'class="active"';} ?>>Coupons</a></li> 
 
</ul>
</div>

<style>
select { border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; }
</style>




<form method="post" target="_self">
<input name="submitted" type="hidden" value="yes" />
<input name="submit" type="hidden" value="1" />
<input name="package100"  type="hidden" value="yes" />
<input name="custom" type="hidden" value="1" />
<input type="hidden" value="" name="showThisTab" id="showThisTab" />

<div id="premiumpress_tab1" class="content">


<div class="grid400-left">

 

<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Currency Display Options</h3></div>


<div class="ppt-form-line">     
<span class="ppt-labeltext">Currency Symbol <br /> <small>e.g &euro; &pound; or $</small>

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>Here you enter the currency symbol for your website. Eg. $ &#8364;, &pound; etc. This is for display purposes only. Payment currency codes are setup separately within the payments tab.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>
<input type="text" name="adminArray[currency_code]" class="ppt-forminput" style="width: 200px; font-size:14px;;" value="<?php echo get_option("currency_code"); ?>">
<div class="clearfix"></div>
</div>  

 
<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress" ){ ?> 	
<div class="ppt-form-line">     
<span class="ppt-labeltext">Currency Code <br /> <small>e.g EUR, GBP or USD</small>

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>This is used as the payment current for users paying for auction items (not listing or memberships) via PayPal. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>
<input type="text" name="adminArray[currency_symbol]" class="ppt-forminput" style="width: 200px; font-size:14px;;" value="<?php echo get_option("currency_symbol"); ?>">
<div class="clearfix"></div>
</div>  
<?php } ?>


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
            
 

            
  <div class="ppt-form-line">	<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" /></div>
 
</fieldset> 

    
    
    
<fieldset>
<div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Default Submission Fields</h3></div>

<p class="ppnote">The fields below are defined as 'default' fields because they are used to fill basic WordPress post values (titles,excepts etc). If you do not wish to display them on the submission form you can turn them off here and the value will be left blank however <b>we recommend</b> you use all fields for best results.</p>
<p><b>Tick to <u>HIDE</u>.</b></p>

<?php  $dfs = get_option('default_form_fields'); ?>
 <p><input name="adminArray[default_form_fields][all]" type="checkbox" value="1" <?php if($dfs['all'] == "1"){ echo 'checked=checked'; } ?> /> Display ALL</p>
 <p><input name="adminArray[default_form_fields][default]" type="checkbox" value="1" <?php if($dfs['default'] == "1"){ echo 'checked=checked'; } ?> /> <u>ALL</u> Default Theme Fields</p>

<p><input name="adminArray[default_form_fields][title]" type="checkbox" value="1" <?php if($dfs['title'] == "1"){ echo 'checked=checked'; } ?> /> Post Title</p>
<p><input name="adminArray[default_form_fields][category]" type="checkbox" value="1" <?php if($dfs['category'] == "1"){ echo 'checked=checked'; } ?> /> Category (if disabled post will go to uncategorized</p>
<p><input name="adminArray[default_form_fields][tagline]" type="checkbox" value="1" <?php if($dfs['tagline'] == "1"){ echo 'checked=checked'; } ?> /> Tagline</p>
<p><input name="adminArray[default_form_fields][excerpt]" type="checkbox" value="1" <?php if($dfs['excerpt'] == "1"){ echo 'checked=checked'; } ?> /> Short Description (excerp)</p>
<p><input name="adminArray[default_form_fields][content]" type="checkbox" value="1" <?php if($dfs['content'] == "1"){ echo 'checked=checked'; } ?> /> Full Description (post content)</p>
<p><input name="adminArray[default_form_fields][tags]" type="checkbox" value="1" <?php if($dfs['tags'] == "1"){ echo 'checked=checked'; } ?> /> Tags/Keywords</p>
<p><input name="adminArray[default_form_fields][email]" type="checkbox" value="1" <?php if($dfs['email'] == "1"){ echo 'checked=checked'; } ?> /> Email (will disable auto-registration and post assigned to admin)</p>
<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "auctionpress"){ ?>
<p><input name="adminArray[default_form_fields][url]" type="checkbox" value="1" <?php if($dfs['url'] == "1"){ echo 'checked=checked'; } ?> /> Website Address</p><?php } ?>
 <p><input name="adminArray[default_form_fields][map]" type="checkbox" value="1" <?php if($dfs['map'] == "1"){ echo 'checked=checked'; } ?> /> Google Map</p>
            
  <div class="ppt-form-line">	<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" /></div>
 
</fieldset>


<?php premiumpress_admin_submission_left_column(); ?>     
    
</div><div class="grid400-left last">

 
<fieldset><div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a3.gif" style="float:left; margin-right:8px;" />New Listing Settings</h3></div> 


<div class="ppt-form-line">	
<span class="ppt-labeltext">Visitors Must Login</span>	

 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will force visitors to login before they can submit a new listing. If you set this to 'No' and the visitors doesnt have an account, the system will automatically create one for them after they submit a listing.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 

<select name="adminArray[tpl_add_mustlogin]" class="ppt-forminput">
           <option value="yes" <?php if(get_option("tpl_add_mustlogin") =="yes"){ print "selected";} ?> >Yes</option>
           <option value="no" <?php if(get_option("tpl_add_mustlogin") =="no"){ print "selected";} ?>>No</option>
           </select>
<div class="clearfix"></div>
</div>



<div class="ppt-form-line">	
<span class="ppt-labeltext">Default Listing Status</span>

 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
 onclick="PPMsgBox(&quot;<b>Whats This?</b><br />Here you choose the default status of newly submission listings. If a listing is a paid one and the user successfully pays then the listing will automatically be set to approved right away, this is to save you having to manually approve new listings and prevent the user from having to wait.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
	
<select name="adminArray[display_listing_status]" class="ppt-forminput">
<option value="pending" <?php if(get_option("display_listing_status") =="pending"){ print "selected";} ?>>Pending Payment (Go Live After Payment)</option>
				<option value="publish" <?php if(get_option("display_listing_status") =="publish"){ print "selected";} ?> >Approved (Go Live Right Away)</option>
                
				<!--<option value="draft" <?php if(get_option("display_listing_status") =="draft"){ print "selected";} ?>>Unapproved (Requires Admin Approval)</option>-->
			</select>
            <div class="clearfix"></div>
            <p><input type="checkbox" name="pak_auto_free" style="background:none; margin:0px; padding:0px; margin-left:140px; float:left; " value="1" <?php if(get_option("pak_auto_free") ==1){ echo "checked"; } ?>>Auto Approve Free Listings</p>
            
            <p><input type="checkbox" name="pak_auto_edit" style="background:none; margin:0px; padding:0px; margin-left:140px; float:left; " value="1" <?php if(get_option("pak_auto_edit") ==1){ echo "checked"; } ?>>Auto Approve Edited Listings</p>
            
            
</div>
 
      
      	
 <div class="ppt-form-line">	
<span class="ppt-labeltext">Price Per Category</span>

 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />Here you can assign an extra listing price for popular categories. This will be charged on top of the existing listing price.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
	
<select name='cat' onchange="CatPriceBox(this.value);" class="ppt-forminput">
<option value='-1'>Select One</option>
<?php $GLOBALS['tpl-add']= true; echo premiumpress_categorylist('',false,true,"category",0,true); ?>	 
</select>  
<div class="clearfix"></div>
<div id="PPT-catpricebox" style="margin-left:140px;"></div>
</div> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Category Selection</span>	

 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This allows you to choose how many category selection list boxes are displayed on the submission form, the more you add the more categories a listing can be assigned to.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 


<select name="adminArray[tpl_add_catcount]" class="ppt-forminput">
        <?php $i=10; while($i > 0){ ?>
           <option value="<?php echo $i; ?>" <?php if(get_option("tpl_add_catcount") == $i){ print "selected";} ?> >Up to <?php echo $i; ?> Categories</option>
           <?php $i--; } ?>
      </select>   
<div class="clearfix"></div>
</div>    

<div class="ppt-form-line">	
<span class="ppt-labeltext">Allow Image Uploads</span>	
<select name="adminArray[display_fileupload]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_fileupload") =="yes"){ print "selected";} ?> >Yes - Visitors Can Upload Images</option>
				<option value="no" <?php if(get_option("display_fileupload") =="no"){ print "selected";} ?>>No / Disable</option>
			</select>
<div class="clearfix"></div>
<div style="margin-left:140px;">How Many? <input type="text" name="adminArray[display_fileupload_max]" value="<?php if(get_option("display_fileupload_max") == ""){ echo 8; }else{ echo get_option("display_fileupload_max"); } ?>" style="width: 60px;  font-size:12px; height:25px; margin-top:4px;" class="ppt-forminput"></div>


</div>

   		 
<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress" ){ ?> 	
<div class="ppt-form-line">	
<span class="ppt-labeltext">Reciprocal Link</span>	

 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />If enabled members/visitors will be required to put a link on their website before they can submit a listing on yours. This is very 'old school' and is not recommended.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
<select name="adminArray[display_rlink]" class="ppt-forminput">
<option value="yes" <?php if(get_option("display_rlink") =="yes"){ print "selected";} ?> >Enabled</option>
<option value="no" <?php if(get_option("display_rlink") =="no"){ print "selected";} ?>>Disabled / Not Required (recommended)</option>
</select>
<div class="clearfix"></div>
</div> 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Reciprocal link Code</span>	
<textarea name="adminArray[display_rlink_text]" cols="" rows="" class="ppt-forminput"><?php echo stripslashes(get_option("display_rlink_text")); ?></textarea>
<div class="clearfix"></div>
</div> 
<?php } ?>

 
         
         
<div class="ppt-form-line">	
<span class="ppt-labeltext">Country Options</span>
	 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will allow users to select their country/state/city on the submission form.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
<select name="adminArray[display_country]" class="ppt-forminput">
<option value="yes" <?php if(get_option("display_country") =="yes"){ print "selected";} ?> >Yes</option>
<option value="no" <?php if(get_option("display_country") =="no"){ print "selected";} ?>>No</option>
</select>
<div class="clearfix"></div>
</div>    


<?php

	if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){  

	//1. GET PACKAGE DATA	
	$nnewpakarray 	= array();
	$packagedata 	= get_option('ppt_membership');
	if(is_array($packagedata) && isset($packagedata['package']) ){ foreach($packagedata['package'] as $val){		
		$nnewpakarray[] =  $val['ID'];		
	} }
	
	//2. GET POST - PACKAGE DATA
	$postpackagedata 	= get_option("ppt_defaultpackageaccess");
	if(!is_array($postpackagedata)){ $postpackagedata = array(0); }
	
	?> 
    
<div class="ppt-form-line">	
<p>Default Membership Package Access
	 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This allows you to assign a default access level for all new and updated listing. This is useful if your setting up membership packages to limit access to listing content. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
 </p>
 
	<select name="package_access[]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="0" <?php if(in_array(0,$postpackagedata)){ echo "selected=selected"; } ?>>All Package Access</option>
    <?php 
	$i=0;
	if(is_array($packagedata['package'])){
	foreach($packagedata['package'] as $package){	
		
		if(is_array($postpackagedata) && in_array($package['ID'],$postpackagedata)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']." ( package ID: ".$package['ID'].")</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']." ( package ID: ".$package['ID'].")</option>";		
		}
		
	$i++;		
	} // end foreach
	}
    ?>
	</select>
    <br /><small>Hold CTRL to select multiple packages.</small> 
    
    <?php } ?>     
 
 <div class="clearfix"></div>
</div>  

 <div class="ppt-form-line">	<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" /></div>
 
    		      
</fieldset> 

 




        
</div>


<?php premiumpress_admin_submission_right_column(); ?>

<div class="clearfix"></div>

 
</div> 




</form>




















<form method="post" target="_self">
<input name="submitted" type="hidden" value="yes" />
<input name="submit" type="hidden" value="1" />
<input name="package200"  type="hidden" value="yes" />
<input name="custom" type="hidden" value="1" />
<input type="hidden" value="" name="showThisTab" id="showThisTab" />



<div id="DisplayImages" style="display:none;"></div><input type="hidden" id="searchBox1" name="searchBox1" value="" />


<div id="premiumpress_tab2" class="content">

 
      

<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script>

function ChangeImgBlock(divname){
document.getElementById("imgIdblock").value = divname;
}

jQuery(document).ready(function() {

jQuery('#upload_h1').click(function() {
 ChangeImgBlock('icon1');
 formfield = jQuery('#icon1').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});
 
jQuery('#upload_h2').click(function() {
 ChangeImgBlock('icon2');
 formfield = jQuery('#icon2').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
}); 

jQuery('#upload_h3').click(function() {
 ChangeImgBlock('icon3');
 formfield = jQuery('#icon3').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h4').click(function() {
 ChangeImgBlock('icon4');
 formfield = jQuery('#icon4').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h5').click(function() {
 ChangeImgBlock('icon5');
 formfield = jQuery('#icon5').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h6').click(function() {
 ChangeImgBlock('icon6');
 formfield = jQuery('#icon6').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h7').click(function() {
 ChangeImgBlock('icon7');
 formfield = jQuery('#icon7').attr('name');
 tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
 return false;
});

jQuery('#upload_h8').click(function() {
 ChangeImgBlock('icon8');
 formfield = jQuery('#icon8').attr('name');
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


<div class="grid400-left">

<?php if(get_option("pak_enabled") ==1){   $packdata = get_option("packages"); ?>


<?php $i=1;  $loopLimit=9;  while($i < $loopLimit){ ?>


<fieldset>
<div class="titleh"> <h3><?php if(isset($packdata[$i]['name']) && strlen($packdata[$i]['name']) > 2){ echo strip_tags($packdata[$i]['name']); }else{ echo "Unnamed Package ".$i; } ?> 


 - <?php echo premiumpress_price($packdata[$i]['price'],get_option("currency_code"),get_option("display_currency_position"),1); ?></h3></div> 
<div style="display:none;" id="package<?php echo $i; ?>">



<div class="ppt-form-line">	
<p><input type="checkbox" name="package[<?php echo $i; ?>][enable]" value="1" <?php if(isset($packdata[$i]['enable']) && $packdata[$i]['enable'] ==1){ echo "checked"; } ?> style="background:none; margin:0px; padding:0px;"> Tick to enable package</p>	 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Name</span>	 
<input type="text" name="package[<?php echo $i; ?>][name]" class="ppt-forminput" value="<?php echo $packdata[$i]['name']; ?>">
<div class="clearfix"></div>
</div>
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Package Icon</span>
	 	 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />Package icons are displayed on the listing page..&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 <input type="text" name="package[<?php echo $i; ?>][icon]" id="icon<?php echo $i; ?>" class="ppt-forminput" value="<?php echo $packdata[$i]['icon']; ?>">
<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','icon<?php echo $i; ?>');" type="button"   value="View Images" style="margin-left:140px;"  />
<input id="upload_h<?php echo $i; ?>" type="button" size="36" name="upload_h<?php echo $i; ?>" value="Upload Image"  />
<div class="clearfix"></div>
</div>
 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Price</span>	

	 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />Check the box if you wish this to be a recurring subscription. The package will renew automatically after the days you specify in the field below expire. <b>Works with Paypal only.</b></p><p><b>Offer a free trial period</b><br /><br /> This will only work if you enable the recurring subscription button above. The value should left blank if you are not using this.</p>.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
 
<?php echo get_option("currency_code"); ?> <input name="package[<?php echo $i; ?>][price]" type="text" size="5" value="<?php echo $packdata[$i]['price']; ?>">
<?php if(get_option('gateway_paypal') == "yes"){ ?>
<img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/paypals.png" />
<input type="checkbox" name="package[<?php echo $i; ?>][rec]" value="1" <?php if(isset($packdata[$i]['price']) && $packdata[$i]['rec'] ==1){ echo "checked"; } ?>> 
<div class="clearfix"></div>
  <b style="margin-left:140px;"> How many trial days?</b> <input name="package[<?php echo $i; ?>][freetrialp]" type="text" style="width:30px;" size="5" value="<?php echo $packdata[$i]['freetrialp']; ?>"> <br /><small style="margin-left:140px;">Leave blank if not used</small>
            
 <?php } ?>
<div class="clearfix"></div>
</div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Days Before Expires</span>	
	 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />Here you enter a value for the number of days the listing will display on your website before it expires</p><br><br>Please make sure you have setup your expiry settings under 'General Setup' -> 'Default Settings' tab.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
 
 
	# <input type="text" name="package[<?php echo $i; ?>][expire]" style="width:50px;" class="ppt-forminput"  value="<?php echo $packdata[$i]['expire']; ?>"> days (example: 5 days) 
<div class="clearfix"></div>
</div>


<br />

 
<fieldset style="background:#E8FCCD">
<legend>Package Features</legend>
 
 
<div class="ppt-form-line">	
<input style="float:left;" type="checkbox" name="package[<?php echo $i; ?>][a1]" value="1" <?php if(isset($packdata[$i]['a1']) && $packdata[$i]['a1'] ==1){ echo "checked"; } ?>> <strong style="margin-top:-5px;"> &nbsp;&nbsp;HTML Description Box </strong>
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will allow the user to design their listing in HTML. Without this HTML will be stripped from content.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
<div class="clearfix"></div>
</div> 
 
<div class="ppt-form-line">	
<input style="float:left;" type="checkbox" name="package[<?php echo $i; ?>][a2]" value="1" <?php if(isset($packdata[$i]['a2']) && $packdata[$i]['a2'] ==1){ echo "checked"; } ?>> <strong>&nbsp;&nbsp;Multi-Categories</strong><br />
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will allow the user to submit their listing to up multiple categories..&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> 
<div class="clearfix"></div>
<p><b>How many category selection boxes?</b></p>
		<select name="package[<?php echo $i; ?>][totalcats]" class="ppt-forminput">
        <?php $ia=10; while($ia > 0){ ?>
           <option value="<?php echo $ia; ?>" <?php if($packdata[$i]['totalcats'] == $ia){ print "selected";} ?> ><?php echo $ia; ?></option>
           <?php $ia--; } ?>
      </select>  
<div class="clearfix"></div>
</div> 
 


      
 
<div class="ppt-form-line">	      
<input style="float:left;" type="checkbox" name="package[<?php echo $i; ?>][a3]" value="1" <?php if(isset($packdata[$i]['a3']) && $packdata[$i]['a3'] ==1){ echo "checked"; } ?>> <strong>&nbsp;&nbsp;File Uploads</strong>
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will display an upload form on step 2 of the submission page allowing users to add images to their listings.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
<div class="clearfix"></div>
Maximum of #<input name="package[<?php echo $i; ?>][uploadlimit]" type="text" class="ppt-forminput" value="<?php if(isset($packdata[$i]['uploadlimit'])){ echo $packdata[$i]['uploadlimit']; } ?>" style="width:50px;" /> files.
<div class="clearfix"></div>

</div> 

<div class="ppt-form-line">	
 <input style="float:left;" type="checkbox" name="package[<?php echo $i; ?>][a4]" value="1" <?php if(isset($packdata[$i]['a4']) && $packdata[$i]['a4'] ==1){ echo "checked"; } ?>> <strong>&nbsp;&nbsp;Google Maps</strong> 
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will display an input box for the user to enter their address which is plotted onto a google map.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
<div class="clearfix"></div>
</div>  

<div class="ppt-form-line">	 
<input style="float:left;" type="checkbox" name="package[<?php echo $i; ?>][a5]" value="1" <?php if(isset($packdata[$i]['a5']) && $packdata[$i]['a5'] ==1){ echo "checked"; } ?>> <strong>&nbsp;&nbsp;Featured/ Highlighted Listing</strong><br />
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will highlight the users listing in the website searches.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
<div class="clearfix"></div>
</div> 
<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress"){ ?> 
<div class="ppt-form-line">	
<input style="float:left;" type="checkbox" name="package[<?php echo $i; ?>][a6]" value="1" <?php if(isset($packdata[$i]['a6']) && $packdata[$i]['a6'] ==1){ echo "checked"; } ?>> <strong>&nbsp;&nbsp;Remove Reciprocal Link</strong><br />
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will remove the reciprocal link requirement for this package.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
<div class="clearfix"></div>
</div> 
<?php } ?>

<div class="ppt-form-line">	 
<input type="checkbox" name="package[<?php echo $i; ?>][pricecats]" value="1" <?php if(isset($packdata[$i]['pricecats']) && $packdata[$i]['pricecats'] ==1){ echo "checked"; } ?>> <strong>&nbsp;&nbsp;Hide Price Per Category</strong><br />
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />This will show any additional prices you have set for each category and add the value to the current package price..&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
<div class="clearfix"></div>
</div>

</fieldset>
 

<fieldset style="background:#E8FCCD">
<legend>Package Features List (Display Captions)</legend>

<p>By default the system will create a list of package features based on your selections above however if you wish to create your own display captions simply check the box (opposite) and enter them here.</p>


<?php $zz=1; while($zz < 11){ ?>
<div class="ppt-form-line">	

<span class="ppt-labeltext">Caption <?php echo $zz; ?></span>	 
<input type="text" name="package[<?php echo $i; ?>][c<?php echo $zz; ?>]" class="ppt-forminput" value="<?php echo $packdata[$i]['c'.$zz]; ?>">
<div class="clearfix"></div>

<div style="margin-left:140px;padding-top:10px;">
On <input name="package[<?php echo $i; ?>][c<?php echo $zz; ?>o]" type="radio" value="1" <?php if(isset($packdata[$i]['c'.$zz.'o']) && $packdata[$i]['c'.$zz.'o'] ==1){ echo "checked=checked"; } ?> /> / 
Off <input name="package[<?php echo $i; ?>][c<?php echo $zz; ?>o]" type="radio" value="0" <?php if(isset($packdata[$i]['c'.$zz.'o']) && $packdata[$i]['c'.$zz.'o'] == 0){ echo "checked=checked"; } ?> />
</div>

<div class="clearfix"></div>
</div>
<?php $zz++; } ?>
 



</fieldset>

<div class="ppt-form-line"><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" onclick="document.getElementById('showThisTab').value=2"  /></div>
</div>
<a href="javascript:void(0);" onclick="toggleLayer('package<?php echo $i; ?>');" class="ppt_layout_showme">Show/Hide Options</a>
</fieldset>


<?php $i++; } } ?>


</div><div class="grid400-left last">

      
      
        
<fieldset>

<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Package Setup</h3></div>
        

      <p><b> <input type="checkbox" name="pak_enabled" value="1" <?php if(get_option("pak_enabled") ==1){ echo "checked"; } ?>>&nbsp;&nbsp; Enable Packages</b></p>

      <p class="ppnote">Turn on/off website submission packages.</p>
      
     
      <?php if(get_option("pak_enabled") ==1){ ?>
      
      
       <p><b> <input type="checkbox" name="pak_force_membership" value="1" <?php if(get_option("pak_force_membership") ==1){ echo "checked"; } ?>>&nbsp;&nbsp; Force Membership</b></p>

      <p class="ppnote">Stop users without any membership package from submitting listings.</p>
      
           
      
      
     <p><b> <input type="checkbox" name="pak_show_customcaptions" value="1" <?php if(get_option("pak_show_customcaptions") ==1){ echo "checked"; } ?>>&nbsp;&nbsp;Display my own custom package feature list captions</b></p>

      <p class="ppnote">Turn on/off the display of your custom package captions.</p>
  
     
      
       <p><b> <input type="checkbox" name="pak_show_fields" value="1" <?php if(get_option("pak_show_fields") ==1){ echo "checked"; } ?>>&nbsp;&nbsp;Show Custom Fields on Packages Page</b></p>

      <p class="ppnote">Turn on/off the display of custom fields within the list of features on the packages page.</p>
       
      
      <p><b>Bottom Text </b></p>
  	  <p class="ppnote">This is the text that appears at the bottom of the package selection page. You can include HTML.</p>
          
<textarea name="adminArray[pak_text]" cols="" rows="" style="width: 360px; height:130px; font-size:14px;" class="ppt-forminput"><?php echo stripslashes(get_option("pak_text")); ?></textarea>
 
 <?php } ?>
 
 
 
 <p><input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" onclick="document.getElementById('showThisTab').value=2"  /></p>


</fieldset>
		 
<div class="videobox" id="videobox22" >
<a href="javascript:void(0);" onclick="PlayPPTVideo('gPXw1LkiCE8','videobox22');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/10.jpg" align="absmiddle" /></a>
</div>

</div>
<div class="clearfix"></div>

</div>
 

 

</form>











<form method="post" target="_self">
<input name="submitted" type="hidden" value="yes" />
<input name="submit" type="hidden" value="1" />

<input name="custom" type="hidden" value="1" />
<input type="hidden" value="5" name="showThisTab" id="showThisTab111" />




 <script language="javascript">
 
 function ChangeTickValue(div){
 
	 if(document.getElementById(div).value==0){
	 document.getElementById(div).value=1;
	 }else{
	 document.getElementById(div).value=0;
	 }
 
 }
 
 </script>
<div id="premiumpress_tab5" class="content">
 

<div class="grid400-left">

<fieldset>
<div class="titleh"> <h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Custom Fields

<a href="http://www.premiumpress.com/tutorial/custom-submission-fields/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div> 
<br />
<?php 
$pe = get_option("pak_enabled");
$cf1 = get_option("customfielddata"); 
$packdata = get_option("packages"); 
$i=0;
 

if(is_array($cf1) ){ 

$neworder = multisort( $cf1 , array('order') );

foreach($neworder as $cfield){    if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] == 1){ $cbg = "blue"; }else{ $cbg = "green"; }?>

<div id="pfcc<?php echo $i; ?>">

<div class="<?php echo $cbg; ?>_box"><div class="<?php echo $cbg; ?>_box_content"> 
 
  
	 
    <span class="ppt-labeltext">Display Caption
    <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What's The Display Caption?</strong><br />This is simply the text that is displayed next to the field to tell the user what is input.<br /><br />Example 'email' or 'phone number'. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
    </span>
    <input name="customfield[name][]" type="text"  class="ppt-forminput" id="pn<?php echo $i; ?>" value="<?php if(isset($cfield['name'])){ echo $cfield['name']; } ?>" />
    
    <div class="clearfix"></div>
    
    <div <?php if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] == 1){ echo "style='display:none;'"; } ?>>
 
    <span class="ppt-labeltext">Database Key ID
    <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What does this mean?</strong><br />A Database Key ID is used to reference your new custom field within the Wordpress database.<br><br>Each ID <b>must be a unique</b> value with no spaces such as <b>Key_1</b> and <b>Key_2</b>.<br><br><br /><strong>More Information?</strong><br />For more information on custom fields in Wordpress see this link: <a href=http://codex.wordpress.org/Custom_Fields target=_blank>http://codex.wordpress.org/Custom_Fields</a>.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
    
    </span>
    
 	<input name="customfield[key][]" type="text" class="ppt-forminput" value="<?php if(isset($cfield['key']) && strlen($cfield['key']) > 1){ echo $cfield['key']; }else{ print "Key_".$i;} ?>" />

	</div>
 
	 
    <div style="margin-top:10px;"><input type="checkbox" name="checkme1<?php echo $i; ?>" value="1" <?php if(isset($cfield['show']) && $cfield['show'] ==1){ echo "checked"; } ?> onchange="ChangeTickValue('checkme1<?php echo $i; ?>');" style="margin-left:140px;"> 
    
    <input type="hidden" name="customfield[show][]" id="checkme1<?php echo $i; ?>" value="<?php if(isset($cfield['show']) && $cfield['show'] ==1){ echo 1; }else{ echo 0; } ?>" />
    
    
    Hide on listing page<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What's This Do?</strong><br />Sometimes you might want to ask for user information but not display is on their listing page such as email or phone number, tick this box and the field will be displayed on the submission pages but NOT on their listing page. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right; margin-right:5px;" /></a> </div> 

<div style="margin-top:10px;">
<input type="checkbox" name="checkme2<?php echo $i; ?>" value="1" <?php if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] == 1){ echo "checked"; } ?> style="margin-left:140px;" onchange="ChangeTickValue('checkme2<?php echo $i; ?>');"> This is a display title only.

<input type="hidden" name="customfield[fieldtitle][]" id="checkme2<?php echo $i; ?>" value="<?php if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] ==1){ echo 1; }else{ echo 0; } ?>" />
    
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What does this mean?</strong><br />A field title will create a title/headline above the field box on the submission form allowing you to split up your field content easier.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</div>



<div class="clearfix"></div>
     
<div class="ppt-form-line" style="padding:0px;">	<div class="clearfix"></div></div>
<div class="clearfix"></div><br />

   
<a href="javascript:void(0);" onclick="toggleLayer('options<?php echo $i; ?>');"  class="button tagadd  right">Show/Hide Options</a>

<a href="javascript:void(0);" onclick="document.getElementById('pn<?php echo $i; ?>').value=''; jQuery('#pfcc<?php echo $i; ?>').hide();" class="button tagadd left"   style="margin-left:100px;">Delete Field</a> 
 
    
    
    
    
    
<div id="options<?php echo $i; ?>" <?php if($pe ==1 && (!isset($cfield['pack1']) &&  !isset($cfield['pack2']) &&  !isset($cfield['pack3'])  &&  !isset($cfield['pack4'])  &&  !isset($cfield['pack5'])  &&  !isset($cfield['pack6'])  && !isset($cfield['pack7'])  &&  !isset($cfield['pack8'])  )){ echo 'style="margin-top:10px;border:2px solid red;padding:2px"';  }else{ ?>style="display:none; margin-top:10px;"<?php } ?>>    


    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Display Order
    <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
        onclick="PPMsgBox(&quot;<strong>What's This Do?</strong><br />This is similar to the package description above however its displayed under the field on the submission page 
        allowing you to customize the help/info text displayed to the user. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right; margin-right:5px;" /></a> 
    </span>
    <input name="customfield[order][]" type="text" class="ppt-forminput" style="width:50px;" value="<?php if(isset($cfield['order'])){ echo $cfield['order']; } ?>" />
    <div class="clearfix"></div>
    </div>
    
    
    
    
     <div class="ppt-form-line">	
<span class="ppt-labeltext">Required  
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What is this?</strong><br>This will force the user to complete the field before they can continue.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>
   <select name="customfield[required][]" class="ppt-forminput">
        <option value="yes" <?php if(isset($cfield['required']) && $cfield['required'] =="yes"){ echo "selected"; } ?>>Required</option>
        <option value="no" <?php if(isset($cfield['required']) && $cfield['required'] =="no"){ echo "selected"; } ?>>Optional</option>
        
    </select>  
<div class="clearfix"></div>
</div> 
    
    
 <div class="ppt-form-line" <?php if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] == 1){ echo "style='display:none;'"; } ?>>	
<span class="ppt-labeltext">Field Type
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>How do i add list box values?</strong><br />List box values are entered into the 'Default values' box below and should be entered like this:<br><br>Value1,Value2,Value3<br><br>Notice each new listbox option is seperated with a comma.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>
   <select name="customfield[type][]" class="ppt-forminput">
        <option value="text" <?php if(isset($cfield['type']) && $cfield['type'] =="text"){ echo "selected"; } ?>>Text Box (best for short answers)</option>
        <option value="textarea" <?php if(isset($cfield['type']) && $cfield['type'] =="textarea"){ echo "selected"; } ?>>Text Area (best for longer answers)</option>
        <option value="list" <?php if(isset($cfield['type']) && $cfield['type'] =="list"){ echo "selected"; } ?>>List Box (drop down menu of options)</option>
        
        <option value="check" <?php if(isset($cfield['type']) && $cfield['type'] =="check"){ echo "selected"; } ?>>Check Box (accepts multiple answers)</option>
        
    </select>  
<div class="clearfix"></div>
</div> 

<div class="ppt-form-line" <?php if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] == 1){ echo "style='display:none;'"; } ?>>	
<span class="ppt-labeltext">Default values
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What does this mean?</strong><br />Sometimes you might want to add content to a text field for display when the page loads to help prompt the user for the correct input. <br><br> For example, if your asking the user to enter their website link and want them to include the http:// at the beginning you can enter the http:// as the default value so that they realise you require this also.<br><br><br /><strong>How do i add list/check box values?</strong><br />List and check box values should be entered like this:<br><br>Value1,Value2,Value3<br><br>Notice each new listbox option is seperated with a comma.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>
<input name="customfield[value][]" type="text"  class="ppt-forminput" value="<?php if(isset($cfield['value'])){ echo htmlentities($cfield['value'],ENT_QUOTES, "UTF-8"); } ?>" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line" <?php if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] == 1){ echo "style='display:none;'"; } ?>>	
<span class="ppt-labeltext">Package Page Description
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What's This Do?</strong><br />Here you enter a small description about what this field is for, when a user hovers over the text on the packages page it will show up in a small bubble.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right; margin-right:5px;" /></a> 
</span>
<input name="customfield[desc1][]" type="text" class="ppt-forminput" value="<?php if(isset($cfield['desc1'])){ echo $cfield['desc1']; } ?>" />
<div class="clearfix"></div>
</div>


<div class="ppt-form-line" <?php if(isset($cfield['fieldtitle']) && $cfield['fieldtitle'] == 1){ echo "style='display:none;'"; } ?>>	
<span class="ppt-labeltext">Submit Page Description
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
    onclick="PPMsgBox(&quot;<strong>What's This Do?</strong><br />This is similar to the package description above however its displayed under the field on the submission page allowing you to customize the help/info text displayed to the user. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right; margin-right:5px;" /></a> 
</span>
<input name="customfield[desc2][]" type="text" class="ppt-forminput" value="<?php if(isset($cfield['desc2'])){ echo $cfield['desc2']; } ?>" />
<div class="clearfix"></div>
</div>   



    <div class="ppt-form-line">	
    <p>Show field on which packages?</p>
    
    <?php if($pe ==1 && (!isset($cfield['pack1']) &&  !isset($cfield['pack2']) &&  !isset($cfield['pack3'])  &&  !isset($cfield['pack4'])  &&  !isset($cfield['pack5'])  &&  !isset($cfield['pack6'])  && !isset($cfield['pack7'])  &&  !isset($cfield['pack8'])  )){   ?>
    <div class="msg msg-error"> <p>You must select at least one package otherwise the field will not be displayed at all.</p></div>
    <?php } ?>
     
    <?php for($o=1; $o < 9; $o++){ 
	
	if(isset($packdata[$o]['enable']) && $packdata[$o]['enable'] ==1){ ?>
    
    <input type="checkbox" name="pak1<?php echo $i; ?>" onchange="ChangeTickValue('pak<?php echo $o.$i; ?>');" value="1" <?php if(isset($cfield['pack'.$o]) && $cfield['pack'.$o] ==1){ echo "checked"; } ?>> 
    <b><?php echo strip_tags($packdata[$o]['name']); ?></b> <br />
	
	 <input type="hidden" name="customfield[pack<?php echo $o; ?>][]" id="pak<?php echo $o.$i; ?>" value="<?php if($cfield['pack'.$o] ==1){ echo 1; }else{ echo 0; } ?>" />
  
	<?php } } ?>
    
 
      
    <div class="clearfix"></div>
	</div>    
    
    
    


</div>



 
</div>

<div class="clearfix"></div>
</div></div> 

 
<?php $i++; } } ?>






<div id="PACKAGEDISPLAYHERE"></div>


<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;"  /> 	

<a href="javascript:void(0);" onclick="jQuery('#packagebox').clone().appendTo('#PACKAGEDISPLAYHERE');" class="button tagadd" style="float:right;">Add New Field</a>
 



</fieldset>


 

</div><div class="grid400-left last">

<div class="videobox" id="videobox221" >
<a href="javascript:void(0);" onclick="PlayPPTVideo('OT7OT423mRA','videobox221');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/11.jpg"  /></a>
</div>

</div>

<div class="clearfix"></div>
  
 
</div>
 
 

					 
</form>



<div id="premiumpress_tab6" class="content">

<div class="msg msg-info"><p>Coupon codes can be used by visitors during the listing submission page only (not membership upgrades). Coupon code usage will only be recorded if the final checkout price (after the coupon is applied) is greater than 0 otherwise the listing is free and no order is saved. </p></div>

<fieldset>
<div class="titleh"> <h3>

<img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Coupons Options

<a href="http://www.premiumpress.com/tutorial/coupon-codes/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3>  </div>
<div id="aa2">
<form method="post" name="ShopperPress" target="_self">
<input name="couponcode" type="hidden" value="1" />
<input name="submitted" type="hidden" value="yes" />
<input type="hidden" value="6" name="showThisTab" id="showThisTab" />



<div class="ppt-form-line">	
<span class="ppt-labeltext">Enable Coupon Codes</span>	
 <select name="adminArray[coupon_enable]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("coupon_enable") =="yes"){ print "selected"; }?>>Enable</option>
				<option value="no" <?php if(get_option("coupon_enable") =="no"){ print "selected"; }?>>Disable</option>
			</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Enter Coupon Code</span>	
 <input name="coupon[name]" type="text" class="ppt-forminput" style="width: 150px;" /> 
<div class="clearfix"></div>
			
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Discount</span>	
 <?php echo get_option("currency_code"); ?> <input name="coupon[price]" type="text" class="ppt-forminput" style="width: 50px;" /> or %<input name="coupon[percentage]" type="text" class="ppt-forminput" style="width: 50px;" />
<div class="clearfix"></div> 
</div>

<p><input class="premiumpress_button" type="submit" value="Add Coupon" style="color:#fff;" /></p>
<table style="margin-bottom: 20px;"></table>
<h3 class="title">Current Coupon Codes</h3>
	<table width="100%"  border="0" style="border:1px solid #ddd;">
    <tr >
    <th style="background:#ceffb4 !important; border-top:1px solid #666; border-bottom:1px solid #83c162;font-weight:bold;">COUPON CODE</th>
    <th style="background:#ceffb4 !important; border-top:1px solid #666; border-bottom:1px solid #83c162;font-weight:bold;">DISCOUNT</th>
    <th style="background:#ceffb4 !important; border-top:1px solid #666; border-bottom:1px solid #83c162;font-weight:bold;">USAGE</th>
    <th style="background:#ceffb4 !important; border-top:1px solid #666; border-bottom:1px solid #83c162;font-weight:bold;">ACTIONS</th>
    </tr>
	<?php
	$i=0;
	$ArrayCoupon = get_option("coupon_array");
	if(is_array($ArrayCoupon)){ foreach($ArrayCoupon as $value){ if(strlen($value['name']) > 1){ 
	
	$SQL = "SELECT count(*) AS total FROM ".$wpdb->prefix."orderdata  WHERE order_couponcode='".$value['name']."'";
	$f = (array)$wpdb->get_results($SQL);
 	
	?>
	  <tr style="background:<?php if($i % 2){ ?>white;<?php }else{ ?>#E3FCE4<?php } ?>">
		<td style="padding:5px;"> <p> <?php echo $value['name']; ?> </p></td>
        <td><?php if($value['price'] !=""){ echo get_option("currency_code").$value['price']; }else{ echo $value['percentage']."% OFF"; } ?></td>
        <td>Used <?php echo $f[0]->total; ?> times</td>
        <td align="center"> <a href="admin.php?page=submit&delc=<?php echo $i; ?>">Delete Coupon</a>  </td> </tr>
	
	<?php  $i++; }} }  ?>
	</table>
 

</form>
</div>
 
 
</fieldset>


<div class="clearfix"></div></div>










<div class="clearfix clear"></div>
</div>






















<!------------------------------------ PACKAGE BLOCK ------------------------------>


<div style="display:none;">
<div id="packagebox">
<div class="green_box"><div class="green_box_content">

 
<span class="ppt-labeltext">Field Caption</span>
 <input name="customfield[name][]" type="text" class="ppt-forminput" />



<div class="clearfix"></div></div></div>
</div></div>

