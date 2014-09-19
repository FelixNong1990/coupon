<?php
 
class VideoProvider {
 	protected $height = 400;
	protected $width = 640;
	protected $link = ""; 
 
	// getEmbedCode
	public function getEmbedCode($videoLink, $width = null, $height = null) {
		 
		if ($videoLink != "") {
			if(!is_numeric(strpos($videoLink, "http://"))){
				$videoLink =  "http://".$videoLink;
			}
			$this->link = $videoLink;
			$embedCode = "";
			$videoProvider = $this->decideVideoProvider();	
			if($videoProvider == "") {
				$embedCode = false;
			} else {
				$embedCode = $this->generateEmbedCode($videoProvider);		
			}
		} else {
			$embedCode = false;
		}
		return $embedCode;
	}
	// decide video provider
	private function decideVideoProvider(){
		$videoProvider= "";
		$hostings = array(	'youtube', 
							'vimeo', 
							'break', 
							'dailymotion', 
							'yahoo', 
							'metacafe', 
							'viddler', 
							'blip', 
							'myspace',
							'megavideo',
							'twitcam',
							'ustream',
							'livestream',
							'twitcam.livestream',
							'gametrailers');
							
		for($i=0; $i<count($hostings); $i++) {
			if(is_numeric(strpos($this->link, $hostings[$i]))){
				$videoProvider = $hostings[$i];
			}
		}
		return $videoProvider;
	}	
	// generate video ıd from link
	private function getVideoId ($operand, $optionaOperand = null) {
		$videoId  = null;
		$startPosCode = strpos($this->link, $operand);
		if ($startPosCode != null) {
			$videoId = substr($this->link, $startPosCode + strlen($operand), strlen($this->link)-1);
			if(!is_null($optionaOperand)) {
				$startPosCode = strpos($videoId, $optionaOperand);	
				if ($startPosCode > 0) {
					$videoId = substr($videoId , 0, $startPosCode);	
				}	
			}	
		}
		return $videoId;
	}
	// generate video embed code via using standart templates
	private function generateEmbedCode ($videoProvider) {
		switch($videoProvider) {
			case 'youtube':
			
				$videoId = $this->getVideoId("v=","&");
				
				
				$youtube 	= new YouTube( $videoId );			
				$meta	 	= $youtube->get_meta();
				 
				if(strlen(str_replace("!!**","",$meta['title'])) > 2){
				$rA = array(
				"ID" => $videoId,
				"network" => "youtube",
				"title" => str_replace("!!**","",$meta['title']),
				"image" => str_replace("!!**","",$meta['thumb']),
				"link" => $this->link,
				"embed" => str_replace("!!**","",$meta['embed']),
				"desc" => str_replace("!!**","",$meta['description']),
				"duration" => str_replace("!!**","",$meta['duration']),
				"views" => str_replace("!!**","",$meta['views']),
				);
				return $rA;
				
				}else{
				
				return false;
				
				}
				 
				break;
			case 'vimeo':
			
				$vimeo = new phpVimeo('f53cab9645f76e61472d86ea321cf145', '28be897bc2e3b159');
					
				$videoId = $this->getVideoId(".com/");
					
				$videoinfo = $vimeo->call('vimeo.videos.getInfo', array('video_id' => $videoId));
				
				if(strlen(str_replace("!!**","",$videoinfo->video[0]->title)) > 2){
				
				$embedCode .= "<object width=\"".$this->width."\" height=\"".$this->height."\">";
						$embedCode .= "<param name=\"allowfullscreen\" value=\"true\" />";
						$embedCode .= "<param name=\"allowscriptaccess\" value=\"always\" />";
						$embedCode .= "<param name=\"movie\" value=\"http://vimeo.com/moogaloop.swf?clip_id=".$videoId;
						$embedCode .= "&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=E8DA28&amp;fullscreen=1\" />";
						$embedCode .= "<embed src=\"http://vimeo.com/moogaloop.swf?clip_id=".$videoId;
						$embedCode .= "&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=E8DA28&amp;fullscreen=1\"";
						$embedCode .= "type=\"application/x-shockwave-flash\"";
						$embedCode .= " allowfullscreen=\"true\" allowscriptaccess=\"always\" width=\"".$this->width."\" height=\"".$this->height."\"></embed>";
						$embedCode .= "</object>";
				
				$rA = array(
						"ID" => $videoId,
						"network" => "vinmeo",
						"title" => str_replace("!!**","",$videoinfo->video[0]->title),
						"image" => $videoinfo->video[0]->thumbnails->thumbnail[0]->_content,
						"link" => $this->link,
						"embed" => $embedCode,
						"desc" => str_replace("!!**","",$videoinfo->video[0]->description),
						"duration" => str_replace("!!**","",$videoinfo->video[0]->duration),
					);
					
				return $rA;
	 
				}else{
				
				return false;
				
				}	 
		  				
				break;
			case 'break':
				$videoId = $this->getBreakInfo($this->link);
				if ($videoId != null) {					
					$embedCode .= "<object width=\"".$this->width."\" height=\"".$this->height."\" id=\"".$videoId."\" type=\"application/x-shockwave-flash\"";
					$embedCode .= "	classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\">";
					$embedCode .= "<param name=\"movie\" value=\"http://embed.break.com/".$videoId."\"></param>";
					$embedCode .= "<param name=\"allowScriptAccess\" value=\"always\"></param>";
					$embedCode .= "<embed src=\"http://embed.break.com/".$videoId."\" type=\"application/x-shockwave-flash\" ";
					$embedCode .= "allowScriptAccess=always width=\"".$this->width."\" height=\"".$this->height."\"></embed></object>";
				} else {
					$embedCode = INVALID_URL;
				}	
				break;
			case 'dailymotion':
				$videoId = $this->getVideoId("video/");	
				if ($videoId != null) {					
					$embedCode .= "<object width=\"".$this->width."\" height=\"".$this->height."\"><param name=\"movie\" ";
					$embedCode .= "value=\"http://www.dailymotion.com/swf/video/".$videoId."\"></param>";
					$embedCode .= "<param name=\"allowFullScreen\" value=\"true\"></param>";
					$embedCode .= "<param name=\"allowScriptAccess\" value=\"always\"></param>";
					$embedCode .= "<embed type=\"application/x-shockwave-flash\" src=\"http://www.dailymotion.com/swf/video/".$videoId."\" ";
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" allowfullscreen=\"true\" allowscriptaccess=\"always\"></embed>";
					$embedCode .= "</object>";	
				} else {
					$embedCode = INVALID_URL;
				}					
				break;	
			case 'yahoo':
				$videoIds = $this->getVideoId("watch/");
				if(strlen($videoIds) == 0) {
					$videoIds = $this->getVideoId("network/");
				}
				if ($videoIds != null) {					
					$startPosCode = strpos($videoIds, "/");
					$firstID = substr($videoIds , 0, $startPosCode);
					$secondID = substr($videoIds , $startPosCode+1, strlen($this->link)-1);
					$embedCode .= "<object width=\"".$this->width."\" height=\"".$this->height."\">";
					$embedCode .= "<param name=\"movie\" value=\"http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46\" />";
					$embedCode .= "<param name=\"allowFullScreen\" value=\"true\" /><param name=\"AllowScriptAccess\" VALUE=\"always\" />";
					$embedCode .= "<param name=\"bgcolor\" value=\"#000000\" />";
					$embedCode .= "<param name=\"flashVars\" value=\"id=".$secondID."&vid=".$firstID."&lang=en-us&intl=us&embed=0\" />";
					$embedCode .= "<embed src=\"http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46\" ";
					$embedCode .= "type=\"application/x-shockwave-flash\" width=\"".$this->width."\" height=\"".$this->height."\" allowFullScreen=\"true\"";
					$embedCode .= " AllowScriptAccess=\"always\" bgcolor=\"#000000\" flashVars=\"id=".$secondID."&vid=".$firstID;
					$embedCode .= "&lang=en-us&intl=us&embed=0\" >";
					$embedCode .= "</embed></object>";
				} else {
					$embedCode = INVALID_URL;
				}
				break;			
			case 'metacafe':
		 
			
				$videoFullID = $this->getVideoId("watch/");	
				$videoFullID = substr($videoFullID, 0, strlen($videoFullID)-1);	
				$videoId = strpos($videoFullID, "/");
				$videoId = substr($videoFullID, 0, $videoId); 
				 
				$feedURL = 'http://www.metacafe.com/api/item/'.$videoId; 
				$dd = simplexml_load_file($feedURL);
	
				if(strlen(str_replace("!!**","",$dd->channel->item->title)) > 2){ 
	
					$embedCode .= "<embed flashVars=\"playerVars=showStats=no|autoPlay=no|\" ";
					$embedCode .= "src=\"http://www.metacafe.com/fplayer/".$videoFullID.".swf\" "; 
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" wmode=\"transparent\" allowFullScreen=\"true\" "; 
					$embedCode .= "allowScriptAccess=\"always\" name=\"Metacafe_".$videoId."\" "; 
					$embedCode .= "pluginspage=\"http://www.macromedia.com/go/getflashplayer\" "; 
					$embedCode .= "type=\"application/x-shockwave-flash\"></embed>";
		
					$rA = array(
					"ID" => $videoId,
					"network" => "metacafe",
					"title" => str_replace("!!**","",$dd->channel->item->title),
					"image" => "http://www.metacafe.com/thumb/".$videoId.".jpg",
					"link" => $this->link,
					"embed" => $embedCode,
					"desc" => str_replace("!!**","",strip_tags($dd->channel->item->description)),
					"duration" => "",
					);
					
					return $rA;
				
				}else{
				return false;
				}
	
	 				
				break;	
			case 'viddler':
				$videoId = $this->getViddlerInfo($this->link);	
				if ($videoId != null) {					
					$embedCode .= "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"".$this->width."\" height=\"".$this->height."\" ";
					$embedCode .= "id=\"viddler_1f72e4ee\">";
					$embedCode .= "<param name=\"movie\" value=\"http://www.viddler.com/player/".$videoId."\"/\" />";
					$embedCode .= "<param name=\"allowScriptAccess\" value=\"always\" />";
					$embedCode .= "<param name=\"allowFullScreen\" value=\"true\" />";
					$embedCode .= "<embed src=\"http://www.viddler.com/player/".$videoId."\"/\"";
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" type=\"application/x-shockwave-flash\" ";
					$embedCode .= "allowScriptAccess=\"always\"";
					$embedCode .= "allowFullScreen=\"true\" name=\"viddler_".$videoId."\"\"></embed></object>";
				} else {
					$embedCode = INVALID_URL;
				}	
		 
				
				break;	
			case 'blip':
			
			$ID = explode("?",str_replace("/","",str_replace("http://blip.tv/file/","",$this->link)));		 
			if(is_numeric($ID[0])){
			 
				$dd = simplexml_load_file("http://www.blip.tv/file/".$ID[0]."?skin=api");
				
				$rA = array(
				"ID" => $ID[0],
				"title" => str_replace("!!**","",$dd->payload->asset->title),
				"image" => "",
				"link" => $this->link,
				"embed" => str_replace("!!**","",$dd->payload->asset->embedCode[0]),
				"desc" => str_replace("!!**","",$dd->payload->asset->description[0]),
				"duration" => str_replace("!!**","",$dd->payload->asset->mediaList->media[0]->duration),
				);
				 
				return $rA;
			
			}else{
			return false;
			}
			 				
				break;
			case 'myspace':
				$this->link = strtolower($this->link);
				$videoId = $this->getVideoId("videoid=","&");
				if ($videoId != null) {
					$embedCode .= "<object width=\"".$this->width."\" height=\"".$this->height."\" ><param name=\"allowFullScreen\" ";
					$embedCode .= "value=\"true\"/><param name=\"wmode\" value=\"transparent\"/><param name=\"movie\" ";
					$embedCode .= "value=\"http://mediaservices.myspace.com/services/media/embed.aspx/m=".$videoId.",t=1,mt=video\"/>";
					$embedCode .= "<embed src=\"http://mediaservices.myspace.com/services/media/embed.aspx/m=".$videoId.",t=1,mt=video\" ";
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" allowFullScreen=\"true\" type=\"application/x-shockwave-flash\" ";
					$embedCode .= "wmode=\"transparent\"></embed></object>";
				} else {
					$embedCode = INVALID_URL;
				}					
				break;	
			case 'megavideo':
				$videoId = $this->getVideoId("v=");
				if ($videoId != null) {
					$embedCode .="<object width=\"".$this->width."\" height=\"".$this->height."\">";
					$embedCode .="<param name=\"movie\" value=\"http://www.megavideo.com/v/".$videoId."></param>";
					$embedCode .="<param name=\"allowFullScreen\" value=\"true\"></param>";
					$embedCode .="<embed src=\"http://www.megavideo.com/v/".$videoId."\" type=\"application/x-shockwave-flash\" ";
					$embedCode .="allowfullscreen=\"true\" width=\"".$this->width."\" height=\"".$this->height."\"></embed></object>";
				} else {
					$embedCode = INVALID_URL;
				}	
				break;			
			case 'twitcam.livestream':
			case 'twitcam':
				$videoId = $this->getVideoId("com/");
				if ($videoId != null) {
					$embedCode .="<object id=\"twitcamPlayer\" width=\"".$this->width."\" height=\"".$this->height."\" ";
					$embedCode .="classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\">";
					$embedCode .="<param name=\"movie\" ";
					$embedCode .="value=\"http://static.livestream.com/chromelessPlayer/wrappers/TwitcamPlayer.swf?hash=".$videoId."\"/>";
					$embedCode .="<param name=\"allowFullScreen\" value=\"true\"/><param name=\"wmode\" value=\"window\"/>";
					$embedCode .="<embed name=\"twitcamPlayer\" ";
					$embedCode .="src=\"http://static.livestream.com/chromelessPlayer/wrappers/TwitcamPlayer.swf?hash=".$videoId."\" ";
					$embedCode .="allowFullScreen=\"true\" type=\"application/x-shockwave-flash\" bgcolor=\"#ffffff\" ";
					$embedCode .="width=\"".$this->width."\" height=\"".$this->height."\" wmode=\"window\" ></embed></object>";
				} else {
					$embedCode = INVALID_URL;
				}	
				break;
				
			case 'ustream':
				$videoId = $this->getVideoId("recorded/",'/');
				if ($videoId != null) {			
					$embedCode .= "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ";
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" ";
					$embedCode .= "id=\"utv867721\" name=\"utv_n_859419\"><param name=\"flashvars\" ";
					$embedCode .= "value\"beginPercent=0.0236&amp;endPercent=0.2333&amp;autoplay=false&locale=en_US\" />";
					$embedCode .= "<param name=\"allowfullscreen\" value=\"true\" /><param name=\"allowscriptaccess\" ";			
					$embedCode .= "value=\"always\" />";
					$embedCode .= "<param name=\"src\" value=\"http://www.ustream.tv/flash/video/".$videoId."\" />";
					$embedCode .= "<embed flashvars=\"beginPercent=0.0236&amp;endPercent=0.2333&amp;autoplay=false&locale=en_US\" ";
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" ";
					$embedCode .= "allowfullscreen=\"true\" allowscriptaccess=\"always\" id=\"utv867721\" ";
					$embedCode .= "name=\"utv_n_859419\" src=\"http://www.ustream.tv/flash/video/".$videoId."\" ";
					$embedCode .= "type=\"application/x-shockwave-flash\" /></object>";
				} else {
					$embedCode = INVALID_URL;
				}
				break;				
			case 'livestream':
				$firstID = $this->getVideoId("com/",'/');
				$secondID = $this->getVideoId("?clipId=",'&');
				if ($firstID != null && $secondID != null) {					
					$embedCode .= "<object width=\"".$this->width."\" height=\"".$this->height."\" id=\"lsplayer\" ";
					$embedCode .= "classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\">";
					$embedCode .= "<param name=\"movie\" ";
					$embedCode .= "value=\"http://cdn.livestream.com/grid/LSPlayer.swf?channel=".$firstID."&amp;";
					$embedCode .= "clip=".$secondID."&amp;autoPlay=false\"></param>";
					$embedCode .= "<param name=\"allowScriptAccess\" value=\"always\"></param><param name=\"allowFullScreen\" ";
					$embedCode .= "value=\"true\"></param><embed name=\"lsplayer\" wmode=\"transparent\" ";
					$embedCode .= "src=\"http://cdn.livestream.com/grid/LSPlayer.swf?channel=".$firstID."&amp;";
					$embedCode .= "clip=".$secondID."&amp;autoPlay=false\" ";
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" allowScriptAccess=\"always\" allowFullScreen=\"true\" ";
					$embedCode .= "type=\"application/x-shockwave-flash\"></embed></object>	";
				} else {
					$embedCode = INVALID_URL;
				}
				break;			
			case 'gametrailers':
				$videoFullID = $this->getVideoId("video/");
				$videoId  = strpos($videoFullID, "/");
				$videoId = substr($videoFullID, $videoId+1, strlen($videoFullID));
				if ($videoId != null) {
					$embedCode .= "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ";
					$embedCode .= "codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" ";
					$embedCode .= "id=\"gtembed\" width=\"".$this->width."\" height=\"".$this->height."\" ><param name=\"allowScriptAccess\" value=\"sameDomain\" />";
					$embedCode .= "<param name=\"allowFullScreen\" value=\"true\" />";
					$embedCode .= "<param name=\"movie\" value=\"http://www.gametrailers.com/remote_wrap.php?mid=".$videoId."\"/>";
					$embedCode .= "<param name=\"quality\" value=\"high\" /> <embed src=\"http://www.gametrailers.com/remote_wrap.php?mid=".$videoId."\" ";
					$embedCode .= "swLiveConnect=\"true\" name=\"gtembed\" align=\"middle\" allowScriptAccess=\"sameDomain\" allowFullScreen=\"true\" ";
					$embedCode .= "quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" ";
					$embedCode .= "width=\"".$this->width."\" height=\"".$this->height."\" ></embed> </object>";					
				} else {
					$embedCode = INVALID_URL;
				}
				break;
		}
		return $embedCode;
	}
	// get link form page
	private function getBreakInfo($url) {
		return $this->getVideoInfo($url, '/<input.*?id=.hdnContentId.*?value=.(.*?)(\'|")/ms');
	}
	// get link form page
	private function getBlipInfo($url) {
		return $this->getVideoInfo($url, '/<link.*?rel=.video_src.*?href=.(.*?)(\'|")/ms');
	}
	// get link form page
	private function getViddlerInfo($url) {
		return $this->getVideoInfo($url, '/<input.*?name=.movieToken.*?value=.(.*?)(\'|")/ms');
	}
	// get link form page
	private function getVideoInfo($url, $matchCase) {
		$html = $this->geturl($url);
		if(stripos($html, "302 Moved") !== false) {
			$html = $this->geturl(match('/HREF="(.*?)"/ms', $html, 1));
		}
		$arr = $this->match($matchCase, $html, 1);
		return $arr;
	}
	
	private function setDimensions ($width = null, $height = null) {
		if((!is_null($width)) && ($width != "")) {
			$this->width  = $width;
		}		
		
		if((!is_null($height)) && ($height != "")) {
			$this->height = $height;		
		}	
	}
	
	private function geturl($url, $username = null, $password = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$html = curl_exec($ch);
		curl_close($ch);
		return $html;
	}
	
	private function match($regex, $str, $i = 0)
	{
		if(preg_match($regex, $str, $match) == 1) {
			return $match[$i];
		} else {
			return null;
		}
	}	
}

class phpVimeo
{
    const API_REST_URL = 'http://vimeo.com/api/rest/v2';
    const API_AUTH_URL = 'http://vimeo.com/oauth/authorize';
    const API_ACCESS_TOKEN_URL = 'http://vimeo.com/oauth/access_token';
    const API_REQUEST_TOKEN_URL = 'http://vimeo.com/oauth/request_token';

    const CACHE_FILE = 'file';

    private $_consumer_key = false;
    private $_consumer_secret = false;
    private $_cache_enabled = false;
    private $_cache_dir = false;
    private $_token = false;
    private $_token_secret = false;
    private $_upload_md5s = array();

    public function __construct($consumer_key, $consumer_secret, $token = null, $token_secret = null)
    {
        $this->_consumer_key = $consumer_key;
        $this->_consumer_secret = $consumer_secret;

        if ($token && $token_secret) {
            $this->setToken($token, $token_secret);
        }
    }

    /**
     * Cache a response.
     *
     * @param array $params The parameters for the response.
     * @param string $response The serialized response data.
     */
    private function _cache($params, $response)
    {
        // Remove some unique things
        unset($params['oauth_nonce']);
        unset($params['oauth_signature']);
        unset($params['oauth_timestamp']);

        $hash = md5(serialize($params));

        if ($this->_cache_enabled == self::CACHE_FILE) {
            $file = $this->_cache_dir.'/'.$hash.'.cache';
            if (file_exists($file)) {
                unlink($file);
            }
            return file_put_contents($file, $response);
        }
    }

    /**
     * Create the authorization header for a set of params.
     *
     * @param array $oauth_params The OAuth parameters for the call.
     * @return string The OAuth Authorization header.
     */
    private function _generateAuthHeader($oauth_params)
    {
        $auth_header = 'Authorization: OAuth realm=""';

        foreach ($oauth_params as $k => $v) {
            $auth_header .= ','.self::url_encode_rfc3986($k).'="'.self::url_encode_rfc3986($v).'"';
        }

        return $auth_header;
    }

    /**
     * Generate a nonce for the call.
     *
     * @return string The nonce
     */
    private function _generateNonce()
    {
        return md5(uniqid(microtime()));
    }

    /**
     * Generate the OAuth signature.
     *
     * @param array $args The full list of args to generate the signature for.
     * @param string $request_method The request method, either POST or GET.
     * @param string $url The base URL to use.
     * @return string The OAuth signature.
     */
    private function _generateSignature($params, $request_method = 'GET', $url = self::API_REST_URL)
    {
        uksort($params, 'strcmp');
        $params = self::url_encode_rfc3986($params);

        // Make the base string
        $base_parts = array(
            strtoupper($request_method),
            $url,
            urldecode(http_build_query($params, '', '&'))
        );
        $base_parts = self::url_encode_rfc3986($base_parts);
        $base_string = implode('&', $base_parts);

        // Make the key
        $key_parts = array(
            $this->_consumer_secret,
            ($this->_token_secret) ? $this->_token_secret : ''
        );
        $key_parts = self::url_encode_rfc3986($key_parts);
        $key = implode('&', $key_parts);

        // Generate signature
        return base64_encode(hash_hmac('sha1', $base_string, $key, true));
    }

    /**
     * Get the unserialized contents of the cached request.
     *
     * @param array $params The full list of api parameters for the request.
     */
    private function _getCached($params)
    {
        // Remove some unique things
        unset($params['oauth_nonce']);
        unset($params['oauth_signature']);
        unset($params['oauth_timestamp']);

        $hash = md5(serialize($params));

        if ($this->_cache_enabled == self::CACHE_FILE) {
            $file = $this->_cache_dir.'/'.$hash.'.cache';
            if (file_exists($file)) {
                return unserialize(file_get_contents($file));
            }
        }
    }

    /**
     * Call an API method.
     *
     * @param string $method The method to call.
     * @param array $call_params The parameters to pass to the method.
     * @param string $request_method The HTTP request method to use.
     * @param string $url The base URL to use.
     * @param boolean $cache Whether or not to cache the response.
     * @param boolean $use_auth_header Use the OAuth Authorization header to pass the OAuth params.
     * @return string The response from the method call.
     */
    private function _request($method, $call_params = array(), $request_method = 'GET', $url = self::API_REST_URL, $cache = true, $use_auth_header = true)
    {
        // Prepare oauth arguments
        $oauth_params = array(
            'oauth_consumer_key' => $this->_consumer_key,
            'oauth_version' => '1.0',
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_nonce' => $this->_generateNonce()
        );

        // If we have a token, include it
        if ($this->_token) {
            $oauth_params['oauth_token'] = $this->_token;
        }

        // Regular args
        $api_params = array('format' => 'php');
        if (!empty($method)) {
            $api_params['method'] = $method;
        }

        // Merge args
        foreach ($call_params as $k => $v) {
            if (strpos($k, 'oauth_') === 0) {
                $oauth_params[$k] = $v;
            }
            else {
                $api_params[$k] = $v;
            }
        }

        // Generate the signature
        $oauth_params['oauth_signature'] = $this->_generateSignature(array_merge($oauth_params, $api_params), $request_method, $url);

        // Merge all args
        $all_params = array_merge($oauth_params, $api_params);

        // Returned cached value
        if ($this->_cache_enabled && ($cache && $response = $this->_getCached($all_params))) {
            return $response;
        }

        // Curl options
        if ($use_auth_header) {
            $params = $api_params;
        }
        else {
            $params = $all_params;
        }

        if (strtoupper($request_method) == 'GET') {
            $curl_url = $url.'?'.http_build_query($params, '', '&');
            $curl_opts = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30
            );
        }
        else if (strtoupper($request_method) == 'POST') {
            $curl_url = $url;
            $curl_opts = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($params, '', '&')
            );
        }

        // Authorization header
        if ($use_auth_header) {
            $curl_opts[CURLOPT_HTTPHEADER] = array($this->_generateAuthHeader($oauth_params));
        }

        // Call the API
        $curl = curl_init($curl_url);
        curl_setopt_array($curl, $curl_opts);
        $response = curl_exec($curl);
        $curl_info = curl_getinfo($curl);
        curl_close($curl);

        // Cache the response
        if ($this->_cache_enabled && $cache) {
            $this->_cache($all_params, $response);
        }

        // Return
        if (!empty($method)) {
            $response = unserialize($response);
            if ($response->stat == 'ok') {
                return $response;
            }
            else if ($response->err) {
                throw new VimeoAPIException($response->err->msg, $response->err->code);
            }

            return false;
        }

        return $response;
    }

    /**
     * Send the user to Vimeo to authorize your app.
     * http://www.vimeo.com/api/docs/oauth
     *
     * @param string $perms The level of permissions to request: read, write, or delete.
     */
    public function auth($permission = 'read', $callback_url = 'oob')
    {
        $t = $this->getRequestToken($callback_url);
        $this->setToken($t['oauth_token'], $t['oauth_token_secret'], 'request', true);
        $url = $this->getAuthorizeUrl($this->_token, $permission);
        header("Location: {$url}");
    }

    /**
     * Call a method.
     *
     * @param string $method The name of the method to call.
     * @param array $params The parameters to pass to the method.
     * @param string $request_method The HTTP request method to use.
     * @param string $url The base URL to use.
     * @param boolean $cache Whether or not to cache the response.
     * @return array The response from the API method
     */
    public function call($method, $params = array(), $request_method = 'GET', $url = self::API_REST_URL, $cache = true)
    {
        $method = (substr($method, 0, 6) != 'vimeo.') ? "vimeo.{$method}" : $method;
        return $this->_request($method, $params, $request_method, $url, $cache);
    }

    /**
     * Enable the cache.
     *
     * @param string $type The type of cache to use (phpVimeo::CACHE_FILE is built in)
     * @param string $path The path to the cache (the directory for CACHE_FILE)
     * @param int $expire The amount of time to cache responses (default 10 minutes)
     */
    public function enableCache($type, $path, $expire = 600)
    {
        $this->_cache_enabled = $type;
        if ($this->_cache_enabled == self::CACHE_FILE) {
            $this->_cache_dir = $path;
            $files = scandir($this->_cache_dir);
            foreach ($files as $file) {
                $last_modified = filemtime($this->_cache_dir.'/'.$file);
                if (substr($file, -6) == '.cache' && ($last_modified + $expire) < time()) {
                    unlink($this->_cache_dir.'/'.$file);
                }
            }
        }
        return false;
    }

    /**
     * Get an access token. Make sure to call setToken() with the
     * request token before calling this function.
     *
     * @param string $verifier The OAuth verifier returned from the authorization page or the user.
     */
    public function getAccessToken($verifier)
    {
        $access_token = $this->_request(null, array('oauth_verifier' => $verifier), 'GET', self::API_ACCESS_TOKEN_URL, false, true);
        parse_str($access_token, $parsed);
        return $parsed;
    }

    /**
     * Get the URL of the authorization page.
     *
     * @param string $token The request token.
     * @param string $permission The level of permissions to request: read, write, or delete.
     * @param string $callback_url The URL to redirect the user back to, or oob for the default.
     * @return string The Authorization URL.
     */
    public function getAuthorizeUrl($token, $permission = 'read')
    {
        return self::API_AUTH_URL."?oauth_token={$token}&permission={$permission}";
    }

    /**
     * Get a request token.
     */
    public function getRequestToken($callback_url = 'oob')
    {
        $request_token = $this->_request(
            null,
            array('oauth_callback' => $callback_url),
            'GET',
            self::API_REQUEST_TOKEN_URL,
            false,
            false
        );

        parse_str($request_token, $parsed);
        return $parsed;
    }

    /**
     * Get the stored auth token.
     *
     * @return array An array with the token and token secret.
     */
    public function getToken()
    {
        return array($this->_token, $this->_token_secret);
    }

    /**
     * Set the OAuth token.
     *
     * @param string $token The OAuth token
     * @param string $token_secret The OAuth token secret
     * @param string $type The type of token, either request or access
     * @param boolean $session_store Store the token in a session variable
     * @return boolean true
     */
    public function setToken($token, $token_secret, $type = 'access', $session_store = false)
    {
        $this->_token = $token;
        $this->_token_secret = $token_secret;

        if ($session_store) {
            $_SESSION["{$type}_token"] = $token;
            $_SESSION["{$type}_token_secret"] = $token_secret;
        }

        return true;
    }

    /**
     * Upload a video in one piece.
     *
     * @param string $file_path The full path to the file
     * @param boolean $use_multiple_chunks Whether or not to split the file up into smaller chunks
     * @param string $chunk_temp_dir The directory to store the chunks in
     * @param int $size The size of each chunk in bytes (defaults to 2MB)
     * @return int The video ID
     */
    public function upload($file_path, $use_multiple_chunks = false, $chunk_temp_dir = '.', $size = 2097152, $replace_id = null)
    {
        if (!file_exists($file_path)) {
            return false;
        }

        // Figure out the filename and full size
        $path_parts = pathinfo($file_path);
        $file_name = $path_parts['basename'];
        $file_size = filesize($file_path);

        // Make sure we have enough room left in the user's quota
        $quota = $this->call('vimeo.videos.upload.getQuota');
        if ($quota->user->upload_space->free < $file_size) {
            throw new VimeoAPIException('The file is larger than the user\'s remaining quota.', 707);
        }

        // Get an upload ticket
        $params = array();

        if ($replace_id) {
            $params['video_id'] = $replace_id;
        }

        $rsp = $this->call('vimeo.videos.upload.getTicket', $params, 'GET', self::API_REST_URL, false);
        $ticket = $rsp->ticket->id;
        $endpoint = $rsp->ticket->endpoint;

        // Make sure we're allowed to upload this size file
        if ($file_size > $rsp->ticket->max_file_size) {
            throw new VimeoAPIException('File exceeds maximum allowed size.', 710);
        }

        // Split up the file if using multiple pieces
        $chunks = array();
        if ($use_multiple_chunks) {
            if (!is_writeable($chunk_temp_dir)) {
                throw new Exception('Could not write chunks. Make sure the specified folder has write access.');
            }

            // Create pieces
            $number_of_chunks = ceil(filesize($file_path) / $size);
            for ($i = 0; $i < $number_of_chunks; $i++) {
                $chunk_file_name = "{$chunk_temp_dir}/{$file_name}.{$i}";

                // Break it up
                $chunk = file_get_contents($file_path, FILE_BINARY, null, $i * $size, $size);
                $file = file_put_contents($chunk_file_name, $chunk);

                $chunks[] = array(
                    'file' => realpath($chunk_file_name),
                    'size' => filesize($chunk_file_name)
                );
            }
        }
        else {
            $chunks[] = array(
                'file' => realpath($file_path),
                'size' => filesize($file_path)
            );
        }

        // Upload each piece
        foreach ($chunks as $i => $chunk) {
            $params = array(
                'oauth_consumer_key'     => $this->_consumer_key,
                'oauth_token'            => $this->_token,
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_timestamp'        => time(),
                'oauth_nonce'            => $this->_generateNonce(),
                'oauth_version'          => '1.0',
                'ticket_id'              => $ticket,
                'chunk_id'               => $i
            );

            // Generate the OAuth signature
            $params = array_merge($params, array(
                'oauth_signature' => $this->_generateSignature($params, 'POST', self::API_REST_URL),
                'file_data'       => '@'.$chunk['file'] // don't include the file in the signature
            ));

            // Post the file
            $curl = curl_init($endpoint);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            $rsp = curl_exec($curl);
            curl_close($curl);
        }

        // Verify
        $verify = $this->call('vimeo.videos.upload.verifyChunks', array('ticket_id' => $ticket));

        // Make sure our file sizes match up
        foreach ($verify->ticket->chunks as $chunk_check) {
            $chunk = $chunks[$chunk_check->id];

            if ($chunk['size'] != $chunk_check->size) {
                // size incorrect, uh oh
                echo "Chunk {$chunk_check->id} is actually {$chunk['size']} but uploaded as {$chunk_check->size}<br>";
            }
        }

        // Complete the upload
        $complete = $this->call('vimeo.videos.upload.complete', array(
            'filename' => $file_name,
            'ticket_id' => $ticket
        ));

        // Clean up
        if (count($chunks) > 1) {
            foreach ($chunks as $chunk) {
                unlink($chunk['file']);
            }
        }

        // Confirmation successful, return video id
        if ($complete->stat == 'ok') {
            return $complete->ticket->video_id;
        }
        else if ($complete->err) {
            throw new VimeoAPIException($complete->err->msg, $complete->err->code);
        }
    }

    /**
     * Upload a video in multiple pieces.
     *
     * @deprecated
     */
    public function uploadMulti($file_name, $size = 1048576)
    {
        // for compatibility with old library
        return $this->upload($file_name, true, '.', $size);
    }

    /**
     * URL encode a parameter or array of parameters.
     *
     * @param array/string $input A parameter or set of parameters to encode.
     */
    public static function url_encode_rfc3986($input)
    {
        if (is_array($input)) {
            return array_map(array('phpVimeo', 'url_encode_rfc3986'), $input);
        }
        else if (is_scalar($input)) {
            return str_replace(array('+', '%7E'), array(' ', '~'), rawurlencode($input));
        }
        else {
            return '';
        }
    }

}

class VimeoAPIException extends Exception {}

class YouTube
{
	/* Author Information */
	private	$_author;
	private	$_author_url;
	
	/* Video Information */
	private	$_id;
	private $_title;
	private $_description;
	private $_url;
	private	$_embed;
	private	$_thumb;
	private $_duration;
	private $_rating;
	
	/* Feed Information */
	private	$_feed;
	private $_feed_url;
	
	/* Comment Information */
	private $_comments_url;
	private	$_comments_count;
	
	public function __construct( $video_id )
    {
		/* Save the video id */
		$this->_id		 = $video_id;
		
		/* Store the feed url and load it to object */
    	$this->_feed_url = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id;
		$this->_feed	 = (Object) simplexml_load_file( $this->_feed_url );
		
		/* Extract data */
		$this->process();
    }
    
    private function process()
	{
		/* Parse author information */
		$this->_author		= $this->_feed->author->name;
		$this->_author_url	= $this->_feed->author->uri;
		
		/* get nodes in media: namespace for media information */
		$media 				= $this->_feed->children( 'http://search.yahoo.com/mrss/' );
		$this->_title 		= $media->group->title;
		$this->_description	= $media->group->description;
		
		/* Create embed code */
		$this->_embed		= '<object width="640" height="385">'
							. '<param name="movie" value="http://www.youtube.com/v/' . $this->_id . '?fs=1&amp;hl=en_GB"></param>'
							. '<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>'
							. '<embed src="http://www.youtube.com/v/' . $this->_id . '?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed>'
							. '</object>';
		
		 
		/* get video player URL */
		//$attrs				= $media->group->player->attributes();
		//$this->_url			= $attrs['url']; 
		
		/* get video thumbnail */
		$attrs				= $media->group->thumbnail[0]->attributes();
		$this->_thumb	 	= $attrs['url']; 
            
		/* get <yt:duration> node for video length */
		$yt 				= $media->children( 'http://gdata.youtube.com/schemas/2007' );
		$attrs 				= $yt->duration->attributes();
		$this->_duration	= $attrs['seconds']; 
      
		/* get <yt:stats> node for viewer statistics */
		$yt 				= $this->_feed->children( 'http://gdata.youtube.com/schemas/2007' );
		$attrs				= $yt->statistics->attributes();
		$this->_views		= $attrs['viewCount']; 
      
		/* get <gd:rating> node for video ratings */
		$gd					= $this->_feed->children( 'http://schemas.google.com/g/2005' ); 
		
		if( $gd->rating )
		{ 
			$attrs			= $gd->rating->attributes();
			$this->_rating	= $attrs['average']; 
		}
		else
		{
			$this->_rating	= 0;         
		}
        
		/* get <gd:comments> node for video comments */
		$gd					= $this->_feed->children( 'http://schemas.google.com/g/2005' );
		
		if( $gd->comments->feedLink )
		{ 
			$attrs					= $gd->comments->feedLink->attributes();
			$this->_comments_url	= $attrs['href']; 
			$this->_comments_count	= $attrs['countHint']; 
		}
      
		/* get feed URL for video responses */
		$this->_feed->registerXPathNamespace( 'feed', 'http://www.w3.org/2005/Atom' );
		$nodeset					= $this->_feed->xpath( "feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.responses']" ); 
		
		if( count( $nodeset ) > 0 )
		{
			$this->_responses_url	= $nodeset[0]['href'];      
		}
         
		/* get feed URL for related videos */
		$this->_feed->registerXPathNamespace( 'feed', 'http://www.w3.org/2005/Atom' );
		$nodeset					= $this->_feed->xpath( "feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.related']" ); 
		
		if( count( $nodeset ) > 0 )
		{
			$this->_related_url		= $nodeset[0]['href'];      
		}
	}
	
	/* Returns information regarding the video itself */
	public function get_meta()
	{
		$array					= array();
		$array['id']			= $this->_id;
		$array['title']			= $this->_title;
		$array['description']	= $this->_description;
		$array['url']			= $this->_url;
		$array['embed']			= $this->_embed;
		$array['thumb']			= $this->_thumb;
		$array['duration']		= $this->_duration;
		$array['rating']		= $this->_rating;
		$array['views']			= $this->_views;
		
		return $array;
	}
	
	/* Returns information regarding the author */
	public function get_author()
	{
    	$authorFeed = simplexml_load_file( $this->_author_url );    
	    $authorData = $authorFeed->children('http://gdata.youtube.com/schemas/2007');

		$array				= array();
		$array['username']	= $this->_author;
		$array['age']		= $authorData->age;
		$array['gender']	= strtoupper($authorData->gender);
		$array['location']	= $authorData->location;
		$array['url']		= $this->_author_url;
		
		return $array;
	}
	
	/* Returns information regarding videocomments, max 20 returned */
	public function get_comments()
	{
		$array 			= array();
		$array['url']	= $this->_comments_url;
		$array['total']	= $this->_comments_count;
		
		if( $this->_comments_url && $this->_comments_count > 0 )
		{
			$commentsFeed = simplexml_load_file( $this->_comments_url );    
		
			$array['title']		= $commentsFeed->title;
			$array['comments']	= array();
			
			foreach( $commentsFeed->entry as $comment ) 
			{
				$array['comments'][] = $comment->content;
			}
		}
		
		return $array;
	}
	
	/* Returns video responses */
	public function get_responses()
	{
		$array 			= array();
		$array['url']	= $this->_responses_url;
		
		if( $this->_responses_url )
		{
			$responseFeed		= simplexml_load_file( $this->_responses_url );
			
			$array['title'] 	= $responseFeed->title;
			$array['responses']	= array();
		
			$i = 0;
		
			foreach( $responseFeed->entry as $response )
			{
				// Get the ID
				$explode				= explode( '/', $response->id );
				$array['responses'][]	= new YouTube( $explode[( count( $explode ) - 1 )] );
				
				++$i;
			}
			
			$array['total'] 	= $i;    
		}
		
		return $array;
	}
	
	/* Returns related videos */
	public function get_related()
	{
		$array 			= array();
		$array['url']	= $this->_related_url;
		
		if( $this->_related_url )
		{
			$relatedFeed 		= simplexml_load_file( $this->_related_url );
		  
			$array['title'] 	= $relatedFeed->title;
			$array['related']	= array();
			
			$i = 0;
		  
			foreach( $relatedFeed->entry as $related )
			{
				// Get the ID
				$explode				= explode( '/', $related->id );
				$array['related'][]	= new YouTube( $explode[( count( $explode ) - 1 )] );
				
				++$i;		
			}
			
			$array['total'] 	= $i;    
		}
		
		return $array;
	}
    
    public function __destruct()
    {
    
    }
}

?>