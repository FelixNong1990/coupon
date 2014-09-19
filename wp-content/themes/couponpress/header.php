<?php

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */

global $PPT, $PPTDesign, $ThemeDesign, $pagenow, $userdata; get_currentuserinfo();
 
/* =============================================================================
   MAINTENANCE MODE // V7 // 16TH MARCH
   ========================================================================== */
 
if(get_option('maintenance_mode') == "yes" && ( !isset($_GET['redirect_to']) && $pagenow !="wp-login.php") ){ $msg = nl2br(stripslashes(get_option("maintenance_mode_message"))); if(strlen($msg)  < 1){ $msg ="Maintenance Mode On"; } die($msg);	}  

/* =============================================================================
   INITIALIZE PAGE ACTIONS AND GLOBALS // V7 // 16TH MARCH
   ========================================================================== */

premiumpress_action();

/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */
   
$hookContent = premiumpress_pagecontent("header"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();
	
}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme']."/_header.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/_header.php');

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_header.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_header.php");
		
}else{

/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--[if lte IE 8 ]><html lang="en" class="ie ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie"><![endif]-->
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title> 

<?php wp_head(); ?>
 
</head> 

<body <?php ppt_body_class(); ?>>

<?php premiumpress_top(); /* HOOK */ ?>

	<div class="wrapper <?php $PPTDesign->CSS("ppt_layout_width"); ?>">
    
    	<?php premiumpress_header_before(); /* HOOK */ ?>
	 	
           <?php function _bit_header_inside(){ /* HEADER WITH LOGO + BANNER */
		   
		    global $wpdb,$PPT;  
           
           	return '<div id="header" class="full"><div class="w_960">
        
            <div class="f_half left" id="logo"> 
            
             <a href="'.$GLOBALS['bloginfo_url'].'/" title="'.get_bloginfo('name').'">
             
			 	<img src="'.$PPT->Logo(true).'" alt="'.get_bloginfo('name').'" />
                
			 </a>
            
            </div>        
        
            <div class="left" id="banner"> 
            
           	 '.premiumpress_banner("top",true).'
             
            </div>
           
        </div> <!-- end header w_960 --> 
		       
        <div class="clearfix"></div>
        
        </div> <!-- end header -->'; 
        
         } ?>
        
        <?php echo premiumpress_header_inside(_bit_header_inside()); /* HOOK  / FILTER  */ ?>             
         
        <?php premiumpress_header_after(); /* HOOK */ ?> 
        
        <?php premiumpress_menu_before(); /* HOOK */ ?>
 
        <?php function _bit_menu_inside(){ /* MENU BAR */
				
				global $wpdb,$PPT; $string='';
            
            	$string .= '<div class="menu" id="menubar"> <div class="w_960">';
                
				if(has_nav_menu('PPT-CUSTOM-MENU-PAGES')){ $string .= wp_nav_menu( $GLOBALS['blog_custom_menu'] ); }else{ 
                
                $string .= '<ul class="nav-bar"> 
                                    
                    <li class="first"><a href="'.$GLOBALS['bloginfo_url'].'/" title="'.get_bloginfo('name').'">'.$PPT->_e(array('head','1')).'</a></li> 
                    '.premiumpress_pagelist().'                    
                    </ul>';                    
                    
                }
                 
             	$string .= '</div><!-- end  menubar w_960 --> </div><!-- end menubar -->';
				
				return $string;
				
				}				
		?>
                
         <?php echo premiumpress_menu_inside(_bit_menu_inside()); /* HOOK / FILTER */ ?> 
        
        <?php echo premiumpress_menu_after(); /* HOOK */ ?>        
           
        <?php if(isset($GLOBALS['ppt_layout_styles']['submenubar']) && isset($GLOBALS['ppt_layout_styles']['submenubar']['hide']) && $GLOBALS['ppt_layout_styles']['submenubar']['hide'] == 1){ ?>
        
        <?php }else{ ?>
        
        <?php premiumpress_submenu_before(); /* HOOK */ ?>
        
        <?php function _bit_submenu_inside(){ /*SUB MENU BAR */
			
			global $wpdb,$PPT, $userdata; get_currentuserinfo(); $string='';  
        
        	$string .= '<div id="submenubar"><div class="w_960">';
            
            if(isset($GLOBALS['ppt_layout_styles']['submenubar']) && isset($GLOBALS['ppt_layout_styles']['submenubar']['search']) && $GLOBALS['ppt_layout_styles']['submenubar']['search'] == 1){
            
            	$string .= '<div id="hpages"><ul>'.premiumpress_pagelist('submenu').'</ul></div>';
            
            }else{
            
				$string .= "<form method='get' action='".$GLOBALS['bloginfo_url']."/' name='searchBox' id='searchBox'>
				<input type='text' value='".$PPT->_e(array('head','2'))."' name='s' id='s' onfocus=\"this.value='';\"  />";
				
				if(isset($GLOBALS['ppt_layout_styles']['submenubar']) && isset($GLOBALS['ppt_layout_styles']['submenubar']['hidecat']) && $GLOBALS['ppt_layout_styles']['submenubar']['hidecat'] == 1){ }else{ 
					// BUILD CATEGORY DROP DOWN LIST
					$catdata = premiumpress_categorylist(0,'toponly');
					if(strlen($catdata) > 1){					
						$string .= '<select id="catsearch" name="cat"><option value="">&nbsp;</option>'.$catdata.'</select>';
					}
				}
				
				$string .= '<div class="searchBtn left" onclick="document.searchBox.submit();"> &nbsp;</div>';
				
				
				if(get_option("display_advanced_search") ==1){
					$string .= '<a href="javascript:jQuery(';
					$string .= "'#AdvancedSearchBox').show();";
					$string .= 'javascript:void(0);"';
					$string .="><small>".$PPT->_e(array('head','3'))."</small></a>";
				}             
				$string .= '</form>';
            
             } 
            
			// CHECK IF WE ARE HIDING THE LOGIN/LOGOUT BUTTONS
			if(isset($GLOBALS['ppt_layout_styles']['submenubar']) && isset($GLOBALS['ppt_layout_styles']['submenubar']['loginlogout']) && $GLOBALS['ppt_layout_styles']['submenubar']['loginlogout'] == 1){ }else{
			
			$string .= '<ul class="submenu_account">';
			
				if ( isset($userdata) && $userdata->ID ){ 
				
					$string .= '<li id="submenu_li_logout"><a href="'.wp_logout_url().'">'.$PPT->_e(array('head','4')).'</a></li>
					<li id="submenu_li_account"><a href="'.$GLOBALS['premiumpress']['dashboard_url'].'">'.$PPT->_e(array('head','5')).'</a></li>
					<li id="submenu_li_username"><b>'.$userdata->display_name.'</b></li>';
				
				}else{
				
					$string .= '<li><a href="'.$GLOBALS['bloginfo_url'].'/wp-login.php" rel="nofollow" id="submenu_li_login">'. $PPT->_e(array('head','6')).'</a> 
					<a href="'.$GLOBALS['bloginfo_url'].'/wp-login.php?action=register" rel="nofollow" id="submenu_li_register">'.$PPT->_e(array('head','7')).'</a></li>';
				
				}
				
			$string .= '</ul> ';  	
			
			}                
        
        	$string .= '</div> <!-- end w_960 --> </div><!-- end submenubar --> ';
			
			return $string;
            
            } ?>
            
       <?php echo premiumpress_submenu_inside(_bit_submenu_inside()); /* HOOK / FILTER */  ?>
       
       <?php premiumpress_submenu_after(); /* HOOK */ ?>
     
     	<?php } ?>
        
 
 		<?php premiumpress_page_before(); ?>
        
		<div id="page" class="clearfix full">
        
        <div class="w_960">
        
        <?php $PPTDesign->AdvancedSearchBox(); ?> 
 
		<?php if(get_option("PPT_slider") =="s1"  && is_home() && !isset($_GET['s']) && !isset($_GET['search-class']) ){ echo $PPTDesign->SLIDER(); } ?>
        
        <?php premiumpress_content_before(); ?> 
        
        <div id="content" <?php $PPTDesign->CSS("padding"); ?>>       	

			<?php
    
                if(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme']."/_sidebar1.php") &&  !isset($GLOBALS['nosidebar-left']) ){
                
                    include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme']."/_sidebar1.php");
                
                }elseif(!isset($GLOBALS['nosidebar-left']) ){ ?>                
                
                
                <div id="sidebar-left" class="<?php $PPTDesign->CSS("columns-left"); ?>"> 
                
                <?php premiumpress_sidebar_left_top(); /* HOOK */ ?> 
                
                <?php if(is_single() && !isset($GLOBALS['ARTICLEPAGE']) && isset($GLOBALS['nosidebar-right']) && get_option("display_listinginfo") =="yes"){  echo $PPTDesign->GetObject('authorinfo'); }
                
                /****************** INCLUDE WIDGET ENABLED SIDEBAR *********************/
                
				if(function_exists('dynamic_sidebar')){ 
				
					// LEFT SIDEBAR REGARDLESS
					//
					
					//}
					
					// DISPLAY IF THE RIGHT SIDEBAR IS DISABLED
					if(isset($GLOBALS['nosidebar-right'] ) ){
				
						if(is_single() && !isset($GLOBALS['ARTICLEPAGE']) ){
							if ( !is_active_sidebar('sidebar-3') ) {
							echo $PPT->SidebarText('Listing Page');
							}else{
								dynamic_sidebar('Listing Page') ;
							} 
						}elseif( isset($GLOBALS['ARTICLEPAGE']) ){
							if ( !is_active_sidebar('sidebar-5') ) {
							echo $PPT->SidebarText('Article/FAQ Page Sidebar');
							}else{
								dynamic_sidebar('Article/FAQ Page Sidebar') ;
							} 
						}elseif(is_page() && !isset($GLOBALS['IS_SINGLEPAGE']) ){
							if ( !is_active_sidebar('sidebar-4') ) {
							echo $PPT->SidebarText('Pages Sidebar');
							}else{
								dynamic_sidebar('Pages Sidebar') ;
							}
						}else{
							dynamic_sidebar('Left Sidebar (3 Column Layouts Only)'); 
						}
					
					}else{// end if
					
					dynamic_sidebar('Left Sidebar (3 Column Layouts Only)');
					
					}
					
				} // end function
 
                
                /****************** end/ INCLUDE WIDGET ENABLED SIDEBAR *********************/
                
                if(get_option('advertising_left_checkbox') =="1"){ 
                
                 echo premiumpress_banner("left");
                
                } ?>
                
                <?php premiumpress_sidebar_left_bottom(); /* HOOK */ ?> 
                
                &nbsp;&nbsp; 
                </div>
                
                <!-- end left sidebar -->                
                
           <?php } ?>
			
        <div class="<?php $PPTDesign->CSS("columns"); ?>">
        
        <?php echo $PPTDesign->GL_ALERT($GLOBALS['error_msg'],$GLOBALS['error_type']); ?>
		
        <?php premiumpress_middle_top(); /* HOOK */ ?>   
<?php 

} 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?> 