<?php

//models are used to get and return things from the database

class CmsModel {
	private $db_handler;
	
	function __construct() {
		$this->db_handler = Db_handler::GetInstance();
	}
	public function get_menu($group = 1) {
		$menu = array();
		$this->db_handler->db_escape_chars($group);
		$query = 'SELECT link_title, link_text, link_url, link_group from '.DB_PREFIX.'link WHERE link_group = '.$group.' ORDER BY link_order';
		$result = $this->db_handler->select_query($query);
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
		$query = 'SELECT link_title, link_text, link_url, link_group, link_order from '.DB_PREFIX.'link WHERE link_id = '.$link_id.';';
		$result = $this->db_handler->select_query($query);
		if($obj = $result->fetch_object()) {
			$link['link_title'] = $obj->link_title;
			$link['link_text'] = $obj->link_text;
			$link['link_url'] = $obj->link_url;
			$link['link_group'] = $obj->link_group;
			$link['link_order'] = $obj->link_order;
		}
		return $link;
	}
	public function get_menus() {
		$menu = array();
		$query = 'SELECT link_id, link_title, link_text, link_url, link_group, link_order from '.DB_PREFIX.'link';
		$result = $this->db_handler->select_query($query);
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
		$result = $this->db_handler->select_query('SELECT * FROM '.DB_PREFIX.'region');

		while($obj = $result->fetch_object()) {
			$regions['regions'][$obj->region_name]['region_text'] = $obj->region_text;
			$regions['regions'][$obj->region_name]['region_id'] = $obj->region_id;
		}
		return $regions;
	}
	public function get_post($post_id) {
		$post = array();
		$this->db_handler->db_escape_chars($post_id);
		$query = 'SELECT p.post_id, p.post_meta_content, p.post_meta_keyword,  p.post_title, p.post_date, p.post_content, p.post_url, u.user_id, u.user_realname, c.category_id, c.category_name, c.category_url
		FROM '.DB_PREFIX.'post AS p 
		INNER JOIN '.DB_PREFIX.'user AS u ON p.post_author = u.user_id
		INNER JOIN '.DB_PREFIX.'category AS c ON p.post_category = c.category_id
		WHERE p.post_id = '.$post_id.';';
		
		$result = $this->db_handler->select_query($query);
		if($obj = $result->fetch_object()) {
			$post['post_date'] = $obj->post_date;
			$post['post_title'] = $obj->post_title;
			$post['meta_content'] = $obj->post_meta_content;
			$post['post_meta_content'] = $obj->post_meta_content;
			$post['post_meta_keyword'] = $obj->post_meta_keyword;
			$post['post_content'] = $obj->post_content;
			$post['post_url'] = $obj->post_url;
			$post['post_author_id'] = $obj->user_id;
			$post['post_author_name'] = $obj->user_realname;
			$post['post_category'] = $obj->category_id;
			$post['post_category_name'] = $obj->category_name;
			$post['post_category_url'] = $obj->category_url;
		}
		return $post;
	}
	public function get_region($region_id) {
		$region = array();
		$region_id = $this->db_handler->db_escape_chars($region_id);
		$query = 'SELECT region_name, region_text FROM '.DB_PREFIX.'region WHERE region_id = \''.$region_id.'\';';
		$result = $this->db_handler->select_query($query);
		if($obj = $result->fetch_object()) {
			$region['region_name'] = $obj->region_name;
			$region['region_text'] = $obj->region_text;
		}
		return $region;
	}
	public function get_posts($nr_of_posts = 0, $category_id = 0) {
		$posts = array();
		$nr_of_posts = $this->db_handler->db_escape_chars($nr_of_posts);
		$limit = '';
		$category = '';
		if($nr_of_posts > 0) {
			$limit = ' LIMIT '.$nr_of_posts;
		}
		if($category_id > 0) {
			$category = ' WHERE c.category_id = '.$category_id;
		}
		$query = 'SELECT p.post_id, p.post_title, p.post_date, p.post_content, p.post_url, u.user_id, u.user_realname, c.category_id, c.category_name, c.category_url
		FROM '.DB_PREFIX.'post AS p 
		INNER JOIN '.DB_PREFIX.'user AS u ON p.post_author = u.user_id 
		INNER JOIN '.DB_PREFIX.'category AS c ON p.post_category = c.category_id '.$category.' '.$limit.';';
		$result = $this->db_handler->select_query($query);
		$count = 0;
		while($obj = $result->fetch_object()) {
			$posts['posts'][$count]['post_title'] = $obj->post_title;
			$posts['posts'][$count]['post_content'] = $obj->post_content;
			$posts['posts'][$count]['post_url'] = $obj->post_url;
			$posts['posts'][$count]['post_id'] = $obj->post_id;
			$posts['posts'][$count]['post_date'] = $obj->post_date;
			$posts['posts'][$count]['post_author_id'] = $obj->user_id;
			$posts['posts'][$count]['post_author_name'] = $obj->user_realname;
			$posts['posts'][$count]['post_category'] = $obj->category_id;
			$posts['posts'][$count]['post_category_name'] = $obj->category_name;
			$posts['posts'][$count]['post_category_url'] = $obj->category_url;
			$count++;
		}
		return $posts;
	}
	public function get_post_id($post_url) {
		$id = 0;
		$this->db_handler->db_escape_chars($post_url);
		$query = 'SELECT post_id FROM '.DB_PREFIX.'post WHERE post_url = \''.$post_url.'\';';
		$result = $this->db_handler->select_query($query);
		if($obj = $result->fetch_object()) {
			$id = $obj ->post_id;
		}
		return $id;
	}
	public function get_category_id($category_url) {
		$id = 0;
		$this->db_handler->db_escape_chars($category_url);
		$query = 'SELECT category_id FROM '.DB_PREFIX.'category WHERE category_url = \''.$category_url.'\';';
		$result = $this->db_handler->select_query($query);
		if($obj = $result->fetch_object()) {
			$id = $obj ->category_id;
		}
		return $id;
	}
	public function get_category($category_id) {
		$category = array();
		$category_id = $this->db_handler->db_escape_chars($category_id);
		$query = 'SELECT category_url, category_name FROM '.DB_PREFIX.'category WHERE category_id = \''.$category_id.'\';';
		$result = $this->db_handler->select_query($query);
		if($obj = $result->fetch_object()) {
			$category['category_url'] = $obj->category_url;
			$category['category_name'] = $obj->category_name;
		}
		return $category;
	}
	public function get_categories() {
		$categories = array();
		$result = $this->db_handler->select_query('SELECT category_id, category_name, category_url  FROM '.DB_PREFIX.'category');
		while($obj = $result->fetch_object()) {
			$categories['categories'][$obj->category_name]['category_url'] = $obj->category_url;
			$categories['categories'][$obj->category_name]['category_id'] = $obj->category_id;
		}
		return $categories;
	}
}
?>