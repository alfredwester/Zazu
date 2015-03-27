<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
		<title>Administration --Zazu cms--</title>
		<meta name="description" content="This is the administration interface for Zazu cms" />
		<meta name="keyword" content="Admin, cms, mvc, zazu, administation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo BASE_PATH;?>/include/stickyfooter/stickyfooter.css" rel="stylesheet" media="screen" />
		<link href="<?php echo BASE_PATH;?>/include/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo BASE_PATH;?>/include/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link href="<?php echo BASE_PATH;?>/theme/bootstrap/css/zazu.css" rel="stylesheet" media="screen" />
		<!--[if !IE 7]>
			<style type="text/css">
				#wrap {display:table;height:100%}
			</style>
		<![endif]-->

		<?php foreach ($head as $css) {
			echo "<link href=\"".BASE_PATH."/".$css."\" rel=\"stylesheet\" media=\"screen\" />";
		}

		?>
		
	</head>
	<body>
		<div id="wrap">
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<nav class="container">
						<a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="/admin">Zazu Administration</a>
						<div class="nav-collapse collapse">
							<ul class="nav">
							<?php
							foreach($admin_menu as $link) {
								if(isset($link['submenu'])) {
									echo "<li class=\"dropdown\">";
									echo "<a href=\"".BASE_PATH.$link['menu_url']."\" title=\"".$link['menu_title']."\" id=\"dLabel\" role=\"button\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" data-target=\"#\">".$link['menu_text']." <b class=\"caret\"></b></a>";
									echo "<ul class=\"dropdown-menu\"  role=\"menu\" aria-labelledby=\"dLabel\">";
									foreach ($link['submenu'] as $subLink) {
										if(isset($subLink['type'])  && $subLink['type'] == 'divider') {
											echo "<li class=\"divider\"></li>";
										} else {
											echo "<li><a href=\"".BASE_PATH.$subLink['menu_url']."\" title=\"".$subLink['menu_title']."\">".$subLink['menu_text']."</a></li>";
										}
									}
									echo "</ul>";
								} else {
									echo "<li>";
									echo "<a href=\"".BASE_PATH.$link['menu_url']."\" title=\"".$link['menu_title']."\">".$link['menu_text']."</a>";
									echo "</li>";
								}
							}
							?>
							</ul>
						</div>
					</nav>
				</div>
			</div>
			<div id="main" class="container">
				<?php
					if(isset($success)) {
						echo "<div class=\"row\"><div class=\"span4 offset4 alert alert-success\">".$success." <a href=\"#\" class=\"close\" data-dismiss=\"alert\">×</a></div></div>";
					}
					if(isset($notice)) {
						echo "<div class=\"row\"><div class=\"span4 offset4 alert\">".$notice."<a href=\"#\" class=\"close\" data-dismiss=\"alert\">×</a></div></div>";
					}
					if(isset($info)) {
						echo "<div class=\"row\"><div class=\"span4 offset4 alert alert-info\">".$info."<a href=\"#\" class=\"close\" data-dismiss=\"alert\">×</a></div></div>";
					}
					if(isset($errors)) {
						echo "<div class=\"row\"><div class=\"span4 offset4 alert alert-error\">";
						echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">×</a>";
						foreach($errors as $val) {
							echo $val."<br>";
						}
						echo "</div></div>";
					}
				?>
