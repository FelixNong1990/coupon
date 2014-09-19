
<?php if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; }  PremiumPress_Header(); $packagedata = get_option('ppt_membership');  


// 1. CREATE PACKAGES

// 2. SET THE POST/PAGE ACCESS FOR PACKAGES

// 3. SETUP PACKAGE PAYMENT OPTIONS






?>


<div class="clearfix"></div> 

<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_membership.png" align="middle"> Membership Packages</h3>	 
 
</div>


<form method="post" target="_self">
<input name="submitted" type="hidden" value="yes" />

<div id="premiumpress_tab1" class="content">



 

<div class="clearfix"></div>


<div class="grid400-left"> 

<div id="videoboxc1"></div>

<fieldset><div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Display Options</h3></div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Memberships <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is the main system switch and will tell the system to use your membership options.<br><br> Turning it off will disable all membership display options and page restrictions. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>	 
 
<select name="ppt_membership[enable]" class="ppt-forminput">
<option value="yes" <?php if($packagedata['enable'] == "yes"){ echo "selected=selected"; } ?>>Enable Memberships</option>
<option value="no" <?php if($packagedata['enable'] == "no"){ echo "selected=selected"; } ?>>Disable</option>
</select>
<a href="http://www.premiumpress.com/tutorial/membership-packages/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-left:10px; margin-right:5px;" /></a>
 
 
<div class="clearfix"></div>
</div>
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Registration <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This option will display your membership packages on the registration page and force the user to select one. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>	 
 
<select name="ppt_membership[show_register]" class="ppt-forminput">
<option value="yes" <?php if($packagedata['show_register'] == "yes"){ echo "selected=selected"; } ?>>Display Membership Packages</option>
<option value="no" <?php if($packagedata['show_register'] == "no"){ echo "selected=selected"; } ?>>Don't Display</option>
</select>
<a href="http://www.premiumpress.com/tutorial/membership-packages/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-left:10px; margin-right:5px;" /></a>

<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">My Account <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This will display your membership packages on the 'my account' page giving the user the option to upgrade. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>	 
 
<select name="ppt_membership[show_myaccount]" class="ppt-forminput">
<option value="yes" <?php if($packagedata['show_myaccount'] == "yes"){ echo "selected=selected"; } ?>>Display Membership Packages</option>
<option value="no" <?php if($packagedata['show_myaccount'] == "no"){ echo "selected=selected"; } ?>>Don't Display</option>
</select>
<a href="http://www.premiumpress.com/tutorial/membership-packages/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-left:10px; margin-right:5px;" /></a>

<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" /> </p></div>

</fieldset>

<fieldset><div class="titleh"> <h3> <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> Membership Transfer</h3></div>

<p>Here you can transfer members from one package to another.</p>

<div class="ppt-form-line">	
<span class="ppt-labeltext">From Package</span>	 
 
<select name="frompack" class="ppt-forminput">
<option value="">----------</option>
<option value="0">No Package Assigned</option>
 <?php $i=0;
if(is_array($packagedata) && isset($packagedata['package']) ){ 
$neworder = multisort( $packagedata['package'] , array('order') );
foreach($neworder as $package){ echo '<option value="'.$package['ID'].'">'.$package['name'].'</option>';   } }?>
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">To Package</span>	 
 
<select name="topack" class="ppt-forminput">
<option value="">----------</option>
<option value="0">No Package Assigned</option>
 <?php $i=0;
if(is_array($packagedata) && isset($packagedata['package']) ){ 
$neworder = multisort( $packagedata['package'] , array('order') );
foreach($neworder as $package){ echo '<option value="'.$package['ID'].'">'.$package['name'].'</option>';   } }?>
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	<p><input class="premiumpress_button" type="submit" value="Start Transfer" style="color:#fff;" /> </p></div>

</fieldset>

 
<div class="clearfix"></div>
<div class="videobox" id="videobox1a" style="margin-top:10px;">
<a href="javascript:void(0);" onclick="PlayPPTVideo('dbuAqgAXPuc','videobox1a');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/17.jpg" align="absmiddle" /></a>
</div> 


</div>

<div class="grid400-left last">

 <script language="javascript">
 
 function ChangeTickValue(div){
 
	 if(document.getElementById(div).value==0){
	 document.getElementById(div).value=1;
	 }else{
	 document.getElementById(div).value=0;
	 }
 
 }
 
 </script>
<?php $i=0;

if(is_array($packagedata) && isset($packagedata['package']) ){ 


$neworder = multisort( $packagedata['package'] , array('order') );

foreach($neworder as $package){   ?>
 

<div id="package<?php echo $i; ?>">

<div class="green_box"><div class="green_box_content">
<div class="ppt-form-line">	
<span class="ppt-labeltext">Package Name <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is the display name for your package. It's just a display caption, it does nothing more than look pretty. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 <input name="ppt_membership[package][name][]" type="text" class="ppt-forminput" value="<?php echo $package['name']; ?>" id="pn<?php echo $i; ?>" />
<div class="clearfix"></div>
</div>

<div id="packop<?php echo $i; ?>" style="display:none;">

 <a href="http://www.premiumpress.com/tutorial/membership-packages/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-left:10px; margin-top:10px; margin-right:5px;" /></a>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Duration <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is where you choose how many days (numeric value) before the package expires. Once expired the users membership will be removed. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 <input name="ppt_membership[package][duration][]" type="text" class="ppt-forminput" style="width:50px;" value="<?php echo $package['duration']; ?>" /> Days (Max 999 days)
<div class="clearfix"></div>
</div>
 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Price <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is the price the user will pay to purchase this membership. The price should be entered as a numberic value (100) NOT ($100). &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
<?php echo get_option('currency_symbol'); ?> <input type="text" class="ppt-forminput" style="width:50px;" name="ppt_membership[package][price][]" value="<?php echo $package['price']; ?>" />

<div style="float:right; margin-top:-30px;">
<input  type="checkbox" name="checkme1<?php echo $i; ?>" value="1" onchange="ChangeTickValue('checkme1<?php echo $i; ?>');" <?php if($package['recurring'] == 1){ echo "checked=checked"; } ?> style="margin-left:140px;" />Recurring (PayPal Only)

<input type="hidden" name="ppt_membership[package][recurring][]" id="checkme1<?php echo $i; ?>" value="<?php if(isset($package['recurring']) && $package['recurring'] ==1){ echo 1; }else{ echo 0; } ?>" />
</div>

  
  <?php if(get_option('gateway_paypal') == "yes" && isset($package['recurring']) && $package['recurring'] ==1){ ?>
 
<div class="clearfix"></div>
  <b style="margin-left:140px;"> How many trial days?</b> <input name="ppt_membership[package][freetrial][]" type="text" style="width:30px;" size="5" value="<?php echo $package['freetrial']; ?>"> <br /><small style="margin-left:140px;">Leave blank if not used. PayPal Only.</small>
  
   
            
 <?php }else{ ?>
 <input name="ppt_membership[package][freetrial][]" type="hidden" value="" />
 <?php } ?>
   
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Submissions <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This option allows you to override the submission package selection. If you set the package to unlimited, the user can add as amny submissions as they like without having to pay extra. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>	 
 
<select name="ppt_membership[package][submission][]" class="ppt-forminput">
<option value="unlimited" <?php if($package['submission'] == "unlimited"){ echo "selected=selected"; } ?>>Unlimited Submissions</option>
<option value="off" <?php if($package['submission'] == "off"){ echo "selected=selected"; } ?>>Normal (1 per purchase)</option>
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Package ID <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />If you have set the 'Submissions' value to unlimited here you can define which package they get unlimited submissions for. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>

<select name="ppt_membership[package][packageID][]" class="ppt-forminput">
<?php $packdata = get_option("packages");  ?>                
<?php if(isset($packdata[1]['enable']) && $packdata[1]['enable'] ==1){ ?><option value="1" <?php if($package['packageID'] =="1"){ echo "selected"; } ?>><?php echo $packdata[1]['name']; ?></option><?php } ?>
<?php if(isset($packdata[2]['enable']) && $packdata[2]['enable'] ==1){ ?><option value="2" <?php if($package['packageID'] =="2"){ echo "selected"; } ?>><?php echo $packdata[2]['name']; ?></option><?php } ?>
<?php if(isset($packdata[3]['enable']) && $packdata[3]['enable'] ==1){ ?><option value="3" <?php if($package['packageID'] =="3"){ echo "selected"; } ?>><?php echo $packdata[3]['name']; ?></option><?php } ?>
<?php if(isset($packdata[4]['enable']) && $packdata[4]['enable'] ==1){ ?><option value="4" <?php if($package['packageID'] =="4"){ echo "selected"; } ?>><?php echo $packdata[4]['name']; ?></option><?php } ?>
<?php if(isset($packdata[5]['enable']) && $packdata[5]['enable'] ==1){ ?><option value="5" <?php if($package['packageID'] =="5"){ echo "selected"; } ?>><?php echo $packdata[5]['name']; ?></option><?php } ?>
<?php if(isset($packdata[6]['enable']) && $packdata[6]['enable'] ==1){ ?><option value="6" <?php if($package['packageID'] =="6"){ echo "selected"; } ?>><?php echo $packdata[6]['name']; ?></option><?php } ?>
<?php if(isset($packdata[7]['enable']) && $packdata[7]['enable'] ==1){ ?><option value="7" <?php if($package['packageID'] =="7"){ echo "selected"; } ?>><?php echo $packdata[7]['name']; ?></option><?php } ?>
<?php if(isset($packdata[8]['enable']) && $packdata[8]['enable'] ==1){ ?><option value="8" <?php if($package['packageID'] =="8"){ echo "selected"; } ?>><?php echo $packdata[8]['name']; ?></option><?php } ?>
                
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Messages <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This option allows you choose which membership packages can use the internal message system. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>	 
 
<select name="ppt_membership[package][messages][]" class="ppt-forminput">
<option value="yes" <?php if($package['messages'] == "yes"){ echo "selected=selected"; } ?>>Yes - Can send messages</option>
<option value="no" <?php if($package['messages'] == "no"){ echo "selected=selected"; } ?>>No - Cannot send messages</option>
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Max Submissions <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is a numeric value which determins the maximum number of listings a user with this package can create. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 #<input name="ppt_membership[package][max_submit][]" type="text" class="ppt-forminput" style="width:50px;" value="<?php echo $package['max_submit']; ?>" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Order <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is a numeric value which determins in what order the package is displayed. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 #<input name="ppt_membership[package][order][]" type="text" class="ppt-forminput" style="width:50px;" value="<?php echo $package['order']; ?>" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">ID <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This MUST be a unique value that identifies the membership package in the database. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 #<input name="ppt_membership[package][ID][]" type="text" class="ppt-forminput" style="width:50px;" value="<?php echo $package['ID']; ?>" /> 
<div class="clearfix"></div>
</div>


    <div class="ppt-form-line">	
    <span class="ppt-labeltext">Package Description <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is where you write a few words about the package. Why should they pay for this package? It's a good idea to include the price and duration in the description. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
    <textarea  class="ppt-forminput" name="ppt_membership[package][desc][]" style="height:100px;"><?php echo $package['desc']; ?></textarea>
    <div class="clearfix"></div>
    </div>
    
</div>

<div class="ppt-form-line">	

<a href="javascript:void(0);" onclick="toggleLayer('packop<?php echo $i; ?>');"  class="button tagadd left">Show/Hide Options</a>

<a href="javascript:void(0);" onclick="document.getElementById('pn<?php echo $i; ?>').value=''; jQuery('#package<?php echo $i; ?>').hide();" class="button tagadd right" style="margin-left:120px;">Remove Package</a>     

</div>


<div class="clearfix"></div>
</div></div></div>



<?php $i++; } } ?>


<a name="botme"></a>


<div id="PACKAGEDISPLAYHERE"></div>
          
 	
<a href="#botme" onclick="jQuery('#packagebox').clone().appendTo('#PACKAGEDISPLAYHERE');" class="button-primary" style="float:left;"> Add New Package</a>
  
<input class="premiumpress_button" type="submit" value="Save Changes" style="float:right;color:#fff;"  /> 

 				 
</form>
                    
</div>



</div>
<div class="clearfix"></div>   









<!------------------------------------ PACKAGE BLOCK ------------------------------>


<div style="display:none;">
<div id="packagebox">
<div class="green_box"><div class="green_box_content">


<div class="ppt-form-line">	
<span class="ppt-labeltext">Package Name</span>
 <input name="ppt_membership[package][name][]" type="text" class="ppt-forminput" />
<div class="clearfix"></div>
</div> 
   


<div class="clearfix"></div></div></div>
</div></div>
</div>