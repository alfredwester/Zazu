<html>
    <head>
        <title><?=$title?></title>
		<meta name="description" content="<?=$meta_content?>">
		<meta name="keyword" content="<?=$meta_keyword?>">
        <link rel="stylesheet" href="/theme/default/css/blueprint/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="/theme/default/css/blueprint/print.css" type="text/css" media="print">
        <link rel="stylesheet" href="/theme/default/css/buttons.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="/theme/default/css/zazu.css" type="text/css" media="all">
        <!--[if lt IE 8]>
        <link rel="stylesheet" href="/theme/default/css/blueprint/ie.css" type="text/css" media="screen, projection">
        <![endif]-->
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

