<?php
require_once "contact_model.php";
class Contact extends Helper implements IPluginController {

	private $contact_model;

	public function __construct() {
		$this->contact_model = new Contact_model();
	}

	private function unset_sessions() {
		unset($_SESSION['name']);
		unset($_SESSION['email']);
		unset($_SESSION['subject']);
		unset($_SESSION['message']);
	}

	public function index($session) {
		extract($session);
		$note = "";
		if (isset($success)) {
			$note = '<div class=\'col-lg-6\'><div class=\'alert alert-success alert-dismissible\' role=\'alert\'><button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button>' . $success . '</div></div>';
		} elseif (isset($errors)) {
			$note = '<div class=\'col-lg-6\'><div class=\'alert alert-danger alert-dismissible\' role=\'alert\'><button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button>' . $errors['note'] . '</div></div>';
		}

		$url = substr($_SERVER['REQUEST_URI'], strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')));

		$contacts = $this->contact_model->get_contacts();
		if (empty($contacts)) {
			$contact_form = "<div class='alert alert-info' role='alert'><i class='fa fa-info-circle fa-lg'></i> Tyvärr går det inte att skicka meddelanden just nu, återkom gärna senare.</div>";
		} else {
			$name = isset($_SESSION['name']) ? $_SESSION['name'] : "";
			$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
			$subject = isset($_SESSION['subject']) ? $_SESSION['subject'] : "";
			$message = isset($_SESSION['message']) ? $_SESSION['message'] : "";

			$options = "";
			foreach ($contacts as $contact) {
				$selected = "";
				if ($subject == $contact['contact_id']) {
					$selected = "selected='selected'";
				}
				$options .= "<option value='" . $contact['contact_id'] . "' " . $selected . ">" . $contact['contact_name'] . "</option>";
			}

			$contact_form = "<div class='contact_form'>
				<form class='form-horizontal' role='form' action='" . BASE_PATH . "/plugin/call_func/contact/send" . $url . "' method='post'>
					<div class='form-group'>
						<label class='col-sm-2 col-md-2 col-lg-2 control-label' for='name'>Namn</label>
						<div class='col-sm-8 col-md-4 col-lg-3'>
							<input class='form-control' type='text' id='name' name='name' placeholder='Ditt namn' value='" . $name . "'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 col-lg-2 control-label' for='email'>E-post</label>
						<div class='col-sm-8 col-md-4 col-lg-3'>
							<input class='form-control' type='email' id='email' name='email' placeholder='Din epost-adress' value='" . $email . "'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 col-lg-2 control-label' for='subject' >Ämne</label>
						<div class='col-sm-8 col-md-4 col-lg-3'>
							<select id='subject' name='subject' class='form-control'>
								" . $options . "
							</select>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 col-lg-2 control-label' for='message'>Meddelande</label>
						<div class='col-sm-8 col-md-6 col-lg-7'>
							<textarea class='form-control' id='message' name='message' rows='6'>" . $message . "</textarea>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-offset-2 col-sm-10 col-lg-1'>
							<button type='submit' class='btn btn-default'>Skicka</button>
						</div>"
			. $note .
			"</div>
				</form>
			</div>";
		}
		$this->unset_sessions();
		if (isset($errors)) {
			$contact_form .= "<script type='text/javascript'>
							window.onload = function(){";
			foreach ($errors as $key => $value) {
				if ($key !== "note") {
					$contact_form .= "showErrorMessage('" . $key . "', '" . $value . "');";
				}
			}
			$contact_form .= "}</script>";
		}

		return $contact_form;
	}

	public function send($redirect_url) {

		$empty_items = $this->check_empty(array("email", "subject", "message", "name"), $_POST);
		$errors_exists = false;
		if (!empty($empty_items)) {
			$_SESSION['errors'] = $empty_items;
			$errors_exists = true;
		}

		if (!isset($empty_items['email']) && !$this->is_email($_POST['email'])) {
			$_SESSION['errors']["email"] = "Felaktig epost-adress";
			$errors_exists = true;
		}

		if ($errors_exists) {
			$_SESSION['errors']["note"] = "Alla fält måste fyllas i korrekt";
			$_SESSION['name'] = strip_tags($_POST['name']);
			$_SESSION['email'] = strip_tags($_POST['email']);
			$_SESSION['subject'] = strip_tags($_POST['subject']);
			$_SESSION['message'] = strip_tags($_POST['message']);
		} else {
			$email = $this->contact_model->get_contact_email($_POST['subject']);
			if (!empty($email)) {
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
				$headers .= "From: " . ucwords(strip_tags($_POST['name'])) . " <" . strip_tags($_POST['email']) . ">\r\n";

				if (mail($email, "Meddelande skickat från " . $_SERVER['SERVER_NAME'], strip_tags($_POST['message']), $headers)) {
					$_SESSION['success'] = "Ditt meddelande har skickats!";
				} else {
					$_SESSION['errors']['note'] = "Meddelandet kunde tyvärr inte skickas, tekniskt fel";
				}
			} else {
				$_SESSION['errors']['note'] = "Meddelandet kunde tyvärr inte skickas, tekniskt fel";
			}
		}
		$this->redirect(0, '/' . $redirect_url);
	}

	public function get_css_array() {
		return array("plugins/contact/css/contact.css");
	}

	public function get_js_array() {
		return array("plugins/contact/js/contact.js");
	}

}
?>