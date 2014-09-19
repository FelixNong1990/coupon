<?php

global $ThemeDesign, $PPTDesign, $userdata;		

$needMargin = false;
$featured = get_post_meta($post->ID, "featured", true);
$color = get_post_meta($post->ID, "displaycolor", true); 

// COUPON EXPIRES
$d1 = get_post_meta($post->ID, "pexpires", true);
if($d1 == ""){
$d1 = get_post_meta($post->ID, "expires", true);
if(is_numeric($d1)){ // work out date 
}
}
$ExpireDate = premiumpress_time_difference($d1);
if($ExpireDate == ""){ $ExpireDate = $PPT->_e(array('cp','17')); }
 
?>
 
<li class="clearfix greybg BG<?php echo  $color; ?>" data-id="id-<?php echo $post->ID; ?>" id="post_id_<?php echo $post->ID; ?>" data-type="<?php if(strpos($ExpireDate, "strike") === false){ echo 'activecoupons'; }else{ echo 'expiredcoupons'; } ?>">
 

 
<?php if( $featured == "yes"){ $needMargin = true; ?>

<div class="sponsoredTag">&nbsp;</div>

<?php }elseif(date('Y-m-d',strtotime(date("Y-m-d", strtotime($post->post_date)) . " +2 days")) > date("Y-m-d") ){ //$needMargin=true;  <div class="newTag">&nbsp;</div> 
} ?>
 

	<div class="side1 <?php if( $needMargin ){ ?>marginTop90<?php } ?>">
    
    <?php echo premiumpress_image($post->ID,"",array('alt' => $post->post_title,  'link' => true, 'link_class' => 'frame', 'width' => '160', 'height' => '110', 'style' => 'max-width:100px' )); ?> 
     
	</div><!-- end side 1 -->

	<div class="side2 <?php if( $needMargin ){ ?>marginTop90<?php } ?>">
    	
        <div class="coupon">
		<?php
		
		// DISPLAY COUPON CODE
		echo $ThemeDesign->MakeCode($post);
        
		// DISPLAY VOTE OPTIONS
        if(get_option("couponpress_didwork") == "on"){ 
              
        $nv = get_post_meta($post->ID, 'no_votes', true);
        $yv = get_post_meta($post->ID, 'yes_votes', true);
        
        ?> 
        <div class="meter expires clearfix"><?php echo $ExpireDate; ?>&nbsp;</div>
     
        <form method="post" id="thumbsup_vote_<?php echo $post->ID; ?>" class="thumbsup thumbs_up_down1">
         
            <div id="votediv<?php echo $post->ID; ?>">
            
                <b class="result1 error " title="<?php echo $PPT->_e(array('cp','11')); ?>">+<?php echo $yv; ?></b>
                <b class="result2 error " title="<?php echo $PPT->_e(array('cp','12')); ?>">-<?php echo $nv; ?></b>    
            
                <input class="up" type="button" value="+1" title="<?php echo $PPT->_e(array('cp','11')); ?>" 
                onClick="jQuery('#thumbsup_vote_<?php echo $post->ID; ?>').addClass('user_voted disabled');PPTVote(<?php echo $post->ID; ?>,'yes','votediv<?php echo $post->ID; ?>','<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/'); return false;">
                <input class="down" type="button" value="-1" title="<?php echo $PPT->_e(array('cp','12')); ?>" 
                onClick="jQuery('#thumbsup_vote_<?php echo $post->ID; ?>').addClass('user_voted disabled');PPTVote(<?php echo $post->ID; ?>,'no','votediv<?php echo $post->ID; ?>','<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/');return false;">
            </div><!-- end vitediv -->
        
        </form>
                
        </div><!-- end coupon -->
        
        <?php }else{ echo '</div><!-- end coupon -->'; } ?>
        
        

		<?php if(!is_single()){ ?><h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo $post->post_title?></a></h3><?php } ?>
        
        <?php if(strlen($tagline) > 1){ ?><p class="tagline"><?php echo $tagline ; ?></p><?php } ?>
            
        <p class="excerpt"><?php if($post->post_excerpt == ""){ echo substr(strip_tags($post->post_content),0,150).".."; }else{ echo strip_tags($post->post_excerpt); }?></p>
        
        <div class="cats">
        
            <?php if(!isset($GLOBALS['IS_SINGLEPAGE']) && get_option("display_country") =="yes"){  
			echo get_the_term_list( $post->ID, 'location', '', ', ', ', ' ); }   ?> 
            <?php echo get_the_term_list( $post->ID, 'store', '', ', ', ', ' );   ?> <?php if(!isset($GLOBALS['IS_SINGLEPAGE'])){ echo get_the_term_list( $post->ID, 'category', '', ', ', ', ' ); } ?> <?php if(!isset($GLOBALS['IS_SINGLEPAGE']) && get_option("display_search_tags") =="yes"){ the_tags( '', ', ', ''); } ?> 
             
             
            <?php if( get_option("couponpress_search_hover") == "off" && get_option("display_myaccount_fav") != "no"){ ?> 
                 
				 <?php if(isset($_GET['pptfavs']) ){ ?>
                 
                 <a class="<?php echo $btnType ?> be6" style="margin-right:10px;" href="javascript:void(0);" onclick="jQuery('#post_id_<?php echo $post->ID; ?>').hide();
                 PPTDeleteWishlist('<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/','<?php echo $GLOBALS['backupID']; ?>','wishlist');"><?php echo $PPT->_e(array('button','3')); ?></a>
            
                 <?php }else{ ?>
            
                  <a  class="be5" href="#top" <?php if($userdata->ID){ ?>onclick="UpdateWishlist(<?php echo $post->ID; ?>,'add','AJAXRESULTS','<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/','wishlist');" 
                     <?php }else{ ?>onclick="alert('<?php echo $PPT->_e(array('ajax','1')) ?>');"<?php } ?> rel="nofollow"><?php echo $PPT->_e(array('fav','3')) ?></a>
                     
                            
                <?php } ?>            
             
            <?php } ?>
        
        </div> <!-- end cats -->
 

	</div><!-- end side 2 --> 
    
    
 <?php if(is_single() || get_option("couponpress_search_hover") != "off"){ ?>
 
	<div class="clearfix <?php if(!isset($GLOBALS['IS_SINGLEPAGE']) && get_option("couponpress_search_hover") == "on"){ echo 'couponDetails'; }else{ echo ''; } ?>"> 

	<hr class="hr4" />
    
    <div class="buttonbox">
    
       <dl class="extraops">
         
         	<?php if(get_option("display_myaccount_fav") != "no"){ ?>
            
             <dt class="be1"><a  href="#top" <?php if($userdata->ID){ ?>onclick="UpdateWishlist(<?php echo $post->ID; ?>,'add','AJAXRESULTS','<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/','wishlist');" 
             <?php }else{ ?>onclick="alert('<?php echo $PPT->_e(array('ajax','1')) ?>');"<?php } ?> rel="nofollow"><?php echo $PPT->_e(array('fav','3')) ?></a></dt>
             
             <?php } ?>
     	 
            <?php if(get_option("couponpress_printbtn") == "on"){ ?>
            <dt class="be2"><a href="<?php echo $GLOBALS['template_url']; ?>/_print.php?cid=<?php echo $post->ID; ?>" class="printform" rel="nofollow"><?php echo $PPT->_e(array('button','23')); ?></a></dt>       
      		<?php } ?>
            
            <?php if(get_option('display_social') == "yes"){ ?>
            <dt class="be3"><a class="addthis_button" href="javascript:void(0);" title="<?php the_title(); ?>" addthis:url="<?php the_permalink(); ?>"><?php echo $PPT->_e(array('button','15')); ?></a></dt>
            <?php } ?>
            
         </dl>
     
    </div>  
 <?php } ?>    
         
		          
<?php if(!isset($GLOBALS['IS_SINGLEPAGE'])){ ?></li><?php } ?>