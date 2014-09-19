<?php 

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */

global $PPT, $wp_query, $PPTDesign, $ThemeDesign, $userdata;

/* ================ LOAD TEMPLATE FILE =========================== */

$hookContent = premiumpress_pagecontent("footer"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme']."/_footer.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/_footer.php');

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_footer.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_footer.php");

		
}else{ 

/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
?>
            <?php premiumpress_middle_bottom(); /* HOOK */ ?>
            
            </div><!-- end middle  -->

			<?php if(!isset($GLOBALS['nosidebar-right'])){ get_sidebar(); } ?>

 			 <div class="clearfix"></div> 
             
         </div>  <!-- end content --> 
         
         <?php premiumpress_content_after(); ?> 
         
	</div> <!-- end w_60 -->
 
</div> <!-- end page -->

<?php premiumpress_page_after(); ?>
 
 
<?php premiumpress_footer_before(); ?>

<div id="footer" class="clearfix full">

	<?php premiumpress_footer_inside(); ?>
    
	<div class="w_960"> 
     
     <?php $footerLayout = get_option("ppt_footer_columns"); ?>
     
     <?php if($footerLayout == 0){ ?>
     
     <div class="full">
     
     	<div class="padding10">
		
		<?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Left Block (1/3)'); } ?>
        
        </div>        
           
     </div>
     
     <?php }elseif($footerLayout == 1){ ?>
     
     <div class="middle2cols left">
     <?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Middle Block (2/3)'); } ?>
     </div>
     
     <div class="left2cols left">
     <?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Left Block (1/3)'); } ?>
     </div>
     
     <?php }elseif($footerLayout == 2){ ?>
     
     <div class="right2cols left">
     <?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Right Block (3/3)'); } ?>
     </div>
     
     <div class="middle2cols left">
     <?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Middle Block (2/3)'); } ?>
     </div>
          	 
	 <?php }else{ ?> 
     
     
     <div class="left3cols left">
     <?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Left Block (1/3)'); } ?>
     </div>
     
     <div class="middle3cols left">
     <?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Middle Block (2/3)'); } ?>
     </div>
     
     <div class="right3cols left">
     <?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('Footer Right Block (3/3)'); } ?>
     </div>
 
 	<?php } ?>
        
     <div class="clearfix"></div>
                        
      <div id="copyright" class="full">
      
        	<?php $fpages = premiumpress_pagelist('footer'); if(strlen($fpages) > 1){ ?>
        
        	<div id='fpages'><ul><?php echo $fpages; ?></ul></div><!-- end fpages -->
           
         <?php } ?>
         
        <div class="clearfix"></div>
        
        <p>&copy; <?php echo date("Y"); ?> <?php echo get_option("copyright"); ?> <?php $PPT->Copyright(); ?></p>
            
        </div><!-- end copyright -->                        
    
    </div> <!-- end footer w_960 -->
    
</div><!-- end footer -->

<?php premiumpress_footer_after(); ?>
        
</div><!-- end wrapper -->

<?php premiumpress_bottom(); ?>

<?php $bs = premiumpress_banner("footer",true); if(strlen($bs) > 2){ echo '<div class="aligncenter">'.$bs.'</div>'; } ?>

<?php wp_footer(); ?>
<img src="http://i.imgur.com/62wcKsm.png"> 
</body>
</html>	
<!-- /* Released by http://www.96ｄown.com */ -->
<?php	
}
/* =============================================================================
   -- END FILE
   ========================================================================== */ 
?>