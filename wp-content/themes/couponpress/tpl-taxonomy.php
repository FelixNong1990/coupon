<?php
/*
Template Name: [Taxonomy List Template]
*/

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */ 

global  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars

$wpdb->hide_errors(); nocache_headers();

$thistax = get_post_meta($post->ID, 'type', true);
$parent = get_post_meta($post->ID, 'parent', true);
if($parent == ""){ $parent=0; }

if($thistax == ""){

	if(current_user_can('administrator')){
	
		if(isset($_GET['type'])){
		
			update_post_meta($post->ID, 'type', $_GET['type']);
			
		}else{
		
		wp_die( 'Select the list type:  <form action="" method="get"><select name="type"><option value="category">Category List</option><option value="location">Country/State/City List</option><option value="store">Stores List</option></select><input name="" type="submit" value="Save Selection" /></form>' );
		
		}
	
	}else{
	
	wp_die( 'This page has not yet been setup.' );
	
	}
 
}

$GLOBALS['LOADTHISTAX'] 	= $thistax;
$GLOBALS['PARENT'] 			= $parent;
$GLOBALS['COLUMNS'] 		= "1";
 
/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */
 
$hookContent = premiumpress_pagecontent("taxonomy"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_tpl_taxonomy.php")){
		
		include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_tpl_taxonomy.php');
		
}else{ 
	
/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 

get_header( ); ?> 

<div class="itembox">
    
    <h1 class="title"><?php the_title(); ?></h1>
    
    <div class="itemboxinner"> 
    
	<?php echo $PPTDesign->TaxonomyDisplay($GLOBALS['COLUMNS'],$thistax,1,$parent);  ?>	 

	</div><!-- end itembox innner -->

</div><!-- end itembox --> 
 
<?php get_footer(); 

}
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>