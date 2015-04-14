<?php
require_once "plugins/calendar/calendar.php";
require_once "plugins/calendar/calendar_admin_model.php";
class Calendar_admin extends Calendar implements IPluginAdminController {

	private $calendar_model;
	private $helper;

	public function __construct() {
		$this->calendar_model = new Calendar_admin_model();
		$this->helper = new Helper();
	}

	public function get_css_array() {
		return array("include/bootstrap-timepicker-0.2.6/css/bootstrap-timepicker.css",
			"include/datepicker/css/datepicker.css",
			"include/summernote-0.5.9/summernote.css",
			"plugins/calendar/css/calendar.css",
			"plugins/calendar/css/calendar-admin.css");
	}
	public function get_data() {
		return $this->calendar_model->get_events();
	}
	public function get_js_array() {
		return array("include/bootstrap-timepicker-0.2.6/js/bootstrap-timepicker.js",
			"include/datepicker/js/bootstrap-datepicker.js",
			"include/summernote-0.5.9/summernote.min.js",
			"theme/bootstrap/js/textarea.js",
			"plugins/calendar/js/calendar_admin.js");
	}
	public function add() {
		if($this->calendar_model->insert_event($_POST)) {
			$_SESSION['success'] = "New event successlly added";
		} else {
			$_SESSION['errors'][] = "Event was not added, database error";
		}
		$this->helper->redirect(0, '/admin/plugin/calendar');
	}
	public function edit($id) {
		$_SESSION['additional_data']['event'] = $this->calendar_model->get_event($id);
		$this->helper->redirect(0, '/admin/plugin/calendar');
	}

	public function update($id) {
		if($this->calendar_model->update_event($id, $_POST)) {
			$_SESSION['success'] = "Event successlly updated";
			unset($_SESSION['additional_data']);
		} else {
			$_SESSION['errors'][] = "Event was not updated, database error";
		}

		$this->helper->redirect(0, '/admin/plugin/calendar');
	}

	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			if($this->calendar_model->delete_event($id)) {
				$_SESSION['success'] = "Event successlly deleted";
				unset($_SESSION['additional_data']);
			} else {
				$_SESSION['errors'][] = "Event was not deleted, database error";
			}
		} else {
			$_SESSION['errors'][] = "Id was not valid";
		}
		$this->helper->redirect(0, '/admin/plugin/calendar');
	}

	public function cancel() {
		unset($_SESSION['additional_data']);
		$this->helper->redirect(0, '/admin/plugin/calendar');
	}

}
?>