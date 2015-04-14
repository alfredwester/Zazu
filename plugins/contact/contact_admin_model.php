<?php
require_once "contact_model.php";
class Contact_admin_model extends Contact_model{

	private $db_handler;

	public function __construct() {
		parent::__construct();
		$this->db_handler = Db_handler::GetInstance();
	}

	public function insert_contact($post_data) {
		$insert = $post_data;
		$success = false;
		if (is_array($insert) && !empty($insert)) {
			$insert = $this->db_handler->db_escape_chars($insert);
			extract($insert);
			$query = "INSERT INTO " . DB_PREFIX . "contact( contact_name, contact_email, contact_author) VALUES('"
			. $contact_name . "', '" . $contact_email . "', " . $_SESSION['user_id'] . ");";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}

	public function get_contact($id) {
		$id = $this->db_handler->db_escape_chars($id);
		$query = "SELECT contact_id, contact_name, contact_email FROM " . DB_PREFIX . "contact WHERE contact_id=".$id;
		$result = $this->db_handler->select_query($query);
		$contact = array();
		if ($obj = $result->fetch_object()) {
			$contact['contact_id'] = $obj->contact_id;
			$contact['contact_name'] = $obj->contact_name;
			$contact['contact_email'] = $obj->contact_email;
		}
		return $contact;
	}

	public function update_contact($id, $update_data) {
		$success = false;
		$id = $this->db_handler->db_escape_chars($id);
		$update_data = $this->db_handler->db_escape_chars($update_data);
		if(is_array($update_data)) {
			extract($update_data);
			$query = "UPDATE ".DB_PREFIX . "contact SET contact_name='".$contact_name."', contact_email='". $contact_email."' WHERE contact_id=".$id.";";
			$success = $this->db_handler->query($query);
		}
		return $success;
	}

	public function delete_contact($id) {
		$id = $this->db_handler->db_escape_chars($id);
		$query = "DELETE FROM " . DB_PREFIX . "contact WHERE contact_id=".$id.";";
		return $this->db_handler->query($query);
	}

	public function get_contacts() {
		$query = "SELECT contact_id, contact_name, contact_email FROM " . DB_PREFIX . "contact ORDER BY contact_id;";
		$result = $this->db_handler->select_query($query);
		$contacts = array();
		$count = 0;
		while ($obj = $result->fetch_object()) {
			$contacts['contacts'][$count]['contact_id'] = $obj->contact_id;
			$contacts['contacts'][$count]['contact_name'] = $obj->contact_name;
			$contacts['contacts'][$count]['contact_email'] = $obj->contact_email;
			$count++;
		}
		return $contacts;
	}
}
?>