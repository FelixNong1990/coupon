<?php
/*
Template Name: [My Account Template]
*/
/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 

global  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars 

$wpdb->hide_errors(); premiumpress_authorize(); nocache_headers();

$GLOBALS['IS_MYACCOUNT']	= true;
$GLOBALS['RETURNPHOTO']		= true;

/* =========================================== */ 
 
if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress" && get_user_meta($userdata->ID, 'aim', true) == ""){ 
	$sc = get_option('auction_startbalance'); 
	if(!is_numeric($sc)){$sc=0; }
 	mysql_query("UPDATE $wpdb->usermeta SET meta_value=".$sc." WHERE meta_key='aim' AND user_id='".PPTCLEAN($userdata->ID)."' LIMIT 1"); 
	 
}

// PACKAGE ACCESS
if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){
$GLOBALS['membershipID'] 		= get_user_meta($userdata->ID, 'pptmembership_level', true);
$GLOBALS['membershipStatus'] 	= get_user_meta($userdata->ID, 'pptmembership_status', true);
$GLOBALS['membershipData'] 		= get_option('ppt_membership'); 
}
 

/* =============================================================================
   ACTIONS // 
   ========================================================================== */ 
 
if(isset($_POST['action'])){ $_GET['action'] = $_POST['action']; }
if(isset($_GET['action']) && $_GET['action'] != ""){

	if($_GET['action'] == "revert" ){
	
		// SET OLD PACKAGE
		update_user_meta($userdata->ID, "pptmembership_level", get_user_meta($userdata->ID, "pptmembership_old_level", true));				
		update_user_meta($userdata->ID, "pptmembership_expires", get_user_meta($userdata->ID, "pptmembership_old_expires", true));
		update_user_meta($userdata->ID, "pptmembership_datestarted", get_user_meta($userdata->ID, "pptmembership_old_datestarted", true));
		update_user_meta($userdata->ID, "pptmembership_status", "ok");
		$GLOBALS['membershipStatus'] 	= "ok";
		$GLOBALS['membershipID'] = get_user_meta($userdata->ID, "pptmembership_old_level", true);
	
	}elseif($_GET['action'] == "upgrademe" ){
	
	  	// GET PACKAGE DURATION
		$duration = "1000"; // default
		foreach($GLOBALS['membershipData']['package'] as $package){	
		 
			if($package['ID'] == $_POST['newselpack'] ){ // && $package['duration'] !=""
				$duration = $package['duration'];
				$price = $package['price'];
			}		
		}
		//die($price."<--".$package['ID'].$_POST['newselpack']);
		// IS THIS FREE???
		if($price == "" || $price == 0){
		update_user_meta($userdata->ID, "pptmembership_status", "ok");
		}else{
		update_user_meta($userdata->ID, "pptmembership_status", "pending");
		}
	 

		// SET OLD PACKAGE
		update_user_meta($userdata->ID, "pptmembership_old_level", get_user_meta($userdata->ID, "pptmembership_level", true));				
		update_user_meta($userdata->ID, "pptmembership_old_expires", get_user_meta($userdata->ID, "pptmembership_expires", true));
		update_user_meta($userdata->ID, "pptmembership_old_datestarted", get_user_meta($userdata->ID, "pptmembership_datestarted", true));
			 
		// SET PACKAGE
		update_user_meta($userdata->ID, "pptmembership_level", $_POST['newselpack']);				
		update_user_meta($userdata->ID, "pptmembership_expires", date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$duration." days")));
		update_user_meta($userdata->ID, "pptmembership_datestarted", date("Y-m-d H:i:s"));
		
		// ASK FOR PAYMENT
		$GLOBALS['membershipID'] 		= $_POST['newselpack'];
		$GLOBALS['membershipStatus'] 	= "pending";
 
	}elseif($_GET['action'] == "updateprofile"){ 

		$GLOBALS['premiumpress']['language'] = get_option("language");
		$PPT->Language();
 

		require_once(ABSPATH . 'wp-admin/includes/user.php');
		require_once(ABSPATH . WPINC . '/registration.php');
		 
		if(isset($_POST['form']['state']) && strlen($_POST['form']['state']) > 0) { $_POST['address']['state'] = $_POST['form']['state']; }
		
		 
		$_POST['form']['ID'] 		= $userdata->ID;
		$_POST['form']['jabber']  	= $_POST['address']['country']."**";
		$_POST['form']['jabber'] 	.= $_POST['address']['state']."**";
		$_POST['form']['jabber'] 	.= $_POST['address']['address']."**";
		$_POST['form']['jabber'] 	.= $_POST['address']['city']."**";
		$_POST['form']['jabber'] 	.= $_POST['address']['zip']."**";
		$_POST['form']['jabber'] 	.= $_POST['address']['phone'];

		if( ( $_POST['password'] == $_POST['password_r'] ) && $_POST['password'] !=""){
			$_POST['form']['user_pass'] = $_POST['password'] ;
		}
		
		$data = premiumpress_account_details_filter($_POST); /* HOOK  - FILTER */ 
			
		wp_update_user( $data['form'] );
		
		// SAVE THE CUSTOM PROFILE DATA // V7
		if(isset($_POST['custom']) && is_array($_POST['custom'])){
			$i=1;
			 
			foreach($_POST['custom'] as $key=>$val){
				// SAVE DATA	
				
				update_user_meta($userdata->ID, strip_tags($key), esc_html(strip_tags($val)));
						
			$i++;	
			}
		}
		
		// USER PHOTO
		if(isset($_POST['pptuserphoto']) && strlen($_POST['pptuserphoto']) > ""){	
		
			// CHECK AND RENAME THE IMAGE FILE
			
			//CHECK FILE EXISTS
			if( substr($_POST['pptuserphoto'],0,7) == "unknown" && file_exists(get_option('imagestorage_path').strip_tags($_POST['pptuserphoto']) ) ){
				
				$STORAGEPATH = get_option('imagestorage_path');	
				
				// IF THERE IS AN EXISTING ONE, LETS DELETE IT TO CLEAN UP FILES
				$existing_image_file = get_user_meta($userdata->ID, "pptuserphoto",true);
				@unlink($STORAGEPATH.$existing_image_file);
							
				// GET FILE PREFIX
				$bits = explode(".",strip_tags($_POST['pptuserphoto']));$prefix = $bits[1]; if(isset($bits[2])){ $prefix = $bits[2]; }	
				$NewName =  "profile-".$userdata->ID."-".date("Y-m-d").".".$prefix;
				rename ($STORAGEPATH.strip_tags($_POST['pptuserphoto']), $STORAGEPATH.$NewName);
				 
				// NOW LETS SAVE THE NEW ONE	
				update_user_meta($userdata->ID, "pptuserphoto", $NewName );
			}
			 
			
			
		}else{
			update_user_meta($userdata->ID, "pptuserphoto", "" );
		}
		
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "success";
		$GLOBALS['error_msg'] 	= $PPT->_e(array('myaccount','31'));
		
	}
 
}
$userdata = get_userdata( $userdata->ID );
$ADD = explode("**",get_user_meta($userdata->ID, 'jabber', true)); 



/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("myaccount"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_tpl_myaccount.php")){
		
		include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_tpl_myaccount.php');
		
}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_tpl_myaccount.php")){
		
		include(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_tpl_myaccount.php");
			
}else{

/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
// REGISTER COLOURBOX
wp_register_script( 'colorbox',  get_template_directory_uri() .'/PPT/js/jquery.colorbox-min.js');
wp_enqueue_script( 'colorbox' );

wp_register_style( 'colorbox',  get_template_directory_uri() .'/PPT/css/css.colorbox.css');
wp_enqueue_style( 'colorbox' );

// GET USER PHOTO
$img = get_user_meta($userdata->ID, "pptuserphoto",true);
if($img == ""){
	$img = get_avatar($userdata->ID,52);
}else{
	$img = "<img src='".get_option('imagestorage_link').$img."' class='photo pptphoto' alt='user ".$userdata->ID."' />";
}

get_header(); 
 
// CUSTOM ADMIN MESSG FOR USER 
if(strlen(get_user_meta($userdata->ID, 'accountmessage', true)) > 2 ){ ?>

  	<div class="red_box">
    	<div class="red_box_content">        
        	<div align="center"><?php echo get_user_meta($userdata->ID, 'accountmessage', true); ?> </div>       
        <div class="clearfix"></div>
        </div>    
 	</div> 

		 
<?php }

 premiumpress_account_top(); /* HOOK */ ?> 
 
<div id="My" style="display:visible;">
 
<div class="itembox">


    <div id="begin" class="inner">
        
        <div class="right"><?php echo $img; ?></div>
        
        <h3><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/account.png" align="absmiddle" alt="" /> <?php the_title(); ?></h3>
        <br />
        
        <ol class="tabs" style="margin-bottom: -20px;border-bottom:none;">
       
            <li><a href="#tab1"><?php echo $PPT->_e(array('myaccount','1')); ?></a></li>
            
             
            <?php if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(PREMIUMPRESS_SYSTEM) != "agencypress"){ 
			
			// WORDPRESS BUG, NO PROFILE CREATED UNLESS A POST/LISTING IS ASSIGNED TO THE USER
			// SO WE MUST HIDE THE PROFILE LINK IF THEY DONT HAVE A LISTING
				
			$SQL = "SELECT count(*) AS total_num FROM ".$wpdb->prefix."posts  WHERE post_author = '".$userdata->ID."' LIMIT 1";
			$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);	
			$array = mysql_fetch_assoc($result); 
			if($array['total_num']  > 0){			
			?>
            <li id="myprofiletab"><a href="#" onclick="window.location='<?php echo get_author_posts_url( $userdata->ID, get_the_author_meta( 'user_nicename', $userdata->ID) ); ?>'"><?php echo $PPT->_e(array('myaccount','32')); ?></a></li>
            <?php } } ?> 
        </ol>
        
        
                            
    </div>
        
	<div class="itemboxinner clearfix">
    
    <?php 
	
	// DISPLAY CURRENT MEMBERSHIP LEVEL
	if($GLOBALS['membershipID'] !="" && is_numeric($GLOBALS['membershipID']) && $GLOBALS['membershipID'] !="0"){
	$nnewpakarray = array();
	if(is_array($GLOBALS['membershipData']) && isset($GLOBALS['membershipData']['package']) ){ foreach($GLOBALS['membershipData']['package'] as $val){		
		$nnewpakarray[$val['ID']] =  $val['name'];		
	} }
	
	// MAKE EXPIRY DATE
	$EP = get_user_meta($userdata->ID, 'pptmembership_expires', true);
	$date_format = get_option('date_format') . ' ' . get_option('time_format');
	$epdate = mysql2date($date_format,  $EP, false); 
	
	if(strlen($nnewpakarray[$GLOBALS['membershipID']]) > 1){
	?>
 
  	<div class="yellow_box">
    	<div class="yellow_box_content">        
        	<div align="center">
            <p><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/pakicon.png" align="absmiddle" alt="nr" />  <?php echo str_replace("%a", "<b>".strip_tags($nnewpakarray[$GLOBALS['membershipID']])."</b>",$PPT->_e(array('membership','10'))); ?></p> 
            
            <p><?php echo str_replace("%a",$epdate,$PPT->_e(array('membership','3'))); ?></p>
            
            </div> 
                  
        <div class="clearfix"></div>
        </div>    
 	</div> 
       
    <?php } } ?>
    
    
    <div class="full clearfix box"> <br />
    
    <?php if(get_option("display_myaccount_accountdetails") != "no"){ ?>
    
    <p class="f_half left"> 
        <a href="javascript:void(0);" onclick="jQuery('#My').hide(); jQuery('#MyDetails').show()">
        <img src="<?php echo IMAGE_PATH; ?>a1.png" style="float:left; padding-right:20px; margin-top:10px;" />
        <b><?php echo $PPT->_e(array('myaccount','2')); ?></b><br /> <?php echo $PPT->_e(array('myaccount','3')); ?></a>
    </p> 
    
    <?php } ?>
    
 
	<?php if(strlen(get_option("messages_url")) > 1 && get_option("display_myaccount_messages") != "no"){  
	$unread_messages = 0;//$PPT->COUNT_NEW_MESSAGES(); ?>
    <p class="f_half left"> 
        <a href="<?php echo get_option("messages_url"); ?>">
        <img src="<?php echo IMAGE_PATH; ?>a2.png" style="float:left; padding-right:20px; margin-top:10px;" />
        <b><?php echo $PPT->_e(array('myaccount','4')); ?></b><br /><?php echo $PPT->_e(array('myaccount','5')); ?></a>
        <?php if($unread_messages > 0){ ?>
        <br /><b style="color:red;"><?php echo str_replace("%a",$unread_messages,$PPT->_e(array('messages','19'))); ?></b>
        <?php } ?> 
    </p> 
   <?php } ?>
   
    </div>

    <?php if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){ ?>
    
        <div class="full clearfix border_t box" id="submitoptions"> <br />
        
        <?php if(strlen(get_option("manage_url")) > 1){ ?>
        <p class="f_half left"> 
            <a href="<?php echo get_option("manage_url"); ?>">
            <img src="<?php echo IMAGE_PATH; ?>a3.png" style="float:left; padding-right:20px; margin-top:10px;" />
            <b><?php echo $PPT->_e(array('myaccount','6')); ?></b><br /><?php echo $PPT->_e(array('myaccount','7')); ?></a>
        </p>
        <?php } ?>
        <?php if(strlen(get_option("submit_url")) > 1){ ?>
        <p class="f_half left"> 
            <a href="<?php echo get_option('submit_url'); ?>">
            <img src="<?php echo IMAGE_PATH; ?>a5.png" style="float:left; padding-right:20px; margin-top:10px;" />
            <b><?php echo $PPT->_e(array('myaccount','8')); ?></b><br /><?php echo $PPT->_e(array('myaccount','9')); ?></a> 
        </p>
        <?php } ?>
         
        </div> 
    
    <?php } ?> 
    
    <?php if(strtolower(PREMIUMPRESS_SYSTEM) != "moviepress"){ ?>
    <div class="full clearfix border_t box"> <br />
 
 	<?php if(get_option("display_myaccount_fav") != "no"){ ?>
    
    <p class="f_half left"> 
        <a href="<?php echo $GLOBALS['bloginfo_url']; ?>/?s=&pptfavs=yes">
        <img src="<?php echo get_template_directory_uri(); ?>/PPT/img/fav.png" style="float:left; padding-right:20px; margin-top:10px;" />
        <b><?php echo $PPT->_e(array('myaccount','35')); ?></b><br /><?php echo $PPT->_e(array('myaccount','36')); ?></a>
    </p>
    
    <?php } ?>
 
 	<?php if(get_option("display_myaccount_purchasehistory") != "no"){ ?>
        
    <p class="f_half left"> 
        <a  href="javascript:void(0);" onclick="jQuery('#My').hide(); jQuery('#MyOrders').show()">
        <img src="<?php echo get_template_directory_uri(); ?>/PPT/img/orders.png" style="float:left; padding-right:20px; margin-top:10px;" />
        <b><?php echo $PPT->_e(array('myaccount','37')); ?></b><br /><?php echo $PPT->_e(array('myaccount','38')); ?></a> 
    </p>
    
    <?php } ?>
      
    </div>
    <?php } ?>
    
       

    
    <?php premiumpress_account_options(); /* HOOK */ ?>  
   
    <?php 
 
	// DISPLAY UPGRADE OPTIONS
	if($GLOBALS['membershipData']['show_myaccount'] == "yes"){ 
	
	// GET OPTIONS DATA
	$mdata = $PPTDesign->Memberships($GLOBALS['membershipID']);  
	
	
	if(strpos($mdata, "</div>") !== false){ ?>
    
    
    <h3><?php echo $PPT->_e(array('membership','9')); ?></h3>
    <hr />
    
    <?php echo $mdata; ?> 
    
    <?php }// end if 
	
	}// end if ?>
         
     
    </div><!-- end inner box -->
        
		<!-- start buttons -->
        <div class="enditembox inner"> 
                
      		<a class="button gray right" href="<?php echo wp_logout_url(); ?>"><?php echo $PPT->_e(array('button','5')); ?> <img src="<?php echo get_template_directory_uri(); ?>/PPT/img/button/power.png" /></a> 
          
        </div>
        <!-- end buttons --> 
    
    </div> <!-- end item box -->
    
</div><!-- end layer -->

























<div id="MyDetails" style="display:none;">

<form action="" method="post" enctype="multipart/form-data" name="SUBMITFORM" id="SUBMITFORM" onsubmit="return CheckFormData();"> 
<input type="hidden" name="action" value="updateprofile" />

<?php if(isset($ADD[0])){ ?>
<script type="text/javascript"> jQuery(document).ready(function() { PremiumPressChangeStateMyAccount('<?php echo $ADD[0]; ?>', '<?php echo $ADD[1]; ?>');  }); </script>
<?php } ?>
        
<div class="itembox">
    
    <div id="begin" class="inner">
        
        <h3><img src="<?php echo IMAGE_PATH; ?>a1.png" align="absmiddle" alt="" /> <?php echo $PPT->_e(array('myaccount','2')); ?></h3>
        
        <ol class="page_tabs">
        
            <li><a href="#tabMyDetails1"><?php echo $PPT->_e(array('myaccount','22')); ?></a></li>           
            <li><a href="#tabMyDetails2"><?php echo $PPT->_e(array('myaccount','20')); ?></a></li>		
            <li><a href="#tabMyDetails4"><?php echo $PPT->_e(array('myaccount','23')); ?></a></li>
            <li><a href="#tabMyDetails3"><?php echo $PPT->_e(array('myaccount','24')); ?></a></li>           
        
        </ol>
                            
    </div>


	<div class="page_container">

			<div id="tabMyDetails1" class="page_content">
            
            <?php $GLOBALS['titlec']=1; ?>
            
            <h4><span>1</span><?php echo $PPT->_e(array('myaccount','2')); ?></h4><div class="clearfix"></div>
            
              <div class="full clearfix box"> 
                <p class="f_half left"> 
                    <label for="name"><?php echo $PPT->_e(array('myaccount','10')); ?> <span class="required">*</span></label> 
                    <input type="text" name="form[first_name]" id="first_name" value="<?php echo $userdata->first_name; ?>" class="short" tabindex="1" /> 
                   
                </p> 
                <p class="f_half left"> 
                    <label for="email"><?php echo $PPT->_e(array('myaccount','11')); ?> <span class="required">*</span></label> 
                    <input type="text" name="form[last_name]" id="last_name" value="<?php echo $userdata->last_name; ?>" class="short" tabindex="2" /> 
                     
                </p> 
                </div>

							 
                <div class="full clearfix box"> 
                
                <p class="f_half left"> 
                    <label for="email"><?php echo $PPT->_e(array('myaccount','12')); ?> <span class="required">*</span></label> 
                    <input type="text" name="form[user_email]" id="email1" value="<?php echo $userdata->user_email; ?>" class="short" tabindex="3" /> 
                </p> 
                
                <p class="f_half left"> 
                    <label for="name"><?php echo $PPT->_e(array('myaccount','13')); ?></label> 
                    <input type="text" name="form[user_url]" value="<?php echo $userdata->user_url; ?>" class="short" tabindex="4" /> 
                </p> 
                </div> 
                
                <div class="full clearfix box"> 
                
                <p> 
                    <label><?php echo $PPT->_e(array('myaccount','14')); ?></label> 
                    <textarea tabindex="5" class="long" rows="4" name="form[description]"><?php echo $userdata->description; ?></textarea> 
                
                </p> 
                </div>
                
                <div class="clearfix"></div>
                                        
                 <?php $GLOBALS['titlec']++; ?>
            
            	<h4><span>2</span><?php echo $PPT->_e(array('myaccount','17')); ?></h4><div class="clearfix"></div>
            
                
                <div class="full clearfix box"> 
                 
                 
                <p class="f_half left"> 
                    <label for="name"><?php echo $PPT->_e(array('myaccount','16')); ?></label> 
                    <input type="text" name="address[city]" value="<?php echo $ADD[3]; ?>" class="short" tabindex="8" /> 
                 
                </p> 
                <p class="f_half left"> 
                    <label for="email"><?php echo $PPT->_e(array('myaccount','17')); ?></label> 
                    <input type="text" name="address[address]" value="<?php echo $ADD[2]; ?>" class="short" tabindex="9" /> 
                  
                </p> 
                
                <p class="f_half left"> 
                    <label for="name"><?php echo $PPT->_e(array('myaccount','15')); ?></label> 
                 <select name="address[country]" id="country" onchange="PremiumPressChangeState(this.value)" class="short" tabindex="10"> 
                                <?php if(isset($ADD[0])){ ?><option value="<?php echo $ADD[0] ?>"><?php echo $ADD[0] ?></option><?php } ?>               
                                <?php include(str_replace("functions/","",THEME_PATH)."_countrylist.php"); ?>
                 </select>                      
                     
                </p> 
                 
                   
                    <div id="PremiumPressState" ><input type="text" name="address[state]" value="<?php echo $ADD[1]; ?>" class="short" tabindex="11" /></div> 
                 
                    
                  
              
                <p class="f_half left"> 
                    <label for="name"><?php echo $PPT->_e(array('myaccount','18')); ?></label> 
                    <input type="text" name="address[zip]" value="<?php echo $ADD[4]; ?>" class="short" tabindex="12" /> 
                 
                </p> 
                <p class="f_half left"> 
                    <label for="email"><?php echo $PPT->_e(array('myaccount','19')); ?></label> 
                    <input type="text" name="address[phone]" value="<?php echo $ADD[5]; ?>" class="short" tabindex="13" /> 
                 
                </p> 
                </div>
                
                <?php echo $PPTDesign->ProfileFields(); ?>           
                
                
                <?php premiumpress_account_details(); /* HOOK */ ?> 
                
                <div class="clearfix"></div> 

			</div>

			<div id="tabMyDetails2" class="page_content">                     
                     
                    
			<?php 
            
            // GET USER PHOTO
            $img = get_user_meta($userdata->ID, "pptuserphoto",true);
            
            if(strlen($img) > 2){ ?>
                
            <div align="center" id="currentImage">
            <a href="<?php echo get_option('imagestorage_link').$img; ?>" class="lightbox frame" id="myimage"><img src="<?php echo get_option('imagestorage_link').$img; ?>" /></a>
            <input type="hidden" name="pptuserphoto" id="pptuserphoto" value="<?php echo strip_tags($img); ?>">
            </div>	
            <br />
            
			<?php }else{ echo '<div id="currentImage"></div>';} ?>
            
            <div id="pptfiles"></div> <span id="pptstatus"></span>
             
            <div class="green_box"><div class="green_box_content nopadding"> 
            
                <div align="center">
                
                <input type="button" id="pptupload" value="<?php echo $PPT->_e(array('myaccount','41')); ?>" class="button green" /> 
                
               <span id="delImg" <?php if(strlen($img) < 2){ echo "style='display:none'"; } ?>>
                   <a class="button blue" href="javascript:void(0);" onclick="jQuery('#pptuserphoto').val('');jQuery('#myimage').hide();jQuery('#delImg').hide();jQuery('#pptupload').show();">
                    <?php echo $PPT->_e(array('button','3')); ?>
                   </a>
               </span>
                
                </div>     
             
            <div class="clearfix"></div></div></div>   
		            


			</div>
            
            <!-- end image tab -->
            
            
			<div id="tabMyDetails3" class="page_content">

								<p><?php echo $PPT->_e(array('myaccount','25')); ?></p>

								 <div class="full clearfix border_t box"> 

                                <p class="f_half left"> 
                                    <label for="name"><?php echo $PPT->_e(array('myaccount','26')); ?> <span class="required">*</span></label> 
                                    <input type="password" name="password" id="password" class="short" tabindex="20" /> 
                                  
                                </p> 
                                <p class="f_half left"> 
                                    <label for="email"><?php echo $PPT->_e(array('myaccount','27')); ?><span class="required">*</span></label> 
                                    <input type="password" name="password_r" id="rpassword" class="short" tabindex="21" /> 
                                     
                                </p> 
                                </div>

			</div>
            
			<div id="tabMyDetails4" class="page_content">

								 
								<p><?php echo $PPT->_e(array('myaccount','29')); ?></p>

								<div class="full clearfix box">
                                
									<?php echo $PPTDesign->EmailAlters(); ?>                                
                                 
                                </div>

			</div>
  

	</div>  <!-- end tab_container box --> 
        
	 
 
 		<!-- start buttons --><div class="enditembox inner"> 
                
      	<input type="button" onclick="jQuery('#My').show(); jQuery('#MyDetails').hide()" class="button gray right" tabindex="15" value="<?php echo $PPT->_e(array('button','8')); ?>" /> 
        <input type="submit" name="submit" id="submit" class="button green left" tabindex="15" value="<?php echo $PPT->_e(array('button','6')); ?>" /> 
          
         </div> <!-- end buttons --> 
    
    </div><!-- end itembox -->    
</form> 
</div>







<?php if(strtolower(PREMIUMPRESS_SYSTEM) != "moviepress"){ ?>
<div id="MyOrders" style="display:none;">

	<div class="itembox">

    <div id="begin" class="inner">
        
        <h3><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/orders.png" align="absmiddle" alt="" /> <?php echo $PPT->_e(array('myaccount','37')); ?></h3>
        
        <ol class="tabs" style="margin-bottom: -20px;border-bottom:none;">
        
            <li><a href="#tabMyOrders1" class="active"><?php echo $PPT->_e(array('myaccount','37')); ?></a></li>         
 
        </ol>
                            
    </div>

	<div class="itemboxinner">

        <div class="page_container">
                 
            <?php echo $PPTDesign->MYORDERS($userdata->ID); ?>            
                 
        </div>
    
    </div>

	<!-- start buttons -->
    <div class="enditembox inner"> 
                
      	<input type="button" onclick="jQuery('#My').show(); jQuery('#MyOrders').hide()" class="button gray right" tabindex="15" value="<?php echo $PPT->_e(array('button','8')); ?>" /> 
           
    </div>
    <!-- end buttons -->
    
    </div>
    <!-- end itembox --> 

</div>

<!-- end my orders -->
<?php } ?>


<?php 
/*
REMOVED IN 7.1.1 // NOW PART OF THE MAIN SEARCH SYSTEM
<div id="MyFav" style="display:none;">

	<div class="itembox">

    <div id="begin" class="inner">
        
        <h3><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/fav.png" align="absmiddle" alt="my account details" /> <?php echo $PPT->_e(array('myaccount','35')); ?></h3>
        <br />        
                            
    </div>
    
    
        <ol class="tabs" style="margin-top:-43px;margin-left:20px;margin-right:-20px;">
    
        <li><a href="#tabMyFav1"><?php echo $PPT->_e(array('myaccount','35')); ?></a></li>            
        <?php if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){ ?>
        <li><a href="#tabMyFav2"><?php echo $PPT->_e(array('myaccount','39')); ?></a></li>
        <?php } ?>
        
        </ol>

        <div class="tab_container" style="border:0px;">
     
                <div id="tabMyFav1" class="tab_content">
                
                <?php echo $PPTDesign->WishList('wishlist'); ?> 
                
                </div>
                
                <!-- end fav -->
    			<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){ ?>
                <div id="tabMyFav2" class="tab_content">
                
                <?php echo $PPTDesign->WishList('compare'); ?> 
                
                </div>
                <?php } ?>
                <!-- end compare list -->
    
        </div>
        <!-- end tab container -->
        
	<!-- start buttons -->
    <div class="enditembox inner"> 
                
      	<input type="button" onclick="jQuery('#My').show(); jQuery('#MyFav').hide()" class="button gray right" tabindex="15" value="<?php echo $PPT->_e(array('button','8')); ?>" /> 
           
    </div>
    <!-- end buttons -->
    
    </div>
    <!-- end itembox -->	

</div>

<!-- end my fav -->
*/ ?>


<div id="MyPaymentForm" style="display:none;">

<div class="itembox" style="background:none !important;">

<div class="padding">

<h3><?php echo str_replace("%a",strip_tags($nnewpakarray[$GLOBALS['membershipID']]),$PPT->_e(array('membership','4'))); ?></h3>


<p><?php echo $PPT->_e(array('membership','5')); ?></p>
<hr />

<?php

// 1. IF PAYMENT IS PENDING
if($GLOBALS['membershipStatus'] == "pending"){ //pending	
	
 
if(is_array($GLOBALS['membershipData']) && isset($GLOBALS['membershipData']['package']) ){ 
 
 	foreach($GLOBALS['membershipData']['package'] as $val){	
 	
		if($GLOBALS['membershipID'] == $val['ID']){	
	 
		 
			// DATA TO ADD TO THE PAYMENT CALL
			$_POST['orderid'] 			= $userdata->ID."-MEMBERSHIP-".$GLOBALS['membershipID']."-".date("Ymd-H:i:s");
			$_POST['description'] 		= $val['name'];
			$_POST['price']['total'] 	= $val['price'];
			$GLOBALS['subtotal'] 		= $val['price'];
			$GLOBALS['shipping'] 		= 0;  
			$GLOBALS['tax'] 			= 0;
			
			$GLOBALS['freetrialperiod'] = $val['freetrial'];
			 
			if($val['recurring'] == 1){	$_POST['rec'] = 1; $_POST['rec_days'] = $val['duration'];	}
		}	
				
	} 
}

	// SAVE THE ORDER DATA INTO THE ORDERS TABLE
	if($_POST['price']['total'] > 0){
	 
	 	include(TEMPLATEPATH ."/PPT/class/class_payment.php");	
		$PPTPayment	= new PremiumPressTheme_Payment;
					
		$OrderData = "\r\n --------- MEMBER ID: ". $userdata->ID. " ------------- \r\n";
		$OrderData .= "\r\n Package: ".strip_tags($_POST['description']). "\r\n";
		$OrderData .= "\r\n Date: ".date('l jS \of F Y h:i:s A'). "\r\n";
		$OrderData .= "\r\n Price: ".premiumpress_price($_POST['price']['total'],$GLOBALS['premiumpress']['currency_symbol'],$GLOBALS['premiumpress']['currency_position'],1). "\r\n";
		$OrderData .= "\r\n Order ID: ".$_POST['orderid']. "\r\n";
				 
			$GLOBALS['orderData'] = strip_tags($OrderData);			 
			$GLOBALS['orderItems'] = strip_tags($_POST['description']);
			// DATA TO ADD TO THE PAYMENT CALL
			$GLOBALS['total'] 		= $_POST['price']['total'];
			$GLOBALS['subtotal'] 	= 0;
			$GLOBALS['shipping'] 	= 0;  
			$GLOBALS['tax'] 		= 0;
						
			$PPTPayment->InsertOrder("",$_POST['orderid'],0);	
			 
	 }


	// INCLUDE PAYMENT GATEWAYS
	include(str_replace("functions/","",THEME_PATH)."/PPT/func/func_paymentgateways.php");
	
	// HOOK INTO THE PAYMENT GATEWAY ARRAY // V7
	$gatway = premiumpress_admin_payments_gateways($gatway);
	
	 if(is_array($gatway)){
		
		foreach($gatway as $Value){
		
			if(get_option($Value['function']) =="yes" ){ // GATEWAY IS ENABLED 
			
			if( $Value['function'] == "gateway_bank" ){ echo wpautop(get_option('bank_info'));
			
			// NOT BIG FORMS
			}elseif( $Value['function'] != "gateway_paypalpro" && $Value['function'] != "gateway_ewayAPI" && $Value['function'] !="gateway_blank_form"){ 
                
               $STRING .= '<div class="gray_box"><div class="gray_box_content">';
               
			   $STRING .= '<h3 class="left" style="margin-top:2px;">'.get_option($Value['function']."_name").'</h3>'.$Value['function']($_POST).'<div class="clearfix"></div></div></div>'; 
                
         	}else{ 
                
                $STRING .= '<div class="gray_box"><div class="gray_box_content">'.$Value['function']($_POST).'<div class="clearfix"></div></div></div>'; 
                		
			} 
			
			}
		} // end foreach
		
	} // end if
	
	// ADMIN TEST
	 if ( current_user_can('edit_post', $post->ID) ) {  ?>
 
     <p style="padding:6px; color:white;background:red; margin-top:20px;">
     <b>You are only seeing this because you are the admin :)</b> - <br /> <a href="#" onclick="document.AdminTest.submit();" style="color:white;">Click here to skip payment and test callback link.</a> </p>


    <form name="AdminTest" id="AdminTest" action="<?php echo $GLOBALS['bloginfo_url']; ?>/callback/" method="post">
    <input type="hidden" name="custom" value="<?php echo $_POST['orderid']; ?>">
    <input type="hidden" name="payment_status" value="Completed">
    <input type="hidden" name="mc_gross" value="<?php echo $_POST['price']['total']; ?>" />
    </form> 


	<?php }
	
	echo $STRING;

}

?>
</div><!-- end padding -->

	<form action="" method="post">
    <input type="hidden" name="action" value="revert" />
	<!-- start buttons -->
    <div class="enditembox inner"> 
                
      	<input type="submit" class="button gray right" tabindex="15" value="<?php echo $PPT->_e(array('button','8')); ?>" /> 
           
    </div>
	</form> 
    
</div> <!-- end itembox -->

</div>

<!-- end my payment form -->

 

<script type="text/javascript">

jQuery(document).ready(function(){

	<?php if($GLOBALS['membershipStatus'] == "pending"){ ?>
	// HIDE FORMS AND SHOW PAYMENT
	jQuery("#My").hide();
	jQuery("#MyPaymentForm").show();	
	
	<?php } ?>

	// INVOICE
	jQuery(".iframe").colorbox({iframe:true, width:"600px", height:"600px"});
	
	// ORDER DATA
	jQuery(".orderinfo").colorbox({inline:true, width:"600px"});				
	jQuery(".orderinfo").colorbox({
					onOpen:function(){ jQuery('#'+document.getElementById('moreinfodiv').value).show();  },					 
					onClosed:function(){ jQuery('#'+document.getElementById('moreinfodiv').value).hide(); }
	});	
	
	// LIGHTBOX FOR IMAGE POPUP
	jQuery(".lightbox").colorbox();

	
});

</script> 
<script language="javascript" type="text/javascript">
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};
		function CheckFormData()
		{
 
 		
			var name 	= document.getElementById("first_name");
			var lname  = document.getElementById("last_name"); 
			var email1 	= document.getElementById("email1");			
			var pass = document.getElementById("password");
 			var pass1 = document.getElementById("rpassword");
		 
						
			if(name.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','1')); ?>');
				name.style.border = 'thin solid red';
				name.focus();
				return false;
			}
			if(lname.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','2')); ?>');
				lname.style.border = 'thin solid red';
				lname.focus();
				return false;
			}
			
			if(email1.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','3')); ?>');
				email1.style.border = 'thin solid red';
				email1.focus();
				return false;
				
			} else {
			
				if( !isValidEmailAddress( email1.value ) ) {
					alert('<?php echo $PPT->_e(array('validate','3')); ?>');
					email1.style.border = 'thin solid red';
					email1.focus();
					return false;
				}
			}
 		

			if(pass.value != '')
			{
				if(pass.value != pass1.value){
				
				alert('<?php echo $PPT->_e(array('validate','4')); ?>');
				pass.style.border = 'thin solid red';
				pass1.style.border = 'thin solid red';
				pass.focus();
				return false;
				
				}
			} 
			 		
			
			return true;
		}

 
</script>

<script type='text/javascript' src="<?php echo PPT_THEME_URI; ?>/PPT/js/jquery.upload.js"></script>
 
<script type="text/javascript" >
	jQuery(function(){
		var btnUpload=jQuery('#pptupload');
		var status=jQuery('#pptstatus');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $GLOBALS['bloginfo_url']; ?>/index.php',
			name: 'pptfileupload',
			onSubmit: function(file, ext){
				 if (! (ext && /^(gif|jpg|png)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only Image Files (.gif/.png/.jpg)');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				
				if(response==="error"){
					jQuery('<li></li>').appendTo('#pptfiles').text(file).addClass('error');
				} else{
				
					jQuery('#delImg').show();
					jQuery('#currentImage').html('');
					
					var image = '<a href="<?php echo get_option('imagestorage_link'); ?>'+response+'" class="lightbox frame" id="myimage"><img src="<?php echo get_option('imagestorage_link'); ?>'+response+'"></a>';
				
					jQuery('#pptupload').hide();					 			
					jQuery('#pptfiles').html('<div align="center" id="currentImage">'+image+'<input type="hidden" name="pptuserphoto" id="pptuserphoto" value="'+response+'"></div>').addClass('pptsuccess');
				}
			}
		});
		
	});
</script>  

<?php premiumpress_account_bottom(); /* HOOK */ ?>   
 
<?php get_footer(); ?>
	 
<?php } ?>