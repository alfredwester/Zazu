<?php
class Adminmodel {
	private $db_handler;
	private $post_array;
	private $region_array;
	private $link_array;
	private $types;
	private $password_salt;
	private $author_menu;
	private $editor_menu;
	private $admin_menu;
	private $new_password_salt;

	public function __construct() {
		$this->db_handler = Db_handler::GetInstance();
		$this->post_array = array(
			'post_title',
			'post_url',
			'post_category',
			'post_content',
		);
		$this->category_array = array(
			'category_name',
			'category_url',
		);
		$this->region_array = array(
			'region_name',
			'region_text',
		);
		$this->link_array = array(
			'link_text',
			'link_title',
			'link_url',
			'link_group',
			'link_order',
		);
		$this->user_array = array(
			'user_username',
			'user_password',
			'user_email',
			'user_realname',
			'user_role',
		);
		$this->types = array('post', 'region', 'link', 'user', 'category');
		$this->password_salt = '##zazu mvc framework## is the best salt ever!!';
		$this->new_password_salt = '##zazu mvc framework## temp link' . date('y-m-d');
		$this->author_menu = array(array('menu_title' => 'Posts', 'menu_text' => 'Posts', 'menu_url' => '/admin/'),
			array('menu_title' => 'Menus', 'menu_text' => 'Menus', 'menu_url' => '/admin/links/'),
			array('menu_title' => 'User profile settings', 'menu_text' => 'User Profile', 'menu_url' => '/admin/user_profile/'),
			array('menu_title' => 'Log out', 'menu_text' => 'Log out', 'menu_url' => '/admin/logout/')
		);
		$this->editor_menu = array(array('menu_title' => 'Posts', 'menu_text' => 'Posts', 'menu_url' => '/admin/'),
			array('menu_title' => 'Regions', 'menu_text' => 'Regions', 'menu_url' => '/admin/regions/'),
			array('menu_title' => 'Menus', 'menu_text' => 'Menus', 'menu_url' => '/admin/links/'),
			array('menu_title' => 'User profile settings', 'menu_text' => 'User Profile', 'menu_url' => '/admin/user_profile/'),
			array('menu_title' => 'Log out', 'menu_text' => 'Log out', 'menu_url' => '/admin/logout/')
		);
		$this->admin_menu = array(array('menu_title' => 'Posts', 'menu_text' => 'Posts', 'menu_url' => '/admin/'),
			array('menu_title' => 'Categories', 'menu_text' => 'Categories', 'menu_url' => '/admin/categories/'),
			array('menu_title' => 'Regions', 'menu_text' => 'Regions', 'menu_url' => '/admin/regions/'),
			array('menu_title' => 'Menus', 'menu_text' => 'Menus', 'menu_url' => '/admin/links/'),
			array('menu_title' => 'Users', 'menu_text' => 'Users', 'menu_url' => '/admin/users/'),
			array('menu_title' => 'Site settings', 'menu_text' => 'Site settings', 'menu_url' => '/admin/settings/'),
			array('menu_title' => 'Log out', 'menu_text' => 'Log out', 'menu_url' => '/admin/logout/')
		);
	}
	private function get_md5_pass($password) {
		$password = md5(md5($this->password_salt) . $password . $this->password_salt);
		return $password;
	}
	public function get_md5_link($email) {
		$url = md5(md5($this->new_password_salt) . $email . $this->new_password_salt);
		return $url;
	}
	public function change_password($email, $password) {
		$success = false;
		$password = $this->db_handler->db_escape_chars($password);
		$email = $this->db_handler->db_escape_chars($email);
		$query = "UPDATE " . DB_PREFIX . "user SET user_password = '" . $this->get_md5_pass($password) . "' WHERE user_email = '" . $email . "';";

		$this->db_handler->query($query);
		if ($this->db_handler->get_affected_rows() > 0) {
			$success = true;
		}
		return $success;
	}
	public function user_exists($email) {
		$email = $this->db_handler->db_escape_chars($email);
		$success = false;
		$query = 'SELECT user_id FROM ' . DB_PREFIX . 'user WHERE user_email = \'' . $email . '\';';

		$result = $this->db_handler->select_query($query);
		if ($this->db_handler->get_affected_rows() > 0) {
			$success = true;
		}
		return $success;
	}
	public function insert_post($post_data) {
		$insert = $post_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO " . DB_PREFIX . "post( post_date, post_title, post_meta_content, post_meta_keyword, post_content, post_url, post_author, post_category) VALUES(NOW(), '" . $post_title . "', '" . $post_meta_content . "', '" . $post_meta_keyword . "', '" . $post_content . "', '" . $post_url . "', " . $_SESSION['user_id'] . ", " . $post_category . ");";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function insert_region($region_data) {
		$insert = $region_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO " . DB_PREFIX . "region( region_name, region_text) VALUES('" . $region_name . "', '" . $region_text . "');";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function insert_category($category_data) {
		$insert = $category_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO " . DB_PREFIX . "category( category_name, category_url) VALUES('" . $category_name . "', '" . $category_url . "');";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function insert_link($link_data) {
		$insert = $link_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$link_url = strip_tags($link_url);
			$link_url = str_ireplace(' ', '_', $link_url);
			$link_url = strtolower($link_url);
			$query = "INSERT INTO " . DB_PREFIX . "link( link_title, link_text, link_url, link_group, link_order, link_author ) VALUES('" . $link_title . "', '" . $link_text . "', '" . $link_url . "', '" . $link_group . "', '" . $link_order . "', " . $_SESSION['user_id'] . ");";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function insert_user($user_data) {
		$insert = $user_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$user_password = $this->get_md5_pass($user_data['user_password']);
			$query = "INSERT INTO " . DB_PREFIX . "user( user_username, user_password, user_email, user_realname, user_role ) VALUES('" . $user_username . "', '" . $user_password . "', '" . $user_email . "', '" . $user_realname . "', " . $user_role . ");";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_post($post_data, $id) {
		$insert = $post_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			extract($insert);
			$query = "UPDATE " . DB_PREFIX . "post SET post_title = '" . $post_title . "', post_meta_content = '" . $post_meta_content . "', post_meta_keyword = '" . $post_meta_keyword . "', post_content = '" . $post_content . "', post_url = '" . $post_url . "', post_category = '" . $post_category . "' WHERE post_id = " . $id . ";";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function save_settings($post_data) {
		$insert = $post_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			foreach ($insert as $key => $val) {
				$query = "UPDATE " . DB_PREFIX . "config SET value = '" . $val . "' WHERE setting = '" . $key . "';";

				$success = $this->db_handler->query($query);
			}
		}
		return $success;
	}
	public function update_link($link_data, $id) {
		$insert = $link_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			extract($insert);
			$link_url = strip_tags($link_url);
			$link_url = str_ireplace(' ', '_', $link_url);
			$link_url = strtolower($link_url);
			$query = "UPDATE " . DB_PREFIX . "link SET link_title = '" . $link_title . "', link_text = '" . $link_text . "', link_url = '" . $link_url . "', link_group = " . $link_group . ", link_order = '" . $link_order . "' WHERE link_id = " . $id . ";";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_user($user_data, $id) {
		$insert = $user_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			$user = $this->get_user($id);
			extract($insert);
			if ($user['user_password'] != $user_password) {
				$user_password = $this->get_md5_pass($user_data['user_password']);
			}
			$query = "UPDATE " . DB_PREFIX . "user SET user_username = '" . $user_username . "', user_password = '" . $user_password . "', user_email = '" . $user_email . "', user_realname = '" . $user_realname . "', user_role = " . $user_role . " WHERE user_id = " . $id . ";";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_region($region_data, $id) {
		$insert = $region_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			extract($insert);
			$query = "UPDATE " . DB_PREFIX . "region SET region_name = '" . $region_name . "', region_text = '" . $region_text . "' WHERE region_id = " . $id . ";";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function update_category($category_data, $id) {
		$insert = $category_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			$id = $this->db_handler->db_escape_chars($id);
			extract($insert);
			$query = "UPDATE " . DB_PREFIX . "category SET category_name = '" . $category_name . "', category_url = '" . $category_url . "' WHERE category_id = " . $id . ";";

			$success = $this->db_handler->query($query);
		}
		return $success;
	}
	public function delete_post($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM " . DB_PREFIX . "post WHERE post_id =" . $id . ";";

		$success = $this->db_handler->query($query);
		return $success;
	}
	public function delete_region($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM " . DB_PREFIX . "region WHERE region_id =" . $id . ";";

		$success = $this->db_handler->query($query);
		return $success;
	}
	public function delete_category($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "SELECT COUNT(post_id) AS nrOfPosts FROM " . DB_PREFIX . "post WHERE post_category = " . $id . ";";

		$result = $this->db_handler->select_query($query);
		if ($obj = $result->fetch_object()) {
			if ($obj->nrOfPosts > 0) {
				$_SESSION['errors'][] = $obj->nrOfPosts . " posts exist in this category. Delete them or move them to another category.";
				$success = false;
			} else {
				$query = "DELETE FROM " . DB_PREFIX . "category WHERE category_id =" . $id . ";";

				$success = $this->db_handler->query($query);
			}
		}
		return $success;
	}
	public function delete_link($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM " . DB_PREFIX . "link WHERE link_id =" . $id . ";";

		$success = $this->db_handler->query($query);
		return $success;
	}
	public function delete_user($id) {
		$this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM " . DB_PREFIX . "user WHERE user_id =" . $id . ";";

		$success = $this->db_handler->query($query);
		return $success;
	}
	public function get_users() {
		$users = array();
		$result = $this->db_handler->select_query('SELECT * FROM ' . DB_PREFIX . 'user');
		$count = 0;
		while ($obj = $result->fetch_object()) {
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
		$result = $this->db_handler->select_query('SELECT * FROM ' . DB_PREFIX . 'user AS u INNER JOIN ' . DB_PREFIX . 'role AS r ON u.user_role = r.role_id WHERE u.user_id =' . $user_id . ';');

		if ($obj = $result->fetch_object()) {
			$user['user_id'] = $obj->user_id;
			$user['user_role'] = $obj->user_role;
			$user['user_username'] = $obj->user_username;
			$user['user_password'] = $obj->user_password;
			$user['user_email'] = $obj->user_email;
			$user['user_realname'] = $obj->user_realname;
			$user['role_name'] = $obj->role_name;
			$user['role_id'] = $obj->role_id;
			$user += $this->get_roles();
		}
		return $user;
	}
	public function get_roles() {
		$roles = array();
		$query = 'SELECT * FROM ' . DB_PREFIX . 'role;';

		$result = $this->db_handler->select_query($query);
		$count = 0;
		while ($obj = $result->fetch_object()) {
			$roles['roles'][$count]['role_id'] = $obj->role_id;
			$roles['roles'][$count]['role_name'] = $obj->role_name;
			$roles['roles'][$count]['role_description'] = $obj->role_description;
			$count++;
		}
		return $roles;
	}
	public function get_current_role() {
		$query = "SELECT user_role FROM " . DB_PREFIX . "user WHERE user_id = " . $_SESSION['user_id'] . ";";

		$result = $this->db_handler->select_query($query);
		$obj = $result->fetch_object();
		return $obj->user_role;
	}
	public function check_login($username, $password) {
		$user = array();
		$username = $this->db_handler->db_escape_chars($username);
		$password = $this->get_md5_pass($password);
		$query = 'SELECT user_id, user_role FROM ' . DB_PREFIX . 'user WHERE user_username = \'' . $username . '\' AND user_password = \'' . $password . '\';';

		$result = $this->db_handler->select_query($query);
		if ($obj = $result->fetch_object()) {
			$user['user_id'] = $obj->user_id;
			$user['user_role'] = $obj->user_role;
		}
		return $user;
	}
	public function get_menu() {
		$menu = array();
		switch ($this->get_current_role()) {
			case 1:$menu = $this->admin_menu;
				break;
			case 2:$menu = $this->editor_menu;
				break;
			case 3:$menu = $this->author_menu;
				break;
		}
		return $menu;
	}
	public function get_post_array() {
		return $this->post_array;
	}
	public function get_category_array() {
		return $this->category_array;
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
	public function get_types() {
		return $this->types;
	}
}