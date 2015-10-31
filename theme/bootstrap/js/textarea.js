$(document).ready(function() {
	var rows = $('textarea').attr("rows");
	$('textarea').summernote({
		height: rows*20,
		 toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
			['fontname', ['fontname']],
			['fontsize', ['fontsize']],
			['height', ['height']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['insert', ['picture', 'link', 'video', 'hr', 'table']],
			['misc', ['undo','redo','fullscreen', 'codeview', 'help']],
		  ],
		onImageUpload: function(files, editor, welEditable) {
			sendFile(files[0], editor, welEditable);
		}
	});
	function sendFile(file, editor, welEditable) {
		data = new FormData();
		data.append("file", file);
		data.append("upload_type", "editorimage");
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
