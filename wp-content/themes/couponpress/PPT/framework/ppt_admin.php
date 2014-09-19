<?php
/**
 * Base class for registering an administration page in the PremiumPress
 * admin framework
 *
 * @since 0.3.0
 */
class PPT_Admin extends PPT_API {

	/**
	 * Sets the slug for a registered page.
	 *
	 * @access public
	 * @since 0.3.0
	 * @see _setup_globals();
	 * @var string
	 */
	var $slug;
	
	/**
	 * Magic hook: Define your own admin_head
	 *
	 * @since 0.3.0
	 */
 
	function PPT_Admin( $args = array() ) {
	
		global $pagenow, $post;
 
		// Setup theme page array
		$api = array('ppt_admin.php','membership','setup','members','display','submit','advertising','analytics','tools','payments','orders','images','emails',
		'import_products','import_movies','quickhelp','updates','shipping','checkout','import','pptplugins','ppthelpme','import_deals');  
		
		// Load admin area notices	 
		add_action('admin_notices', array( $this, '_admin_notices' ));	

		// Load all the javascript/styles into the theme wp_head
		add_action( 'wp_loaded', array( $this, '_enqueue_assets' ) ); 
  
		// Load into WP Magic hooks only for PPT themes
		add_action( 'admin_menu', array( $this, '_admin_menu' ) );
		
		// Load delete post items
		add_action('delete_post', array( $this, 'ppt_delete_post' ) );
 		
		//Load in all the styles for PPT themes
		if(isset($_GET['page']) && in_array($_GET['page'], $api)){		
		add_action( 'admin_head', array( $this, '_admin_head' ) );
		}
		
		add_filter('default_hidden_meta_boxes', array( $this, 'ppt_hidden_meta_boxes' ), 10, 2);	
			
	
		// CHECK IF WERE TRYING TO UPLOAD A NEW THEME
		// IF SO WE SHOULD DISABLE THE IMAGE UPLOAD PATHS
		if( $pagenow == "theme-install.php"){		
			update_option("upload_url_path","",true);
			update_option("upload_path","",true);	
			//update_option("imagestorage_link","",true);
			//update_option("imagestorage_path","",true);	 
		} 
		
		// CUSTOM CATEGORY EDITS // VERSION 7.1.1
		if(isset($_REQUEST['taxonomy'])){
		
		// Load the pop-up for admin image uploads	
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		
		$taxnow = sanitize_key($_REQUEST['taxonomy']);
			//if($taxnow == "store" || $taxnow == "category"){
				add_filter($taxnow.'_edit_form_fields', array( $this, 'my_category_fields'  ) );
				add_filter('edited_terms', array( $this, 'update_my_category_fields' ));
				add_filter('deleted_term_taxonomy', array( $this, 'remove_my_category_fields'));					
				add_filter( 'manage_edit-'.$taxnow.'_columns', array( $this, 'category_id_head' ) );
				add_filter( 'manage_'.$taxnow.'_custom_column', array( $this, 'category_id_row' ), 10, 3 );
			//}
		}

		if( ( $pagenow == "edit.php" && ( $_GET['post_type'] == "post" || !isset($_GET['post_type']) ) ) || $pagenow == "post.php" || $pagenow == "post-new.php"){
 
			// Load PremiumPress admin theme options
			require_once ("ppt_customfields.php");	
		
			// ADD IN EDITOR OPTIONS FOR POSTS/PAGES/ARTICLES
			add_action('admin_head', 'ppt_custom_admin_head');
			
			// LOAD ALL PREMIUMPRESS ADMIN EDITING DATA	
			add_action('save_post',  'premiumpress_postdata', 1, 2);		
			 
			// ADD IN CUSTOM ACTIONS/FILTERS
			add_action('manage_posts_custom_column', 'premiumpress_custom_column', 10, 2);
			add_action('admin_menu', 'premiumpress_customfields_box');	
			add_action('wp_loaded', 'HeaderPOSTData');
			add_action( 'post_submitbox_misc_actions', 'ppt_metabox' );
			
			add_filter('manage_posts_columns', 'ppt_remove_columns');	
			add_filter( 'manage_edit-post_sortable_columns', 'price_column_register_sortable' );
			add_filter( 'request', 'price_column_orderby' );
			add_filter( 'manage_posts_columns', 'ppt_custom_columns' );	
		}
		
		
	}
	
	function category_id_row( $output, $column, $term_id ){
	
		global $wpdb;
 
		if( $column == 'description'){
		
			return strip_tags(substr($output,0,100));
		
		}elseif( $column == 'icon'){	
		
		$CATARRAY = get_option("cat_icons");		 
		if(isset($CATARRAY[$term_id]['image'])){ 
		
		$Cimg = str_replace(".png","",$CATARRAY[$term_id]['image']);
		if(is_numeric($Cimg)){ $imgPath = get_template_directory_uri().'/images/icons/'.$CATARRAY[$term_id]['image'];  }else{  $imgPath = $CATARRAY[$term_id]['image']; }
	
		$icon = "<img src='".$imgPath."' style='max-width:50px; max-height:50px;' />";		
		}else{ $icon ="";  }
		return $icon;
		
		}else{
		
			return $output;
		
		}
	 
	}
	 
	function category_id_head( $columns ) {
	
		//$columns['description'] = __('Description');
		if(sanitize_key($_REQUEST['taxonomy']) == "store" || sanitize_key($_REQUEST['taxonomy']) == "category"){
		unset($columns['description']);
		unset($columns['slug']);
    	$columns['icon'] = __('Icon');
		}
    	return $columns;
		
	}

	function my_category_fields($tag) {
	
		if(!isset($_GET['tag_ID'])){ return; }
		
 	
		if(sanitize_key($_REQUEST['taxonomy']) == "store" || sanitize_key($_REQUEST['taxonomy']) == "category"){
		 
			//$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
			
			// GET THE CURRENT ICON VALUE
			$CATARRAY = get_option("cat_icons");			
			if(isset($CATARRAY[$tag->term_id]['image'])){ $icon = $CATARRAY[$tag->term_id]['image']; }else{ $icon ="";  }
		
			?>
            <input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
            
            <script type="text/javascript">
			
			function ChangeImgBlock(divname){ document.getElementById("imgIdblock").value = divname; }

            function ChangeCatIcon(){
			
             ChangeImgBlock('caticon');
             formfield = jQuery('#caticon').attr('name');
             tb_show('', <?php if(defined('MULTISITE') && MULTISITE != false){ ?>'admin.php?page=images&amp;tab=nw&amp;TB_iframe=true'<?php }else{ ?>'media-upload.php?type=image&amp;TB_iframe=true'<?php } ?>);
             return false;	
             
            }
			
			jQuery(document).ready(function() {			 
						
			window.send_to_editor = function(html) {
			 imgurl = jQuery('img',html).attr('src'); 
			 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
			 tb_remove();
			} 
			
			});
            
            </script>
		
            <table class="form-table">
                    <tr class="form-field">
                        <th scope="row" valign="top"><label>Icon</label></th>
                        <td><input name="caticon" id="caticon" type="text" size="40" aria-required="false" value="<?php echo $icon; ?>" />
                        
                        
                        
                        <div class="updated below-h2 clearfix" style="padding:10px;">
                        <p><b>Icons </b> - <input type="button" size="36" name="upload_caticon" value="Upload Icon" onclick="ChangeCatIcon();" class="button" style="width:100px;"></p>
                     
                        <?php
						
						$i=1;
	while($i < 57){
	
	echo "<img src='".get_template_directory_uri()."/images/icons/".$i.".png' style='float:left; border:1px solid #ddd; background:#fff; padding:3px; margin-right:10px; margin-bottom:10px; cursor:pointer;' onclick=\"document.getElementById('caticon').value='".$i.".png'\">";
	$i++;
	}
						
						?>
                         <div class="clear"></div> 
                         </div>
                        
                        
                        </td>
                    </tr>
                     
            </table>
		
			<?php
			
			}elseif(sanitize_key($_REQUEST['taxonomy']) != "faq"){ // end if cat or store 
			
			$cats = array();
			$CATS = get_option("taxonomy_customcats");
			if(isset($CATS[$tag->term_id]['cats'])){ $cats = $CATS[$tag->term_id]['cats']; }else{ $cats = array();  }
		  
			?>
			
            <table class="form-table">
                    <tr class="form-field">
                        <th scope="row" valign="top"><label>Belongs to category;</label></th>
                        <td> 
                        
                        <select name="tax_cats[]" multiple="multiple" style="width:100%; height:150px;">
                        <!--<option value="0" <?php if(in_array(0, $cats)){ echo "selected=selected"; } ?>>All Categories</option> -->
                        <option value="1" <?php if(in_array(1, $cats)){ echo "selected=selected"; } ?>>Home Page</option>
						  <?php echo premiumpress_categorylist($cats,false,false,"category",0,true); ?>
                        </select>
                        <input type="hidden" name="tax_id" value="<?php echo $_GET['taxonomy']; ?>" />
                        
                        <span>Here you can assign this taxonomy to a category so that when you use the taxonomy widget, the options will only display if the user is viewing the category.</span>
                         <div class="clear"></div> 
                         </div>
                        
                        
                        </td>
                    </tr>
                     
            </table>			
			
			<?php }
			
		}
		
		
		// when the form gets submitted, and the category gets updated (in your case the option will get updated with the values of your custom fields above		
		function update_my_category_fields($term_id) {
		 
		  if($_POST['taxonomy'] == 'category' || $_POST['taxonomy'] == 'store' ){		  
		  	$CATARRAY = get_option("cat_icons");
			$CATARRAY[$term_id]['image'] = strip_tags($_POST['caticon']);
			update_option("cat_icons",$CATARRAY);  
		  
		  }elseif( isset($_POST['tax_cats']) ){
		  
		  	$CATARRAY = get_option("taxonomy_customcats");
			$IDARRAY = get_option("taxonomy_customids");
			$IDARRAY[$_POST['tax_id']] = $term_id;
			$CATARRAY[$term_id]['cats'] = $_POST['tax_cats'];
			update_option("taxonomy_customcats",$CATARRAY); 
		  	update_option("taxonomy_customids",$IDARRAY); 
		  }
		}
		
		
		// when a category is removed		
		function remove_my_category_fields($term_id) {
		  if($_POST['taxonomy'] == 'category' || $_POST['taxonomy'] == 'store'){		  
		  	$CATARRAY = get_option("cat_icons");
			unset($CATARRAY[$term_id]['image']);
			update_option("cat_icons",$CATARRAY);
		  
		  }
			 
		}
	
 
	
	function ppt_delete_post( $postid = ''){
	
	global $wpdb;
	
	 	if(!is_numeric($postid)){ return; }
		
		$d = get_post($postid);
		
		// CHECK FOR POST PARENT
		if(isset($d->post_parent) && is_numeric($d->post_parent) ){		
			$postid = $d->post_parent;		
		}
		
		// SEND USER AN EMAIL
		$emailID = get_option("email_listing_deleted");					 
		if(is_numeric($emailID) && $emailID != 0){
			//SendMemberEmail($d->post_author, $emailID);
		}
	  	
		// STORAGE PATHS
		/*$S1 = get_option('imagestorage_link');
		$S2 = get_option('imagestorage_path');
		
		// GET THE IMAGES FOR DELETION
		$image = str_replace($S1,"",get_post_meta($postid, "image", true));	
		 
		// CHECK ITS NOT A LINKED IMAGE
		if (strpos($image, "http") === false) { @unlink($S2.$image); } 
		 
		$images = get_post_meta($postid, "images", true);
		$imgs = explode(",",$images);
		foreach($imgs as $image){ 
			if(strlen($image) > 4){
				if (strpos($image, "http") === false) { @unlink($S2.$image); } 
			}
		}*/
	
	} 


	/**
	 * Magic hook: Custom display the author and excerpt when you install the theme 
	 *
	 * @since 0.3.0
	 */	
	function ppt_hidden_meta_boxes($hidden, $screen) {
	 
		if ( 'post' == $screen->base || 'page' == $screen->base )
			$hidden = array('slugdiv', 'trackbacksdiv',  'commentstatusdiv', 'postcustom', 'commentsdiv',  'revisionsdiv');
			// removed , 'postexcerpt','authordiv',
		return $hidden;
	}	
	/**
	 * Magic hook: Define your own admin_head
	 *
	 * @since 0.3.0
	 */
	 
	function _admin_head() {	 
 		
		$this->_enqueue_assets(true);	
		$this->_admin_css();
 
	}

	/**
	 * Magic hook: Defines the admin notices
	 *
	 * @since 0.3.0
	 */		
	function _admin_notices() {
	
	echo "<br />"; 	 
	
	if($GLOBALS['error'] == 1){ ?><div class="msg msg-<?php echo $GLOBALS['error_type']; ?>"><p><?php echo $GLOBALS['error_msg']; ?></p></div> <?php  }
			 
		 
	}

 

	
	/**
	 * Magic hook: Define the header scripts
	 *
	 * @since 0.3.0
	 */
	 
	function _enqueue_assets($ishead = false){
	
	global $pagenow, $wpdb, $api;

	
	 // WIDGET ONLY INCLUDES
	 if($pagenow == "widgets.php"){ 	 
	  
 		wp_enqueue_script('wf_wn_common', PPT_PATH . 'framework/widgets/js/wn-common.js', array(), '1.0');
        wp_enqueue_script('wf_wn_tipsy', PPT_PATH . 'framework/widgets/js/jquery.tipsy.js', array(), '1.0');
        wp_enqueue_script('jquery-ui-dialog');
		
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_style('wn-style', PPT_PATH . 'framework/widgets/css/wn-style.css', array(), '1.0');

        // only for IE, no comment :(
        add_action('admin_head', array('wf_wn', 'admin_header'));

        // help content for tooltips
        add_action('admin_footer', array('wf_wn', 'admin_footer'));
		wp_register_style( 'extended-tags-widget', PPT_PATH . 'framework/widgets/css/widget.css' );
		wp_enqueue_style( 'extended-tags-widget' );	 
	 	wp_enqueue_style( 'extended-tags-widget', PPT_PATH . 'framework/widgets/css/widget-admin.css', false, 0.7, 'screen' );
	 
	 	return; // exit	 
	 } 
	 
	 // CHECK TO ENSURE ONLY PREMIUMPRESS PAGES INCLUDE THE ADDITIONAL JS OPTIONS TO PREVENT ISSUES WITH PLUGINS
	 if( ( $pagenow == "edit.php" && !isset($_GET['post_type']) ) || $pagenow == "post.php" || $pagenow == "post-new.php" || ( isset($_GET['page']) && in_array($_GET['page'],
	 array('ppt_admin.php','membership','setup','members','display','submit','advertising','analytics','tools','payments','orders','images','emails',
		'import_products','import_movies','quickhelp','updates','shipping','checkout','import','pptplugins')) ) ){
	  
	 }else{
	 return;
	 }
	
	 
		// Load scripts into system
		//wp_deregister_script( 'jquery' );
		//wp_register_script( 'jquery', PPT_THEME_URI.'/PPT/js/jquery.js');
		wp_enqueue_script( 'jquery' ); //<-- load WP jquery instead
		
		
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');		
		
		wp_enqueue_script('jquery-ui-sortable');
		
	 
		wp_register_script( 'ppt_ajax_actions', PPT_THEME_URI.'/PPT/ajax/actions.js');
		wp_enqueue_script( 'ppt_ajax_actions' );	 
		
		if(isset($_GET['page']) && ($_GET['page'] == "images" || $_GET['page'] == "add" )){ 	  // not great i know but it works
	 
			wp_register_script( 'fancybox', PPT_THEME_URI.'/PPT/fancybox/jquery.fancybox-1.3.1.js');
			wp_enqueue_script( 'fancybox' );
			
			wp_register_style( 'fancyboxCSS', PPT_THEME_URI.'/PPT/fancybox/jquery.fancybox-1.3.1.css');
			wp_enqueue_style( 'fancyboxCSS' );
		
		}
		
		
		if(isset($_GET['page']) && $_GET['page'] == "import_products"){
		// COLOUR PICKER TOOL FOR THEME STYLES
		wp_register_script( 'p1', PPT_THEME_URI.'/PPT/js/jquery.smartsuggest.js');		
		wp_enqueue_script( 'p1' );		
		wp_register_style( 'c1', PPT_THEME_URI.'/PPT/js/jquery.smartsuggest.css');
		wp_enqueue_style( 'c1' );
		}
	 
		if(isset($_GET['page']) && $_GET['page'] == "display" ){
		// COLOUR PICKER TOOL FOR THEME STYLES
		wp_register_script( 's1', PPT_THEME_URI.'/PPT/js/jquery.picker.js');		
		wp_enqueue_script( 's1' );		
		wp_register_style( 's1', PPT_THEME_URI.'/PPT/css/css.admin.colorpicker.css');
		wp_enqueue_style( 's1' );		
		}
 
			 
		// ADMIN MESSAGE BOX FUNC
		wp_register_style( 'msgbox', PPT_PATH.'js/msgbox/jquery.msgbox.css');
		wp_enqueue_style( 'msgbox' );
			
		wp_register_script( 'msgbox', PPT_PATH.'js/msgbox/jquery.msgbox.js');
		wp_enqueue_script( 'msgbox' );

		// Load the pop-up for admin image uploads	
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		
		
		if($ishead){ // Load the content within the head because we cannot enqueue after the init
		?>
        
 
  
       
		<script type="text/javascript">
		
	
		 function PPHelpMe(keyword){
			 
			 tb_show("PremiumPress Video Tutorials","http://www.premiumpress.com/videotutorials/?l=<?php if($_SERVER['HTTP_HOST'] == "localhost"){ echo "localhost"; }else{ echo get_option('license_key');} ?>&t=<?php echo strtolower(constant('PREMIUMPRESS_SYSTEM')); ?>&p=<?php if(isset($_GET['page']))echo $_GET['page']; ?>&k="+keyword+"TB_iframe=true&height=600&width=900&modal=false", null);
			 return false;
			 
			}
		
		function PPMsgBox(text){
		jQuery.msgbox(text, {  type: "info",   buttons: [    {type: "submit", value: "OK"}  ]}, function(result) {  
		if (!result) {      window.open('http://www.premiumpress.com/videotutorials/?k=<?php if($_SERVER['HTTP_HOST'] == "localhost"){ echo "localhost"; }else{ echo get_option('license_key');} ?>&p=<?php if(isset($_GET['page']))echo $_GET['page']; ?>','mywindow','width=900,height=600')		  }});
		
		} 
		
		function PlayPPTVideo(videoname,div){
		
		document.getElementById( div ).innerHTML = '<iframe width="380" height="223" src="http://www.youtube.com/embed/'+videoname+'?rel=0" frameborder="0" allowfullscreen></iframe>';
		
		
		}
		
		jQuery(document).ready(function() { 
		
		
		  
		
			jQuery('#post-type-select').siblings('a.edit-post-type').click(function() {
						if (jQuery('#post-type-select').is(":hidden")) {
							jQuery('#post-type-select').slideDown("normal");
							jQuery(this).hide();
						}
						return false;
			});
		
			jQuery('.save-post-type', '#post-type-select').click(function() {
						jQuery('#post-type-select').slideUp("normal");
						jQuery('#post-type-select').siblings('a.edit-post-type').show();
						pts_updateText();
						return false;
			});
		
			jQuery('.cancel-post-type', '#post-type-select').click(function() {
						jQuery('#post-type-select').slideUp("normal");
						jQuery('#pts_post_type').val(jQuery('#hidden_post_type').val());
						jQuery('#post-type-select').siblings('a.edit-post-type').show();
						pts_updateText();
						return false;
			});
		
			function pts_updateText() {
						jQuery('#post-type-display').html( jQuery('#pts_post_type :selected').text() );
						jQuery('#hidden_post_type').val(jQuery('#pts_post_type').val());
						jQuery('#post_type').val(jQuery('#pts_post_type').val());
						return true;
			}
		
							
		<?php if(isset($_GET['page']) && ( $_GET['page'] == "images" || $_GET['page'] == "add" )){ ?>
		jQuery("a[rel=image_group]").fancybox({
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
		});
		<?php } ?>
		
  <?php if( isset($_POST['ad_zone']) ){ ?>
							jQuery('#premiumpress_box1 .content#premiumpress_tab1').hide(); 
							<?php } ?>
							<?php if(!isset($_POST['showtax']) ){ ?>
							jQuery('#premiumpress_box1 .content#premiumpress_tab2').hide(); 
							<?php } ?>					
							jQuery('#premiumpress_box1 .content#premiumpress_tab3').hide(); 
							jQuery('#premiumpress_box1 .content#premiumpress_tab4').hide(); 
							<?php if(!isset($_POST['ad_zone'])){ ?>
							jQuery('#premiumpress_box1 .content#premiumpress_tab5').hide(); 
							<?php } ?>
							<?php if(!isset($_POST['selectcountry'])){ ?>
							jQuery('#premiumpress_box1 .content#premiumpress_tab6').hide(); 
							 <?php } ?>			
							jQuery('#premiumpress_box1 .content#premiumpress_tab7').hide(); 		
							jQuery('#premiumpress_box1 .header ul a').click(function(){
							
								jQuery('#premiumpress_box1 .header ul a').removeClass('active');
								jQuery(this).addClass('active');								
								jQuery('#premiumpress_box1 .content').hide(); 
								jQuery('#premiumpress_box1').find('#' + jQuery(this).attr('rel')).show(); 

								return false;
							});
							
							
							<?php   if(isset($_POST['showThisTab']) && strlen($_POST['showThisTab']) > 0  ){ 
								
									$tabs=1;
									while($tabs < 8){
										if($tabs !=  $_POST['showThisTab']){
										echo "jQuery('#premiumpress_box1 .content#premiumpress_tab".$tabs."').hide();";
										}else{
										echo "jQuery('#premiumpress_box1 .content#premiumpress_tab".$tabs."').show();";
										}
										$tabs++;
									}
								
								
								}  ?>
							
					});		 
					 
					 
					function toggleLayer( whichLayer )
					{
					  var elem, vis;
					  if( document.getElementById ) 
						elem = document.getElementById( whichLayer );
					  else if( document.all ) 
						  elem = document.all[whichLayer];
					  else if( document.layers ) 
						elem = document.layers[whichLayer];
					  vis = elem.style;
					
					  if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)    vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';  vis.display = (vis.display==''||vis.display=='block')?'none':'block';
					} 
					
		</script>  	
		<?php

		}
		
}	
	
	
	/**
	 * Magic hook: Define the menu lables
	 *
	 * @since 0.3.0
	 */	 
	
	
	function change_post_object_label() {
	 
	 
		switch(strtolower(constant('PREMIUMPRESS_SYSTEM'))){

			case "resumepress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Item';
					$labels->singular_name = 'Items';
					$labels->add_new = 'Add Item';
					$labels->add_new_item = 'Add Item';
					$labels->edit_item = 'Edit Item';
					$labels->new_item = 'Items';
					$labels->view_item = 'View Items';
					$labels->search_items = 'Search Items';
					$labels->not_found = 'No Resume Items found';
					$labels->not_found_in_trash = 'No Resume Items found in Trash';
			
			} break;
					
			case "auctionpress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Auctions';
					$labels->singular_name = 'Auctions';
					$labels->add_new = 'Add Auction';
					$labels->add_new_item = 'Add Auction';
					$labels->edit_item = 'Edit Auction';
					$labels->new_item = 'Auctions';
					$labels->view_item = 'View Auctions';
					$labels->search_items = 'Search Auctions';
					$labels->not_found = 'No Auctions found';
					$labels->not_found_in_trash = 'No Auctions found in Trash';
			
			} break;
		
			case "directorypress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Listings';
					$labels->singular_name = 'Listings';
					$labels->add_new = 'Add Listing';
					$labels->add_new_item = 'Add Listing';
					$labels->edit_item = 'Edit Listing';
					$labels->new_item = 'Listings';
					$labels->view_item = 'View Listings';
					$labels->search_items = 'Search Listings';
					$labels->not_found = 'No Listings found';
					$labels->not_found_in_trash = 'No Listings found in Trash';
			
			} break;
			
			case "couponpress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Coupons';
					$labels->singular_name = 'Coupons';
					$labels->add_new = 'Add Coupon';
					$labels->add_new_item = 'Add Coupon';
					$labels->edit_item = 'Edit Coupon';
					$labels->new_item = 'Coupons';
					$labels->view_item = 'View Coupons';
					$labels->search_items = 'Search Coupons';
					$labels->not_found = 'No Coupons found';
					$labels->not_found_in_trash = 'No Coupons found in Trash';
			
			} break;
			
			case "classifiedstheme": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Classifieds';
					$labels->singular_name = 'Classifieds';
					$labels->add_new = 'Add Classified';
					$labels->add_new_item = 'Add Classified';
					$labels->edit_item = 'Edit Classified';
					$labels->new_item = 'Classifieds';
					$labels->view_item = 'View Classifieds';
					$labels->search_items = 'Search Classifieds';
					$labels->not_found = 'No Classifieds found';
					$labels->not_found_in_trash = 'No Classifieds found in Trash';
			
			} break;	
			
			
			case "realtorpress": {
			
					global $wp_post_types;
		
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Listings';
					$labels->singular_name = 'Real Estate';
					$labels->add_new = 'Add Real Estate';
					$labels->add_new_item = 'Add Real Estate';
					$labels->edit_item = 'Edit Real Estate';
					$labels->new_item = 'Real Estate';
					$labels->view_item = 'View Real Estate';
					$labels->search_items = 'Search Real Estate';
					$labels->not_found = 'No Real Estate found';
					$labels->not_found_in_trash = 'No Real Estate found in Trash';
			
			} break;	
			
			
			case "shopperpress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Products';
					$labels->singular_name = 'Product';
					$labels->add_new = 'Add Product';
					$labels->add_new_item = 'Add Product';
					$labels->edit_item = 'Edit Product';
					$labels->new_item = 'Product';
					$labels->view_item = 'View Product';
					$labels->search_items = 'Search Product';
					$labels->not_found = 'No Product found';
					$labels->not_found_in_trash = 'No Product found in Trash';
			
			} break;
			
			
			case "moviepress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Videos';
					$labels->singular_name = 'Video';
					$labels->add_new = 'Add Video';
					$labels->add_new_item = 'Add Video';
					$labels->edit_item = 'Edit Video';
					$labels->new_item = 'Video';
					$labels->view_item = 'View Video';
					$labels->search_items = 'Search Video';
					$labels->not_found = 'No Video found';
					$labels->not_found_in_trash = 'No Video found in Trash';
			
			} break;
			
			case "employeepress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Jobs';
					$labels->singular_name = 'Job';
					$labels->add_new = 'Add Job';
					$labels->add_new_item = 'Add Job';
					$labels->edit_item = 'Edit Job';
					$labels->new_item = 'Job';
					$labels->view_item = 'View Job';
					$labels->search_items = 'Search Job';
					$labels->not_found = 'No Job found';
					$labels->not_found_in_trash = 'No Job found in Trash';
			
			} break;

			case "comparisonpress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Products';
					$labels->singular_name = 'Product';
					$labels->add_new = 'Add Product';
					$labels->add_new_item = 'Add Product';
					$labels->edit_item = 'Edit Product';
					$labels->new_item = 'Product';
					$labels->view_item = 'View Product';
					$labels->search_items = 'Search Products';
					$labels->not_found = 'No Products found';
					$labels->not_found_in_trash = 'No Products found in Trash';
			
			} break;	
			
			case "dealpress": {
			
					global $wp_post_types;
					$labels = &$wp_post_types['post']->labels;
					$labels->name = 'Deals';
					$labels->singular_name = 'Product';
					$labels->add_new = 'Add Product';
					$labels->add_new_item = 'Add Product';
					$labels->edit_item = 'Edit Product';
					$labels->new_item = 'Product';
					$labels->view_item = 'View Product';
					$labels->search_items = 'Search Deals';
					$labels->not_found = 'No Deals found';
					$labels->not_found_in_trash = 'No Deals found in Trash';
			
			} break;	 
				
		}
	
	} 
	

	/**
	 * Magic hook: Define the admin_menu items
	 * @since 0.3.0
	 */
	function remove_menus () {
	global $menu;
		$restricted = array(__('Dashboard'),  __('Media'), __('Profile'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
	}
	 
	function _admin_menu() {
  
	global $wpdb, $user; $userdata = wp_get_current_user();
	
	$DEFAULT_STATUS = "edit_pages";
	
	if(defined('PREMIUMPRESS_DEMO')  && !user_can($userdata->ID, 'administrator') ){
	$DEFAULT_STATUS = "edit_posts";
	$this->remove_menus ();
	}
	
	// Load the custom labels for the admin pages 
	$this->change_post_menu_label();
	$this->change_post_object_label();
	
	
 
	 
		add_menu_page(basename(__FILE__), __(str_replace("RealtorPress","Real Estate",str_replace("Theme","",str_replace("ComparisonPress","Comparison",constant('PREMIUMPRESS_SYSTEM')))),'cp'), $DEFAULT_STATUS, basename(__FILE__), '', ''.PPT_PATH.'/img/admin/'.strtolower(constant('PREMIUMPRESS_SYSTEM')).'.png',3); 
		
		if(get_option("license_key") != ""){	 // && $_SERVER['HTTP_HOST'] != "localhost"
		
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('License Key','cp'), $DEFAULT_STATUS, basename(__FILE__), array( $this, 'premiumpress_admin_licensekey_form' ) );	
		
		}else{
 
		
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/overview.png" align="middle"> Overview','cp'), $DEFAULT_STATUS, basename(__FILE__), array( $this, 'premiumpress_overview' ) );	
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/ssetup.png" align="middle"> General Setup','cp'), $DEFAULT_STATUS, 'setup', array( $this, 'premiumpress_admin_setup' ) );
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/smembers.png" align="middle"> Members','cp'), $DEFAULT_STATUS, 'members', array( $this, 'premiumpress_admin_members' ) );	
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/sdisplay.png" align="middle"> Display Settings','cp'), $DEFAULT_STATUS, 'display', array( $this, 'premiumpress_admin_display' ) );
		 
		
		if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){  
	 
		}else{	
		
		 add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/spackages.png" align="middle"> Memberships','cp'), $DEFAULT_STATUS, 'membership',array( $this, 'premiumpress_admin_membership'));
		 
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/simport.png" align="middle"> Submission','cp'), $DEFAULT_STATUS, 'submit', array( $this,'premiumpress_admin_submit'));
		
		 
		
		}	
		

		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/sadvert.png" align="middle"> Advertising','cp'), $DEFAULT_STATUS, 'advertising', array( $this,'premiumpress_admin_advertising'));			
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/sgoogle.png" align="middle"> Google+','cp'), $DEFAULT_STATUS, 'analytics', array( $this,'premiumpress_admin_analytics'));		
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/stools.png" align="middle"> Tools','cp'), $DEFAULT_STATUS, 'tools', array( $this,'premiumpress_admin_tools'));		 	
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/spayment.png" align="middle"> Payments','cp'), $DEFAULT_STATUS, 'payments', array( $this,'premiumpress_admin_payments'));		
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'),
		 __('<img src="'.PPT_PATH.'/img/admin/sorders.png" align="middle"> Order Manager','cp'), $DEFAULT_STATUS, 'orders', array( $this,'premiumpress_admin_orders'));
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/simages.png" align="middle"> File Manager','cp'), $DEFAULT_STATUS, 'images', array( $this,'premiumpress_admin_images'));	 
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/semail.png" align="middle"> Email Manager','cp'), $DEFAULT_STATUS, 'emails', array( $this,'premiumpress_admin_emails'));
		
		switch(strtolower(constant('PREMIUMPRESS_SYSTEM'))){ 
		
			case "bookingpress": {	
		  	
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/simport_hotels.png" align="middle"> Import Hotels','cp'), $DEFAULT_STATUS, 'import',  array( $this,'premiumpress_admin_import_hotel'));
 				
			} break;
			
			case "employeepress": {	
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/simport_jobs.png" align="middle"> Import Jobs','cp'), $DEFAULT_STATUS, 'import',  array( $this,'premiumpress_admin_import_jobs'));
				
			} break;
					
			case "comparisonpress": {	
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/import.png" align="middle"> Import Products','cp'), $DEFAULT_STATUS, 'import_products',  array( $this,'premiumpress_admin_import_products')); 
					
			} break;
			
			case "couponpress": {	
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/simport_coupons.png" align="middle"> Import Coupons','cp'), $DEFAULT_STATUS, 'import',  array( $this,'premiumpress_admin_import_coupons'));
				
			} break;
		
			case "shopperpress": {	
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/scheckout.png" align="middle"> Checkout','cp'), $DEFAULT_STATUS, 'checkout',  array( $this,'premiumpress_admin_checkout'));
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/sshipping.png" align="middle"> Shipping','cp'), $DEFAULT_STATUS, 'shipping',  array( $this,'premiumpress_admin_shipping'));
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/import.png" align="middle"> Import Products','cp'), $DEFAULT_STATUS, 'import_products',  array( $this,'premiumpress_admin_import_products'));
				
			} break;	
			
			case "moviepress": {	
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/video.png" align="middle"> Import Videos','cp'), $DEFAULT_STATUS, 'import_movies',  array( $this,'premiumpress_admin_import_movies'));
				
			} break;
			
			case "classifiedstheme": {	
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/import.png" align="middle"> Import Products','cp'), $DEFAULT_STATUS, 'import_products',  array( $this,'premiumpress_admin_import_products'));
				
			} break;
			
			case "auctionpress":{
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/import.png" align="middle"> Import Products','cp'), $DEFAULT_STATUS, 'import_products',  array( $this,'premiumpress_admin_import_products'));
						
			} break;		
					
			case "dealspress":{
			
			add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/import.png" align="middle"> Import Deals','cp'), $DEFAULT_STATUS, 'import_deals',  array( $this,'premiumpress_admin_import_deals'));
						
			} break;			
			
		}
 
 		//add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/s123.png" align="middle"> Quick Help','cp'), $DEFAULT_STATUS, "quickhelp", array( $this, 'premiumpress_steps_setup' ) );
		
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/splugin.png" align="middle"> Plugins','cp'), $DEFAULT_STATUS, "pptplugins", array( $this, 'premiumpress_admin_plugins' ) );
		
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/supdate.png" align="middle"> Theme Updates','cp'), $DEFAULT_STATUS, 'updates',  array( $this,'premiumpress_admin_updates'));
	
		add_submenu_page(basename(__FILE__), __(constant('PREMIUMPRESS_SYSTEM'),'cp'), __('<img src="'.PPT_PATH.'/img/admin/s123.png" align="middle"> Help &amp; Tutorials','cp'), $DEFAULT_STATUS, 'ppthelpme',  array( $this,'premiumpress_admin_gettingstarted'));
	
		
		} 

		$this->contextual_callback( 'admin_menu' );
	}

 


	/**
	 * Magic hook: Define the admin menu calls
	 * @since 0.3.0
	 */
 
	function premiumpress_overview() 		{  			include(TEMPLATEPATH . '/admin/_ad_overview.php');  }
	function premiumpress_steps_setup() 	{  			include(TEMPLATEPATH . '/admin/_ad_stepbystep.php');  }
	function premiumpress_admin_setup() 	{  			include(TEMPLATEPATH . '/admin/_ad_setup.php');  }
	function premiumpress_admin_display() 	{ 			include(TEMPLATEPATH . '/admin/_ad_design.php');  }
	function premiumpress_admin_submit() 	{ 			include(TEMPLATEPATH . '/admin/_ad_packages.php');  }
	function premiumpress_admin_members() 	{ 			include(TEMPLATEPATH . '/admin/_ad_members.php');  }
	function premiumpress_admin_orders() 	{    		global $wpdb;   include(TEMPLATEPATH . '/admin/_ad_orders.php');	}
	function premiumpress_admin_payments() 	{ 			include(TEMPLATEPATH . '/admin/_ad_payments.php'); }
	function premiumpress_admin_advertising() { 		include(TEMPLATEPATH . '/admin/_ad_advertising.php'); }
	function premiumpress_admin_tools() 	{ 			include(TEMPLATEPATH . '/admin/_ad_tools.php'); }
	function premiumpress_admin_analytics() { 			include(TEMPLATEPATH . '/admin/_ad_google.php'); }
	function premiumpress_admin_images() 	{ 			include(TEMPLATEPATH . '/admin/_ad_images.php'); } 
	function premiumpress_admin_emails() 	{ 			include(TEMPLATEPATH . '/admin/_ad_emails.php'); } 
	function premiumpress_admin_import_coupons() 	{ 	include(TEMPLATEPATH . '/admin/_ad_import_coupons.php'); } 
	function premiumpress_admin_checkout() 	{ 			include(TEMPLATEPATH . '/admin/_ad_checkout.php'); } 
	function premiumpress_admin_shipping() 	{ 			include(TEMPLATEPATH . '/admin/_ad_shipping.php'); } 
	function premiumpress_admin_import_products() 	{ 	include(TEMPLATEPATH . '/admin/_ad_import_products.php'); } 
	function premiumpress_admin_import_movies() 	{ 	include(TEMPLATEPATH . '/admin/_ad_import_movies.php'); } 
	function premiumpress_admin_import_jobs() 	{ 	include(TEMPLATEPATH . '/admin/_ad_import_jobs.php'); } 
	function premiumpress_admin_membership() 	{ 	include(TEMPLATEPATH . '/admin/_ad_membership.php'); } 
	function premiumpress_admin_plugins() 	{ 	include(TEMPLATEPATH . '/admin/_ad_plugins.php'); }
	function premiumpress_admin_gettingstarted() 	{ 	include(TEMPLATEPATH . '/admin/_ad_gettingstarted.php'); }
	
	function premiumpress_admin_import_hotel(){ include(TEMPLATEPATH . '/admin/_ad_import_hotels.php'); }
	function premiumpress_admin_import_deals(){ include(TEMPLATEPATH . '/admin/_ad_import_deals.php'); }
	
	function premiumpress_admin_import_calendar(){ include(TEMPLATEPATH . '/admin/_ad_import_calendar.php'); } 
	
	
	function premiumpress_admin_updates(){  $this->premiumpress_updates(); } 

 
 
	/**
	 * Magic hook: Define the admin menu labels
	 * @since 0.3.0
	 */ 
  
	function change_post_menu_label() {
	
		global $menu,$submenu;
		
		switch(strtolower(constant('PREMIUMPRESS_SYSTEM'))){
		
		case "resumepress": {
		
				$menu[5][0] = 'Resumes';
				$submenu['edit.php'][5][0] = 'Items';
				$submenu['edit.php'][10][0] = 'Add Item';
				$submenu['edit.php'][16][0] = 'Item Tags';
				echo '';
		} break;
		
		case "auctionpress": {
		
				$menu[5][0] = 'Auctions';
				$submenu['edit.php'][5][0] = 'Auctions';
				$submenu['edit.php'][10][0] = 'Add Auction';
				$submenu['edit.php'][16][0] = 'Auction Tags';
				echo '';
		} break;
		
		case "directorypress": {
		
				$menu[5][0] = 'Directory Listings';
				$submenu['edit.php'][5][0] = 'Listings';
				$submenu['edit.php'][10][0] = 'Add Listing';
				$submenu['edit.php'][16][0] = 'Listing Tags';
				echo '';
		} break;
		
		case "couponpress": {
		
				$menu[5][0] = 'Coupons';
				$submenu['edit.php'][5][0] = 'Coupons';
				$submenu['edit.php'][10][0] = 'Add Coupon';
				$submenu['edit.php'][16][0] = 'Coupon Tags';
				echo '';
		} break;
		
		case "classifiedstheme": {
		
				$menu[5][0] = 'Classifieds';
				$submenu['edit.php'][5][0] = 'Classifieds';
				$submenu['edit.php'][10][0] = 'Add Classified';
				$submenu['edit.php'][16][0] = 'Classified Tags';
				echo '';
		} break;
		
		
		case "realtorpress": {
		
				$menu[5][0] = 'Real Estate';
				$submenu['edit.php'][5][0] = 'Manage Real Estate';
				$submenu['edit.php'][10][0] = 'Add Real Estate';
				$submenu['edit.php'][16][0] = 'Real Estate Tags';
				echo '';
		} break;
		
		case "shopperpress": {
		
				$menu[5][0] = 'Products';
				$submenu['edit.php'][5][0] = 'Manage Products';
				$submenu['edit.php'][10][0] = 'Add Product';
				$submenu['edit.php'][16][0] = 'Product Tags';
				echo '';
		} break;
		
		
		case "moviepress": {
		
				$menu[5][0] = 'Videos';
				$submenu['edit.php'][5][0] = 'Manage Videos';
				$submenu['edit.php'][10][0] = 'Add Video';
				$submenu['edit.php'][16][0] = 'Video Tags';
				echo '';
		} break;
		
		case "employeepress": {
		
				$menu[5][0] = 'Jobs';
				$submenu['edit.php'][5][0] = 'Manage Jobs';
				$submenu['edit.php'][10][0] = 'Add Job';
				$submenu['edit.php'][16][0] = 'Job Tags';
				echo '';
		} break;
		
		case "comparisonpress": {
		
				$menu[5][0] = 'Products';
				$submenu['edit.php'][5][0] = 'Manage Products';
				$submenu['edit.php'][10][0] = 'Add Product';
				$submenu['edit.php'][16][0] = 'Product Tags';
				echo '';
		} break;
		
		case "agencypress": {
		
				$menu[5][0] = 'Profiles';
				$submenu['edit.php'][5][0] = 'Manage Profiles';
				$submenu['edit.php'][10][0] = 'Add Profile';
				$submenu['edit.php'][16][0] = 'Profile Tags';
				echo '';
		} break;		

		case "dealspress": {
		
				$menu[5][0] = 'Deals';
				$submenu['edit.php'][5][0] = 'Manage Deals';
				$submenu['edit.php'][10][0] = 'Add Deal';
				$submenu['edit.php'][16][0] = 'Deal Tags';
				echo '';
				
		} break;			
	
		}
	
	
	}


 
 
	/**
	 * Magic hook: Define the admin area CSS
	 * @since 0.3.0
	 */ 
 	
	function _admin_css(){
 
	?>   
	<style type="text/css">
	
/* =============================================================================
   GENERAL 
   ========================================================================== */
table {border-collapse: separate; border-spacing: 0;}
caption, th, td {text-align: left; font-weight: normal;}
blockquote:before, blockquote:after,
q:before, q:after {content: "";}
blockquote, q {quotes: "" "";}
li {list-style-type: none;}
hr {display: none;}
strong, b {font-weight: bold;}
em, i {font-style: italic;}
a { text-decoration: none; }
a img {border: none;}
.cw {width: 100%; overflow: hidden;}
.cw2 {overflow: hidden; height: 1%;}
.fl {float: left;}
.fr {float: right;}
.cleaner {clear: both; visibility: hidden; height: 0; overflow: hidden; line-height: 0; font-size: 0;}
 
 * html .clearfix {	    height: 1%; /* IE5-6 */	    }
*+html .clearfix {		display: inline-block; /* IE7not8 */		}
.clearfix:after { /* FF, IE8, O, S, etc. */	    content: ".";	    display: block;	    height: 0;	    clear: both;	    visibility: hidden;	    }
.clearfix:after {	content: ".";	display: block;	clear: both;	visibility: hidden;	line-height: 0;	height: 0;}
.clearfix {	display: inline-block;}
 html[xmlns] .clearfix {	display: block;} 
 

.ir {position: absolute; top: 0; left: 0; display: block; width: 100%; height: 100%;}
.tl {text-align: left !important;}
.tr {text-align: right !important;}
.tc {text-align: center !important;}
.ttop {vertical-align: top !important;}
.hand {cursor: hand; cursor: pointer;}
.a-hidden {position: absolute; top: -10000em;}
.first {border-left: 0 !important;}
.last {border-right: 0 !important; margin-right:0px !important}
	
/* =============================================================================
   CONTENT BOXES
   ========================================================================== */
   
.premiumpress_box .content {padding:10px;}
.grid400-left {width: 400px;padding-bottom: 10px;float: left;margin-right: 10px; margin-left:10px;} 	
.grid300-left {width: 340px;padding-bottom: 10px;float: left;margin-right: 10px; margin-left:10px;} 
.savebarb { border-top:1px solid #ddd; padding-top:10px; }

	.green_box {	-webkit-border-radius: 1px;	-moz-border-radius: 1px;	border-radius: 1px;	border: 1px solid #bbb;	margin-bottom: 20px;}
	.green_box_content h3 {  padding:0px; margin:0px; color:#006600; margin-top:-5px; }
	.green_box_content {	border: 1px solid #fff;	padding:10px;}
	.green_box {	background: #E2F2CE;	color: #466840;	border-color: #BFE098;}
 
 	.yellow_box {	-webkit-border-radius: 1px;	-moz-border-radius: 1px;	border-radius: 1px;	border: 1px solid #bbb;	margin-bottom: 20px; }
	.yellow_box_content h3 {	margin-bottom: 0px; color:#ebc203; }
	.yellow_box_content {	border: 1px solid #fff;	padding:10px;}
 
	.yellow_box {	background: #FFF9CC;	color: #736B4C;	border-color: #FFDB4F;}

/* =============================================================================
   FIELDSET STYLES + FORM FIELD STYLES
   ========================================================================== */
   
fieldset {border: 1px solid #ddd; margin-bottom: 15px; padding:10px; background:url(<?php echo PPT_FW_IMG_URI; ?>content_pane-gradient.gif) bottom left repeat-x; 

border: 1px solid #B9B9B9;
box-shadow: 0 1px 0 rgba(0, 0, 0, 0.11); border-radius: 2px
	}

.titleh { background:url( <?php echo PPT_FW_IMG_URI; ?>admin/titlebg.png) repeat-x; border:1px solid #ddd;	margin-left:-11px; margin-right:-11px; margin-top:-11px; 	height:40px; 	
position:relative; 
border: 1px solid #B9B9B9;
box-shadow: 0 1px 0 rgba(0, 0, 0, 0.11); border-radius: 2px; 
}

.titleintrobox { background:url('<?php echo PPT_THEME_URI; ?>/PPT/img/content_pane-gradient.gif') bottom left repeat-x; border-bottom:1px solid #ddd; min-height:350px; margin-left:-10px; margin-right:-10px; margin-bottom:10px; }
.titleintrobox .grid400-left { margin-top:10px; }
.helpsec { margin-left:20px; }
.helpsec li { list-style-type:circle !important;  }	
	
	
.titleh h3{ font-size:12px; color:#444; text-transform:uppercase; padding-left:10px; text-shadow: #fff 1px 1px 0;  }
  
.ppt-form-line{	display:block;	border-bottom:1px solid #E5E5E5;	padding:15px 0px;}
.ppt-labeltext{	display:block;	color:#3C5868;	float:left;	width:130px;	line-height:20px;	font-size:12px;	padding-top:3px;	padding-right:10px;}
.ppt-forminput{	width:200px; background:#fff url(<?php echo PPT_FW_IMG_URI; ?>admin/new/inputbg.png) repeat-x top;	border:1px solid #D2D4D4;	border-top:1px solid #A5A6A6;	border-radius:2px;	color:#4444;	font:12px Arial, Helvetica, sans-serif;	padding:7px 6px;}
.ppt-disable{	background:#fafafa;}
.ppt-forminput-active{	background:#fff url(<?php echo PPT_FW_IMG_URI; ?>admin/new/inputbg.png) repeat-x top;	border:1px solid #B5B7B7;	border-top:1px solid #8E8F8F;	border-radius:2px;	color:#666666;	font:12px Arial, Helvetica, sans-serif;	padding:7px 6px;	width:auto;}

.shortcuts-icons{	position:absolute;	display:block;	text-align:right;	right:10px;	top:8px;}
.shortcuts-icons a{	opacity:0.8;}
.shortcut{	background:url(<?php echo PPT_FW_IMG_URI; ?>admin/shortcut-normal.png) no-repeat top left;	width:25px;	display:block;	height:26px;	float:left;	margin-left:3px;}
.shortcut:hover{	background:url(<?php echo PPT_FW_IMG_URI; ?>admin/shortcut-hover.png) no-repeat top left;}
	.forminp input, .forminp select, .forminp textarea { margin-bottom: 9px !important;  border-top: 1px solid #ccc; border-left: 1px solid #ccc;  }.info {   border: 1px dotted #D8D2A9; padding: 10px; color: #333; }.forminp .checkbox { width:20px }.info a { color: #333; text-decoration: none; border-bottom: 1px dotted #333 }.info a:hover { color: #666; border-bottom: 1px dotted #666; }.warning { background: #FFEBE8; border: 1px dotted #CC0000; padding: 10px; color: #333; font-weight: bold; }/* front grid */.frontleft { width: 500px; }.frontright { width: 500px; } .gdpttitle span {	font-size: 12px;	vertical-align: 14px;	color: red;	font-weight: bold;	margin-left: 5px;}.gdrgrid .disabled { color: gray; }.gdrgrid .table {	background: #F9F9F9 none repeat scroll 0 0;	border-bottom: 1px solid #ECECEC;	border-top: 1px solid #ECECEC;	margin: 0 -9px 10px;	padding: 0 10px;	table-layout: fixed;}.gdrgrid div.inside { margin: 10px; }.gdrgrid p.sub {	color: #777777;	font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;	font-size: 13px;	font-style: italic;	padding: 5px 10px 15px;	margin: -12px;}.gdrgrid table { width: 100%; }.gdrgrid table tr.first th { color: #990000; font-weight: bold; }.gdrgrid table tr.first th, .gdrgrid table tr.first td { border-top: medium none; }.gdrgrid td {	border-top: 1px solid #ECECEC;	padding: 2px 0;	white-space: nowrap;	font-size: 18px;}.gdrgrid td.b, .gdrgrid th.first {	font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;	font-size: 16px;	padding-right: 6px;	white-space: nowrap;	text-align: right;}.gdrgrid td.first, .gdrgrid td.last { width: 1px; }.gdrgrid td.options {	text-align: right;	white-space: normal;	padding-right: 0 !important;}.gdrgrid td.t { white-space: normal; padding-bottom: 3px; }.gdrgrid td.t, .gdrgrid th {	color: #777777;	font-size: 12px;	padding-right: 12px;	padding-top: 6px;}.gdrgrid th {	text-align: left;	background-color: #ECECEC;	padding: 3px 5px;}.panel { padding: 4px; }.paneltext { font-size: 11px; vertical-align: baseline; }.postbox .hndle { cursor: default !important; }.regular-text { border: 1px solid #8CBDD5; }.rssSummary { font-size: 11px; }.rssTitle { background-color: #DFDFDF; padding: 1px 6px; } .ssclear { clear: both; }
 
/* =============================================================================
   TOOL TIP
   ========================================================================== */

.tooltip {	background-color:#000;	border:1px solid #fff;	padding:10px 15px;	width:200px;	display:none;	color:#fff;	text-align:left;	font-size:12px;-moz-box-shadow:0 0 10px #000;	-webkit-box-shadow:0 0 10px #000;}
 
/* =============================================================================
  NOTIFICATIONS
   ========================================================================== */

.msg {border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;border: 1px solid; margin: 0 0 15px 0; padding: 8px 10px 0 10px;max-width:840px;}
.msg p {margin: 0 0 8px 0; padding-left: 25px;}
.msg-ok {border-color: #a6d877; background: #d2ecba url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/msg-ok.png") repeat-x; color: #336801;}
.msg-error {border-color: #f3abab; background: #f9c9c9 url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/msg-error.png") repeat-x; color: #8d0d0d;}
.msg-warn {border-color: #d7e059; background: #f3f7aa url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/msg-warn.png") repeat-x; color: #6c6600;}
.msg-info {border-color: #9fd1f5; background: #c3e6ff url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/msg-info.png") repeat-x; color: #005898;}
.msg-ok p {background: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/led-ico/accept.png") 0 50% no-repeat;}
.msg-error p {background: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/led-ico/cross_octagon.png") 0 50% no-repeat;}
.msg-warn p {background: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/led-ico/exclamation_octagon_fram.png") 0 50% no-repeat;}
.msg-info p {background: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/led-ico/exclamation.png") 0 50% no-repeat;}
.error {color: #b70b0b;}
.ppnote { background:#dbffde; padding:10px; color:#078b10; min-width:280px; font-size:10px; border:1px silid #ddd;  }
.ppnote1 { background:#dbefff; padding:10px; color:#4787b8; min-width:280px; font-size:12px; border:1px silid #9cc3e0;  }
	
	
/* =============================================================================
   BUTTONS
   ========================================================================== */
   
.premiumpress_button {border: 1px solid #7a0000; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; background: #8e0f0f url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/red/button.gif") repeat-x; padding: 5px 9px 5px; text-shadow: #5d0101 1px 1px 0; color: #fff; cursor: pointer; }
.premiumpress_button:hover,
.premiumpress_button:focus,
.premiumpress_button:active {border-color: #272727; background: #2a2a2a url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/altbutton.gif") repeat-x; text-shadow: #000 1px 1px 0; color: #fff;}
/* alternative colors */
.altbox .premiumpress_button {border: 1px solid #272727; background: #2a2a2a url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/altbutton.gif") repeat-x; text-shadow: #000 1px 1px 0;}
.altbox .premiumpress_button:hover,
.altbox .premiumpress_button:focus,
.altbox .premiumpress_button:active {border-color: #7a0000; background: #8e0f0f url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/red/button.gif") repeat-x; text-shadow: #5d0101 1px 1px 0; color: #fff;}
.altbutton {border: 1px solid #272727; background: #2a2a2a url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/altbutton.gif") repeat-x; text-shadow: #000 1px 1px 0;}
.altbutton:hover,
.altbutton:focus,
.altbutton:active {border-color: #7a0000; background: #8e0f0f url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/red/button.gif") repeat-x; text-shadow: #5d0101 1px 1px 0; color: #fff;}
.altbox .altbutton {border: 1px solid #7a0000; background: #8e0f0f url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/red/button.gif") repeat-x; text-shadow: #5d0101 1px 1px 0;}
.altbox .altbutton:hover,
.altbox .altbutton:focus,
.altbox .altbutton:active {border-color: #272727; background: #2a2a2a url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/altbutton.gif") repeat-x; text-shadow: #000 1px 1px 0; color: #fff;}
	
/* =============================================================================
   POST.PHP / ADD EDIT PAGE CUSTOM STYLES
   ========================================================================== */

#post-type-select {				line-height: 2.5em;				margin-top: 3px;			}
#post-type-display {				font-weight: bold;			}
div.post-type-switcher {				border-top: 1px solid #eee;			}
	
	
/* =============================================================================
   PAGE NAVIGATION
   ========================================================================== */
	
.pagination {border-top: 1px solid #999; background: #fff url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/pagination.gif") repeat-x; text-align: center; color: #333 !important;}
.pagination ul {position: relative; top: -1px; padding: 12px 10px 6px;}
.pagination ul li {display: inline;}
.pagination a {border: 0; background: #ebebeb url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/pagination-item.gif") repeat-x; margin: 0 5px; padding: 6px 10px; color: #333 !important;
border-radius: 3px;   -moz-border-radius: 3px;   -webkit-border-radius: 5px;}
.pagination a:hover,
.pagination a:active,
.pagination a:focus {color: #b10d0d !important;}
.pagination strong {background: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/pagination-arrow.gif") 50% 0 no-repeat; padding: 15px 10px 8px;}	
	

/* =============================================================================
   ADMIN CUSTOM DESIGN STYLES
   ========================================================================== */

.ppt_layout_columns li { padding:0px; margin:0px; line-height:normal; border: 1px solid #E2E2E2; margin-right:13px;  padding:2px; float:left; background:#fff;  -webkit-box-shadow: 0 0 0px #cccccc; -moz-box-shadow: 0 0 0px #cccccc;  	-webkit-box-shadow: 0 0 0px #ccc;  	box-shadow:0px 0px 15px #ccc;}
.ppt_layout_columns li img { opacity:0.3; margin-top:2px;}
.ppt_layout_columns .active img { opacity:1; }
.ppt_layout_columns li img:hover { opacity:1; }
.ppt_layout_columns li a {   }
.ppt_layout_showme { color:#444; margin-top:10px; display:block; background:#fff; border:1px solid #ddd;width:110px; padding:5px;color:#666; letter-spacing:1px; font-size:10px; text-align:center; }

#gallery { padding:10px; background:#fff; border:1px solid #ddd; min-height:50px; }
#trash li a, #gallery li a { color:#FFFFFF; text-decoration:underline; }
#trash li, #gallery li { width: 310px; font-size:10px; color:#fff; float: left; margin: 5px 5px; padding:5px; background:#fff; border:1px solid #ddd; -webkit-box-shadow: 0 0 0px #cccccc; -moz-box-shadow: 0 0 0px #cccccc;  	-webkit-box-shadow: 0 0 0px #ccc;  	box-shadow:0px 0px 15px #ccc; 

	border:1px solid #fff;
		filter					: progid:DXImageTransform.Microsoft.gradient(startColorStr='#ce0202', EndColorStr='#a00000');
	background-image		: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ce0202), color-stop(1, #a00000));
	background-image		: -webkit-linear-gradient(top, #ce0202 0%, #a00000 100%);
	background-image		:    -moz-linear-gradient(top, #ce0202 0%, #a00000 100%);
	background-image		:     -ms-linear-gradient(top, #ce0202 0%, #a00000 100%);
	background-image		:      -o-linear-gradient(top, #ce0202 0%, #a00000 100%);
	background-image		:         linear-gradient(top, #ce0202 0%, #a00000 100%);
	border-bottom:1px solid #ddd;

}

#trash li .optionbox, #gallery li .optionbox {   }
#trash li p, #gallery li p { padding:0px; margin:0px; }
#trash li h4, #gallery li h4 { color:#fff; font-size:13px; padding:0px; margin:0px;  text-shadow: 0.1em 0.1em 0.05em #460000; padding-bottom:5px; padding-top:0px; }
#trash li div, #gallery li div { background:white;   float:left; margin-right:20px;-moz-border-radius: 5px;    -webkit-border-radius: 5px;    -khtml-border-radius: 5px;    border-radius: 5px; margin-bottom:10px; }
#trash li div img, #gallery li div img { margin:auto auto; display:block; padding:5px; }
#trash{ margin-top:10px; width: 350px; min-height: 300px; border:2px dashed #dedede; padding: 0.5em; float: left;    background:#efefef; }
#trash li { background:orange; }	
.videobox { border:1px solid #ddd; padding:10px; }	
	
	
/* =============================================================================
   EVERYTHING ELSE
   ========================================================================== */
   	.maintable { font-family:Arial,Verdana,sans-serif; background: ##F9F9F9; margin-bottom: 20px; padding: 10px 0px; border:1px solid #E6E6E6; width: 100%;}

	.mainrow { padding-bottom: 10px !important; border-bottom: 1px solid #E6E6E6 !important; float: left;   }
	.titledesc { font-size: 12px; font-weight:bold; width: 220px !important; margin-right: 20px !important; }
	  .forminp { width: 700px !important; valign: middle !important; }
 
.ico { border: 0 !important; }.ico-a { border: 0 !important; padding-left: 20px !important; }form.plain {padding: 0;} form.basic dl {width: 100%; overflow: hidden;}form.basic dl dt,form.basic dl dd {float: left;}form.basic dl dt {padding: 3px 5px 3px 0; width: 20%;}form.basic dl dd {padding: 3px 0 3px 5px; width: 76%;}label.check,label.radio {margin-right: 5px;}form small {color: #999;}input.txt,textarea {border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;border: 1px solid #999; background: #fff url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/txt.gif") repeat-x; padding: 5px 2px;}form.basic input.txt,form.basic textarea {width: 100%;}input.error,textarea.error {border-color: #d35757; background-image: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/txt-error.gif");}span.loading {background: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/upload.gif") 0 50% no-repeat; padding: 3px 0 3px 20px;}label,div.sep {display: block; margin-top: 6px;}label.check,label.radio {display: inline; margin-top: 0;}span.loading {margin-left: 10px;}ul.actions {margin: 0;}ul.actions li {display: inline; margin-right: 5px;}.premiumpress_box {float: left; width: 860px; margin: 0 20px 20px 0;}.premiumpress_box-25 {width: 225px;} .premiumpress_box-50 {width: 470px;}.premiumpress_box-75 {width: 715px;}.premiumpress_box-100 {min-width: 860px;}.premiumpress_boxin {box-shadow: #aaa 0 0 10px; -webkit-box-shadow: #aaa 0 0 10px; -moz-box-shadow: #aaa 0 0 10px; border: 1px solid #999; border-radius: 6px; -webkit-border-radius: 6px; -moz-border-radius: 6px; background: #fff;}.premiumpress_box .header {background: #3d3d3d url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/headerbox.png") repeat-x;border-top: 1px solid #444;border-radius: 5px 5px 0 0;   -moz-border-radius-topleft: 5px;   -moz-border-radius-topright: 5px;   -webkit-border-top-left-radius: 5px;   -webkit-border-top-right-radius: 5px;position: relative; margin: -1px -1px 0 -1px; padding: 7px 0 9px 20px;}.altbox .header {border-top-color: #be0000; background: #8e0f0f url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/red/altheaderbox.png") repeat-x;}.premiumpress_box .header h3 {position: relative; top: 2px; display: inline; font-size: 150%; color: #fff; text-shadow: #151515 0 1px 0; }.altbox .header h3 {text-shadow: #6c0000 0 1px 0;}.premiumpress_box .header .premiumpress_button {margin-left: 15px;}

.premiumpress_box .header ul {position: absolute; right: 9px; bottom:0; top:6px; }
.premiumpress_box .header ul li {display: inline;  }
.premiumpress_box .header ul a { background: #777; border: 0; float: left; margin: 0 0 0 7px; padding: 8px 13px 6px; color: #fff; font-size:14px; 

border-top-left-radius: 5px; border-top-right-radius: 5px; -moz-border-radius-topright: 5px; -moz-border-radius-topleft: 5px; }


.premiumpress_box .header ul a.active,.premiumpress_box .header ul a:hover,.premiumpress_box .header ul a:focus,.premiumpress_box .header ul a:active {background: #fff url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/headertab.png") repeat-x; color: #444;}.altbox .header ul a {background-color: #d44848;}.altbox .header ul a.active,.altbox .header ul a:hover,.altbox .header ul a:focus,.altbox .header ul a:active {background: #fff url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/red/altheadertab.png") repeat-x; color: #8e0f0f;}.premiumpress_box .content table {width: 100%;}.premiumpress_box .content table th,
.premiumpress_box .content table td {padding: 10px 10px 8px 10px;}
.ws-dropdown-popup-inner td { padding:0px !important;}
.premiumpress_box .content table th {text-align: left; font-weight: normal;}.premiumpress_box .content table tr.even th,.premiumpress_box .content table tr.even td {background: #f5f5f5;}.altbox .content table tr.even th,.altbox .content table tr.even td {background: #fff0f0;}.premiumpress_box .content table th.first,.premiumpress_box .content table td.first {padding-left: 20px;}.premiumpress_box .content table thead th,.premiumpress_box .content table thead td {border-left: 1px solid #f2f2f2; border-right: 1px solid #d5d5d5; background: #ddd url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/thead.gif") repeat-x; text-shadow: #fff 0 1px 0;}.premiumpress_box .content table tbody tr.first th,.premiumpress_box .content table tbody tr.first td {border-top: 1px solid #bbb;}.altbox .content table tbody {color: #732222;}.premiumpress_box .content table a.ico-comms {border: 0; background: url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/red/ico-tablecomms.gif") 50% 60% no-repeat; padding: 10px; color: #fff;}.premiumpress_box .content table tfoot th,.premiumpress_box .content table tfoot td {border-top: 1px solid #ccc; background: #fff url("<?php bloginfo('template_url'); ?>/PPT/img/premiumpress/tfoot.gif") repeat-x;}.premiumpress_box .content ul.simple li {clear: both; padding: 10px 20px 8px 20px; overflow: hidden;}.premiumpress_box .content table tr.even th,.premiumpress_box .content ul.simple li.even {background: #f5f5f5;}.altbox .content table tr.even th,.altbox .content ul.simple li.even {background: #fff0f0;}.premiumpress_box .content ul.simple strong {float: left; font-weight: normal;}.premiumpress_box .content ul.simple span {float: right;}.premiumpress_box .content .grid {}.premiumpress_box .content .grid .line {border-bottom: 1px solid #ddd; width: 100%; overflow: hidden;}.altbox .content .grid .line {border-bottom-color: #f4d3d3;}.premiumpress_box .content .grid .even {background: #f5f5f5;}.altbox .content .grid .even {background: #fff0f0;}h2 { margin-bottom: 20px; }.title { margin: 0px !important; background: #DFDFDF repeat-x scroll left top; padding: 10px; font-family: Georgia, serif; font-weight: normal !important; letter-spacing: 1px; font-size: 18px; }.container { background: #EAF3FA; padding: 10px; }
	 
<?php if(isset($_GET['page']) && $_GET['page'] == "quickhelp"  ){ ?>
.panel{	background-color: #ffffff;	border: 1px solid #dbe6ee;	padding: 10px;	-moz-border-radius: 3px;	-webkit-border-radius: 3px;	border-radius: 3px;	width:980px;}.step{	float: left;	position: relative;	margin-left: -20px;	width: 351px;	height: 43px;	font-size: 16px;	padding-left: 20px;	padding-top: 18px;	background-image: url("<?php echo PPT_FW_IMG_URI; ?>sprite_with_icons.png");	background-repeat: no-repeat;	outline: none;}.step1, .step2, .step3{width: 237px; }.stepLabel{	position: absolute;	top: 19px;	right: 30px;}.stepLabelLast{	position: absolute;	top: 19px;	right: 25px;}.content{	clear: both;	padding: 0px;	line-height: 150%;}.nextPrevButtons { border-top:1px solid #ddd; padding-top:20px;}.nextPrevButtons .button:first-child{	margin-right: 10px;}.nextPrevButtons .button{float: left;	display: block;	width: 150px;	height: 34px;	padding-top: 12px;	text-align: center;	background:none; background-image: url("<?php echo PPT_FW_IMG_URI; ?>sprite_buttons.png");	background-repeat: no-repeat;	cursor: pointer; border:0px; font-size:14px !important}.nextPrevButtons .inactiveButton{	background-position: -10px -310px;	color: #ffffff;}.boxStart{	float: left;	width: 6px;	height: 60px;	background: url("<?php echo PPT_FW_IMG_URI; ?>sprite_with_icons.png") no-repeat;} .step-green-blue{	color: #ffffff;	background-position: -10px -170px;}.step1-green-blue, .boxStart-green-blue{	background-position: -10px -90px;}.nextPrevButtons .activeButton-green-blue{	color: #ffffff;	background-position: -10px -130px;}.nextPrevButtons .activeButton-green-blue:hover{	color: #ffffff;	background-position: -10px -70px;}
	.bar{	width:770px;	height: 52px;	border-right:0px;background: url("<?php echo PPT_FW_IMG_URI; ?>aspp_bar.png") no-repeat;	color: #5596bc;	margin-bottom: 15px;	margin-top: 0px;	padding-left: 30px;	padding-top: 18px;}
	
	.title{	margin-top: 15px;	font-size: 26px;	color: #666;}.button_green{	background-image: url("<?php echo PPT_FW_IMG_URI; ?>live_preview_img/aspp_button_green.png");}.button_blue{	background-image: url("<?php echo PPT_FW_IMG_URI; ?>live_preview_img/aspp_button_blue.png");}.p2Step1, .p2Step2, .p2Step3, .p2Step4{	width: 173px;}.p3Step1, .p3Step2, .p3Step3, .p3Step4{	width: 173px;}.p4Step1{	width: 202px;}.p4Step2{	width: 160px;}.p4Step3{	width: 135px;}.p4Step4{	width: 100px;}.p4Step5{	width: 85px;}.p5Step1, .p5Step2, .p5Step3{	width: 240px;}.p6Step1, .p6Step2, .p6Step3, .p6Step4{	width: 175px;}.p7Step1, .p7Step2{	width: 371px;}.p8Step1, .p8Step2, .p8Step3{	width: 240px;}
<?php } ?>
	
</style>
<!--[if IE]>
<style>
 
</style>
<![EndIf]-->
<?php
	
	}


 

	/**
	 * Magic hook: Define the update tool for PremiumPress
	 * @since 0.3.0
	 */ 

 
	function premiumpress_updates(){  


	$msg = $this->PremiumPress_ValidateMe(strip_tags(get_option("license_key"))); 
	$whatNow = explode("**",$msg);
	$showBox = $whatNow[0];
	$showMessage = $whatNow[1];
	if($showBox ==0){
		update_option("license_key","");
	} 
	
	include(TEMPLATEPATH."/PPT/class/class_update.php");
	$updateME = new PremiumPress_Update; 
 
	PremiumPress_Header(); 

	?>       
	<div class="premiumpress_box premiumpress_box-50 altbox"> 
	<div class="premiumpress_boxin"><div class="header"><h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/new/block7.png" align="middle"> Latest News </h3></div>
	<form class="fields" style="padding:10px;">
	<fieldset >
	<legend><strong>Latest PremiumPress News</strong></legend>
	<?php $this->premiumpress_rssfeed("http://www.premiumpress.com/feed/?post_type=blog_type"); ?>
	</ul>
    </fieldset>
	</form>	
	</div></div> 


    <div class="premiumpress_box premiumpress_box-50 altbox"> 
    <div class="premiumpress_boxin"><div class="header"><h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/new/block5.png" align="middle"> Helpful Information </h3>
    <a class="premiumpress_button" href="javascript:void(0);" onclick="PPHelpMe('update')">Help Me</a> 
    
    </div>
    <form class="fields" style="padding:10px;">
    
    <?php 
    
        if(isset($_GET['updateme'])){
        
            echo $updateME->STARTUPDATE();
        
        }else{
        
            echo $updateME->Check();
        } ?>
    
    <fieldset >
    
    
    
    
    <legend><strong>Theme Information </strong></legend>
    
  
    
    <table style="width:400px;">
    
        
    
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Name</td>
            <td class="forminp"><?php if(defined('PREMIUMPRESS_SYSTEM')){ echo PREMIUMPRESS_SYSTEM; }elseif(defined('PREMIUMPRESS_PLUGIN')){ echo PREMIUMPRESS_PLUGIN; } ?></td>
        </tr>
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Version Number</td>
            <td class="forminp"><?php if(defined('PREMIUMPRESS_VERSION')){ echo PREMIUMPRESS_VERSION;}elseif(defined('PREMIUMPRESS_PLUGIN_VERSION')){ echo PREMIUMPRESS_PLUGIN_VERSION; } ?></td>
        </tr>
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Last Updated</td>
            <td class="forminp"><?php if(defined('PREMIUMPRESS_VERSION_DATE')){  echo PREMIUMPRESS_VERSION_DATE; }elseif(defined('PREMIUMPRESS_PLUGIN_VERSION_DATE')){ echo PREMIUMPRESS_PLUGIN_VERSION_DATE; } ?></td>
        </tr>
        <?php if(!defined('PREMIUMPRESS_DEMO')){ ?>
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">License Key</td>
            <td class="forminp"><?php echo get_option("license_key");?> - <a href="admin.php?page=ppt_admin.php&resetkey=1">reset</a></td>
        </tr>
        <?php } ?>
        
        
    
    
    </table>
    
    </fieldset><br />
    
    <fieldset >
    <legend><strong>Support Information </strong></legend>
    
    <table class="" style="width:400px;">
    
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Manuals</td>
            <td class="forminp"><a href="http://www.premiumpress.com/documentation/?adminlink=<?php if(defined('PREMIUMPRESS_SYSTEM')){ echo PREMIUMPRESS_SYSTEM; }elseif(defined('PREMIUMPRESS_PLUGIN')){ echo PREMIUMPRESS_PLUGIN; } ?>" target="_blank">Visit Website</a></td>
        </tr>
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Forums</td>
            <td class="forminp"><a href="http://www.premiumpress.com/forum/?adminlink=<?php if(defined('PREMIUMPRESS_SYSTEM')){ echo PREMIUMPRESS_SYSTEM; }elseif(defined('PREMIUMPRESS_PLUGIN')){ echo PREMIUMPRESS_PLUGIN; } ?>" target="_blank">Visit Website</a></td>
        </tr>
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Video Tutorials</td>
            <td class="forminp"><a href="http://www.premiumpress.com/videos/?adminlink=<?php if(defined('PREMIUMPRESS_SYSTEM')){ echo PREMIUMPRESS_SYSTEM; }elseif(defined('PREMIUMPRESS_PLUGIN')){ echo PREMIUMPRESS_PLUGIN; } ?>" target="_blank">Visit Website</a></td>
        </tr>
    
    </table>
    </fieldset><br />
    
    
    
    <fieldset >
    <legend><strong>Cron Information </strong></legend>
 
    <table class="" style="width:400px;">
    
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Hourly</td>
            <td class="forminp"><?php echo date('l jS \of F Y h:i:s A',wp_next_scheduled( "ppt_hourly_event"));?></td>
        </tr>
        
        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Twice Daily</td>
            <td class="forminp"><?php echo date('l jS \of F Y h:i:s A',wp_next_scheduled( "ppt_twicedaily_event"));?></td>
        </tr>    
     
         <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;">Daily</td>
            <td class="forminp"><?php echo date('l jS \of F Y h:i:s A',wp_next_scheduled( "ppt_daily_event"));?></td>
        </tr> 


        <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;"> <input style="margin:0 !important;" onclick="document.getElementById('fgformval').value=<?php if(get_option('ppt_debug_cron') !="1"){ echo "1"; }else{ echo "0"; } ?>;document.fgform1.submit();" type="checkbox" value="1" <?php if(get_option('ppt_debug_cron') == "1"){ print "checked=checked"; } ?> /> Debug</td>
            <td class="forminp">Send an email every time the cron is executed. <br /> <small>(email: <?php echo get_option('admin_email'); ?> )</small></td>
        </tr>
        
        <?php /*
          <tr class="ppt-form-line">
            <td class="titledesc" style="width:250px;"> <input style="margin:0 !important;" onclick="document.getElementById('fgformval2').value=<?php if(get_option('ppt_adminhelp') !="1"){ echo "1"; }else{ echo "0"; } ?>;document.fgform2.submit();" type="checkbox" value="1" <?php if(get_option('ppt_adminhelp') == "1"){ print "checked=checked"; } ?> /> Admin Help</td>
            <td class="forminp"> Turn off PremiumPress help menus.</td>
        </tr>
		*/ ?>
        
       
          
        <?php
        
        if(isset($_GET['rcron'])){
        wp_clear_scheduled_hook('ppt_hourly_event');
        wp_clear_scheduled_hook('ppt_twicedaily_event');
        wp_clear_scheduled_hook('ppt_daily_event');	
        }	    
    
        ppt_event_activation(); // REGISTER CRON SCHEDULES
        ?>
    
    </table>
    <p>Click here to <a href="admin.php?page=updates&rcron=1">reset the cron times.</a></p>
    </fieldset><br />
     
    </form>
    </div></div> 
     
<form method="post" target="_self" id="fgform" name="fgform1">
<input name="submitted" type="hidden" value="yes" />
<input type="hidden" value=""  name="adminArray[ppt_debug_cron]" id="fgformval" />      
</form>

<form method="post" target="_self" id="fgform2" name="fgform2">
<input name="submitted" type="hidden" value="yes" />
<input type="hidden" value=""  name="adminArray[ppt_adminhelp]" id="fgformval2" />      
</form>
  
     
    <?php } 



	/**
	 * Magic hook: Define the update tool for PremiumPress
	 * @since 0.3.0
	 */  

	function premiumpress_admin_licensekey_form(){
	
	if(isset($_POST['action_key'])){
	
		$msg = $this->PremiumPress_ValidateMe(strip_tags($_POST['premiumpress_key']));
		$whatNow = explode("**",$msg);
	
		$showBox = $whatNow[0];
		$showMessage = $whatNow[1];
	
		if($showBox ==1){
			update_option("license_key",strip_tags($_POST['premiumpress_key']));
		}
	}
	
	if(!isset($showBox) ){
		$showBox = 3;
		$showMessage = $this->hexToStr("506c6561736520656e74657220796f7572205072656d69756d507265737320564950206c6963656e7365206b657920696e746f2074686520626f782062656c6f772e496620796f752061726520756e737572652077686174207468697320697320706c65617365206c6f67696e20746f20796f757220564950206163636f756e74206174207777772e7072656d69756d70726573732e636f6d");
	}
	
	?>
	<br />
	<div class="premiumpress_box premiumpress_box-50 altbox"> 
	<div class="premiumpress_boxin"><div class="header"><h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/new/block7.png" align="middle"> License Key</h3></div>
	<form class="fields" style="padding:10px;" method="post" target="_self">
	<input type="hidden" name="action_key" value="1">
	<fieldset >
	<legend><strong>VIP License Key</strong></legend>
	<div class="msg <?php if($showBox == 0){ ?>msg-error<?php }elseif($showBox == 1){ ?>msg-ok<?php }else{ ?>msg-info<?php } ?>"><p><?php echo $showMessage; ?></p></div> 
	<?php if($showBox != 1){ ?><label>Enter License Key</label>
	<input name="premiumpress_key" type="text" class="txt" value="<?php echo get_option("license_key"); ?>">             
	<input type="submit" class="premiumpress_button" value="save" style="color:white;">
	<?php } ?>
    
    <?php if($showBox == 1){ ?><a href="admin.php?page=setup" style="font-size:18px; background-color:yellow;">Click here to get started</a> <?php } ?>
	</fieldset>
	
	
	</form>
	</div></div> 
	
	<?php 
	
	}  









function PremiumPress_ValidateMe($key){

	if(!is_numeric($key)){
		return "0**".$this->hexToStr("496e76616c6964204c6963656e7365204b6579");
	}
	
	$msg = $this->PremiumPress_HelpFiles($key);
	
	return $msg;

}
function PremiumPress_HelpFiles($helpme){
	 
		$helpme = $helpme;
		$installed_host = $this->hexToStr("636c69656e74732e7072656d69756d70726573732e636f6d");
		$installed_directory=""; 
		$query_string	 = $this->hexToStr("6c6963656e73653d").$helpme;		
		$query_string	.= $this->hexToStr("266163636573735f69703d").$_SERVER['SERVER_ADDR'];
		$query_string	.= $this->hexToStr("266163636573735f7468656d653d").PREMIUMPRESS_SYSTEM;
		$query_string	.= $this->hexToStr("266163636573735f686f73743d").$_SERVER['HTTP_HOST'];			
		$query_string	.= "&version=".PREMIUMPRESS_VERSION."&version_date=".PREMIUMPRESS_VERSION_DATE;	
		
		$data=$this->PremiumPress_exec_socket($installed_host, $installed_directory, "/validate.php", $query_string);
		$parser=@xml_parser_create('');
		@xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		@xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		@xml_parse_into_struct($parser, $data, $values, $tags);
		@xml_parser_free($parser);

		$returned=$values[0]['attributes'];
 

		if ($returned['status']=="invalid")
			{
				$error="0**".$returned['message'];
			}
		
		elseif ($returned['status']=="suspended")
			{
				$error="0**".$returned['message'];
			}

		else{
			
			$error="1**".$returned['message'];
		}
		
		return $error;
}

function PremiumPress_exec_socket($http_host, $http_dir, $http_file, $querystring)
	{
			 
	$fp=@fsockopen($http_host, 80, $errno, $errstr, 5); 
	if (!$fp) { return false; }
	else
		{
		$header="POST ".($http_dir.$http_file)." HTTP/1.0\r\n";
		$header.="Host: ".$http_host."\r\n";
		$header.="Content-type: application/x-www-form-urlencoded\r\n";
		$header.="User-Agent: PremiumPress (www.premiumpress.com)\r\n";
		$header.="Content-length: ".@strlen($querystring)."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$querystring;

		$data=false;		
		@fputs($fp, $header);
		
		$status=@socket_get_status($fp);
		while (!@feof($fp)&&$status) 
			{ 
			$data.=@fgets($fp, 1024);
			
			$status=@socket_get_status($fp);
			}
		@fclose ($fp);
 
		if (!$data) { return false; }		
		$data=explode("\r\n\r\n", $data, 2);
		return $data[1];
		}
}
function hexToStr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}





function premiumpress_rssfeed($link) {	error_reporting( 0 ); wp_widget_rss_output($link, array('items' => 10, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1)); }

 
	
} // END PREMIUMPRESS ADMIN CLASS FILE










function PremiumPress_Header(){ 

global  $wpdb, $PPT, $post; 

//if(get_option('ppt_new_theme_version')){ // new version available
//echo '<div class="msg msg-warn"><p>A new version of '.PREMIUMPRESS_SYSTEM.' is available! <strong><a href="admin.php?page=updates&updateme=1">Click here to update now</a></strong></p></div>';
//}

if(get_option('permalink_structure') == "" || get_option('permalink_structure') != "/%postname%/"){

echo '<div class="msg msg-warn"><p>You need to set your permalinks to "Post name" <strong><a href="options-permalink.php">Click here to update now</a></strong></p></div>';
}

// SYSTEM CHECKS
switch(strtolower(constant('PREMIUMPRESS_SYSTEM'))){

	case "auctionpress": {
	$MakePagesArray = array("checkout_url","submit_url","messages_url","dashboard_url","contact_url","manage_url");
	} break;
	
	case "directorypress": {
	$MakePagesArray = array("submit_url","messages_url","dashboard_url","contact_url","manage_url");
	} break;

	case "couponpress": {
	$MakePagesArray = array("submit_url","messages_url","dashboard_url","contact_url","manage_url");
	} break;


	case "classifiedstheme": {
	$MakePagesArray = array("submit_url","messages_url","dashboard_url","contact_url","manage_url");
	} break;
	
	case "shopperpress": {
	$MakePagesArray = array("checkout_url", "dashboard_url","contact_url");
	} break;
	
	case "moviepress": {
	$MakePagesArray = array("dashboard_url","contact_url");
	} break;
			
	default: { $MakePagesArray = array(); }

}
	?>
    <form method="post" action="admin.php?page=setup" enctype="multipart/form-data" name="PPTSUPPOTALTERME" id="PPTSUPPOTALTERME">
	<input type="hidden" value="2" name="showThisTab"   />    
    </form>
    <?php 
foreach($MakePagesArray as $page){

	if(get_option($page) == ""){
	

	
	echo '<div class="msg msg-warn"><p>You have NOT setup your '.str_replace("_"," ",str_replace("dashboard","My Account ",$page)).'! <strong><a href="javascript:void(0);" onclick="document.PPTSUPPOTALTERME.submit();">Click Here To Do It Now</a></strong></p></div>';
	
	}

} 
		

}	

?>