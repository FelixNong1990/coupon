<?php

class PremiumPress_Feed {

	function Add($ID){
 
	global $wpdb;
	// GET ALL FEED DATA
	$feeddata = get_option("feeddatadata");
	// GET SELECTED FEED
	$thisone = $feeddata[$ID];
	 
 	// CHECK FOR ERRORS
	if(!is_array($thisone)){ return "error:no feed data"; }
 	
	// GET FEED FILE
	if(isset($thisone['csv']) && strlen($thisone['csv']) > 1){
	$input = get_option('imagestorage_path').$thisone['csv'];
	}else{
	$input = $thisone['url'];
	}
 
	
	// GET A LIST OF ALL POSTS AND THEIR sku
	$SQL = "SELECT DISTINCT post_id, meta_value FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key = 'SKU'";
	$posts_with_SKU = $wpdb->get_results($SQL,ARRAY_A); 
 
	$count = $this->Get($ID, $input, $thisone, $posts_with_SKU, $feeddata);
	 
	return $count;
	
	}


	// THIS FUNCTION GETS THE FEED HEADERS AND THE
	// FIRST ROW FOR SAMPLE DATA SO THE USER CAN MAP THE
	// FIELDS
	function Get($type = "header", $input, $feeddata = "", $exists = "", $feeddataALL = ""){
	 
	 $saveme = array(); $i = 0; $row = 0; $counter = 0;
	 
	//1. IF INVALID FORMAT, GET IT	
	if($feeddata['format'] == ""){	$feeddata['format'] = $this->Format($input);	}
 
	//2. GET FILE TYPE
	$fb = explode("|",$feeddata['format']);
	$fc = count($fb)-1;
	 
	  	
	switch($fb[0]){
	
	case "csv": {
	  
		// OPEN FILE
		$handle = fopen($input, 'r');
			
		// LOOP THROUGH ALL CSV LINES
		while(!feof($handle)) {
			 
			//AUTO DETECT delimiter
			if(isset($feeddata['delimiter']) && strlen($feeddata['delimiter']) > 0 ){ $delimiter = $feeddata['delimiter']; }else{ $delimiter = ","; }			
			 
			// GET THE DATA FROM THE THIS LINE
			$line = fgetcsv($handle, 4096, $delimiter);	 
			 	
			// GET TITLES	
			if($row == 0){
					// SHOULD WE RETURN HEADERS
					$title = $line;					
					
			}else{
			 
				// RETURN IF WERE GETTING HEADERS ONLY
				if($type != '0' && $type == "header"){ 	
					foreach($line as $key){				 
						$saveme[$i]['key'] 		= $title[$i]; 
						$saveme[$i]['value'] 	= $key;
						$i++;
					}
					fclose($handle);
					return $saveme;
					//continue;
				}
				
				// FORMAT LINE SO IT LINKS TO MAPPED DATA
				$formattedarray = array(); $o=0;
				foreach($title as $t){			 	 
					$formattedarray[$t] = $line[$o];
					$o++;
				}
				// ADD NEW FEED TO DATABASE 
			 
				$this->AddFeedToDatabase($type, $formattedarray, $exists, $feeddataALL);
				$counter++;	 
			}			
 			 
		$row++;	
			
		}
		fclose($handle); 
	
	} break;
	
	case "xml":
	case "rss": {	 

	 
	$feed = simplexml_load_file($input);		
		
	// BUILD QUERY STRING		
	$str = "";
	for($i=1;$i < count($fb); $i++){ $fitems[] = $fb[$i];	}
	switch(count($fitems)){
	case 1: { $fstr = $feed->$fitems[0]; } break;
	case 2: { $fstr = $feed->$fitems[0]->$fitems[1]; } break;
	case 3: { $fstr = $feed->$fitems[0]->$fitems[1]->$fitems[2]; } break;
	case 4: { $fstr = $feed->$fitems[0]->$fitems[1]->$fitems[2]->$fitems[3]; } break;
	case 5: { $fstr = $feed->$fitems[0]->$fitems[1]->$fitems[2]->$fitems[3]->$fitems[4]; } break;
	default: { } break;	
	}

		if(isset($fstr)){
		 
			// OTHERWISE LOOP ALL DATA
			$saveme = array();
			foreach($fstr as $item){
			
			//die($type."<--".print_r($item));
			 
					foreach($item as $key=>$val){		
					$saveme[$i]['key'] 		= $key; 
					$saveme[$i]['value'] 	= str_replace("asdad!!33","",$val); 
					$i++;	
					}
					$row ++;
					
					if($type != '0' && $row == 1 && $type == "header"){
										 
						return $saveme;				
					}
					
					// CLEAN AND FORMAT ITEM DATA
					$formattedarray = array(); $o=0;
					foreach($item as $key => $val){
					$formattedarray[$key] = str_replace("!asdas#4","",$val); // get rif of object code
					$o++;
					}					
					// ADD NEW FEED TO DATABASE 
					$this->AddFeedToDatabase($type, $formattedarray, $exists, $feeddataALL);
					$counter++; 			
			}
		 
		}else{
		
		return "error:rss has no items";
		
		}
 
	} break;
	
	default: { return "error:invalid format"; }
	
	}// end switch
	
	return $counter;
			
	}

	function Format($input){
	
		$contents = ''; $format = '';
		
		if(strlen($input) < 8){ return; }
		
		if(substr($input,-3) == "csv"){ 
		
		return "csv|";
		
		}else{
		 
	 
		$xml = simplexml_load_file($input);
		
		 
		// CHECK FOR COMMON STRUCTURES
		if(isset($xml->channel->item)){
			$format = "channel|item";
		}elseif(isset($xml->channel)){
			$format = "channel";
		}elseif(isset($xml->rs->r)){
			$format = "rs|r";
		}elseif(isset($xml->Products->Product)){
			$format = "Products|Product";		 
		}elseif(isset($xml->products->product)){
			$format = "products|product";
		}elseif(isset($xml->Products)){
			$format = "Products";
		}elseif(isset($xml->Product)){
			$format = "Product";
		}elseif(isset($xml->product)){
			$format = "product";
		}
		
		
		// TRY TO AUTO DETECT
		if($format == ""){
			return "xml|unknown";		
		}

		return "xml|".$format; 
		
		}
	
	}

 	
	if(!defined('AddFeedToDatabase')){
	function AddFeedToDatabase($ID, $record, $exists, $feeddataALL){	
 
	 
	global $wpdb;$feeddata = $feeddataALL; $THISFEEDDATA = $feeddata[$ID]; $custom = array(); $updatemeFlag = false;
	 
	// CREATE NEW POST TO ADD TO DATABASE
	$my_post = array();
	$my_post['post_status'] = 'publish';
	$my_post['post_author'] = 1;
 
 	//if(is_array($THISFEEDDATA[$THISFEEDDATA['ID']])){ }else{ return; }
	//die(print_r($THISFEEDDATA[$THISFEEDDATA['ID']]));
	foreach($THISFEEDDATA[$THISFEEDDATA['ID']] as $key => $val){
		 //echo $key." -- ".$val."<br>";
		  
		if($val == "post_title"){
		$my_post['post_title'] = $record[$key];
		}elseif($val == "post_content"){
		$my_post['post_content'] = $record[$key];
		}elseif($val == "post_author"){
		$my_post['post_author'] = $record[$key];		
		}elseif($val == "post_status"){
		$my_post['post_status'] = $record[$key];
		}elseif($val == "post_type"){
		$my_post['post_type'] = $record[$key];
		}elseif($val == "post_date"){
		$my_post['post_date'] = $record[$key];	
		}elseif($val == "post_excerpt"){
		$my_post['post_excerpt'] = $record[$key]; 
		}elseif($val == "price"){
		$custom['price'] = $record[$key];	
		}elseif($val == "link"){
		$custom['link'] = $record[$key];
		}elseif($val == "old_price"){
		$custom['old_price'] = $record[$key];
		}elseif($val == "image"){
		$custom['image'] = $record[$key];
		
		}elseif($val == "SKU"){
		
		// CHECK THIS SKU ISNT ALREADY IN OUR DATABASE
		foreach($exists as $skuval){			
			if($skuval['meta_value'] == $record[$key]){						
				$my_post['ID'] = $skuval['post_id'];						 
			}			
		}		
		$custom['SKU'] = $record[$key];		
		}elseif($val == "custom"){
		$custom[$key] = $record[$key];
		}elseif($val == "category"){
		 
			//loop is multiple
			$cats = explode(",",$record[$key]);
			if(!isset($cats[1])){
			$cats = explode(">>",trim($cats[0]));
			}
			
			$catStr = "";
			if(is_array($cats)){
			
				foreach($cats as $cat){ 
				
				if(strlen($cat) > 1){				
					$cat = trim($cat);				
					if ( is_term( $cat , 'category' ) ){
						 $term = get_term_by('name', str_replace("_"," ",$cat), 'category');	
						 if(strlen($term->term_id) > 1){				 
							 $catStr .= $term->term_id.",";
						 }// end if
						 						
					}else{
						$args = array('cat_name' => str_replace("_"," ",$cat) ); 
						$term = wp_insert_term(str_replace("_"," ",$cat), 'category', $args);
						if(strlen($term->term_id) > 1){				 
							$catStr .= $term->term_id.",";
						}
					} // end if	
				  } // end if	
				 }// end foreach
		 
		 	}			
			
			$catStr = substr($catStr,0,-1);
			
			$my_post['post_category'] 	= explode(",",$catStr);
		 
		}else{
			//die($val."--".$key);
			$custom[$val] = $record[$key];
		} 
	}
	
	if(!isset($my_post['post_category']) || empty($my_post['post_category']) ){

	$my_post['post_category'] = array($THISFEEDDATA['category']);
	
	}
	
		//die(print_r($my_post).print_r($custom));
	// Insert the post into the database
	if(isset($my_post['post_title']) && strlen($my_post['post_title']) > 1){ 

		if(!isset($my_post['ID'])){
		// INSERT NEW POST
		$POSTID = wp_insert_post( $my_post );
		}else{
		wp_update_post( $my_post );
		$POSTID = $my_post['ID'];
		}
		
		// ADD ON CUSTOM FIELDS 
		if(is_array($custom)){  
		
			 foreach($custom as $key=>$val){
			 update_post_meta($POSTID, $key, $val);
			 }
		 }// end if		 
	}// end if
	
}
}
	


}
?>