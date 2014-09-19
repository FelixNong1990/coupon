<?php 

$GLOBALS['singleCategory'] 	= get_the_category($post->ID); 
  
get_header( ); 
 

if (have_posts()) : while (have_posts()) : the_post();

// SETUP GLOBAL VALUES FROM CUSTOM DATA
$GLOBALS['images'] 		= get_post_meta($post->ID, 'images', true);
$GLOBALS['map'] 		= get_post_meta($post->ID, "map_location", true);
$GLOBALS['hits']		= get_post_meta($post->ID, "hits", true);
// TAGLINE
$tagline = get_post_meta($post->ID, "tagline", true);

	// TOOLBOX FOR POST AUTHOR
	if($post->post_author == $userdata->ID ){ ?>
  
    <div class="green_box"><div class="green_box_content"> 
    
    <h3 class="left" style="margin:0px; padding:0px; line-height:20px; width:200px"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/toolbox.png" align="absmiddle" style="padding-right:10px;" />
	<?php echo $PPT->_e(array('title','15')); ?>
    </h3>        
    
    <div class="right">
    
    <?php $IMAGEVALUES = get_option('pptimage'); if(strlen($link) > 2 && isset($IMAGEVALUES['stw_2']) && $IMAGEVALUES['stw_2'] == 1 && ($post->post_author == $userdata->ID || is_admin())){ ?>
     <a href="<?php the_permalink(); echo '?refresh=1'; ?>" class="button green" rel="nofollow">Refresh Thumbnail</a> |       
    
    <?php } ?> 

	<a href="<?php echo get_option('submit_url'); ?>?eid=<?php echo $post->ID; ?>" class="button green" rel="nofollow"><?php echo $PPT->_e(array('button','2')); ?></a> |    
    <a href="<?php echo get_option('manage_url'); ?>?eid=<?php echo $post->ID; ?>&dd=1" onclick="return ppt_confirm('<?php echo $PPT->_e(array('validate','5')); ?>');" class="button green" rel="nofollow"><?php echo $PPT->_e(array('button','3')); ?></a>   
   
    </div>
    <div class="clearfix"></div>
           
    </div>
    </div> 
           
    <?php } ?>

<div id="AJAXRESULTS"></div><!-- AJAX RESULTS -do not delete- -->

    
<div class="itembox">
    
    <h1 id="icon-single-title"><?php the_title(); ?> <?php if(isset($GLOBALS['packageIcon']) && strlen($GLOBALS['packageIcon']) > 2){ echo "<img src='".premiumpress_image_check($GLOBALS['packageIcon'])."' class='floatr'>"; } ?></h1>
 
		<div class="greybg">   
         
			<ul class="couponlist">
            
 				<?php include("_item.php"); ?>                
                
                <div class="clearfix"></div>

				<?php if($post->post_content != $post->post_excerpt){ ?><p class="texttitle" style="margin-top:-20px"><?php echo $PPT->_e(array('add','24')); ?></p><hr class="hr4" /><div class="entry"><?php the_content(); ?></div>  <?php } ?>      
                      
                <?php $PPTDesign->CustomFields($post,get_option("customfielddata")); ?>
                
                <?php echo $PPTDesign->Attachments($post->ID); ?> 
                    
                <?php if( $GLOBALS['SINGLEMAP'] && $PPT->CanShow($post->ID, "map_location") ){ ?> <div class="clearfix"></div><div id="map_sidebar2" style="margin-top:10px;"></div><?php } ?>
            
				<?php if(get_option('comments_notify') && get_option("display_single_comments") =="yes"){ echo '<div class="clearfix"></div><hr class="hr4" />'; comments_template(); } ?>
           
     		</ul><!-- item.php li -->
     
		</div>      
    
</div>  
 
    
<?php endwhile; else :  endif; wp_reset_query();  ?>  
   
   
   
    
    
    
    
    
    

<?php if(get_option("display_related_coupons") =="yes"){ $GLOBALS['stophide'] = 1;
	
	$STORECURRENTID = $post->ID; $postslist = query_posts('numberposts=20&order=DESC&orderby=meta_value&showposts=10&&meta_key=hits&post_type=post&cat='.$GLOBALS['singleCategory'][0]->cat_ID); if(count($postslist) > 1){ ?>
    
    <div class="itembox">
    
        <h2 id="single-relatedcoupons"><?php echo $PPT->_e(array('cp','4')); ?></h2>
        
		<div class="itemboxinner nopadding">
                
        <div id="VoteResult"></div> 
                    
        <ul class="couponlist">
        
        <?php foreach ($postslist as $loopID => $post){   if($post->ID != $STORECURRENTID){   include("_item.php");  } } ?>
    
        </ul>
        
    </div>
    
 </div>
<?php } } ?>


 
 
<?php wp_reset_query();  get_footer(); ?>