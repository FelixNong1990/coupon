<?php

// CORE THEME CLASS FILE // DONT EDIT THIS FILE

class PremiumPressTheme {

  // REGISTER HOOKS
  public function PremiumPressTheme() {
  
  		add_action( 'premiumpress_upload', array($this, 'Upload') );
  		add_action( 'premiumpress_upload_edit', array($this, 'EditUpload') );
		add_action( 'premiumpress_upload_delete', array($this, 'DeleteUpload') );
		
		add_action( 'premiumpress_user', array($this, 'User') );
		
		add_action( 'premiumpress_banner', array($this, 'Banner') );
		add_action( 'premiumpress_link', array($this, 'Link') );
		
		add_action( 'premiumpress_post', array($this, 'Post') );
		add_action( 'premiumpress_post_data', array($this, 'PostData') );
		add_action( 'premiumpress_post_delete', array($this, 'PostDelete') );
		add_action( 'premiumpress_post_validate', array($this, 'PostValidate') );
		
		add_action( 'premiumpress_categorylist', array($this, 'CategoryList') );
		add_action( 'premiumpress_pagelist', array($this, 'PageList') );
		 
		add_action( 'premiumpress_expired', array($this, 'Expired') );
		add_action( 'premiumpress_prune', array($this, 'Prune') );
		
		add_action( 'premiumpress_price', array($this, 'Price') );
		
		add_action( 'premiumpress_image', array($this, 'Image') );
		//add_action( 'premiumpress_image_check', array($this, 'ImageCheck') ); 
		
		add_action( 'premiumpress_authorize', array($this, 'Authorize') ); 
		
		add_action( 'premiumpress_time_difference', array($this, 'TimeDiff') );
		
		//add_action( 'premiumpress_time_difference', array($this, 'CountFeedback') );
		
   }
   
function COUNT_NEW_MESSAGES(){

	global $wpdb, $userdata; $total_messages = 0;
	
	// COUNT HOW MANY MESSAGES USER HAS UNREAD
	$SQL = "SELECT ".$wpdb->prefix."posts.ID FROM ".$wpdb->prefix."posts 
	INNER JOIN ".$wpdb->prefix."postmeta ON ( ".$wpdb->prefix."postmeta.post_id = ".$wpdb->prefix."posts.ID AND  meta_value ='".$userdata->ID."' AND meta_key='userID' ) 
	WHERE post_type = 'ppt_message'";
 
	$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);	
	
	 if (mysql_num_rows($result) > 0) {
 
		while ($msg = mysql_fetch_object($result)){
 
			 if(get_post_meta($msg->ID, 'status', true) == "unread"){
				$total_messages++;
			 }		
		}	
	
	}
	
	return $total_messages; 

}
/* =============================================================================
   CHECK MEMBERSHIP LEVELS HAVENT EXPIRED / V7.1.3 / Nov 20th
   ========================================================================== */
   
function CHECK_MEMBERSHIPS_AMOUNT(){

	global $wpdb, $userdata; $membershipData = get_option('ppt_membership'); $conContinue = true;	
 	
	if($membershipData['enable'] == "yes"){
	
		// GET USER PACKAGE ID
		$MID = get_user_meta($userdata->ID, 'pptmembership_level', true);
		 
		if($MID != "" && $MID > 0){
	
			// CHECK IF WE HAVE A MEMBERSHIP PACKAGE ASSIGNED
			$DS = get_user_meta($userdata->ID, 'pptmembership_datestarted', true);
			
			// COUNT ALL POSTS WITHIN THE DATE PERIOD
			$SQL = "SELECT DISTINCT count(*) AS total FROM ".$wpdb->prefix."posts WHERE post_author='".$userdata->ID."' AND post_type = 'post' AND post_date > '".$DS."'"; 

			// RESULTS
			$r = mysql_query($SQL, $wpdb->dbh);
			$array = mysql_fetch_assoc($r);
			
			// LOOP PACKAGES AND CHECK IF THE USERS PACKAGE VALUE IS BIGGER THAN THE AMOUNT POSTED
			if(is_array($membershipData['package'])){
			
				foreach($membershipData['package'] as $pack){
					
					if($pack['ID'] == $MID){
						
						//die($array['total'] .">=". $pack['max_submit']);
						if($array['total'] >= $pack['max_submit']){
						
						return false;
						
						}
					}				
				}			
			}
		
		} // end if MID
	
	} // end membership on/off
	
	return $conContinue;
	 
}

/* =============================================================================
   CHECK FOR COUPON CODE // V7 // 29TH MARCH
   ========================================================================== */

function Coupon($code){

global $wpdb;
	
	$ArrayCoupon = get_option("coupon_array");
 
	if(is_array($ArrayCoupon)){
		foreach($ArrayCoupon as $value){
			if($code ==$value['name']){
			 
				return $value;
			
			}
		}
	}	
}
   
/* =============================================================================
   V7 LAST LOGIN / EDITED: FEB 21ST 2012
   ========================================================================== */

function User($data) {
 
if(!is_array($data) ){ return $data; }
 
global $wpdb;

$ID 	= $data[0];
$type 	= $data[1]; 
$value = "";

switch($type){

	case "last_login";{
		$last_login = get_user_meta($ID, 'last_login', true);
		$date_format = get_option('date_format') . ' ' . get_option('time_format');
		$value = mysql2date($date_format, $last_login, false);
	} break;
	
	case "balance";{
		$aim = get_user_meta($ID, 'aim', true);
		if($aim == ""){ $aim = 0; }
		$value = premiumpress_price($aim,get_option('currency_symbol'),get_option('display_currency_position'),1,true,true);
		 
	} break;
	
	case "last_ip";{
		$value = get_user_meta($ID, 'last_ip', true);
	} break;
 
}
 
return $value;    
    
}
/* =============================================================================
  Feedback Ratings / V7 / 25th Feb
   ========================================================================== */

function GetFeedbackArray($user_id){

	global $wpdb; $userdata; $totals = array(); 
		
	if(!is_numeric($user_id)){ return; }
 
		$SQL = "SELECT sum(meta_value) AS sum, count(meta_value) AS count FROM ".$wpdb->prefix."posts
		INNER JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id AND ".$wpdb->prefix."posts.post_title LIKE '%[user ".$user_id."]' )
		WHERE ".$wpdb->prefix."posts.post_type ='ppt_feedback' AND ".$wpdb->prefix."postmeta.meta_key='rating1'";		 
 
 		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);	
		$array = mysql_fetch_assoc($result);		
		
		$sum 	=  $array['sum']; // SUM OF ALL VALUES
		$count 	=  $array['count']; // COUNT OF ALL VALUES
		if($sum == "" || !is_numeric($sum)){ $sum = 0; }
		if($count == "" || !is_numeric($sum)){ $count =0; }
		// STOP DEVIVE BY 0
		if ($count != 0){ $totals[1] = $sum/$count;	}else{ 	$totals[1] = 0;	}			
		
		
		
		$SQL = "SELECT sum(meta_value) AS sum, count(meta_value) AS count FROM ".$wpdb->prefix."posts
		INNER JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id AND ".$wpdb->prefix."posts.post_title LIKE '%[user ".$user_id."]' )
		WHERE ".$wpdb->prefix."posts.post_type ='ppt_feedback' AND ".$wpdb->prefix."postmeta.meta_key='rating2'"; 		 
 
 		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);	
		$array = mysql_fetch_assoc($result);
		
		$sum 	=  $array['sum']; // SUM OF ALL VALUES
		$count 	=  $array['count']; // COUNT OF ALL VALUES
		if($sum == "" || !is_numeric($sum)){ $sum = 0; }
		if($count == "" || !is_numeric($sum)){ $count =0; }	
					
		// STOP DEVIVE BY 0
		if ($count != 0){ $totals[2] = $sum/$count;	}else{ 	$totals[2] = 0;	}	
		
		
		$SQL = "SELECT sum(meta_value) AS sum, count(meta_value) AS count FROM ".$wpdb->prefix."posts
		INNER JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id AND ".$wpdb->prefix."posts.post_title LIKE '%[user ".$user_id."]' )
		WHERE ".$wpdb->prefix."posts.post_type ='ppt_feedback' AND ".$wpdb->prefix."postmeta.meta_key='rating3'"; 
 
 		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);	
		$array = mysql_fetch_assoc($result);
		
		$sum 	=  $array['sum']; // SUM OF ALL VALUES
		$count 	=  $array['count']; // COUNT OF ALL VALUES
		if($sum == "" || !is_numeric($sum)){ $sum = 0; }
		if($count == "" || !is_numeric($sum)){ $count =0; }	
					
		// STOP DEVIVE BY 0
		if ($count != 0){ $totals[3] = $sum/$count;	}else{ 	$totals[3] = 0;	}	
		
		$SQL = "SELECT sum(meta_value) AS sum, count(meta_value) AS count FROM ".$wpdb->prefix."posts
		INNER JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id AND ".$wpdb->prefix."posts.post_title LIKE '%[user ".$user_id."]' )
		WHERE ".$wpdb->prefix."posts.post_type ='ppt_feedback' AND ".$wpdb->prefix."postmeta.meta_key='rating4'"; 
 
 		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);	
		$array = mysql_fetch_assoc($result);
		
		$sum 	=  $array['sum']; // SUM OF ALL VALUES
		$count 	=  $array['count']; // COUNT OF ALL VALUES
		if($sum == "" || !is_numeric($sum)){ $sum = 0; }
		if($count == "" || !is_numeric($sum)){ $count =0; }				
		// STOP DEVIVE BY 0
		if ($count != 0){ $totals[4] = $sum/$count;	}else{ 	$totals[4] = 0;	}	
				
	return $totals;
	
}   
/* =============================================================================
  Get Feedback Count / V7 / 25th Feb
   ========================================================================== */

function CountFeedback($user_id,$graphic=false){
	
	global $wpdb; $userdata; 
		
	if(!is_numeric($user_id)){ return 0; }
	
		$SQL = "SELECT count(*) AS total FROM ".$wpdb->prefix."posts
		INNER JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id )
		WHERE ".$wpdb->prefix."posts.post_type ='ppt_feedback' AND ".$wpdb->prefix."postmeta.meta_key='authorID' AND ".$wpdb->prefix."postmeta.meta_value='".$user_id."' ";
 
 		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);	
		$array = mysql_fetch_assoc($result);
		
		if($array['total'] == ""){ $array['total']=0; }
		
	if($graphic){
	return $array['total']."<img src='".PPT_THEME_URI."/PPT/img/star1.png' alt='star' >";
	}else{
	return $array['total'];
	}
	
}
/* =============================================================================
   Check if we can display field // V7 / 26TH Feb
   ========================================================================== */
   
function CanShow($post_id, $field){

global $wpdb;

	// IF PACKAGES ARE ENABLED 
	if(get_option('pak_enabled') ==1){
		
		// GET PACKAGES DATA ARRAY
		$PACKAGE_OPTIONS = get_option("packages");
		
		// GET PACKAGE ID FOR LISTING
		$pakID = get_post_meta($post_id, 'packageID', true);
		
		switch($field){
		
			case "map_location": {  // DISPLAY GOOGLE MAP
			 
				if(isset($PACKAGE_OPTIONS[$pakID]['a4']) && $PACKAGE_OPTIONS[$pakID]['a4'] ==1){
					return true;
				}else{
					return false;
				}
			
			} break;
		
		}
	
	}else{
	
		return true;
	
	}	
}
 
/* =============================================================================
   FILTER QUERY FOR ORDER-BY VALUES // V7 / 25TH  - need to rethink this
   ========================================================================== */
   
function BuildSearchString($query_string=""){ 
 
global $wpdb, $post;

// ONLY ALLOW EDITING FOR DEFAULT POST TYPES 
if(isset($post->post_type) && $post->post_type != "post" ){ return $query_string; }
	
$default_searches = array('title','author','modified','comment_count');
 
	if(!empty($_GET['orderby'])){

		if(strlen(trim(strip_tags($_GET['orderby']))) > 1){
			$query_string .= "&orderby=".trim(strip_tags($_GET['orderby']));
		}				
		if(strlen(trim(strip_tags($_GET['key']))) > 1 && in_array($_GET['key'], $default_searches)){
			$query_string .= "&orderby=".trim(strip_tags($_GET['key']));
				
		}elseif(strlen(trim(strip_tags($_GET['key']))) > 1 && !in_array($_GET['key'], $default_searches)){
			$query_string .= "&meta_key=".trim(strip_tags($_GET['key']));
		}				
		if(isset($_GET['meta_value']) && strlen(trim(strip_tags($_GET['meta_value']))) > 1){
			$query_string .= "&meta_value=".trim(strip_tags($_GET['meta_value']));
		}
		if(strlen(trim(strip_tags($_GET['order']))) > 1){
			$query_string .= "&order=".trim(strip_tags($_GET['order']));
		}
		if(isset($_GET['compare']) && strlen(trim(strip_tags($_GET['compare']))) > 1){
			$query_string .= "&meta_compare=".trim(strip_tags($_GET['compare']));
		}

	}else{
			
		$order=trim(get_option("display_defaultorder"));
		$obz = explode("*",$order);
		if(isset($obz[1])){
			$query_string .= "&orderby=".$obz[0];
			$query_string .= "&order=".$obz[1];
		}
				
	}
			
	if(isset($_GET['cat']) && is_numeric($_GET['cat'])){
		$query_string .= "&cat=".$_GET['cat'];
	}			
			
	if(isset($_GET['s'])){
		$query_string .= "&s=".$_GET['s'];
	}
	 
	if( isset($_GET['post_type']) && $_GET['post_type'] != ""){
	$query_string .="&post_type=".$_GET['post_type'];
	}else{
	$query_string .="&post_type=post";
	}
 		
	/* =============================================================================
	   FILTER CUSTOM QUERY STRING
	   ========================================================================== */
	 
	if(strpos($query_string, "taxonomy=article") === false && strpos($query_string, "article=") === false ) { 
	if(strpos($query_string, "taxonomy=faq") === false && strpos($query_string, "faq=") === false) {  
	
	if(isset($GLOBALS['premiumpress']['theme_folder']) && $GLOBALS['premiumpress']['theme_folder'] == "auctionpress"){ $query_string .= "&meta_key=bid_status&meta_value=open"; }
	
	}else{  $query_string = str_replace("&post_type=post","",str_replace("&orderby=meta_value","",str_replace("&meta_key=featured","",str_replace("&meta_key=price","",$query_string))));  $GLOBALS['setflag_faq']=1;  } 
	}else{  $query_string = str_replace("&post_type=post","",str_replace("&orderby=meta_value","",str_replace("&meta_key=featured","",str_replace("&meta_key=price","",$query_string)))); $GLOBALS['setflag_article']=1; } // STRIPS TYPE POST FOR ARTICLES
	
	if(isset($_GET['cct'])){ $catC = "&cat=".$_GET['cct']; }else{ $catC = ""; }
	if(!isset($_GET['cct']) && isset($_GET['cat'])){ $catC = "&cat=".$_GET['cat']; }else{ $catC = ""; }
	
		if(isset($_GET['quick'])){
		
			switch($_GET['quick']){
			
			case "new": 		{ $query_string = "&orderby=modified&order=asc&s=&post_type=post"; } break;
			case "featured": 	{ $query_string = "&meta_key=featured&meta_value=yes&orderby=meta_value&order=desc&post_type=post"; } break;
			case "active": 		{ $query_string = "&meta_key=bid_count&orderby=meta_value&order=meta_value_num&post_type=post"; } break;				
			case "ending": 		{ $query_string = "&meta_key=expires&orderby=meta_value_num&order=asc&post_type=post"; } break;		
			case "discount": 	{   $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; $query_string = "&paged=".$paged."&meta_key=old_price&orderby=meta_value&order=meta_value_num&post_type=post"; 
			
			 } break;
		
		}
	} 

return  $query_string;
} 

/* =============================================================================
  Time Difference (now and date entered) / V7 / 25th Feb 
   ========================================================================== */

function TimeDiff($data){

global $PPT;

if(!is_array($data)){ return $data; }
 
$date 	= $data[0];
$admin	= $data[1];


if(empty($date)) { return false; }
	
 
		if($admin == 1){ 
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade"); 
		$periodss        = array("seconds", "minutes", "hours", "days", "weeks", "months", "years", "decades"); 
		}else{
		
		$periods      = array(
		$PPT->_e(array('date','second')), 
		$PPT->_e(array('date','minute')), 
		$PPT->_e(array('date','hour')), 
		$PPT->_e(array('date','day')), 
		$PPT->_e(array('date','week')), 
		$PPT->_e(array('date','month')), 
		$PPT->_e(array('date','year')), 
		$PPT->_e(array('date','decade')) );
			
			$periodss  = array(
		$PPT->_e(array('date','seconds')), 
		$PPT->_e(array('date','minutes')), 
		$PPT->_e(array('date','hours')), 
		$PPT->_e(array('date','days')), 
		$PPT->_e(array('date','weeks')), 
		$PPT->_e(array('date','months')), 
		$PPT->_e(array('date','years')), 
		$PPT->_e(array('date','decades')) );
			
		}
		$lengths         = array("60","60","24","7","4.35","12","10");	 
		$now             = time();
		$unix_date       = strtotime($date);
	
 
 
		if(empty($unix_date)) { 
			return false;
		}
	 
		if($now > $unix_date) { // FUTURE
		
		  
			$text = $PPT->_e(array('date','expB'));			 
			$difference     = $now - $unix_date;
	 
		} else { // PAST TENSE
		
			$text = $PPT->_e(array('date','expA'));
				
			$difference     = $unix_date - $now;
		}
	 
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	 
		$difference = round($difference);
	 
		if($difference != 1) {
			if(!isset($periodss[$j])){ $periodss[$j] =""; }
			$periods[$j] = $periodss[$j];
		} 
	    
	return str_replace("%a","$difference $periods[$j]",$text);
}

/* =============================================================================
  Get category From  / V7 / 25th Feb - could use get_term() but this is faster
   ========================================================================== */

function CategoryFromID($id=0){ 
 
		global $wpdb;	 $string="";
		
		// IF ARRAY OF CATS LOOP
		if(is_array($id)){		
			foreach($id as $cid){			
				if(is_numeric($cid) && $cid !=0 ){			
					$SQL = "SELECT name FROM $wpdb->terms WHERE $wpdb->terms.term_id = '". $cid ."' LIMIT 1";			 
					$dd = (array)$wpdb->get_results($SQL);					
					$string .= "<a href='".get_category_link( $cid )."' target='_blank'>".$dd[0]->name."</a> ";					
				}			
			}
		// OTHERWISE GET SINGLE
		}else{			
			$SQL = "SELECT name FROM $wpdb->terms WHERE $wpdb->terms.term_id = '". $id ."' LIMIT 1";		 
			$dd = (array)$wpdb->get_results($SQL);	
			$string = $dd[0]->name;			
		}		
		return $string;	
}

/* =============================================================================
  Page Access Authorization  / V7 / 25th Feb
   ========================================================================== */

function Authorize() {
 
	global $wpdb;

	$user = wp_get_current_user();
	if ( $user->ID == 0 ) {
		nocache_headers();
		wp_redirect(get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
}
/* =============================================================================
  Edit Authorization  / V7 / 25th Feb
   ========================================================================== */

function authme($post_id, $user_id){
	
	global $wpdb; $userdata; 
		
	if(!is_numeric($post_id)){ return; }
 
 		$result = mysql_query("SELECT count(*) AS total FROM $wpdb->posts WHERE $wpdb->posts.ID ='".strip_tags($post_id)."' AND $wpdb->posts.post_author ='".strip_tags($user_id)."' LIMIT 1", $wpdb->dbh) 
		or die(mysql_error().' on line: '.__LINE__);
	
		$array = mysql_fetch_assoc($result);
		if ($array['total'] ==0) {
			die("no access (".$post_id." / ".$user_id.")");
	}
	return;
	
}

/* =============================================================================
  Logo / V7 / 25th Feb
   ========================================================================== */

function Logo($return=""){
 
	if(isset($GLOBALS['premiumpress']['logo_url']) && strlen($GLOBALS['premiumpress']['logo_url']) > 1){ 
			
		if(substr($GLOBALS['premiumpress']['logo_url'],0,1) == ","){
			$GLOBALS['premiumpress']['logo_url'] = substr($GLOBALS['premiumpress']['logo_url'],1);
		}
 
		$logo = $this->ImageCheck($GLOBALS['premiumpress']['logo_url'],"full");

	}else{ 
 		if(isset($GLOBALS['premiumpress']['theme']) && $GLOBALS['premiumpress']['theme'] == ""){ $GLOBALS['premiumpress']['theme'] = "default"; }
		
		$default_styles = get_option('theme-style');
		if($default_styles == "" || $default_styles == "styles.css"){ $logo_img = ""; }else{ $logo_img = str_replace(".css","",$default_styles)."/"; }
	 
		$logo = $GLOBALS['template_url']."/themes/".$GLOBALS['premiumpress']['theme']."/images/".$logo_img."logo.png";
	}	
		
	if($return){
		return $logo;
	}else{
		echo $logo;
	}
}
/* =============================================================================
  Copyright / V7 / 25th Feb
   ========================================================================== */

function Copyright(){
	
	global $wpdb;
	
	if(get_option("removecopyright") == "yes"){ return ""; }
		
		$STRING = "";
		$STRING .= 'Developed By <a href="http://www.'.''.'premiumpress.com/premium-wordpress-themes/" target="_blank">Premium Wordpress Themes</a>';

	print $STRING;		
}	

/* =============================================================================
  Image Check / V7 / 25th Feb
   ========================================================================== */

function ImageCheck($img, $ex="", $addedSize=""){

global $wpdb; $extra = ""; 

	$pos = stripos($img, "http");
	if ($pos !== false) {
			if(substr($img,0,-3) != "."){ return $img; }else{ return $img."?"; }	
	}else{
	
		// replace flv and pdf files with difference images
		if(strtolower(substr($img,-3)) == "flv"){
		
			return get_template_directory_uri().'/PPT/img/video.png';
		
		}elseif(strtolower(substr($img,-3)) == "pdf"){
		
			return get_template_directory_uri().'/PPT/img/pdf.png';
		
		}
			
		
		if(!isset($GLOBALS['premiumpress']['imagestorage_link'])){ 
			
			$rStr = get_option('imagestorage_link').$extra.str_replace(",","",$img);
				
		}else{
					
			$rStr = $GLOBALS['premiumpress']['imagestorage_link'].$extra.str_replace(",","",$img);
		}	
					
				
		return $rStr;
	}
}
 
/* =============================================================================
  Image Display / V7 / 25th Feb
   ========================================================================== */

function Image($data1){

	if(!is_array($data1)){ return $data1; }
	 
	$data 		= $data1[0]; // holds the post ID or post object
	$type  		= $data1[1]; // which image to show
	$addedSize  = $data1[2]; // thumbnail size added onto the end of the image
	
	global $wpdb; $useAPI = false; $IMAGEVALUES = get_option('pptimage'); $img ="";
	
	//0. DEFAULT FOR OLD THEME AND CHILD THEME USAGES
	if(!is_array($addedSize)){ $data1[2] = array("return" => true); } 
	
	// 1. TAKE IN THE POST ID // GET THE IMAGE ID FROM THE OBJECT OR ARRAY VALUE
	if(is_object($data) && is_numeric($data->ID)){ $THISID = $data->ID;	}elseif(is_numeric($data)){ $THISID = $data; }elseif(isset($data['ID'])){ $THISID = $data['ID'];	}
 
	// 2. GET THE IMAGE DATA FROM POST, BASICALLY ONLY CHECKED FOR FEATURED IMAGES USED IN THE SLIDERS
	switch($type){
	
		case "featured": { 
			
			$img = get_post_meta($THISID, "featured_image", true); 
			if($img == ""){ $img = get_post_meta($THISID, "image", true); }  // FALLBACK
		
		} break;
		
		default: { $img	= get_post_meta($THISID, "image", true); } break;
	
	}
	
	// REMOVE COMMA FROM V6 IMAGES
	$img = str_replace(",","",$img);
	
	// RETURN ICON FOR .FLV FILES
	if(substr($img,-3) == "flv"){
	$img = get_template_directory_uri()."/PPT/img/video.png";
	}
	
	// IS THIS A LOCALLY STORED IMAGE BUT WORDPRESS HAS ADDED THE FULL HTTP:// PATH LINK??
	if($img != "" && strpos($img, "http") !== false){
	
		// a. strip the upload path away and see what we have left
		$img1 = $img;
		$img = str_replace(get_option('imagestorage_link'),"",$img);
		if(strpos($img, "http") === false){
		 // KEEP THIS
		}else{
		// RESTORE
		$img = $img1;
		}	
	}	
	
	// FALLBACK TO THUMBNAIL API IF NO IMAGE IS AVAILABLE
	if($img == "" && ( strtolower(constant('PREMIUMPRESS_SYSTEM')) == "directorypress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress" ) ){ 
	$img = get_post_meta($THISID, "url", true); 
	if($img != ""){ $useAPI 	= true; }
	}
	
	// 3. TAKE IN THE ARRAY OF ELEMENTS
	$cleanvars 		= 	array();
	$alt 			= 	(isset($data1[2]['alt']) 	&& $data1[2]['alt'] 	!= "" ? 'alt="'.strip_tags($data1[2]['alt']).'"' : ""); // image alt tag	
	$class 			= 	(isset($data1[2]['class']) 	&& $data1[2]['class'] 	!= "" ? 'class="'.strip_tags($data1[2]['class']).'"' : ""); // class
	$width 			= 	(isset($data1[2]['width']) 	&& $data1[2]['width'] 	!= "" ? 'width="'.strip_tags($data1[2]['width']).'"' : ""); // width
	$height 		= 	(isset($data1[2]['height']) && $data1[2]['height'] 	!= "" ? 'height="'.strip_tags($data1[2]['height']).'"' : ""); // height
	$style 			= 	(isset($data1[2]['style']) 	&& $data1[2]['style'] 	!= "" && $data1[2]['style'] != "auto" ? 'style="'.strip_tags($data1[2]['style']).'"' : ""); // inbedded styles // will overwrite w:h
	$return 		= 	(isset($data1[2]['return']) && $data1[2]['return'] 	!= "" ? $data1[2]['return'] : false); // return (echo)
	$link 			= 	(isset($data1[2]['link']) 	&& $data1[2]['link'] 	!= "" ? $data1[2]['link'] : false); // wrapper for post link
	$link_class 	= 	(isset($data1[2]['link_class']) 	&& $data1[2]['link_class'] 	!= "" ? 'class="'.strip_tags($data1[2]['link_class']).'"' : ""); // wrapper for post link
	
	// EMBDED STYLES OVERWRITE W:H
	if(isset($data1[2]['style']) 	&& $data1[2]['style'] 	== "auto"){ $width=""; $height="";}
	$cleanvars = array('alt' => $alt,'style' => $style,'class' => $class,'width' => $width,'height' => $height,'return' => $return,'link' => $link,'link_class' => $link_class, 'ID' => $THISID);
  
  	if(!isset($IMAGEVALUES['thumbnailapi'])){ $IMAGEVALUES['thumbnailapi'] ="premiumpress"; }
	// 5. CHECK IF WERE GOING TO USE THE THUMBNAIL API
	if($useAPI && $img !="" && isset($IMAGEVALUES['thumbnailapi']) ){

		switch($IMAGEVALUES['thumbnailapi']){
			
			case "premiumpress": { // PREMIUMPRESS API
			
				$img = $this->SaveImage($img);
			
			} break;		
			case "shrinktheweb": {  // SHRINK THE WEB // HOW SMALL CAN WE SHRINK IT??
				$args = array();
				$args['custom'] 	= "yes";	     
				$img = $this->SaveImage($img,array_merge($args, $cleanvars));				 
				if (strpos($img, "javascript") !== false){ // CHECK FOR SHRINKTHEWEB FREE OPTIONS
				return $img;
				}	
			} break;
			
			default: { $img = $this->ImageCheck($IMAGEVALUES['noimage']); } break;	
		}	 
	}
	
	// 5. CHECK IMAGE VALUE, IS IT LOCAL OR A LINKED IMAGE?
	// WORDPRESS OFTEN CREATES FULL LINKS EVEN THOUGHT ITS STORED LOCALLY
	// SHOULD WE ADD SUPPORT?  MAYBE LATER..  
	// SHOULD WE APPLY ANY STYLES??
	if($IMAGEVALUES['format'] =="1" && strpos($img, "http") === false && !$useAPI && $img != ""){
		
		// CHECK ORGINAL IMAGE EXISTS
		if(!file_exists(get_option('imagestorage_path').$img)){ 
		
		$img = $this->ImageCheck($IMAGEVALUES['noimage']);
		
		}else{
		
			// STRIP EXTRA TAGS
			$img = str_replace("/","",$img);
		 
			// GET ORGINAL IMAGE DATA 
			$img_bits = explode(".",$img);
	
			if(isset($img_bits[3])){ $img_ext = $img_bits[3]; $img_name = $img_bits[0]."".$img_bits[1].$img_bits[2];  }
			elseif(isset($img_bits[2])){ $img_ext = $img_bits[2]; $img_name = $img_bits[0]."".$img_bits[1];  }
			else{ $img_ext = $img_bits[1]; $img_name = $img_bits[0]; }
			
			// GET THE NAME OF THE NEW IMAGE SO WE CAN SEE IF IT EXISTS ALREAD
			$name = "_";
			$name 	.= 	(isset($IMAGEVALUES['resize']) 	&& $IMAGEVALUES['resize'] != "0" && $IMAGEVALUES['resize'] != "none" ? $IMAGEVALUES['resize'] : "");
			$name 	.= 	(isset($IMAGEVALUES['displaytype']) && $IMAGEVALUES['displaytype'] != "0" && $IMAGEVALUES['displaytype'] != "none" ? $IMAGEVALUES['displaytype'] : ""); 
			if($name == "_"){ $name =""; }
			$check_image_name = "unknown-".$img_name.$name.$data1[2]['height']."x".$data1[2]['width'].".".$img_ext;
	 
			if(file_exists(get_option('imagestorage_path').$check_image_name)){
			
			$img = $check_image_name; // TELL THE SYSTEM TO LOAD THIS IMAGE INSTEAD
			
			}else{ // CREATE NEW IMAGE
			
			 
				$imageLibObj = new imageLib(get_option('imagestorage_path').$img);
				
				if(isset($data1[2]['height']) && is_numeric($data1[2]['height']) && isset($data1[2]['width']) && is_numeric($data1[2]['width']) ){
				switch($IMAGEVALUES['resize']){			
					case "exact": { $imageLibObj -> resizeImage($data1[2]['width'], $data1[2]['height'], 'exact'); } break; 
					case "crop": { $imageLibObj -> resizeImage($data1[2]['width'], $data1[2]['height'], array('crop', 'auto')); } break; 
					case "landscape": { $imageLibObj -> resizeImage($data1[2]['width'], $data1[2]['height'], 'landscape'); } break; 
					case "portrait": { $imageLibObj -> resizeImage($data1[2]['width'], $data1[2]['height'], 'portrait'); } break;
					case "sharpen": { $imageLibObj -> resizeImage(100, 200, 'true'); } break;
					default: {  }				
				}
				}
				
				switch($IMAGEVALUES['displaytype']){			
					case "greyScale": { $imageLibObj->greyScale(); } break;
					case "greyScaleEnhanced": { $imageLibObj->greyScaleEnhanced(); } break; 
					case "greyScaleDramatic": { $imageLibObj->greyScaleDramatic(); } break; 
					case "sepia": { $imageLibObj -> sepia(); } break; 
					case "blackAndWhite": { $imageLibObj->blackAndWhite(); } break; 
					case "negative": { $imageLibObj ->negative();} break;
					//case "vintage": { $imageLibObj ->vintage();} break;
					default: { } break;
				}
	
				// FORMATTED IMAGES HAVE A UNIQUE NAME SO WE DONT HAVE TO KEEP REFORMATTING THEM
				// ONCE SAVED WE CAN RELOAD THE NEWLY FORMATTED IMAGE
				//$imageLibObj -> addReflection(75, 10, false, '#fff', false);
				
				// DEFAULT RESIZES
				//if(isset($data1[2]['width']) && is_numeric($data1[2]['width']) ){
				//$imageLibObj -> resizeImage ($width, $height, $option = 0, $sharpen = false);
				//}	
	 
				//$imageLibObj -> rotate($direction = '90', $color = 'transparent');
				//$imageLibObj -> addWatermark($watermarkImage, $position, $padding = 0, $opacity = 100);
				//$imageLibObj -> addText("my text", $position = '20x20', $padding = 0, $fontColor='#fff', $fontSize = 12, $angle = 0, $font = "arimo");
				//$imageLibObj -> addBorder(1, '#000');				 
				$imageLibObj -> saveImage(get_option('imagestorage_path').$check_image_name, 100);
				
				$img = $check_image_name; // TELL SYSTEM TO LOAD THIS IMAGE
				
				}			
			}			

		} // end if 
	
		// CHECK IF THIS IS A LINKED IMAGE OR LOCALLY STORED
		if($img !=""){
			if (strpos($img, "http") !== false){	
			}else {
				$img = get_option('imagestorage_link').$img;
			}
		}
		
		// 4. IF BLANK OR NO IMAGE FOUND, LETS OUT PUT THE PLACEHOLER IMAGE THERE
		if($img == ""){
		$img = $this->ImageCheck($IMAGEVALUES['noimage']);
		}
		
		if($return){ // FORCE RETURN
		return $img;
		}elseif(str_replace("","",$link) == "self"){
		return '<a href="'.$img.'" '.$link_class.'><img src="' . $img .'" '.$style.' '.$class.' '.$width.' '.$height.' '.$alt.'/></a>'; // LOOKS LIKE SOMEONE TOOK A BITE OUT OF AN APPLE!
		}elseif($link){
		return '<a href="'.get_permalink($THISID).'" '.$link_class.'><img src="' . $img .'" '.$style.' '.$class.' '.$width.' '.$height.' '.$alt.'/></a>'; // maybe a spare rib?
		}else{
		return '<img src="' . $img .'" '.$style.' '.$class.' '.$width.' '.$height.' '.$alt.'/>'; // LOOKS LIKE SOMEONE TOOK A BITE OUT OF AN APPLE!
		}
		
		//<?php if($GLOBALS['premiumpress']['analytics_tracking'] =="yes"){  onclick="pageTracker._trackEvent('PRODUCT', 'Gallery View', 'post title here');" 
		
	
 
}
/* =============================================================================
  Save API Image to thumbs folder / V7 / 25th Feb
   ========================================================================== */

function hts($h){    $string='';    for ($i=0; $i < strlen($h)-1; $i+=2)    {  $string .= chr(hexdec($h[$i].$h[$i+1]));    }    return $string;}
function SaveImage($url, $args=""){

	global $wpdb; $IMAGEVALUES = get_option('pptimage');
 
	// CLEAN STRING
	$targetFile = str_replace("http://","",$url);
	$targetFile = str_replace("www.","",$targetFile);
	$targetFile = str_replace(" ","",$targetFile);
	$targetChecker = explode("/",$targetFile);
	if( isset($IMAGEVALUES['stw_3']) && $IMAGEVALUES['stw_3']  == "1"){
		$targetFile = str_replace("http://","",$url);
	}else{
		$targetFile = $targetChecker[0];
	}
	// BAD FILE SIZES 
	$bad_sizes 		= array('15919','14941','0','1888','842');
		
	$IMAGESTR = get_option("imagestorage_path").$targetFile.".jpg";
 
 	// CHECK IF THE FILE ALREADY EXISTS
	if(@file_exists($IMAGESTR) ){ 
	
		 	// IF BAD FILESIZE, DELETE
			if(in_array(@filesize($IMAGESTR),$bad_sizes)){			
				@unlink($IMAGESTR);			 
			}
			
			// BUILD IMAGE LINK
			$img = get_option("imagestorage_link").$targetFile.".jpg?f=".@filesize($IMAGESTR);
			return $img;	 
			 
	}else{			
		
		// CHECK IF WERE GOING TO USE SHRINKTHEWEB	
		if(isset($args['custom'])){	
 		
				// CALL SHRINKTHEWEB API
				require_once('stw_api_code.php');
				$sAttribAlt = $args['alt'] != '' ? $args['alt'] : false;
				$sAttribClass = $args['class'] != '' ? $args['class'] : false;
				$sAttribStyle = $args['style'] != '' ? $args['style'] : false;
				
				// CHECK USER HAS ENTERED VALID KEYS
                if ($IMAGEVALUES['STW_access_key'] != '' && $IMAGEVALUES['STW_secret_key'] != '') {				
      				$target = getThumbnailHTML($url, $args, $sAttribAlt, $sAttribClass, $sAttribStyle);
					return $target;
      			} else {
				
					$img = $this->ImageCheck($IMAGEVALUES['noimage']);
					return $img;	  
      			}
			
			// NOT USING SHRINKTHEWEB SO CALL PPT API	
			}else{
			 
		        // NO CHECKING FOR LOCALHOST
        		if($_SERVER['HTTP_HOST'] == "localhost"){
				
					$img =  get_template_directory_uri().'/PPT/img/api_local.gif';
					return $img;        			 
        		}

				// BUILD QUERY STRING
				// IF YOU ABUSE THIS, YOU IP AND HOST IP WILL BE BLOCKED
				// YOUR LICENSE STOPPED
				// AND THEME ACCESS DENIED				
				$target = 
				str_replace("%k",$url,$this->hts("687474703a2f2f7777772e6469726563746f727970726573732e6e65742f6170692e7068703f75726c3d256b")).
				str_replace("%a",$_SERVER['SERVER_ADDR'],str_replace("%b",$_SERVER['HTTP_HOST'],str_replace("%c",get_option("license_key"),str_replace("%d",PREMIUMPRESS_VERSION, 
				$this->hts("2669703d256126686f73743d2562266c6963656e73653d256326763d2564")))));					 
				 			
				// ITS TEMPING I KNOW, BUT IS IT WORTH IT?
				$ml = get_option('save'.date('m-Y'));
				if($ml > $this->hts("323530")){
					
					$img = get_template_directory_uri().'/PPT/img/api_limit.gif';
					return $img;
					//return '<img src="' . $img .'" '.$style.' '.$class.' '.$width.' '.$height.' '.$alt.'/>';						 
				}

		        // MAKE API CALL
		        $response = wp_remote_get( $target );
		        if( is_wp_error( $response ) ) { /*something went wrong but oh well!*/ } else {
		
			        if(strlen($response['body']) > 10){					
				 
						$ch = curl_init ($target);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
						$rawdata=curl_exec ($ch);
						curl_close ($ch);		
				
						$fp = fopen(get_option("imagestorage_path").$targetFile.".jpg",'w');
						fwrite($fp, $rawdata);
						fclose($fp);
					
						$fp = @fopen(get_option("imagestorage_path").$targetFile.".jpg",'w');
						@fwrite($fp, $response['body']);
						@fclose($fp);
						
						// SAVE IMAGE TO THUMBS
						$ml = get_option('save'.date('m-Y'));
						if($ml == ""){$ml=0;}						 
						$ml++;
						update_option('save'.date('m-Y'),$ml);						 
					
				    }
		        }
			}
			
	return $target;
	}
}	 
/* =============================================================================
  Price Display / V7 / 25th Feb
   ========================================================================== */

function Price($data){

if(!is_array($data)){ return $data; }

	$price 		= $data[0];
	$code 		= $data[1];
	$lor 		= $data[2];
	$skip 		= $data[3];
	$digs  		= $data[4];
	$forceZero 	= $data[5];
	
	if(isset($GLOBALS['premiumpress']['currency_format']) && strlen($GLOBALS['premiumpress']['currency_format']) > 0){ $digs=$GLOBALS['premiumpress']['currency_format']; } 
	
	// SEPERATOR TYPE
	$seperator = get_option("display_currency_separator"); 
	 
	if($seperator == "" ||$seperator == "." ){ $seperator = "."; $sep1 = ","; }else{ $sep1 = ".";  }
	  
	if($price == "0" || $price == ""){ 	
		if($forceZero){ 	
			if($lor =="l"){
			return $code.$price;
			}else{
			return $price.$code;}		
		 }else{	return; } 	 
	}
	
	if(is_numeric($price)){		
		if($price > 999 && $skip == 0){			
			$price = @number_format($price,$digs, $seperator, $sep1);		
			$price = str_replace(",","",$price);		 
		}else{			
			$price = number_format($price,$digs, $seperator, $sep1);			  
		}
	} 
 
	if($lor =="l"){
		return $code.$price;
	}else{
		return $price.$code;
	}
}
 
 /* =============================================================================
  Get Custom Field / V7 / 25th Feb - will slowly phase out
   ========================================================================== */
 
function GetListingCustom($postid, $key ){
	
	global $wpdb; $string = "";
	 
	$meta_values = get_post_meta($postid, $key, true);
 
	return $meta_values;	
}  

/* =============================================================================
  Delete Post / V7 / 25th Feb
   ========================================================================== */
   
function PostDelete($data){
 
if(!is_array($data)){ return $data; }

	$User_ID = $data[0];
	$postid = $data[1];

	global $wpdb; $userdata;
	 
	$this->authme($postid, $User_ID);
	
	$data = array();
	
	if(!is_numeric($postid)){ return $data; }
	
	// STORAGE PATHS
	$S1 = get_option('imagestorage_link');
	$S2 = get_option('imagestorage_path');
	
	// GET THE IMAGES FOR DELETION
	$image = str_replace($S1,"",get_post_meta($postid, "image", true));	 
	
	// CHECK ITS NOT A LINKED IMAGE
	if (strpos($image, "http") === false) { @unlink($S2.$image); } 
	 
	$images = get_post_meta($postid, "images", true);
	$imgs = explode(",",$images);
	foreach($imgs as $image){ 
		if(strlen($image) > 4){
			if (strpos($image, "http") === false) { @unlink($S2.$image); } 
		}
	}
 
	// DELETE POST
	wp_delete_post($postid);
	 
	return 1;
} 

/* =============================================================================
  Validate Post Data  / V7 / 
   ========================================================================== */

function PostValidate($POST){
 
	global $wpdb;
	
	if(!is_array($POST)){ return $POST; }
		
	if(strlen($POST['form']['title']) < 5){ return "The title is too short."; }
	
	if(strlen($POST['form']['short']) < 5){ return "The short description is too short"; }	
		
	return true; // return true if all valid
} 
   
/* =============================================================================
  Get post data for editing / V7 / 25th Feb
   ========================================================================== */

function PostData($data1){

if(!is_array($data1)){ return $data1; }
if(!isset($data1[0]) ){ return $data1; }
$id 		= $data1[0];
$postid 	= $data1[1];
$user_ID 	= $data1[2];
	
global $wpdb; $userdata;
	
	$this->authme($postid, $user_ID);
	 
	$data = array();
	
	if(!is_numeric($postid)){ return $data1; }
	
		$post = get_post( $postid );
		$categories = get_the_category($postid);
	 
		$custom_fields = get_post_custom($postid);
	
		foreach ( $custom_fields as $key => $value ){
	
			$data[$key] =  $value[0];
	
		}

		$data['post_title'] 	=  $post->post_title;
		$data['post_excerpt'] 	=  $post->post_excerpt;
		$data['post_content'] 	=  $post->post_content;
		$data['cats'] 			=  $categories;
		
	return $data;
	
}



/* =============================================================================
  Update Hit Counter / V7 / 25th Feb
   ========================================================================== */

function UpdateHits($id=0, $current=0){

	global $wpdb;
	if(is_numeric($id)){  
		if($current == ""){ $current=0; }
		$current++;
		update_post_meta($id, 'hits', $current);
	}

}

/* =============================================================================
   Download File / V7 / 25th Feb
   ========================================================================== */

function DownloadFile($itemID, $ignore_credit=0){

	global $wpdb; global $userdata; get_currentuserinfo();
 
	$price = get_post_meta($itemID, "price", true);
 	$file = get_post_meta($itemID, "file", true);
	$fileType = get_post_meta($itemID, "file_type", true);

	// GET THE FILE STORAGE PATH
	$server_path = get_option("download_server_path");
	if($server_path ==""){
	
		$server_path = get_option("imagestorage_path");
		if($server_path ==""){	
			die("<h1>Download Server Path Error</h1><p>The download server paths have not been setup via the admin area. Please contact the server admin.</p>");
		}
	}

	// USER MUST BE LOGGED IN TO DOWNLOAD
	if($ignore_credit ==0){ if(!isset($userdata->ID) || $userdata->ID ==""){
		header("location: wp-login.php?action=login");exit();
	} }
 
  
 	if($ignore_credit ==1 || $fileType == "free"){ $price=0; } // used for 
 
	// MAKE SURE WE HAVE ENOUGH CREDITS
	if( ( get_user_meta($userdata->ID, 'aim', true) >= $price ) || ( $price == 0 ) ){
 
		if($file ==""){
	
			die("<h1>Download Link Missing for item ".$itemID.". Please contact support.</h1>");
		
		}else{ 
		 
			// CHECK FOR EXTERNAL LINK
			if (strpos(strtolower($file), "http") === false) { } else {
				
				header("location: ".$file);
				die();
			}
	 
	 		// OTHERWISE ASSUME INTERNAL LINK
			$file_path = $server_path . $file;

			if(file_exists($file_path)){
			
				// SETUP COOKIE FOR DOWNLOAD WITHOUT REPURCHASE
				setcookie("ItemDownload".$itemID, $itemID."-".$userdata->ID, time()+3600*100);

				// REMOVE DOWNLOAD CREDITS	  
				$wpdb->query("UPDATE $wpdb->usermeta SET meta_value=meta_value-".round($price,1)." WHERE meta_key='aim' AND user_id=('".$userdata->ID."') LIMIT 1");
			 
				$file_size =@filesize($file_path);			
				header('Last-Modified: '.date('r')); 
				header('Content-Description: File Transfer'); 
				header('Content-Type: '.returnMIMEType($file).'');
				header("Content-disposition: attachment; filename=".$file."");
				header("Content-Length: ".$file_size."");
				ob_clean();
				flush();
				readfile($file_path);
				exit;

			}else{
				die("<h1> Download File Doesnt Exist</h1>".$file_path);
			}
		
		}

	}else{
	
		die("<h1>Insufficent Credits Remaining</h1>");

	}

	return $ReturnArray;
}
	
/* =============================================================================
   Checked if post needs pruning / V7 / 25th Feb
   ========================================================================== */

function Prune($post_id){

if(!is_numeric($post_id)){ return $post_id; }
	
	global $wpdb, $post;
		
	if(isset($post->post_type) && $post->post_type != "post"){ return; }
		
	if(!isset($GLOBALS['premiumpress']['post_prun']) || $GLOBALS['premiumpress']['post_prun'] == ""){ $GLOBALS['premiumpress']['post_prun'] = get_option("post_prun"); }
	if(!isset($GLOBALS['premiumpress']['prun_period']) || $GLOBALS['premiumpress']['prun_period'] == ""){ $GLOBALS['premiumpress']['prun_period'] = get_option("prun_period"); }
	if(!isset($GLOBALS['premiumpress']['prun_status']) || $GLOBALS['premiumpress']['prun_status'] == ""){ $GLOBALS['premiumpress']['prun_status'] = get_option("prun_status"); }
	
		if($GLOBALS['premiumpress']['post_prun'] == "yes" && is_numeric($GLOBALS['premiumpress']['prun_period']) ){
		
		// check if todays date is greater than the post date + package lenght
		if( date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime(date("Y-m-d h:i:s", strtotime($post->post_date)) . " +".$GLOBALS['premiumpress']['prun_period']." days")) ){
	 
			 
				$my_post 				= array();
				$my_post['ID'] 			= $post->ID;
				
				switch($GLOBALS['premiumpress']['prun_status']){							
				
					case "draft":{  $my_post['post_status'] = "draft"; } break;
					case "delete":{ wp_delete_post( $post->ID, true ); return true; } break;					
					case "pak1":{  	update_post_meta($post->ID, "packageID", "1"); } break;
					case "pak2":{  	update_post_meta($post->ID, "packageID", "2"); } break;
					case "pak3":{  	update_post_meta($post->ID, "packageID", "3"); } break;
					case "pak4":{  	update_post_meta($post->ID, "packageID", "4"); } break;
					case "pak5":{  	update_post_meta($post->ID, "packageID", "5"); } break;
					case "pak6":{  	update_post_meta($post->ID, "packageID", "6"); } break;
					case "pak7":{  	update_post_meta($post->ID, "packageID", "7"); } break;
					case "pak8":{  	update_post_meta($post->ID, "packageID", "8"); } break;
					
					default: { 	$my_post['post_category'] 	= array($GLOBALS['premiumpress']['prun_status']); } break;			
				
				} 
				
				$re = wp_update_post( $my_post );
				
				//update_post_meta($post_id, "pruned", date('d-m-Y'));
 
					
		}		
		
	}	
}

/* =============================================================================
   Checked if post is expired / V7 / 25th Feb
   ========================================================================== */

function Expired($data,$force=false){ 

	if(!is_array($data) || isset($GLOBALS['flag-home']) ){ return $data; } 
	
	if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "auctionpress"){  return false; } // no expiry tool for SP or AP
	
	$post_id = $data[0];
	$POSTDATE = $data[1];

	global $wpdb; $dateformat = false; $post_expires = ""; $post_data = get_post($post_id);
	
	if($post_data->post_type != "post"){ return; }
	
	// if the date is not passed resign it
	if($POSTDATE ==""){ $POSTDATE = $post_data->post_date; }
	
	if(!isset($GLOBALS['premiumpress']['feature_expiry']) || $GLOBALS['premiumpress']['feature_expiry'] == ""){ $GLOBALS['premiumpress']['feature_expiry'] = get_option("feature_expiry"); }
	//if($GLOBALS['premiumpress']['feature_expiry'] != "yes" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "auctionpress"){ return; }
	if(!isset($GLOBALS['premiumpress']['feature_expiry_do']) || $GLOBALS['premiumpress']['feature_expiry_do'] == ""){ $GLOBALS['premiumpress']['feature_expiry_do'] = get_option("feature_expiry_do"); }
		 
	if(!$force){
		 
		// couponpress has two expiry fields so check which one to use	
		if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress"){ 
			
				$post_expires = get_post_meta($post_id, "pexpires", true);			 
				
				// FALLBACK ONTO THE NUMERIC EXPIRY DATE
				if($post_expires == ""){
					$post_expires = get_post_meta($post_id, "expires", true);				 
				}
				
				// FMTC hack for odd dates
				if(substr($post_expires,0,4) == "2050"){
				return false;
				//update_post_meta($post_id, "expires", "");
				}
			
			}else{
			
				// FALLBACK ONTO THE NUMERIC EXPIRY DATE
				if($post_expires == ""){
					$post_expires = get_post_meta($post_id, "expires", true);				
				}
			
			}
	 
			// if not expiry date is found then prune and exit 
			if($post_expires ==""){		
					premiumpress_prune($post_id);
					return false; // invalid date
			}		
		  
			// DATE FORMAT IS FOR COUPONPRESS COUPONS
			if(!is_numeric($post_expires)){
				$AHHH = date('Y-m-d h:i:s',strtotime(date("Y-m-d h:i:s", strtotime($post_expires) ))); //<-- couponpress date since it checks the date it expires rather than the post value
			}else{
				$AHHH = date('Y-m-d h:i:s',strtotime(date("Y-m-d h:i:s", strtotime($POSTDATE )) . " +".$post_expires." days")); // <-- everything else
			}
		
		} // end if force
 
		if( date("Y-m-d h:i:s") > $AHHH || $force ){ 
		 //die(date("Y-m-d h:i:s") .">". $AHHH);	
				$my_post 				= array();
				$my_post['ID'] 			= $post_id; 
				
				if(!isset($GLOBALS['premiumpress']['feature_expiry_do']) || strlen($GLOBALS['premiumpress']['feature_expiry_do']) < 1){
				$GLOBALS['premiumpress']['feature_expiry_do'] = get_option('feature_expiry_do');
				}
				
				
				if(get_option("feature_expiry") =="yes"){
				
				switch($GLOBALS['premiumpress']['feature_expiry_do']){							
				
					case "draft":{  	$my_post['post_status'] = "draft"; } break;
					case "delete":{  	wp_delete_post( $post_id, true ); return true; } break;					
					case "pak1":{  	update_post_meta($post_id, "packageID", "1"); } break;
					case "pak2":{  	update_post_meta($post_id, "packageID", "2"); } break;
					case "pak3":{  	update_post_meta($post_id, "packageID", "3"); } break;
					case "pak4":{  	update_post_meta($post_id, "packageID", "4"); } break;
					case "pak5":{  	update_post_meta($post_id, "packageID", "5"); } break;
					case "pak6":{  	update_post_meta($post_id, "packageID", "6"); } break;
					case "pak7":{  	update_post_meta($post_id, "packageID", "7"); } break;
					case "pak8":{  	update_post_meta($post_id, "packageID", "8"); } break;					
					default: { 			 
					
					if(is_numeric($GLOBALS['premiumpress']['feature_expiry_do']) && $GLOBALS['premiumpress']['feature_expiry_do'] > 1){
					$my_post['post_category'] 	= array($GLOBALS['premiumpress']['feature_expiry_do']); 
					}
					
					} break;			
				
				}// end switch
				}// end if 
				 
				wp_update_post( $my_post );
				
				update_post_meta($post_id, "expires", "");
				update_post_meta($post_id, "featured", "no");
				
				return true;
					
			}
			
			premiumpress_prune($post_data->ID);	
			
			return false; // not expired	 
		 
	
	}

/* =============================================================================
   Language Setup / V7 / 25th Feb
   ========================================================================== */
   
function _e($text,$lang="english", $textdomain="premiumpress"){

global $wpdb; $ct = get_option("pptlanguage"); $outtext = "";

if(is_array($text)){

	if(isset($text[1])){
		  
		$outtext = (isset($ct[$lang][$text[0]][$text[1]]) && $ct[$lang][$text[0]][$text[1]] !="" ? $ct[$lang][$text[0]][$text[1]] : $GLOBALS['_LANG'][$lang][$text[0]][$text[1]] );		 
	
	}else{
	
		$outtext = $GLOBALS['_LANG'][$lang][$text[0]];	
	}


}else{ // if array

	$outtext = $text;
}
 
return stripslashes($outtext);
 

}
function Language(){

// BUG FIX FOR LOGOUT
//if(isset($_GET['action']) &&  $_GET['action'] == "logout"){ die($_SESSION['lang']."<--");}
 
if(!isset($GLOBALS['_LANG'])){
 
	if(!isset($GLOBALS['premiumpress']['language']) || $GLOBALS['premiumpress']['language'] ==""){ 
			
		define("THEME_LANG","language_english");
				
	}else{
		 
		if ( !isset($_SESSION['lang'] ) && !isset($_REQUEST['l']) ){
				
			// SAVE SESSON FOR LANG
			define("THEME_LANG",$GLOBALS['premiumpress']['language']);
			$_SESSION['lang'] = $GLOBALS['premiumpress']['language'];		
		
		}else{		
		 
			if (isset($_REQUEST['l'])){ 
				unset($_SESSION['lang']);
			}
			if (isset($_SESSION['lang']) && !isset($_REQUEST['l'])){
								
				$_REQUEST['l'] = $_SESSION['lang'];
				define('THEME_LANG',str_replace("language_language","language","language_".$_REQUEST['l'])); 
			
			}elseif (isset($_SESSION['lang'] ) && isset($_REQUEST['l'])){
			
				unset($_SESSION['lang']);
				$_SESSION['lang'] = $_REQUEST['l']; 
				define('THEME_LANG',str_replace("language_language","language","language_".$_REQUEST['l'])); 
				
			}else{		
						
				if(file_exists(str_replace("functions/","",THEME_PATH) . "/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/language_".strtolower(strip_tags($_REQUEST['l'])).'.php')){
										 
					$_SESSION['lang'] = $_REQUEST['l'];
					define('THEME_LANG',"language_".$_REQUEST['l']);
								 
					} else {
						define('THEME_LANG',$GLOBALS['premiumpress']['language']);
					}				
				}		
		}			
			 
	}
 
	$ThisLanguage = THEME_LANG;
 
	if(file_exists(str_replace("functions/","",THEME_PATH) . "/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/".$ThisLanguage.'.php')){
		require_once (str_replace("functions/","",THEME_PATH) . "/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/".$ThisLanguage.'.php');
  
		$GLOBALS['_LANG'] = premiumpress_language($LANG_);	 
			
		}
	}	 	
} 
/* =============================================================================
   BANNER DISPLAY / V7 / 25TH FEB
   ========================================================================== */

function Banner($data){ 

if(!is_array($data)){ return $data; }
 
global $wpdb, $post; $s = "";

	if(is_numeric($data[0])){ // BANNER ZONE
	
		$a = stripslashes(get_option("advertising_zone_".$data[0]));
		//if($a == ""){ update_option("advertising_zone_".$data[0],"n/a"); }
		if(strlen($a) < 4 ) { return ""; }
			
		return do_shortcode(stripslashes(get_option("advertising_zone_".$data[0])));	
		
	}else{ // TOP / LEFT / RIGH / FOOTER BANNER
	 
		if(get_option('advertising_'.$data[0].'_checkbox') !=1){  return "";}
			
		$s = stripslashes(get_option('advertising_'.$data[0].'_adsense'));	 
		
		if($data[1] == 1){ return do_shortcode($s); }else{ echo do_shortcode($s); }		
		
	}
} 

/* =============================================================================
   GET CATEGORY IMAGE AND DESCRIPTION / V7 / Feb 25th
   ========================================================================== */

function CategoryExtras($cat_id,$type,$return=false){ 

global $wpdb; 

// REMOVED IN 7.1.1
// CATEGORY VALUES ARE NOW PART OF THE DEFAULT TAXONOMY IN WP
//$CATARRAY = get_option("cat_icons");

}
   
/* =============================================================================
   DISPLAY PAGES / V7 / 25th Feb
   ========================================================================== */

function PageList($data){ 
 
	if(!is_array($data)){ return $data; }
 
	$footer =  $data[0];
 
 	global $PPT, $wpdb; $STRING = "";  $pa = array();
 
 	if($footer == "submenu"){
	
		$flist = get_option("submenu_excluded_pages");
		if($flist == ""){ return; }
		$args = array( 
			'sort_column'              => 'menu_order',
			'include'                  => $flist,
			'hierarchical'             => true,
		);	 
		$pa = explode(",",get_option("submenu_excluded_pages"));
		
	}elseif($footer == "footer"){
	
		$flist = get_option("footer_excluded_pages");
		if($flist == ""){ return; }
		$args = array( 
			'sort_column'              => 'menu_order',
			'include'                  => $flist,
			'hierarchical'             => true,
		);	 
		$pa = explode(",",get_option("footer_excluded_pages"));
	
	}else{
		$args = array(
			 
			'sort_column'              => 'menu_order',
			'exclude'                  => get_option("excluded_pages"),
			'hierarchical'             => true,
		);
		$pa = explode(",",get_option("excluded_pages"));
	}
	 
	$pages = get_page_hierchy(0,$args);
	 
	foreach($pages as $p) { if($footer || !in_array($p->ID, $pa)){	
	
	$STRING .= '<li><a href="'.get_permalink($p->ID).'">'.$p->post_title.'</a>';	
 
	if(is_object($p->children) && !empty($p->children)){ 
	
	$STRING .="<ul>";
 
		foreach($p->children as $child_p){
		
			$STRING .= '<li><a id="nav-'.$pid.'" href="'.get_permalink($child_p->ID).'">';
			$STRING .= $child_p->post_title;
			$STRING .= '</a></li>'; 
		
		}				
	
	$STRING .="</ul>";		 
	$STRING = str_replace("<ul></ul>","",$STRING);
	}
	
	$STRING .="</li>";	
	
	} }
	
	return $STRING;		
 	
}

/* =============================================================================
   DISPLAY CATEGORIES / V7 / 25th Feb
   ========================================================================== */

function CategoryList($data){

if(!is_array($data)){ return $data; }

$id				=$data[0];
$showAll		=$data[1];
$showExtraPrice	=$data[2];
 
$TaxType		=$data[3];
$ChildOf		=$data[4];
$hideExCats		=$data[5]; 

 
global $wpdb; $exclueMe=array(); $extra = ""; $count=0; $limit = 200; $STRING = ""; $ShowCatCount = get_option("display_categories_count");	$exCats = str_replace(",-","",get_option('article_cats')); 

$LARGECATLIST = get_option('system_largecatload');
if($LARGECATLIST == "yes"){ $largelistme = true; }else{ $largelistme = false; }

if($exCats == "" || $exCats ==","){ $exCats=0; } 
if($hideExCats){  $exCats=0;} 
 

	if($showAll == "toponly"){
		
		if($TaxType == "category"){
			$args = array(
			'taxonomy'              => $TaxType,
			'child_of'              => $ChildOf,
			'hide_empty'            => $largelistme,
			'hierarchical'          => 0,
			'use_desc_for_title'	=> 1,
			'pad_counts'			=> 1,
			'exclude'               => $exCats,
			);			
		}else{
			$args = array(
			'taxonomy'              => $TaxType,
			'child_of'              => $ChildOf,
			'hide_empty'            => $largelistme,
			'hierarchical'          => 0,
			'use_desc_for_title'	=> 1,
			'pad_counts'			=> 1,
			);			
		}
		 
			$categories = get_categories($args); 
		 
			foreach($categories as $category) {		
				if ($category->parent > 0 && $ChildOf == 0) { continue; }
				if($ChildOf > 0 && $ChildOf != $category->parent){ continue; }
				$STRING .= '<option value="'.$category->cat_ID.'" ';
				if( ( is_array($id) && in_array($category->cat_ID,$id) ) ||  ( !is_array($id) && $id == $category->cat_ID ) ){
				$STRING .= 'selected=selected';
				}
				$STRING .= '>';
				$STRING .= $category->cat_name;
				if($ShowCatCount =="yes"){ $STRING .= " (".$category->count.')'; }			 
				$STRING .= '</option>';
		
			}
			
			return $STRING;	
		
/* =============================================================================
   DISPLAY ALL CATEGORIES
   ========================================================================== */
		
		}else{
		
		// CURRENCY VALUES USED FOR DISPLAY ON PACKAGES PAGE
		if(isset($GLOBALS['tpl-add'])){ $CCode = get_option("currency_code");	 $CatPriceArray = get_option("CatPrice"); }			
		
		$args = array(
		'taxonomy'                 => $TaxType,
		'child_of'                 => $ChildOf,
		'hide_empty'               => $largelistme,
		'hierarchical'             => true,
		'exclude'                  => $exCats);
 	
		$cats  = get_categories( $args );
 
		$newcatarray = array(); $addedAlready = array();
	
		// NOW WE BUILD A CLEAN ARRAY OF VALUES
		foreach($cats as $cat){	
		 
			if($cat->parent != 0){ continue; }		
			$newcatarray[$cat->term_id]['term_id'] 	=  $cat->term_id;
			$newcatarray[$cat->term_id]['name'] 	=  $cat->cat_name;
			$newcatarray[$cat->term_id]['parent'] 	=  $cat->parent;
			$newcatarray[$cat->term_id]['slug'] 	=  $cat->slug;
			$newcatarray[$cat->term_id]['count'] 	=  $cat->count;
		}
		// SECOND LOOP TO GET CHILDREN
		foreach($cats as $cat){
	 
			if($cat->parent == 0){ continue; }		
			$newcatarray[$cat->parent]['child'][] = $cat;		 
		}
 		  
		foreach($newcatarray as $cat){
		 	
			// SHOW CAT COUNT
			if($CATcOUNT == "yes"){ $extra1 = " (".$cat['count'].")"; }else{ $extra1 = ""; }
			
			// CHECK IF THIS IS SELECTED
			if( ( is_array($id) && in_array($cat['term_id'],$id) ) ||  ( !is_array($id) && $id == $cat['term_id'] ) ){ $EX1 = 'selected=selected'; }else{ $EX1 = ""; }
			
			// CHECK IF THIS IS A SHOW PRICE DISPLAY
			if(isset($GLOBALS['tpl-add'])){			 
				if( isset($CatPriceArray[$cat['term_id']]) && strlen($CatPriceArray[$cat['term_id']]) > 0 ){ $extra1 .= " + ".$CCode.$CatPriceArray[$cat['term_id']]; }else{ $extra1  .= ""; }				 
			}
			
			if(!in_array($cat['term_id'], $addedAlready) && $cat['name'] !=""){ 	 
			$STRING .= '<option value="'.$cat['term_id'].'" '.$EX1.'>'.$cat['name'].''.$extra1.'</option>';
			}
			$addedAlready[] = $cat['term_id'];
			 	
			if(!empty($cat['child'])){	
				foreach($cat['child'] as $sub1){ 
				 			// SHOW COUNT
							if($CATcOUNT == "yes"){ $extra2 = " (".$sub1->count.")"; }else{ $extra2 = ""; }
							
							// CHECK IF THIS IS SELECTED
							if( ( is_array($id) && in_array($sub1->term_id,$id) ) ||  ( !is_array($id) && $id == $sub1->term_id ) ){ $EX2 = 'selected=selected'; }else{ $EX2 = ""; }
							
							// CHECK IF THIS IS A SHOW PRICE DISPLAY
							if(isset($GLOBALS['tpl-add'])){			 
								if( isset($CatPriceArray[$sub1->term_id]) && strlen($CatPriceArray[$sub1->term_id]) > 0 ){ $extra2 .= " + ".$CCode.$CatPriceArray[$sub1->term_id]; }else{ $extra2  .= ""; }				 
							} 
							
							// OUTPUT
							if(!in_array($sub1->term_id, $addedAlready)){ 
							$STRING .= '<option value="'.$sub1->term_id.'" '.$EX2.'> -- '.$sub1->name.''.$extra2.'</option>';
							}
							$addedAlready[] = $sub1->term_id;
							 
							// CHECK FOR SUB CATS LEVEL 2
							if(!empty($newcatarray[$sub1->term_id]['child'])){  
							 
								foreach($newcatarray[$sub1->term_id]['child'] as $sub2){
								
								 	// SHOW COUNT
									if($CATcOUNT == "yes"){ $extra3 = " (".$sub2->count.")"; }else{ $extra3 = ""; }
									
									// CHECK IF THIS IS SELECTED
									if( ( is_array($id) && in_array($sub2->term_id,$id) ) ||  ( !is_array($id) && $id == $sub2->term_id ) ){ $EX3 = 'selected=selected'; }else{ $EX3 = ""; }
									
									// CHECK IF THIS IS A SHOW PRICE DISPLAY
									if(isset($GLOBALS['tpl-add'])){			 
										if( isset($CatPriceArray[$sub2->term_id]) && strlen($CatPriceArray[$sub2->term_id]) > 0 ){ $extra3 .= " + ".$CCode.$CatPriceArray[$sub2->term_id]; }else{ $extra3  .= ""; }				 
									}
									
									// OUTPUT
									if(!in_array($sub2->term_id, $addedAlready)){ 
									$STRING .= '<option value="'.$sub2->term_id.'" '.$EX3.'> ---- '.$sub2->name.''.$extra3.'</option>';	
									}
									$addedAlready[] = $sub2->term_id;						
									 
									// CHECK FOR SUB CATS LEVEL 2
								 
									if(!empty($newcatarray[$sub2->term_id]['child'])){ 
										foreach($newcatarray[$sub2->term_id]['child'] as $sub3){
										
											// SHOW COUNT
											if($CATcOUNT == "yes"){ $extra4 = " (".$sub3->count.")"; }else{ $extra4 = ""; }
											
											// CHECK IF THIS IS SELECTED
											if( ( is_array($id) && in_array($sub3->term_id,$id) ) ||  ( !is_array($id) && $id == $sub3->term_id ) ){ $EX4 = 'selected=selected'; }else{ $EX4 = ""; }
											
											// CHECK IF THIS IS A SHOW PRICE DISPLAY
											if(isset($GLOBALS['tpl-add'])){			 
												if( isset($CatPriceArray[$sub3->term_id]) && strlen($CatPriceArray[$sub3->term_id]) > 0 ){ $extra4 .= " + ".$CCode.$CatPriceArray[$sub3->term_id]; }else{ $extra4  .= ""; }				 
											}
											
											// OUTPUT
											if(!in_array($sub3->term_id, $addedAlready)){ 
											$STRING .= '<option value="'.$sub3->term_id.'" '.$EX4.'> ------ '.$sub3->name.''.$extra4.'</option>';	
											}
											$addedAlready[] = $sub3->term_id;	
											
											
											// CHECK FOR SUB CATS LEVEL 2
											if(!empty($newcatarray[$sub3->term_id]['child'])){ 
												foreach($newcatarray[$sub3->term_id]['child'] as $sub4){
										
													// SHOW COUNT
													if($CATcOUNT == "yes"){ $extra4 = " (".$sub4->count.")"; }else{ $extra4 = ""; }
													
													// CHECK IF THIS IS SELECTED
													if( ( is_array($id) && in_array($sub4->term_id,$id) ) ||  ( !is_array($id) && $id == $sub4->term_id ) ){ $EX4 = 'selected=selected'; }else{ $EX4 = ""; }
													
													// CHECK IF THIS IS A SHOW PRICE DISPLAY
													if(isset($GLOBALS['tpl-add'])){			 
														if( isset($CatPriceArray[$sub4->term_id]) && strlen($CatPriceArray[$sub4->term_id]) > 0 ){ $extra4 .= " + ".$CCode.$CatPriceArray[$sub4->term_id]; }else{ $extra4  .= ""; }				 
													}
													
													// OUTPUT
													if(!in_array($sub4->term_id, $addedAlready)){ 
													$STRING .= '<option value="'.$sub4->term_id.'" '.$EX4.'> ------ '.$sub4->name.''.$extra4.'</option>';	
													}
													$addedAlready[] = $sub4->term_id;	
																							
												}
											} 
										 									
										}										
									}
									
								}
							}
							
				}
			}
					 
			$STRING .= '</ul></li>';
		 		
		
		} // end foreach
  	
		return $STRING;		

	}
}

/* =============================================================================
   ADD / EDIT LISTING FUNCTION  // 25th Feb
   ========================================================================== */

function Post($type){ 
 
if($type != "add" && $type != "edit"){ return $type; }

global $wpdb; global $userdata; get_currentuserinfo();


	// QUICK FIX FOR LONG/LAT
	if(isset($_POST['form']['map-loglat']) && strlen($_POST['form']['map-loglat']) > 1){
		$mapbits = explode(",",str_replace("lat:","",str_replace("long:","",$_POST['form']['map-loglat'])));
		$_POST['form']['latitude'] =  $mapbits[0];
		$_POST['form']['longitude'] = $mapbits[1];
	
	}
	
	// QUICK FIX FOR PRICE FIELDS WHERE USER ADDED CURRENCY CODE
	$pricefield_array = array('price','price_current','price_reserve','price_bin');
	foreach($pricefield_array as $pf){	
		if(isset($_POST['form'][$pf])){ $_POST['form'][$pf] = str_replace("$","",str_replace("USD","",str_replace("$","",strip_tags($_POST['form'][$pf])))); }
	}
	 
 
	if($type == "add"){
	
		// CHECK IF THIS HAS BEEN ADDED ALREADY (PAGE REFRESH)
		if(isset($_POST['form']['trackingID'])){
			
			$SQL = "SELECT post_id FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key='trackingID' AND $wpdb->postmeta.meta_value LIKE '%".PPTCLEAN($_POST['form']['trackingID'])."%' LIMIT 1";	
			$found = (array)$wpdb->get_results($SQL);
			 
			if(isset($found[0]->post_id) && $found[0]->post_id != ""){ 
			return $found[0]->post_id;
			}			
		} 	
	}
	
	// LOAD IN PACKAGE DATA	
	$PACKAGE_OPTIONS = get_option("packages"); 

	$DefaultFields = array("title","description","short","tags");
  	 
 		$NewcatArray = array();
		foreach($catArray as $nc){if($nc !=""){ $NewcatArray[] = $nc; }		}
		
 		// BUILT LISTING ARRAY
		$my_post = array();
		if($type == "edit"){
			$my_post['ID'] 				= $_POST['eid'];
		}
		$my_post['post_title'] 		= PPTOUTPUT($_POST['form']['title']);
		$my_post['post_content'] 	= $_POST['form']['description'];
		$my_post['post_excerpt'] 	= PPTOUTPUT($_POST['form']['short']);
		
		if($my_post['post_title'] == ""){ $my_post['post_title'] = "&nbsp;"; }		
		
		// IF THEY ARE NOT YET A USER, CREATE AN ACCOUNT
		if ( !$userdata->ID ){ 
		
			// CHECK IF WE HAVE A VALID EMAIL OTHERWISE ASSIGN POST TO ADMIN
			if(strlen($_POST['form']['email']) > 1){
			
				$user_email = $_POST['form']['email'];
				$user_name = explode("@",$user_email);
				$new_user_name = $user_name[0].date('d');
				$random_password = wp_generate_password( 12, false );
				$user_ID = wp_create_user( $new_user_name, $random_password, $user_email );
				
				// CHECK IF THE USER EXISTS ALREADy
				if(isset($user_ID->errors['existing_user_email'])){
				
					$user = get_user_by('email', $user_email);
					$user_ID = $user->data->ID;			
					
				}else{
				
					$_POST['password'] = $random_password;
					
					// SEND THE USER EMAILS				
					$emailID = get_option("email_signup");					 
					if(is_numeric($emailID) && $emailID != 0){
						SendMemberEmail($user_ID, $emailID);
					}
					
					if ( is_wp_error($user_ID) ){
						$user_ID=0;
					}else{
						// AUTO LOGIN NEW USER
						$creds = array();
						$creds['user_login'] 	= $new_user_name;
						$creds['user_password'] = $random_password;
						$creds['remember'] 		= true;
						$userdata = wp_signon( $creds, false );	
								 
					}				
				}
				
				$GLOBALS['new_user_id'] = $user_ID; 
				
			}else{ // NO VALID EMAIL
			
				$GLOBALS['new_user_id'] = 1;  // ADMIN ID: 1
			}
			
		}else{
			$user_ID = $userdata->ID;
		}		
		
		$my_post['post_author'] 	= $user_ID;
		$my_post['post_category'] 	= $NewcatArray;		
		$my_post['tags_input'] 		= PPTOUTPUT($_POST['form']['tags']);

		
		// AUTO APPROVE FREE LISITNGS
		if(get_option("display_listing_status") != ""){		
			if($type == "add"){
				if(get_option("pak_auto_free") ==1 && isset($_POST['packageID']) &&($PACKAGE_OPTIONS[$_POST['packageID']]['price'] == "" || $PACKAGE_OPTIONS[$_POST['packageID']]['price'] == "0")){
				$my_post['post_status'] 	= "publish";
				}else{
				$my_post['post_status'] 	= get_option("display_listing_status");
				}
			}else{
				if(get_option("pak_auto_free") ==1 && isset($_POST['NEWpackageID']) && ($PACKAGE_OPTIONS[$_POST['NEWpackageID']]['price'] == "" || $PACKAGE_OPTIONS[$_POST['NEWpackageID']]['price'] == "0")){
				$my_post['post_status'] 	= "publish";
				}else{
				$my_post['post_status'] 	= get_option("display_listing_status");
				}
			}
		}
		 
		// AUTO APPROVE EDITED LISTINGS // ADDED 7.0.9.6
		if(get_option("pak_auto_edit") == 1 && $type == "edit" && ($_POST['NEWpackageID'] == $_POST['packageID']) ){		
			$my_post['post_status'] 	= "publish";		
		}
		
		// UPDATE / INSERTPOST
		if($type == "add"){
		
			$POSTID 						= wp_insert_post( $my_post );
			 
			// DEFAULT LISTING DATA
			add_post_meta($POSTID, "featured", "no");
			add_post_meta($POSTID, "hits", "0");
			add_post_meta($POSTID, "displaycolor", "");			
			if(!isset($_POST['form']['price'])){ add_post_meta($POSTID, "price", "0"); }else{ $_POST['form']['price'] = str_replace(",","",$_POST['form']['price']); } 

			// SET DEFAULT PACKAGE ACCESS // V7 // APRIL 5TH
			add_post_meta($POSTID, 'package_access', get_option("ppt_defaultpackageaccess"));	
		
		}else{
		
		wp_update_post( $my_post ); $POSTID = $_POST['eid'];
		if(!isset($_POST['form']['price'])){ $_POST['form']['price'] = ""; }
		$_POST['form']['price'] = str_replace(",","",$_POST['form']['price']);

			// SET DEFAULT PACKAGE ACCESS // V7 // APRIL 5TH
			update_post_meta($POSTID, 'package_access', get_option("ppt_defaultpackageaccess"));	
					
		}
		
		
		// BUILT CATEGORY ARRAY
		$_POST['link'] 		= get_permalink( $POSTID );
		$catArray = array();
		if(is_array($_POST['CatSel'])){
		
			foreach($_POST['CatSel'] as $cat){ 
			
			array_push($catArray,$cat); 
					
				// SEND ALTER EMAIL // V7 // 26TH MARCH			 
				$emailID = get_option("email_alter");					 
				if(is_numeric($emailID) && $emailID != 0){
				
				$_POST['category'] = $cat; // FOR USE IN EMAIL ONLY
					
					$SQL = "SELECT $wpdb->posts.post_author FROM $wpdb->posts
					INNER JOIN $wpdb->postmeta ON ( $wpdb->postmeta.post_id = $wpdb->posts.ID )
					WHERE $wpdb->postmeta.meta_key='catID' AND $wpdb->postmeta.meta_value='".$cat."'";				 
					$posts = $wpdb->get_results($SQL,ARRAY_A); 			
					foreach ($posts as $p){	
						// SEND EMAIL
						SendMemberEmail($p['post_author'], $emailID);
					}// END FOREACH
				} // END IF
			 } // END FOREACH
		} // END IF
		
		
			  
	 
		 if(get_option("display_country") =="yes" && isset($_POST['form']['country']) ){ 
		// INSERT COUNTRY/STATE/CITY TERMS
		$locationArray = array($_POST['form']['country'],$_POST['form']['state'],$_POST['form']['city']);
		wp_set_post_terms( $POSTID, $locationArray , 'location' );
		}	
		
		// AUTO INSERT FORM DATA
		if(is_array($_POST['form']) ){
				foreach($_POST['form'] as $key => $val){
					if(!in_array($key,$DefaultFields)){
						if($type == "add"){ add_post_meta($POSTID, $key, $val); }else{ update_post_meta($POSTID, $key,  PPTOUTPUT($val)); }			
					}	
				}	
		}

		// AUTO INSERT CUSTOM DATA
		if(is_array($_POST['custom']) ){
				foreach($_POST['custom'] as $in_array){
						if($type == "add"){ add_post_meta($POSTID, $in_array['name'], nl2br2($in_array['value'])); }else{ update_post_meta($POSTID, $in_array['name'],  nl2br2($in_array['value']));	 }				
				}	
		}
		
		// STORE TAXOMONY
		//if(isset($_POST['form']['store']) && is_numeric($_POST['form']['store'])){
		//wp_set_post_terms( $POSTID, $_POST['form']['store'], 'store' );
		//}
		if(is_array($_POST['taxonomy']) ){		
			foreach($_POST['taxonomy'] as $key => $value){
			
				if($value == ""){
				
				wp_set_post_terms( $POSTID, "", $key );
				
				}elseif(is_numeric($value) && $value != "new"){
				// UPDATE EXITING
				wp_set_post_terms( $POSTID, $value, $key );
				
				}else{
				
					if ( is_term( $_POST[$key."_new"], $key ) ){		
							 
						 $term = get_term_by('name', $_POST[$key."_new"], $key);				
						 $cat = $term->term_id;
					 
					 }else{			 
						 
						$term = wp_insert_term($_POST[$key."_new"], $key, array('cat_name' => $_POST[$key."_new"] ));						
						$cat = $term->term_id;
						 
						if($cat == "" && isset($term['term_id']) ){
						$cat = $term['term_id'];
						}
						
					 }
					 
					 wp_set_post_terms( $POSTID, $cat, $key );
				}
			 
				
							
			}
		}
			
			
		// CUSTOM DATA FOR THEMES
		if(isset($_POST['reclink'])){
			if($type == "add"){ add_post_meta($POSTID, 'reclink', $_POST['reclink']); }else{ update_post_meta($POSTID, 'reclink', $_POST['reclink']); }
		}
 
		// INSERT UPLOAD IMAGES
		if(isset($_POST['files']) && is_array($_POST['files']) ){
		
			$cleanfilesstring=""; $cleanfiles= array();  $STORAGEPATH = get_option('imagestorage_path');
		
			// LOOP FILE ARRAY
			foreach($_POST['files'] as $file){
			
				// IF FILE STARTS WITH 'unknown' RENAME IT
				if(substr($file,0,7) == "unknown"){
				
					$bits = explode(".",$file);
					$NewName =  $POSTID."-".$user_ID."-".date("Y-m-d").RandomID(5).".".$bits[1];
					rename ($STORAGEPATH.$file, $STORAGEPATH.$NewName);	
					
					$cleanfiles[] = $NewName;
					$cleanfilesstring .= $NewName.",";			
				
				}else{
				
				$cleanfiles[] = $file;
				$cleanfilesstring .= $file.",";
				}
			
			}		
		 
			// NOW WE SAVE THE PHOTOS TO THE LISTING PROFILE		
			if($type == "add"){ // new listing
				
				if(strlen($cleanfiles[0]) > 2){
				add_post_meta($POSTID, 'image', $cleanfiles[0]);
				
				}
				if(strlen(substr($cleanfilesstring,0,-1)) > 2){
				add_post_meta($POSTID, 'images', substr($cleanfilesstring,0,-1)); 
				}
				
			}else{ // edit listing
			
				$images = get_post_meta($_POST['eid'], "images", true);
				
				if(strlen($cleanfilesstring.$images) > 2){
				
				// CHECK IF THERE IS A DEFAULT IMAGE
				$image = get_post_meta($_POST['eid'], "image", true);
				 
				if($image == ""){
					update_post_meta($POSTID, 'image', $cleanfiles[0]);
				}
				
				
				update_post_meta($POSTID, 'images', $cleanfilesstring.$images);
				}
				
			}
		}
		
		// NEW LISTING
		if($type == "add"){
		
			if(isset($_POST['packageID'])){
			
				
				add_post_meta($POSTID, "packageID", $_POST['packageID'] );
			
					if(strlen($PACKAGE_OPTIONS[$_POST['packageID']]['expire']) > 0){
						add_post_meta($POSTID, "expires", $PACKAGE_OPTIONS[$_POST['packageID']]['expire']);		
					}
			
					if($PACKAGE_OPTIONS[$_POST['packageID']]['a5'] == 1){
						update_post_meta($POSTID, "featured", "yes");
					}	
	
					return $POSTID;
			
			}else{
	
				return $POSTID;
	
			}
		}	
 	

	return "Changed Saved";

}

/* =============================================================================
   BUILD AFFILIATE BUY LINKS
   ========================================================================== */
   
function Link($data){

if(!is_array($data)){ return $data; }
 	
global $wpdb;

$post_id 	= $data[0];
$checkA 	= $data[1]; // affiliate /true/false
$link = "";

if($checkA){ // CHECK AFFILIATE LINKS FIRST
 
$link  	= get_post_meta($post_id, "amazon_link", true);
if($link == ""){
	$link  	= get_post_meta($post_id, "buy_link", true);
	 
	}
	if($link == ""){
		$link  	= get_post_meta($post_id, "buy_link1", true);
		}
		if($link == ""){
			$link  	= get_post_meta($post_id, "buy_link2", true);
			}
			if($link == ""){
				$link  	= get_post_meta($post_id, "buy_link3", true);
				}
				if($link == ""){
					$link  	= get_post_meta($post_id, "buy_link4", true);
					}
					if($link == ""){
						$link  	= get_post_meta($post_id, "buy_link5", true);
						}
						if($link == ""){
								$link  	= get_post_meta($post_id, "redirect", true);
							}

}
// LOOK FOR A LINK IN THE CUSTOM FIELD DATA	
if($link == ""){	
	$link 				= get_post_meta($post_id, "link", true);
	}
	if($link == ""){
		$link 				= get_post_meta($post_id, "buy_link", true);
		}
		if($link == ""){	
			$link 				= get_post_meta($post_id, "customurl", true);
			}
			if($link == ""){
				$link  	= get_post_meta($post_id, "url", true);
				}
		 
	// NO LINK FOUND RETURN		
	if($link  == ""){ return; }
	
	// ADD HTTP IF NONE FOUND		 
	$pos = strpos($link , 'http://'); $pos1 = strpos($link , 'https');
	if ($pos === false && $pos1 === false && $link  != "") {		$link  = "http://".$link ;		} 
 
		
		// LINK CLOAKING
		if(get_option("display_linkcloak") =="yes" && !isset($_GET['link'])){		
			$link = get_template_directory_uri()."/_link.php?link=".$post_id; 
		}	 
 	 
 		$pos = stripos($link, "affiliatefuture");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_2_ID"),$link);
			return $link.get_option("affiliates_2_TRACK");
		}

 		$pos = stripos($link, "linkshare");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_3_ID"),$link);
			return $link.get_option("affiliates_3_TRACK");
		}
		
 		$pos = stripos($link, "linksynergy");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_3_ID"),$link);
			return $link.get_option("affiliates_3_TRACK");
		}		

  		$pos = stripos($link, "regnow");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_4_ID"),$link);
			return $link.get_option("affiliates_4_TRACK");
		}

		$pos = stripos($link, "kqzyfj");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}

		$pos = stripos($link, "dpbolvw");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}
		
		$pos = stripos($link, "jdoqocy");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}
		
		$pos = stripos($link, "anrdoezrs");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}
		
		$pos = stripos($link, "tkqlhce");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}		
		$pos = stripos($link, "jdoqocy");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}

		$pos = stripos($link, "tkqlhce");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}

		$pos = stripos($link, "anrdoezrs");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_5_ID"),$link);
			return $link.get_option("affiliates_5_TRACK");
		}

  		$pos = stripos($link, "webgains");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_6_ID"),$link);
			return $link.get_option("affiliates_6_TRACK");
		}	

		$pos = stripos($link, "clickbank");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_7_ID"),$link);
			return $link.get_option("affiliates_7_TRACK");
		}

  		$pos = stripos($link, "tradedoubler");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_8_ID"),$link);
			return $link.get_option("affiliates_8_TRACK");
		}	

		$pos = stripos($link, "bridaluxe");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_9_ID"),$link);
			return $link.get_option("affiliates_9_TRACK");
		}
 
		$pos = stripos($link, "linkconnector");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_10_ID"),$link);
			return $link.get_option("affiliates_10_TRACK");
		}

		$pos = stripos($link, "netshops");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_11_ID"),$link);
			return $link.get_option("affiliates_11_TRACK");
		}

		$pos = stripos($link, "buy.at");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_12_ID"),$link);
			return $link.get_option("affiliates_12_TRACK");
		}

		$pos = stripos($link, "pepperjam");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_13_ID"),$link);
			return $link.get_option("affiliates_13_TRACK");
		}

		$pos = stripos($link, "pntrs");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_13_ID"),$link);
			return $link.get_option("affiliates_13_TRACK");
		}


		$pos = stripos($link, "google");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_14_ID"),$link);
			return $link.get_option("affiliates_14_TRACK");
		}
		
		$pos = stripos($link, "doubleclick");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_14_ID"),$link);
			return $link.get_option("affiliates_14_TRACK");
		}

		$pos = stripos($link, "clickserve");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_14_ID"),$link);
			return $link.get_option("affiliates_14_TRACK");
		}

		$pos = stripos($link, "affiliatewindow");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_15_ID"),$link);
			return $link.get_option("affiliates_15_TRACK");
		}

		$pos = stripos($link, "awin1");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_15_ID"),$link);
			return $link.get_option("affiliates_15_TRACK");
		}

		$pos = stripos($link, "commissionmonster");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_16_ID"),$link);
			return $link.get_option("affiliates_16_TRACK");
		}

		$pos = stripos($link, "markethealth");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_17_ID"),$link);
			return $link.get_option("affiliates_17_TRACK");
		}

		$pos = stripos($link, "affilinet");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_18_ID"),$link);
			return $link.get_option("affiliates_18_TRACK");
		}

		$pos = stripos($link, "onenetworkdirect");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_19_ID"),$link);
			return $link.get_option("affiliates_19_TRACK");
		}

		$pos = stripos($link, "amazon");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',"?tag=".get_option("affiliates_20_ID"),$link);
			return $link.get_option("affiliates_20_TRACK");
		}
		
		$pos = stripos($link, "shareasale");
		if ($pos !== false) {
			$link = str_replace('YOURUSERID',get_option("affiliates_1_ID"),$link);
			return $link.get_option("affiliates_1_TRACK");
		} 
			
	return $link;		
	
} 

 
/* =============================================================================
   V7 Set Display Photo / Feb 25th
   ========================================================================== */
  
function SetDisplayPhoto($post_id, $imagename,$user_id){
	 
		global $wpdb; $userdata; $string="";

		$this->authme($post_id,$user_id);
	
		update_post_meta($post_id, 'image', $imagename);		 
	 
		return 1;
}

/* =============================================================================
  Delete File / V7 / 25th Feb
   ========================================================================== */

function DeleteUpload($data){

if(!isset($data[2])){ return $data; }

	$post_id 	= $data[0];
	$imagename 	= $data[1];
	$user_id 	= $data[2];
	 
	global $wpdb; $userdata; $string=""; $i=0;

	$this->authme($post_id,$user_id);
		
	// DELETE FILE FROM STORAGE FOLDER
	@unlink(get_option('imagestorage_path').$imagename);
	
	// REMOVE FILE FROM STRINGS
	$image 		= str_replace($imagename,"",get_post_meta($post_id, "image", true)); 
	$images 	= str_replace($imagename,"",get_post_meta($post_id, "images", true));
		
	// UPDATE		
	update_post_meta($post_id, 'image', $image);
	update_post_meta($post_id, 'images', $images);		
	 
	return 1;
}

/* =============================================================================
   IMAGE UPLOAD / EDIT ON SUBMISSION PAGE / EDITED: FEB 26th 2012
   ========================================================================== */
   
function EditUpload($post_id){

if(!is_numeric($post_id)){ return $post_id; }
	
global $wpdb, $PPT; $userdata; $string = ""; $imagePath= ""; $picCount = 0;

	// GET IMAGE DATA	 
	$image = get_post_meta($post_id, "image", true); 
			
	// ENSURE EDIT LINK IS CORRECT	
	$pos = strpos($GLOBALS['premiumpress']['submit_url'], '?'); 
	if ($pos === false) {
		$elink = $GLOBALS['premiumpress']['submit_url']."?";			
	} else {
		$elink = $GLOBALS['premiumpress']['submit_url']."&";			 
	} 
	
	$ST1 = get_post_meta($post_id, "image", true).",".str_replace(get_post_meta($post_id, "image", true),"",get_post_meta($post_id, "images", true));
	  
 	$pics = explode(",",$ST1);
	
	// CHECK WE HAVE FILES
	if(is_array($pics)){ 
	
		// LOOP THROUGH ALL FILES
		foreach($pics as $pic) {
			
			// MAKE SURE IS VALID FILE
			if(strlen(trim($pic)) > 4){
				
			$string .="<li class='First' style='margin-right:10px;'><div id='img".$picCount."'>";
				
				// SWITCH DIFFERENT FILE TYPES
				switch(substr($pic,-3)){
				
					case "flv": { 
					
					$out = "<img src='".get_template_directory_uri()."/PPT/img/video.png' class='editimg' />"; 
					
					} break;	
							
					case "pdf": { 
					
					$out = "<img src='".get_template_directory_uri()."/PPT/img/pdf.png' class='editimg' />"; 					
					
					} break;	
														
					default: { 
					
					$out = "<a href='".$this->ImageCheck($pic)."' rel='gallery' class='lightbox'><img src='".$this->ImageCheck($pic)."'";				
					if($image == $pic){ $out .=' style="border:2px solid red;" '; }
					$out .= " id='imgfile".$picCount."' class='editimg' /></a>"; 					
					
					}	
								
				} // end switch
				
				$string .= $out;
				$string .="<br />"; 
				
				if(substr($pic,-3) !="flv" && substr($pic,-3) != "pdf"){
				
				$string .="<a href=\"javascript:void(0);\" onclick=\"document.getElementById('imgfile".$picCount."').style.border ='2px solid green';document.getElementById('display').value='1';document.getElementById('pid').value='".trim($pic)."';document.editimageform.submit();\"  class='button gray'>".$PPT->_e(array('button','17'))."</a>";
				
				}
				
				$string .= "<a href=\"javascript:void(0);\" onclick=\"document.getElementById('pid').value='".trim($pic)."';jQuery('#img".$picCount."').hide();document.editimageform.submit();\" style='text-align:Center;'>".$PPT->_e(array('button','3'))."</a>
				
				</div></li>";
				
				$picCount++;
				
			} // end if  valid
			
		} // end loop
			
	}else{
		return "<li>".$GLOBALS['_LANG']['_err13']."</li>"; // return no files found messages
	}
	
	return $string;
}

/* =============================================================================
   V7 FILE UPLOAD TOOL / Feb 25th
   ========================================================================== */
   
function Upload($file){

if(!is_array($file)){ return $file; }

global $wpdb, $userdata; get_currentuserinfo(); $error=""; $i=0; $currentCount=0;

// MAKE USER ID
if(isset($userdata->data->ID) && is_numeric($userdata->data->ID)){
$userID = $userdata->data->ID;
}elseif(isset($userdata->ID) && is_numeric($userdata->ID)){
$userID = $userdata->ID;
}
		 
// LOAD IN THE IMAGE RESIZE CLASS FOR LATER
$image = new ResizeImage(); $STORAGEPATH = get_option('imagestorage_path');

// TEST THE UPLOAD DIRECTORY
if(!is_writable($STORAGEPATH)){ return "writable"; }


	// HERE WE CAN DECIDE WHAT FILE FORMATS ARE ACCEPTABLE
	$permitted_files = array('image/jpeg','image/pjpeg','image/png', 'image/gif', 'application/pdf', 'video/x-flv'); //,'image/svc','video/mov','video/mpeg4','video/mp4','video/wmv','application/pdf' 'image/gif','image/tiff','image/ico'
	$image_files = array('image/jpeg','image/pjpeg','image/png', 'image/gif');
	$allowed_prefixes = array('jpeg','gif','png','jpg','flv','pdf');	
	$blacklist = array("porn",".php", ".phtml", ".php3", ".php4","shell","fuck",".txt".".doc","backdoor","trojan","hack");
	
	// FIRST SEE IF ITS AN ARRAY OF IMAGES OR SINGLE IMAGE
	if(isset($file['tmp_name']) && $file['error'] == 0){ 	
	
	// GET FILE PREFIX
	$bits = explode(".",$file['name']);$prefix = $bits[1]; if(isset($bits[2])){$prefix = $bits[2]; }
 
	// VALIDATION // FILE NAMES
	foreach ($blacklist as $item) {
		if(preg_match("/$item/i", $file['name'])) {
			   return "invalid";
		}
	}
 
	// VALIDATION // CHECK FORMAT
	if(!in_array($file['type'], $permitted_files)){  return "invalid"; }
	
	// VALIDATION // CHECK FILE PREFIX
	if(!in_array(strtolower($prefix), $allowed_prefixes)){  return "invalid"; } 
	
		
		// SAVE FILE
		$copy = copy($file['tmp_name'], $STORAGEPATH.$file['name']);
		if($copy){
		
			// IF THE IMAGE SIZE IS GREATER THAN 400, RESIZE IT
			if(in_array($file['type'],$image_files)){			
				$image_info = @getimagesize($STORAGEPATH.$file['name']);
				if(is_array($image_info) && isset($image_info['mime']) && $image_info[0] > 800){
					$image->load($STORAGEPATH.$file['name']);
					$image->resizeToWidth(800);
					$image->save($STORAGEPATH.$file['name']);							
				}
			}
			
			// OK NOW THE FILES LOADED WE NEED TO RENAME IT FOR CLEANING UP LATER
			// IF THE USER IS LOGGED IN AND EDITING A LISTING, WE CAN ATTACH THE ITEMS TO THE 
			// LISTING, OTHERWISE WE NEED TO UPDATE THE FILENAME LASTER
			// BEST NAMING IS: (listing id)-(user id)-date
			if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ // EDITING LISTING, MUST BE A MEMBER
			
				$NewName =  $_GET['eid']."-".$userID."-".date("Y-m-d").RandomID(5).".".$prefix;
			
			}else{ // COULD BE ANYONE
			
				if(isset($userID)){
				
					$NewName =  "unknown-".$userID."-".date("Y-m-d").RandomID(5).".".$prefix;
					
				}else{
				
					$NewName =  "unknown-guest-".date("Y-m-d").RandomID(5).".".$prefix;
				}		
			
			}						   
								
			// NOW LETS RENAME IT		
			rename ($STORAGEPATH.$file['name'], $STORAGEPATH.$NewName);			
			
			return premiumpress_upload_return($NewName);			
			
			 		
		}else{
		
			return premiumpress_upload_return("error");
		
		}
	
	
	}else{ // array
	
		return premiumpress_upload_return("error");
	
	
	}
}
   
 


 
 
 

	
	
 
	
/******************************************************************* DEPRECIATED IN 6.3 (SEE PPT/CLASS/CLASS_DESING.PHP) */

function SidebarText($name=""){
global $userdata; get_currentuserinfo(); 

if(current_user_can('administrator')){
return "<div class='panel secondary'>
<b>".$name."</b>
<p><u><a href='".get_home_url()."/wp-admin/widgets.php'>Click here to edit this sidebar</a></u></p> <p>This sidebar is Widget ready which means you can customize the contents displayed here with widgets.</p></div>";
}
}
 
	
	
} // end premiumpress class











/***************** DO NOT EDIT THIS FILE *************************
******************************************************************

INFORMATION:
------------

This is a core theme file, you should not need to edit 
this file directly. Code changes maybe lost during updates.

EDITED BY: MARK FAIL
------------------------------------------------------------------

******************************************************************/

class PremiumPressTheme_Import extends PremiumPressTheme {
 
	function IMPORTSWITCH($period){
 
		global $wpdb;
		
		$debugArray = array();
		
		// CHECK FOR DEBUG
		if(get_option('ppt_debug_cron') == "1"){ $debugme = true; }else{ $debugme = false; }
	
		switch(strtolower(constant('PREMIUMPRESS_SYSTEM'))){
		

			case "shopperpress": {
	 
				// INCLUDE AMAZON CLASS
				require_once (TEMPLATEPATH ."/PPT/class/class_amazon.php");			
				$obj = new AmazonProductAPI();				
				$obj->amazon_dreepfeed($period);				
				if(get_option('enabled_amazon_updater') == "yes"){ 
				
					$debugArray['amazonupdate'] = $obj->AmazonAutoUpdaterTool(false); 
				
				}
		
			} break;
			
			case "comparisonpress": {
			
				if($period == "daily"){ $this->CLEARFOUND(); }
		
			} break;
				
			case "auctionpress": {
		
			} break;
			
			
			case "directorypress": {			
				
		
			} break;
		
			case "couponpress": {
			
				$debugArray['couponimport'] = $this->ICODESIMPORT($period);			
			
			} break;
		}
		 
	
		// CHECK FOR FEED IMPORT
		$debugArray['feedimport'] = $this->FEEDIMPORT($period);
		 	
		// CHECK MEMBERSHIP LEVELS
		$debugArray['membership'] = $this->MEMBERSHIPS($period);
		
		// CHECK FOR UNWANTED IMAGE FILES
		DELETEIMAGES();
		
		// PACKAGE EXPIRY
		$this->PACKAGEEXPIRY($period);
		
		// LOOK FOR ITEMS WHICH START TODAY AND SET THEIR STATUS TO ACTIVE
		if($period == "daily"){  $debugArray['startdate'] = $this->MAKESTARTDATE(); }	 
		
		// SEND DEBUG ME EMAIL
		if($debugme){
			$message = $period. " cron executed successfully at: ".date('l jS \of F Y h:i:s A');
			
			foreach($debugArray as $key=>$val){
			
			//echo $key." ".$val."<br>";
			
				//if(isset($debugArray[$key]) && $debugArray[$key] != false){
				
					switch($key){
					
					case "amazonupdate": { $message.= "<br>Amazon Update Completed<br>"; } break;
					case "feedimport": { $message.= "Feed Import Completed<br>";} break;
					case "membership": { $message.= "Membership Update Completed<br>";} break;
					case "couponimport": { $message.= "Coupon Import Completed<br>";} break;
					
					}
				
				//}			
			}
			 
			wp_mail( get_option('admin_email'), "Cron Debug Mail (".$period.")", $message);
		}
		
	} 

/* =============================================================================
   CHECK MEMBERSHIP LEVELS HAVENT EXPIRED / V7 / April 3rd
   ========================================================================== */

function MEMBERSHIPS($period){

	global $wpdb;
	
	// ONLY PERFORM THIS TWICE DAILY
	if($period == "daily"){ //$period == "twicedaily" || 
	
		// FIND ALL PACKAGES THAT HAVE EXPIRED	 
		$SQL = "SELECT user_id FROM $wpdb->usermeta WHERE `meta_key` = 'pptmembership_expires' AND meta_value <= '".date('Y-m-d h:i:s')."'";		
		$posts = $wpdb->get_results($SQL,ARRAY_A); 
		foreach ($posts as $p){	
		
		//0. GET CURRENT MEMBERSHIP LEVEL
		$currentlevel = get_user_meta($p['user_id'], "pptmembership_level", true);
		 
		//1. DOWNGRADE USER
		update_user_meta($p['user_id'], "pptmembership_level", 		"0");
		update_user_meta($p['user_id'], "pptmembership_status", 	"ok");
		update_user_meta($p['user_id'], "pptmembership_expires",	 "");
		
		// 2. CHECK IF THE EMAIL HASNT ALREADY BEEN SENT
		$sentalready = get_user_meta($p['user_id'], "sent_expired_email_".$currentlevel,true);
	  
		if($sentalready != "yes"){
				
			//3. SEND USER AN EMAIL
			$emailID = get_option("email_user_membershipexpired");
			if($emailID != "0" && strlen($emailID) > 0 ){					 
				//SendMemberEmail($p['user_id'], $emailID,$message);
			}
			
			// 4. UPDATE TO STOP REPEAT EMAILS
			update_user_meta($p['user_id'], "sent_expired_email_".$currentlevel, "yes");
		
		}
			
		} // end loop
			
	}else{ // end if 
	
		return false;
	
	}
	
}
/* =============================================================================
   CHECK FOR LISTING THAT HAVE A START DATE / V7 / Feb 25th
   ========================================================================== */
	
function MAKESTARTDATE(){

	global $wpdb; $count = 0;
	
	$SQL = "SELECT * 
	FROM $wpdb->postmeta
	WHERE $wpdb->postmeta.meta_key='starts' AND $wpdb->postmeta.meta_value LIKE '%".date('Y-m-d')."%'	LIMIT 1";	

	$posts = $wpdb->get_results($SQL,ARRAY_A); 
	foreach ($posts as $p){	
		$my_post 				= array();
		$my_post['ID'] 			= $p->post_id;
		$my_post['post_status'] = "publish";
		wp_update_post( $my_post );
		$count++;
	}
	//Reset Query
	wp_reset_query();
	
	if($count == 0){
		return false;
	}else{
		return $count;
	}
}
	
/* =============================================================================
   CHECK FOR SCHEDULED FEED IMPORTS
   ========================================================================== */
   
function FEEDIMPORT($period){ 

global $wpdb, $PPT; $i=0;

	$cf1 = get_option("feeddatadata"); 
	
	if(isset($cf1) && is_array($cf1)){
	
		require_once (TEMPLATEPATH ."/PPT/class/class_feed.php");
		$feedMe = new PremiumPress_Feed();
		$h = 0; // COUNT ARRAY LOOP VALUE
		foreach($cf1 as $feed){	
	 
			if($feed['period'] == $period){				 
				$feeddata = $feedMe->Add($h); /* <-- pass in loop value NOT key */	 
			}
		$h++;
		}
		
	}else{
	
		return false;
		
	}

}	
/* =============================================================================
   CLEAR THE FOUND RESULTS FOR THE SYSTEM
   ========================================================================== */

function CLEARFOUND(){

	global $wpdb, $PPT;

	$SQL = "UPDATE ".$wpdb->prefix."postmeta SET meta_value ='' WHERE meta_key='found'";
	
	$wpdb->get_results($SQL,ARRAY_A);
	
	return;
}
/* =============================================================================
   CHECK IF PACKAGE HAS EXPIRED / V7 / 25th Feb
   ========================================================================== */
		
function PACKAGEEXPIRY($period){

	global $wpdb, $PPT;

	$SQL = "SELECT ".$wpdb->prefix."postmeta.meta_value, ".$wpdb->prefix."posts.post_author, ".$wpdb->prefix."posts.post_title, ".$wpdb->prefix."posts.ID, ".$wpdb->prefix."posts.post_date,	
	".$wpdb->prefix."posts.guid AS link, ".$wpdb->prefix."posts.post_excerpt AS description
	FROM  `".$wpdb->prefix."postmeta` 
	INNER JOIN ".$wpdb->prefix."posts ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id)
	WHERE ".$wpdb->prefix."postmeta.meta_key =  'expires' AND ".$wpdb->prefix."postmeta.meta_value != '' AND ".$wpdb->prefix."posts.post_status = 'publish'";
	
	$posts = $wpdb->get_results($SQL,ARRAY_A);
	foreach ($posts as $post){
	
		$_POST = $post; // makes post global for email values
		
		if(premiumpress_expired($post['ID'], $post['post_date'])){
		
			$emailID = get_option("email_user_expired");					 
			if(is_numeric($emailID) && $emailID != 0){
				SendMemberEmail($post['post_author'], $emailID);
			}
	 
		}else{
			// since its not YET expired, lets see how many days it has left.	
			$days = round((strtotime(date("Y-m-d h:i:s", strtotime($post['post_date'] )) . " +".$post['meta_value']." days") - strtotime(date("Y-m-d h:i:s")) ) / (60 * 60 * 24),0);
		 
			if($days == 7 && $period == "daily"){	
				$emailID = get_option("email_user_expire7");					 
				if(is_numeric($emailID) && $emailID != 0){
					SendMemberEmail($post['post_author'], $emailID);
				}	
			}
		}				
	} // end foreach
}
 	
/* =============================================================================
   ICODES HOURLY IMPORT TOOL / V7 / 25th Feb
   ========================================================================== */

function ICODESIMPORT($period="hourly",$debug=false){
 
	global $wpdb; $c=0; $counterA=0; $counterB=0; $page=0;
	
	
	// AUTOMATICALLY IMPORT NEW COUPONS
	if(get_option("icodes_autoimport_coupons") == "1"  ){ 
	 
		$mapCatsList = get_option('icodes_autoimport_cats');
	
		$QueryString  = get_option('icodes_country')."?";
		$QueryString .= "UserName=".get_option('icodes_subscription_username');
		$QueryString .= "&SubscriptionID=".get_option('icodes_subscriptionID')."&Relationship=joined";
		$QueryString .= "&RequestType=Codes&Action=New&Hours=24&PageSize=50";
		
		if($debug){ if(isset($_GET['testfeedlink']) && $_GET['testfeedlink'] == 1){ return $QueryString; }else{ $QueryString=""; }  }
	 
	 	if($QueryString != ""){
		
			$xml = $this->GetIcodesData($QueryString,"xml");
		 
			$message1 = trim($xml->Message);
			if($message1==''){
			
				foreach ($xml->item as $item) { 
				
					$iCodesCatID = str_replace("!@121212","",$item->category_id[0]);			
					if(isset($mapCatsList[$iCodesCatID]['catID'])){ $pCat = $mapCatsList[$iCodesCatID]['catID']; }else{ $pCat=0; }				 
					if($this->ICODESADDCOUPON($item,$pCat,"Codes")){$counterA++;}else{ $counterB++;}	
				 
				 }
			} 
		
		}		
		
	}
		
	// AUTOMATICALLY IMPORT NEW OFFERS
	if(get_option("icodes_autoimport_offers") == "1"  ){ 
	 
		$mapCatsList = get_option('icodes_autoimport_cats');
	
		$QueryString  = get_option('icodes_country')."?";
		$QueryString .= "UserName=".get_option('icodes_subscription_username');
		$QueryString .= "&SubscriptionID=".get_option('icodes_subscriptionID')."&Relationship=joined";
		$QueryString .= "&RequestType=Offers&Action=New&Hours=48&PageSize=50";
		
		if($debug){ if(isset($_GET['testfeedlink']) && $_GET['testfeedlink'] == 2){ return $QueryString; }else{ $QueryString=""; }  }
		
		if($QueryString != ""){
	 
			$xml = $this->GetIcodesData($QueryString,"xml");
		 
			$message1 = trim($xml->Message);
			if($message1==''){
			
				foreach ($xml->item as $item) {			
					$iCodesCatID = str_replace("!@121212","",$item->category_id[0]);		 
					if(isset($mapCatsList[$iCodesCatID]['catID'])){ $pCat = $mapCatsList[$iCodesCatID]['catID']; }else{ $pCat=0; }					 
					if($this->ICODESADDCOUPON($item,$pCat,"Offer")){$counterA++;}else{ $counterB++;}			 
				 }
			}
		
		}
	
	}
	
	if($counterA == 0){
	return false;
	}else{
	return $counterA;
	}

} 

/* =============================================================================
   ADD ICODES TO DATABASE / V7 / 25th Feb
   ========================================================================== */

function ICODESADDCOUPON($cc,$cat=0,$type){

 	global $wpdb; $code = array();
	 
	 $dataArray = array('id','title','description','merchant','merchant_logo_url','merchant_id','program_id','voucher_code','excode','affiliate_url','merchant_url','icid','mid','network','deep_link','start_date','expiry_date','category','category_id');
	 
	foreach($dataArray as $key){	 
	 	$code[$key] 		= str_replace("","",$cc->$key);	 
	}
 
	// GIVE THE COUPON AN ID TO REFERENCE ID
	$id = $code['icid'];
	
	// COUPON WEBSITE URL STRIP HTTPS
	$dd = str_replace("http://","",str_replace("www.","",$code['merchant_url']));
	$dd1 = explode("/",$dd);
 
	// CHECK FOR DUPLICATES	
	$SQL = "SELECT count($wpdb->postmeta.meta_key) AS total, post_id
	FROM $wpdb->postmeta
	WHERE $wpdb->postmeta.meta_key='ID' AND $wpdb->postmeta.meta_value = '".$id."'	LIMIT 1";	
 
	
	$array = (array)$wpdb->get_results($SQL,"ARRAY_A");
	 
	if(isset($array[0]['total'])){	
	$array['total'] = $array[0]['total'];
	}	
		//die(print_r($array)."<--".$array['total']);
	if($array['total'] == 0){ 
	
		// AUTO SETUP CATEGORY
		if($cat == "setup"){	 
			 if ( is_term( str_replace("_"," ",$code['category']) , 'category' ) ){				 
				 $term = get_term_by('name', str_replace("_"," ",$code['category']), 'category');			
				 $cat = $term->term_id;
			 }else{
				$args = array('cat_name' => str_replace("_"," ",$code['category']) ); 
				$term = wp_insert_term(str_replace("_"," ",$code['category']), 'category', $args);				
				$cat = $term->term_id;				 
			 }
		}
 
 
 	// CREATE THE CUSTOM TITLE AND DESCRIPTION
	$ctitle = stripslashes(get_option("icodes_custom_title"));
	if($ctitle == ""){
		$CUSTOMTITLE = $code['title'];
	}else{	    
		$CUSTOMTITLE = str_replace("[title]",$code['title'],str_replace("[code]",$code['voucher_code'],str_replace("[merchant]",$code['merchant'],str_replace("[url]",$dd1[0],str_replace("[starts]",date('l jS \of F Y h:i:s A',strtotime($code['start_date'])),str_replace("[ends]",date('l jS \of F Y h:i:s A',strtotime($code['expiry_date'])),$ctitle))))));
		
		$CUSTOMTITLE = str_replace("[description]",$code['description'],$CUSTOMTITLE);
	}
	
	$cdesc = stripslashes(get_option("icodes_custom_desc"));
	if($cdesc == ""){
		$CUSTOMDESC = $code['description'];
	}else{
		$CUSTOMDESC = str_replace("[description]",$code['description'],str_replace("[code]",$code['voucher_code'],str_replace("[merchant]",$code['merchant'],str_replace("[url]",$dd1[0],str_replace("[starts]",date('l jS \of F Y h:i:s A',strtotime($code['start_date'])),str_replace("[ends]",date('l jS \of F Y h:i:s A',strtotime($code['expiry_date'])),$cdesc))))));
		
		$CUSTOMDESC = str_replace("[title]",$code['title'],$CUSTOMDESC);
		  
	}
	 
 
			 $my_post = array();
			 $my_post['post_title'] 	= $CUSTOMTITLE;
			 $my_post['post_content'] 	= $CUSTOMDESC;
			 $my_post['post_excerpt'] 	= $CUSTOMDESC;
			 $my_post['post_author'] 	= 1;
			 $my_post['post_status'] 	= get_option("icodes_import_status");
			 $my_post['post_category']  = array($cat);
			 //$my_post['tags_input'] = $dd1[0];
	 
			 $POSTID = wp_insert_post( $my_post );	  
					 
			if (strlen(stristr($type,"Codes"))>0) { $thetype = "coupon"; } else { $thetype = "offer"; }
					 
			 // EXTRA FIELDS
			 add_post_meta($POSTID, "ID", 		str_replace("!!aaqq","",$id));
			 
			 if($code['voucher_code'] == ""){
			 add_post_meta($POSTID, "code", 	$code['coupon_code']);
			 }else{
			 add_post_meta($POSTID, "code", 	$code['voucher_code']);
			 }
			 add_post_meta($POSTID, "url", 		$code['merchant_url']);	  
			 add_post_meta($POSTID, "hits", 	"0");
			 add_post_meta($POSTID, "link", 	$code['affiliate_url']);	
			 add_post_meta($POSTID, "image", 	$code['merchant_logo_url']);
			 add_post_meta($POSTID, "featured", "no");
			 add_post_meta($POSTID, "type", 	$thetype);
			 
			 add_post_meta($POSTID, "starts", 	$code['start_date']);
			 add_post_meta($POSTID, "pexpires", $code['expiry_date']);
			  	
				 
	if ( is_term( $code['network'] , 'network' ) ){
		 $term = get_term_by('name', str_replace("_"," ",$code['network']), 'network');
		 $netID = $term->term_id;
	}else{
		$args = array('cat_name' => str_replace("_"," ",$code['network']) ); 
		$term = wp_insert_term(str_replace("_"," ",$code['network']), 'network', $args);
		$netID = $term->term_id;
	}	
	
 
	wp_set_post_terms( $POSTID, $netID, 'network' );
	
	if ( is_term( $code['merchant'] , 'store' ) ){
		 $term = get_term_by('name', str_replace("_"," ",$code['merchant']), 'store');
		 $storeID = $term->term_id;
	}else{
		$args = array('cat_name' => str_replace("_"," ",$code['merchant']) ); 
		$term = wp_insert_term( str_replace("_"," ",$code['merchant']), 'store', $args);
		$storeID = $term->term_id;
	}			 
				 
	
	wp_set_post_terms( $POSTID, $storeID, 'store' );
				
	 return true;	
		
		 
	 }else{
	 
	 //coupon/offer has already been found
	 // lets update it with the new category just incase
	 if($array['total'] == 1){
	 
	 $my_post = array();
	 // AUTO SETUP CATEGORY
		if($cat == "setup"){
		  
			 if ( is_term( str_replace("_"," ",$code['category']) , 'category' ) ){				 
				 $term = get_term_by('name', $code['category'], 'category');			
				 $cat = $term->term_id;
			 }else{
				$args = array('cat_name' => str_replace("_"," ",$code['category']) ); 
				$term = wp_insert_term(str_replace("_"," ",$code['category']), 'category', $args);				
				$cat = $term->term_id;				 
			 }
			 
			 $my_post['post_category']  = array($cat);
		}else{
		
		$arrayList = "";
		 foreach((get_the_category($array['post_id'])) as $category) {		 
		 	$arrayList .= $category->cat_ID.","; 		 
		 }
		 $arrayList = substr($arrayList,0,-1).",".$cat;
		$my_post['post_category']  = explode(",",$arrayList);
		}
		 
		 
		// print $array['post_id']."<br>";
		 if(strlen($arrayList) > 1){ 
	 		
			$my_post['ID'] = $array['post_id'];	
			
			wp_update_post( $my_post );
			if($array['post_id'] == "4024"){
		// die(print_r($my_post));
		 }
			
		 }
	  
	 }
	 //die($array['total']."<--".print_r($array));
	 //
	 
	 return false;	
	 
	 }
 
 return $POSTID;
} 

/* =============================================================================
   QUERY STRING / V7 / 25th Feb
   ========================================================================== */
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
	
	}else{
	 
		$xml = simplexml_load_file($QueryString);
	
	}

	return $xml;
}


	

} // END OF IMPORT CLASS
 









class ResizeImage extends PremiumPressTheme {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      
}

 

// holds soem methods used for handling errors.
class data_export_error_handling {
	
	// mimics the errors from php, also shows the correct line numbers.
	protected function custom_error($msg){
		if (ini_get('display_errors') && error_reporting() > 0){
			$info		= next(debug_backtrace());
			$prepend	= ini_get('error_prepend_string');
			$append		= ini_get('error_append_string');
			
			if (empty($prepend) === false) echo $prepend;
			
			echo "Warning: {$msg} in {$info['file']} on line {$info['line']}";
			
			if (empty($append) === false) echo $append;
		}
	}
	
}

class data_export_helper extends data_export_error_handling {
	
	// holds the data to be exported.
	private $data				= null;
	
	// holds the value of the constant chosen from the below (defaults to csv).
	private $export_mode		= 4;
	
	// the available modes, because json may not be available.
	private $available_modes	= null;
	
	// these determine the export type.
	const EXPORT_AS_XML			= 0;
	const EXPORT_AS_JSON		= 1;
	const EXPORT_AS_SERIALIZE	= 2;
	const EXPORT_AS_CSV			= 3;
	const EXPORT_AS_EXCEL		= 4;
	
	// loads the data.
	public function __construct($data){
		if (is_object($data)){
			$this->data = get_object_vars($data);
		}else if (is_array($data)){
			$this->data = $data;
		}else{
			$this->custom_error('data_export_helper::__construct(): The supplied argument must be either an object or an array.');
		}
		
		$this->available_modes = array();
			
		$this->available_modes[] = self::EXPORT_AS_XML;
		
		if (is_callable('json_encode')){
			$this->available_modes[] = self::EXPORT_AS_JSON;
		}
		
		$this->available_modes[] = self::EXPORT_AS_SERIALIZE;
		$this->available_modes[] = self::EXPORT_AS_CSV;
		$this->available_modes[] = self::EXPORT_AS_EXCEL;
	}
	
	// gets an array of available export modes.
	public function get_available_export_modes(&$result){
		$result = $this->available_modes;
		
		return true;
	}
	
	// sets the export mode to one of the given constants.
	public function set_mode($mode){
		if (in_array($mode, $this->available_modes) === false){
			$this->custom_error('data_export_helper::set_mode(): The selected export mode is not available.');
			return false;
		}
		
		$this->export_mode = $mode;
		return true;
	}
	
	// exports the data as xml.
	private function export_as_xml(){
		$xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		$xml .= "<document>\n";
		
		foreach ($this->data as $data){
			if (is_array($data)){
				$xml .= "\t<entry>\n";
				
				foreach ($data as $key => $val){
					while (is_array($val)){
						$val = $val[0];
					}
					
					$key = htmlspecialchars($key);
					$val = htmlspecialchars($val);
					
					$xml .= "\t\t<{$key}>{$val}</{$key}>\n";
				}
				
				$xml .= "\t</entry>\n";
			}else{
				$data = htmlspecialchars($data);
				$xml .= "\t<entry>{$data}</entry>\n";
			}
		}
		
		$xml .= '</document>';
		
		return $xml;
	}
	
	// exports the data as a json encoded string.
	private function export_as_json(){
		return json_encode($this->data);
	}
	
	// exports the data as serialized string.
	private function export_as_serialize(){
		return serialize($this->data);
	}
	
	// exports the data as csv.
	private function export_as_csv(){
		$headings = array_keys($this->data[0]);
		
		foreach ($headings as &$heading){
			$heading = str_replace('"', '""', trim($heading));
		}
		
		$csv = '"' . implode('","', $headings) . "\"\r\n";
		
		foreach ($this->data as $data){
			$data = (is_array($data)) ? array_values($data) : array($data);
			
			foreach ($data as &$entry){
				while (is_array($entry)){
					$entry = $entry[0];
				}
				
				if (is_numeric($entry) === false){
					$entry = '"' . str_replace('"', '""', trim($entry)) . '"';
				}
			}
			
			$csv .= implode(',', $data) . "\r\n";
		}
		
		return $csv;
	}
	
	// exports the data as excel xls format.
	private function export_as_excel(){
		$xls = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		
		$xls_data = array(array_keys($this->data[0]));
		
		foreach ($this->data as $data){
			$xls_data[] = (is_array($data)) ? array_values($data) : array($data);
		}
 
		foreach ($xls_data as $row => $data){
			foreach ($data as $col => $entry){
				if (is_numeric($entry)){
					$xls .= pack("sssss", 0x203, 14, $row, $col, 0x0);
					$xls .= pack("d", $entry);
				}else{
					$len = strlen($entry);
					
					$xls .= pack("ssssss", 0x204, 8 + $len, $row, $col, 0x0, $len);
					$xls .= $entry;
				}
			}
		}
		
		$xls .= pack("ss", 0x0A, 0x00);
		
		return $xls;
	}
	
	// calls the appropriate method to export the data.
	public function export(&$result){
		if (empty($this->data)){
			$this->custom_error('data_export_helper::export(): Data array cannot be empty.');
			return false;
		}
		
		if ($this->export_mode === self::EXPORT_AS_XML){
			$result = $this->export_as_xml();
		}else if ($this->export_mode === self::EXPORT_AS_JSON){
			$result = $this->export_as_json();
		}else if ($this->export_mode === self::EXPORT_AS_SERIALIZE){
			$result = $this->export_as_serialize();
		}else if ($this->export_mode === self::EXPORT_AS_CSV){
			$result = $this->export_as_csv();
		}else if ($this->export_mode === self::EXPORT_AS_EXCEL){
			$result = $this->export_as_excel();
		}else{
			$result = null;
			return false;
		}
		
		return true;
	}
}

?>