			<article class="span-17 prepend-1 colborder">
				<?php
				if(isset($posts)) {
					foreach($posts as $post) {
						$date = new DateTime($post['post_date']);
						echo "<h3><a href=\"".$post['post_url']."\" title=\"".$post['post_title']."\">".$post['post_title']."</a></h3>";
						echo "<p class=\"small\" >Posted ".$date->format('Y-m-d H:i')." in <a href=\"".$post['post_category_url']."\" title=\"Go to category ".$post['post_category_name']."\" >".$post['post_category_name']."</a>
						by ".$post['post_author_name']."</p>";
						echo "<p>".$post['post_content']."</p>";
					}
				}
				else {
					echo "<h1>".$post_title."</h1>";
					echo "<p>".$post_content."</p>";
				}
				?>
			</article>
