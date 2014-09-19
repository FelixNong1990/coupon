<?php global $PPT, $PPTImport;

if(get_option('icodes_country') == "http://webservices.icodes.co.uk/ws2.php"){

$GLOBALS['ICODESCATS'] = array(
"41" =>"Adult_and_Dating",
"3" =>"Baby_and_Toddler",
"4" =>"Books_and_Magazines",
"5" =>"Business",
"6" =>"CDs_and_DVDs",
"42" =>"Charities",
"7" =>"Clothing_and_Footwear",
"38" =>"Competitions",
"8" =>"Computers_and_Internet",
"46" =>"Daily_Deals",
"9" =>"DIY_and_Tools",
"45" =>"Education",
"10" =>"Electronics_and_Appliances",
"11" =>"Experience_Days",
"12" =>"Finance_and_Insurance",
"13" =>"Flights_and_Cruises",
"14" =>"Flowers",
"15" =>"Food_and_Drink",
"16" =>"Gambling",
"17" =>"Games_and_Consoles",
"18" =>"Gifts_and_Gadgets",
"19" =>"Health_and_Beauty",
"20" =>"Hobbies_and_Collectables",
"39" =>"Holidays_Abroad",
"21" =>"Home_and_Garden",
"22" =>"Hotels_and_Accommodation",
"23" =>"Jewellery_and_Accessories",
"40" =>"Lingerie_and_Underwear",
"24" =>"Mobile_Phones",
"25" =>"Motoring",
"43" =>"Music",
"26" =>"Pets",
"44" =>"Photo_Printing",
"27" =>"Rent_and_Hire",
"28" =>"Services",
"29" =>"Shopping",
"30" =>"Sound_and_Vision",
"31" =>"Special_Occasions",
"32" =>"Sports_and_Leisure",
"33" =>"Tickets",
"34" =>"Toys_and_Games",
"35" =>"Travel",
"36" =>"UK_Holidays",
"0" =>"Uncategorized");

}else{ 

$GLOBALS['ICODESCATS'] = array(
"28" =>"Adult_and_Dating",
"2" =>"Apparel",
"48" =>"Arts and Crafts",
"53" =>"Auctions",
"17" =>"Automotive",
"5" =>"Baby and Toddler",
"7" =>"Books and Magazines",
"1" =>"Cell Phones", 
"54" =>"Charities",
"9" =>"Computers and Software",
"58" =>"Daily Deals",
"11" =>"Department Stores", 
"36" =>"Education and Careers",
"29" =>"Electronics and Gadgets",
"39" =>"Event Tickets", 
"57" =>"Fashion",
"22" =>"Finance",
"42" =>"Food and Drink",
"37" =>"Footwear",
"24" =>"Gambling and Bingo",
"14" =>"Gifts and Flowers",
"19" =>"Health and Beauty",
"55" =>"Hobbies and Collectibles",
"18" =>"Home and Furniture",
"26" =>"Home Entertainment",
"23" =>"Insurance",
"4" =>"Jewelry and Accessories",
"6" =>"Kitchen and Appliances",
"30" =>"Lingerie and Underwear",
"44" =>"Luggage and Bags",
"8" =>"Movies and Music",
"34" =>"Musical Instruments",
"10" =>"Office Supplies",
"47" =>"Online Services",
"31" =>"Party Supplies",
"12" =>"Pet Supplies",
"25" =>"Photography and Photos",
"50" =>"Special Occasions",
"15" =>"Sports and Recreation",
"46" =>"Tools and Hardware",
"35" =>"Toys and Games",
"20" =>"Travel and Vacations",
"52" =>"Uncategorised",
"21" =>"Video Gaming",
"3" =>"Yard and Garden"

);

 
} 

 function GetDataMe($QueryString, $httpRequest="CURL"){
 
	if($httpRequest == "CURL"){
	
		$ch = curl_init();
		$timeout = 0;  
		curl_setopt ($ch, CURLOPT_URL, $QueryString);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$xml_raw  = curl_exec($ch);
		$xml = simplexml_load_string($xml_raw);
		curl_close($ch);
	
	}
	else{
	
		$xml = simplexml_load_file($QueryString);
	
	}

	return $xml;
}

if(isset($_GET['testfeedlink'])){

die("<h1>Feed Test</h1><p>Click the link below to see the query that will be imported every 24 hours.</p><p><a href='".$PPTImport->ICODESIMPORT('hourly',true)."' target='_blank'>".$PPTImport->ICODESIMPORT('hourly',true)."</a></p>");
 

}




/********************************* COUPONPRESS SPECIAL OPTIONS *************************/


if(isset($_POST['featuredstores']) && is_array($_POST['featured_stores']) ){	 

	update_option("featured_stores",$_POST['featured_stores']);	

}


if(isset($_POST['icodes_update_categorylist']) && $_POST['adminArray']['icodes_subscription_username'] != ""){

global $PPTImport;

	$QueryString  = $_POST['adminArray']['icodes_country']."?";
	$QueryString .= "UserName=".$_POST['adminArray']['icodes_subscription_username'];
	$QueryString .= "&SubscriptionID=".$_POST['adminArray']['icodes_subscriptionID'];
	$QueryString .= "&RequestType=CategoryList";
	
	$xml = $PPTImport->GetIcodesData($QueryString,$_POST['adminArray']['icodes_importtype']);
	
	$c=0; $total_items = 0; $categorylist = array();
	$total_items += trim($xml->Results);
	$message1 = trim($xml->Message);
	if($message1==''){
		foreach ($xml->item as $item) {	
	 
			$categorylist[$c]['id'] 	= str_replace("","",$item->id);
			$categorylist[$c]['name'] 	= str_replace("","",$item->category);			 
			$c++;
		}
	}else{ die("<h1>Category List Update Failed</h1><p>".$xml->Message."</p><p>".$QueryString."</p>");}	
	
	update_option("icodes_categorylist",$categorylist);	
	 
}


if(isset($_POST['icodes_update_networklist'])  && $_POST['adminArray']['icodes_subscription_username'] != ""){
 
 /*
	$QueryString  = $_POST['adminArray']['icodes_country']."?";
	$QueryString .= "UserName=".$_POST['adminArray']['icodes_subscription_username'];
	$QueryString .= "&SubscriptionID=".$_POST['adminArray']['icodes_subscriptionID'];
	$QueryString .= "&RequestType=NetworkList";
	$xml = $PPTImport->GetIcodesData($QueryString,$_POST['adminArray']['icodes_importtype']);

	$c=0; $categorylist = array();
	$total_items += trim($xml->Results);
	$message1 = trim($xml->Message);
	if($message1==''){
		foreach ($xml->item as $item) {	
	  
			$categorylist[$c]['id'] 	= str_replace("","",$item->id);
			$categorylist[$c]['name'] 	= str_replace("","",$item->network);
			 
			$c++;
		}
	}else{ die("<h1>Network List Update Failed</h1><p>".$xml->Message."</p><p>".$QueryString."</p>");}	
	
 
	update_option("icodes_networklist",$categorylist);	*/
}

if(isset($_POST['icodes_update_merchantlist'])  && $_POST['adminArray']['icodes_subscription_username'] != "" ){
 
	$QueryString  = $_POST['adminArray']['icodes_country']."?";
	$QueryString .= "UserName=".$_POST['adminArray']['icodes_subscription_username'];
	$QueryString .= "&SubscriptionID=".$_POST['adminArray']['icodes_subscriptionID'];
	$QueryString .= "&RequestType=MerchantList&Action=Full&Relationship=Joined".get_option("icodes_Relationship");
  
	$xml = $PPTImport->GetIcodesData($QueryString,$_POST['adminArray']['icodes_importtype']);
 
	$c=0; $categorylist = array();
	$total_items += trim($xml->Results);
	$message1 = trim($xml->Message);
	if($message1==''){
		foreach ($xml->item as $item) {
		 
	   //die(print_r($item));
			$categorylist[$c]['id'] 			= str_replace("","",$item->icid);
			$categorylist[$c]['name_merchant'] 	= str_replace("","",$item->merchant);
			$categorylist[$c]['mid'] 	= str_replace("","",$item->merchant_id);
			
			//$a = wp_insert_term($categorylist[$c]['name_merchant'], "store", "" );
		
			//$categorylist[$c]['name'] 			= str_replace("","",$item->network);
			//$categorylist[$c]['category'] 		= str_replace("","",$item->category);
			//$categorylist[$c]['logo'] 			= str_replace("","",$item->merchant_logo_url);
					 
			$c++;
		}
	}else{ die("<h1>Merchant List Update Failed</h1><p>".$xml->Message."</p><p>".$QueryString."</p>");}	

	update_option("icodes_merchantlist",$categorylist);	 
	
	 
}

if(isset($_POST['icodes_save_me'])){

	$cList = get_option("icodes_savelist");
	update_option("icodes_savelist",""); 
	if(is_array($cList)){ $d= count($cList); }else{ $d=0; }

	$cList[$d]['ID'] 			= $d;	
	$cList[$d]['RequestType'] 	= $_POST['icodes_s_1'];
	$cList[$d]['Action'] 		= $_POST['icodes_s_2'];
	$cList[$d]['ActionID'] 		= $_POST['icodes_s_3'];
	$cList[$d]['Sort'] 			= $_POST['icodes_s_4'];	
	$cList[$d]['Map'] 			= $_POST['icodes_s_5'];	
	$cList[$d]['Time'] 			= $_POST['icodes_s_6'];	
	$cList[$d]['Page'] 			= 1;	
	$cList[$d]['PageSize'] 		= 10;	
	$cList[$d]['PageTotal'] 	= 0;
	$cList[$d]['CountGood'] 	= 0; 
	$cList[$d]['CountBad'] 		= 0;
			
	update_option("icodes_savelist",$cList);	
	
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "iCodes Scheduled Search Saved Successfully";
}

function pptreindex_array($src) {

	if(!is_array($src)){ return; }

    $dest = array();
	$i=0; 
    foreach ($src as $value) {
        if (is_array($value)) {
		
			foreach ($value as $k => $v) {
				if($k == "ID"){
					$dest[$i][$k] = $i;
				}else{
					$dest[$i][$k] = $v;
				}			 
			}         
		   
		$i++;   
        }		
    }

    return $dest;
}

if(isset($_GET['icodes_s_del']) && !isset($_POST['icodes_save_me']) ){

$c=0;
 	$cff = get_option("icodes_savelist");
 	update_option("icodes_savelist",""); 
	foreach($cff as $key=> $d){
	
		if($_GET['icodes_s_del'] != $d['ID']){
	
		$cList[$c]['ID'] 			= $d['ID'];	
		$cList[$c]['RequestType'] 	= $d['RequestType'];
		$cList[$c]['Action'] 		= $d['Action'];
		$cList[$c]['ActionID'] 		= $d['ActionID'];
		$cList[$c]['Sort'] 			= $d['Sort'];	
		$cList[$c]['Map'] 			= $d['Map'];	
		$cList[$c]['Time'] 			= $d['Time'];	
		$cList[$c]['CountGood'] 	= $d['CountGood'];
		$cList[$c]['CountBad'] 		= $d['CountBad'];
		$cList[$c]['Page'] 			= $d['Page'];
		$cList[$c]['PageSize'] 		= $d['PageSize'];
		$cList[$c]['PageTotal'] 	= $d['PageTotal'];
		$c++;				
		}
	
	}
	
	$cList = pptreindex_array($cList);
	
	update_option("icodes_savelist",$cList);
	
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "iCodes Scheduled Search Deleted";
}

if(isset($_GET['icodes_run'])){

	$num = $PPTImport->ICODESIMPORT($_GET['icodes_run']);
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "info"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "This test imported ".$num." coupons.";
}

if(isset($_GET['icodes_debug'])){

	$PPTImport->ICODESIMPORT($_GET['icodes_run'],true);
 
}

 




PremiumPress_Header(); 

 
if(isset($_POST['autoimportsetup'])  ){

$icodesMapList = array();
$catlist = $GLOBALS['ICODESCATS'];

if(!is_array($catlist)){ $catlist = array(); }
$i=0; foreach($catlist as $val){
$icodesMapList[$_POST['icodesMapCat'.$i]]['catID'] = $_POST['mapCat'][$i];
$i++;
}
 
update_option('icodes_autoimport_cats',$icodesMapList);

$a = (int)trim($_POST['icodes_autoimport_coupons']);
update_option('icodes_autoimport_coupons',$a);
$b = (int)trim($_POST['icodes_autoimport_offers']);
update_option('icodes_autoimport_offers',$b);
}
 

if(isset($_POST['icodes_quicksetup_import']) && $_POST['icodes_quicksetup_import'] == 1){
update_option('icodesBasicImport1','');
update_option('icodesBasicImport2','');
update_option('icodesBasicImport3','');
}

if(isset($_GET['deleteallsaved']) && $_GET['deleteallsaved'] ==1){
update_option('icodes_savelist','');
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "iCodes Scheduled Search Deleted Successfully";
}

 
?>
 
 





























<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100" <?php if(isset($_POST['startsearch']) || isset($_POST['formetocoupon']) ){ echo 'style="display:none;"'; } ?>><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/new/block7.png" align="middle"> Import Coupons</h3> <a class="premiumpress_button" href="javascript:void(0);" onclick="PPHelpMe()"><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/youtube.png" align="middle" style="margin-top:-10px;"> Help Me</a> 							 
<ul>
	<li><a rel="premiumpress_tab1" href="#" class="active">iCodes Search</a></li>

</ul>
</div>


<div id="premiumpress_tab1" class="content">


<div class="grid400-left">


<?php if(strlen(get_option("icodes_subscriptionID")) > 5){  ?> 


<?php $ff = explode("wp-content",TEMPLATEPATH); ?>
<form method="post" target="upload_target" action="<?php echo get_template_directory_uri(); ?>/admin/importtools/_icode_results.php" onSubmit="jQuery('#searchresultsform').show();window.frames['upload_target'].document.body.innerHTML='<br>Loading results, please wait...';">
<input type="hidden" name="start_page" value="1" />
<input type="hidden" name="icodes" value="1" />
<input name="display_coupons" type="hidden" value="1" />
<input type="hidden" name="feed_path" value="<?php echo $ff[0]; ?>">
<input type="hidden" name="web_path" value="<?php echo PPT_THEME_URI; ?>">
<fieldset>
<div class="titleh"> <h3>Quick Coupon Search</h3></div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Keyword</span>
<input name="keyword" value="" type="text" class="ppt-forminput" style="background:#D9F9D8">
<div class="clearfix"></div>
</div>

 

<div id="icodes122" style="display:none;">

<div class="ppt-form-line">	
<span class="ppt-labeltext">Search</span>
<select class="ppt-forminput" name="display_stype"><option value="Codes">Coupons</option><option value="Offers">Offers</option><option value="PrintableVouchers">Printable Vouchers</option></select>
<div class="clearfix"></div>
</div> 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Category</span>
<select class="ppt-forminput" name="i_category">
<option value="all" selected>All Categories</option>  
<?php $catlist = get_option("icodes_categorylist"); foreach($catlist as $cat){	print '<option value="'.$cat['id'].'">'.str_replace("_"," ",$cat['name']).'</option>';	}?>
</select>		 
    
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Order Results By</span>
 <select name="orderby" class="ppt-forminput">
            <option value="start_date">Start Date</option>
            <option value="expiry_date">Expiry Date</option>
            <option value="max_start_date">Max Start Date</option>
            <option value="min_expiry_date">Min Expiry Date</option>
            <option value="id">iCodes Coupon ID</option>                   
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<p>Import Select Coupons In this Category;</p>

<select name="cat[]" multiple="multiple" style="width:350px;">
<?php echo premiumpress_categorylist("1",false,false,"category",0,true); ?></select>
<div class="clearfix"></div>
</div>

</div> 
<a href="javascript:void(0);" onclick="toggleLayer('icodes122');" class="ppt_layout_showme" style="float:right;">Show/Hide Options</a>

<p><input class="premiumpress_button" type="submit" value="Start Search" style="color:white;" /></p>
</fieldset> 
</form>



<fieldset>
<div class="titleh"> <h3>iCodes Mass Import</h3></div>
<div id="icodes5" style="display:none;">
<div class="ppt-form-line">	
<b>Import Categories &amp; Coupons</b> <span style="background-color:#cbf6ad">*CATEGORY SETUP*</span><br />
<p>This option will import all categories from your iCodes account then import all coupons into each category.</p>
<a href="#" onclick="document.getElementById('dome').value='1';jQuery('#searchresultsform').show();window.frames['upload_target'].document.body.innerHTML='<br>Loading results, please wait...';document.icodesmassimport.submit();alert('Please Note, The import process can take a few minnutes to start whilst it gets the coupons from your iCodes account. Please be patience.');">Run Import Tool Now</a> 
</div>

<div class="ppt-form-line">	
<b>Import Categories &amp; Offers</b> <span style="background-color:#cbf6ad">*CATEGORY SETUP*</span><br />
<p>This option will import all categories from your iCodes account then import all offers into each category.</p>
<a onclick="document.getElementById('dome').value='3';jQuery('#searchresultsform').show();window.frames['upload_target'].document.body.innerHTML='<br>Loading results, please wait...';document.icodesmassimport.submit();alert('Please Note, The import process can take a few minnutes to start whilst it gets the coupons from your iCodes account. Please be patience.');">Run Import Tool Now</a> 
</div>

<div class="ppt-form-line">	
<b>Import Merchants &amp; Coupons</b> <span style="background-color:yellow">*STORE SETUP*</span><br />
<p>This option will import all merchants from your iCodes account as stores then import all coupons into each store.</p>
<a onclick="document.getElementById('dome').value='2';jQuery('#searchresultsform').show();window.frames['upload_target'].document.body.innerHTML='<br>Loading results, please wait...';document.icodesmassimport.submit();alert('Please Note, The import process can take a few minnutes to start whilst it gets the coupons from your iCodes account. Please be patience.');" >Run Import Tool Now</a> 
</div>

<div class="ppt-form-line">	
<b>Import Merchants &amp; Offers</b> <span style="background-color:yellow">*STORE SETUP*</span><br />
<p>This option will import all merchants from your iCodes account as stores then import all offers into each stores.</p>
 <a onclick="document.getElementById('dome').value='4';jQuery('#searchresultsform').show();window.frames['upload_target'].document.body.innerHTML='<br>Loading results, please wait...';document.icodesmassimport.submit();alert('Please Note, The import process can take a few minnutes to start whilst it gets the coupons from your iCodes account. Please be patience.');">Run Import Tool Now</a> 
</div>
 </div>
<a href="javascript:void(0);" onclick="toggleLayer('icodes5');" class="ppt_layout_showme">Show/Hide Options</a>

</fieldset>



<fieldset>
<div class="titleh"> <h3>iCodes Automatic Import Settings</h3></div>

<div style="display:none;" id="icodes3"> 

<form method="post" target="_self" name="autod" id="autod">
<input name="submitted" type="hidden" value="yes" />
<input name="autoimportsetup" type="hidden" value="yes" />

<div class="ppt-form-line">	
<input name="icodes_autoimport_coupons" type="checkbox" value="1" <?php if(get_option("icodes_autoimport_coupons") == "1"){ ?>checked="checked"<?php } ?> /> 
<b>Automatically Import New Coupons (24 Hour Period)</b> <br />
<small>Tick this box to auto import new coupons every 24 hours. <a href="admin.php?page=import&testfeedlink=1">Click This link to preview the icodes feed.</a></small>
<div class="clearfix"></div>
</div>
<div class="ppt-form-line">	

<input name="icodes_autoimport_offers" type="checkbox" value="1" <?php if(get_option("icodes_autoimport_offers") == "1"){ ?>checked="checked"<?php } ?> /> <b>Automatically Import New Offers (24 Hour Period)</b> <br />
<small>Tick this box to auto import new coupons every 24 hours. <a href="admin.php?page=import&testfeedlink=2">Click This link to preview the icodes feed.</a></small>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">
<b>Configure Your imported Categories</b>
<p class="pptnote">Choose which iCodes categories import to your website categories;</p>
<?php 





$savedcatlist = get_option('icodes_autoimport_cats');

$websitecatlist = premiumpress_categorylist("",false,false,"category",0,true);
$a=0;


?>
<table width="100%" border="0">
<?php  foreach($GLOBALS['ICODESCATS'] as $id=>$name){ ?>
<tr><td>
<input type="hidden" name="icodesMapCat<?php echo $a;?>" value="<?php echo $id; ?>">
<?php echo str_replace("_"," ",$name); ?></select>	
    </td><td>= 
</td><td>
<select name="mapCat[]" class="ppt-forminput" style="width:150px;">
<?php echo str_replace('"'.$savedcatlist[$id]['catID'].'"','"'.$savedcatlist[$id]['catID'].'" selected=selected',$websitecatlist); ?></select>
</td></tr>
<?php $a++; } ?>
</table>



<div class="clearfix"></div>
</div>


<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" /></p>



</form>
</div>
<a href="javascript:void(0);" onclick="toggleLayer('icodes3');" class="ppt_layout_showme">Show/Hide Options</a>
</fieldset>


<?php } ?> 






<fieldset>
<div class="titleh"> <h3>iCodes Account Settings</h3></div>

<div style="display:none;" id="icodes1"> 
<form method="post" target="_self">
<input name="submitted" type="hidden" value="yes" />

<div class="ppt-form-line">	
<span class="ppt-labeltext">iCodes Country</span>
<select name="adminArray[icodes_country]" class="ppt-forminput">
<option value="http://webservices.icodes.co.uk/ws2.php"> iCodes UK Database</option>
 <option value="http://webservices.icodes-us.com/ws2_us.php" <?php if(get_option("icodes_country") == "http://webservices.icodes-us.com/ws2_us.php"){ echo 'selected'; } ?>> iCodes USA Database</option>
</select>
<div class="clearfix"></div>

<div style="margin-left:140px; font-size:11px;">Website Links: <a href="http://icodes.co.uk/?source=couponpress-theme" target="_blank">iCodes UK</a> | <a href="http://www.icodes-us.com/?source=couponpress-theme" target="_blank">iCodes USA</a></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Subscription ID</span>
<input name="adminArray[icodes_subscriptionID]" type="text" value="<?php echo get_option("icodes_subscriptionID"); ?>" class="ppt-forminput"> 
<br /><small>Your icodes subscription ID. eg 67d96d458abdef21792e6d8e590244eXXX</small>
<div class="clearfix"></div>
</div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Subscription Username</span>
<input name="adminArray[icodes_subscription_username]" type="text" value="<?php echo get_option("icodes_subscription_username"); ?>" class="ppt-forminput">
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Search Type</span>
<select name="adminArray[icodes_importtype]" class="ppt-forminput">
<option value="url" <?php if(get_option("icodes_importtype") == "url"){ echo 'selected'; } ?>>URL Search (Recommended)</option>   
<option value="CURL" <?php if(get_option("icodes_importtype") == "CURL"){ echo 'selected'; } ?>>cURL Search (Requires cURL Installed on your server) </option>
                
</select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">RelationShip</span>
<select name="adminArray[icodes_Relationship]" class="ppt-forminput">
<option value="&Relationship=joined">Only Joined Merchants (recommended)</option>
<option value="" <?php if(get_option("icodes_Relationship") == ""){ echo 'selected'; } ?>> All </option>
</select>
<div class="clearfix"></div>
</div>
 

<div class="ppt-form-line">	
<span class="ppt-labeltext">Default Import Status</span>
<select name="adminArray[icodes_import_status]" class="ppt-forminput">
<option value="publish"> Published</option>
<option value="draft" <?php if(get_option("icodes_import_status") == "draft"){ echo 'selected'; } ?>> Draft</option>
</select> 
<div class="clearfix"></div>
</div>
 
 
<input name="icodes_update_categorylist" type="hidden" value="1" /> 
<input name="icodes_update_networklist" type="hidden" value="1" />  
<input name="icodes_update_merchantlist" type="hidden" value="1" /> 

<br /><div class="titleh"> <h3>Coupon Code Layout</h3></div>

<p><b>Customize The Imported Coupon Title</b>

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<p class='ppnote'>[title] [code] [merchant] [url] [starts] [ends]</p><p>[title] at [url] = <u>10% off at couponpress.com</u></p><p>Get [title] with [code] at [url] starting [starts] = <br /><br /> <u>Get 10% off with MYCODE at couponpress.com starting Starting Monday 8th of August 2011 03:12:46 PM</u></p>&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</p>

<textarea style="width:360px; height:80px;" class="ppt-forminput" name="adminArray[icodes_custom_title]"><?php if(get_option("icodes_custom_title") ==""){echo "[title] @ [url]"; }else{ echo stripslashes(get_option("icodes_custom_title")); } ?></textarea>



 

<p><b>Customize The Imported Coupon Description</b>
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<p class='ppnote'>[description] [code] [merchant] [url] [starts] [ends]</p><p>[description] = save XX using this coupon...</p><p>[code] = DSFDS%#$%</p><p>[merchant] = PremiumPress</p><p>[url] = premiumpress.com</p><p>[starts] = Monday 8th of August 2011 03:12:46 PM</p><p>[ends] = Monday 22th of August 2011 06:12:22 PM</p>&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</p>

<textarea style="width:360px; height:80px;" class="ppt-forminput" name="adminArray[icodes_custom_desc]"><?php if(get_option("icodes_custom_desc") ==""){  echo "[description]"; }else{ echo stripslashes(get_option("icodes_custom_desc")); } ?></textarea>
 

<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" /></p>

</form>





</div>
<a href="javascript:void(0);" onclick="toggleLayer('icodes1');" class="ppt_layout_showme">Show/Hide Options</a>

</fieldset>





</div>







<div class="grid400-left last">



<form method="post" target="upload_target" id="icodesmassimport" name="icodesmassimport" action="<?php echo get_template_directory_uri(); ?>/admin/importtools/_icode_results.php">
<input type="hidden" name="start_page" value="1" />
<input type="hidden" name="icodes" value="1" />
<input name="display_coupons" type="hidden" value="1" />
<input type="hidden" name="feed_path" value="<?php echo $ff[0]; ?>">
<input type="hidden" name="web_path" value="<?php echo PPT_THEME_URI; ?>">
<input type="hidden" name="dome" id="dome" value="0" />
</form>

 

<fieldset id="searchresultsform" style="display:none;">
<div class="titleh"> <h3>Search Results</h3></div>
<iframe id="upload_target" name="upload_target" src="<?php echo PPT_THEME_URI; ?>/admin/importtools/index.html" style="width:390px;height:600px;border:0px solid #fff; margin-left:0px;margin-top:10px; "></iframe>
</fieldset>

















</div>

<div class="clearfix"></div> 

</div> 


 
 

 


</div>