<?php
class Calendar_model {
	private $db_handler;

	public function __construct() {
		$this->db_handler = Db_handler::GetInstance();
	}

	public function get_events($nr_of_items = null) {
		$limit = "";
		$this->db_handler->db_escape_chars($nr_of_items);
		if(isset($nr_of_items) && is_numeric($nr_of_items) && $nr_of_items > 0) {
			$limit = " LIMIT ".$nr_of_items;
		}
		$query = "SELECT event_id, event_name, event_date, event_description, event_author FROM " . DB_PREFIX . "calendar_event WHERE event_date >= CURDATE() ORDER BY event_date".$limit.";";
		$result = $this->db_handler->select_query($query);
		$events = array();
		$count = 0;
		while ($obj = $result->fetch_object()) {
			$events['events'][$count]['event_id'] = $obj->event_id;
			$events['events'][$count]['event_name'] = $obj->event_name;
			$events['events'][$count]['event_date'] = $obj->event_date;
			$events['events'][$count]['event_description'] = $obj->event_description;
			$count++;
		}
		return $events;
	}
}