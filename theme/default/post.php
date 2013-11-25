			<article class="span-17 prepend-1 colborder">
				<?php
				echo "<h1><a href=\"".$post_url."\" title=\"".$post_title."\">".$post_title."</a></h1>";
				$date = new DateTime($post_date);
				echo "<p class=\"small\" >Posted ".$date->format('Y-m-d H:i')." in <a href=\"".$post_category_url."\" title=\"Go to category ".$post_category_name."\" >".$post_category_name."</a>
				by ".$post_author_name."</p>";
				echo $post_content;
				?>
			</article>
