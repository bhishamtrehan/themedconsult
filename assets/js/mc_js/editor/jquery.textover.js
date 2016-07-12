(function ( $ ) {

	$.TextOver = function(obj, options) {

		// Set options
        var settings = $.extend({}, options),
        	messages = [];
        var fontSize = $('#textSize').val();
        var color = $('.text_col .m-r-xs').data('rel');
        var text_css = {
			border: '1px dotted',
			visibility: 'visible',
			margin: 0,
			padding: 0,
			position: 'absolute',
			top: 0,
			left: 0,
			background: 'none',
			color: color,
			'font-size': fontSize,
			padding: '0px',
			height: '24px',
			width: '20px',
			overflow: 'hidden',
			outline: 'none',
			'box-shadow': 'none',
  			'-moz-box-shadow': 'none',
  			'-webkit-box-shadow': 'none',
  			'resize': 'none'
	    };

        var $img = $(obj);

	    getPos = function(obj) {
	      var pos = $(obj).offset();
	      return [pos.left, pos.top];
	    };

        getData = function() {
          removeEmpty();
          data = [];
          imgPos = getPos($img);
          $.each(messages, function() {
            pos = getPos(this);
            textLeft = pos[0] - imgPos[0];
            textTop = pos[1] - imgPos[1];
            data.push({ 'text': this.val(), 'left': textLeft, 'top': textTop });
          });
          return data;

        }
	
				
	    mouseAbs = function(e) { 
			
	      //return [e.pageX, e.pageY];
			var parentOffset = $('#test').offset(); 
			//or $(this).offset(); if you really just want the current element's offset
			
			if ("ontouchstart" in window || navigator.msMaxTouchPoints)
				{
					isTouch = true;
					endCoords = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
					var relX = endCoords.pageX - parentOffset.left;
					var relY = endCoords.pageY - parentOffset.top;
					//console.log([relX, relY]);
					//console.log("Your end coords is: x: " + endCoords.pageX + ", y: " + endCoords.pageY);
					return ([relX, relY]);
				} else {
					isTouch = false;
					var relX = e.originalEvent.pageX - parentOffset.left;
					var relY = e.originalEvent.pageY - parentOffset.top;
					return([relX, relY]);
				}
		
			
			
		
	    };
	
	/*	var getPointerEvent = function(event) {
		return event.originalEvent.targetTouches ? event.originalEvent.targetTouches[0] : event;
		};
		var $touchArea = $('canvas#test'),
		touchStarted = false, // detect if a touch event is sarted
		currX = 0,
		currY = 0,
		cachedX = 0,
		cachedY = 0;


		$touchArea.on('touchstart mousedown',function (e){
		e.preventDefault(); 
		var pointer = getPointerEvent(e);
		// caching the current x
		cachedX = currX = pointer.pageX;
		// caching the current y
		cachedY = currY = pointer.pageY;
		// a touch event is detected      
		touchStarted = true;
		// detecting if after 200ms the finger is still in the same position
		setTimeout(function (){
		if ((cachedX === currX) && !touchStarted && (cachedY === currY)) {

		}
		},200);
		});
					
		$touchArea.on('touchend mouseup touchcancel',function (e){
			e.preventDefault();
			var pointer = getPointerEvent(e);
			currX = pointer.pageX - $(this).offset().left;
			currY = pointer.pageY - $(this).offset().top;
			if(touchStarted) {
				 // here you are swiping
				 console.log(currX + ' Y ' + currY)
			}
		
	
   
});*/
		
	    resizeTextArea = function(e) {
	    	var span = $('#helper');
	    	if(span.length < 1) {
	    		span = $('<span id="helper"></span>');
	    	}
	    	innerHTML = String($(this).val()).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br />') + '...';
            if(e.keyCode == 13) { innerHTML += '<br />...'; }
	    	span.html(innerHTML).css({
	    		'display': 'none',
	    		'word-wrap': 'break-word',
				'white-space': 'normal',
				'font-family': $(this).css('font-family'),
				'font-size': $(this).css('font-size'),
				'line-height': $(this).css('line-height'),
				'min-height': '24px'
	    	});

	    	$('body').append(span);
	    	$(this).css({'height': span.height()+6, 'width': span.width()+10});
	    }
	
        newTextArea = function(e) {
        	
			if($('#text_to_img').hasClass('active'))
			{
				removeEmpty();
				var wrap = $('<div class="textWrap"></div>');
				var textArea = $('<textarea cols="4" rows="4"></textarea><a class="delText" onclick="removeCanvasText($(this).parent())"  style="position:absolute; margin-left:10px;">X</a>');

				wrap.append(textArea);


				textArea.css(text_css);
				position = mouseAbs(e);
				
			//	alert(position[0]);
				//alert(position[1]);
				textArea.css({'left': position[0], 'top': position[1]});
				//textArea.css({'left': currX, 'top': currY});
			
				var canvas = document.getElementById("test");
				var context = canvas.getContext('2d');
				$('#can_wrap').append(wrap);   	
				$(textArea).bind('keydown', resizeTextArea);
				$(textArea).on('paste', function(e) {
					/*TODO Fix resize issue */
					$(this).trigger('keydown');
				})
				$(textArea).focus(function() {
					$(this).css('border', '1px dotted #000');

				}).blur(function() {
					$(this).css('border', 'none');
				});
				textArea.focus();

				$('#can_wrap').hover(function() {
					$('.delText').css('display', 'block');

				})

				messages.push($(textArea));
			
        }
        else
        {
        	return false;
        }
			
			
        };

        removeTextArea = function(index) {
        	$(messages[index]).remove();
        	messages.splice(index, 1);

        };

        removeEmpty = function() {
			
        	$.each(messages, function(i) {
        		if($(this).val() == '') {
        			removeTextArea(i);
        		}
        	});
			
			
  
  
        };
		
		

        handleEsc = function(e) {
        	//console.log(e.keyCode);
        	if(e.keyCode == 27) {
        		removeTextArea(messages.length-1);
        	}
        };

		//$(obj).one( "click", newTextArea);
		
        //$(obj).unbind("click").click(newTextArea);
        $(obj).on('click touchstart',newTextArea);
		 /* setInterval(function(){ 
			removeEmpty();
			
			$( ".textWrap" ).each(function( index ) {
				if(($(this).html() == '')){
					//$(this).remove();
				}
			});
		 }, 3000); */
		
        
        $(document).keydown(handleEsc);
       
		
	};
 
    $.fn.TextOver = function(options, callback) {
 

        api = $.TextOver(this, options);
        if ($.isFunction(callback)) callback.call(api);
 
        // Return "this" so the object is chainable (jQuery-style)
    	return this;
 
    };
	
	
 
}(jQuery));

