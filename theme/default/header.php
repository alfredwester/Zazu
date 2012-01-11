<html>
	<head>
		<title><?=$title?></title>
		<meta name="description" content="<?=$meta_content?>">
		<meta name="keyword" content="<?=$meta_keyword?>">
		<link rel="stylesheet" href="/include/blueprint/screen.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="/include/blueprint/print.css" type="text/css" media="print">
		<!--[if lt IE 8]>
		<link rel="stylesheet" href="/include/blueprint/ie.css" type="text/css" media="screen, projection">
		<![endif]-->
		<link rel="stylesheet" href="/theme/default/css/buttons.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="/theme/default/css/zazu.css" type="text/css" media="all">
		<?=$head?>
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
				if(isset($success)) {
					echo "<div class=\"span-8 push-8 success\">".$success."</div>";
				}
				if(isset($errors)) {
					echo "<div class=\"span-8 push-8 error\">";
					foreach($errors as $val) {
						echo $val."<br>";
					}
					echo "</div>";
				}
			?>