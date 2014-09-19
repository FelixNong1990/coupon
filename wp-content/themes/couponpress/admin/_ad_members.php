<?php 
if (!defined('PREMIUMPRESS_SYSTEM')) {	header('HTTP/1.0 403 Forbidden'); exit; } 
 
function StaffRoles($current,$single=false){

	if(strtolower(PREMIUMPRESS_SYSTEM) == "realtorpress"){
	
		$roles = array('subscriber' => 'Client/Website User', 'administrator' => 'Admin','editor' => 'Site Manager','author' => 'Author', 'contributor' => 'Employee/Agent'); //
		
	}else{
	
		$roles = array('subscriber' => 'Client/Website User', 'administrator' => 'Admin','editor' => 'Site Manager','author' => 'Author', 'contributor' => 'Employee'); //
		
	}

	
	$string= "";
	
	foreach($roles as $key=>$val){
	
		if($current == $key){
		if($single){
		return $val;
		}else{
		$string .="<option value='".$key."' selected=selected>".$val." (".$key.")</option> ";
		}
		
		}else{
		$string .="<option value='".$key."'>".$val." (".$key.")</option> ";
		}
		
	
	}
	
	return $string;
 

}

global $PPT,$wp_roles,$getWP, $user,$wpdb,$PPTDesign; get_currentuserinfo();


/* ====================== PREMIUM PRESS FILES CLASS INCLUDE ====================== */

$PPM = new PremiumPress_Membership;

/* ====================== PREMIUM PRESS SWITCH FUNCTIONS ====================== */
if(current_user_can('administrator')){
if(isset($_POST['action'])){ $_GET['action'] = $_POST['action']; }
if(isset($_GET['action'])){

	switch($_GET['action']){

		case "massdelete": {
		  
			for($i = 0; $i < 50; $i++) { 
				if(isset($_POST['d'. $i]) && $_POST['d'.$i] == "on"){ 
					wp_delete_user( $_POST['d'.$i.'-id'] ) ;					 				
				}
			}

			$GLOBALS['error'] 		= 1;
			$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
			$GLOBALS['error_msg'] 	= "Selected Members Deleted Successfully";
		
		} break;

		case "delete": { 

		wp_delete_user( $_GET['id'] ) ;
		 
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Member Deleted Sccuessfully.";
		
		} break;
	
		case "edit": { 

		if( ( $_POST['password'] == $_POST['password_r'] ) && $_POST['password'] !=""){
		$_POST['userdata']['user_pass'] = $_POST['password'] ;
		} 
 
		$_POST['userdata']['jabber']  = $_POST['address']['country']."**";
		$_POST['userdata']['jabber'] .= $_POST['address']['state']."**";
		$_POST['userdata']['jabber'] .= $_POST['address']['address']."**";
		$_POST['userdata']['jabber'] .= $_POST['address']['city']."**";
		$_POST['userdata']['jabber'] .= $_POST['address']['zip']."**";
		$_POST['userdata']['jabber'] .= $_POST['address']['phone']; 
 
		if($_POST['userdata']['ID'] == 0){
		
		$data = wp_create_user( $_POST['usr'], $_POST['password'], $_POST['userdata']['user_email'] );
		 
		if(isset($data->errors)){
		die(print_r($data->errors));
		}else{
		$_POST['userdata']['ID'] = $data;
		}
			
		}
 		
		 
		wp_update_user( $_POST['userdata'] );
		
		// ADD THE FILE DOWNLOADS
		if(isset($_POST['user_files_'.$_POST['userdata']['ID']])){
		
		update_option("user_files_".$_POST['userdata']['ID'],$_POST['user_files_'.$_POST['userdata']['ID']]);
		
		}
		
		// CUSTOM POST META ADDED IN V7
		if(isset($_POST['custom']) && is_array($_POST['custom']) ){
		
			foreach($_POST['custom'] as $key=>$val){
				// SAVE DATA	
				update_user_meta($_POST['userdata']['ID'], $key, $val);
				 //echo $key."--".$val."<--".$_POST['userdata']['ID']."<br>";
			}
		
		}
		
		// USER PHOTO
		if(isset($_POST['pptuserphoto']) && strlen($_POST['pptuserphoto']) > ""){		
			
			 
			// ONLY UPDATE IF THE FILE EXISTING AND HAS NOT BEEN UPDATED ALREADY
			if(substr($_POST['pptuserphoto'],0,7) == "unknown" && file_exists(get_option('imagestorage_path').strip_tags($_POST['pptuserphoto']) ) ){
				
				$STORAGEPATH = get_option('imagestorage_path');				
				// GET FILE PREFIX
				$bits = explode(".",strip_tags($_POST['pptuserphoto']));$prefix = $bits[1]; if(isset($bits[2])){ $prefix = $bits[2]; }	
				$NewName =  "profile-".$_POST['userdata']['ID']."-".date("Y-m-d").".".$prefix;
				rename ($STORAGEPATH.strip_tags($_POST['pptuserphoto']), $STORAGEPATH.$NewName);
				
				// IF THERE IS AN EXISTING ONE, LETS DELETE IT TO CLEAN UP FILES
				$existing_image_file = get_user_meta($_POST['userdata']['ID'], "pptuserphoto",true);
				@unlink($STORAGEPATH.$existing_image_file);
				// NOW LETS SAVE THE NEW ONE	
				 
				update_user_meta($_POST['userdata']['ID'], "pptuserphoto", $NewName );
			
			}
			
		}else{
			update_user_meta($_POST['userdata']['ID'], "pptuserphoto", "" );
		}

		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_msg'] 	= "Member Updated Successfully.";

		} break;
	
	}

}
}
 if($GLOBALS['error'] == 1){ ?><div class="msg msg-<?php echo $GLOBALS['error_type']; ?>"><p><?php echo $GLOBALS['error_msg']; ?></p></div> <?php  }

/* ====================== PREMIUM PRESS EDIT PAGE ====================== */

if(isset($_GET['edit'])){  

$data = new WP_User($_GET['edit']);

PremiumPress_Header();

$ADD = explode("**",$data->jabber);	

?>
 
<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_members.png" align="middle"> <?php if(isset($_GET['edit'])){ ?>Member ID: <?php echo $_GET['edit']; }else{ ?>Add Member<?php } ?></h3>	 <a class="premiumpress_button" href="javascript:void(0);" onclick="PlayPPTVideo('0XHvwwy4QYI','videobox1');">Help Me</a> 						 
<ul>
	<li><a rel="premiumpress_tab1" href="#" class="active">Details</a></li>
  
  
    <li><a href="#" onclick="window.location.href='admin.php?page=orders&cid=<?php echo $_GET['edit']; ?>'">Order History</a></li>
    <?php if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "employeepress"){ ?>
    <li><a rel="premiumpress_tab3" href="#">File Downloads</a></li>
    <?php } ?>
    
    
	<!--<li><a href="admin.php?page=members">Search Results</a></li>-->
</ul>
</div>
 



<div id="videobox1"></div>
 

<form method="post" target="_self" enctype="multipart/form-data">
<input name="action" type="hidden" value="edit" />
<input name="userdata[ID]" type="hidden" value="<?php echo $_GET['edit']; ?>" />
<input type="hidden" value="" name="showThisTab" id="showThisTab" />

<div id="premiumpress_tab1" class="content">



<div class="grid400-left">


 

<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> User Access</h3>  </div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">User Role
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;for more information about roles <a href='http://codex.wordpress.org/Roles_and_Capabilities' target='_blank'>click here.</a>.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a>
</span>	
<select name="userdata[role]" id="role" class="ppt-forminput"><?php echo StaffRoles($data->roles[0]); ?></select>

<a href="http://codex.wordpress.org/Roles_and_Capabilities?TB_iframe=true&width=640&height=838" class="thickbox" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-top:5px; margin-right:5px;" /></a>
 
<div class="clearfix"></div>
</div>
 
        
<div class="ppt-form-line">	
<span class="ppt-labeltext">Account Status</span>	
<?php if(isset($_GET['edit'])){ $status = get_user_meta($_GET['edit'], "pptaccess", true); }else{ $status="active"; } ?>
         
        <select name="custom[pptaccess]" id="role" class="ppt-forminput">
        <option <?php if($status == "active"){ print "selected=selected"; } ?> value="active">Active</option>
        <option <?php if($status == "pending"){ print "selected=selected"; } ?> value="pending">Pending</option>
        <option <?php if($status == "suspended"){ print "selected=selected"; } ?> value="suspended">Suspended</option>  
        <option <?php if($status == "fired"){ print "selected=selected"; } ?> value="fired">Fired</option>         
        </select>

<div class="clearfix"></div>
</div>



<div class="ppt-form-line">	
<span class="ppt-labeltext">Membership</span>	
<?php $packagedata 	= get_option('ppt_membership'); $ps = get_user_meta($_GET['edit'], 'pptmembership_level', true); ?>
<select name="custom[pptmembership_level]" class="ppt-forminput" > 
<option value="0" <?php if($ps == "" || $ps == "0"){ echo "selected=selected"; } ?>>-- No Package -- </option>
 <?php 
	$i=0;
	
	foreach($packagedata['package'] as $package){
		
		if($package['ID'] == $ps && $ps != "0"){
		
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']." (ID:".$package['ID'].")</option>";
		
		}else{  
		
		echo "<option value='".$package['ID']."'>".$package['name']." (ID:".$package['ID'].")</option>";
		
		}
		
		 //$package['id']
		
	$i++;
		
	} // end foreach
	
?>

</select> 
<div class="clearfix"></div>
<div style="margin-left:140px;">
<b>Status</b><br />
<?php $ss = get_user_meta($_GET['edit'], 'pptmembership_status', true); ?>
        <select name="custom[pptmembership_status]" id="role" class="ppt-forminput">
        <option <?php if($ss == "ok"){ print "selected=selected"; } ?> value="ok">Active</option>
        <option <?php if($ss == "pending"){ print "selected=selected"; } ?> value="pending">Pending Payment</option>        
        </select>
</div>
 

<div class="clearfix"></div>
<div style="margin-left:140px;">
<b>Expiry Date <a href="javascript:void(0);" onclick="jQuery('#expirydateval').val('<?php echo date("Y-m-d H:i:s"); ?>');">(Y-m-d H:i:s)</a></b><br />
<?php $ss = get_user_meta($_GET['edit'], 'pptmembership_expires', true); ?>
<input name="custom[pptmembership_expires]" id="expirydateval" type="text" class="ppt-forminput" value="<?php echo $ss; ?>" /> 
</div>
<div style="margin-left:140px;">
<b>Start Date <a href="javascript:void(0);" onclick="jQuery('#sexpirydateval').val('<?php echo date("Y-m-d H:i:s"); ?>');">(Y-m-d H:i:s)</a></b><br />
<?php $ss = get_user_meta($_GET['edit'], 'pptmembership_datestarted', true); ?>
<input name="custom[pptmembership_datestarted]" id="sexpirydateval" type="text" class="ppt-forminput" value="<?php echo $ss; ?>" /> 
</div>
</div>

 

 

<?php

// DONT INCLUDE THIS FOR SP
if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){

	// MAKE EXPIRY DATE
	$EP = get_user_meta($_GET['edit'], 'pptmembership_expires', true);
	$date_format = get_option('date_format') . ' ' . get_option('time_format');
	$epdate = mysql2date($date_format,  $EP, false);
	if(strlen($epdate) > 3){
	echo '<p align="center">'.str_replace("%a",$epdate,"Current membership package expires on %a").'</p>';
	} 
}

?>
 





<?php  if(strtolower(constant('PREMIUMPRESS_SYSTEM')) == "auctionpress" || strtolower(constant('PREMIUMPRESS_SYSTEM')) == "shopperpress"){  ?>
<div class="ppt-form-line">	
<span class="ppt-labeltext">Account Balance</span>	
<input name="userdata[aim]" type="text" class="ppt-forminput" value="<?php echo $data->aim; ?>" /> 
<div class="clearfix"></div>
</div>
<?php } ?>


<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;" /></p>
 
</fieldset> 


<?php if(isset($_GET['edit'])){ ?>
<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a2.gif" style="float:left; margin-right:8px;" /> User Photo</h3>  </div>
<style>
.frame img { 
 
	margin: 5px 15px 19px 5px;
	border: 8px solid white;
	position: relative;
	-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.06) inset;
	-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.06) inset;
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.06) inset;
	max-height: 180px;max-width: 180px;padding:0px;margin-left:10px; margin-top:20px;
 } 
 </style>

<br />
			<?php 
            
            // GET USER PHOTO
            $img = get_user_meta($_GET['edit'], "pptuserphoto",true);
            
            if(strlen($img) > 2){ ?>
                
            <div align="center" id="currentImage">
            <a href="<?php echo get_option('imagestorage_link').$img; ?>" class="lightbox frame" id="myimage"><img src="<?php echo get_option('imagestorage_link').$img; ?>" /></a>
            <input type="hidden" name="pptuserphoto" id="pptuserphoto" value="<?php echo strip_tags($img); ?>">
            </div>	
            <br />
            
			<?php }else{ echo '<div id="currentImage"></div>';} ?>
            
            <div id="pptfiles"></div> <span id="pptstatus"></span>
             
            <div class="green_box"><div class="green_box_content nopadding"> 
            
                <div align="center">
                
                <input type="button" id="pptupload" value="Upload Image" class="button green" /> 
                
               <span id="delImg" <?php if(strlen($img) < 2){ echo "style='display:none'"; } ?>>
                   <a class="button blue" href="javascript:void(0);" onclick="jQuery('#pptuserphoto').val('');jQuery('#myimage').hide();jQuery('#delImg').hide();jQuery('#pptupload').show();">
                    Delete Image
                   </a>
               </span>
                
                </div>     
             
            <div class="clearfix"></div></div></div>



</fieldset>
<script type='text/javascript' src="<?php echo PPT_THEME_URI; ?>/PPT/js/jquery.upload.js"></script>
 
<script type="text/javascript" >
	jQuery(function(){
		var btnUpload=jQuery('#pptupload');
		var status=jQuery('#pptstatus');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $GLOBALS['bloginfo_url']; ?>/index.php',
			name: 'pptfileupload',
			onSubmit: function(file, ext){
				 if (! (ext && /^(gif|jpg|png)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only Image Files (.gif/.png/.jpg)');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				
				if(response==="error"){
					jQuery('<li></li>').appendTo('#pptfiles').text(file).addClass('error');
				} else{
				
					jQuery('#delImg').show();
					jQuery('#currentImage').html('');
					var image = '<a href="<?php echo get_option('imagestorage_link'); ?>'+response+'" class="lightbox frame" id="myimage"><img src="<?php echo get_option('imagestorage_link'); ?>'+response+'"></a>';
				
					jQuery('#pptupload').hide();					 			
					jQuery('#pptfiles').html('<div align="center" id="currentImage">'+image+'<input type="hidden" name="pptuserphoto" id="pptuserphoto" value="'+response+'"></div>').addClass('pptsuccess');
				}
			}
		});
		
	});
</script> 
<?php } ?>



<fieldset>


<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a3.gif" style="float:left; margin-right:8px;" /> Account Notice</h3>  </div>


<div class="ppt-form-line">	
 	
<small>This will be displayed to the member when they login to their account.</small><br />
<textarea name="custom[accountmessage]" class="ppt-forminput" style="height:100px;width:380px;"><?php echo get_user_meta($data->ID, 'accountmessage', true); ?></textarea> 
<div class="clearfix"></div>
</div> 

<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;" /></p>

 
</fieldset>


<?php $cf = $PPTDesign->ProfileFields(); if(strlen($cf) > 5){ ?>

<fieldset>


<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a4.gif" style="float:left; margin-right:8px;" />Custom Profile Fields</h3>  </div>


<?php echo $cf; ?>

<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;" /></p>

 
</fieldset>
<?php } ?>



</div>

<div class="grid400-left last">

<fieldset>
<?php if($_GET['edit'] == 0){ ?>
<div class="titleh"> <h3>WordPress Data - These details cannot be changed</h3></div> 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Username</span>	
<input type="text"  value="<?php echo esc_attr($data->user_login); ?>" name="usr" class="ppt-forminput" /> 
<div class="clearfix"></div>
</div>
<?php } ?>

<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a5.gif" style="float:left; margin-right:8px;" />Account Details</h3>  </div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">First Name</span>	
<input name="userdata[first_name]" type="text" class="ppt-forminput" value="<?php echo $data->first_name; ?>" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Last Name</span>	
<input name="userdata[last_name]" type="text" class="ppt-forminput" value="<?php echo $data->last_name; ?>" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Email Address</span>	
<input name="userdata[user_email]" type="text" class="ppt-forminput" value="<?php echo $data->user_email; ?>" /> 
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Nick Name</span>	
<input name="userdata[nickname]" type="text" class="ppt-forminput" value="<?php echo $data->nickname; ?>" /> 
<div class="clearfix"></div>
</div>


<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a6.gif" style="float:left; margin-right:8px;" />User Details</h3>  </div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Addresss</span>	
 <input type="text" name="address[address]" value="<?php echo $ADD[2]; ?>" class="ppt-forminput" tabindex="17" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">State</span>	
 <input type="text" name="address[state]" value="<?php echo $ADD[1]; ?>" class="ppt-forminput" tabindex="15" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">City</span>	
 <input type="text" name="address[city]" value="<?php echo $ADD[3]; ?>" class="ppt-forminput" tabindex="16" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Country</span>	
 <input type="text" name="address[country]" value="<?php echo $ADD[0]; ?>" class="ppt-forminput" tabindex="14" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Zip/Postal Code</span>	
 <input type="text" name="address[zip]" value="<?php echo $ADD[4]; ?>"class="ppt-forminput" tabindex="18" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">Phone</span>	
 <input type="text" name="address[phone]" value="<?php echo $ADD[5]; ?>" class="ppt-forminput" tabindex="19" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line">	
<span class="ppt-labeltext">User Description</span>	
 <textarea name="userdata[description]" class="ppt-forminput" style="height:200px;"><?php echo nl2br(stripslashes($data->description)); ?></textarea>
<div class="clearfix"></div>
</div>
 

<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a7.gif" style="float:left; margin-right:8px;" />Change Password</h3>  </div>


<div class="ppt-form-line">	
<span class="ppt-labeltext">New Password</span>	
 <input name="password" type="text" class="ppt-forminput" value="" />
<div class="clearfix"></div>
</div>
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Re-Type New Password</span>	
<input name="password_r" type="text" class="ppt-forminput" value="" /> 
<div class="clearfix"></div>
</div>

</fieldset>

<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;" /></p>

</div>



 <div class="clearfix"></div>

</div>

<!-- end tab 1 -->

 

<div id="premiumpress_tab2" class="content">

 
</div>

<!-- end tab 2 -->




<div id="premiumpress_tab3" class="content">

<table class="maintable" style="style="background:white;"">
<tr class="mainrow"><td class="titledesc">



</td><td class="forminp">  
        
<fieldset>
<legend> File Access</legend>

<p>Select the files you wish this member to be able to download</p>

	<?php $existingFileArray = get_option("user_files_".$_POST['userdata']['ID']); ?>

       <select name="user_files_<?php echo $_GET['edit']; ?>[]" multiple="multiple" style="width:350px;">
       <?php
	   
		$GLOBALS['image_path'] = get_option("imagestorage_path");	
		
		$result = read_all_files($GLOBALS['image_path'],"");	 
	    
		foreach ($result['files'] as $file) {
		
			$a = explode("/",$file); $f =count($a);
			
			if(is_array($result['dirs']) && count($result['dirs']) > 0){
				foreach($result['dirs'] as $part){
					$fi = str_replace($part,"",$a[$f-1]);
				}
			}else{			
			$a = explode("/",$result['files'][$currThumb]);			
			$fi = $a[count($a)-1];				
			}		
		
		if( in_array($fi,$existingFileArray) ){ $etx = 'selected="selected"'; }else{  $etx =''; }
		echo '<option value="'.$fi.'" '.$etx.'>'.$fi.'</option>';	
 
		}
		?> 
       
       </select><br />
       <small>Hold CTRL to select multiple values</small>

<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:#fff;" onclick="document.getElementById('showThisTab').value=1" /></p>
</fieldset>
  
 
</td></tr>  
    
 

</table>
</div>


 
 
 
 
 
 
 
 
 
 
 
 
 





</form>
</div>
</div>
































<?php }else{

//$packages = $wpdb->get_results("SELECT ID, package_name FROM premiumpress_packages");

if(!isset($_GET['p']) || $_GET['p']==""){ $_GET['p']=1; }
$GLOBALS['results_per_page'] = 10;
$GLOBALS['user_fields'] = array('ID','user_login','user_pass','user_nicename','user_email','user_url','user_registered','user_activation_key','user_status','display_name');
$GLOBALS['meta_fields'] = array(
	'Last Name'		=>	'last_name',
	'First Name'	=>	'first_name',
	'Description'	=>	'description'
);
$GLOBALS['members_fields'] = array(
	'User Name'		=>	'user_nicename',
	'Email Address'	=>	'user_email',
	'Display Name'	=>	'display_name',
	'URL'			=>	'user_url'
);
 
$TotalResults 			= $PPM->scope();
$MEMBER_SEARCH_DATA 	= $PPM->MQuery();
PremiumPress_Header();  ?>


<script>
<?php /*
function da(x){for(var j=0;j<=x;j++){box=eval("document.orderform.d"+j);box.checked=true;}}
function du(x){for(var j=0;j<=x;j++){box=eval("document.orderform.d"+j);box.checked=false;}}*/ ?>
function clearMe(){

document.getElementById("query").value = "";
}
</script>
<style>.photo { max-width:50px; max-height: 50px; }

.PremiumPress_Members_AlphaSearch { margin-bottom:20px; }
.PremiumPress_Members_AlphaSearch ul, .PremiumPress_Members_AlphaSearch li { display:inline; list-style:none;text-indent:0; margin-bottom:20px;}
.PremiumPress_Members_AlphaSearch span { font-size:10px;font-style:italic; }
.PremiumPress_Members_AlphaSearch a { display:inline-block;padding:6px; padding-top:0px; padding-bottom:0px;  border:1px solid #ddd; background:#fff; margin-right:7px; }
.PremiumPress_Members_AlphaSearch a:hovor { background:#ddd; color:white; }
.PremiumPress_Members_AlphaSearch_Selected a { background:#990000; color:white; }


</style>



 
  
<div id="premiumpress_box1" class="premiumpress_box premiumpress_box-100"><div class="premiumpress_boxin"><div class="header">
<h3><img src="<?php echo PPT_FW_IMG_URI; ?>/admin/_ad_members.png" align="middle"> Members</h3>
<ul>
	<li><a rel="premiumpress_tab1" href="#" class="active"> Results</a></li>
	<li><a href="#" onclick="window.location.href='admin.php?page=members&edit=0'">Add Person</a></li>
     <li><a rel="premiumpress_tab4" href="#">Custom Profile Fields</a></li>
   
</ul>
</div>







<div id="videobox1"></div>








<div id="premiumpress_tab1" class="content">


<div class="PremiumPress_Members_search" style="float:right;">
		<form method="get" action="admin.php?page=members">			
			<input type="text" id="query" name="query" class="blur" value="Keyword.." onclick="clearMe();" />
			in <?php if(!isset($_REQUEST['by'])){ $_REQUEST['by']=""; } echo $PPM->selectPaired('by','by','','','All Fields',array($_REQUEST['by'])) ?>
			<input type="hidden" name="page" value="members" />			
			<input type="submit" value="Search" />
		</form>
</div>


<div class="PremiumPress_Members_AlphaSearch">
<div style="height:30px;">Quick Alphabetically Search <span>(by first name)</span>:</div>
<ul>
<li><span><a href="admin.php?page=members">All Person's</a></span></li>
<?php echo $PPM->alpha('admin.php?page=members');?>

</ul>
</div>

<form class="plain" method="post" name="orderform" id="orderform">
<input type="hidden" name="action" value="massdelete">
<fieldset style="padding:0px;">
<table cellspacing="0"><thead><tr>
<td class="tc"><input type="checkbox" id="data-1-check-all" name="data-1-check-all" value="true"/></td>
<td class="tc">Photo</td>
<th>Username <br /> <small>Order By Username </small><a href="admin.php?page=members&sort=user_nicename&order=asc"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/su.png" align="middle"></a> <a href="admin.php?page=members&sort=user_nicename&order=desc"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/sd.png" align="middle"></a></th>
<td>First Name / Last Name <br /><small>Order By First Name <a href="admin.php?page=members&sort=first_name&order=asc"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/su.png" align="middle"></a> <a href="admin.php?page=members&sort=first_name&order=DESC"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/sd.png" align="middle"></a> Last Name <a href="admin.php?page=members&sort=last_name&order=asc"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/su.png" align="middle"></a> <a href="admin.php?page=members&sort=last_name&order=DESC"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/sd.png" align="middle"></a> </small>    </td>
<td class="tc">Account Status</td>
<td class="tc">Listing #</td>
<td class="tc">Actions</td>
</tr></thead>


<tfoot><tr><td colspan="7">
<label>

<select name="data-1-groupaction"><option value="delete">delete</option></select> selected members. <input class="button altbutton" type="submit" value="OK" style="color:white;float:left;" />


</label>

</td></tr></tfoot>


<?php

	// SETUP MEMBERSHIP PACKAGES ARRAY
	if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){
	
		$GLOBALS['membershipData'] 		= get_option('ppt_membership'); 
		$nnewpakarray = array();
		if(is_array($GLOBALS['membershipData']) && isset($GLOBALS['membershipData']['package']) ){ foreach($GLOBALS['membershipData']['package'] as $val){
		
			$nnewpakarray[$val['ID']] =  $val;
		
		} }
	
	}
 
 	// START LOOP
	$c = 0;  $checkbox=0;
	foreach($MEMBER_SEARCH_DATA as $user) {


		$user = new WP_User($user);
		$r = $user->roles;
		$r = array_shift($r);
		if(!empty($_REQUEST['role']) and $_REQUEST['role'] != $r) {
			continue;
		}
 
		//$timesince = premiumpress_time_difference($user->user_registered,true);
 
?>

<tbody <?php if($checkbox%2){ echo "class='alt'"; }?>>
<tr class="first">
<td class="tc"><?php if($user->ID !=1){ ?>
<input type="checkbox" value="on" name="d<?php echo $checkbox; ?>" id="d<?php echo $checkbox; ?>"/>
<input type="hidden" name="d<?php echo $checkbox; ?>-id" value="<?php echo $user->ID; ?>">
<?php } ?>
</td>

<td class="tc"><?php 

 // GET USER PHOTO
        $img = get_user_meta($user->ID, "pptuserphoto",true);
		if($img == ""){
			$img = get_avatar($user->ID,52);
		}else{
			$img = "<img src='".get_option('imagestorage_link').$img."' class='photo' alt='user ".$user->ID."' />";
		}
		
		echo $img;
 

?></td>
<td><a href="<?php echo $e;?>"><?php echo $user->user_login; ?></a> </td>
<td><?php echo $user->first_name.' '.$user->last_name;?>  <br /> <small>Created: <?php echo $user->user_registered; ?></small> 

<?php

// DONT INCLUDE THIS FOR SP
if(strtolower(PREMIUMPRESS_SYSTEM) != "shopperpress"){

	$GLOBALS['membershipID'] 		= get_user_meta($user->ID, 'pptmembership_level', true);
	$GLOBALS['membershipStatus'] 	= get_user_meta($user->ID, 'pptmembership_status', true);
	
 
	if($GLOBALS['membershipID'] !="" && is_numeric($GLOBALS['membershipID'])){
	echo "<br /> <b style='background-color:yellow;'>".$nnewpakarray[$GLOBALS['membershipID']]['name']." ( ".$GLOBALS['membershipStatus']." )</b>";
	
	}

}

?>

</td>

<td class="tc">
<?php $status = get_user_meta($user->ID, "pptaccess", true); if($status == "" || $status == "active"){ echo "Active"; }else{ echo "<b style='background-color:red;color:#fff;'>".$status."</b>"; } 

?>
</td>

<td><center>

  <?php //echo StaffRoles($r,true);?><br />
 
 <a href="edit.php?post_type=post&author=<?php echo $user->ID; ?>&TB_iframe=true&width=640&height=838" class="thickbox">
 
 <?php $ttp 		= $wpdb->get_row("SELECT count(*) as count FROM $wpdb->posts WHERE post_author='".$user->ID."'"); echo $ttp->count; ?>
 
 </a>
</center>
</td>

<td class="tc">
<ul class="actions">
<li><a class="ico" href="admin.php?page=members&edit=<?php echo $user->ID; ?>" rel="permalink"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/premiumpress/led-ico/pencil.png" alt="edit" /></a></li>

<!--<li><a href="admin.php?page=orders&cid=<?php echo $user->ID; ?>&TB_iframe=true&width=940&height=838" class="thickbox ico" rel="permalink"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/money.png" alt="order history" /></a></li>-->

<li><a href="admin.php?page=emails&uid=<?php echo $user->ID; ?>&TB_iframe=true&width=940&height=838" class="thickbox ico" > <img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/email.png" /></a></li>

<?php if($user->ID !=1){ ?><li><a class="ico" class='submitdelete' href='admin.php?page=members&action=delete&id=<?php echo $user->ID; ?>' onclick="if ( confirm('Are you sure you want to delete this member?') ) { return true;}return false;">
<img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/premiumpress/led-ico/cross.png" alt="delete" /></a>
</li><?php } ?>

 

</ul>
</td>
</tr>


</td>	</tr>
	</tbody>
<?php $checkbox++;  } ?>

</table>




<input type="hidden" name="totalorders" value="<?php echo $checkbox; ?>">
<div class="pagination"><ul><li><?php echo $PPM->viewing('admin.php?page=members'); ?></li></ul></div>
</form>
</div>








































<div id="premiumpress_tab2" class="content">




<form class="fields" method="post" target="_self" enctype="multipart/form-data" style="padding:10px;">
<input name="csvimport" type="hidden" value="yes" />
<input type="hidden" class="hidden" name="type"  value="users" />
<input name="enc" type="hidden"  value="/" size="5">
<input name="del" type="hidden"  value="," size="5">
<input type="hidden"  name="heading"  value="yes" />
<input type="hidden"   name="rq"  value="yes" />


<fieldset style="padding:20px; margin-left:30px;">
<legend><strong>CSV Member Import Options</strong></legend>

<input type="file" name="import" class="input">
<p>Click the button above to select a .csv file that contains the information of the members you would like to import.</p>
 
<p><a href="">Click here to download a sample .csv file.</a> Your file should follow this format. </p> 
 
<input class="premiumpress_button" type="submit" value="<?php _e('Save changes','cp')?>" style="color:white;" />
</fieldset>
</form>
 
</div>



<?php $packagedata = get_option('ppt_profilefields'); ?>



<div id="premiumpress_tab4" class="content">


 
<form method="post" target="_self">
<input type="hidden" value="4" name="showThisTab" id="showThisTab" />
 
 


<div class="clearfix"></div>

<div class="grid400-left"> 

<div id="videoboxc1"></div>


<fieldset>
<div class="titleh"> <h3><img src="<?php echo PPT_FW_IMG_URI; ?>admin/a1.gif" style="float:left; margin-right:8px;" /> Default Registration Fields</h3></div>

 <div class="ppt-form-line">	
<span class="ppt-labeltext">Display Options
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" onclick="PPMsgBox(&quot;&lt;strong&gt;Here you can turn on/off the default registration fields hard coded into the theme.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;"></a>

</span>
 <a href="http://www.premiumpress.com/tutorial/custom-profile-fields/" target="_blank"><img src="<?php echo PPT_FW_IMG_URI; ?>admin/s123.png" style="float:right; margin-left:10px; margin-right:5px;" /></a>

<p><input name="df1" type="checkbox" value="1" onchange="ChangeTickValue('df1');" <?php if($packagedata['default1'] == "1"){ ?>checked="checked"<?php } ?> />  Hide My Account Details Title</p>
<p><input name="df2" type="checkbox" value="1" onchange="ChangeTickValue('df2');" style="margin-left:140px;" <?php if($packagedata['default2'] == "1"){ ?>checked="checked"<?php } ?> />  Hide First Name</p>
<p><input name="df3" type="checkbox" value="1" onchange="ChangeTickValue('df3');" style="margin-left:140px;" <?php if($packagedata['default3'] == "1"){ ?>checked="checked"<?php } ?> />  Hide Last Name</p>
<p><input name="df4" type="checkbox" value="1" onchange="ChangeTickValue('df4');" style="margin-left:140px;" <?php if($packagedata['default4'] == "1"){ ?>checked="checked"<?php } ?> />  Hide A few words about me..</p>
  

<input type="hidden" name="ppt_profilefield[default1]" id="df1" value="<?php if(isset($packagedata['default1']) && $packagedata['default1'] ==1){ echo 1; }else{ echo 0; } ?>" />
<input type="hidden" name="ppt_profilefield[default2]" id="df2" value="<?php if(isset($packagedata['default2']) && $packagedata['default2'] ==1){ echo 1; }else{ echo 0; } ?>" />
<input type="hidden" name="ppt_profilefield[default3]" id="df3" value="<?php if(isset($packagedata['default3']) && $packagedata['default3'] ==1){ echo 1; }else{ echo 0; } ?>" />
<input type="hidden" name="ppt_profilefield[default4]" id="df4" value="<?php if(isset($packagedata['default4']) && $packagedata['default4'] ==1){ echo 1; }else{ echo 0; } ?>" />

 
<div class="clearfix"></div>
</div>

 
 
 
<p><input class="premiumpress_button" type="submit" value="Save Changes" style="color:white;"></p>
</fieldset>

 

<div class="videobox" id="videobox1a" style="margin-bottom:10px;">
<a href="javascript:void(0);" onclick="PlayPPTVideo('7LSGF9594fU','videobox1a');"><img src="<?php echo $GLOBALS['template_url']; ?>/PPT/img/admin/video/16.jpg" align="absmiddle" /></a>
</div> 

</div>

 <script language="javascript">
 
 function ChangeTickValue(div){
 
	 if(document.getElementById(div).value==0){
	 document.getElementById(div).value=1;
	 }else{
	 document.getElementById(div).value=0;
	 }
 
 }
 
 </script>
<div class="grid400-left last"> 

 
 <?php $i=0;

if(is_array($packagedata) && isset($packagedata['package']) ){ 


$neworder = multisort( $packagedata['package'] , array('order') );

foreach($neworder as $package){   ?>
<input type="hidden" name="ppt_profilefield[field][ID][]" value="<?php echo $package['ID']; ?>" />

<div id="package<?php echo $i; ?>">

<?php if($package['title'] == "1"){ $bg = "blue"; }else{ $bg = "green"; } ?>
<div class="<?php echo $bg; ?>_box"><div class="<?php echo $bg; ?>_box_content">



<div class="ppt-form-line">	
<span class="ppt-labeltext">Field Caption <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is the display caption for your field. It's just a display caption, it does nothing more than look pretty. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 <input name="ppt_profilefield[field][name][]" type="text" class="ppt-forminput" value="<?php echo $package['name']; ?>" id="pn<?php echo $i; ?>" />
<div class="clearfix"></div>
</div>

<div class="ppt-form-line" <?php if($package['title'] == "1"){ ?>style="display:none;"<?php } ?>>	
<span class="ppt-labeltext">Database Key <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is a numeric value which determins in what order the packages are displayed. 0 first. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 <input name="ppt_profilefield[field][key][]" type="text" class="ppt-forminput"  value="<?php echo $package['key']; ?>" /> 
<div class="clearfix"></div>
</div>

<div id="packop<?php echo $i; ?>" style="display:none;">


 <div class="ppt-form-line">	
<span class="ppt-labeltext">Display Options
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" onclick="PPMsgBox(&quot;&lt;strong&gt;How do i add list box values?&lt;/strong&gt;&lt;br /&gt;List box values are entered into the 'Default values' box below and should be entered like this:&lt;br&gt;&lt;br&gt;Value1,Value2,Value3&lt;br&gt;&lt;br&gt;Notice each new listbox option is seperated with a comma.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;"></a>

</span>
 
<p><input name="checkme1<?php echo $i; ?>" type="checkbox" value="1" onchange="ChangeTickValue('checkme1<?php echo $i; ?>');" <?php if($package['title'] == "1"){ ?>checked="checked"<?php } ?> />  Field Title Only</p>
<p><input name="checkme2<?php echo $i; ?>" type="checkbox" value="1" onchange="ChangeTickValue('checkme2<?php echo $i; ?>');" style="margin-left:140px;" <?php if($package['display_register'] == "1"){ ?>checked="checked"<?php } ?> />  Registration Page</p>
<p><input name="checkme3<?php echo $i; ?>" type="checkbox" value="1" onchange="ChangeTickValue('checkme3<?php echo $i; ?>');" style="margin-left:140px;" <?php if($package['display_account'] == "1"){ ?>checked="checked"<?php } ?> />  My Account Page</p>
 

<input type="hidden" name="ppt_profilefield[field][title][]" id="checkme1<?php echo $i; ?>" value="<?php if(isset($package['title']) && $package['title'] ==1){ echo 1; }else{ echo 0; } ?>" />
<input type="hidden" name="ppt_profilefield[field][display_register][]" id="checkme2<?php echo $i; ?>" value="<?php if(isset($package['display_register']) && $package['display_register'] ==1){ echo 1; }else{ echo 0; } ?>" />
<input type="hidden" name="ppt_profilefield[field][display_account][]" id="checkme3<?php echo $i; ?>" value="<?php if(isset($package['display_account']) && $package['display_account'] ==1){ echo 1; }else{ echo 0; } ?>" />
 
 
<div class="clearfix"></div>
</div>

 
 <div class="ppt-form-line" <?php if($package['title'] == "1"){ ?>style="display:none;"<?php } ?>>	
<span class="ppt-labeltext">Required Field</span>
   <select name="ppt_profilefield[field][required][]" class="ppt-forminput">
        <option value="yes" <?php if($package['required'] == "yes"){ ?>selected="selected"<?php } ?>>Yes</option>
        <option value="no" <?php if($package['required'] == "no"){ ?>selected="selected"<?php } ?>>No - Optional</option>
    </select>  
<div class="clearfix"></div>
</div>

 
<div class="ppt-form-line" <?php if($package['title'] == "1"){ ?>style="display:none;"<?php } ?>>	
<span class="ppt-labeltext">Field Type
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" onclick="PPMsgBox(&quot;&lt;strong&gt;How do i add list box values?&lt;/strong&gt;&lt;br /&gt;List box values are entered into the 'Default values' box below and should be entered like this:&lt;br&gt;&lt;br&gt;Value1,Value2,Value3&lt;br&gt;&lt;br&gt;Notice each new listbox option is seperated with a comma.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;"></a>

</span>
   <select name="ppt_profilefield[field][type][]" class="ppt-forminput">
        <option value="text" <?php if($package['type'] == "text"){ ?>selected="selected"<?php } ?>>Text Box (best for short answers)</option>
        <option value="textarea" <?php if($package['type'] == "textarea"){ ?>selected="selected"<?php } ?>>Text Area (best for longer answers)</option>
        <option value="list" <?php if($package['type'] == "list"){ ?>selected="selected"<?php } ?>>List Box (drop down menu of options)</option>
    </select>  
<div class="clearfix"></div>
</div>

<div class="ppt-form-line" <?php if($package['title'] == "1"){ ?>style="display:none;"<?php } ?>>	
<span class="ppt-labeltext">Default Field Values
<a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" onclick="PPMsgBox(&quot;&lt;strong&gt;What does this mean?&lt;/strong&gt;&lt;br /&gt;Sometimes you might want to add content to a text field for display when the page loads to help prompt the user for the correct input. &lt;br&gt;&lt;br&gt; For example, if your asking the user to enter their website link and want them to include the http:// at the beginning you can enter the http:// as the default value so that they realise you require this also.&lt;br&gt;&lt;br&gt;&lt;br /&gt;&lt;strong&gt;How do i add list box values?&lt;/strong&gt;&lt;br /&gt;List box values should be entered like this:&lt;br&gt;&lt;br&gt;Value1,Value2,Value3&lt;br&gt;&lt;br&gt;Notice each new listbox option is seperated with a comma.&quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;"></a>
</span>
<input name="ppt_profilefield[field][values][]" type="text" class="ppt-forminput" value="<?php echo $package['values']; ?>">
<div class="clearfix"></div>
</div> 

 
 
<div class="ppt-form-line">	
<span class="ppt-labeltext">Display Order <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is a numeric value which determins in what order the packages are displayed. 0 first. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
 <input name="ppt_profilefield[field][order][]" type="text" class="ppt-forminput" style="width:50px;" value="<?php echo $package['order']; ?>" /> 
<div class="clearfix"></div>
</div>


<!--
<div class="ppt-form-line">	
    <span class="ppt-labeltext">Description <a href="javascript:void(0);" onmouseover="this.style.cursor='pointer';" 
onclick="PPMsgBox(&quot;<strong>What is this?</strong><br /><br />This is where you write a few words about the package. Why should they pay for this package? It's a good idea to include the price and duration in the description. &quot;);"><img src="<?php echo PPT_FW_IMG_URI; ?>help.png" style="float:right;" /></a></span>
    <textarea  class="ppt-forminput" name="ppt_profilefield[field][desc][]" style="height:100px;"><?php echo $package['desc']; ?></textarea>
    <div class="clearfix"></div>
</div>
-->    
    
    
    
</div>

<div class="ppt-form-line">	

<a href="javascript:void(0);" onclick="toggleLayer('packop<?php echo $i; ?>');"  class="button tagadd left">Show/Hide Options</a>

<a href="javascript:void(0);" onclick="document.getElementById('pn<?php echo $i; ?>').value=''; jQuery('#package<?php echo $i; ?>').hide();" class="button tagadd right" style="margin-left:120px;">Delete Field</a>     

</div>


<div class="clearfix"></div>
</div></div></div>



<?php $i++; } } ?>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 


<div id="PACKAGEDISPLAYHERE"></div>

<a name="botb"></a>           
<div class="ppt-form-line">	
<p>
<a href="#botb"  onclick="jQuery('#packagebox').clone().appendTo('#PACKAGEDISPLAYHERE');" class="button-primary">Add Custom Field</a>

<input class="premiumpress_button" type="submit" value="Save Changes" style="float:right; color:white;" /> 
</p>
</div>					 
</form>


</div>

 




<div class="clearfix"></div>



</div>

<!-- end tab 4 -->










</div>
 
 
 
 <!------------------------------------ PACKAGE BLOCK ------------------------------>


<div style="display:none;">
<div id="packagebox">
<div class="green_box"><div class="green_box_content">

<div class="ppt-form-line">	
<span class="ppt-labeltext">Field Caption</span>
 <input name="ppt_profilefield[field][name][]" type="text" class="ppt-forminput" />
<div class="clearfix"></div>
</div> 
   
<div class="clearfix"></div></div></div>
</div>
</div>



<?php
 
}

?>