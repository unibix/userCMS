$(document).ready(function() {
	$('.tabs ul li a').click(function(){
		if(!$(this).hasClass('active')){
			$('.tabs ul li a').removeClass('active');
			$('#tabs_content > div').fadeOut(100, function(){$('#'+container).fadeIn(100);});
			var container = $(this).attr('class');

			$(this).addClass('active');
		}
	});
});