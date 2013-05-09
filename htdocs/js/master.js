function center_box(){
	var dimArray = getPageSize();
	var scrollArray = getPageScroll();
	var box_height = $('#lightbox').height();
	var box_width = $('#lightbox').width();
	var screen_height = dimArray[3];
	var screen_width = dimArray[2];

	var top = (screen_height / 2) - (box_height / 2) + scrollArray[1];
	var left = (screen_width / 2) - (box_width / 2);

	$('#lightbox').css('top', top);
	$('#lightbox').css('left', left);
}

//
// getPageSize()
// Returns array with page width, height and window width, height
// Core code from - quirksmode.org
// Edit for Firefox by pHaez
//
function getPageSize(){
	
	var xScroll, yScroll;
	
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}


	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) ;
	return arrayPageSize;
}

//
// getPageScroll()
// Returns array with x,y page scroll values.
// Core code from - quirksmode.org
//
function getPageScroll(){

	var yScroll;

	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		yScroll = document.documentElement.scrollTop;
	} else if (document.body) {// all other Explorers
		yScroll = document.body.scrollTop;
	}

	arrayPageScroll = new Array('',yScroll) ;
	return arrayPageScroll;
}

function closeLightbox(){
	$('#lightbox-bg').animate({"opacity": "0"}, 500, 'swing', function(){
		$(this).css('display', 'none');
	});
	$('#lightbox').animate({"opacity": "0", "height": "0", "width": "0"}, 500, 'swing', function(){
		$(this).css('display', 'none');
	});
	
	$.cookie('entrance_cookie', true, {path: '/'});
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
		
$(window).resize(function(){
	center_box();
});

$(window).scroll(function(){
	center_box();
});



/** Lightbox **/
$(document).ready(function(){
	$('#contactable').contactable({
		subject: 'Feedback Message'
	});
	
	if(typeof $.cookie('entrance_cookie') == 'undefined'){
		$('#lightbox-bg').animate({"opacity": ".70"}, 500);
		$('#lightbox').animate({"opacity": "1.0"}, 500);
		$('#lightbox-bg, #lightbox').css('display', 'block');
		$('#lightbox-bg').click(closeLightbox);
		$('#lightbox-close').click(closeLightbox);
		center_box();
	}

	$('#stay-updated').click(function(){
		var email = $('#signup-email').val();
		
		if(!validateEmail(email)){
			$('#submit_response').css('color', 'red').html('Please enter a valid email address');
			return;
		}
		
		$.post('signup.php', {'email': email}, function(data){
			data = JSON.parse(data);
			
			if(data.success == true){
				$('#submit_response').css('color', 'green').html(data.msg);
			}else{
				$('#submit_response').css('color', 'red').html(data.msg);
			}
		});
	});
});
	
