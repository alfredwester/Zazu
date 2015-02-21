<?php
require_once "calendar_model.php";
class Calendar implements IPluginController {

	private $calendar_model;

	public function __construct() {
		$this->calendar_model = new Calendar_model();
	}

	public function index() {
		return $this->draw_calendar();
	}

	public function get_css_array() {
		return array("calendar_css" => "plugins/calendar/css/calendar.css");
	}

	public function get_js_array() {
		return array();
	}

	protected function draw_calendar() {

		$calendar = "<div class=\"calendar\">";
		$events = $this->calendar_model->get_events();
		if (empty($events)) {
			$calendar .= "<p class=\"calendar-no-events\">Inga aktuella händelser hittades, återkom inom kort.</p>";
		} else {
			foreach ($events['events'] as $event) {
				extract($event);
				$time = strtotime($event_date);
				$event_month = date('M Y', $time);
				$event_time = date('G:i', $time);
				$event_date = date('j', $time);
				$calendar .= "<div class=\"calendar-event-row\">
				<div class=\"calendar-event-container\">
					<div class=\"calendar-event-date\">
						<span class=\"date\">" . $event_date . "</span>
						<span class=\"month\">" . $event_month . "</span>
						<span class=\"time\">" . $event_time . "</span>
					</div>
					<div class=\"calendar-event-info clearfix\">
						<h5>" . $event_name . "</h5>
						<p>" . $event_description . "</p>
					</div>
				</div>
			</div>";
			}
		}
		$calendar .= "</div>";

		return $calendar;
	}
}
?>