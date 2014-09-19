<?php

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */ 
   
if(!function_exists('get_currentuserinfo')){ die("No Access"); }

global $PPT,$ThemeDesign, $PPTDesign, $user_ID, $userdata; get_currentuserinfo();

	// ADMIN OPTION // GET CUSTOM WIDTH FOR PAGES
	$GLOBALS['page_width'] 	= get_post_meta($post->ID, 'width', true);
	if($GLOBALS['page_width'] =="full"){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }

	// CHECK USER - PAGE ACCESS
	if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){ 
	
		// GET MEMBERSHIP OPTIONS
		$MEMBERSHIPDATA = get_option('ppt_membership');
		
		// CHECK IF WE HAVE ENABLED THE SYSTEM
		if(isset($MEMBERSHIPDATA['enable']) && $MEMBERSHIPDATA['enable'] == "no"){
	 
	 		//NOTHING TODO
			 
		}else{		 
	 
			$GLOBALS['page_package_acecss'] = get_post_meta($post->ID, "package_access", true);	
			if(is_array($GLOBALS['page_package_acecss']) && !in_array(0,$GLOBALS['page_package_acecss'])){
			
				// GET USER ACCESS
				$GLOBALS['membershipID'] 		= get_user_meta($userdata->ID, 'pptmembership_level', true);			
			
			}
		
		}
		
				
	} // end if
	
/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */
   
$hookContent = premiumpress_pagecontent("page"); /* HOOK V7 */

if( 
( !isset($userdata) && is_array($GLOBALS['page_package_acecss']) && !in_array(0,$GLOBALS['page_package_acecss']) ) || 
($userdata->ID == 0 &&  is_array($GLOBALS['page_package_acecss']) && !in_array(0,$GLOBALS['page_package_acecss']) ) || ( $userdata->ID !=0 &&  isset($GLOBALS['membershipID']) && is_numeric($GLOBALS['membershipID']) && !in_array($GLOBALS['membershipID'],$GLOBALS['page_package_acecss']) ) ){

	// REDIRECT GUEST TO LOGIN PAGE
	if($userdata->ID == 0){		
		
		header("location: ".$GLOBALS['bloginfo_url']."/wp-login.php?action=register&noaccess=1");	
	}
	
	get_header();
	
	echo "<h3>".$PPT->_e(array('membership','1'))."</h3>";
	
	echo "<p>".$PPT->_e(array('membership','2'))."</p> ";
	
	echo "<hr />";
	
	echo $PPTDesign->Memberships($GLOBALS['membershipID'],$GLOBALS['page_package_acecss']);
	
	get_footer(); 
		 
}elseif(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_page.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_page.php');
		
}else{ 
	
/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 

get_header( ); ?> 

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
 
<div class="itembox">
    
    <h1 class="title"><?php the_title(); ?></h1>
    
    <div class="itemboxinner article">    
    
    <div class="entry">
    
    <?php the_content(); ?>     
    
    </div>		
    
    <?php endwhile; endif; ?>

	</div>

<div class="clearfix"></div>
 
</div>
 
<?php get_footer(); 
	
}
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>