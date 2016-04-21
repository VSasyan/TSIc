function hideMessages() {
	setTimeout(function() {$('.notice, .error, .success').slideUp(800);}, 2000);
}

function showMessages(data) {
	$('#messages').html(data).find('div').hide();
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

var miniMaps = false;
function init_show_element() {
	$('#show_elements').click(function(event) {
		event.preventDefault();
		$(this).parents('.elements.none').find('#table_list').slideToggle(300, function() {
			if (miniMaps != false) {$.each(miniMaps, function(i,m) {m.invalidateSize();})}
			$('html, body').delay('300').animate({
				scrollTop: $(this).offset().top 
			}, 300);
		});
	});
}

function init_click_vote() {
	$('.button.validate, .button.inhibate, .button.terminate, .button.archive').click(function(event) {
		event.preventDefault();
		var url = $(this).data('path');
		var $this = $(this);
		$.ajax({
			url : url,
			type : 'GET',
			success : function(data) {
				showMessages(data);
				$this.parent().find('.validate, .inhib').fadeOut();
				if ($this.hasClass('terminate')) {$this.parent().find('.terminate').fadeOut();}
				if ($this.hasClass('archive')) {$this.parent().find('.terminate, .archive').fadeOut();}
			}
		});
	});
}

function init_free_select() {
	function show_free_select() {
		var classe = $(this).data('free');
		if ($(this).val() == '') {$('input.' + classe).parent().slideDown();}
		else {$('input.' + classe).val('').parent().slideUp();}
	}

	$('select.freeSelect').val(1).change(show_free_select).each(show_free_select);
}

document.addEventListener("DOMContentLoaded", function() {
	$(document).ready(function() {
		hideMessages();
		init_show_element();
		init_select_lien();
		init_click_vote();
		show_mini_map();
		init_free_select();
	});
});

var HTML_AJAX_LOADING = '<div class="ajax loading" />';
var HTML_AJAX_LOADING_BIG = '<div class="ajax loading big" />';