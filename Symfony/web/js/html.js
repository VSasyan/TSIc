function html_popup_perturbation(name, type, path) {
	var html = '';
	html += '<div>';
		html += '<h3>' + name + '</h3>';
		html += '<p>Type de perturbation : ' + type + '</p>';
		html += '<p><a href="' + path + '">Plus d\'information</a></p>';
	html += '</div>';
	return html;
}

function html_popup_objet(name, srcIcon) {
	var html = '';
	html += '<div>';
		html += '<h3>' + name + '</h3>';
		html += '<p>Type d\'objet : <img src="' + srcIcon + '" class="icon"/></p>';
	html += '</div>';
	return html;
}