function html_popup_perturbation(name, type, path) {
	var html = '';
	html += '<div>';
		html += '<h3>' + name + '</h3>';
		html += '<p>Type de perturbation : ' + type + '</p>';
		html += '<p><a href="' + path + '">Plus d\'information</a></p>';
	html += '</div>';
	return html;
}

function html_popup_perturbation_mobile(name, type) {
	var html = '';
	html += '<div>';
		html += '<h3>' + name + '</h3>';
		html += '<p>Type de perturbation : ' + type + '</p>';
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

function html_list_perturbation(o) {
	var src = Routing.generate("logo_type_perturbation", {id : o.id});
	var html = '';
	html += '<div class="row" data-type="initSection" data-initSection="showPerturbation" data-id="' + o.id + '">';
		html += '<div class="cell mini"><img src="' + src + '" class="icon"/></div>';
		html += '<div class="cell"><span>' + o.name + '</span></div>';
	html += '</div>';
	return html;
}