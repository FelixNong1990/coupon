<?php

if(isset($_POST['icodes'])){

require( $_POST['feed_path'].'/wp-config.php' );
 
global $wpdb;

 if(isset($_POST['dome']) && $_POST['dome'] == "1"){
 


	ob_implicit_flush();

	$ctype = get_option('icodes_importtype');  $loopCounter=0;
	
	print "<div class='titleh'>";
	
	print "<h3>Connecting to your icodes account.....</h3>";
	
	echo "<p>Creating a categrory for each of your icodes categories</p>";
 
		
	$catlist = get_option('icodes_categorylist');
	
 $ParentcatID=0;
 
	if(is_array($catlist)){
	
		foreach($catlist as $cat){ 
	
		
		$count =1; $pagec=0;
		
		 if ( is_term( $cat['name'] , 'category' ) ){
			 echo "Skipping category creation, <b>".str_replace("_"," ",$cat['name'])."</b> already exists...<br>";
			 $term = get_term_by('name', str_replace("_"," ",$cat['name']), 'category');
			 $ThisCatID = $term->term_id;
		 }else{
			$ThisCatID = wp_create_category1(str_replace("_"," ",$cat['name']), $ParentcatID);
			echo "Creating new category <b>".str_replace("_"," ",$cat['name'])."</b>...<br>";	
		 
		 }
		 
		// NOW LETS CHECK FOR COUPONS FOR THIS CATEGORY
		$QueryString  = get_option('icodes_country')."?";
		$QueryString .= "UserName=".get_option('icodes_subscription_username');
		$QueryString .= "&SubscriptionID=".get_option('icodes_subscriptionID');
		$QueryString .= "&RequestType=Codes&Action=Category";
		$QueryString .= "&Query=".$cat['id'].get_option("icodes_Relationship")."&Page=0&PageSize=10";
	 
		echo "<br /><div style='font-size:10px; background:#efefef; border:1px solid #ddd;padding:5px;'>Building iCodes Query - <a href='".$QueryString."' target='_blank'>click here to test</a></div>";
 
 		echo "<div style=' margin-top:10px; margin-bottom:10px;'>";
		
		 
		//loop until all pages are found
		while($count < 100){ // 10 is a falback 
				 
			$ff = $pagec+1;
			$QueryString = str_replace("Page=".$pagec,"Page=".$ff,$QueryString);		
			$xml = $PPTImport->GetIcodesData($QueryString,$ctype);
			$pagec = $ff;
		 
			 // START THE COUPON IMPORT PROCESS 
			$counterA=0; $counterB=0;  
			$total_items += trim($xml->Results);
			$message1 = trim($xml->Message);
			if($message1==''){
				foreach ($xml->item as $item) { 
							 
					if($PPTImport->ICODESADDCOUPON($item,$ThisCatID,'Codes')){$counterA++;}else{ $counterB++;}
				}				
				if($counterA > 0){
				echo "Added ".$counterA." coupons";
				}
				if($counterB > 0){
				 echo "Updated ".$counterB." coupons";
				}
				
				echo " from iCodes feed (page ".$pagec." of ".$xml->TotalPages.") <br />"; 
				 
				// increment the page counter
				if($pagec >= $xml->TotalPages){
					$count=100; 
				} 
				
			}else{
				$count=100;
				echo "&nbsp;0 coupons found for this category <br />";
			}
			
			  
			$count++;		 
		}
		echo '</div><hr />';
		 
		ob_flush();   
    	flush(); 	
		sleep(1);
		
		//if($loopCounter > 1){die();} $loopCounter++;
		}
	
	}
 
	
	// SETUP THE AUTO IMPORT TOOL
	$icodesAutoSetup = array('enabled'=>'yes', "date"=>date('Y-m-d H:i:s'));
	update_option("icodesBasicImport1",$icodesAutoSetup);
	

}elseif(isset($_POST['dome']) && $_POST['dome'] == "2"){ // merchant import

	ob_implicit_flush();

	$ctype = get_option('icodes_importtype');  $loopCounter=0;
	
	print "<div class='titleh'>";
	
	print "<h3>Connecting to your icodes account.....</h3>";
	
	echo "<p>Creating a categrory for each of your icodes merchants</p>";
	
	$catlist = get_option('icodes_merchantlist'); 
	
	if($catlist == ""){ echo "<b style='color:red;'>Your merchant list is empty, click on the 'Icodes Subscription Settings' tab and update the merchants list.</b>"; } 
	
	// CREATE A PARENT ACCOUNT TO KEEP THEM ALL IN
	$ParentcatID=0;
 
	
	if(is_array($catlist)){
	
		foreach($catlist as $cat){
		
		$count =1; $pagec=0;
		
		 if ( is_term( $cat['name_merchant'] , 'store' ) ){
			 echo "Skipping store creation, <b>".$cat['name_merchant']."</b> already exists...<br>";
			 $term = get_term_by('name', $cat['name_merchant'], 'store');
			 $ThisCatID = $term->term_id;
		 }else{
		 
			$args = array('cat_name' => str_replace("_"," ",$cat['name_merchant']) ); 
			$term = wp_insert_term( str_replace("_"," ",$cat['name_merchant']), 'store', $args);
			$storeID = $term->term_id;
			 
			echo "Creating new store <b>".$cat['name_merchant']."</b>...<br>";	
		 
		 }
		 
		// NOW LETS CHECK FOR COUPONS FOR THIS CATEGORY
		$QueryString  = get_option('icodes_country')."?";
		$QueryString .= "UserName=".get_option('icodes_subscription_username');
		$QueryString .= "&SubscriptionID=".get_option('icodes_subscriptionID');
		$QueryString .= "&RequestType=Codes&Action=Merchant";
		$QueryString .= "&Query=".$cat['name_merchant'].get_option("icodes_Relationship")."&Page=0&PageSize=10";
	 
 
		echo "<br /><div style='font-size:10px; background:#efefef; border:1px solid #ddd;padding:5px;'>Building iCodes Query - <a href='".$QueryString."' target='_blank'>click here to test</a></div>";
 
 		echo "<div style=' margin-top:10px; margin-bottom:10px;'>";
		
		  
		//loop until all pages are found
		while($count < 100){ // 10 is a falback 
			
			$ff = $pagec+1;
			$QueryString = str_replace("Page=".$pagec,"Page=".$ff,$QueryString);		
			$xml = $PPTImport->GetIcodesData($QueryString,$ctype);
			$pagec = $ff;
		  
			 // START THE COUPON IMPORT PROCESS 
			$counterA=0; $counterB=0;  
			$total_items += trim($xml->Results);
			$message1 = trim($xml->Message);
			if($message1==''){
				foreach ($xml->item as $item) {
				
				
							 
					if($PPTImport->ICODESADDCOUPON($item,$ThisCatID,'Codes')){$counterA++;}else{ $counterB++;}
				}				
				if($counterA > 0){
				echo "Added ".$counterA." coupons";
				}
				if($counterB > 0){
				 echo "Updated ".$counterB." coupons";
				}
				
				echo " from iCodes feed (page ".$pagec." of ".$xml->TotalPages.")  <br />"; 
				 
				// increment the page counter
				if($pagec >= $xml->TotalPages){
					$count=100; 
				} 
				
			}else{
				$count=100;
				echo "&nbsp;0 coupons found for this merchant <br />";
			}
			
			  
			$count++;		 
		}
		echo '</div><hr />';
		 
		ob_flush();   
    	flush(); 	
		sleep(1);
		
		//if($loopCounter > 1){ $catlist=""; } $loopCounter++;
		}
	
	}
 
	
	// SETUP THE AUTO IMPORT TOOL
	$icodesAutoSetup = array('enabled'=>'yes', "date"=>date('Y-m-d H:i:s'));
	update_option("icodesBasicImport2",$icodesAutoSetup);
 
	

}elseif(isset($_POST['dome']) && $_POST['dome'] == "3"){

	ob_implicit_flush();

	$ctype = get_option('icodes_importtype');  $loopCounter=0; $newcatlist = get_option('icodes_autoimport_cats');
	 
	print "<div class='titleh'>";
	
	print "<h3>Connecting to your icodes account.....</h3>";
	
	echo "<p>Creating a categrory for each of your icodes categories</p>";
	
	$catlist = get_option('icodes_categorylist');
	
	$ParentcatID = 0; 
	if(is_array($catlist)){
	
		foreach($catlist as $cat){
		
		$count =1; $pagec=0;
		
		 if ( is_term( $cat['name'] , 'category' ) ){
			 echo "Skipping category creation, <b>".$cat['name']."</b> already exists...<br>";
			 $term = get_term_by('name', str_replace("_"," ",$cat['name']), 'category');
			 $ThisCatID = $term->term_id;
		 }else{
			$ThisCatID = wp_create_category1(str_replace("_"," ",$cat['name']), $ParentcatID);
			echo "Creating new category <b>".str_replace("_"," ",$cat['name'])."</b>...<br>";	
		 
		 }
		 
		// NOW LETS CHECK FOR COUPONS FOR THIS CATEGORY
		$QueryString  = get_option('icodes_country')."?";
		$QueryString .= "UserName=".get_option('icodes_subscription_username');
		$QueryString .= "&SubscriptionID=".get_option('icodes_subscriptionID');
		$QueryString .= "&RequestType=Offers&Action=Category";
		$QueryString .= "&Query=".$cat['id'].get_option("icodes_Relationship")."&Page=0&PageSize=10";
 
		echo "<br /><div style='font-size:10px; background:#efefef; border:1px solid #ddd;padding:5px;'>Building iCodes Query - <a href='".$QueryString."' target='_blank'>click here to test</a></div>";
 
 		echo "<div style=' margin-top:10px; margin-bottom:10px;'>";
		
		 
		//loop until all pages are found
		while($count < 100){ // 10 is a falback 
			
			$ff = $pagec+1;
			$QueryString = str_replace("Page=".$pagec,"Page=".$ff,$QueryString);		
			$xml = $PPTImport->GetIcodesData($QueryString,$ctype);
			$pagec = $ff;
		 
			 // START THE COUPON IMPORT PROCESS 
			$counterA=0; $counterB=0;  
			$total_items += trim($xml->Results);
			$message1 = trim($xml->Message);
			if($message1==''){
				foreach ($xml->item as $item) {
				
				$caaID = str_replace("!!asd","",$item->category_id);
				if(isset($newcatlist[$caaID]['catID'])){
				$thisCat = get_category($newcatlist[$caaID]['catID'],false);				
				$item->category = $thisCat->name;
				} 				
				 
				if($PPTImport->ICODESADDCOUPON($item,"setup",'offer')){$counterA++;}else{ $counterB++;}
				
				}				
				if($counterA > 0){
				echo "Added ".$counterA." offers";
				}
				if($counterB > 0){
				 echo "Updated ".$counterB." offers";
				}
				
				echo " from iCodes feed (page ".$pagec." of ".$xml->TotalPages.") <br />"; 
				 
				// increment the page counter
				if($pagec >= $xml->TotalPages){
					$count=100; 
				} 
				
			}else{
				$count=100;
				echo "&nbsp;0 offers found for this category <br />";
			}
			
			  
			$count++;		 
		}
		echo '</div><hr />';
		 
		ob_flush();   
    	flush(); 	
		sleep(1);
		
		//if($loopCounter > 1){die();} $loopCounter++;
		}
}

 
	
	// SETUP THE AUTO IMPORT TOOL
	$icodesAutoSetup = array('enabled'=>'yes', "date"=>date('Y-m-d H:i:s'));
	update_option("icodesBasicImport3",$icodesAutoSetup);

}elseif(isset($_POST['dome']) && $_POST['dome'] == "4"){

 
	ob_implicit_flush();

	$ctype = get_option('icodes_importtype');  $loopCounter=0; $newcatlist = get_option('icodes_autoimport_cats');
	
	print "<div class='titleh'>";
	
	print "<h3>Connecting to your icodes account.....</h3>";
	
	echo "<p>Creating a categrory for each of your icodes merchants</p>";
	
	$catlist = get_option('icodes_merchantlist');
	
	if($catlist == ""){ echo "<b style='color:red;'>Your merchant list is empty, click on the 'Icodes Subscription Settings' tab and update the merchants list.</b>"; } 
 
	
	if(is_array($catlist)){
	
		foreach($catlist as $cat){
		 
		$count =1; $pagec=0;
		
		 if ( is_term( $cat['name_merchant'] , 'category' ) ){
			 echo "Skipping category creation, <b>".$cat['name_merchant']."</b> already exists...<br>";
			 $term = get_term_by('name', $cat['name_merchant'], 'category');
			 $ThisCatID = $term->term_id;
		 }else{
 			$args = array('cat_name' => str_replace("_"," ",$cat['name_merchant']) ); 
			$term = wp_insert_term( str_replace("_"," ",$cat['name_merchant']), 'store', $args);
			$storeID = $term->term_id;
			echo "Creating new category <b>".$cat['name_merchant']."</b>...<br>";	
		 
		 }
		// print_r($cat);
		// NOW LETS CHECK FOR COUPONS FOR THIS CATEGORY
		$QueryString  = get_option('icodes_country')."?";
		$QueryString .= "UserName=".get_option('icodes_subscription_username');
		$QueryString .= "&SubscriptionID=".get_option('icodes_subscriptionID');
		$QueryString .= "&RequestType=Offers&Action=Merchant";
		$QueryString .= "&Query=".$cat['id'].get_option("icodes_Relationship")."&Page=0&PageSize=10";

		echo "<br /><div style='font-size:10px; background:#efefef; border:1px solid #ddd;padding:5px;'>Building iCodes Query - <a href='".$QueryString."' target='_blank'>click here to test</a></div>";
 
 		echo "<div style=' margin-top:10px; margin-bottom:10px;'>";
		
		  
		//loop until all pages are found
		while($count < 100){ // 10 is a falback 
			
			$ff = $pagec+1;
			$QueryString = str_replace("Page=".$pagec,"Page=".$ff,$QueryString);		
			$xml = $PPTImport->GetIcodesData($QueryString,$ctype);
			$pagec = $ff;
		  
			 // START THE COUPON IMPORT PROCESS 
			$counterA=0; $counterB=0;  
			$total_items += trim($xml->Results);
			$message1 = trim($xml->Message);
			if($message1==''){
			 
				foreach ($xml->item as $item) {
				  
					$caaID = str_replace("!!asd","",$item->category_id);
					if(isset($newcatlist[$caaID]['catID'])){
					$thisCat = get_category($newcatlist[$caaID]['catID'],false);				
					$item->category = $thisCat->name;
					}else{
					$item->category = "";
					}
					 		 
					if($PPTImport->ICODESADDCOUPON($item,"setup",'offer')){$counterA++;}else{ $counterB++;}
				}				
				if($counterA > 0){
				echo "Added ".$counterA." offers";
				}
				if($counterB > 0){
				 echo "Updated ".$counterB." offers";
				}
				
				echo " from iCodes feed (page ".$pagec." of ".$xml->TotalPages.")  <br />"; 
				 
				// increment the page counter
				if($pagec >= $xml->TotalPages){
					$count=100; 
				} 
				
			}else{
				$count=100;
				echo "&nbsp;0 coupons found for this merchant <br />";
			}
			
			  
			$count++;		 
		}
		echo '</div><hr />';
		 
		ob_flush();   
    	flush(); 	
		sleep(1);
		
		//if($loopCounter > 1){ $catlist=""; } $loopCounter++;
		}
	
	}
 
	
	// SETUP THE AUTO IMPORT TOOL
	$icodesAutoSetup = array('enabled'=>'yes', "date"=>date('Y-m-d H:i:s'));
	update_option("icodesBasicImport4",$icodesAutoSetup);

}else{ 
 

require( $_POST['feed_path'].'/wp-config.php' );
 
global $wpdb;
$import_date=time();
$import_date=date('Y-m-d H:i:s',$import_date);

function GetIcodesData($QueryString, $httpRequest="CURL"){

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

function BuildQueryString($data){

	global $wpdb;

	$QueryString  = get_option("icodes_country")."?";
	$QueryString .= "UserName=".get_option("icodes_subscription_username");
	$QueryString .= "&SubscriptionID=".get_option("icodes_subscriptionID").get_option("icodes_Relationship");
	$QueryString .= "&RequestType=".$data['display_stype'];

	if(strlen($data['keyword']) > 1){
	$QueryString .= "&Query=".$data['keyword'];
	$QueryString .= "&Action=Search";
		if($data['i_category'] !="all"){
			$QueryString .= "&NarrowBy=".$data['i_category'];
		}
	}else{	
		if($data['i_category'] !="all"){
		$QueryString .= "&Action=Category&Query=".$data['i_category'];
		}else{
		$QueryString .= "&Action=All";
		}
	}
	 
	if($data['display_coupons'] !=2){
		$QueryString .= "&Page=".$data['start_page']."&PageSize=10"; 
	}else{	
		$QueryString .= "&Page=".$data['start_page']."&PageSize=50";
	}
 
	return $QueryString;
}

function AddCoupon($cc,$cat=0){

 global $wpdb;
 

	 $dataArray = array('id','title','description','merchant','merchant_logo_url','merchant_id','program_id','voucher_code','excode','affiliate_url','merchant_url','icid','mid','network','deep_link','start_date','expiry_date','category','category_id');
	 
	 foreach($dataArray as $key){	 
	 	$code[$key] 		= str_replace("","",$cc->$key);	 
	 } 
 
	// GIVE THE COUPON AN ID TO REFERENCE ID
	$id = $code['icid'];

 $SQL = "SELECT count($wpdb->postmeta.meta_key) AS total
 FROM $wpdb->postmeta
 WHERE $wpdb->postmeta.meta_key='ID' AND $wpdb->postmeta.meta_value = '".$id."'
 LIMIT 1";	
		 
 $result = mysql_query($SQL);			 
 $array = mysql_fetch_assoc($result);
	
 if($array['total'] == 0){
 
 	// GIVE THE COUPON AN ID TO REFERENCE ID
	$id = $code['icid'];
	
	// COUPON WEBSITE URL STRIP HTTPS
	$dd = str_replace("http://","",str_replace("www.","",$code['merchant_url']));
	$dd1 = explode("/",$dd);
 
  			// CREATE THE CUSTOM TITLE AND DESCRIPTION
	$ctitle = stripslashes(get_option("icodes_custom_title"));
	if($ctitle == ""){
		$CUSTOMTITLE = $code['title'];
	}else{	    
		$CUSTOMTITLE = str_replace("[title]",$code['title'],str_replace("[code]",$code['voucher_code'],str_replace("[merchant]",$code['merchant'],str_replace("[url]",$dd1[0],str_replace("[starts]",date('l jS \of F Y h:i:s A',strtotime($code['start_date'])),str_replace("[ends]",date('l jS \of F Y h:i:s A',strtotime($code['expiry_date'])),$ctitle))))));
	}
	$cdesc = stripslashes(get_option("icodes_custom_desc"));
	if($cdesc == ""){
		$CUSTOMDESC = $code['description'];
	}else{
		$CUSTOMDESC = str_replace("[description]",$code['description'],str_replace("[code]",$code['voucher_code'],str_replace("[merchant]",$code['merchant'],str_replace("[url]",$dd1[0],str_replace("[starts]",date('l jS \of F Y h:i:s A',strtotime($code['start_date'])),str_replace("[ends]",date('l jS \of F Y h:i:s A',strtotime($code['expiry_date'])),$cdesc))))));
		  
	}

			 $my_post = array();			 
			 $my_post['post_title'] 	= $CUSTOMTITLE;
			 $my_post['post_content'] 	= $CUSTOMDESC;
			 $my_post['post_excerpt'] 	= $CUSTOMDESC;
			 
			 //$my_post['post_title'] 	= $code['title'];
			// $my_post['post_content'] 	= $code['description'];
			 //$my_post['post_excerpt'] 	= $code['description'];
			 $my_post['post_author'] 	= 1;
			 $my_post['post_status'] 	= get_option("icodes_import_status");
			 $my_post['post_category']  = array($cat);
			 //$my_post['tags_input'] = $dd1[0];
			 
			 $POSTID = wp_insert_post( $my_post );	  
					 
			 // EXTRA FIELDS
			 add_post_meta($POSTID, "ID", 		str_replace("!!aaqq","",$id));
			 add_post_meta($POSTID, "code", 	$code['voucher_code']);
			 add_post_meta($POSTID, "url", 		$code['merchant_url']);	  
			 add_post_meta($POSTID, "hits", 	"0");
			 add_post_meta($POSTID, "link", 	$code['affiliate_url']);	
			 add_post_meta($POSTID, "image", 	$code['merchant_logo_url']);
			 
			 //wp_set_post_terms
			  
			 add_post_meta($POSTID, "type", 	"coupon");
			 
			 add_post_meta($POSTID, "starts", 	$code['start_date']);
			 add_post_meta($POSTID, "pexpires", $code['expiry_date']);
			   add_post_meta($POSTID, "featured", "no");	

echo "<div style='margin-left:10px; padding:8px; font-size:13px; border: 1px dashed #ddd; background:#e2ffd9; margin-right:30px;'>
				<img src='../wp-content/themes/couponpress/images/accept.png' align='middle'/> ".$cc->network." - ".$cc->title."</div><br>";

 }else{

echo "<div style='margin-left:10px; padding:8px; font-size:13px; border: 1px dashed #ddd; background:#ffe5e9; margin-right:30px;'>
				<b>DUPLICATE FOUND - NOT SAVED - </b> ".$cc->network." - ".$cc->title."</div><br>";

 }
 return $POSTID;
}



if(get_option("icodes_subscriptionID") =="" || strlen(get_option("icodes_subscriptionID")) < 5 ){ die("<h1> iCodes Subscription Key Missing</h1><p>You need to enter your subsscription key into the configuration settings</p>"); }
 



/* MASS IMPORT TOOLS FOR CATEGORY INTEGRATION */

if($_POST['display_coupons'] == "2"){
	$counter = 0; if(isset($_POST['total_items'])){ $total_items = $_POST['total_items'];}else{ $total_items =0; }

	foreach($_POST['masscat'] as $key){ 

		if(is_numeric($key['enable']) ){
			
			$_POST['i_category'] = $key['cat'];
			$string = BuildQueryString($_POST);
			$xml = GetIcodesData($string);
			$total_items += trim($xml->Results);
			$message1 = trim($xml->Message);
			if($message1==''){
				foreach ($xml->item as $item) {
					AddCoupon($item,$key['enable']);
					$counter++;
				}
			}	
	
		}
	}

}else{
/* ------------------------------------------ */



 
$run=0;
$cats = "";
if(is_array($_POST['cat'])){
foreach($_POST['cat'] as $cat){			
	$cats .= $cat.",";
}}else{
$cats = 1;
}

$_POST['keyword'] = str_replace(" ","%20",$_POST['keyword']);


$string = BuildQueryString($_POST);
$xml = GetIcodesData($string);
$total_items = trim($xml->Results);
$message1 = trim($xml->Message);
 
if($message1 !=''){

	print "<h1>".$message1."</h1><p>".$string."</p> <p> <a href='admin.php?page=import'>Click here to perform a new search.</a> </p>";

}else{

?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <style>
	* { padding:0px; margin:0px; }
	body { padding:0px; margin:0px; font: 12px "Lucida Grande", Verdana, Arial, sans-serif;  margin-right:20px; }
	
	.ppt-form-line {
display: block;
border-bottom: 1px solid #E5E5E5;
padding: 15px 0px;
}
	</style> 
      <script type='text/javascript' src='<?php echo $_POST['web_path']; ?>/PPT/ajax/actions.js?ver=3.3.1'></script>  

    <script type='text/javascript'>
	
	function gobackpage(page){

	document.getElementById('start_page').value = page -1;
	document.subform.submit();
	
	}
 
	</script>      
</head>

<body>
 
 

<div id="resultstable">
<div id="ShopperPressAlert"  style="font-size:12px; font-weight:bold; background:#e6ffd7;color:#296900; margin-bottom:5px;"></div>
<div style="background:#efefef; border:1px solid #ddd; padding:9px; font-size:11px;">Total Found: <?php echo $total_items; ?> <?php echo $_POST['display_stype']; ?> - Showing Page <?php echo $_POST['start_page']; ?> of <?php echo round($total_items/10); ?></div>



<?php
	
	foreach ($xml->item as $item) {
	
	
		$id = $item->id;
		if($id==""){
			$id = $item->icid;
		} 
		$network = $item->network;
		$merchant = $item->merchant;
		$merchant_logo_url = $item->merchant_logo_url;
		$merchant_url = $item->merchant_url;
		$affiliate_url = $item->affiliate_url;
		$category = $item->category;	
		$mid = $item->mid;
		$title = $item->title;
		$description = $item->description;	 
		$voucher_code = $item->voucher_code;		
		$excode = $item->excode;
		$start_date = $item->start_date;
		$expiry_date = $item->expiry_date;

		if($_POST['display_stype'] == "Offers"){
		$type = "offer";
		}elseif($_POST['display_stype'] =="PrintableVouchers"){
		$type = "print";
		}else{
		$type = "code";
		}

		
		?>
        
<div style="clear:both; border-bottom:1px dashed #666;" id="A<?php echo $id; ?>">

<div class="ppt-form-line">  
<img src="<?php echo $merchant_logo_url; ?>" style="float:right; max-width:80px; max-height:80px;">

<b style="font-size:12px;"><?php echo $title; ?> - <?php echo $id; ?></b>
<p><small><?php echo $description; ?></small></p>

<p style="background:#efefef; border:1px solid #dddddd; padding:3px; margin-top:5px;"><b><small> <?php if($_POST['display_stype'] == "Codes"){ ?>Code: <?php echo $voucher_code; ?>  -<?php } ?> <br />starts: <?php echo str_replace("00:00:00","",$start_date); ?> / ends: <?php echo str_replace("00:00:00","",$expiry_date); ?> </small></b></p>
 
</div>
 <div class="ppt-form-line"> 
  
[<a href='javascript:void(0);' onclick='addiCodes("<?php echo $cats; ?>","<?php echo str_replace("'","",$title); ?>","<?php echo str_replace("'","",trim(strip_tags($description))); ?>","<?php echo str_replace("&","**",$affiliate_url); ?>","<?php echo $voucher_code; ?>","<?php echo $expiry_date; ?>","<?php echo $merchant_url; ?>","<?php echo $type; ?>","<?php echo $_POST['import_status']; ?>","<?php echo str_replace("'","",$merchant_logo_url); ?>","<?php echo $start_date; ?>","<?php echo $merchant; ?>","<?php echo str_replace("http://","",$_POST['web_path']); ?>/PPT/ajax/");document.getElementById("A<?php echo $id; ?>").style.display = "none";'>Add Coupon</a>] 
[ <a href="<?php echo $affiliate_url; ?>" target="_blank">View Product</a>]
[ <a href="<?php echo $merchant_url; ?>" target="_blank">View Merchant</a>]
 
</div>

</div>

<?php }} ?>



<?php } ?>


<?php if($_POST['display_coupons'] != 2){?>

       <div style="background:#eee; border:1px solid #ddd; padding:10px; margin-top:10px; font-size:12px;">
 
        
     <?php if($_POST['start_page'] > 1){ ?><a href="javascript:void(0);" onclick="getElementById('resultstable').innerHTML='<br>Loading results, please wait...'; gobackpage(<?php echo $_POST['start_page']; ?>)">Previous Page</a>  <?php } ?>
        
        <a href="#" onclick="document.subform.submit();getElementById('resultstable').innerHTML='<br>Loading results, please wait...';" style="float:right;">Next Page</a> </div>
 
	<div style="clear:both;"></div>
    
    <?php }else{ 

	$totalSoFar = $counter*$_POST['start_page'];
	?>
    
    
        <div style="background:#eee; border:1px solid #ddd; padding:10px; margin-top:10px; font-size:12px;">
		 
			<b>Number of coupons added:</b>		
			
			<?php 

			if($totalSoFar > $total_items){ echo $total_items; }else{ echo $totalSoFar . " of ". $total_items; } 

			if($totalSoFar < $total_items){ ?>
             - <a href="#"onclick="getElementById('resultstable').innerHTML='<br>Loading results, please wait...';document.subform.submit();" style="float:right;">Next Page</a>

			<?php } ?>
		</div>  
    
 
    <?php } ?>





    <script>
	
	function gobackpage(page){

	document.getElementById('start_page').value = page -1;
	document.subform.submit();
	
	}
	
	</script> 
        
    <form method="post" target="_self" id="subform" name="subform">			
    <input type="hidden" name="icodes" value="1" />
	<input name="display_coupons" type="hidden" value="1" />
	<input type="hidden" name="feed_path" value="<?php echo $_POST['feed_path'];?>">
	<input type="hidden" name="web_path" value="<?php echo $_POST['web_path'];  ?>">

 	<input type="hidden" name="total_items" value="<?php echo $total_items; ?>">
    <?php
 
	foreach($_POST as $key=>$val){
	
		if(is_array($val)){
		
			foreach($val as $key=>$val1){
				 print '<input type="hidden" name="'.$key.'" value="'.$val1.'">';			 
			}
		
		
		}else{

			if($key == "start_page"){	
				if($val ==""){ $val=2; }else{ $val++; }	
				print '<input type="hidden" name="'.$key.'" value="'.$val.'" id="start_page">';	
			}else{	
				print '<input type="hidden" name="'.$key.'" value="'.$val.'">';
			}
		}

	}
	
	if(is_array($_POST['cat'])){ foreach($_POST['cat'] as $cat){			
		print '<input type="hidden" name="cat[]" value="'.$cat.'">';	
	} }
 
		if(is_array($_POST['masscat'])){ $i=0; foreach($_POST['masscat'] as $cat){			
		print '<input type="hidden" name="masscat['.$i.'][enable]" value="'.$cat['enable'].'">';	
		print '<input type="hidden" name="masscat['.$i.'][cat]" value="'.$cat['cat'].'">';	
		$i++;
	} }
	?>
	
    </form>
</body>
</html>   
<?php } } ?>