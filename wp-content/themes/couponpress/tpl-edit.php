<?php
/*
Template Name: [Edit/Manage Template]
*/

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
global $PPT,  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars

$wpdb->hide_errors(); nocache_headers(); premiumpress_authorize();

$GLOBALS['IS_EDIT']	= true;

/* =============================================================================
   ACTIONS
   ========================================================================== */ 

if(!isset($GLOBALS['premiumpress']['language'])){
 	$GLOBALS['premiumpress']['language'] = get_option("language");
	$PPT->Language();
}

if(isset($_POST['action'])){

	if($_POST['action'] == "addfeedback"){
	
		// GET THE AUTHOR ID FOR SAVING
		$result = mysql_query("SELECT post_author FROM ".$wpdb->prefix."posts WHERE ".$wpdb->prefix."posts.ID='".strip_tags(PPTCLEAN($_POST['postID']))."' LIMIT 1", $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);							
		$array = mysql_fetch_assoc($result); 
	 
		$my_post = array();
		$my_post['post_title'] 		= "Feedback for ".$_POST['postID'];
		$my_post['post_content'] 	= strip_tags(strip_tags($_POST['feedback_message']));
		$my_post['post_excerpt'] 	= "";
		$my_post['post_status'] 	= "publish";
		$my_post['post_type'] 		= "ppt_feedback";
		$my_post['post_author'] 	= $userdata->ID;
		$POSTID 					= wp_insert_post( $my_post );
		
		add_post_meta($POSTID, "postID", $_POST['postID']);	
		add_post_meta($POSTID, "authorID", $_POST['authorID']);
		
		//add_post_meta($POSTID, "completed", $_POST['completed']);
		add_post_meta($POSTID, "rating1", $_POST['rating1']);
		add_post_meta($POSTID, "rating2", $_POST['rating2']);
		add_post_meta($POSTID, "rating3", $_POST['rating3']);
		add_post_meta($POSTID, "rating4", $_POST['rating4']);
		
		// UPDATE THE POST STATUS TO FINISHED
		update_post_meta($_POST['postID'], "bid_status", "finished");
 
	
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "success"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= $PPT->_e(array('edit','6'));
		
		// SEND EMAIL
		//$emailID = get_option("email_message_new");					 
		//if(is_numeric($emailID) && $emailID != 0){
		//	SendMemberEmail($userdata, $emailID);
		//}
		
	}	

}


if(isset($_GET['eid']) && isset($_GET['dd']) && is_numeric($_GET['eid']) ){
 
	$data = premiumpress_post_delete($user_ID, $_GET['eid']);

	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "success"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= $PPT->_e(array('edit','5'));
	
}

 
/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */

$hookContent = premiumpress_pagecontent("edit"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_tpl_edit.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_tpl_edit.php');

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_tpl_edit.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_tpl_edit.php");
		
}else{ 

/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 
 
get_header();   ?>

<?php premiumpress_edit_top(); /* HOOK */ ?> 

<div class="itembox">

<div id="begin" class="inner">
    
	<h3><img src="<?php echo IMAGE_PATH; ?>a3.png" align="absmiddle" /> <?php echo $PPT->_e(array('myaccount','6')); ?></h3>
    
    <ol class="page_tabs">
    
    	<li><a href="#tab1"><?php echo $PPT->_e(array('edit','1')); ?></a></li>
    	<li><a href="#tab2"><?php echo $PPT->_e(array('edit','2')); ?></a></li>
    
    </ol>
                        
</div>

	<div class="page_container">

			<div id="tab1" class="page_content">

				<h4><?php echo $PPT->_e(array('edit','1')); ?></h4>

				<p><?php echo $PPT->_e(array('edit','3')); ?></p>
                                
                <?php echo $PPTDesign->MANAGE($user_ID); ?>

			</div>

			<div id="tab2" class="page_content">

				<h4><?php echo $PPT->_e(array('edit','2')); ?></h4>

				<p><?php echo $PPT->_e(array('edit','4')); ?></p>

				<?php echo $PPTDesign->MANAGE($user_ID,"pending"); ?>

			</div>
  

	</div>  <!-- end tab_container box -->  
    
<!-- start buttons --><div class="enditembox inner"> 
                
      	<input type="button" onclick="window.location='<?php echo get_option('dashboard_url'); ?>'" class="button gray right" tabindex="15" value="<?php echo $PPT->_e(array('button','7')); ?>" /> 
        <input type="button" onclick="window.location='<?php echo get_option('submit_url'); ?>'" class="button green left" tabindex="15" value="<?php echo $PPT->_e(array('myaccount','8')); ?>" /> 
          
         </div> <!-- end buttons --> 
    
</div><!-- end itembox -->

<?php premiumpress_edit_bottom(); /* HOOK */ ?> 


<?php get_footer(); ?>
    
<?php } ?>