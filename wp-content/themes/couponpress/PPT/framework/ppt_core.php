<?php

/**
 * Default constants available throughout the Framework.
 *
 * @since 0.3.0
 *
 * @return void
 */
function ppt_initial_constants() {

	// sets the name of the PremiumPress theme
	define( 'HOME_URI', get_home_url() );	
	
	// sets the name of the PremiumPress theme
	define( 'PPT_THEME', strtolower(PREMIUMPRESS_SYSTEM) );	
 
	// Sets the File path for the theme installation
	define( 'PPT_THEME_DIR', TEMPLATEPATH );	 
 
	// Sets the File path for the theme installation
	define( 'PPT_THEMES_DIR', TEMPLATEPATH . '/themes/');
	
	// Sets the URI path to the theme installation
	define( 'PPT_THEME_URI', get_template_directory_uri() );
	
	// Sets the file path to PremiumPress Framework folder(s)
	define( 'PPT_FW', PPT_THEME_DIR . '/PPT/' );
 
		// Sets the file path to framework files ()
		define( 'PPT_FW_CLASS', PPT_THEME_DIR . '/PPT/class/' );

		// Sets the file path to framework files ()
		define( 'PPT_FW_AJAX', PPT_THEME_DIR . '/PPT/ajax/' );

			// Sets the file path to framework files ()
			define( 'PPT_FW_AJAX_URI', PPT_THEME_URI . '/PPT/ajax/' );
		
		// Sets the file path to framework files ()
		define( 'PPT_FW_JS', PPT_THEME_DIR . '/PPT/js/' );

			// Sets the file path to framework files ()
			define( 'PPT_FW_JS_URI', PPT_THEME_URI . '/PPT/js/' );
		
		// Sets the file path to framework files ()
		define( 'PPT_FW_WP', PPT_THEME_DIR . '/PPT/wordpress/' );		

		// Sets the file path to framework files ()
		define( 'PPT_FW_CSS', PPT_THEME_DIR . '/PPT/css/' );
		
			// Sets the file path to framework files ()
			define( 'PPT_FW_CSS_URI', PPT_THEME_URI . '/PPT/css/' );

		// Sets the file path to framework files ()
		define( 'PPT_FW_GATEWAYS', PPT_THEME_DIR . '/PPT/gateways/' );

		// Sets the file path to framework files ()
		define( 'PPT_FW_FUNCTION', PPT_THEME_DIR . '/PPT/func/' );
		
		// Sets the file path to framework files ()
		define( 'PPT_FW_IMG', PPT_THEME_DIR . '/PPT/img/' );
			
			// Sets the file path to framework files ()
			define( 'PPT_FW_IMG_URI', PPT_THEME_URI . '/PPT/img/' );				
			
		// Sets the file path to framework files ()
		define( 'PPT_THUMBS', PPT_THEME_DIR . '/thumbs/' );
			
			// Sets the file path to framework files ()
			define( 'PPT_THUMBS_URI', PPT_THEME_URI . '/thumbs/' );		

			// Sets the file path to framework files ()
			define( 'PPT_V8_URI', PPT_THEME_URI . '/PPT/v8/' );		
	
	// OLD THEME SETTING FOR OLDER CHILD THEME SUPPORT	
	define('PPT_PATH',PPT_THEME_URI.'/PPT/');
	define('THEME_PATH',PPT_THEME_DIR."/"); 
		
			 
}

/**
 * Templating constants that you can override before the Framework is loaded.
 *
 * @since 0.3.0
 *
 * @return void
 */
function ppt_templating_constants() {

	global $wpdb;
	
	if(defined('PREMIUMPRESS_DEMO')){
		// CORE OPTIONS
		if ( !isset($_SESSION['dd'] ) && !isset($_REQUEST['dd']) ){
			$GLOBALS['premiumpress']['theme']			= get_option('theme');
		}elseif(isset($_REQUEST['dd'])){	
			$GLOBALS['premiumpress']['theme'] 			= strip_tags($_REQUEST['dd']);
		$_SESSION['dd']= $_REQUEST['dd'];
		}elseif(isset($_SESSION['dd'])){
			$GLOBALS['premiumpress']['theme'] 			= strip_tags($_SESSION['dd']);
		}
		$CHILDTHEME = $GLOBALS['premiumpress']['theme'];
	
	}else{
		$CHILDTHEME = get_option('theme');
		if(strlen($CHILDTHEME) < 2){ $CHILDTHEME = strtolower(PREMIUMPRESS_SYSTEM)."_default"; } 
	}
	
	
	// PATH TO CHOSEN STYLE
	if ( !defined( 'PPT_CUSTOM_STYLE_IMAGE_URL' ) ){
	
		$default_styles = get_option('theme-style');
		if($default_styles == "" || $default_styles == "styles.css"){ $img_p = ""; }else{ $img_p = str_replace(".css","",$default_styles)."/"; }
	 
		define( 'PPT_CUSTOM_STYLE_URL', PPT_THEME_URI.'/themes/'.$CHILDTHEME.'/images/'.$img_p ); 
		define( 'PPT_CUSTOM_STYLE_PATH', PPT_THEME_DIR.'/themes/'.$CHILDTHEME.'/images/'.$img_p );
	}
 

	// Sets relative paths for the default directories/paths
	if ( !defined( 'PPT_CHILD_DIR' ) )
		define( 'PPT_CHILD_DIR', PPT_THEME_DIR.'/template_'.strtolower(PREMIUMPRESS_SYSTEM).'/' );

 
	// Sets relative paths for the default directories/paths
	if ( !defined( 'PPT_CHILD_URL' ) )
		define( 'PPT_CHILD_URL', PPT_THEME_URI.'/template_'.strtolower(PREMIUMPRESS_SYSTEM).'/' );

 
	// Sets relative paths for the default directories/paths
	if ( !defined( 'PPT_CHILD_IMG' ) )
		define( 'PPT_CHILD_IMG', PPT_THEME_URI.'/template_'.strtolower(PREMIUMPRESS_SYSTEM).'/images/' ); 
 
 	// Sets relative paths for the default directories/paths
	if ( !defined( 'PPT_CHILD_JS' ) )
		define( 'PPT_CHILD_JS', PPT_THEME_URI.'/template_'.strtolower(PREMIUMPRESS_SYSTEM).'/js/' ); 
 
 	// Sets relative paths for the child theme
	if ( !defined( 'PPT_CUSTOM_CHILD_URL' ) )
		define( 'PPT_CUSTOM_CHILD_URL', PPT_THEME_URI.'/themes/'.$CHILDTHEME.'/' ); 

 	// Sets relative paths for the child theme
	if ( !defined( 'PPT_CUSTOM_CHILD_DIR' ) )
		define( 'PPT_CUSTOM_CHILD_DIR', PPT_THEME_DIR.'/themes/'.$CHILDTHEME.'/' ); 
		
		

	// OLD THEME SETTING FOR OLDER CHILD THEME SUPPORT	
	define('IMAGE_PATH',PPT_CHILD_IMG);

}

 
// SETUP WORDPRESS SCHEDULES
function ppt_event_activation() {
		
			if ( !wp_next_scheduled( 'ppt_hourly_event' ) ) {
				wp_schedule_event(time(), 'hourly', 'ppt_hourly_event');
			}	
			if ( !wp_next_scheduled( 'ppt_twicedaily_event' ) ) {		
				wp_schedule_event(time(), 'twicedaily', 'ppt_twicedaily_event');
			}	
			if ( !wp_next_scheduled( 'ppt_daily_event' ) ) {	
				wp_schedule_event(time(), 'daily', 'ppt_daily_event');		
			}
}
		 
		//print date('l jS \of F Y h:i:s A',wp_next_scheduled( "ppt_hourly_event"))."<br><br>".date('l jS \of F Y h:i:s A',wp_next_scheduled( "ppt_twicedaily_event"))."<br><br>".date('l jS \of F Y h:i:s A',wp_next_scheduled( "ppt_daily_event")); 
		
		function do_this_event_hourly() { 		global $PPTImport; $PPTImport->IMPORTSWITCH('hourly');	}		
		function do_this_event_twicedaily() { 	global $PPTImport; $PPTImport->IMPORTSWITCH('twicedaily');	}
		function do_this_event_daily() { 		global $PPTImport; $PPTImport->IMPORTSWITCH('daily');	}	

function ppt_body_class() {
	
	global $post; $c = "";
	
	if(isset($GLOBALS['GALLERYPAGE'])){ $c = 'id="PPTGalleryPage"'; 
	}elseif(isset($GLOBALS['IS_EDIT'])){ $c = 'id="PPTManagePage"';	
	}elseif(isset($GLOBALS['IS_MYACCOUNT'])){ $c = 'id="PPTAccountPage"'; 	
	}elseif(is_author()){ $c = 'id="PPTAuthorPage"'; 
	}elseif(is_home()){ $c = 'id="PPTHomePage"'; 
	}elseif(is_single()){ $c = 'id="PPTSinglePage-'.$post->post_type.'"'; 
	}elseif(is_page()){ $c = 'id="PPTPage"'; }
	
	echo $c.' class="custom-background"';
}

/**
 * Returns an array of contextual data based on the requested page.
 * It does this by running through all the WordPress conditional tags
 * and for every condition that is true, it the function adds contextual data
 * specific to that condition into the array and finally returns it.
 *
 * @link http://codex.wordpress.org/Conditional_Tags/
 *
 * @since 0.3.0
 * @global $wp_query The current page's query object.
 * @global $ppt_theme The global Theme object.
 * @return Array Returns an array of contexts based on the query.
 */
function ppt_get_request() {
	// The query isn't parsed until wp, so bail if the function is called before.
	if ( !did_action( 'wp' ) )
		return false;

	global $wp_query, $ppt_theme;

	if ( isset($ppt_theme->request) && !empty($ppt_theme->request) )
		return $ppt_theme->request;

	/* Front page of the site. */
	if ( is_front_page() )
		$request[] = 'front_page';

	/* Blog page. */
	if ( is_home() )
		$request[] = 'home';

	/* Singular views. */
	elseif ( is_singular() ) {
		$request[] = 'singular';

		if ( ppt_is_subpage() )
			$request[] = 'subpage';

		$request[] = 'post_type_' . $wp_query->post->post_type;		
		$request[] = 'post_type_' . $wp_query->post->post_type . '_' . str_replace( '-', '_', $wp_query->post->post_name );
	}

	/* Archive views. */
	elseif ( is_archive() ) {
		$request[] = 'archive';

		/* Taxonomy archives. */
		if ( is_tax() || is_category() || is_tag() ) {
			$term = $wp_query->get_queried_object();
			$request[] = 'taxonomy';
			$request[] = 'taxonomy_' . $term->taxonomy;
			$request[] = 'taxonomy_' . "{$term->taxonomy}_" . sanitize_html_class( $term->slug, $term->term_id );
		}

		/* User/author archives. */
		elseif ( is_author() ) {
			$request[] = 'user';
			$request[] = 'user_' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
		}

		/* Date archives. */
		else {
			if ( is_date() ) {
				$request[] = 'date';
				if ( is_year() )
					$request[] = 'year';
				if ( is_month() )
					$request[] = 'month';
				if ( get_query_var( 'w' ) )
					$request[] = 'week';
				if ( is_day() )
					$request[] = 'day';
			}
		}
	}

	/* Search results. */
	elseif ( is_search() )
		$request[] = 'search';
	
	elseif ( is_feed() )
		$request[] = 'feed';
	
	elseif ( is_multisite() )
		$request[] = 'multisite';

	/* Error 404 pages. */
	elseif ( is_404() )
		$request[] = '404';

	if(empty($request)){ $request[] = 'front_page'; $request[] = 'home'; }

	//$ppt_theme->request = apply_filters( 'ppt_request', $request );
	//}
	
	return $request;
}

/**
 * Returns true if a post is the subpage of a post.
 *
 * @since 0.3.0
 *
 * @param string $post Optional. Post id, or object.
 * @return bool true if the post is a subpage, false if not.
 */
function ppt_is_subpage( $post = null ) {
	$post = get_post( $post );

	if ( is_page() && $post->post_parent )
		return $post->post_parent;

	return false;
}

 

/**
 * Retrieves the theme framework class and initalises it.
 *
 * @since 0.3.0
 * @uses ppt_get_class()
 *
 * @return object $ppt_theme class
 */
function PPT() {

	global $ppt_classes;

	//$theme_class = ppt_get_class( 'theme' );

	//return $ppt_classes['theme'] = new $theme_class;
}

 

/**
 * Registers a WP Framework class.
 *
 * @since 0.3.0
 *
 * @param string $handle Name of the api.
 * @param string $class The class name.
 * @return string The name of the class registered to the handle.
 */
function ppt_register_class( $handle, $class, $autoload = false ) {

	global $ppt_classes;

	$type = $autoload ? 'autoload' : 'static';

	$ppt_classes[$type][$handle] = $class;

	return $ppt_classes[$type][$handle];
}

/**
 * Registers a contextual Framework class.
 * Contextual classes will get loaded after the 'wp' action is fired.
 *
 * @since 0.3.0
 * @see ppt_load_contextual_classes()
 * @see ppt_get_request()
 *
 * @param string $handle Name of the api.
 * @param string $class The contextual class name.
 * @return string The name of the class registered to the handle.
 */
function ppt_register_contextual_class( $handle, $class ) {
	global $ppt_classes;

	$ppt_classes['contextual'][$handle] = $class;

	return $ppt_classes['contextual'][$handle];
}

/**
 * Registers an admin class in WP Framework.
 * An admin class allows you to create administrative pages in WordPress.
 *
 * @since 0.3.0
 * @see class ppt_Admin
 * @see class ppt_Admin_Metabox
 * @uses ppt_load_admin_pages()
 *
 * @param string $handle Identifier for the admin class.
 * @param string $class The admin class name.
 * @return string The name of the class registered to the handle.
 */
function ppt_register_admin_class( $menu_slug, $class ) {
	global $ppt_classes;

	$ppt_classes['admin'][$menu_slug] = $class;

	return $ppt_classes['admin'][$menu_slug];
}

/**
 * Retrieves a registered WP Framework class.
 *
 * @since 0.3.0
 *
 * @param string $class The class handler
 * @return string The name of the class registered to the handler.
 */
function ppt_get_class( $class ) {
	global $ppt_classes;
	
	if ( isset($ppt_classes[$class]) )
		return $ppt_classes[$class];
	
	if ( isset($ppt_classes['admin'][$class]) )
		return $ppt_classes['admin'][$class];
	
	if ( isset($ppt_classes['static'][$class]) )
		return $ppt_classes['static'][$class];
	
	if ( isset($ppt_classes['autoload'][$class]) )
		return $ppt_classes['autoload'][$class];
	
	if ( isset($ppt_classes['contextual'][$class]) )
		return $ppt_classes['contextual'][$class];
	
	return false;
}

/**
 * Loops through all the registered autoloaded classes and instantiates them.
 *
 * @since 0.3.0
 * 
 * @return void
 */
function ppt_autoload_classes() {
	global $ppt_classes;

	if ( isset( $ppt_classes['autoload'] ) ) {
		foreach ( (array) $ppt_classes['autoload'] as $handle => $class ) {
			if ( !isset($ppt_classes[$handle]) ) {
				$ppt_classes[$handle] = new $class;
			}
		}
	}
}

/**
 * Loops through all the registered contextual classes and attempts to call 
 * classs methods based on ppt_get_request().
 *
 * @since 0.3.0
 * 
 * @return void
 */
function ppt_load_contextual_classes() {

	global $ppt_classes, $ppt_theme;

	if ( isset($ppt_classes['contextual']) && !empty( $ppt_classes['contextual'] ) ) {
		$methods = array();

		// Get the context, but not in the admin.
		if ( !is_admin() ) {
			$context = array_reverse( (array) ppt_get_request() );

			if ( !empty($context) ) {
				foreach ( $context as $method ) {
					$methods[] = str_replace( '-', '_', $method );
				}
			}
		}

		foreach ( (array) $ppt_classes['contextual'] as $handle => $class ) {
			if ( isset($ppt_classes[$handle]) )
				continue;

			// Call the admin method if we're in the admin area.
			if ( is_admin() ) {
				$ppt_theme->callback( $ppt_classes['contextual'][$handle], 'admin' );

			} else {

				// Call the constructor method if we're not in the admin,
				// pass all the methods that are valid for this page request.
				$ppt_classes[$handle] = new $class( $methods );
			}

			// Call all the contextual methods.
			if ( !empty( $methods ) ) {
				foreach( $methods as $method ) {
					$ppt_theme->callback( $ppt_classes[$handle], $method );
				}
			}
		}
	}
}

/**
 * Loops through all the registered admin pages and attempts to call 
 * classs methods based on ppt_get_request().
 *
 * @since 0.3.0
 * 
 * @return void
 */
function ppt_load_admin_pages() {
	if ( !is_admin() )
		return;

	global $ppt_classes;

	if ( isset($ppt_classes['admin']) && !empty($ppt_classes['admin']) ) {
		foreach ( $ppt_classes['admin'] as $handle => $class ) {
			if ( !isset($ppt_classes[$handle]) ) {
				$ppt_classes[$handle] = new $class;
			}
		}
	}
} 

/* =============================================================================
   WORDPRESS HOOKS // V7 26TH MARCH
   ========================================================================== */

function ppt_the_content($content){

	global $post, $wpdb;
	
	$beforecontent = "";
	$aftercontent = "";
	
	if(isset($GLOBALS['packageIcon']) && strlen($GLOBALS['packageIcon']) > 2){ $beforecontent  .= "<img src='".premiumpress_image_check($GLOBALS['packageIcon'])."' class='PackageIcon' id='PackageIcon".$GLOBALS['packageID']."'>"; }  
		 
	
	return $beforecontent .$content. $aftercontent;

}
add_filter('the_content','ppt_the_content',99);

/* =============================================================================
   REGISTRATION PAGE OPTIONS
   ========================================================================== */

function cp_show_errors($wp_error) {
	global $error,$PPTDesign;
	
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( !empty($wp_error) ) {
		if ( $wp_error->get_error_code() ) {
			$errors = '';
			$messages = '';
			
			foreach ( $wp_error->get_error_codes() as $code ) {			
			
				$severity = $wp_error->get_error_data($code);
				 
				foreach ( $wp_error->get_error_messages($code) as $error ) {
					if ( 'message' == $severity )
						$messages .= $error ;
					else
						$errors .= $error;
				}
			}
			if ( !empty($errors) )
				echo $PPTDesign->GL_ALERT( $errors ,"error");
			if ( !empty($messages) ) 	
				echo $PPTDesign->GL_ALERT( $messages ,"success");
		}
	}
}


// FIX FOR WORDPRESS 3+ 
function ppt_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css">body { <?php echo trim( $style ); ?> }</style>
<?php

}

function meta_no_index(){

echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';

} 
function cp_head($cp_msg) {

	global $pagenow, $user_ID, $cp_options;
	
	$GLOBALS['IS_LOGIN'] = true;
	
	add_action('wp_head','ppt_custom_background_callback');
	
	add_action('wp_head','meta_no_index');
	
 	include(TEMPLATEPATH . '/header.php'); 
	
	premiumpress_login_top();	 
 
}
 
function cp_footer() {

	global $pagenow, $user_ID, $cp_options;
	
	premiumpress_login_bottom();
 
	include(TEMPLATEPATH . '/footer.php');
}


function cp_show_login() {

	global $PPT; 
	
	// LANGUAGE FIX
	$GLOBALS['premiumpress']['language'] =  get_option('language');
	
	// LOAD IN LANGUAGE
	$PPT->Language();

	$errors = new WP_Error();

	// BASIC VALIDATION
	//if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) ){
	//$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a>.",'cp'));
	//}				
	if	( isset($_GET['fr'])){
	$errors->add('loggedout', __($PPT->_e(array('login','_zz9')),'cp'), 'message');
	}
	
	if	( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )			$errors->add('loggedout', __($PPT->_e(array('login','_zz7') ),'cp'), 'message');
	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )	$errors->add('registerdisabled', __( "".$PPT->_e(array('login','_zz8')),'cp'));
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )	$errors->add('confirm', __( $PPT->_e(array('login','_zz9')),'cp'), 'message');
	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )	$errors->add('newpass', __( $PPT->_e(array('login','_zz10')),'cp'), 'message');
	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )	$errors->add('registered', __( $PPT->_e(array('login','_zz11')),'cp'), 'message'); 
 	
	// CHECK FOR PLUGIN ERRORS 
	if(strlen($_POST['log']) > 1 ){
		$plugin_error = apply_filters('login_errors','');
		 if(strlen($plugin_error) > 5){
			$errors->add('registered', __( $plugin_error,'cp'), 'error');
		 }
	}
  
 	// CHECK FOR BASIC ERRORS AND THAT THE FORUM HAS BEEN PRESSED
	if ( empty($errors->errors) && isset($_POST['log'])  ) {
 
 		// CHECK FOR SECURE LOGINS
		if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) ){
			$secure_cookie = false;
		}else{
			$secure_cookie = '';
		}
		// DO LOGIN	
		$user = wp_signon('', $secure_cookie);
 
		// SEE IF LOGIN WAS SUCCESSFULL
		if ( !is_wp_error($user) ) {
		
			// GET THE USER STATUS, ADDED IN V7
			$status = get_user_meta($user->ID, "pptaccess", true);
		
			// CHECK ACCOUNT STATUS
			if($status == "pending"){
			wp_logout();
			die($PPT->_e(array('login','11')));
			
			}elseif($status == "suspended"){			
			wp_logout();
			die($PPT->_e(array('login','12')));
			
			}elseif($status == "fired"){			
			wp_logout();
			die($PPT->_e(array('login','13')));		
			}	 
		 
			// REDIRECT USER TO ACCOUNT PAGE
			if(defined('PREMIUMPRESS_DEMO') && $user->user_level == 1){
				$redirect_to = admin_url()."admin.php?page=ppt_admin.php";
			 }elseif($user->user_level > 2){
				$redirect_to = admin_url()."admin.php?page=ppt_admin.php";;
			 }else{
				$redirect_to = get_option("dashboard_url");
				if($redirect_to == ""){ $redirect_to = $GLOBALS['bloginfo_url']; }
			 }
			 header("location: ".$redirect_to);
			 exit();	
		}

	$errors = $user;
	
	} // end basic validation
 

// START O
cp_head(__('Login','cp'));	

$string = ""; 
$string .= cp_show_errors($errors);

if(!isset($_POST['log'])){ $_POST['log']=""; }
 
if(defined('PREMIUMPRESS_DEMO')){
$ee = '<div class="green_box"><div class="green_box_content"><img src="'.get_template_directory_uri().'/PPT/img/thumb_up.png" alt="logins" alt="absmiddle" /> <b>Demo User Logins</b>: username: demo | password: demo <div></div></div></div>';
$ee .= '<div class="yellow_box"><div class="yellow_box_content"><img src="'.get_template_directory_uri().'/PPT/img/pakicon.png" alt="logins" alt="absmiddle" /> <b>Admin User Logins</b>: username: admindemo | password: admindemo <div></div></div></div>';

}else{
$ee = "";
}

$string .= ''.$ee.'<div class="itembox">

	<h2 class="title">'.$PPT->_e(array('login','1')).'</h2>
	
	<div class="itemboxinner">
	
<fieldset style="background:transparent;"> 
<form class="loginform" action="'.get_bloginfo('wpurl').'/wp-login.php" method="post" > 
<input type="hidden" name="testcookie" value="1" /> 
<input type="hidden" name="rememberme" id="rememberme" value="forever" />
 
<div class="full clearfix box"> 
<p class="f_half left"> 
    <label for="name">'.$PPT->_e(array('login','_zz3')).'</label> 
    <input type="text" name="log" value="'.esc_attr(stripslashes($_POST['log'])).'" id="user_login" class="short" tabindex="10" />  
</p> 
<p class="f_half left"> 
    <label for="email">'.$PPT->_e(array('myaccount','26')).':</label> 
    <input type="password"name="pwd" id="user_pass" class="short" tabindex="11" />  
</p> 
</div>';

echo premiumpress_password_inside($string); 
do_action('login_form');

$string =' 

<input type="submit" name="submit" id="submit" class="button gray" tabindex="15" value="'.$PPT->_e(array('button','16')).'" /><div class="clearfix"></div> <br />

</form> 
 
</fieldset>    
</div>

<div class="enditembox inner">
<a href="wp-login.php?action=register" class="button gray left">'.$PPT->_e(array('login','6')).'</a> 
<a href="wp-login.php?action=lostpassword" class="button gray right">'.$PPT->_e(array('login','5')).'</a>
</div>

</div>';	

echo premiumpress_login_inside($string); 		
  
cp_footer();
}


function cp_show_register() {

global $PPT, $PPTDesign; $user_login = ''; $user_email = ''; 

 	// CHECK IF REGISTRATION IS ENABLED
	if ( !get_option('users_can_register') ) {
		wp_redirect(get_bloginfo('wpurl').'/wp-login.php?registration=disabled');
		exit();
	}
	
	// LANGUAGE FIX
	$GLOBALS['premiumpress']['language'] =  get_option('language');
	
	// LOAD IN LANGUAGE
	$PPT->Language();

	// LOAD IN ERRORS
	$errors = new WP_Error(); 

	// V7 // MEMBERSHIP PACKAGE INTEGRATION	
	$packagedata 	= get_option('ppt_membership');
	$fielddata 		= get_option('ppt_profilefields');
	
	
	// START BASIC VALIDATION
	if ( isset($_POST['user_login']) && strlen($_POST['user_login']) > 1 ) {
	
		require_once( ABSPATH . WPINC . '/registration.php');
	
		// ADD SUPPORT FOR CAPTHCA
		if(function_exists('cptch_register_post')){ // 1. http://wordpress.org/extend/plugins/captcha/
				
			$errors = cptch_register_post('','',$errors);
			
		}
			
		if(function_exists('si_captcha_register_post')){ // 2. http://wordpress.org/extend/plugins/si-captcha-for-wordpress/
			 
			$errors = si_captcha_register_post($errors);
			
		}
		
		 $plugin_error = apply_filters('registration_errors','');
		 if(strlen($plugin_error) > 5){
			$errors->add('registered', __( $plugin_error,'cp'), 'error');
		 }
	 
	}
 

  
	if ( isset($_POST['user_login']) && empty($errors->errors) ) {
 		
			
			// ADDED IN 7.1.1 SO THE USER IS SENT THE PASSWORD VIA EMAIL
			if(get_option("users_can_register_setup") =="1"){ 
			
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
				$_POST['password'] = $random_password;	
			
			}
			
			// 1. REGISTER THE NEW USER			 
			$errors = wp_create_user( $_POST['user_login'], $_POST['password'], $_POST['user_email'] );
			 
			if ( !is_wp_error($errors) ) {					 		
			
				// REGISTER ANY NEW CUSTOM REGISTRATION FIELDS
				if(isset($_POST['custom'])){ 
					foreach($_POST['custom'] as $key=>$val){
						add_user_meta( $errors, $key, esc_html(strip_tags($val)), true);
					} 
				}
				
				// UPDATE USER DATA
				update_user_meta($errors, "first_name", esc_html(strip_tags($_POST['form']['first_name'])) );
				update_user_meta($errors, "last_name", esc_html(strip_tags($_POST['form']['last_name'])) );
				update_user_meta($errors, "description", esc_html(strip_tags($_POST['form']['description'])) );
				
			 	// SETUP DEFAULT ACCOUNT STATUS
				update_user_meta($errors, "pptaccess", get_option('pptuser_default'));
				
				// SETUP DEFAULT PACKAGE ACCESS
				
				if(!isset($_POST['SELECTEDPACKAGEID']) || $_POST['SELECTEDPACKAGEID'] == ""){
				
				update_user_meta($errors, "pptmembership_level", "0");
				update_user_meta($errors, "pptmembership_status", "ok");
				update_user_meta($errors, "pptmembership_expires", "");				 
				
				}elseif(isset($_POST['SELECTEDPACKAGEID']) && is_numeric($_POST['SELECTEDPACKAGEID'])){
				
				// GET PACKAGE DURATION
				$duration = "1000"; // default
				$packagedata = get_option('ppt_membership');
				if(is_array($packagedata) && isset($packagedata['package']) ){
					foreach($packagedata['package'] as $package){		
						if($package['ID'] == $_POST['SELECTEDPACKAGEID'] && $package['duration'] !=""){
							$duration = $package['duration'];
							$price = $package['price'];
						}		
					}
				}
				
				//die($duration."<--".date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$duration." days")));
				
				// IS THIS A FREE PACKAGE?????
				if($price == "" || $price == 0){
				update_user_meta($errors, "pptmembership_status", "ok");
				}else{
				update_user_meta($errors, "pptmembership_status", "pending");
				}
				// SET PACKAGE
				update_user_meta($errors, "pptmembership_level", $_POST['SELECTEDPACKAGEID']);				
				update_user_meta($errors, "pptmembership_expires", date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$duration." days")));				
				update_user_meta($errors, "pptmembership_datestarted", date("Y-m-d H:i:s"));
				
				}
				
				// GET THE USER STATUS, ADDED IN V7				
				if(get_option('pptuser_default') == "pending"){	
				
						// SEND EMAIL TO THE USER
						$emailID = get_option("email_register_pending");					 
						if(is_numeric($emailID) && $emailID != 0  ){			 
							SendMemberEmail($user->ID, $emailID);					 
						} 
						// SEND EMAIL TO THE ADMIN
						$emailID = get_option("email_register_pending_admin");					 
						if(is_numeric($emailID) && $emailID != 0  ){			 
							SendMemberEmail("admin", $emailID);					 
						}
						
					wp_logout();
					die($PPT->_e(array('login','11')));	
								
				}else{
				
					// SEND WELCOME EMAIL
					$emailID = get_option("email_signup");					 
					if(is_numeric($emailID) && $emailID != 0){
						SendMemberEmail($errors, $emailID);
					}
				
					// SEND ADMIN NEW USER EMAIL // VERSION 7.1.1
					$emailID = get_option("email_signup_admin");					 
					if(is_numeric($emailID) && $emailID != 0){
						SendMemberEmail("admin", $emailID);
					}
				
				}
				
				if(get_option("users_can_register_setup") !="1"){
				// LOGIN USER	
				$creds = array();
				$creds['user_login'] 	= $_POST['user_login'];
				$creds['user_password'] = $_POST['password'];
				$creds['remember'] 		= true;
				$userdata = wp_signon( $creds, false );
				
				$redirect_to = get_option("dashboard_url");
			 	if($redirect_to == ""){ $redirect_to = $GLOBALS['bloginfo_url']; }
			
				header("location: ".$redirect_to);
		 		exit();							
				
				}else{
				
				
				$redirect_to = $GLOBALS['bloginfo_url']."/wp-login.php?fr=1";
			
				header("location: ".$redirect_to);
		 		exit();	
				
				}
				
			}
		 
	}
	
	cp_head(__('Register','cp'));
	

// DEFAULTS
if(!isset($_POST['form'])){
$_POST['form']['first_name'] = "";
$_POST['form']['last_name'] = "";
$_POST['form']['description'] = "";
$_POST['user_login'] = "";
$_POST['user_email'] = "";
}
$GLOBALS['titlec']=1;
$string = ""; 
$string .= cp_show_errors($errors);


	// NO ACCESS FOR PACKAGE PERMISSIONS
	if(isset($_GET['noaccess']) && $_GET['noaccess'] == 1){
	$string .= "<div class='red_box'><div class='red_box_content'><h3>".$PPT->_e(array('membership','1'))."</h3>";	
	$string .= "<p>".$PPT->_e(array('membership','2'))."</p> ";	
	$string .= "</div></div>";
	} 

$string .= '
<div class="itembox">

<h2 class="title">'.$PPT->_e(array('login','6')).'</h2>

<div class="itemboxinner">
<form class="loginform" name="registerform" id="registerform" action="'.site_url('wp-login.php?action=register', 'login_post').'" method="post" onsubmit="return CheckFormData(); ">  
<fieldset style="background:transparent;">

<h4><span>'.$GLOBALS['titlec'].'</span>'.$PPT->_e(array('login','reg1')).'</h4><div class="clearfix"></div>'; $GLOBALS['titlec']++;


$string .= '<div class="full clearfix  box"> 
<p class="f_half left"> 
    <label for="name">'.$PPT->_e(array('login','10')).' <span class="required">*</span></label> 
    <input type="text" name="user_login" value="'.esc_html(strip_tags($_POST['user_login'])).'" id="user_login" class="short" tabindex="1" /> 
</p> 
<p class="f_half left"> 
    <label for="email">'.$PPT->_e(array('add','28')).' <span class="required">*</span></label> 
    <input type="text" name="user_email" id="email1" value="'.esc_html(strip_tags($_POST['user_email'])).'"  class="short" tabindex="2" /> 
</p> 
</div>';

if(get_option("users_can_register_setup") =="1"){ }else{

$string .= '<div class="full clearfix box"> 

                                <p class="f_half left"> 
                                    <label for="name">'.$PPT->_e(array('myaccount','26')).' <span class="required">*</span></label> 
                                    <input type="password" name="password" id="password" class="short" tabindex="3" /> 
                                  
                                </p> 
                                <p class="f_half left"> 
                                    <label for="email">'.$PPT->_e(array('myaccount','27')).' <span class="required">*</span></label> 
                                    <input type="password" name="password_r" id="rpassword" class="short" tabindex="4" /> 
                                     
                                </p> 
</div>'; 

}



// HIDE FIELDS // V7.0.9.6 // 20TH MAY
if(isset($fielddata['default1']) && $fielddata['default1'] ==1){ }else{

$string .= '<h4><span>'.$GLOBALS['titlec'].'</span>'.$PPT->_e(array('myaccount','2')).'</h4><div class="clearfix"></div>';

}



$string .= '<div class="full clearfix box">';

// HIDE FIELDS // V7.0.9.6 // 20TH MAY
if(isset($fielddata['default2']) && $fielddata['default2'] ==1){ }else{
 
			  
                $string .= '<p class="f_half left" id="formelement1"> 
                    <label for="name">'.$PPT->_e(array('myaccount','10')).' <span class="required">*</span></label> 
                    <input type="text" name="form[first_name]" id="first_name" value="'.esc_html(strip_tags($_POST['form']['first_name'])).'" class="short" tabindex="5" /> 
                   
                </p>';
}

// HIDE FIELDS // V7.0.9.6 // 20TH MAY
if(isset($fielddata['default3']) && $fielddata['default3'] ==1){ }else{
				 
                $string .= '<p class="f_half left" id="formelement2"> 
                    <label for="email">'.$PPT->_e(array('myaccount','11')).' <span class="required">*</span></label> 
                    <input type="text" name="form[last_name]" id="last_name" value="'.esc_html(strip_tags($_POST['form']['last_name'])).'" class="short" tabindex="6" /> 
                     
                </p>'; 
}
				
$string .= '</div>';

// HIDE FIELDS // V7.0.9.6 // 20TH MAY
if(isset($fielddata['default4']) && $fielddata['default4'] ==1){ }else{
 
$string .= '<div class="full clearfix box" id="formelement5"> 
                
                <p> 
                    <label for="comment2">'.$PPT->_e(array('myaccount','14')).'</label> 
                    <textarea tabindex="7" class="long" rows="4" name="form[description]">'.esc_html(strip_tags($_POST['form']['description'])).'</textarea> 
                
                </p> 
</div>';

}

$string .= $PPTDesign->ProfileFields();


echo premiumpress_register_inside($string);

do_action('register_form');

$string ="<div class='clearfix'></div>";

// SHOULD WE OUTPUT THE MEMBERSHIP PACKAGES???
if($packagedata['show_register']  == "yes"){

$string .= $PPTDesign->Memberships();

} 

 
$string .= '<div class="clearfix"></div>
 
<p><input type="submit" name="submit" id="submit" class="button gray" tabindex="15" value="'.$PPT->_e(array('login','18')).'" /></p><br />';
 

	
$string .= '</fieldset></form></div>

<div class="enditembox inner">
<a href="wp-login.php?action=login" class="button gray left">'.$PPT->_e(array('login','1')).'</a> 
<a href="wp-login.php?action=lostpassword" class="button gray right">'.$PPT->_e(array('login','5')).'</a>
</div>

</div>';
    
echo premiumpress_register_inside($string); 
 

?>
<script language="javascript" type="text/javascript">
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};
		function CheckFormData()
		{
 
 		
		<?php echo $PPTDesign->RegisterCustomRequiredFields(); ?>
			
		var user_login = document.getElementById("user_login");
			var name = document.getElementById("first_name");
			var lname  = document.getElementById("last_name"); 
			var email1 	= document.getElementById("email1");			
			var pass = document.getElementById("password");
 			var pass1 = document.getElementById("rpassword");
			
			<?php if($packagedata['show_register']  == "yes" && isset($packagedata['package']) ){ ?>
			var pak1 = document.getElementById("SELECTEDPACKAGEID");
			if(pak1.value == "")
			{
				alert('<?php echo $PPT->_e(array('validate','22')); ?>');				 
				pak1.focus();
				return false;
			}
			
			<?php } ?> 
		 
			if(user_login.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','20')); ?>');
				user_login.style.border = 'thin solid red';
				user_login.focus();
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
 		
			if(pass.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','21')); ?>');
				pass.style.border = 'thin solid red';
				pass1.style.border = 'thin solid red';
				pass.focus();
				return false;
			}
			
			if(pass1.value == '')
			{
				alert('<?php echo $PPT->_e(array('validate','4')); ?>');
				pass.style.border = 'thin solid red';
				pass1.style.border = 'thin solid red';
				pass.focus();
				return false;
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
<?php
  
cp_footer();

}



function cp_password() {
	
	global $PPT;
	
	if ( isset($_POST['user_login']) && $_POST['user_login'] ) {
 
		$errors = new WP_Error();
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			wp_redirect('wp-login.php?checkemail=confirm');
			exit();
		}
		
		if ( 'invalidkey' == $_GET['error'] ) 
		$errors->add('invalidkey', $PPT->_e(array('login','_zz6')),'cp');

		$errors->add('registermsg', $PPT->_e(array('login','_zz5')), 'message');	
		
		do_action('lostpassword_post');
	}

	cp_head("Lost Password");

if(!isset($_POST['user_login'])){ $_POST['user_login']=""; }
if(!isset($errors)){ $errors=""; }

$string = ""; 
$string .= cp_show_errors($errors);

$string .= '<div class="itembox"><h2 class="title">'.$PPT->_e(array('login','5')).'</h2><div class="itemboxinner"> 
    
<form class="loginform" name="lostpasswordform" id="lostpasswordform" action="'.site_url('wp-login.php?action=lostpassword', 'login_post').'" method="post">
<fieldset style="background:transparent;"> 
<p>'.$PPT->_e(array('login','15')).'</p> 
<div class="full clearfix border_t box"> 
<p> 
    <label for="name">'.$PPT->_e(array('login','_zz3')).'</label> 
    <input type="text"  name="user_login" id="user_login" value="'.esc_attr(stripslashes($_POST['user_login'])).'"/> 
   
</p> 
</div>';

echo premiumpress_password_inside($string); 
do_action('lostpassword_form');

$string = '
<div class="full clearfix border_t box"><p class="full clearfix"> 
<input type="submit" name="submit" id="submit" class="button gray" tabindex="15" value="'.$PPT->_e(array('login','9')).'" /> 
</p></div>
</fieldset>
</form>  
</div>

<div class="enditembox inner">
<a href="wp-login.php?action=login" class="button gray left">'.$PPT->_e(array('login','1')).'</a> 
<a href="wp-login.php?action=register" class="button gray right">'.$PPT->_e(array('login','6')).'</a>
</div>

</div>'; 
 
echo premiumpress_password_inside($string); 		
  
cp_footer(); }

/* =============================================================================
   DEFAULT THEME ACTIONS FOR ALL PPT THEME
   ========================================================================== */
   
function PremiumPressActions(){

global $post, $wpdb, $PPT, $PPTDesign, $wp_query;

	/* =============================================================================
	   SETUP SITE GLOBALS // V7 // 16TH MARCH
	   ========================================================================== */
	
	$GlobalsArray = array("language","logo_url","feature_expiry","feature_expiry_do","imagestorage_link","thumbresize","submit_url","manage_url","dashboard_url",
	"contact_url","post_prun","prun_period","prun_status","analytics_tracking","faviconLink","nofollow"); 
	foreach($GlobalsArray as $value){
	$GLOBALS['premiumpress'][$value] 	= get_option($value);
	}  
	if(!defined('PREMIUMPRESS_DEMO')){$GLOBALS['premiumpress']['theme'] = get_option('theme');} 
	$GLOBALS['theme_folder'] 		= strtolower(PREMIUMPRESS_SYSTEM);
	
	// CURRENY OPTIONS // TODO // CLEAN UP
	$GLOBALS['premiumpress']['currency_symbol']		= get_option("currency_code");
	$GLOBALS['premiumpress']['currency_position'] 	= get_option("display_currency_position");
	$GLOBALS['premiumpress']['currency_format'] 	= get_option("display_currency_format");

	// INITIALIZE LANGUAGE FILE
	if(is_object($PPT)){ $PPT->Language(); }

 	/* =============================================================================
	   SETUP SIDEBARS // V7 // 16TH MARCH 
	   ========================================================================== */

	$GLOBALS['ppt_layout_styles'] = get_option('ppt_layout_styles');
	if(isset($GLOBALS['flag-home'])){ 	
		
		// SP HAS ITS OWN HOME PAGE SYSTEM SO WE NEED TO FACTOR THIS
		// INTO THE SYSTEM
		if(strtolower(PREMIUMPRESS_SYSTEM) == "shopperpress"){	
			
			if( get_option("display_default_homepage") == 1){
				$ppt_layout_columns  = get_option("ppt_homepage_columns");
			}else{
				$DHOME = get_option("display_default_homepage");	
				$ppt_layout_columns  = 0;
			}
		
		}else{ 		
			$ppt_layout_columns  = get_option("ppt_homepage_columns");		
		}	
	 
	}else{
	
		if(isset($GLOBALS['IS_SINGLEPAGE']) && !isset($GLOBALS['ARTICLEPAGE']) ){
		
			$ppt_layout_columns  = get_option("ppt_listing_columns"); 	
					 
		}elseif(isset($GLOBALS['IS_SINGLEPAGE']) && isset($GLOBALS['ARTICLEPAGE']) ){
		
			$ppt_layout_columns  = get_option("ppt_articlecolumns");
		
		}else{
			$ppt_layout_columns = get_option("ppt_layout_columns");
		}
	}	

	// NOW SETUP GLOBALS
	
	$GLOBALS['ppt_columncount'] = $ppt_layout_columns;
	$GLOBALS['nosidebar'.$ppt_layout_columns] = true;

	if(!isset($_GET['s']) && !isset($_GET['search-class']) ){
	 
		if( $ppt_layout_columns =="0"){ 		$GLOBALS['nosidebar-right'] =1; $GLOBALS['nosidebar-left'] =1;
		}elseif( $ppt_layout_columns =="1"){ 	$GLOBALS['nosidebar-left'] =1;
		}elseif( $ppt_layout_columns =="2"){ 	$GLOBALS['nosidebar-right'] =1;
		} 
		
	}else{
	
		if(isset($GLOBALS['IS_SINGLEPAGE'])){
			$nl  = get_option("ppt_listing_columns"); 
		}else{
			$nl = get_option("ppt_layout_columns");
		}
		if($nl  == 3 ){ }
		elseif($nl == 1){ 		$GLOBALS['nosidebar-left'] =1; }
		elseif($nl == 2){ 		$GLOBALS['nosidebar-right'] =1; 
		}else{ 					$GLOBALS['nosidebar-right'] =1; $GLOBALS['nosidebar-left'] =1;  } 
	
	}

 	/* =============================================================================
	   SETUP CATEGORY ID'S // V7 // 16TH MARCH 
	   ========================================================================== */

	if(isset($wp_query)){
	
		$category = $wp_query->get_queried_object();
	  
		if(is_object($category) && isset($category->cat_ID) || isset($category->term_id) ){
	 
			if(isset($category->term_id)){
			$GLOBALS['premiumpress']['catID'] = $category->term_id;	
			$GLOBALS['premiumpress']['pcatID'] = $category->parent;		 
			}else{
			$GLOBALS['premiumpress']['catID'] = $category->cat_ID;
			$GLOBALS['premiumpress']['pcatID'] = $category->parent;	
			}
			
			
			 
			/* GET THE CATEGORY TEXT AND IMAGE FOR THIS CATEGORY */			
			 
			if(isset($category->taxonomy) && strlen($category->taxonomy) > 0 && $category->taxonomy !="category"){
			$GLOBALS['premiumpress']['taxonomy'] = $category->taxonomy;
			}
			 
			if(isset($category->category_parent) && $category->category_parent == 0){ 
			$GLOBALS['premiumpress']['catParent'] = true;
			}else{
			$GLOBALS['premiumpress']['catParent'] = false;
			}
			
			$GLOBALS['premiumpress']['catName'] = $category->name;
			$GLOBALS['premiumpress']['catDesc'] = do_shortcode($category->description);
			if($GLOBALS['premiumpress']['catDesc'] == "99"){ $GLOBALS['premiumpress']['catDesc'] =""; }
			$GLOBALS['catText'] 	=  wpautop($GLOBALS['premiumpress']['catDesc']); 
			$GLOBALS['premiumpress']['catCount'] = $category->count;
			$GLOBALS['premiumpress']['catIcon'] =""; 
			
			
			// TAXONOMY ICON // VERSION 7.1.1
			if($category->taxonomy == "store" || $category->taxonomy == "category"){
				$CATARRAY = get_option("cat_icons");		 
				if(isset($CATARRAY[$GLOBALS['premiumpress']['catID']]['image'])){				 			
					$Cimg = str_replace(".png","",$CATARRAY[$GLOBALS['premiumpress']['catID']]['image']);
					if(is_numeric($Cimg)){ $imgPath = get_template_directory_uri().'/images/icons/'.$CATARRAY[$GLOBALS['premiumpress']['catID']]['image'];  }else{  $imgPath = $CATARRAY[$GLOBALS['premiumpress']['catID']]['image']; }			
					$GLOBALS['premiumpress']['catIcon'] = $imgPath;
				}else{ 
					$GLOBALS['premiumpress']['catIcon'] =""; 
				}
			}
			   
		}else{
		
		
		$GLOBALS['premiumpress']['catID'] = "";
		$GLOBALS['premiumpress']['catName'] = "";
		$GLOBALS['premiumpress']['catDesc'] = "";
		}
	}

 


	// FILE DOWNLOAD SYSTEM
	// USED MOSTLY IN SP BUT MAY USED FOR FUTHER THEMES
	if(isset($_POST) && isset($_POST['hash']) ){
		
			check_admin_referer('FileDownload');
			 
			if(isset($_POST['fileID'])){
				if($_POST['fileID'] > 800){
					$FILE_ID = $_POST['fileID']/800;
				}else{
					$FILE_ID = $_POST['fileID']; // fallback just incase modification
				}
				
			}else{
				$FILE_ID = $post->ID;			
			}
	 
			if(isset($_COOKIE['ItemDownload'.$FILE_ID]) || isset($_POST['force']) ){
			$IGNORECREDITDOWNLOAD =1;
			}else{
			$IGNORECREDITDOWNLOAD =0;
			}
			 
			$PPT->DownloadFile($FILE_ID,$IGNORECREDITDOWNLOAD);	
	}

	// START PAGE ACTIONS
	if(isset($_POST['action'])){
	
		if($_POST['action'] == "sidebarcontact"){		 
			 
			// CHECK TO ENSURE THE VALIDATION CODE IS CORRECT	 
			if(	$_POST['code'] != "" && $_POST['code'] == $_POST['code_value']){
				
				$_POST['title'] = $post->post_title;
				
				// ADD REFERENCE LINK TO THE MESSAGE
				$ExtraMessage = "\r\n<a href='".get_permalink($post->ID)."'>".get_permalink($post->ID)."</a>\r\n"; 
		 
				$my_post = array();
				$my_post['post_title'] 		= $_POST['message_from'];
				$my_post['post_content'] 	= strip_tags(strip_tags($_POST['message_message']))."<br />".$ExtraMessage;
				$my_post['post_excerpt'] 	= "";
				$my_post['post_status'] 	= "publish";
				$my_post['post_type'] 		= "ppt_message";
				$my_post['post_author'] 	= $userdata->ID;
				$POSTID 					= wp_insert_post( $my_post );
				
				// ADD SOME EXTRA CUSTOM FIELDS
				add_post_meta($POSTID, "username", strip_tags($_POST['message_name']) );	
				add_post_meta($POSTID, "from", strip_tags($_POST['message_from']) );
				add_post_meta($POSTID, "email", strip_tags(strip_tags($_POST['message_subject'])) );	
				add_post_meta($POSTID, "status", "unread" );
				add_post_meta($POSTID, "ref", get_permalink($post->ID) );
			
				$GLOBALS['error'] 		= 1;
				$GLOBALS['error_type'] 	= "success"; //ok,warn,error,info
				$GLOBALS['error_msg'] 	= $PPT->_e(array('contact','7'));
				
				// SEND EMAIL TO THE USER
				$emailID = get_option("email_message_new");					 
				if(is_numeric($emailID) && $emailID != 0  ){	
				
					if(get_option("email_forward_enabled") ==1){ 
					SendMemberEmail("admin", $emailID, $ExtraMessage);
					}else{
					SendMemberEmail($post->post_author, $emailID, $ExtraMessage);
					}		 
										 
				}	 
			
			}else{
			
				$GLOBALS['error'] 		= 1;
				$GLOBALS['error_type'] 	= "error"; //ok,warn,error,info
				$GLOBALS['error_msg'] 	= $PPT->_e(array('contact','8'));		
			}
			
		} // end sidebar contact form	
	
	} // end if action 

} // end function

add_action('premiumpress_action','PremiumPressActions'); // add in new hook


/* =============================================================================
   HOOKS // ADMIN AREA
   ========================================================================== */
   
function premiumpress_admin_payments_gateways($gateways){ return  apply_filters('premiumpress_admin_payments_gateways', $gateways);  }	

function premiumpress_admin_display_objects($objects){ return  apply_filters('premiumpress_admin_display_objects', $objects);  }	
	function premiumpress_admin_display_objects_options(){  do_action('premiumpress_admin_display_objects_options');  }	
		function premiumpress_admin_display_objects_display($item){ return apply_filters('premiumpress_admin_display_objects_display', $item);  }	
 
function premiumpress_admin_setup_left_column(){  do_action('premiumpress_admin_setup_left_column');  } // Executed below the opening #wrapper tag.
function premiumpress_admin_setup_right_column(){  do_action('premiumpress_admin_setup_right_column');  } // Executed below the opening #wrapper tag.

function premiumpress_admin_overview_left_column(){  do_action('premiumpress_admin_overview_left_column');  } // Executed below the opening #wrapper tag.
function premiumpress_admin_overview_right_column(){  do_action('premiumpress_admin_overview_right_column');  } // Executed below the opening #wrapper tag.

 
function premiumpress_admin_submission_left_column(){  do_action('premiumpress_admin_submission_left_column');  } // Executed below the opening #wrapper tag.
function premiumpress_admin_submission_right_column(){  do_action('premiumpress_admin_submissionp_right_column');  } // Executed below the opening #wrapper tag.
 
function premiumpress_admin_post_custom_title(){  do_action('premiumpress_admin_post_custom_title');  } // Executed below the opening #wrapper tag.
function premiumpress_admin_post_custom_content(){  do_action('premiumpress_admin_post_custom_content');  } // Executed below the opening #wrapper tag.
 

/* =============================================================================
   HOOKS // CALLBACK
   ========================================================================== */
 
function premiumpress_callback_paymentstatus($order_id){ return  apply_filters('premiumpress_callback_paymentstatus', $order_id);  }	
function premiumpress_callback_thankyou(){  do_action('premiumpress_callback_thankyou');  } // Executed below the opening #wrapper tag.
function premiumpress_callback_pending(){  do_action('premiumpress_callback_pending');  } // Executed below the opening #wrapper tag.
function premiumpress_callback_error(){  do_action('premiumpress_callback_error');  } // Executed below the opening #wrapper tag.
 
/* =============================================================================
   HOOKS // HEADER // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_top(){  do_action('premiumpress_top');  } // Executed below the opening #wrapper tag.
function premiumpress_bottom(){  do_action('premiumpress_bottom');  } // Executed after the #wrapper tag.

/* =============================================================================
   HOOKS // HEADER // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_header_before(){  do_action('premiumpress_header_before');  } //Executed before the opening #header DIV tag.
function premiumpress_header_inside($content){  return apply_filters('premiumpress_header_inside',$content);  } // Executed at the top, inside the #header DIV tag.
function premiumpress_header_after(){  do_action('premiumpress_header_after');  } //Executed after the closing #header DIV tag.

/* =============================================================================
   HOOKS // MENU // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_menu_before(){  do_action('premiumpress_menu_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_menu_inside($content){  return apply_filters('premiumpress_menu_inside',$content);  } // Executed at the top, inside the #menubar DIV tag.
function premiumpress_menu_after(){  do_action('premiumpress_menu_after');  } //Executed after the closing #menubar DIV tag.

/* =============================================================================
   HOOKS // SUB MENU // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_submenu_before(){  do_action('premiumpress_submenu_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_submenu_inside($content){  return apply_filters('premiumpress_submenu_inside',$content);  } // Executed at the top, inside the #menubar DIV tag.
function premiumpress_submenu_after(){  do_action('premiumpress_submenu_after');  } //Executed after the closing #menubar DIV tag.

/* =============================================================================
   HOOKS // PAGE // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_page_before(){  do_action('premiumpress_page_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_page_after(){  do_action('premiumpress_page_after');  } //Executed after the closing #menubar DIV tag.

/* =============================================================================
   HOOKS // CONTENT // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_content_before(){  do_action('premiumpress_content_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_content_after(){  do_action('premiumpress_content_after');  } //Executed after the closing #menubar DIV tag.

/* =============================================================================
   HOOKS // CONTENT // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_footer_before(){  do_action('premiumpress_footer_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_footer_inside(){  do_action('premiumpress_footer_inside');  } //Executed after the closing #menubar DIV tag.
function premiumpress_footer_after(){  do_action('premiumpress_footer_after');  } //Executed after the closing #menubar DIV tag.
 
/* =============================================================================
   HOOKS // MIDDLE - LEFT - RIGHT // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_middle_top(){  do_action('premiumpress_middle_top');  } //Executed before the opening #menubar DIV tag.
function premiumpress_middle_bottom(){  do_action('premiumpress_middle_bottom');  } //Executed after the closing #menubar DIV tag.

function premiumpress_sidebar_left_top(){  do_action('premiumpress_sidebar_left_top');  } //Executed before the opening #menubar DIV tag.
function premiumpress_sidebar_left_bottom(){  do_action('premiumpress_sidebar_left_bottom');  } //Executed after the closing #menubar DIV tag.

function premiumpress_sidebar_right_top(){  do_action('premiumpress_sidebar_right_top');  } //Executed before the opening #menubar DIV tag.
function premiumpress_sidebar_right_bottom(){  do_action('premiumpress_sidebar_right_bottom');  } //Executed after the closing #menubar DIV tag.

/* =============================================================================
   HOOKS // LOGIN PAGE // FRONT AREA // DESIGN
   ========================================================================== */
   
function premiumpress_login_top(){  do_action('premiumpress_login_top');  } //Executed before the opening #menubar DIV tag.
function premiumpress_login_bottom(){  do_action('premiumpress_login_bottom');  } //Executed before the opening #menubar DIV tag.

function premiumpress_login_inside($content){  return apply_filters('premiumpress_login_inside',$content);  } //Executed before the opening #menubar DIV tag.
function premiumpress_register_inside($content){  return apply_filters('premiumpress_register_inside',$content);  } //Executed before the opening #menubar DIV tag.
function premiumpress_password_inside($content){  return apply_filters('premiumpress_password_inside',$content);  } //Executed before the opening #menubar DIV tag.
 
/* =============================================================================
   HOOKS // MY ACCOUNT // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_account_top(){  do_action('premiumpress_account_top');  } //Executed before the opening #menubar DIV tag.
function premiumpress_account_bottom(){  do_action('premiumpress_account_bottom');  } //Executed before the opening #menubar DIV tag.
	function premiumpress_account_options(){  do_action('premiumpress_account_options');  } //Executed before the opening #menubar DIV tag.
	function premiumpress_account_details(){  do_action('premiumpress_account_details');  } //Executed before the opening #menubar DIV tag.
		function premiumpress_account_details_filter($content){  return apply_filters('premiumpress_account_details_filter',$content);  }

function premiumpress_edit_top(){  do_action('premiumpress_edit_top');  } //Executed before the opening #menubar DIV tag.
function premiumpress_edit_bottom(){  do_action('premiumpress_edit_bottom');  } //Executed before the opening #menubar DIV tag.

function premiumpress_manage_filter($content){  return apply_filters('premiumpress_manage_filter', $content);  }
	
function premiumpress_manage_text($text=''){ return apply_filters('premiumpress_manage_text',$text);  }
	
	
/* =============================================================================
   HOOKS // PACKAGE BLOCK // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_packages_before(){  do_action('premiumpress_packages_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_packages_inside($content){  return apply_filters('premiumpress_packages_inside',$content);  } //Executed after the closing #menubar DIV tag.
function premiumpress_packages_after(){  do_action('premiumpress_packages_after');  } //Executed after the closing #menubar DIV tag.

/* =============================================================================
   HOOKS // SUBMISSION FORM // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_packages_step1_before(){  do_action('premiumpress_packages_step1_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_packages_step1_fields($content){  return apply_filters('premiumpress_packages_step1_fields',$content);  } //Executed after the closing #menubar DIV tag.
function premiumpress_packages_step1_after(){  do_action('premiumpress_packages_step1_after');  } //Executed after the closing #menubar DIV tag.

function premiumpress_packages_step2_before(){  do_action('premiumpress_packages_step2_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_packages_step2_after(){  do_action('premiumpress_packages_step2_after');  } //Executed after the closing #menubar DIV tag.
function premiumpress_packages_step2_images($content){  return apply_filters('premiumpress_packages_step2_images',$content);  } //Executed after the closing #menubar DIV tag.
function premiumpress_packages_step2_keys($content){  return apply_filters('premiumpress_packages_step2_keys',$content);  } //Executed after the closing #menubar DIV tag.

function premiumpress_packages_step3_before(){  do_action('premiumpress_packages_step3_before');  } //Executed before the opening #menubar DIV tag.
function premiumpress_packages_step3_after(){  do_action('premiumpress_packages_step3_after');  } //Executed after the closing #menubar DIV tag.
function premiumpress_packages_step3_inside_payment(){  do_action('premiumpress_packages_step3_inside_payment');  } //Executed after the closing #menubar DIV tag.
function premiumpress_packages_step3_inside_updated(){  do_action('premiumpress_packages_step3_inside_updated');  } //Executed after the closing #menubar DIV tag.


/* =============================================================================
   HOOKS // ITEM LOOP // FRONT AREA // DESIGN
   ========================================================================== */
   
function premiumpress_item($type){ return apply_filters('premiumpress_item',$type);  } //Executed after the closing #menubar DIV tag
 
/* =============================================================================
   HOOKS // PAGE CONTENT // FRONT AREA // DESIGN
   ========================================================================== */
   
function premiumpress_pagecontent($page){ return apply_filters('premiumpress_pagecontent',$page);  } //Executed after the closing #menubar DIV tag
function premiumpress_action(){ do_action('premiumpress_action');  } //Executed after the closing #menubar DIV tag


/* =============================================================================
   HOOKS // CLASS PREMIUMPRESS //
   ========================================================================== */

function premiumpress_upload_delete($post_id, $imagename,$user_id){   return  apply_filters('premiumpress_upload_delete', array($post_id, $imagename,$user_id));   } // in: post id // out: string
function premiumpress_upload_edit($post_id){   return  apply_filters('premiumpress_upload_edit', $post_id);   } // in: post id // out: string
function premiumpress_upload($file){   return  apply_filters('premiumpress_upload', $file);   } // in: $_FILE (array) // out: filename or error

function premiumpress_upload_return($file){   return  apply_filters('premiumpress_upload_return', $file);   } // in: $_FILE (array) // out: filename or error


function premiumpress_user($ID,$type){   return apply_filters('premiumpress_user', array($ID,$type) );     } // in: $_FILE (array) // out: filename or error
function premiumpress_banner($type,$return=false){ return apply_filters('premiumpress_banner', array($type,$return));   } // in: $_FILE (array) // out: filename or error
function premiumpress_bannerZone($catID,$return=true){ return apply_filters('premiumpress_banner', array($catID,$return));   } // in: $_FILE (array) // out: filename or error


function premiumpress_link($postID,$affiliate=false){ return apply_filters('premiumpress_link', array($postID,$affiliate));   } // in: post ID

function premiumpress_post($type){ return apply_filters('premiumpress_post', $type);   } // in: post ID
function premiumpress_post_data($id, $postid, $user_ID){ return apply_filters('premiumpress_post_data', array($id, $postid, $user_ID) );  } // in: post ID
function premiumpress_post_delete($User_ID, $postid){ return apply_filters('premiumpress_post_delete', array($User_ID, $postid));   } // in: post ID
function premiumpress_post_validate(){ return apply_filters('premiumpress_post_validate',$_POST);   } // in: post ID


function premiumpress_categorylist($id=0,$showAll=false,$showExtraPrice=false,$TaxType="category",$ChildOf=0,$hideExCats=false){ return apply_filters('premiumpress_categorylist', array($id,$showAll,$showExtraPrice,$TaxType,$ChildOf,$hideExCats));   } 

function premiumpress_pagelist($footer=false){ return apply_filters('premiumpress_pagelist', array($footer));   } // in: post ID

function premiumpress_category_extra($cat_id,$type="text",$return=0){ return apply_filters('premiumpress_category_extra', array($cat_id,$type,$return));   } // in: post ID

function premiumpress_expired($post_id,$date){ return apply_filters('premiumpress_expired', array($post_id,$date));   } // in: post ID
function premiumpress_prune($post_id){ return apply_filters('premiumpress_prune', $post_id);  } // in: post ID
function premiumpress_price($price, $code="",$lor="l",$skip=0,$digs=2,$forceZero=false){ return apply_filters('premiumpress_price', array($price, $code,$lor,$skip,$digs,$forceZero));  } // in: post ID

 
function premiumpress_image($data,$type="m",$addedSize=""){ return apply_filters('premiumpress_image', array($data,$type,$addedSize));   } // in: post ID
function premiumpress_image_check($img,$ex="thumb",$addedSize=""){ global $PPT; return $PPT->ImageCheck($img,$ex,$addedSize);  } // in: post ID
 
function premiumpress_authorize(){ do_action('premiumpress_authorize');   } // in: post ID
 
function premiumpress_time_difference($date, $admin=false){ return apply_filters('premiumpress_time_difference', array($date, $admin));   } // in: post ID
 
function premiumpress_functionhook($page){ return apply_filters('premiumpress_functionhook',$page);   } // in: post ID

function premiumpress_language($content){ return apply_filters('premiumpress_language',$content);   } // takes in the entire language file array


/* =============================================================================
   HOOKS // AUTHOR PAGE // FRONT AREA // DESIGN
   ========================================================================== */

function premiumpress_author_description($content){  return apply_filters('premiumpress_author_description',$content);  } //Executed before the opening #menubar DIV tag.
function premiumpress_author_listinginformation($content){  return apply_filters('premiumpress_author_listinginformation',$content);  } //Executed before the opening #menubar DIV tag.
 
function premiumpress_widget_featuredlisting_content($c){ return apply_filters('premiumpress_widget_featuredlisting_content',$c); } // takes in the entire language file array

function premiumpress_article_footer($c){ return apply_filters('premiumpress_article_footer',$c);   } // in: post ID
  
?>