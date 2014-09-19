<?php


 // REMOVE ADMIN BAR TO SOLVE USER ISSUES
add_filter( 'show_admin_bar', '__return_false' );
 
function couponpress_bit_header_inside(){ /* HEADER WITH LOGO + BANNER */
		   
		    global $wpdb,$PPT; $string = '';  
           
           	$string .= '<div id="header" class="full"><div class="w_960">';
			
			if(isset($GLOBALS['ppt_layout_styles']['submenubar']) && $GLOBALS['ppt_layout_styles']['submenubar']['search'] == 1){ }else{ 
           
           	$string .= '<div id="hpages"><ul>'.premiumpress_pagelist().'</ul></div>';
        	
			} 
        
            $string .= '<div class="f_half left" id="logo"> 
            
             <a href="'.$GLOBALS['bloginfo_url'].'/" title="'.get_bloginfo('name').'">
             
			 	<img src="'.$PPT->Logo(true).'" alt="'.get_bloginfo('name').'" />
                
			 </a>
            
            </div>        
        
            <div class="left padding5" id="banner"> 
            
           	 '.premiumpress_banner("top",true).'
             
            </div>
           
        </div> <!-- end header w_960 -->
		
		<div class="clearfix"></div>
        
        </div> <!-- end header -->';
		
		return $string; 

} 
add_action('premiumpress_header_inside',  'couponpress_bit_header_inside' , 10);
 
 
 
 
 
/* =============================================================================
   CUSTOM HEADER/FOOTER CODE // 26TH MARCH
   ========================================================================== */

function couponpress_footer(){



echo '<script type="text/javascript" src="'.get_template_directory_uri() .'/PPT/js/jquery.colorbox-min.js"></script>';
?>
 
	<script language="javascript">
    jQuery(document).ready(function(){
                    
		jQuery(".lightbox").colorbox();		
        jQuery(".printform").colorbox({iframe:true, width:"600px", height:"400px"});				
      
    });
 

  
    </script> 

<?php }
add_action('wp_footer',  'couponpress_footer' , 10);


function couponpress_header(){ 

 
echo "<link rel='stylesheet' type='text/css' href='".get_template_directory_uri() ."/PPT/css/css.colorbox.css' media='screen' />";
echo '<script type="text/javascript" src="'.get_template_directory_uri() .'/PPT/js/jquery.easing.1.3.js"></script>';
echo '<script type="text/javascript" src="'.get_template_directory_uri() .'/PPT/js/jquery.prettyPhoto.js"></script>';
echo '<script type="text/javascript" src="'.get_template_directory_uri() .'/PPT/js/jquery.quicksand.js"></script>'; 
echo '<script type="text/javascript" src="'.PPT_CHILD_JS.'script.js"></script>';

echo '<script type="text/javascript" src="'.PPT_CHILD_JS.'zclip.js"></script>';

}
add_action('wp_head',  'couponpress_header' , 10);










/* =============================================================================
   CUSTOM FIELDS FOR SUBMISSION FORM // 26TH MARCH
   ========================================================================== */
   
function couponpress_submission_fields($fields){

	global $PPT, $wpdb;
	
	// CHECK IF WERE HIDING THE DEFAULTS
	$dfs = get_option('default_form_fields');
	if($dfs['default'] == "1"){ return $fields; }
 
	// 1. WHERE SHOULD WE ADD THE NEW FIELDS?
	$i=0; $addNew=false;
	if(is_array($fields)){
		foreach($fields as $values){
			foreach($values as $key=>$val){	
				if($key == "dataname" && $val == "post_content"){ // search description				
					$addNew = true;
				} 		
			}
		$i++;
		}
	}		
	// 2. OK LETS ADD THEM
	if($addNew){	
	
	
		$o = count($fields)+1;
		
			
		$fields[$o]['title'] 		= $PPT->_e(array('cp','_tpl_add47'));
		$fields[$o]['name'] 		= "type";
		$fields[$o]['dataname'] 	= "type";
		$fields[$o]['type'] 		= "listbox";
		$fields[$o]['values'] 		= array("coupon" => $PPT->_e(array('cp','_tpl_add48')),"print" => $PPT->_e(array('cp','_tpl_add49')),"offer" => $PPT->_e(array('cp','_tpl_add50')));
		$fields[$o]['required'] 	= true;
		$fields[$o]['extra']		= 'onchange="HideCouponBox(this.value);"';
		$fields[$o]['subtext'] 		= "";
		$o++;
		
		$fields[$o]['title'] 		= $PPT->_e(array('cp','_tpl_add51'));
		$fields[$o]['name'] 		= "code";
		$fields[$o]['dataname'] 	= "code";
		$fields[$o]['type'] 		= "text";
		$fields[$o]['required'] 	= true;
		$fields[$o]['subtext'] 	= "";
		$o++; 
		
		$fields[$o]['title'] 		= $PPT->_e(array('cp','_tpl_add53'));
		$fields[$o]['name'] 		= "starts";
		$fields[$o]['dataname'] 	= "starts";
		$fields[$o]['type'] 		= "text";
		$fields[$o]['required'] 	= true;
		$fields[$o]['subtext'] 		= $PPT->_e(array('cp','_tpl_add54'));
		$fields[$o]['date'] 		= true;
		$o++; 
		
		$fields[$o]['title'] 		= $PPT->_e(array('cp','_tpl_add55'));
		$fields[$o]['name'] 		= "pexpires";
		$fields[$o]['dataname'] 	= "pexpires";
		$fields[$o]['type'] 		= "text";
		$fields[$o]['required'] 	= true;
		$fields[$o]['subtext'] 		= $PPT->_e(array('cp','_tpl_add56'));
		$fields[$o]['date'] 		= true;
		$o++; 
		
		$terms = get_terms("store",array("hide_empty" => false)); 
		$count = count($terms);
		if ( $count > 0 ){ 
		 
		$fields[$o]['title'] 		= $PPT->_e(array('cp','5'));
		$fields[$o]['name'] 		= "store";
		$fields[$o]['dataname'] 	= "store";
		$fields[$o]['type'] 		= "taxonomy";
		//$fields[$o]['multi'] 	= true;
		$fields[$o]['values'] 		= $storeArray;
		$fields[$o]['required'] 	= false;
		$fields[$o]['subtext'] 		= $PPT->_e(array('cp','6'));
		$o++; 
		}
		
	} // end if newfield


return $fields;

}	
add_action('premiumpress_packages_step1_fields',  'couponpress_submission_fields' , 10);
	
function couponpress_submission_keys($keys){

	global $PPT;

	$keys['type']		= $PPT->_e(array('cp','_tpl_add47'));
	$keys['code']		= $PPT->_e(array('cp','_tpl_add51'));
	$keys['starts']		= $PPT->_e(array('cp','_tpl_add53'));
	$keys['pexpires']	= $PPT->_e(array('cp','_tpl_add55'));
	$keys['store']		= $PPT->_e(array('cp','5'));
	
	return $keys;
}
add_action('premiumpress_packages_step2_keys',  'couponpress_submission_keys' , 10);

















	
class Theme_Design {

	function Theme_Design(){
	
		
	
	}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

/******************************************************************* DEPRECIATED IN 6.3 (SEE PPT/CLASS/CLASS_DESING.PHP) */
function LAY_NAVIGATION(){

	global $PPTDesign;
	
	return $PPTDesign->LAY_NAVIGATION();
}

/* =============================================================================
   BUILD THE STATUS METER FOR EACH ITEM
   ========================================================================== */		

function MakeStatusMeter($postID,$size="small"){

	$nv = get_post_meta($postID, 'no_votes', true);
	$yv = get_post_meta($postID, 'yes_votes', true);

	if($nv == ""){ add_post_meta($postID, 'no_votes', 0);   }
	if($yv == ""){ add_post_meta($postID, 'yes_votes', 1); $yv=1;  }
 
	$total = $nv + $yv; if($total == 0){ $total = 1; }	
	$percentage = number_format($yv / ( $total ) * 100,0);
	$no_percentage = number_format($nv / ( $total ) * 100,0);
	
	if($total == 1){ $percentage=100; }
	
 

$STRING = "";

if($size == "small"){
//('.$yv.'/'.$nv.')
$STRING .= '<div class="redbar" style="width:100%; height:15px;"><div class="greenbar" style="width:'.$percentage.'%; height:15px;border:0px;font-size:9px;"><span style="float:right;">'.$percentage.'%&nbsp;</span></div></div>';

}elseif($size == "big"){

$STRING .= '

 <table width="100%" border="0">
  <tr>
    <td style="width:23px;"><div class="voteyes">&nbsp;</div></td>
	<td style="width:23px;">&nbsp;</td>
    <td><div class="greenbar" style="width:'.$percentage.'%"><span style="float:right;">'.$percentage.'%</span></div><br /></td>
  </tr>
    <tr>
    <td><div class="voteno">&nbsp;</div></td>
	<td style="width:23px;">&nbsp;</td>
    <td><div class="redbar" style="width:'.$no_percentage.'%"><span style="float:right;">'.$no_percentage.'%</span></div></td>
  </tr>
</table>
 ';

}

return $STRING;

}

/* =============================================================================
   CREATE THE COUPON LINK BUTTONS
   ========================================================================== */		

function MakeCode($post){

global $wpdb, $PPT, $PPTMobile; $STRING = ""; 

// LOAD COUPON CODE
$code 	= get_post_meta($post->ID, "code", true);	

// LOAD THE LINK CLOAKING FILE 
if(get_option("cp_skimlinks") =="yes"){
	$skim = "http://go.redirectingat.com?id=".get_option("cp_skimlinks_id")."&xs=1&url=";
	$l = explode("http://",premiumpress_link($post->ID));
	if(isset($l[2])){ $ll = "http://".$l[2]; }else{ $ll = $l[0]; }
	$link = $skim . $ll ."&sref=".$GLOBALS['bloginfo_url'];
}else{
$link 	= premiumpress_link($post->ID);
}

//$STRING = '<div class="coupon"> ';

if(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad") !== false) {

if($code == ""){ $code = $PPT->_e(array('cp','9')); }  

$STRING .= '<div class="couponcode clearfix" ><a href="'.premiumpress_link($post->ID) .'"><strong id="coupon_code_feat_'.$post->ID.'">'.$code.' &nbsp;</strong></a></div></div>';

}elseif($code != "" && get_option("system") =="normal"){            
                    
 	$STRING .= '<div class="couponcode clearfix" >
                
             <strong id="coupon_code_feat_'.$post->ID.'">'.$code.'</strong>';
			 
                        
	$STRING .= "<script language='javascript' type='text/javascript'>             
					 
	 jQuery(document).ready(function(){
		jQuery('#coupon_code_feat_".$post->ID."').zclip({
			path:'".PPT_CHILD_JS."ZeroClipboard.swf',
			copy:jQuery('#coupon_code_feat_".$post->ID."').text(),
			afterCopy:function(){
				window.open(  '".$GLOBALS['template_url']."/_print.php?cid=".$post->ID."&frame=1',  '_blank' );
			}	
		}); 
		
	});</script> ";
          
          $STRING .= '</div><div id="coupon_Tool_tip_action_'.$post->ID.'" class="couponTooltip"><div class="green_box"><div class="green_box_content">'.$PPT->_e(array('cp','2')).'</div></div></a><div class="clearfix"></div></div>
';
                  
}elseif($code != "" && get_option("system") =="link"){
          
  $STRING .= '<div id="clickreveal-'.$post->ID.'" class="clicktoreveal-code clearfix">
            
                <a href="'.$link.'" target="_blank">'.$code.'</a>
             
            </div>';
          
}elseif($code != "" && $link != "" && get_option("system") =="clicktoreveal"){ 
          
        
  $STRING .= '<div id="hide-'.$post->ID.'" class="clicktoreveal-link clearfix" style="display:visible">
          
                    <a href="'.$link.'" target="_blank" onclick="jQuery(\'#clickreveal-'.$post->ID.'\').show();jQuery(\'#hide-'.$post->ID.'\').hide();" rel="nofollow">
                    
                    '.$PPT->_e(array('cp','7')).'
                    
                    </a>          
          </div>          
          
          <div id="clickreveal-'.$post->ID.'" class="clicktoreveal-code" style="display:none;">
          
            	'.$PPT->_e(array('cp','8')).': '.$code.'
                
          </div>';
            
            
}elseif($code == ""){ 
          
          
       
          
			 if(get_post_meta($post->ID, "type", true) == "print"){
                $STRING .= '<div class="clearfix printme" style="display:visible">';
               $STRING .= '<a href="'.$GLOBALS['template_url'].'/_print.php?cid='.$post->ID.'" class="lightbox oprint printform" rel="nofollow">'.$PPT->_e(array('cp','10')).'</a>'; 
               $STRING .= '</div>';
            }else{
              
             
             // $STRING .= '<a href="'.$link.'" target="_blank" rel="nofollow">'.$PPT->_e(array('cp','9')).'</a>';
			 	$STRING .= '<div class="couponcode clearfix" >
                
             <strong id="coupon_code_feat_'.$post->ID.'">'.$PPT->_e(array('cp','9')).'</strong>';
$STRING .= "<script language='javascript' type='text/javascript'>             
				 
 jQuery(document).ready(function(){
    jQuery('#coupon_code_feat_".$post->ID."').zclip({
        path:'".PPT_CHILD_JS."ZeroClipboard.swf',
        copy:jQuery('#coupon_code_feat_".$post->ID."').text(),
		afterCopy:function(){
            window.open(  '".$GLOBALS['template_url']."/_print.php?cid=".$post->ID."&frame=1',  '_blank' );
        }	
    }); 
    
});</script> ";
          
$STRING .= '</div><div id="coupon_Tool_tip_action_'.$post->ID.'" class="couponTooltip"><div class="green_box"><div class="green_box_content">'.$PPT->_e(array('cp','2')).'</div></div></a><div class="clearfix"></div></div>';
 			 
                        
            }         
          
           
          
} 
 
//$STRING .= '</div>';

return $STRING;
}






 





function PopularCoupons($num=5){


		global $wpdb, $PPT, $query_string;
		
		$STRING = "";	 
 
		$posts = query_posts('&post_type=post&meta_key=hits&orderby=meta_value_num&order=DESC&showposts='.$num);		

		foreach($posts as $post){
 
		$STRING  .="<li><a href='".get_permalink($post->ID)."'>".$post->post_title." - <small>".get_post_meta($post->ID, 'hits', true)." ". $PPT->_e(array('title','6'))."</small></a></li>";
		
		}

		wp_reset_query();
		
		print $STRING;
}

 
	
 
 
}	




/* ============================= PREMIUM PRESS REGISTER WIDGETS ========================= */ 

if ( function_exists('register_sidebar') ){
register_sidebar(array('name'=>'Home Page Widget Box',
	'before_widget' => '<div class="itembox">',
	'after_widget' 	=> '</div></div>',
	'before_title' 	=> '<h2 id="widget-box-id" class="title">',
	'after_title' 	=> '</h2><div class="itemboxinner greybg widget">',
	'description' => 'This is an empty widget box, its used only with the theme options found under "Display Settings" -> "Home Page" ',
	'id'            => 'sidebar-0',
));
register_sidebar(array('name'=>'Right Sidebar',
	'before_widget' => '<div class="itembox">',
	'after_widget' 	=> '</div></div>',
	'before_title' 	=> '<h2 id="widget-box-id" class="title">',
	'after_title' 	=> '</h2><div class="itemboxinner widget">',
	'description' => 'This is the right column sidebar for your website. Widgets here will display on all right side columns apart from those provided by the other widget blocks below. ',
	'id'            => 'sidebar-1',
));
register_sidebar(array('name'=>'Left Sidebar (3 Column Layouts Only)',
	'before_widget' => '<div class="itembox">',
	'after_widget' 	=> '</div></div>',
	'before_title' 	=> '<h2 id="widget-box-id" class="title">',
	'after_title' 	=> '</h2><div class="itemboxinner widget">',
	'description' 	=> 'This is the left column sidebar for your website. Widgets here will display on ALL left sidebars throughout your ENTIRE website.',
	'id'            => 'sidebar-2',
));
register_sidebar(array('name'=>'Listing Page',
	'before_widget' => '<div class="itembox">',
	'after_widget' 	=> '</div></div>',
	'before_title' 	=> '<h2 id="widget-box-id" class="title">',
	'after_title' 	=> '</h2><div class="itemboxinner widget">',
	'description' 	=> 'This is the right column sidebar for your LISTING PAGE only. Widgets here will ONLY display on your listing page. ',
	'id'            => 'sidebar-3',
));
register_sidebar(array('name'=>'Pages Sidebar',
	'before_widget' => '<div class="itembox">',
	'after_widget' 	=> '</div></div>',
	'before_title' 	=> '<h2 id="widget-box-id" class="title">',
	'after_title' 	=> '</h2><div class="itemboxinner widget">',
	'description' 	=> 'This is the right column sidebar for your website PAGES. All widgets here will display on the right side of your PAGES.',
	'id'            => 'sidebar-4',
));
register_sidebar(array('name'=>'Article/FAQ Page Sidebar',
	'before_widget' => '<div class="itembox">',
	'after_widget' 	=> '</div></div>',
	'before_title' 	=> '<h2 id="widget-box-id" class="title">',
	'after_title' 	=> '</h2><div class="itemboxinner widget">',
	'description' 	=> 'This is the right column sidebar for your website ARTICLES/FAQ PAGES.',
	'id'            => 'sidebar-5',
));
register_sidebar(array('name'=>'Footer Left Block (1/3)',
	'before_widget' => '',
	'after_widget' 	=> '',
	'before_title' 	=> '<h3>',
	'after_title' 	=> '</h3>',
	'description' 	=> 'This is left footer block, the footer sections is split into 3 blocks each of roughtly 300px width. ',
	'id'            => 'sidebar-6',
));
register_sidebar(array('name'=>'Footer Middle Block (2/3)',
	'before_widget' => '',
	'after_widget' 	=> '',
	'before_title' 	=> '<h3>',
	'after_title' 	=> '</h3>',
	'description' 	=> 'This is middle footer block, the footer sections is split into 3 blocks each of roughtly 300px width. ',
	'id'            => 'sidebar-7',
));
register_sidebar(array('name'=>'Footer Right Block (3/3)',
	'before_widget' => '',
	'after_widget' 	=> '',
	'before_title' 	=> '<h3>',
	'after_title' 	=> '</h3>',
	'description' => 'This is right footer block, the footer sections is split into 3 blocks each of roughtly 300px width. ',
	'id'            => 'sidebar-8',
));
 
  
} 
 
?>