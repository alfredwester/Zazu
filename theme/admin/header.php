<html>
    <head>
        <title>Administration --Zazu cms--</title>
		<meta name="description" content="This is the administration interface for Zazu cms" />
		<meta name="keyword" content="Admin, cms, mvc, zazu, administation" />
		<link rel="stylesheet" href="/theme/default/css/blueprint/screen.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="/theme/default/css/blueprint/print.css" type="text/css" media="print">
		<link rel="stylesheet" href="/theme/default/css/buttons.css" type="text/css" media="screen, projection">
		<!--[if lt IE 8]>
		<link rel="stylesheet" href="/theme/default/css/blueprint/ie.css" type="text/css" media="screen, projection">
		<![endif]-->
		<link rel="stylesheet" href="/theme/default/css/zazu.css" type="text/css" media="all">
		<?=$head;?>
	</head>
    <body>
        <div class="container">
            <header class="header span-24">
                <h4>Zazu Administration</h4>
            </header>
            <nav class="span-24 menu buttons">
                <?php
				foreach($admin_menu as $link) {
				?>
					<a href="<?=$link['menu_url'];?>" title="<?=$link['menu_title'];?>"><?=$link['menu_text'];?></a>
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

