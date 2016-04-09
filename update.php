<?php
/*--------------------------------
Update script for zazu database
----------------------------------*/
require_once ('core/bootstrap.php');
require_once ('config.php');
require_once ('core/logger.php');
require_once ('core/db_handler.php');
$db_handler = Db_handler::getInstance();
$prefix = DB_PREFIX;

$sql = <<<EOD
## Update plugin table with the new column version ##
ALTER TABLE {$prefix}plugin
ADD COLUMN plugin_version varchar(30) COLLATE utf8_unicode_ci
AFTER plugin_name;
EOD;

echo "<pre>";
if (isset($_GET['sql'])) {
	echo "<br>" . htmlentities($sql) . "<br>";
} else {

	$result = $db_handler->multi_query($sql);
	$success = true;

	foreach ($result as $key => $val) {
		$s = $key + 1;
		if ($val == 1) {
			echo "Statement " . $s . " passed <br>";
		} else {
			$success = false;
			echo "Statement " . $s . " failed: " . $db_handler->get_latest_error() . "<br>";
		}
	}

	if ($success) {
		echo "<br><strong>Congratulations, update script has finished!</strong>
  	<br>To access cms administration, go to <a href='login'>login</a>
  	<br>Remove or change permissions to this file to prevent damage.
    <br><br><a href='?sql' title='sql'>Click here to see the sql</a>";
	} else {
		echo "<strong>Update has failed! Please check failing statements, fix the problem and run this script again.</strong>";
	}
	echo "</pre>";
}
?>