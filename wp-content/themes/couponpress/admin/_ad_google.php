
<?php if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; }  PremiumPress_Header();  ?>


<div class="clearfix"></div> 

<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_analytics.png" align="middle"> Google Tools</h3>	 <a class="premiumpress_button" href="javascript:void(0);" onclick="PPHelpMe()"><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/youtube.png" align="middle" style="margin-top:-10px;"> Help Me</a>							 
<ul>
	<li><a rel="premiumpress_tab1" href="#" class="active">Google WebMaster Tools</a></li> 
</ul>
</div>


<form method="post" target="_self">
<input name="submitted" type="hidden" value="yes" />

<div id="premiumpress_tab1" class="content">


<div class="grid400-left"> 

<fieldset><div class="titleh"> <h3>Google Analytics Code</h3></div>

<p>Copy/paste your google analytics site code in the box below.</p>
<div class="ppt-form-line">	
<textarea name="adminArray[analytics_code]" type="text" class="ppt-forminput"style="width:350px;height:100px;"><?php echo stripslashes(get_option("analytics_code")); ?></textarea>
<p class="ppnote" >Google analytics is a free web analytics tool from Google that allows you to track your website visitors and statistics. </p>
<p class="ppnote1" >If you don't already have an account, its strongly recommended you signup and start learning more about where your website visitors come from. <a href="http://www.google.com/analytics/" target="_blank" style="text-decoration:underline;">http://www.google.com/analytics/</a></p>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Event Tracking</span>	 
 
<select name="adminArray[analytics_tracking]" class="ppt-forminput">
				<option value="yes">Enable Event Tracking</option>
				<option value="no">Disable</option>
</select>
<div class="clearfix"></div>
</div>
<p class="ppnote">This will allow Google analytics to track your website visitor click history to see which products/items are most popular. <b>This is strongly recommended for all website owners.</b> </p>            
</fieldset>


 <fieldset><div class="titleh"> <h3>Sales Conversion Tracking</h3></div>
<p>Enter any aftersales tracking or conversion code here and it will be injected into your callback page to record callback data. </p>
 
<textarea name="adminArray[google_aftersales]" type="text" class="ppt-forminput"  style="width:350px;height:40px;"><?php echo stripslashes(get_option("google_aftersales")); ?></textarea>
 
</fieldset>


</div>

<div class="grid400-left last">





<fieldset><div class="titleh"> <h3>Verification Code</h3></div>
<p>To verify your website enter your meta string opposite.</p>
 
<textarea name="adminArray[google_webmaster_code]" type="text" class="ppt-forminput"  style="width:350px;height:40px;"><?php echo stripslashes(get_option("google_webmaster_code")); ?></textarea>
<br />
<p class="ppnote" >Google Webmaster Tools provides you with detailed reports about your pages' visibility on Google.</p>
<p class="ppnote1" >If you don't have an account with Google Webmaster Tools you can signup here: <a href="http://www.google.com/webmasters/tools/" target="_blank">http://www.google.com/webmasters/tools/</a></p>
</fieldset>

<fieldset><div class="titleh"> <h3>Adsense Tracking Code</h3></div>

<p>Copy/paste your Adsense javascript code opposite.</p>
<textarea name="adminArray[google_adsensetracking_code]" type="text" class="ppt-forminput" style="width:350px;height:80px;"><?php echo stripslashes(get_option("google_adsensetracking_code")); ?></textarea>
 
			<br />
			 
<p class="ppnote" >Google AdSense is a free program that enables website publishers of all sizes to display relevant Google ads and earn.</p>
<p class="ppnote1" >If you don't have a Google adsense account you can create one here: <a href="https://www.google.com/adsense/" target="_blank">https://www.google.com/adsense/</a></p>

</fieldset>

</div>

 <div class="clearfix"></div>
 
 <div class="savebarb clear">
 
 <input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" />
 
 <a class="premiumpress_button" href="javascript:void(0);" onclick="PPHelpMe()" style="float:right;"><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/youtube.png" align="middle" style="margin-top:-10px;"> Help Me</a>
 
 </div>
 
</div>

           
					 
</form>
                      
</div>
</div>
<div class="clearfix"></div>   