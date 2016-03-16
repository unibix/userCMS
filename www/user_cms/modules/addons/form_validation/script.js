$( function() {
	$('form').submit(function() {
		$(this).validate({
			submitHandler: function(this) {
				this.submit();
			}
		});
		
		return false;
	});
});