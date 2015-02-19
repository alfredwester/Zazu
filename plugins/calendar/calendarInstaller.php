<?php
class CalendarInstaller implements IPluginInstaller {
	private $prefix = DB_PREFIX;
	private $install_query;
	private $remove_query;

	function __construct() {
		$this->db_handler = Db_handler::GetInstance();
		$this->init();
	}

	private function init() {
		$prefix = $this->prefix;
		$this->install_query = <<<EOD
		CREATE TABLE IF NOT EXISTS {$prefix}calendar_event (
			event_id SMALLINT PRIMARY KEY AUTO_INCREMENT,
			event_name varchar(50) NOT NULL,
			event_date DATETIME NOT NULL,
			event_description text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			event_author int(11) NOT NULL,
			FOREIGN KEY (event_author) REFERENCES {$prefix}user(user_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOD;
		$this->remove_query = <<<EOD
		DROP TABLE IF EXISTS {$prefix}calendar_event;
EOD;
	}

	public function install() {
		$this->db_handler->query($this->install_query);
	}

	public function uninstall() {
		$this->db_handler->query($this->remove_query);

	}
}
?>