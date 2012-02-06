			<nav class="span-24 buttons">
				<a href="<?php echo BASE_PATH;?>/admin/new_edit/post/" title="New post">New Post</a>
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
							<th class="span-2">Author</th>
							<th class="span-3">Title</th>
							<th class="span-18 last">Summary</th>
						</tr>
					</thead>
					<?php
					foreach($posts as $post) {
						extract($post);
						echo "<tr><td>";
						if($post_author_id == $_SESSION['user_id'] || $_SESSION['user_role'] != 3) {
							echo " <a href=\"".BASE_PATH."/admin/new_edit/post/".$post_id."\"><img src=\"".BASE_PATH."/theme/admin/images/icons/pencil.png\"></a>";
							echo " <a href=\"".BASE_PATH."/admin/delete/post/".$post_id."\" onclick=\"return confirm('Do you really want to delete this post?')\"><img src=\"".BASE_PATH."/theme/admin/images/icons/delete.png\"></a>";
						}
						else {
							echo "<img src=\"".BASE_PATH."/theme/admin/images/icons/lock.png\" title=\"You have no permissions to manage this post\">";
						}
						echo "</td><td>".$post_author_name;
						echo "</td><td><strong><a href=\"".BASE_PATH."/".$post_url."\" title=\"Go to ".$post_title."\">".$post_title."</a></strong></td>";
						echo "<td>".mb_strcut(strip_tags($post_content), 0, 200)."</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
				else {
					echo "<strong>No posts found</strong>";
				}
				?>
			</article>
