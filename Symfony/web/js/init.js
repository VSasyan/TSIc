function hideMessages() {
	setTimeout(function() {$('.notice, .error, .success').slideUp(800);}, 2000);
}

function showMessages(data) {
	$('#messages').css({position:'fixed'}).html(data).find('div').hide();
	$('#messages div').slideDown(800);
	setTimeout(function() {hideMessages();}, 2000);
}

function init_select_lien() {
	$('select.lien').change(function() {
		//var parameter = $(this).val();
     //window.location = "http://yoursite.com/page?variable=" + parameter;
		window.location = $(this).val();
		
	});
}

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		hideMessages();

		init_select_lien();
	});
});

var HTML_AJAX_LOADING = '<div class="ajax loading" />';
var HTML_AJAX_LOADING_BIG = '<div class="ajax loading big" />';