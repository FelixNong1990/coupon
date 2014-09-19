<?php
/*
Template Name: [FAQ Page]
*/
/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
  
global  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars

$wpdb->hide_errors(); nocache_headers(); 

// ADMIN OPTION // GET CUSTOM WIDTH FOR PAGES
$GLOBALS['page_width'] 	= get_post_meta($post->ID, 'width', true);
if($GLOBALS['page_width'] =="full"){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }

/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("faq"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_tpl_faq.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_tpl_faq.php');
		
}else{
 
/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
get_header();  ?>

<div class="itembox">

<h2 class="title"><?php the_title(); ?></h2>

	<div class="itemboxinner greybg">
    
    <?php if(strlen($post->post_content) > 2){ ?><p><?php echo wpautop($post->post_content); // display the template page content regardless ?></p><?php } ?>
     
	<div class="FAQ_Content">

			<div class="item categories">
            
            <div id="catsblock">
	 
                <div class="full clearfix">
                    
                <?php
				
				//1. GET ALL FAQ AND PLACE THEM INTO CATEGORY ORDER
				$faqs_formatted = array();
				$i = 0;
				$faqs = query_posts(array( 'post_type' => 'faq_type', 'posts_per_page' => '500'));						
				if(is_array($faqs)){
					foreach($faqs as $faq){ 
						 
						$cats = array();
						$terms = get_the_terms( $faq->ID, 'faq' );
						if(is_array($terms)){ // MULTIPLE CATEGORIES
							$a=0;
							foreach($terms as $t){
							 
								$cats[$a] = $t->slug;
								$a++;
							}
						
						}else{
						$cats = array($terms['slug']);
						}
						$faqs_formatted[$i]['title'] 	= $faq->post_title;
						$faqs_formatted[$i]['content'] 	= $faq->post_content;
						$faqs_formatted[$i]['cats'] 	= $cats;
						
					$i++;	
					}
				} // end if 
			 
				
				//2. GET CATEGORIES 
	 
				$FAQSTRING ="";
				 
                    $taxonomy     = 'faq';
                    $orderby      = 'name'; 
                    $show_count   = 1;      // 1 for yes, 0 for no
                    $pad_counts   = 1;      // 1 for yes, 0 for no
                    $hierarchical = 1;      // 1 for yes, 0 for no
                    $title        = '';
                    $fcats 		  = '';
                    $i			  = 0;
                    $args = array(
                      'taxonomy'     => $taxonomy,
                      'orderby'      => $orderby,
                      'show_count'   => $show_count,
                      'pad_counts'   => $pad_counts,
                      'hierarchical' => $hierarchical,
                      'title_li'     => $title,
                      'hide_empty'	=> 0
                    );
                    
					$CatCount=0;
                    $cats  = get_categories( $args );
                    foreach($cats as $cat){					
					
						if($cat->parent == 0){ 
						
							$fcats .= $cat->cat_ID.",";					  
						
							if($i%2){ $ex ="space"; }else{ $ex =""; }
							if($i == 3){ print '<div class="clearfix"></div>'; $ex =""; $i=0;}
										
						
							print '<div class="categoryItem '.$ex.'">
										
									<a href="javascript:void(0);" onclick="jQuery(\'#catsblock\').hide();jQuery(\'#faqcat'.$cat->cat_ID.'\').show();" title="'.$cat->category_nicename.'">'.$cat->cat_name.'</a>
									<p>'.$cat->description.'</p>
								
								</div>';
							$CatCount++;
							$i++;
							
							// 3. GET ALL THE FAQS FOR THIS CATEGORY						
							$FAQSTRING .= '<div id="faqcat'.$cat->cat_ID.'" style="display:none;"><h3>'.$cat->cat_name.'</h3><hr/><div class="accordion">';
							foreach($faqs_formatted as $faqs){
								
								if(in_array($cat->category_nicename,$faqs['cats'])){
								
									// ADD FAW TO STRING
									$FAQSTRING .= '<div class="trigger"><a href="#">'.$faqs['title'].'</a></div><div class="container">'.wpautop($faqs['content']).'</div>';
								}					
							
							}
							
							$FAQSTRING .= '<div class="enditembox inner">
							<a href="javascript:void(0);" onclick="jQuery(\'#catsblock\').show();jQuery(\'#faqcat'.$cat->cat_ID.'\').hide();" class="button gray left">'.$PPT->_e(array('button','7')).'</a>
							</div>'; // <a href="" class="button gray right">adsa</a>

							
							$FAQSTRING .= '</div></div>';						
						
						}  // end if					
					
					} // end foreacg
					
                	wp_reset_query();
				
                    print '<div class="clearfix"></div></div> </div> </div>';
					
					// OUTPUT FAQS
					echo $FAQSTRING;
			      
   				?>
                
				</div><!-- end category block -->    
    
    
    			
                
         
         
        <?php if(empty($cats)){ ?>
        <br />    
        <div class="accordion">
        
        <?php
        
        // GET FAQS FOR THIS CATEGORY
		$faqs = query_posts(array( 'post_type' => 'faq_type', 'posts_per_page' => '500'));
		if(is_array($faqs) && !empty($faqs)){
        foreach($faqs as $faq){   
	 
		?>      
      
        <div class="trigger"><a href="#"><?php echo $faq->post_title; ?></a></div>
        <div class="container"><?php echo wpautop($faq->post_content); ?></div>
        <?php } }  ?>
        
        <?php echo $suba; ?>		
         
        </div><!-- end toggle -->
        
        <?php } ?>     
        
        <div class="clearfix"></div>

	</div><!-- end itemboxinner -->
 
</div> <!-- end itembox -->

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('.accordion .container').hide();
	jQuery('.accordion .trigger:first-child').addClass('active').next().show();
	
	jQuery('.accordion .trigger').click(function() {
		if(jQuery(this).next().is(':hidden')) {
			jQuery(this).parent().find(".trigger").removeClass('active').next().slideUp('fast');
			jQuery(this).toggleClass('active').next().slideDown('fast');
		}
		return false;
	}); 
	
});
</script>
<?php get_footer(); } ?>