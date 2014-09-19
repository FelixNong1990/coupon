
	
(function($) {

	$.stackGallery = function (settings) {


	var isIEbelow9 = false;
	if($.browser.msie && parseInt($.browser.version, 10) < 9){
		isIEbelow9=true;
	}
	//console.log(isIEbelow9);
	
	var introHappened=false;

	var slideshowOn=settings.slideshowOn;
	var slideshowTimeout = settings.slideshowDelay;
	var slideshowTimeoutID; 

	var windowResizeInterval = 500;
	
	var sliderHolder = jQuery('#sliderHolder');
	var sliderImages = jQuery('#sliderImages');
	
	var tempArr =sliderImages.children('ul'); 
	var dataArr = [];

	tempArr.each(function(){
		dataArr.push($(this));
	});
	dataArr.reverse();
	//console.log(dataArr)
	
	var slideArr = [];//holds finished slides
	var imgArr = [];
	
	var imageW = settings.imageWidth;
	var imageH = settings.imageHeight;
	
	var playlistLength = dataArr.length;
	 
	
	
	var transitionOn=false;
	var endTransitionCheckID;
	
	
	//settings
	var upPartDuration = settings.upPartDuration;
    var downPartDuration = settings.downPartDuration;
	var maxRandomUpAngle = settings.maxRandomUpAngle;
	var minRandomUpAngle = settings.minRandomUpAngle;
	var maxRandomDownAngle = settings.maxRandomDownAngle;
	var minRandomDownAngle = settings.minRandomDownAngle;
	var useControls=settings.useControls;
	
	var slideshowLayout=settings.slideshowLayout;
	if(slideshowLayout != 'horizontalLeft' && slideshowLayout != 'horizontalRight' && slideshowLayout != 'verticalAbove' && slideshowLayout != 'verticalRound') slideshowLayout = verticalRound;
	
	var slideshowDirection = settings.slideshowDirection;
	if(slideshowDirection != "forward" && slideshowDirection != "backward") slideshowDirection = "forward";
	
	var captionOpenDelay=settings.captionOpenDelay;
	var captionToggleSpeed=settings.captionToggleSpeed;
	
	var verticalValue=parseInt(imageH, 10) + parseInt(100);//how far to animate slide up
	var horizontalValue=parseInt(imageW, 10) + parseInt(50);
	//console.log(verticalValue);
	
	
	var toggleBtnHeight = jQuery('#playimg').height();
	//console.log(toggleBtnHeight);
	

	var slideControls = jQuery('#slideControls');
	var slide_prev = jQuery('#slide_prev');
	var slide_toggle = jQuery('#slide_toggle');
	var slide_next = jQuery('#slide_next');
				
	slide_prev.bind('click', toggleControls);
	slide_toggle.bind('click', toggleControls);
	slide_next.bind('click', toggleControls);
	slideControls.css('opacity', 0);
	 
	var pause_icon = jQuery('#pause_icon');//wrappers
	var play_icon = jQuery('#play_icon');
	
	var pause_icon2 = jQuery('#pause_icon2');//inners (height change)
	var play_icon2 = jQuery('#play_icon2');
	
	play_icon.css('display', 'none');
	pause_icon.css('display', 'none');
	
	if(!slideshowOn){
		play_icon.css('display', 'block');
	}else{
		pause_icon.css('display', 'block');
	}
	
	

	var sliderHit=false;
	sliderHolder.mouseenter(function(e){       
		//console.log("enter");
		sliderHit=true;
		if(!transitionOn && slideshowOn) pauseSlideshow();
	}).mouseleave(function(){
		//console.log("leave");
		sliderHit=false;
		if(!transitionOn && slideshowOn) resumeSlideshow();
	});
	
	
	
				  
	
	
	loadImages();
	
	function loadImages(){
		
		//get image count 
		var i = 0;
		var slide;
		var img;
		var imageUrl;
		var imageLoadCounter=0;
		var imageCount=0;
		var imgUrlArr=[];
		
		
		for(i; i < playlistLength; i++){
			slide = $(dataArr[i]);
		 
			if(slide.find('li[title=image]').length > 0){
				imageCount++;
				img = slide.find('li[title=image]').find('img');
				imageUrl = img.attr('src') +"?rand=" + (Math.random() * 99999999);
				//console.log(imageUrl);
				
				img =$(new Image());
				img.attr('id', i);
				img.css('position', 'relative');
				img.css('display', 'block');
				img.css('width', imageW);
				img.css('height', imageH);
				
				imgArr.push(img);
					
				img.load(function() {
					
					//console.log($(this).attr('id'));
					
					imageLoadCounter++;
					//console.log(imageLoadCounter,imageCount );
					if(imageLoadCounter == imageCount) {
						//ALL IMAGES LOADED
						
						//hide loader
						var componentLoader = jQuery('#componentLoader');
						if(componentLoader){
							componentLoader.stop().animate({'opacity': 0},  {duration: 500, easing: "easeOutSine", complete: function(){
								componentLoader.remove();
								componentLoader = null;	
							}});
						}
						
						setup();
					}
					
				}).attr('src', imageUrl);
					
				img.error(function(e) {
					console.log('image load error: ' + e);
				});
				
			}else{
				//console.log(i);
				imgArr.push('');
			}
		}
	}
		
	function setup(){	
		//console.log('setup');
	
		var div;
		var i = 0;
		var img;
		var slide;
		
		var captionDiv;
		var captionHolderDiv;
		var captionBgColor; 
		var captionTextColor;
		var xy;
		var x;
		var y;
		var j;
		var len;
		var title;
		var infoWidth;
		var infoHeight;
		var leftInfoPadding;
		var rightInfoPadding;
		var topInfoPadding;
		var bottomInfoPadding; 
		var finalInfoWidth;
		var finalInfoHeight;
		var captionArr;
		var fontMeasure = jQuery('#fontMeasure');
		
		var caption;
		
		
		var customContentArr=[];
		var z;
		var zlen;
		
		//custom content
		var customContent;
		
		for(i; i <playlistLength; i++){
			
			slide = $(dataArr[i]);
			
			div = $("<div></div>");
			div.css('display', 'none');
			div.attr('id', i);
			div.attr('title', i);
			div.attr('class', 'imageHolder');
			div.css('zIndex', i);
			
			div.css('top', Math.random() * 35 );
			div.css('left', Math.random() * 25 );
			
			var r  = randomMinMax(maxRandomDownAngle, minRandomDownAngle);
			 
			sliderHolder.append(div);
			 
			if(i != playlistLength-1) div.css({rotate: r+'deg' });//dont rotate first
			
			if (imgArr[i].length > 0) {
				img = $(imgArr[i]);
				//console.log(img, i);
				img.appendTo(div);
			}
			
			//custom content
			if(slide.find('div[title=customContent]').length > 0){
				
				customContentArr = slide.children('div[title=customContent]');
				
				z=0;
				zlen = customContentArr.length;
				for(z; z < zlen; z++){
					customContent = customContentArr[z];
					div.append(customContent);
				}
			}
			
			
			
			//captions
			j=0;
			len = slide.find('li[title=caption]').size();
			captionArr = [];
			
			for(j; j < len;j++){
			
				caption=slide.find('li[title=caption]').eq(j);
					
				captionBgColor = caption.css('backgroundColor'); 
				captionTextColor = caption.css('color');
				xy = caption.attr('class');
				x = xy.substring(0, xy.indexOf(','));
				y = xy.substring(xy.indexOf(',') + 1);
				
				title = caption.html();
				//console.log(title);
				
				//check caption for links
				if(title.indexOf("href") != -1){
					// console.log(title);
					//div.link = $(title).attr('href');
					
					div.bind('click', navigateToUrl);
					div.css('cursor', 'pointer');
					
					div.link =  $(title).attr('href');
					div.linkTarget=$(title).attr('target');
					
					//console.log($(title).attr('href'), $(title).attr('target'));
				}
				
				captionDiv = $("<div />").html(title).addClass("caption").appendTo(fontMeasure);
				
				infoWidth = $(captionDiv).width() + 1;
				infoHeight = $(captionDiv).height() + 1;
				
				leftInfoPadding =parseInt($(captionDiv).css('paddingLeft'), 10);
				rightInfoPadding =parseInt($(captionDiv).css('paddingRight'), 10);
				topInfoPadding =parseInt($(captionDiv).css('paddingTop'), 10);
				bottomInfoPadding =parseInt($(captionDiv).css('paddingBottom'), 10); 
				
				
				
				finalInfoWidth =  infoWidth + leftInfoPadding + rightInfoPadding;
				finalInfoHeight = infoHeight + topInfoPadding + bottomInfoPadding;
				
				//console.log(finalInfoWidth, finalInfoHeight);
				
				captionDiv.css('width', finalInfoWidth);
				captionDiv.css('height', finalInfoHeight );
				captionDiv.css('color', captionTextColor );		
				
				captionHolderDiv = $("<div />").addClass("infoHolder");
				captionDiv.appendTo(captionHolderDiv);
				
				
				captionHolderDiv.finalInfoWidth = finalInfoWidth;
				
				captionHolderDiv.css('width', 0);
				captionHolderDiv.css('height', finalInfoHeight );
				
				captionHolderDiv.css('left', parseInt(x, 10));
				captionHolderDiv.css('top', parseInt(y, 10));
				captionHolderDiv.css('background', captionBgColor);
				
				captionHolderDiv.appendTo(div);
				
				
				captionArr.push(captionHolderDiv);
			
			}
			
			if(len > 0){
				div.captions=captionArr;
				//console.log(i, len);
			}
			
			slideArr.push(div);
			
			div.css('opacity', 0);//FIX FOR IE7/8, ADD AFTER BECAUSE OF DROP SHADOW
			div.css('display', 'block');
			div.animate({'opacity': 1},  {duration: 1000, easing: "easeOutSine"});
		
		}
	
		correctCustomContent();
						  
		 if(useControls){	
			  slideControls.css('display', 'block');
			  slideControls.animate({'opacity': 1},  {duration: 500, easing: "easeOutSine"});
			  advanceButtonMode('on');
		 }
		  
		 checkCaptions(playlistLength-1);
				
	
	}
	
	
	
	function correctCustomContent() {
		//ADD YOUR OWN CUSTOM CODE HERE
	 
		
		
	}
	
	
	
	function getSlideById(id){
		var i = 0;
		var div;
		var index;
		for(i; i< playlistLength; i++){
			div = slideArr[i];
			//console.log($(div).attr('id'), id);
			index = $(div).attr('id');
			if(index == id) break;
		}
		return div;
	}
	
	function unbindAll(){
		var i = 0;
		var div;
		for(i; i< playlistLength; i++){
			div = $(slideArr[i]);
			//div.unbind('click', toggleSlide);
			//div.css('cursor', 'default');
		}
	}
	/*
	function toggleSlide(e){
		
		if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();
		
		if(transitionOn) return;
		transitionOn=true;
		advanceButtonMode('off');
		
		var currentTarget = e.currentTarget;
		var id = $(currentTarget).attr('id');
		
		goForward(id);
		resetTimer2();
		
		return false;
		
	}*/
	
	function goForward(id){
		
		if(!id){
			var id = playlistLength - 1;
		}
		
		var slide=getSlideById(id);

		unbindAll();
		
		removeCaptions(id);
		
		//console.log('goForward ', id, slide);
	
		 var r    = randomMinMax(maxRandomUpAngle, minRandomUpAngle) + 'deg';
		  var r2    = randomMinMax(maxRandomDownAngle, minRandomDownAngle) + 'deg';
		 
		 
		 if(slideshowLayout == 'verticalAbove' || slideshowLayout == 'verticalRound'){
		 
			slide.animate({rotate: r+'deg', top: -(verticalValue)+'px'}, {
						duration: upPartDuration, 
						easing: "easeOutCubic",
						complete: function(){
							goUpPart2(slide, r2, cr, slideToOpen, original);
						}
					});	
		
		 }else{
			 
			 $(slide).animate({rotate: r, left: slideshowLayout == 'horizontalLeft' ? - horizontalValue : horizontalValue }, {
				duration: upPartDuration, 
				easing: "easeOutCubic",
				complete: function(){
					goSidePart2(slide, r2);
				}
			});
			 
		}
	
	}
	
	function goUpPart2(slide, r2){
		
		//change indexes
		slideArr.unshift(slideArr.pop());//push last to front 
		changeIndexes(slide);
		
		$(slide).animate({rotate: r2, top: 0}, {
			duration: downPartDuration, 
			easing: "easeOutExpo"
		});
		
		var nextInStack = slideArr[playlistLength - 1];
		
		  $(nextInStack).animate({ 
			 rotate:0 + 'deg',
			 duration:downPartDuration,
			 easing: "easeOutExpo"
		  });
		  
		  if(endTransitionCheckID) clearTimeout(endTransitionCheckID);
		  endTransitionCheckID = setTimeout(checkEndTransition, downPartDuration);
		
	}
	
	function goSidePart2(slide, r2){
		
		//change indexes
		slideArr.unshift(slideArr.pop());//push last to front 
		changeIndexes(slide);
		
		$(slide).animate({rotate: r2, left: 0}, {
			duration: downPartDuration, 
			easing: "easeOutExpo"
		});
		
		var nextInStack = slideArr[playlistLength - 1];
		
		  $(nextInStack).animate({ 
			 rotate:0 + 'deg',
			 duration:downPartDuration,
			 easing: "easeOutExpo"
		  });
		  
		  if(endTransitionCheckID) clearTimeout(endTransitionCheckID);
		  endTransitionCheckID = setTimeout(checkEndTransition, downPartDuration);
		
	}
	
	function goBack(){
		
		var id = 0;
		var slide=getSlideById(id);

		unbindAll();
	
		removeCaptions($(slideArr[playlistLength - 1]).attr('id'));
	
		 var r    = randomMinMax(maxRandomUpAngle, minRandomUpAngle) + 'deg';
		 var r2    = randomMinMax(maxRandomDownAngle, minRandomDownAngle) + 'deg';
		 
		  if(slideshowLayout == 'verticalAbove' || slideshowLayout == 'verticalRound'){
		 
				$(slide).animate({rotate: r, top: slideshowLayout == 'verticalRound' ? verticalValue : -verticalValue}, {
					duration: upPartDuration, 
					easing: "easeOutCubic",
					complete: function(){
						goBackUpPart2(slide, r2);
					}
				});
		
		 }else{
			 
			 	$(slide).animate({rotate: r, left: slideshowLayout == 'horizontalLeft' ? - horizontalValue : horizontalValue}, {
					duration: upPartDuration, 
					easing: "easeOutCubic",
					complete: function(){
						goBackSidePart2(slide, r2);
					}
				});
			 
		 }
		 
	}
	
	function goBackUpPart2(slide, r2){
		//console.log("top finished..........");
						
		//change indexes
		slideArr.push(slideArr.shift());//push front to last 
		changeIndexes2(slide);
		
		/*
		on each go back rotate forward to non zero. (otherwise if we go back all the time all would be zero rotated in stack)
		*/
		//check forward for non zero
		var previousFront = slideArr[playlistLength - 2];
		$(previousFront).animate({ 
			 rotate:r2,
			 duration:downPartDuration,
			 easing: "easeOutExpo"
		  });
		
		
		$(slide).animate({rotate: 0, top: 0}, {
			duration: downPartDuration, 
			easing: "easeOutExpo",
			complete: function(){
				 
				 checkCaptions($(slide).attr('id'));
				 
				//console.log("...........back finished");
				// console.log("\n");
			}
			
		});
	}
	
	function goBackSidePart2(slide, r2){
		//console.log("top finished..........");
		
		//change indexes
		slideArr.push(slideArr.shift());//push front to last 
		changeIndexes2(slide);
		
		/*
		on each go back rotate forward to non zero. (otherwise if we go back all the time all would be zero rotated in stack)
		*/
		//check forward for non zero
		var previousFront = slideArr[playlistLength - 2];
		$(previousFront).animate({ 
			 rotate:r2,
			 duration:downPartDuration,
			 easing: "easeOutExpo"
		  });
		
		
		$(slide).animate({rotate: 0, left: 0}, {
			duration: downPartDuration, 
			easing: "easeOutExpo",
			complete: function(){
				 
				 checkCaptions($(slide).attr('id'));
				 
				//console.log("...........back finished");
				// console.log("\n");
			}
			
		});
	}
	
	function checkEndTransition(){
		//console.log("checkEndTransition ");
		//console.log("\n");
		if(endTransitionCheckID) clearTimeout(endTransitionCheckID);
		checkCaptions($(slideArr[playlistLength - 1]).attr('id'));
	}
	
	
	
	function removeCaptions(id){
		//console.log('removeCaptions');
			
		if(slideArr[id].captions == undefined) return;	
			
		var i = 0;
		var captionArr = slideArr[id].captions;
		var len =captionArr.length;
		var caption;
		
		for(i; i < len;i++){
			
			caption=$(captionArr[i]);
				
			caption.stop().animate({width: 0}, {
				duration: captionToggleSpeed, 
				easing: "easeOutQuint"
			});
			
		}
		
	}
	
	function checkCaptions(id){
		//console.log('checkCaptions');
		
		if(slideArr[id].captions != undefined){
			
			var i = 0;
			var captionArr = slideArr[id].captions;
			var len =captionArr.length;
			//console.log(len);
			var caption;
			var finalInfoWidth;
			
			for(i; i < len;i++){
				
				caption=$(captionArr[i]);
				finalInfoWidth = captionArr[i].finalInfoWidth;
				
				if(i != len-1){
					
					//console.log(caption.finalInfoWidth);
					
					caption.delay(captionOpenDelay * i).animate({width: finalInfoWidth}, {
						duration: captionToggleSpeed, 
						easing: "easeOutQuint"
					});
				
				}else if(i == len -1){
					
					caption.delay(captionOpenDelay * i).animate({width: finalInfoWidth}, {
					duration: captionToggleSpeed, 
					easing: "easeOutQuint",
					complete: function(){
						
						if(slideArr[id].hasLink == true){//add click to ones with no link
							//$(slideArr[id]).bind('click', navigateToUrl);
							//$(slideArr[id]).css('cursor', 'pointer');
						}
						
						 advanceButtonMode('on');
						 transitionOn=false;
						
						checkSlideshow(); 
					}});
					
				}//if else
				
			}//for
			
		}else{
			
			//slide clickabale only if has no link
			//$(slideArr[id]).bind('click', toggleSlide);
			//$(slideArr[id]).css('cursor', 'pointer');
			
			advanceButtonMode('on');
			transitionOn=false;
			
			checkSlideshow();
		}
		
	}
	
	function navigateToUrl(e){
		
		if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();
		
		var currentTarget = e.currentTarget;
		var id = $(currentTarget).attr('id');
		//console.log('id = ' , id);
		
		var link = slideArr[id].link;
		//console.log('link = ' , link);
		if(!link) return;
		
		var target=slideArr[id].linkTarget;
		//console.log(target);
		if(!target) target="_blank";
		
		if(target=='_parent'){
			window.location=link;
		}else if(target=='_blank'){
			var newWindow=window.open(link, target);
			if (window.focus) {newWindow.focus();}
		}else{
			alert("Only _blank and _parent are allowed as target atributes for opening new url. You have set it to: " + target);
		}
		
		return false;
	}
	
	
	function checkSlideshow(){
		//console.log('checkSlideshow ', sliderHit);
		if(slideshowOn && !sliderHit){
			 pause_icon2.stop().animate( {height: 0}, {duration: slideshowTimeout, easing: 'linear', complete: nextSlide } );
			 play_icon2.stop().animate( {height: 0}, {duration: slideshowTimeout, easing: 'linear' } );
		}
	}
	
	function pauseSlideshow(){
		pause_icon2.stop();
		play_icon2.stop();
	}
	
	function resumeSlideshow(){
		//calculate new time
		var h=pause_icon2.height();
		var newTime=h/toggleBtnHeight * slideshowTimeout;
		if(newTime < 0) newTime=0;
		//console.log(newTime);
		
		pause_icon2.stop().animate( {height: 0}, {duration: newTime, easing: 'linear', complete: nextSlide } );
		play_icon2.stop().animate( {height: 0}, {duration: newTime, easing: 'linear' } );
	}
	
	function nextSlide(){
		//console.log("nextSlide");
		
		transitionOn=true;
		advanceButtonMode('off');
		
		if(slideshowDirection == "forward"){
			goForward();
		}else{
			goBack();
		}
		
		resetTimer();
	}
	
	function resetTimer(){
		pause_icon2.animate( {height: toggleBtnHeight}, {duration: 500, easing: 'easeOutExpo' } );
		play_icon2.animate( {height: toggleBtnHeight}, {duration: 500, easing: 'easeOutExpo' } );
	}
	
	function resetTimer2(){
		pause_icon2.stop();
		play_icon2.stop();
		pause_icon2.animate( {height: toggleBtnHeight}, {duration: 500, easing: 'easeOutExpo' } );
		play_icon2.animate( {height: toggleBtnHeight}, {duration: 500, easing: 'easeOutExpo' } );
	}
	
	function advanceButtonMode(mode){
		if(mode=='on'){
			slide_prev.css('cursor', 'pointer');
			slide_next.css('cursor', 'pointer');
		}else{
			slide_prev.css('cursor', 'default');
			slide_next.css('cursor', 'default');
		}
	}
	
	function toggleControls(e){
		
		if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();
		
		// if(slideshowTimeoutID) clearTimeout(slideshowTimeoutID);
		
		var currentTarget = e.currentTarget;
		var id = $(currentTarget).attr('id');
		//console.log("toggleControls = ", id);
		
		if(id == "slide_prev"){
			
			if(transitionOn) return;
			transitionOn=true;
			advanceButtonMode('off');
			
			goBack();
			resetTimer2();
			
		}else if(id == "slide_toggle"){
			if(slideshowOn){
				slideshowOn = false;
				
				pause_icon2.stop();
				play_icon2.stop();
				play_icon.css('display', 'block');
				pause_icon.css('display', 'none');
				
			}else{
				slideshowOn=true;
				
				play_icon.css('display', 'none');
				pause_icon.css('display', 'block');
				

				if(!transitionOn){
					
					//calculate new time
					var h=pause_icon2.height();
					var newTime=h/toggleBtnHeight * slideshowTimeout;
					if(newTime < 0) newTime=0;
					//console.log(newTime);
					
					pause_icon2.stop().animate( {height: 0}, {duration: newTime, easing: 'linear', complete: nextSlide } );
					play_icon2.stop().animate( {height: 0}, {duration: newTime, easing: 'linear' } );
					
					
				}
				
				//if(!transitionOn) checkSlideshow();
			}
		}else if(id == "slide_next"){
			
			if(transitionOn) return;
			transitionOn=true;
			advanceButtonMode('off');
			
			goForward();
			resetTimer2();
		}
		
		return false;
		
	}
	
	
	function changeIndexes(objectToBack) {
		
		$(objectToBack).css('zIndex', 0);
		$(objectToBack).attr('id', 0);
		
		var i = 1;//start from second
		var div;
		
		for(i; i< playlistLength;i++){
			div=$(slideArr[i]);
			div.attr('id', i);
			div.css('zIndex', i);
		}
		
	}
	
	function changeIndexes2(objectToFront) {
		
		$(objectToFront).css('zIndex', playlistLength-1);
		$(objectToFront).attr('id', playlistLength-1);
		
		var i = 0;
		var div;
		
		for(i; i< playlistLength - 1;i++){
			div=$(slideArr[i]);
			div.attr('id', i);
			div.css('zIndex', i);
		}
		
	}
	
	//returns a random value between min and max
	function randomMinMax(min, max){
		return Math.random() * (max - min) + min;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		//********** helper functions
		
		function getDocumentWidth(){
			return Math.max(
				//$(document).width(),
				$(window).width(),
				/* For opera: */
				document.documentElement.clientWidth
			);
		};	
		
		function getDocumentHeight(){
			return Math.max(
				$(window).height(),
				/* For opera: */
				document.documentElement.clientHeight
			);
		};
	
	
	
		//browser resize
		$(window).resize(function() {
			 
			 clearTimeout(this.id);
			 this.id = setTimeout(doneResizing, windowResizeInterval);
		});
		
		function doneResizing(){
			
		};
	
	
	

	
	}
	
})(jQuery);