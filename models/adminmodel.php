<?php
class Adminmodel {
	private $db_handler;
	private $post_array;
	private $region_array;
	private $link_array;
	private $password_salt;

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
		$this->user_array = array(
									'user_username',
									'user_password',
									'user_email',
									'user_realname'
									);
		$this->password_salt = '##zazu mvc framework## is the best salt ever!!';
	}
	private function get_md5_pass($password) {
		$password = md5(md5($this->password_salt).$password.$this->password_salt);
		return $password;
	}
	public function insert_post($post_data) {
		$insert = $post_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO ".DB_PREFIX."post( post_date, post_title, post_meta_content, post_meta_keyword, post_content, post_url) VALUES(NOW(), '".$post_title."', '".$post_meta_content."', '".$post_meta_keyword."', '".$post_content."', '".$post_url."');";
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
	public function insert_user($user_data) {
		$insert = $user_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$user_password = $this->get_md5_pass($user_data['user_password']);
			$query = "INSERT INTO ".DB_PREFIX."user( user_username, user_password, user_email, user_realname ) VALUES('".$user_username."', '".$user_password."', '".$user_email."', '".$user_realname."');";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_post($post_data, $id) {
		$insert = $post_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			extract($insert);
			$query = "UPDATE ".DB_PREFIX."post SET post_title = '".$post_title."', post_meta_content = '".$post_meta_content."', post_meta_keyword = '".$post_meta_keyword."', post_content = '".$post_content."', post_url = '".$post_url."' WHERE post_id = ".$id.";";
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
			$id = $this->db_handler->db_escape_chars($id);
			extract($insert);
			$link_url = strip_tags($link_url);
			$link_url = str_ireplace(' ', '_',$link_url);
			$link_url = strtolower($link_url);
			$query = "UPDATE ".DB_PREFIX."navigation SET link_title = '".$link_title."', link_text = '".$link_text."', link_url = '".$link_url."', link_group = ".$link_group.", link_order = '".$link_order."' WHERE link_id = ".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_user($user_data, $id) {
		$insert = $user_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			$user = $this->get_user($id);
			extract($insert);
			if($user['user_password'] != $user_password) {
				$user_password = $this->get_md5_pass($user_data['user_password']);
			}
			$query = "UPDATE ".DB_PREFIX."user SET user_username = '".$user_username."', user_password = '".$user_password."', user_email = '".$user_username."', user_realname = '".$user_realname."' WHERE user_id = ".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_region($region_data, $id) {
		$insert = $region_data;
		$success = false;
		if(is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			extract($insert);
			$query = "UPDATE ".DB_PREFIX."region SET region_name = '".$region_name."', region_text = '".$region_text."' WHERE region_id = ".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function delete_post($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM ".DB_PREFIX."post WHERE post_id =".$id.";";
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
	public function delete_user($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM ".DB_PREFIX."user WHERE user_id =".$id.";";
		$success = $this->db_handler->query($query);
		return $success;
	}
	public function get_users() {
		$users = array();
		$result = $this->db_handler->query('SELECT * FROM '.DB_PREFIX.'user');
		$count = 0;
		while($obj = $result->fetch_object()) {
			$users['users'][$count]['user_id'] = $obj->user_id;
			$users['users'][$count]['user_username'] = $obj->user_username;
			$users['users'][$count]['user_password'] = $obj->user_password;
			$users['users'][$count]['user_email'] = $obj->user_email;
			$users['users'][$count]['user_realname'] = $obj->user_realname;
			$count++;
		}
		return $users;
	}
	public function get_user($user_id) {
		$user = array();
		$this->db_handler->db_escape_chars($user_id);
		$result = $this->db_handler->query('SELECT * FROM '.DB_PREFIX.'user WHERE user_id ='.$user_id.';');
		$obj = $result->fetch_object();
		$user['user_id'] = $obj->user_id;
		$user['user_username'] = $obj->user_username;
		$user['user_password'] = $obj->user_password;
		$user['user_email'] = $obj->user_email;
		$user['user_realname'] = $obj->user_realname;
		return $user;
	}
	public function check_login($username, $password) {
		$user_id = 0;
		$this->db_handler->db_escape_chars($username);
		$password = $this->get_md5_pass($password);
		$query = "SELECT user_id FROM ".DB_PREFIX.'user WHERE user_username = \''.$username.'\' AND user_password = \''.$password.'\';';
		$result = $this->db_handler->query($query);
		if($obj = $result->fetch_object()) {
			$user_id = $obj->user_id;
		}
		return $user_id;
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
	public function get_user_array() {
		return $this->user_array;
	}
}