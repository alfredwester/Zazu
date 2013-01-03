<?php
class Helper {
	public function redirect($status, $url = null, $message = null) {
		switch($status) {
			case 404:
				header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
				echo "404 Not Found";
				exit;
			case 301:
				header($_SERVER['SERVER_PROTOCOL'].' 301 Moved Permanently');
				header('location: '.$url);
				exit;
			case 500:
				header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');
				echo "500 Internal Server Error <br>";
				echo $message;
				exit;
			case 0:
				header('location: '.BASE_PATH.$url);
				exit;
			break;
		}
	}
	
	protected function check_empty($key_array, $data) {
		$data_empty = array();
		foreach($key_array as $val) {
			if(!isset($data[$val]) || !is_numeric($data[$val]) && (empty($data[$val]) || $data[$val] == "")) {
				$data_empty[] = str_replace('_', ' ', ucfirst($val)).' was empty';
			}
		}
		return $data_empty;
	}
	
	public function get_standard_tinymce_head() {
		$base = BASE_PATH;
		$tinymce = <<<EOD
		<script type="text/javascript" src="{$base}/include/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
		<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		// content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
EOD;
		return $tinymce;
	}
	public function get_colorbox_head() {
		$base = BASE_PATH;
		$colorbox = <<<EOD
		<link rel="stylesheet" href="{$base}/include/colorbox/example1/colorbox.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="{$base}/include/colorbox/colorbox/jquery.colorbox.js"></script>
EOD;
		return $colorbox;
	}
	
	public function get_bootstrap_wysihtml5_head() {
		$base = BASE_PATH."include/bootstrap-wysihtml5";
		$wysihtml5 = <<<EOD
		<link rel="stylesheet" href="/{$base}/bootstrap-wysihtml5.css" />
EOD;
		return $wysihtml5;
	}
	
	public function get_bootstrap_wysihtml5_footer() {
		$base = BASE_PATH."include/bootstrap-wysihtml5";
		$wysihtml5 = <<<EOD
		<script src="/{$base}/libs/js/wysihtml5-0.3.0.js" type="text/javascript"></script>
		<script src="/{$base}/bootstrap-wysihtml5.js" type="text/javascript"></script>
EOD;
		return $wysihtml5;
	}
}
