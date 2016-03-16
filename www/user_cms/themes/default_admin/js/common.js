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

