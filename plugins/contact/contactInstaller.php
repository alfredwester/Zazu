<?php
class ContactInstaller implements IPluginInstaller {
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
		CREATE TABLE IF NOT EXISTS {$prefix}contact (
			contact_id SMALLINT PRIMARY KEY AUTO_INCREMENT,
			contact_name varchar(100) NOT NULL,
			contact_email varchar(100) NOT NULL,
			contact_author int(11) NOT NULL,
			FOREIGN KEY (contact_author) REFERENCES {$prefix}user(user_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOD;
		$this->remove_query = <<<EOD
		DROP TABLE IF EXISTS {$prefix}contact;
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