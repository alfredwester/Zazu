<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
		<title>Administration --Zazu cms--</title>
		<meta name="description" content="This is the administration interface for Zazu cms" />
		<meta name="keyword" content="Admin, cms, mvc, zazu, administation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo BASE_PATH;?>/include/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen" />
		<link href="<?php echo BASE_PATH;?>/theme/bootstrap/css/zazu.css" rel="stylesheet" media="screen" />
		<?=$head;?>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<nav class="container">
					<a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse"></a>
					<a class="brand" href="#">Zazu Administration</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
						<?php
						foreach($admin_menu as $link) {
						?>
							<li><a href="<?php echo BASE_PATH.$link['menu_url'];?>" title="<?=$link['menu_title'];?>"><?=$link['menu_text'];?></a></li>
						<?php
						}
						?>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<div class="main container">
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
