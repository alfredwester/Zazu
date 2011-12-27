<?php

//models are used to get and return things from the database

class CmsModel {
    private $db_handler = null;
    function __construct() {
        $this->db_handler = Db_handler::GetInstance();
    }
	
    public function get_content($url = null) {
        $content = array();
        $this->db_handler->mysqli->real_escape_string($url);
        $result = $this->db_handler->select_query('SELECT content, headline, footer from '.DB_PREFIX.'post WHERE url = \''.$url.'\'');
        $obj =  $result->fetch_object();

        $content['content'] = $obj->content;
        $content['headline'] = $obj->headline;
        $content['footer'] = $obj->footer;

        return $content;

    }

    public function get_header($url = null) {
        $header = array();
        $this->db_handler->mysqli->real_escape_string($url);
        $result = $this->db_handler->select_query('SELECT title, metaContent, metaKeyword from '.DB_PREFIX.'post WHERE url = \''.$url.'\'');
        $obj =  $result->fetch_object();

        $header['title'] = $obj->title;
        $header['meta_content'] = $obj->metaContent;
        return $header;
    }
	public function get_menu($group = 1) {
		$menu = array();
		$query = 'SELECT title, text, url, menu_group AS \'group\' from '.DB_PREFIX.'navigation WHERE menu_group = '.$group.' ORDER BY menu_order';
		$result = $this->db_handler->select_query($query);
		$count = 0;
		while($obj = $result->fetch_object()) {
			$menu['menu_'.$obj->group][$count]['title'] = $obj->title;
			$menu['menu_'.$obj->group][$count]['text'] = $obj->text;
			$menu['menu_'.$obj->group][$count]['url'] = $obj->url;
			$count++;
		}
		return $menu;	
	}
}
?>
