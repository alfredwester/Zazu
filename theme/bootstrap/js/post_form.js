$(document).ready(function() {
	$('[name="post_title"]').keyup(function() {
		var post_url = convert_to_url_string($(this).val());
		$('[name="post_url"]').val(post_url);
	});
});

function convert_to_url_string(string) {
	var result = string.toLowerCase().trim();
	result = result.replace(/ä/g, "a").replace(/å/g, "a").replace(/ö/g, "o");
	return result.replace(/[^\w- ]+/g,'').replace(/ +/g,'-').replace(/---/g, '-');
}
