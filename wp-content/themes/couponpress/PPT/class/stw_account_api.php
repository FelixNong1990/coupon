<?php
    /**
     * Prerequisites: PHP4 (tested 4.4.1+), PHP5
	 * Maintainers: Andreas Pachler, Brandon Elliott
	 *
	 *	For the latest documentation and best practices: please visit http://www.shrinktheweb.com/content/shrinktheweb-pagepix-documentation.html
     */
    define('USE_DB', false); // set to true if you want to save the account info into database

    // include the example code for some needed functions and constants
    include_once("stw_api_code.php");
    if(USE_DB){include_once("stw_db_funcs.php");}

    /**
     * Get Account Info from DB and return it as array
     */
    function getAccountInfoDB() {
        $aResponse = getAccountInfoFromDB(ACCESS_KEY);

        return $aResponse;
    }

    /**
     * Get Account Info and return it as array
     */
    function getAccountInfo() {
        $aArgs['stwaccesskeyid'] = ACCESS_KEY;
        $aArgs['stwu'] = SECRET_KEY;

  	    $sRequestUrl = 'http://images.shrinktheweb.com/account.php';    
	    $sRemoteData = _fileGetContent($sRequestUrl, $aArgs);
        $aResponse = _getAccXMLResponse($sRemoteData);

        return $aResponse;
    }

    /**
     * Get Account XML response, store it into DB and return it as array
     */
    function saveAccountInfo() {
        $aResponse = getAccountInfo();
                
        // save data into db
        if ($aResponse['stw_response_status'] == 'Success') {
            addAccountInfoToDB(ACCESS_KEY, $aResponse);
        }

        return $aResponse;
    }

    /**
     * store the Account XML response in an array
     */
    function _getAccXMLResponse($sResponse) {
	
		if($sResponse == "ShrinkTheWeb is temporarily offline for maintenance"){
		$aResponse['stw_response_status'] =0;
		return $aResponse;		
		}
	
        if (extension_loaded('simplexml')) { // If simplexml is available, we can do more stuff!
	        $oDOM = new DOMDocument;
            $sLineXML = DOMDocument::loadXML($sResponse);
	        $sXML = simplexml_import_dom($sLineXML);
	        $sXMLLayout = 'http://www.shrinktheweb.com/doc/stwacctresponse.xsd';

            // Pull response codes from XML feed
	        $aResponse['stw_response_status'] = $sXML->children($sXMLLayout)->Response->Status->StatusCode; // Response Code
	        $aResponse['stw_account_level'] = $sXML->children($sXMLLayout)->Response->Account_Level->StatusCode; // Account level
	        // check for enabled upgrades
	        $aResponse['stw_inside_pages'] = $sXML->children($sXMLLayout)->Response->Inside_Pages->StatusCode; // Inside Pages
	        $aResponse['stw_custom_size'] = $sXML->children($sXMLLayout)->Response->Custom_Size->StatusCode; // Custom Size
	        $aResponse['stw_full_length'] = $sXML->children($sXMLLayout)->Response->Full_Length->StatusCode; // Full Length
	        $aResponse['stw_refresh_ondemand'] = $sXML->children($sXMLLayout)->Response->Refresh_OnDemand->StatusCode; // Refresh OnDemand
	        $aResponse['stw_custom_delay'] = $sXML->children($sXMLLayout)->Response->Custom_Delay->StatusCode; // Custom Delay
	        $aResponse['stw_custom_quality'] = $sXML->children($sXMLLayout)->Response->Custom_Quality->StatusCode; // Custom Quality
	        $aResponse['stw_custom_resolution'] = $sXML->children($sXMLLayout)->Response->Custom_Resolution->StatusCode; // Custom Resolution
	        $aResponse['stw_custom_messages'] = $sXML->children($sXMLLayout)->Response->Custom_Messages->StatusCode; // Custom Messages
        } else {
	        // LEGACY SUPPPORT
            $aResponse['stw_response_status'] = _getLegacyResponse('Status', $sRemoteData);
	        $aResponse['stw_account_level'] = _getLegacyResponse('Account_Level', $sRemoteData); // Account level
	        // check for enabled upgrades
	        $aResponse['stw_inside_pages'] = _getLegacyResponse('Inside_Pages', $sRemoteData); // Inside Pages
	        $aResponse['stw_custom_size'] = _getLegacyResponse('Custom_Size', $sRemoteData); // Custom Size
	        $aResponse['stw_full_length'] = _getLegacyResponse('Full_Length', $sRemoteData); // Full Length
	        $aResponse['stw_refresh_ondemand'] = _getLegacyResponse('Refresh_OnDemand', $sRemoteData); // Refresh OnDemand
	        $aResponse['stw_custom_delay'] = _getLegacyResponse('Custom_Delay', $sRemoteData); // Custom Delay
	        $aResponse['stw_custom_quality'] = _getLegacyResponse('Custom_Quality', $sRemoteData); // Custom Quality
	        $aResponse['stw_custom_resolution'] = _getLegacyResponse('Custom_Resolution', $sRemoteData); // Custom Resolution
	        $aResponse['stw_custom_messages'] = _getLegacyResponse('Custom_Messages', $sRemoteData); // Custom Messages
        }

        return $aResponse;
    }

?>
