<html>
	<head>
		<title><?=$title?></title>
	</head>
	<body>
		<h1>Start page</h1>

		<?php foreach($articles as $article){
			echo "<h3>".$article."</h3>";
		} 
		?>
	</body>
</html>
