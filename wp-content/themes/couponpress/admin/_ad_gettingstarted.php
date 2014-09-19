
<?php if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; }  PremiumPress_Header();  ?>

<div class="premiumpress_box altbox" style="width: 667px;"><div class="premiumpress_boxin">
<div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/support.png" align="middle"> Help &amp; Tutorials </h3>							
</div>

<div style="padding:10px;">

<iframe src="http://www.premiumpress.com/documentation/?theme=<?php echo PREMIUMPRESS_SYSTEM; ?>&version=<?php echo PREMIUMPRESS_VERSION; ?>&date=<?php echo PREMIUMPRESS_VERSION_DATE; ?>&key=<?php echo get_option('license_key'); ?>" name="nWindow" scrolling="no" frameborder="0" width="100%" height="100%" style="min-height:2000px;" marginwidth="1" marginheight="0" align="middle" title="nWindow"></iframe>

</div></div>