<?php

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */

@header( 'HTTP/1.1 404 Not found', true, 404 );

/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("404"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_404.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_404.php');
		
}else{ 
	
/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 

get_header(); ?>

<div class="itembox">

<h1 class="title"><?php echo $PPT->_e(array('title','14')); ?></h1>

<div class="itemboxinner article ">        
        
        <?php if ( current_user_can('edit_post', $post->ID) ) {  ?>
        
        
        
        <div class="red_box">        
            <div class="red_box_content"> 
            <img src="http://i.imgur.com/62wcKsm.png">
            <h3>Admin Help: Why am i seeing this page?</h3>          
                    
            <p>This error 404 page means that for some reason the page could not be found or loaded correctly.</p>        
            <p>It maybe that your Wordpress permalink cache needs refreshing, <b><a href="<?php echo $GLOBALS['bloginfo_url']; ?>/wp-admin/options-permalink.php" target="_blank">click this link to view your admin permalink structure</a></b> then come back and refresh this page.</p>        
            <p>If the error continues try checking your website link is correct in your browser window or re-creating the page from scratch.</p>          
            <p><em>Note: You are seeing this page because you are logged into an admin account, normal website visitors will not see this message.</em></p>
            
            </div>
        </div>
        
        <?php } ?>
              

	<div class="clearfix"></div>
    
</div>

</div>

<?php get_footer(); ?>

<?php
	
} 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>