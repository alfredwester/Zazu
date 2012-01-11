			<nav class="span-24 buttons">
				<a href="/admin/new_edit/post/" title="New post">New Post</a>
			</nav>
			<hr class="space">
			<article class="span-24">
				<?php
				if(isset($posts)) {
					?>
				<table>
					<caption>All existing posts</caption>
					<thead>
						<tr>
							<th class="span-1">Action</th>
							<th class="span-3">Title</th>
							<th class="span-20 last">Summary</th>
						</tr>
					</thead>
					<?php
					foreach($posts as $post) {
						echo "<tr><td>";
						echo " <a href=\"/admin/new_edit/post/".$post['post_id']."\"><img src=\"/theme/admin/images/icons/pencil.png\"></a>";
						echo " <a href=\"/admin/delete/post/".$post['post_id']."\" onclick=\"return confirm('Do you really want to delete this post?')\"><img src=\"/theme/admin/images/icons/delete.png\"></a></td>";
						echo "<td><strong><a href=\"/".$post['post_url']."\" title=\"Go to ".$post['post_title']."\">".$post['post_title']."</a></strong></td>";
						echo "<td>".mb_strcut($post['post_content'], 0, 200)."</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
				else {
					echo "<strong>No posts found</strong>";
				}
				?>
			</article>
