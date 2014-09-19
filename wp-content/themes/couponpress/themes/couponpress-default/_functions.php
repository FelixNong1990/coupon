<?php

// ADMIN OPTIONS FOR SOCIAL ICONS
function ppt_add_watermark_adminpanel(){

global $wpdb;

$icons = get_option('ppt_custom_theme');

echo '<fieldset>
<div class="titleh"><h3>Header Text</h3></div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Custom Text</span>	 
 <input type="text" name="adminArray[ppt_custom_theme][text]" class="ppt-forminput" value="'.$icons['text'].'">
 <p>%a = count // example: %a coupons and counting!</p>
<div class="clearfix"></div>
</div>

 

<div class="savebarb clear"> 
<input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;">
</div>
</fieldset>';
 
 
} 
add_action('premiumpress_admin_setup_left_column','ppt_add_watermark_adminpanel');



function new_header_content(){

 global $wpdb,$PPT;  
           
           echo '<div class="w_960" style="margin: 0 auto;">
        
            <div class="f_half left" id="logo"> 
            
             <a href="'.$GLOBALS['bloginfo_url'].'/" title="'.get_bloginfo('name').'">
             
			 	<img src="'.$PPT->Logo(true).'" alt="'.get_bloginfo('name').'" />
                
			 </a>
            
            </div>        
        
            <div class="left padding5" id="banner"> 
            
           	 '.premiumpress_banner("top",true).'
             
            </div>
           
        </div> <!-- end header w_960 -->
		
		<div class="clearfix"></div>'; 

}
add_action('premiumpress_top','new_header_content');


function blank_content(){


}
add_action('premiumpress_header_inside','blank_content');
add_action('premiumpress_submenu_inside','blank_content');


 	
function custommenu($menu){

global $wpdb, $userdata, $PPT; $pc = wp_count_posts(); 

$icons = get_option('ppt_custom_theme');


$string = "";
// CHECK IF WE ARE HIDING THE LOGIN/LOGOUT BUTTONS
			if(isset($GLOBALS['ppt_layout_styles']['submenubar']) && isset($GLOBALS['ppt_layout_styles']['submenubar']['loginlogout']) && $GLOBALS['ppt_layout_styles']['submenubar']['loginlogout'] == 1){ }else{
			
			$string .= '<ul class="accountbar">';
			
				if ( $userdata->ID ){ 
				
					$string .= '<li id="submenu_li_logout"><a href="'.wp_logout_url().'">'.$PPT->_e(array('head','4')).'</a></li>
					<li id="submenu_li_account"><a href="'.$GLOBALS['premiumpress']['dashboard_url'].'">'.$PPT->_e(array('head','5')).'</a></li>
					<li id="submenu_li_username"><b>'.$userdata->display_name.'</b></li>';
				
				}else{
				
					$string .= '<li><a href="'.$GLOBALS['bloginfo_url'].'/wp-login.php" rel="nofollow" id="submenu_li_login">'. $PPT->_e(array('head','6')).'</a> 
					<a href="'.$GLOBALS['bloginfo_url'].'/wp-login.php?action=register" rel="nofollow" id="submenu_li_register">'.$PPT->_e(array('head','7')).'</a></li>';
				
				}
			
			$string .= '</ul>';  
			$string .= '<p class="introtxt">'.str_replace("%a",number_format($pc->publish),$icons['text']).'</p> ';	
			
			} 
$string .= '


<form id="custom-search-form" method="get" action="'.$GLOBALS['bloginfo_url'].'/">
          <input class="nice_search" type="text" name="s" value="'.$PPT->_e(array('cp','18')).'" onfocus="this.value=\'\';">
          <input class="nice_submit" type="submit" name="submit_search" value="">
        </form>';
		
		

return str_replace("</ul></div>","</ul></div><div>".$string."</div>", str_replace('w_960"><ul>','w_960"><ul><li style="min-width:30px;"><a href="'.$GLOBALS['bloginfo_url'].'/" class="homeli">'.$PPT->_e(array('head','1')).'</a></li>',$menu ) );
}
add_action('premiumpress_menu_inside','custommenu');

function demo_home_image(){

	global $wpdb;
	if(isset($GLOBALS['flag-home']) ){
	echo "<img src='".get_template_directory_uri()."/themes/".get_option('theme')."/images/demo_home.jpg' title='couponpress' style='margin-top:10px;'><div class='clearfix'></div>";
	}
	
}
if(defined('PREMIUMPRESS_DEMO')){ 
add_action( 'premiumpress_content_before', 'demo_home_image' ); 
}

?>