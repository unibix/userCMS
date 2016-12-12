$.fn.redraw = function(){
	$(this).each(function(){
		var redraw = this.offsetHeight;
	});
};


$(window).ready(function() {$(".cube-slider").each(cubeSliderInit)});
$(window).resize(function() {$(".cube-slider").each(cubeSliderResize)});



////////////////////////////////////////////////////////////////////////////////
//
//	Stop all sliders if tab is hidden and start when our tab become visible
//
////////////////////////////////////////////////////////////////////////////////
$(window).ready(function() {
	var hidden, visibilityChange; 
	if (typeof document.hidden !== "undefined") {
		hidden = "hidden";
		visibilityChange = "visibilitychange";
	} else if (typeof document.mozHidden !== "undefined") {
		hidden = "mozHidden";
		visibilityChange = "mozvisibilitychange";
	} else if (typeof document.msHidden !== "undefined") {
		hidden = "msHidden";
		visibilityChange = "msvisibilitychange";
	} else if (typeof document.webkitHidden !== "undefined") {
		hidden = "webkitHidden";
		visibilityChange = "webkitvisibilitychange";
	}
	 
	function handleVisibilityChange() {
		if (document[hidden]) {
			$(".cube-slider").each(function() {this.animationEnabled = false});
		} else {
			$(".cube-slider").each(function() {this.animationEnabled = true});
		}
	}

	if (typeof document.addEventListener !== "undefined" && typeof document[hidden] !== "undefined") {
		document.addEventListener(visibilityChange, handleVisibilityChange, false);
	}
})



////////////////////////////////////////////////////////////////////////////////
//
//	Initialize Cube Slider
//
////////////////////////////////////////////////////////////////////////////////
function cubeSliderInit(slider) {
	if (!slider || slider.className != 'cube-slider') slider = this;

	//to create cube need at least 4 slides. This code clone slides if need.	
	while ($(slider).find('.slide').length < 4) {
		$(slider).find('.slide').clone().appendTo($(slider).find('.slides'));
	}

	//set right sizes for all elements
	cubeSliderResize(slider);

	var freq = parseInt(slider.getAttribute('data-frequency'));		//slide change period, ms
	setInterval(cubeSliderMoveLeft.bind(slider), freq);

	//attach event handlers on controls
	$(slider).find('.left-arrow').click(cubeSliderMoveLeft.bind(slider));
	$(slider).find('.right-arrow').click(cubeSliderMoveRight.bind(slider));

	slider.style.opacity = '1';
}




////////////////////////////////////////////////////////////////////////////////
//
//	Adjust size and position of elements of Cube Slider
//
////////////////////////////////////////////////////////////////////////////////
function cubeSliderResize(slider) {
	if (!slider || slider.className != 'cube-slider') slider = this;

	//disable transitions to prevent animation
	slider.animationEnabled = false;
	$(slider).find('.slide').css('transition', '');
	$(slider).find('.shadow').css('transition', '');

	//get parameters
	var w = $(slider).find('.perspective-wrap').innerWidth();		//slide width, px (defined by CSS style)
	var w2 = Math.round(w/2);										//we will often use half-width
	var ar = parseFloat(slider.getAttribute('data-aspect-ratio'));	//slide aspect ratio
	var speed = parseInt(slider.getAttribute('data-speed'));		//slide change animation speed, ms
	var h = Math.round(w/ar);                                       //slider height
    if (h < 350) h = 350;

	//adjust "viewport" height
	var perspectiveStyles = {
		'height': h+'px',
		'perspective': w+'px'
	}
	$(slider).find('.perspective-wrap').css(perspectiveStyles);

    $(slider).find('.right-wrap').css('line-height', h+'px');
    $(slider).find('.left-wrap').css('line-height', h+'px');

	//set slider's dimensions
	var slideStyles = {
		'width': w+'px',
		'height': h+'px'
	}
	$(slider).find('.slide').css(slideStyles);

	//set slider's position
	var leftSlide	= 'translateZ(-'+w2+'px) rotateY(-90deg) translateZ('+w2+'px)';
	var rightSlide = 'translateZ(-'+w2+'px) rotateY(90deg) translateZ('+w2+'px)';
	var frontSlide = 'translateZ(-'+w2+'px) rotateY(0deg) translateZ('+w2+'px)';
	var backSlide	= 'translateZ(-'+w2+'px) rotateY(180deg) translateZ('+w2+'px) scale(0.01)';
	var cnt = $(slider).find('.slide').length;

	$(slider).find('.slide').each(function(index) {
		switch (index) {
			case 0:
			this.style.transform = frontSlide;
			break;

			case 1:
			this.style.transform = rightSlide;
			break;

			case (cnt-1):
			this.style.transform = leftSlide;
			break;

			default:
			this.style.transform = backSlide;
		}
	});

	//set shadow position & dimensions (dim + 2*pos = w)
	var dim = Math.round(0.8*w);
	var pos = Math.round(0.1*w);
	var shadowStyles = {
		'width': dim+'px',
		'height': dim+'px',
		'bottom': pos+'px',
		'left': pos+'px',
		'box-shadow': '0 0 '+(1.5*pos)+'px '+pos+'px rgba(0,0,0,0.5)'
	}
	$(slider).find('.shadow').css(shadowStyles);
	slider.shadowAngle = 0;
	slider.shadowInitTransform = $(slider).find('.shadow').get(0).style.transform
		 = 'translateZ(-'+w2+'px) rotateX(90deg) translateZ(-'+(w2+pos)+'px)';

	//redraw slides and shadow before we start
	$(slider).find('.slide').redraw();
	$(slider).find('.shadow').redraw();
	
	//setting transitions
	var transition = 'transform '+(0.001*speed)+'s ease';
	$(slider).find('.slide').css('transition', transition);
	$(slider).find('.shadow').css('transition', transition);
	slider.animationEnabled = true;
}


////////////////////////////////////////////////////////////////////////////////
//
//	Enable Cube Slider animation (it's disabled when animation already started)
//
////////////////////////////////////////////////////////////////////////////////
function cubeSliderEnableAnimation(slider) {
	if (!slider || slider.className != 'cube-slider') slider = this;
	slider.animationEnabled = true;
}


////////////////////////////////////////////////////////////////////////////////
//
//	Rotate Cube Slider left
//
////////////////////////////////////////////////////////////////////////////////
function cubeSliderMoveLeft(slider) {
	if (!slider || slider.className != 'cube-slider') slider = this;
	if (slider.animationEnabled) {
		slider.animationEnabled = false;
		var speed = parseInt(slider.getAttribute('data-speed'));
		setTimeout(cubeSliderEnableAnimation.bind(slider), speed);

		var slides = $(slider).find('.slide');
		var last = slides[slides.length-1].style.transform;

		for (var i=slides.length-1; i>=0; i--) {
			if (i == 0) {
				slides[i].style.transform = last;
			} else {
				slides[i].style.transform = slides[i-1].style.transform;
			}
		}

		var shadow = $(slider).find('.shadow').get(0);
        if (shadow) {
    		if (slider.shadowAngle == 360) {
    			slider.shadowAngle = 0;
    			var t = shadow.style.transition;
    			shadow.style.transition = '';
    			shadow.style.transform = slider.shadowInitTransform + ' rotateZ('+slider.shadowAngle+'deg)';
    			$(shadow).redraw();
    			shadow.style.transition = t;
    		}
    		slider.shadowAngle += 90;
    		shadow.style.transform = slider.shadowInitTransform + ' rotateZ('+slider.shadowAngle+'deg)';
        }
	}
}




////////////////////////////////////////////////////////////////////////////////
//
//	Rotate Cube Slider right
//
////////////////////////////////////////////////////////////////////////////////
function cubeSliderMoveRight(slider) {
	if (!slider || slider.className != 'cube-slider') slider = this;
	if (slider.animationEnabled) {
		slider.animationEnabled = false;
		var speed = parseInt(slider.getAttribute('data-speed'));
		setTimeout(cubeSliderEnableAnimation.bind(slider), speed);

		var slides = $(slider).find('.slide');
		var first = slides[0].style.transform;

		for (var i=0; i<slides.length; i++) {
			if (i == slides.length-1) {
				slides[i].style.transform = first;
			} else {
				slides[i].style.transform = slides[i+1].style.transform;
			}
		}

		var shadow = $(slider).find('.shadow').get(0);
        if (shadow) {
    		if (slider.shadowAngle == 0) {
    			slider.shadowAngle = 360;
    			var t = shadow.style.transition;
    			shadow.style.transition = '';
    			shadow.style.transform = slider.shadowInitTransform + ' rotateZ('+slider.shadowAngle+'deg)';
    			$(shadow).redraw();
    			shadow.style.transition = t;
    		}
    		slider.shadowAngle -= 90;
    		shadow.style.transform = slider.shadowInitTransform + ' rotateZ('+slider.shadowAngle+'deg)';
        }
	}
}