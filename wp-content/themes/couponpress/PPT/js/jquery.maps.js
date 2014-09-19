var MeOnTheMap = function(options){
    
    this.options = {
        address    : "",
        container  : "",
        defaultUI  : true,
        noDragging : false,
        html       : "",
		longlatmap : false,
        zoomLevel  : 16,
        view       : 0
    };
    
 
	// 0. PREPARE DATA
     this.preparePreloading = function(){
        var regxp = new RegExp('(src)=("[^"]*")','g');
        var sources = this.options.html.match(regxp);

        if (!sources)
            return;

        function getHandler(obj) {
            return function(){
                var el = document.getElementById(obj.id);
                if (el){
                    el.parentNode.replaceChild(this, el);
                    obj.marker.tooltip.redraw(true);
                }
            };
        };
    
        for (var i = 0; i < sources.length; i++){
            this.options.html = this.options.html.replace(sources[i],"style=\"visibility:visible\" id=\"preloadimg" + i + "\" src=\"\"");

            var src = sources[0].split("=\"")[1];
            src = src.substring(0,src.length - 1);

            var img = new Image();

            this.preloads.push({
                element: img,
                src: src,
                id: "preloadimg" + i
            });

            img.onload = getHandler(this.preloads[this.preloads.length - 1]);
        }
    };
	
	
	// 1. LOAD THE INTITAL LOADING ITEMS	
   this.initialize = function(options) { 

        for (var opt in options){
            this.options[opt] = options[opt];
        }
		
		this.preparePreloading();

        this.container = document.getElementById(this.options.container);
        if (!this.container) {
            alert("Could not locate \"" + this.options.container + "\"");
            return;
        }
		
		// start geolocation
		geocoder = new google.maps.Geocoder();		
		
		// start baic map options
	  	var myOptions = {
		  zoom: this.options.zoomLevel,
		  center: new google.maps.LatLng(-33, 151),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		} 


		if(this.options.longlatmap){
		this.LoadLongLat(options, myOptions); 	
		} else {
		this.LoadAddress(options, myOptions);
		}

 		      
    };
	
	


	// 1. LOAD THE MAP OBJECT FOR ADDRESS VALUE
	this.LoadAddress = function(options, myOptions){
			
		var map = new google.maps.Map(this.container, myOptions); 
		var html = this.options.html; 
	  
		//"latLng": latlng
		geocoder.geocode( { "address": this.options.address }, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {			 
			  
			map.setCenter(results[0].geometry.location);		
			
			var image      = "../wp-content/themes/couponpress/PPT/js/map/icon.png";
        	 
			var marker = new google.maps.Marker({				
				icon: image,
				map: map,			
				position: results[0].geometry.location			 
			});
			
			
		/*var boxText = document.createElement("div");	
			
		if(html.length > 20){
			var maph = -80;
			var mapw = -180	
			boxText.style.cssText = "margin-top: 8px; background: #000000; padding: 5px; -moz-border-radius: 3px; border-radius: 3px; font-size:12px; font-weight:bold; color:#fff; padding-bottom:10px;";
		} else{
			var maph = -80;
			var mapw = -70	
			boxText.style.cssText = "margin-top: 8px; background: #000000; padding: 5px; -moz-border-radius: 3px; border-radius: 3px; font-size:12px; font-weight:bold; color:#fff;";
		}
		
		
		boxText.innerHTML = "<div class='map_container'>"+html+"</div>";

		var myOptions = {
			 content: boxText
			,disableAutoPan: false
			,maxWidth: 0
			,pixelOffset: new google.maps.Size(maph, mapw)
			,zIndex: null
			,boxStyle: { 			 
			  opacity: 0.8
			  ,width: "160px"
			 }
			,closeBoxMargin: ""
			,closeBoxURL: ""
			,infoBoxClearance: new google.maps.Size(1, 1)
			,isHidden: false
			,pane: "floatPane"
			,enableEventPropagation: false
		};*/

		google.maps.event.addListener(marker, "click", function (e) {
			ib.open(map, this);
		});

		var ib = new InfoBox(myOptions);
		ib.open(map, marker);
			
 
			
		
		  } else {
			alert("Geocode was not successful for the following reason: " + status);
		  }
		});
		
	}	

	
	// 2. LOAD THE MAP OBJECT FOR LONG AND LAT OPTIONS
	this.LoadLongLat = function(options, myOptions){
		
		var input = this.options.address;
		var latlngStr = input.split(",",2);
    	var lat = parseFloat(latlngStr[0]);
    	var lng = parseFloat(latlngStr[1]);
			
		geocoder = new google.maps.Geocoder();
    	var latlng = new google.maps.LatLng(lat,lng);
		
		var myOptions = {
		  zoom: 15,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(this.container, myOptions);
	
		var html = this.options.html;
		
		
		var image      = "../wp-content/themes/couponpress/PPT/js/map/icon.png";
        	 
		var marker = new google.maps.Marker({
				 
				icon: image,
				map: map,			
				position: latlng			 
		});			
			
		/*var boxText = document.createElement("div");	
			
		if(html.length > 20){
			var maph = -80;
			var mapw = -180	
			boxText.style.cssText = "margin-top: 8px; background: #000000; padding: 5px; -moz-border-radius: 3px; border-radius: 3px; font-size:12px; font-weight:bold; color:#fff; padding-bottom:10px;";
		} else{
			var maph = -80;
			var mapw = -70	
			boxText.style.cssText = "margin-top: 8px; background: #000000; padding: 5px; -moz-border-radius: 3px; border-radius: 3px; font-size:12px; font-weight:bold; color:#fff;";
		}
		
		
		boxText.innerHTML = "<div class='map_container'>"+html+"</div>";

		var myOptions = {
			 content: boxText
			,disableAutoPan: false
			,maxWidth: 0
			,pixelOffset: new google.maps.Size(maph, mapw)
			,zIndex: null
			,boxStyle: { 			 
			  opacity: 0.8
			  ,width: "160px"
			 }
			,closeBoxMargin: ""
			,closeBoxURL: ""
			,infoBoxClearance: new google.maps.Size(1, 1)
			,isHidden: false
			,pane: "floatPane"
			,enableEventPropagation: false
		};

		google.maps.event.addListener(marker, "click", function (e) {
			ib.open(map, this);
		});

		var ib = new InfoBox(myOptions);
		ib.open(map, marker);

		*/
    	  
		
	}	
	
   
    
    this.initialize(options);
};