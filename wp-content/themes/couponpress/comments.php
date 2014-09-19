<?php

/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED // UPDATED: 16TH MARCH 2012
   ========================================================================== */ 

global $PPT, $wp_query, $PPTDesign, $ThemeDesign,$userdata; get_currentuserinfo(); 
 
/* =============================================================================
   LOAD IN PAGE CONTENT // V7 // 16TH MARCH
   ========================================================================== */
   
$hookContent = premiumpress_pagecontent("comments"); /* HOOK V7 */

if(strlen($hookContent) > 20 ){ // HOOK DISPLAYS CONTENT

	get_header();
	
	echo $hookContent;
	
	get_footer();

}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme')."/_comments.php")){
		
	include(str_replace("functions/","",THEME_PATH)."/themes/".get_option('theme').'/_comments.php');
	
}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_comments.php")){
		
		include(str_replace("functions/","",THEME_PATH)."/template_".strtolower(PREMIUMPRESS_SYSTEM)."/_comments.php");
				
}else{

/* =============================================================================
   LOAD IN PAGE DEFAULT DISPLAY // UPDATED: 25TH MARCH 2012
   ========================================================================== */ 

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php echo $PPT->_e(array('comment','1')); ?></p>
	<?php
		return;
	}
?> 




<!-- start _comments.php  -->

<?php if ( have_comments() ) : ?>
	<h5 id="comments" class="texttitle subheader"><?php comments_number($PPT->_e(array('comment','9')), $PPT->_e(array('comment','10')), '% '.$PPT->_e(array('comment','11')));?></h5>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
<div class="clearfix"></div>
	<ol class="commentlist">
	<?php wp_list_comments("callback=ppt_comments"); ?>
	</ol>
<div class="clearfix"></div>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php echo $PPT->_e(array('comment','2')); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div id="respond" class="clearfix">
<br />
<div class="texttitle"><?php comment_form_title( $PPT->_e(array('comment','8')) ); ?></div>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php echo $PPT->_e(array('comment','3')); ?></p>
<?php else : ?>
<div class="enditembox inner"> 
         
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
 
<?php if ( is_user_logged_in() ) : ?>

 
<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" />
<label for="author"><small><?php echo $PPT->_e(array('comment','4')); ?> <?php if ($req) echo $PPT->_e(array('title','11')); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" />
<label for="email"><small><?php echo $PPT->_e(array('comment','5')); ?> <?php if ($req) echo $PPT->_e(array('title','11')); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
<label for="url"><small><?php echo $PPT->_e(array('comment','6')); ?></small></label></p>

<?php endif; ?>

<textarea name="comment" id="comment" cols="58" rows="5" tabindex="4" class="long"></textarea>

<p><input name="submit" type="submit" id="submit" class="button gray" tabindex="5" value="<?php echo $PPT->_e(array('comment','7')); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
</div>
<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
 
<?php }
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>