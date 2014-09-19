<?php
/*
Template Name: [Articles Template]
*/

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */

global $PPT, $PPTDesign, $ThemeDesign, $userdata; get_currentuserinfo();

$GLOBALS['ARTICLEPAGE']=true; 

// ADMIN OPTION // GET CUSTOM WIDTH FOR PAGES
$GLOBALS['page_width'] 	= get_post_meta($post->ID, 'width', true);
if($GLOBALS['page_width'] =="full"){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }

/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("articles"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_tpl_articles.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_tpl_articles.php');
		
}else{ 
	
/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
get_header();  

?>

<div class="itembox">

<h1 class="title"><?php if(isset($GLOBALS['ARTICLEPAGECONTENT'])){ echo $GLOBALS['premiumpress']['catName']; }else{ the_title(); } ?></h1>

	<div class="itemboxinner greybg">
    
    
      <?php 
       
       /* CUSTOM CATEGORY DESCRIPTION */
       
       if(isset($GLOBALS['catText']) && strlen($GLOBALS['catText']) > 1){  echo $GLOBALS['catText']; }
       
       /* END CUSTOM CAT DESCRIPTION */
      
	  
	  if(strlen($post->post_content) > 2 && !isset($GLOBALS['ARTICLEPAGECONTENT']) ){ ?><p><?php echo wpautop($post->post_content); // display the template page content regardless ?></p><?php } ?>
 
         <div id="articlepage">
        
            <div id="acontent">
            
            <?php 
			 
			if(!isset($GLOBALS['ARTICLEPAGECONTENT']) ){ 
			 
				$temp 		= $wp_query; //save old query
				$wp_query	= null; //clear $wp_query
				$articlesperpage = get_option("articles_per_page"); if($articlesperpage == ""){ $articlesperpage =6; }
			 
				$wp_query 	= new WP_Query();
				$articles 	= $wp_query->query( array( 'post_type' =>'article_type', 'orderby'=> 'ID', 'order' => 'desc', 'paged' => $paged, 'posts_per_page' =>  $articlesperpage ) ); //
				$canContinue = true; 
			}else{
				 
				$articles = query_posts($GLOBALS['query_string']);
				
				if($GLOBALS['query_total'] > 0){ $canContinue = true; }else{ $canContinue = false; } 
				
			}
			
			// DEFAULT DATE VALUES
			$date_format = get_option('date_format') . ' ' . get_option('time_format');
			$my_date = the_date('d-M', '', '', FALSE);
			 
			// START LOOP
			if($canContinue){
            foreach($articles as $post){ 			
			
			$datebits = explode("-",$my_date); 
			$date = mysql2date($date_format, $post->post_date, false);

            
            if(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/_item_article.php')){
                                        
                            include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/_item_article.php');
                                        
                        }else{
                        
                            if(file_exists(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item_article.php")){
                            
                                include(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item_article.php"); 
                            
                            }else{
                            
							// GET ARTICLE CATEGORIES
							$terms = get_the_terms( $post->ID, 'article' );
							if(is_array($terms)){ // MULTIPLE CATEGORIES
								$a=0; $output = "";
								foreach($terms as $category){	
								 	  
									$output .= '<li><a href="'.get_home_url().'/article-category/'.$category->slug.'/">'.$category->name.'</a></li>';
								}
							
							} 
															
                                if ( has_post_thumbnail() ) { $hasImg = true; ?>
                                
                                <a  href="<?php the_permalink(); ?>"> <?php the_post_thumbnail(array(150,150)); ?> </a>
                                    
                                <?php }
								
								if(!isset($hasImg)){ 
								
									$img  = get_post_meta($post->ID, 'image', true);
									
									$img = $PPT->ImageCheck(str_replace(",","",$img));
								
									if(strlen($img) > 1){ 
									echo '<img src="'.$img.'" class="wp-post-image" style="max-width:150px; max-height:150px;" 
									alt="'.$post->post_title.'">';  
									} 
                                } ?> 
                                
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                                     
                                <div class="excerpt-content">
                                                                
                                <?php 
								
								if(strlen($post->post_excerpt) < 1){
								
								echo substr(strip_tags($post->post_content),0,250)."..";
								
								}else{
								
								the_excerpt();
								
								}
								
								?>
                                
                                 <div class="date">
                                    <ul>
                                    <li class="datepad"><?php echo get_the_author_meta( 'display_name', $post->post_author);?></li>
                                    <li class="datepad"><?php echo $date; ?></li>
                                     <?php  echo $output; ?>    
                                    <?php if(get_option('comments_notify') && get_option("display_search_comments") =="yes"){ echo "<li>"; comments_popup_link($PPT->_e(array('comment','9')), $PPT->_e(array('comment','10')), '% '.$PPT->_e(array('comment','11'))); echo "</li>"; } ?>
                                    </ul>
                                </div>
                                
                                 </div>
                                
                                <?php
                             
                            }
                                    
                        }
            }
            }
            echo '</div> <!-- end content --><div class="clearfix"></div>';
			if($canContinue){ 
            echo '<ul class="pagination paginationD paginationD10 marginTop left"> ';
            echo $PPTDesign->PageNavigation();             			 
            echo '</ul><div class="clearfix"></div>';
			}
            
            wp_reset_postdata();
            $wp_query = null; //Reset the normal query
            $wp_query = $temp;//Restore the query ?>
            
            
        
        </div><!-- end article page -->

	</div><!-- end itemboxinner -->
 
</div> <!-- end itembox -->

<?php 
get_footer(); 
	
}
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>