<?php if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; } 

class PPTPlugin  {
    var $name;  // aa name
    var $symbol;    // three letter symbol
    var $code;  // one letter code
    var $type;  // hydrophobic, charged or neutral
    
    function PPTPlugin ($aa) 
    {
        foreach ($aa as $k=>$v)
            $this->$k = $aa[$k];
    }
}

function readDatabase() 
{
 
  	$STRING = '';
	$Soc 		= new PPT_Admin;
	 
 	// SORT OPTIONS
	$type = empty($_GET['type']) ? "" : $_GET['type'];
	$query = empty($_GET['query']) ? "" : $_GET['query'];	
	$sort = empty($_GET['sort']) ? "name" : $_GET['sort'];	
	$order = empty($_GET['order']) ? "asc" : $_GET['order'];
 	$page = empty($_GET['start_page']) ? "1" : $_GET['start_page'];
	
	$installed_host 	= $Soc->hexToStr("636c69656e74732e7072656d69756d70726573732e636f6d");
 
	$query_string		= "type=".$type;
	$query_string		.= "&s=".$sort."&o=".$order."&q=".$query."&p=".$page;
	$query_string		.= "&key=".get_option('license_key')."&version=".PREMIUMPRESS_VERSION."&version_date=".PREMIUMPRESS_VERSION_DATE."&theme=".PREMIUMPRESS_SYSTEM;
 
	$data = $Soc->PremiumPress_exec_socket($installed_host, "", "/pluginAPI.php", $query_string);
	
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);
 
    // loop through the structures
    foreach ($tags as $key=>$val) {
        if ($key == "plugin") {
            $molranges = $val;
            // each contiguous pair of array entries are the 
            // lower and upper range for each molecule definition
            for ($i=0; $i < count($molranges); $i+=2) {
                $offset = $molranges[$i] + 1;
                $len = $molranges[$i + 1] - $offset;
                $tdb[] = parseMol(array_slice($values, $offset, $len));
            }
        } else {
            continue;
        }
    }

 $totalresults= 0;
 if(is_array($tdb)){	
	 foreach( $tdb as $plugin ){	 
	  $STRING .= '
		<tr class="first">
		<td style="width:220px;">';
		if($plugin->type == "member"){
		
			$STRING .= '<img src="'.PPT_FW_IMG_URI.'admin/user_green.png" style="float:left; margin-right:2px;" /> <b>'.$plugin->title.'</b> <br> <em style="font-size:11px;">PremiumPress Member Submitted</em>';
		
		}else{
		
			$STRING .= '<b>'.$plugin->title.'</b>';
		
		}
		
		$STRING .= '</td>
		<td>'.$plugin->desc.'</td>  
		<td class="tc" style="width:150px;">';
		
		if(strpos($plugin->SKU,"http://") !== false){
		$lstr = $plugin->SKU; $clss ='" target="_blank"';
		}else{
		$lstr = "plugin-install.php?tab=plugin-information&plugin=".$plugin->SKU."&TB_iframe=true&width=640&height=838"; $clss = "thickbox ";
		}
		
		$STRING .= '<a href="'.$lstr.'" class="premiumpress_button '.$clss.'">More Details</a>
		</td>
		</tr>';	
		
		$totalresults = $plugin->total;
	 }
 }
 
 echo $STRING;
 
 return $totalresults;	
 
}

function parseMol($mvalues) 
{
    for ($i=0; $i < count($mvalues); $i++) {
        $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
    }
    return new PPTPlugin($mol);
}



PremiumPress_Header();  
?>




<div class="clearfix"></div> 

<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_plugin.png" align="middle"> PremiumPress Plugins *beta*</h3>
						 
<ul>
	<li><a rel="premiumpress_tab1" href="#" class="active">Popular Plugins</a></li> 
    <li><a rel="premiumpress_tab3" href="#">Paid Plugins</a></li>
    <li><a href="#" onClick="window.location.href='plugin-install.php?tab=search&s=&plugin-search-input=Search+Plugins'">All WordPress Plugins</a></li>
</ul>
</div>


 <style> 
.pagenav { width:500px; margin-top:10px; }
.pagenav li { border:1px solid #ddd; background:#fff; padding:5px 8px 5px 8px; float:left; margin-right:5px; list-style:none; }
.pagenav li.active { background:#8E0F0F; }
.pagenav li.active a { color:#fff; font-weight:bold; }
.left { float:left; }
.right { float:right; }
</style> 
 
<script language="javascript">
function clearMe(){
document.getElementById("query").value = "";
}
</script>

<div style="padding:10px;padding-bottom:0px;">
<div class="PremiumPress_Members_search" style="float:right;">
		<form method="get" action="admin.php?page=pptplugins" name="subform" id="subform1">			
			<input type="text" id="query" name="query" class="blur" value="Keyword.." onclick="clearMe();">
			in <select name="sort">
            <option value="">All Fields</option>
            <option value="plugin_name">Plugin Name</option>
            <option value="plugin_desc">Plugin Description</option>
            
            </select>
            
              <select name="type">
            <option value="">All Plugins</option>
            <option value="member">PremiumPress Member Submitted Only</option> 
            
            </select>
            <input type="hidden" name="page" value="pptplugins">			
			<input type="submit" value="Search" class="button">
            <input type="hidden" name="start_page" value="1" id="start_page">
            
		</form>
</div>
 </div>
 <div class="clearfix"></div>

<div id="premiumpress_tab1" class="content">
 
<fieldset style="padding:0px;">

<table cellspacing="0" id="resultstable"><thead><tr>
<th>Plugin Name</th>
<td>Plugin Description </td>
 
<td class="tc">Actions</td>
</tr></thead>
<?php $totalResults = readDatabase(); ?>
</table>

</fieldset> 

    <?php
  
	$num_rows = $totalResults; // total amount
	$items = 20; // per page	
	$page_amount = ceil($num_rows/$items);
	if($page < "1"){
		$page = "0";
	}
 
	$i = 1;
	$cp = empty($_GET['start_page']) || !is_numeric($_GET['start_page']) ? "1" : $_GET['start_page'];
	echo '<ul class="pagenav left">';
	while($i <= $page_amount){ 
	if($i == $cp){ $st = "class='active'"; }else{  $st = "";  }
	?>
    <li <?php echo $st; ?>><a href="#" onclick="getElementById('start_page').value='<?php echo $i; ?>';getElementById('resultstable').innerHTML='<p align=center>Loading results, please wait...</p>'; document.subform.submit();" style="float:right;">
	<?php echo $i; ?></a></li>
    <?php $i++; }
	echo '</ul>'; 	
 
	
	?>
    
    <div class="clearfix"></div>

</div> 
 

<div id="premiumpress_tab3" class="content">

<p class="ppnote">

 <img src="<?php echo PPT_FW_IMG_URI; ?>tip.png" style="float:left; padding-right:5px;" /> There are currently no paid plugins available.

</p> 

</div>



</div><div class="clearfix"></div>   