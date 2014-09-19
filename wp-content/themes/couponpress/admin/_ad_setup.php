<?php
	//die(print_r(get_option("ppt_s")).print_r($searchbits));	
if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; } 


	// CHOSEN
	wp_register_style( 'chosen', PPT_PATH.'js/jquery.chosen.css');
	wp_enqueue_style( 'chosen' );

 	wp_register_script( 'chosen', PPT_PATH.'js/jquery.chosen.min.js');
	wp_enqueue_script( 'chosen' ); 	

global $PPT,$PPTImport;

// GET DEFAULT VALUES
$IMAGEVALUES = get_option('pptimage');


 
// SERACH PLUGIN
require_once (TEMPLATEPATH ."/PPT/class/class_search.php");	
$searchData = new PPT_S;
include(str_replace("functions","",THEME_PATH)."/PPT/class/class_search_data.php");	
ppt_event_activation(); // REGISTER CRON SCHEDULES



/* =============================================================================
  CHECK IF WE SHOULD SHOW RESET BUTTONS
   ========================================================================== */
if(isset($_POST['JUSSTARTED'])){
	update_option("JUSSTARTED","checked8");
} 	
if(get_option("JUSSTARTED") != "checked8" && !isset($_POST['JUSSTARTED']) ){
$count_posts 	= wp_count_posts();
if($count_posts->publish > 10){
update_option("JUSSTARTED","checked8"); 
}else{ 

?>


<div style="padding:20px; background:#d6ffcf; border:1px solid #438b38; margin-top:20px;">

<h1>Website Reset Recommended</h1>
<p>We have detected that you are installing <?php echo constant('PREMIUMPRESS_SYSTEM'); ?> for the first time, we strongly recommend a theme reset to help you get started quickly.</p>
<small>Note, the reset will delete any pages/posts you have already setup in Wordpress and install sample data to help you get started.</small>
<br /><br />

<form method="post" target="_self">
<input name="reset" type="hidden" value="yes" />
<input name="JUSSTARTED" type="hidden" value="1" />
<select name="RESETME" style="font-size:20px;">
<option value="yes">Yes Please (recommended BUT will delete your current posts + categories)</option>
<option value="no">No Thank You</option>
</select> 

<input class="premiumpress_button" type="submit" value="Continue" style="color:white;" />

</form>
 
</div>


<?php }  }else{  PremiumPress_Header(); 


?>


 
 
 


<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script type="text/javascript">

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


window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src'); 
 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
 tb_remove();
} 

});

</script>

 
<script type="text/javascript">

 jQuery(document).ready(function() {
 
   jQuery("#themepreview").change(function() {
     jQuery("#imagePreview").empty();
	 
	 jQuery("#ttfggf").html("<input type='hidden' name='adminArray[theme-style]' value='' />");
     if ( jQuery("#themepreview").val()!="" ){
        jQuery("#imagePreview").append("<img src=\"<?php echo $GLOBALS['template_url']; ?>/themes/" + jQuery("#themepreview").val()  + "/screenshot.png\" style='border:1px solid #666; padding:4px;' /><br /><input class='button-primary' type='submit' value='Save Changes'>");
		alert("Note. new template styles maybe available AFTER you save changes.");
     }
     else{
        jQuery("#imagePreview").append("displays image here");
     }
   });
   
   
   jQuery("#themepreview1").change(function() {
     jQuery("#imagePreview").empty();
     if ( jQuery("#themepreview1").val() !="" ){
	 
	 	var text = jQuery("#themepreview1").val();
		var new_text = text.replace(".css", "");
        jQuery("#imagePreview").append("<img src=\"<?php echo $GLOBALS['template_url']; ?>/themes/" + jQuery("#themepreview").val()  + "/images/" + new_text  + "/screenshot.png\" style='border:1px solid #666;padding:4px;' />");
     }
     else{
        jQuery("#imagePreview").append("<img src=\"<?php echo $GLOBALS['template_url']; ?>/themes/" + jQuery("#themepreview").val()  + "/screenshot.png\" style='border:1px solid #666; padding:4px;' />");
     }
   });
   
   
 });
 
 
</script>


 
 
 


<div class="msg msg-info"><p>Would you like to reset your website back to factory settings? <strong> Recommended for new installs.</strong> <a href="javascript:void(0);" onclick="toggleLayer('reset');">Click here to learn more.</a></p></div>

<form method="post" target="_self"style="background:white; display:none" id="reset">
<fieldset style="margin-bottom:30px; width:820px;">

<input name="reset" type="hidden" value="yes" />
<p><b>Reset Website + Install Defaults</b></p>
<select name="RESETME"><option value="no">No</option> <option value="yes">Yes (Warning: You will lose all current data)</option></select><br />
<small>If you select reset your database will be cleared and you will start from the theme defaults.</small>
<p><input class="premiumpress_button" type="submit" value="Restore Defaults" style="color:white;" /></p>

</fieldset>
</form>
































<div id="DisplayImages" style="display:none;"></div><input type="hidden" id="searchBox1" name="searchBox1" value="" />


<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_setup.png" align="middle"> General Setup</h3>  						 
<ul>
	<li><a rel="premiumpress_tab1" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="1"){ echo 'class="active"';}elseif(!isset($_POST['showThisTab'])){ echo 'class="active"'; } ?>>System</a></li>
    
    
    <li><a rel="premiumpress_tab4" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="4"){ echo 'class="active"';} ?>>Category</a></li>
	<li><a rel="premiumpress_tab2" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="2"){ echo 'class="active"';} ?>>Page</a></li>
    <li><a rel="premiumpress_tab3" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="3"){ echo 'class="active"';} ?>>Image</a></li>
     <li><a rel="premiumpress_tab5" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="5"){ echo 'class="active"';} ?>>Search</a></li>
	<li><a rel="premiumpress_tab6" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="6"){ echo 'class="active"';} ?>>Default Settings</a></li> 
  
    
    <li><a rel="premiumpress_tab7" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="7"){ echo 'class="active"';} ?>>Language</a></li> 
</ul>
</div> 



<style>
select { border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; }
</style>

<form method="post" target="_self" enctype="multipart/form-data">
<input name="submitted" type="hidden" value="yes" />
<input name="admin_page" type="hidden" value="general_setup" />

<input type="hidden" value="" name="showThisTab" id="showThisTab" />
 
 <input type="hidden" value="posts" name="adminArray[show_on_front]" />

 
 
 
<!-- include all get_options for themes so the system can always store them -->


<?php if(get_option('system') == ""){ ?><input type="hidden" value="" name="adminArray[system]" /><?php } ?>
<?php if(get_option('analytics_tracking') == ""){ ?><input type="hidden" value="" name="adminArray[analytics_tracking]" /><?php } ?>
<?php if(get_option('google_webmaster_code') == ""){ ?><input type="hidden" value="" name="adminArray[google_webmaster_code]" /><?php } ?>
<?php if(get_option('analytics_code') == ""){ ?><input type="hidden" value="" name="adminArray[analytics_code]" /><?php } ?>
<?php if(get_option('google_adsensetracking_code') == ""){ ?><input type="hidden" value="" name="adminArray[google_adsensetracking_code]" /><?php } ?>
<?php if($IMAGEVALUES['stw_3'] == ""){ ?><input type="hidden" value="" name="adminArray[stw_3]" /><?php } ?>






 

 
<div id="premiumpress_tab1" class="content">
 

 

<div id="PPTPAGEVIDEOBOX"></div>


<?php /* ============================ 1 ================================= */ ?>

<div class="grid400-left">


<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Basic Website Setup</h3>  </div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Website Title </span>	 
<input name="adminArray[blogname]"  type="text" class="ppt-forminput" value="<?php echo get_option('blogname'); ?>" style="width: 200px;">



<a href="http://www.premiumpress.com/tutorial/website-title/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a> 
  
<div class="clearfix"></div>
</div>






 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Language

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;The list will display all of the files that begin with 'language_' in the folder; <br /><small> '<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>/template_<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>/'.</small><br /><br /><strong>The list is empty or will not save</strong><br />This is likely because you have renamed the theme folder to something other than '<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>' or that your file paths are not setup correctly on your hosting account.<br /><br /><strong>How to add my own language?</strong><br />Simply copy and rename the file 'language_english.php in the  folder; <br /><small> '<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>/template_<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>/'</small><br /> to something like 'language_french.php' and translate the text in that file.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;"  /></a>


 


</span>	 
 <select name="adminArray[language]" class="ppt-forminput" id="wsf1">
		<?php
		
		$HandlePath = str_replace("functions/","",THEME_PATH) ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/";	   
	    $count=1;
		if($handle1 = opendir($HandlePath)) {
      
	  	while(false !== ($file = readdir($handle1))){	

		if(substr($file,-4) ==".php" && substr($file,0,8) == "language"){
		$file = str_replace(".php","",$file); 
		$name = explode("_",$file);
		?>
			<option <?php if (get_option("language") == $file) { echo ' selected="selected"'; } ?> value="<?php echo $file; ?>"><?php echo $name[1]." ".$name[0]; ?></option>
		<?php
		} }}
		?>	 
		</select> 
         
                <a href="http://www.premiumpress.com/tutorial/language-files/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
        

 
        
        <div class="clearfix"></div>
        
        

</div> 


<div class="ppt-form-line">	
<span class="ppt-labeltext">Template

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;The list will display all of the child themes found in the folder; <br /><small> 'wp-content/themes/<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>/themes/'.</small><br /><br /><strong>The list is empty or will not save</strong><br />This is likely because you have renamed the theme folder to something other than '<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>' or that your file paths are not setup correctly on your hosting account.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>	
	<select name="adminArray[theme]" class="ppt-forminput" id="themepreview" title="Here you select the design for your website.">
		<?php

		$HandlePath = PPT_THEMES_DIR;
	    $count=1;
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			
				if(strpos($file,".") ===false && ( strpos($file,strtolower(constant('PREMIUMPRESS_SYSTEM'))) !== false || strpos($file,"premiumpress") !== false ) ){	
				
				
							
					$TemplateString .= "<option "; 
					if (get_option("theme") == $file) { $TemplateString .= ' selected="selected"'; }   
					$TemplateString .= 'value="'.$file.'">'; 
					if($file ==strtolower(constant('PREMIUMPRESS_SYSTEM'))."-default"){ $TemplateString .= "Default (".constant('PREMIUMPRESS_SYSTEM')." Theme)";  }else{ $TemplateString .= str_replace("-"," ",str_replace(strtolower(constant('PREMIUMPRESS_SYSTEM')),"",$file)); } 					
					$TemplateString .= "</option>";			
   
				}
			}
		}
		echo $TemplateString;
		
		 

		?>
		</select> 
        
     <a href="http://www.premiumpress.com/wordpress-child-themes/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
            
        
<div class="clearfix"></div>
</div>


















<?php

$CHILDTHEMEHANDLE = PPT_THEME_DIR.'/themes/'.get_option('theme')."/css/";
$count=1; $STYLETHEME = "";
if($handle2 = opendir($CHILDTHEMEHANDLE)) { 
     
	while(false !== ($file = readdir($handle2))){			
 
		if(strpos($file,".") !== false && substr($file,0,1) == "_" ){
							
					$STYLETHEME .= "<option "; 
					if (get_option("theme-style") == $file) { $STYLETHEME .= ' selected="selected"'; }   
					$STYLETHEME .= 'value="'.$file.'">'; 
					$STYLETHEME .= str_replace("_"," ",str_replace(strtolower(constant('PREMIUMPRESS_SYSTEM')),"",str_replace(".css"," ",str_replace("-"," ",$file))));					
					$STYLETHEME .= "</option>";
					
						 		
   
				}
			}
		}

if(strlen($STYLETHEME) > 1){
?>
<div id="ttfggf" style="background:#DBFFDE;font-weight:bold;">
<div class="ppt-form-line">	
<span class="ppt-labeltext"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/sdisplay.png" align="absmiddle" style="margin-left:10px;" />&nbsp;&nbsp;Template Styles

</span>	
	<select name="adminArray[theme-style]" id="themepreview1" >
    	<option value=""></option>
		<?php echo $STYLETHEME; ?>
		</select> 
<div class="clearfix"></div>
</div>
</div>
<?php }else{ ?>
<input type="hidden" name="adminArray[theme-style]" value="" />
<?php } ?>









 
<div class="ppt-form-line">	
<center><div id="imagePreview"><?php if(get_option('theme') !=""){ 
$subt = get_option('theme-style');
if($subt != "" && $subt !="styles.css"){ $eff = "images/".str_replace(".css","",$subt)."/"; }else{ $eff = ""; } ?>
 <img src="<?php echo $GLOBALS['template_url']; ?>/themes/<?php echo get_option('theme'); ?>/<?php echo $eff; ?>screenshot.png" style='border:1px solid #666; padding:4px;' /><?php } ?></div></center>
<div class="clearfix"></div>
</div>
 
 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Upload Template 

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>How to add my own child theme?</strong><br />Simply copy and rename any of the child themes in the  folders; <br /><small> 'wp-content/themes/<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>/themes/'</small><br /> it will then display in this list to be selected.<br><br><b>Note:</b>Child theme folder names must started with <?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>, eg. <?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>-my-template-name&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

 </span>	
<input name="childtheme" type="file" style="font-size:14px; width:200px;" title="Here you can upload new child themes for <?php echo PREMIUMPRESS_SYSTEM; ?>" />  
<div class="clearfix"></div>
</div> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Mobile Friendly View

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>The mobile friendly option will turn on a seperate website interface for mobile users, is a 'cut down' version of your main website with all main functionality such as registration and submission are disabled..&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>	 
 <select name="adminArray[ppt_mobile]" class="ppt-forminput" class="box1">
			<option value="" <?php if(get_option("ppt_mobile") ==""){ print "selected";} ?> >Disabled</option>
			<option value="1" <?php if(get_option("ppt_mobile") =="1"){ print "selected";} ?>>Enabled</option>
			</select>
 <script type="text/javascript">$('#comboId4').wscombo({img:1,combo:1,reset:1,selectedIndex:-1});</script>           
            
  <a href="http://www.premiumpress.com/tutorial/mobile-friendly/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
               
            
<div class="clearfix"></div>
</div>
  <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" />
 
 
 </div>

</fieldset>




 
<?php premiumpress_admin_setup_left_column(); ?>





</div> 
<div class="grid400-left last">



 
 
<fieldset>

<div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" />User Registration</h3></div>

<p class="ppnote" style="width:95%;"> <img src="<?php echo PPT_FW_IMG_URI; ?>tip.png" style="float:left; padding-right:5px;" /> 
<b>Custom Registration Fields</b> 
<br /> You can create your own registration fields under the 'members' -> 'custom profile fields' tab or by <a href="admin.php?page=members">clicking here.</a> 
</p>

 
 <?php if(!defined('WP_ALLOW_MULTISITE')){ ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Registration

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>This option simply turns on/off the website registration options. Disabling this will stop all visitors from creating an account.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</span>	
<select name="adminArray[users_can_register]" class="ppt-forminput">
			<option value="" <?php if(get_option("users_can_register") ==""){ print "selected";} ?>>Disabled</option>
			<option value="1" <?php if(get_option("users_can_register") =="1"){ print "selected";} ?>>Enabled (Visitors can create accounts)</option>
			</select>
            
   <a href="http://www.premiumpress.com/tutorial/registration/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
           
            
<div class="clearfix"></div>
</div>

<?php } ?>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Password

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>This option will allow the user to create their own password during registration.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</span>	
<select name="adminArray[users_can_register_setup]" class="ppt-forminput">
			<option value="" <?php if(get_option("users_can_register_setup") ==""){ print "selected";} ?>>Let user create a password.</option>
			<option value="1" <?php if(get_option("users_can_register_setup") =="1"){ print "selected";} ?>>Email random password. (verifies email)</option>
			</select>
<div class="clearfix"></div>
</div>



<div class="ppt-form-line">	
<span class="ppt-labeltext">Default User Status

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>This option will prevent NEW users from logging into their account until the admin has manually approved them.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</span>	
<?php  $status = get_option('pptuser_default');  ?>
 <select name="adminArray[pptuser_default]"  class="ppt-forminput">
        <option <?php if($status == "active"){ print "selected=selected"; } ?> value="active">Active (Account Live)</option>
        <option <?php if($status == "pending"){ print "selected=selected"; } ?> value="pending">Pending Review</option>    
        </select>
<div class="clearfix"></div>
</div>

 <div class="ppt-form-line">	
<span class="ppt-labeltext">Default User Role

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>This option will determin the default WordPress user role for all NEW registered users.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</span>
<?php  $role = get_option('default_role');   ?>	
<select name="adminArray[default_role]" id="default_role">
	<option <?php if($role == "subscriber"){ ?>selected="selected"<?php } ?> value="subscriber">Subscriber</option>
	<option value="administrator" <?php if($role == "administrator"){ ?>selected="selected"<?php } ?>>Administrator</option>
	<option value="editor" <?php if($role == "editor"){ ?>selected="selected"<?php } ?>>Editor</option>
	<option value="author" <?php if($role == "author"){ ?>selected="selected"<?php } ?>>Author</option>
	<option value="contributor" <?php if($role == "contributor"){ ?>selected="selected"<?php } ?>>Contributor</option></select>
    
      <a href="http://codex.wordpress.org/Roles_and_Capabilities?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
 
    
<div class="clearfix"></div>
</div>
 
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" />
 
 
 </div>
 
</fieldset>
 

 
 
<fieldset>
<div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a3.gif" style="float:left; margin-right:8px;" /> Website Maintenance</h3></div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Maintenance Mode

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>Maintenance mode allows you to work on your website as the admin without visitors from seeing your content, instead they are displayed the message you set in the message box below.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>	 
<select name="adminArray[maintenance_mode]" class="ppt-forminput" title="Here you on/off maintenance mode which prevents visitors from accessing your website whilst you perform update work.">
			<option value="no" <?php if(get_option("maintenance_mode") =="no"){ print "selected";} ?>>Disabled</option>
			<option value="yes" <?php if(get_option("maintenance_mode") =="yes"){ print "selected";} ?>>Enable Maintenance Mode</option>
			</select>
<div class="clearfix"></div>
</div>
 
  
            
			 
 <?php if(get_option("maintenance_mode") =="yes"){ ?>
<div class="ppt-form-line">	
<p>Enter your maintenance message here (accepts html).</p>
 <textarea name="adminArray[maintenance_mode_message]" type="text" class="ppt-forminput" style="width:100%;height:100px; font-size:14px;" title="Here you enter a message that will be displayed to your website visitors. Accepts HTML."><?php echo stripslashes(get_option("maintenance_mode_message")); ?></textarea>
<div class="clearfix"></div>
</div>
 <?php } ?>  
 
  <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" />
 
 
 </div> 

</fieldset>


<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "agencypress"){   ?>
<fieldset>
<div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a4.gif" style="float:left; margin-right:8px;" /> Chatroom Setup</h3></div>
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Chatroom Title 

</span>	 
<input name="adminArray[ppt_chatroom_title]" type="text" class="ppt-forminput"   value="<?php echo get_option('ppt_chatroom_title'); ?>" />

<div class="clearfix"></div>
</div>

<div class="savebarb clear">
<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" />
</div> 

</fieldset>
<?php } ?>


<?php premiumpress_admin_setup_right_column(); ?>


</div> 




 <div class="clearfix"></div>
 



 
</div>















 

<div id="premiumpress_tab2" class="content">


  
<div class="grid400-left">
<?php
$p=1;

switch(strtolower(constant('PREMIUMPRESS_SYSTEM'))){

	case "dealspress":
	case "auctionpress": {
	$MakePagesArray = array("checkout_url","submit_url","messages_url","dashboard_url","contact_url","manage_url", "tc_url");
	} break;
 
	
	case "couponpress":
	case "classifiedstheme":
 
	case "comparisonpress":
	case "directorypress": {
	$MakePagesArray = array("submit_url","messages_url","dashboard_url","contact_url","manage_url","tc_url");
	} break; 
	
	case "moviepress": {
	$MakePagesArray = array("submit_url", "dashboard_url","contact_url","manage_url","tc_url");
	} break; 
	
	case "shopperpress": {
	$MakePagesArray = array("checkout_url", "dashboard_url","contact_url", "tc_url");
	} break;
	
 
			
	default: { $MakePagesArray = array("submit_url","messages_url","dashboard_url","contact_url","manage_url","tc_url"); }

}

$pageTitles = array(
"tc_url" => "Terms and Conditions",
"checkout_url" => "Checkout",
"submit_url" => "Add/Submission",
"messages_url" => "Private Message",
"dashboard_url" => "My Account",
"contact_url" => "Contact",
"manage_url" => "Edit/Manage Listing",
"payment_url" => "Payment",
 
);


?>
 
     <fieldset> 
    
    <div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Page / Button Links  <a href="edit.php?post_type=page&TB_iframe=true&width=640&height=838" class="thickbox button-primary" style="float:right; margin-right:10px; margin-top:-2px;">Manage Pages</a>
 </h3></div>
    
    <?php foreach($MakePagesArray as $pageBit){ ?>
    
<div class="ppt-form-line">	
<span class="ppt-labeltext"><?php echo $pageTitles[$pageBit]; ?> 

  <?php if($pageBit !="tc_url"){ ?>
  
  <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />Here you enter the website link for the page that the user will see when they click on the '<?php echo str_replace("_url","",$pageBit); ?> buttons. <br /><br /><b>How do i setup the <?php echo str_replace("_url","",$pageBit); ?> page?</b><br />The  <?php echo str_replace("_url","",$pageBit); ?> page is a normal page in Wordpress but when creating the page select the '<?php echo str_replace("_url","",$pageBit); ?> template' from the 'page attributes' list on the right side of the page.<br /><br /><b>The page in the listbox doesnt save / show the page i have entered?</b><br />Dont worry it's not supposed to, it's only there to help you see what pages you have already created in Wordpress. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>   

<?php }else{ ?>

  <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>Whats this page?</b><br />You setup the terms and conditions page just like any normal WordPress page. You add your own terms and conditions for your website then enter the link into the box here. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>  
<?php } ?>


</span>	 

  <input name="adminArray[<?php echo $pageBit; ?>]" id="<?php echo $pageBit; ?>" type="text" class="ppt-forminput" value="<?php echo get_option($pageBit); ?>"   style="width: 200px;<?php if(get_option($pageBit) == ""){ echo 'border:1px solid red;'; } ?>" />

 <a href="http://www.premiumpress.com/tutorial/pages/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
     
<div class="clearfix"></div>
</div>
    
  
        
		
     <?php } ?>  
     
     
     
   
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=2" />
 
 
 </div>
    </fieldset>
       
     

<div class="videobox" id="videobox1" style="margin-bottom:10px;">
<a href="javascript:void(0);" onclick="PlayPPTVideo('nQ6mmIuGw4c','videobox1');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/5.jpg" align="absmiddle" /></a>
</div>

 
</div>
 
<div class="grid400-left last">

    <div id="videoboxc1"></div>
   
   


     <fieldset> 
    
    <div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Page Display  <a href="edit.php?post_type=page&TB_iframe=true&width=640&height=838" class="thickbox button-primary" style="float:right; margin-right:10px; margin-top:-2px;">Manage Pages</a>
 </h3></div>
    
 
     
     <div class="clearfix"></div>
     
     
   
   		<div class="ppt-form-line">
        
          <p> Hidden Pages (<em>select pages to hide</em>) 
          
          
          
          <a href="http://www.premiumpress.com/tutorial/pages/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-left:10px; margin-right:5px;" /></a>
 
          
          
         <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>Sometimes you want to add pages to your website but not display them on your meny bars etc. This tool will help you hide pages from display. <br><br>Note. This only works with theme functions, third part widgets and function will not hide selected pages..&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a> </p>

         
          
        
       <div class="clearfix"></div>
 
       <select name="nav_page[]" multiple="multiple" style="width:350px;height:200px;"  tabindex="3" >
       <?php
		$SAVED_DISPLAY = get_option("excluded_pages");
		if($SAVED_DISPLAY != ""){ $pageArray = explode(",",$SAVED_DISPLAY); }else{ $pageArray = array(); }
		$Pages = get_pages("parent=0"); //
		$Page_Count = count($Pages);	
 		$i=0;	 
		foreach ($Pages as $Page) {	
		if( in_array($Page->ID,$pageArray) ){ $etx = 'selected="selected"'; }else{  $etx =''; }
		echo '<option value="'.$Page->ID.'" '.$etx.'>'.$Page->post_title.'</option>';	
 
		}
		?> 
       
       </select><br />
       <small>Hold SHIFT to select multiple pages.</small>
       
		<div class="clearfix"></div>
		</div>
        
        
        <div class="ppt-form-line">
       
       <p> Submenu Links (<em>select pages to <b>show</b></em>)
     


 </p>

<div class="clearfix"></div>      
     
       <select name="submenu_nav_page[]" multiple="multiple" style="width:350px; height:200px;" data-placeholder="Choose a Page..." >
       <option></option>
       <?php
		$SAVED_DISPLAY = get_option("submenu_excluded_pages");
		if($SAVED_DISPLAY != ""){ $pageArray = explode(",",$SAVED_DISPLAY); }else{ $pageArray = array(); }
		 
 		$i=0;	 
		foreach ($Pages as $Page) {	
		if( in_array($Page->ID,$pageArray) ){ $etx = 'selected="selected"'; }else{  $etx =''; }
		echo '<option value="'.$Page->ID.'" '.$etx.'>'.$Page->post_title.'</option>';	
 
		}
		?> 
       
       </select><br />
       <small>Hold SHIFT to select multiple pages.</small>
        
   		<div class="clearfix"></div>
</div>        
        
        
        
        
        
        
        
        
        
        

       <div class="ppt-form-line">
       
       <p> Footer Links (<em>select pages to <b>show</b></em>)
       
       
       <a href="http://www.premiumpress.com/tutorial/pages/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-left:10px; margin-right:5px;" /></a>
 
           <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br>Here you select the pages you want to be displayed in your footer, this is commonly used for terms and conditions, privay pages.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>



 </p>

<div class="clearfix"></div>      
     <?php $SAVED_DISPLAY = get_option("footer_excluded_pages");   ?>
       <select name="footer_nav_page[]" multiple="multiple" style="width:350px; height:200px;" >
       <option></option>
       <?php
		
		if($SAVED_DISPLAY != ""){ $pageArray = explode(",",$SAVED_DISPLAY); }else{ $pageArray = array(); }
	 	
 		$i=0;	 
		foreach ($Pages as $Page) {	
		if( in_array($Page->ID,$pageArray) ){ $etx = 'selected="selected"'; }else{  $etx =''; }
		echo '<option value="'.$Page->ID.'" '.$etx.'>'.$Page->post_title.'</option>';	
 
		}
		?> 
       
       </select><br />
       <small>Selected pages will be displayed in your footer</small>
        
   		<div class="clearfix"></div>
</div>    
     
     
     
 
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=2" />
 
 
 </div>
    </fieldset>
    
    


   
   
 
        
</div>

 <div class="clearfix"></div>
 
  

</div>















<div id="premiumpress_tab3" class="content">

 
 

<div class="clearfix"></div> 
 
<div class="grid400-left">

 
 <div class="videobox" id="videobox55" style="float:right; border:1px #CCCCCC solid; padding:10px; margin-bottom:40px;">
<a href="javascript:void(0);" onclick="PlayPPTVideo('uOEKAKr5O4U','videobox55');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/7.jpg" align="absmiddle" /></a>
</div>  

<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Image Storage Paths</h3></div>

		
     
     <?php 
	 
	 $ss1 = stripslashes(get_option("imagestorage_path"));
	 $ss2 = stripslashes(get_option("imagestorage_link"));
	 $ss3 = stripslashes(get_option("upload_path"));
	 $ss4 = stripslashes(get_option("upload_url_path"));
	 
	 
	 if(strlen($ss1) < 2){ $ss1 = PPT_THUMBS; } 	 
	 if(strlen($ss2) < 2){ $ss2 = $GLOBALS['template_url']."/thumbs/"; }
	 
	 if(strlen($ss3) < 2){ $ss3 = "wp-content/themes/".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/thumbs"; }
	 if(strlen($ss4) < 2){ $ss4 = $GLOBALS['template_url']."/thumbs"; }
	 ?>
	 



<div class="ppt-form-line">	
<span class="ppt-labeltext">File Storage Path
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />This is the hosting server path to your images folder where you will store your member and website images. <br /><br /><b>What should i enter here?</b><br /> It is recommended to enter the link below into the box: <br /> <small><?php print PPT_THUMBS; ?></small><br /><br /> <b>My images dont save or upload</b>The common issue here is that the path you entered is incorrect and/or the folder is NOT CHMOD 777, please contact your hosting provider for the correct path and confirm that the path you have entered is CHMOD 777. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>


<input name="adminArray[imagestorage_path]" type="text" class="ppt-forminput" value="<?php echo $ss1;  ?>" />

<a href="http://www.premiumpress.com/tutorial/images/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
 
 
<div class="clearfix"></div>

<?php if (strpos($ss1, strtolower(constant('PREMIUMPRESS_SYSTEM'))) === false) { ?>
<div class="clearfix"></div><div class="msg msg-error">  <p>Your current path is wrong!</p></div>

<p class="ppnote1"><b>Recommended Path:</b><br /> <span style="font-size:10px;"><?php print PPT_THUMBS; ?></span></p>

<?php } ?>	 

<?php if(strlen($ss1) > 5 && !is_writable($ss1)){  ?>

<div class="clearfix"></div><div class="msg msg-warn">  <p>Your current path is NOT writable therefore images might not be saved. <a href="javascript:void(0);" onclick="PlayPPTVideo('mbwjUWrNbTI','videobox55');">Learn how to CHMOD Here.</a></p></div>
<?php } ?> 

</div>
   
	       
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Theme Storage Link

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />This is the website link (http://..) to your images folder where you will store your product and website images. <br /><br /><b>What should i enter here?</b><br /> It is recommended to enter the link below into the box: <br /> <small><?php echo $GLOBALS['template_url']; ?>/thumbs/</small> &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>
<input name="adminArray[imagestorage_link]" type="text" class="ppt-forminput"   value="<?php echo $ss2; ?>" />

<a href="http://www.premiumpress.com/tutorial/images/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>


<div class="clearfix"></div>
<?php if (strpos($ss2, strtolower(constant('PREMIUMPRESS_SYSTEM'))) === false) { ?>
<div class="clearfix"></div><div class="msg msg-error">  <p>Your current path is wrong!</p></div>

<p class="ppnote1"><b>Recommended Path:</b><br /> <span style="font-size:10px;"><?php echo PPT_THUMBS_URI; ?></span></p>
<?php } ?>
</div> 



<?php if(defined('MULTISITE') && MULTISITE != false){ ?>

<div class="msg msg-info">  <p>You are running WP Network (multi website feature) therefore the network storage path cannot be adjusted. <br /><br /> It is recommended you upload all media to your theme 'thumbs' folder; <br /><br /> <?php print PPT_THUMBS; ?> </p></div>
<?php }else{ ?>

<div class="ppt-form-line">

<span class="ppt-labeltext">WP Storage Folder</span>

<input name="adminArray[upload_path]" type="text" class="ppt-forminput"   value="<?php echo $ss3; ?>" />

<a href="http://www.premiumpress.com/tutorial/images/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>


<div class="clearfix"></div>
<?php if (strpos($ss3, strtolower(constant('PREMIUMPRESS_SYSTEM'))) === false) { ?>
<div class="clearfix"></div><div class="msg msg-error">  <p>Your current path is wrong!</p></div>
<p class="ppnote1"><b>Recommended Path:</b><br /> <span style="font-size:10px;"><?php echo "wp-content/themes/".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/thumbs"; ?></span></p>
<?php } ?>
</div>

<div class="ppt-form-line">

<span class="ppt-labeltext">WP Storage Link</span>
<input name="adminArray[upload_url_path]" type="text" class="ppt-forminput"   value="<?php echo $ss4; ?>" />

<a href="http://www.premiumpress.com/tutorial/images/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>


<div class="clearfix"></div> 
<?php if (strpos($ss4, strtolower(constant('PREMIUMPRESS_SYSTEM'))) === false) { ?>
<div class="clearfix"></div><div class="msg msg-error">  <p>Your current path is wrong!</p></div>
<p class="ppnote1"><b>Recommended Path:</b><br /> <span style="font-size:10px;"><?php echo substr(PPT_THUMBS_URI,0,-1); ?></span></p>
<?php } ?>
</div>

<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){   ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Secure Download Path </span>

<input name="adminArray[download_server_path]" type="text" class="ppt-forminput"   value="<?php echo get_option('download_server_path'); ?>" />

<a href="http://www.premiumpress.com/tutorial/images/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>


<?php if(get_option('download_server_path') == ""){ ?>
<p class="ppnote"><b>Note, this is for download stores only.</b> Here you enter the directory path to where your file downloads are located.</p>
<p class="ppnote1"><b>Recommended Path:</b><br /> <span style="font-size:10px;"><?php print PPT_THUMBS; ?></span></p>
<?php } ?>

<p class="ppnote1"><b>Recommended Path:</b><br /> <span style="font-size:10px;"><?php print PPT_THUMBS; ?></span></p>
</div>
<?php } ?> 

<input type="hidden" name="adminArray[uploads_use_yearmonth_folders]" value="0" />

<?php } ?> 
  
  
   <div class="clearfix"></div>
 
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=3" />
 
  
 </div>
  
 </fieldset>
 
 	 

</div>


 

 <?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "directorypress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress"){ ?>


	<div class="grid400-left">
    <fieldset>
        <div class="titleh"><h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a3.gif" style="float:left; margin-right:8px;" /> Website Thumbnail API Comparison</h3></div>
        
        
        
        
        <div class="ppt-form-line">     
            <span class="ppt-labeltext">Thumbnail API
            <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" onclick="PPMsgBox(&quot;<b>How does this work?</b><br />The thumbnail API built into our themes will try to generate a image preview of any website you add to your posts/listing. <br/><br/> (custom field: url).<br><br><b>Fair Usage Limit</b><br>This service costs our company money therefore we have a limit of 250 requests per license a month. This is more than enough for most businesess.<br><br>If you require more screenshots, please use the ShrinkTheWeb API which has a 'free' and a 'paid' service that comes with more requests and optional PRO upgrades. Take a look at the 'Website Thumbnail API' comparison grid on this page.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
            
            </span>
            
            <!-- display_previewimage_type -->
            <select name="adminArray[pptimage][thumbnailapi]" style="width:200px;  font-size:14px;">
                <option value="off" <?php if($IMAGEVALUES['thumbnailapi'] == "off" || get_option("display_previewimage_type") ==""){ print "selected";} ?>> Disabled </option>
			    <option value="premiumpress" <?php if($IMAGEVALUES['thumbnailapi'] =="premiumpress"){ print "selected";} ?>> PremiumPress Free API</option>
                <option value="shrinktheweb" <?php if($IMAGEVALUES['thumbnailapi'] =="shrinktheweb"){ print "selected";} ?>>ShrinkTheWeb API (third party)</option>
			</select>    
            
            <a href="http://www.premiumpress.com/tutorial/thumbnail-api/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>

        
            <div class="clearfix"></div>
            <?php if($IMAGEVALUES['thumbnailapi'] != "off"){ ?>
            <?php if($IMAGEVALUES['thumbnailapi'] != "shrinktheweb"){?>
            <small style="margin-left:140px;"><?php $ml = get_option('save'.date('m-Y')); if($ml == ""){ update_option('save'.date('m-Y'),"0"); $ml=0; } ?>used <?php echo $ml; ?> of 250 image requests this month.</small>
            <?php }else{?>
			<small style="margin-left:140px;">Scroll down to configure settings...</small>
            <?php }?>
            <?php }?>
    	</div>  
        
        
        
		<?php if($IMAGEVALUES['thumbnailapi'] =="premiumpress"){?>
        <div class="ppt-form-line">     
            <span class="ppt-labeltext">Image Storage</span>
            <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" onclick="PPMsgBox(&quot;<b>How does this work?</b><br />cURL is a hosting account function which will try to store images locally to speed up your website. This is used to save the thumbnails to your website rather than loading them dynamically and using up your requests.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>   
	        <select name="adminArray[image_preview_storage]" class="ppt-forminput" <?php if(get_option("display_previewimage_type") =="off"){ print "disabled"; } ?>>
			    <option value="yes" <?php if(get_option("image_preview_storage") =="yes"){ print "selected";} ?> >On My Server (recommended, required cURL)</option>
			    <option value="no" <?php if(get_option("image_preview_storage") =="no"){ print "selected";} ?>>On Theirs</option>
			</select>	
            <div class="clearfix"></div>
    	</div>  
        <?php }   ?>        
        
        
        
    	<br/>
		<table id="stwwt_feature_comp">
			<thead>
				<tr>
					<th style="text-align: left;">PremiumPress Free API</th>
					<th colspan="2" style="text-align: center;">Free Account</th>
				</tr>
			</thead>
				<tr>
					<th style="text-align: left;">Automated Thumbnail Service</th>
					<td colspan="2" style="text-align: left;">Limit 250 requests per month</td>
				</tr>
			<thead>
				<tr>
					<th style="text-align: left;">ShrinkTheWeb API Service</th>
					<th style="text-align: center;">Free Account</th>
					<th style="text-align: center;">Paid Account</th>
				</tr>
			</thead>
				<tr>
					<th style="text-align: left;">Automated Thumbnail Service</th>
					<td style="text-align: center;">5Gb /month</td>
					<td style="text-align: center;">5Gb+ /month</td>
				</tr>
				 				
			 
		</table>
        
        
         <div class="clearfix"></div>
 
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=3" />
 
  
 </div>
        
    </fieldset>  
    
    
    
    
             
 	</div>

<?php } ?>
 
<div style="clear:right;"> 




 <fieldset>
<div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Image Options</h3></div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Image Placeholder  
   <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />This image is used when a listing does not have a default image.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>   
 </span>	 

  <input name="adminArray[pptimage][noimage]" id="logo" type="text" class="ppt-forminput" value="<?php if(!isset($IMAGEVALUES['noimage']) || $IMAGEVALUES['noimage'] ==""){ echo "na.gif"; $pdi = "na.gif"; }else{ echo $IMAGEVALUES['noimage']; $pdi = $IMAGEVALUES['noimage']; } ?>">
  
  <a href="http://www.premiumpress.com/tutorial/images/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>


<div class="clearfix"></div>
<input onclick="toggleLayer('DisplayImages'); add_image_next(0,'<?php echo get_option("imagestorage_path"); ?>','<?php echo get_option("imagestorage_link"); ?>','logo');" type="button"   value="View Images" style="margin-left:140px;"  />
<input id="upload_logo" type="button" size="36" name="upload_logo" value="Upload Image"  />
 
</div>

<div class="ppt-form-line"> 
<center>
<img src="<?php echo $PPT->ImageCheck($pdi); ?>" alt="preview image" style="max-width:400px;" />
</center>
</div>

   <div class="ppt-form-line">     
   <span class="ppt-labeltext">Image Formatting
   
      <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>   
  
   
   </span>
   
 
<select name="adminArray[pptimage][format]" style="width:200px;  font-size:14px;">
            <option value="1" <?php if($IMAGEVALUES['format'] =="1"){ print "selected";} ?>> Yes</option>
			<option value="0" <?php if($IMAGEVALUES['format'] =="0" || $IMAGEVALUES['format'] ==""){ print "selected";} ?>> No (Use raw images only)</option>
            
			</select>	
            
            <a href="http://www.premiumpress.com/tutorial/images/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>

    <div class="clearfix"></div>
    	</div>  
        
   <?php if($IMAGEVALUES['format'] =="1"){  ?>
   
   
       <?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "directorypress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress"){ ?>
    <p class="ppnote">Note. Image resizing and image mode features are not applied to website thumbnails. They are applied to upload images only.</p>
    <?php } ?>

       
   <span class="ppt-labeltext">Image Resizing </span>
   

   
   <div style="margin-left:140px;">
   
     <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />This feature will automatically resize images to fit the area they are being displayed in. It will create a smaller thumbnail which will increase your page loading times and user experience.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>   
   
   
   
   <p> <input name="adminArray[pptimage][resize]" type="radio" value="none" <?php if($IMAGEVALUES['resize'] == "none" || $IMAGEVALUES['resize'] == ""){ echo 'checked=checked'; } ?> /> Normal Size </p>   
   <p> <input name="adminArray[pptimage][resize]" type="radio" value="exact" <?php if($IMAGEVALUES['resize'] == "exact"){ echo 'checked=checked'; } ?> /> Exact Size </p>
   <p> <input name="adminArray[pptimage][resize]" type="radio" value="crop" <?php if($IMAGEVALUES['resize'] == "crop"){ echo 'checked=checked'; } ?> /> Crop To Fit </p>
   <p> <input name="adminArray[pptimage][resize]" type="radio" value="landscape" <?php if($IMAGEVALUES['resize'] == "landscape"){ echo 'checked=checked'; } ?> /> Landscape (best option) </p> 
   <p> <input name="adminArray[pptimage][resize]" type="radio" value="portrait" <?php if($IMAGEVALUES['resize'] == "portrait"){ echo 'checked=checked'; } ?> /> Portrait</p>
   <p> <input name="adminArray[pptimage][resize]" type="radio" value="sharpen" <?php if($IMAGEVALUES['resize'] == "sharpen"){ echo 'checked=checked'; } ?> /> Sharpening </p> 
   </div>      
        
    
   <span class="ppt-labeltext">Image Mode</span>
   
   <div style="margin-left:140px;">
   
        <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />This feature will change the image display and give it a new render type.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>   
   
   
   
   <p> <input name="adminArray[pptimage][displaytype]" type="radio" value="none" <?php if($IMAGEVALUES['displaytype'] == "none" || $IMAGEVALUES['displaytype'] == ""){ echo 'checked=checked'; } ?> /> Normal Mode (recommended) </p>   
   <p> <input name="adminArray[pptimage][displaytype]" type="radio" value="greyScale" <?php if($IMAGEVALUES['displaytype'] == "greyScale"){ echo 'checked=checked'; } ?> /> 
   Gray Scale </p>
   <!--<p> <input name="adminArray[pptimage][displaytype]" type="radio" value="greyScaleEnhanced" <?php if($IMAGEVALUES['displaytype'] == "greyScaleEnhanced"){ echo 'checked=checked'; } ?> /> greyScaleEnhanced </p>
   <p> <input name="adminArray[pptimage][displaytype]" type="radio" value="greyScaleDramatic" <?php if($IMAGEVALUES['displaytype'] == "greyScaleDramatic"){ echo 'checked=checked'; } ?> /> greyScaleDramatic </p>-->
   <p> <input name="adminArray[pptimage][displaytype]" type="radio" value="sepia" <?php if($IMAGEVALUES['displaytype'] == "sepia"){ echo 'checked=checked'; } ?> /> Sepia </p>
   <p> <input name="adminArray[pptimage][displaytype]" type="radio" value="blackAndWhite" <?php if($IMAGEVALUES['displaytype'] == "blackAndWhite"){ echo 'checked=checked'; } ?> /> Black &amp; White </p>
   <p> <input name="adminArray[pptimage][displaytype]" type="radio" value="negative" <?php if($IMAGEVALUES['displaytype'] == "negative"){ echo 'checked=checked'; } ?> /> Negative </p>
    
   </div>
   
  
   
<?php } ?>

 <div class="clearfix"></div>
 
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=3" />
 
  
 </div> 
 
 

   
  </fieldset> 
  


 



  
  
  
 
  
</div>
 



 
 


<a name="stwpro"></a>
<div class="clearfix"></div>
     
<?php if($IMAGEVALUES['thumbnailapi'] =="shrinktheweb"){  /* ============================ SHRINK THE WEB API ================================= */?>
	
   
    <p>&nbsp;</p>
    <?php if($IMAGEVALUES['STW_access_key']=='' || $IMAGEVALUES['STW_secret_key']==''){?>
    <div class="grid400-left">
    <fieldset>
        <div class="titleh"><h3>Get a ShrinkTheWeb Account</h3></div>
    	<br/>
        <center>
    	<div id="stwwt_signup">
			<a href="http://www.shrinktheweb.com/a/markfail" target="_blank">
				<img src="http://www.shrinktheweb.com/uploads/stw-banners/shrinktheweb-234x60.gif" alt="Website Thumbnail Provider" class="stwwt_settings_banner" width="234" height="60" >
			</a><br /><br />
			<div class="stwwt_settings_banner_text">
				<span>Need an account?</span>
				<a href="http://www.shrinktheweb.com/a/markfail" target="_blank" class="button-primary">Register for FREE</a>
			</div>
		</div>
        </center>
    </fieldset>           
    </div>
    <?php } else {?>
    <div class="grid400-left">
    <fieldset>
        <div class="titleh"><h3>ShrinkTheWeb Login</h3></div>
    	<br/>
        <center>
    	<div id="stwwt_signup">
		    <a href="http://www.shrinktheweb.com/auth/stw-lobby" target="_blank"> <img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/stw.png"></a>
		</div>
        </center>
    </fieldset>           
    </div>
    <?php }?>
    
    <div class="grid400-left">
    <fieldset>
        <div class="titleh"><h3>Enter ShrinkTheWeb Account Credentials</h3></div>
        <br/>
  	    <span class="ppt-labeltext">ACCESS_KEY:</span><input name="adminArray[pptimage][STW_access_key]" type="text" value="<?php echo $IMAGEVALUES['STW_access_key']; ?>" style="width: 200px; font-size:14px;"><br />
        <span class="ppt-labeltext">SECRET_KEY:</span><input name="adminArray[pptimage][STW_secret_key]" type="text" value="<?php echo $IMAGEVALUES['STW_secret_key']; ?>" style="width: 120px; font-size:14px;"><br />
  	    <small>The details above are found in the ShrinkTheWeb admin pages.</small>
        <?php if($IMAGEVALUES['STW_access_key']=='' || $IMAGEVALUES['STW_secret_key']==''){?>
        <center><a href="http://www.shrinktheweb.com/auth/stw-lobby" target="_blank"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/help-images_access-keys.jpg"></a></center>
        <?php }?>
    </fieldset>           
    </div>
     
    <div class="grid400-left">
    <fieldset>
        <div class="titleh"><h3>Help & Support</h3></div>
    	<ol>
    		<li>If you have questions with configuring the "Image" settings, please <a href="http://support.premiumpress.com/index.php?_m=tickets&_a=submit" target="_blank">open a support ticket</a> with PremiumPress to see if your issue is already well-known or is a configuration problem. Your issue might already be answered or resolved.</li>
    		<li>If you think the problem is a <b>plugin or STW account problem</b>, please <a href="http://www.shrinktheweb.com/support/" target="_blank">open a support ticket</a> with ShrinkTheWeb, including <b>as much detail as possible</b>, including any <b>error messages</b> or URLs to see the problem in action.</li>
    	</ol>	
    	<br/>
	    <div class="stwwt_title">A word about the plugin authors...</div>
    	<p>This plugin and the <a href="http://www.shrinktheweb.com" target="_blank">Shrink The Web</a> service has been developed and is provided by <a href="http://www.neosys.net/profile.htm" target="_blank">Neosys Consulting, Inc.</a></p>
    </fieldset>           
    </div>

    <div>
    <fieldset>
        <div class="titleh"><h3>ShrinkTheWeb PRO Features</h3></div>
            
        <p>
            <small>(the below options are for ShrinkTheWeb PRO account holders only, please refer to their manual <a href="http://www.shrinktheweb.com/uploads/PRO_Feature_Documentation.pdf" target="_blank">here</a> for help with this)</small>
        </p>
        
        ShrinkTheWeb Account Type: <br />
        <?php
		
	 
            require_once(TEMPLATEPATH."/PPT/class/stw_account_api.php");
            $aResponse = getAccountInfo(); ?>
        
        <script type="text/javascript">
            function goToAnchor(nameAnchor) {
                window.location.hash=nameAnchor;
            }
        jQuery(document).ready(function(jQuery) {
          goToAnchor('#stwpro');
        
          var upgrade = '<p style="padding-top:3px;"><a href="http://www.shrinktheweb.com/auth/order-page" target="_blank">Upgrade required to use this feature</a></p>';
                    
<?php if ($aResponse['stw_response_status'] == 'Success') { ?>

    if (<?php echo $aResponse['stw_inside_pages']; ?> == 0) {
      jQuery("input[name='adminArray[pptimage][stw_1]']").attr("checked", false);
      jQuery("input[name='adminArray[pptimage][stw_1]']").attr("disabled", true);
      jQuery("input[name='adminArray[pptimage][stw_1]']").parent().append(upgrade);
    }
    if (<?php echo $aResponse['stw_custom_size']; ?> == 0 && <?php echo $aResponse['stw_full_length']; ?> == 0) {
      jQuery("input[name='adminArray[stw_4]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_4]']").parent().append(upgrade);
    } 
    if (<?php echo $aResponse['stw_full_length']; ?> == 0) {
      jQuery("input[name='adminArray[stw_14]']").attr("checked", false);
      jQuery("input[name='adminArray[stw_14]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_8]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_14]']").parent().append(upgrade);
      jQuery("input[name='adminArray[stw_8]']").parent().append(upgrade);
    }
    if (<?php echo $aResponse['stw_refresh_ondemand']; ?> == 0) {
      jQuery("input[name='adminArray[stw_2]']").attr("checked", false);
      jQuery("input[name='adminArray[stw_2]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_2]']").parent().append(upgrade);
    }
    if (<?php echo $aResponse['stw_custom_delay']; ?> == 0) {
      jQuery("input[name='adminArray[stw_5]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_5]']").parent().append(upgrade);
    }
    if (<?php echo $aResponse['stw_custom_quality']; ?> == 0) {
      jQuery("input[name='adminArray[stw_6]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_6]']").parent().append(upgrade);
    }
    if (<?php echo $aResponse['stw_custom_resolution']; ?> == 0) {
      jQuery("input[name='adminArray[stw_9]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_10]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_9]']").parent().append(upgrade);
      jQuery("input[name='adminArray[stw_10]']").parent().append(upgrade);
    }
    if (<?php echo $aResponse['stw_custom_messages']; ?> == 0) {
      jQuery("input[name='adminArray[stw_12]']").attr("disabled", true);
      jQuery("input[name='adminArray[stw_12]']").parent().append(upgrade);
    }
    
<?php }?>

        });
        </script>
            
	<?php if ($aResponse['stw_response_status'] == 'Success') { ?>
            
            <div>
            Cache days <br />
            
             <input name="adminArray[pptimage][stw_11]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_11'] == '' ? '3' : $IMAGEVALUES['stw_11']; ?>"/> 
             days before overwriting stored images<br /><small>Enter 0 (zero) to never update screenshots once cached or<br>-1 to disable caching and always use embedded method instead</small>
            </div>
            <br /><br />


            <div>
            <input style="margin:0 !important;" name="adminArray[pptimage][stw_1]" type="checkbox" value="1" <?php if($IMAGEVALUES['stw_1'] == "1"){ print "checked=checked"; } ?> /> Inside Page Capture
            </div>
            <br /><br />


<!--            <div>
            Default Thumbnail size <br />
            
             <input name="adminArray[stw_7]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_7']; ?>"/> 
             e.g. lg<br /><small>width: mcr 75px, tny 90px, vsm 100px, sm 120px, lg 200px, xlg 320px</small>
            </div>
            <br /><br />
        

            <div>
            Custom Image Size <br />
            
             <input name="adminArray[stw_4]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_4']; ?>"/> 
             e.g. 200 <br /><small>will create image sizes of 200px width</small>
            </div>
            <br /><br />
            

            <div>
             <input style="margin:0 !important;" name="adminArray[stw_14]" type="checkbox" value="1" <?php if($IMAGEVALUES['stw_14'] == "1"){ print "checked=checked"; } ?> /> Full Page Capture
            </div>
            <br /><br />
            

            <div>
            Max height <br />
            
             <input name="adminArray[stw_8]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_8']; ?>"/> 
             e.g. 150<br /><small>for 150px height; use if you want to set maxheight for fullsize capture</small>
            </div>
            <br /><br /> -->


            <div>
             <input style="margin:0 !important;" name="adminArray[stw_2]" type="checkbox" value="1" <?php if($IMAGEVALUES['stw_2'] == "1"){ print "checked=checked"; } ?> /> Refresh on-Demand
            </div>
            <br /><br />

            
            <div>
            Native resolution <br />
            
             <input name="adminArray[stw_9]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_9']; ?>"/> 
             e.g. 640<br /><small>for 640x480</small>
            </div>
            <br /><br />


<!--            <div>
            Widescreen resolution Y <br />
            
             <input name="adminArray[stw_10]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_10']; ?>"/> 
             e.g. 900<br /><small>for 1440x900 if 1440 is set for Native resolution</small>
            </div>
            <br /><br /> -->


            <div>
            Custom Delay <br />            
            
             <input name="adminArray[stw_5]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_5']; ?>"/> 
             e.g. 40 <br /><small>To specify wait after page load in seconds - max 45s</small>
            </div>
            <br /><br />
             
             
            <div>
            Custom quality <br />
            
             <input name="adminArray[stw_6]" type="text" style="width:80px;" value="<?php echo $IMAGEVALUES['stw_6']; ?>"/> 
             e.g. 80 <br /><small>Where X represents the output image quality percent e.g. for 80%</small>
            </div>
            <br /><br />

        
            <div>
            Custom Messages URL (remote path) <br />
            
             <input name="adminArray[stw_12]" type="text" style="width:250px;" value="<?php echo $IMAGEVALUES['stw_12']; ?>"/> 
             <br /><small>path to your custom message images</small>
            </div>
            <br /><br />


    <?php } else {?>
            <br /><p style="color:red">Invalid account credentials detected</p>
            <small style="color:red">please check your account credentials to use ShrinkTheWeb</small><br /><br />
    <?php } ?>
    
     <div class="clearfix"></div>
 
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=3" />
 
  
 </div> 
 
        </fieldset> 
        
        
        
                 
    </div>         
    
<?php }  /* ============================ SHRINK THE WEB API ================================= */   ?>  
 
 
 
 <div class="clearfix"></div>
 
 

 
</div>














<div id="premiumpress_tab4" class="content">

 


 
<div class="clearfix"></div>


<div class="grid400-left">

<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Category Display Options

<a href="edit-tags.php?taxonomy=category&TB_iframe=true&width=640&height=838" class="thickbox button-primary" style="float:right; margin-right:10px; margin-top:-3px;">Manage Categories</a>


</h3></div>


  <div class="ppt-form-line">     
<span class="ppt-labeltext">Empty Categories

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is this</b><br /><br />If you are importing thousands of categories into your website some hosting accounts cannot withstand the server load, enable this option and the system will display only categories with listings to prevent your website from timing out. a&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>

      

<select name="adminArray[system_largecatload]" class="ppt-forminput" >
				
				<option value="no" <?php if(get_option("system_largecatload") =="no" || get_option("display_linkcloak") ==""){ print "selected";} ?>>Show (recommended)</option>
                <option value="yes" <?php if(get_option("system_largecatload") =="yes"){ print "selected";} ?>>Hide </option>
			</select>
            
       <a href="http://www.premiumpress.com/tutorial/categories-and-tags/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
        
<div class="clearfix"></div>
</div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Category Count 
   <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br />Here you show/hide the category count next to the category names. ie: Category Name (100).&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>




     
<select name="adminArray[display_categories_count]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("display_categories_count") =="yes"){ print "selected";} ?>>Show</option>
				<option value="no" <?php if(get_option("display_categories_count") =="no"){ print "selected";} ?>>Hide</option>
			</select>
            
     <a href="http://www.premiumpress.com/tutorial/categories-and-tags/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
                
            
<div class="clearfix"></div>
</div>
 
<div class="ppt-form-line">	            
 <p>Hidden Categories (<em>select categories to hide</em>)
 
       <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br />Some times you may want to completely hide a category from dislay, by selecting the category here the system will hide from from display.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
     
 </p>
    <select name="hidden_cats[]" multiple="multiple" style="width:100%; height:150px;">
    <option></option>
      <?php echo premiumpress_categorylist(explode(",",get_option('article_cats')),false,false,"category",0,true); ?>
    </select>
    <br /> <small>Hold SHIFT to select multiple categories.</small>
 </div>
 
 
  <div class="clear" style="margin-top:10px;">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=4" />
 
 
 </div>
 
</fieldset>
 

</div>

<div class="grid400-left last">
	 

 
<a href="http://www.premiumpress.com/tutorial/categories-and-tags/" target="_blank"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/18.jpg" align="absmiddle" style="margin-left:10px;" /></a>
 

  
 
</div>

 <div class="clearfix"></div>
 


</div>


 







<div id="premiumpress_tab5" class="content">


<div id="videoboxc3"></div> 

<?php  $searchData->presets_form(); ?> 

<div class="clearfix clear"></div>

</div>













<div id="premiumpress_tab6" class="content">

 

<div class="grid400-left">

 
			 
  
<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Listing / Package Expiry</h3></div>

<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "auctionpress"){   ?>
<div class="ppt-form-line">     
<span class="ppt-labeltext">Listing Expiry

     <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is listing expiry?</b><br /><br />When adding/editing a listing you can choose how long the listing will stay on your website before it expires, the options here allow you to determine what happens to the listing when it expires. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>

 

	<select name="adminArray[feature_expiry]" class="ppt-forminput" >
				<option value="yes" <?php if(get_option("feature_expiry") =="yes"){ print "selected";} ?>>Enable </option>
				<option value="no" <?php if(get_option("feature_expiry") =="no" || get_option("feature_expiry") ==""){ print "selected";} ?>>Disable</option>
			</select> 
            
        <a href="http://www.premiumpress.com/tutorial/listing-expiry-options/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
     
            
            
<div class="clearfix"></div>
</div>  
 
 
 
<?php if(get_option("feature_expiry") =="yes"){ ?>	 
 <div class="ppt-form-line">     
<span class="ppt-labeltext">When expires;</span>
 
 		 
			
			<?php $vv1 = get_option("feature_expiry_do"); ?>
			<select name="adminArray[feature_expiry_do]" class="ppt-forminput" <?php if(get_option("feature_expiry") !="yes"){ print 'disabled';} ?>>
				<option value="draft" <?php if($vv1 =="draft"){ echo "selected"; } ?> >Set to draft</option>
                <option value="delete" <?php if($vv1 =="delete"){ echo "selected"; } ?>>Delete</option>
                
                <?php 
				
				if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "shopperpress"){
				
				$packdata = get_option("packages");  ?>
                
                <?php if(isset($packdata[1]['enable']) && $packdata[1]['enable'] ==1){ ?><option value="pak1" <?php if($vv1 =="pak1"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[1]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[2]['enable']) && $packdata[2]['enable'] ==1){ ?><option value="pak2" <?php if($vv1 =="pak2"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[2]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[3]['enable']) && $packdata[3]['enable'] ==1){ ?><option value="pak3" <?php if($vv1 =="pak3"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[3]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[4]['enable']) && $packdata[4]['enable'] ==1){ ?><option value="pak4" <?php if($vv1 =="pak4"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[4]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[5]['enable']) && $packdata[5]['enable'] ==1){ ?><option value="pak5" <?php if($vv1 =="pak5"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[5]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[6]['enable']) && $packdata[6]['enable'] ==1){ ?><option value="pak6" <?php if($vv1 =="pak6"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[6]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[7]['enable']) && $packdata[7]['enable'] ==1){ ?><option value="pak7" <?php if($vv1 =="pak7"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[7]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[8]['enable']) && $packdata[8]['enable'] ==1){ ?><option value="pak8" <?php if($vv1 =="pak8"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[8]['name']; ?></option><?php } ?>
                
                
<?php
}

		$Maincategories= get_categories('use_desc_for_title=1&hide_empty=0&hierarchical=0');
		$Maincatcount = count($Maincategories);				 
		foreach ($Maincategories as $cat) {		
			if($cat->parent ==0){
				print '<option  value="'.$cat->cat_ID.'"';
				if($vv1 == $cat->cat_ID){ print "selected"; }
				print ' >Move to ' . $cat->cat_name."</option>";
			}else{
				print '<option value="'.$cat->cat_ID.'" ';
				if($vv1 == $cat->cat_ID){ print "selected"; }
				print '> -- Move to  ' . $cat->cat_name."</option>";
			} 
		
		}
		
?>                
                
			</select>
            
            <a href="http://www.premiumpress.com/tutorial/listing-expiry-options/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
     
            
            
            <br />
             <p class="ppnote1">Only listings with a valid expiry date will follow the rules set here.</p>
 
 
<?php }else{ echo '<input type="hidden" name="adminArray[feature_expiry_do]" value="no">'; } ?>

<?php } ?>

<div class="clearfix"></div>



<div class="ppt-form-line">     
<span class="ppt-labeltext">Automatic Listing Removal

    <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What's This?</b><br /><br />Here you can enable listings to be automatically move/delete listings after X number of days. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</span>

  
<select name="adminArray[post_prun]" class="ppt-forminput">

				<option value="no" <?php if(get_option("post_prun") == "no"){ print "selected"; } ?>>Disable</option>

				<option value="yes" <?php if(get_option("post_prun") == "yes"){ print "selected"; } ?>>Enable</option>

			</select>
            
            <a href="http://www.premiumpress.com/tutorial/automatic-listing-removal/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
     
            
<div class="clearfix"></div>
</div> 
 
 
 
 
            

			<?php if(get_option("post_prun") == "yes"){  ?>


            
            <p><b>What should we do with the listing?</b></p>
            
            <?php $vv1 = get_option('prun_status'); ?>
            <select name="adminArray[prun_status]" class="ppt-forminput">

				<option value="draft" <?php if($vv1 =="draft"){ echo "selected"; } ?> >Set to draft</option>
                <option value="delete" <?php if($vv1 =="delete"){ echo "selected"; } ?>>Delete</option>
                
                <?php 
				
				if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "shopperpress"){
				
				$packdata = get_option("packages");  ?>
                
                <?php if(isset($packdata[1]['enable']) && $packdata[1]['enable'] ==1){ ?><option value="pak1" <?php if($vv1 =="pak1"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[1]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[2]['enable']) && $packdata[2]['enable'] ==1){ ?><option value="pak2" <?php if($vv1 =="pak2"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[2]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[3]['enable']) && $packdata[3]['enable'] ==1){ ?><option value="pak3" <?php if($vv1 =="pak3"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[3]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[4]['enable']) && $packdata[4]['enable'] ==1){ ?><option value="pak4" <?php if($vv1 =="pak4"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[4]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[5]['enable']) && $packdata[5]['enable'] ==1){ ?><option value="pak5" <?php if($vv1 =="pak5"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[5]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[6]['enable']) && $packdata[6]['enable'] ==1){ ?><option value="pak6" <?php if($vv1 =="pak6"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[6]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[7]['enable']) && $packdata[7]['enable'] ==1){ ?><option value="pak7" <?php if($vv1 =="pak7"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[7]['name']; ?></option><?php } ?>
                <?php if(isset($packdata[8]['enable']) && $packdata[8]['enable'] ==1){ ?><option value="pak8" <?php if($vv1 =="pak8"){ echo "selected"; } ?>>Down Grade to <?php echo $packdata[8]['name']; ?></option><?php } ?>
                
                
<?php
}

		$Maincategories= get_categories('use_desc_for_title=1&hide_empty=0&hierarchical=0');
		$Maincatcount = count($Maincategories);				 
		foreach ($Maincategories as $cat) {		
			if($cat->parent ==0){
				print '<option  value="'.$cat->cat_ID.'"';
				if($vv1 == $cat->cat_ID){ print "selected"; }
				print ' >Move to ' . $cat->cat_name."</option>";
			}else{
				print '<option value="'.$cat->cat_ID.'" ';
				if($vv1 == $cat->cat_ID){ print "selected"; }
				print '> -- Move to  ' . $cat->cat_name."</option>";
			} 
		
		}
		
?>     

			</select>	

				<br />
                
            <p><b>After how many days?</b></p> 
			<input name="adminArray[prun_period]" type="text" style="width: 40px;" maxlength="3" value="<?php echo get_option("prun_period"); ?>" /> Days 
            
            <p class="ppnote">Here you enter a numeric value, X days after first published, the above action is then performed </p>
 
           

		 

            <?php }else{ echo '<input type="hidden" name="adminArray[prun_status]" value=""><input type="hidden" name="adminArray[prun_period]" value="">'; } ?>



  <div class="clearfix"></div>
  <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=6" />
 
  
 </div>


</fieldset> 


	<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> MISC / Extras</h3></div>

  <div class="ppt-form-line">     
<span class="ppt-labeltext">`nofollow` links

    <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is nofollow?</b><br /><br />nofollow is a value that can be assigned to the rel attribute of an HTML element to instruct some search engines that a hyperlink should not influence the link target's ranking in the search engine's index. <br/><br/> It is intended to reduce the effectiveness of certain types of search engine spam, thereby improving the quality of search engine results and preventing spamdexing from occurring.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>


  

<select name="adminArray[nofollow]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("nofollow") =="yes"){ print "selected";} ?>>Enable</option>
				<option value="no" <?php if(get_option("nofollow") =="no"){ print "selected";} ?>>Disable</option>
			</select>
            
   <a href="http://www.premiumpress.com/tutorial/misc-settings/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
              
            
<div class="clearfix"></div>
</div>          
 
 

  <div class="ppt-form-line">     
<span class="ppt-labeltext">Link Cloaking


 <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is link cloaking?</b><br /><br />Link cloaking simply disguises an external link such as http://google.com with an internal link such as http://mywebsite.com/link=123 a so that it does not display the actual URL to your website visitors. It is most often applied with affiliate links which can be long or look ugly from an SEO stand point.<br><br><b>Should i enable this option?</b><br><br>Unless you are very familiar with link cloaking it is <b>not recommended</b> to use this option, it has only been added to provide resources for those who wish to use it.<br><br><b>How does it work?</b><br><br>The link cloaking file path you enter below will replace the external link, the post ID is passed to the file and the system will then auto redirect the user to the link. a&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>

     

<select name="adminArray[display_linkcloak]" class="ppt-forminput" >
				<option value="yes" <?php if(get_option("display_linkcloak") =="yes"){ print "selected";} ?>>Enable </option>
				<option value="no" <?php if(get_option("display_linkcloak") =="no" || get_option("display_linkcloak") ==""){ print "selected";} ?>>Disable (recommended)</option>
			</select>
            
   <a href="http://www.premiumpress.com/tutorial/misc-settings/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
            
<div class="clearfix"></div>
</div>

  
     <div class="ppt-form-line">	
    <span class="ppt-labeltext">Addthis Username
    
    <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is AddThis?</b><br /><br />AddThis use big social data to create tools that enable publishers and brands to weave a more personal and social web. Their social plugins and real-time analytics enable site owners to drive traffic and increase engagement. Find out more from their website at: http://www.addthis.com<br><br><b>How to turn it OFF? </b><br>Enter the username 'off' and it will be disabled.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
    
    </span>	
    
           
	 
    <input  type="text" value="<?php $addtu = get_option('addthisusername'); if($addtu == ""){ echo "premiumpress"; }else{ echo $addtu; }  ?>" name="adminArray[addthisusername]"  class="ppt-forminput" />
    
    
    <a href="http://www.premiumpress.com/tutorial/misc-settings/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
   
    <div class="clearfix"></div>    
    </div>
    
    
    
<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress"){ ?>

  <div class="ppt-form-line">     
<span class="ppt-labeltext">SkimLinks <br /><small>(<a href="http://skimlinks.com" target="_blank">Learn More</a>)</small>

    <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is SkimLinks</b><br /><br />Skimlinks works by turning direct merchant urls into affiliate links simply by placing a snippet of javascript into your website coding, or alternatively use the Skimlinks redirect.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>


  

<select name="adminArray[cp_skimlinks]" class="ppt-forminput">
				<option value="yes" <?php if(get_option("cp_skimlinks") =="yes"){ print "selected";} ?>>Enable</option>
				<option value="no" <?php if(get_option("cp_skimlinks") =="no"){ print "selected";} ?>>Disable</option>
			</select>
            
<div>API ID: <input name="adminArray[cp_skimlinks_id]" type="text" style="width: 160px;"  value="<?php echo get_option("cp_skimlinks_id"); ?>" /> </div> 
                       
            
<div class="clearfix"></div>
</div> 
<?php } ?>
    


 <div class="clearfix"></div>
  <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=6" />
 
  
 </div>
</fieldset>  	 

</div><div class="grid400-left last"> 



<div class="videobox" id="videobox42" style="margin-bottom:10px;">
<a href="javascript:void(0);" onclick="PlayPPTVideo('SOTWxQuPZT4','videobox42');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/4.jpg" align="absmiddle" /></a>
</div>

  

 
</div>
<div class="clearfix"></div>

<?php /* ============================ ================================= */ ?>
 



    
 
<?php


 


$lv = explode("**",get_option("listbox_custom_string"));
?>
 

<table width="650"  border="0" style=" border:5px solid #ccc; margin-top:20px;">

  
 <td colspan="4">
<img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/b2.png" style="float:right;">  
 		<p><b><input type="checkbox" class="checkbox" name="listbox_custom" value="1" <?php if(get_option("listbox_custom") =="1"){ print "checked";} ?> /> Enable Display</b><br />
        
        
        
 		<small>Check the box to display the 'order by' list box on your website.</small></p>
 		<br />
			 
           
     <p><b>List box Caption</b></p>       
	 <input name="adminArray[listbox_custom_title]" type="text"  class="ppt-forminput" style="width: 400px;" value="<?php echo get_option("listbox_custom_title"); ?>" /><br />
			<small>This will be the title caption for your new list box.</small>
 
 </td>

  <tr>
    <td width="51%" height="47"><strong>List Item Caption <br />
    <small>(e.g: Order By Hits ASC)</small></strong></td>
    <td width="13%"><div align="center"><strong>Order by Field </div></td>
    <td width="24%"><div align="center"><strong>Display Order </strong></div></td>
    <td width="24%"> <div align="center"><strong>Extra <br />
    <small>(advanced use only. e.g &amp;meta_value=yes)</small></strong></div></td>
    </tr>
    
    <?php 
	
	$carray = array('a','b','c','d','e','f','g','h','i','j','k','l');
	$C1 = 0; $C2=0; $c=0; while($c < 12){ ?>
  <tr>
    <td><input type="text" name="<?php echo $carray[$C2]; ?>1" class="ppt-forminput" style="width:250px;" value="<?php echo $lv[$C1++]; ?>"></td>
    <td><select name="<?php echo $carray[$C2]; ?>2"><?php echo GetCustomFieldList($lv[$C1++]); ?></select></td>
    <td><select name="<?php echo $carray[$C2]; ?>3"><option value="asc">Ascending Order</option><option value="desc" <?php if($lv[$C1++] == "desc"){ print "selected='selected'";} ?>>Descending Order</option></select></td>
    <td><input name="<?php echo $carray[$C2]; ?>4" type="text" size="20" value="<?php echo $lv[$C1++]; ?>"></td>
    </tr>
    
    <?php $C2++; $c++; } ?>
    
 
 </table>
  
 


<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;"  onclick="document.getElementById('showThisTab').value=6" /></p>
</div>            
					 
                        
</form> 









<div id="premiumpress_tab7" class="content">

<script language="javascript">
function clearMe(){
document.getElementById("query").value = "";
}
</script>
<div style="padding:0px;padding-bottom:10px;">
<div class="PremiumPress_Members_search" style="float:right;">
		<form method="post" action="admin.php?page=setup">			
			<input type="text" id="query" name="query" class="blur" value="Keyword.." onclick="clearMe();">
			 
            <input type="hidden" name="page" value="setup">	
            <input type="hidden" value="7" name="showThisTab" id="showThisTab" />		
			<input type="submit" value="Search Text" class="button">
		</form>
</div>
</div>
<div class="clearfix"></div>

<form method="post" target="_self" enctype="multipart/form-data">

<input name="admin_page" type="hidden" value="language_setup" />
<input type="hidden" value="7" name="showThisTab" id="showThisTab" />	

<?php $PPT->Language(); $sl = get_option("pptlanguage"); $lang = "english"; ?>

<div class="toggle">
<?php 

// GET ARRAY KEYS
$i=0; $STRING = "";
$language_array_keys = array_keys($GLOBALS['_LANG'][$lang]);

foreach($GLOBALS['_LANG'][$lang] as $value){
 
	if($language_array_keys[$i] == "descriptions"){ $i++; continue; }
	 
	if(is_array($value)){ 
	 
	   
	
		$STRING .= '<div class="trigger activateme'.$i.'"><a href="#">'.$i.'. '.$GLOBALS['_LANG'][$lang]['descriptions'][$language_array_keys[$i]].'. [click here to show/hide text]</a></div> <div class="container">';
		$STRING .= '<table width="100%" border="0"><th>Current Text</th><th>Your Translation Here</th>';
	 
		foreach($value as $key=>$val){
		
		 
		
		 if(isset($_POST['query']) && strlen($_POST['query']) > 1 && strpos(strtolower($val), strtolower($_POST['query']) ) !== false){ $STRING = str_replace("activateme".$i,"active", $STRING); $bull = "<img src='".PPT_FW_IMG_URI."link-menu-arrow.png' />";  }else{ $bull = ""; } 
		
		  $STRING .=' <tr>
			<td>'.$bull.'<input name="" type="text" class="ppt-forminput" value="'.$val.'" style="width:350px;" disabled="disabled" /></td>
			<td>'.$bull.'<input name="pplang['.$lang.']['.$language_array_keys[$i].']['.$key.']" type="text" class="ppt-forminput" 
			value="';
			if(isset($sl[$lang][$language_array_keys[$i]][$key])){ $STRING .= stripslashes($sl[$lang][$language_array_keys[$i]][$key]); }
			$STRING .='" style="width:350px;" /></td></tr>';
		
		} 
		// clean up 
		$STRING = str_replace("activateme".$i,"", $STRING); 
		
		$STRING .= '</table>';
		
		$STRING .= '<p><input class="premiumpress_button" type="submit" value="Save Text Changes" style="color:#fff;"  onclick="document.getElementById(\'showThisTab\').value=7" /></p>';
	
	
		$STRING .= '</div>';
		$i++;
	} // if array
}// end foreach
echo $STRING; 
?>
 </div>

<div class="clearfix"></div>



<script language="javascript">
	jQuery(".toggle .container").hide();
	jQuery('.toggle .trigger.active').addClass('active').next().show();

	jQuery(".toggle .trigger").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("fast");
		return false;
	});
</script>

<style>
 
.toggle, .accordion {	position: relative;	margin-bottom: 20px;}
.trigger {	background: #eeeeee url('<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/toggle-button.png') top right no-repeat;	border-top: 1px solid #dddddd;	height: 32px;	width: 100%;	float: left;    margin-bottom: 10px;	-moz-border-radius: 4px;    -webkit-border-radius: 4px;    border-radius: 4px;}
.active.trigger a {	color: #333333;}
.trigger a {font-size: 12px;	font-weight: bold;	line-height: 32px;	color: #666666;	padding-left: 10px;	display: block;}
.trigger a:hover { color: #ccc; }
.trigger.active { background-position: bottom right; }
.toggle > .container, .accordion > .container {	padding: 10px;	overflow: hidden;	clear: both;}

</style>

</div>

<!-- end tab 7 -->



</div> 
<div class="clearfix clear"></div>  



</form> 

 

 

<?php } ?>