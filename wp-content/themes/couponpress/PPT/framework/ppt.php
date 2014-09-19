<?php

class PPT extends PPT_API {
 	
/* =============================================================================
	  CLASS LOAD FUNCTION // V7 // 16TH MARCH
	========================================================================== */

function PPT( $args = array() ) {
	 
	global $pagenow;
	
		// ADD MENU + BACKGROUND SUPPORT
		add_theme_support('nav_menus');
		add_theme_support( 'post-thumbnails' ); 
		add_theme_support( 'custom-background' );  
		register_nav_menu('PPT-CUSTOM-MENU-PAGES', 'Main Navigation Bar');		
		  
		// LOAD IN NEW PAGE SETUP FOR LOGIN SYSTEM
		if ( $pagenow == "wp-login.php"  &&  $_GET['action'] != 'logout' && $_GET['action'] != "rp" 
		&& $_GET['action'] != "resetpass" &&  !isset($_GET['key']) ) {			
			add_action('init', array( $this, 'ppt_login' ) , 98); 			
		}		
		//LOAD IN CUSTOM POST TYPES
		add_action( 'init', array( $this, 'ppt_post_types' ) );		
		
		// STOP DIRECT ADMIN ACCESS
		add_action('init', array( $this, 'prevent_admin_access' ), 0);
		
		add_action('wp', array( $this, 'ppt_mobile' ) );
		
		
		// last login
		add_action('wp_login', array( $this,'ppt_last_login' ) );			

		// Magic hook for the admin.
		if ( is_admin() ){
			$this->callback( $this, 'admin' ); // loads the ppt-admin.php 
		}else{
		
			// BUILD IN CUSTOM QUERY STRING
			 
			add_filter('query_string', array( $this, 'ppt_query_string' ) );
			add_filter('pre_get_posts', array( $this, 'ppt_alter_query' ) );
			 
			$this->ppt_setup();
 		} 
		
		// ADD IN FILTERS
		add_filter( 'post_thumbnail_html', array( $this, 'ppt_thumbnail_fallback' ) , 20, 5 );
		//add_filter( 'get_avatar', array( $this, 'ppt_bbpress_get_avatar' ) , 10, 5 );
	

} // END PPT 

/* =============================================================================
	CORE SETUP FUNCTION // V7 // 16TH MARCH
	========================================================================== */

function ppt_setup() {
	
	global $PPT, $pagenow; 
	
 		// load the advanced search options
		require_once (PPT_FW_CLASS . 'class_search.php');	
		add_action('init',array('PPT_S','init'));
		add_shortcode( 'premiumpress_search', array(&$this,'process_shortcode') );
 		
		// Load the schedule options
		add_action('ppt_hourly_event', 'do_this_event_hourly');
		add_action('ppt_twicedaily_event', 'do_this_event_twicedaily');
		add_action('ppt_daily_event', 'do_this_event_daily');  
 
			// Load in the filter for search queries 
			add_filter('posts_orderby', array($this, 'query_orderby') ); 
		 
			// add in custom order by values for search pages
			if(isset($_GET['s']) || isset($_GET['search-class']) ){			
				add_filter('posts_join', array($this, 'query_join') );
				add_filter('posts_where', array($this, 'query_where') );
			}
		 
		 
		// LOAD IN REDIRECT FOR COMMENTS		
		add_filter('get_comment_link', array( $this, 'redirect_after_comment' ));
		
		// Load user area top admin menu bar
		add_action( 'admin_bar_menu', array( $this, 'add_menu_admin_bar' ) ,  70);
		
		// Load all the javascript/styles into the theme wp_head		 
		add_action( 'wp_loaded', array( $this, '_enqueue_assets' ) ); 		 		
			
		// Load any widgets for the theme
		add_action( 'widgets_init', array( $this, '_widgets_init' ) );
		add_action( 'wp_head', array( $this, '_wp_head' ) );		
		
		// remove actions for theme header
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_generator');
		
		// Load footer objects
		// Load all the javascript/styles into the theme wp_head 
		add_action( 'wp_footer', array( $this, '_wp_footer' ) ); 
		
		
 
}  // END SETUP FUNC

/* =============================================================================
	  WORDPRESS CUSTOM THUMBNAIL FALLBACK
	========================================================================== */

function ppt_thumbnail_fallback( $html, $post_id, $post_thumbnail_id, $size, $attr ) {

    if ( empty( $html ) ) {
        // return you fallback image either from post of default as html img tag.
		
		return premiumpress_image($post_id ,"",array('alt' => $post->post_title,  'link' => true )); //, 'class' => 'listImage', 'width' => '160', 'height' => '110', 'style' => 'auto'
		 
    }
    return $html;
}

function ppt_bbpress_get_avatar($avatar = '', $id_or_email, $size = '96', $default = '', $alt = false){
   
   global $wpdb, $userdata;
   
   // SEEMS MOST OF (EMAIL) IS REFERING TO SELF
   
   if(is_numeric($id_or_email)){ }else{ $id_or_email = $userdata->ID; }
   
	// GET USER PHOTO
	$img = get_user_meta($id_or_email, "pptuserphoto",true);
	if($img == ""){
			$avatar = get_avatar($id_or_email,52);
	}else{
			$avatar = "<img src='".get_option('imagestorage_link').$img."' class='avatar avatar-{$size}{$author_class} photo' height='{$size}' width='{$size}' />";
	}   
  	return $avatar;
	
  }

/* =============================================================================
	  WORDPRESS QUERY STRING
	========================================================================== */
 
function ppt_alter_query($query){
 
global $userdata;
 
      if( $query->is_main_query() ){
		
		if(isset($_GET['pptfavs']) && $_GET['pptfavs'] == "yes" && $userdata->ID ){
		
			$query->set('category_name','');
			$query->set('post_type', 'ppt_wishlist');
			$query->set('meta_key','type');
			$query->set('meta_value','wishlist');
			$query->set('author', $userdata->ID);
			
		}elseif(isset($_GET['pptfavs']) && $_GET['pptfavs'] == "compare" && $userdata->ID ){
		
			$query->set('category_name','');
			$query->set('post_type', 'ppt_wishlist');
			$query->set('meta_key','type');
			$query->set('meta_value','compare');
			$query->set('author', $userdata->ID);
			
		}else{		
		 
		 // STRIP THE DEFAULT TEXT FROM THE SEARCH BOX 	
		 $query->set('s',str_replace("Enter a keyword..","",$query->query_vars['s']));			 
			
		}
			  
      }	 
}

function ppt_query_string($query_string) { 
 
    global $pagenow, $wpdb, $PPT;
	
 
	// ONLY PERFORM THIS QUERY IF ITS FOR THE CATEGsORY PAGE
	if( substr($query_string,0,13) == "category_name" || substr($query_string,0,6) == "store=" || substr($query_string,0,4) == "tag=" || substr($query_string,0,2) == "s=" || substr($query_string,0,9) == "location=" || substr($query_string,0,8) == "network=" || isset($_GET['orderby']) ){
 
		// LOAD IN WP DEFAULT QUERY STRING AND EDIT IT 
		$query_string = $PPT->BuildSearchString($query_string);		
	 
	 } 
 
	// STRIPPING THE QUERY STING FOR CUSTOM TAXONOMIE DATA	
	if(strpos($query_string, "taxonomy=article") === false && strpos($query_string, "article=") === false ) {  }else{ $GLOBALS['setflag_article']=1; } // STRIPS TYPE POST FOR ARTICLES
 
    return $query_string; 
}  


/* =============================================================================
	  WORDPRESS INIT HOOKS // V7 // 16TH MARCH
	========================================================================== */
	
function ppt_init(){

	global $wpdb, $PPT, $PPTDdesign, $PPTMobile;


	/*  FILE UPLOAD TOOL // V7 // 16TH MARCH */
	if(isset($_FILES['pptfileupload']) && !empty($_FILES['pptfileupload']) ){
		$responce = premiumpress_upload($_FILES['pptfileupload']);
		echo $responce; 
		die();				
	}
 
} // END FUN PPT_INIT


function ppt_mobile(){
	
	global $wpdb, $PPT, $PPTDdesign, $PPTMobile;
	
	/*  MOBILE DETECT // V7 // 16TH MARCH  */	
	if($PPTMobile->_check() != false && get_option('ppt_mobile') == 1){
	if(isset($_GET['hide_mobile_view']) && $_GET['hide_mobile_view'] == 1){ $_SESSION['hidemobileview'] = true; } 
		if(!isset($_SESSION['hidemobileview'])){
			$PPTMobile->start();
			die();
		}
	}  
}



/* =============================================================================
   CUSTOM QUERIES // SEARCH PAGE // Fix Wordpress Bug - Wish they would fix this!
   ========================================================================== */
 
function query_join($arg) {

global $wpdb;

	// CHECK THE TABLE IS NOT ALREADY JOINED
	if(strpos($arg,"INNER JOIN $wpdb->postmeta") !== false || isset($_GET['pptfavs']) ){		 
		return $arg;
	}
 
	// CHECK FOR DEFAULT THEME ORDER BY VALUES	
	$ppt_default_orderby = get_option('display_defaultorder');	
	 
	switch($ppt_default_orderby){ 
		case "meta_value&meta_key=price*desc": 
		case "meta_value&meta_key=price*asc":
		case "meta_value&meta_key=packageID*desc":
		case "meta_value&meta_key=packageID*asc":
		case "meta_value&meta_key=featured*desc": { $arg .= "INNER JOIN $wpdb->postmeta ON ( $wpdb->postmeta.post_id = $wpdb->posts.ID ) "; } break;

	}	

	return $arg;
}

function query_where($arg) {
 
global $wpdb;

//$arg = str_replace(" (wp_posts.post_status = 'publish')"," (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'private')",$arg); 
 
 	if(isset($_GET['pptfavs'])){
	return $arg;
	}
	// CHECK FOR DEFAULT THEME ORDER BY VALUES	
	$ppt_default_orderby = get_option('display_defaultorder');	
	
	switch($ppt_default_orderby){		  
		
		case "meta_value&meta_key=price*desc": { $arg .= " AND $wpdb->postmeta.meta_key = 'price'"; } break;
		case "meta_value&meta_key=price*asc":  { $arg .= " AND $wpdb->postmeta.meta_key = 'price'"; } break;
		case "meta_value&meta_key=packageID*desc":
		case "meta_value&meta_key=packageID*asc": { $arg .= " AND $wpdb->postmeta.meta_key = 'packageID'"; } break;
		case "meta_value&meta_key=featured*desc": { $arg .= " AND $wpdb->postmeta.meta_key = 'featured'"; } break;

	}	

	return $arg;
} 

function query_orderby($sort) { 

 	global $wpdb, $query_string;  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	 
	// CHECK FOR DEFAULT THEME ORDER BY VALUES	
	// ONLY ADD +0 IF THE VALUE SEARCHED FOR IS NUMERICAL
	$ppt_default_orderby = get_option('display_defaultorder');
	
	if(isset($_GET['pptfavs'])){
	return $sort;
	}
	
	switch($ppt_default_orderby){		  
		
		case "meta_value&meta_key=price*desc": ;
		case "meta_value&meta_key=price*asc": ;
		case "meta_value&meta_key=packageID*desc":
		case "meta_value&meta_key=packageID*asc": {		
		
			// QUICK FIX TO ADD NUMBERIC VALUES TO ORDER BY FIELDS (PRICE ETC)
			if(strpos($sort,"postmeta.meta_value") !== false){
				$sort	= str_replace("postmeta.meta_value","postmeta.meta_value+0",$sort);
				return $sort;
			}		
		
		} break;

	}	
	 
		
		
		$array_of_numeric_fields = array('ending','price','old_price','hits'); 	
		if(isset($_GET['key']) && in_array($_GET['key'],$array_of_numeric_fields)){ $_GET['quick'] = $_GET['key']; }
		
		// QUICK SEARCH FOR OLDER COPIES		   
        if ( isset($_GET['quick']) && (is_tag() OR is_category() OR is_author() OR is_date() OR is_home()) ) {          
            $ee = explode(" ",$sort);
			$ef = explode(".",$ee[0]);			 
           if (in_array($_GET['quick'],$array_of_numeric_fields) && $ee[0] == $wpdb->prefix."postmeta.meta_value" ) {		 
                $sort = "" .  $ee[0] . "+0 ".$ee[1];				  
           }
        }  
		
	// CHECK FOR DEFAULT THEME ORDER BY VALUES	
	$ppt_default_orderby = get_option('display_defaultorder');
	//echo $sort."<--".$ppt_default_orderby;
	switch($ppt_default_orderby){
	
		case "date*desc": {  } break;
		case "date*asc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.post_date ASC",$sort); } break;		
		case "author*asc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.post_author ASC",$sort); } break;
		case "author*desc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.post_author DESC",$sort); } break;
		case "title*asc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.post_title ASC",$sort); } break;
		case "title*desc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.post_title DESC",$sort); } break;
		case "modified*asc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.post_modified ASC",$sort); } break;
		case "modified*desc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.post_modified DESC",$sort); } break;
		case "ID*asc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.ID ASC",$sort); } break;
		case "ID*desc": { $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->posts.ID DESC",$sort); } break;
		
		case "meta_value&meta_key=price*desc":
		case "meta_value&meta_key=packageID*desc":
		case "meta_value&meta_key=featured*desc": { if($paged > 1 || isset($_GET['s']) || isset($_GET['search-class']) ){ $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->postmeta.meta_value+0 DESC",$sort);  } } break;
		
		case "meta_value&meta_key=price*asc":		 
		case "meta_value&meta_key=packageID*asc": {  if($paged > 1 || isset($_GET['s']) || isset($_GET['search-class']) ){ $sort = str_replace("$wpdb->posts.post_date DESC","$wpdb->postmeta.meta_value+0 ASC",$sort);  }  } break;
	 
	}		
	
	
 
	// RETURN	
    return  $sort; 
}

/* =============================================================================
	  LOGIN FUNCTION // V7 // 16TH MARCH
	========================================================================== */
	
function ppt_login() {

	switch($_GET["action"]) {
			case 'lostpassword' :
			case 'retrievepassword' :
				cp_password();
				break;
			case 'register': {
				$GLOBALS['IS_REGISTER'] = true; // set flag
				cp_show_register();
			} break;
			case 'login':
			default:
				cp_show_login();
				break;
	}
	die();
} // END LOGIN	
	
/* =============================================================================
	  CUSTOM POST TYPES // V7 // 16TH MARCH
	========================================================================== */

function ppt_post_types() {

	switch(strtolower(constant('PREMIUMPRESS_SYSTEM'))){	
	
		case "employeepress" : {
		
		  register_post_type( 'ppt_resume', 
			array(
			'hierarchical' => true,	
			  'labels' => array('name' => 'Resumes'),
			  'public' => true,
			  'query_var' => true,
			  'show_ui' => true,
			  'rewrite' => array('slug' => 'resume'),
			   'supports' => array ( 'title', 'editor','author', 'custom-fields', 'excerpt' ),
			  'menu_icon' => get_template_directory_uri()."/PPT/img/admin/resume.png") );
			  
		  /*register_post_type( 'ppt_exams', 
			array(
			'hierarchical' => true,	
			  'labels' => array('name' => 'exam'),
			  'public' => true,
			  'query_var' => true,
			  'show_ui' => true,
			  'rewrite' => array('slug' => 'exam'),
			   'supports' => array ( 'title', 'author', 'custom-fields', 'excerpt' ),
			  'menu_icon' => get_template_directory_uri()."/PPT/img/admin/exam.png",	     
	 
			) ); */
			
			register_post_type( 'ppt_proposal', 
					array(
					'hierarchical' => true,	
					  'labels' => array('name' => 'Proposals'),
					  'public' => true,
					  'query_var' => true,
					  'show_ui' => false, // dont show UI
					  'rewrite' => array('slug' => 'proposal')	,
					   'supports' => array ( 'title',  'custom-fields'  ),    
			 
				) );
				
			$labels = array(
			'name' =>  'Budget' ,
			'singular_name' =>  'Budget' ,
			'search_items' =>  __( 'Search Budget' ),
			'all_items' => __( 'All Budgets' ),
			'parent_item' => __( 'Parent Budget' ),
			'parent_item_colon' => __( 'Parent Budget' ),
			'edit_item' => __( 'Edit Budget' ), 
			'update_item' => __( 'Update Budget' ),
			'add_new_item' => __( 'Add New Budget' ),
			'new_item_name' => __( 'New Budget' ),
			'menu_name' => __( 'Budget' ),	  ); 
			register_taxonomy( 'budget', 'post', array( 'hierarchical' => true, 'labels' => $labels, 'query_var' => true, 'rewrite' => true ) );
				
		} break;
		
 
		
		case "comparisonpress" : {
		
		  register_post_type( 'ppt_compare', 
			array(
			'hierarchical' => true,	
			  'labels' => array('name' => 'Compared Products'),
			  'public' => true,
			  'query_var' => true,
			  'show_ui' => true,
			  'rewrite' => array('slug' => 'compare'),
			   'supports' => array ( 'title', 'editor','author', 'custom-fields', 'excerpt' ),
			  'menu_icon' => get_template_directory_uri()."/PPT/img/admin/compare.png",
				 
	 
			) );	
		
		} break; 
		
		default : {
		
		
		
		} break;
	
	}
 


// WISHLIST // FAVORITES
register_post_type( 'ppt_wishlist', array('hierarchical' => true,	 'labels' => array('name' => 'Wishlist'),  'public' => true, 'query_var' => true, 'show_ui' => false, 'rewrite' => array('slug' => 'wishlist')	) );

// ALERTS
register_post_type( 'ppt_alert',  array( 'hierarchical' => true,	 'labels' => array('name' => 'Alert'),  'public' => true,  'query_var' => true, 'show_ui' => false, 'supports' => array (  'custom-fields' ) ) );
 	
	
	
	
 
 	if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "moviepress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress" ){
	  register_post_type( 'ppt_message', 
		array(
		'hierarchical' => true,	
		  'labels' => array('name' => 'Messages'),
		  'public' => true,
		  'query_var' => true,
		  'show_ui' => false,
		  'exclude_from_search' => true,
      	  'rewrite' => array('slug' => 'message'),
		   'menu_icon' => get_template_directory_uri()."/PPT/img/admin/messages.png",
		    'supports' => array (  'custom-fields' ),  
		     
 
		) );
	}
	
	if( strtolower(constant('PREMIUMPRESS_SYSTEM')) == "auctionpress" || strtolower(PREMIUMPRESS_SYSTEM) == "employeepress"){
		
	  register_post_type( 'ppt_feedback', 
		array(
		'hierarchical' => true,	
		  'labels' => array('name' => 'Feedback'),
		  'public' => true,
		  'query_var' => true,
		  'show_ui' => true,
		  'exclude_from_search' => true,
      	  'rewrite' => array('slug' => 'feedback')	,
		   'supports' => array ( 'title', 'editor','author', 'custom-fields', 'excerpt' ),  
 
		) );
	} 
		  
	
 
 
	
	if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "comparisonpress" ){
		$labels = array(
		'name' =>  'Stores' ,
		'singular_name' =>  'Stores' ,
		'search_items' =>  __( 'Search Stores' ),
		'all_items' => __( 'All Stores' ),
		'parent_item' => __( 'Parent Stores' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item' => __( 'Edit Stores' ), 
		'update_item' => __( 'Update Stores' ),
		'add_new_item' => __( 'Add New Stores' ),
		'new_item_name' => __( 'New Stores' ),
		'menu_name' => __( 'Stores' ),	  ); 
		
		register_taxonomy( 'store', 'post', array( 'hierarchical' => true, 'labels' => $labels, 'query_var' => true, 'rewrite' => true ) );  
		//register_taxonomy( 'store', 'post', array( 'hierarchical' => true, 'labels' => $labels, 'query_var' => true, 'rewrite' => array('slug' => '', 'with_front' => false, 'hierarchical' => true),) );
		
		register_taxonomy( 'network', 'post', array( 'hierarchical' => true, 'label' => 'Affiliate Networks', 'query_var' => true, 'rewrite' => true ) ); 
		
		}
		
		
		
		if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "shopperpress" ){
		$labels = array(
		'name' =>  'Country/State/City' ,
		'singular_name' =>  'Genre' ,
		'search_items' =>  __( 'Search Country/State/City' ),
		'all_items' => __( 'All Country/State/City' ),
		'parent_item' => __( 'Parent Country/State/City' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item' => __( 'Edit Country/State/City' ), 
		'update_item' => __( 'Update Country/State/City' ),
		'add_new_item' => __( 'Add New Country/State/City' ),
		'new_item_name' => __( 'New Country/State/City' ),
		'menu_name' => __( 'Country/State/City' ),	  ); 
		register_taxonomy( 'location', 'post', array( 'hierarchical' => true, 'labels' => $labels, 'query_var' => true, 'rewrite' => true ) );
		}	
		
		 
   	register_taxonomy( 'article', 'article_type', array( 	
	 
	'labels' => array(
		'name' => 'Article Categories' ,
		'singular_name' => _x( 'Article Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Article Categorys' ),
		'popular_items' => __( 'Popular Article Categorys' ),
		'all_items' => __( 'All Article Categorys' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Article Category' ), 
		'update_item' => __( 'Update Article Category' ),
		'add_new_item' => __( 'Add Article Category' ),
		'new_item_name' => __( 'New Article Category Name' ),
		'separate_items_with_commas' => __( 'Separate Article Categorys with commas' ),
		'add_or_remove_items' => __( 'Add or remove Article Categorys' ),
		'choose_from_most_used' => __( 'Choose from the most used Article Categorys' )
		) , 
	'hierarchical' => true,	
	'query_var' => true,
	'show_ui' => true,
	'has_archive' => true, 
	'rewrite' => array('slug' => 'article-category') ) );
	
	
	
	register_post_type( 'article_type',
		array(
		  'labels' => array('name' => 'Article Manager', 'singular_name' => 'Articles' ), 
      	  'rewrite' =>  array('slug' => 'article'),
		  'public' => true,
		  'supports' => array ( 'title', 'editor','author', 'revisions', 'post-formats', 'trackbacks', 'comments','excerpt', 'thumbnail', 'custom-fields', ),
		  'menu_icon' => get_template_directory_uri()."/PPT/img/admin/article.png", 
		 // 'taxonomy' => array('category', 'post_tag'),
		)
	  ); 
 
		  
   	register_taxonomy( 'faq', 'faq_type', array( 	
	 
	'labels' => array(
		'name' => 'FAQ Categories' ,
		'singular_name' => _x( 'FAQ', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search FAQ\'s' ),
		'popular_items' => __( 'Popular FAQ\'s' ),
		'all_items' => __( 'All FAQs' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit FAQ' ), 
		'update_item' => __( 'Update FAQ' ),
		'add_new_item' => __( 'Add New FAQ' ),
		'new_item_name' => __( 'New FAQ Name' ),
		'separate_items_with_commas' => __( 'Separate FAQ\'s with commas' ),
		'add_or_remove_items' => __( 'Add or remove FAQ\'s' ),
		'choose_from_most_used' => __( 'Choose from the most used FAQ\'s' )
		) , 
	'hierarchical' => true,		
	'query_var' => false,
	'show_ui' => true,
	
	  ) );
	
	
	
	register_post_type( 'faq_type',
		array(
		  'labels' => array('name' => 'FAQ Manager', 'singular_name' => 'FAQ Manager' ), 
      	  'rewrite' =>  array('slug' => 'faq'),
		  'public' => true,
		  'exclude_from_search' => true,
		  'supports' => array ( 'title', 'editor',   ) ,
		  'menu_icon' => get_template_directory_uri()."/PPT/img/admin/faq.png", 
		)
	  );
	  
 
	 // THIS IS USED TO CREATE THE DEFAULT ARTICLE CATEGORY FOR WEBSITE RESETS 
	if(isset($_POST['RESETME']) && $_POST['RESETME'] == "yes"){	

		wp_insert_term("Sample Category 1", 'article',array('cat_name' => "Sample Category 1", 'description' => "This is an example article category description"  ));
 		wp_insert_term("Sample Category 2", 'article',array('cat_name' => "Sample Category 2", 'description' => "This is an example article category description"  ));
		wp_insert_term("Sample Category 3", 'article',array('cat_name' => "Sample Category 3", 'description' => "This is an example article category description"  ));
		wp_insert_term("Sample Category 4", 'article',array('cat_name' => "Sample Category 4", 'description' => "This is an example article category description"  ));		
		wp_insert_term("Sample Category 5", 'article',array('cat_name' => "Sample Category 5", 'description' => "This is an example article category description"  ));
		wp_insert_term("Sample Category 6", 'article',array('cat_name' => "Sample Category 6", 'description' => "This is an example article category description"  ));		
 
		//wp_insert_term("Sample Category 1", 'faq',array('cat_name' => "Sample Category 1", 'description' => "This is an example faq category description"  ));
 		//wp_insert_term("Sample Category 2", 'faq',array('cat_name' => "Sample Category 2", 'description' => "This is an example faq category description"  ));
		//wp_insert_term("Sample Category 3", 'faq',array('cat_name' => "Sample Category 3", 'description' => "This is an example faq category description"  ));
			
	} 
	  
	    
	 	$taxArray = get_option("ppt_custom_tax");
		if(!is_array($taxArray)){ return; }
	 	foreach($taxArray as $tax){
		
			if($tax['name'] != "" && strlen($tax['name']) > 2){
			
			$NewTax = strtolower(htmlspecialchars(str_replace(" ","-",str_replace("&","",str_replace("'","",str_replace('"',"",str_replace('/',"",str_replace('\\',"",strip_tags($tax['name'])))))))));
			
			$labels = array(
			'name' =>  $tax['title'] ,
			'singular_name' =>  $tax['title'] ,
			'search_items' =>  __( 'Search '.$tax['title'] ),
			'all_items' => __( 'All '.$tax['title'] ),
			'parent_item' => __( 'Parent '.$tax['title'] ),
			'parent_item_colon' => __( 'Parent '.$tax['title'].':' ),
			'edit_item' => __( 'Edit '.$tax['title'] ), 
			'update_item' => __( 'Update '.$tax['title'] ),
			'add_new_item' => __( 'Add New '.$tax['title'] ),
			'new_item_name' => __( 'New '.$tax['title'] ),
			'menu_name' => __( $tax['title'] ),	  ); 
			
			 register_taxonomy( $NewTax, 'post', array( 'hierarchical' => true, 'labels' => $labels, 'query_var' => true, 'rewrite' => true ) );  
		
			}
		 
	 	}
 	  
} // END PPT_POST_TYPES	
	
	
/* =============================================================================
	PREVENT ADMIN ACCESS // V7 // 16TH MARCH
	========================================================================== */
	
function prevent_admin_access() {

global $pagenow;		
 
	if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin') !== false) {
		 
		$userdata = wp_get_current_user(); 
			
		if(!user_can($userdata->ID, 'administrator') && ( !user_can($userdata->ID, 'contributor') ) ){
			  
		if ('profile.php' == basename($_SERVER['SCRIPT_NAME']) ){ // || 'index.php' == basename($_SERVER['SCRIPT_NAME'])
					wp_die(__('Ops! You do not have sufficient permissions to access this page.'));
		}
				
		add_action('admin_menu', array( $this,'remove_menus' ) );
			
		}
	}
}
/* =============================================================================
	RECORD USER LOGIN // V7 // 16TH MARCH
	========================================================================== */

function ppt_last_login($login) {

	global $user_ID;
	
	$user = get_userdatabylogin($login);	
	update_usermeta($user->ID, 'last_login', current_time('mysql'));
		
	 if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
	}
	
	update_usermeta($user->ID, 'last_ip', $ip);
} 







	
	
	
	/**
	 * Ads user login date when user logs in
	 *
	 * @since 3.3.1
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
 
	
	 
	function redirect_after_comment($location)
	{
	 
	return preg_replace("/#comment-([\d]+)/", "?commentstab=1", $location);
	}
 
	
	/**
	 * Customizes the admin display bar 
	 *
	 * @since 0.3.0
	 */	
	function add_menu_admin_bar() {
	
		global $wp_admin_bar;
	 
		if ( !is_super_admin() || !is_admin_bar_showing() )
			exit;
		$wp_admin_bar->add_menu( array( 'id' => 'theme_options', 'title' =>__( constant('PREMIUMPRESS_SYSTEM') , strtolower(constant('PREMIUMPRESS_SYSTEM')) ), 'href' => admin_url('admin.php')."?page=setup" ) ); 		
		$wp_admin_bar->add_menu( array( 'id' => 'pp-updates', 'title' =>__( 'Check for Updates', 'ppt-updates' ), 'href' => "http://www.premiumpress.com/?piwik_campaign=ThemeLink-".strtolower(constant('PREMIUMPRESS_SYSTEM'))."&piwik_kwd=admin-menu-bar") );	
	   
	}
	
	
	/**
	 * This removed the dashbord link from members
	 */	
	function remove_the_dashboard () {
		if (!current_user_can('level_0') || !current_user_can('level_1') || !current_user_can('level_2')) {
			return;
		} else {
	 
		global $menu, $submenu, $user_ID;
				$the_user = new WP_User($user_ID);
				reset($menu); $page = key($menu);
				while ((__('Dashboard') != $menu[$page][0]) && next($menu))
						$page = key($menu);
				if (__('Dashboard') == $menu[$page][0]) unset($menu[$page]);
				reset($menu); $page = key($menu);
				while (!$the_user->has_cap($menu[$page][1]) && next($menu))
						$page = key($menu);
				if (preg_match('#wp-admin/?(index.php)?$#',$_SERVER['REQUEST_URI']) && ('index.php' != $menu[$page][2]))
						wp_redirect(get_option('siteurl') . '/wp-admin/post-new.php');
		}
	}			

 	/**
	 * Magic hook: Define your own after_setup_theme method
	 *
	 * @since 0.3.0
	 */
	
	function _enqueue_assets_v8($currentPage = "") {
	
	global $post, $pagenow, $page;

	wp_enqueue_script( 'jquery' );	 // <-- load WP jquery  
 
	// LOAD IN THE NEW FRAMEWORK
	wp_register_script( 'PPTv8_1',  PPT_V8_URI.'javascripts/foundation.min.js');
	wp_enqueue_script( 'PPTv8_1' );	
	
	wp_register_script( 'PPTv8_2',  PPT_V8_URI.'javascripts/app.js');
	wp_enqueue_script( 'PPTv8_2' );

	// FRAMEWORK
	wp_register_style( 'PPTv8_c1', PPT_V8_URI.'stylesheets/framework.css');
	wp_enqueue_style( 'PPTv8_c1' );		
	 
	wp_register_style( 'PPTv8_c2', PPT_V8_URI.'stylesheets/foundation.min.css');
	wp_enqueue_style( 'PPTv8_c2' );
	
	// Load the custom child theme CSS
	$default_styles = get_option('theme-style');
	if($default_styles == ""){ $default_styles = "styles.css"; }
	wp_register_style( 'PPT3', PPT_CUSTOM_CHILD_URL.'css/'.$default_styles);
	wp_enqueue_style( 'PPT3' );	
 
		//wp_register_style( 'PPT1', PPT_THEME_URI.'/PPT/css/css.premiumpress.css');
		//wp_enqueue_style( 'PPT1' );	 
	
	} 
	function _enqueue_assets($currentPage = "") {
	
	global $post, $pagenow, $page;	
	 
		wp_enqueue_script( 'jquery' );	 // <-- load WP jquery 
        
        wp_register_script( 'PPTajax',  PPT_FW_AJAX_URI.'actions.js');
		wp_enqueue_script( 'PPTajax' );	
		 
		if($currentPage == "front_page" || $currentPage == "home"){ 
	
			// Load the home page full content slider
			
			if(get_option('PPT_slider') == "s1"){ 
			
				$SLIDERSTYLE = get_option('PPT_slider_style');
				
				if($SLIDERSTYLE == 1){
				
					echo "<link rel='stylesheet' type='text/css' href='".PPT_THEME_URI."/PPT/js/slide/css.slider1.css' media='screen' />";
 					echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/support/jquery.easing.1.3.min.js"></script>';
					echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/slider1.js"></script>';
					echo '<script type="text/javascript"> jQuery(document).ready( function() { jQuery(".slider9").wtListRotator({ }); } );  </script>';
				
				}elseif($SLIDERSTYLE == 2 || $SLIDERSTYLE == 3 || $SLIDERSTYLE == 4 || $SLIDERSTYLE == 5){
				
					echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/slider2-3-4-5.js"></script>';
					echo "<link rel='stylesheet' type='text/css' href='".PPT_THEME_URI."/PPT/js/slide/css.slider".$SLIDERSTYLE.".css' media='screen' />";
					echo "<link rel='stylesheet' type='text/css' href='".PPT_THEME_URI."/PPT/js/slide/css.slider".$SLIDERSTYLE.".ie.css' media='screen' />";
					echo "<script type='text/javascript'>jQuery(document).ready(function() { jQuery('.myslider').slideshow({ width:'960',height:'360'});});</script>";
					
				}elseif($SLIDERSTYLE == 7){	
				
					echo "<link rel='stylesheet' type='text/css' href='".PPT_THEME_URI."/PPT/js/slide/css.slider7.css' media='screen' />";
					echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/support/jquery.easing.1.3.min.js"></script>';
					echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/support/jquery.transform-0.9.3.min.js"></script>';
					echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/slider7.js"></script>';				
					echo "<script type='text/javascript'>var settings = {imageWidth: 500,imageHeight: 250,slideshowLayout: 'verticalRound',slideshowDirection:'forward',
					maxRandomUpAngle: -25,minRandomUpAngle: -15,maxRandomDownAngle: 10,minRandomDownAngle: -10,upPartDuration: 500,downPartDuration: 500,slideshowDelay: 3000,slideshowOn:true,
					captionToggleSpeed:600,captionOpenDelay:300,useControls:false};jQuery(document).ready(function() {jQuery.stackGallery(settings);settings = null;});</script>";
					
				}elseif($SLIDERSTYLE == 8){	
				
				echo "<link rel='stylesheet' type='text/css' href='".PPT_THEME_URI."/PPT/js/slide/css.slider8.css' media='screen' />";
				echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/support/jquery.touchwipe.min.js"></script>';
				echo '<script type="text/javascript" src="'.PPT_THEME_URI.'/PPT/js/slide/slider8.js"></script>';		
				echo '<script type="text/javascript" charset="utf-8"> jQuery(document).ready(function() { jQuery(\'#oneByoneB\').oneByOne({className: \'oneByOne1\',easeType: \'random\',slideShow: true});  }); </script> ';
					 
				 
				} 
				 
			}
	 	 
        }   // end if
		 
		
		// Load custom headers for the login page
		if($pagenow == "wp-login.php" && $_GET['action'] != "logout" && $_GET['action'] != "rp" && $_GET['action'] != "resetpass"){
		
			echo "<script type='text/javascript' src='".$GLOBALS['bloginfo_url']."/wp-includes/js/jquery/jquery.js'></script>";
			echo "<script type='text/javascript' src='".PPT_THEME_URI."/PPT/js/jquery.selectBox.min.js'></script>";
			echo "<script type='text/javascript' src='".PPT_THEME_URI."/PPT/js/custom.js'></script>";
			 
			echo "<link rel='stylesheet' type='text/css' href='".PPT_THEME_URI."/PPT/css/css.premiumpress.css' media='screen' />";
			
			// Load the custom child theme CSS
			$default_styles = get_option('theme-style');
			if($default_styles == ""){ $default_styles = "styles.css"; } 
			
			echo "<link rel='stylesheet' type='text/css' href='".PPT_CHILD_URL."styles.css' media='screen' />";
			echo "<link rel='stylesheet' type='text/css' href='".PPT_CUSTOM_CHILD_URL."css/".$default_styles."' media='screen' />";
			echo "<link rel='stylesheet' type='text/css' href='".PPT_THEME_URI."/PPT/js/jquery.selectBox.css' media='screen' />";
			
			$this->CustomStyles();
 
		}else{		
		// Load the PremiumPress FrameWork CSS
		wp_register_style( 'PPT1', PPT_THEME_URI.'/PPT/css/css.premiumpress.css');
		wp_enqueue_style( 'PPT1' );	
 
		 
		//if( isset($GLOBALS['flag-home']) ) {
		// Load the home page CSS
		wp_register_style( 'PPTHome', PPT_THEME_URI.'/PPT/css/css.homepage.css');
		wp_enqueue_style( 'PPTHome' );
		
		//}			
		
		if(!defined('STOPLOAD_CSS')){ 
		// Load the PremiumPress Core theme CSS
		wp_register_style( 'PPT2', PPT_CHILD_URL.'styles.css');
		wp_enqueue_style( 'PPT2' );
		}
		
		// Load the PremiumPress FrameWork CSS
		wp_register_style( 'PPT122',  PPT_THEME_URI.'/PPT/js/jquery.selectBox.css');
		wp_enqueue_style( 'PPT122' );	
		
		wp_register_script( 'PPTajax142',  PPT_THEME_URI.'/PPT/js/jquery.selectBox.min.js');
		wp_enqueue_script( 'PPTajax142' );	
 		
		// Load the custom child theme CSS
		$default_styles = get_option('theme-style');
		if($default_styles == ""){ $default_styles = "styles.css"; }
		wp_register_style( 'PPT3', PPT_CUSTOM_CHILD_URL.'css/'.$default_styles);
		wp_enqueue_style( 'PPT3' );	 
  
		
		// Load Wordpress Style Sheet
		wp_register_style( 'PPT4', PPT_THEME_URI.'/style.css');
		wp_enqueue_style( 'PPT4' );	
		}
		


	 
	}
 

	/**
	 * Magic hook: Define your own wp_head method
	 *
	 * @since 0.3.0
	 */
	function _wp_head() {
	
	global  $wpdb, $PPT, $post;
 
	 // Wordpress doesnt load enqueue options after the int 
	 // so to keep everything togehter we call it after the int has run
	 $f = ppt_get_request();	
	 
	 if(defined('PPT_V8')){
	 $this->_enqueue_assets_v8($f[0]);
	 }else{
	 $this->_enqueue_assets($f[0]);
	 }
	 
	 // WARNING ABOUT LICENSE KEY	 
	 // if(get_option('license_key') ==""){	 
	 // echo "<div style='padding:20px; font-size:16px; background:red;border:1px solid #444; color:white; font-family:Verdana, Arial, Helvetica, sans-serif'>
	// ".PREMIUMPRESS_SYSTEM." installed but not activated. Please <a href='".get_home_url()."/wp-admin/admin.php?page=ppt_admin.php' style='color:white;'><u><b>CLICK HERE</b></u></a> and enter your license key.</div>"; }
	  
	 
	
	// Load custom header content for our themes
	switch(strtolower(PREMIUMPRESS_SYSTEM)){
	
	
	case "auctionpress":
	case "agencypress":	
	case "couponpress":	
	case "comparisonpress":
	case "classifiedstheme":
	case "realtorpress": 
	case "directorypress":
	case "bookingpress":
	case "employeepress":
	 { 
 
	 
	 if(!isset($post->ID)){ continue; } // SKIP
	 
	 // 1. CHECK TO SEE IF LONG/LATT IS AVAILABLE
	 $long	= get_post_meta($post->ID, "longitude", true);
	 $lat 	= get_post_meta($post->ID, "latitude", true);
	 $loglat = get_post_meta($post->ID, "map-loglat", true);
	
	 $showlongmap = false;
	 // 2. LOAD IN MAP DATA
	 if($long != "" && $lat !="" && $long != '0'){
	 	$mapAddress = $lat.",".$long;
		$showlongmap = true;
	 }elseif(strlen($loglat) > 2){
		 //lat:54.29293240463316,long:-0.4108783920898986
		 $mapAddress = str_replace("lat:","",str_replace("long:","",$loglat));	
		 $showlongmap = true;	
	 }else{	 
	 	$mapAddress = get_post_meta($post->ID, "map_location", true);	 
	 }
		
	 	  
        // Load Google map include
        if(is_single() && strlen($mapAddress) > 2 && $PPT->CanShow($post->ID, "map_location") ){  //   
		
		$GLOBALS['SINGLEMAP'] = true;
		?>
         <script type='text/javascript' src='<?php echo PPT_PATH; ?>js/jquery.maps.js'></script> 
         <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>            
         <script src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.9/src/infobox_packed.js" type="text/javascript"></script>
            
                <script type="text/javascript"> 
                    function loadsinglemap(){
                        var mymap = new MeOnTheMap({
                            container: "map_sidebar2",
                            html: "<?php echo str_replace('"',"",$post->post_title); ?>",
                            address: "<?php echo str_replace('"','',$mapAddress); ?>",
							<?php if($showlongmap){ ?>longlatmap: true,<?php } ?>
                            zoomLevel: 15
                        });                        
                    } 
					jQuery(document).ready(function() {  loadsinglemap();  })
					
                </script>
            
        <?php } 		
		
		 
	} break; 

	
	} 
	
 

		$F = get_option('faviconLink');	
		
		if(strlen($F) > 5){  ?>
		
		<link rel="shortcut icon" href="<?php echo $F; ?>" type="image/x-icon" />
		 
	<?php }  
		
	// Load the Google Webmaster code 
	echo stripslashes(get_option("google_webmaster_code"));
  
	
	//INSET CUSTOM STYLES
	if(defined('PPT_V8')){  }else{ $this->CustomStyles(); }
			
	// NEW CUSTOM HEADER DATA 7+
	echo stripslashes(get_option("ppt_custom_metatags"));
	
	
	 
}	

function CustomStyles(){

global $PPT;

	// CUSTOM WEBSITE STYLES ADDED IN 6.9+	
	$layouttypes = get_option('ppt_layout_styles');
	
		$fontsA = array();
 
	$fontsA["anton"]['google'] = true;
	$fontsA["anton"]['name'] = '"Anton", arial, serif';
 
	$fontsA["arial"]['google'] = false;
	$fontsA["arial"]['name'] = 'Arial, "Helvetica Neue", Helvetica, sans-serif';	
 
	$fontsA["arial_black"]['google'] = false;
	$fontsA["arial_black"]['name'] = '"Arial Black", "Arial Bold", Arial, sans-serif';	
 
	$fontsA["arial_narrow"]['google'] = false;
	$fontsA["arial_narrow"]['name'] = '"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif';
 
	$fontsA["cabin"]['google'] = true;
	$fontsA["cabin"]['name'] = 'Cabin, Arial, Verdana, sans-serif';
 
	$fontsA["cantarell"]['google'] = true;
	$fontsA["cantarell"]['name'] = 'Cantarell, Candara, Verdana, sans-serif';
 
	$fontsA["cardo"]['google'] = true;
	$fontsA["cardo"]['name'] = 'Cardo, "Times New Roman", Times, serif';
 
	$fontsA["courier_new"]['google'] = false;
	$fontsA["courier_new"]['name'] = 'Courier, Verdana, sans-serif';
 
	$fontsA["crimson_text"]['google'] = true;
	$fontsA["crimson_text"]['name'] = '"Crimson Text", "Times New Roman", Times, serif';
 
	$fontsA["cuprum"]['google'] = true;
	$fontsA["cuprum"]['name'] = '"Cuprum", arial, serif';
 
	$fontsA["dancing_script"]['google'] = true;
	$fontsA["dancing_script"]['name'] = '"Dancing Script", arial, serif';
 
	$fontsA["droid_sans"]['google'] = true;
	$fontsA["droid_sans"]['name'] = '"Droid Sans", "Lucida Grande", Tahoma, sans-serif';
 
	$fontsA["droid_mono"]['google'] = true;
	$fontsA["droid_mono"]['name'] = '"Droid Sans Mono", Consolas, Monaco, Courier, sans-serif';
 
	$fontsA["droid_serif"]['google'] = true;
	$fontsA["droid_serif"]['name'] = '"Droid Serif", Calibri, "Times New Roman", serif';
 
	$fontsA["georgia"]['google'] = false;
	$fontsA["georgia"]['name'] = 'Georgia, "Times New Roman", Times, serif';
 
	$fontsA["im_fell_dw_pica"]['google'] = true;
	$fontsA["im_fell_dw_pica"]['name'] = '"IM Fell DW Pica", "Times New Roman", serif';
 
	$fontsA["im_fell_english"]['google'] = true;
	$fontsA["im_fell_english"]['name'] = '"IM Fell English", "Times New Roman", serif';
 
	$fontsA["inconsolata"]['google'] = true;
	$fontsA["inconsolata"]['name'] = '"Inconsolata", Consolas, Monaco, Courier, sans-serif';
 
	$fontsA["inconsolata"]['google'] = true;
	$fontsA["inconsolata"]['name'] = '"Josefin Sans Std Light", "Century Gothic", Verdana, sans-serif';
 
	$fontsA["kreon"]['google'] = true;
	$fontsA["kreon"]['name'] = 'Kreon:300,400,700" kreon, georgia,serif';
 
	$fontsA["lato"]['google'] = true;
	$fontsA["lato"]['name'] = '"Lato", arial, serif';
 
	$fontsA["lobster"]['google'] = true;
	$fontsA["lobster"]['name'] = 'Lobster, Arial, sans-serif';
 
	$fontsA["lora"]['google'] = true;
	$fontsA["lora"]['name'] = '"Lora", georgia, serif';
 
	$fontsA["merriweather"]['google'] = true;
	$fontsA["merriweather"]['name'] = 'Merriweather, georgia, times, serif';
 
	$fontsA["molengo"]['google'] = true;
	$fontsA["molengo"]['name'] = 'Molengo, "Trebuchet MS", Corbel, Arial, sans-serif';	
 
	$fontsA["nobile"]['google'] = true;
	$fontsA["nobile"]['name'] = 'Nobile, Corbel, Arial, sans-serif';
 
	$fontsA["ofl_sorts_mill_goudy"]['google'] = true;
	$fontsA["ofl_sorts_mill_goudy"]['name'] = '"OFL Sorts Mill Goudy TT", Georgia, serif';
 
	$fontsA["old_standard"]['google'] = true;
	$fontsA["old_standard"]['name'] = '"Old Standard TT", "Times New Roman", Times, serif';
 
	$fontsA["reenie_beanie"]['google'] = true;
	$fontsA["reenie_beanie"]['name'] = '"Reenie Beanie", Arial, sans-serif';
 
	$fontsA["tangerine"]['google'] = true;
	$fontsA["tangerine"]['name'] = 'Tangerine, "Times New Roman", Times, serif';
 
	$fontsA["times_new_roman"]['google'] = false;
	$fontsA["times_new_roman"]['name'] = '"Times New Roman", Times, Georgia, serif';
 
	$fontsA["trebuchet_ms"]['google'] = false;
	$fontsA["trebuchet_ms"]['name'] = '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif';
 
	$fontsA["verdana"]['google'] = false;
	$fontsA["verdana"]['name'] = 'Verdana, sans-serif';
 
	$fontsA["vollkorn"]['google'] = true;
	$fontsA["vollkorn"]['name'] = 'Vollkorn, Georgia, serif';
 
	$fontsA["yanone"]['google'] = true;
	$fontsA["yanone"]['name'] = '"Yanone Kaffeesatz", Arial, sans-serif';
 
	$fontsA["american_typewriter"]['google'] = false;
	$fontsA["american_typewriter"]['name'] = '"American Typewriter", Georgia, serif';
 
	$fontsA["andale"]['google'] = false;
	$fontsA["andale"]['name'] = '"Andale Mono", Consolas, Monaco, Courier, "Courier New", Verdana, sans-serif';
 
	$fontsA["baskerville"]['google'] = false;
	$fontsA["baskerville"]['name'] = 'Baskerville, "Times New Roman", Times, serif';
 
	$fontsA["bookman_old_style"]['google'] = false;
	$fontsA["bookman_old_style"]['name'] = '"Bookman Old Style", Georgia, "Times New Roman", Times, serif';
 
	$fontsA["calibri"]['google'] = false;
	$fontsA["calibri"]['name'] = 'Calibri, "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif';
 
	$fontsA["cambria"]['google'] = false;
	$fontsA["cambria"]['name'] = 'Cambria, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["candara"]['google'] = false;
	$fontsA["candara"]['name'] = 'Candara, Verdana, sans-serif';
 
	$fontsA["century_gothic"]['google'] = false;
	$fontsA["century_gothic"]['name'] = '"Century Gothic", "Apple Gothic", Verdana, sans-serif';
 
	$fontsA["century_schoolbook"]['google'] = false;
	$fontsA["century_schoolbook"]['name'] = '"Century Schoolbook", Georgia, "Times New Roman", Times, serif';
 
	$fontsA["consolas"]['google'] = false;
	$fontsA["consolas"]['name'] = 'Consolas, "Andale Mono", Monaco, Courier, "Courier New", Verdana, sans-serif';
 
	$fontsA["constantia"]['google'] = false;
	$fontsA["constantia"]['name'] = 'Constantia, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["Corbel"]['google'] = false;
	$fontsA["Corbel"]['name'] = 'Corbel, "Lucida Grande", "Lucida Sans Unicode", Arial, sans-serif';
 
	$fontsA["franklin_gothic"]['google'] = false;
	$fontsA["franklin_gothic"]['name'] = '"Franklin Gothic Medium", Arial, sans-serif';
 
	$fontsA["garamond"]['google'] = false;
	$fontsA["garamond"]['name'] = 'Garamond, "Hoefler Text", "Times New Roman", Times, serif';
 
	$fontsA["gill_sans"]['google'] = false;
	$fontsA["gill_sans"]['name'] = '"Gill Sans MT", "Gill Sans", Calibri, "Trebuchet MS", sans-serif';
 
	$fontsA["helvetica"]['google'] = false;
	$fontsA["helvetica"]['name'] = '"Helvetica Neue", Helvetica, Arial, sans-serif';
 
	$fontsA["hoefler"]['google'] = false;
	$fontsA["hoefler"]['name'] = '"Hoefler Text", Garamond, "Times New Roman", Times, sans-serif';
 
	$fontsA["lucida_bright"]['google'] = false;
	$fontsA["lucida_bright"]['name'] = '"Lucida Bright", Cambria, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["lucida_grande"]['google'] = false;
	$fontsA["lucida_grande"]['name'] = '"Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif';
 
	$fontsA["palatino"]['google'] = false;
	$fontsA["palatino"]['name'] = '"Palatino Linotype", Palatino, Georgia, "Times New Roman", Times, serif';
 
	$fontsA["rockwell"]['google'] = false;
	$fontsA["rockwell"]['name'] = 'Rockwell, "Arial Black", "Arial Bold", Arial, sans-serif';
 
	$fontsA["tahoma"]['google'] = false;
	$fontsA["tahoma"]['name'] = 'Tahoma, Geneva, Verdana, sans-serif';
	
if(is_array($layouttypes) && !empty($layouttypes)){	

	if(isset($layouttypes['body']['font']) && strlen($layouttypes['body']['font']) > 0){	if($fontsA[$layouttypes['body']['font']]['google']){
	$FName = explode(",",$fontsA[$layouttypes['body']['font']]['name']);
	?>
	<style type="text/css" id="dynamic-css">
	 @import url(http://fonts.googleapis.com/css?v2&family=<?php echo str_replace('"',"",str_replace(' ',"+",$FName[0])); ?>);
	h1, h2, h3, h4, h5, h6, #submenubar, .menu li a {font-family:'<?php echo str_replace('"',"",$FName[0]); ?>';} } 
	</style>
	<?php }else{ ?>
	<style type="text/css">
	body { font-family:<?php echo $fontsA[$layouttypes['body']['font']]['name']; ?>; }
	</style>
	<?php } } ?>
    
	<style type="text/css">
 	<?php if(isset($layouttypes['sidebar']['leftw']) && $layouttypes['sidebar']['leftw'] != "" && $layouttypes['sidebar']['leftw'] !="200px" && $layouttypes['sidebar']['leftw'] !="260px"){  echo ".left3cols, .left2cols { width:".$layouttypes['sidebar']['leftw']."; }"; } ?>
	<?php if( isset($layouttypes['sidebar']['rightw']) && $layouttypes['sidebar']['rightw'] != "" && $layouttypes['sidebar']['rightw'] !="200px" && $layouttypes['sidebar']['rightw'] !="260px"){  echo ".right3cols, .right2cols { width:".$layouttypes['sidebar']['rightw']."; }"; } ?>
	<?php if(  isset($layouttypes['sidebar']['middlew']) && $layouttypes['sidebar']['middlew'] != "" && $layouttypes['sidebar']['middlew'] !="670px" && $layouttypes['sidebar']['middlew'] !="540px"){  echo ".middle3cols, .middle2cols { width:".$layouttypes['sidebar']['middlew']."; }"; } ?>
	<?php if(isset($layouttypes['wrapper']['bg']) && strlen($layouttypes['wrapper']['bg']) > 0){ echo ".wrapper { border:".$layouttypes['wrapper']['border-width']."px solid #".$layouttypes['wrapper']['bg']."; ".$layouttypes['wrapper']['custom']." }"; } ?>
	<?php if(isset($layouttypes['body']['bg']) && strlen($layouttypes['body']['bg']) > 0){ echo "body { background:#".$layouttypes['body']['bg']."; }"; } ?>	 
	<?php if(isset($layouttypes['header']) && ( strlen($layouttypes['header']['bg']) > 0 || strlen($layouttypes['header']['image']) > 0)){ 
	if($layouttypes['header']['bg'] == ""){ $bgc = "transparent"; }else{ $bgc = "#".$layouttypes['header']['bg']; }
	echo "#header { background:".$bgc." ";
	
	
	if(strlen($layouttypes['header']['image']) > 3){ echo " url('".$layouttypes['header']['image']."') ".$layouttypes['header']['image-repeat'];  }
	
	echo $layouttypes['header']['custom']." }"; } ?>
	
	<?php if(isset($layouttypes['page']['bg']) && strlen($layouttypes['page']['bg']) > 0){ echo "#page { background:#".$layouttypes['page']['bg']."; }"; } ?>
	<?php if(isset($layouttypes['content']['bg']) && strlen($layouttypes['content']['bg']) > 0){ echo "#content { background:#".$layouttypes['content']['bg']."; }"; } ?>
	<?php if(isset($layouttypes['footer']['bg']) && strlen($layouttypes['footer']['bg']) > 0){ echo "#steptable div.stepped, #footer { background:#".$layouttypes['footer']['bg']."; }"; } ?>
	<?php if(isset($layouttypes['footer']['text']) && strlen($layouttypes['footer']['text']) > 0){ echo "#footer p,#footer h3 { color:#".$layouttypes['footer']['text']."; }"; } ?>
	<?php if(isset($layouttypes['footer']['a']) && strlen($layouttypes['footer']['a']) > 0){ echo "#footer a, #fpages ul li a, #steptable div.steps h4 { color:#".$layouttypes['footer']['a']."; }"; } ?>
	<?php if(isset($layouttypes['text']['main']) && strlen($layouttypes['text']['main']) > 0){ echo "body { color:#".$layouttypes['text']['main']."; }"; } ?>
	<?php if(isset($layouttypes['text']['h1']) && strlen($layouttypes['text']['h1']) > 0){ echo "h1,h2,h3,h4,.texttitle { color:#".$layouttypes['text']['h1']."; }"; } ?>
	<?php if(isset($layouttypes['text']['a']) && strlen($layouttypes['text']['a']) > 0){ echo "a,a.visited { color:#".$layouttypes['text']['a']."; }"; } ?>

	<?php if(isset($layouttypes['button']['from']) && strlen($layouttypes['button']['from']) > 0){ ?>
	.gray.button, .skin.button, .button gray, .gray.button:hover, .skin.button:hover, .button gray:hover {  
	filter					: progid:DXImageTransform.Microsoft.gradient(startColorStr='#<?php echo $layouttypes['button']['from']; ?>', EndColorStr='#<?php echo $layouttypes['button']['to']; ?>');
	background-image		: -webkit-gradient(linear, left top, left bottom, color-stop(0, #<?php echo $layouttypes['button']['from']; ?>), color-stop(1, #<?php echo $layouttypes['button']['to']; ?>));
	background-image		: -webkit-linear-gradient(top, #<?php echo $layouttypes['button']['from']; ?> 0%, #<?php echo $layouttypes['button']['to']; ?> 100%);
	background-image		:    -moz-linear-gradient(top, #<?php echo $layouttypes['button']['from']; ?> 0%, #<?php echo $layouttypes['button']['to']; ?> 100%);
	background-image		:     -ms-linear-gradient(top, #<?php echo $layouttypes['button']['from']; ?> 0%, #<?php echo $layouttypes['button']['to']; ?> 100%);
	background-image		:      -o-linear-gradient(top, #<?php echo $layouttypes['button']['from']; ?> 0%, #<?php echo $layouttypes['button']['to']; ?> 100%);
	background-image		:         linear-gradient(top, #<?php echo $layouttypes['button']['from']; ?> 0%, #<?php echo $layouttypes['button']['to']; ?> 100%);
	text-shadow: none;
	border:0px;
	color:#<?php echo $layouttypes['button']['text']; ?> !important;
	}
	<?php } ?>
	<?php if(isset($layouttypes['nav']['from']) && strlen($layouttypes['nav']['from']) > 0){ ?>
	.menu { 
	
	filter					: progid:DXImageTransform.Microsoft.gradient(startColorStr='#<?php echo $layouttypes['nav']['from']; ?>', EndColorStr='#<?php echo $layouttypes['nav']['to']; ?>');
	background-image		: -webkit-gradient(linear, left top, left bottom, color-stop(0, #<?php echo $layouttypes['nav']['from']; ?>), color-stop(1, #<?php echo $layouttypes['nav']['to']; ?>));
	background-image		: -webkit-linear-gradient(top, #<?php echo $layouttypes['nav']['from']; ?> 0%, #<?php echo $layouttypes['nav']['to']; ?> 100%);
	background-image		:    -moz-linear-gradient(top, #<?php echo $layouttypes['nav']['from']; ?> 0%, #<?php echo $layouttypes['nav']['to']; ?> 100%);
	background-image		:     -ms-linear-gradient(top, #<?php echo $layouttypes['nav']['from']; ?> 0%, #<?php echo $layouttypes['nav']['to']; ?> 100%);
	background-image		:      -o-linear-gradient(top, #<?php echo $layouttypes['nav']['from']; ?> 0%, #<?php echo $layouttypes['nav']['to']; ?> 100%);
	background-image		:         linear-gradient(top, #<?php echo $layouttypes['nav']['from']; ?> 0%, #<?php echo $layouttypes['nav']['to']; ?> 100%);
	border-bottom:0px solid #ddd;
	}
	<?php } ?>
	<?php if(isset($layouttypes['nav']['dropbg']) && strlen($layouttypes['nav']['dropbg']) > 1){ ?>
	.menu li ul, #hpages li ul a, #hpages li ul a, .submenu li ul a, #categorylistwrapper ul li ul li, .category li ul a, .submenu_account li ul a, .togglesub1   { background: #<?php echo $layouttypes['nav']['dropbg']; ?> !important;   }
	<?php } ?>
	<?php if(isset($layouttypes['nav']['dropbgh']) && strlen($layouttypes['nav']['dropbgh']) > 1){ ?>
	.menu li ul a:hover, #hpages ul li ul a:hover, .submenu li ul a:hover, .category li ul a:hover, #categorylistwrapper ul li ul li a:hover, .submenu_account li ul a:hover, .togglesub1 a:hover  { background: #<?php echo $layouttypes['nav']['dropbgh']; ?> !important;  }
	<?php } ?>
	<?php if(isset($layouttypes['nav']['droptext']) && strlen($layouttypes['nav']['droptext']) > 1){ ?>
	.menu li ul a, #hpages li ul a, .submenu li ul a, .category li ul a, .submenu_account li ul a   { color: #<?php echo $layouttypes['nav']['droptext']; ?> !important;  }
	<?php } ?>	
	 
	
	<?php if(isset($layouttypes['nav']['text']) && strlen($layouttypes['nav']['text']) > 1){ ?>
	.menu li a {   color: #<?php echo $layouttypes['nav']['text']; ?>;  <?php if($layouttypes['nav']['text-shawdow']  ==1){  ?>text-shadow: 0.1em 0.1em 0.05em #444;<?php } ?> }
	<?php } ?>
	<?php if(isset($layouttypes['submenubar']['bg']) && strlen($layouttypes['submenubar']['bg']) > 0){ echo "#submenubar { background:#".$layouttypes['submenubar']['bg']."; }"; } ?> 	
	<?php if(isset($layouttypes['submenubar']['text']) && strlen($layouttypes['submenubar']['text']) > 0){ echo "#submenubar { color:#".$layouttypes['submenubar']['text'].";}ul.submenu_account li a { color:#".$layouttypes['submenubar']['text'].";}"; } ?>
	<?php if(isset($layouttypes['submenubar']['search']) && $layouttypes['submenubar']['search'] ==1){ echo "#searchBox {display:none; } ";} ?>
	<?php if(isset($layouttypes['itembox']['border-bg']) && strlen($layouttypes['itembox']['border-bg']) > 1){ ?>
	.itembox { border: <?php echo $layouttypes['itembox']['border-width']; ?>px solid #<?php echo $layouttypes['itembox']['border-bg']; ?>; }
	<?php } ?>
	
	<?php if(isset($layouttypes['itembox']['from']) && strlen($layouttypes['itembox']['from']) > 0){ ?> 			
	.itembox h2.title,.itembox h1.title {   color: #<?php echo $layouttypes['itembox']['text']; ?>; 	
	border:1px solid #fff;
	background:#<?php echo $layouttypes['itembox']['to']; ?>;
	filter					: progid:DXImageTransform.Microsoft.gradient(startColorStr='#<?php echo $layouttypes['itembox']['from']; ?>', EndColorStr='#<?php echo $layouttypes['itembox']['to']; ?>');
	background-image		: -webkit-gradient(linear, left top, left bottom, color-stop(0, #<?php echo $layouttypes['itembox']['from']; ?>	), color-stop(1, #<?php echo $layouttypes['itembox']['to']; ?>));
	background-image		: -webkit-linear-gradient(top, #<?php echo $layouttypes['itembox']['from']; ?>	 0%, #<?php echo $layouttypes['itembox']['to']; ?> 100%);
	background-image		:    -moz-linear-gradient(top, #<?php echo $layouttypes['itembox']['from']; ?>	 0%, #<?php echo $layouttypes['itembox']['to']; ?> 100%);
	background-image		:     -ms-linear-gradient(top, #<?php echo $layouttypes['itembox']['from']; ?>	 0%, #<?php echo $layouttypes['itembox']['to']; ?> 100%);
	background-image		:      -o-linear-gradient(top, #<?php echo $layouttypes['itembox']['from']; ?>	 0%, #<?php echo $layouttypes['itembox']['to']; ?> 100%);
	background-image		:         linear-gradient(top, #<?php echo $layouttypes['itembox']['from']; ?>	 0%, #<?php echo $layouttypes['itembox']['to']; ?> 100%);
	border-bottom:1px solid #<?php echo $layouttypes['itembox']['border-bg']; ?>;<?php if($layouttypes['itembox']['text-shawdow']  ==1){  ?>text-shadow: 0.1em 0.1em 0.05em #444;<?php } ?>
	}
	<?php  if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){ ?>
 
	   .pb7, .pb6, .ExtraData { border:1px solid #<?php echo $layouttypes['itembox']['border-bg']; ?>; } .pb1 { border-top:1px solid #<?php echo $layouttypes['itembox']['border-bg']; ?>; border-bottom:1px solid #<?php echo $layouttypes['itembox']['border-bg']; ?>; } .shareButton, .pb8 { border-top:1px solid #<?php echo $layouttypes['itembox']['border-bg']; ?>; }
	  
 	<?php } ?>
	<?php } ?>
	
	<?php if(isset($layouttypes['itembox']['bg']) && strlen($layouttypes['itembox']['bg']) > 1){ ?>.itemboxinner,#BackGroundWrapper {   background:#<?php echo $layouttypes['itembox']['bg']; ?>;  }.greybg { background-image:none; } <?php } ?>	
	<?php if(isset($layouttypes['itembox']['text']) && strlen($layouttypes['itembox']['text']) > 1){ ?>.itembox h2 a,.itembox h1 a { color: #<?php echo $layouttypes['itembox']['text']; ?>; }<?php } ?>	
	<?php if(isset($layouttypes['itembox']['hover']) && strlen($layouttypes['itembox']['hover']) > 1){ ?>.widget li a:hover, .category li a:hover, #homeFeaturedBottom li:hover   { background:#<?php echo $layouttypes['itembox']['hover'] ?>; }
	  <?php } ?>
	    
	<?php if(isset($layouttypes['slider']['bg']) && strlen($layouttypes['slider']['bg']) > 0){ ?>
	.l-rotator{ 
	background-color:#<?php echo $layouttypes['slider']['bg']; ?>;
	border:1px solid #<?php echo $layouttypes['slider']['border-color']; ?>;
	}
	<?php } ?>
	
	<?php  if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){  ?>
	
	<?php if(isset($layouttypes['gallery']['border-bg']) && strlen($layouttypes['gallery']['border-bg']) > 0){ ?>ul.display li  {   border: 5px solid #<?php echo $layouttypes['gallery']['border-bg'];  ?>; }<?php } ?>
	<?php if(isset($layouttypes['gallery']['hover']) && strlen($layouttypes['gallery']['hover']) > 0){ ?>ul.display li:hover { border: <?php echo $layouttypes['gallery']['border-width']; ?>px solid #<?php echo $layouttypes['gallery']['hover']; ?>;  }<?php } ?>
	<?php if(isset($layouttypes['gallery']['hover']) && strlen($layouttypes['gallery']['hover']) > 0){ ?>ul.display li:hover h2 a { color: #<?php echo $layouttypes['gallery']['hover']; ?>; } <?php } ?>
	
	<?php if(isset($layouttypes['gallery']['hover']) && strlen($layouttypes['gallery']['hover']) > 0){ ?>ul.display li:hover .actions .add-box, ul.thumb_view li:hover  .actions .add-box {	background: #<?php echo $layouttypes['gallery']['hover']; ?>;		}<?php } ?>
	<?php if(isset($layouttypes['gallery']['price-bg']) && strlen($layouttypes['gallery']['price-bg']) > 0){ ?>.actions { background:#<?php echo $layouttypes['gallery']['price-bg']; ?>;  }<?php } ?>
	<?php if(isset($layouttypes['gallery']['price-text']) && strlen($layouttypes['gallery']['price-text']) > 0){ ?>.actions { color:#<?php echo $layouttypes['gallery']['price-text']; ?>;  }<?php } ?>
	<?php if(isset($layouttypes['gallery']['text']) && strlen($layouttypes['gallery']['text']) > 0){ ?>ul.display li h2 a { color:#<?php echo $layouttypes['gallery']['text']; ?>;  }<?php } ?>
	<?php if(isset($layouttypes['gallery']['cart']) && strlen($layouttypes['gallery']['cart']) > 0){ ?>.actions .add-box {  background:#<?php echo $layouttypes['gallery']['cart']; ?>; }<?php } ?>
	
	
		<?php if(isset($layouttypes['gallery']['featured-border-bg'])){ ?>
	ul.display li:hover, #SearchContent .featured { border: 5px solid #<?php echo $layouttypes['gallery']['featured-border-bg']; ?>;  }	
	<?php } ?>
	
	<?php if(isset($layouttypes['single']['buy-bg']) && strlen($layouttypes['single']['buy-bg']) > 0){ ?>#ProductBuyBlock .btn { background:#<?php echo $layouttypes['single']['buy-bg']; ?>; }#ProductBuyBlock .btn a, #ProductBuyBlock .download a { color:#<?php echo $layouttypes['single']['buy-bg-text']; ?>; }<?php } ?>
	<?php } ?><?php if(is_front_page() && get_option("PPT_slider") !="off" && isset($layouttypes['slider']['from']) && strlen($layouttypes['slider']['from']) > 0){ ?> 
	
	.l-rotator .thumbnails .thumb{		
		color:#<?php echo $layouttypes['slider']['text']; ?>;
		background:#<?php echo $layouttypes['slider']['from']; ?>;
		background:-moz-linear-gradient(top, #<?php echo $layouttypes['slider']['from']; ?>, #<?php echo $layouttypes['slider']['to']; ?>);
		background:-webkit-gradient(linear, left top, left bottom, from(#<?php echo $layouttypes['slider']['from']; ?>), to(#<?php echo $layouttypes['slider']['to']; ?>));
		filter:progid:DXImageTransform.Microsoft.gradient(startColorStr='#<?php echo $layouttypes['slider']['from']; ?>', EndColorStr='#<?php echo $layouttypes['slider']['to']; ?>'); 
		border-color:#<?php echo $layouttypes['slider']['from']; ?>;
		
	}
	#featured-item {  background:#<?php echo $layouttypes['slider']['from']; ?>;}
	.featured-itemImage span strong { color:#<?php echo $layouttypes['slider']['atext']; ?>; }
	.featured-itemImage span {background-color: #<?php echo $layouttypes['slider']['afrom']; ?>;}
	.l-rotator p, .featured-itemImage span b {color: #<?php echo $layouttypes['slider']['text']; ?>;}
	 
	<?php } ?>	
		
	<?php if(is_front_page() && get_option("PPT_slider") !="off" &&  isset($layouttypes['slider']['afrom']) && strlen($layouttypes['slider']['afrom']) > 0){ ?> 
	.l-rotator .thumbnails li.selected,
	.l-rotator .thumbnails li.selected .thumb{
		background:#<?php echo $layouttypes['slider']['afrom']; ?> !important;
		background:-moz-linear-gradient(top, #<?php echo $layouttypes['slider']['afrom']; ?>, #<?php echo $layouttypes['slider']['ato']; ?>) !important;
		background:-webkit-gradient(linear, left top, left bottom, from(#<?php echo $layouttypes['slider']['afrom']; ?>), to(#<?php echo $layouttypes['slider']['ato']; ?>)) !important;
		filter:progid:DXImageTransform.Microsoft.gradient(startColorStr='#<?php echo $layouttypes['slider']['afrom']; ?>', EndColorStr='#<?php echo $layouttypes['slider']['ato']; ?>') !important;
	}
	.l-rotator .thumbnails li.selected .thumb{color:#<?php echo $layouttypes['slider']['atext']; ?>; }
	.l-rotator .thumbnails li:hover .thumb{background:#<?php echo $layouttypes['slider']['afrom']; ?>; color:#<?php echo $layouttypes['slider']['atext']; ?>;}
	<?php } ?>	
	
	<?php if(isset($layouttypes['slider8']['bg']) && strlen($layouttypes['slider8']['bg']) > 3){ ?>
	#oneByoneB { background:#<?php echo $layouttypes['slider8']['bg']; ?>; }
	<?php } ?>
	<?php if(isset($layouttypes['slider8']['text']) && strlen($layouttypes['slider8']['text']) > 3){ ?>
	#oneByoneB, #oneByoneB .oneByOne_item span, #oneByoneB p, #oneByoneB .oneByOne_item h2, #oneByoneB .oneByOne_item h1 { color:#<?php echo $layouttypes['slider8']['text']; ?>; }
	<?php } ?>
	<?php  if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "directorypress"){  ?>
    <?php if(isset($layouttypes['gallery']['featured-bg']) && strlen($layouttypes['gallery']['featured-bg']) > 1){ ?>
	.featuredlisting, .featuredlisting:hover { background: #<?php echo $layouttypes['gallery']['featured-bg']; ?> !important;
	<?php if(strlen($layouttypes['gallery']['featured-text']) > 1){ ?>color: #<?php echo $layouttypes['gallery']['featured-text']; ?> !important;<?php } ?>
	border-color: #<?php echo $layouttypes['gallery']['featured-bordercolor'] ?> !important;  }	
	<?php if(strlen($layouttypes['gallery']['featured-text']) > 1){ ?>.featuredlisting .title { color: #<?php echo $layouttypes['gallery']['featured-text']; ?> !important;}<?php } ?>
	<?php if(strlen($layouttypes['gallery']['featured-button-bg']) > 1){ ?>
	.featuredlisting .green.button { background:#<?php echo $layouttypes['gallery']['featured-button-bg']; ?> !important; color:#<?php echo $layouttypes['gallery']['featured-button-bgtxt']; ?> !important; border:0px !important; filter:none!important; }<?php } ?>
	<?php if(strlen($layouttypes['gallery']['featured-bordercolor']) > 1){ ?> .featuredlisting .frame { border-color: #<?php echo $layouttypes['gallery']['featured-bordercolor'] ?>; } <?php } ?>
	<?php if(strlen($layouttypes['gallery']['featured-text']) > 1){ ?>#PPTGalleryPage ul.items.list_style .tags1 a, #PPTGalleryPage ul.items li.featuredlisting .ititle a { color: #<?php echo $layouttypes['gallery']['featured-text']; ?> !important;}<?php } ?>
	<?php } ?>
    <?php } ?></style>
    
    <?php
	
	}  // end if 
	
	$STRING = "";
	// HOME PAGE CUSTOM ICONS IN VERSION 7
	if(is_front_page()){
	$ICONS = get_option("cat_icons");
	if(is_array($ICONS) && !empty($ICONS)){
	$STRING .= '<style type="text/css"> ';
	foreach($ICONS as $key=>$icon){ if(strlen($icon['image']) > 1){ 
	
		$Cimg = str_replace(".png","",$icon['image']);
		if(is_numeric($Cimg)){ $imgPath = get_template_directory_uri().'/images/icons/'.$icon['image'];  }else{  $imgPath = $icon['image']; }
	
		$STRING .= '.icon'.$key.'{ background: url('.$imgPath.') no-repeat 8px 0px !important;   } ';
	
	} }
	$STRING .= '</style>';
	}
	echo $STRING;
	}

}
	
	
	
	

	/**
	 * Magic hook: Define your own wp_footer method
	 *
	 * @since 0.3.0
	 */
 
	 
	function _wp_footer() {
	
	global $wpdb, $pagenow;
	
	if ( defined('SAVEQUERIES') && current_user_can('administrator')){
		 
		echo "<pre>";
		print_r($wpdb->queries);
		echo "</pre>";
	}
	
	if($pagenow == "wp-login.php" && $_GET['action'] != "logout" && $_GET['action'] != "rp" && $_GET['action'] != "resetpass"){ return; }
	
	
	?>
       
    <?php 
	
 
  	// Load the content slider
		if(isset($GLOBALS['flag-home'])){  ?>  
        
        <?php if(get_option('PPT_slider') == "s1"){ 
		
			$SLIDERSTYLE = get_option('PPT_slider_style');
			 
			switch($SLIDERSTYLE){
			case "1": {  } break;
			case "2":
			case "3":
			case "4":
			case "5": { ?><?php } break;
			}
			
		  }elseif(isset($GLOBALS['s2'])){ ?>
			<script src="<?php echo PPT_PATH; ?>js/jquery.s3Slider.js" type="text/javascript"></script> 
            <script type="text/javascript">	jQuery(document).ready(function() {	jQuery('#featured-item').s3Slider({timeOut: 6000	});}); </script> 
         <?php } ?> 
         
		<?php }  
		
  
		// Load global theme footer scripts
		if(!isset($GLOBALS['tpl-add'])){
		
		$addUsername = get_option('addthisusername');
		if($addUsername == ""){ $addUsername = "premiumpress"; }
		
		if($addUsername != "off"){
		?>         
	 
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=<?php echo $addUsername; ?>"></script>    
        <script type="text/javascript">var addthis_config = {ui_click: true}</script>
        <script type="text/javascript">if (typeof addthis_config !== "undefined") {addthis_config.data_use_cookies = false} else {var addthis_config = {data_use_cookies: false};}</script>
        
        <?php } } ?>
         
		<script type="text/javascript" src="<?php echo PPT_FW_JS_URI; ?>custom.js"></script> 
		<script type="text/javascript" src="<?php echo PPT_CHILD_JS; ?>_defaults.js"></script>
        
        
     
    <?php
   
   
	switch(strtolower(PREMIUMPRESS_SYSTEM)){
	
	case "shopperpress": {  } break;
	case "bookingpress":
	case "auctionpress":
	case "couponpress":
	case "classifiedstheme":
	case "realtorpress":
	case "employeepress":
	case "comparisonpress":
	case "directorypress": {
	 
		if(is_single() ){ // || isset($GLOBALS['IS_MYACCOUNT'])  ?>
 
		 
		<script type="text/javascript"> 
		 
		jQuery(document).ready(function() {
		 
			//Default Action
			jQuery(".tab_content").hide(); //Hide all content
			
			
			<?php  if(isset($_GET['commentstab'])){ ?>
			 
			jQuery('#comments').show(); //Show first tab content
			jQuery("#c").addClass("active").show();
			jQuery("#a").removeClass("active");
			
			<?php }elseif(strtolower(PREMIUMPRESS_SYSTEM) == "comparisonpress" && ( !isset($GLOBALS['packageID']) || $GLOBALS['packageID'] == "" )){ ?>
			jQuery('#products').show(); //Show first tab content
			jQuery("#p").addClass("active").show();
			jQuery("#a").removeClass("active");
			
			<?php }elseif(strtolower(PREMIUMPRESS_SYSTEM) == "employeepress" && is_single()){ ?>
			jQuery('#proposals').show(); //Show first tab content
			jQuery("#p").addClass("active").show();
			<?php }else{ ?>
			 jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
			jQuery(".tab_content:first").show(); //Show first tab content
			<?php } ?>
			
			//On Click Event
			jQuery("ul.tabs li").click(function() {
				jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
				jQuery(this).addClass("active"); //Add "active" class to selected tab
				jQuery(".tab_content").hide(); //Hide all tab content
				var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
				jQuery(activeTab).fadeIn(); //Fade in the active content
				return false;
				
			});
		 
		});
		</script>
        
        
        
	<?php }	
	
		 
		
		
	
	} break; 
    
    }    
    
    // NEW CUSTOM HEADER DATA 7+
	echo stripslashes(get_option("ppt_custom_footertags"));
    
	// Load the Google Analytics code into the footer
    echo stripslashes(get_option("analytics_code")); 
	
	// Load the Google Adsense tracking code into the footer
	echo stripslashes(get_option("google_adsensetracking_code")); 
		 
		
	}	
 
	
	/**
	 * Magic hook: Define your own widgets_init method
	 *
	 * @since 0.3.0
	 */
	function _widgets_init() {
		self::callback( $this, 'widgets_init' );
	} 
 


	
		
}
	
?>