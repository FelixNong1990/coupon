<?php

if (!function_exists('add_action')) {
  die('Please don\'t open this file directly!');
} 


 
 
class PPT_Widgets_FEATURED extends WP_Widget {

    function PPT_Widgets_FEATURED() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-featured',
			'description' => __( 'Here you can display a list of posts customized with your own custom query.' )
		);
		parent::__construct( 'ppt-featured', __( 'NEW ** WEBSITE LISTINGS **' ), $opts );
		
    }

    function form($instance) {
	
	global $PPT;
	
        // outputs the options form on admin
		
		$defaults = array(
			'title'		=> 'Featured Listings',
			'num'		=> '5',	 
			'sq'		=> 'post_type=post',
			'related' 	=> '0'
		);
		
		$instance = wp_parse_args( $instance, $defaults );
	?>
    
 	<p><b>Box Title</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  
     <br /><br /><p><b>How many listings to display?</b></p>
    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" style="width:60px;" value="<?php echo esc_attr( $instance['num'] ); ?>" />
     <p><small>Enter a numberic value, e.g, 1,2,3 etc</small></p>    
     
      
 	<p><b>Custom Query (<a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank">example info</a>)</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'sq' ); ?>" name="<?php echo $this->get_field_name( 'sq' ); ?>" value="<?php echo esc_attr( $instance['sq'] ); ?>" /> <br />
            
	<br /><p><b>From Which Category?</b></p>

 	<select id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>"  style="width: 240px;  font-size:12px;">
	<option value=''>All/Current Category</option>
	 <?php echo premiumpress_categorylist($instance['cat'],false,false,"category",0,true); ?>
    </select>
 
<?php

		$out = "";
		$out .= '<br><br><p><b>Show Related Listing</b> (Where Possible)</label>&nbsp;&nbsp;';
		$out .= '<input id="' . $this->get_field_id('related') . '" name="' . $this->get_field_name('related') . '" type="checkbox" ' . checked(isset($instance['related'])? $instance['related']: 0, true, false) . ' /></p>';
		
		echo $out;


    }

	function update( $new, $old )
	{	
		$clean = $old;
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	
		$clean['sq'] = isset( $new['sq'] ) ?  esc_html( $new['sq'] )  : '';		 
		$clean['num'] = isset( $new['num'] ) ? esc_attr( $new['num'] ) : '';
		$clean['cat'] = isset( $new['cat'] ) ? esc_attr( $new['cat'] ) : '';
		$clean['related'] = isset( $new['related'] ) ? '1' : '0';
		return $clean;
	}

    function widget($args, $instance) {
 	
	global $PPT, $PPTDesign, $wp_query, $wpdb; $STRING = ""; @extract($args); $ex = ""; 
 	
	if(!isset($instance['num'])){ $instance['num'] =1; }
	if(!isset($instance['cat'])){ $instance['cat'] =1; }
	$num = $instance['num'];
	$cat = $instance['cat'];
	if(!isset($instance['related'])) { $instance['related'] =0; }
	if(!isset($instance['sq'])){ $instance['sq']=""; }
 	$related = $instance['related'];
 	
	// RELATED ITEMS ONLY OR CATEGORY
	if($cat != ""){		$ex = "&cat=".$cat; 	}else{		$ex =""; 	}
	if($related && is_numeric($GLOBALS['premiumpress']['catID'])){		$ex = "&cat=".$GLOBALS['premiumpress']['catID'];	}
	 
	 // GET THE CAT ID FOR THE LISTING TO MAKE RELATED LISTINGS
	if($related && isset($GLOBALS['IS_SINGLEPAGE'])){ 
	
		$post_categories = wp_get_post_categories( $GLOBALS['IS_POSTID'] );
		$single_cats = "";
		foreach($post_categories as $c){
			$single_cats .= $c.",";
		}
		$ex = "&cat=".substr($single_cats,0,-1);
	}	 
 	
	// BUILD QUERY
	//$temp 		= $wp_query;
	//$wp_query	= null; 
	$qstring = 'posts_per_page='.$num.'&'.str_replace("&amp;","&",$instance['sq']).$ex; 
	$qstring = str_replace("&&","&",$qstring);	
    $the_query = new WP_Query($qstring);			 
 
 	// CHECK WE HAVE RESULTS
	if(count($the_query->posts) > 0 ){ //meta_value_num

		$STRING .= $before_widget.str_replace("widget-box-id","ppt-widget-featured",$before_title).$instance['title'].$after_title.'<div id="ppt-widget-featured-box">';
		$injectimg = ""; 
	
		foreach($the_query->posts as $pp){ 
			
			if( ( isset($GLOBALS['IS_POSTID']) && $GLOBALS['IS_POSTID'] == $pp->ID )|| $pp->post_title == ""){ continue; }
		  	
				$innerSTRING = '<div class="item clearfix">'; 
				
				$innerSTRING .= '<div class="imgb">';				 
				
				$injectimg = premiumpress_image($pp->ID,"",array('alt' => $pp->post_title, 'link' =>true, 'link_class'=>'frame right', 'width' => '50', 'height' => '50', 'style' => 'max-width:80px;' ));

				$innerSTRING .= '</div><div class="contentb">'.$injectimg;
				
				$innerSTRING .= '<h4><a href="'.get_permalink($pp->ID).'" title="'.$pp->post_title.'">'.$pp->post_title.'</a></h4>';					 
						
				$innerSTRING .= '<p>'.mb_substr(strip_tags($pp->post_excerpt),0,100).'..</p>';
						 
				$innerSTRING .= '</div>';				
				
				$innerSTRING .= '</div><!-- end featured item -->';
				
				$newSTRING = premiumpress_widget_featuredlisting_content($pp);
				 
				if(!is_object($newSTRING) && trim($newSTRING) != "" && !is_numeric($newSTRING) ){
				$innerSTRING = $newSTRING;
				}
				
				$STRING .= $innerSTRING;
			 
		} // end foreach
		
		$STRING .= '</div><div class="clearfix"></div>'.$after_widget;
		
	} // END LOOP
		
	wp_reset_postdata();
   // $wp_query = null; //Reset the normal query
   // $wp_query = $temp;//Restore the query 
	
	echo $STRING; 
 
    }

}
























class PPT_Widgets_TAXOMONY extends WP_Widget {

    function PPT_Widgets_TAXOMONY() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-taxomony',
			'description' => __( 'Here you can display a list of your custom taxonomies for users to search.' )
		);
		parent::__construct( 'ppt-taxomony', __( 'NEW ** TAXONOMY SEARCH **' ), $opts );
		
    }

    function form($instance) {
   
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /> 
  
   
  <table width="100%" border="0" style="margin-top:10px;">
   <tr>
    <td><b>Display</b></td>
    <td><b>Title</b></td>   
  </tr>
  <tr>
    <td><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php echo checked(isset($instance['filter'])? $instance['filter']: 0, true, false); ?> /> Categories (parent only)</td>
    <td><input class="widefat" type="text" id="<?php echo $this->get_field_id( 'cattitle' ); ?>" name="<?php echo $this->get_field_name( 'cattitle' ); ?>" value="<?php echo esc_attr( $instance['cattitle'] ); ?>" /> 
  </td>
  </tr>
  
  <tr>
    <td><input id="<?php echo $this->get_field_id('adsearch'); ?>" name="<?php echo $this->get_field_name('adsearch'); ?>" type="checkbox" <?php echo checked(isset($instance['adsearch'])? $instance['adsearch']: 0, true, false); ?> /> Advanced Search</td>
    <td><input class="widefat" type="text" id="<?php echo $this->get_field_id( 'adseatitle' ); ?>" name="<?php echo $this->get_field_name( 'adseatitle' ); ?>" value="<?php echo esc_attr( $instance['adseatitle'] ); ?>" /> 
  </td>
  </tr>
  
  
  
  <tr>
    <td><input id="<?php echo $this->get_field_id('search'); ?>" name="<?php echo $this->get_field_name('search'); ?>" type="checkbox" <?php echo checked(isset($instance['search'])? $instance['search']: 0, true, false); ?> /> Keyword Search</td>
    <td><input class="widefat" type="text" id="<?php echo $this->get_field_id( 'seatitle' ); ?>" name="<?php echo $this->get_field_name( 'seatitle' ); ?>" value="<?php echo esc_attr( $instance['seatitle'] ); ?>" /> 
  </td>
  </tr>
  
  <tr>
    <td><input id="<?php echo $this->get_field_id('country'); ?>" name="<?php echo $this->get_field_name('country'); ?>" type="checkbox" <?php echo checked(isset($instance['country'])? $instance['country']: 0, true, false); ?> /> Country (parent only)</td>
    <td><input class="widefat" type="text" id="<?php echo $this->get_field_id( 'countrytitle' ); ?>" name="<?php echo $this->get_field_name( 'countrytitle' ); ?>" value="<?php echo esc_attr( $instance['countrytitle'] ); ?>" /> 
  </td>
  </tr>
  
  
</table>

        
   
    <?php
	if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "comparisonpress" ){
	echo '<input id="' . $this->get_field_id('stores') . '" name="' . $this->get_field_name('stores') . '" type="checkbox" ' . checked(isset($instance['stores'])? $instance['filter']: 0, true, false) . ' /> Display Stores</p>';
	}
	
	
	
	echo '</p>';
		 
	?>
	 <p><b>Display Taxomony Values:</b></p>
 	<?php if(!is_array($instance['taxID'])){ $instance['taxID'] = array(); } ?>
	<?php $taxArray = get_option("ppt_custom_tax"); if(is_array( $taxArray)){  ?>
    <select id="<?php echo $this->get_field_id( 'taxID' ); ?>" name="<?php echo $this->get_field_name( 'taxID' ); ?>[]" multiple="multiple" style="width:100%; height:150px;">
    <option></option>
    <?php foreach($taxArray as $tax){ if($tax['name'] != ""){ echo "<option value='".$tax['name']."'"; if(in_array($tax['name'],$instance['taxID'])){ echo " selected=selected "; }  echo ">".$tax['title']."</option>";   } } ?>
    </select> 
    <?php } ?><br />
    
	<?php 
	}

	function update( $new, $old )
	{	
		$clean = $old;		
		  
		 $clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	
		 $clean['cattitle'] = isset( $new['cattitle'] ) ? strip_tags( esc_html( $new['cattitle'] ) ) : '';
		 $clean['seatitle'] = isset( $new['seatitle'] ) ? strip_tags( esc_html( $new['seatitle'] ) ) : '';
		 
		 
		$clean['taxID'] = $new['taxID'];
		$clean['search'] = isset($new['search']);
		$clean['filter'] = isset($new['filter']);
		$clean['stores'] = isset($new['stores']);
		
		// ADVANCED SEARCH
		$clean['adseatitle'] = isset( $new['adseatitle'] ) ? strip_tags( esc_html( $new['adseatitle'] ) ) : '';
		$clean['adsearch'] = isset($new['adsearch']);
		
		// COUNTRY SEARCH
		$clean['countrytitle'] = isset( $new['countrytitle'] ) ? strip_tags( esc_html( $new['countrytitle'] ) ) : '';
		$clean['country'] = isset($new['country']);		
		
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$PPTDesign; $STRING = ""; @extract($args); $taxArray = get_option("ppt_custom_tax"); 
	
	echo $before_widget.str_replace("widget-box-id","ppt-widget-taxonomy",$before_title).$instance['title'].$after_title.'<div id="ppt-widget-taxonomy-box" >';  
	 
	 
	 // ADVANCED SEARCH	
	if(isset($instance['adsearch']) && $instance['adsearch'] == 1){
	
		echo "<div class='boxme'> <h3>".$instance['adseatitle']."</h3>";
		
		echo '<form id="AdvancedSearchTaxForm" name="AdvancedSearchTaxForm" action="'.$GLOBALS['bloginfo_url'].'/" method="get">'; 
	
		echo PPT_AdvancedSearch('preset-default');
		
		echo '<a  href="javascript:document.AdvancedSearchTaxForm.submit();" class="button gray" style="margin-top:10px;" > 
          '.$PPT->_e(array('button','11')).' </a>';
		
		echo "</form> <div class='clearfix'></div></div>";
	
	}	 
	 
	 
	// CATEGORY SEARCH 	
	if(isset($instance['filter']) && $instance['filter'] == 1){
	 
	 		echo "<div class='boxme'> <h3>".$instance['cattitle']."</h3>";
	 
		    $terms = get_terms("category","orderby=count&order=desc");
			 $count = count($terms);
			 if ( $count > 0 ){
				 echo "<ul id='ppt_taxonomy_widget_catlist'>";
				 foreach ( $terms as $term ) {
				 
				   if($term->parent != "0"){ continue; } // HIDE CHILD
			 
				   echo "<li><a href='".get_term_link($term->slug, "category"). "'>" . $term->name . " <span>(".$term->count.")</span></a></li>";					
				 }
				 echo "</ul>";
			 }
			 
			echo "</div>";
	 
	 }		 
	 
 	if(!is_array($instance['taxID'])){ $instance['taxID'] = array(); } 
 	if(is_array($taxArray)){ 
	
			// ADDED IN 7.1.1 SO YOU CAN CUSTOMIZE DISPLAY OF TAXONOMIES
			$CATS = get_option("taxonomy_customcats");
			$IDARRAY = get_option("taxonomy_customids");
			$STRING = "";
			$OUTPUT = "";
			//print_r($CATS);
			foreach($taxArray as $tax){
			 
				if(in_array($tax['name'],$instance['taxID'])){		 
				 
					$STRING .= "<div class='boxme'> <h3>".$tax['title']."</h3>";
					
					$NewTax = strtolower(htmlspecialchars(str_replace(" ","-",str_replace("&","",str_replace("'","",str_replace('"',"",str_replace('/',"",str_replace('\\',"",strip_tags($tax['name'])))))))));
				   
					$terms = get_terms($NewTax);
					$count = count($terms);
					if ( $count > 0 ){
								
						$STRING .= "<ul id='ppt_taxonomy_widget_".$NewTax."list' class='taxsubclass'>";
								$countinside = 0;
								foreach ( $terms as $term ) {
								 
									// if(isset($GLOBALS['flag-home'])){ $canContinue = false; }else{ $canContinue = true; }
									 $canContinue = true;
									 if(isset($CATS[$term->term_id]) && !empty($CATS[$term->term_id]) && is_array($CATS[$term->term_id]['cats']) ){
										//echo $GLOBALS['premiumpress']['catID']."<--".$term->term_id; //  && $GLOBALS['premiumpress']['catParent']  && $GLOBALS['premiumpress']['catParent']
										//print_r($CATS[$term->term_id]['cats']);
										// CHECK IF WE CAN SHOW THIS ITEM WITHIN THE CURRENT CATEGORY				
										
										 // CHECK IF IN ARRAY
										 if(in_array($GLOBALS['premiumpress']['catID'], $CATS[$term->term_id]['cats'])){  }else{ $canContinue=false;  }										 
										 // CHECK IF IS HOME PAGE
										  if(isset($GLOBALS['flag-home']) &&  in_array(1, $CATS[$term->term_id]['cats'])){ $canContinue = true; }	
										  // CHECK IF IS ITSELF
										  if($GLOBALS['premiumpress']['catID'] == $term->term_id){ $canContinue = true; }
										  
										  			   	 
									 }// end if
								 
									 if($canContinue){
									   $STRING .= "<li><a href='".get_term_link($term->slug, $NewTax). "'>" . $term->name . "</a></li>";
									   $countinside++;	
									 }// end if
												
								} // end foreach
						 $STRING .= "</ul>";
						 
					} // end if count			 
					 
					$STRING .= "</div>";	
					 
					if($countinside > 0){
					 $OUTPUT = $STRING;
					}	 
					  
				 } // if in array
				 
			 }// end foreach
			 
			 echo $OUTPUT;
	 	 
	}// is array
	
	
		 	

	 if(isset($instance['country']) && $instance['country'] == 1){
	 
	 		echo "<div class='boxme'> <h3>".$instance['countrytitle']."</h3>";
	 
		    $terms = get_terms("location",array("parent" => 0 ));
			 $count = count($terms);
			 if ( $count > 0 ){
				 echo "<ul id='ppt_taxonomy_widget_storelist'>";
				 foreach ( $terms as $term ) {
			 		 
				   echo "<li><a href='".get_term_link($term->slug, "location"). "'>" . $term->name . " <span>(".$term->count.")</span></a></li>";					
				 }
				 echo "</ul>";
			 }
			 
			 echo "</div>";
	 
	 }	
	
	 if(isset($instance['stores']) && $instance['stores'] == 1){
	 
	 		echo "<div class='boxme'> <h3>".$PPT->_e(array('title','9'))."</h3>";
	 
		    $terms = get_terms("store");
			 $count = count($terms);
			 if ( $count > 0 ){
				 echo "<ul id='ppt_taxonomy_widget_storelist'>";
				 foreach ( $terms as $term ) {
			 
				   echo "<li><a href='".get_term_link($term->slug, "store"). "'>" . $term->name . "</a></li>";					
				 }
				 echo "</ul>";
			 }
			 
			 echo "</div>";
	 
	 } 

	 
	if(isset($instance['search']) && $instance['search'] == 1){
	 
	 	echo "<div class='boxme'> <h3>".$PPT->_e(array('head','8'))."</h3>";
	 
		echo '<form method="get" action="'.$GLOBALS['bloginfo_url'].'/" name="searchBox1" id="searchBox">
            <div class="searchBtn" onclick="document.searchBox1.submit();" style="float:left; "> &nbsp;</div>
            <input type="text" value="'.$PPT->_e(array('head','2')).'" name="s" id="s" onfocus="this.value=\'\';"  />            
            </form><div class="clearfix"></div>';
			
		echo "</div>";
	 
	 }
	 
	 	if(!isset($GLOBALS['IS_LOGIN'])){ echo  '<script type="text/javascript">	jQuery(document).ready(function() { jQuery("#ppt-widget-taxonomy-box SELECT").selectBox(); });</script>'; }	

	
	echo '<div class="clearfix"></div><br /></div>'.$after_widget; 
	  
 
    }

}


























class PPT_Widgets_EXPSOON extends WP_Widget {

    function PPT_Widgets_EXPSOON() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-expsoon',
			'description' => __( 'Here you can display a list of items ending soon.' )
		);
		parent::__construct( 'ppt-expsoon', __( 'NEW ** ENDING SOON **' ), $opts );
		
    }

    function form($instance) {
   
		$instance = wp_parse_args( $instance, $defaults );
		
	?>
    
    <p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /> 
  
    <?php 
		
	}
	
	function update( $new, $old )
	{	
		$clean = $old;		
		  
		 $clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	
		 
		
		return $clean;
	}

    function widget($args, $instance) {
	
	if(isset($GLOBALS['query_total_num']) && $GLOBALS['query_total_num'] == 0){ return; }
    
	// outputs the content of the widget
		
	global $PPT,$PPTDesign; $STRING = ""; @extract($args);
	
	if(isset($_GET['search-class'])){ return; }
 
 	$STRING .= $before_widget.str_replace("widget-box-id","ppt-widget-expsoon",$before_title).$instance['title'].$after_title.'<div id="ppt-widget-expsoon-box" >';
 	
	wp_reset_query();
				
    $STRING .= $this->Posts();  
        
	$STRING .= '</div>'.$after_widget;
			
	echo $STRING; 
  
    }
	
	
	function Posts(){
	
		global $wpdb, $wp_query, $PPTDesign; $STRING="";
	  
		 
		$SQL = "SELECT * FROM ".$wpdb->prefix."postmeta LEFT JOIN ".$wpdb->prefix."posts ON ( ".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id ) 
		WHERE ".$wpdb->prefix."postmeta.meta_key = 'expires' AND ".$wpdb->prefix."postmeta.meta_value !=''
		AND  ".$wpdb->prefix."posts.post_status = 'publish' AND  ".$wpdb->prefix."posts.post_type = 'post'
		ORDER BY ".$wpdb->prefix."postmeta.meta_value ASC LIMIT 10";  // ON ($wpdb->users.ID =  
		$posts = $wpdb->get_results($SQL);
		
		if(!empty($posts)){
		
		$STRING = "<ul>";
			 
			foreach($posts as $post){
			
			if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress"  ){ 
			if(get_post_meta($post->ID, 'bid_status', true) != "open"){ continue; }
			}
			 
				$date_expires = strtotime(date("Y-m-d H:i:s", strtotime($post->post_date)) . " +".get_post_meta($post->ID, 'expires', true)." days");
 		 
				 
			 	$STRING  .="<li><a href='".get_permalink( $post->ID )."'>".$post->post_title."<span>".$PPTDesign->TimeDiff(date('Y-m-d H:i:s',$date_expires),4)."</span></a><div class='clearfix'></div></li>";			
			
			} 
		wp_reset_query();
		$STRING .= "</ul>";
		
		}
		
		return $STRING;
	
	}
	 
}









 




class PPT_Widgets_ADVSEARCH extends WP_Widget {

    function PPT_Widgets_ADVSEARCH() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-price-search',
			'description' => __( 'Advanced search box for your search settings.' )
		);
		parent::__construct( 'ppt-price-search', __( 'NEW ** ADVANCED SEARCH ** ' ), $opts );
		
    }

    function form($instance) {
	
	global $PPT;
	
        // outputs the options form on admin		
		$defaults = array(
			'title'		=> 'Advanced Search',
			'te'		=> '',
			 	 
		);		
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
     
     <div class="msg msg-info"> 
	 <p style="background:none;">The search settings are configured under the <a href="admin.php?page=setup" style="font-weight:bold;">General Setup -> Search tab</a>.</p>
  </div>
     
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /> 
  
    
     <p><br /><b>Customized Content (Displayed above the search fields):</b></p>
 
  
  <p><textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'te' ); ?>" name="<?php echo $this->get_field_name( 'te' ); ?>"><?php echo esc_attr( $instance['te'] ); ?></textarea></p>
  
     <?php
		 
		$out = "";
		$out .= '<p><label for="' . $this->get_field_id('filter') . '">Automatically add paragraphs to text</label>&nbsp;&nbsp;';
		$out .= '<input id="' . $this->get_field_id('filter') . '" name="' . $this->get_field_name('filter') . '" type="checkbox" ' . checked(isset($instance['filter'])? $instance['filter']: 0, true, false) . ' /></p>';
		
		echo $out;
	 
	 	 
	 
	 }

	function update( $new, $old )
	{	
		$clean = $old; 
		 
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	 
		if (current_user_can('unfiltered_html')) {
		  $clean['te'] = $new['te'];
		} else {
		  $clean['te'] = stripslashes(wp_filter_post_kses(addslashes($new['te'])));
		}
		
		$clean['filter'] = isset($new['filter']);
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$ThemeDesign; $STRING = ""; @extract($args);
	

 
	echo $before_widget.str_replace("widget-box-id","ppt-widget-advancedsearch",$before_title).$instance['title'].$after_title.'<div id="ppt-widget-advancedsearch-box" >';
			
	echo '<form id="PriceSearchForm1" name="PriceSearchForm1" action="'.$GLOBALS['bloginfo_url'].'/" method="get">'; 
	
		if (isset($instance['filter']) && $instance['filter']) {
		  $instance['te'] = wpautop($instance['te']);
		}
		if(isset($instance['te'])){
		echo $instance['te'];  }
		echo PPT_AdvancedSearch('preset-default');  
		
		
		echo '<a class="button gray" href="javascript:document.PriceSearchForm1.submit();" style="margin-top:10px;" > 
          '.$PPT->_e(array('button','11')).' </a>';
	
	echo '<div class="clearfix"></div>';
	
	echo '</form>';
	
	if(!isset($GLOBALS['IS_LOGIN'])){ echo  '<script type="text/javascript">	jQuery(document).ready(function() { jQuery("#ppt-widget-advancedsearch-box SELECT") .selectBox();});</script>'; }	
	 
	echo '<div class="clearfix"></div></div>'.$after_widget; 

}

}



class PPT_Widgets_STORES extends WP_Widget {

    function PPT_Widgets_STORES() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-stores',
			'description' => __( 'Stores widget for CouponPress' )
		);
		parent::__construct( 'ppt-stores', __( 'NEW ** STORES ** ' ), $opts );
		
    }

    function form($instance) {
	
	global $PPT;
	
        // outputs the options form on admin		
		$defaults = array(
			'title'		=> 'Featured Stores',		 
		);		
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
     
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /> 
 
     <p><br /><b>Select Stores to Display</b> (Hold Shift+Ctrl to select multiple)</p>  
      <select id="<?php echo $this->get_field_id( 'storeID' ); ?>" name="<?php echo $this->get_field_name( 'storeID' ); ?>[]" multiple="multiple" style="width:100%; height:150px;">
      <?php echo premiumpress_categorylist($instance['storeID'],false,false,"store"); ?>
    </select> 
    
	<p><br /><b>Order By</b></p>

 	<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>"  style="width: 240px;  font-size:14px;">
 
<option <?php if($instance['order'] == "id"){ echo "selected=selected"; } ?>>id</option>
<option <?php if($instance['order'] == "name"){ echo "selected=selected"; } ?>>name</option>
<option <?php if($instance['order'] == "slug"){ echo "selected=selected"; } ?>>slug</option>
<option <?php if($instance['order'] == "count"){ echo "selected=selected"; } ?>>count</option>
<option <?php if($instance['order'] == "term_group"){ echo "selected=selected"; } ?>>term_group</option>
<option <?php if($instance['order'] == "order"){ echo "selected=selected"; } ?>>order </option>
 
</select>
     
     <?php  }

	function update( $new, $old )
	{	
		$clean = $old; 
		$clean['order'] = isset( $new['order'] ) ? strip_tags( esc_html( $new['order'] ) ) : 'name';
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	 
		$clean['storeID'] = $new['storeID'];
		
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$PPTDesign; $STRING = ""; @extract($args);
	
	if(!isset($instance['order'])){ $instance['order']=0; }
 
	echo $before_widget.str_replace("widget-box-id","ppt-widget-stores",$before_title).$instance['title'].$after_title.'<div id="ppt-widget-stores-box" ><ul>';
	echo $this->FeaturedStores($instance['storeID'],$instance['order']);	
	
	echo '</ul><div class="clearfix"></div></div>'.$after_widget; 

	}


/* =============================================================================
   SIDEBAR WIDGET FOR FEATURED STORES
   ========================================================================== */
   		
function FeaturedStores($storesID="",$order=""){

	global $wpdb,$PPT; $STRING = ""; $CATARRAY = get_option("cat_icons");
 
	$args = array(
		'taxonomy'                 => 'store',
		'orderby'             	   => $order,
		'child_of'                 => 0,
		'hide_empty'               => false,
		'hierarchical'             => 0,
		'include'                  => $storesID);
	
	$categories = get_categories($args); 
	foreach($categories as $category) {	
	
		 
		
		if(isset($CATARRAY[$category->term_id]['image'])){ 
		
				$Cimg = str_replace(".png","",$CATARRAY[$category->term_id]['image']);
				if(is_numeric($Cimg)){ $imgPath = get_template_directory_uri().'/images/icons/'.$CATARRAY[$category->term_id]['image'];  }else{  $imgPath = $CATARRAY[$category->term_id]['image']; }
		
				$IMAGE = "<img src='".$imgPath."' alt='".$category->cat_name."' />";
						
			}else{ 
			
			$IMAGE =""; 
			
			}		
			
		$STRING .= '<li>'; 		
				
		$STRING .= "<a href='".get_term_link( $category, "store" )."' title='".$category->cat_name."' style='text-decoration:none;' ";
		//if(isset($GLOBALS['premiumpress']['analytics_tracking']) && $GLOBALS['premiumpress']['analytics_tracking'] =="yes"){
		//$STRING .= "onclick=\"pageTracker._trackEvent('STORE CLICK', 'IMAGE CLICK', '".$catBits->cat_name."');\"";
		//}
		$STRING .= ">";	
		$STRING .= $IMAGE;
						 
		$STRING .= "<span>".$category->cat_name;
		$STRING .= " (".$category->count.')</span>'; 	
						 
		$STRING .= '</a>';
		$STRING .= '</li>';
		
	}
	wp_reset_query();		
	return $STRING;		
	
	
 
		$SAVED_DISPLAY = get_option("featured_stores");

			if(is_array($SAVED_DISPLAY)){
				$SHOWRESULTS = multisort( $SAVED_DISPLAY , array('ORDER') );
			}else{
				$SHOWRESULTS = array();
			} 		

			foreach($SHOWRESULTS as $ThisCat){  if( isset($ThisCat['ID']) && $ThisCat['ID'] > 0 ){ 
 
				$catBits = get_category($ThisCat['ID'],false);

				if(!empty($catBits)){
				$storeimage = premiumpress_category_extra($ThisCat['ID'],"image",1);
			
				$STRING .= "<li>";
				$STRING .= "<a href='".get_category_link( $ThisCat['ID'] )."' title='".$catBits->cat_name."' style='text-decoration:none;' ";

				if(isset($GLOBALS['premiumpress']['analytics_tracking']) && $GLOBALS['premiumpress']['analytics_tracking'] =="yes"){
				//$STRING .= "onclick=\"pageTracker._trackEvent('STORE CLICK', 'IMAGE CLICK', '".$catBits->cat_name."');\"";
				}
				$STRING .= ">";

				//$STRING .= "<div style='width:150px;'>";
				if($storeimage != ""){ 
					$STRING .= "<img src='".$storeimage."' style='bordr:0px; text-decoration:none;' alt='".$catBits->cat_name."' />";
				}
				//$STRING .= "</div>";				
				
				$STRING .= "</a><div style='clear:both;'></div>
				<a href='".get_category_link( $catBits->term_id )."' title='".$catBits->cat_name."' style='font-size:12px;'";
				if(isset($GLOBALS['premiumpress']['analytics_tracking']) && $GLOBALS['premiumpress']['analytics_tracking'] =="yes"){
				//$STRING .= "onclick=\"pageTracker._trackEvent('STORE CLICK', 'TEXT CLICK', '".$catBits->cat_name."');\"";
				}
				$STRING .= ">";
				$STRING .= $catBits->cat_name." (".$catBits->category_count.")";
				$STRING .= "</a>";
				$STRING .= "</li>";
				}
			
			} }
 
	return $STRING; 
	 
}

}





 



class PPT_Widgets_CouponPress_POPULARCOUPONS extends WP_Widget {

    function PPT_Widgets_CouponPress_POPULARCOUPONS() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-couponpress-popcoupons',
			'description' => __( 'List of popular coupons for CouponPress.' )
		);
		parent::__construct( 'ppt-couponpress-popcoupons', __( 'NEW ** POPULAR COUPONS ** ' ), $opts );
		
    }

    function form($instance) {
        // outputs the options form on admin		
		$defaults = array(
			'title'		=> 'Popular Coupons',
			'num'		=> '10',	 
		);		
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
     
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	<p><br /><b>Display Amount</b> (numeric value)</p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo esc_attr( $instance['num'] ); ?>" style="width:50px;" /> 
    
     <?php  }

	function update( $new, $old )
	{	
		$clean = $old; 
		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
		$clean['num'] = isset( $new['num'] ) ? strip_tags( esc_html( $new['num'] ) ) : '';
		
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	if(isset($GLOBALS['query_total_num']) && $GLOBALS['query_total_num'] ==  0){ return; } // bolt not sure why wp spits out rubbish here
		
	global $PPT,$ThemeDesign; $STRING = ""; @extract($args); 
	  
	echo $before_widget.str_replace("widget-box-id","ppt-widget-popularcoupons",$before_title).$instance['title'].$after_title.'<ul class="CouponPopList">';
	echo $ThemeDesign->PopularCoupons($instance['num']);
	echo '</ul>'.$after_widget; 

}

}

















 












class PPT_Widgets_BUTTON extends WP_Widget {

    function PPT_Widgets_BUTTON() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-button',
			'description' => __( 'Create your own buttons.' )
		);
		parent::__construct( 'ppt-button', __( 'NEW ** BUTTON **' ), $opts );
		
    }

    function form($instance) {
        // outputs the options form on admin
		
		$barray = array ('green','blue','purple', 'pink', 'orange', 'yellow', 'gray', 'black' ); 
		
		$iarray = array ('none','forward','backward','address', 'adobe', 'aim', 'chart', 'clipboard', 'clock', 'cog', 'comment', 'cross', 'cut', 'date', 'docs',  'down_arrow', 'eject','email','emailnew','facebook','film','heart','home','id','left_arrow','locked','minus','music','pen','photo','play','plus','power','rewind','right_arrow','star','star1','stop','tag','tag2','tick','tv','twitter','unlock','up_arrow','user','users','word','zip','zoom'); 

		
		$defaults = array(
			'title'		=> 'My Button Text',
			'css'		=> 'min-width:195px; margin-bottom:15px;',
			'link'		=> 'http://www.premiumpress.com',
			'icon' => 'accept',	 
			'iconpos' => 'right',
			'color' => '',
		);
		
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
     <p><b>Button Text:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />

  <p><br /><b>Button Link:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo esc_attr( $instance['link'] ); ?>" />
 
	<p><br /><b>Button Color</b></p> 

 	<select id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>"  style="width: 240px;  font-size:14px;">
 
    <?php foreach($barray as $val){ ?><option <?php if($instance['color'] ==$val){ echo "selected=selected"; } ?>><?php echo $val; ?></option><?php } ?>
    </select>  
    
<p><br /><b>Button Icon</b></p> 

 	<select id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>"  style="width: 240px;  font-size:14px;">	 
    <?php foreach($iarray as $val){ ?><option <?php if($instance['icon'] ==$val){ echo "selected=selected"; } ?>><?php echo $val; ?></option><?php } ?>
    </select> 
    
 <p><br /><b>Button Size</b></p> 

 	<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>"  style="width: 240px;  font-size:14px;">
	<option value='' <?php if($instance['size'] == ""){ echo "selected=selected"; } ?>>Normal</option> 
 <option value='large' <?php if($instance['size'] == "large"){ echo "selected=selected"; } ?>>Large</option> 
    </select> 
    
 <p><br /><b>Button Shape</b></p> 

 	<select id="<?php echo $this->get_field_id( 'shape' ); ?>" name="<?php echo $this->get_field_name( 'shape' ); ?>"  style="width: 240px;  font-shape:14px;">
	<option value='' <?php if($instance['shape'] == ""){ echo "selected=selected"; } ?>>Normal</option> 
 	<option value='rounded' <?php if($instance['shape'] == "rounded"){ echo "selected=selected"; } ?>>Rounded</option> 
    </select>     
        
     
   
	<p><br /><b>Custom CSS:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'css' ); ?>" name="<?php echo $this->get_field_name( 'css' ); ?>" value="<?php echo esc_attr( $instance['css'] ); ?>"/>
       
     <?php 

    }

	function update( $new, $old )
	{	
		$clean = $old;	
			
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
		$clean['link'] = isset( $new['link'] ) ? strip_tags( esc_html( $new['link'] ) ) : ''; 
	  	$clean['css'] = isset( $new['css'] ) ? strip_tags( esc_html( $new['css'] ) ) : '';
	  	$clean['color'] = isset( $new['color'] ) ? strip_tags( esc_html( $new['color'] ) ) : '';
		$clean['icon'] = isset( $new['icon'] ) ? strip_tags( esc_html( $new['icon'] ) ) : ''; 
		$clean['size'] = isset( $new['size'] ) ? strip_tags( esc_html( $new['size'] ) ) : '';
		$clean['shape'] = isset( $new['shape'] ) ? strip_tags( esc_html( $new['shape'] ) ) : '';
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$PPTDesign; $STRING = ""; @extract($args);
	  
	 echo '<a href="'.$instance['link'].'" class="button '.$instance['color'].' '.$instance['size'].' '.$instance['shape'].'" style="'.$instance['css'].'">';
	  
	 echo $instance['title'];
	 
	 if($instance['icon'] != "" && $instance['icon'] != "none"){
	 
	 echo "<img src='".get_template_directory_uri()."/PPT/img/button/".$instance['icon'].".png' alt='' /> ";
	 }
	 
	 echo '</a>';		 
 
    }

}










class PPT_Widgets_BLANK extends WP_Widget {

    function PPT_Widgets_BLANK() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-blank',
			'description' => __( 'A blank text box without border styles allowing you to enter Text/HTML code. (great for advertising!)' )
		);
		parent::__construct( 'ppt-blank', __( 'NEW ** BLANK WIDGET **' ), $opts );
		
    }

    function form($instance) {
   
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
     <p><b>Content:</b></p>
 
  
  <p><textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'te' ); ?>" name="<?php echo $this->get_field_name( 'te' ); ?>"><?php echo esc_attr( $instance['te'] ); ?></textarea></p>
  
     <?php
		 
	$out = "";
		$out .= '<p><label for="' . $this->get_field_id('filter') . '">Automatically add paragraphs to text</label>&nbsp;&nbsp;';
		$out .= '<input id="' . $this->get_field_id('filter') . '" name="' . $this->get_field_name('filter') . '" type="checkbox" ' . checked(isset($instance['filter'])? $instance['filter']: 0, true, false) . ' /></p>';
		
		echo $out;


    }

	function update( $new, $old )
	{	
		$clean = $old;		
		  
		 
		if (current_user_can('unfiltered_html')) {
		  $clean['te'] = $new['te'];
		} else {
		  $clean['te'] = stripslashes(wp_filter_post_kses(addslashes($new['te'])));
		}
		
		$clean['filter'] = isset($new['filter']);
		
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$PPTDesign; $STRING = ""; @extract($args);
	  
	if ($instance['filter']) {
      $instance['te'] = wpautop($instance['te']);
    }
		echo do_shortcode($instance['te']); 
 
    }

}

















class PPT_Widgets_MAP extends WP_Widget {

    function PPT_Widgets_MAP() {
        // widget actual processes 
		$opts = array(
			'classname' => 'ppt-map',
			'description' => __( 'Google Maps widget for display a map on your sidebar.' )
		);
		parent::__construct( 'ppt-map', __( 'NEW ** GOOGLE MAP **' ), $opts );
		
    }
	


    function form($instance) {
        // outputs the options form on admin
		
		$defaults = array(
			'title'		=> 'Google Map',
			'address'	=> 'London',
			'text'		=> 'example text here',	
			'w' 		=> '100%', 
			'h' 		=> '220px',
			'zoom' 		=> '15',
		);
		
		$instance = wp_parse_args( $instance, $defaults );
	?>
    
 
     <input name="submitted" type="hidden" value="yes">
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  
    <p><br /><b>Display Address</b></p>
    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>"  value="<?php echo esc_attr( $instance['address'] ); ?>" />
     <p><small>Enter a street address to plot onto the map.</small></p>

	<p><b>Zoom Level</b> <small>Between 1 - 25</small></p>
    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'zoom' ); ?>" name="<?php echo $this->get_field_name( 'zoom' ); ?>"  value="<?php echo esc_attr( $instance['zoom'] ); ?>" />

     
    <p><b>Pointer Label</b></p>
    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"  value="<?php echo esc_attr( $instance['text'] ); ?>" />

   
	<p><br /><b>Display Dimensions:</b></p>
	Width: <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'w' ); ?>" name="<?php echo $this->get_field_name( 'w' ); ?>" value="<?php echo esc_attr( $instance['w'] ); ?>" style="width:80px;"/>
    Height: <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'h' ); ?>" name="<?php echo $this->get_field_name( 'h' ); ?>" value="<?php echo esc_attr( $instance['h'] ); ?>" style="width:80px;"/>    
 
<?php
    }

	function update( $new, $old )
	{	
		$clean = $old;
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';		 
		$clean['address'] = isset( $new['address'] ) ? esc_attr( $new['address'] ) : '';
		$clean['text'] = isset( $new['text'] ) ? esc_attr( $new['text'] ) : '';
		
		$clean['w'] = isset( $new['w'] ) ? esc_attr( $new['w'] ) : '';
		$clean['h'] = isset( $new['h'] ) ? esc_attr( $new['h'] ) : '';
		$clean['zoom'] = isset( $new['zoom'] ) ? esc_attr( $new['zoom'] ) : '';
		
		return $clean;
	}
	
	function countwidget($findme=""){
	global $wp_registered_sidebars;
	$foundCounter=0;

	if ( !empty($wp_registered_sidebars) ) {
	
		$sidebars_widgets = wp_get_sidebars_widgets();		
		 
		$num_widgets = 0;
		foreach ( (array) $sidebars_widgets as $k => $v ) {
		
		if(is_array($v)){
		foreach($v as $m){
			if(strpos($m,$findme) !== false) {
				$foundCounter++;
			}
		}
		
		}
		 
	}
		return $foundCounter;
	
	}}
	
	function extraCSS(){
	
	
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $post, $PPT,$PPTDesign; $STRING = ""; @extract($args); $mapID=rand(0,100);
	
	if(isset($GLOBALS['IS_SINGLEPAGE']) && !isset($GLOBALS['ARTICLEPAGE']) ){ return; }
	
	wp_register_script( 'GoogleMapsAPI', 'http://maps.googleapis.com/maps/api/js?sensor=false');
	wp_enqueue_script( 'GoogleMapsAPI' );
	
	wp_register_script( 'GoogleMapsAPIIcons', 'http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.9/src/infobox_packed.js');
	wp_enqueue_script( 'GoogleMapsAPIIcons' );
	
	wp_register_script( 'GoogleMapsAPICustom', PPT_PATH.'js/jquery.maps.js');
	wp_enqueue_script( 'GoogleMapsAPICustom' );
	 
	if(isset($GLOBALS['map']) && strlen($GLOBALS['map']) > 1 ){
	
	$instance['text'] = $post->post_title;
	$instance['address'] = $GLOBALS['map'];
	} 
 
	
	$STRING .= '<script type="text/javascript"> 
	window.onload = function(){
	
	var mymap'.$mapID.' = new MeOnTheMap({	container: "ppt-map-widget'.$mapID.'",	html: "'.$instance['text'].'",	address: "'.$instance['address'].'",	zoomLevel: '.$instance['zoom'].'	});
	 
	} 
	</script>';	 
	
	$STRING .= $before_widget.str_replace("widget-box-id","ppt-widget-map",$before_title).$instance['title'].$after_title.'';
	$STRING .= '<div id="ppt-map-widget'.$mapID.'" style="height:'.$instance['h'].'; width:'.$instance['w'].';"></div> '; 
	$STRING .= ''.$after_widget;
	echo $STRING; 
 
    }
	

}

























class PPT_Widgets_ARTICLES extends WP_Widget {

    function PPT_Widgets_ARTICLES() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-articles',
			'description' => __( 'Display articles in your sidebar.' )
		);
		parent::__construct( 'ppt-articles', __( 'NEW ** ARTICLES **' ), $opts );
		
    }

    function form($instance) {
	
	global $wp_query;
        // outputs the options form on admin
		
		$defaults = array(
			'title'		=> 'Articles',		 
		);
		
		$instance = wp_parse_args( $instance, $defaults );
	?>
 
     
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  
  
 <p><br /><b>Which Article?</b> (Hold Shift+Ctrl to select multiple)</p>  
  <select id="<?php echo $this->get_field_id( 'articleID' ); ?>" name="<?php echo $this->get_field_name( 'articleID' ); ?>[]" multiple="multiple" style="width:100%; height:150px;">
  <?php
  
 	$temp 		= $wp_query; //save old query
	$wp_query	= null; //clear $wp_query
  	$query = new WP_Query('post_type=article_type&posts_per_page=100&orderby=ID&order=DESC');
  	$posts = $query->posts;
	
  if(!empty($posts)){
  foreach($posts as $post){ ?>
  <option value="<?php echo $post->ID; ?>"
  
  <?php echo ( in_array( $post->ID, (array) $instance['articleID'] ) ? 'selected="selected"' : '' ); ?>
  ><?php echo $post->post_title; ?></option>
 <?php } } 
 
            wp_reset_postdata();
            $wp_query = null; //Reset the normal query
            $wp_query = $temp;//Restore the query  
 
 
 ?>
</select>
  
  
      <p><br/><b>Display Type</b></p>
 
    <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" style="width: 220px;  font-size:14px;">
				<option value="full" <?php if(esc_attr( $instance['type'] ) =="full"){ print "selected";} ?>>Detailed Display</option>
                <option value="list" <?php if(esc_attr( $instance['type'] ) =="list"){ print "selected";} ?>>List Display</option>
				 
                 
	</select><br />  
 
<?php
    }

	function update( $new, $old )
	{	
		$clean = $old;
		
		$clean['include'] = array();
		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	
		$clean['type'] = isset( $new['type'] ) ? strip_tags( esc_html( $new['type'] ) ) : '';	 
		$clean['articleID'] = $new['articleID'];
				 
		
		return $clean;
	}

    function widget($args, $instance) {
	
	  
	// outputs the content of the widget
		
	global $PPT,$PPTDesign; $STRING = ""; @extract($args);
	
	if(isset($_GET['search-class'])){ return; }
 
 	$STRING .= $before_widget.str_replace("widget-box-id","ppt-widget-article",$before_title).$instance['title'].$after_title.'<div id="ppt-widget-article-box" >';

	if($instance['type'] == "full"){ $tt = true; }else{ $tt = false; }
	
	wp_reset_query();
				
    $STRING .= $this->Articles($instance['articleID'], $tt);  
        
	$STRING .= '</div>'.$after_widget;
			
	echo $STRING; 
  
    }
	
	
	function Articles($ID, $details=false){
	
	global $wpdb, $wp_query, $query_string, $post; $n="";		 
	 
	if(!is_array($ID)){ return; }	
				
	$STRING = "<ul>";	 	
		
	 foreach($ID as $val){ $n .= " OR ID = '".$val."'";}
	 	
	$SQL = "SELECT ID, post_title, post_date, post_content FROM $wpdb->posts 
	WHERE  $wpdb->posts.post_type = 'article_type' 
	AND ( post_status = 'published' ".$n." )
	AND post_title !=''  
	GROUP BY $wpdb->posts.ID ORDER BY $wpdb->posts.post_title ASC";
 
	$a = (array)$wpdb->get_results($SQL);		
	 	
	$date_format = get_option('date_format') . ' ' . get_option('time_format');
	
		 if(!empty($a)){
		foreach($a as $post){
		
			 $dateme = mysql2date($date_format, $post->post_date, false);
			 
			   $dd = "<div class='time'>".$dateme."</div>";  
		
			if($details){
			
				$cont = get_post_meta($post->ID, "short_desc", true);
				if(strlen($cont) < 5){
				$cont = mb_substr(strip_tags(strip_shortcodes($post->post_content)),0,170);
				}
 
				$STRING  .= "<li>";
				
				 if ( has_post_thumbnail() ) {  $STRING  .= get_the_post_thumbnail($page->ID, 'thumbnail'); }
                               
				$STRING  .= "<h3><a href='".get_permalink( $post->ID )."'>".$post->post_title."</a></h3>".$dd."".$cont."</li>";			
			 
			}else{ 
			
			
				$STRING  .="<li><a href='".get_permalink( $post->ID )."'>".$post->post_title." <br/>".$dd."</a></li>";			
			
			}
		
		} }
		
        wp_reset_query();
		 
		return $STRING."</ul>";
	
	}

}















class PPT_Widgets_CATEGORIES extends WP_Widget {

    function PPT_Widgets_CATEGORIES() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-categories',
			'description' => __( 'Display website categories within your website.' )
		);
		parent::__construct( 'ppt-categories', __( 'NEW ** CATEGORIES **' ), $opts );
		
    }

    function form($instance) {
        // outputs the options form on admin
		
		$defaults = array(
			'title'		=> 'Website Categories',
			'type'		=> 'post',	 
		);
		
		$instance = wp_parse_args( $instance, $defaults );
	?> 
     
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  
     <p><br/><b>Category List:</b></p>
 
    <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" style="width: 220px;  font-size:14px;">
				<option value="category" <?php if(esc_attr( $instance['type'] ) =="post"){ print "selected";} ?>>Product/Listing Categories</option>
                <option value="faq" <?php if(esc_attr( $instance['type'] ) =="faq"){ print "selected";} ?>>FAQ Categories</option> 
				<option value="article" <?php if(esc_attr( $instance['type'] ) =="article"){ print "selected";} ?>>Article Categories</option>
                <option value="location" <?php if(esc_attr( $instance['type'] ) =="location"){ print "selected";} ?>>Country/state/city</option>
                 
	</select><br />
    
     <p><br /><b>(Optional) Select Display Categories </b> (Hold Shift+Ctrl to select multiple)</p>  
      <select id="<?php echo $this->get_field_id( 'storeID' ); ?>" name="<?php echo $this->get_field_name( 'storeID' ); ?>[]" multiple="multiple" style="width:100%; height:150px;">
      <option value=""></option>
      <?php 
	  $types_array = array('category','faq','article','location');
	  if($instance['type'] == "" || !in_array($instance['type'],$types_array) ){ $instance['type'] = "category"; }
	  echo premiumpress_categorylist($instance['storeID'],false,false,$instance['type']); ?>
    </select> 
    
     <p><br/><b>Order By:</b></p>
 
    <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" style="width: 220px;  font-size:14px;">
    
				<option value="id*asc" <?php if(esc_attr( $instance['orderby'] ) =="id*asc"){ print "selected";} ?>>ID (Asc)</option>
                <option value="id*desc" <?php if(esc_attr( $instance['orderby'] ) =="id*desc"){ print "selected";} ?>>ID (Desc)</option>
                
                <option value="name*asc" <?php if(esc_attr( $instance['orderby'] ) =="name*asc"){ print "selected";} ?>>Name (Asc)</option> 
                <option value="name*desc" <?php if(esc_attr( $instance['orderby'] ) =="name*desc"){ print "selected";} ?>>Name (Desc)</option> 
                
				<option value="count*asc" <?php if(esc_attr( $instance['orderby'] ) =="count*asc"){ print "selected";} ?>>Count (Asc)</option>
               <option value="count*desc" <?php if(esc_attr( $instance['orderby'] ) =="count*desc"){ print "selected";} ?>>Count (Desc)</option>
                 
	</select><br />
    
    <?php
 
	$out .= '<br /><p><label for="' . $this->get_field_id('parentonly') . '">Show Parent Categories Only</label>&nbsp;&nbsp;';
    $out .= '<input id="' . $this->get_field_id('parentonly') . '" name="' . $this->get_field_name('parentonly') . '" type="checkbox" ' . checked(isset($instance['parentonly'])? $instance['parentonly']: 0, true, false) . ' /></p>';

	$out .= '<br /><p><label for="' . $this->get_field_id('toggle') . '">Enable Sub-Category Toggle Mode </label>&nbsp;&nbsp;';
    $out .= '<input id="' . $this->get_field_id('toggle') . '" name="' . $this->get_field_name('toggle') . '" type="checkbox" ' . checked(isset($instance['toggle'])? $instance['toggle']: 0, true, false) . ' /></p>';


	echo  $out;
	?>
             
 
<?php
    }

	function update( $new, $old )
	{	
		$clean = $old;
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';		 
		$clean['type'] = isset( $new['type'] ) ? esc_attr( $new['type'] ) : '';
		$clean['orderby'] = isset( $new['orderby'] ) ? esc_attr( $new['orderby'] ) : 'name*asc';
		$clean['toggle'] = isset( $new['toggle'] ) ? '1' : '0';
		$clean['parentonly'] = isset( $new['parentonly'] ) ? '1' : '0';
		$clean['storeID'] = $new['storeID'];
		
		return $clean;
	}

    function widget($args, $instance) {
		
	global $PPT,$PPTDesign; $STRING = ""; @extract($args); $CATcOUNT = get_option("display_categories_count");
	
	// HIDE IF IT SP CHECKOUT
	if(isset($GLOBALS['IS_CHECKOUTPAGE'])){ return; }
	if(!isset($clean['orderby'])){ $clean['orderby'] = "name*asc"; }
	$odata = explode("*",$clean['orderby']);
	
	// BUILD DATA STRING	  
 	$taxonomy     = str_replace("_type","",$instance['type']);
	$orderby      = $odata[0]; 
	$order        = $odata[1]; 
	$show_count   = 1;      // 1 for yes, 0 for no
	$pad_counts   = 1;      // 1 for yes, 0 for no
	if(isset($instance['storeID'])){
	$storesID = $instance['storeID'];
	}else{
	$storesID =0;
	}
	if(isset($instance['parentonly']) && $instance['parentonly']){ $hierarchical = 0; }else{ $hierarchical = 1; }
	if(get_option('system_largecatload') == "yes"){ $hide_empty = 1; }else{  $hide_empty = 0; }
	$exclude = get_option('article_cats');
	if($exclude == ","){ $exclude =""; }
 
	
	$args = array(
		  'taxonomy'     => $taxonomy,
		  'orderby'      => $orderby,
		  'order'      	 => $order,
		  'show_count'   => $show_count,
		  'pad_counts'   => $pad_counts,
		  'hierarchical' => $hierarchical,
		  'hide_empty'	 => $hide_empty,
		  'exclude' 	 => $exclude,
		  'include'      => $storesID,
		);
 
 
	$cats  = get_categories( $args );
	
	if(empty($cats)){ return; }
	
	
	// BUILD STRING 	
	$STRING .= $before_widget.str_replace("widget-box-id","ppt-widget-categories",$before_title).$instance['title'].$after_title;
 
 	// SEPERATE BASED ON TOGGLE OR LIST
	if($instance['toggle'] && !$instance['parentonly']){ 
	$STRING .= '<div id="ppt_widgettoggle" class="toggle">';
	}else{
	$STRING .= '<div id="categorylistwrapper"><ul>';
	} 
	

	$newcatarray = array();

	// NOW WE BUILD A CLEAN ARRAY OF VALUES
	foreach($cats as $cat){	
	 
		if($cat->parent != 0){ continue; }		
		$newcatarray[$cat->term_id]['term_id'] 	=  $cat->term_id;
		$newcatarray[$cat->term_id]['name'] 	=  $cat->cat_name;
		$newcatarray[$cat->term_id]['parent'] 	=  $cat->parent;
		$newcatarray[$cat->term_id]['slug'] 	=  $cat->slug;
		$newcatarray[$cat->term_id]['count'] 	=  $cat->count;
	}
	// SECOND LOOP TO GET CHILDREN
 	foreach($cats as $cat){
 
		if($cat->parent == 0){ continue; }		 
		$newcatarray[$cat->parent]['child'][] = $cat;		 
	}
	  
    foreach($newcatarray as $cat){
	
	// STOP BLANK NAMES
	if($cat['name'] == ""){ continue; }
 	
	// CHECK IF ITS THE CATEGORY WE ARE CURRENTLY VIEWING
	if(isset($GLOBALS['premiumpress']['pcatID']) && $GLOBALS['premiumpress']['pcatID'] == $cat['term_id'] || $GLOBALS['premiumpress']['catID'] == $cat['term_id'] ){  $extra="active"; }else{ $extra=""; }
	
	// SHOW CAT COUNT
	if($CATcOUNT == "yes"){ $extra1 = " (".$cat['count'].")"; }else{ $extra1 = ""; }
	 
	 	if($instance['parentonly']){
		 
			 $STRING .= '<li><a href="'.get_term_link( $cat['slug'], str_replace("_type","",$instance['type'])   ).'">'.$cat['name'].''.$extra1.'</a></li>';
	 			
		}else{ 
		
			// TOGGLE ON +CATS 
			if($instance['toggle']){
			
				if(!empty($cat['child'])){
				 
					 $STRING .= '<div class="trigger '.$extra.'"><a href="#">'.$cat['name'].''.$extra1.'</a></div><div class="container"><ul>';
					
					$STRING .= '<li class="togglesub1"><a href="'.get_term_link( $cat['slug'], str_replace("_type","",$instance['type'])   ).'">'.$cat['name'].''.$extra1.'</a></li>';
					
					 foreach($cat['child'] as $sub1){
					 	
						if($CATcOUNT == "yes"){ $extra2 = " (".$sub1->count.")"; }else{ $extra2 = ""; }
							
						$STRING .= '<li class="togglesub1"><a href="'.get_term_link( $sub1->slug, str_replace("_type","",$instance['type'])   ).'">'.$sub1->name.''.$extra2.'</a></li>';
					 }
					 
					 $STRING .= '</ul></div>';
				 
				 }else{
				 
				 $STRING .= '<div class="trigger1"><a href="'.get_term_link( $cat['slug'], str_replace("_type","",$instance['type'])   ).'"">'.$cat['name'].'</a></div>';
				 
				 }
			
			
			}else{
			
		 		// UL LIST // NOT TOGGLE
				if(!empty($cat['child'])){
				 
				  $STRING .= '<li><a href="#">'.$cat['name'].''.$extra1.'</a><ul class="listTab">';
				  
				  	 $STRING .= '<li><a href="'.get_term_link( $cat['slug'], str_replace("_type","",$instance['type'])   ).'">'.$cat['name'].''.$extra1.'</a></li>';
					
					 foreach($cat['child'] as $sub1){	
					 	
						if($CATcOUNT == "yes"){ $extra2 = " (".$sub1->count.")"; }else{ $extra2 = ""; }
						
						$STRING .= '<li><a href="'.get_term_link( $sub1->slug, str_replace("_type","",$instance['type'])   ).'">'.$sub1->name.''.$extra2.'</a></li>';
					 }
					 
					 $STRING .= '</ul></li>';
				 
				 }else{
				 
				 $STRING .= '<li><a href="'.get_term_link( $cat['slug'], str_replace("_type","",$instance['type'])   ).'">'.$cat['name'].''.$extra1.'</a></li>';
				 
				 } 
			 
			}
		
		}
		  
	 }
	 
	// FINISH OFF THE STRING 
	if($instance['toggle'] && !$instance['parentonly']){ 
	 $STRING .= '</div><div class="clearfix"></div>';
	}else{
	 $STRING .= '</ul></div><div class="clearfix"></div>';
	 $STRING .= '<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#categorylistwrapper ul li").mouseover(function(e) {jQuery(this).addClass(" iehover ");});
			jQuery("#categorylistwrapper ul li").mouseout(function(e) {jQuery(this).removeClass(" iehover ");});
		});
	</script>';
	} 

	
	$STRING .= $after_widget;
 	
	print $STRING;
	
    } 

}

 




 


define('WF_FTW_CORE_VER', 1.1);

global $wf_ftw_do_footer, $wf_ftw_active_fonts, $wf_ftw_nb;
$wf_ftw_do_footer = false;
$wf_ftw_active_fonts = array();
$wf_ftw_nb = 0;


class wf_ftw {
  // add hooks and filters
  function init() {
    if (is_admin()) {
      // enqueue scripts
      add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts')); 
    
    } else {
      add_action('wp_footer', array(__CLASS__, 'wp_footer'));
    }
  } // init 

 
 

  // enqueue CSS and JS scripts on widgets pages
  function enqueue_scripts() {
    $uri = $_SERVER['REQUEST_URI'];

    if (strpos($uri, 'widgets.php') !== false) {
      $plugin_url = plugin_dir_url(__FILE__);
      wp_enqueue_script('wf-ftw-colorpicker-js', PPT_PATH . 'framework/widgets/js/ftw-colorpicker.js', array(), '1.0', true);
      wp_enqueue_style('wf-ftw-colorpicker-css', PPT_PATH . 'framework/widgets/css/ftw-colorpicker.css', array(), '1.0');
    } // if
  } // enqueue_scripts


 


  // add links to plugin's description in plugins table
  function plugin_meta_links($links, $file) {
    $documentation_link = '<a target="_blank" href="' . plugin_dir_url(__FILE__) . 'documentation/' .
                          '" title="View documentation">Documentation</a>';

    if ($file == plugin_basename(__FILE__)) {
      $links[] = $documentation_link;
    }

    return $links;
  } // plugin_meta_links


  // inject CSS in theme footer
  function wp_footer() {
    global $wf_ftw_do_footer, $wf_ftw_active_fonts;
    $out = '';

    $font_files['ftw-font-waiting-for-the-sunrise'] = 'Waiting+for+the+Sunrise';
    $font_files['ftw-font-the-girl-next-door'] = 'The+Girl+Next+Door';
    $font_files['ftw-font-sue-ellen-francisco'] = 'Sue+Ellen+Francisco';
    $font_files['ftw-font-annie-use-your-telescope'] = 'Annie+Use+Your+Telescope';
    $font_files['ftw-font-indie-flower'] = 'Indie+Flower';
    $font_files['ftw-font-architects-daughter'] = 'Architects+Daughter';
    $font_files['ftw-font-just-me-again-down-here'] = 'Just+Me+Again+Down+Here';
    $font_files['ftw-font-just-another-hand'] = 'Just+Another+Hand';
    $font_files['ftw-font-covered-by-your-grace'] = 'Covered+By+Your+Grace';
    $font_files['ftw-font-schoolbell'] = 'Schoolbell';
    $font_files = apply_filters('wf_ftw_font_files_list', $font_files);

    if ($wf_ftw_do_footer) {
      $css_files[] = PPT_PATH . 'framework/widgets/css/ftw.css';
      $css_files = apply_filters('wf_ftw_css_files_list', $css_files);

      foreach ($css_files as $css_file) {
        $out .= '<style type="text/css">@import url("' . $css_file . '");</style>' . "\n";
      }

      if ($wf_ftw_active_fonts) {
        foreach ($wf_ftw_active_fonts as $font => $tmp) {
          $font = 'http://fonts.googleapis.com/css?family=' . $font_files[$font];
          $out .= '<style type="text/css">@import url("' . $font . '");</style>' . "\n";
        }
      } // if fonts

      $out = apply_filters('wf_ftw_do_footer', $out);
      echo $out;
    } // if do_footer
  } // wp_footer


  // helper function for creating dropdowns
  function create_select_options($options, $selected = null, $output = true) {
    $out = "\n";

    foreach ($options as $tmp) {
      if ($selected == $tmp['val']) {
        $out .= "<option selected=\"selected\" value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      } else {
        $out .= "<option value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      }
    } // foreach

    if ($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_select_options
} // class wf_ftw


// main widget class
class fancy_text extends WP_Widget {

  // constructor method
  function fancy_text() {
    $widget_ops = array('classname' => 'fancy_text', 'description' => "Fancy, colorful arbitrary text or HTML.");
    $control_ops = array('width' => 400, 'height' => 350);
    $widget_name = 'NEW ** FANCY NOTICE **';

    $this->WP_Widget('fancy_text', $widget_name, $widget_ops, $control_ops);
  } // fancy_text


  // widget HTML generator
  function widget($args, $instance) {
    global $wf_ftw_active_fonts, $wf_ftw_do_footer, $wf_ftw_nb;
    $out = '';

    @extract($args);
    extract($instance);

    $wf_ftw_do_footer = true;
    $wf_ftw_active_fonts[$font] = true;
    $wf_ftw_nb++;

    $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
    $text = do_shortcode($instance['text']);
    if (isset($instance['filter']) && $instance['filter']) {
      $text = wpautop($text);
    }
	
	if(!isset($font_color)){ $font_color=""; }
    if ($font_color) {
      $font_color = ' color:' . $font_color . ' !important;';
    }

    $container_class = apply_filters('wf_ftw_container_class', '', $args, $instance);

    //$out .= $before_widget;
    $out .= '<div id="ftw-' . $wf_ftw_nb . '" class="ftw-container' . $container_class . '">';
    $out = apply_filters('wf_ftw_html_container_begin', $out, $args, $instance);
    $out .= '<div class="ftw-body ' . $background . ' ' . $font . '" style="background-color: ' . $instance['color'] . ' !important;' . $font_color . '"><div class="ftw-spacing">';
    if (!empty($title)) {
      $out .= '<strong>' . $title . '</strong><br />';
    }
    $out .= $text . '</div></div>';
    $out .= '<div class="ftw-footer">';
    if ($corners == 'both') {
      $out .= '<div class="ftw-footer-left"></div>';
      $out .= '<div class="ftw-footer-right"></div>';
    } elseif ($corners == 'left') {
      $out .= '<div class="ftw-footer-left"></div>';
    } elseif ($corners == 'right') {
      $out .= '<div class="ftw-footer-right"></div>';
    }
    $out .= '</div>';
    $out .= '<div class="' . $icon . ' ' . $icon_position . '"></div>';
    $out .= '</div>';
    //$out .= $after_widget;

    $out = apply_filters('wf_ftw_html_before_echo', $out, $args, $instance);
    echo $out;
  } // widget


  // update widget settings
  function update($new_instance, $old_instance) {
    $instance = $new_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    if (current_user_can('unfiltered_html')) {
      $instance['text'] = $new_instance['text'];
    } else {
      $instance['text'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text'])));
    }
    $instance['filter'] = isset($new_instance['filter']);
    $instance['color'] = substr($instance['color'], 0, 7);

    $instance = apply_filters('wf_ftw_update_widget', $instance, $new_instance, $old_instance);

    return $instance;
  } // update


  // widget customization form
  function form($instance) {
    $out = '';
    $default_options = array('title' => 'Widget title',
                             'text' => 'You are reading text inside a fancy text widget. There\'s no real purpose to it. It\'s just <strong>fancy</strong>!',
                             'filter' => 0,
                             'background' => 'ftw-body-horizontal-vertical-lines-paper',
                             'icon' => 'ftw-graphics-tape-2',
                             'icon_position' => 'ftw-graphics-right',
                             'font' => 'ftw-font-schoolbell',
                             'corners' => 'both',
                             'font-color' => '',
                             'color' => '#57bdcf');
    $default_options = apply_filters('wf_ftw_default_options', $default_options);

    $instance = wp_parse_args((array) $instance, $default_options);
    $title = strip_tags($instance['title']);

    $backgrounds[] = array('val' => '', 'label' => 'Plain');
    $backgrounds[] = array('val' => 'ftw-body-crumbled-paper-1', 'label' => 'Crumbled paper, less');
    $backgrounds[] = array('val' => 'ftw-body-crumbled-paper-2', 'label' => 'Crumbled paper, more');
    $backgrounds[] = array('val' => 'ftw-body-sand-paper-1', 'label' => 'Sand paper, fine');
    $backgrounds[] = array('val' => 'ftw-body-sand-paper-2', 'label' => 'Sand paper, more grainy');
    $backgrounds[] = array('val' => 'ftw-body-horizontal-lines-paper', 'label' => 'Paper with horizontal lines');
    $backgrounds[] = array('val' => 'ftw-body-horizontal-vertical-lines-paper', 'label' => 'Paper with horizontal and vertical lines');
    $backgrounds = apply_filters('wf_ftw_backgrounds_list', $backgrounds);

    $icons[] = array('val' => '', 'label' => 'None');
    $icons[] = array('val' => 'ftw-graphics-tape-1', 'label' => 'Sticky tape vertical');
    $icons[] = array('val' => 'ftw-graphics-tape-2', 'label' => 'Stick type diagonal');
    $icons[] = array('val' => 'ftw-graphics-paperclip', 'label' => 'Paper clip');
    $icons[] = array('val' => 'ftw-graphics-paperclip-oldschool', 'label' => 'Old school paper clip');
    $icons[] = array('val' => 'ftw-graphics-pinup', 'label' => 'Safety pin');
    $icons[] = array('val' => 'ftw-graphics-pin-blue', 'label' => 'Blue pin');
    $icons[] = array('val' => 'ftw-graphics-pin-red', 'label' => 'Red pin');
    $icons[] = array('val' => 'ftw-graphics-pin-white', 'label' => 'White pin');
    $icons[] = array('val' => 'ftw-graphics-pin-green', 'label' => 'Green pin');
    $icons[] = array('val' => 'ftw-graphics-pin-black', 'label' => 'Black pin');
    $icons = apply_filters('wf_ftw_icons_list', $icons);

    $icon_positions[] = array('val' => 'ftw-graphics-left', 'label' => 'Top left');
    $icon_positions[] = array('val' => 'ftw-graphics-right', 'label' => 'Top right');
    $icon_positions[] = array('val' => 'ftw-graphics-left-bottom', 'label' => 'Bottom left');
    $icon_positions[] = array('val' => 'ftw-graphics-right-bottom', 'label' => 'Bottom right');
    $icon_positions = apply_filters('wf_ftw_icon_positions_list', $icon_positions);

    $corners[] = array('val' => '', 'label' => 'Both straight');
    $corners[] = array('val' => 'both', 'label' => 'Both folded');
    $corners[] = array('val' => 'left', 'label' => 'Left folded');
    $corners[] = array('val' => 'right', 'label' => 'Right folded');
    $corners = apply_filters('wf_ftw_corners_list', $corners);

    $fonts[] = array('val' => '', 'label' => 'Default, theme defined');
    $fonts[] = array('val' => 'ftw-font-the-girl-next-door', 'label' => 'The Girl Next Door');
    $fonts[] = array('val' => 'ftw-font-sue-ellen-francisco', 'label' => 'Sue Ellen Francisco');
    $fonts[] = array('val' => 'ftw-font-annie-use-your-telescope', 'label' => 'Annie Use Your Telescope');
    $fonts[] = array('val' => 'ftw-font-waiting-for-the-sunrise', 'label' => 'Waiting for the Sunrise');
    $fonts[] = array('val' => 'ftw-font-indie-flower', 'label' => 'Indie Flower');
    $fonts[] = array('val' => 'ftw-font-architects-daughter', 'label' => 'Architects Daughter');
    $fonts[] = array('val' => 'ftw-font-just-me-again-down-here', 'label' => 'Just Me Again Down Here');
    $fonts[] = array('val' => 'ftw-font-just-another-hand', 'label' => 'Just Another Hand');
    $fonts[] = array('val' => 'ftw-font-covered-by-your-grace', 'label' => 'Covered By Your Grace');
    $fonts[] = array('val' => 'ftw-font-schoolbell', 'label' => 'School bell');
    $fonts = apply_filters('wf_ftw_fonts_list', $fonts);

    $out .= '<script type="text/javascript">' . "\n";
    $out .= "jQuery('#" . $this->get_field_id('color') . "').css('background-color', jQuery('#" . $this->get_field_id('color') . "').val()); ";
    $out .= "jQuery('#" . $this->get_field_id('font_color') . "').css('background-color', jQuery('#" . $this->get_field_id('font_color') . "').val()); ";
    //$out .= "ftw_colorpicker('" . $this->get_field_id('color') . "');\n";
    //$out .= "ftw_colorpicker('" . $this->get_field_id('font_color') . "');\n";
    $out .= '</script>';

    $out = apply_filters('wf_ftw_form_out_pre', $out, $this, $instance);

    $out .= '<p><label for="' . $this->get_field_id('title') . '">Title</label>';
    $out .= '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="'. esc_attr($title) . '" /></p>';

    $out .= '<p><textarea class="widefat" rows="16" cols="20" id="' . $this->get_field_id('text') . '" name="' . $this->get_field_name('text') . '">' . $instance['text'] . '</textarea></p>';

    $out .= '<p><label for="' . $this->get_field_id('filter') . '">Automatically add paragraphs to text</label>&nbsp;&nbsp;';
    $out .= '<input id="' . $this->get_field_id('filter') . '" name="' . $this->get_field_name('filter') . '" type="checkbox" ' . checked(isset($instance['filter'])? $instance['filter']: 0, true, false) . ' /></p>';

    $out .= '<p><label for="' . $this->get_field_id('background') . '">Background:</label>&nbsp;&nbsp;';
    $out .= '<select name="' . $this->get_field_name('background') . '" id="' . $this->get_field_id('background') . '">';
    $out .= wf_ftw::create_select_options($backgrounds, $instance['background'], false);
    $out .= '</select></p>';

    $out .= '<p><label for="' . $this->get_field_id('color') . '">Background color:</label>&nbsp;&nbsp;';
    $out .= '<input onclick="ftw_bind_fix(\'' . $this->get_field_id('color') . '\');" class="medium-text ftw-color" id="' . $this->get_field_id('color') . '" name="' . $this->get_field_name('color') . '" type="text" value="'. $instance['color'] . '" /></p>';

    $out .= '<p><label for="' . $this->get_field_id('font_color') . '">Font color:</label>&nbsp;&nbsp;';
    $out .= '<input onclick="ftw_bind_fix(\'' . $this->get_field_id('font_color') . '\');" class="medium-text ftw-color" id="' . $this->get_field_id('font_color') . '" name="' . $this->get_field_name('font_color') . '" type="text" value="'. $instance['font_color'] . '" />';
    $out .= '&nbsp;&nbsp;<input type="button" class="button-secondary" value="Default theme color" onclick="jQuery(\'#' . $this->get_field_id('font_color') . ' \').val(\'\').css(\'background-color\', \'white\');" /></p>';

    $out .= '<p><label for="' . $this->get_field_id('font') . '">Font:</label>&nbsp;&nbsp;';
    $out .= '<select name="' . $this->get_field_name('font') . '" id="' . $this->get_field_id('font') . '">';
    $out .= wf_ftw::create_select_options($fonts, $instance['font'], false);
    $out .= '</select></p>';

    $out .= '<p><label for="' . $this->get_field_id('icon') . '">Icon:</label>&nbsp;&nbsp;';
    $out .= '<select name="' . $this->get_field_name('icon') . '" id="' . $this->get_field_id('icon') . '">';
    $out .= wf_ftw::create_select_options($icons, $instance['icon'], false);
    $out .= '</select></p>';

    $out .= '<p><label for="' . $this->get_field_id('icon_position') . '">Icon position:</label>&nbsp;&nbsp;';
    $out .= '<select name="' . $this->get_field_name('icon_position') . '" id="' . $this->get_field_id('icon_position') . '">';
    $out .= wf_ftw::create_select_options($icon_positions, $instance['icon_position'], false);
    $out .= '</select></p>';

    $out .= '<p><label for="' . $this->get_field_id('corners') . '">Corners:</label>&nbsp;&nbsp;';
    $out .= '<select name="' . $this->get_field_name('corners') . '" id="' . $this->get_field_id('corners') . '">';
    $out .= wf_ftw::create_select_options($corners, $instance['corners'], false);
    $out .= '</select></p>';

    $out = apply_filters('wf_ftw_form_out_post', $out, $this, $instance);
    echo $out;
  } // form
} // class fancy_text












/**************************** END FANCY BOX **********************************/





// constants
define('WF_WN_PLUGIN_URL', '');
define('WF_WN_WIDGET_WIDTH', 400);

// AJAX and common functions
require_once 'widgets/php/wn-common.php';
require_once 'widgets/php/wn-ajax.php';

class wf_wn {
  static $debug_output = '';

  // add hooks and filters
  function init() {
    // admin area
    if (is_admin()) {
      // widget related hooks
      add_action('sidebar_admin_setup',    array('wf_wn', 'modify_controls'));
      add_action('in_widget_form',         array('wf_wn', 'form'), 10, 3);
      add_action('widgets_admin_page',     array('wf_wn', 'dialog_container'));
      add_filter('widget_update_callback', array('wf_wn', 'update'), 10, 3);

    
      // server-side AJAX callback
      add_action('wp_ajax_wf_wn_dialog', array('wn_ajax', 'dialog'));

      // hooks only for widgets admin page
      if (strpos($_SERVER['REQUEST_URI'], 'widgets.php') !== false) {
       
      }
    } else { // frontend
      add_filter('widget_display_callback', array('wf_wn', 'widget_display'), 10, 3);
      add_filter('wp_footer', array('wf_wn', 'footer_debug'));
    }
  } // init


 

  // check if debugging is enabled
  function is_debug() {
    if (isset($_GET['wn-debug']) && current_user_can('manage_options')) {
      return true;
    } else {
      return false;
    }
  } // is_debug


  // display debug info in footer
  function footer_debug() {
    if (self::is_debug()) {
      echo '<div id="wn_debug" style="clear: both; font-family: monospace; padding: 10px; margin: 10px; border: 1px solid black; background-color: #F9F9F9; color: black;">';
      echo '<b>debug data</b><br />' . self::$debug_output . '</div>';
    }
  } // footer_debug


  // check if widget is enabled on the current page
  // main plugin function, only one used on frontend
  function widget_display($instance, $obj, $args) {
    if (self::is_debug()) {
      self::$debug_output .= '<br />Widget: ' . $obj->name . ($instance['title']? ' (' . $instance['title'] . ')': '') . '; WN operator: ' . ($instance['wn_show']? $instance['wn_show']: 'off') . '<br />';
    }
	
if(!isset($instance['wn_active_hooks'])){ $instance['wn_active_hooks']=""; $instance['wn_show']=""; }

    parse_str($instance['wn_active_hooks'], $ac_hooks);
    $show = strtolower($instance['wn_show']);

    // is Ninja enabled for this widget?
    if (empty($ac_hooks) || empty($show) || !is_array($ac_hooks)) {
      if (self::is_debug()) {
        self::$debug_output .= 'Widget is <b>visible</b><br />';
      }
      return $instance;
    }
 

    foreach($ac_hooks as $condition => $params) {

      // remove 0 from params list
      if ($params[0] == '0') {
        // no aditional params for this conditional
        $params = null;
      } else {
        // explode string by "," so we can get an array of selected items (pages, posts, categories, ...)
        $params = explode(',', $params[0]);
      }
	  
	  	
	  
      if(sizeof($params) == 1) {
        $params = $params[0];
      }

      // if debugging is enabled log each conditional tag call
      if (self::is_debug()) {
        self::$debug_output .= '&nbsp;&nbsp;' . $condition;
        self::$debug_output .= '(' . (is_null($params)? '': print_r($params, true)) . ') == ';
        self::$debug_output .= (call_user_func($condition, $params)? 'true': 'false') . '<br />';
      }

      // OR condition
      if ($show == 'or') {
	  
        $show_it = false;
		
		 
		if($condition == "is_submit_page"){ // CUSOTOM ELEMENTS ADDED BY MARK
		
			if(isset($GLOBALS['tpl-add'])){
				$show_it = true;
				break;
			}
		
		}elseif($condition == "is_callback_page"){ // CUSOTOM ELEMENTS ADDED BY MARK
		
			if(isset($GLOBALS['tpl-callback'])){
				$show_it = true;
				break;
			}
					 
        // show widget as soon as one criteria is met
        }elseif (call_user_func($condition, $params)) {
		
		 
          $show_it = true;
          break;
        }
		
		
      } elseif ($show == 'and') { // AND condition
	  
        $show_it = true;
		
		// ADDED BY MARK TO STOP HOME PAGE SHOWING INAEGORY 
		if(isset($GLOBALS['flag-home']) && $condition == "in_category"){
		
		 $show_it = false; 
          break;
		}
		
        // hide widget as soon as one criteria is not met
        if (!call_user_func($condition, $params)) {
          $show_it = false; 
          break;
        }
		//die($GLOBALS['premiumpress']['catID']);
		//die($show_it.print_r($params).$condition);
		
      } elseif ($show == 'not') { // NOT condition
        $show_it = true;
		
		
		
        // hide widget as soon as one criteria is met
        if (call_user_func($condition, $params)) {
          $show_it = false;
          break;
        }
      } else { // should never happen but if it does show widget
        $show_it = true;
      }
    } // foreach hook

    if ($show_it) {
      if (self::is_debug()) {
        self::$debug_output .= 'Widget is <b>visible</b><br />';
      }
      return $instance;
    } else {
      if (self::is_debug()) {
        self::$debug_output .= 'Widget is <b>not visible</b><br />';
      }
      return false;
    }
  } // widget_display


  // modify widget controls; force min width to fit WN GUI
  function modify_controls() {
    global $wp_registered_widgets, $wp_registered_widget_controls;

    foreach ($wp_registered_widgets as $id => $widget) {
      // check if default widget width is bigger then our custom width
      if ($wp_registered_widget_controls[$id]['width'] < WF_WN_WIDGET_WIDTH) {
        $wp_registered_widget_controls[$id]['width'] = WF_WN_WIDGET_WIDTH;
      }
    } // foreach widget
  } // modify_controls


  // generate Widget Ninja GUI
  function form($instance, $widget, $widget_option) {
    $active_hooks = array(); 
    $widget_id = $instance->id;
	
	if(!isset($widget_option['wn_show'])){ $widget_option['wn_show'] = ""; }
	if(!isset($widget_option['wn_active_hooks'])){ $widget_option['wn_active_hooks'] = ""; }
	 

    echo '<div class="widget-control-actions">
    <div class="alignright">
      <img alt="" title="" class="ajax-feedback " src="' . admin_url() .'images/wpspin_light.gif" style="visibility: hidden;">
      <input type="submit" value="' . __('Save') . '" class="button-primary widget-control-save" id="savewidget" name="savewidget">
    </div>
    <br class="clear">
    </div>';

    echo '<br /><p><b>Widget Display Options</b></p>';

    // WN status options
    $wn_status[] = array('val' => '',    'label' => 'Show Widget.');
    $wn_status[] = array('val' => 'or',  'label' => 'Show widget if ANY active conditional tag returns TRUE (logical OR)');
    $wn_status[] = array('val' => 'and', 'label' => 'Show widget if ALL active conditional tags return TRUE (logical AND)');
    $wn_status[] = array('val' => 'not', 'label' => 'Show widget if ALL active conditional tags return FALSE');

    echo '<select name="' . $instance->get_field_name('wn_show') . '" id="' . $instance->get_field_id('wn_show') . '" class="wn_status ' . $instance->get_field_id('wn_show') . '">';
    wf_wn_common::create_select_options($wn_status, $widget_option['wn_show']);
    echo '</select>';
    echo ' <a href="#" wn-help="options" class="help" title="Click to show help"><img alt="Click to show help" title="Click to show help" src="' . PPT_PATH . 'framework/widgets/images/help.png" /></a>';

    // check if widget ninja is enabled for this widget
    if ($widget_option['wn_show'] != '') {
      $display = 'display: block;';
    } else {
      $display = 'display: none;';
    }
    // list available hook options
    echo '<div class="hook_options ' . $instance->get_field_id('wn_show') . '" style="' . $display . '">';

    // conditional tags, WP built-in and custom
    $hooks[] = array('wnfn' => 'is_home:0', 'label' => 'is_home');
    $hooks[] = array('wnfn' => 'is_front_page:0', 'label' => 'is_front_page');

    $hooks[] = array('wnfn' => 'is_category:0', 'dialog' => 'categories', 'label' => 'is_category');
    $hooks[] = array('wnfn' => 'in_category:0', 'dialog' => 'categories',  'label' => 'in_category');

    //$hooks[] = array('wnfn' => 'is_tag:0', 'dialog' => 'tags', 'label' => 'is_tag');
    //$hooks[] = array('wnfn' => 'has_tag:0', 'dialog' => 'tags', 'label' => 'has_tag');

    $hooks[] = array('wnfn' => 'is_page:0', 'dialog' => 'pages', 'label' => 'is_page');
    $hooks[] = array('wnfn' => 'is_single:0', 'dialog' => 'posts',  'label' => 'is_single');
    $hooks[] = array('wnfn' => 'is_singular:0', 'label' => 'is_singular', 'dialog' => 'post_types');
    //$hooks[] = array('wnfn' => 'is_sticky:0', 'label' => 'is_sticky');
    $hooks[] = array('wnfn' => 'is_author:0', 'dialog' => 'authors',  'label' => 'is_author');

    $hooks[] = array('wnfn' => 'is_404:0', 'label' => 'is_404');
    $hooks[] = array('wnfn' => 'is_search:0', 'label' => 'is_search');
   // $hooks[] = array('wnfn' => 'is_archive:0', 'label' => 'is_archive');
    //$hooks[] = array('wnfn' => 'is_preview:0', 'label' => 'is_preview');
    // works only on WP >= v3.1
     

    $hooks[] = array('wnfn' => 'is_paged:0', 'label' => 'is_paged');
	
   // $hooks[] = array('wnfn' => 'is_submit_page:0', 'label' => 'SUBMIT PAGE');
	//$hooks[] = array('wnfn' => 'is_callback_page:0', 'label' => 'CALLBACK PAGE');

    $hooks[] = array('wnfn' => 'comments_open:0', 'label' => 'comments_open');
    $hooks[] = array('wnfn' => 'has_excerpt:0', 'label' => 'has_excerpt');

    $hooks[] = array('wnfn' => 'wn_is_user_guest:0', 'label' => 'is_user_guest');
    $hooks[] = array('wnfn' => 'is_user_logged_in:0', 'label' => 'is_user_logged_in');
    $hooks[] = array('wnfn' => 'current_user_can:manage_options', 'label' => 'is_user_admin');

    // check which hooks are active
    parse_str($widget_option['wn_active_hooks'], $ac_hooks);

    // if there are any active hooks
    if (is_array($ac_hooks)) {
      // foreach available hook see if it's active
      $tmp_hooks = $hooks;
      foreach ($hooks as $hook_key => $hook_value){
        $clean_id = explode(':', $hook_value['wnfn']);

        if (isset($ac_hooks[$clean_id[0]]) && is_array($ac_hooks[$clean_id[0]])) { //??
          // check if our hook has any parameters defined
          $hook_attachments = $ac_hooks[$hook_value['label']];
          if (is_array($hook_attachments)) {
            $attachments = $hook_attachments[0];
            $hook_value['wnfn'] = $hook_value['label'] . ':' . $attachments;
          }
          // add used hooks to active array and remove them from available array
          $active_hooks[] = $hook_value;
          unset($tmp_hooks[$hook_key]);
        } // if (is_array($ac_hooks))
      } // foreach ($hooks)
      $hooks = $tmp_hooks;
    } // if (is_array($ac_hooks))

    // active hooks
    echo '<h4 class="wn-title"><span class="extra-vis active">Active</span> conditional tags</h4>';
    echo '<div class="wn-drag-description">Only active tags determine widget\'s visibility. Drag tags here to create complex conditional statements based on <a target="_blank" href="http://codex.wordpress.org/Conditional_Tags">conditional tags</a>.</div>';
    echo '<ul id="' . $instance->get_field_id('wn_active_hooks') . '" class="wn_Connected active_tags">';
    wf_wn_common::create_list($instance->get_field_id('wn_active_hooks'), $active_hooks, 'active', $widget_id);
    echo '</ul>';

    // available/unactive hooks
    echo '<h4 class="wn-title"><span class="extra-vis inactive">Inactive</span> conditional tags</h4>';
    echo '<div class="wn-drag-description">Drag tags you want to disable to this area.</div>';
    echo '<ul id="' . $instance->get_field_id('wn_available_hooks') . '" class="wn_Connected inactive_tags">';
    wf_wn_common::create_list($instance->get_field_id('wn_available_hooks'), $hooks, 'available', $widget_id);
    echo '</ul>';

    // hidden input field for remembering active conditions
    echo '<input type="hidden" name="' . $instance->get_field_name('wn_active_hooks') . '" id="' . $instance->get_field_id('wn_active_hooks') . '" class="serialized_tags" value="" />';
    echo '</div>';
    echo '<br class="clear" />';

    echo '<div id="wn-info-message"><p>Please remember to click <strong>Save</strong> after making any changes to widget\'s settings.</p></div>';
    echo '<br class="clear" />';
  } // form


  // update widget options
  function update($instance, $new_instance, $old_instance) {
    $instance['wn_show'] = $new_instance['wn_show'];
    $instance['wn_active_hooks'] = $new_instance['wn_active_hooks'];

    return $instance;
  } // update


  // dialog box container
  function dialog_container() {
    echo '<div class="dialog_loading_container" style="display: none;">
           <div class="dialog_loading" id="loading">
            <img src="' . PPT_PATH . 'framework/widgets/images/loading.gif" alt="Loading dialog, please wait!" title="Loading dialog, please wait!" />
           </div>
          </div>';
    echo '<div class="dialog" id="dialog"></div>';
  } // dialog_container


  // CSS fixes for IE 7 and 8
  function admin_header() {
    echo '<!--[if IE 8]> ';
    echo '<link rel="stylesheet" type="text/css" href="' . PPT_PATH . 'framework/widgets/css/wn-ie8.css" />';
    echo " <![endif]-->\n";

    echo '<!--[if IE 7]> ';
    echo '<link rel="stylesheet" type="text/css" href="' . PPT_PATH . 'framework/widgets/css/wn-ie7.css" />';
    echo ' <![endif]-->';
  } // admin_header


  // inject help content
  function admin_footer() {
  ?>
<div id="wn-help-container" style="display: none;">
  <div id="wn-help-options">
  <ul>
    <li>the widget will be shown on all pages</li>
    <li>logical "or" operator will show the widget if any tag returns <i>true</i></li>
    <li>logical "and" operator will show the widget only if all tags return <i>true</i></li>
    <li>last option, logical "not" displays the widget only if all tags return <i>false</i></li>
  </ul>
  </div>

  <div id="wn-help-is_home">
  <p>Checks if the main page is being displayed. If you select a static page as your front page then use <i>is_front_page</i>.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_home" target="_blank">is_home</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_front_page">
  <p>Checks if the main page is a post or a page. It returns <i>true</i> when the main blog page is being displayed and the Settings-Reading-Front page displays is set to "Your latest posts", or when is set to "A static page" and the "Front Page" value is the current page being displayed.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_front_page" target="_blank">is_front_page</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_category">
  <p>Checks if a category archive page is being displayed. If you define specific category (or categories using <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" />) it will check only for that category.
  <br />Should not be confused with <i>in_category</i>.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_category" target="_blank">is_category</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-in_category">
  <p>Checks if the current post is assigned to any of the specified categories (use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to select categories).<br />
  Tag considers only the categories a post is directly assigned to, not the parents of the assigned categories.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/in_category" target="_blank">in_category</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_tag">
  <p>Checks if a tag archive page is being displayed. Use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to select specific tags you want to check for.
  <br />Should not be confused with <i>has_tag</i>.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_tag" target="_blank">is_tag</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-has_tag">
  <p>Check if the current post has any of the given tags (use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to choose tags). If no tags are given, determines if post has any tags.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/has_tag" target="_blank">has_tag</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_404">
  <p>Checks if a 404 error page is being displayed.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_404" target="_blank">is_404</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_page">
  <p>Checks if a page is being displayed (use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to choose which pages you want to test for). If no pages are defined it determines if any page is displayed.<br />
  See <i>is_single</i> if you want to test if a single post is being displayed.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_page" target="_blank">is_page</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_single">
  <p>Checks if a single post is being displayed (use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to choose which posts you want to test for). If no posts are defined it determines if any post is displayed.<br />
  See <i>is_page</i> if you want to test if a single page is being displayed.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_single" target="_blank">is_single</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_sticky">
  <p>Checks if "Stick this post to the front page" check box has been checked for the current post.<br />
  Click <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> if you want to test "stickiness" for posts other than current.
  </p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_sticky" target="_blank">is_sticky</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_search">
  <p>Checks if search result page archive is being displayed.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_search" target="_blank">is_search</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_archive">
  <p>Checks if any type of archive page is being displayed. An archive is a category, tag, author or a date based page.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_archive" target="_blank">is_archive</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_preview">
  <p>Checks if current page/post is in preview mode (not yet published).</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_preview" target="_blank">is_preview</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_paged">
  <p>Checks if page being displayed is "paged".<br>
  This refers to an archive or the main page being split up over several pages. It does not refer to a post or page whose content has been divided into pages using the <i>&lt;!--nextpage--&gt;</i> QuickTag.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_paged" target="_blank">is_paged</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_attachment">
  <p>Checks if an attachment is being displayed. An attachment is an image or other file uploaded through the post editor's upload utility. Attachments can be displayed on their own "page" or template.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_attachment" target="_blank">is_attachment</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_singular">
  <p>Checks if a singular page is being displayed. Singular page is when any of the following conditional tags return true: <i>is_single</i>, <i>is_page</i> or <i>is_attachment</i>.
  <br />Use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to define specific post types the tag should check for.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_singular" target="_blank">is_singular</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-comments_open">
  <p>Checks if comments are allowed on the current post/page.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/comments_open" target="_blank">comments_open</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-has_excerpt">
  <p>Checks if the current post has an excerpt.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/has_excerpt" target="_blank">has_excerpt</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_user_logged_in">
  <p>Checks if the current visitor is logged in.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_user_logged_in" target="_blank">is_user_logged_in</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_user_guest">
  <p>Checks if the current visitor is a guest (not logged in).</p>
  </div>

  <div id="wn-help-is_author">
  <p>Checks if an author archive page is being displayed. Use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to check for a specific author's archive.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_author" target="_blank">is_author</a> description on WordPress Codex.</p>
  </div>

  <div id="wn-help-is_user_admin">
  <p>Checks if the current visitor is logged in and has administrator privileges (<i>manage_options</i> capability).</p>
  </div>

  <div id="wn-help-is_post_type_archive">
  <p>Checks if a post type archive page is being displayed. Use <img title="Options" alt="Options" src="<?php echo PPT_PATH . 'framework/widgets/'; ?>images/attach.gif" /> to define which post type should the tag check for.</p>
  <p>See <a href="http://codex.wordpress.org/Function_Reference/is_post_type_archive" target="_blank">is_post_type_archive</a> description on WordPress Codex.</p>
  </div>
</div>
  <?php
  } // admin_footer
} // class wf_wn

// hook the whole plugin
add_action('init', array('wf_wn', 'init'));

// checks if user is a guest; not logged in
// moved outside class so it's accessible to other plugins
function wn_is_user_guest() {
  if (is_user_logged_in()) {
    return false;
  } else {
    return true;
  }
} // wn_is_user_guest








































class Extended_Tags_Widget extends WP_Widget {

	/**
	 * Prefix for the widget.
	 */
	var $prefix;

	/**
	 * Textdomain for the widget.
	 */
	var $textdomain;

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 * @since 0.6
	 */
	function Extended_Tags_Widget() {

		/* Set the widget prefix. */
		$this->prefix = ''; 
		
		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'tags',
			'description' => esc_html__( '[+] An advanced widget that gives you total control over the output of your tags.', $this->textdomain )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 800,
			'height' => 350,
			'id_base' => "{$this->prefix}extended-tags"
		);

		/* Create the widget. */
		$this->WP_Widget( "{$this->prefix}extended-tags", esc_attr__( 'Extended Tags', $this->textdomain ), $widget_options, $control_options );
		
		/* print the user costum style sheet. */
		add_action( 'wp_head', array( &$this, 'print_custom_styles_cript') );
	}
 
	
	/* Print the custom script-style to the header wp_head */
	function print_custom_styles_cript() {
		$all_widgets = $this->get_settings();
		foreach ($all_widgets as $key => $etw_setting){
			$widget_id = $this->id_base . '-' . $key;
			if( is_active_widget( false, $widget_id, $this->id_base ) ){
				if ( !empty( $etw_setting['customstylescript'] ) )
					echo $etw_setting['customstylescript'];
			}
		}		
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 * @since 0.6
	 */
	function widget( $args, $instance ) {
		@extract($args);

		/* Set up the arguments for wp_tag_cloud(). */
		$args = array(
			'taxonomy' => 	$instance['taxonomy'],
			'largest' => 	!empty( $instance['largest'] ) ? absint( $instance['largest'] ) : 22,
			'smallest' =>	!empty( $instance['smallest'] ) ? absint( $instance['smallest'] ) : 8,
			'number' =>	intval( $instance['number'] ),
			'child_of' =>	intval( $instance['child_of'] ),
			'parent' =>	!empty( $instance['parent'] ) ? intval( $instance['parent'] ) : '',
			'separator' =>	!empty( $instance['separator'] ) ? $instance['separator'] : "\n",
			'pad_counts' =>	!empty( $instance['pad_counts'] ) ? true : false,
			'hide_empty' =>	!empty( $instance['hide_empty'] ) ? true : false,
			'unit' =>		$instance['unit'],
			'format' =>	$instance['format'],
			'style' =>	$instance['style'],
			'include' =>	!empty( $instance['include'] ) ? join( ', ', $instance['include'] ) : '',
			'exclude' =>	!empty( $instance['exclude'] ) ? join( ', ', $instance['exclude'] ) : '',
			'order' =>	$instance['order'],
			'orderby' =>	$instance['orderby'],
			'link' =>		$instance['link'],
			'search' =>	$instance['search'],
			'name__like' =>	$instance['name__like'],
			'intro_text' 		=> $instance['intro_text'],
			'outro_text' 		=> $instance['outro_text'],
			'customstylescript'	=> $instance['customstylescript'],
			'echo' =>		false
		);

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Print intro text if exist */
		if ( !empty( $instance['intro_text'] ) )
			echo '<p class="'. $this->id . '-intro-text">' . $instance['intro_text'] . '</p>';
			
		/* Get the tag cloud. */
		$tags = str_replace( array( "\r", "\n", "\t" ), ' ', wp_tag_cloud( $args ) );
		$tags = str_replace( "'>", "'><span>", $tags );
		$tags = str_replace( '</a>', '</span></a>', $tags );
		
		/* push the style */
		if ( !empty ( $instance['style'] ) )
			$tags = str_replace( "class='", "class='" . $instance['style'] . " ", $tags );

		/* If $format should be flat, wrap it in the <p> element. */
		if ( 'flat' == $instance['format'] )
			$tags = '<p class="' . $instance['taxonomy'] . '-cloud term-cloud extended-tags">' . $tags . '</p>';

		/* Output the tag cloud. */
		echo $tags;

		/* Print outro text if exist */
		if ( !empty( $instance['outro_text'] ) )
			echo '<p class="'. $this->id . '-outro_text">' . $instance['outro_text'] . '</p>';

		/* Close the theme's widget wrapper. */
		echo "<div class='clearfix'></div>".$after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 * @since 0.6
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Set the instance to the new instance. */
		$instance = $new_instance;

		/* If new taxonomy is chosen, reset includes and excludes. */
		if ( $instance['taxonomy'] !== $old_instance['taxonomy'] ) {
			$instance['include'] = array();
			$instance['exclude'] = array();
		}

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['smallest'] = strip_tags( $new_instance['smallest'] );
		$instance['largest'] = strip_tags( $new_instance['largest'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['separator'] = strip_tags( $new_instance['separator'] );
		$instance['name__like'] = strip_tags( $new_instance['name__like'] );
		$instance['search'] = strip_tags( $new_instance['search'] );
		$instance['child_of'] = strip_tags( $new_instance['child_of'] );
		$instance['parent'] = strip_tags( $new_instance['parent'] );
		$instance['unit'] = $new_instance['unit'];
		$instance['format'] = $new_instance['format'];
		$instance['style'] = $new_instance['style'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
		$instance['taxonomy'] = $new_instance['taxonomy'];
		$instance['link'] = $new_instance['link'];
		$instance['pad_counts'] = ( isset( $new_instance['pad_counts'] ) ? 1 : 0 );
		$instance['hide_empty'] = ( isset( $new_instance['hide_empty'] ) ? 1 : 0 );
		$instance['intro_text'] 		= $new_instance['intro_text'];
		$instance['outro_text'] 		= $new_instance['outro_text'];
		$instance['customstylescript']	= $new_instance['customstylescript'];
		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 * @since 0.6
	 */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => '',
			'order' => 'ASC',
			'orderby' => 'name',
			'format' => 'flat',
			'style' => 'bluerr',
			'include' => array(),
			'exclude' => array(),
			'unit' => 'pt',
			'smallest' => 8,
			'largest' => 22,
			'link' => 'view',
			'number' => 45,
			'separator' => '',
			'child_of' => '',
			'parent' => '',
			'taxonomy' => 'post_tag',
			'hide_empty' => 1,
			'pad_counts' => false,
			'search' => '',
			'name__like' => '',
			'intro_text' 		=> '',
			'outro_text' 		=> '',
			'customstylescript'	=> ''
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/* <select> element options. */
		$taxonomies = get_taxonomies( array( 'show_tagcloud' => true ), 'objects' );
		$terms = get_terms( $instance['taxonomy'] );
		$link = array( 'view' => esc_attr__( 'View', $this->textdomain ), 'edit' => esc_attr__( 'Edit', $this->textdomain ) );
		$format = array( 'flat' => esc_attr__( 'Flat', $this->textdomain ), 'list' => esc_attr__( 'List', $this->textdomain ) );
		$style = array( '' 	=> esc_attr__( '', $this->textdomain ), 
						'bluerr' 	=> esc_attr__( 'Bluerr', $this->textdomain ), 
						'green' 	=> esc_attr__( 'Green', $this->textdomain ),
						'orange' 	=> esc_attr__( 'Orange', $this->textdomain ),
						'orange2' 	=> esc_attr__( 'Orange 2', $this->textdomain ),	
						'red' 		=> esc_attr__( 'Red', $this->textdomain ),
						'yellow' 	=> esc_attr__( 'Yellow', $this->textdomain ),
						'rounded r-orange' 	=> esc_attr__( 'Orange Rounded', $this->textdomain ),
						'rounded r-green' 	=> esc_attr__( 'Green Rounded', $this->textdomain ),
						'rounded r-blue' 	=> esc_attr__( 'Blue Rounded', $this->textdomain ),
						'rounded r-red' 	=> esc_attr__( 'Red Rounded', $this->textdomain ),
						'rounded r-grey' 	=> esc_attr__( 'Grey Rounded', $this->textdomain ),
						'rounded r-black' 	=> esc_attr__( 'Black Rounded', $this->textdomain ),
						'rounded r-cyan' 	=> esc_attr__( 'Cyan Rounded', $this->textdomain ),
						'rounded t-black' 	=> esc_attr__( 'Trimmed Black', $this->textdomain ),
						'rounded t-blue' 	=> esc_attr__( 'Trimmed Blue', $this->textdomain ),
						'rounded t-cyan' 	=> esc_attr__( 'Trimmed Cyan', $this->textdomain ),
						'rounded t-green' 	=> esc_attr__( 'Trimmed Green', $this->textdomain ),
						'rounded t-grey' 	=> esc_attr__( 'Trimmed Grey', $this->textdomain ),
						'rounded t-orange' 	=> esc_attr__( 'Trimmed Orange', $this->textdomain ),
						'rounded t-red' 	=> esc_attr__( 'Trimmed Red', $this->textdomain )
						);
		$order = array( 'ASC' => esc_attr__( 'Ascending', $this->textdomain ), 'DESC' => esc_attr__( 'Descending', $this->textdomain ), 'RAND' => esc_attr__( 'Random', $this->textdomain ) );
		$orderby = array( 'count' => esc_attr__( 'Count', $this->textdomain ), 'name' => esc_attr__( 'Name', $this->textdomain ) );
		$unit = array( 'pt' => 'pt', 'px' => 'px', 'em' => 'em', '%' => '%' );
		$intro_text	= esc_textarea($instance['intro_text']);
		$outro_text	= esc_textarea($instance['outro_text']);
		?>

		<div class="zframe-widget-controls columns-3">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', $this->textdomain ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><code>taxonomy</code></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
					<?php foreach ( $taxonomies as $taxonomy ) { ?>
						<option value="<?php echo $taxonomy->name; ?>" <?php selected( $instance['taxonomy'], $taxonomy->name ); ?>><?php echo $taxonomy->labels->singular_name; ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'style' ); ?>">Style:</label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
					<?php foreach ( $style as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['style'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p style="width: 48%; float: left;">
				<label for="<?php echo $this->get_field_id( 'link' ); ?>"><code>link</code></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>">
					<?php foreach ( $link as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['link'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p style="width: 48%; float: right;">
				<label for="<?php echo $this->get_field_id( 'format' ); ?>"><code>format</code></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'format' ); ?>" name="<?php echo $this->get_field_name( 'format' ); ?>">
					<?php foreach ( $format as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['format'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p style="width: 48%; float: left;">
				<label for="<?php echo $this->get_field_id( 'order' ); ?>"><code>order</code></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
					<?php foreach ( $order as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['order'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
			<p style="width: 48%; float: right;">
				<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><code>orderby</code></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
					<?php foreach ( $orderby as $option_value => $option_label ) { ?>
						<option value="<?php echo $option_value; ?>" <?php selected( $instance['orderby'], $option_value ); ?>><?php echo $option_label; ?></option>
					<?php } ?>
				</select>
			</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><code>number</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'largest' ); ?>"><code>largest</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'largest' ); ?>" name="<?php echo $this->get_field_name( 'largest' ); ?>" value="<?php echo esc_attr( $instance['largest'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'smallest' ); ?>"><code>smallest</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'smallest' ); ?>" name="<?php echo $this->get_field_name( 'smallest' ); ?>" value="<?php echo esc_attr( $instance['smallest'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'unit' ); ?>"><code>unit</code></label> 
			<select class="smallfat" id="<?php echo $this->get_field_id( 'unit' ); ?>" name="<?php echo $this->get_field_name( 'unit' ); ?>">
				<?php foreach ( $unit as $option_value => $option_label ) { ?>
					<option value="<?php echo $option_value; ?>" <?php selected( $instance['unit'], $option_value ); ?>><?php echo $option_label; ?></option>
				<?php } ?>
			</select>
		</p>

	</div>

	<div class="zframe-widget-controls columns-3">
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><code>include</code></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>[]" size="4" multiple="multiple">
				<?php foreach ( $terms as $term ) { ?>
					<option value="<?php echo $term->term_id; ?>" <?php echo ( in_array( $term->term_id, (array) $instance['include'] ) ? 'selected="selected"' : '' ); ?>><?php echo $term->name; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><code>exclude</code></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>[]" size="4" multiple="multiple">
				<?php foreach ( $terms as $term ) { ?>
					<option value="<?php echo $term->term_id; ?>" <?php echo ( in_array( $term->term_id, (array) $instance['exclude'] ) ? 'selected="selected"' : '' ); ?>><?php echo $term->name; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'separator' ); ?>"><code>separator</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'separator' ); ?>" name="<?php echo $this->get_field_name( 'separator' ); ?>" value="<?php echo esc_attr( $instance['separator'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'child_of' ); ?>"><code>child_of</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'child_of' ); ?>" name="<?php echo $this->get_field_name( 'child_of' ); ?>" value="<?php echo esc_attr( $instance['child_of'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'parent' ); ?>"><code>parent</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'parent' ); ?>" name="<?php echo $this->get_field_name( 'parent' ); ?>" value="<?php echo esc_attr( $instance['parent'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'search' ); ?>"><code>search</code></label>
			<input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'search' ); ?>" name="<?php echo $this->get_field_name( 'search' ); ?>" value="<?php echo esc_attr( $instance['search'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'name__like' ); ?>"><code>name__like</code></label>
			<input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'name__like' ); ?>" name="<?php echo $this->get_field_name( 'name__like' ); ?>" value="<?php echo esc_attr( $instance['name__like'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'pad_counts' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['pad_counts'], true ); ?> id="<?php echo $this->get_field_id( 'pad_counts' ); ?>" name="<?php echo $this->get_field_name( 'pad_counts' ); ?>" /> <?php _e( 'Pad counts?', $this->textdomain ); ?> <code>pad_counts</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hide_empty'], true ); ?> id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" /> <?php _e( 'Hide empty?', $this->textdomain ); ?> <code>hide_empty</code></label>
		</p>
	</div>

	<div class="zframe-widget-controls columns-3 column-last">
		<p>
			<label for="<?php echo $this->get_field_id('intro_text'); ?>"><?php _e( 'Intro text:', $this->textdomain ); ?>
			<textarea name="<?php echo $this->get_field_name( 'intro_text' ); ?>" id="<?php echo $this->get_field_id( 'intro_text' ); ?>" rows="4" class="widefat"><?php echo $intro_text; ?></textarea>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('outro_text'); ?>"><?php _e( 'Outro text:', $this->textdomain ); ?>
			<textarea name="<?php echo $this->get_field_name( 'outro_text' ); ?>" id="<?php echo $this->get_field_id( 'outro_text' ); ?>" rows="4" class="widefat"><?php echo $outro_text; ?></textarea>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('customstylescript'); ?>"><?php _e( 'Custom Script & Stylesheet :', $this->textdomain );  echo '<br />Widget ID: <code>#' . $this->id . '</code>' ; ?>
			<textarea style="font-size: 11px;" name="<?php echo $this->get_field_name( 'customstylescript' ); ?>" id="<?php echo $this->get_field_id( 'customstylescript' ); ?>" rows="5" class="widefat code"><?php echo htmlentities($instance['customstylescript']); ?></textarea>
			</label>
		</p>
	</div>
	<div style="clear:both;">&nbsp;</div>
	<?php
	}
}







class PPT_Widgets_SEARCH extends WP_Widget {

    function PPT_Widgets_SEARCH() {
        // widget actual processes		
		$opts = array(
			'classname' => 'ppt-search',
			'description' => __( 'Search box for your website.' )
		);
		parent::__construct( 'ppt-search', __( 'NEW ** BASIC SEARCH WIDGET ** ' ), $opts );
		
    }

    function form($instance) {
        // outputs the options form on admin		
		$defaults = array(
			'title'		=> 'Website Search',
			'default'		=> 'Enter a keyword here..',	 
		);		
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
     
	<p><b>Box Title:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	<p><br /><b>Default Box Text:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'default' ); ?>" name="<?php echo $this->get_field_name( 'default' ); ?>" value="<?php echo esc_attr( $instance['default'] ); ?>" /> 

	<br/><br/><p><b>Button Text:</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'btn' ); ?>" name="<?php echo $this->get_field_name( 'btn' ); ?>" value="<?php echo esc_attr( $instance['btn'] ); ?>" />
    
      <p><br/><b>Search Type:</b></p>
 
    <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" style="width: 220px;  font-size:14px;">
				<option value="post_type" <?php if(esc_attr( $instance['type'] ) =="post"){ print "selected";} ?>>Product/Listings</option>
                <option value="faq_type" <?php if(esc_attr( $instance['type'] ) =="faq"){ print "selected";} ?>>FAQ</option> 
				<option value="article_type" <?php if(esc_attr( $instance['type'] ) =="article"){ print "selected";} ?>>Articles</option>
                 
	</select><br />   
    
    
     <?php  }

	function update( $new, $old )
	{	
		$clean = $old; 
		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
		$clean['default'] = isset( $new['default'] ) ? strip_tags( esc_html( $new['default'] ) ) : '';
		$clean['btn'] = isset( $new['btn'] ) ? strip_tags( esc_html( $new['btn'] ) ) : '';
		$clean['type'] = isset( $new['type'] ) ? esc_attr( $new['type'] ) : '';
		
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$PPTDesign; $STRING = ""; extract($args);
	  
	echo $before_widget.str_replace("widget-box-id","ppt-widget-search",$before_title).$instance['title'].$after_title.'<div id="ppt-widget-search-box" >';
	
	 ?>
     <form method="get" action="<?php echo $GLOBALS['bloginfo_url']; ?>/" class="padding" name="quickSearchBox" id="quickSearchBox">
     <input type="hidden" name="post_type" value="<?php echo $instance['type']; ?>" />
     <a  class="button gray floatr" onclick="document.quickSearchBox.submit();"><?php echo $instance['btn']; ?></a>  
     
     <input type="text" value="<?php echo $instance['default']; ?>" name="s" id="s" onfocus="this.value='';"  />
            
             
     </form>
     <div class="clearfix"></div>
     <?php  echo '</div>'.$after_widget; 

}

}





















// hook everything up
add_action('init',         array('wf_ftw', 'init'));

/******************************************************************************/
 
   add_action( 'widgets_init', 'widgets_init' );
  
  function widgets_init() {
  
  
  	register_widget( 'PPT_Widgets_TAXOMONY' );  
  	//register_widget( 'PPT_Widgets_CATEGORIES' ); 
	register_widget( 'PPT_Widgets_CATEGORIES' );	
	register_widget( 'PPT_Widgets_FEATURED' );
 	register_widget( 'PPT_Widgets_SEARCH' );
	register_widget( 'PPT_Widgets_BUTTON' );
 
	register_widget( 'PPT_Widgets_ADVSEARCH' );
	 
	register_widget( 'PPT_Widgets_ARTICLES' );
	register_widget( 'PPT_Widgets_BLANK' );
	register_widget( 'PPT_Widgets_MAP' );
	
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress"  ){
	 register_widget( 'PPT_Widgets_EXPSOON' );
	
	}
	
	
    register_widget('fancy_text');
	//register_widget( 'Extended_Tags_Widget' );
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress" || strtolower(PREMIUMPRESS_SYSTEM) == "comparisonpress"){
	register_widget( 'PPT_Widgets_STORES' );
	}
	
	if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress"){
	
		register_widget( 'PPT_Widgets_CouponPress_POPULARCOUPONS' );
		
	
	}
	
  }  



 
?>