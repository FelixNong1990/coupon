<?php
/* =============================================================================
   DEBUG OPTIONS
   ========================================================================== */

	//ini_set( 'display_errors', 1 );
	//error_reporting( E_ALL );
	//define('SAVEQUERIES', true);
	//define("PREMIUMPRESS_DEMO","1");

/* =============================================================================
   LOAD IN FRAMEWORK
   ========================================================================== */
	  	
	if (!headers_sent()){
	session_start();
	if(isset($_GET['emptyCart'])){ foreach($_SESSION as $key => $value){ unset($_SESSION[$key]); }}	 
	if(!isset($_SESSION['ddc']['cartqty'])) $_SESSION['ddc']['cartqty'] = 0;
	if(!isset($_SESSION['ddc']['price'])) $_SESSION['ddc']['price'] = 0.00;
	}

	define("PREMIUMPRESS_SYSTEM","CouponPress");  
	define("PREMIUMPRESS_VERSION","7.1.4");
	define("PREMIUMPRESS_VERSION_DATE","5th April, 2013");
 
	
	// LOAD THE PREMIUMPRESS THEME FRAMEWORK

	if(defined('TEMPLATEPATH')){ include("PPT/_config.php"); }
	
/* =============================================================================
   -- END PREMIUMPRESS // ADD YOUR CUSTOM CODE BELOW THIS LINE // PLEASE :)
   ========================================================================== */



?>