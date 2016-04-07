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
	});
});

var HTML_AJAX_LOADING = '<div class="ajax loading" />';