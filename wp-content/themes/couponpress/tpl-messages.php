<?php
/*
Template Name: [Messages Template]
*/
 
/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
global  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars

$wpdb->hide_errors(); nocache_headers(); premiumpress_authorize();

// ADMIN OPTION // GET CUSTOM WIDTH FOR PAGES
$GLOBALS['page_width'] 	= get_post_meta($post->ID, 'width', true);
if($GLOBALS['page_width'] =="full"){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }

// GET MEMBERSHIP ID SO WE CAN SEE IF THEY ARE ABLE TO SEND MESSAGES
$GLOBALS['canSendMessages']		= true;
$GLOBALS['membershipID'] 		= get_user_meta($userdata->ID, 'pptmembership_level', true);
if(is_numeric($GLOBALS['membershipID']) && $GLOBALS['membershipID'] > 0){

	// CHECK IF WE CAN SEND MESSAGES 
	$GLOBALS['membershipData'] 		= get_option('ppt_membership');
	foreach($GLOBALS['membershipData']['package'] as $package){	
		if($package['ID'] == $GLOBALS['membershipID'] ){ // && $package['duration'] !=""
				if($package['messages'] == "no"){
				 $GLOBALS['canSendMessages'] = false;
				}
			}		
		}
}
 

if(isset($_POST['action'])){

	$GLOBALS['premiumpress']['language'] = get_option("language");
	$PPT->Language();

	if($_POST['action'] == "add"){
	
	$dd = get_userdatabylogin( $_POST['message_name'] );
	
	// ADDED TO FIX HYPEN USERNAMES
	if($dd == ""){
	$dd = get_userdatabylogin( str_replace("-"," ",$_POST['message_name']) );	
	}
 
	if(isset($dd->ID)){
	
		// CHECK HOW MANY MESSAGES HAVE BEEN SENT ALREADY FROM THIS USER
		$SQL = "SELECT count(*) AS total FROM $wpdb->posts WHERE post_type = 'ppt_message' AND post_author = '".$userdata->ID."' AND post_date LIKE ('".date("Y-m-d")."%')";	
		$found = (array)$wpdb->get_results($SQL);
 
		if($found[0]->total < 16){
	 
			$my_post = array();
			$my_post['post_title'] 		= strip_tags(strip_tags($_POST['message_subject']));
			$my_post['post_content'] 	= strip_tags(strip_tags($_POST['message_message']));
			$my_post['post_excerpt'] 	= "";
			$my_post['post_status'] 	= "publish";
			$my_post['post_type'] 		= "ppt_message";
			$my_post['post_author'] 	= $userdata->ID;
			$POSTID 					= wp_insert_post( $my_post );
			
			add_post_meta($POSTID, "username", $_POST['message_name']);	
			add_post_meta($POSTID, "userID", $dd->ID);
			add_post_meta($POSTID, "status", "unread");
		
			$GLOBALS['error'] 		= 1;
			$GLOBALS['error_type'] 	= "success"; //ok,warn,error,info
			$GLOBALS['error_msg'] 	= $PPT->_e(array('messages','17'));
			
			// SEND EMAIL
			$emailID = get_option("email_message_new");					 
			if(is_numeric($emailID) && $emailID != 0){
				SendMemberEmail($dd->ID, $emailID);
			}
		
			
		}else{
		
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= $PPT->_e(array('messages','14')); 
		
		
		}
		
	}else{
	
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= $PPT->_e(array('messages','15'));		
	}
		
		
	}elseif($_POST['action'] == "delete"){
	
		wp_delete_post( $_POST['messageID'], true );
	 
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= $PPT->_e(array('messages','16'));	
		
		unset($_GET['mid']);
	
	}	

}
// LETS VALIDATE THAT THE READER CAN READ THIS MESSAGE
if(isset($_GET['mid']) && is_numeric($_GET['mid']) ){ 

	$msgData = wp_get_single_post( $_GET['mid'] );  
	
	// CHECK SENDER IS CORRECT
	if(strtolower(get_post_meta($msgData->ID, 'username', true)) != strtolower($userdata->user_login) ){
	
	header("location: ".get_option('messages_url'));
	die();
	
	}


}
 
/* =================== START DISPLAY ================== */ 

if(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_tpl_messages.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_tpl_messages.php');
		
}else{  ?>
	
<?php get_header(); 
 
 if(isset($_GET['u']) ){ ?> 
<script>jQuery(document).ready(function() {jQuery('#messageView').hide();jQuery('#messageBox').show();});</script>
<?php }elseif(isset($_GET['mid']) && is_numeric($_GET['mid']) ){ $msgData = wp_get_single_post( $_GET['mid'] );  ?>
<script>jQuery(document).ready(function() {jQuery('#messageView').hide();jQuery('#messageBox').hide(); jQuery('#messageRead').show(); });</script>
<?php } ?>
 
    


<?php if(isset($msgData)){ 

$date_format = get_option('date_format') . ' ' . get_option('time_format'); $date = mysql2date($date_format, $msgData->post_date, false);
update_post_meta($msgData->ID, "status", "read");
$email = get_post_meta($msgData->ID, 'email', true)
?> 
<div id="messageRead" style="display:none;">    

<div class="itembox">
    
	<h1 class="title"><?php echo $PPT->_e(array('messages','1')); ?></h1>
        
	<div class="itemboxinner article">
    
    <h3><?php echo $msgData->post_title; ?></h3>
    <ol class="info"> 
	<?php if($msgData->post_author == 0){ ?>
    <li><a class="user icon" href="#"><?php echo $PPT->_e(array('messages','3')); ?></a></li>
    <?php }else{ ?>
    <li><a class="user icon" href="<?php echo get_author_posts_url( $msgData->post_author, get_the_author_meta( 'user_nicename', $msgData->post_author) ); ?>"><?php the_author_meta('display_name',$msgData->post_author); ?></a></li> 
	<?php } ?>
    <?php if(strlen($email) > 1){ ?>
    <li><a class="email icon" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
    <?php } ?> 
    
    <li><a class="clock icon" href="#"><?php echo $date; ?></a></li> 
    
	</ol>
    <hr />
    
    <?php echo nl2br($msgData->post_content); ?>     
         
    </div><!-- end inner item box -->
    
    
    <?php if($msgData->post_author == 0){ ?>
    
    <div class="padding"><div class="yellow_box"><div class="yellow_box_content"><?php echo $PPT->_e(array('messages','4')); ?></div></div></div>
    
    <?php }?>
      
    
 	<!-- start buttons -->
    <div class="enditembox inner">
    
     <a href="<?php echo get_option('messages_url'); ?>" class="button gray"><?php echo $PPT->_e(array('button','7')); ?></a> 
    
    
    <div class="right">
    <?php if($msgData->post_author != 0){ ?>
    <a href="javascript:void(0);" onclick="document.getElementById('messageID').value='<?php echo $msgData->ID; ?>';messageDel2.submit();" class="button blue"><?php echo $PPT->_e(array('button','3')); ?></a>
    <?php if($GLOBALS['canSendMessages']){ ?>  | 
    <a href="<?php echo get_option("messages_url"); ?>/?u=<?php the_author_meta('user_nicename',$msgData->post_author); ?>&re=<?php echo str_replace('"','',strip_tags($msgData->post_title)); ?>" class="button blue"><?php echo $PPT->_e(array('button','9')); ?></a>
    <?php } ?>
    <?php } ?> 
     
    </div>
    
    </div>
    
     
    
    </div><!-- end itembox -->
    
</div>             
 
  
<?php } ?>    
    
    
    

<?php if($GLOBALS['canSendMessages']){ ?>   
<div id="messageBox" style="display:none;">

<form action="" method="post" onsubmit="return CheckMessageData(this.message_name.value,this.message_subject.value,this.message_message.value,'<?php echo $PPT->_e(array('validate','0')); ?>');"> 
<input type="hidden" name="action" value="add" />

<div class="itembox">
    
	<h1 class="title"><?php echo $PPT->_e(array('messages','5')); ?></h1>
        
	<div class="itemboxinner"> 
 
   
    <fieldset> 
                             
        <div class="full clearfix box"> 
        <p class="f_half left"> 
            <label for="name"><?php echo $PPT->_e(array('title','4')); ?><span class="required">*</span></label>
            <input type="text" name="message_name" id="message_name"  class="short" tabindex="1" value="<?php if(isset($_GET['u'])){ print strip_tags($_GET['u']); } ?>" />
            <br /><small><?php echo $PPT->_e(array('messages','6')); ?></small> 
        </p> 
        <p class="f_half left"> 
            <label for="email"><?php echo $PPT->_e(array('messages','7')); ?> <span class="required">*</span></label> 
            <input type="text" name="message_subject" id="message_subject" class="short" tabindex="2" value="<?php if(isset($_GET['re']) ){ echo "RE: ".strip_tags($_GET['re']);  } ?>" /> 
            <br /><small><?php echo $PPT->_e(array('messages','8')); ?></small> 
        </p> 
        </div> 
        
        <div class="full clearfix border_t box"> 
        <p>
            <label for="comment"><?php echo $PPT->_e(array('messages','9')); ?> <span class="required">*</span></label> 
            <textarea tabindex="4" class="long" rows="4" name="message_message" id="message_message"></textarea>           
        </p>
        </div>                            
      	
    
    </fieldset> 
    

        </div> 
        
         <!-- start buttons -->
         <div class="enditembox inner">         
      
         <input type="submit" name="submit" id="submit" class="button green left" tabindex="15" value="<?php echo $PPT->_e(array('messages','5')); ?>" />
         <input type="button" onclick="window.location='<?php echo get_option('messages_url'); ?>'" class="button gray right" tabindex="15" value="<?php echo $PPT->_e(array('button','8')); ?>" /> 
         
         </div>
         <!-- end buttons -->
   
    
    </div>	
    
    </form> 
    			 
</div>     
<?php }else{ ?>
Please upgrade your account to access this function.
<?php } ?>    
    
    
    
    
    
    
    
<div id="messageView" style="display:visible;">    
   

<div class="itembox">


    <div id="begin" class="inner">
        
        <h3><img src="<?php echo IMAGE_PATH; ?>a2.png" alt="my messages" align="absmiddle" /> <?php echo $PPT->_e(array('messages','10')); ?></h3>
        
        <ol class="page_tabs">
        
            <li><a href="#tab1"><?php echo $PPT->_e(array('messages','11')); ?></a></li>
            <li><a href="#tab2"><?php echo $PPT->_e(array('messages','12')); ?></a></li>                   
        
        </ol>
                            
    </div>


<div class="page_container">

		<div id="tab1" class="page_content">

			<?php echo $PPTDesign->MessagesBox('unread'); ?>                                
                                
        </div>
          
        <div id="tab2" class="page_content">

			<?php echo $PPTDesign->MessagesBox('read'); ?>
        
        </div>
          
</div>   
	    
 
    
   <!-- start buttons --><div class="enditembox inner"> 
                
      	<input type="button" onclick="window.location='<?php echo get_option('dashboard_url'); ?>'" class="button gray right" value="<?php echo $PPT->_e(array('button','7')); ?>" /> 
        <?php if($GLOBALS['canSendMessages']){ ?><input type="button" onclick="jQuery('#messageView').hide();jQuery('#messageBox').show();" class="button green left" value="<?php echo $PPT->_e(array('messages','13')); ?>" /><?php } ?> 
         </div> <!-- end buttons -->    
    
</div>

 
        

</div>

  

<form method="post" action="" id="messageDel2" name="messageDel2">
<input type="hidden" name="action" value="delete" />
<input type="hidden" name="messageID" id="messageID" value="" />
</form>
 
<?php get_footer();   } ?>