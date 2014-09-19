<?php

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */ 
  
if(!function_exists('get_currentuserinfo')){ die("No Access"); }

global $PPT,$ThemeDesign, $query_string, $PPTDesign, $user_ID, $userdata; get_currentuserinfo(); 

/* =============================================================================
   LOAD HOME PAGE
   ========================================================================== */

if(is_home() && !isset($_GET['s']) && !isset($_GET['search-class']) ){


	$GLOBALS['flag-home'] = 1; // sometimes WP doesnt always get the home page // dunno why?! do you? 

	// CHECK FOR SP, HATE ADDED IT HERE BUT NEEDS TO BE DONE
	if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){$DHOME = get_option("display_default_homepage");}else{ $DHOME = 0; }
	
	// LOAD IN THE CHILD THEME NAME
	$THEMEN = get_option('theme');

	// FIRE UP THE HOOKS TO CHECK FOR HOOKED CONTENT
	$hookContent = premiumpress_pagecontent("homepage");

	if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

		get_header();
		
		echo $hookContent;
		
		get_footer();

	}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$THEMEN."/_homepage.php") && $DHOME != 1 ){
		
		include(str_replace("functions/","",THEME_PATH)."/themes/".$THEMEN.'/_homepage.php');

	}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_homepage.php")){
		
		include(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_homepage.php");
		
	}else{
	 
        get_header(); $used_items = get_option('ppt_layout_block');  ?>
          
        <?php if(get_option("PPT_slider") =="s2" ){  $GLOBALS['s2'] =1;echo $PPTDesign->SLIDER(2); } ?>
        
        <?php if(is_array($used_items)){ foreach($used_items as $object){ echo $PPTDesign->GetObject($object); } } ?> 
     
        <?php get_footer();
	
	}
	
	// THAT'S ALL FOLKS!
	
	 
/* =============================================================================
   GALLERY PAGE - BUILD CUSTOM QUERY
   ========================================================================== */
   
}elseif(!is_single() && !is_page() ){ 
	 
	// SET FLAG JUST IN CASE WP DOESNT DO IT
	$GLOBALS['GALLERYPAGE'] = 1; 
  
  	// STORE DATA IN GLOBALS FOR THEME USAGE
	$GLOBALS['query_data'] 		= $posts;
	$GLOBALS['query_string'] 	= $query_string; 
 	
	// ADD IN CHECKS FOR TAG SEARCH SO WE CAN DISABLE THE ORDER BY OPTION
	if(strpos($GLOBALS['query_string'], "tag=") !== false || strpos($GLOBALS['query_string'], "price=") !== false || strpos($GLOBALS['query_string'], "location=") !== false || strpos($GLOBALS['query_string'], "store=") !== false ) { 
	 $GLOBALS['tag_search'] = true;
	} 
 
	// DETERMIN TOTAL AMOUNTS AND PAGE AMOUNTS  
	$total_posts = (int) $wp_query->found_posts;	 
 
	$GLOBALS['query_total']		= $total_posts;	
	$GLOBALS['query_total_num'] = $total_posts;	
 		
	// FIRE UP THE HOOKS TO CHECK FOR HOOKED CONTENT	
	$hookContent = premiumpress_pagecontent("gallerypage"); /* HOOK V7 */
	
	if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

		get_header();
		
		echo $hookContent;
		
		get_footer();

	}elseif(strpos($GLOBALS['query_string'], "article=") !== false || ( isset($_GET['post_type']) && $_GET['post_type'] == "article_type")){
	
		$GLOBALS['ARTICLEPAGECONTENT'] = true;
	
		include(str_replace("functions/","",THEME_PATH)."tpl-articles.php");
	 
	}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_gallerypage.php")){
		
		include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_gallerypage.php');
		
	}else{
	
		include("template_".strtolower(PREMIUMPRESS_SYSTEM)."/_gallerypage.php");
	
	}
	
	// THAT'S ALL FOLKS!

} 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>