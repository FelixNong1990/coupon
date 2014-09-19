<?php if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $wpdb; global $PPT;  

if(isset($_GET['expireme']) && $_GET['expireme'] == 1 && is_numeric($_GET['pid']) ){

	$PPT->Expired(array($_GET['pid'],""),true);

	$GLOBALS['error'] 		= 1;
	$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
	$GLOBALS['error_msg'] 	= "Listing Expired Successfully";
	
	if($GLOBALS['error'] == 1){ ?><div class="msg msg-<?php echo $GLOBALS['error_type']; ?>"><p><?php echo $GLOBALS['error_msg']; ?></p></div> <?php  }

}

PremiumPress_Header();

 
// ADJUSTMENTS FOR THOSE RUNNING OLDER COPIES 
if(get_option("ppt_update_7_1_1") == ""){

	update_option("ppt_update_7_1_1","1"); 

	// LOOP THROUGH ALL CATEGORIES AND UPDATE DESCRIPTION 
	$catlist="";
 	$Maincategories = get_categories('use_desc_for_title=1&hide_empty=0&hierarchical=0');		
	$Maincatcount = count($Maincategories);	 
	foreach ($Maincategories as $Maincat) { 
		if($Maincat->parent ==0){			
			$text = get_option("cat_extra_text_".$Maincat->term_id);
			if($text != ""){
					wp_update_term($Maincat->term_id, 'category', array(
					  'description' =>  $text, 
					));	
			}
		} 
 	}
	
	if( strtolower(PREMIUMPRESS_SYSTEM) == "couponpress" ){
	
	
	}
}


 
if( strtolower(PREMIUMPRESS_SYSTEM) == "auctionpress" &&  get_option("ppt_load_bidtable") == ""){

	update_option("ppt_load_bidtable","1"); 
	 
	mysql_query("CREATE TABLE  `".$wpdb->prefix."bidhistory` (
	`ID` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  `bid_date` datetime NOT NULL,
  `bid_amount` float NOT NULL,
  `bid_type` varchar(10) NOT NULL,  
  `bid_comments` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`))");

}


if( strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" &&  get_option("ppt_load_countries") == ""){
update_option("ppt_load_countries","1");


	mysql_query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."orderdata` (
  `autoid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `cus_id` varchar(10) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `order_ip` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_data` longtext NOT NULL,
  `order_items` longtext NOT NULL,
  `order_address` blob NOT NULL,
  `order_addressShip` blob NOT NULL,
  `order_country` varchar(150) NOT NULL,
  `order_email` varchar(255) NOT NULL,
  `order_total` varchar(10) NOT NULL,
  `order_subtotal` varchar(10) NOT NULL,
  `order_tax` varchar(10) NOT NULL,
  `order_coupon` varchar(10) NOT NULL,
  `order_couponcode` varchar(100) NOT NULL,
  `order_currencycode` varchar(10) NOT NULL,
  `order_shipping` varchar(10) NOT NULL,
  `order_status` int(1) NOT NULL DEFAULT '0',
  `cus_name` varchar(100) NOT NULL,
  `payment_data` blob NOT NULL,
  PRIMARY KEY (`autoid`))");
  
}




  
  
 


function createDateRangeArray($strDateFrom,$strDateTo) {

 $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}
 
function ppt_chardata($query=0,$return=false){
 
	global $wpdb; $STRING = "";
	 
	$DATE1 = date("Y-m-d",mktime(0, 0, 0, date("m")-1  , date("d")+10, date("Y")));
	$DATE2 = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));	
	
	$dates = createDateRangeArray($DATE1,$DATE2); 
	$newdates = array();
	foreach($dates as $date){	  
	 $newdates[''.$date.''] = 0;
	}
 
	if($return)return $newdates;
 
	// GET ALL DATA FOR THE LAST 31 DAYS
	if($query == 0){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date from ".$wpdb->prefix."posts where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' GROUP BY ID";
 
	}elseif($query == 1){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='1' GROUP BY ID";
	}elseif($query == 2){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='2' GROUP BY ID";
	}elseif($query == 3){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='3' GROUP BY ID";
	}elseif($query == 4){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='4' GROUP BY ID";
	}elseif($query == 5){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='5' GROUP BY ID";
	}elseif($query == 6){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='6' GROUP BY ID";
	}elseif($query == 7){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='7' GROUP BY ID";
	}elseif($query == 8){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND post_type='post' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='8' GROUP BY ID";
	}elseif($query == 9){
	 $SQL1 = "SELECT order_date AS post_date FROM ".$wpdb->prefix."orderdata LEFT JOIN ".$wpdb->prefix."users ON (".$wpdb->prefix."users.ID = ".$wpdb->prefix."orderdata.cus_id) WHERE ".$wpdb->prefix."orderdata.order_date >= '".$DATE1."' and ".$wpdb->prefix."orderdata.order_date < '".$DATE2."'"; 
	 
	}
 
 
	$data = $wpdb->get_results($SQL1);
	
	foreach($data as $value){	 
	  $postDate = explode(" ",$value->post_date);	 
		$newdates[$postDate[0]] ++;
	}	 
	 
	// FORMAT RESULTS FOR CHART	
	$i=1;  
	foreach($newdates as $key=>$val){
		$a = $key; 
		if(!is_numeric($val)){$val=0; }
		 	
		$STRING .= '['.$i.','.$val.'], ';
		$i++;		 
	}
	// RETURN DATA	
	return $STRING;
 
}


function TableDataO($q){

global $wpdb, $PPTDesign; $STRING = "";

	if($q == 1){
		
	 $posts = query_posts( "meta_key=hits&orderby=meta_value_num&order=DESC&showposts=10" );
	 
	}elseif($q == 2){
	 
	 $posts = query_posts( "meta_key=hits&orderby=meta_value_num&order=ASC&showposts=10" );
	
	}elseif($q == 3){

	$SQL = "SELECT * FROM ".$wpdb->prefix."postmeta LEFT JOIN ".$wpdb->prefix."posts ON ( ".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id ) 
	WHERE ".$wpdb->prefix."postmeta.meta_key = 'expires' AND ".$wpdb->prefix."postmeta.meta_value !=''
	AND  ".$wpdb->prefix."posts.post_status = 'publish' AND  ".$wpdb->prefix."posts.post_type = 'post'
	ORDER BY ".$wpdb->prefix."postmeta.meta_value ASC LIMIT 10";  // ON ($wpdb->users.ID =  
	$posts = $wpdb->get_results($SQL);
 	 
	}
	 
	foreach($posts as $post){
	
	if($q == 3){
	
	$exp = get_option("feature_expiry");
	if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "auctionpress"){ $exp = "no"; }
	
	$hits1 = date('Y-m-d h:i:s',strtotime(date("Y-m-d h:i:s", strtotime($post->post_date)) . " +".$post->meta_value." days"));
 
	//$desc = substr(strip_tags($post->post_excerpt),0,200)."...";
	$desc  = "Created: ".date("Y-m-d h:i:s", strtotime($post->post_date))."</br>";
	$desc .= "Expiry Period: ".$post->meta_value." days</br>";
	$desc .= "Expiry Date: ".$hits1."</br>";
	$desc .= "<b>".$PPTDesign->TimeDiff(date('Y-m-d H:i:s',strtotime($hits1)),2)."</b>";
 	}else{
	
	$hits = get_post_meta($post->ID, 'hits', true);
	$desc = substr(strip_tags($post->post_excerpt),0,200)."...";
	
	}
		 
	 $STRING .= '
		<tr class="first">
		<td style="width:200px;"><b>'.$post->post_title.'</b></td>
		<td>'.$desc.'</td> ';
		if($q != 3){ 
		$STRING .= '<td style="text-align:center !important;">'.$hits.'</td>'; 
		} 
		$STRING .= '<td class="tc">
		<a href="post.php?post='.$post->ID.'&action=edit" class="premiumpress_button" target="_blank">Edit</a> | <a href="'.get_permalink($post->ID).'" class="premiumpress_button" target="_blank">View</a>
		';
		if($q == 3 && $exp == "yes"){ 
		$STRING .= ' | <a href="admin.php?page=ppt_admin.php&expireme=1&pid='.$post->ID.'" class="premiumpress_button">Expire Now</a>';
		}
		 
		$STRING .= '</td></tr>';
		
	}
	// Reset Query
	wp_reset_query();

	return $STRING;

}  


// LOAD IN DATA VALUES
$packdata = get_option("packages");
$CURRENCYCODE = get_option('currency_code');
$CURRENCYPOST = get_option('display_currency_position');


 
?>


<style>
.info { font-size:13px; background:inherit; }
.info legend { font-weight:bold; }
.info dl {  clear:both;  width:100%;  height:8em; }
.info dt {  font-weight:bold;}
.info dd {    margin:0;}
.info ul { margin-left:0px; }
.info ul.first {  counter-reset:item 0; }
.info ul.second {  counter-reset:item 5;  } 
.info ul li { width:180px; float:left; margin-bottom:20px;   }
.popularup li { background: url('<?php echo PPT_THEME_URI; ?>/PPT/img/arrow_up.png') top left no-repeat;  padding-left:22px; }
.populardown li { background: url('<?php echo PPT_THEME_URI; ?>/PPT/img/arrow_down.png') top left no-repeat; padding-left:22px; }
.orders li { background: url('<?php echo PPT_THEME_URI; ?>/PPT/img/money.png') top left no-repeat;  padding-left:22px; }
.users li { background: url('<?php echo PPT_THEME_URI; ?>/PPT/img/admin/smembers.png') top left no-repeat;  padding-left:22px; } 
 /*Big buttons with icons*/
.bigBtnIcon {list-style: none; margin:0; padding:0;  position:relative; text-align: center; margin-top:20px; }
	.bigBtnIcon li {
		text-align: center;
		margin-right:14px;
		margin-bottom: 13px;
		display: inline-block;
	}
		.bigBtnIcon li a {
			border: 1px solid #c4c4c4;
			border-radius: 2px;
			-webkit-border-radius: 2px;
			-moz-border-radius: 2px;
			padding:5px;
			background: rgb(255,255,255);
 
			background: -moz-linear-gradient(top,  rgba(255,255,255,1) 1%, rgba(243,243,243,1) 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,rgba(255,255,255,1)), color-stop(100%,rgba(243,243,243,1)));
			background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 1%,rgba(243,243,243,1) 100%);
			background: -o-linear-gradient(top,  rgba(255,255,255,1) 1%,rgba(243,243,243,1) 100%);
			background: -ms-linear-gradient(top,  rgba(255,255,255,1) 1%,rgba(243,243,243,1) 100%);
			background: linear-gradient(top,  rgba(255,255,255,1) 1%,rgba(243,243,243,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f3f3f3',GradientType=0 );
			position: relative;
			-moz-box-shadow:0 1px 0px rgba(255, 255, 255, 1);
			-webkit-box-shadow: 0 1px 0px rgba(255, 255, 255, 1);
			box-shadow: 0 1px 0px rgba(255, 255, 255, 1);
			text-decoration: none;
			width: 90px;
			height: 60px;
			display: inline-block;
		}
		.bigBtnIcon li a:after {
			content:"";
			width: 98px;
			height: 68px;
			border:1px solid #fff;
			border-radius: 2px;
			-webkit-border-radius: 2px;
			-moz-border-radius: 2px;
			position: absolute;
			top:0;
			left:0;
		}
		.bigBtnIcon li a:hover {
			-moz-box-shadow:0px 0px 3px rgba(0, 0, 0, 0.2);
			-webkit-box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.2);
			box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.2);
			border-color: #a5a5a5;
			-webkit-transition: all 0.5s ease;
			-moz-transition: all 0.5s ease;
			-ms-transition: all 0.5s ease;
			-o-transition: all 0.5s ease;
			transition: all 0.5s ease;
		}
		 
		.bigBtnIcon li a .icon { font-size: 26px; width: 100%; margin: 0; display: inline-block;}
		.bigBtnIcon li a .txt {line-height: 12px; text-align: center; font-size: 12px;}
		.bigBtnIcon li a .notification {padding: 0 6px 1px 6px; z-index: 999} 
		.bigBtnIcon .d1 { background: url('<?php echo PPT_FW_IMG_URI; ?>admin/d1.png') 30px 0px no-repeat; height: 32px; width: 32px;}
		.bigBtnIcon .d2 { background: url('<?php echo PPT_FW_IMG_URI; ?>admin/d2.png') 30px 0px no-repeat; height: 32px; width: 32px;}
		.bigBtnIcon .d3 { background: url('<?php echo PPT_FW_IMG_URI; ?>admin/_ad_orders.png') 30px 0px no-repeat; height: 32px; width: 32px;}
		.bigBtnIcon .d4 { background: url('<?php echo PPT_FW_IMG_URI; ?>admin/d4.png') 30px 0px no-repeat; height: 32px; width: 32px;}
		.bigBtnIcon .d5 { background: url('<?php echo PPT_FW_IMG_URI; ?>admin/d5.png') 30px 0px no-repeat; height: 32px; width: 32px;}
		.bigBtnIcon .d6 { background: url('<?php echo PPT_FW_IMG_URI; ?>admin/d6.png') 30px 0px no-repeat; height: 32px; width: 32px;}
		/*Red style*/
.notification {
	padding:0px 7px 0px 7px; 
	color:#fff;
	background: #ed7a53;
	border-radius:2px;
	-webkit-border-radius:2px;
	-moz-border-radius:2px;
	font-weight:700;
	font-size:12px;
	font-family: Tahoma;
	position: absolute;
	top:-11px;
	right:-10px;
	-webkit-box-shadow:  0px 1px 0px 0px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 0px 1px 0px 0px rgba(0, 0, 0, 0.2);
    box-shadow:  0px 1px 0px 0px rgba(0, 0, 0, 0.2);
    text-shadow:none;
}

.notification.green {background: #9fc569;}/*green style*/
.notification.blue { background: #88bbc8;}/*blue style*/
</style>
<script language="javascript" type="text/javascript" src="<?php echo PPT_THEME_URI; ?>/PPT/js/jquery.flot.min.js"></script>
    
    
 
   

<div class="premiumpress_box altbox"><div class="premiumpress_boxin">
<div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/new/block7.png" align="middle"> Website Summary </h3>							
</div>
 
<div style="background:url('<?php echo PPT_THEME_URI; ?>/PPT/img/content_pane-gradient.gif') bottom left repeat-x; border-bottom:1px solid #ddd; ">
 <br />
<div id="placeholder" style="width:800px;height:300px; margin-left:20px; margin-bottom:20px; margin-top:10px;"></div>
 

 
<script type="text/javascript">
jQuery(function () {
        
    var datasets = {
        "a": {
            label: "New Listings",
            data: [<?php echo ppt_chardata(0); ?>]
        },
		<?php if(isset($packdata[1]['enable']) && $packdata[1]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "b": {
            label: "<?php echo strip_tags($packdata[1]['name']); ?>",
            data: [<?php echo ppt_chardata(1); ?>]
        },
		<?php } ?>		 
		<?php if(isset($packdata[2]['enable']) && $packdata[2]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "c": {
            label: "<?php echo strip_tags($packdata[2]['name']); ?>",
            data: [<?php echo ppt_chardata(2); ?>]
        },
		<?php } ?>
		<?php if(isset($packdata[3]['enable']) && $packdata[3]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "d": {
            label: "<?php echo strip_tags($packdata[3]['name']); ?>",
            data: [<?php echo ppt_chardata(3); ?>]
        },
		<?php } ?>		
		<?php if(isset($packdata[4]['enable']) && $packdata[4]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "e": {
            label: "<?php echo strip_tags($packdata[4]['name']); ?>",
            data: [<?php echo ppt_chardata(4); ?>]
        },
		<?php } ?>
		<?php if(isset($packdata[5]['enable']) && $packdata[5]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "f": {
            label: "<?php echo strip_tags($packdata[5]['name']); ?>",
            data: [<?php echo ppt_chardata(5); ?>]
        },
		<?php } ?>
		<?php if(isset($packdata[6]['enable']) && $packdata[6]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "g": {
            label: "<?php echo strip_tags($packdata[6]['name']); ?>",
            data: [<?php echo ppt_chardata(6); ?>]
        },
		<?php } ?>		
		<?php if(isset($packdata[7]['enable']) && $packdata[7]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "h": {
            label: "<?php echo strip_tags($packdata[7]['name']); ?>",
            data: [<?php echo ppt_chardata(7); ?>]
        },
		<?php } ?>		
		<?php if(isset($packdata[8]['enable']) && $packdata[8]['enable'] ==1 && strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>
        "i": {
            label: "<?php echo strip_tags($packdata[8]['name']); ?>",
            data: [<?php echo ppt_chardata(8); ?>]
        },
		<?php } ?>
		
		<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){ ?>						
        "j": {
            label: "New Orders",
            data: [<?php echo ppt_chardata(9); ?>]
        },
		<?php } ?>		
		 };

                    // hard-code color indices to prevent them from shifting as
            // countries are turned on/off
            var i = 0;
           jQuery.each(datasets, function(key, val) {
                val.color = i;
                ++i;
            });
            
            // insert checkboxes 
            var choiceContainer =jQuery("#choices");
    jQuery.each(datasets, function(key, val) {
        choiceContainer.append('<div style="float:left;width:150px; margin-bottom:10px;"><input style="float:left; margin-top:8px; margin-right:4px;" type="checkbox" name="' + key +
                               '" checked="checked" id="id' + key + '">' +
                               '<label for="id' + key + '">'
                                + val.label + '</label></div>');
    });
            choiceContainer.find("input").click(plotAccordingToChoices);

            
            function plotAccordingToChoices() {
                var data = [];

                choiceContainer.find("input:checked").each(function () {
                    var key =jQuery(this).attr("name");
                    if (key && datasets[key])
                        data.push(datasets[key]);
                });

                if (data.length > 0)
                   jQuery.plot(jQuery("#placeholder"), data, {
                        shadowSize: 0,
                        yaxis: {   },
                        xaxis: {   ticks: [0, <?php $s = ppt_chardata(0,true); $i=1;foreach($s as $val=>$da){ echo '['.$i.', "'.substr($val,5,5).'"],'; $i++;  } ?>  ],  
						lines: { show: true },
						label: 'string' },						
						selection: { mode: "xy" },
                                                grid: { hoverable: true, clickable: true },
                                                bars: { show: true,lineWidth:3,autoScale: true, fillOpacity: 1 },
                                        points: { show: true },
                                        legend: {container:jQuery("#LegendContainer")    }
             
                                


                        
                    });
            }
                var previousPoint = null;
   		jQuery("#placeholder").bind("plothover", function (event, pos, item) {
       jQuery("#x").text(pos.x.toFixed(2));
       jQuery("#y").text(pos.y.toFixed(2));

       
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                   jQuery("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1];
                    if (y==1)
                    {
                    showTooltip(item.pageX, item.pageY, y + " " + item.series.label );
                    }
                    else
                    {
                    showTooltip(item.pageX, item.pageY, y + " " + item.series.label );
                    }
                }
                }
                else {
               jQuery("#tooltip").remove();
                previousPoint = null;            
            
            
        }
    });
function showTooltip(x, y, contents) {
       jQuery('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
            plotAccordingToChoices();
        });
</script>
<div id="LegendContainer" style="float:right; margin-right:20px;margin-top:-10px;"></div>
<div id="choices" style="padding:10px;">&nbsp;</div>
<div class="clearfix"></div>
</div>

 
  


<?php 
$count_posts 	= wp_count_posts(); 
$count_pages 	= wp_count_posts('page');
$comments 		= $wpdb->get_row("SELECT count(*) as count FROM $wpdb->comments");
$articles 		= $wpdb->get_row("SELECT count(*) AS count FROM $wpdb->posts WHERE post_type='article_type'");
$order_total 	= $wpdb->get_row("SELECT sum(order_total) AS total FROM ".$wpdb->prefix."orderdata");
wp_reset_query();
 
?>
 
<ul class="bigBtnIcon">
                                <li>
                                    <a href="admin.php?page=members" >
                                        <span class="icon d1"></span>
                                        <span class="txt">Users</span>
                                        <span class="notification">5</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="edit.php">
                                        <span class="icon d2"></span>
                                        <span class="txt">Listings</span>
                                        <span class="notification blue"><?php echo $count_posts->publish+$count_posts->draft+$count_posts->pending+$count_posts->trash; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="admin.php?page=orders">
                                        <span class="icon d3"></span>
                                        <span class="txt">Sales</span>
                                        <span class="notification"><?php if($order_total->total ==""){ $oT = "0"; }else{ $oT = $order_total->total;} echo premiumpress_price($oT,$CURRENCYCODE,$CURRENCYPOST,1,true);   ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="edit.php?post_type=page">
                                        <span class="icon d4"></span>
                                        <span class="txt">Pages</span>
                                        <span class="notification blue"><?php echo $count_pages->publish; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="edit-comments.php?comment_status=all">
                                        <span class="icon d5"></span>
                                        <span class="txt">Comments</span>
                                        <span class="notification green"><?php echo $comments->count; ?></span>
                                    </a>
                                </li>
                                
                                <li>
                                    <a href="edit.php?post_type=article_type">
                                        <span class="icon d6"></span>
                                        <span class="txt">Articles</span>
                                        <span class="notification"><?php echo $articles->count; ?></span>
                                        
                                    </a>
                                </li>
                                
                            </ul>




<div class="clearfix"></div>
 
 
 
 
 
 
<div class="grid400-left">

<?php premiumpress_admin_overview_left_column(); ?>



</div><div class="grid400-left last">

<?php premiumpress_admin_overview_right_column(); ?>

</div>

<div class="clearfix"></div>
 
 
<div id="premiumpress_tab1" class="content" style="margin-top:-20px;">



<h3>10 Most Popular Listings</h3>
 
<fieldset style="padding:0px;">

<table cellspacing="0"><thead><tr>
<th>Post Title</th>
<td>Description </td>
<td>Hits</td>
<td class="tc"  style="width:150px;">Actions</td>
</tr></thead>

<?php echo TableDataO(1); ?>
</table>
</fieldset> 
 


<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress" && strtolower(constant('PREMIUMPRESS_SYSTEM')) != "shopperpress"){ $tfg = TableDataO(3); if(strlen($tfg) > 5){  ?>

<h3>Listings Expiring Soon (Current Server Time: <?php echo date('Y-m-d h:i:s'); ?>)</h3>
 <fieldset style="padding:0px;">

<table cellspacing="0"><thead><tr>
<th>Post Title</th>
<td>Description </td> 
<td class="tc" >Actions</td>
</tr></thead>

<?php echo $tfg; ?>
</table>

</fieldset>

<?php } } ?> 




<?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) != "comparisonpress"){  

$SQL = "SELECT order_id, order_total, order_date FROM ".$wpdb->prefix."orderdata LEFT JOIN $wpdb->users ON ($wpdb->users.ID = ".$wpdb->prefix."orderdata.cus_id) ORDER BY ".$wpdb->prefix."orderdata.order_date DESC LIMIT 10 "; 
$posts = $wpdb->get_results($SQL);
if(!empty($posts)){
?>

<h3>10 Most Recent Orders</h3>
<fieldset style="padding:0px;">

<table cellspacing="0"><thead><tr>
<th>Order ID</th>
<td>Date</td>
<td>Amount</td>
<td class="tc"  style="width:150px;">Actions</td>
</tr></thead>

<?php 


foreach($posts as $order){
		//echo '<li><a href="'..'" target="_blank">'.$post->post_title."</a> (".get_post_meta($post->ID, 'hits', true)." hits)".'</li>';
	 
	 $STRING .= '
		<tr class="first">
		<td style="width:400px;"><b>'.$order->order_id.'</b></td>
		<td>'.$order->order_date.'</td>  
		<td style="text-align:center !important;">'.premiumpress_price($order->order_total,$CURRENCYCODE,$CURRENCYPOST,1,true).'</td>  
		<td class="tc" style="width:150px;">
		 <a href="admin.php?page=orders&id='.$order->order_id.'" class="premiumpress_button" target="_blank">View</a> 
		</td>
		</tr>';
		
	} 
	
	echo $STRING;

?>
</table>
</fieldset> 

<?php } } ?> 



<fieldset class="info">
<div class="titleh"> <h3>Active Users</h3>  </div>
 

<dd>
 
<ul class="first users">
<?php
// The Query
$SQL = "SELECT count(".$wpdb->prefix."posts.post_author) AS total,".$wpdb->prefix."posts.post_author, ".$wpdb->prefix."users.user_nicename FROM ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."users ON (".$wpdb->prefix."posts.post_author = ".$wpdb->prefix."users.ID AND ".$wpdb->prefix."posts.post_status='publish' AND ".$wpdb->prefix."posts.post_type='post') WHERE ".$wpdb->prefix."users.user_nicename != '' 
GROUP BY post_author ORDER BY count(post_author) DESC LIMIT 20"; 
$posts = $wpdb->get_results($SQL); 
foreach($posts as $post){
	echo '<li><a href="'.get_author_posts_url( $post->post_author, $post->user_nicename ).'" target="_blank">'.$post->user_nicename."</a> 
	
	<a href='edit.php?post_type=post&author=".$post->post_author."'>(".$post->total." listings )</a>".'</li>';
}
// Reset Query
wp_reset_query();
?>
</ul>
</dd>
 
 
 
</fieldset>

</div>


</div>
</div>