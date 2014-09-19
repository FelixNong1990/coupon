<?php

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */
   
global $PPT, $wp_query, $PPTDesign, $ThemeDesign,$userdata; get_currentuserinfo();
 
$GLOBALS['RETURNPHOTO']=true; // quick fix, needs removing soon

 
// GET THE AUTHOR ID  
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );

$GLOBALS['authorID'] = $author->ID; 
 
/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("author"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_author.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_author.php");

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_author.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_author.php');
		
}else{ 

/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 


// LAST LOGGED IN
$lastlog = premiumpress_user($GLOBALS['authorID'],"last_login");
 
 
// GET USER PHOTO
$img = get_user_meta($author->ID, "pptuserphoto",true);
if($img == ""){
	$img = get_avatar($author->ID,52);
}else{
	$img = "<img src='".get_option('imagestorage_link').$img."' class='photo pptphoto' alt='user ".$author->ID."' />";
}



get_header();  if ( have_posts() ) the_post(); ?>


			<?php 
			
			// PROFILE LINK BOX
			if($userdata->ID == $GLOBALS['authorID']){ ?>
            
            <div class="green_box"><div class="green_box_content">
            
            <h3>My Profile Link</h3>
            <p>Share your profile link with your friends and family online so they can see your website profile.</p>
            <input value="<?php echo get_author_posts_url( $userdata->ID, get_the_author_meta( 'user_nicename', $userdata->ID) ); ?>" type="text" style="width:98%;" />
            
            <div class="clearfix"></div></div></div>
            
            <?php } ?>


<div class="itembox">


    <div id="begin" class="inner">
        
        <div class="right"><?php echo $img; ?></div>
        
        <h3><?php echo get_the_author(); ?></h3>
        
        <p class="icon star"><a href="javascript:void(0);" addthis:url="<?php echo get_author_posts_url( $GLOBALS['authorID'], get_the_author_meta( 'user_nicename', $GLOBALS['authorID']) ); ?>" class="addthis_button"><?php echo get_author_posts_url( $GLOBALS['authorID'], get_the_author_meta( 'display_name', $GLOBALS['authorID']) ); ?></a></p>
        
        <?php if(strlen($lastlog) > 0){ echo '<p class="lastlog">'.str_replace("%a",get_the_author(), str_replace("%b",$lastlog,$PPT->_e(array('author','4')))).'</p>'; } ?>
        
        <?php echo get_the_author_meta( 'description', $GLOBALS['authorID']); ?>
        
        <br />
        
        <ol class="page_tabs">
        
            <li><a href="#tab1"><?php echo $PPT->_e(array('author','3')); ?></a></li>
            <?php if($author->ID != "" && is_numeric($author->ID)){ ?><li><a href="#tab2"><?php echo str_replace("%a",get_the_author(),$PPT->_e(array('author','2'))) ?></a></li><?php } ?>                   
        
        </ol>
                            
    </div>
	 
	<div class="itemboxinner">
    
        <div class="page_container">
    
        	<div id="tab1" class="page_content"> 
            
            <?php
			
			function _premiumpress_author_description(){
			
				global $PPT; $STRING = "";
				
				$desctxt = get_the_author_meta( 'description' );
				
				if(strlen($desctxt) > 2){
				
					$STRING .= '<p class="texttitle">'.$PPT->_e(array('myaccount','14')).'</p>
					<hr />
					<p>'.$desctxt.'</p> ';
					
				}
				
				return $STRING;
			
			}
			
			echo premiumpress_author_description(_premiumpress_author_description());
			?> 

                
            </div>
                
            <!-- end tab 1 -->
    
            <div id="tab2" class="page_content">

			<ol class="list starlist nopadding">
                        
                        <?php
                        if($author->ID != "" && is_numeric($author->ID)){
						
                        $i=1;
                        $posts = query_posts('caller_get_posts=1&author='.$author->ID.'&post_type=post&post_status=publish&orderby=post_date&order=DESC'); 
                        foreach($posts as $post){  
                        
                     
                        $price_current 	= get_post_meta($post->ID, "price_current", true);
                     
                        $bid_status = get_post_meta($post->ID, "bid_status", true);
                        if($bid_status == "open" || $bid_status ==""){$bid_status_text = "Running"; }else{ $bid_status_text = "<span style='color:#ccc;'>Ended</span>"; }	
                        
                        ?>
                         
                         <li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a> - <?php echo get_the_date(); ?></li>
                         <?php $i++; } 
						 
						 } // end if
						 
						 ?>   
                            
                     </ol>
                     
                </div>
                
                <!-- end tab 2 -->
                            
         </div> 

	</div>
    
    <!-- start buttons -->
    <div class="enditembox inner"> 
    
    <?php if($userdata->ID == $author->ID){ ?>
    <input type="button" onclick="window.location='<?php echo get_option('dashboard_url'); ?>'" class="button gray" tabindex="15" value="<?php echo $PPT->_e(array('button','7')); ?>" /> 
    <?php } ?>
                    
      	<a  class="button gray right" href="<?php echo get_option("messages_url"); ?>/?u=<?php echo get_the_author(); ?>"><?php echo str_replace("%a",get_the_author(),$PPT->_e(array('author','1'))) ?> <img src="<?php echo get_template_directory_uri(); ?>/PPT/img/button/comment.png" /></a>
         
    </div>
    <!-- end buttons --> 
    
</div>


<?php get_footer();  }
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>