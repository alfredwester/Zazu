<?php

//models are used to get and return things from the database

class CmsModel {
	private $db_handler;
	
	function __construct() {
		$this->db_handler = Db_handler::GetInstance();
	}
	/*
	public function get_content($url = null) {
		$content = array();
		$this->db_handler->db_escape_chars($url);
		$result = $this->db_handler->query('SELECT content, headline, footer from '.DB_PREFIX.'post WHERE url = \''.$url.'\'');
		$obj =  $result->fetch_object();

		$content['content'] = $obj->content;
		$content['headline'] = $obj->headline;
		$content['footer'] = $obj->footer;

		return $content;
	}*/
	public function get_menu($group = 1) {
		$menu = array();
		$this->db_handler->db_escape_chars($group);
		$query = 'SELECT link_title, link_text, link_url, link_group from '.DB_PREFIX.'navigation WHERE link_group = '.$group.' ORDER BY link_order';
		$result = $this->db_handler->query($query);
		$count = 0;
		while($obj = $result->fetch_object()) {
			$menu['menu_'.$obj->link_group][$count]['link_title'] = $obj->link_title;
			$menu['menu_'.$obj->link_group][$count]['link_text'] = $obj->link_text;
			$menu['menu_'.$obj->link_group][$count]['link_url'] = $obj->link_url;
			$count++;
		}
		return $menu;
	}
	public function get_link($link_id) {
		$link = array();
		$this->db_handler->db_escape_chars($link_id);
		$query = 'SELECT link_title, link_text, link_url, link_group, link_order from '.DB_PREFIX.'navigation WHERE link_id = '.$link_id.';';
		$result = $this->db_handler->query($query);
		$obj = $result->fetch_object();
		$link['link_title'] = $obj->link_title;
		$link['link_text'] = $obj->link_text;
		$link['link_url'] = $obj->link_url;
		$link['link_group'] = $obj->link_group;
		$link['link_order'] = $obj->link_order;
		return $link;
	}
	public function get_menus() {
		$menu = array();
		$query = 'SELECT link_id, link_title, link_text, link_url, link_group, link_order from '.DB_PREFIX.'navigation';
		$result = $this->db_handler->query($query);
		$count = 0;
		while($obj = $result->fetch_object()) {
			$menu['links'][$count]['link_title'] = $obj->link_title;
			$menu['links'][$count]['link_text'] = $obj->link_text;
			$menu['links'][$count]['link_url'] = $obj->link_url;
			$menu['links'][$count]['link_id'] = $obj->link_id;
			$menu['links'][$count]['link_group'] = $obj->link_group;
			$menu['links'][$count]['link_order'] = $obj->link_order;
			$count++;
		}
		return $menu;
	}
	public function get_regions() {
		$regions = array();
		$result = $this->db_handler->query('SELECT * FROM '.DB_PREFIX.'region');

		while($obj = $result->fetch_object()) {
			$regions['regions'][$obj->region_name]['region_text'] = $obj->region_text;
			$regions['regions'][$obj->region_name]['region_id'] = $obj->region_id;
		}
		return $regions;
	}
	public function get_post($post_id) {
		$post = array();
		$this->db_handler->db_escape_chars($post_id);
		$query = 'SELECT post_title, post_date, post_meta_content, post_meta_keyword, post_content, post_url FROM '.DB_PREFIX.'post WHERE post_id = '.$post_id.';';
		$result = $this->db_handler->query($query);
		$obj = $result->fetch_object();
		$post['post_title'] = $obj->post_title;
		$post['meta_content'] = $obj->post_meta_content;
		$post['post_meta_content'] = $obj->post_meta_content;
		$post['meta_keyword'] = $obj->post_meta_keyword;
		$post['post_meta_keyword'] = $obj->post_meta_keyword;
		$post['post_content'] = $obj->post_content;
		$post['post_url'] = $obj->post_url;
		return $post;
	}
	public function get_region($region_id) {
		$region = array();
		$this->db_handler->db_escape_chars($region_id);
		$query = 'SELECT region_name, region_text FROM '.DB_PREFIX.'region WHERE region_id = \''.$region_id.'\';';
		$result = $this->db_handler->query($query);
		$obj = $result->fetch_object();
		$region['region_name'] = $obj->region_name;
		$region['region_text'] = $obj->region_text;
		return $region;
	}
	public function get_latest_posts($nr_of_posts = 10) {
		$posts = array();
		$this->db_handler->db_escape_chars($nr_of_posts);
		$query = 'SELECT post_title, post_date, post_content, post_url FROM '.DB_PREFIX.'post LIMIT '.$nr_of_posts.';';
		$result = $this->db_handler->query($query);
		$count = 0;
		while($obj = $result->fetch_object()) {
			$posts['posts'][$count]['post_title'] = $obj->post_title;
			$posts['posts'][$count]['post_content'] = $obj->post_content;
			$posts['posts'][$count]['post_url'] = $obj->post_url;
			$count++;
		}
		return $posts;
	}
	public function get_posts() {
		$posts = array();
		$query = 'SELECT post_id, post_title, post_date, post_content, post_url FROM '.DB_PREFIX.'post;';
		$result = $this->db_handler->query($query);
		$count = 0;
		while($obj = $result->fetch_object()) {
			$posts['posts'][$count]['post_title'] = $obj->post_title;
			$posts['posts'][$count]['post_content'] = $obj->post_content;
			$posts['posts'][$count]['post_url'] = $obj->post_url;
			$posts['posts'][$count]['post_id'] = $obj->post_id;
			$count++;
		}
		return $posts;
	}
	public function get_post_id($post_url) {
		$id = 0;
		$this->db_handler->mysqli->real_escape_string($post_url);
		$query = 'SELECT post_id FROM '.DB_PREFIX.'post WHERE post_url = \''.$post_url.'\';';
		$result = $this->db_handler->query($query);
		if($obj = $result->fetch_object()) {
			$id = $obj ->post_id;
		}
		return $id;
	}
}
?>