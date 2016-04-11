function hideMessages() {
	setTimeout(function() {$('.notice, .error, .success').slideUp(800);}, 2000);
}

function showMessages(data) {
	$('#messages').css({position:'fixed'}).html(data).find('div').hide();
	$('#messages div').slideDown(800);
	setTimeout(function() {hideMessages();}, 2000);
}

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		hideMessages();

		$('#show_elements').click(function() {
			$(this).parents('.elements.none').find('#list_elements').slideDown(300, function() {
				$('html, body').delay('300').animate({
					scrollTop: $(this).offset().top 
				}, 300);
			});
		});
	});
});

var HTML_AJAX_LOADING = '<div class="ajax loading" />';
var HTML_AJAX_LOADING_BIG = '<div class="ajax loading big" />';