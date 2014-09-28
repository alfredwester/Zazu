$(document).ready(function() {
	$('textarea').summernote({ height:400

	});
	$('.accordion-body').on('hide', function () {
	 	$('.accordion-body').find( "input" ).prop( "disabled", "disabled" );
	});
	$('.accordion-body').on('show', function () {
	 	$('.accordion-body').find( "input" ).removeProp( "disabled" );
	});
});
