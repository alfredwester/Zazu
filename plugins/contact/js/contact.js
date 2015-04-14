function showErrorMessage(id, message) {
	var p = $("<p class='contact-input-error-text'>"+message+"</p>");
	var id = "#"+id;
	var formGroup = $(id).parent().parent();
	formGroup.addClass("has-error");
	formGroup.append(p);
}