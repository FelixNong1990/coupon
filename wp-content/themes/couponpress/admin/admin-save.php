<?php

 
 	$ThemeDesign 	= new Theme_Design;		
	$PPT 			= new PremiumPressTheme;
 
	$PPTDesign 		= new PremiumPressTheme_Design;	
	$PPTImport 		= new PremiumPressTheme_Import;	
	
 
$GLOBALS['sf'] 			= 0;
$GLOBALS['error'] 		= 0;
$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
$GLOBALS['error_msg'] 	= "";


if(current_user_can('administrator')){

	if(isset($_GET['resetkey'])){
	
		update_option("license_key","");
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Your lience key has been removed successfully.";	
	}
	/*********************************************************************
	/************************ RESET OPTIONS *****************************/ 
	/********************************************************************/
	
	if(isset($_POST['reset']) && $_POST['RESETME'] =="yes"){
	
		update_option("ppt_layout_styles",""); 
		include(TEMPLATEPATH ."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/system_reset.php");
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Your website has been successfully reset.";
	}
	/*********************************************************************
	/************** GENERAL SETUP PAGE OPTIONS **************************/ 
	/********************************************************************/
	
	if(isset($_POST['admin_page']) && $_POST['admin_page'] == "language_setup"){
	
		$stopUpdate = true;
	 
		
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Changes Saved Successfully";    
	} 




if(isset($_GET['testdownloadID'])){

$dwl_content = '
<html>
<head>
</head>
<body onload="document.downloadform'.$_GET['testdownloadID'].'.submit()">
<form action="'.get_home_url().'/" method="POST" name="downloadform'.$_GET['testdownloadID'].'">';
$dwl_content .= wp_nonce_field('FileDownload');
 $dwl_content .= "<input type='hidden' name='hash' value='123'>
                     <input type='hidden' name='force' value='1'>
                    <input type='hidden' name='fileID' value='".($_GET['testdownloadID']*800)."'>";
                    
$dwl_content .= '<a  href="javascript:void(0);" onclick="document.downloadform'.$_GET['testdownloadID'].'.submit();" >';
$dwl_content .= 'test download';
$dwl_content .= "</a> </form> </p></div></body></html>";
echo $dwl_content;
die();

}




if(isset($_POST['admin_page']) && $_POST['admin_page'] == "general_setup"){


	// TURNS ON/OFF USER REGISTRATION
	$allow_register = (int)trim($_POST['users_can_register']);
	update_option("users_can_register", $allow_register);
	
	// if SHRINKTHEWEB
	if($_POST['adminArray']['pptimage']['thumbnailapi'] == "shrinktheweb"){	
		if($_POST['adminArray']['stw_1']){$_POST['adminArray']['pptimage']['stw_1'] = trim($_POST['adminArray']['stw_1']);}
		if($_POST['adminArray']['stw_2']){$_POST['adminArray']['pptimage']['stw_2'] = trim($_POST['adminArray']['stw_2']);}
		if($_POST['adminArray']['stw_3']){$_POST['adminArray']['pptimage']['stw_3'] = trim($_POST['adminArray']['stw_3']);}
		if($_POST['adminArray']['stw_4']){$_POST['adminArray']['pptimage']['stw_4'] = trim($_POST['adminArray']['stw_4']);}
		if($_POST['adminArray']['stw_5']){$_POST['adminArray']['pptimage']['stw_5'] = trim($_POST['adminArray']['stw_5']);}
		if($_POST['adminArray']['stw_6']){$_POST['adminArray']['pptimage']['stw_6'] = trim($_POST['adminArray']['stw_6']);}	
		if($_POST['adminArray']['stw_7']){$_POST['adminArray']['pptimage']['stw_7'] = trim($_POST['adminArray']['stw_7']);}	
		if($_POST['adminArray']['stw_8']){$_POST['adminArray']['pptimage']['stw_8'] = trim($_POST['adminArray']['stw_8']);}
		if($_POST['adminArray']['stw_9']){$_POST['adminArray']['pptimage']['stw_9'] = trim($_POST['adminArray']['stw_9']);}
		if($_POST['adminArray']['stw_10']){$_POST['adminArray']['pptimage']['stw_10'] = trim($_POST['adminArray']['stw_10']);}
		if($_POST['adminArray']['stw_11']){$_POST['adminArray']['pptimage']['stw_11'] = trim($_POST['adminArray']['stw_11']);}
		if($_POST['adminArray']['stw_12']){$_POST['adminArray']['pptimage']['stw_12'] = trim($_POST['adminArray']['stw_12']);}
		if($_POST['adminArray']['stw_13']){$_POST['adminArray']['pptimage']['stw_13'] = trim($_POST['adminArray']['stw_13']);}		
	}
	
	// ORDER BY LISTBOX DATA
	$check_right = (int)trim($_POST['listbox_display']);
	update_option("listbox_display", $check_right);
		
	$check_right2 = (int)trim($_POST['listbox_custom']);
	update_option("listbox_custom", $check_right2);
		
	$check_right = (int)trim($_POST['listbox_display_cats']);
	update_option("listbox_display_cats", $check_right);	
		
		
	$check_right = (int)trim($_POST['listbox_display_order']);
	update_option("listbox_display_order", $check_right);
		
		//custom field value
		$String = $_POST['a1']."**".$_POST['a2']."**".$_POST['a3']."**".$_POST['a4']."**";
		$String .= $_POST['b1']."**".$_POST['b2']."**".$_POST['b3']."**".$_POST['b4']."**";
		$String .= $_POST['c1']."**".$_POST['c2']."**".$_POST['c3']."**".$_POST['c4']."**";
		$String .= $_POST['d1']."**".$_POST['d2']."**".$_POST['d3']."**".$_POST['d4']."**";
		$String .= $_POST['e1']."**".$_POST['e2']."**".$_POST['e3']."**".$_POST['e4']."**";
		$String .= $_POST['f1']."**".$_POST['f2']."**".$_POST['f3']."**".$_POST['f4']."**";
		$String .= $_POST['g1']."**".$_POST['g2']."**".$_POST['g3']."**".$_POST['g4']."**";
		$String .= $_POST['h1']."**".$_POST['h2']."**".$_POST['h3']."**".$_POST['h4']."**";
		$String .= $_POST['i1']."**".$_POST['i2']."**".$_POST['i3']."**".$_POST['i4']."**";
		$String .= $_POST['j1']."**".$_POST['j2']."**".$_POST['j3']."**".$_POST['j4']."**";
		$String .= $_POST['k1']."**".$_POST['k2']."**".$_POST['k3']."**".$_POST['k4']."**";
		$String .= $_POST['l1']."**".$_POST['l2']."**".$_POST['l3']."**".$_POST['l4']."**";
		
		update_option("listbox_custom_string", $String);
		
		
 	// // CATEGORY DISPLAY
	if(isset($_POST['nav_cat']) && is_array($_POST['nav_cat']) ){	 
		update_option("nav_cats",$_POST['nav_cat']);	
	}
	
	// ADVANCED SEARCH
	$check_enabled = (int)trim($_POST['display_advanced_search']);
	update_option("display_advanced_search", $check_enabled);
 
	// PAGES DISPLAY
	 
	if(isset($_POST['nav_page'])){	
			$hide_pages = ""; 
		foreach($_POST['nav_page'] as $id){
				$hide_pages .= $id.",";
		}
		 
		update_option("excluded_pages",$hide_pages);	
	}else{
	update_option("excluded_pages","");
	}
	
	
	if(isset($_POST['submenu_nav_page'])){	 
			$hide_pages = ""; 
		foreach($_POST['submenu_nav_page'] as $page_id){
				$hide_pages .= $page_id.",";
		}
		update_option("submenu_excluded_pages",$hide_pages);	
	}else{
	update_option("submenu_excluded_pages","");
	}
	
	
	if(isset($_POST['footer_nav_page'])){	
	
		$hide_pages = ""; 
		foreach($_POST['footer_nav_page'] as $page_id){
				$hide_pages .= $page_id.",";
		} 
		update_option("footer_excluded_pages",$hide_pages);	
	}else{
	update_option("footer_excluded_pages","");
	}
	
	
	if(isset($_POST['hidden_cats'])){	
			$hide_pages = ""; 
		foreach($_POST['hidden_cats'] as $page_id){
				$hide_pages .= $page_id.",";
		}
		update_option("article_cats",$hide_pages);	
	}else{
	update_option("article_cats","");
	}	 
		
}

/* =============================================================================
   NEW MEMBERSHIP SYSTEM // V7 // 2ND APRIL
   ========================================================================== */ 
   
   
 
if(isset($_POST['adminArray']['display_country']) ){ 

update_option("ppt_defaultpackageaccess",$_POST['package_access']);
} 
   
if(isset($_POST['ppt_membership']) ){ 

$newpackages = array(); $i=0;

// 1. CLEAN STRING
$newpackages['show_register'] 	= $_POST['ppt_membership']['show_register'];
$newpackages['show_myaccount'] 	= $_POST['ppt_membership']['show_myaccount'];
$newpackages['enable'] 			= $_POST['ppt_membership']['enable'];

// 2. LOOP THOURGH AND CLEAN
if(is_array($_POST['ppt_membership']['package']['name'])){
foreach($_POST['ppt_membership']['package']['name'] as $package){
  
	if($package == ""){ $i++; continue; }
	
	if(!isset($_POST['ppt_membership']['package']['ID'][$i])){
	$pid = $i+5;
	}else{
	$pid = $_POST['ppt_membership']['package']['ID'][$i];
	}
 
	
	$newpackages['package'][$i]['ID'] 			= $pid;
	$newpackages['package'][$i]['name'] 		= $_POST['ppt_membership']['package']['name'][$i];
	$newpackages['package'][$i]['desc'] 		= $_POST['ppt_membership']['package']['desc'][$i];
	//$newpackages['package'][$i]['warn'] 		= $_POST['ppt_membership']['package']['warn'][$i];	
	$newpackages['package'][$i]['max_submit'] 	= $_POST['ppt_membership']['package']['max_submit'][$i];	
	$newpackages['package'][$i]['duration'] 	= $_POST['ppt_membership']['package']['duration'][$i];	
	$newpackages['package'][$i]['price'] 		= $_POST['ppt_membership']['package']['price'][$i];
	$newpackages['package'][$i]['submission'] 	= $_POST['ppt_membership']['package']['submission'][$i];
	$newpackages['package'][$i]['recurring'] 	= $_POST['ppt_membership']['package']['recurring'][$i];
	$newpackages['package'][$i]['order'] 		= $_POST['ppt_membership']['package']['order'][$i];
	$newpackages['package'][$i]['messages'] 	= $_POST['ppt_membership']['package']['messages'][$i];
	$newpackages['package'][$i]['packageID'] 	= $_POST['ppt_membership']['package']['packageID'][$i];
	$newpackages['package'][$i]['freetrial'] 	= $_POST['ppt_membership']['package']['freetrial'][$i];
	
	$i++; // next one
		
} }
 
update_option("ppt_membership",$newpackages);

// CHECK FOR PACKAGE CHANEGS
if($_POST['frompack'] != "" && is_numeric($_POST['frompack']) ){ 

	if($_POST['frompack'] == "0"){
	
	
	$SQL = "SELECT * FROM ".$wpdb->prefix."users"; 
	$result = mysql_query($SQL); 	 
	while($row = mysql_fetch_array($result)){
	 
		update_user_meta($row['ID'], "pptmembership_level", $_POST['topack']);
		
		//die($row['ID']." -- ".$_POST['topack']);
	
	}
	
	
	
	}else{
	
		mysql_query("UPDATE ".$wpdb->prefix."usermeta SET meta_value = '".$_POST['topack']."' WHERE  `meta_key` =  'pptmembership_level' AND meta_value = '".$_POST['frompack']."'");
	}



}

}




if(isset($_POST['ppt_profilefield'])  ){ 
 
$newpackages = array(); $i=0;
 
// 2. LOOP THOURGH AND CLEAN
if(is_array($_POST['ppt_profilefield']['field']['name'])){
foreach($_POST['ppt_profilefield']['field']['name'] as $package){
  
	if($package == ""){ $i++; continue; }
	
	if(!isset($_POST['ppt_profilefield']['field']['ID'][$i])){
	$pid = $i+5;
	}else{
	$pid = $_POST['ppt_profilefield']['field']['ID'][$i];
	}
	
	$newpackages['package'][$i]['ID'] 			= $pid;
	$newpackages['package'][$i]['name'] 		= $_POST['ppt_profilefield']['field']['name'][$i];
	$newpackages['package'][$i]['desc'] 		= $_POST['ppt_profilefield']['field']['desc'][$i];
	
	$newpackages['package'][$i]['key'] 			= str_replace(" ","",$_POST['ppt_profilefield']['field']['key'][$i]);
	if($newpackages['package'][$i]['key'] == ""){
	$newpackages['package'][$i]['key'] = "profilefield_".$pid;
	}
		
	$newpackages['package'][$i]['title'] 		= $_POST['ppt_profilefield']['field']['title'][$i];	
	$newpackages['package'][$i]['values'] 		= $_POST['ppt_profilefield']['field']['values'][$i];	
	$newpackages['package'][$i]['type'] 		= $_POST['ppt_profilefield']['field']['type'][$i];	
	$newpackages['package'][$i]['order'] 		= $_POST['ppt_profilefield']['field']['order'][$i];
	$newpackages['package'][$i]['required'] 		= $_POST['ppt_profilefield']['field']['required'][$i];
	
	$newpackages['package'][$i]['display_register'] 	= $_POST['ppt_profilefield']['field']['display_register'][$i];
	$newpackages['package'][$i]['display_account'] 		= $_POST['ppt_profilefield']['field']['display_account'][$i];
	
	$i++; // next one
		
} }

$newpackages['default1'] 		= $_POST['ppt_profilefield']['default1'];
$newpackages['default2'] 		= $_POST['ppt_profilefield']['default2'];
$newpackages['default3'] 		= $_POST['ppt_profilefield']['default3'];
$newpackages['default4'] 		= $_POST['ppt_profilefield']['default4'];
 
update_option("ppt_profilefields",$newpackages);
}

/* =============================================================================
   CUSTOM SUBMISSION FIELDS // V7 // 28TH APRIL
   ========================================================================== */ 


// CUSTOM FIELD OPTIONS
if(isset($_POST['customfield'])){ // && is_array($_POST['customfield'])

	//$i=1; while($i < 50){
	//$_POST['customfield'][$i]['key'] = str_replace(" ","",$_POST['customfield'][$i]['key']);
	//$i++;
	//}
	
	$newpackages = array(); $i=0;
	 
	// 2. LOOP THOURGH AND CLEAN
	 
	foreach($_POST['customfield']['name'] as $package){
	  
		if($package == ""){ $i++; continue; }
		
		if(!isset($_POST['customfield']['ID'][$i])){
		$pid = $i+5;
		}else{
		$pid = $_POST['customfield']['ID'][$i];
		}
		
		$newpackages[$i]['ID'] 			= $pid;
		
		$newpackages[$i]['name'] 		= $_POST['customfield']['name'][$i];
		$newpackages[$i]['key'] 		= str_replace(" ","",$_POST['customfield']['key'][$i]);
		$newpackages[$i]['show'] 		= $_POST['customfield']['show'][$i];
		$newpackages[$i]['order'] 		= $_POST['customfield']['order'][$i];
		
		if($_POST['customfield']['fieldtitle'][$i] == 1){
		$newpackages[$i]['fieldtitle'] =1;
		}else{
		$newpackages[$i]['fieldtitle'] =0;
		}
		 
		$newpackages[$i]['type'] 		= $_POST['customfield']['type'][$i];
		$newpackages[$i]['value'] 		= $_POST['customfield']['value'][$i];
		$newpackages[$i]['desc1'] 		= $_POST['customfield']['desc1'][$i];
		$newpackages[$i]['desc2'] 		= $_POST['customfield']['desc2'][$i];
		$newpackages[$i]['required'] 	= $_POST['customfield']['required'][$i];
		
		$newpackages[$i]['pack1'] 		= $_POST['customfield']['pack1'][$i];
		$newpackages[$i]['pack2'] 		= $_POST['customfield']['pack2'][$i];
		$newpackages[$i]['pack3'] 		= $_POST['customfield']['pack3'][$i];
		$newpackages[$i]['pack4'] 		= $_POST['customfield']['pack4'][$i];
		$newpackages[$i]['pack5'] 		= $_POST['customfield']['pack5'][$i];
		$newpackages[$i]['pack6'] 		= $_POST['customfield']['pack6'][$i];
		$newpackages[$i]['pack7'] 		= $_POST['customfield']['pack7'][$i];
		$newpackages[$i]['pack8'] 		= $_POST['customfield']['pack8'][$i];
	 	 
		
		$i++; // next one
			
	} 
	 
	update_option("customfielddata",$newpackages);

}

/* =============================================================================
   BULK IMPORT FOR CATEGORIES AND TAXONOMIES // V7 // 26TH MARCH
   ========================================================================== */ 

if(isset($_POST['catme']) && isset($_POST['submitted']) && $_POST['submitted'] =="yes" ){ 

	global $wpdb;	 $pCat = "yes"; $skip=false;
	
	// REGISTER TAXMONIES TO SAVE ERRORS
 	if($_POST['tax'] != "category"){
	register_taxonomy( $_POST['tax'], 'post', array( 'hierarchical' => true, 'label' => 'Affiliate locations', 'query_var' => true, 'rewrite' => true ) ); 
	}
	
	$cat = explode(",",trim(ereg_replace( "\n", ",", $_POST['cats'])));
	foreach($cat as $catName){
	
	// CLEAN NAME
	$catName = strip_tags(trim($catName));
	
	// CHECK
	if($catName == "["){   $pCat = "no"; $skip=true; }elseif($catName == "]"){ $pCat =  "yes"; $skip=true; } // setup parent cats
	  
	// DO IMPORT
	if($catName != "[" && $catName != "]"){
	
			if($pCat ==  "yes"){	
		 
				$term = wp_insert_term(str_replace("_"," ",$catName), $_POST['tax'], array('cat_name' => $catName ) );
				
				if(isset($term->errors) && isset($term->error_data)){		 
					$cat_id = $term->error_data['term_exists']; 
				}else{
					$cat_id = $term['term_id']; 
				}
			
			}else{			 
				
				$term = wp_insert_term(str_replace("_"," ",$catName), $_POST['tax'], array('cat_name' => $catName, 'parent' => $cat_id ) );				 
				 
			}	
		} 		
		
 	} 
	
	flush_rewrite_rules( false );
	
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Import Successfull";		
}

/* =============================================================================
   LANGUAGE SYSTEM // V7 // 26TH MARCH
   ========================================================================== */ 

if(isset($_POST['pplang']) && is_array($_POST['pplang']) ){

// CLEAN ARRAY
/*foreach($_POST['pplang'] as $value){
die(print_r($value));
foreach($value as $key=>$val){

}

}*/
 
update_option("pptlanguage",$_POST['pplang']);
}
 
/* =============================================================================
   RESUMEPRESS 
   ========================================================================== */ 
if(isset($_POST['resume'])){
	 update_option("resume",$_POST['resume']);	 
}
if(isset($_POST['portfolioimg'])){
	 update_option("portfolioimgs",$_POST['portfolioimg']);
	 update_option("portfolioimgsalt",$_POST['portfolioimgalt']);
	 update_option("portfolioimgslink",$_POST['portfolioimglink']);
}

if(isset($_POST['skill'])){
$na = array();
if(is_array($_POST['skill'])){
 
	$i=0;
	foreach($_POST['skill'] as $val){ 
		if(strlen($val[$i]) > 0){
			$na[$i]['name'] = $_POST['skill']['name'][$i];
			$na[$i]['level'] = $_POST['skill']['level'][$i];
		}
	$i++; 
	}
}
update_option("resumepress_skill",$na);	 
}

/* =============================================================================
   SAVE / SHARE DESIGN CHANGES
   ========================================================================== */ 
if(isset($_POST['importdesign'])){ 
 
$xml = simplexml_load_file($_FILES['designfile']['tmp_name']);

	$saveArray = array();

	foreach($xml->children() as $child){
	
		foreach($child as $key=>$val){
		
		if($key == "ppt_custom_metatags"){
		
			update_option("ppt_custom_metatags",html_entity_decode(str_replace("!212","",$val)));
		
		}else{
		
			$f = explode("--",$key);
		
			$saveArray[$f[0]][$f[1]] =  str_replace("!212","",$val);
		 
		 }
		
		}
	} 
 
	update_option("ppt_layout_styles",$saveArray);
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Design File Saved Successfully.";

}
if(isset($_GET['dldesign'])){ 
 
 	$newArray = array();

	// GET DESIGN SETTINGS
	$design = get_option('ppt_layout_styles');
	
	if(!is_array($design)){
	die("<h1>No Design Data Found</h1><p>Looks like you havent added any design data.</p>");
	}
	
	foreach($design as $key=>$val){
	
		if(is_array($val)){
			
			foreach($val as $k=>$value){
			
				$newArray[$key][$key."--".$k] = $value;
			} 
		
		}else{
		
			$newArray[$key] = $key."--".$val;
		
		}
	
	}
	
	// ADD IN SOME OF THE OTHER STYLES
	$newArray[]['ppt_custom_metatags'] = htmlentities(get_option('ppt_custom_metatags'));
	// ADD IN SOME OF THE OTHER STYLES
	$newArray[]['ppt_custom_footertags'] = htmlentities(get_option('ppt_custom_footertags'));
 
 	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=PremiumPress-Design-Styles-".date('l jS \of F Y h:i:s A')." .xml"); 
 
	$export = new data_export_helper($newArray);
	$export->set_mode(data_export_helper::EXPORT_AS_XML);
	$export->export($export);
	
	echo $export;
	die();

}

/* =============================================================================
   VIDEO OBJECT DATA
   ========================================================================== */ 
if(isset($_POST['ppt_homepage_video'])){

if( $_POST['ppt_homepage_video']['type'] == "youtube" && $_POST['ppt_homepage_video']['youtube'] != $_POST['ppt_homepage_video']['youtube-current']  ){ //&& ( !isset($vd['youtube-embedded']) || $vd['youtube-embedded'] == ""
 
	 
	include(TEMPLATEPATH."/PPT/class/class_video.php");
	$embedCode = new VideoProvider(); 
	$data =  $embedCode->getEmbedCode($_POST['ppt_homepage_video']['youtube']);
 
	if(isset($data['embed'])){
	$_POST['ppt_homepage_video']['youtube-current'] 	= $_POST['ppt_homepage_video']['youtube']; 
	$_POST['ppt_homepage_video']['youtube-title'] 		= $data['title']; 
	$_POST['ppt_homepage_video']['youtube-image'] 		= $data['image']; 
	$_POST['ppt_homepage_video']['youtube-embedded'] 	= wpautop(stripslashes($data['embed'])); 
	}	
	
	 
}elseif( $_POST['ppt_homepage_video']['type'] != "youtube"){
update_option("ppt_homepage_video","");	
}

update_option("ppt_homepage_video",$_POST['ppt_homepage_video']);
}
/* =============================================================================
   CATEGORY ICONS IN V7
   ========================================================================== */ 
if(isset($_POST['cat_icons'])){
update_option("cat_icons",$_POST['cat_icons']);
}
/* =============================================================================
   CUSTOM TAXOMONIES IN V7
   ========================================================================== */ 
if(isset($_POST['ppt_custom_tax'])){
update_option("ppt_custom_tax",$_POST['ppt_custom_tax']);
}

/* =============================================================================
   FEED IMPORT TOOL
   ========================================================================== */ 
	// TEST FEED
if(isset($_POST['runFeedID']) && is_numeric($_POST['runFeedID'])){
	
	ini_set("memory_limit","256M");
	
	require_once (TEMPLATEPATH ."/PPT/class/class_feed.php");
	$feedMe = new PremiumPress_Feed(); 
 
 	$count = $feedMe->Add($_POST['runFeedID']);
  
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Feed Successfully Imported ".$count." Listings.";	  
	   
	
}
if(isset($_POST['feeddata']) && is_array($_POST['feeddata'])){

	require_once (TEMPLATEPATH ."/PPT/class/class_feed.php");
	$feedMe = new PremiumPress_Feed();	
 
	$i=0;  $newpackages = array(); $EXISTING = get_option("feeddatadata");
 
 	if(isset($_POST['feeddata']['name']) && is_array($_POST['feeddata']['name'])){ 
	
		// 2. LOOP THOURGH AND CLEAN
		foreach($_POST['feeddata']['name'] as $feed){
		  
			// DONT INCLUDE FEEDS WITH EMPTY NAMES
			if($feed == ""){ $i++; continue; }
			
			// GIVE THE FEED A UNIQUE ID
			if(!isset($_POST['feeddata']['ID'][$i])){
			$pid = $i+5;
			}else{
			$pid = $_POST['feeddata']['ID'][$i];
			}
			$defaults = array('ID','name','url','csv','delimiter','format','category','period','order');
			
			// CLEAN UP DATA
			$newpackages[$i]['ID'] 			= $pid;
			$newpackages[$i]['name'] 		= $_POST['feeddata']['name'][$i];
			$newpackages[$i]['url'] 		= str_replace("Feed Link (http://)","",$_POST['feeddata']['url'][$i]);
			$newpackages[$i]['csv'] 		= $_POST['feeddata']['csv'][$i];
			$newpackages[$i]['delimiter'] 	= $_POST['feeddata']['delimiter'][$i];	
			$newpackages[$i]['format'] 		= $_POST['feeddata']['format'][$i];
			$newpackages[$i]['category'] 	= $_POST['feeddata']['category'][$i];
			$newpackages[$i]['period'] 		= $_POST['feeddata']['period'][$i];		 	 
			$newpackages[$i]['order'] 		= $_POST['feeddata']['order'][$i];
			$newpackages[$i][$newpackages[$i]['ID']] 		= $_POST['feeddata'][$newpackages[$i]['ID']];
			
			// ADD ON EXTRA VALUES
			/*if(isset($_POST['feeddata'][$newpackages[$i]['ID']])){
			foreach($_POST['feeddata'][$newpackages[$i]['ID']] as $key=>$val){
				//if(!in_array($key,$defaults)){			
					$newpackages[$i][$key] = $val[$i];
				//}	
			}
			}*/
	 
			// ARE WE IMPORTING FROM A URL OR FILE?
			if(strlen($newpackages[$i]['csv']) > 1){
				$path 	= get_option('imagestorage_path').$newpackages[$i]['csv'];	 
			}elseif(strlen($newpackages[$i]['url']) > 1){
				$path 	= $newpackages[$i]['url'];	
			}else{
				$path = "";
			}
					
			// IF THE FORMAT IS BLANK, TRY AND CREATE ONE
			if(isset($newpackages[$i]['format']) && $newpackages[$i]['format'] == "" && strlen($path) > 2 ){
				//die($path." -- ".$newpackages[$i]['ID']);
				$newpackages[$i]['format'] = $feedMe->Format($path);
			}
			
			// GET THE HEADERS 	
			if(strlen($path) > 2 ){	
			$feeddata = $feedMe->Get("header",$path,$newpackages[$i]);
			$newpackages[$i]['mapdata'] 		= $feeddata;
			}			 	
			 
			 
		$i++;	 
		} // end foreach

	// SAVE DATA
 
	update_option("feeddatadata",$newpackages); 		
		
	} // end if 

 
}
/* =============================================================================
   CUSTOM LAYOUT STYLES FOR WEBSITE
   ========================================================================== */ 

if(isset($_POST['ppt_layout_style']) && is_array($_POST['ppt_layout_style'])){
 
	update_option("ppt_layout_styles",$_POST['ppt_layout_style']);	  
}
if(isset($_POST['ppt_layout_style_reset'])){ update_option("ppt_layout_styles",""); 


		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "All Design Changes Reset";	
  }

if(isset($_POST['chosencolor']) && $_POST['chosencolor'] != ""){
$new = array();

if($_POST['chosencolor'] == 1){
 
	$new[wrapper][bg] = "cae6d8";
	$new[wrapper]['border-width'] =  "1";
	$new[wrapper][customer] =  "";
		  
	$new[body][bg] =  "e7fcf2";
	$new[page][bg] = ""; 
	$new[content][bg] = "";
	
	$new['header'][bg] = "023b30";
	$new['header']['image'] = "";
	$new['header'][custom] = "";
	
	$new[text][main] = "20b369";
	$new[text][h1] = "0b924e";
	$new[text][a] = "20b369";

	$new[gallery]['border-width'] = "5"; 
	$new[gallery]['border-bg'] = "EEEEEE";
	$new[gallery]['hover'] = "20b369"; 
	$new[gallery]['text'] = "20b369";	
				
	$new[nav][from] = "47c485";
	$new[nav][to] = "218954";
	$new[nav][text] = "fff";
	$new[nav][font] = "";
	$new[nav][custom] = "";
	
	$new[submenubar][bg] = "e7fcf2";
	$new[submenubar][text] = "20b369";
	
	$new[itembox]['border-bg'] = "cae6d8";
	$new[itembox]['border-width'] = "1";
	$new[itembox][bg] = "f4fffa";
	$new[itembox][from] = "e7fcf2";
	$new[itembox][to] = "d5efe2";
	$new[itembox][text] = "20b369";
	$new[itembox][font] = "";
	$new[itembox]['text-shawdow'] = "0";
	$new[itembox]['hover'] = "f8fefb";
	
	
	$new[itembox][custom] = "";
	
	$new[footer][bg] = "20b369";
	$new[footer][a] = "ffffff";
	$new[footer][text] = "ffffff"; 

}elseif($_POST['chosencolor'] == 2){
 
	$new[wrapper][bg] = "e0d2a4";
	$new[wrapper]['border-width'] =  "1";
	$new[wrapper][customer] =  "";
		  
	$new[body][bg] =  "e0d2a4";
	$new[page][bg] = ""; 
	$new[content][bg] = "";
	
	$new['header'][bg] = "f3edd8";
	$new['header']['image'] = "";
	$new['header'][custom] = "";
	
	$new[text][main] = "706339";
	$new[text][h1] = "706339";
	$new[text][a] = "706339";
	
	$new[gallery]['border-width'] = "5"; 
	$new[gallery]['border-bg'] = "EEEEEE";
	$new[gallery]['hover'] = "706339"; 
	$new[gallery]['text'] = "706339";	

				
	$new[nav][from] = "958551";
	$new[nav][to] = "706339";
	$new[nav][text] = "fff";
	$new[nav][font] = "";
	$new[nav][custom] = "";
	
	$new[submenubar][bg] = "fffbef";
	$new[submenubar][text] = "958551";
	
	$new[itembox]['border-bg'] = "f4fffa";
	$new[itembox]['border-width'] = "1";
	$new[itembox][bg] = "f3edd8";
	$new[itembox][from] = "d2c8a9";
	$new[itembox][to] = "a69b79";
	$new[itembox][text] = "706339";
	$new[itembox][font] = "";
	$new[itembox]['text-shawdow'] = "0";
	$new[itembox]['hover'] = "f7f5ec";
	
	
	$new[itembox][custom] = "";
	
	$new[footer][bg] = "706339";
	$new[footer][a] = "ffffff";
	$new[footer][text] = "ffffff"; 

	
}elseif($_POST['chosencolor'] == 3){
 
	$new[wrapper][bg] = "96a4ba";
	$new[wrapper]['border-width'] =  "1";
	$new[wrapper][customer] =  "";
		  
	$new[body][bg] =  "dce0e6";
	$new[page][bg] = ""; 
	$new[content][bg] = "";
	
	$new['header'][bg] = "e1edff";
	$new['header']['image'] = "";
	$new['header'][custom] = "";
	
	$new[text][main] = "2b4c7e";
	$new[text][h1] = "2b4c7e";
	$new[text][a] = "2b4c7e";
	
	$new[gallery]['border-width'] = "5"; 
	$new[gallery]['border-bg'] = "EEEEEE";
	$new[gallery]['hover'] = "2b4c7e"; 
	$new[gallery]['text'] = "2b4c7e";
				
	$new[nav][from] = "3f67a3";
	$new[nav][to] = "2b4c7e";
	$new[nav][text] = "fff";
	$new[nav][font] = "";
	$new[nav][custom] = "";
	
	$new[submenubar][bg] = "dce0e6";
	$new[submenubar][text] = "606d80";
	
	$new[itembox]['border-bg'] = "e0e9f6";
	$new[itembox]['border-width'] = "1";
	$new[itembox][bg] = "dfe8f4";
	$new[itembox][from] = "b4c1d4";
	$new[itembox][to] = "79889e";
	$new[itembox][text] = "fff";
	$new[itembox][font] = "";
	$new[itembox]['text-shawdow'] = "1";
	$new[itembox]['hover'] = "f2f7fd";	
	
	$new[itembox][custom] = "";
	
	$new[footer][bg] = "1f1f20";
	$new[footer][a] = "ffffff";
	$new[footer][text] = "ffffff"; 
	
}elseif($_POST['chosencolor'] == 4){
 
	$new[wrapper][bg] = "69d2e7";
	$new[wrapper]['border-width'] =  "1";
	$new[wrapper][customer] =  "";
		  
	$new[body][bg] =  "69d2e7";
	$new[page][bg] = ""; 
	$new[content][bg] = "";
	
	$new['header'][bg] = "69d2e7";
	$new['header']['image'] = "";
	$new['header'][custom] = "";
	
	$new[text][main] = "fa6900";
	$new[text][h1] = "69d2e7";
	$new[text][a] = "fa6900";
	
	$new[gallery]['border-width'] = "5"; 
	$new[gallery]['border-bg'] = "EEEEEE";
	$new[gallery]['hover'] = "fea35c"; 
	$new[gallery]['text'] = "69d2e7";
				
	$new[nav][from] = "f89f59";
	$new[nav][to] = "fa6900";
	$new[nav][text] = "fff";
	$new[nav][font] = "";
	$new[nav][custom] = "";
	
	$new[submenubar][bg] = "fff1e6";
	$new[submenubar][text] = "fa6900";
	
	$new[itembox]['border-bg'] = "e0e9f6";
	$new[itembox]['border-width'] = "1";
	$new[itembox][bg] = "fff1e6";
	$new[itembox][from] = "fea35c";
	$new[itembox][to] = "f38630";
	$new[itembox][text] = "fff";
	$new[itembox][font] = "";
	$new[itembox]['text-shawdow'] = "1";
	$new[itembox]['hover'] = "f2f7fd";	
	
	$new[itembox][custom] = "";
	
	$new[footer][bg] = "fa6900";
	$new[footer][a] = "ffffff";
	$new[footer][text] = "ffffff"; 
	
}elseif($_POST['chosencolor'] == 5){
 
	$new[wrapper][bg] = "";
	$new[wrapper]['border-width'] =  "0";
	$new[wrapper][customer] =  "";
		  
	$new[body][bg] =  "490a3d";
	$new[page][bg] = ""; 
	$new[content][bg] = "";
	
	$new['header'][bg] = "bd1550";
	$new['header']['image'] = "";
	$new['header'][custom] = "";
	
	$new[text][main] = "444";
	$new[text][h1] = "444";
	$new[text][a] = "444";
	
	$new[gallery]['border-width'] = "5"; 
	$new[gallery]['border-bg'] = "EEEEEE";
	$new[gallery]['hover'] = "bd1550"; 
	$new[gallery]['text'] = "bd1550";
				
	$new[nav][from] = "e33371";
	$new[nav][to] = "bd1550";
	$new[nav][text] = "fff";
	$new[nav][font] = "";
	$new[nav][custom] = "";
	
	$new[submenubar][bg] = "fcf3ca";
	$new[submenubar][text] = "444";
	
	$new[itembox]['border-bg'] = "";
	$new[itembox]['border-width'] = "1";
	$new[itembox][bg] = "ffffff";
	$new[itembox][from] = "fcf3ca";
	$new[itembox][to] = "fcf3ca";
	$new[itembox][text] = "bd1550";
	$new[itembox][font] = "";
	$new[itembox]['text-shawdow'] = "0";
	$new[itembox]['hover'] = "f2f7fd";	
	
	$new[itembox][custom] = "";
	
	$new[footer][bg] = "bd1550";
	$new[footer][a] = "ffffff";
	$new[footer][text] = "ffffff"; 

}elseif($_POST['chosencolor'] == 6){
 
	$new[wrapper][bg] = "fff";
	$new[wrapper]['border-width'] =  "0";
	$new[wrapper][customer] =  "";
		  
	$new[body][bg] =  "4f434f";
	$new[page][bg] = ""; 
	$new[content][bg] = "";
	
	$new['header'][bg] = "697a74";
	$new['header']['image'] = "";
	$new['header'][custom] = "";
	
	$new[text][main] = "444";
	$new[text][h1] = "444";
	$new[text][a] = "444";
	
	$new[gallery]['border-width'] = "5"; 
	$new[gallery]['border-bg'] = "EEEEEE";
	$new[gallery]['hover'] = "697a74"; 
	$new[gallery]['text'] = "697a74";
				
	$new[nav][from] = "dad693";
	$new[nav][to] = "b4b17a";
	$new[nav][text] = "fff";
	$new[nav][font] = "";
	$new[nav][custom] = "";
	
	$new[submenubar][bg] = "f3f2dd";
	$new[submenubar][text] = "444";
	
	$new[itembox]['border-bg'] = "dad693";
	$new[itembox]['border-width'] = "1";
	$new[itembox][bg] = "fdfce9";
	$new[itembox][from] = "dad693";
	$new[itembox][to] = "b4b17a";
	$new[itembox][text] = "fff";
	$new[itembox][font] = "";
	$new[itembox]['text-shawdow'] = "0";
	$new[itembox]['hover'] = "f2f7fd";	
	
	$new[itembox][custom] = "";
	
	$new[footer][bg] = "697a74";
	$new[footer][a] = "ffffff";
	$new[footer][text] = "ffffff";
}
 
update_option("ppt_layout_styles",$new);


}
/* =============================================================================
   ADMIN DRAG AND DROP DATA SAVE
   ========================================================================== */ 

if(isset($_POST['ppt_droplist'])){
 
if( isset( $_POST['ppt_layout_block'] ) && is_array( $_POST['ppt_layout_block'] ) ) {
	update_option('ppt_layout_block',$_POST['ppt_layout_block']);
}else{ update_option('ppt_layout_block',''); }
}
/* =============================================================================
   SLIDER / DELETE
   ========================================================================== */ 

if(isset($_POST['delslider']) && is_numeric($_POST['delslider'])){
 
	$nowSlide = get_option("slider_array");  $newArray = array(); $i=0;
	
	foreach($nowSlide as $slide){
			 
		if($_POST['delslider'] != $slide['id']){
		 
			if($slide['id'] == ""){ $slide['id'] = $i; }
			$newArray[$i] = $slide;
		}
		$i++;
		 
	}
 
	update_option("slider_array",$newArray);
	
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Slider Deleted Successfully";
}

/* =============================================================================
   ADVERTISING OPTIONS
   ========================================================================== */ 

	if(isset($_POST['advertise'])){
		$check_right = (int)trim($_POST['advertising_right_checkbox']);
		$check_left = (int)trim($_POST['advertising_left_checkbox']);
		$check_top = (int)trim($_POST['advertising_top_checkbox']);
		$check_footer = (int)trim($_POST['advertising_footer_checkbox']);
		update_option("advertising_right_checkbox", $check_right);
		update_option("advertising_left_checkbox", $check_left);
		update_option("advertising_top_checkbox", $check_top);
		update_option("advertising_footer_checkbox", $check_footer);
	}
/* =============================================================================
   SLIDER / ADD NEW SLIDE
   ========================================================================== */ 

if(isset($_POST['admin_slider'])){
 
	if($_POST['admin_slider'] == "reset"){
	
		update_option("slider_array","");
		
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Slider Reset Successfully";	
	
	}else{


	$newArray = array(); $nowSlide = get_option("slider_array"); $i=0;
	
	if(!get_magic_quotes_gpc()){ //WP always turns on magic quotes
	$_POST['s1']=stripslashes($_POST['s1']);
	$_POST['s2']=stripslashes($_POST['s2']);
	$_POST['s3']=stripslashes($_POST['s3']);
	$_POST['s4']=stripslashes($_POST['s4']);
	$_POST['s5']=stripslashes($_POST['s5']);
	}
	
	if(is_array($nowSlide)){ 
	
		foreach($nowSlide as $slide){
		 
			if($_POST['ppsedit'] != "" && $_POST['ppsedit'] == $slide['id']){
				$newArray[$_POST['ppsedit']]['id'] 		= $_POST['ppsedit'];
				$newArray[$_POST['ppsedit']]['order'] 	= $_POST['s6'];
				$newArray[$_POST['ppsedit']]['s1'] 		= $_POST['s1'];
				$newArray[$_POST['ppsedit']]['s2'] 		= $_POST['s2'];
				$newArray[$_POST['ppsedit']]['s3']		= $_POST['s3'];
				$newArray[$_POST['ppsedit']]['s4'] 		= $_POST['s4'];
				$newArray[$_POST['ppsedit']]['s5'] 		= $_POST['s5'];							
			}else{
			if($slide['id'] == ""){ $slide['id'] = $i; }
			$newArray[$i] = $slide;
			}
			$i++;
		}
	
	} 
 	
	if($_POST['ppsedit'] == ""){	
	 
		$newArray[$i]['order'] = $_POST['s6'];
		$newArray[$i]['s1'] = $_POST['s1'];
		$newArray[$i]['s2'] = $_POST['s2'];
		$newArray[$i]['s3'] = $_POST['s3'];
		$newArray[$i]['s4'] = $_POST['s4'];
		$newArray[$i]['s5'] = $_POST['s5']; 		
		$newArray[$i]['id'] = $i;
		
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Slider Added Successfully";
	}else{
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Slider Updated Successfully";
	
	} 	
 
	update_option("slider_array",$newArray);
	

	
	}

}
/* =============================================================================
   dDOWNLOAD XML FILE FOR PRODUCTS/LISTINGS
   ========================================================================== */ 
 
 if(isset($_GET['downloadcsv'])){ 

	// GET ALL CUSTOM FIELDS
	$CFT = $wpdb->get_results("SELECT DISTINCT meta_key FROM ".$wpdb->prefix."postmeta",ARRAY_A);
	$FF = array();	
	foreach($CFT as $k=>$v){
		 
		if(substr($v['meta_key'],0,1) == "_"){ // DONT INCLUDE FIELDS THAT BEGIN WITH _
		
		}else{
		
		$FF[$v['meta_key']] ="";
		
		} 
			
	}	 

 	// GET ALL POSTS
	$allposts = array();
	$PPO = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='post' AND post_status='publish' ",ARRAY_A);
  
	if(empty($PPO)){
	
	 die("<h1>No Products Found</h1><p>You can only use this tool if you have 'published' products available to export.</p>");
	  
	}
	
	foreach ( $PPO as $dat ){ 

	// UNSET ID AS THIS CAUSES ISSUES WITH XML FILE SOFTWARE 
	if(!isset($dat['ID'])){ continue; } 
 
	// CLEAN ANY COLUMNS WE DONT WANT
	unset($dat['comment_count']);	
	unset($dat['post_mime_type']);
	unset($dat['menu_order']);	 
	unset($dat['post_date_gmt']);
	unset($dat['ping_status']);
	unset($dat['post_password']);
	unset($dat['post_name']);
	unset($dat['to_ping']);
	unset($dat['pinged']);
	unset($dat['post_modified']);
	unset($dat['post_modified_gmt']);
	unset($dat['post_content_filtered']);
	unset($dat['post_parent']);
	unset($dat['guid']);
	unset($dat['_edit_last']);
	unset($dat['_wp_page_template']);
	unset($dat['_edit_lock']);
	unset($dat['post_status']);
	unset($dat['comment_status']);/**/
	 
	// GET ALL THE POST DATA FOR THIS LISTING
	$cf = get_post_custom($dat['ID']);
	
	 // LOOP THROUGH AND DELETE UNUSED ONES
	 if(is_array($cf)){
	 foreach($cf as $k=>$c){	 	 
	 	if(substr($k,0,1) == "_"){ unset($cf[$k]); }else{  } 
	  //if( == ""){  }	 // unset($dat[$k]);	 
	 } } 
 
	 // CLEAN OUT DEFAULT CUSTOM FIELDS WHICH WE DONT WANT
	 unset($cf['_wp_page_template']);
	 unset($cf['_wp_attachment_metadata']);
	 unset($cf['_wp_attached_file']);
	 unset($cf['_wp_trash_meta_status']);
	 unset($cf['_wp_trash_meta_time']);
	 unset($cf['_edit_lock']);
	 unset($cf['_edit_last']);
	 
 	 unset($cf['post_title']);
	 unset($FF['post_title']);

 	 unset($cf['post_excerpt']);
	 unset($FF['post_excerpt']);
	 
 	 unset($cf['post_content']);
	 unset($FF['post_content']);	 
	 
	 
	 
	 // ADD ON THE CUSTOM FIELDS TO THE OUTPUT DATA
	 if(is_array($FF)){
		 foreach($FF as $key=>$val){ 
			if(isset($cf[$key])){
			$dat[$key] = $cf[$key][0];
			}else{
			$dat[$key] = "";
			}
			
			 
		 }
	 } 
 
	 // GET CATEGORY
	 $cs = ""; $categorys = get_the_category($dat['ID']); 
	 foreach($categorys as $cat){ $cs .= $cat->cat_name. ","; } 
	 $dat['category'] = substr($cs,0,-1); //$category[0]
	 
 	// ADD IN SKU
	 if(!isset($dat['SKU'])){	$dat['SKU'] = $dat['ID'];	}
	 
	 // ADD ADDITIONAL VALUES FOR THEMES
	 if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress" ){
	 
	 register_taxonomy( 'store', 'post', array( 'hierarchical' => true, 'labels' => "", 'query_var' => true, 'rewrite' => true ) );  

	 $st = get_the_terms( $dat['ID'], 'store' ); $ff = "";
 	 if(is_array($st)){
		 foreach($st as $storename){
		 $ff .= $storename->name.",";
		 }
		 $ff = substr($ff,0,-1);
	 }
	 $dat['store'] = $ff;
	 
	 }
	
	unset($dat['ID']);	
	
		// SAVE DATA INTO ARRAY
		if(strlen(trim($dat['post_title'])) > 2){
		$allposts[] = $dat; 
		}
 
	 } // end loop
 	
 	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=CSV-".date('l jS \of F Y h:i:s A')." .csv"); 
	
 
	$export = new data_export_helper($allposts);
	$export->set_mode(data_export_helper::EXPORT_AS_CSV);
	$export->export($export);
	
	echo $export;
	die();

}



// EXPORT TO CSV FILE
if(isset($_GET['exportcsv'])){
	function orders_fetch_all($result) {$all = array();while ($all[] = mysql_fetch_assoc($result)) {}return $all;}
	$SQL = "SELECT * FROM ".$wpdb->prefix."orderdata"; 
	$result = mysql_query($SQL);
	$results = orders_fetch_all($result);
	$header = array_keys($results[0]);
	

	
 	//$results[0]['newone'] = "HAHA";
	//array_push($header,"newone");	
	
 
	$cols = count($header); 
	$deliminator = ",";
	for ($i=0; $i<$cols; $i++)
		$output .= "\"".$header[$i]."\"".$deliminator;
		$output .= "\r\n";
	foreach ($results as $row){
		for ($i=0; $i<$cols; $i++)
		{
			$data = str_replace('"', '\'', $row[$header[$i]]);
			$output .= "\"".$data."\"".$deliminator;
		}
			$output .= "\r\n";
	}
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
			//header("Content-Type: application/vnd.ms-excel" );
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"".date("Y-m-d").".csv\";");
	header("Content-Transfer-Encoding:?binary");
	header("Content-Length: ".strlen($output)); 
	echo $output;
	die();
}



 

/*********************************************************************
/************** GENERAL SETUP PAGE OPTIONS **************************/
 
if(isset($_POST['admin_page']) && $_POST['admin_page'] == "email_manager"){

 
	// ADMIN EMAIL SETUP
	if(isset($_POST['emailrole1']) || isset($_POST['emailrole2']) || isset($_POST['emailrole3'])){	
	update_option("emailrole1", $_POST['emailrole1']);
	update_option("emailrole2", $_POST['emailrole2']);
	update_option("emailrole3", $_POST['emailrole3']);
	update_option("emailrole4", $_POST['emailrole4']);
	}
 
}







/*****************************************************************************
/************** CLASSIFIEDSTHEME DESIGN SETUP OPTIONS **************************/

if(isset($_POST['admin_page']) && $_POST['admin_page'] == "classifiedstheme_setup"){


	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_themecolumns']);
	update_option("display_themecolumns", $f);

	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_footer_themecolumns']);
	update_option("display_footer_themecolumns", $f);
	
	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_homecolumns']);
	update_option("display_homecolumns", $f); 
	
}


// MOVIEPRESS TEASER SAVE

if(isset($_POST['adminArray']['teaser_timer'])){



	// LAYOUT CHOICE
	$f = (int)trim($_POST['teaser_enabled']);
	update_option("teaser_enabled", $f);
}

// EMAIL ADMIN FW
if(isset($_POST['adminArray']['display_contactform'])){

	// LAYOUT CHOICE
	$f = (int)trim($_POST['email_forward_enabled']);
	update_option("email_forward_enabled", $f);
}

/*****************************************************************************
/************** SHOPPERPRESS DESIGN SETUP OPTIONS **************************/


if(isset($_POST['admin_page']) && $_POST['admin_page'] == "shopperpress_setup"){

	// DEFAUL HOME PAGE TICK BOX
	$check_right = (int)trim($_POST['display_default_homepage']);
	update_option("display_default_homepage", $check_right);

	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_themecolumns']);
	update_option("display_themecolumns", $f);

	if($f == 2){ update_option("display_sidebar_basket", "right"); }	
}





/*****************************************************************************
/************** auctionpress DESIGN SETUP OPTIONS **************************/

if(isset($_POST['admin_page']) && $_POST['admin_page'] == "auctionpress_setup"){


	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_themecolumns']);
	update_option("display_themecolumns", $f);

}



 

/*****************************************************************************
/************** DIRECTORYPRESS DESIGN SETUP OPTIONS **************************/

if(isset($_POST['admin_page']) && $_POST['admin_page'] == "realtorpress_setup"){


	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_themecolumns']);
	update_option("display_themecolumns", $f);
	
	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_footer_themecolumns']);
	update_option("display_footer_themecolumns", $f);
	
	// LAYOUT CHOICE
	$f = (int)trim($_POST['display_homecolumns']);
	update_option("display_homecolumns", $f); 

}



/*******************************************************************************/





 












// HOME PAGE CATEGORY HIDE
if(isset($_POST['home_hidden_cats1_array'])){	
			$hide_pages = ""; 
		foreach($_POST['home_hidden_cats1_array'] as $page_id){
				$hide_pages .= $page_id.",";
		}
		update_option("home_hidden_cats1",$hide_pages);	
}else{
	//update_option("home_hidden_cats","");

}	
if(isset($_POST['home_hidden_cats_array'])){	
			$hide_pages = ""; 
		foreach($_POST['home_hidden_cats_array'] as $page_id){
				$hide_pages .= $page_id.",";
		}
		update_option("home_hidden_cats",$hide_pages);	
}else{
	//update_option("home_hidden_cats","");

}	
 
//  PACKAGES AND PACKAGE OPTIONS
if(isset($_POST['package']) && is_array($_POST['package'])){
	update_option("packages",$_POST['package']);	  
}

 // if setup
if(isset($_POST['submit']) && isset($_POST['display_submit']) ){
		$enable_listing = (int)trim($_POST['display_submit']);
		update_option("display_submit", $enable_listing);
}
if(isset($_POST['package100'])){ 
		
		
		$check_enabled = (int)trim($_POST['pak_auto_free']);
		update_option("pak_auto_free", $check_enabled);	
		
		$check_enabled = (int)trim($_POST['pak_auto_edit']);
		update_option("pak_auto_edit", $check_enabled);				
			
}

if(isset($_POST['package200'])){

	if(isset($_POST['pak_enabled'])){ $check_enabled=1; }else{ $check_enabled=0; }
	update_option("pak_enabled", $check_enabled);
	
	if(isset($_POST['pak_force_membership'])){ $check_enabled=1; }else{ $check_enabled=0; }
	update_option("pak_force_membership", $check_enabled);
	
	if(isset($_POST['pak_show_customcaptions'])){ $check_enabled=1; }else{ $check_enabled=0; }
	update_option("pak_show_customcaptions", $check_enabled);
	
	$check_enabled = (int)trim($_POST['pak_show_fields']);
	update_option("pak_show_fields", $check_enabled);	


}
 
 

// NORMAL SUBMIT FORM VALUES
if(isset($_POST['submitted']) && $_POST['submitted'] == "yes" && !isset($stopUpdate) ){

if(isset($_POST['ctax'])){update_option('citytax_'.$_POST['adminstate'],$_POST['citytax']);}

 
	$update_options = $_POST['adminArray']; 
	if(is_array($update_options )){
	foreach($update_options as $key => $value){
		if(is_array($value)){ // V7 // 5TH APRIL	
			if($key != "CatPrice"){	
			update_option( trim($key), $value);
			}else{
				// PRICE PER CATS FOR MOST THEMES
				$k = get_option("CatPrice");
				foreach($value as $a=>$g){
					$k[$a] = $g;
				}			
				update_option( "CatPrice", $k);
			}
		}else{
		
		 
 		if (strpos($key, 'cat_extra_text') === false) { }else{ 
		 
			// VERSION 7.1.1 
			$args = array('description' => $value );
			wp_update_term(str_replace("cat_extra_text_","",$key), 'category', $args);

		}
		
		
		update_option( trim($key), trim($value));
		}
		
	} }
 
 
		
 
		
 
				



	// admin 2 - categories
	if(isset($_POST['fea_cat']) && is_array($_POST['fea_cat']) ){	 
		update_option("fea_cats",$_POST['fea_cat']);	
	}
 
 
 
 
 
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Changes Saved Successfully";          
}









/***************************************** DIRECTORYPRESS *********************************************** */

 
 
 		// if setup
		if(isset($_POST['featured'])){
		$check_right = (int)trim($_POST['display_featuredbox']);
		update_option("display_featuredbox", $check_right);
		$check_right = (int)trim($_POST['display_middle_featuredbox']);
		update_option("display_middle_featuredbox", $check_right);
		$check_right = (int)trim($_POST['display_featured_image_enable']);
		update_option("display_featured_image_enable", $check_right); 
		}		
		// if setup
		if(isset($_POST['featured1'])){				
		$check_right = (int)trim($_POST['display_featuredbox1']);
		update_option("display_featuredbox1", $check_right);
		$check_right = (int)trim($_POST['display_featuredbox2']);
		update_option("display_featuredbox2", $check_right);
		$check_right = (int)trim($_POST['display_featuredbox3']);
		update_option("display_featuredbox3", $check_right);
		$check_right = (int)trim($_POST['display_featuredbox4']);
		update_option("display_featuredbox4", $check_right);		
		}
 
 
 /*********************************************************************************************************/ 












/********************************* DIRECTORYPRESS SPECIAL OPTIONS *************************/



if(isset($_POST['premiumpress_import'])){

	ini_set("memory_limit","256M");
	
	include(TEMPLATEPATH."/PPT/func/func_import.php");
	$PPIMPORT = new PremiumPressImport();
	$result = $PPIMPORT->StartImport($_POST['system'],$_POST['table_prefix']);
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "The system successfully imported ".$result." from your ".$_POST['system']." database";

}




// DOMZ IMPORT TOOLS
if(isset($_POST['domz']) && $GLOBALS['sf']==0){
include(TEMPLATEPATH."/PPT/func/func_domz.php");
 
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "You successfully imported ".$i." Links";  
}







// CSV FILE IMPORT
if(isset($_POST['csvimport'])){

global $PPT;

	ini_set("memory_limit","256M");

	if(strlen($_FILES['import']['tmp_name']) > 0 || $_POST['file_csv'] !="0" ){
	 
	if($_POST['file_csv'] == "0"){
		$filename = $_FILES['import']['tmp_name'];
	}else{
		$path = FilterPath();
		$HandlePath =  str_replace("wp-admin","",$path)."/wp-content/themes/".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/thumbs/";
		$filename = $HandlePath.$_POST['file_csv'];
	}
 
	
	$numB = parse_csv_file($filename, $_POST['heading'], $_POST['del'], $_POST['enc'], $_POST['rq'], $_POST['csv']['cat'],$_POST['type']);		
	$totals = explode("**",$numB);			
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= $totals[0]." Products Added <br /> ".$totals[1]." Products Updated";								
	}else{
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Please select a CSV file to import.";
	}  
}


////////////////////// CHILD THEME UPLOAD


if(isset($_FILES['childtheme']) && strlen($_FILES['childtheme']['name']) > 4){

	if(substr($_FILES['childtheme']['name'], -3) != "zip"){
	
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Child Themes should be uploaded as a .zip file. Please select a .zip file.";
	
	}else{
	
		if(is_writable( str_replace("thumbs","themes",get_option('imagestorage_path')))){
		
		
			$copy = @copy($_FILES['childtheme']['tmp_name'], str_replace("thumbs","themes",get_option('imagestorage_path')).$_FILES['childtheme']['name']);
				
			if($copy){	
			
				 				
				
				include(TEMPLATEPATH."/PPT/class/class_pclzip.php");  
				$zip = new PclZip(str_replace("thumbs","themes",get_option('imagestorage_path')).$_FILES['childtheme']['name']);
		
		
				if ($zip->extract(PCLZIP_OPT_PATH, str_replace("thumbs","themes",get_option('imagestorage_path'))) == 0) {
				
				$GLOBALS['error'] 		= 1;
				$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
				$GLOBALS['error_msg'] 	= "Child Theme uploaded successfully.";
				
				}else{
				
				$GLOBALS['error'] 		= 1;
				$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
				$GLOBALS['error_msg'] 	= "Upload Failed";
				
				}
						
			}	
		
		}else{
		
		
				$GLOBALS['error'] 		= 1;
				$GLOBALS['error_type'] 	= "info"; //ok,warn,error,info
				$GLOBALS['error_msg'] 	= "Your themes folder path is not CHMOD 777 (writable) therefore new child themes cannot be upload. <br>PAth is: ".str_replace("thumbs","themes",get_option('imagestorage_path'));	
		
		}
	
	}

}












/********************************* SHOPPERPRESS SPECIAL OPTIONS *************************/

	// if setup
	

 
	// if setup
	if(isset($_POST['promo'])){
		//$check_right = (int)trim($_POST['enable_promotionqty']);
		//update_option("enable_promotionqty", $check_right);
	}
	
	
 
	// if shipping method 
	if(isset($_POST['shipping_method'])){
	
		$b=1;while($b < 11){	
		$pack1_b = (int)trim($_POST['pak_enable_'.$b]);
		update_option("pak_enable_".$b, $pack1_b);
		update_option("pak_name_".$b, $_POST['pak_name_'.$b]);
		update_option("pak_price_".$b, $_POST['pak_price_'.$b]);
		update_option("pak_del_".$b, $_POST['pak_del_'.$b]);		
		$b++; }
			
	}
	
	

	// if credit packages
	if(isset($_POST['credit_packages'])){

		$pack1_b = (int)trim($_POST['credit_enable_1']);
		update_option("credit_enable_1", $pack1_b);
		$pack2_b = (int)trim($_POST['credit_enable_2']);
		update_option("credit_enable_2", $pack2_b);
		$pack3_b = (int)trim($_POST['credit_enable_3']);
		update_option("credit_enable_3", $pack3_b);
		$pack4_b = (int)trim($_POST['credit_enable_4']);
		update_option("credit_enable_4", $pack4_b);
		$pack5_b = (int)trim($_POST['credit_enable_5']);
		update_option("credit_enable_5", $pack5_b);
		
		update_option("credit_name_1", $_POST['credit_name_1']);
		update_option("credit_name_2", $_POST['credit_name_2']);
		update_option("credit_name_3", $_POST['credit_name_3']);
		update_option("credit_name_4", $_POST['credit_name_4']);
		update_option("credit_name_5", $_POST['credit_name_5']);
				
		update_option("credit_price_1", $_POST['credit_price_1']);
		update_option("credit_price_2", $_POST['credit_price_2']);
		update_option("credit_price_3", $_POST['credit_price_3']);
		update_option("credit_price_4", $_POST['credit_price_4']);
		update_option("credit_price_5", $_POST['credit_price_5']);	
				
		update_option("credit_del_1", $_POST['credit_del_1']);
		update_option("credit_del_2", $_POST['credit_del_2']);
		update_option("credit_del_3", $_POST['credit_del_3']);
		update_option("credit_del_4", $_POST['credit_del_4']);
		update_option("credit_del_5", $_POST['credit_del_5']);			
	}	
	
	
	
	
	
	
	
	
	
	
	

// DELETE COUPON CODES
if(isset($_GET['delc'])){
$i=0;
$NewArray=array();
$ArrayCoupon = get_option("coupon_array");
foreach($ArrayCoupon as $value){
	if($i !=$_GET['delc'] && strlen($value['name']) > 1){

		$NewArray[$i]['name'] = $value['name'];
		$NewArray[$i]['price'] = $value['price'];
		$NewArray[$i]['percentage'] = $value['percentage'];

	}
$i++; }
update_option("coupon_array", $NewArray);
$GLOBALS['error'] 		= 1;
$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
$GLOBALS['error_msg'] 	= "Changes Saved Successfully"; 
if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" ){
$_POST['showThisTab'] = 6;
}
}

// SETUP COUPON CODES
if(isset($_POST['couponcode'])){
$NewArray=array();
$ArrayCoupon = get_option("coupon_array");
$i=0;
if(is_array($ArrayCoupon)){
	foreach($ArrayCoupon as $value){
	$NewArray[$i]['name'] 		= $value['name'];
	$NewArray[$i]['price'] 		= $value['price'];
	$NewArray[$i]['percentage'] = $value['percentage'];
	$i++;
	}
}
$NewArray[$i]['name']= $_POST['coupon']['name'];
$NewArray[$i]['price']= $_POST['coupon']['price'];
$NewArray[$i]['percentage']= $_POST['coupon']['percentage'];
update_option("coupon_array", $NewArray);
$GLOBALS['error'] 		= 1;
$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
$GLOBALS['error_msg'] 	= "Coupon Added Scuessfully";	
}


 
}else{ // IS NOT THE ADMIN
 
	if(isset($_POST['submitted'])){
	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "warn"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Changes will not be saved in demo mode.";
	}
}

?>