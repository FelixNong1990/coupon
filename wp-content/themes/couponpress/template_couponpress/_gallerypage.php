<?php get_header();  ?> 

<div id="AJAXRESULTS"></div><!-- AJAX RESULTS -do not delete- -->
 
<?php /*------------------------- DISPLAY GALLERY BLOCK ----------------------------*/ ?>
  
<div class="itembox">
 
    <h2  id="icon-home-cats" class="title"><?php echo $GLOBALS['premiumpress']['catName']; ?>  &raquo; <?php echo str_replace("%a",$GLOBALS['query_total_num'],$PPT->_e(array('gallerypage','1'))); ?> </h2> 
    
    <div class="itemboxinner nopadding">
    
    <div class="padbox">
    
  		<?php if($GLOBALS['query_total_num'] > 0 && !isset($GLOBALS['setflag_article']) && !isset($GLOBALS['tag_search']) && !isset($GLOBALS['setflag_faq']) ){  echo $PPTDesign->GL_ORDERBY(); } ?>	        
  
       <?php
        // STORE ICON 
        if(isset($GLOBALS['premiumpress']['catIcon']) && strlen($GLOBALS['premiumpress']['catIcon']) > 1 && !$GLOBALS['premiumpress']['catParent'] ){ 
        echo "<img src='".premiumpress_image_check($GLOBALS['premiumpress']['catIcon'])."' class='frame right storeimage'>"; 
        }
        // -- end category icon
        ?> 
  
        <div class="left">        
  
        <div class="lefttxt">
        
        <?php
		// CATEGORY ICON 
		if(isset($GLOBALS['premiumpress']['catParent']) && $GLOBALS['premiumpress']['catParent'] && strlen($GLOBALS['premiumpress']['catIcon']) > 1){ 
		echo "<img src='".premiumpress_image_check($GLOBALS['premiumpress']['catIcon'])."' class='galcaticon'>"; 
		}
		// -- end category icon
		?>
        
        <?php if(isset($_GET['s'])){ echo $PPT->_e(array('button','11')).": ".strip_tags($_GET['s']); }
            elseif( isset($_GET['search-class'])) {  echo $PPT->_e(array('button','11')).": ".strip_tags($_GET['cs-all-0']); }else{ echo $GLOBALS['premiumpress']['catName']; } ?></div>
        
        </div>
	
        
        <?php /*------------------------- CUSTOM CATEGORY TEXT AND IMAGE ----------------------------*/ ?>   
            
        <?php if(isset($GLOBALS['catText']) && strlen($GLOBALS['catText']) > 1){ ?>
            
        <div class="customCatText clearfix"><?php echo $GLOBALS['catText']; ?></div>
                
        <?php } ?>        
            
         <div class="clearfix"></div>
         
        <?php /*------------------------- sub CATEGORIES BLOCK ----------------------------*/ ?>   
        
        <?php if($GLOBALS['query_total_num'] != 0 && isset($GLOBALS['premiumpress']['catID']) && is_numeric($GLOBALS['premiumpress']['catID']) && get_option("display_sub_categories") =="yes" ){ 
        $STRING = $PPTDesign->HomeCategories();
        if(strlen($STRING) > 5){
        ?>
        
        <div class="green_box">
            <div class="green_box_content nopadding" id="subcategories">        
                <?php echo $STRING; ?>        
            <div class="clearfix"></div>
            </div>    
        </div>
            
        <?php } } ?>
    
 	</div><!-- END PADBOX -->
    
     
    <?php 
	
	// DISPLAY FAV/SEARCH OPTIONS
	if(get_option("display_gallery_saveoptions") != "no"){ ?>
    
    	<?php if(isset($term->taxonomy) && $term->taxonomy == "store"){ }else{ ?>
    
        <a class="floatr iconvss" href="javascript:PPTGetSaveSearch('<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/','AJAXRESULTS');" rel="nofollow">
          <?php echo $PPT->_e(array('gallerypage','3')); ?></a> 

      
      <?php } ?>
  
    <?php } ?>
    
    <?php if(get_option("display_myaccount_fav") != "no"){ ?>
    
    <a href="<?php echo $GLOBALS['bloginfo_url']; ?>/?s=&pptfavs=yes" class="floatr iconfavs"><?php echo $PPT->_e(array('myaccount','35')); ?></a>
      
    <?php } ?>

    
    <?php /*------------------------- PAGE NAVIGATION BLOCK ----------------------------*/ ?>   
 
    <ol class="tabs filter">
    <li class="current all" style="margin-left:5px;"><a href="#all" class="active"><?php echo $PPT->_e(array('cp','16')); ?></a></li>       
    <?php if($GLOBALS['query_total_num'] > 0){ ?>
    <li class="activecoupons"><a href="#activecoupons"><?php echo $PPT->_e(array('cp','14')); ?></a></li>         
    <li class="expiredcoupons"><a href="#expiredcoupons"><?php echo $PPT->_e(array('cp','15')); ?></a></li>  
    <?php } ?>
    </ol> 
    
    <div class="clearfix"></div>    
    
	<?php if($GLOBALS['query_total_num'] > 0){ ?>
    
    <div id="SearchContent">
    
    	<div id="VoteResult"></div> 
                        
    	<ul class="couponlist portfolio"><?php $PPTDesign->GALLERYBLOCK(); ?></ul><br />
        
            <?php 
	
	// DISPLAY FAV/SEARCH OPTIONS
	if(get_option("display_gallery_saveoptions") != "no"){ ?>
    
    		<a href="#top" onClick="javascript:PPTSaveSearch('<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/','<?php echo htmlentities(str_replace("http://","",str_replace("&","---",curPageURL()))); ?>','AJAXRESULTS');" 
            class="iconss right" rel="nofollow"><?php echo $PPT->_e(array('gallerypage','2')); ?></a> 
      
      
		  <?php if(isset($GLOBALS['premiumpress']['catID']) && is_numeric($GLOBALS['premiumpress']['catID']) && $GLOBALS['premiumpress']['catParent'] ){ ?>
          <a  class="iconemail right" href="#top" onClick="javascript:PPTEmailAlter('<?php echo str_replace("http://","",PPT_THEME_URI); ?>/PPT/ajax/','<?php echo $GLOBALS['premiumpress']['catID']; ?>','AJAXRESULTS');" rel="nofollow">
          <?php echo $PPT->_e(array('gallerypage','4')); ?></a><?php } ?>  
          
          <?php } ?>
         
     </div>
      
     		<div class="clearfix"></div>
        </div>
    </div>    
 
     <ul class="pagination paginationD paginationD10"><?php echo $PPTDesign->PageNavigation(); ?></ul>
        
	<?php }else{ 
	
	// NO RESULTS FOUND	
	?>
    <div class="padding">
 	<div class="yellow_box">
    	<div class="yellow_box_content">        
        	<div align="center"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/exclamation.png" align="absmiddle" alt="nr" />  <?php echo $PPT->_e(array('gallerypage','11')); ?> </div>       
        <div class="clearfix"></div>
        </div>    
 	</div>    
    </div>
    
         		<div class="clearfix"></div>
        </div>
    </div> 
    <?php } ?>
 

<?php  get_footer(); ?>