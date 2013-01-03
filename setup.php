<?php
/*--------------------------------
	Setup script for zazu database
----------------------------------*/
require_once('config.php');
require_once('core/db_handler.php');
$db_handler = Db_handler::getInstance();
$prefix = DB_PREFIX;

$sql = <<<EOD
CREATE TABLE IF NOT EXISTS {$prefix}config (
  setting varchar(50) NOT NULL,
  value varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (setting)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO {$prefix}config (setting, value) VALUES
('admin_theme', 'bootstrap'),
('default_controller', 'cmscontroller'),
('default_function', 'index'),
('meta_content', 'zazu is a small and simple cms mvc '),
('meta_keyword', 'zazu, mvc, cms, framework, php'),
('site_subtitle', 'mvc-cms framework'),
('site_title', 'Zazu'),
('start_content', 'latest10'),
('theme', 'default'),
('title', 'Default title if no post title is not used');

CREATE TABLE IF NOT EXISTS {$prefix}link (
  link_id int(11) NOT NULL AUTO_INCREMENT,
  link_title varchar(156) COLLATE utf8_unicode_ci NOT NULL,
  link_text varchar(156) COLLATE utf8_unicode_ci NOT NULL,
  link_url varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  link_group int(11) NOT NULL,
  link_order int(11) NOT NULL,
  link_author int(11) NOT NULL,
  PRIMARY KEY (link_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO {$prefix}link (link_id, link_title, link_text, link_url, link_group, link_order, link_author) VALUES
(1, 'Home page', 'Home', '/', 1, 0, 1),
(2, 'Welcome First page', 'Welcome', 'first_page', 1, 1, 1),
(3, 'Log in to admin panel', 'Login', '/login', 1, 2, 1);

CREATE TABLE IF NOT EXISTS {$prefix}post (
  post_id int(11) NOT NULL AUTO_INCREMENT,
  post_date datetime NOT NULL,
  post_title varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  post_meta_content varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  post_meta_keyword varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  post_content text COLLATE utf8_unicode_ci NOT NULL,
  post_url varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  post_author int(11) NOT NULL,
  PRIMARY KEY (post_id),
  UNIQUE KEY url (post_url),
  KEY post_author (post_author)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO {$prefix}post (post_id, post_date, post_title, post_meta_content, post_meta_keyword, post_content, post_url, post_author) VALUES
(1, '2012-01-11 19:38:30', 'Welcome', 'Congratulations, this is the first post and everything works fine!', 'zazu, mvc, first, post', '<p>This is the first post in the cms. and everything seems to work fine! Delete it or change it as you wish.<img title="tr&auml;d" src="http://www.mynumberis911.se/wp-content/uploads/2011/02/tr%C3%A4d.jpg" alt="tr&auml;d" width="380" height="246" /></p>', 'first_page', 1);

CREATE TABLE IF NOT EXISTS {$prefix}region (
  region_id int(11) NOT NULL AUTO_INCREMENT,
  region_name varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  region_text text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (region_id),
  UNIQUE KEY region_name (region_name)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO {$prefix}region (region_id, region_name, region_text) VALUES
(1, 'top1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
(2, 'top2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
(3, 'top3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
(4, 'footer', 'Zazu default theme &copy; Zazu.se');

CREATE TABLE IF NOT EXISTS {$prefix}role (
  role_id int(11) NOT NULL AUTO_INCREMENT,
  role_name varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  role_description varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (role_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO {$prefix}role (role_id, role_name, role_description) VALUES
(1, 'admin', 'As admin you have permissions to administrate everything on the website'),
(2, 'editor', 'As editor you have permissions to edit and create posts and regions'),
(3, 'author', 'As author you have permissions to create and manage posts created by you');

CREATE TABLE IF NOT EXISTS {$prefix}user (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  user_username varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  user_password varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  user_email varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  user_realname varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  user_role int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (user_id),
  UNIQUE KEY unique_user (user_username,user_password)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO {$prefix}user (user_id, user_username, user_password, user_email, user_realname, user_role) VALUES
(1, 'admin', '4dba7c2b78117960597d06505c183cec', 'admin@admin.com', 'Admin', 1),
(2, 'editor', '5c6c609c509823dbb3887b229b839114', 'editor@zazu.se', 'Eddie', 2),
(3, 'author', '2febb571d707867a0c291ff933285282', 'alfredwester@gmail.com', 'Author', 3);
EOD;

$result = $db_handler->multi_query($sql);
$success = true;
echo "<pre>";
foreach($result as $key => $val) {
	$s = $key+1;
	if($val == 1) {
		echo "Statement ". $s ." passed <br>";
	}
	else {
		$success = false;
		echo "Statement ". $s ." failed: ".$db_handler->get_latest_error()."<br>";
	}
}
echo "<pre>";
if($success) {
	echo "<strong>Congratulations, setup has finished!</strong>
	<br>To access cms administration, go to /login and enter username: admin, password: admin. You can change password in the admin-area. 
	<br>Remove or change permissions to this file to prevent damage.";
}
else {
	echo "<strong>Setup has failed! Please check failing statements, fix the problem and run this script again.</strong>";
}
?>