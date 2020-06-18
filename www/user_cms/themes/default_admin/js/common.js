// возвращает cookie если есть или undefined
function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
	  "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	))
	return matches ? decodeURIComponent(matches[1]) : undefined 
}

// уcтанавливает cookie
function setCookie(name, value, props) {
	props = props || {}
	var exp = props.expires
	if (typeof exp == "number" && exp) {
		var d = new Date()
		d.setTime(d.getTime() + exp*1000)
		exp = props.expires = d
	}
	if(exp && exp.toUTCString) { props.expires = exp.toUTCString() }

	value = encodeURIComponent(value)
	var updatedCookie = name + "=" + value
	for(var propName in props){
		updatedCookie += "; " + propName
		var propValue = props[propName]
		if(propValue !== true){ updatedCookie += "=" + propValue }
	}

	document.cookie = updatedCookie

}

// удаляет cookie
function deleteCookie(name) {
	setCookie(name, null, { expires: -1 })
}

function startLoading() {
	$('body').append('<div class="loading"></div>');
}

function endLoading() {
	$('body .loading').remove();
}

function checkAll(selector) {
	$(selector + ' input:checkbox:enabled').attr('checked', true);
	return false;
}
function uncheckAll(selector) {
	$(selector + ' input:checkbox:enabled').attr('checked', false);
	return false;
}

function confirmDelete() {
	if (confirm("Вы уверены?")) {
		return true;
	} else {
		return false;
	}
}

let confirmButton = $(".confirmButton");

if(confirmButton != null) {
confirmButton.on('click', function(){
	return confirmDelete();
});
}


$(document).ready(function () {     
let additional_menu_btn = $('.additional-menu-btn');    
let left_menu = $('.component-block #left_side');   

if($(document).width() <= 745 && (left_menu.length > 0)) {
	if(additional_menu_btn != null) {
		additional_menu_btn.css({
			display: 'block'
		});
	} 
} else if(left_menu.length > 0) {
	if(additional_menu_btn != null) {
		additional_menu_btn.css({
			display: 'none'
		});
	} 		
}

if($(window).width() <= 974) {
	$('#close_menu.collapse').removeClass('show');
} else {
	$('#close_menu.collapse').addClass('show');
}

$(window).resize(function() {
	if($(window).width() <= 745) {
		if(additional_menu_btn != null && left_menu.length > 0) {
			additional_menu_btn.css({
				display: 'block'
			});
		} 			
	} else {
		if(additional_menu_btn != null && left_menu.length > 0) {
			additional_menu_btn.css({
				display: 'none'
			});
		} 					
	}

	if($(window).width() <= 974) {
		$('#close_menu.collapse').removeClass('show');
	} else {
		$('#close_menu.collapse').addClass('show');
	}

});

let was_click_menu = false

$('.additional-menu-btn').on('click', function() {
	let left_menu = $('.component-block #left_side');
	

	if(left_menu != null) {
		if(was_click_menu) {
			$('.additional-menu-btn').animate({
				left: -40 + 'px'
			}, 150);

			left_menu.animate({
				left: -185 + 'px'
			}, 150);

			was_click_menu = false;
		} else {
			$('.additional-menu-btn').animate({
				left: 129 + 'px'
			}, 150);

			left_menu.animate({
				left: 0
			}, 150);

			was_click_menu = true;
		}
	}
});

});  
