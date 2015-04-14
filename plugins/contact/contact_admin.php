<?php
require_once "plugins/contact/contact_admin_model.php";
class Contact_admin implements IPluginAdminController {
	
	private $contact_model;
	private $helper;

	public function __construct() {
		$this->contact_model = new Contact_admin_model();
		$this->helper = new Helper();
	}

	public function get_css_array() {
		return array("plugins/contact/css/contact_admin.css");
	}

	public function get_data() {
		return $this->contact_model->get_contacts();
	}

	public function get_js_array() {
		return array("plugins/contact/js/contact_admin.js");
	}

	public function add() {
		if($this->contact_model->insert_contact($_POST)) {
			$_SESSION['success'] = "New contact successlly added";
		} else {
			$_SESSION['errors'][] = "Contact was not added, database error";
		}
		$this->helper->redirect(0, '/admin/plugin/contact');
	}

	public function edit($id) {
		$_SESSION['additional_data']['contact'] = $this->contact_model->get_contact($id);
		$this->helper->redirect(0, '/admin/plugin/contact');
	}

	public function update($id) {
		if($this->contact_model->update_contact($id, $_POST)) {
			$_SESSION['success'] = "Contact successlly updated";
			unset($_SESSION['additional_data']);
		} else {
			$_SESSION['errors'][] = "Contact was not updated, database error";
		}

		$this->helper->redirect(0, '/admin/plugin/contact');
	}

	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			if($this->contact_model->delete_contact($id)) {
				$_SESSION['success'] = "Contact successlly deleted";
				unset($_SESSION['additional_data']);
			} else {
				$_SESSION['errors'][] = "Contact was not deleted, database error";
			}
		} else {
			$_SESSION['errors'][] = "Id was not valid";
		}
		$this->helper->redirect(0, '/admin/plugin/contact');
	}

	public function cancel() {
		unset($_SESSION['additional_data']);
		$this->helper->redirect(0, '/admin/plugin/contact');
	}
}
?>