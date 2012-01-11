<?php
class Adminmodel {
	private $db_handler;
	private $post_array;
	private $region_array;
	private $link_array;

	public function __construct() {
		$this->db_handler = Db_handler::GetInstance();
		$this->post_array = array(
									'post_title',
									'post_url',
									'post_content',
									'post_meta_content',
									'post_meta_keyword'
									);
		$this->region_array = array(
									'region_name',
									'region_text'
									);
		$this->link_array = array(
									'link_text',
									'link_title',
									'link_url',
									'link_group',
									'link_order'
									);
	}
	public function insert_post($post_data) {
		$insert = $post_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO ".DB_PREFIX."post( date, title, meta_content, meta_keyword, content, url) VALUES(NOW(), '".$post_title."', '".$post_meta_content."', '".$post_meta_keyword."', '".$post_content."', '".$post_url."');";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function insert_region($region_data) {
		$insert = $region_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO ".DB_PREFIX."region( region_name, region_text) VALUES('".$region_name."', '".$region_text."');";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function insert_link($link_data) {
		$insert = $link_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$link_url = strip_tags($link_url);
			$link_url = str_ireplace(' ', '_',$link_url);
			$link_url = strtolower($link_url);
			$query = "INSERT INTO ".DB_PREFIX."navigation( link_title, link_text, link_url, link_group, link_order ) VALUES('".$link_title."', '".$link_text."', '".$link_url."', '".$link_group."', '".$link_order."');";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_post($post_data, $id) {
		$insert = $post_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "UPDATE ".DB_PREFIX."post SET title = '".$post_title."', meta_content = '".$post_meta_content."', meta_keyword = '".$post_meta_keyword."', content = '".$post_content."', url = '".$post_url."' WHERE idPost = ".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function save_settings($post_data) {
		$insert = $post_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			foreach($insert as $key => $val)
			{
				$query = "UPDATE ".DB_PREFIX."config SET value = '".$val."' WHERE setting = '".$key."';";
				$success = $this->db_handler->query($query);
			}
		}
		return $success;
	}
	public function update_link($link_data, $id) {
		$insert = $link_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$link_url = strip_tags($link_url);
			$link_url = str_ireplace(' ', '_',$link_url);
			$link_url = strtolower($link_url);
			$query = "UPDATE ".DB_PREFIX."navigation SET link_title = '".$link_title."', link_text = '".$link_text."', link_url = '".$link_url."', link_group = ".$link_group.", link_order = '".$link_order."' WHERE link_id = ".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_region($region_data, $id) {
		$insert = $region_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "UPDATE ".DB_PREFIX."region SET region_name = '".$region_name."', region_text = '".$region_text."' WHERE region_id = ".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function delete_post($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM ".DB_PREFIX."post WHERE idPost =".$id.";";
		$success = $this->db_handler->query($query);
		return $success;
	}
	public function delete_region($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM ".DB_PREFIX."region WHERE region_id =".$id.";";
		$success = $this->db_handler->query($query);
		return $success;
	}
	public function delete_link($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM ".DB_PREFIX."navigation WHERE link_id =".$id.";";
		$success = $this->db_handler->query($query);
		return $success;
	}
	public function get_post_array() {
		return $this->post_array;
	}
	public function get_region_array() {
		return $this->region_array;
	}
	public function get_link_array() {
		return $this->link_array;
	}
}
