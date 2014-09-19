<?php

// CORE THEME CLASS FILE // DONT EDIT THIS FILE

class PremiumPressTheme_Design {

/* =============================================================================
   CUSTOM PROFILE FIELDS // V7 // 28TH APRIL
   ========================================================================== */

function ProfileFields($current="",$access_levels=""){

global $wpdb, $userdata, $PPT; $packagedata = get_option('ppt_profilefields'); if(!isset($GLOBALS['titlec'])){ $GLOBALS['titlec'] = 1; }else{ $GLOBALS['titlec']++; }

// GET THE USER ID FOR EDITING
if(isset($_GET['page']) && $_GET['page'] == "members" && isset($_GET['edit'])){ $MYUSERID = $_GET['edit']; }else{  $MYUSERID = $userdata->ID; } $tabindex=22;

	
	//CHECK IF WE HAVE ANY
	if(is_array($packagedata) && isset($packagedata['package']) ){
	 
	 	//PUT IN CORRECT ORDER
		$neworder = multisort( $packagedata['package'] , array('order') );
	 
	 	// LOOP THOURGH
		$i=0;
		foreach($neworder as $package){	
			
			$tabindex++;
		
			// CAN WE DISPLAY THIS FIELD??
			if(isset($GLOBALS['IS_REGISTER']) && $package['display_register'] != 1){ continue; }
			
			if(isset($GLOBALS['IS_MYACCOUNT']) && $package['display_account'] != 1){ continue; }
		
			// IS THIS JUST A TITLE?
			if($package['title'] == "1"){
			
			$STRING .= '<div class="clearfix"></div><h4><span>'.$GLOBALS['titlec'].'</span>'.$package['name'].'</h4><div class="clearfix"></div>'; $GLOBALS['titlec']++;
			
			}else{
			 
			if(isset($package['required']) && $package['required'] == "yes"){ $reqa = " <span class='required'>*</span>"; }else{ $reqa = ""; }
			  
			 // START OUTPUT		
			$STRING .= '<p class="f_half left" id="field_custom_'.$i.'"><label>'.$package['name'].$reqa.'</label>';
			
			// GET DEFAULT VALUE
			if(isset($GLOBALS['IS_REGISTER'])){ 
			if(isset($_POST['custom'][$package['key']])){
			$FIELDVAL = strip_tags($_POST['custom'][$package['key']]);
			}else{
			$FIELDVAL = $package['values']; 
			}
			
			}else{ $FIELDVAL = get_user_meta($MYUSERID, $package['key'], true); }
			
				//SWITCH TYPE
				switch($package['type']){
				
				// added in 7.1.1 (1st sep)
				 case "check": {
				 
					 $ll = explode("|",$package['values']);
					 
					 foreach($ll as $val){
								
							if(strlen($val) > 1){
									$STRING .= ' '.$val.'';
							}
					}// end foreach 
				 
				 } break;
				
				case "list": {
					
						$ll = explode(",",$package['values']);
						
						$STRING .= '<select name="custom['.$package['key'].']" id="form_'.$package['key'].'" class="short" tabindex="'.$tabindex.'">';
					
						foreach($ll as $val){
						
							if(isset($FIELDVAL) && $FIELDVAL == $val){
							$STRING .= '<option value="'.$val.'" selected=selected>'.$val.'</option>';
							}else{
							$STRING .= '<option value="'.$val.'">'.$val.'</option>';
							}
						}// end foreach
						
						$STRING .= '</select>';
					
					} break;
					
					case "textarea": { 
					
						$STRING .= '<textarea class="long" rows="4" name="custom['.$package['key'].']" id="form_'.$package['key'].'" tabindex="'.$tabindex.'">'.$FIELDVAL.'</textarea>';
					 
					} break;
				
					default: { 
					
						$STRING .= '<input type="text" name="custom['.$package['key'].']" id="form_'.$package['key'].'" class="short" value="'.$FIELDVAL.'" tabindex="'.$tabindex.'">';
					
					} break;
				
				} // END SWITCH
			 
			 
			}// END IF TITLE 
		 
		$i++;
		} // END LOOP
	
	}// END IF

return $STRING;

}

/* =============================================================================
   MEMBERSHIP PACKAGES // V7 // 2ND APRIL
   ========================================================================== */

function Memberships($current="",$access_levels=""){

global $wpdb, $PPT; 

	if(isset($GLOBALS['IS_REGISTER'])){
	
	$STRING = '<div id="PACKAGEAJAX"></div><input type="hidden" name="SELECTEDPACKAGEID" id="SELECTEDPACKAGEID" value="" />';
	}else{
	
	$STRING = "<form name='upgrademembershipform' id='upgrademembershipform' action='".get_option('dashboard_url')."' method='post'>
	<input type='hidden' name='action' value='upgrademe' ><input type='hidden' name='newselpack' id='newselpack' ></form>";
	
	}
	
	$packagedata = get_option('ppt_membership');
	
	if(is_array($packagedata) && isset($packagedata['package']) ){
	 
		$neworder = multisort( $packagedata['package'] , array('order') );
	 
		$i=0;
		foreach($neworder as $package){
		
		if($current == $package['ID']){ continue; }
		
		if(is_array($access_levels) && !in_array($package['ID'],$access_levels)){ continue; }
		
		// package id
		if($package['ID'] == ""){ $pakID = $i; }else{ $pakID = $package['ID']; }
		
		// START COLOR BOX
		$STRING .= '<div class="green_box" id="pack'.$i.'"><div class="green_box_content">';
		
		if(isset($GLOBALS['IS_REGISTER'])){
		// BUTTONS
		$STRING .= "<div id='pack".$i."_on' style='display:none'><a class='button blue right' href='javascript:void(0);' onclick=\"jQuery('#pack".$i."_off').show();jQuery('#pack".$i."_on').hide();jQuery('#SELECTEDPACKAGEID').val('');\" >".$PPT->_e(array('login','20'))."</a></div>";
		$STRING .= "<div id='pack".$i."_off' style='display:visible'><a class='button green right' href='javascript:void(0);' onclick=\"jQuery('#pack".$i."_off').hide();jQuery('#pack".$i."_on').show();jQuery('#SELECTEDPACKAGEID').val('".$pakID."');\" >".$PPT->_e(array('login','19'))."</a></div>";
		
		}else{
		
		$STRING .= "<div id='pack".$i."_off' style='display:visible'><a class='button green right' href='javascript:void(0);' onclick=\"jQuery('#newselpack').val('".$pakID."');document.upgrademembershipform.submit();\" >".$PPT->_e(array('login','19'))."</a></div>";		
		}
		
		// onclick=\"SubscribeMembership('".str_replace("http://","",PPT_THEME_URI)."/PPT/ajax/','PACKAGEAJAX','".$pakID."')\"		
		
		// COLUMN WIDTHS	
		if($GLOBALS['ppt_columncount']  == 3){ $exf = "max-width:280px;"; }else{ $exf = "max-width:400px;"; }		
		
		$STRING .= "<div style='".$exf."'><h3>".$package['name']."</h3><p>".$package['desc']."</p></div>";
		
		$STRING .= "";

		
		// END COLOUR BOX
		$STRING .= '<div class="clearfix"></div></div></div>';
		
		$i++;
		}
	
	}

return $STRING;

}


/* =============================================================================
   MY ORDER HISTORY // V7 // 26TH MARCH
   ========================================================================== */

function MYORDERS($user_id){
	
	global $wpdb,$PPT, $ThemeDesign, $userdata; get_currentuserinfo(); $content=""; $dwl_content=""; $td=1; $STRING ='<input type="hidden" value="" id="moreinfodiv" name="moreinfodiv">';
	$date_format = get_option('date_format') . ' ' . get_option('time_format');
	if(!is_numeric($user_id)){ die("nice try!"); }
 

	$SQL = "SELECT * FROM ".$wpdb->prefix."orderdata WHERE cus_id='".$userdata->ID."' GROUP BY order_id ORDER BY autoid DESC";  

	$posts = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);
		
	  if ($posts && mysql_num_rows($posts) > 0) {
 
		while ($thepost = mysql_fetch_object($posts)) { if($thepost->order_total > 0){
		
		if($thepost->order_status ==0){  
		$status = $PPT->_e(array('myaccount','_paymentstatus0'));
		}elseif($thepost->order_status ==3){ 
		$status = "<b style='color:green;'>".$PPT->_e(array('myaccount','_paymentstatus1'))."</b>";
		}elseif($thepost->order_status ==5){ 
		$status = "<b style='color:green;'>".$PPT->_e(array('myaccount','_paymentstatus2'))."</b>";
		}elseif($thepost->order_status ==6){  
		$status = "<b style='color:red;'>".$PPT->_e(array('myaccount','_paymentstatus3'))."</b>";
		}elseif($thepost->order_status ==7){ 
		$status = "<b style='color:blue;'>".$PPT->_e(array('myaccount','_paymentstatus4'))."</b>";
		}elseif($thepost->order_status ==8){ 
		$status = "<b>".$PPT->_e(array('myaccount','_paymentstatus5'))."</b>";
		}  
		
		
		// START COLOR BOX
		$STRING .= '<div class="green_box" id="alter'.$thepost->order_id.'"><div class="green_box_content">';
		
		// DATE
		$date = mysql2date($date_format, $thepost->order_date." ".$thepost->order_time, false); 
	
		// ORDER ID
		$STRING .= '<div class="left"><h3>'.$thepost->order_id.'</h3>'.$status.' | '.premiumpress_price($thepost->order_total,$thepost->order_currencycode,$GLOBALS['premiumpress']['currency_position'],1).' | '.$date.'</div>';
		
 	
	
		if($thepost->order_status == 0 ){
		
		if( strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" ) { 
		
		
		if(!isset($GLOBALS['premiumpress']['checkout_url']) || $GLOBALS['premiumpress']['checkout_url'] == ""){ $GLOBALS['premiumpress']['checkout_url'] = get_option('submit_url');  }
				
			$STRING .= "<form action='".$GLOBALS['premiumpress']['checkout_url']."' method='post'>
			<input type='hidden' name='action' value='forcecheckout' />
			<input type='hidden' name='forcecheckout' value='1' />
			<input type='hidden' name='packageID' value='0' />
			<input type='hidden' name='step3' value='1' />
			<input type='hidden' name='amount' value='".$thepost->order_total."' />
			<input type='hidden' name='orderID' value='".$thepost->order_id."' />
			<input type='submit' value='".$PPT->_e(array('button','21'))."' class='button blue right' style='margin-left:10px;'></form>";
			
			}
		}	
		
		// MORE DETAILS BUTTON
		if($thepost->order_status ==5 || $thepost->order_status ==3){ 
			
			$STRING .= "<a href='#morebox".str_replace("-","",str_replace(":","",$thepost->order_id))."' class='button green right orderinfo' style='margin-left:10px;' onclick=\"document.getElementById('moreinfodiv').value='morebox".str_replace("-","",str_replace(":","",$thepost->order_id))."';\">".$PPT->_e(array('button','13'))."</a>";
		}
		
		// INVOICE BUTTON
		$STRING .= "<a href='".get_template_directory_uri()."/_invoice.php?id=".$thepost->order_id."' style='margin-left:10px;' class='button green right iframe'>".$PPT->_e(array('button','22'))."</a>";
		
		// END COLOUR BOX
		$STRING .= '<div class="clearfix"></div></div></div>'; 
		
		
		// ORDER IS APPROVED // LETS CREATE THE HIDDEN FRAME
		if($thepost->order_status ==5 || $thepost->order_status ==3 || $thepost->order_status == 0){
		
		// NEW COLOR BOX
		$STRING .= '<div class="gray_box" id="morebox'.str_replace("-","",str_replace(":","",$thepost->order_id)).'" style="display:none"><div class="gray_box_content">';
			
		$STRING .= nl2br($thepost->order_data) ;
			
				// INCLUDE DOWNLOAD FOR SP ONLY 
				if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){
					$dwl = $ThemeDesign->CheckDownloadLinks($thepost->order_id);
				}				
			 
				 // INCLUDE DOWNLOAD FOR SP ONLY 
				if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" && is_array($dwl)){
				
					$a=1;
					foreach($dwl as $download){					
						 
						$STRING .= "<div class='green_box'><div class='green_box_content'>";
						
						if(strlen($download['image']) > 2){
						
							$STRING .= " <img src='".premiumpress_image_check($download['image'],"m")."'>";
						
						}						
						
						$STRING .= "<h3>".$download['name']."</h3><p>
						
						<form action=\"".$GLOBALS['bloginfo_url']."/\" method=\"POST\" name=\"downloadform".$download['id'].str_replace("-","",$thepost->order_id)."\">".wp_nonce_field('FileDownload')."
						<input type='hidden' name='hash' value='123'>
						<input type='hidden' name='force' value='1'>
						<input type='hidden' name='fileID' value='".($download['id']*800)."'>
						 <a  href='javascript:void(0);' onclick=\"document.downloadform".$download['id'].str_replace("-","",$thepost->order_id).".submit();\" class='button green' >
						   ".$PPT->_e(array('sp','7'))."
					   </a> 			 
						</form>
						
						</p><div class='clearfix'></div>
						
						
						</div></div>";
						
						$a++;
					
				} // end loop 
				
			} // end if	
			
			// END COLOUR BOX
			$STRING .= '<div class="clearfix"></div></div></div>';	
		
		 } // END IF
		
		 
		}
		 
		$td++;
		}
	}
		
	return $STRING;

}

/* =============================================================================
   WISHLIST // COMPARE // V7 // 26TH MARCH
   ========================================================================== */

function WishList($type="wishlist"){

	global $wpdb, $PPT, $userdata; $STRING = ""; $i=1; $date_format = get_option('date_format') . ' ' . get_option('time_format');
 
	$sql = 'posts_per_page=200&post_type=ppt_wishlist&author='.$userdata->ID."&meta_key=type&meta_value=".$type;

	$posts = new WP_Query( $sql );
 
	if(empty($posts)){
	
	$STRING .= '<div class="yellow_box"><div class="yellow_box_content"><div align="center"><img src="'.get_template_directory_uri().'/PPT/img/exclamation.png" align="absmiddle" /> 
	'.$PPT->_e(array('myaccount','40')).'</div><div class="clearfix"></div></div></div>';
	
	return  $STRING;
	
	}
	foreach($posts->posts as $post){ 
	
	// SOTRED DATA
	$itemID 	= get_post_meta($post->ID, "itemID", true); 
	 	 
	// DATE
	$date = mysql2date($date_format, $post->post_date, false);  
	
	$STRING .= '<div class="green_box" id="alter'.$post->ID.'"><div class="green_box_content">';
 
	// IMAGE
	$STRING .='<div class="left">'.premiumpress_image($itemID,"",array('alt' => $post->post_title,  'link' => true, 'link_class' => 'frame', 'width' => '50', 'height' => '50', 'style' => 'max-width:60px; max-height:40px;' )).'</div><div class="left"  style="padding-left:10px;">';
		
	// TITLE
	$STRING .= '<a href="'.get_permalink($itemID).'"><h3>'.get_the_title($itemID).'</h3></a> '.$PPT->_e(array('title','13')).' '.$date;
	
	$STRING .= "</div>";
	
	// BUTTONS
	$STRING .= "<div class='right'>";	
	$STRING .= "<a class='button green' href='".get_permalink($itemID)."'>".$PPT->_e(array('button','4'))."</a> | 
	<a class='button green addthis_button' href='javascript:void(0);'>".$PPT->_e(array('button','15'))."</a> | 
	<a class='button green' href='javascript:void(0);' onclick=\"jQuery('#alter".$post->ID."').hide();PPTDeleteWishlist('".str_replace("http://","",PPT_THEME_URI)."/PPT/ajax/','".$post->ID."','deletealter".$type."');\">".$PPT->_e(array('button','3'))."</a>";			
	  
	$STRING .= "</div>";	
	
	
	
 
 	// END GREEN BOX
	$STRING .= '<div class="clearfix"></div></div></div> <!-- ajax alter --> <div id="deletealter'.$type.'"></div><!--end ajax alter -->'; 
	
	$i++; }  
      
    return  $STRING;
}

/* =============================================================================
   EMAIL ALTERS // V7 // 26TH MARCH
   ========================================================================== */

function EmailAlters(){

global $wpdb, $PPT, $userdata; $STRING = ""; $i=1; $date_format = get_option('date_format') . ' ' . get_option('time_format');
 
 	
	$sql = 'post_type=ppt_alert&post_author='.$userdata->ID;

	$posts = new WP_Query( $sql );
 
	if(empty($posts)){
	
	$STRING .= '<div class="yellow_box"><div class="yellow_box_content"><div align="center">
	<img src="'.get_template_directory_uri().'/PPT/img/exclamation.png" align="absmiddle" /> '.$PPT->_e(array('myaccount','40')).'</div><div class="clearfix"></div></div></div>';
	
	return  $STRING;
	
	}
	
	foreach($posts->posts as $post){
	
	if($post->post_author != $userdata->ID ){ continue; } 
	 
	// GET CATEGORY DETAILS
	$TERMID = get_post_meta($post->ID, "catID", true);
	 
	$cat = get_the_category_by_ID( $TERMID );	
	
	if(!is_string($cat)){ unset($cat); $cat=""; }
	 
	 
	// DATE
	$date = mysql2date($date_format, $post->post_date, false);  
	
	if($cat !=""){
	$STRING .= '<div class="green_box" id="alter'.$post->ID.'"><div class="green_box_content">';	
	
	// BUTTONS
	$STRING .= "<div class='right'>";	
	$STRING .= "<a href='".get_category_link(get_post_meta($post->ID, "catID", true) )."' class='button green'>".$PPT->_e(array('button','4'))." </a> | 
	<a class='button green' href='javascript:void(0);' onclick=\"jQuery('#alter".$post->ID."').hide();PPTDeleteAlert('".str_replace("http://","",PPT_THEME_URI)."/PPT/ajax/','".$post->ID."','deletealter');\">".$PPT->_e(array('button','3'))."</a>";			
	  
	$STRING .= "</div>";	
	
	
	$STRING .= '<a href="?mid='.$post->ID.'"><h3>'.$cat.'</h3></a> '.$PPT->_e(array('title','13')).' '.$date;
	
 
 	// END GREEN BOX
	$STRING .= '<div class="clearfix"></div></div></div> <!-- ajax alter --> <div id="deletealter"></div><!--end ajax alter -->';
	} 
	
	$i++; }  
      
    return  $STRING;

}
 

/* =============================================================================
   MESSAGES
   ========================================================================== */

function MessagesBox($type=""){

global $wpdb, $wp_query, $PPT, $userdata; $STRING = ""; $i=1; $date_format = get_option('date_format') . ' ' . get_option('time_format'); $tcount = 0;
 
	
	$temp 		= $wp_query; //save old query
	$wp_query	= null; //clear $wp_query
  	$query = new WP_Query('posts_per_page=200&post_type=ppt_message&meta_key=username&meta_value='.$userdata->user_login);
  	$posts = $query->posts;
	
	foreach($posts as $post){ 
		
		// STATUS
		$status = get_post_meta($post->ID, "status", true);	
		if($status != $type){ continue; }
		
		//SETUP BOX COLOR
		if($status == "unread"){ $bc = "green"; }else{ $bc = "gray"; }
		
		// DATE
		$date = mysql2date($date_format, $post->post_date, false);  
		
		$STRING .= '<div class="'.$bc.'_box"><div class="'.$bc.'_box_content">';	
		
		// BUTTONS
		$STRING .= "<div class='right'>";	
		$STRING .= "<a href='?mid=".$post->ID."' class='button ".$bc."'>".$PPT->_e(array('button','4'))." </a> | 
		<a href=\"javascript:void(0);\" class='button ".$bc."' onclick=\"document.getElementById('messageID').value='".$post->ID."';messageDel2.submit();\">".$PPT->_e(array('button','3'))."</a>";			
		  
		$STRING .= "</div>";
		
		// GET AUTHOR
		if($post->post_author == 0){
		$author = "a website visitor";
		}else{
		$author = get_the_author_meta('display_name',$post->post_author);
		}
		
		
		$STRING .= '<a href="?mid='.$post->ID.'"><h3>'.$post->post_title.'</h3></a> sent by <b>'.$author."</b> on ".$date;
		
	 
		// END GREEN BOX
		$STRING .= '<div class="clearfix"></div></div></div>'; 
		
		$tcount++; $i++;
		
	} // end foreach  
	
   wp_reset_postdata();
   $wp_query = null; //Reset the normal query
   $wp_query = $temp;//Restore the query  
	
	if($tcount == 0){
	
		$STRING = '<div class="yellow_box"><div class="yellow_box_content" align="center">'.$PPT->_e(array('messages','18')).'<div class="clearfix"></div></div></div>';
	
	}
      
    return  $STRING;

}
 

/* =============================================================================
   SLIDER FUNCTION // V7 // MARCH 16TH
   ========================================================================== */

function SLIDER($sliderID=1){

	if(isset($GLOBALS['noslide'])){ return; } // HELPS STOP THE SLIDER DISPLAY
	
	global $PPT, $wpdb; $STRING = ""; 
	
	$SLIDERSTYLE = get_option("PPT_slider_style");
	
	if($SLIDERSTYLE == "9"){ return do_shortcode(stripslashes(get_option("PPT_slider9_content"))); }
	
	// BUILD THE SLIDER DATA
	if(get_option("PPT_slider_items") =="featured"){
			$sliderData = query_posts('meta_key=featured&meta_value=yes&orderby=rand&showposts=100');
			 
			$isFeatured = true;
			$orderValue = "post_title";
			
	}elseif(get_option("PPT_slider_items") =="new"){
			$sliderData = query_posts('&orderby=ID&order=desc&showposts=10');
			 
			$isFeatured = true;
			$orderValue = "post_title";
			
	}elseif(get_option("PPT_slider_items") =="custom"){
	
			$sliderData = query_posts(get_option('PPT_slider_items_customquery'));
			 
			$isFeatured = true;
			$orderValue = "post_title";
	}else{
			$sliderData = get_option("slider_array");
			$isFeatured = false;
			$orderValue = "order";
	}

	// return if no data is found
	if(!is_array($sliderData) || count($sliderData) == 0 ){ return ""; }
	
	
	// HALF PAGE SLIDER SETUP
	if($sliderID == 2){	
		$STRING .= '<div id="featured-item"><ul id="featured-itemContent">'; //&amp;w=695
						
		$sortedSlider = $this->array_sort($sliderData, 'order', SORT_ASC);
		$i=0; foreach($sortedSlider as $slide){ 
		 
		if($isFeatured){
		 
		$STRING .= '<li class="featured-itemImage">'.premiumpress_image($slide,"featured",array('alt' => $slide->post_title,  'link' => true,  'width' => '695', 'height' => '265', 'style' => 'auto' ));
		
			if(get_option("PPT_slider2_text") =="yes"){               
			$STRING .= '<span>';
			}else{
			$STRING .= '<div  style="display:none"><span>';
			}                      
			 
			$STRING .= '<strong>'.stripslashes($slide->post_title).'</strong>            
			   <b>'.strip_tags($slide->post_excerpt).' <br /> </b> 
			 </span>';
			 
			 if(get_option("PPT_slider2_text") =="yes"){  }else{ $STRING .= '</div>'; } 
			 
			 $STRING .= '</a>';
			 
		  $STRING .= '</li>';
		  
		  }else{
		  
		$STRING .= '<li class="featured-itemImage">               
			<a href="'.$slide['s5'].'"  title="'.$slide['s3'].'">
			<img src="'.premiumpress_image_check($slide['s2'],"full","").'" alt="'.$slide['s3'].'" /> ';
			if(get_option("PPT_slider2_text") =="yes"){               
			$STRING .= '<span>';
			}else{
			$STRING .= '<div  style="display:none"><span>';
			}  
			                   
			$STRING .= '<strong>'.stripslashes($slide['s3']).'</strong>            
			   <b>'.strip_tags($slide['s4']).' <br /> </b> 
			 </span>';
			 if(get_option("PPT_slider2_text") =="yes"){  }else{ $STRING .= '</div>'; }  
			 $STRING .= '</a>';
			
		 
		  $STRING .= '</li>';
		  		  
		  }
		
		}
						
		$STRING .= '<li class="clear featured-itemImage">&amp;&amp;</li></ul></div>';	
	
	wp_reset_query();
	return $STRING;
	
	}
	
	// FULL PAGE SLIDER SETUPS 
	 
	switch($SLIDERSTYLE){
	
	
	case "1": {
	
	$STRING .= '<div class="clearfix"></div><div class="clearfix" style="padding-top:10px;"></div>
	<div class="slider9"><div class="l-rotator"><div class="screen"><noscript><!--  javascript is off --> </noscript></div><div class="thumbnails"><ul>';
	
	
	$sortedSlider = $this->array_sort($sliderData, $orderValue, SORT_ASC); $i=0;
	
	foreach($sortedSlider as $slide){
		 
			if($isFeatured){
			
			$STRING .=
			'<li>
			<div class="thumb">
			'.premiumpress_image($slide,"",array('alt' => $slide->post_title,  'width' => '75', 'height' => '50', 'style' => 'max-width:60px; max-height:55px;', 'class'=>'frame' )).'
			<p><span class="title">'.$slide->post_title.'</span>';
			
			if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" || strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){
			$STRING .= '<br />'.premiumpress_price(get_post_meta($slide->ID, "price", true),$GLOBALS['premiumpress']['currency_symbol'],$GLOBALS['premiumpress']['currency_position'],1).'';
			}
			
			$STRING .='</p>
			</div>
			<a href="'.premiumpress_image($slide,'featured',array('return' => true, 'alt' => $slide->post_title)).'">&nbsp;</a>
			<a href="'.get_permalink($slide->ID).'" >&nbsp;</a>
			<div style="top:230px; left:0px; width:695px; height:70px;">
			<div style="margin-left:10px;"><b>'.$slide->post_title.'</b><br />'.strip_tags($slide->post_excerpt).'</div>
			</div>
			</li>';
			
			}else{
			
			$STRING .=
			'<li>
			<div class="thumb"><img src="'.premiumpress_image_check($slide['s2'],'url',"&amp;w=70&amp;h=65").'" alt="'.strip_tags(str_replace('"',"",stripslashes($slide['s3']))).'" style="max-width:60px; max-height:55px;" class="frame"/>
			<p><span class="title">'.$slide['s1'].'</span><br/>'.substr(strip_tags(stripslashes($slide['s3'])),0,55).'..</p>
			</div>
			<a href="'.premiumpress_image_check($slide['s2'],'full',"").'"></a>
			<a href="'.$slide['s5'].'" ></a>
			<div style="top:230px; left:0px; width:695px; height:70px;">
			<div style="margin-left:10px;"><b>'.$slide['s3'].'</b><br />'.stripslashes($slide['s4']).'</div>
			</div>
			</li>';		
			
			}
	 
	} 
	
	$STRING .= '</ul></div></div></div>';
	
	} break;
	
	case "2":
		case "3":
		case "4":		
		case "5": {
			 
		$STRING .= '<div class="myslider">';	 
						 
		$sortedSlider = $this->array_sort($sliderData, $orderValue, SORT_ASC);
		$i=0; foreach($sortedSlider as $slide){
		
			if($isFeatured){ 
						 
				$STRING .= ' <div>'.premiumpress_image($slide,"featured",array('alt' => $slide->post_excerpt, 'width' => '960', 'height' => '360', 'style' => 'auto' )).'</div>';
			
			}else{ 
						  
				$STRING .= ' <div><a href="'.$slide['s5'].'"  title="'.$slide['s3'].'"><img src="'.premiumpress_image_check($slide['s2'],"full","&amp;w=960&amp;h=360").'" alt="'.stripslashes($slide['s3']).'" /></a></div>';			
			
			} 

		}
						
		$STRING .= '</div>';
	 
	} break;	
	
	
	case "6": { } break;	
	
	case "7": {
	
	$STRING = '<div class="clearfix"></div><div class="box clearfix full "><div class="first_col b1 col" style="width:550px;"><div id="sliderWrapper"><div id="sliderHolder"></div><div id="sliderImages"> ';
	$sortedSlider = $this->array_sort($sliderData, $orderValue, SORT_ASC);
	$i=0; 
	foreach($sortedSlider as $slide){
	$STRING .= '<ul>';
		 
		if($isFeatured){
						
				$STRING .= '<li title="image">'.premiumpress_image($slide->ID,"featured",array('link' => true, 'alt' => $slide->post_title, 'width' => '500', 'height' => '250', 'style' => 'auto' )).'
				 
				 
				</li><li title="caption" class="20,20" style="background-color: #fff; color: #444">'.$slide->post_title.'</li>';
			
			}else{
			 
				$STRING .= '<li title="image"><a href="'.$slide['s5'].'"  title="'.$slide['s3'].'"><img src="'.premiumpress_image_check($slide['s2'],'full',"&amp;w=500&amp;h=250").'" alt="'.stripslashes($slide['s3']).'" /></a></li>
				
				<li title="caption" class="20,20" style="background-color: #fff; color: #444">'.$slide['s1'].'</li>
				
				</li>';
			} 
			
		$STRING .= '</ul>';	
		}
			
		$STRING .= '</div>
      	   <div id="slideControls">
                <div id="slide_prev">
                    <img src="'.PPT_THEME_URI.'/PPT/js/slide/images/7/icons/prev.png" alt="prev" width="33" height="33"/>
                </div>
                 <div id="slide_toggle">
                	<div id="pause_icon">
                    <img id="pause2img" src="'.PPT_THEME_URI.'/PPT/js/slide/images/7/icons/pause2.png" alt="pause2" width="33" height="33"/>
                    <div id="pause_icon2"><img id="pauseimg" src="'.PPT_THEME_URI.'/PPT/js/slide/images/7/icons/pause.png" alt="pause" width="33" height="33"/></div>
                    </div>                  
                    <div id="play_icon">
                    <img id="play2img" src="'.PPT_THEME_URI.'/PPT/js/slide/images/7/icons/play2.png" alt="play2" width="33" height="33"/>
                    <div id="play_icon2"><img id="playimg" src="'.PPT_THEME_URI.'/PPT/js/slide/images/7/icons/play.png" alt="play" width="33" height="33"/></div>
                    </div>                    
                </div>
                 <div id="slide_next">
                    <img src="'.PPT_THEME_URI.'/PPT/js/slide/images/7/icons/next.png" alt="next" width="33" height="33"/>
                </div>
    
    	  </div>
           <div id="fontMeasure">a</div>           
     </div>
   
     <div id="componentLoader"><img src="'.PPT_THEME_URI.'/PPT/js/slide/images/7/loader.gif" width="24" height="24"></img></div>
	 <div class="clearfix"></div></div><div class="last_col b2 col" style="width:360px;"><div style="margin-top:20px; margin-left:20px;">'.stripslashes(get_option('PPT_slider_7_description')).'</div></div></div> ';
 
	
	
	} break; 
	
	case "8": {
	
	if($isFeatured){
	
	$STRING .= "<h1>Manual Configuration Only</h1><p>This PremiumPress slider is designed for manual configuration only, please login to the admin setup slides manually.</p>";
	
	}else{ 
	
	$STRING .= '<div id="oneByoneB">  ';
	
	$sortedSlider = $this->array_sort($sliderData, $orderValue, SORT_ASC);
	foreach($sortedSlider as $slide){	
	
	if($slide['order']%2){ $styleME = ''; }else{ $styleME = 'class="rb"'; }			
	
		$STRING .= '<div class="oneByOne_item"><img src="'.premiumpress_image_check($slide['s2'],'full',"").'" alt="img 1" '.$styleME.' />';		
			
			if(isset($slide['s1']) && strlen($slide['s1']) > 1){ $STRING .= '<h1 '.$styleME.'>'.$slide['s1'].'</h1>'; }			            
			if(isset($slide['s1']) && strlen($slide['s3']) > 1){ $STRING .= '<h2 '.$styleME.'>'.$slide['s3'].'</h2>'; } 	
			if(isset($slide['s1']) && strlen($slide['s4']) > 1){ $STRING .= '<span '.$styleME.'>'.$slide['s4'].'</span>'; }
															
		$STRING .= '</div>';
		
	}
 
	$STRING .= '</div>';
		
		
	}
	
	} break;
	
		 
		 
	}
		
	wp_reset_query();
	return $STRING;
	
	
	}
	
	
	function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}







/* =============================================================================
   CUSTOM FIELD OUTPUT // V7 // MARCH 16TH
   ========================================================================== */
   		
 function CustomFields($post,$FieldValues="", $return = false, $bf="<div class='full clearfix border_b customfieldsoutput'><p class='f_half left'>",$af="</p></div>"){

	global $wpdb,$PPT;$row=1; $STRING = ""; $checkPak = false;

	$FieldValues = get_option("customfielddata");	
	 
	// CHECK IF PACKAGES ARE ENABLED
	if(get_option('pak_enabled') ==1){ $checkPak=true; }
	
	// GET PACKAGES DATA ARRAY
	$PACKAGE_OPTIONS = get_option("packages");
		
	// GET PACKAGE ID FOR LISTING
	$pakID = get_post_meta($post->ID, 'packageID', true);	 

	if(is_array($FieldValues)){ 

		foreach($FieldValues as $key => $field){
		
		if(isset($field['show']) && $field['show'] == 1){ continue; } 		
		
		// CAN WE DISPLAY THIS FIELD FOR THIS PACKAGE?
		if($checkPak && is_numeric($pakID) ){
			// BETTER CHECK
			if(!isset($field['pack'.$pakID]) || isset($field['pack'.$pakID]) && $field['pack'.$pakID] != 1){ continue; }	
		}		
		
		// IS THIS A TITLE?
		if(isset($field['fieldtitle']) && $field['fieldtitle'] == 1){
		
		$STRING .= "<h4 class='fieldtitle'>".$field['name']."</h4>";
		
		}else{ 
 
			if(strlen($field['name']) > 0 ){ 				 
			
			$imgArray = array('jpg','gif','png');

			$value = $PPT->GetListingCustom($post->ID,$field['key'] );
 
			if(is_array($value) || strlen($value) < 1){   }else{	
			
			if($field['type'] != "textarea"){						
		
				$STRING .= $bf; 
				
				if($field['name'] != "youtube"){
				$STRING .= "<span>".$field['name']."</span></p>";
				}
				$STRING .= "<p class='f_half left'>";
				
			}else{
			
				$STRING .= "<div><p><strong>".$field['name']."</strong></p>";
			
			}	
				
		
				switch($field['type']){
				 case "textarea": {			
					$STRING .= "<div class='clearfix'></div>".wpautop(stripslashes($value))."<div class='clearfix'></div>";
				 } break;
				 
				 // added in 7.1.1 (1st sep)
				 case "check": {
				 
				 	$svv = explode(",",$field['value']);			
					
					$ll = explode("|",$value);
					$STRING .= '<div class="ticklist"><ol class="list clearfix">';
					
					foreach($svv as $val){
						if(strlen($val) > 0){
					 		if(in_array($val,$ll)){
					 			$STRING .= '<li class="on"><span>'.$val.'</span></li>';
					 		}else{
								$STRING .= '<li class="off"><span>'.$val.'</span></li>';
							}	
						}					
					}// end foreach 
				 	$STRING .= '</ol></div>';
				 
				 } break;
				 
				 case "list": {
					$STRING .=  stripslashes(stripslashes(stripslashes($value)));
				 } break;
				 
				 default: {
					
					$pos = strpos($value, 'http://');
					
					if($field['key'] == "youtube"){	
					
					include(TEMPLATEPATH."/PPT/class/class_video.php"); 
					$embedCode = new VideoProvider();
					$data =  $embedCode->getEmbedCode($value);
					
					if(isset($GLOBALS['nosidebar3'])){ 
					$STRING .= "</p></div><div><p>".str_replace("640","450",str_replace("385","285",$data['embed']));	
					}else{
					$STRING .= "</p></div><div><p>".str_replace("640","580",str_replace("385","345",$data['embed']));	
					}
					
					
								
					}elseif($field['key'] == "skype"){
						$STRING .= "<a href='skype:".$value."?add'>" .  $value ."</a>";
					}elseif ($pos === false) {
						$STRING .=  $value;
					}elseif(in_array(substr($value,-3),$imgArray)){
						$STRING .= "<img src='".strip_tags($value)."' style='max-width:250px;margin-left:20px;'>";
					}else{
						$STRING .= "<a href='".$value."' target='_blank'";
						if($GLOBALS['premiumpress']['nofollow'] =="yes"){ $STRING .= 'rel="nofollow"'; }
						$STRING .= ">" .  $value ."</a>";				
					} 
					
				 }
		
				}
				$row++;
				$STRING .= $af;
				
				}

				} 
			}
		}
		
		}
		
	if(strtolower(PREMIUMPRESS_SYSTEM) != "employeepress"){ 
	
		
	// INCLUDE CATEGORY	
	$STRING .= "<div class='full clearfix border_b customfieldsoutput'><p class='f_half left'><strong>".$PPT->_e(array('add','19'))."</strong></p>";
	$STRING .= "<p class='f_half left'>".get_the_term_list( $post->ID, "category", "", ', ', '' )."</p>";
	$STRING .= "</div>";
		
		// INCLUDE LOCATION AND TAXONOMIES
		if(get_option('display_country') == "yes"){
			$ca = get_the_term_list( $post->ID, "location", "", ', ', '' );
			if(strlen($ca) > 1){
			$STRING .= "<div class='full clearfix border_b customfieldsoutput'><p class='f_half left'><strong>".$PPT->_e(array('myaccount','15'))."</strong></p>";
			$STRING .= "<p class='f_half left'>".$ca."</p>";
			$STRING .= "</div>";
			}
		}
	
		// INCLUDE CATEGORY	
		if(get_option("display_search_tags") =="yes"){ 
			$posttags = get_the_tags(); $tags = "";
			if ($posttags) {
				foreach($posttags as $tag) {
				 
				$tags .= "<a href='".get_tag_link($tag->term_id)."'>".$tag->name . '</a> '; 
				}
			
			$STRING .= "<div class='full clearfix border_b customfieldsoutput'><p class='f_half left'><strong>".$PPT->_e(array('add','25'))."</strong></p>";
			$STRING .= "<p class='f_half left'>".$tags."</p>";
			$STRING .= "</div>";	
			}
		}
	
	}
	
	if($return){
	return $STRING;
	}else{
	echo $STRING;
	}		

	
}


/* =============================================================================
   ATTACHMENTS // V7 // MARCH 16TH
   ========================================================================== */

function Attachments($postID){

	global $wpdb,$PPT;$row=1; $STRING = "";
	
	// RETUNR IF INVALID
	if(!is_numeric($postID)){ return; }

	// GET THE IMAGES ARRAY
	$files = explode(",",get_post_meta($postID, 'images', true));
	
	if(is_array($files)){ 

		foreach($files as $file){ if(strlen($file) > 5){
			
		// SWITCH THE FILE TYPE
		$prefix = explode(".",$file);
			
			switch($prefix[1]){
			
				case "flv": {				
				
				if(isset($GLOBALS['nosidebar1']) || isset($GLOBALS['nosidebar2'])){ $w = 580; $h = 325; }elseif(isset($GLOBALS['nosidebar3'])){ $w = 450; $h = 255; }else{ $w = 860; $h = 490;  }
	
				
				if(strpos($file, "http") === false){
				$filelink = get_option('imagestorage_link').$file;
				}else{
				$filelink = $file;
				}
				
				$file_type = substr($file,-3);
				switch($file_type){
					case "mp4": { $fileType = "video/mp4";} break;
					default: { $fileType = "video/flv";} break;
				} 
	
				$STRING .= '<video id="video_id_'.$row.'" width="100%" height="300" style="width: 100%; height: 100%;" controls="controls" preload="none">
				<source type="'.$fileType.'" src="'.$filelink.'" />
				</video>';
				
				$STRING .= '<script type="application/javascript">jQuery(\'#video_id_'.$row.'\').mediaelementplayer();</script>';
			  
						 
				} break;
			 
				case "pdf": {					
					
						$STRING .= "<a href='".get_option('imagestorage_link').$file."' target='_blank' rel='nofollow'><img src='".get_template_directory_uri()."/PPT/img/pdf.png' alt='pdf' /></a>";
				} break;
				
				// DEFAULT IS JPG / GIF / PND
				default: {
				 
				$STRING .= '<a href="'.premiumpress_image_check($file,"full","").'" class="lightbox" rel="attachments"><img class="small attachment" src="'.premiumpress_image_check($file,"image","&amp;w=150").'" /></a>';
				
				}
				
			} // end switch
				
		} }// end loop
	
	} // end if
	 
		
return $STRING;
	
}	 



/* =============================================================================
   DISPLAY CUSTOM FIELD OUTPUT ON SUBMISSION PAGE // V7 UPDATED
   ========================================================================== */	

function TPLADD_Value($key,$value){
$STRING = "";
switch(trim($key)){
	case "description":{
		$STRING = wpautop($value);
	} break;
	case "short":{
		$STRING = "".nl2br($value)."";
	} break;			
	default: {
	
		if($key == "store"){
			if(is_array($value)){		
				foreach($value as $val){
				$t = get_term( $val, "store" );
				$STRING .= $t->name.",";
				}
			}elseif(is_numeric($value)){
				$t = get_term( $value, "store" );
				$STRING .= $t->name." ";
			}
		 
		}else{
		$STRING = strip_tags($value);
		}		
	}	
}
return PPTOUTPUT($STRING,$key);
} 

/* =============================================================================
   BUILD CUSTOM FIELDS FOR SUBMISSION PAGE // V7 // MARCH 16TH
   ========================================================================== */

function BuildFields($fields,$PACKAGE_OPTIONS, $data=""){

global $wpdb, $PPT, $PPTDesign, $userdata; get_currentuserinfo(); $i = 0; $STRING = ""; $FIELDVALUE=""; 

$csstxt = "f_half left"; 

if(!is_array($fields)){ return; }

	// TAB ORDER
	if(!isset($GLOBALS['tabo'])){ $GLOBALS['tabo']=1; }
 
	foreach($fields as $field){
	
	// NEW TITLE BAR OPTION
	if($field['name'] == "titlebar"){
	$STRING .= '<div class="clearfix"></div><h4><span>'.$field['num'].'</span>'.$field['title'].'</h4><div class="clearfix"></div>';	
	
	continue;
	}
	
	if(isset($field['subtext']) && strlen($field['subtext']) > 1){
		$tooltip = '<a href="javascript:;" class="tooltip" title="'.$field['subtext'].'"></a>';
	}else{ $tooltip =""; }	
	
	if($field['name'] == "map_location"){ $field['type'] = "map"; $STRING .="<div class='clearfix'></div>"; }
	
	if($field['name'] == "tags"){ $field['type'] = "tags"; $STRING .="<div class='clearfix'></div>"; }
		
		
		
		// EXTRA
		if(isset($field['extra']) && $field['extra']){  $extra = $field['extra']; }else{ $extra = ""; }
		
		// CUSTOM GET FOR TAGS
		if(isset($_GET['eid']) && $field['name'] == "tags"){
		
			$tags=""; 
			$posttags = get_the_tags($_GET['eid']);
			
				if ($posttags) {
					foreach($posttags as $tag) {
					$tags  .= $tag->name . ','; 
				}
			}
			 
			$FIELDVALUE = $tags;
			
		}elseif(isset($_POST['action']) && (isset($field['dataname']) && !isset($data[$field['dataname']]) ) && isset($_POST['form'][$field['name']]) ){ 
		
			$FIELDVALUE = $_POST['form'][$field['name']]; 
		 
		
		}elseif($field['type'] == "taxonomy" && isset($_GET['eid']) ){		
		 
				// GET LIST
				$current_terms = wp_get_post_terms( $_GET['eid'], $field['name']);
				// SEE IF WE FOUND ANY
				if(is_array($current_terms)){
					// IF SO LETS LOOP AND BUILD ARRAY
					$FIELDVALUE = array();
					foreach($current_terms as $vv){
					 
						$FIELDVALUE[]  = $vv->term_id;
					}				
				}// end find vals				
				 
		}elseif(isset($field['dataname']) && isset($data[$field['dataname']])){ 
		
			$FIELDVALUE = $data[$field['dataname']]; 	
			
		}else{
		
			$FIELDVALUE = "";
		
		}		
		
		
		
		// SETUP DISPLAY OUTPUT FOR FIELD TYPES
		if($field['type'] == "text" || $field['type'] == "category" || $field['type'] == "listbox" || $field['type'] == "taxonomy" ){
		
		if(isset($field['hidden']) && $field['hidden'] && $FIELDVALUE ==""){ $hidden = "style='display:none;'"; }else{ $hidden = "";  }			
		
		
		$STRING .= '<p class="'.$csstxt.'" id="field_'.$field['name'].'_wrapper" '.$hidden.'><label>'.$field['title'].$tooltip;
		
		if(isset($field['required']) && $field['required']){ $STRING .= ' <span class="required">*</span>'; }
		$STRING .= '</label>';
		
		// FULL OUTPUT FOR TEXTAREAS
		}else{
		 
		if($field['type'] == "longtext"){ $STRING .='<div class="clearfix"></div>'; }
		$STRING .= '<p><label>'.$field['title'].$tooltip;
		
		if(isset($field['required']) && $field['required']){ $STRING .= ' <span class="required">*</span>'; }
		
		$STRING .= '</label>';
		
		if(isset($field['editor'])){ echo $STRING; $STRING=""; } // dirty hack for wp_editor
		
		} 
		 
		
			switch($field['type']){
			
				case "map": {				
				
					$STRING .= '<input type="text" onchange="getMapLocation(this.value);" name="form['.$field['name'].']" id="form_'.$field['name'].'" class="long" tabindex="'.$GLOBALS['tabo'].'" value="'.$FIELDVALUE.'"  '.$extra.'/>';
					
					$STRING .= '<input type="hidden" id="map-long-lat" name="form[map-loglat]" />';
				
				} break;
				
				case "tags": {				
				
					$STRING .= '<input type="text" name="form['.$field['name'].']" id="form_'.$field['name'].'" class="long" tabindex="'.$GLOBALS['tabo'].'" value="'.$FIELDVALUE.'"  '.$extra.'/>';					 
				
				} break;
				
				case "upload": {				
				
					$STRING .= '<input name="form['.$field['name'].']" id="form_'.$field['name'].'" class="long" tabindex="'.$GLOBALS['tabo'].'"  '.$extra.' type="file" />';					 
				
				} break;

				case "hidden": {
				$STRING .= '<input type="hidden" name="form['.$field['name'].']" id="form_'.$field['name'].'" value="'.$field['values'].'"  '.$extra.'/>';	
				} break;
				
				case "longtext": 
				case "text": {
				
				// defaults
				$bitbefore = '';
				
				if(isset($field['onchange'])){ $onchange = "onchange='".$field['onchange']."'"; }else{ $onchange = "";  }
				
				// SHORTNER FOR PRICE FIELDS
				if($field['name'] == "price" || isset($field['pricetag'])){ 
				
				$extra = "style='width:150px;'";
				$bitbefore = '<span style="font-size:16px;font-weight:bold;">'.get_option('currency_code')."</span> ";	
				}
				if(isset($field['date']) && $field['date']){	$ex = 'short date-pick dp-applied"'; 
				
				
				echo "<script type=\"text/javascript\" charset=\"utf-8\">
				
				jQuery(function(){
				Date.format = 'yyyy-mm-dd';
				jQuery('.date-pick').datePicker({startDate:'1996/01/01'})
				
            	jQuery('#form_".$field['name']."').bind('dpClosed',function(e, selectedDates){
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        jQuery('#form_".$field['name']."').dpSetStartDate(d.addDays(1).asString());
                    } } );
					
					});</script> ";
				
				}elseif($field['type'] == "longtext"){ $ex='long'; }else{ $ex='short'; }
				
				$STRING .= $bitbefore.'<input type="text" name="form['.$field['name'].']" id="form_'.$field['name'].'" class="'.$ex.'" tabindex="'.$GLOBALS['tabo'].'" value="'.$FIELDVALUE.'"  '.$extra.' '.$onchange.'/>';
				
				} break;
				
				case "textarea": {
				
				if( $field['name'] == "description" && isset($field['editor']) ){
				
				$STRING .= wp_editor($FIELDVALUE, 'form['.$field['name'].']',array('media_buttons'=>false,  "editor_css"=>"<style>.wp-editor-container{width:98%;}</style>",)); 
				
				}else{
				
				$STRING .= '<textarea class="long" rows="4" name="form['.$field['name'].']" id="form_'.$field['name'].'" tabindex="'.$GLOBALS['tabo'].'" '.$extra.'>'.$FIELDVALUE.'</textarea>';
				
				}
				
				 			
				
				} break;
				
				case "taxonomy": {
				 
				 
				 if(isset($field['defaulttxt'])){   $dt = $field['defaulttxt']; }else{ $dt = "--------"; }
				 
				 $terms = get_terms($field['name'],array("hide_empty" => false));
				 
				 
				 $count = count($terms);				 
				 $STRING .= '<select name="taxonomy['.$field['name'].']'.$bit.'" id="form_'.$field['name'].'" tabindex="'.$GLOBALS['tabo'].'" class="short" onChange="CheckTaxonomyFieldValue(this.value,\''.$field['name'].'\')" >
				 <option value="">'.$dt.'</option>';
					 
					if ( $count > 0 ){ 
					
						 foreach ( $terms as $term ) {
							   
							if(is_array($FIELDVALUE) && in_array($term->term_id,$FIELDVALUE) ){
								$STRING .= '<option value="'.$term->term_id.'" selected=selected>'.$term->name.'</option>';
							}else{
								$STRING .= '<option value="'.$term->term_id.'">'.$term->name.'</option>';
							}										
						 }
					
					 }
					 
				// ADD NEW FIELD SELECTION
				$STRING .= '<option value="new">'.$PPT->_e(array('add','addnew')).'</option>';
				
				$STRING .= '</select><span id="newselectionform_'.$field['name'].'"></span>';
				 
				} break;		
				
				case "listbox": {
				
				if(isset($field['onchange'])){ $onchange = "onchange='".$field['onchange']."'"; }else{ $onchange = "";  }	
			 	
				if(isset($field['multi']) && $field['multi']){ $bit = "[]"; $ex = "multiple style='height:150px;'"; }else{ $ex = ""; $bit = ""; }
				
				// DEFAULT VALUE
				if(isset($_POST['form'][$field['name']])){ $FIELDVALUE = $_POST['form'][$field['name']]; }
			
				$STRING .= '<select name="form['.$field['name'].']'.$bit.'" id="form_'.$field['name'].'" tabindex="'.$GLOBALS['tabo'].'" class="short" '. $ex.' '.$extra.' '.$onchange.'>';
				
					foreach($field['values'] as $key => $title){
					
						if(isset($FIELDVALUE) && $FIELDVALUE == $key){
						$STRING .= '<option value="'.$key.'" selected=selected>'.stripslashes($title).'</option>';
						}else{
						$STRING .= '<option value="'.$key.'">'.stripslashes($title).'</option>';
						}						
						
					}	
							
				$STRING .= '</select>';				
				
				} break;		
				
				case "category": { 
				
					// CHECK HOW MANY CATS WE CAN DISPLAY
					if(isset($_POST['packageID']) && isset($PACKAGE_OPTIONS[$_POST['packageID']]['totalcats']) && is_numeric($PACKAGE_OPTIONS[$_POST['packageID']]['totalcats']) && isset($PACKAGE_OPTIONS[$_POST['packageID']]['a2']) && $PACKAGE_OPTIONS[$_POST['packageID']]['a2'] ==1){
					$totalthis = $PACKAGE_OPTIONS[$_POST['packageID']]['totalcats']; 
					}else{
					$totalthis = get_option("tpl_add_catcount"); 
					}
					 
					// JUST INCASE WE DONT HAVE ANY
					if($totalthis ==""){ $totalthis=1; } 
					
					// MATHS
					$showc = $totalthis-1;	
					
					// LOOP THOURGH ALL OF THEM
					$cattotal=0; $CTOT =0;
					while($cattotal < $totalthis){ 
					
						// FIND DEFAULT CATEGORY
						if(isset($data['cats']) && isset($data['cats'][$cattotal])){ $default = $data['cats'][$cattotal]->cat_ID; }
						elseif(isset($_POST['CatSel'][$cattotal]) && is_numeric($_POST['CatSel'][$cattotal])){ $default = $_POST['CatSel'][$cattotal]; }
						else{ $default =0; }
						
						// HIDE THOSE WE DONT NEED TO SEE
						if($default == 0 && $cattotal > 0){ $hide = '<span style="display:none" id="catlist'.$cattotal.'">'; }else{ $hide = ''; $CTOT++; }
						 
            			$STRING .= $hide.'<select name="CatSel['.$cattotal.']" class="short" tabindex="'.$GLOBALS['tabo'].'">';	
						
										
						if($cattotal > 0){  $STRING .= '<option value=""></option>'; } 
						 
						if(!isset($_POST['packageID']) || !isset($PACKAGE_OPTIONS[$_POST['packageID']]['pricecats'])){ 
						$ThisPAckageID = "";
						$PACKAGE_OPTIONS[$_POST['packageID']]['pricecats'] = ""; 
						
						}else{
						$ThisPAckageID = $_POST['packageID'];
						}
						
						 
						$STRING .= premiumpress_categorylist($default,false,$PACKAGE_OPTIONS[$ThisPAckageID]['pricecats']).'</select>';
						
						$nd = $cattotal+1;
						
						if($default == 0 && $cattotal > 0 && $nd <= $totalthis ){ 
						
							if($nd !=  $totalthis){
						
								$STRING .= '<a href="javascript:void();" class="clearfix" onclick="toggleLayer(\'catlist'.($nd).'\');jQuery(\'#morelink'.$cattotal.'\').hide();" id="morelink'.$cattotal.'">+ '.$PPT->_e(array('add','19')).' ('.$nd.' / '.$totalthis.') </a>';
						
							}
							$STRING .= '</span>';						
						 }
                     
             			$cattotal++; 
                    }  
				
				 	// DISPLAY ADD MORE BUTTONS
					if($totalthis > 1){
					
					$nc = $CTOT*30+30;
					 
					$STRING .= '<a href="javascript:void();" class="clearfix"  style="float:right; margin-top:-'.$nc.'px; padding-right:20px;"  onclick="toggleLayer(\'catlist'.$CTOT.'\');jQuery(\'#morelinkx\').hide();" id="morelinkx"> + '.
					$PPT->_e(array('add','19')).'</a>'; 
					} 
                     
				
				
				} break;
				
				case "packageselect": {
				
					if(is_array($data) && isset($_GET['eid']) ){ 
					
						$STRING  = '<div class="full clearfix" id="packageBox">
						<div class="green_box"><div class="green_box_content"><label>'.$PPT->_e(array('add','53')).'</label> 
						<select class="full" name="NEWpackageID" onchange="document.getElementById(\'refreshPID\').value=this.value;document.refreshPIDform.submit();" tabindex="'.$GLOBALS['tabo'].'">'.$this->PACKAGES($_POST['packageID'],true).'</select>
						<br /><br /><em>'.$PPT->_e(array('add','54')).' '.strip_tags($PACKAGE_OPTIONS[$_POST['packageID']]['name']).'</em> 
						</div></div>
						</div><!-- end package selection block -->'; 
					
					 } 
				
				} break;
			
			} 
		
		if($field['type'] == "map"){
		$STRING .= '<div id="ppt_map_location"></div>';	
		}
		
		if($field['type'] != "packageselect"){
		$STRING .= '</p>';
		}
		
		if(isset($field['editor'])){ echo $STRING; $STRING=""; } // dirty hack for wp_editor
		
		// if($i%2 || $i==0){ $STRING .= '</div>'; }
	$GLOBALS['tabo']++;
	$i++;
	
	}

return $STRING;

}


/* =============================================================================
   DISPLAYS CUSTOM FIELD OUTPUT ON SUBMISSION PAGE // V7 // MARCH 16TH
   ========================================================================== */
function CustomRequiredFields(){

global $wpdb, $PPT; $i = 0; $p = 0; $STRING ="";  $STRING = ""; $FieldValues = get_option("customfielddata");
 
  	if(is_array($FieldValues)){
	
		// REORDER VALUES
		$FieldValues = multisort( $FieldValues , array('order') );
		 
		foreach($FieldValues as $key => $field){	
		
			 if(isset($field['required']) && $field['required'] == "yes" && $field['fieldtitle'] != 1){  
			  
			$STRING .= "var cus".$i." 	= document.getElementById(\"fieldid_".$field['key']."\");
					if(cus".$i.".value == '-------'){
						alert('".$PPT->_e(array('validate','0'))."');
						cus".$i.".style.border = 'thin solid red';
						cus".$i.".focus();
						return false;
					}
					if(cus".$i.".value == ''){
						alert('".$PPT->_e(array('validate','0'))."');
						cus".$i.".style.border = 'thin solid red';
						cus".$i.".focus();
						return false;
					}
					 ";
			 
			 $i++;
			 }
		 } // end foreach
	 
	 }// end is_array
	 
	 return $STRING;
}

/* =============================================================================
   DISPLAYS CUSTOM FIELD OUTPUT ON SUBMISSION PAGE // V7 // MARCH 16TH
   ========================================================================== */
function RegisterCustomRequiredFields(){

global $wpdb, $PPT; $i = 0; $p = 0; $STRING ="";  $STRING = ""; $FieldValues = get_option("ppt_profilefields");

 	if(is_array($FieldValues)){
	
		// REORDER VALUES
		$FieldValues = multisort( $FieldValues['package'] , array('order') );
		if(is_array($FieldValues)){ 
		foreach($FieldValues as $key => $field){
		 
		 	 if(isset($field['required']) && $field['required'] == "yes" && $field['title'] == 0){  
			  
			$STRING .= "var cus".$i." 	= document.getElementById(\"form_".$field['key']."\");
			 
					if(cus".$i.".value == '-------'){
						alert('".$PPT->_e(array('validate','0'))."');
						cus".$i.".style.border = 'thin solid red';
						cus".$i.".focus();
						return false;
					}
					if(cus".$i.".value == ''){
						alert('".$PPT->_e(array('validate','0'))."');
						cus".$i.".style.border = 'thin solid red';
						cus".$i.".focus();
						return false;
					}
					 ";
			 
			 $i++;
			 }
		 } // end foreach
	 }
	 }// end is_array
	 
	 return $STRING;
}		
	
function TPL_ADD_CUSTOMFIELDS($data,$packageID){

global $wpdb, $PPT; $i = 0; $p = 0; $FVAL=""; $FieldValues = get_option("customfielddata"); $STRING = "";

 	if(is_array($FieldValues)){
	
	// REORDER VALUES
	$FieldValues = multisort( $FieldValues , array('order') );
	
	 foreach($FieldValues as $key => $field){	

		if( strlen($field['name']) > 0 && ( isset($field['pack'.$packageID]) && $field['pack'.$packageID] == 1 || get_option('pak_enabled') ==0)  ){
		
		
		   if(isset($field['required']) && $field['required'] == "yes"){ $reqa = "<span class='required'>*</span>"; }else{ $reqa = ""; }
		   
			if(isset($field['fieldtitle']) && $field['fieldtitle'] == 1){
			 
				$STRING .= '<div class="clearfix"></div><h4><span>'.$GLOBALS['numcounter'].'</span>'.$field['name'].'</h4><div class="clearfix"></div>'; $GLOBALS['numcounter']++;
				
			}else{
	
		 	if($field['type'] == "textarea" || $field['type'] == "check"){
			$STRING .= '<p class="full clearfix box"><label>'.$field['name'].''.$reqa.'</label>';
			}else{
			$STRING .= '<p class="f_half left"><label>'.$field['name'].''.$reqa.'</label>';
			}
			switch($field['type']){
			 case "textarea": {
			 
			 if(isset($_POST['action']) && !isset($data) ){ $dd = $_POST['custom'][$i]['value']; }elseif(isset($data)){ $dd = $PPT->GetListingCustom($_GET['eid'],$field['key']);  }else{ $dd = $field['value'];} 
			 
				$STRING .= '<textarea class="long" name="custom['.$i.'][value]" rows="10" cols="48" tabindex="'.$GLOBALS['tabo'].'" id="fieldid_'.$field['key'].'">';				
				$STRING .= str_replace("<br />","\n",$dd);
				$STRING .= '</textarea>';
				
			 } break;
			 
			 // added in 7.1.1 (1st sep)
			 case "check": {
			 
			 if(isset($data)){$listval = explode("|",$PPT->GetListingCustom($_GET['eid'],$field['key']) ); }else{ $listval=""; }	
				
				// DEFAULT VALUE
				if(isset($_POST['custom'][$i]['value']) && is_array($_POST['custom'][$i]['value']) ){$li ='';
				foreach($_POST['custom'][$i]['value'] as $nv){$li  .= $nv."|"; } $listval = explode("|",$li); }
							
				$listvalues = explode(",",$field['value']);
				
				 
				
				 foreach($listvalues as $value){ 
					if(is_array($listval) && in_array($value,$listval) ){ 
					$STRING .= '<span class="shortcheckedwrap"><input type="checkbox" name="custom['.$i.'][value][]" class="shortchecked" tabindex="'.$GLOBALS['tabo'].'" value="'.$value.'" checked=checked> '.$value."</span>"; 
					}else{
					$STRING .= '<span class="shortcheckedwrap"><input type="checkbox" name="custom['.$i.'][value][]" class="shortchecked" tabindex="'.$GLOBALS['tabo'].'" value="'.$value.'"> '.$value."</span>"; 
					}				
					 
				} 
				 
			 
			 
			 } break;
			 
			 case "list": {
			 
				if(isset($data)){$listval = $PPT->GetListingCustom($_GET['eid'],$field['key'] ); }else{ $listval=""; }	
				
				// DEFAULT VALUE
				if(isset($_POST['custom'][$i]['value'])){ $listval = $_POST['custom'][$i]['value']; }
							
				$listvalues = explode(",",$field['value']);
				
				$STRING .= '<select name="custom['.$i.'][value]" class="short" tabindex="'.$GLOBALS['tabo'].'" id="fieldid_'.$field['key'].'">';
				foreach($listvalues as $value){ 
					if($listval ==  $value){ 
					$STRING .= '<option value="'.$value.'" selected>'.$value.'</option>'; 
					}else{
					$STRING .= '<option value="'.$value.'">'.$value.'</option>'; 
					}
				}
				$STRING .= '</select>';	
				
						
			 } break;
			 
			 
			 default: {	
			  
				$STRING .= '<input id="fieldid_'.$field['key'].'" type="text" class="short" name="custom['.$i.'][value]" size="55" tabindex="'.$GLOBALS['tabo'].'" value="';
				
				if(isset($_POST['action']) ){ $FVAL .= "".$_POST['custom'][$i]['value']; }elseif(isset($data) && isset($_GET['eid']) ){ $FVAL .= $PPT->GetListingCustom($_GET['eid'],$field['key'] );  }else{ $FVAL .= $field['value']; }
				
				if($FVAL== ""){ $FVAL= $field['value'];  } 
				
				$STRING .= $FVAL.'">';
				
				$FVAL= "";
			 }
			}
			
			
			
			if(strlen($field['desc2']) > 1){
			$STRING .= '<br /><small>'.$field['desc2'].'</small>';
			}
				
			$STRING .= '<input type="hidden"  name="custom['.$i.'][name]" value="'.$field['key'].'" /><input type="hidden"  name="custom['.$i.'][type]" value="'.$field['type'].'" /></p>'; 
			$GLOBALS['tabo']++;
			$i++;
			
			}
			
		}
	  } 
	}
	
	return $STRING;
}





/* =============================================================================
   VERSION 7+ ADDS EXTRA STYLING TO CUSTOM LAYOUTS
   ========================================================================== */	
   	
function CSS($tag,$return=false){

global $wpdb, $PPT; $V7 = ""; $V8 = "";
	
	if(isset($GLOBALS['flag-home'])){ 
		$columnlayout  = get_option("ppt_homepage_columns");
	}if(isset($GLOBALS['IS_SINGLEPAGE'])){
		$columnlayout  = get_option("ppt_listing_columns"); 
	}else{
		$columnlayout = get_option("ppt_layout_columns");
	}

	if($tag == "columns-left"){	

		if(isset($GLOBALS['flag-home'])){ 	
	 		
			if(get_option("ppt_homepage_columns") == 3 ){ 
			$V7 = "left3cols left"; $V8 = "three columns"; 
			}else{ 
			$V7 = "left2cols left"; $V8 = "four columns"; 
			} 
			 
		}elseif(isset($_GET['s']) || isset($_GET['search-class']) ){
			
			if($columnlayout == 3 ){
			$V7 = "left3cols left"; $V8 = "three columns"; 
			}else{ 
			$V7 = "left2cols left"; $V8 = "four columns"; 
			} 
		
		}elseif($columnlayout =="3"){ $V7 = "left3cols left"; $V8 = "three columns"; 		
		
		}else{  $V7 = "left2cols left"; $V8 = "four columns";  }
		
	}elseif($tag == "columns-right"){
 
		if(isset($GLOBALS['flag-home'])){ 
		
			if(get_option("ppt_homepage_columns") == 3 ){ 
			$V7 = "right3cols left"; $V8 = "three columns"; 
			}else{ 
			$V7 = "right2cols left"; $V8 = "four columns"; } 
			
		}elseif(isset($_GET['s']) || isset($_GET['search-class']) ){
		
			if($columnlayout == 3 ){ $V7 = "right3cols left"; $V8 = "three columns"; }else{ $V7 = "right2cols left"; $V8 = "four columns"; }			
		
		}elseif($columnlayout =="3"){ $V7 = "right3cols left"; $V8 = "three columns";		
		
		}else{  $V7 = "right2cols left"; $V8 = "four columns"; }

	}elseif($tag == "padding"){
	
	if(isset($GLOBALS['nosidebar-right']) && isset($GLOBALS['nosidebar-left'])){ 
	
	if(is_front_page() && strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress" && get_option("display_default_homepage") != 1){	return ""; }
	
	$V7 = "class='padding10'"; 
	$V8 = "class='padding10'";
	}
 
	}elseif($tag == "columns"){	
	
		if(!isset($_GET['s']) && !isset($_GET['search-class']) ){	
		
		if(isset($GLOBALS['nosidebar-right']) && isset($GLOBALS['nosidebar-left'])){ 
		$V7 = "full"; 
		
		}elseif(isset($GLOBALS['nosidebar-right']) && !isset($GLOBALS['nosidebar-left'])){ 
		$V7 = "middle2cols left"; 
		$V8 = "eight columns";	
		}elseif(!isset($GLOBALS['nosidebar-right']) && isset($GLOBALS['nosidebar-left'])){ $V7 = "middle2cols left"; $V8 = "eight columns";	
		}else{ $V7 = "middle3cols left";  $V8 = "six columns"; }
		
		}else{ 
		$ppt_layout_columns = $columnlayout;
		
			if($ppt_layout_columns == 0 ){ $V7 = "full"; }elseif($ppt_layout_columns == 3 ){
			  
			$V7 = "middle3cols left"; 
			$V8 = "six columns";	
			
			}else{ 
			
			$V7 = "middle2cols left"; 
			$V8 = "eight columns"; 
			
			}
		
		}
	
	}elseif($tag == "ppt_layout_width"){
	
		$a = get_option('ppt_layout_width');
		if($a != "full"){ $V7 = "w_960"; $V8 = "row"; }
	
	}
	
	if($return){return $V7 ;}else{echo $V7 ;}
	

}


// moved to main class file
function SYS_PAGES($footer=false){
	 global $PPT;	 
	 return premiumpress_pagelist($footer);
}

/* =============================================================================
   VERSION 6.8+ ADVANCED SEARCH MODIFICATION BOX
   ========================================================================== */		

function AdvancedSearchBox(){

global $PPT;

 if(get_option("display_advanced_search") ==1 ){ // ?>
        
        <div class='AdvancedSearchBox' id='AdvancedSearchBox' style='display:none'>
        <h2><?php $pptST = get_option('ppt_s'); echo $pptST['preset-default']['name']; ?></h2>
        <hr class='hr4' />
        <form action="<?php echo $GLOBALS['bloginfo_url']; ?>/" method="get">
        <?php echo PPT_AdvancedSearch('preset-default'); ?>      
        
        <div class="clearfix"></div>
        <hr class='hr4' />
        <input type='submit' class='button gray' value='<?php echo $PPT->_e(array('button','11')); ?>'/>  
			 <a href="javascript:jQuery('#AdvancedSearchBox').hide();javascript:void(0);" class="button gray" style='float:right;'>
			 <?php echo $PPT->_e(array('button','18')); ?>
			 </a> 
         </form>    
         </div>  
         
<?php }

} 

/* =============================================================================
   VERSION 6.8+ COUNTRY/STATE/CITY DISPLAY
   ========================================================================== */		


function DisplayCountry($data=""){

global $PPT;

$STRING = "";

if(!isset($data['country'])){ $data['country'] = ""; }


	$STRING .=' <p class="f_half left"><label for="name">'.$PPT->_e(array('myaccount','15')).'</label>';
	$STRING .='<select name="form[country]" onchange="javascript:PPTChangeCountry(this.value, \'1\', \'DisplayCountry1\');" class="short" tabindex="8">
	<option value="">--------</option>'.premiumpress_categorylist($data['country'],"toponly",false,"location").'</select>';              
	$STRING .='<div id="DisplayCountry1"> ';

		if(isset($data['state'])){
		$STRING .=' <p class="f_half left"><label>&nbsp;</label>';
		$STRING .='<select name="form[state]" onchange="javascript:PPTChangeCountry(this.value, \'2\', \'DisplayCountry2\')" class="short" tabindex="8"><option value="">--------</option>'.premiumpress_categorylist($data['state'],"toponly",false,"location",$data['country']).'</select>';
		$STRING .='<div id="DisplayCountry2"></div>';
		$STRING .='</p>';
		}
		
$STRING .='</div>';	
		
		if(isset($data['city'])){
		$STRING .=' <p class="f_half left"><label>&nbsp;</label>';
		$STRING .='<select name="form[city]" onchange="javascript:PPTChangeCountry(this.value, \'3\', \'DisplayCountry3\')" class="short" tabindex="8"><option value="">--------</option>'.premiumpress_categorylist($data['city'],"toponly",false,"location",$data['state']).'</select>';
		$STRING .='<div id="DisplayCountry3"></div>';
		$STRING .='</p>';
		}
		
	
			     
$STRING .='</p>';  
 
return $STRING;

}

/* =============================================================================
   HOME PAGE + SEARCH CATEGORY FUNCTION
   ========================================================================== */		


function HomeCategories($TaxType="category",$id=""){ // updated Jan 7th 2012

	global $wpdb, $PPT, $post, $pagenow;
	
	if(isset($post->post_type) && $post->post_type == "article_type"){ $TaxType="article";  }
	
	$SHOWCATCOUNT = get_option("display_categories_count"); $SHOW_SUBCATS = get_option("display_50_subcategories"); $SHOW_SUBCATS_TOTAL = get_option("display_homecats_num"); $STRING = ""; $stopShow=0; 
	if($TaxType ==""){ $TaxType="category"; }
	
	// CHECK FOR LARGE CAT LISTS
	$LARGECATLIST = get_option('system_largecatload');
	if($LARGECATLIST == "yes"){ $largelistme = true; }else{ $largelistme = false; }
	
	if($SHOW_SUBCATS_TOTAL == ""){ $SHOW_SUBCATS_TOTAL=3; } 
	$DISPLAYTYPE = get_option("display_homecats_type");
		
/* =============================================================================
   DISPLAY ALL CATEGORIES
   ========================================================================== */		
	
	
	if( isset($GLOBALS['premiumpress']['catID']) && is_numeric($GLOBALS['premiumpress']['catID']) ){
	
	if(is_numeric($id)){ $thisId = $id;   }else{ $thisId = $GLOBALS['premiumpress']['catID']; }
	
		$args = array(
		'taxonomy'              => $TaxType,
		'type'                  => 'post',
		'parent'  				=>	$thisId,
		'hide_empty'  			=>	$largelistme,	 
		'pad_counts' 			=>	1,
		'hierarchical'          =>  0,
		'exclude'  				=> get_option('article_cats')
		);
		 
		$categories = get_categories($args);		
 
		if(empty($categories)){ return; }
		
	}elseif(is_front_page() || is_home() ){
	
		$dd = explode("&",get_option("display_homecats_orderby"));
		if(!isset($dd[1])){ $dd[1] = "asc"; }
		$args = array(
		'taxonomy'              => $TaxType,
		'type'                  => 'post',
		'orderby'				=> $dd[0],
		'order'					=> str_replace("order=","",$dd[1]),
		'pad_counts'            => 1,
		'child_of'              => 0,
		'hide_empty'            => $largelistme, //
		'hierarchical'          => true,
		'exclude'               => get_option('home_hidden_cats')
		); 
	 
		$categories = get_cat_hierchy(0,$args);
		
	} 
 
 
	$STRING .= '<ul>';
	$icon=0;
 	
	foreach($categories as $category) {
	
	// DONT SHOW SUB CATS FOR CATEGORY PAGES
	if( !isset($thisId) &&  isset($GLOBALS['premiumpress']['catID']) && is_numeric($GLOBALS['premiumpress']['catID']) && $category->parent != $GLOBALS['premiumpress']['catID'] ){ continue; }
	
	
	
	if($TaxType=="category"){$LINK = get_category_link( $category->term_id );	}else{	$LINK = get_term_link( $category, $TaxType );	}		
	 
	 if($DISPLAYTYPE == "full"){ $iconclass = 'icon'.$category->term_id.''; }else{$iconclass = 'icon'; }
	 
	 
			$STRING .= '<li class="'.$iconclass.'"><span><a href="'.$LINK.'" title="'.$category->category_nicename.'" class="bit16"><b>';
			$STRING .= $category->name;
			if($SHOWCATCOUNT =="yes"){ $STRING .= " (".$category->count.')</b></a></span>'; }else{ $STRING .= '</b></a></span>'; }				
			
				if($SHOW_SUBCATS == "yes" && is_front_page()){
				$STRING .= '<div class="bit">';
				foreach($category->children as $child_category){
				
					if($TaxType=="category"){$LINK = get_category_link( $child_category->term_id );	}else{	$LINK = get_term_link( $child_category, $TaxType );	}	
						
					if($stopShow < $SHOW_SUBCATS_TOTAL){
						$STRING .= '<a href="'.$LINK.'" title="'.$child_category->cat_name.'" class="sm">';
						$STRING .= $child_category->cat_name;
						$STRING .= '</a> ';
					}
					$stopShow++;
				}
				$stopShow=0;
				$STRING .= '</div>';
				}
			
			$STRING .= '</li>';		
	$icon++;				
	}
	
	$STRING .= '</ul>'; 
		
	return $STRING;

}

/* =============================================================================
   HOME PAGE + SEARCH CATEGORY FUNCTION
   ========================================================================== */		


function TaxonomyDisplay($cols=3,$tax='location',$all=0,$parentCatId=0) {

 
	$options['columns'] = $cols;   
	$options['more'] = "View more";	
	$options['hide'] = "no";
	$options['num_show'] = 5;	
	$options['toggle'] = "no";
	$show_empty = "0";
	
	if($parentCatId != 0 && is_numeric($parentCatId) ){
 
	$tax .= "&parent=".$parentCatId;
	}
	
    $list = '<div id="CouponPressStores">';
	$SQL = 'order=ASC&hide_empty='.$show_empty.'&taxonomy='.$tax;
	 
 	$tags = get_categories($SQL); 
	$groups = array();
 	
	
	if( $tags && is_array( $tags ) ) {
		foreach( $tags as $tag ) {
		if ($tag->parent > 0 && $all == 1 && $parentCatId == 0) { continue; }
			$first_letter = strtoupper( $tag->name[0] );
			$groups[ $first_letter ][] = $tag;
		}
		
		 
	if( !empty ( $groups ) ) {	
		$count = 0;
		$howmany = count($groups);
		
		// this makes 2 columns
		if ($options['columns'] == 2){
		$firstrow = ceil($howmany * 0.5);
	    $secondrow = ceil($howmany * 1);
	    $firstrown1 = ceil(($howmany * 0.5)-1);
	    $secondrown1 = ceil(($howmany * 1)-0);
		}
		
		
		//this makes 3 columns
		if ($options['columns'] == 3){
	    $firstrow = ceil($howmany * 0.33);
	    $secondrow = ceil($howmany * 0.66);
	    $firstrown1 = ceil(($howmany * 0.33)-1);
	    $secondrown1 = ceil(($howmany * 0.66)-1);
		}
		
		//this makes 4 columns
		if ($options['columns'] == 4){
	    $firstrow = ceil($howmany * 0.25);
	    $secondrow = ceil(($howmany * 0.5)+1);
	    $firstrown1 = ceil(($howmany * 0.25)-1);
	    $secondrown1 = ceil(($howmany * 0.5)-0);
		$thirdrow = ceil(($howmany * 0.75)-0);
	    $thirdrow1 = ceil(($howmany * 0.75)-1);
		}
		
		//this makes 5 columns
		if ($options['columns'] == 5){
	    $firstrow = ceil($howmany * 0.2);
	    $firstrown1 = ceil(($howmany * 0.2)-1);
	    $secondrow = ceil(($howmany * 0.4));
		$secondrown1 = ceil(($howmany * 0.4)-1);
		$thirdrow = ceil(($howmany * 0.6)-0);
	    $thirdrow1 = ceil(($howmany * 0.6)-1);
		$fourthrow = ceil(($howmany * 0.8)-0);
	    $fourthrow1 = ceil(($howmany * 0.8)-1);
		}
		
		foreach( $groups as $letter => $tags ) { 
			if ($options['columns'] == 2){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $firstrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($options['columns'] == 3){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow) { 
			    if ($count == $secondrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($options['columns'] == 4){				
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow) { 
			    if ($count == $thirdrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
			if ($options['columns'] == 5){
			if ($count == 0 || $count == $firstrow || $count ==  $secondrow || $count == $thirdrow || $count == $fourthrow ) { 
			    if ($count == $fourthrow){
				$list .= "\n<div class='holdleft noMargin'>\n";
				$list .="\n";
				} else {
				$list .= "\n<div class='holdleft'>\n";
				$list .="\n";
				}
				}
				}
		
    $list .= '<div class="tagindex">';
	$list .="\n";
	$list .='<h4>' . apply_filters( 'the_title', $letter ) . '</h4>';
	$list .="\n";
	$list .= '<ul class="links">';
	$list .="\n";			
	$i = 0;
	foreach( $tags as $tag ) {
if ($tag->parent > 0 && $all == 1 && $parentCatId == 0) { continue; }
		$url = get_term_link( $tag, "store" );

		$name = apply_filters( 'the_title', $tag->name );
	//	$name = ucfirst($name);
		$i++;
		$counti = $i;
		if ($options['hide'] == "yes"){
		$num2show = $options['num_show'];
		$num2show1 = ($options['num_show'] +1);
		$toggle = ($options['toggle']);
		
		if ($i != 0 and $i <= $num2show) {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			$list .="\n";
			}
		if ($i > $num2show && $i == $num2show1 && $toggle == "no") {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$options['more']."</a>"."</li>"."\n";
			}
		if ($i >= $num2show1){
               $list .= '<li class="hideli"><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			   $list .="\n";
		}
		} else {
			$list .= '<li><a title="' . $name . '" href="' . $url . '">' . $name . '</a></li>';
			$list .="\n";
		}	
		
	} 
		if ($options['hide'] == "yes" && $toggle != "no" && $i == $counti && $i > $num2show) {
			$list .=  "<li class=\"morelink\">"."<a href=\"#x\" class=\"more\">".$options['more']."</a>"."<a href=\"#x\" class=\"less\">".$options['toggle']."</a>"."</li>"."\n";
		}	 
	$list .= '</ul>';
	$list .="\n";
	$list .= '</div>';
	$list .="\n\n";
		if ($options['columns'] == 3 || $options['columns'] == 2){
		if ( $count == $firstrown1 || $count == $secondrown1) { 
			$list .= "</div>"; 
			}	
			}
		if ($options['columns'] == 4){
		if ( $count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1) { 
			$list .= "</div>"; 
			}	
			}
		if ($options['columns'] == 5){		
		if ( $count == $firstrown1 || $count == $secondrown1 || $count == $thirdrow1 || $count == $fourthrow1) { 
			$list .= "</div>"; 
			}	
			}
				 
		$count++;
			} 
		} 
	$list .="</div>";
	
		}
	else $list .= '<p>Sorry, but no results were found</p>';
	
	if($count > 2){
	$list .= "</div>";
	}
	$list .= "<div style='clear: both;'></div>";

return $list ;

}


/* =============================================================================
   BUILD THE GALLERY DISPLAY LIST
   ========================================================================== */		

function GALLERYBLOCK(){

 
	global $wpdb, $PPT;
	$doFeatured = get_option('display_defaultorder');
	
	 
	if(  isset($GLOBALS['GALLERYPAGE']) && $doFeatured == "meta_value&meta_key=featured*desc" &&  !isset($GLOBALS['setflag_article'])  && !isset($GLOBALS['setflag_faq']) && !isset($_GET['s']) && !isset($_GET['search-class']) && !isset($_GET['orderby']) ){
	    
		$i =0;
		while($i < 2){
		
		$taxArray = get_option("ppt_custom_tax");
		
		if(strpos($GLOBALS['query_string'], "tag=") === false){ // DONT INCLUDE CATEGORY FOR TAG SEARCHES
		
			if(strpos($GLOBALS['query_string'], "location=") === false){ // DONT INCLUDE CATEGORY FOR LOCATION SEARCHES
 
				if(strpos($GLOBALS['query_string'], "budget=") === false){ // DONT INCLUDE CATEGORY FOR LOCATION SEARCHES
 
					if(strpos($GLOBALS['query_string'], "store=") === false){ // DONT INCLUDE CATEGORY FOR TAG SEARCHES
				
						if(is_array($taxArray)){ 
						
							foreach($taxArray as $tax){
							
								if($tax['name'] != "" && strlen($tax['name']) > 2){
								
								$NewTax = strtolower(htmlspecialchars(str_replace(" ","-",str_replace("&","",str_replace("'","",str_replace('"',"",str_replace('/',"",str_replace('\\',"",strip_tags($tax['name'])))))))));
								
									if(strpos($GLOBALS['query_string'], $NewTax."=") === false){ // DONT INCLUDE CATEGORY FOR TAG SEARCHES
									
									}else{
									
										$a = explode($NewTax."=",$GLOBALS['query_string']);
										$b = explode("&",$a[1]);	
										$cat = $NewTax."=".$b[0];								
										 
									}
								}
							}
							
							
						
						}else{
						
						$cat = "cat=".$GLOBALS['premiumpress']['catID'];
						
						}
						
				}else{
				$a = explode("store=",$GLOBALS['query_string']);
				$b = explode("&",$a[1]);	
				$cat = "store=".$b[0];	
				 
				}
			
				}else{
				$a = explode("budget=",$GLOBALS['query_string']);
				$b = explode("&",$a[1]);	
				$cat = "budget=".$b[0];	
				 
				}
							
			}else{
				$a = explode("location=",$GLOBALS['query_string']);
				$b = explode("&",$a[1]);	
				$cat = "location=".$b[0];	
			 	
			}
		
		}else{
		 
		$a = explode("tag=",$GLOBALS['query_string']);
		$b = explode("&",$a[1]);	
		$cat = "tag=".$b[0];	
		 
			
		}  
		
	 
	 	// NOT SET?
		if(!isset($GLOBALS['query_string_new'])){ $GLOBALS['query_string_new'] =""; }	
 		if(!isset($cat) || strlen($cat) < 1){$cat = "cat=".$GLOBALS['premiumpress']['catID'];}
	 
			if($i ==0){ 
				$GLOBALS['query_string_new'] .=  $cat."&meta_value=yes&meta_key=featured&orderby=rand&posts_per_page=50"; 
			}else{ 
				$GLOBALS['query_string_new'] .= $cat."&meta_value=no&meta_key=featured&orderby=rand&order=rand";  
			}
			// echo $GLOBALS['query_string_new']."<br>";
			$this->GALLERYBLOCKDO(); $GLOBALS['query_string_new']="";
			$i++;
			}
		
		//}else{
		//wp_reset_query();
		//}
	
	}else{
 
		$this->GALLERYBLOCKDO();
	
	}

}

/* =============================================================================
   GALLERY BLOCK // V7 // MARCH 16TH
   ========================================================================== */		

function GALLERYBLOCKDO(){


	global $wpdb, $userdata, $wp_query, $PPT; $GLOBALS['counter'] = 1;  $galType = get_option('display_liststyle');

	 
	if(isset($GLOBALS['query_string_new'])){	
 
 		// NOT SURE WHY BUT I CANT PASS THE PAGE IN HERE // MOST LIKLY BECAUSE ITS AN ARRAY..
 		if(!is_array($GLOBALS['query_string_new'])){
		
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$GLOBALS['query_string_new'].= "&paged=".$paged;
		
		}
		
		$postslist = query_posts($GLOBALS['query_string_new']);

	}elseif(is_array($GLOBALS['query_string']) && !empty($GLOBALS['query_string']) ){	
		 
		$postslist = query_posts($GLOBALS['query_string']);
		
	}elseif(isset($GLOBALS['query_data'])){
	 
		$postslist = $GLOBALS['query_data'];
	
	}else{
		$GLOBALS['query_string_new']="";
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if(isset($GLOBALS['limitSearch']) && is_numeric($GLOBALS['limitSearch']) ){ $GLOBALS['query_string_new'] .= "&posts_per_page=".$GLOBALS['limitSearch']; }
		$postslist = query_posts($GLOBALS['query_string_new']."&paged=".$paged);  
	
	 }
	 
	
	// HIDE POST ID'S
	if(!isset($GLOBALS['galleryblockhideID']) || !is_array($GLOBALS['galleryblockhideID']) ){ $GLOBALS['galleryblockhideID'] = array(); }
    foreach ($postslist as $loopID => $post){ 
	
	// EDIT FOR FAVS
	// SOTRED DATA
	if(isset($_GET['pptfavs']) && ( $_GET['pptfavs'] == "yes" || $_GET['pptfavs'] == "compare") ){ $GLOBALS['backupID'] = $post->ID; $post  = get_post(get_post_meta($post->ID, "itemID", true)); }
	
	if(in_array($post->ID, $GLOBALS['galleryblockhideID'])){ continue; }
	
		$GLOBALS['post'] 	= $post;
 	 
		if($post->post_type  == "post"){
		
			// CHECK IF THE LISTING HAS EXPIRED			
			premiumpress_expired($post->ID,$post->post_date);  			
			
			// CHECK FOR THE WEBSITE LINK
			$link = premiumpress_link($post->ID);	
			
			// FEATURED
			$featured 	= get_post_meta($post->ID, "featured", true);
			if($featured == ""){ update_post_meta($post->ID, "featured", "no"); }
			
			// FEATURED TEXT
			$featured_text = get_post_meta($post->ID, "featured_text", true);
			 
			// TAGLINE
			$tagline = get_post_meta($post->ID, "tagline", true);
 
		}
		
		
		if( ( strtolower(constant('PREMIUMPRESS_SYSTEM')) == "directorypress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "realtorpress" ) && $post->post_type == "post"){
			// LOAD SOME GLOBAL VALUES FOR DISPLAY
			
			$GLOBALS['directorypress']['custom1'] 			= get_option("display_custom_value1");
			$GLOBALS['directorypress']['custom2'] 			= get_option("display_custom_value2");
			if($GLOBALS['directorypress']['custom1'] != ""){
			
			if($GLOBALS['directorypress']['custom1'] == "country" || $GLOBALS['directorypress']['custom1'] == "city" || $GLOBALS['directorypress']['custom1'] == "state"){
			$custom1 = get_the_term_list( $post->ID, 'location', ' ', ', ', ', ' );
			}else{
			$custom1 		= get_post_meta($post->ID, $GLOBALS['directorypress']['custom1'], true);
			
			}
			
			
			}
			if($GLOBALS['directorypress']['custom2'] != ""){			
			 
				if($GLOBALS['directorypress']['custom2'] == "country" || $GLOBALS['directorypress']['custom2'] == "city" || $GLOBALS['directorypress']['custom2'] == "state"){
				$custom2 = get_the_term_list( $post->ID, 'location', ' ', ', ', ', ' );
				}else{
				$custom2 		= get_post_meta($post->ID, $GLOBALS['directorypress']['custom2'], true);		
				}
			
			}
			
			if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "realtorpress"){
			
			$GLOBALS['directorypress']['custom3'] 			= get_option("display_custom_value3");
			
			
				if($GLOBALS['directorypress']['custom3'] != ""){			
				 
					if($GLOBALS['directorypress']['custom3'] == "country" || $GLOBALS['directorypress']['custom3'] == "city" || $GLOBALS['directorypress']['custom3'] == "state"){
					$custom3 = get_the_term_list( $post->ID, 'location', ' ', ', ', ', ' );
					}else{
					$custom3 		= get_post_meta($post->ID, $GLOBALS['directorypress']['custom3'], true);		
					}
				
				}			
			
			
			}else{
			$GLOBALS['directorypress']['vps'] 				= get_option("display_search_publisher");
			
			}
			
			
		} 
		 
		 
		$hookContent = premiumpress_item($post->post_type); /* HOOK V7 */
		
		if($hookContent == "1"){
		
		// DO NOTHING, OUTPUT FROM THE HOOK ALREADY
		
		
		}elseif( ( $post->post_type  =="article_type" || $post->post_type  =="faq_type" ) ){ 
	
			if(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/_item_article.php')){
							
				include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/_item_article.php');
							
			}else{
			
				if(file_exists(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item_article.php")){
				
					include(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item_article.php"); 
				
				}else{
				
					 include(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item.php");
				 
				}
						
			}
						
		}elseif($galType == "gal"){ 
	
			if(file_exists(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item_gallery.php")){
				
					include(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item_gallery.php"); 
				
				}else{
				
					include(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/_item.php");
				 
				}
						
		}else{ 
		
			if(isset($GLOBALS['query_file'])){ $Loadfile = $GLOBALS['query_file']; }else{  $Loadfile = '_item.php'; }
						
			if(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/'.$Loadfile)){
							
				include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/'.$Loadfile);
							
			}else{
						
				include(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/".$Loadfile); 
						
			}			
						
		}  

	 	$GLOBALS['counter']++;   
					 
	  }
	  
	  wp_reset_query(); wp_reset_postdata();
	  
}


/* =============================================================================
   ALERT BOX // V7 // MARCH 16TH
   ========================================================================== */		

function GL_ALERT($message="",$type="sucesss"){	
	 
 if(strlen($message) < 5){ return; } 	 
 
 $code = '<div class="notification '.$type.'"><p>'.$message.'</p></div> ';	
	
return $code;
	 
}

/* =============================================================================
   ORDER BY BOX ON GALLERY PAGE // V7 // MARCH 16TH
   ========================================================================== */		

function GL_ORDERBY(){
	 
global $PPT, $wpdb; $code= ""; 
	 
if(!isset($GLOBALS['premiumpress']['catID'])){ $GLOBALS['premiumpress']['catID']=""; }
	 
if($GLOBALS['premiumpress']['catID'] == "" && !isset($_GET['search-class']) ){ return; }
	 
	 	if(get_option("listbox_custom") =="1"){
	 
			$code .= '<div class="dropui dropui-menu dropui-grey"><a href="javascript:;" class="dropui-tab">'.get_option("listbox_custom_title").'</a><div class="dropui-content"><ul>';				
			
			$i=1; $a=0; $lv = explode("**",get_option("listbox_custom_string"));
			while($i < 10){
				
				$title = $lv[$a]; $a++;
				$key = $lv[$a]; $a++;
				$value = $lv[$a]; $a++;
				$extra = $lv[$a]; $a++;
				if(strlen($title) > 1){
				
				if(isset($_GET['s'])){ $extra .= "&s=".strip_tags($_GET['s']).""; }
				
				if(isset($_GET['search-class'])){
				$sitelink = curPageURL().'&amp;orderby=meta_value&amp;key='.$key.'&amp;order='.$value.$extra;
				}else{
				$sitelink = get_option('siteurl').'/index.php?cat='.$GLOBALS['premiumpress']['catID'].'&amp;orderby=meta_value&amp;key='.$key.'&amp;order='.$value.$extra;
				}
				 
				$code .= '<li><a href="'.$sitelink.'" rel="nofollow">'.$title.'</a></li>';
				
				 } 
				  
			$i++; }
			
				$code .= '</ul></div></div>';
		
		}
	 
	return $code;
}


/* =============================================================================
   DISPLAY PACKAGE LIST ON SUBMISSION PAGE // V7 // MARCH 16TH
   ========================================================================== */		
	 
function PACKAGES($current=99,$priceDifference=false){
	
		global $wpdb,$PPT;
		
		$STRING = ""; $i=1; $packdata = get_option("packages"); $time ="";
		
		//print_r($packdata[$i]['price']);

		foreach($packdata as $package){ 
		
			if(isset($package['enable']) && $package['enable'] == 1){  
			
				if($current == $i){ $ex = 'selected'; }else{  $ex = ''; }
				
				
				if(isset($packdata[$i]['rec']) &&$packdata[$i]['rec'] ==1){ 
				
					$time =  "/".$packdata[$i]['expire']." ".$PPT->_e(array('date','2'));  
				
				}elseif($packdata[$i]['price'] !="0" && $packdata[$i]['price'] !="" && $packdata[$i]['expire'] > 1){ 
				
				$time = "/".$packdata[$i]['expire']." ".$PPT->_e(array('date','2')); 
				
				}else{
				
				$time = "";
				
				}
			
		
				if($priceDifference && !isset($_POST['currentID']) ){ 
				
					if(  $packdata[$i]['price'] >= $packdata[$current]['price'] ){
					
						$newPrice = $packdata[$i]['price'] - $packdata[$current]['price'];
						
						if($newPrice == 0){ $newPrice="0 / ".$PPT->_e(array('add','add1')); }
					
						$STRING  .="<option value='".$i."' ".$ex.">".$package['name']." (".premiumpress_price($newPrice,$GLOBALS['premiumpress']['currency_symbol'],$GLOBALS['premiumpress']['currency_position'],1)."".$time.")</option>";
					
					}
				
				}else{
				
				$STRING  .="<option value='".$i."' ".$ex.">".$package['name']." (".premiumpress_price($packdata[$i]['price'],$GLOBALS['premiumpress']['currency_symbol'],$GLOBALS['premiumpress']['currency_position'],1)."".$time.")</option>";
				
				}		
		
			} 
		
		$i++; }
 		
		return $STRING;	 
	
}	
	
/* =============================================================================
   MANAGE FUNCTION FOR THE SUBMISSION PAGE // V7 // MARCH 16TH
   ========================================================================== */		

function MANAGE($id,$type="publish"){

	global $wpdb, $PPT; $GLOBALS['type'] = $type;
	
	$hookContent = premiumpress_functionhook("MANAGE"); /* HOOK V7 */

	if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT
	return $hookContent;
	}
	
	$PACKAGE_OPTIONS = get_option("packages");

	$pos = strpos($GLOBALS['premiumpress']['submit_url'], '?'); 
	if ($pos === false) {
		$elink = $GLOBALS['premiumpress']['submit_url']."?";
	} else {
		 $elink = $GLOBALS['premiumpress']['submit_url']."&";
	}	
 

	$pos = strpos($GLOBALS['premiumpress']['manage_url'], '?'); 
	if ($pos === false) {
		$mlink = $GLOBALS['premiumpress']['manage_url']."?";
	} else {
		 $mlink = $GLOBALS['premiumpress']['manage_url']."&";
	}	

	$content = ""; $pakSTRING = ""; 
	
	$SQL = "SELECT ID, post_title, post_date,post_status FROM $wpdb->posts 
	WHERE post_author = ".$id." 
	AND $wpdb->posts.post_type = 'post' 
	AND ( post_status = '".$type."' )
	AND post_title !=''  
	GROUP BY $wpdb->posts.ID ORDER BY $wpdb->posts.post_title ASC LIMIT 200";

	wp_reset_query();
 
	$last_posts = (array)$wpdb->get_results($SQL);

	foreach ($last_posts as $post) {
	
	$GLOBALS['EDITTHISPOSTID'] = $post->ID;
 
	//$categories = get_the_category($post->ID); 
  	$type = get_post_meta($post->ID, "type", true);
	$package = get_post_meta($post->ID, "packageID", true);
	$expires = get_post_meta($post->ID, "expires", true);
	
	if($package > 0 && $expires !=""){
	
		$date_expires 	= strtotime(date("Y-m-d H:i:s", strtotime($post->post_date)) . " +".$expires." days");
		$expires		= date('Y-m-d H:i:s',$date_expires);		 
		$date_format = get_option('date_format') . ' ' . get_option('time_format');
		$date = mysql2date($date_format, $expires, false); 
		 
		$pakSTRING 		= "<br /> <small> ".$PPT->_e(array('title','5')).": ".$date."</small> ";
		 
	}
 	
	$nbox = "";
	
	// START BOX
	$nbox .= '<div class="green_box"><div class="green_box_content">';
	
	// BUTTONS
	$nbox .= "<div class='right' id='rightedit".$post->ID."'>";	
	
	if($post->post_status != "pending"){ 
	$nbox .= "<a href='".$elink."eid=".$post->ID."' class='button green'>".$PPT->_e(array('button','2'))."</a> | ";
	}
			
	//if($post->post_status == "pending"){			 
	//}else{
	$nbox .= "<a href='".$mlink."eid=".$post->ID."&dd=1' onclick=\"return ppt_confirm('".$PPT->_e(array('validate','5'))."');\" class='button green'>".$PPT->_e(array('button','3'))."</a>";			
	//}
	
	$nbox .= "</div>";
	
	// COLUMN WIDTHS	
	if($GLOBALS['ppt_columncount']  == 3){ $exf = "max-width:280px;"; }else{ $exf = "max-width:400px;"; }
	
	// IMAGE	
	$nbox .='<div class="left">'.premiumpress_image($post->ID,"",array('link' => true, 'link_class' => 'frame', 'alt' => $post->post_title, 'width' => '60', 'height' => '60', 'style' => 'max-width:50px;max-height:50px;' )).'</div><div class="left"  style="padding-left:10px;'.$exf.'">';
 
	$nbox .= "<a href='" . get_permalink($post->ID) . "'><h3 style='font-size:16px;'>" .	$post->post_title ."</h3></a>";
	
	if(get_post_meta($post->ID, "hits", true) == ""){update_post_meta($post->ID, "hits", "0");	}
	if(!isset($PACKAGE_OPTIONS[$package]['name'])){ $pa =""; }else{ $pa = strip_tags($PACKAGE_OPTIONS[$package]['name'])." | "; }
	 
	
	$nbox .= "".$pa." ".get_post_meta($post->ID, "hits", true)." ".$PPT->_e(array('title','6'))." ".$pakSTRING;
			 
	$nbox .= premiumpress_manage_text();
	
	$nbox .= "</div><div class='clearfix'></div>";	      
	
	// END BOX
	$nbox .= "</div></div>";	
	
	$content .= premiumpress_manage_filter($nbox);		
		
	}
	 
	wp_reset_query();
	
	return $content;	

}

/* =============================================================================
   TIME DIFFERENCE  // V7 // MARCH 16TH
   ========================================================================== */		

function TimeDiff($date,$style=1){

global $PPT;
	
	switch($style){
	
	case "1": {
	
		return date('l jS \of F h:i:s A',$date);
	
	} break;
	
	case "2" : {
	
			$then = strtotime($date);
		  	$now = time(); 
		  	$diff = $then - $now; 
			$weeks = floor($diff / (60*60*24*7)); 
			$diff = $diff - ($weeks * (60*60*24*7)); 
			
			$days = floor($diff / (60*60*24)); 
			$diff = $diff - ($days * (60*60*24)); 
			
			$hours = floor($diff / (60*60)); 
			$diff = $diff - ($hours * (60*60)); 
			
			$minutes = floor($diff / 60); 
			$diff = $diff - ($minutes * 60); 
			
			$secs = $diff; 
		  
			$out = ''; 
			if($weeks > 0) 
				$out .= $weeks . ' week(s), '; 
			if($days > 0) 
				$out .= $days . ' day(s), '; 
			if($hours > 0) 
				$out .= $hours . ' hour(s), '; 
			if($minutes > 0) 
				$out .= $minutes . ' minute(s), '; 
			if($secs > 0) 
				$out .= $secs . ' second(s) '; 
			$out .= 'left'; 
			
			return $out; 
	
	} break;
	
	
	case "3": {
	 
		$periods      = array(
		$PPT->_e(array('date','second')), 
		$PPT->_e(array('date','minute')), 
		$PPT->_e(array('date','hour')), 
		$PPT->_e(array('date','day')), 
		$PPT->_e(array('date','week')), 
		$PPT->_e(array('date','month')), 
		$PPT->_e(array('date','year')), 
		$PPT->_e(array('date','decade')) );
		
		$lengths        = array("60","60","24","7","4.35","12","10");
	 
		$now             = time();
		$unix_date       = strtotime($date);
	 
		if(empty($unix_date)) {    
			return $PPT->_e(array('date','bad'));
		}
	 
		if($now > $unix_date) {    
			//return "Auction Ended";
			$difference     = $now - $unix_date;
			$tense         = $PPT->_e(array('date','ago'));
	 
		} else {
			$difference     = $unix_date - $now;
			$tense         = "";
		}
	 
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	 
		$difference = round($difference);
	 
		if($difference != 1) {
			$periods[$j].= "s";
		}
	 
		return "$difference $periods[$j] {$tense}";
	
	} break;
	
	case "4" : {
	
			$then = strtotime($date);
		  	$now = time(); 
		  	$diff = $then - $now; 
			$weeks = floor($diff / (60*60*24*7)); 
			$diff = $diff - ($weeks * (60*60*24*7)); 
			
			$days = floor($diff / (60*60*24)); 
			$diff = $diff - ($days * (60*60*24)); 
			
			$hours = floor($diff / (60*60)); 
			$diff = $diff - ($hours * (60*60)); 
			
			$minutes = floor($diff / 60); 
			$diff = $diff - ($minutes * 60); 
			
			$secs = $diff; 
		  
			$out = ''; 
			if($weeks > 0) 
				$out .= $weeks . 'w '; 
			if($days > 0) 
				$out .= $days . 'd '; 
			if($hours > 0) 
				$out .= $hours . 'h '; 
			if($minutes > 0 && $hours < 1) 
				$out .= $minutes . 'm '; 
			if($secs > 0 && $hours < 1) 
				$out .= $secs . 's '; 
			 
			
			return $out; 
	
	} break;	
	
	
	default: {
	
		return $date;
	}
	
	
	}
	
	
	

	}	 
	 
	 
	
 
	 
 
  
/* =============================================================================
   BREADCRUMBS // V7 // MARCH 16TH
   ========================================================================== */		

function breadcrumbs() {
 
 global $PPT;
 
  $delimiter = '';
  $home = $PPT->_e(array('head','1')); // text for the 'Home' link
  $before = '<li class="current">'; // tag before the current crumb
  $after = '</li>'; // tag after the current crumb
  $STRING = "";
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    $STRING .= '<ol class="path">';
 
    global $post;
    $homeLink = get_bloginfo('url');
    $STRING .= '<li><a href="' . $homeLink . '">' . $home . '</a></li>' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) $STRING .=(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      $STRING .= $before . '<a href="#">' . single_cat_title('', false) . '</a>' . $after;
 
    } elseif ( is_day() ) {
      $STRING .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $STRING .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      $STRING .= $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      $STRING .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $STRING .= $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      $STRING .= $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        $STRING .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        $STRING .= $before . get_the_title() . $after;
      } else {
        $cat = get_the_category();
		if(!empty($cat)){
		$cat = $cat[0];
		 
        $STRING .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        $STRING .= $before . get_the_title() . $after;
		}
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      $STRING .= $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      $STRING .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      $STRING .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      $STRING .= $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      $STRING .= $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
	  if(!is_object($parent_id)){
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
		}
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) $STRING .= $crumb . ' ' . $delimiter . ' ';
      $STRING .= $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      $STRING .= $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      $STRING .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      $STRING .= $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      $STRING .= $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $STRING .= ' (';
      $STRING .= $PPT->_e(array('title','10')) . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $STRING .= ')';
    }
 
    $STRING .= '</ol>';
 
  }
  
  return $STRING;
}



/* =============================================================================
   VERSION 7 HOME PAGE OBJECTS
   ========================================================================== */

function GetObject($item,$css=""){

global $wpdb,  $PPTDesign, $post, $PPT, $userdata; $STRING = ""; 


	$STRING = str_replace($item,"",premiumpress_admin_display_objects_display($item)); // HOOK V7 	
 
	
	if(strlen($STRING) > 5){
	
	return $STRING; 
	
	}elseif($item == "tabs"){
 
 	// ADD IN JQUERY
	$STRING .= '<script src="'.PPT_PATH.'js/jquery.jcarousel.pack.js" type="text/javascript"></script>';
	$STRING .= '<script src="'.PPT_PATH.'js/jquery.jcarousellite_1.0.1.js" type="text/javascript"></script>';
	
	// BUILT TABS ARRAY
	$STRING .= '<div class="advtabs"><ol class="tabs">';
	
	// SETUP TITLES
	for($i=0; $i < 5; $i++){
		$title = get_option("ppt_object_tabs_tab_title_".$i);
		if(strlen($title) > 0){
			$STRING .= '<li><a href="#adtabs'.$i.'">'.$title.'</a></li>'; 
		}
	}
	$STRING .= '</ol><div class="tab_container">';
	
	// SETUP CONTENT
	for($i=0; $i < 5; $i++){
	 
		if(get_option("ppt_object_tabs_tab_title_".$i) == ""){ continue; }		
	
		$STRING .= '<div id="adtabs'.$i.'" class="tab_content">'.stripslashes(get_option("ppt_object_tabs_tab_content_".$i));
		
		$queryst = get_option("ppt_object_tabs_tab_query_".$i);
		
		if(strlen($queryst) > 2){
			
			// GET QUERY
			$postslist = query_posts($queryst);
			// MAKE OUTPUT
			if(is_array($postslist) && !empty($postslist) ){
	
			$STRING .= '<div class="ppt-clean-carousel_wrapper cols'.$GLOBALS['ppt_columncount'].'" id="tabcar'.$i.'"><div class="ppt-clean-carousel"><div class="previous_button"></div><div class="container"><ul>'; 
		
			foreach ($postslist as $post ){ 
				  
					$STRING .= '<li>'.premiumpress_image($post->ID,"",array('link' => true,'alt' => $post->post_title, 'width' => '100', 'height' => '100', 'style' => 'auto' )).'
					 
					<div class="ctext">'.$post->post_title.'';
					if(strtolower(PREMIUMPRESS_SYSTEM) != "directorypress" && strtolower(PREMIUMPRESS_SYSTEM) != "agencypress"){ 			
					$price = get_post_meta($post->ID, "price", true);
					if($price != ""){
					$STRING .= '<em class="price">'.premiumpress_price(get_post_meta($post->ID, "price", true),$GLOBALS['premiumpress']['currency_symbol'],$GLOBALS['premiumpress']['currency_position'],1).'</em>';
					}
					}
					 $STRING .= '</div>
					</li>';	
						
			} // end foreach	  
			
			
			$STRING .= '</ul></div><div class="next_button"></div></div></div><div class="clearfix"></div>';
			$STRING .= '<script type="text/javascript">jQuery(function() {    jQuery("#tabcar'.$i.'").jCarouselLite({        btnNext: ".next_button",        btnPrev: ".previous_button",		visible:4,		scroll: 1, auto:2000 }); });</script>';
			} // END MAKE OUTPUT
		} // end if
		
		$STRING .= '</div> <!-- end tab -->';
	
	} // end foreach

	$STRING .= '</div>';// end inner tab
	
	$STRING .= '</div><!-- end advcarousel -->'; 
	
	
	}elseif($item == "bigsearch"){
	
		global $wpdb, $PPT; $STRING = ""; $ext=""; $txtext="";
	
		// GET COLOR
		$color 	= get_option('ppt_object_bigsearch_color');
		$txtcolor 	= get_option('ppt_object_bigsearch_txtcolor');		
		if($color !=""){
			$ext = 'style="background:#'.$color.'"';
		}
		if($txtcolor !=""){
			$txtext = 'style="color:#'.$txtcolor.'"';
		}	
		// GET IMAGE FOR SEARCH BOX
		$img 	= get_option('ppt_object_bigsearch_css');
		if($img !=""){	
		 
			if (stripos($img, "http") !== false) { }else{  $img = $PPT->ImageCheck($img);  }
			$ext = 'style="background:#'.$color.' url(\''.$img.'\') no-repeat top right;"';
		} 
		
		$des = get_option("ppt_object_bigsearch_desc"); 
		$STRING .= '<form method="get"  action="'.$GLOBALS['bloginfo_url'].'/" name="object_bigsearch" id="object_bigsearch" '.$ext.'>';
		$STRING .= '<h1 '.$txtext.'>'.get_option("ppt_object_bigsearch_title").'</h1>';
		if(strlen($des) > 1){
		$STRING .= '<p '.$txtext.' class="desc">'.$des.'</p>';
		}
		$STRING .= '<p '.$txtext.'>'.$PPT->_e(array('object','bigsearch1')).' <input name="s" id="s" type="text"onfocus="this.value=\'\';" value="'.$PPT->_e(array('object','bigsearch2')).'"/>
		
		<input type="submit" value="'.$PPT->_e(array('object','bigsearch3')).'"  class="button gray large" /></p>';
		  
		$STRING .= '</form>	';
		
		return $STRING;	
	
	}elseif($item == "mpvideo"){
	
	$vd = get_option('ppt_homepage_video');
	
	
	if($vd['type'] == "custom" && strlen($vd['filename']) > 1){ 
	
			if(isset($GLOBALS['nosidebar1']) || isset($GLOBALS['nosidebar2'])){ $w = 670; $h = 370; }elseif(isset($GLOBALS['nosidebar3'])){ $w = 540; $h = 304; }else{ $w = 960; $h = 518;  }

 
			$STRING ='<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/jquery.swfobject.js"></script><div id="flashvideo" class="marginBottom"><script type="text/javascript">
			var so = new SWFObject("'.PPT_THEME_URI.'/PPT/js/player.swf", "mymovie", "'.$w.'", "'.$h.'", "9","#fff");
			so.addParam("menu", "false");
			so.addParam("allowfullscreen", "true");
			so.addParam("wmode", "transparent");
 
			so.addVariable("setting", "1");
			so.addVariable("playerAutoHide", "yes");';
			
			$STRING .=' 
			so.addVariable("videoWidth","'.$w.'");
			so.addVariable("videoHeight","'.$h.'");';	
					
			$STRING .='
			so.addVariable("videoDefaultQuality","high");
			so.addParam("videoSmoothness", "yes");';
			 
			$STRING .='so.addVariable("videoAutoStart","'.$vd['autostart'].'");';		 
			 
			$STRING .= 'so.addVariable("videoPath","'.get_option('imagestorage_link').$vd['filename'].'");';			 						 
			
			$STRING .= 'so.addVariable("reflection","no"); 
			so.write("flashvideo");
		</script></div>';
	
	
	
	
	}elseif($vd['type'] == "youtube" && isset($vd['youtube-embedded'])){
	
		if(isset($GLOBALS['nosidebar1']) || isset($GLOBALS['nosidebar2'])){
		 
		echo wpautop(stripslashes(str_replace("640","670",str_replace("385","370",$vd['youtube-embedded']))));	
		
		}elseif(isset($GLOBALS['nosidebar3'])){
		
		echo wpautop(stripslashes(str_replace("640","540",str_replace("385","304",$vd['youtube-embedded']))));
		
		}else{
		
		echo wpautop(stripslashes(str_replace("640","970",str_replace("385","523",$vd['youtube-embedded']))));
		
		}	
	}
 
	}elseif($item == "hometext"){
	
		$STRING = "<div class='entry article'>".wpautop(stripslashes(get_option("ppt_homepage_html")))."</div>";
	
	}elseif($item == "widget"){
	
		$thisOne = get_option("ppt_object_widget_bar");
	
		if(strlen($thisOne) > 1){ dynamic_sidebar($thisOne); }	
	
	}elseif($item == "categories"){
		
	// COMPACT OR FULL VIEW ADDED IN V7.0.6
	$DISPLAYTYPE = get_option("display_homecats_type");
	if($DISPLAYTYPE == "full"){ $idm = "homeCategories"; }else{ $idm = "homeCompactCategories"; }
	
	$STRING = '<div class="clearfix"></div><div class="itembox '.$css.'"><h2 class="title">'.get_option("display_homecats_title").'</h2><div class="itemboxinner greybg" id="'.$idm.'">
	<div class="innerwrapper">'.$this->HomeCategories().'<div class="clearfix"></div></div></div></div>';
	
	
	
	
	
	}elseif($item == "2columns"){ 
	
	
		$STRING = '<div class="full"> <!-- two columns -->

					<div class="f_half left">'.do_shortcode(wpautop(stripslashes(get_option("ppt_object_2columns_1")))).'</div>

					<div class="f_half left">'.do_shortcode(wpautop(stripslashes(get_option("ppt_object_2columns_2")))).'</div>

		</div>';
	
	
	}elseif($item == "recent" ||  $item == "chosenlisting"){ 
	
		$STRING = "";
	
		
		if($item == "recent"){
		
			$BOXTITLE = get_option("ppt_object_recent_title");
			
		}else{
		
			$BOXTITLE = get_option("ppt_object_chosenlisting_title");
			
			$GLOBALS['query_string_new'] = array('post__in' => explode(",",get_option('ppt_object_chosenlisting_ids')));
		
		}
	
	if(get_option("ppt_object_recent_type") =="2" || get_option("ppt_object_recent_type") =="3" || $item == "chosenlisting"){
	
	
			if($item == "recent"){
		
				if(get_option("ppt_object_recent_type") =="2"){
			
					$GLOBALS['query_string_new'] = "orderby=ID&order=desc"; //&posts_per_page=".get_option('ppt_object_recent_num'); 
					$GLOBALS['galleryblockstop']=3;
				 
					
				}else{
					$GLOBALS['query_string_new'] = get_option('ppt_object_recent_custom');//"&posts_per_page=".get_option('ppt_object_recent_num'); 
				}
			
			}else{
			
				$GLOBALS['query_string_new'] = array('post__in' => explode(",",get_option('ppt_object_chosenlisting_ids')));
			
			}
		 
			
		
		
		
		
		if(isset($GLOBALS['nosidebar0'])){ $GLOBALS['galleryblockstop'] = 4; }
		 
	 
 
		switch(strtolower(PREMIUMPRESS_SYSTEM)){


 		case "comparisonpress":
		case "auctionpress": {
		
			$GLOBALS['setflag_faq'] = true;
		
			//echo  '<div class="itembox">';
			
			//echo '<div class="itemboxinner">';
						
			echo  '<div id="AJAXRESULTS"></div><div id="SearchContent">'; 	
			echo  '<h1 class="title" id="home-recentadded">'.$BOXTITLE.'</h1><div class="clearfix"></div>';	
			echo  '<a href="#" class="switch_thumb">'.$PPT->_e(array('gallerypage','9')).'</a><div class="clearfix"></div><ul class="display thumb_view">';		
			echo  $this->GALLERYBLOCK();
			echo  '</ul><div class="clearfix"></div></div><div class="clearfix"></div>';
			
			//echo  '</div>';	
			//echo  '</div>';	
					
			if($item != "chosenlisting"){ echo  '<div class="clearfix"></div>
			//<ul class="pagination paginationD paginationD10">'.$this->PageNavigation().'</ul><br /><div class="clearfix"></div>'; }
		
		return;
		
		} break;	

		case "shopperpress": { 
		
			echo  '<div id="AJAXRESULTS"></div><div class="itembox">';
			echo  '<h1 id="home-recentadded" class="title">'.$BOXTITLE.'</h1><div class="clearfix"></div>';
			echo '<div class="itemboxinner">';
						
			echo  '<div id="SearchContent">'; 		
			echo  '<a href="#" class="switch_thumb">'.$PPT->_e(array('gallerypage','9')).'</a><div class="clearfix"></div><ul class="display thumb_view">';		
			echo  $this->GALLERYBLOCK();
			echo  '</ul><div class="clearfix"></div></div>';
			
			echo  '</div>';	
			echo  '</div>';	
					
			//echo  '<div class="clearfix"></div>
			//<ul class="pagination paginationD paginationD10">'.$this->PageNavigation().'</ul><br />';
		
		return;	
	
		} break;
		
		case "employeepress": { 		
		
			echo '<div id="AJAXRESULTS"></div><div class="itembox">';
			echo '<h1 id="home-recentadded" class="title">'.$BOXTITLE.'</h1>';
			echo '<div class="itemboxinner nopadding">';
			echo '<ol class="list">';
			echo  $this->GALLERYBLOCK();
			echo '</ol>';			
			if($item != "chosenlisting"){ echo  '<ul class="pagination paginationD paginationD10">'.$this->PageNavigation().'</ul><br />';	 }
			echo  '</div>';
			echo  '</div>';
			
			return;
		
		} break;
		
		
		case "couponpress": {
		
			echo '<div id="AJAXRESULTS"></div><div class="itembox">';
			echo '<h1 id="home-recentadded" class="title">'.$BOXTITLE.'</h1>';
			echo '<div class="itemboxinner nopadding">';
			echo '<div id="VoteResult"></div><ul class="couponlist">';
			echo  $this->GALLERYBLOCK();
			echo '</ul></div></div>';			
			//if($item != "chosenlisting"){ echo  '<ul class="pagination paginationD paginationD10">'.$this->PageNavigation().'</ul><br />';	}
			
			return;
			
		} break;
		
		case "dealspress":  $GLOBALS['galleryblockstop']=3;
		case "moviepress": 
		case "realtorpress": 
		case "classifiedstheme": 
		case "directorypress": {
		
			if(get_option('display_liststyle') == "gal"){ $df= "three_columns"; }else{ $df= "list_style"; }
			
			echo '<div id="AJAXRESULTS"></div><div class="itembox">';
			echo '<h2 id="home-recentadded" class="title">'.$BOXTITLE.'</h2>';
			echo '<div class="itemboxinner nopadding" id="PPTGalleryPage"><div class="'.$PPTDesign->CSS("columns",true).'">';
			echo '<ul class="items '.$df.'" id="itemsbox">';
			echo  $this->GALLERYBLOCK();
			echo '</ul></div></div>';
			//if($item != "chosenlisting"){ echo  '<div class="enditembox inner"><ul class="pagination paginationD paginationD10">'.$this->PageNavigation().'</ul></div>'; }
			echo'<div class="clearfix"></div></div>';			
				
			
			return;
			
		} break;
		
		 
		
		default: {
		
			echo  '<h2 id="home-recentadded" class="title">'.$BOXTITLE.'</h2>';
			echo  $this->GALLERYBLOCK();
			if($item != "chosenlisting"){ echo  '<ul class="pagination paginationD paginationD10">'.$this->PageNavigation().'</ul><br />'; }
			return;			
		}		
		
		
		} 
		
		
				
	}else{
	
	//$cq = get_option('ppt_object_recent_custom');
	//if(strlen($cq) > 3){
	//$postslist = query_posts(get_option('ppt_object_recent_custom')."&posts_per_page=".get_option('ppt_object_recent_num')); 
	//}else{
	$postslist = query_posts('order=DESC&orderby=modified&posts_per_page='.get_option("ppt_object_recent_num").'&post_type=post'); 
	//} 
 

	echo '<div class="clearfix"></div><div class="itembox '.$css.'"><h2 id="home-recentadded" class="title">'.$BOXTITLE.'</h2> <div class="itemboxinner nopadding clearfix" id="homeFeaturedList"><ul class="display">';					
	
		foreach ($postslist as $loopID => $post){
			
			if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress"){ 
			
			if(isset($GLOBALS['query_file'])){ $Loadfile = $GLOBALS['query_file']; }else{  $Loadfile = '_item.php'; }
						
			if(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/'.$Loadfile)){
							
				include(str_replace("functions/","",THEME_PATH)."/themes/".$GLOBALS['premiumpress']['theme'].'/'.$Loadfile);
							
			}else{
						
				include(TEMPLATEPATH ."/template_".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/".$Loadfile); 
						
			}
			
			}else{
		
			echo'<li>'.premiumpress_image($post->ID,"",array('link' => true,'alt' => $post->post_title, 'width' => '100', 'height' => '100', 'style' => 'auto' )).'			 
			<h3><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h3><p>'.strip_tags($post->post_excerpt).'</p>
			</li>'; 
			
			}
		}    
	echo '</ul></div></div>'; 
	
	} 
	
	
	

}elseif($item == "carousel"){

	$query = get_option('ppt_object_carousel_query'); 
	if(isset($GLOBALS['nosidebar-right']) && isset($GLOBALS['nosidebar-left'])){ $ThisStyle =1; }elseif(!isset($GLOBALS['nosidebar-right']) && !isset($GLOBALS['nosidebar-left'])){ $ThisStyle =3; }else{ $ThisStyle =2; }
	
	
	if($query ==  1){
	$ThisQuery = 'meta_key=featured&meta_value=yes&orderby=rand&posts_per_page=25';
	}elseif($query ==  2){
	$ThisQuery = 'posts_per_page=25&orderby=comments&order=desc';
	}else{
	$ThisQuery = get_option("ppt_object_carousel_custom");
	}
	
	// RUN NEW QUERY
 
	$foundposts = new WP_Query( $ThisQuery );	
 
 	if(!empty($foundposts->posts)){
	
	if(get_option("ppt_object_carousel_query_padding") == "1"){ $sty = ""; }else{ $sty = "style='margin-top:0px;'"; }
	
  	$STRING .= '<div id="style'.$ThisStyle.'_wrapper" '.$sty.'><div id="style'.$ThisStyle.'" class="style'.$ThisStyle.'"><div class="previous_button"></div><div class="container"><ul>'; 
		 
		foreach ($foundposts->posts as $post ){ 
		  
			$STRING .= '<li>
			'.premiumpress_image($post->ID,"",array('alt' => $post->post_title,  'link' => true, 'width' => '120', 'height' => '100', 'style' => 'auto' )).'
			<div>'.$post->post_title.'<br />';
			
			if(strtolower(PREMIUMPRESS_SYSTEM) != "directorypress" && strtolower(PREMIUMPRESS_SYSTEM) != "auctionpress" && strtolower(PREMIUMPRESS_SYSTEM) != "couponpress"){ 			
			$price = get_post_meta($post->ID, "price", true);
			if($price != ""){
			$STRING .= '<em class="price">'.premiumpress_price(get_post_meta($post->ID, "price", true),$GLOBALS['premiumpress']['currency_symbol'],$GLOBALS['premiumpress']['currency_position'],1).'</em>';
			}
			}
			 $STRING .= '</div>
			</li>';
		
		 }  

	$STRING .= '</ul></div><div class="next_button"></div></div></div><div class="clearfix"></div>';
	
	$STRING .= '<script src="'.PPT_PATH.'js/jquery.jcarousel.pack.js" type="text/javascript"></script>';
	$STRING .= '<script src="'.PPT_PATH.'js/jquery.jcarousellite_1.0.1.js" type="text/javascript"></script>';
	$STRING .= '<script type="text/javascript">jQuery(function() {    jQuery(".style'.$ThisStyle.'").jCarouselLite({        btnNext: ".next_button",        btnPrev: ".previous_button",		visible:4,		scroll: 1, auto:2000 }); });</script>';
	
	}	

}elseif($item == "authorinfo"){

if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){ return; }

global $userdata, $post;

	// CLAMI LISTING OPTIONS
	 
	if(isset($GLOBALS['claim_email']) && $GLOBALS['claim_email'] !=""  && $post->post_author == 1 ){  
 
     
	}else{ 

		$STRING = '<div class="itembox" id="listinginformation"><h2 class="title">'.$PPT->_e(array('add','52')).'</h2><div class="itemboxinner greybg"> ';    

		$STRING .='<div id="authorphoto"><a href="'.get_author_posts_url( $GLOBALS['authorID'], get_the_author_meta( 'user_nicename', $GLOBALS['authorID']) ).'">';
		
		// GET USER PHOTO
        $img = get_user_meta($GLOBALS['authorID'], "pptuserphoto",true);
		if($img == ""){
			$img = get_avatar($GLOBALS['authorID'],52);
		}else{
			$img = "<img src='".get_option('imagestorage_link').$img."' class='photo frame' alt='user ".$GLOBALS['authorID']."' />";
		}
			
		$STRING .= $img; 		
        $STRING .='</a></div>';
 		$STRING .='<h3>'.get_the_author_meta( 'display_name', $GLOBALS['authorID']).'</h3>';
		
		$date_format = get_option('date_format') . ' ' . get_option('time_format');
		$date = mysql2date($date_format, $post->post_date, false);
 
		$STRING .= get_the_author_meta( 'description', $GLOBALS['authorID']);
 			
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = ".$GLOBALS['authorID']." AND post_type IN ('post') and post_status = 'publish'" );
		
		$STRING .='</p><div class="full"><p><img src="'.IMAGE_PATH.'icon1.png" alt="send email" align="middle" /> <a href="'.get_author_posts_url( $GLOBALS['authorID'], get_the_author_meta( 'user_nicename', $GLOBALS['authorID']) ).'">
		'.str_replace("%a",get_the_author_meta( 'display_name', $GLOBALS['authorID']),str_replace("%b",$count,$PPT->_e(array('author','2')))).'</a></p>
        <p><img src="'.IMAGE_PATH.'icon2.png" alt="send email" align="middle" /> <a href="'.get_option("messages_url").'?u='.get_the_author_meta( 'user_nicename', $GLOBALS['authorID']).'" rel="nofollow">'.str_replace("%a",get_the_author_meta( 'display_name', $GLOBALS['authorID']),$PPT->_e(array('author','1'))).'</a></p>
        </div><em>'.$date.'</em></div></div>';
		
		
		// HOOK INTO IT
		$STRING = premiumpress_author_listinginformation($STRING);
        
    }



}elseif($item == "mapme"){  if(isset($GLOBALS['nosidebar1']) || isset($GLOBALS['nosidebar2'])){ $w = 670; $h = 370; }elseif(isset($GLOBALS['nosidebar3'])){ $w = 540; $h = 304; }else{ $w = 940; $h = 518;  }

 
wp_reset_query();
$postslist = query_posts(get_option('ppt_object_map_query')); 
 
if(empty($postslist)){
wp_reset_query();
echo "<h2>Admin..! No results for your Google map query were found.</h2><p>".get_option('ppt_object_map_query')."</p>";
return;

}else{

?>

 
<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script> 
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.9/src/infobox_packed.js" type="text/javascript"></script>	
<style type="text/css">	#ppt-object-map { height:<?php echo $h; ?>px; width:<?php echo $w; ?>px; }</style> 	
<script type="text/javascript">
function initialize() {
  var myOptions = {   zoom: <?php echo get_option("ppt_object_map_zoom"); ?>,   center: new google.maps.LatLng(-33.9, 151.2),    mapTypeId: google.maps.MapTypeId.ROADMAP  }
  var map = new google.maps.Map(document.getElementById("ppt-object-map"), myOptions);  setMarkers(map, featuredlistings);
}

var featuredlistings = [
<?php 

if(!empty($postslist)){  $i=1; 
foreach($postslist as $post){ 

$map = trim(strip_tags((get_post_meta($post->ID, 'map_location', true))));
if(strlen($map) > 5){

echo "['".addslashes(str_replace("-"," ",str_replace("'","",$post->post_title))).premiumpress_image($post->ID,"",array('link' => true, 'width' => '120', 'height' => '100', 'style' => 'auto' ))."', '".addslashes(str_replace("-"," ",str_replace("'","",get_post_meta($post->ID, 'map_location', true))))."', ".$i."],"; $i++; } } }
?>
 
];

function setMarkers(map, locations) {

for (var i = 0; i < locations.length; i++) {

    var featuredlistings = locations[i];
 
  	DrawIcon(map,featuredlistings);
  }
}

function DrawIcon(map,featuredlistings){ 

var image = new google.maps.MarkerImage('<?php echo PPT_FW_JS_URI; ?>/map/icon.png',
new google.maps.Size(20, 32),
new google.maps.Point(0,0),
new google.maps.Point(0, 32));
var shadow = new google.maps.MarkerImage('<?php echo PPT_FW_JS_URI; ?>/map/shadow.png',
new google.maps.Size(37, 32),
new google.maps.Point(0,0),
new google.maps.Point(0, 32));
var image      = "<?php echo PPT_FW_JS_URI; ?>map/icon.png";
var shadow     = "<?php echo PPT_FW_JS_URI; ?>map/shadow.png";
var shape = {
      coord: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
};


	geocoder = new google.maps.Geocoder();		
	geocoder.geocode( { 'address': featuredlistings[1] }, function(results, status) {
	if (status == google.maps.GeocoderStatus.OK) { 
	 
			map.setCenter(results[0].geometry.location);
			
			var marker = new google.maps.Marker({
				shadow: shadow,
				icon: image,
				map: map,
				position: results[0].geometry.location,		 	 
			
			});
			
	var boxText = document.createElement("div");	
	if(featuredlistings[0].length > 20){
			var maph = -80;
			var mapw = -180	
			boxText.style.cssText = "margin-top: 8px; background: #000000; padding: 5px; -moz-border-radius: 3px; border-radius: 3px; font-size:12px; font-weight:bold; color:#fff; padding-bottom:10px;";
	} else{
			var maph = -80;
			var mapw = -70	
			boxText.style.cssText = "margin-top: 8px; background: #000000; padding: 5px; -moz-border-radius: 3px; border-radius: 3px; font-size:12px; font-weight:bold; color:#fff;";
	}
	
 	 
		boxText.innerHTML = "<div class='map_container'>"+featuredlistings[0]+"</div>";

		var myOptions = {
			 content: boxText
			,disableAutoPan: false
			,maxWidth: 0
			,pixelOffset: new google.maps.Size(maph, mapw)
			,zIndex: null
			,boxStyle: { 			 
			  opacity: 0.8
			  ,width: "160px"
			 }
			,closeBoxMargin: ""
			,closeBoxURL: ""
			,infoBoxClearance: new google.maps.Size(1, 1)
			,isHidden: false
			,pane: "floatPane"
			,enableEventPropagation: false
		};

		google.maps.event.addListener(marker, "click", function (e) {
			ib.open(map, this);
		});

		var ib = new InfoBox(myOptions);
		ib.open(map, marker);
		
		
		
	} else {
			alert("Geocode was not successful for the following reason: " + status);
		 }
	});

}


jQuery(document).ready(function() {
      initialize();
});
</script>
  
  <div id="ppt-object-map"></div> 

   <?php  
}
}
 wp_reset_query();
 
return $STRING;


} 

/* =============================================================================
   RECIEVES THE CUSTOM KEY NAME FROM FIELDDATA // V7 // MARCH 16TH
   ========================================================================== */

function GL_CustomKeyName($name=""){
	$FieldValues = get_option("customfielddata");	
	foreach($FieldValues as $key => $field){
		if($name == $field['key']){
			return $field['name'];
		}
	} 
}

/* =============================================================================
  PAGE NAVIGATION FUNCTION // V7 / MARCH 16TH
   ========================================================================== */

function PageNavigation($return="",$title="") {


	global $wpdb, $wp_query, $PPT;
	$return="";
	
	if (!is_single()) {
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
	
		$pagenavi_options['pages_text'] = $PPT->_e(array('gallerypage','6'));
		$pagenavi_options['current_text'] = "%PAGE_NUMBER%";
		$pagenavi_options['page_text'] = "%PAGE_NUMBER%";
		$pagenavi_options['first_text'] = $PPT->_e(array('gallerypage','7'));
		$pagenavi_options['last_text'] = $PPT->_e(array('gallerypage','8'));
		$pagenavi_options['prev_text'] = "<<";//"";
		$pagenavi_options['next_text'] = ">>";//"";
		$pagenavi_options['dotleft_text'] = "";
		$pagenavi_options['dotright_text'] = "";
		$pagenavi_options['num_pages'] = "2";
		$pagenavi_options['num_larger_page_numbers'] = "3";
		$pagenavi_options['larger_page_numbers_multiple'] = "10";
		$pagenavi_options['always_show'] = "0";
		
 		 
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		
		$pages_to_show = intval(5);
		$larger_page_to_show = intval(1);
		$larger_page_multiple = intval(1);
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		$larger_per_page = $larger_page_to_show*$larger_page_multiple;
		$larger_start_page_start = ($this->n_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
		$larger_start_page_end = $this->n_round($start_page, 10) + $larger_page_multiple;
		$larger_end_page_start = $this->n_round($end_page, 10) + $larger_page_multiple;
		$larger_end_page_end = $this->n_round($end_page, 10) + ($larger_per_page);
		if($larger_start_page_end - $larger_page_multiple == $start_page) {
			$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
			$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		if($larger_start_page_start <= 0) {
			$larger_start_page_start = $larger_page_multiple;
		}
		if($larger_start_page_end > $max_page) {
			$larger_start_page_end = $max_page;
		}
		if($larger_end_page_end > $max_page) {
			$larger_end_page_end = $max_page;
		}
		if($max_page > 1 || intval(1) == 1) {
		
		if($max_page == 0 && $paged > 0){ $max_page=1; }
			$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
			$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);	

if($title){ return $pages_text; }
					if(!empty($pages_text)) {
						$return .= '<li><a class="pages">'.$pages_text.'</a></li>';
					}
					if ($start_page >= 2 && $pages_to_show < $max_page) {
					
						$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
						
						if($paged > 1 && $paged < $max_page){
						
						$return .= '<li><a href="'.esc_url(get_pagenum_link($paged-5)).'" class="first"><<</a></li>';
						
						}
						
						if(!empty($pagenavi_options['dotleft_text'])) {
							//$return .= '<span class="extend">'.$pagenavi_options['dotleft_text'].'</span>';
						}
					}
				 
					//previous_posts_link($pagenavi_options['prev_text']);
					for($i = $start_page; $i  <= $end_page; $i++) {						
						if($i == $paged) {
							$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
							$return .= '<li><a class="current">'.$current_page_text.'</a></li>';
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
							$return .= '<li><a href="'.esc_url(get_pagenum_link($i)).'" class="page">'.$page_text.'</a></li>';
						}
					}
					 
			 
						if($paged > 0 && $paged+3 < $max_page){
						
						$return .= '<li><a href="'.esc_url(get_pagenum_link($paged+5)).'" class="first">>></a></li>';
						
						}
			
			
		}
	}
	
	
	if($return){
	return $return;
	}else{
	echo $return;
	}
}
function n_round($num, $tonearest) {  return floor($num/$tonearest)*$tonearest;}
 

	
} // end class file :(

?>