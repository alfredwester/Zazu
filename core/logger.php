<?php
class Logger {
	static public function log($log_level, $message) {
		if (LOG_LEVEL >= $log_level) {
			$today = date("Y-m-d H:i:s");
			error_log("[" . $today . " " . self::get_log_level_as_string($log_level) . " " . self::get_caller() . "] - " . $message . "\n", 3, LOG_FILE);
		}
	}

	private static function get_caller() {
		$trace = debug_backtrace();
		$line_nr ="#";
		if(isset($trace[2]['line'])) {
			$line_nr = $trace[1]['line'];
		}
		return $trace[2]['class'] . " " . $trace[2]['function'] . ":" . $line_nr;
	}

	private static function get_log_level_as_string($log_level) {
		$constants = get_defined_constants(true)["user"];
		$level = "";
		foreach ($constants as $key => $value) {
			if ($log_level == $value && ($key == 'ERROR' || $key == "INFO" || $key == "DEBUG")) {
				$level = $key;
			}
		}
		return $level;
	}
}
?>