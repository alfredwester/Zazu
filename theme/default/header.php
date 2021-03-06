<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
		<title><?=$title?></title>
		<meta name="description" content="<?=$meta_content?>">
		<meta name="keywords" content="<?=$meta_keyword?>">
		<link rel="stylesheet" href="<?php echo BASE_PATH;?>/include/blueprint/screen.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="<?php echo BASE_PATH;?>/include/blueprint/print.css" type="text/css" media="print">
		<!--[if lt IE 8]>
		<link rel="stylesheet" href="<?php echo BASE_PATH;?>/include/blueprint/ie.css" type="text/css" media="screen, projection">
		<![endif]-->
		<link rel="stylesheet" href="<?php echo BASE_PATH;?>/theme/default/css/buttons.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="<?php echo BASE_PATH;?>/theme/default/css/zazu.css" type="text/css" media="all">
		<?php 
			if(isset($head)) {
				echo "<!-- css from dynamic places -->\n";
				foreach ($head as $css) {
					echo "\t\t<link href=\"".BASE_PATH."/".$css."\" rel=\"stylesheet\" media=\"screen\" />\n";
				}
			}
		?>
	</head>
	<body>
		<div class="container showgrid">
			<header class="header span-24">
				<h4><?=$site_title?></h4>
				<p><?=$site_subtitle?></p>
			</header>
			<nav class="span-24 menu buttons">
				<?php
				foreach($menu_1 as $link) {
				?>
					<a href="<?=$link['link_url'];?>" title="<?=$link['link_title'];?>"><?=$link['link_text'];?></a>
				<?php
				}
				?>
			</nav>
			<hr>
			<?php
				if(isset($info)) {
					echo "<div class=\"span-10 push-6 info\">".$info."</div>";
				}
				if(isset($success)) {
					echo "<div class=\"span-10 push-6 success\">".$success."</div>";
				}
				if(isset($errors)) {
					echo "<div class=\"span-10 push-6 error\">";
					foreach($errors as $val) {
						echo $val."<br>";
					}
					echo "</div>";
				}
			?>
