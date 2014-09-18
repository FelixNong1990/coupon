<?php
/**
 * AppThemes common functions.
 *
 * @version 1.0
 * @author AppThemes
 *
 * DO NOT UPDATE WITHOUT UPDATING ALL OTHER THEMES!
 *
 * Add new functions to the /framework/ folder and move existing functions there as well, when you need to modify them.
 *
 */


// contains the reCaptcha anti-spam system. Called on reg pages
function appthemes_recaptcha() {

	if ( ! current_theme_supports( 'app-recaptcha' ) )
		return;

	list( $options ) = get_theme_support( 'app-recaptcha' );
	
	require_once( $options['file'] );
?>
	<script type="text/javascript">
	// <![CDATA[
		var RecaptchaOptions = {
			custom_translations : {
				instructions_visual : "<?php _e( 'Type the two words:', APP_TD ); ?>",
				instructions_audio : "<?php _e( 'Type what you hear:', APP_TD ); ?>",
				play_again : "<?php _e( 'Play sound again', APP_TD ); ?>",
				cant_hear_this : "<?php _e( 'Download sound as MP3', APP_TD ); ?>",
				visual_challenge : "<?php _e( 'Visual challenge', APP_TD ); ?>",
				audio_challenge : "<?php _e( 'Audio challenge', APP_TD ); ?>",
				refresh_btn : "<?php _e( 'Get two new words', APP_TD ); ?>",
				help_btn : "<?php _e( 'Help', APP_TD ); ?>",
				incorrect_try_again : "<?php _e( 'Incorrect. Try again.', APP_TD ); ?>",
			},
			theme: "<?php echo $options['theme']; ?>",
			lang: "en",
			tabindex: 5
		};
	// ]]>
	</script>

	<p>
		<?php echo recaptcha_get_html( $options['public_key'] ); ?>
	</p>

<?php
}


// get the page view counters and display on the page
function appthemes_get_stats( $post_id ) {
	global $posts, $app_abbr;

	$daily_views = get_post_meta( $post_id, $app_abbr.'_daily_count', true );
	$total_views = get_post_meta( $post_id, $app_abbr.'_total_count', true );

	if ( ! empty( $total_views ) && ( ! empty( $daily_views ) ) )
		echo number_format( $total_views ) . '&nbsp;' . __( 'total views', APP_TD ) . ',&nbsp;' . number_format( $daily_views ) . '&nbsp;' . __( 'today', APP_TD );
	else
		echo __( 'no views yet', APP_TD );
}


/**
 * tinyMCE text editor.
 *
 * @deprecated 1.5.1
 */
function appthemes_tinymce( $width = 540, $height = 400 ) {
	_deprecated_function( __FUNCTION__, '1.5.1', 'wp_editor()' );

	return;
}


// give us either the uploaded profile pic, a gravatar, or a placeholder
function appthemes_get_profile_pic($author_id, $author_email, $avatar_size) {
//    if(function_exists('userphoto_exists')) {
//        if(userphoto_exists($author_id))
//			//if the size of userphoto called is less then 32px, it must be looking for the thumbnail
//			if($avatar_size <= 32)
//            	userphoto_thumbnail($author_id);
//			else
//				userphoto($author_id);
//        else
//            echo get_avatar($author_email, $avatar_size);
//      } else {
         echo get_avatar($author_email, $avatar_size);
//     }
}


// change the author url base permalink
// not using quite yet. need to
function appthemes_author_permalink() {
	global $wp_rewrite, $app_abbr;

	$author_base = trim( get_option( $app_abbr.'_author_url' ) );

	// don't waste resources if the author base hasn't been customized
	// MAKE SURE TO CHECK IF VAR IS EMPTY OTHERWISE THINGS WILL BREAK
	if ( $author_base <> 'author' ) {
		$wp_rewrite->author_base = $author_base;
		$wp_rewrite->flush_rules();
	}
}

// don't load on admin pages
// if(!is_admin())
	// add_action('init', 'appthemes_author_permalink');


/**
 *
 * Helper functions
 *
 */

// mb_string compatibility check.
if (!function_exists('mb_strlen')) :
function mb_strlen($str) {
	return strlen($str);
}
endif;


// mb_strtoupper compatibility check.
if (!function_exists('mb_strtoupper')) :
function mb_strtoupper($str, $encoding = null) {
	return strtoupper($str);
}
endif;


// round to the nearest value used in pagination
function appthemes_round($num, $tonearest) {
   return floor($num/$tonearest)*$tonearest;
}


// for the price field to make only numbers, periods, and commas
function appthemes_clean_price($string) {
    $string = preg_replace('/[^0-9.,]/', '', $string);
    return $string;
}


// error message output function
function appthemes_error_msg($error_msg) {
    $msg_string = '';
    foreach ($error_msg as $value) {
        if(!empty($value))
            $msg_string = $msg_string . '<div class="error">' . $msg_string = $value.'</div><div class="pad5"></div>';
    }
    return $msg_string;
}


// just places the search term into a js variable for use with jquery
// not being used as of 3.0.5 b/c of js conflict with search results
function appthemes_highlight_search_term($query) {
	if(is_search() && strlen($query) > 0){
    echo '
      <script type="text/javascript">
        var search_query  = "'.$query.'";
      </script>
    ';
  }

}


// insert the first login date once the user has been created
function appthemes_first_login($user_id) {
    update_user_meta($user_id, 'last_login', gmdate('Y-m-d H:i:s'));
}


// insert the last login date for each user
function appthemes_last_login($login) {
    global $user_ID;
    $user = get_user_by('login', $login);
    update_user_meta($user->ID, 'last_login', gmdate('Y-m-d H:i:s'));
}
add_action('wp_login','appthemes_last_login');


// get the last login date for a user
function appthemes_get_last_login($user_id) {
    $last_login = get_user_meta($user_id, 'last_login', true);
    $date_format = get_option('date_format') . ' ' . get_option('time_format');
    $the_last_login = mysql2date($date_format, $last_login, false);
    echo $the_last_login;
}


// format the user registration date used in the sidebar-user.php template
function appthemes_get_reg_date($reg_date) {
    $date_format = get_option('date_format') . ' ' . get_option('time_format');
    $the_reg_date = mysql2date($date_format, $reg_date, false);
    echo $the_reg_date;
}


// add or remove upload file types
function appthemes_custom_upload_mimes ($existing_mimes=array()) {

// add your ext =&gt; mime to the array
    //$existing_mimes['extension'] = 'mime/type';

    //unset( $existing_mimes['exe'] );

    return $existing_mimes;
}
// add_filter('upload_mimes', 'appthemes_custom_upload_mimes');


// suggest terms on search results
// based off the Search Suggest plugin by Joost de Valk
function appthemes_search_suggest($full = true) {
    global $yahooappid, $s;

    require_once(ABSPATH . 'wp-includes/class-snoopy.php');
    $yahooappid = '3uiRXEzV34EzyTK7mz8RgdQABoMFswanQj_7q15.wFx_N4fv8_RPdxkD5cn89qc-';
    $query 	= "http://search.yahooapis.com/WebSearchService/V1/spellingSuggestion?appid=$yahooappid&query=".$s."&output=php";
    $wpurl 	= home_url('/');
    $snoopy = new Snoopy;

    $snoopy->fetch($query);
    $resultset = unserialize($snoopy->results);
    if (isset($resultset['ResultSet']['Result'])) {
        if (is_string($resultset['ResultSet']['Result'])) {
            $output = '<a href="'.$wpurl.'?s='.urlencode($resultset['ResultSet']['Result']).'" rel="nofollow">'.$resultset['ResultSet']['Result'].'</a>';
        } else {
            foreach ($resultset['ResultSet']['Result'] as $result) {
                $output .= '<a href="'.$wpurl.'?s='.urlencode($result).'" rel="nofollow">'.$result.'</a>, ';
            }
        }
        if ($full) {
            echo __( 'Perhaps you meant', APP_TD ) . '<strong> ' . $output . '</strong>?';
        } else {
            return __( 'Perhaps you meant', APP_TD ) . '<strong> ' . $output . '</strong>?';
        }
    } else {
        return false;
    }
}


// deletes all the theme database tables
function appthemes_delete_db_tables() {
	global $wpdb, $app_db_tables;

	echo '<div class="update-msg">';
	foreach ( $app_db_tables as $key => $value ) :

		$sql = "DROP TABLE IF EXISTS ". $wpdb->prefix . $value;
		$wpdb->query( $sql );

		printf( '<div class="delete-item">' . __( "Table '%s' has been deleted.", APP_TD ) . '</div>', $value );

	endforeach;
	echo '</div>';
}

// deletes all the theme database options
function appthemes_delete_all_options() {
	global $wpdb, $app_abbr;

	$sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '" . $app_abbr . "_%'";
	$wpdb->query( $sql );

	echo '<div class="update-msg">';
	echo '<div class="delete-item">' . __( 'All theme options have been deleted.', APP_TD ) . '</div>';
	echo '</div>';
}

/**
 * customize the tinyMCE editor buttons
 * @since 1.1
 */
function appthemes_change_mce_buttons( $initArray ) {
	// see http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference
	$initArray['theme_advanced_blockformats'] = 'p,address,pre,code,h1,h2,h3,h4,h5,h6';
	//$initArray['theme_advanced_disable'] = 'forecolor';
	return $initArray;
}
//add_filter( 'tiny_mce_before_init', 'appthemes_change_mce_buttons' );

/**
 * save all site search queries. called in the search.php template
 * @since 1.1
 */
function appthemes_save_search() {
	global $wpdb, $wp_query, $app_abbr;

	// define the table names used
	$tsearch_total = $wpdb->clpr_search_total;
	$tsearch_recent = $wpdb->clpr_search_recent;

	// make sure it's only search, not paged, not admin, and not a spider
	if (is_search() && !is_paged() && !is_admin() && isset($_SERVER['HTTP_REFERER'])) {

		// search string is the raw query
		$search_string = $wp_query->query_vars['s'];

		if (get_magic_quotes_gpc()) $search_string = stripslashes($search_string);

		// search terms is the words in the query
		$search_terms = preg_replace('/[," ]+/', ' ', $search_string);
		$search_terms = trim($search_terms);
		$hit_count = $wp_query->found_posts;
		// Other useful details of the search
		$details = '';

		// save header info with the search
		foreach (array('REQUEST_URI','REQUEST_METHOD','QUERY_STRING','REMOTE_ADDR','HTTP_USER_AGENT','HTTP_REFERER') as $header)
			$details .= $header . ': ' . $_SERVER[$header] . "\n";

		// Sanitize as necessary
		$search_string = esc_sql( $search_string );
		$search_terms = esc_sql( $search_terms );
		$details = esc_sql( $details );

		// Save the individual search to the db
		$query = "INSERT INTO `$tsearch_recent` (`terms`, `datetime`, `hits`, `details`) VALUES ('$search_string', NOW(), $hit_count,'$details')";
		$success = $wpdb->query($query);

		$query = "UPDATE `$tsearch_total` SET `count` = `count` + 1, `last_hits` = $hit_count WHERE `terms` = '$search_terms' AND `date` = CURDATE()";
		$results = $wpdb->query($query);

		// if the search terms don't already exist, let's create it
		if ($results == 0) {
			$query = "INSERT INTO `$tsearch_total` (`terms`, `date`, `count`, `last_hits`) VALUES ('$search_terms', CURDATE(), 1, $hit_count)";
			$results = $wpdb->query($query);
		}

	}

}

