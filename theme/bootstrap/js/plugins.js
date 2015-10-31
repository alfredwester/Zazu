$(document).ready(function() {
	$('#plugin-file-input').on("change", handleFiles, false);

	$('#plugin-dropzone').on("click", function(e) {
		$("#plugin-file-input").click();
		e.preventDefault();
	});

	var dropzone = $('#plugin-dropzone');
	dropzone.on("dragenter", function(e) {
		e.stopPropagation();
 		e.preventDefault();
 		dropzone.addClass("dragenter");
 		return false;
	});
	dropzone.on("dragover", function(e) {
		e.stopPropagation();
 		e.preventDefault();
 		return false;
	});
	dropzone.on("drop", function(e) {
		e.stopPropagation();
  		e.preventDefault();
  		var dt = e.originalEvent.dataTransfer;
  		var files = dt.files;
  		dropzone.removeClass("dragenter");
  		handleFiles(files);
	});
	dropzone.on("dragleave", function(e) {
		e.stopPropagation();
 		e.preventDefault();
 		dropzone.removeClass("dragenter");
	});
});

function handleFiles(files) {
	var zipType = /\/zip/;
	var error = "";
	var file;
	if(files.length > 0) {
		for(var i = 0; i<files.length; i++) {
			file = files.item(i);
			if (!zipType.test(file.type)) {
				error = error + file.name + " is not a zip file<br>";
			} else {
				sendFile(file);
			}
		}
	} else {
		error = "No files selected";
	}

	if(error.length > 0) {
		$("#main").prepend("<div class=\"row\">" +
			"<div class=\"span4 offset4 alert alert-error\">"+
			"<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times</a>"+
			"<h4>File upload error</h4>"+
			error+
			"</div>"+
			"</div>");
	}
}

function sendFile(file) {
	data = new FormData();
	data.append("file", file);
	data.append("upload_type", "plugin");
	$.ajax({
		data: data,
		type: "POST",
		url: "/admin/upload_file",
		cache: false,
		contentType: false,
		processData: false,
		success: function(url) {
			location.reload();
		},
		error: function(data) {
			$("#main").prepend("<div class=\"row\"><div class=\"span4 offset4 alert alert-error\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times</a><h4>File upload error</h4>"+data.responseText+"</div></div>");
			console.log(data.responseText);
		}
	});
}