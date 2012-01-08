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
	public function get_regions() {
		$regions = array();
		$result = $this->db_handler->select_query('SELECT * FROM '.DB_PREFIX.'regions');
		while($obj = $result->fetch_object()) {
			$regions[REGION_PREFIX.$obj->region_name] = $obj->region_text;
		}
		return $regions;
	}
	public function get_post($post_id) {
		$post = array();
		$query = 'SELECT title, date, meta_content, meta_keyword, content, url FROM '.DB_PREFIX.'post WHERE idPost = '.$post_id.';';
		$result = $this->db_handler->select_query($query);
		$obj = $result->fetch_object();
		$post['post_title'] = $obj->title;
		$post['meta_content'] = $obj->meta_content;
		$post['meta_keyword'] = $obj->meta_keyword;
		$post['post_content'] = $obj->content;
		$post['post_url'] = $obj->url;
		
		return $post;
	}
	public function get_latest_posts($nr_of_posts = 10) {
		$posts = array();
		$query = 'SELECT title, date, content, url FROM '.DB_PREFIX.'post LIMIT '.$nr_of_posts.';';
		$result = $this->db_handler->select_query($query);
		$count = 0;
		while($obj = $result->fetch_object()) {
			$posts['posts'][$count]['post_title'] = $obj->title;
			$posts['posts'][$count]['post_content'] = $obj->content;
			$posts['posts'][$count]['post_url'] = $obj->url;
			$count++;
		}
		return $posts;
	}
	public function get_posts() {
		$posts = array();
        $query = 'SELECT title, date, content, url FROM '.DB_PREFIX.'post;';
        $result = $this->db_handler->select_query($query);
        $count = 0;
        while($obj = $result->fetch_object()) {
            $posts['posts'][$count]['post_title'] = $obj->title;
            $posts['posts'][$count]['post_content'] = $obj->content;
            $posts['posts'][$count]['post_url'] = $obj->url;
            $count++;
        }
        return $posts;	
	}
	public function get_post_id($post_url) {
		$id = 0;
		$this->db_handler->mysqli->real_escape_string($post_url);
		$query = 'SELECT idPost FROM '.DB_PREFIX.'post WHERE url = \''.$post_url.'\';';
		$result = $this->db_handler->select_query($query);
		if($obj = $result->fetch_object()) {
			$id = $obj ->idPost;
		}
		return $id;
	}

}
?>
