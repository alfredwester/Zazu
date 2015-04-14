$(document).ready(function() {
	$('.contact-row').click(function() {
		location.href = "/admin/call_plugin_func/contact/edit/" + this.getAttribute("data-id");
	});
	$('.contact-btn-delete').click(function() {
		if(confirm('Do you really want to delete this contact?')) {
			location.href = "/admin/call_plugin_func/contact/delete/" + this.getAttribute("data-id");
		}
	});
	$('.contact-btn-cancel').click(function() {
		location.href = "/admin/call_plugin_func/contact/cancel/";
	});
});