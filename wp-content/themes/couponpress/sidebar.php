<?php

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */ 
   
if(!function_exists('get_currentuserinfo')){ die("No Access"); }

global $PPT,$ThemeDesign, $PPTDesign, $user_ID, $userdata; get_currentuserinfo();

/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("sidebar-right"); /* HOOK V7 */
 
if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme']."/_sidebar.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/_sidebar.php');
		
}else{

/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
?>

<div id="sidebar" class="<?php $PPTDesign->CSS("columns-right"); ?>">

	<div class="sidebar_wrapper">

<?php premiumpress_sidebar_right_top(); /* HOOK */ ?> 

<?php if(is_single() && !isset($GLOBALS['ARTICLEPAGE']) && get_option("display_listinginfo") =="yes"){  echo $PPTDesign->GetObject('authorinfo'); }
	
/****************** INCLUDE WIDGET ENABLED SIDEBAR *********************/

if(function_exists('dynamic_sidebar')){ 

	if(is_single() && !isset($GLOBALS['ARTICLEPAGE']) ){
		if ( !is_active_sidebar('sidebar-3') ) {
		echo $PPT->SidebarText('Listing Page');
		}else{
			dynamic_sidebar('Listing Page') ;
		} 
	}elseif( isset($GLOBALS['ARTICLEPAGE']) ){
		if ( !is_active_sidebar('sidebar-5') ) {
		echo $PPT->SidebarText('Article/FAQ Page Sidebar');
		}else{
			dynamic_sidebar('Article/FAQ Page Sidebar') ;
		} 
	}elseif(is_page()){
		if ( !is_active_sidebar('sidebar-4') ) {
		echo $PPT->SidebarText('Pages Sidebar');
		}else{
			dynamic_sidebar('Pages Sidebar') ;
		}
	}else{
		if ( !is_active_sidebar('sidebar-1') ) {
		echo $PPT->SidebarText('Right Sidebar');
		}else{
		dynamic_sidebar('Right Sidebar'); 
		} 
	}
}

/****************** end/ INCLUDE WIDGET ENABLED SIDEBAR *********************/
 				

if(isset($GLOBALS['premiumpress']['catID']) && is_numeric($GLOBALS['premiumpress']['catID'])){ 					

	echo premiumpress_bannerZone($GLOBALS['premiumpress']['catID']); 					

}


 premiumpress_sidebar_right_bottom(); /* HOOK */ ?> 

</div><!-- end right sidebar wrapper --> 

<?php if(get_option('advertising_right_checkbox') =="1"){ ?><div class="aligncenter"><?php echo premiumpress_banner("right");?></div><?php } ?>  

</div><!-- end right sidebar --> 
	
<?php }
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>