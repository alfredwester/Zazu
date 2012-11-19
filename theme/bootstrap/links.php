			<nav class="span-24 buttons">
				<a href="<?php echo BASE_PATH;?>/admin/new_edit/link/" title="New link">New link</a>
			</nav>
			<hr class="space">
			<article class="span-24">
				<?php
				if(isset($links)) {
					?>
				<table>
					<caption>All existing menu links</caption>
					<thead>
						<tr>
							<th class="span-1">Action</th>
							<th class="span-4">text</th>
							<th class="span-9">title</th>
							<th class="span-8">url</th>
							<th class="span-1">group</th>
							<th class="span-1 last">order</th>
						</tr>
					</thead>
					<?php
					foreach($links as $link) {
						extract($link);
						$auth = false;
						echo "<tr><td>";
						if($this->permission_handler->has_permission('update', 'link', $link_id)) {
							echo " <a href=\"".BASE_PATH."/admin/new_edit/link/".$link_id."\"  title=\"Edit this link\"><img src=\"".BASE_PATH."/theme/admin/images/icons/pencil.png\"></a>";
							$auth = true;
						}
						if($this->permission_handler->has_permission('delete', 'link', $link_id)) {
							echo " <a href=\"".BASE_PATH."/admin/delete/link/".$link_id."\" title=\"Delete this link\" onclick=\"return confirm('Do you really want to delete this menu link?')\"><img src=\"".BASE_PATH."/theme/admin/images/icons/delete.png\"></a></td>";
							$auth = true;
						}
						if(!$auth) {
							echo "<img src=\"".BASE_PATH."/theme/admin/images/icons/lock.png\" title=\"You have no permissions to manage this link\">";
						}
						echo "<td><strong>".$link_text."</strong></td>";
						echo "<td>".$link_title."</td>";
						echo "<td>".$link_url."</td>";
						echo "<td>".$link_group."</td>";
						echo "<td>".$link_order."</td>";
						echo "</tr>";
						
					}
					echo "</table>";
				}
				else {
					echo "<strong>No links found</strong>";
				}
				?>
			</article>