$(document).ready(function() {
	$('textarea').summernote({
		height: 400, 
		onImageUpload: function(files, editor, welEditable) {
			sendFile(files[0], editor, welEditable);
		}
	});
	function sendFile(file, editor, welEditable) {
		data = new FormData();
		data.append("file", file);
		$.ajax({
			data: data,
			type: "POST",
			url: "/admin/upload_file",
			cache: false,
			contentType: false,
			processData: false,
			success: function(url) {
				editor.insertImage(welEditable, url);
			},
			error: function(data) {
				$("#main").prepend("<div class=\"row\"><div class=\"span4 offset4 alert alert-error\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times</a><h4>File upload error</h4>"+data.responseText+"</div></div>");
				console.log(data.responseText);
			}
		});
	}
});
