$(document).ready(function() {
	$('.fancybox').fancybox({
		openEffect : 'elastic',
		openSpeed  : 400,

		closeEffect : 'elastic',
		closeSpeed  : 200,
		nextClick : true,
		helpers: {
			thumbs : {
				width  : 50,
				height : 50
			},
			title : {
				type : 'over'
			}
		},

		//afterLoad : function() {
		//	this.title = 'Изображение ' + (this.index + 1) + ' из ' + this.group.length + (this.title ? ' - ' + this.title : '');
		//}
	});

});