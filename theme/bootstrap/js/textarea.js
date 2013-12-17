$(document).ready(function() {
	$('textarea').wysihtml5("deepExtend", {
		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
		"emphasis": true, //Italics, bold, etc. Default true
		"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
		"html": true, //Button which allows you to edit the generated HTML. Default false
		"link": true, //Button to insert a link. Default true
		"color": true, //Button to change color of font  
		"image": true, //Button to insert an image. Default true,
		"stylesheets": ["/include/bootstrap/css/bootstrap.min.css"],
		parserRules: {
			tags: {
				del: {}
			},
			classes: {
                // (path_to_project/lib/css/wysiwyg-color.css)
                "muted" : 1,
                "text-warning" : 1,
                "text-error" : 1,
                "text-info" : 1,
                "text-success" : 1,
                "wysiwyg-color-silver" : 0,
                "wysiwyg-color-gray" : 0,
                "wysiwyg-color-white" : 0,
                "wysiwyg-color-maroon" : 0,
                "wysiwyg-color-red" : 0,
                "wysiwyg-color-purple" : 0,
                "wysiwyg-color-fuchsia" : 0,
                "wysiwyg-color-green" : 0,
                "wysiwyg-color-lime" : 0,
                "wysiwyg-color-olive" : 0,
                "wysiwyg-color-yellow" : 0,
                "wysiwyg-color-navy" : 0,
                "wysiwyg-color-blue" : 0,
                "wysiwyg-color-teal" : 0,
                "wysiwyg-color-aqua" : 0,
                "wysiwyg-color-orange" : 0
            }
		}
	});
});
