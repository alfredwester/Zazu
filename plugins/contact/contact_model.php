<?php
class Contact_model {
	private $db_handler;

	public function __construct() {
		$this->db_handler = Db_handler::GetInstance();
	}

	public function get_contacts() {
		$query = "SELECT contact_id, contact_name FROM " . DB_PREFIX . "contact ORDER BY contact_id;";
		$result = $this->db_handler->select_query($query);
		$contacts = array();
		$count = 0;
		while ($obj = $result->fetch_object()) {
			$contacts[$count]['contact_id'] = $obj->contact_id;
			$contacts[$count]['contact_name'] = $obj->contact_name;
			$count++;
		}
		return $contacts;
	}

	public function get_contact_email($id) {
		$id = $this->db_handler->db_escape_chars($id);
		$query = "SELECT contact_email FROM " . DB_PREFIX . "contact WHERE contact_id=".$id;
		$result = $this->db_handler->select_query($query);
		$contact_email = "";
		if ($obj = $result->fetch_object()) {
			$contact_email = $obj->contact_email;
		}
		return $contact_email;
	}
}
?>