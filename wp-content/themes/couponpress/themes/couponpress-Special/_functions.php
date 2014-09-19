<?php

function BlankMe(){
return "";
}
add_action('premiumpress_header_inside',  'BlankMe' , 10);
add_action('premiumpress_header_inside',  'BlankMe' , 10);






function new_header(){

global $wpdb, $PPT; $STRING = "";
		    
$STRING = '<div id="new_header"><div class="w_960">
        
            <div class="f_half left" id="logo"> 
            
             <a href="'.$GLOBALS['bloginfo_url'].'/" title="'.get_bloginfo('name').'">
             
			 	<img src="'.$PPT->Logo(true).'" alt="'.get_bloginfo('name').'" />
                
			 </a>
            
            </div>        
        
            <div class="left" id="banner"> 
            
           	 '.premiumpress_banner("top",true).'
             
            </div>
           
        </div> <!-- end header w_960 --><div class="clearfix"></div> </div>
		
		<div class="clearfix"></div>'; 

 
echo $STRING;




}
add_action('premiumpress_top',  'new_header');



function SubMe(){

global $wpdb, $PPTDesign; $STRING = ""; $storeIcon = "";

if(get_option("PPT_slider") =="s1"  && is_home() && !isset($_GET['s']) && !isset($_GET['search-class']) ){ 

	//echo '<div id="submenubar">';	
	//echo $PPTDesign->SLIDER(); 	
	//echo '</div>';
	return;
	
}elseif(isset($GLOBALS['GALLERYPAGE'])){
 
 	 // STORE ICON 
     if(isset($GLOBALS['premiumpress']['catIcon']) && strlen($GLOBALS['premiumpress']['catIcon']) > 1 && !$GLOBALS['premiumpress']['catParent'] ){ 
      $storeIcon = "<img src='".premiumpress_image_check($GLOBALS['premiumpress']['catIcon'])."' class='frame right storeimage'>"; 
     // CAT ICON
	 }elseif(isset($GLOBALS['premiumpress']['catParent']) && $GLOBALS['premiumpress']['catParent'] && strlen($GLOBALS['premiumpress']['catIcon']) > 1){ 
		$storeIcon = "<img src='".premiumpress_image_check($GLOBALS['premiumpress']['catIcon'])."' class='frame right storeimage'>"; 
	}
 

	$STRING = '
	<div id="submenubar">
	
		<div class="left" id="b1">
		
			<div class="padding"> 
				
				<h1>'.$GLOBALS['premiumpress']['catName'].'</h1>
				<p>'.$GLOBALS['catText'].'</p>
			 
			</div>
		
		</div>
	
		<div class="left" id="b2"> 
		
			<div class="padding"> 
			
			'.$storeIcon.'
			
			</div>
		
		</div>
		
	</div>';
	
	return $STRING;

}

}
add_action('premiumpress_submenu_inside',  'SubMe' , 10);


/* =============================================================================
   Addon new search box
   ========================================================================== */
if(!function_exists('ppt_custom_searchbox')){

	function ppt_custom_searchbox($menu){
	
	global $PPT;
	
	$STRING = '<form id="custom-search-form" method="get" action="'.$GLOBALS['bloginfo_url'].'/">
			  <input class="nice_search" type="text" name="s" value="'.$PPT->_e(array('head','2')).'" onfocus="this.value=\'\';" />
			  <input class="nice_submit" type="submit" name="submit_search" value="" />
			</form>';
	
	return str_replace("</ul></div>","</ul>".$STRING."</div>",$menu);
	}
	add_action('premiumpress_menu_inside','ppt_custom_searchbox');
	
}

?>