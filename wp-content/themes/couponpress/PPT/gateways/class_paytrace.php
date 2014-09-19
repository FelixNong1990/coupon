<?php
//START - this section defiens the PayTrace API class, it can be centrally located and included throughout your application
	class PayTraceAPI {
		private $UN,$PSWD,$TERMS,$METHOD,$TRANXTYPE,$CC,$EXPMNTH,$EXPYR,$AMOUNT,$CSC,$BADDRESS,$BZIP;
		private $RESPONSE,$ERROR,$TRANSACTIONID,$APPCODE,$APPMSG,$AVSRESPONSE,$CSCRESPONSE;
		
		public function __construct() {
			$this->UN = "";
			$this->PSWD = "";
			$this->TERMS = "";
			$this->METHOD = "";
			$this->TRANXTYPE = "";
			$this->CC = "";
			$this->EXPMNTH = "";
			$this->EXPYR = "";
			$this->AMOUNT = "";
			$this->CSC = "";
			$this->BADDRESS = "";
			$this->BZIP = "";
		}
		
		public function SetUN($p_UN) {
			$this->UN = $p_UN;
		}
		public function SetPSWD($p_PSWD) {
			$this->PSWD = $p_PSWD;
		}
		public function SetTERMS($p_TERMS) {
			$this->TERMS = $p_TERMS;
		}
		public function SetMETHOD($p_METHOD) {
			$this->METHOD = $p_METHOD;
		}
		public function SetTRANXTYPE($p_TRANXTYPE) {
			$this->TRANXTYPE = $p_TRANXTYPE;
		}
		public function SetCC($p_CC) {
			$this->CC = $p_CC;
		}
		public function SetEXPMNTH($p_EXPMNTH) {
			$this->EXPMNTH = $p_EXPMNTH;
		}
		public function SetEXPYR($p_EXPYR) {
			$this->EXPYR = $p_EXPYR;
		}
		public function SetAMOUNT($p_AMOUNT) {
			$this->AMOUNT = $p_AMOUNT;
		}
		public function SetCSC($p_CSC) {
			$this->CSC = $p_CSC;
		}
		public function SetBADDRESS($p_BADDRESS) {
			$this->BADDRESS = $p_BADDRESS;
		}
		public function SetBZIP($p_BZIP) {
			$this->BZIP = $p_BZIP;
		}
		
		public function GetRESPONSE() {
			return $this->RESPONSE;
		}
		public function GetERROR() {
			return $this->ERROR;
		}
		public function GetTRANSACTIONID() {
			return $this->TRANSACTIONID;
		}
		public function GetAPPCODE() {
			return $this->APPCODE;
		}
		public function GetAPPMSG() {
			return $this->APPMSG;
		}
		public function GetAVSRESPONSE() {
			return $this->AVSRESPONSE;
		}
		public function GetCSCRESPONSE() {
			return $this->CSCRESPONSE;
		}
		
		public function __destruct() {
			$this->UN = "";
			$this->PSWD = "";
			$this->TERMS = "";
			$this->METHOD = "";
			$this->TRANXTYPE = "";
			$this->CC = "";
			$this->EXPMNTH = "";
			$this->EXPYR = "";
			$this->AMOUNT = "";
			$this->CSC = "";
			$this->BADDRESS = "";
			$this->BZIP = "";
			
			$this->RESPONSE = "";
			$this->ERROR = "";
			$this->TRANSACTIONID = "";
			$this->APPCODE = "";
			$this->APPMSG = "";
			$this->AVSRESPONSE = "";
			$this->CSCRESPONSE = "";
		}
		
		public function ProcessRequest() {
			$l_ParmList = $this->FormatRequest();
			$l_Response = $this->SendRequest($l_ParmList);
			$this->ParseResponse($l_Response);
		}
	
	  private function FormatRequest() {
	  	//create the API request
			$l_parmlist = "UN~" . $this->UN . "|";
			$l_parmlist .= "PSWD~" . $this->PSWD . "|";
			$l_parmlist .= "TERMS~" . $this->TERMS . "|";
			$l_parmlist .= "METHOD~" . $this->METHOD . "|";
			$l_parmlist .= "TRANXTYPE~" . $this->TRANXTYPE . "|";
			$l_parmlist .= "CC~" . $this->CC . "|";
			$l_parmlist .= "EXPMNTH~" . $this->EXPMNTH . "|";
			$l_parmlist .= "EXPYR~" . $this->EXPYR . "|";
			$l_parmlist .= "AMOUNT~" . $this->AMOUNT . "|";
			$l_parmlist .= "CSC~" . $this->CSC . "|";
			$l_parmlist .= "BADDRESS~" . $this->BADDRESS . "|";
			$l_parmlist .= "BZIP~" . $this->BZIP . "|";
			//URL encode the request
			$l_parmlist = "ParmList=" . urlencode($l_parmlist);
			return $l_parmlist;
	  }
	
	  private function SendRequest($p_ParmList) {
			//set up the CURL instance
			$l_Header = array("MIME-Version: 1.0","Content-type: application/x-www-form-urlencoded","Contenttransfer-encoding: text");
			$l_URL = "https://paytrace.com/api/default.pay";
			$l_CURL = curl_init();
			curl_setopt($l_CURL, CURLOPT_URL, $l_URL);
			curl_setopt($l_CURL, CURLOPT_VERBOSE, 1);
			curl_setopt ($l_CURL, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt($l_CURL, CURLOPT_HTTPHEADER, $l_Header);
			//Depending on your PHP Host, you may need to specify their proxy server
			//curl_setopt ($l_CURL, CURLOPT_PROXY, "http://64.202.165.130:3128");
			//The proxy information above is for GoDaddy.com
			curl_setopt($l_CURL, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($l_CURL, CURLOPT_POST, true);
			curl_setopt($l_CURL, CURLOPT_POSTFIELDS, $p_ParmList);
			curl_setopt($l_CURL, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($l_CURL, CURLOPT_TIMEOUT, 10);
			$l_Response = curl_exec($l_CURL);
			curl_close($l_CURL);
			return $l_Response;
	  }
	
	  private function ParseResponse($p_Response) {
			if ( $p_Response == "" ) {
				$this->ERROR .= "The request did not receive a valid response from the network, please try again.";
			}
			else {
				$l_HasAPipe = strpos($p_Response,"|");
				$l_HasATilde = strpos($p_Response,"~");
				if ( $l_HasAPipe === false || $l_HasATilde == false ) {
					$this->ERROR .= "The request did not receive a valid response from the network, please try again.";
				}
				else {
					//parse through the response and put pairs into an array
					$l_ResponseArray = explode('|', $p_Response);
					foreach ($l_ResponseArray as $l_NameValuePair ){
						$l_HasATilde = strpos($l_NameValuePair,"~");
						if ( $l_HasATilde == true ) {
							$l_NameValuePairArray = explode('~',$l_NameValuePair);
							$l_ArrayOfPairs[$l_NameValuePairArray[0]] = $l_NameValuePairArray[1];
						}
					}
					//loop through the array of pairs and put the data into the class properties
					foreach($l_ArrayOfPairs as $l_Name => $l_Value){
						if ( $l_Name == "RESPONSE" ) {
							$this->RESPONSE = $l_Value;
						}
						elseif ( $l_Name == "ERROR" ) {
							$this->ERROR .= $l_Value;
						}
						elseif ( $l_Name == "TRANSACTIONID" ) {
							$this->TRANSACTIONID = $l_Value;
						}
						elseif ( $l_Name == "APPCODE" ) {
							$this->APPCODE = $l_Value;
						}
						elseif ( $l_Name == "APPMSG" ) {
							$this->APPMSG = $l_Value;
						}
						elseif ( $l_Name == "AVSRESPONSE" ) {
							$this->AVSRESPONSE = $l_Value;
						}
						elseif ( $l_Name == "CSCRESPONSE" ) {
							$this->CSCRESPONSE = $l_Value;
						}
					}
				}
			}
	  }
	
	  public function DidErrorOccur() {
			$DidErrorOccur = false;
			if ( $this->ERROR != "" ) {
				$DidErrorOccur = true;
			}
			return $DidErrorOccur;
	  }
	
	  public function WasTransactionApproved() {
			$l_WasApproved = false;
			if ( $this->DidErrorOccur() == false ) {
				if ( $this->APPCODE != "" ) {
					$l_WasApproved = true;
				}
			}
			return $l_WasApproved;
	  }
	}
//END - this section defiens the PayTrace API class, it can be centrally located and included throughout your application
?>