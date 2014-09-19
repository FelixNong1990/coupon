<?php
if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $wpdb,$PPT; PremiumPress_Header(); ?>


<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_payment.png" align="middle"> Payments</h3>	 <a class="premiumpress_button" href="javascript:void(0);" onclick="PlayPPTVideo('c1tMJsOLdjI','videobox1');"><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/youtube.png" align="middle" style="margin-top:-10px;"> Help Me</a>							 
<ul>
 
 
</ul>
</div>

<style>
.merchantlogo { margin-top:20px; border: 1px solid #E2E2E2; margin-right:13px;  padding:2px; float:left; background:#fff;  -webkit-box-shadow: 0 0 0px #cccccc; -moz-box-shadow: 0 0 0px #cccccc;  	-webkit-box-shadow: 0 0 0px #ccc;  	box-shadow:0px 0px 15px #ccc; float:right; }
</style>

<div id="premiumpress_tab1" class="content">

<div id="videobox1"></div>

<?php include(str_replace("functions/","",THEME_PATH) . '/PPT/func/func_paymentgateways.php');

 

$gatways = premiumpress_admin_payments_gateways($gatway);

 
$i=1;$p=1; if(is_array($gatways)){foreach($gatways as $Value){ ?>



<fieldset style="width:380px; float:left; <?php if($i%2){ ?>margin-right:20px;<?php } ?>">

<div class="titleh">
<?php if(get_option($Value['function']) =="yes"){ ?>
<span style="color:red; float:right; margin-top:10px; margin-right:20px;"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/star.png" align="middle" style="float:left; padding-right:10px;"> Enabled </span>
<?php } ?>

<h3><?php echo $Value['name'] ?></h3> 
 

</div>

<?php if(strpos($Value['logo'], "http") === false){ ?>
<img src="<?php echo PPT_FW_IMG_URI; ?>admin/new/logo/<?php echo $Value['logo'] ?>"  class="merchantlogo ">
<?php }else{ ?>
<img src="<?php echo $Value['logo'] ?>"  class="merchantlogo " style="max-width:140px; max-height:60px;">
<?php } ?>



  
 
 
 <?php if(strlen($Value['website']) > 0){ ?><p>Merchant Website: <a href="<?php echo $Value['website']; ?>" target="_blank"><?php echo $Value['website']; ?></a></p><?php } ?>
 <!--<p>Includes Callback: <img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/<?php echo $Value['callback']; ?>.png" /></p>-->

 <form method="post"  target="_self" style="display:none;" id="g_<?php echo $i ?>">
<input name="submitted" type="hidden" value="yes" />
<?php foreach($Value['fields'] as $key => $field){ 

if(!isset($field['list'])){ $field['list'] = ""; }
if(!isset($field['default'])){ $field['default'] =""; }

   ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext"><?php echo $field['name'] ?></span>	 
<?php echo MakeField($field['type'], $field['fieldname'],get_option($field['fieldname']),$field['list'], $field['default']) ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" />	
</form> 

<a href="javascript:void(0);" onclick="toggleLayer('g_<?php echo $i ?>');" class="ppt_layout_showme">Show/Hide Options</a>


</fieldset>   
    
    
    
    
 
        
 <?php $i++; } }  ?>  


<?php  ?>		 

</div>                    
<div class="clearfix"></div> 
</div>
<div class="clearfix"></div>



 
