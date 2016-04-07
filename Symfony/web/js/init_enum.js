document.addEventListener("DOMContentLoaded", function() {
	$('.elements .element .delete').click(function() {
		var $parent = $(this).parent();
		console.log($(this).data('url'));
		$.ajax({
			url : $(this).data('url'),
			type : 'GET',
			success : function (data) {
				$parent.slideUp();
				showMessages(data);
			}
		})
	});
});