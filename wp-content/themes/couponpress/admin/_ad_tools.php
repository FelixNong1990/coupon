<?php if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $PPT; PremiumPress_Header(); 
global $PPT, $wpdb;






 
if(current_user_can('administrator')){
if(isset($_GET['task']) && $_GET['task'] != "" ){


	switch($_GET['task']){


		case "import1": { 
$a = wp_insert_term("United Kingdom", "location" ); 
 

$state_uk = array('London',
'Bedfordshire',
'Buckinghamshire',
'Cambridgeshire',
'Cheshire',
'Cornwall and Isles of Scilly',
'Cumbria',
'Derbyshire',
'Devon',
'Dorset',
'Durham',
'East Sussex',
'Essex',
'Gloucestershire',
'Greater London',
'Greater Manchester',
'Hampshire',
'Hertfordshire',
'Kent',
'Lancashire',
'Leicestershire',
'Lincolnshire',
'Merseyside',
'Norfolk',
'North Yorkshire',
'Northamptonshire',
'Northumberland',
'Nottinghamshire',
'Oxfordshire',
'Shropshire',
'Somerset',
'South Yorkshire',
'Staffordshire',
'Suffolk',
'Surrey',
'Tyne and Wear',
'Warwickshire',
'West Midlands',
'West Sussex',
'West Yorkshire',
'Wiltshire',
'Worcestershire',
'Flintshire',
'Glamorgan',
'Merionethshire',
'Monmouthshire',
'Montgomeryshire',
'Pembrokeshire',
'Radnorshire',
'Anglesey',
'Breconshire',
'Caernarvonshire',
'Cardiganshire',
'Carmarthenshire',
'Denbighshire',
'Kirkcudbrightshire',
'Lanarkshire',
'Midlothian',
'Moray',
'Nairnshire',
'Orkney',
'Peebleshire',
'Perthshire',
'Renfrewshire',
'Ross & Cromarty',
'Roxburghshire',
'Selkirkshire',
'Shetland',
'Stirlingshire',
'Sutherland',
'West Lothian',
'Wigtownshire',
'Aberdeenshire',
'Angus',
'Argyll',
'Ayrshire',
'Banffshire',
'Berwickshire',
'Bute',
'Caithness',
'Clackmannanshire',
'Dumfriesshire',
'Dumbartonshire',
'East Lothian',
'Fife',
'Inverness',
'Kincardineshire',
'Kinross-shire');

foreach($state_uk as $value){ if(!is_object($a)){  wp_insert_term($value, "location", array(  'parent' => $a['term_id'] )); } }
 
$b = wp_insert_term("United States of America", "location" ); 


$state_usa = array('Alabama', 'Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming');

foreach($state_usa as $value){   wp_insert_term($value, "location", array(  'parent' => $b['term_id'] )); }


wp_insert_term("Afghanistan", "location" ); wp_insert_term("Albania", "location" ); wp_insert_term("Algeria", "location" ); wp_insert_term("American Samoa", "location" ); wp_insert_term("Andorra", "location" ); wp_insert_term("Angola", "location" ); wp_insert_term("Anguilla", "location" ); wp_insert_term("Antarctica", "location" ); wp_insert_term("Antigua and Barbuda", "location" ); wp_insert_term("Argentina", "location" ); wp_insert_term("Armenia", "location" ); wp_insert_term("Aruba", "location" ); 


$state_australia = array("Australian Capital Territory","New South Wales","Northern Territory","Queensland","South Australia","Tasmania","Victoria","Western Australia");

$l = wp_insert_term("Australia", "location" );
foreach($state_australia as $value){   wp_insert_term($value, "location", array(  'parent' => $l['term_id'] )); }


 wp_insert_term("Austria", "location" ); wp_insert_term("Azerbaijan", "location" ); wp_insert_term("Bahamas", "location" );  wp_insert_term("Bahrain", "location" ); wp_insert_term("Bangladesh", "location" ); wp_insert_term("Barbados", "location" ); wp_insert_term("Belarus", "location" ); wp_insert_term("Belgium", "location" ); wp_insert_term("Belize", "location" );
wp_insert_term("Benin", "location" ); wp_insert_term("Bermuda", "location" ); wp_insert_term("Bhutan", "location" ); wp_insert_term("Bolivia", "location" ); wp_insert_term("Bosnia and Herzegovina", "location" ); wp_insert_term("Botswana", "location" ); wp_insert_term("Bouvet Island", "location" ); wp_insert_term("Brazil", "location" ); wp_insert_term("British Indian Ocean Territory", "location" ); wp_insert_term("British Virgin Islands", "location" ); wp_insert_term("Brunei", "location" ); wp_insert_term("Bulgaria", "location" ); wp_insert_term("Burkina Faso", "location" ); wp_insert_term("Burundi", "location" ); wp_insert_term("Cambodia", "location" ); wp_insert_term("Cameroon", "location" ); wp_insert_term("Canada", "location" ); wp_insert_term("Cape Verde", "location" ); wp_insert_term("Cayman Islands", "location" ); 
wp_insert_term("Central African Republic", "location" ); wp_insert_term("Chad", "location" ); wp_insert_term("Chile", "location" ); 


$state_china = array('Anhui','Beijing','Chongqing','Fujian','Gansu','Guangdong','Guangxi','Guizhou','Hainan','Hebei','Heilongjiang','Henan','Hubei','Hunan','Jiangsu','Jiangxi','Jilin','Liaoning','Nei Mongol','Ningxia','Qinghai','Shaanxi','Shandong','Shanghai','Shanxi','Sichuan','Tianjin','Xinjiang','Xizang (Tibet)','Yunnan','Zhejiang');

$e = wp_insert_term("China", "location" ); 

foreach($state_china as $value){   wp_insert_term($value, "location", array(  'parent' => $e['term_id'] )); }


wp_insert_term("Christmas Island", "location" ); wp_insert_term("Cocos (Keeling) Islands", "location" ); wp_insert_term("Colombia", "location" ); wp_insert_term("Comoros", "location" ); wp_insert_term("Congo", "location" ); wp_insert_term("Cook Islands", "location" ); wp_insert_term("Costa Rica", "location" ); wp_insert_term("Croatia", "location" ); wp_insert_term("Cuba", "location" ); wp_insert_term("Cyprus", "location" ); wp_insert_term("Czech Republic", "location" ); wp_insert_term("Democratic Republic of the Congo", "location" ); wp_insert_term("Denmark", "location" ); wp_insert_term("Djibouti", "location" ); wp_insert_term("Dominica", "location" ); wp_insert_term("Dominican Republic", "location" ); wp_insert_term("East Timor", "location" ); wp_insert_term("Ecuador", "location" ); wp_insert_term("Egypt", "location" ); wp_insert_term("El Salvador", "location" ); wp_insert_term("Equatorial Guinea", "location" ); wp_insert_term("Eritrea", "location" ); wp_insert_term("Estonia", "location" ); wp_insert_term("Ethiopia", "location" ); wp_insert_term("Falkland Islands (Malvinas)", "location" ); wp_insert_term("Faroe Islands", "location" ); wp_insert_term("Fiji", "location" ); wp_insert_term("Finland", "location" ); 

$d = wp_insert_term("France", "location" ); 
$state_france = array('Alsace','Aquitaine','Auvergne','Basse-Normandie','Bourgogne','Bretagne','Centre','Champagne-Ardenne','Corse','Franche-Comte','Haute-Normandie','Ile-de-France','Languedoc-Roussillon','Limousin','Lorraine','Midi-Pyrenees','Nord-Pas-de-Calais','Pays de la Loire','Picardie','Poitou-Charentes','Provence-Alpes-Cote dAzur','Rhone-Alpes');

foreach($state_france as $value){   wp_insert_term($value, "location", array(  'parent' => $d['term_id'] )); }

wp_insert_term("French Guiana", "location" ); wp_insert_term("French Polynesia", "location" ); wp_insert_term("French Southern/Antarctic Lands", "location" ); wp_insert_term("Gabon", "location" ); wp_insert_term("Gambia", "location" ); wp_insert_term("Georgia", "location" ); 

$c = wp_insert_term("Germany", "location" );

$state_germany = array('Baden-Wuerttemberg','Bayern','Berlin','Brandenburg','Bremen','Hamburg','Hessen','Mecklenburg-Vorpommern','Niedersachsen','Nordrhein-Westfalen','Rheinland-Pfalz','Saarland','Sachsen','Sachsen-Anhalt','Schleswig-Holstein','Thueringen');
foreach($state_germany as $value){   wp_insert_term($value, "location", array(  'parent' => $c['term_id'] )); }
 

 wp_insert_term("Ghana", "location" ); wp_insert_term("Gibraltar", "location" ); wp_insert_term("Greece", "location" ); 
wp_insert_term("Greenland", "location" ); wp_insert_term("Grenada", "location" ); wp_insert_term("Guadeloupe", "location" ); wp_insert_term("Guam", "location" ); wp_insert_term("Guatemala", "location" ); wp_insert_term("Guinea", "location" ); wp_insert_term("Guinea-Bissau", "location" ); wp_insert_term("Guyana", "location" ); wp_insert_term("Haiti", "location" ); wp_insert_term("Heard and McDonald Islands", "location" ); wp_insert_term("Honduras", "location" ); wp_insert_term("Hong Kong", "location" ); wp_insert_term("Hungary", "location" ); wp_insert_term("Iceland", "location" ); 


$state_india = array("Andaman and Nicobar Islands","Andhra Pradesh","Arunachal Pradesh","Assam","Bengal","Bihar","Chandigarh","Chhattisgarh","Dadra and Nagar Haveli","Daman and Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jharkhand","Karnataka","Kashmir","Kerala","Madhya Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Orissa","Pondicherry","Punjab","Rajasthan","Sikkim","Tamil Nadu","Tripura","Uttar Pradesh","Uttarakhand");


$v = wp_insert_term("India", "location" ); 
foreach($state_india as $value){   wp_insert_term($value, "location", array(  'parent' => $v['term_id'] )); }


wp_insert_term("Indonesia", "location" ); wp_insert_term("Iraq", "location" ); wp_insert_term("Ireland", "location" ); wp_insert_term("Islamic Republic of Iran", "location" ); wp_insert_term("Israel", "location" ); wp_insert_term("Italy", "location" ); wp_insert_term("Ivory Coast", "location" ); wp_insert_term("Jamaica", "location" ); wp_insert_term("Japan", "location" ); wp_insert_term("Jordan", "location" ); wp_insert_term("Kazakhstan", "location" ); 
wp_insert_term("Kenya", "location" ); wp_insert_term("Kiribati", "location" ); wp_insert_term("Korea", "location" );   wp_insert_term("Kuwait", "location" ); wp_insert_term("Kyrgyzstan", "location" ); wp_insert_term("Lao Peoples Democratic Republic", "location" ); wp_insert_term("Latvia", "location" ); wp_insert_term("Lebanon", "location" ); wp_insert_term("Lesotho", "location" ); wp_insert_term("Liberia", "location" ); wp_insert_term("Libya", "location" ); wp_insert_term("Liechtenstein", "location" ); wp_insert_term("Lithuania", "location" ); wp_insert_term("Luxembourg", "location" ); 
wp_insert_term("Macau", "location" ); wp_insert_term("Macedonia", "location" ); wp_insert_term("Madagascar", "location" ); wp_insert_term("Malawi", "location" ); 


$state_malaysia = array("Federal Territory of Labuan","Johor","Kedah","Kelantan","Kuala Lumpur","Melaka","Negeri Sembilan","Pahang","Perak","Perlis","Pulau Pinang","Putrajaya","Sabah","Sarawak","Selangor","Terengganu");

$ma = wp_insert_term("Malaysia", "location" );
foreach($state_malaysia as $value){   wp_insert_term($value, "location", array(  'parent' => $ma['term_id'] )); }


wp_insert_term("Maldives", "location" ); wp_insert_term("Mali", "location" ); wp_insert_term("Malta", "location" );  wp_insert_term("Marshall Islands", "location" ); wp_insert_term("Martinique", "location" ); wp_insert_term("Mauritania", "location" ); wp_insert_term("Mauritius", "location" ); wp_insert_term("Mayotte", "location" ); wp_insert_term("Mexico", "location" ); wp_insert_term("Micronesia", "location" ); wp_insert_term("Moldova", "location" ); wp_insert_term("Monaco", "location" ); wp_insert_term("Mongolia", "location" ); wp_insert_term("Monserrat", "location" ); wp_insert_term("Morocco", "location" ); wp_insert_term("Mozambique", "location" ); wp_insert_term("Namibia", "location" ); wp_insert_term("Nauru", "location" ); wp_insert_term("Nepal", "location" ); wp_insert_term("Netherlands", "location" ); wp_insert_term("Netherlands Antilles", "location" ); wp_insert_term("New Caledonia", "location" ); wp_insert_term("New Zealand", "location" ); wp_insert_term("Nicaragua", "location" ); wp_insert_term("Niger", "location" ); wp_insert_term("Nigeria", "location" ); wp_insert_term("Niue", "location" ); wp_insert_term("Norfolk Island", "location" ); wp_insert_term("Northern Mariana Islands", "location" ); wp_insert_term("Norway", "location" ); wp_insert_term("Oman", "location" ); wp_insert_term("Pakistan", "location" ); wp_insert_term("Palau", "location" ); wp_insert_term("Panama", "location" ); wp_insert_term("Papua New Guinea", "location" ); wp_insert_term("Paraguay", "location" ); wp_insert_term("Peru", "location" ); wp_insert_term("Philippines", "location" ); wp_insert_term("Pitcairn", "location" ); wp_insert_term("Poland", "location" );
 wp_insert_term("Portugal", "location" ); wp_insert_term("Puerto Rico", "location" ); wp_insert_term("Qatar", "location" ); wp_insert_term("Reunion", "location" ); wp_insert_term("Romania", "location" ); wp_insert_term("Russia", "location" ); wp_insert_term("Rwanda", "location" ); wp_insert_term("Saint Lucia", "location" ); wp_insert_term("Samoa", "location" ); wp_insert_term("San Marino", "location" ); wp_insert_term("Sao Tome and Principe", "location" ); wp_insert_term("Saudi Arabia", "location" ); wp_insert_term("Scotland", "location" ); wp_insert_term("Senegal", "location" ); wp_insert_term("Seychelles", "location" ); wp_insert_term("Sierra Leone", "location" ); wp_insert_term("Singapore", "location" ); wp_insert_term("Slovakia", "location" ); wp_insert_term("Slovenia", "location" ); wp_insert_term("Solomon Islands", "location" ); wp_insert_term("Somalia", "location" ); wp_insert_term("South Africa", "location" ); wp_insert_term("South Georgia/Sandwich Islands", "location" ); 
 
$f = wp_insert_term("Spain", "location" ); 
 
$state_spain = array('Andaluc','Arag','Asturias','Baleares','Canarias','Cantabria','Castilla - La Mancha','Castilla y Le','Catalu','Comunidad Valenciana','Extremadura','Galicia','La Rioja','Madrid','Navarra','Pa Vasco','Murcia','Ceuta','Melilla');
foreach($state_spain as $value){   wp_insert_term($value, "location", array(  'parent' => $f['term_id'] )); }
 
 
 
 
 wp_insert_term("Sri Lanka", "location" ); wp_insert_term("St. Helena", "location" ); wp_insert_term("St. Kitts and Nevis", "location" ); wp_insert_term("St. Pierre and Miquelon", "location" ); wp_insert_term("St. Vincent and the Grenadines", "location" ); wp_insert_term("Sudan", "location" ); wp_insert_term("Suriname", "location" ); wp_insert_term("Svalbard/Jan Mayen Islands", "location" ); wp_insert_term("Swaziland", "location" ); wp_insert_term("Sweden", "location" ); wp_insert_term("Switzerland", "location" ); wp_insert_term("Syria", "location" ); wp_insert_term("Taiwan", "location" ); wp_insert_term("Tajikistan", "location" ); wp_insert_term("Tanzania", "location" );   wp_insert_term("Thailand", "location" ); wp_insert_term("Togo", "location" ); wp_insert_term("Tokelau", "location" ); wp_insert_term("Tonga", "location" ); 
 wp_insert_term("Trinidad and Tobago", "location" ); wp_insert_term("Tunisia", "location" ); wp_insert_term("Turkey", "location" ); wp_insert_term("Turkmenistan", "location" ); wp_insert_term("Turks and Caicos Islands", "location" ); wp_insert_term("Tuvalu", "location" ); wp_insert_term("U.S. Minor Outlying Islands", "location" ); wp_insert_term("Uganda", "location" ); wp_insert_term("Ukraine", "location" ); wp_insert_term("United Arab Emirates", "location" ); wp_insert_term("Uruguay", "location" ); wp_insert_term("Uzbekistan", "location" ); wp_insert_term("Vanuatu", "location" ); wp_insert_term("Vatican City State (Holy See)", "location" ); wp_insert_term("Venezuela", "location" ); wp_insert_term("Vietnam", "location" ); wp_insert_term("Virgin Islands", "location" ); wp_insert_term("Wallis and Futuna Islands", "location" ); wp_insert_term("Western Sahara", "location" ); wp_insert_term("Wales", "location" ); wp_insert_term("Yemen", "location" ); wp_insert_term("Zambia", "location" ); wp_insert_term("Zimbabwe", "location" ); 		
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;
			
		case "delete1": { 
	 
		$terms = get_terms('location', 'orderby=count&hide_empty=0');	 
		$count = count($terms);
		if ( $count > 0 ){
		
			 foreach ( $terms as $term ) {
				wp_delete_term( $term->term_id, 'location' );
			 }
		 }
		
		echo "<h1>Delete All Locations Successfull</h1>";
		die();
		} break;
		
		
		case "delete2": { 
	 
		$terms = get_terms('category', 'orderby=count&hide_empty=0');	 
		$count = count($terms);
		if ( $count > 0 ){
		
			 foreach ( $terms as $term ) {
				wp_delete_term( $term->term_id, 'category' );
			 }
		 }
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;
		
		case "delete3": { 
	 
		$terms = get_terms('post_tag', 'orderby=count&hide_empty=0');	 
		$count = count($terms);
		if ( $count > 0 ){
		
			 foreach ( $terms as $term ) {
				wp_delete_term( $term->term_id, 'post_tag' );
			 }
		 }
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;		
		
		case "delete4": { 
	 
		mysql_query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type ='post'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;	
		
		
		case "delete5": { 
	 
		mysql_query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'revision'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;			
		
		case "delete6": { // PAGES 
	 
		mysql_query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'page'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;
		
		
		case "delete7": { 
	 
		mysql_query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'article_type'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;	
		
		case "delete8": { 
	 
		mysql_query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'faq_type'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;
		
		case "delete9": { 
	 
		mysql_query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'message_type'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;	
		
		case "delete10": { 
	 
		mysql_query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'alert_type'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;	
				
		case "delete11": { 
	 
		mysql_query("TRUNCATE TABLE ".$wpdb->prefix."orderdata");
		
		echo "<h1>Orders Deleted Successfull</h1>";
		die();
		} break;	
						
		case "import11": {  // UK IMPORT
	 
//$b = wp_insert_term("United States of America", "location" ); 
//wp_insert_term($value, "location", array(  'parent' => $b['term_id'] ));

$states = 
array(

	array( 	
	"name" => "Aberdeenshire",
	"vars" => array("Aberdeen","Aboyne","Alford","Ballater","Ellon","Fraserburgh","Huntly","Insch","Inverurie","Milltimber","Peterculter","Peterhead","Strathdon","Turriff","Westhill")
	),
	
	array( 	
	"name" => "Angus",
	"vars" => array("Arbroath","Brechin","Carnoustie","Dundee","Forfar","Kirriemuir","Montrose")
	),	
	
	array( 	
	"name" => "Argyll",
	"vars" => array("Acharacle","Appin","Ballachulish","Bridge of Orchy","Cairndow","Campbeltown","Colintraive","Dalmally","Dunoon","Inveraray","Kinlochleven","Lochgilphead","Oban","Tarbert","Taynuilt","Tighnabruaich")
	),	
	
	array( 	
	"name" => "Avon",
	"vars" => array("Badminton","Banwell","Bath","Bristol","Clevedon","Radstock","Weston-super-Mare","Winscombe")
	),	
	
	array( 	
	"name" => "Ayrshire",
	"vars" => array( "Ardrossan","Ayr","Beith","Cumnock","Dalry","Darvel","Galston","Girvan","Irvine","Kilbirnie","Kilmarnock","Kilwinning","Largs","Mauchline","Maybole","Newmilns",
	"Prestwick","Saltcoats","Skelmorlie","Stevenston","Troon","West Kilbride")
	),
	
	array( 	
	"name" => "Banffshire",
	"vars" => array("Aberlour","Ballindalloch","Banff","Buckie","Keith","MacDuff")
	),	
	
	array( 	
	"name" => "Bedfordshire",
	"vars" => array("Arlesey","Bedford","Biggleswade","Dunstable","Henlow","Leighton Buzzard","Luton","Sandy","Shefford")
	),	
	
	array( 	
	"name" => "Berkshire",
	"vars" => array("Ascot","Bracknell","Crowthorne","Hungerford","Maidenhead","Newbury","Reading","Sandhurst","Slough","Thatcham","Windsor","Wokingham")
	),	
	
	array( 	
	"name" => "Berwickshire",
	"vars" => array("Cockburnspath","Coldstream","Duns","Earlston","Eyemouth","Gordon","Laudera")
	),	
	
	array( 	
	"name" => "Buckinghamshire",
	"vars" => array("Amersham","Aylesbury","Beaconsfield","Bourne End","Buckingham","Chalfont St Giles","Chesham","Gerrards Cross","Great Missenden","High Wycombe","Iver","Marlow","Milton Keynes","Newport Pagnell","Olney","Princes Risborough")
	),	
	
	array( 	
	"name" => "Caithness",
	"vars" => array("Berriedale","Dunbeath","Halkirk","Latheron","Lybster","Thurso","Wick")
	),	
	
	array( 	
	"name" => "Cambridgeshire",
	"vars" => array("Cambridge","Chatteris","Huntingdon","March","Peterborough","St Ives","St Neots","Wisbech")
	),	
	
	array( 	
	"name" => "Channel Islands",
	"vars" => array("Guernsey","Jersey")
	),	
	
	array( 	
	"name" => "Cheshire",
	"vars" => array("Alderley Edge","Altrincham","Cheadle","Chester","Congleton","Crewe","Dukinfield","Frodsham","Hyde","Knutsford","Lymm","Macclesfield","Malpas","Middlewich","Nantwich","Northwich","Runcorn","Sale","Sandbach","Stalybridge","Stockport","Tarporley","Warrington","Widnes","Wilmslow","Winsford")
	),	
	
	array( 	
	"name" => "Clackmannanshire",
	"vars" => array("Alloa","Alva","Clackmannan","Dollar","Menstrie","Tillicoultry")
	),		
	
	array( 	
	"name" => "Cleveland",
	"vars" => array("Billingham","Guisborough","Hartlepool","Middlesbrough","Redcar","Saltburn-by-the-Sea","Stockton-on-Tees","Yarm")
	),		

	array( 	
	"name" => "Clwyd",
	"vars" => array("Abergele","Bagillt","Buckley","Colwyn Bay","Corwen","Deeside","Denbigh","Flint","Holywell","Llangollen","Mold","Prestatyn","Rhyl","Ruthin","St Asaph","Wrexham")
	),		

	array( 	
	"name" => "Cornwall",
	"vars" => array("Bodmin","Boscastle","Bude","Callington","Calstock","Camborne","Camelford","Delabole","Falmouth","Fowey","Gunnislake","Hayle","Helston","Launceston","Liskeard","Looe","Lostwithiel","Marazion","Newquay","Padstow","Penryn","Penzance","Perranporth","Port Isaac","Redruth","Saltash","Tintagel","Torpoint","Truro","Wadebridge")
	),	
	
	array( 	
	"name" => "County Antrim",
	"vars" => array("Antrim","Ballycastle","Ballyclare","Ballymena","Ballymoney","Belfast","Bushmills","Carrickfergus","Crumlin","Larne","Lisburn","Newtownabbey","Portrush")
	),		
	
	array( 	
	"name" => "County Down",
	"vars" => array("Ballynahinch","Banbridge","Bangor","Castlewellan","Donaghadee","Downpatrick","Dromore","Hillsborough","Holywood","Newcastle","Newry","Newtownards")
	),		
	
	array( 	
	"name" => "County Durham",
	"vars" => array("Barnard Castle","Bishop Auckland","Chester le Street","Consett","Crook","Darlington","Durham","Ferryhill","Newton Aycliffe","Peterlee","Seaham","Shildon","Spennymoor","Stanley","Trimdon Station","Wingate")
	),	
 
	array( 	
	"name" => "County Fermanagh",
	"vars" => array("Enniskillen")
	),		
	
	array( 	
	"name" => "County Londonderry",
	"vars" => array("Coleraine","Limavady","Londonderry","Magherafelt","Maghera","Portstewart")
	),			
	
	array( 	
	"name" => "County Tyrone",
	"vars" => array("Augher","Aughnacloy","Caledon","Castlederg","Clogher","Cookstown","Dungannon","Fivemiletown","Omagh","Strabane")
	),	
	array( 	
	"name" => "Cumbria",
	"vars" => array("Alston","Ambleside","Appleby-in-Westmorland","Askam-in-Furness","Barrow-in-Furness","Brampton","Broughton-in-Furness","Carlisle","Cleator Moor","Cockermouth","Coniston","Dalton-in-Furness","Egremont","Frizington","Grange-over-Sands","Holmrook","Kendal","Keswick","Kirkby Stephen","Maryport","Millom","Milnthorpe","Penrith","Seascale","Sedbergh","Ulverston","Whitehaven","Wigton","Windermere","Workington")
	),	 
 
	array( 	
	"name" => "Derbyshire",
	"vars" => array("Alfreton","Ashbourne","Bakewell","Belper","Buxton","Chesterfield","Derby","Dronfield","Glossop","Heanor","High Peak","Hope Valley","Ilkeston","Matlock","Ripley","Swadlincote")
	),	
	array( 	
	"name" => "Devon",
	"vars" => array("Axminster","Barnstaple","Bideford","Braunton","Brixham","Crediton","Cullompton","Dartmouth","Dawlish","Exeter","Exmouth","Holsworthy","Honiton","Ilfracombe","Ivybridge","Kingsbridge","Newton Abbot","Okehampton","Paignton","Plymouth","Seaton","Sidmouth","South Molton","Tavistock","Teignmouth","Tiverton","Torquay","Torrington","Totnes","Yelverton")
	),	
	
	array( 	
	"name" => "Dorset",
	"vars" => array("Beaminster","Blandford Forum","Bournemouth","Bridport","Broadstone","Christchurch","Dorchester","Ferndown","Gillingham","Lyme Regis","Poole","Portland","Shaftesbury","Sherborne","Sturminster Newton","Swanage","Verwood","Wareham","Weymouth","Wimborne")
	),
	
	array( 	
	"name" => "Dumfriesshire",
	"vars" => array("Annan","Canonbie","Dumfries","Gretna","Langholm","Lockerbie","Moffat","Sanquhar","Thornhill")
	),	
	array( 	
	"name" => "Dunbartonshire",
	"vars" => array("Alexandria","Arrochar","Clydebank","Dumbarton","Helensburgh")
	),		
	array( 	
	"name" => "Dyfed",
	"vars" => array("Aberaeron","Aberystwyth","Ammanford","Burry Port","Cardigan","Carmarthen","Clynderwen","Crymych","Fishguard","Haverfordwest","Kidwelly","Kilgetty","Lampeter","Llandeilo","Llandovery","Llandysul","Llanelli","Llangadog","Llanwrda","Llanybydder","Milford Haven","Narberth","Newcastle Emlyn","Pembroke Dock","Pembroke","Pencader","Saundersfoot","Tenby","Tregaron","Whitland")
	),	
	array( 	
	"name" => "East Lothian",
	"vars" => array("Dunbar","East Linton","Gullane","Haddington","Humbie","Longniddry","North Berwick","Prestonpans","Tranent")
	),	
	array( 	
	"name" => "East Sussex",
	"vars" => array("Battle","Bexhill-on-Sea","Brighton","Crowborough","Eastbourne","Etchingham","Forest Row","Hailsham","Hartfield","Hastings","Heathfield","Hove","Lewes","Mayfield","Newhaven","Peacehaven","Pevensey","Polegate","Robertsbridge","Seaford","St Leonards-on-Sea","Uckfield","Wadhurst","Winchelsea")
	),	
	array( 	
	"name" => "East Lothian",
	"vars" => array("Dunbar","East Linton","Gullane","Haddington","Humbie","Longniddry","North Berwick","Prestonpans","Tranent")
	),		
	
	array( 	
	"name" => "Essex",
	"vars" => array("Barking","Basildon","Benfleet","Billericay","Braintree","Brentwood","Canvey Island","Chelmsford","Clacton-on-Sea","Colchester","Dagenham","Dunmow","Epping","Grays","Halstead","Harlow","Hornchurch","Ilford","Leigh-on-Sea","Loughton","Maldon","Rayleigh","Romford","Saffron Walden","Southend-on-Sea","Upminster","Waltham Abbey","Westcliff-on-Sea","Wickford","Witham")
	),	
	array( 	
	"name" => "Fife",
	"vars" => array("Anstruther","Burntisland","Cowdenbeath","Cupar","Dunfermline","Glenrothes","Inverkeithing","Kelty","Kirkcaldy","Leven","Lochgelly","Newport-on-Tay","St Andrews","Tayport")
	),		
	array( 	
	"name" => "Gloucestershire",
	"vars" => array("Berkeley","Blakeney","Cheltenham","Chipping Campden","Cinderford","Cirencester","Coleford","Drybrook","Dursley","Dymock","Fairford","Gloucester","Lechlade","Longhope","Lydbrook","Lydney","Mitcheldean","Moreton-in-Marsh","Newent","Newnham","Ruardean","Stonehouse","Stroud","Tetbury","Tewkesbury","Westbury-on-Severn","Wotton-under-Edge")
	),	
	array( 	
	"name" => "Gwent",
	"vars" => array("Abergavenny","Abertillery","Blackwood","Caldicot","Chepstow","Cwmbran","Ebbw Vale","Monmouth","New Tredegar","Newport","Pontypool","Tredegar")
	),	
	array( 	
	"name" => "Gwynedd",
	"vars" => array("Aberdovey","Amlwch","Bala","Bangor","Barmouth","Beaumaris","Betws-y-Coed","Blaenau Ffestiniog","Caernarfon","Cemaes Bay","Conwy","Criccieth","Dolgellau","Gaerwen","Harlech","Holyhead","Llandudno Junction","Llandudno","Llanfairfechan","Llanfairpwllgwyngyll","Llangefni","Llanrwst","Menai Bridge","Penmaenmawr","Penrhyndeudraeth","Porthmadog","Pwllheli","Tyn-y-Gongl","Tywyn","Y Felinheli")
	),		
	array( 	
	"name" => "Hampshire",
	"vars" => array("Aldershot","Alresford","Alton","Andover","Basingstoke","Bordon","Eastleigh","Emsworth","Fareham","Farnborough","Fleet","Fordingbridge","Gosport","Havant","Hayling Island","Hook","Liphook","Liss","Lymington","New Milton","Petersfield","Portsmouth","Ringwood","Romsey","Southampton","Southsea","Tadley","Waterlooville","Winchester","Yateley")
	),	
	array( 	
	"name" => "Herefordshire",
	"vars" => array("Bromyard","Hereford","Kington","Ledbury","Leominster","Ross-on-Wye")
	),		
	array( 	
	"name" => "Hertfordshire",
	"vars" => array("Abbots Langley","Baldock","Barnet","Berkhamsted","Bishop's Stortford","Borehamwood","Broxbourne","Buntingford","Bushey","Harpenden","Hatfield","Hemel Hempstead","Hertford","Hitchin","Hoddesdon","Kings Langley","Knebworth","Letchworth Garden City","Potters Bar","Radlett","Rickmansworth","Royston","Sawbridgeworth","Stevenage","Tring","Waltham Cross","Ware","Watford","Welwyn Garden City","Welwyn")
	),		
	array( 	
	"name" => "Herefordshire",
	"vars" => array("Arisaig","Aviemore","Beauly","Boat of Garten","Carrbridge","Corrour","Dalwhinnie","Fort Augustus","Fort William","Glenfinnan","Invergarry","Inverness","Kingussie","Lochailort","Mallaig","Nethy Bridge","Newtonmore","Roy Bridge","Spean Bridge")
	),	
	array( 	
	"name" => "Isle of Arran",
	"vars" => array("Isle of Arran")
	),		
	array( 	
	"name" => "Isle of Barra",
	"vars" => array("Isle of Barra")
	),			
	array( 	
	"name" => "Isle of Benbecula",
	"vars" => array("Isle of Benbecula")
	),	
	array( 	
	"name" => "Isle of Bute",
	"vars" => array("Isle of Bute")
	),		
	array( 	
	"name" => "Isle of Canna",
	"vars" => array("Isle of Canna")
	),
	array( 	
	"name" => "Isle of Coll",
	"vars" => array("Isle of Coll")
	),	
	array( 	
	"name" => "Isle of Colonsay",
	"vars" => array("Isle of Colonsay")
	),		
	array( 	
	"name" => "Isle of Cumbrae",
	"vars" => array("Isle of Cumbrae")
	),		
	array( 	
	"name" => "Isle of Eigg",
	"vars" => array("Isle of Eigg")
	),	
	array( 	
	"name" => "Isle of Gigha",
	"vars" => array("Isle of Gigha")
	),		
	array( 	
	"name" => "Isle of Harris",
	"vars" => array("Isle of Harris")
	),
	array( 	
	"name" => "Isle of Iona",
	"vars" => array("Isle of Iona")
	),	
	array( 	
	"name" => "Isle of Islay",
	"vars" => array("Isle of Islay")
	),	
	array( 	
	"name" => "Isle of Jura",
	"vars" => array("Isle of Jura")
	),		
	array( 	
	"name" => "Isle of Lewis",
	"vars" => array("Isle of Lewis")
	),	
	array( 	
	"name" => "Isle of Man",
	"vars" => array("Isle of Man")
	),	
	array( 	
	"name" => "Isle of Mull",
	"vars" => array("Isle of Mull")
	),		
	array( 	
	"name" => "Isle of North Uist",
	"vars" => array("Isle of Mull")
	),			
	array( 	
	"name" => "Isle of Rum",
	"vars" => array("Isle of Rum")
	),				
	array( 	
	"name" => "Isle of Scalpay",
	"vars" => array("Isle of Scalpay")
	),	
	array( 	
	"name" => "Isle of Skye",
	"vars" => array("Isle of Skye")
	),		
	array( 	
	"name" => "Isle of South Uist",
	"vars" => array("Isle of South Uist")
	),			
	array( 	
	"name" => "Isle of Tiree",
	"vars" => array("Isle of Tiree")
	),	
	array( 	
	"name" => "Isle of Wight",
	"vars" => array("Bembridge","Cowes","East Cowes","Freshwater","Newport","Ryde","Sandown","Seaview","Shanklin","Totland Bay","Ventnor","Yarmouth")
	),		
	array( 	
	"name" => "Isles of Scilly",
	"vars" => array("Isles of Scilly")
	),
	array( 	
	"name" => "Isles of Scilly",
	"vars" => array("Ashford","Beckenham","Bexleyheath","Broadstairs","Bromley","Canterbury","Chatham","Cranbrook","Dartford","Deal","Dover","Erith","Faversham","Folkestone","Gillingham","Gravesend","Herne Bay","Maidstone","Margate","Orpington","Ramsgate","Rochester","Sevenoaks","Sheerness","Sidcup","Sittingbourne","Tonbridge","Tunbridge Wells","Westerham","Whitstable")
	),	
	array( 	
	"name" => "Kincardineshire",
	"vars" => array("Banchory","Laurencekirk","Stonehaven")
	),	
	array( 	
	"name" => "Kirkcudbrightshire",
	"vars" => array("Castle Douglas","Dalbeattie","Kirkcudbright")
	),				
	array( 	
	"name" => "Lanarkshire",
	"vars" => array("Airdrie","Bellshill","Biggar","Carluke","Coatbridge","Glasgow","Hamilton","Lanark","Larkhall","Motherwell","Shotts","Strathaven","Wishaw")
	),		
	array( 	
	"name" => "Lancashire",
	"vars" => array("Accrington","Ashton-under-Lyne","Blackburn","Blackpool","Bolton","Burnley","Bury","Carnforth","Chorley","Clitheroe","Colne","Darwen","Fleetwood","Heywood","Lancaster","Leigh","Leyland","Manchester","Morecambe","Nelson","Oldham","Ormskirk","Poulton-le-Fylde","Preston","Rochdale","Rossendale","Salford","Skelmersdale","Thornton-Cleveleys","Wigan")
	),		
	array( 	
	"name" => "Leicestershire",
	"vars" => array("Ashby-de-la-Zouch","Coalville","Hinckley","Ibstock","Leicester","Loughborough","Lutterworth","Market Harborough","Markfield","Melton Mowbray","Oakham","Wigston")
	),		
	array( 	
	"name" => "Kirkcudbrightshire",
	"vars" => array("Alford","Boston","Bourne","Cleethorpes","Gainsborough","Grantham","Horncastle","Immingham","Lincoln","Louth","Mablethorpe","Market Rasen","Scunthorpe","Skegness","Sleaford","Spalding","Spilsby","Stamford","Woodhall Spa")
	),
	array( 	
	"name" => "London",
	 
	),		
	array( 	
	"name" => "Merseyside",
	"vars" => array("Birkenhead","Bootle","Ellesmere Port","Liverpool","Neston","Newton-le-Willows","Prenton","Prescot","Southport","St Helens","Wallasey","Wirral")
	),		
	array( 	
	"name" => "Merseyside",
	"vars" => array("Aberdare","Bargoed","Bridgend","Caerphilly","Ferndale","Hengoed","Maesteg","Merthyr Tydfil","Mountain Ash","Pentre","Pontyclun","Pontypridd","Porthcawl","Porth","Tonypandy","Treharris","Treorchy")
	),		
	array( 	
	"name" => "Middlesex",
	"vars" => array("Ashford","Brentford","Edgware","Enfield","Feltham","Greenford","Hampton","Harrow","Hayes","Hounslow","Isleworth","Northolt","Northwood","Pinner","Ruislip","Shepperton","Southall","Staines","Stanmore","Sunbury-on-Thames","Teddington","Twickenham","Uxbridge","Wembley","West Drayton")
	),		
	array( 	
	"name" => "Midlothian",
	"vars" => array("Balerno","Bonnyrigg","Currie","Dalkeith","Edinburgh","Gorebridge","Heriot","Juniper Green","Kirknewton","Lasswade","Loanhead","Musselburgh","Newbridge","Pathhead","Penicuik","Rosewell","Roslin")
	),		
	array( 	
	"name" => "Morayshire",
	"vars" => array("Elgin","Fochabers","Forres","Grantown-on-Spey","Lossiemouth","Nairn")
	),		
	array( 	
	"name" => "Norfolk",
	"vars" => array("Attleborough","Cromer","Dereham","Diss","Downham Market","Fakenham","Great Yarmouth","Harleston","Holt","Hunstanton","King's Lynn","Melton Constable","North Walsham","Norwich","Sandringham","Sheringham","Swaffham","Thetford","Walsingham","Wells-next-the-Sea","Wymondham")
	),			
	array( 	
	"name" => "North Humberside",
	"vars" => array("Beverley","Bridlington","Brough","Cottingham","Driffield","Goole","Hessle","Hornsea","Hull","North Ferriby","Withernsea")
	),
	array( 	
	"name" => "North Yorkshire",
	"vars" => array("Bedale","Catterick Garrison","Filey","Harrogate","Hawes","Knaresborough","Leyburn","Malton","Northallerton","Pickering","Richmond","Ripon","Scarborough","Selby","Settle","Skipton","Tadcaster","Thirsk","Whitby","York")
	),	
	array( 	
	"name" => "Northamptonshire",
	"vars" => array("Brackley","Corby","Daventry","Kettering","Northampton","Rushden","Towcester","Wellingborough")
	),	
	array( 	
	"name" => "Northumberland",
	"vars" => array("Alnwick","Ashington","Bamburgh","Bedlington","Belford","Berwick-upon-Tweed","Blyth","Chathill","Choppington","Corbridge","Cornhill-on-Tweed","Cramlington","Haltwhistle","Hexham","Mindrum","Morpeth","Newbiggin-by-the-Sea","Prudhoe","Riding Mill","Seahouses","Stocksfield","Wooler","Wylam")
	),				
	array( 	
	"name" => "Nottinghamshire",
	"vars" => array("Mansfield","Newark","Nottingham","Retford","Southwell","Sutton-in-Ashfield","Worksop")
	),	
	array( 	
	"name" => "Orkney",
	"vars" => array("Kirkwall","Orkney","Stromness")
	),		
	array( 	
	"name" => "Orkney",
	"vars" => array("Abingdon","Bampton","Banbury","Bicester","Burford","Carterton","Chinnor","Chipping Norton","Didcot","Faringdon","Henley-on-Thames","Kidlington","Oxford","Thame","Wallingford","Wantage","Watlington","Witney","Woodstock")
	),		
	array( 	
	"name" => "Peeblesshire",
	"vars" => array("Innerleithen","Peebles","Walkerburn","West Linton")
	),		
	array( 	
	"name" => "Perthshire",
	"vars" => array("Aberfeldy","Auchterarder","Blairgowrie","Callander","Crianlarich","Crieff","Doune","Dunblane","Dunkeld","Killin","Kinross","Lochearnhead","Perth","Pitlochry")
	),
	array( 	
	"name" => "Powys",
	"vars" => array("Brecon","Builth Wells","Caersws","Crickhowell","Knighton","Llanbrynmair","Llandinam","Llandrindod Wells","Llanfechain","Llanfyllin","Llangammarch Wells","Llanidloes","Llansantffraid","Llanwrtyd Wells","Llanymynech","Machynlleth","Meifod","Montgomery","Newtown","Presteigne","Rhayader","Welshpool")
	),	
	array( 	
	"name" => "Renfrewshire",
	"vars" => array("Bishopton","Bridge of Weir","Erskine","Gourock","Greenock","Johnstone","Kilmacolm","Lochwinnoch","Paisley","Port Glasgow","Renfrew","Wemyss Bay")
	),			
	array( 	
	"name" => "Ross-Shire",
	"vars" => array("Achnasheen","Alness","Avoch","Cromarty","Dingwall","Fortrose","Gairloch","Garve","Invergordon","Kyle","Muir of Ord","Munlochy","Plockton","Strathcarron","Strathpeffer","Strome Ferry","Tain","Ullapool")
	),	
	array( 	
	"name" => "Roxburghshire",
	"vars" => array("Hawick","Jedburgh","Kelso","Melrose","Newcastleton")
	),		
	array( 	
	"name" => "Selkirkshire",
	"vars" => array("Galashiels","Selkirk")
	),	
	array( 	
	"name" => "Shetland", 
	),	
	array( 	
	"name" => "Shropshire",
	"vars" => array("Bishops Castle","Bridgnorth","Broseley","Bucknell","Church Stretton","Craven Arms","Ellesmere","Ludlow","Lydbury North","Market Drayton","Much Wenlock","Newport","Oswestry","Shifnal","Shrewsbury","Telford","Whitchurch")
	),	
	array( 	
	"name" => "Somerset",
	"vars" => array("Axbridge","Bridgwater","Bruton","Burnham-on-Sea","Castle Cary","Chard","Cheddar","Crewkerne","Dulverton","Frome","Glastonbury","Highbridge","Ilminster","Langport","Martock","Merriott","Minehead","Shepton Mallet","Somerton","South Petherton","Stoke-sub-Hamdon","Street","Taunton","Templecombe","Watchet","Wedmore","Wellington","Wells","Wincanton","Yeovil")
	),	
	array( 	
	"name" => "South Glamorgan",
	"vars" => array("Barry","Cardiff","Cowbridge","Dinas Powys","Llantwit Major","Penartha")
	),	
	array( 	
	"name" => "South Humberside",
	"vars" => array("Barnetby","Barrow-upon-Humber","Barton-upon-Humber","Brigg","Cleethorpes","Grimsby","Immingham","Scunthorpe","Ulceby")
	),	
	array( 	
	"name" => "South Yorkshire",
	"vars" => array("Barnsley","Doncaster","Mexborough","Rotherham","Sheffield")
	),	
	array( 	
	"name" => "Staffordshire",
	"vars" => array("Burntwood","Burton-on-Trent","Cannock","Leek","Lichfield","Newcastle","Rugeley","Stafford","Stoke On Trent","Stoke-on-Trent","Stone","Tamworth","Uttoxeter")
	),	
	array( 	
	"name" => "Stirlingshire",
	"vars" => array("Bonnybridge","Denny","Falkirk","Grangemouth","Larbert","Stirling")
	),		
	array( 	
	"name" => "Suffolk",
	"vars" => array("Aldeburgh","Beccles","Brandon","Bungay","Bures","Bury St Edmunds","Felixstowe","Halesworth","Haverhill","Ipswich","Leiston","Lowestoft","Newmarket","Saxmundham","Southwold","Stowmarket","Sudbury","Woodbridge")
	),		
	array( 	
	"name" => "Surrey",
	"vars" => array("Camberley","Carshalton","Caterham","Chertsey","Coulsdon","Croydon","Dorking","Egham","Epsom","Farnham","Godalming","Guildford","Haslemere","Horley","Kingston upon Thames","Leatherhead","Mitcham","Morden","New Malden","Redhill","Reigate","Richmond","South Croydon","Surbiton","Sutton","Thornton Heath","Wallington","Walton-on-Thames","Weybridge","Woking")
	),
	
	array( 	
	"name" => "Sutherland",
	"vars" => array("Ardgay","Brora","Dornoch","Forsinard","Golspie","Helmsdale","Kinbrace","Lairg","Rogart")
	),	
	array( 	
	"name" => "Tyne and Wear",
	"vars" => array("Blaydon-on-Tyne","Boldon Colliery","East Boldon","Gateshead","Hebburn","Houghton le Spring","Jarrow","Newcastle upon Tyne","North Shields","Rowlands Gill","Ryton","South Shields","Sunderland","Wallsend","Washington","Whitley Bay")
	),
	array( 	
	"name" => "Warwickshire",
	"vars" => array("Alcester","Atherstone","Bedworth","Kenilworth","Leamington Spa","Nuneaton","Rugby","Shipston-on-Stour","Southam","Stratford-upon-Avon","Studley","Warwick")
	),			
	array( 	
	"name" => "West Glamorgan",
	"vars" => array("Neath","Port Talbot","Swansea")
	),	
	array( 	
	"name" => "West Lothian",
	"vars" => array("Bathgate","Bo'ness","Broxburn","Kirkliston","Linlithgow","Livingston","Peebles","South Queensferry","West Calder")
	),			
	array( 	
	"name" => "West Glamorgan",
	"vars" => array("Bilston","Birmingham","Brierley Hill","Coventry","Cradley Heath","Dudley","Halesowen","Henley-in-Arden","Kingswinford","Oldbury","Rowley Regis","Smethwick","Solihull","Stourbridge","Sutton Coldfield","Tipton","Walsall","Wednesbury","West Bromwich","Willenhall","Wolverhampton")
	),	
	array( 	
	"name" => "West Sussex",
	"vars" => array("Arundel","Billingshurst","Bognor Regis","Burgess Hill","Chichester","Crawley","East Grinstead","Gatwick","Hassocks","Haywards Heath","Henfield","Horsham","Lancing","Littlehampton","Midhurst","Petworth","Pulborough","Shoreham-by-Sea","Steyning","Worthing")
	),		
	array( 	
	"name" => "West Yorkshire",
	"vars" => array("Batley","Bingley","Bradford","Brighouse","Castleford","Cleckheaton","Dewsbury","Elland","Halifax","Hebden Bridge","Heckmondwike","Holmfirth","Huddersfield","Ilkley","Keighley","Knottingley","Leeds","Liversedge","Mirfield","Normanton","Ossett","Otley","Pontefract","Pudsey","Shipley","Sowerby Bridge","Wakefield","Wetherby")
	),		
	array( 	
	"name" => "Wigtownshire",
	"vars" => array("Newton Stewart","Stranraer")
	),				
	array( 	
	"name" => "Wigtownshire",
	"vars" => array("Bradford-on-Avon","Calne","Chippenham","Corsham","Devizes","Malmesbury","Marlborough","Melksham","Pewsey","Salisbury","Swindon","Trowbridge","Warminster","Westbury")
	),
	array( 	
	"name" => "Worcestershire",
	"vars" => array("Bewdley","Broadway","Bromsgrove","Droitwich","Evesham","Kidderminster","Malvern","Pershore","Redditch","Stourport-on-Severn","Tenbury Wells","Worcester")
	),		
																									
);

 

		$taxType = "location";
		if(isset($_GET['cat']) && $_GET['cat'] == 1){ $taxType = "category"; }
		
		foreach($states as $value){  
		
			if ( is_term( $value['name'] , $taxType ) ){
				$term = get_term_by('name', str_replace("_"," ",$value['name']), $taxType );
				$taxID = $term->term_id;
			}else{
				$args = array('cat_name' => str_replace("_"," ",$value['name']) ); 
				$term = wp_insert_term(str_replace("_"," ",$value['name']), $taxType, $args);				
				$taxID = $term['term_id'];				
			}
		 	
			if(is_array($value['vars'])){
				foreach($value['vars'] as $sub){
					wp_insert_term($sub, $taxType, array( 'parent' => $taxID ));
				}
			}
			 
		} 	
		echo "<h1>Action Successfull</h1>";
		die();
		} break;				
				
		
		default:  { die("nothing happened!"); } 
	} // END SWITCH

}// END IF
}// END IF ADMIN

	 
	 //$PPTImport 		= new PremiumPressTheme_Import;	 
	 // $PPTImport->IMPORTSWITCH('hourly');
	 // die('finished');	
 
?>

<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_setup.png" align="middle"> Tools</h3>  						 
<ul>
	<li><a rel="premiumpress_tab1" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="1"){ echo 'class="active"';}elseif(!isset($_POST['showThisTab'])){ echo 'class="active"'; } ?>>CSV Import</a></li>
    <li><a rel="premiumpress_tab2" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="2"){ echo 'class="active"';} ?>>Category/Taxonomy</a></li>
    <?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress"){ ?> 
    <li><a rel="premiumpress_tab3" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="3"){ echo 'class="active"';} ?>>Database</a></li>
    <li><a rel="premiumpress_tab4" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="4"){ echo 'class="active"';} ?>>Domz</a></li>
   
    <?php } ?>
    <li><a rel="premiumpress_tab6" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="6"){ echo 'class="active"';} ?>>Feed Import</a></li>
      <li><a rel="premiumpress_tab5" href="#" <?php if(isset($_POST['showThisTab']) && $_POST['showThisTab'] =="5"){ echo 'class="active"';} ?>>Modules</a></li>
      
</ul>
</div>






<div id="premiumpress_tab5" class="content"> 





<div class="grid400-left">





<fieldset>
<div class="titleh"><h3>System Cleanup Modules</h3></div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Country/State/City</span>	 
 <a href="admin.php?page=tools&amp;task=delete1&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All</a>
 <a href="admin.php?page=tools&task=import1&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button-primary" >Import Sample Data</a>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Categories</span>	 
<a href="admin.php?page=tools&amp;task=delete2&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Categories</a>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Tags</span>	 
 <a href="admin.php?page=tools&amp;task=delete3&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Tags</a>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Posts</span>	 
 <a href="admin.php?page=tools&amp;task=delete4&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Posts</a>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Pages</span>	 
 <a href="admin.php?page=tools&amp;task=delete6&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Pages</a> 

<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Articles</span>	 
 <a href="admin.php?page=tools&amp;task=delete7&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Articles</a> 

<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">FAQ</span>	 
 <a href="admin.php?page=tools&amp;task=delete8&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All FAQs</a> 

<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Saved Revisions</span>	 
<a href="admin.php?page=tools&amp;task=delete5&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Revisions</a>

<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Messages</span>	 
 <a href="admin.php?page=tools&amp;task=delete9&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Messages</a> 

<div class="clearfix"></div>
</div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">Email Alerts</span>	 
 <a href="admin.php?page=tools&amp;task=delete10&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Email Alerts</a> 

<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Orders</span>	 
 <a href="admin.php?page=tools&amp;task=delete11&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button" >Delete All Orders</a> 

<div class="clearfix"></div>
</div>

 
</fieldset>


<fieldset>
<div class="titleh"><h3>Extra Modules</h3></div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">UK Provice/City</span>	 
 <a href="admin.php?page=tools&task=import11&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button-primary" >Import As Taxonomy</a>  
<div class="clearfix"></div> <br />
 <a href="admin.php?page=tools&task=import11&cat=1&amp;TB_iframe=true&amp;width=640&amp;height=100" class="thickbox button-primary" style="margin-left:140px;">Import As Category</a>  

<div class="clearfix"></div>
</div>

</fieldset><?php /**/ ?>



</div>

<div class="grid400-left last">
<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "directorypress"){ ?> 
<fieldset>
<div class="titleh"><h3>Broken Link Checker </h3></div>  

<form class="fields" style="padding:10px;" method="post" target="_self" >
<input name="borken_links" type="hidden" value="yes" />
 <input type="hidden" value="5" name="showThisTab" id="showThisTab" />

<?php if(isset($_POST['borken_links'])){ ?>
<table width="100%"  border="0">
  <tr style="background:#666; height:30px;">
    <td style="color:#fff; width:55px; text-align:center;">&nbsp;ID</td>
    <td style="color:#fff;">&nbsp;Title / Link</td>
    <td style="color:#fff;">&nbsp;Edit</td>
  </tr>
<?php
global $wpdb;
$SQL = "SELECT $wpdb->posts.post_title, $wpdb->posts.ID, $wpdb->posts.post_title, $wpdb->postmeta.*
		FROM $wpdb->posts, $wpdb->postmeta
		WHERE $wpdb->postmeta.meta_key ='url' AND ( $wpdb->posts.ID = $wpdb->postmeta.post_id )	";
 
$result = mysql_query($SQL);
while ($row = mysql_fetch_assoc($result)) { 
$error =  checkDomainAvailability($row['meta_value']);
if($error != 1){
?>
  <tr>
    <td style="text-align:center;"><?php echo $row['ID']; ?></td>
    <td><?php echo $row['post_title']; ?> <br /> <?php echo $error; ?> <a href="<?php echo $row['meta_value']; ?>" target="_blank">+</a></td>
    <td><a href="post.php?action=edit&post=<?php echo $row['ID']; ?>">Edit</a></td>
  </tr>
<?php } } ?>
</table>

<?php }else{ ?>
<input class="button" type="submit" value="Check for broken links" />
<?php } ?>
 
</form>

</fieldset>
<?php } ?>
</div>
<div class="clearfix"></div>
</div>
 

































<div id="premiumpress_tab1" class="content"> 


<div class="grid400-left">


<fieldset>
<div class="titleh"> <h3>
 <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" />

CSV File Import

 <a href="http://www.premiumpress.com/tutorial/importing-items-using-excel/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>

</h3>  </div>

<form class="fields" method="post" target="_self" enctype="multipart/form-data"  style="padding:10px;">
<input name="csvimport" type="hidden" value="yes" />
 <input type="hidden" value="" name="showThisTab" id="showThisTab" />

<input type="file" name="import"  style="width: 350px; font-size:14px;">
 

<div class="ppt-form-line">	
<span class="ppt-labeltext"><b>OR</b> Select CSV File

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>How does this work?</b><br>If you are having problems importing large CSV files to your hosting account it maybe easier to upload them via FTP instead. <br><br><b>Where should i put my CSV file?</b></br> Upload your CSV file to your 'thumbs' folder within your theme installation, if uploaded correctly it will be displayed in this list.<br>  Your thumbs folder path: <br /> <small><?php print get_option("imagestorage_path"); ?>thumbs/</small> &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>	 
<select   name="file_csv" class="ppt-forminput" style="width:200px;">
<option value="0">-- --- NO CSV FILE -- -- </option>
		<?php
	   
		$path = FilterPath();
	    $HandlePath =  $path."wp-content/themes/".strtolower(constant('PREMIUMPRESS_SYSTEM'))."/thumbs/";
 		$HandlePath = str_replace("//","/",str_replace("wp-admin","",$HandlePath));

	    $count=1;
		if($handle1 = opendir($HandlePath)) {
      
	  	while(false !== ($file = readdir($handle1))){	

		if(substr(strtolower($file),-4) ==".csv"){
	
		?>
			<option value="<?php echo $file; ?>"><?php echo $file; ?></option>
		<?php
		} }}
		?>	 
</select>
<div class="clearfix"></div>
<br  />
<a href="javascript:void(0);" onclick="toggleLayer('mops');" style="float:right;">more options</a>

</div>    
 


<div style="display:none;" id="mops">



<div class="ppt-form-line">	
<span class="ppt-labeltext">Import Type</span>	 
<select   name="type" class="ppt-forminput"><option value="posts" selected>Wordpress Posts</option><option value="users">Wordpress Members</option></select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Column Delimiter</span>	 
<input name="del" type="text" class="ppt-forminput"  value="," size="5">
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Enclosure</span>	 
<input name="enc" type="text" class="ppt-forminput"  value="/" size="5">
<div class="clearfix"></div>
</div>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Column Headings</span>	 
<select   name="heading"><option value="yes">Yes</option><option value="no" selected>No</option></select>
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Remove Quotes</span>	 
<select   name="rq"><option value="yes">Yes</option><option value="no" selected>No</option></select>
<div class="clearfix"></div>
</div>
 
 
<br />





<label><b>Select which category to add imported items too.</b></label>
<p class="ppnote">Note: You only need to select a category if your CSV file doesn't include a category already.</p>
<div style="background:#eee; padding:8px;">
<select name="csv[cat][]" multiple="multiple" style="width:350px;">
<?php echo premiumpress_categorylist(explode(",",get_option('article_cats')),false,false,"category",0,true); ?></select><br />
<small>Hold CTRL to select multiple values</small>
<div class="clearfix"></div>   
</div>	 
 
</div>
 <div class="clearfix"></div>
 
<div class="ppt-form-line">          
<input class="premiumpress_button" type="submit" value="<?php _e('Start Import','cp')?>" style="color:white;" />
 </div>
 

</form>


</fieldset>




 <fieldset >
<legend><strong>Download CSV File</strong></legend>
<p>Click the link below to download a ready formatted CSV file for all the existing products/listings on your website.</p>

<p><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/import.png" align="absmiddle" /> <a href="?downloadcsv=1">Download CSV File</a></p>
 <br />
 
<div class="msg msg-info">
  <p>
<b>Note.</b> Before re importing this file, save it as a <u>Windows Format</u> CSV (comma delimited) file using excel.</p>
</div> 
 </fieldset>







</div>
<div class="grid400-left last">
 

<div class="videobox" id="videobox1">
<a href="javascript:void(0);" onclick="PlayPPTVideo('9mWID9hD4hI','videobox1');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/2.jpg" align="absmiddle" /></a>
</div>



</div>




<div class="clearfix"></div>
</div>











<div id="premiumpress_tab2" class="content"> 


<div class="grid400-left">
<fieldset>
<div class="titleh"> <h3>

 <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" />

Category/Taxonomy Import Tool

 <a href="http://www.premiumpress.com/tutorial/categorytaxonomy-import-tool/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3>  </div>


<form class="fields" style="padding:10px;" method="post" target="_self" >
<input name="submitted" type="hidden" value="yes" />
<input name="catme" type="hidden" value="yes" />
<input type="hidden" value="2" name="showThisTab" id="showThisTab" />
<p class="ppnote">Creating lots of categories is time consuming, this tools allows you to create lots of categories quickly. Enter a list of categories below, separating each with a comma. Eg. cat1,cat2,cat3</p>
<textarea name="cats" style="height:100px;width:350px;" class="ppt-forminput"></textarea><br />

<?php /*<label>Parent Category</label>
<small>Select a parent category below if you would like the list to be created as sub categories, leave blank to create parent categories.</small><br />
<select name="pcat" style="width: 250px;" class="ppt-forminput" >
<option value="0">------------</option>
<?php echo premiumpress_categorylist(); ?>
</select> */ ?>

<label>Import Into: </label>
 <select name="tax" style="width: 250px;" class="ppt-forminput" >
<option value="category">Category List</option>
<option value="location">Country/State/City List</option>

<?php if(strtolower(PREMIUMPRESS_SYSTEM) == "couponpress"){ ?> 
 <option value="store">Store List</option>
 <option value="network">Network List</option>
<?php } 

$taxArray = get_option("ppt_custom_tax");
$dd=0; 
while($dd < 13){
	if($dd == 1 || ( isset($taxArray[$dd]['title']) && $taxArray[$dd]['title'] !="" ) ){
	
	echo '<option value="'.$taxArray[$dd]['name'].'">'.$taxArray[$dd]['title'].'</option>';
	}
$dd++; 
}
 

?> 
 
</select>


<br /><br />
<input class="premiumpress_button" type="submit" value="Create Categories" style="color:white;" />
 
 <hr />
 
 
<p class="ppnote1">Note. If importing sub-categories you need to refresh the WordPress AFTER import. Do this by simply editing the parent category after import and clicking save, the save process will refresh the WordPress cache and show your sub categories.</p>
</form>
 
</fieldset>
</div>
 
<div class="grid400-left last">
 <div class="videobox" id="videobox2">
<a href="javascript:void(0);" onclick="PlayPPTVideo('IHXvN8kUDAY','videobox2');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/3.jpg" align="absmiddle" /></a>
</div>
</div>


<div class="clearfix"></div>
</div>











<div id="premiumpress_tab3" class="content"> 


<div class="grid400-left">
<fieldset>
<div class="titleh">

<h3>

 <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" />

Database Import Tool

 <a href="http://www.premiumpress.com/tutorial/database-import-tool/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>



</h3></div> 
 
<form class="fields" style="padding:10px;" method="post" target="_self" >
<input name="premiumpress_import" type="hidden" value="yes" />
 <input type="hidden" value="3" name="showThisTab" id="showThisTab" />
<p>Remember, the system you select below must be installed onto the SAME database as your Wordpress installation.</p>
<legend><strong>Select Your System</strong></legend>

<label><input name="system" type="radio" value="esyndicate" checked="checked"> eSyndicate</label>
<small>More information about esyndicat.com can be <a href="http://www.intelliants.com/affiliates/xp.php?id=16800" target="_blank">found here.</a></small><br />

<label><input name="system" type="radio" value="phpld"> phpLD</label>
<small>More information about phplinkdirectory can be <a href="http://www.phplinkdirectory.com" target="_blank"> found here.</a> </small><br />

<label><input name="system" type="radio" value="phplinkbid"> php Link Bid</label>
<small>More information about phplinkbid can be <a href="http://www.phplinkbid.com" target="_blank">found here.</a></small><br />

<label><input name="system" type="radio" value="linkbidscript"> Link Bid Script</label>
<small>More information about phplinkbid can be <a href="http://www.linkbidscript.com/" target="_blank">found here.</a></small><br />


<label><input name="system" type="radio" value="edirectory"> eDirectory</label>
<small>More information about eDirectory can be <a href="http://www.edirectory.com" target="_blank">found here.</a></small><br />

<label><input name="system" type="radio" value="edirectory1"> eDirectory *New Releases*</label>
<small>More information about eDirectory can be <a href="http://www.edirectory.com" target="_blank">found here.</a></small><br />

  
<label>Table Prefix</label>
<input type="text" name="table_prefix" value=""><br />
<small>If you have installed your database with a prefix, enter it above.</small><br />
 

<input class="premiumpress_button" type="submit" value="Import Database" style="color:white;" onclick="document.getElementById('showThisTab').value=3" />
 
</form>
 </fieldset>
</div>

<div class="grid400-left last">

 
<div class="videobox" id="videobox553" >
<a href="javascript:void(0);" onclick="PlayPPTVideo('D5wqyrkamdc','videobox553');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/9.jpg" align="absmiddle" /></a>
</div> 
 
</div>


<div class="clearfix"></div>
</div>






<div id="premiumpress_tab4" class="content"> 


<div class="grid400-left">
<fieldset>
<div class="titleh"><h3>

 <img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" />

Dmoz Import Tool

 <a href="http://www.premiumpress.com/tutorial/dmoz-import-tool/?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-right:10px;" /></a>


</h3></div> 


<form class="fields" style="padding:10px;" method="post" target="_self" >
<input name="domz" type="hidden" value="yes" />
 <input type="hidden" value="4" name="showThisTab" id="showThisTab" />

<div class="ppt-form-line">	
<span class="ppt-labeltext">DMOZ Link </span>	 
 
<input type="text" name="domz_link" value="" class="ppt-forminput">
<div class="clearfix"></div>
</div>
 
			<p class="ppnote">Select the link from the dmoz website to extract the content, example: http://www.dmoz.org/Arts/Animation/</p>



 <p>Import Into Which Category?</p>
 
 <select name="import[cat][]" multiple="multiple" style="width:350px; height:250px;">
<?php echo premiumpress_categorylist(explode(",",get_option('article_cats')),false,false,"category",0,true); ?></select><br />
       <small>Hold CTRL to select multiple values</small>
<div class="clearfix"></div>       
 
<input class="premiumpress_button" type="submit" value="Import Now" style="color:white;" onclick="document.getElementById('showThisTab').value=4" />
 
</form> 
</fieldset> 




</div>

<div class="grid400-left last">

 

</div>


<div class="clearfix"></div>
</div>
 



<div id="premiumpress_tab6" class="content"> 

<div id="runfeedbox" style="display:none;">
<div class="yellow_box"><div class="yellow_box_content">
<img src="<?php echo PPT_FW_IMG_URI; ?>/loading.gif" style="float:left; padding-right:30px; padding-bottom:80px;" /> 

<h3>Feed Import Started, Please Wait...</h3>
<p>Feed imports can take along time to process depending on how big the feed file is.</p>
<p><b>Note</b> If you experience any time-out errors such as the page goes blank, white, or you get the message 'Fatal error: Allowed memory size..' you need to contact your hosting provider and ask them to increase your hosting account memory limits.</p>
<div class="clearfix"></div>
</div></div>
</div>

<div class="grid400-left" id="feedboxleft">



<form method="post" target="_self" name="runFeed" id="runFeed">
<input name="runFeedID" id="runFeedID" type="hidden" value="" /> 
 <input type="hidden" value="6" name="showThisTab" id="showThisTab" />
</form>
<form method="post" target="_self" enctype="multipart/form-data">
<input name="submitted" type="hidden" value="yes" />
<input name="submit" type="hidden" value="1" />
 <input type="hidden" value="6" name="showThisTab" id="showThisTab" />

<?php

// STUPID BUT NEEDED FOR CUSTOM FIELDS
 $querystr = "
    SELECT $wpdb->posts.ID 
    FROM $wpdb->posts 
    WHERE $wpdb->posts.post_status = 'publish' 
	AND $wpdb->posts.post_type = 'post' 
    ORDER BY $wpdb->posts.post_date DESC LIMIT 1 ";

 $POO = $wpdb->get_results($querystr, ARRAY_A);
 

 
$selectArray=array();
$selectArray[0] = "---------------";
$selectArray['post_title'] 		= "Post Default - Title";
$selectArray['post_content'] 	= "Post Default - Content (big description)";
$selectArray['post_excerpt'] 	= "Post Default - Excerpt (short description";
$selectArray['post_status'] 	= "Post Default - Status (publish/draft)";
$selectArray['post_type'] 		= "Post Default - Type (post/article/faq)";
$selectArray['post_author'] 	= "Post Default - Author (1)";
$selectArray['category'] 		= "Post Default - Category";
$selectArray['image'] 			= "Post Default - Image";
$selectArray['post_date'] 		= "Post Default - Date";

 
$selectArray[1] = "---------------";

if(is_numeric($POO[0]['ID'])){
$custom_field_keys = get_post_custom_keys($POO[0]['ID']);
if(is_array($custom_field_keys)){
  foreach ( $custom_field_keys as $value ) { 
    $valuet = trim($value);
      if ( '_' == $valuet{0} )
      continue;
	  $selectArray[$valuet] = "Custom Field - ".$valuet."";
    
  } 
}
}
$selectArray['price'] 			= "Custom Field - Price (NOW)";
$selectArray['old_price'] 		= "Custom Field - Old Price (WAS)";
$selectArray['link'] 			= "Custom Field - Buy/Affiliate Link";
$selectArray['url'] 			= "Custom Field - Website Link";
$selectArray[2] = "---------------";
$selectArray['custom'] = "Custom Field - SAVE AS NEW";
$selectArray['SKU'] 	= "SKU - Unique ID to prevent duplicates";
$catlist = premiumpress_categorylist('',false,false);

if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "couponpress"){ 

$selectArray['starts'] 		= "Custom Field - Start Date";
$selectArray['pexpires'] 	= "Custom Field - End Date";
$selectArray['code'] 		= "Custom Field - Coupon Code";
}
$selectArray[1] = "---------------";


$i=0; $viscount=1; 

// LOAD AT THE TOP SO WE CAN USE THOUGHOUT
$feeddata = get_option("feeddatadata");  
if(is_array($feeddata)){

	foreach($feeddata as $feed){ //print_r($feed);
?>




<input type="hidden" name="feeddata[ID][]" value="<?php echo $feed['ID']; ?>" />

<div id="CF<?php echo $i; ?>">

<?php if(isset($feed['format']) && substr($feed['format'],-7) == "unknown"){ ?>
<br /><div class="msg msg-warn"><p>Your XML feed <b>format</b> could not be auto detected. You will need to manually adjust the format below for the import to be successfully imported.</p></div>

<?php } ?>  

<?php if(isset($feed['format']) && isset($feed['mapdata']) && !is_array($feed['mapdata']) ){  ?>
<br /><div class="msg msg-warn"><p>No data could be retrieved for this feed. Try adjusting the format below or try a new feed.</p></div>
<?php } ?>

<div class="green_box"><div class="green_box_content">

<p><b><?php if(isset($feed['name'])){ echo $feed['name']; } ?></b> <span style="float:right;">Feed ID:#<?php echo $feed['ID']; ?></span></p>
 
 
 
<p><b>Feed Data Source</b> (anything over 200k we recommend upload)
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>What is this?</b><br>Feed source is a file or link to a file that contains the data you are going to be importing. <br><br>If the file size is small you can simply enter the http:// web path to the file and the system will import it directly however if the file is over 200KB we strongly recommend you upload it to your thumbs folder and select it from the drop down list.<br><br><b>Where do i upload it?</b> Upload all feed files to your 'thumbs' folder;<br><br> (/wp-content/themes/<?php echo strtolower(PREMIUMPRESS_SYSTEM); ?>/thumbs/) <br><br>once uploaded you can then select it from the feed list.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</p>
<table width="250" border="0">
  <tr>
    <td  style="padding:0px; margin:0px;"><input name="feeddata[url][]" type="text" id="feedurl<?php echo $i; ?>"  class="ppt-forminput" 
    
    <?php if(strlen($feed['url']) == 0 && $feed['csv'] == ""){ ?>onfocus="this.value=''" style="color:#999;width:170px" value="Feed Link (http://)" <?php }else{ ?> style="width:170px" value="<?php  echo $feed['url'];  ?>" <?php } ?>  /></td>
    <td  style="padding:0px; margin:0px;font-size:9px;">&nbsp; OR &nbsp;</td>
    <td  style="padding:0px; margin:0px;"><select name="feeddata[csv][]" class="ppt-forminput" style="width:170px" onChange="document.getElementById('feedurl<?php echo $i; ?>').value='';document.getElementById('forMatFeed<?php echo $i; ?>').value='';jQuery('#csvbox<?php echo $i; ?>').show();">
<option value="0">----- XML/CSV FILE ----</option>
		<?php
 
	    $HandlePath =  get_option('imagestorage_path'); 

	    $count=1;
		if($handle1 = opendir($HandlePath)) {
      
	  	while(false !== ($file = readdir($handle1))){	

		if(substr(strtolower($file),-4) ==".csv" || substr(strtolower($file),-4) ==".xml"){
		
			if(isset($feed['csv']) &&  $feed['csv'] == $file){
				echo '<option value="'.$file.'" selected=selected>'.$file.'</option>';
			}else{
				echo '<option value="'.$file.'">'.$file.'</option>';
			}
	
		 
		} }}
		?>	 
</select></td>
  </tr>
</table>

 

<div class="clearfix"></div> 
<a href="javascript:void(0);" onclick="toggleLayer('delim<?php echo $i; ?>');" style="margin-left:140px;float:right; <?php if($feed['csv'] == ""){ ?>display:none;<?php } ?>" id="csvbox<?php echo $i; ?>">csv options</a>
<div class="clearfix"></div> 
<span style="margin-left:140px;font-size:10px;display:none;" id="delim<?php echo $i; ?>" >CSV Delimiter: <input name="feeddata[delimiter][]" class="ppt-forminput" style="width:40px; font-size:10px;" value="<?php if(isset($feed['delimiter']) && strlen($feed['delimiter']) > 0 ){ echo $feed['delimiter']; } ?>"></span>
 

 
<div class="clearfix"></div>
<br /> 
<a href="javascript:void(0);" onclick="document.getElementById('feedname<?php echo $i; ?>').value=''; jQuery('#CF<?php echo $i; ?>').hide();" class="button tagadd" style="float:right">Delete Feed</a>

<a href="javascript:void(0);" onclick="toggleLayer('options<?php echo $i; ?>').show();" class="button tagadd">Show Options</a> 




<?php 

// CHECK TO SEE IF A MAP DATA VALUE HAS BEEN FILLED
$canimport = false; 

if(isset($feed['mapdata']) && is_array($feed['mapdata']) ){ foreach($feed['mapdata'] as $data){   if(isset($feed[$feed['ID']][$data['key']]) && strlen($feed[$feed['ID']][$data['key']]) > 1){ $canimport = true; }  } } 

if($canimport){

?>
<a href="javascript:void(0);" onclick="jQuery('#runfeedbox').show();jQuery('#feedboxleft').hide();jQuery('#feedboxright').hide();document.getElementById('runFeedID').value=<?php echo $i; ?>;document.runFeed.submit();" class="button-primary">Run Import</a>
 	 
<?php } ?>
 
 

 
<div id="options<?php echo $i; ?>" style="display:none; margin-top:40px;">




<h3>-------------------------- Import Settings --------------------------</h3> 
<p>Here are additional feed settings for you to configure.</p> 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Feed Name

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;This is the display caption for your feed. Remove the name to delete the field..&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>

</span>
<input type="text" class="ppt-forminput" id="feedname<?php echo $i; ?>" name="feeddata[name][]"  value="<?php if(isset($feed['name'])){ echo $feed['name']; } ?>" size="35"> 
<div class="clearfix"></div>     
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Feed Format

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;Remove value to auto detected format.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>
<input type="text" id="forMatFeed<?php echo $i; ?>" class="ppt-forminput" name="feeddata[format][]"  value="<?php if(isset($feed['format'])){ echo $feed['format']; } ?>" size="35">
<div class="clearfix"></div>
</div>
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Import Category

<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;The is the category the system will use if no category is added as part of the feed import.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>
<select name="feeddata[category][]" class="ppt-forminput"><?php echo str_replace('value="'.$feed['category'].'"','value="'.$feed['category'].'" selected=selected',$catlist); ?></select>  
<div class="clearfix"></div>     
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Scheduled Import
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;This option will tell the system to import the same file on a timely bases, ideal if your updating the file every day..&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>


</span>
<select name="feeddata[period][]" class="ppt-forminput">
<option value="0" <?php if($feed['period'] == 0){ echo "selected=selected"; } ?>>------------</option>
<option value="hourly" <?php if($feed['period'] == 'hourly'){ echo "selected=selected"; } ?>>Import Every Hour</option>
<option value="twicedaily" <?php if($feed['period'] == 'twicedaily'){ echo "selected=selected"; } ?>>Import Twice Daily</option>
<option value="daily" <?php if($feed['period'] == 'daily'){ echo "selected=selected"; } ?>>Import Once Daily</option>
</select>
<div class="clearfix"></div>
 
</div>
 
<?php  if(isset($feed['mapdata']) && is_array($feed['mapdata']) ){  ?>


<h3>---------------------- Feed Value Mapping ----------------------</h3>
<p>Here you select which WordPress field to import your feed data into.</p>

<div style="width:350px; overflow:hidden;">

	<?php foreach($feed['mapdata'] as $data){ //if(strlen($data['value']) > 0 && $data['value'] != "0"){ ?>
    
    <div class="ppt-form-line">	
    <span class="ppt-labeltext"><?php echo str_replace("-"," ",str_replace("_"," ",$data['key'])); ?>
    
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<b>Example</b>: <?php echo substr(htmlentities(str_replace('"','',$data['value'])),0,200); ?>.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
    
    </span>
    <select name="feeddata[<?php echo $feed['ID']; ?>][<?php echo $data['key']; ?>]"  class="ppt-forminput">
    <?php foreach($selectArray as $key=>$val){ ?><option value="<?php echo $key; ?>" <?php if($feed[$feed['ID']][$data['key']] == $key){ echo "selected=selected"; } ?>><?php echo $val; ?></option><?php } ?>
    </select> 
    <div class="clearfix"></div>            
     
    </div>
    <?php } ?>



 
<div class="ppt-form-line">
<a href="javascript:void(0);" onclick="toggleLayer('options<?php echo $i; ?>').show();" class="button tagadd">Hide Options</a> 
<input class="button-primary" type="submit" value="<?php _e('Save changes','cp')?>" style="float:right;" /></div>
</div>
<?php }else{ ?>

<?php } ?>


  

 
 
 </fieldset>
</div>

<div class="clearfix"></div>  
</div></div></div>


<?php $i++; } } // end if ?>




<input type="hidden" name="VisC" value="<?php echo $viscount; ?>" id="VisC" />
<script>
function shownb(){

var ev = document.getElementById('VisC').value;
var nxt = parseInt(ev)+1;
document.getElementById('VisC').value = nxt;
toggleLayer('CF'+nxt);

}
</script>



<div id="PACKAGEDISPLAYHERE"></div>

<input class="button-primary" type="submit" value="<?php _e('Save changes','cp')?>" />  
 
<a href="javascript:void(0);" onclick="jQuery('#packagebox').clone().appendTo('#PACKAGEDISPLAYHERE');" class="button tagadd" style="float:right;">Add New Feed</a>
 
 
</form>

 









</div>
<div class="grid400-left last" id="feedboxright">
 
<div class="videobox" id="videobox1a" style="margin-bottom:10px;">
<a href="javascript:void(0);" onclick="PlayPPTVideo('mUkoDZmQD2M','videobox1a');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/14.jpg" align="absmiddle" /></a>
</div>  
</div>
<div class="clearfix"></div>
</div> 

 
</div> 

















































 

<!------------------------------------ PACKAGE BLOCK ------------------------------>


<div style="display:none;">
<div id="packagebox">
<div class="green_box"><div class="green_box_content">
 
<span class="ppt-labeltext">Feed Name</span>
 <input name="feeddata[name][]" type="text" class="ppt-forminput" />
<div class="clearfix"></div>
 
<div class="clearfix"></div></div></div>


 
</div>
</div> 