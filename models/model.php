<?php
//models are used to get and return things from the database

class Model {
	private $db_handler = null;
	private $header = null;
	
	function __construct() {
		$this->db_handler = Db_handler::GetInstance();
			
	}

	public function content($url = null) {
		$content = array();
		$this->db_handler->mysqli->real_escape_string($url);
		$result = $this->db_handler->select_query('SELECT content, headline, footer from '.DB_PREFIX.'post WHERE url = \''.$url.'\'');
		$obj =  $result->fetch_object();
		       
		$content['content'] = $obj->content;
		$content['headline'] = $obj->headline;
		$content['footer'] = $obj->footer;

		return $content;
	
	}

	public function header_content($url = null) {
		$header = array();
		$this->db_handler->mysqli->real_escape_string($url);
		$result = $this->db_handler->select_query('SELECT title, metaContent, metaKeyword from '.DB_PREFIX.'post WHERE url = \''.$url.'\'');
		$obj =  $result->fetch_object();

		$header['title'] = $obj->title;
		$header['meta_content'] = $obj->metaContent;
		return $header;				
	}
}
