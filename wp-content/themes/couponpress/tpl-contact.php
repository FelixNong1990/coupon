<?php
/*
Template Name: [Contact Template]
*/

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */ 

global  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars

$wpdb->hide_errors(); nocache_headers();

$email_nr1 = rand("0", "9");$email_nr2 = rand("0", "9");

// ADMIN OPTION // GET CUSTOM WIDTH FOR PAGES
$GLOBALS['page_width'] 	= get_post_meta($post->ID, 'width', true);
if($GLOBALS['page_width'] =="full"){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }

/* =============================================================================
   PAGE ACTIONS // 
   ========================================================================== */

if(isset($_POST['action'])){ $_GET['action'] = $_POST['action']; }
if(isset($_GET['action']) && isset($_POST['form']['code']) ){ 

		$GLOBALS['premiumpress']['language'] = get_option("language");
		$PPT->Language();
 
		//check_admin_referer('ContactForm');	
		
		if(	isset($_POST['form']['code']) && $_POST['form']['code'] == $_POST['form']['code_value']){
		
		
			$message = "<p> ".$PPT->_e(array('contact','1'))." : " . strip_tags($_POST['form']['name']) . "
						<p> ".$PPT->_e(array('contact','2'))." : " . strip_tags($_POST['form']['email']) . "
						<p> ".$PPT->_e(array('contact','3'))." : " . strip_tags($_POST['form']['message']) . "";
						
			if(isset($_POST['report']) && is_numeric($_POST['report']) ){
			
			$message .= "<p> ".$PPT->_e(array('contact','6')).":  ".strip_tags($_POST['report'])."  <a href='" .get_permalink($_POST['report']) ."'>".$PPT->_e(array('contact','5'))."</a></p>";
			
			}
		
			// SEND EMAIL
			$emailID = get_option("email_admin_contact");
			if($emailID != "0" && strlen($emailID) > 0 ){					 
			SendMemberEmail("admin", $emailID,$message);
			}
			 
		
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "success"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= $PPT->_e(array('contact','7'));
				
		}else{

			$GLOBALS['error'] 		= 1;
			$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
			$GLOBALS['error_msg'] 	= $PPT->_e(array('contact','8'));		
			
		}

 
}

function NoFollowIndex(){

	echo '<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW"><META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW"><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';

}

// no index for report page
if(isset($_GET['report'])){add_filter('wp_head','NoFollowIndex');}

/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 25TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("contact"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_tpl_contact.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_tpl_contact.php');
		
}else{ get_header(); ?>

<form action="" method="post" onsubmit="return CheckFormData();"> 
<input type="hidden" name="action" value="1" />
<?php if(isset($_GET['report'])){ ?><input type="hidden" name="report" value="<?php echo strip_tags($_GET['report']); ?>" /><?php } ?>
<?php //wp_nonce_field('ContactForm') ?>
        
<div class="itembox">

	<h1 class="title"><?php the_title(); ?></h1>
	
    <div class="itemboxinner">
    
    <?php if(strlen($post->post_content) > 2){ echo wpautop($post->post_content); }  // display the template page content regardless ?>
    
        <fieldset> 
     
        
        <div class="full clearfix box"> 
        <p class="f_half left"> 
            <label for="name"><?php echo $PPT->_e(array('contact','1')); ?><span class="required">*</span></label> 
            <input type="text" name="form[name]" id="name" value="<?php echo $userdata->user_nicename; ?>" class="short" tabindex="1" /> 
            
        </p> 
        <p class="f_half left"> 
            <label for="email"><?php echo $PPT->_e(array('contact','2')); ?><span class="required">*</span></label> 
            <input type="text" name="form[email]" id="email1" value="<?php echo $userdata->user_email; ?>" class="short" tabindex="2" /> 
         
        </p> 
        </div> 
        <div class="full clearfix border_t box">         
        <p>
           <label for="comment"><?php echo $PPT->_e(array('contact','3')); ?><span class="required">*</span></label> 
           <textarea tabindex="4" class="long" rows="4" name="form[message]" id="message"><?php if(isset($_POST['form']['message'])){  print strip_tags($_POST['form']['message']); }?></textarea> 
          
        </p>        
        </div>  
        
        <div class="full clearfixbox"> 
          
        <div class="green_box"><div class="green_box_content">
            <label for="name"><?php echo str_replace("%a",$email_nr1,str_replace("%b",$email_nr2,$PPT->_e(array('validate','6')))); ?></label> 
            <input type="text" name="form[code]" value="" class="short" tabindex="1" id="code" /> 
            <input type="hidden" name="form[code_value]" value="<?php echo $email_nr1+$email_nr2; ?>" />
            </div></div>
          
     
        </div>
            
        </fieldset><!-- end fieldset --> 
   
    
    </div><!-- end innerhtml -->
    
    <!-- start buttons --><div class="enditembox inner"><input type="submit" name="submit" id="submitMe" class="button gray right" tabindex="15" value="<?php echo $PPT->_e(array('contact','4')); ?>"/></div> <!-- end buttons -->

</div><!-- end itembox -->

</form>

<script language="javascript" type="text/javascript">

		function CheckFormData()
		{
 
 		
			var name 	= document.getElementById("name"); 
			var email1 	= document.getElementById("email1");
			var code = document.getElementById("code");
			var message = document.getElementById("message");	 
						
			if(name.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','0')); ?>');
				name.focus();
				return false;
			}
			if(email1.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','3')); ?>');
				email1.focus();
				return false;
			}
 		

			if(code.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','0')); ?>');
				code.focus();
				return false;
			} 
			
			if(message.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','0')); ?>');
				message.focus();
				return false;
			} 			
			
			return true;
		}

 
</script>   

<?php get_footer(); } ?>