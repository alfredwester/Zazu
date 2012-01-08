			<div class="span-7 colborder">
				<p><?=$reg_top1;?></p>
			</div>
			<div class="span-7 colborder">
				<p><?=$reg_top2;?></p>
			</div>
			<div class="span-7 last">
				<p><?=$reg_top3;?></p>
			</div>
			<hr>
			<article class="span-17 prepend-1 colborder">
				<?php
				if(isset($posts)) {
					foreach($posts as $post) {
						echo "<h3><a href=\"".$post['post_url']."\" title=\"".$post['post_title']."\">".$post['post_title']."</a></h3>";
						echo "<p>".$post['post_content']."</p>";
					}
				}
				else {
					echo "<h1>".$post_title."</h1>";
					echo "<p>".$post_content."</p>";
				}
				?>
			</article>
