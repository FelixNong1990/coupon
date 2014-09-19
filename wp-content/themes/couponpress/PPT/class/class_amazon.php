<?php
class AmazonProductAPI {


// TEST RUN THE IMPORT TOOL
function AmazonRunSearch($RunID=0){
	
	global $wpdb, $PPTImport;
		$mA 						= array();
	$ASS 						= get_option("AmazonSavedSearch_Data");
	$ASS_TOTAL_NEW 				= 0;
	
	// LETS LOOP THROUGH AND FIND THE ONE WE WANT TO
	// TEST RUN
	foreach($ASS as $inArray){
			 
		if($ASS_TOTAL_NEW == $RunID){
			$mA = array(0 => $inArray);			 ;			 
			$this->amazon_dreepfeed($inArray['time'],$mA);				 
		}				
			 
	$ASS_TOTAL_NEW++;
	}
	
} // end test run
	
	

// SAVE NEW AUTOMATIC SEARCH
function AmazonSavedSearch(){

		global $wpdb;
	
		$ASS 						= array();
		$ASS 						= get_option("AmazonSavedSearch_Data");
		$ASS_TOTAL 					= get_option("AmazonSavedSearch_Total");
	 
		if($ASS_TOTAL == "" || $ASS_TOTAL < 1){$ASS_TOTAL = 0;	}else{	$ASS_TOTAL++;	}

		$ASS[$ASS_TOTAL]['name'] 	= $_POST['amazon']['keyword'];
		$ASS[$ASS_TOTAL]['time'] 	= $_POST['schedule']['time'];
		$ASS[$ASS_TOTAL]['total'] 	= 0;
		$ASS[$ASS_TOTAL]['last'] 	= "Never";
		$ASS[$ASS_TOTAL]['status'] 	= "Running";
		$ASS[$ASS_TOTAL]['cat'] 	= $_POST['cat'];

		foreach($_POST['amazon'] as $key => $val){	
			$ASS[$ASS_TOTAL][$key] 	= $val; 	
		}		

		$ASS_TOTAL++;
		update_option("AmazonSavedSearch_Total",$ASS_TOTAL);
		update_option("AmazonSavedSearch_Data",$ASS);		
	
} // end save search
 
	
function amazon_dreepfeed($ActionTime="hourly", $thisArray="") {

	global $wpdb;
		
	$STROED_ARRAY = get_option("AmazonSavedSearch_Data");
	$MOD_ARRAY = $STROED_ARRAY;	
	// ARE WE PASSING IN ALL VALUES OR JUST 1 FOR TESTING?	
	if(is_array($thisArray)){
		$ASS 						= $thisArray; 
	}else{
		$ASS 						= $STROED_ARRAY;
	} 
 
	// MAKE SURE VALID ARRAY OF SAVED SEARCHES 
 	if(is_array($ASS)){
		
		if(isset($_GET['runnow'])){ $ACC = $_GET['runnow']; }else{$ACC	= 0; }
		
		foreach($ASS as $SearchArray){ 
		
		 //echo $ACC." -- ".$SearchArray['keyword']."<br>";
 
			if($SearchArray['time'] == $ActionTime){
 
				if($SearchArray['keyword'] != ""){		
 
						$importcounter 					= 0;
						$_POST['amazon'] 				= $SearchArray;
						$_POST['amazon']['keyword'] 	= $SearchArray['keyword'];
						$_POST['amazon']['keyword_cat'] = $SearchArray['keyword_cat'];
						$_POST['amazon']['cat'] 		= $SearchArray['cat'];
	
						try
						{
						
						//die($_POST['amazon']['keyword']."<--".$_POST['amazon']['keyword_cat']."<-- cat ~ site -->".print_r($_POST['amazon']));
							$result = $this->searchProducts($_POST['amazon']['keyword'],$_POST['amazon']['keyword_cat'],$_POST['amazon']);			
							$SEARCHSTATUS = "Running";						
							//print_r($result->Items->TotalResults);	 
					
						}
						catch(Exception $e)
						{
							$SEARCHSTATUS = "Finished (".$e->getMessage().")";
						}  

						$importcounter = AmazonSearchSave($result);
				 			
 					 
				}else{

					$SEARCHSTATUS = "Finished (No Keyword Entered)";

				} // end keyword if 
				 
						
			}// end if
			
			
			// NOW WE HAVE FINISHED THE SEARCH AND IMPORT
			// WE NEED TO REBUILD THE ARRAY SO THE SYSTEM CAN
			// DO ANOTHER SEARCH STARTING FROM THE NEXT PAGE
	 
			foreach($SearchArray as $key => $val){
			 
			   if($key == "last" && ( $SearchArray['time'] == $ActionTime ) ) {
			  
					$MOD_ARRAY[$ACC]['last'] = date('l jS \of F Y h:i:s A'); /// set the last import date
				 
				}elseif($key == "total" && ( $SearchArray['time'] == $ActionTime || isset($_GET['runnow']) ) ){
					
					$MOD_ARRAY[$ACC]['total'] = $MOD_ARRAY[$ACC]['total'] + $importcounter;	 // add on new import count			 
						 
				}elseif($key == "status" && ( $SearchArray['time'] == $ActionTime ) ){
					
					$MOD_ARRAY[$ACC]['status'] = $SEARCHSTATUS;	 // set running status
						 
				}elseif($key == "start_page" && ( $SearchArray['time'] == $ActionTime ) ){				
					 
					$MOD_ARRAY[$ACC]['start_page'] = $MOD_ARRAY[$ACC]['start_page'] + 1; // update start page		
						
				}// end if	 
					
			}// end update foreach loop
			
			$ACC++;	
				 
			
		} // end foreach loop
 	
 
		// SAVE NEW ARRAY
		update_option("AmazonSavedSearch_Data",array_values($MOD_ARRAY));
	
		
	} // end is array
 
	
return $importcounter;
	
}


function AmazonAutoUpdaterTool($echo=true){
	
		global $PPT, $wpdb;
		require_once (TEMPLATEPATH ."/PPT/class/class_amazon.php");
		 
		$LASTID = get_option("amazon_updater_lastId"); $aa=0;
		
		if($LASTID ==""){ $LASTID=0; }
		$country = get_option('enabled_amazon_updater_country');
		if($country == ""){$country="com"; }
		$EXTRA = " AND $wpdb->posts.ID > ".$LASTID;
		
		$SQL = "SELECT $wpdb->posts.ID, $wpdb->postmeta.meta_value AS GUID FROM $wpdb->posts
		LEFT JOIN $wpdb->postmeta ON ($wpdb->postmeta.post_id =  $wpdb->posts.ID)
		WHERE $wpdb->postmeta.meta_key = 'amazon_guid' AND $wpdb->posts.post_status='publish'
		".$EXTRA."		 
		GROUP BY $wpdb->posts.ID 
		ORDER BY $wpdb->posts.ID ASC
		LIMIT 20";
		 
		
		//print "<div style='padding:10px; background:#efefef; border:1px solid #ddd; margin-bottom:40px;'>SQL: ".$SQL."</div>";
		
		if($echo){ print "<h2>Showing 20 products per page, starting at post ID ".$LASTID."</h2><p>Refresh the page again to view the next 20</p>"; }

		$results = (array)$wpdb->get_results($SQL);
		
		if(is_array($results) && !empty($results)){		 
		
		foreach($results as $value){
		
			$counter = 0;
			
			if(get_post_meta($value->ID, "amazon_noupdate", true) != "yes"){
			 
				$obj = new AmazonProductAPI();
					//die($value->GUID." ".$country);
				try {
					
					$item = $obj->getItemByAsin($value->GUID,$country);	
					
				} catch(Exception $e){
					
					//mysql_query("UPDATE ".$wpdb->prefix."posts SET 	post_status='draft'		WHERE ".$wpdb->prefix."posts.ID='".$value->ID."' LIMIT 1"); 
			
					if($echo){ print str_replace("h1","span",$e->getMessage()); } // else { return $e->getMessage(); }
					$aa++;
					//return;
					
					continue;
							
				} 
					
					 
					
								
					$val = $item->Items->Item;
					
				
					$data['old_price'] 		= "";
					$data['price']			= str_replace("!!aaqq","",$val->ItemAttributes->ListPrice->Amount);	 				
				
					if($data['price'] == ""){
						$data['price'] = str_replace("!!aaqq","",$val->OfferSummary->LowestNewPrice->Amount);
					}
					
					if(isset($val->Offers->Offer->OfferListing->Price->Amount) && strlen($val->Offers->Offer->OfferListing->Price->Amount) > 1){
					
							$data['old_price'] = $data['price'];
							$data['price'] 	=  str_replace("!!aaqq","",$val->Offers->Offer->OfferListing->Price->Amount);	
					}	
				 
					// Load price options
					if($country == "jp"){
					
					}else{
						$data['old_price'] = substr($data['old_price'],0, -2).".".substr($data['old_price'],-2);
						if($data['old_price'] == "."){ $data['old_price']=""; }
						$data['price'] = substr($data['price'],0, -2).".".substr($data['price'],-2);
					}
					
					// PRICE IS THE WRONG WAY AROUND
					if($data['old_price'] !="" && $data['old_price'] < $data['price']){	 
						$s1 = $data['price'];
						$data['price'] = $data['old_price'];
						$data['old_price'] =  $s1;
					}
		  
		  
		  
				 
					if($data['price'] > 0 && $data['price'] != get_post_meta($value->ID, 'price', true)){
						$change=1;
						update_post_meta($value->ID, 'price', $data['price']);					 
					
					}
					
					if($data['old_price'] > 0 && $data['old_price'] != $data['price'] && $data['old_price'] != get_post_meta($value->ID, 'old_price', true)){
					$change=1;
					update_post_meta($value->ID, 'old_price', $data['old_price']); 
					
					}
					
					
		
		
					
					
		if($change == 1){ $counter++;
		
		if($echo){ echo "<div style='padding:10px; background:#aadcfb; border:1px solid #1d78b0; margin-bottom:10px; clear:both;'>"; }
		
		}else{
		
		if($echo){ echo "<div style='padding:10px; background:#e7ffcc; border:1px solid #88c446; margin-bottom:10px; clear:both;'>"; }
		
		}	
				
		if($echo){ echo '<img src="'.premiumpress_image($value->ID,"full") .'" style="float:left; max-width:80px; max-height:80px; padding-right:30px; padding-bottom:20px;">'; }
					
		if($echo){ echo "<h3>Checking for product changes...</h3> 
		
		<p>(<a href='".get_bloginfo('url')."/?p=".$value->ID."' target='_blank'>view product</a> / <a href='post.php?post=".$value->ID."&action=edit' target='_blank'>edit product</a>)</p> <p>"; }
					
		
		if($change == 1){
					
					if($echo){ print " price is now ".$data['price']." old price is ".$data['old_price']; }
					
					}else{
					if($echo){ echo "... no changes found."; }
					}
					
					$change=0;
					
					
					if($echo){ print " </p><div style='clear:both'></div></div>"; }
					$LASTPOSTiDME = $value->ID;
					unset($value);
 					
			}else{
			
			if($echo){ print "No Update flag set, skipping product update."; }
			
			
			}
					
				$aa++;
			
			}
			
			
			if($aa > 1){
			update_option("amazon_updater_lastId", $LASTPOSTiDME);
			}else{
			update_option("amazon_updater_lastId", "0");
			}
			
			
			 
			
		
		}else{
			update_option("amazon_updater_lastId", 0);
		} 
		
	
		
		if($aa == 20){
?>

 <script language="JavaScript">
var countDownInterval=20;
var c_reloadwidth=200
</script>
<ilayer id="c_reload" width=&{c_reloadwidth}; ><layer id="c_reload2" width=&{c_reloadwidth}; left=0 top=0></layer></ilayer>
<script>

var countDownTime=countDownInterval+1;
function countDown(){
countDownTime--;
if (countDownTime <=0){
countDownTime=countDownInterval;
clearTimeout(counter)
window.location.reload()
return
}
if (document.all) //if IE 4+
document.all.countDownText.innerText = countDownTime+" ";
else if (document.getElementById) //else if NS6+
document.getElementById("countDownText").innerHTML=countDownTime+" "
else if (document.layers){ //CHANGE TEXT BELOW TO YOUR OWN
document.c_reload.document.c_reload2.document.write('Next <a href="javascript:window.location.reload()">refresh</a> in <b id="countDownText">'+countDownTime+' </b> seconds')
document.c_reload.document.c_reload2.document.close()
}
counter=setTimeout("countDown()", 1000);
}

function startit(){
if (document.all||document.getElementById) //CHANGE TEXT BELOW TO YOUR OWN
document.write('Automatic <a href="javascript:window.location.reload()">refresh</a> in <b id="countDownText">'+countDownTime+' </b> seconds')
countDown()
}

if (document.all||document.getElementById)
startit()
else
window.onload=startit

</script>
<?php 
		}else{
		
			if($echo){ print "..finished"; }
		}
	
return $counter;


}	
 	

function AmazonDeleteSearch($id=0){

		global $wpdb;
	
		$ASS_NEW 					= array();
		$ASS 						= get_option("AmazonSavedSearch_Data");
		$ASS_TOTAL 					= get_option("AmazonSavedSearch_Total");		
		$ASS_TOTAL_NEW 				= 0;

		delete_option("AmazonSavedSearch_Data");
		delete_option("AmazonSavedSearch_Total");
 
		foreach($ASS as $inArray){		
		if($ASS_TOTAL_NEW != $id){
			foreach($inArray as $key => $val){		
				$ASS_NEW[$ASS_TOTAL_NEW][$key] 	= $val; 		
			}
		}
		$ASS_TOTAL_NEW++;
		}

		update_option("AmazonSavedSearch_Data",$ASS_NEW);
		update_option("AmazonSavedSearch_Total",count($ASS_NEW));
	
	} 
       
        /**
         * Check if the xml received from Amazon is valid
         * 
         * @param mixed $response xml response to check
         * @return bool false if the xml is invalid
         * @return mixed the xml response if it is valid
         * @return exception if we could not connect to Amazon
         */
        private function verifyXmlResponse($response)
        {
            if ($response === False)
            {
                throw new Exception("Could not connect to Amazon");
            }
            else
            {
 
				if (isset($response->Items->Item->ItemAttributes->Title))
                {
                    return ($response);
                
                }elseif (isset($response->Cart))
                {
                    return ($response);
                }
				elseif(isset($response->Items->Request->Errors->Error->Message)){
				throw new Exception("<h1>There was an error but don't panic..</h1><p>".$response->Items->Request->Errors->Error->Message[0]."</p>");
				}
                else
                {
                    throw new Exception("<h1>We did not find any matches for your request</h1>");
                }
            }
        }
        
        
        /**
         * Query Amazon with the issued parameters
         * 
         * @param array $parameters parameters to query around
         * @return simpleXmlObject xml query response
         */
        private function queryAmazon($parameters, $country="com")
        {
            return aws_signed_request($country, $parameters);
        }
        
        
        /**
         * Return details of products searched by various types
         * 
         * @param string $search search term
         * @param string $category search category         
         * @param string $searchType type of search
         * @return mixed simpleXML object
         */
        public function searchProducts($search, $category, $values)
        { 
		
		if(strlen($values['minprice']) > 1){
		$values['minprice'].="00";
		}
		
		if(strlen($values['maxprice']) > 1){
		$values['maxprice'].="00";
		}
 
		if($category =="All"){
		$parameters = array(
		"Operation"  	=> "ItemSearch",
		"Keywords" 		=> $search,
		"SearchIndex"   => $category,
		"ResponseGroup" => "ItemAttributes,Offers,Images,EditorialReview,Reviews",
		"MinimumPrice" 	=> $values['minprice'],
		"MaximumPrice" 	=> $values['maxprice'],
		"ItemPage" 		=> $values['start_page'],
		"Brand"	 		=> $values['brand'],		
		"Condition" 	=> $values['condition'], 
		//"Sort" 			=> $values['Sort'],
		//"MerchantId"	=> $values['merchantid']
		);
		}else{
		$parameters = array(
		"Operation"  	=> "ItemSearch",
		"Title" 		=> $search,
		"SearchIndex"   => $category,
		"ResponseGroup" => "ItemAttributes,Offers,Images,EditorialReview,Reviews",
		"MinimumPrice" 	=> $values['minprice'],
		"MaximumPrice" 	=> $values['maxprice'],
		"ItemPage" 		=> $values['start_page'],
		"BrowseNode"	=> $values['node'],
		"Brand"	 		=> $values['brand'],
		"Condition" 	=> $values['condition'],
		"Sort" 			=> $values['Sort'],
		"MerchantId"	=> $values['merchantid']);
		}
		
		
		
		//die(print_r($parameters));
		 
             
            $xml_response = $this->queryAmazon($parameters, $values['country']);
            
            return $this->verifyXmlResponse($xml_response);

        }
        
        
        /**
         * Return details of a product searched by UPC
         * 
         * @param int $upc_code UPC code of the product to search
         * @param string $product_type type of the product
         * @return mixed simpleXML object
         */
        public function getItemByUpc($upc_code, $product_type)
        {
            $parameters = array("Operation"     => "ItemLookup",
                                "ItemId"        => $upc_code,
                                "SearchIndex"   => $product_type,
                                "IdType"        => "UPC",
                                "ResponseGroup" => "Medium");
                                
            $xml_response = $this->queryAmazon($parameters);
            
            return $this->verifyXmlResponse($xml_response);

        }
        
        
        /**
         * Return details of a product searched by ASIN
         * 
         * @param int $asin_code ASIN code of the product to search
         * @return mixed simpleXML object
         */
        public function getItemByAsin($asin_code, $country)
        {
		 
            $parameters = array("Operation"     => "ItemLookup",
                                "ItemId"        => $asin_code,
                                "ResponseGroup" => "ItemAttributes,Offers,Images,EditorialReview,Reviews");
                                
            $xml_response = $this->queryAmazon($parameters, $country);
            
            return $this->verifyXmlResponse($xml_response);
        }
        
        
        /**
         * Return details of a product searched by keyword
         * 
         * @param string $keyword keyword to search
         * @param string $product_type type of the product
         * @return mixed simpleXML object
         */
        public function getItemByKeyword($keyword, $product_type)
        {
            $parameters = array("Operation"   => "ItemSearch",
                                "Keywords"    => $keyword,
                                "SearchIndex" => $product_type);
                                
            $xml_response = $this->queryAmazon($parameters);
            
            return $this->verifyXmlResponse($xml_response);
        }

 

        public function CreateCart($parameters,$country="com")
        {
           
                                
            $xml_response = $this->queryAmazon($parameters,$country);
            
            return $this->verifyXmlResponse($xml_response);

        }

}
?>