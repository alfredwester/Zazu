			<nav class="span-24 buttons">
				<a href="/admin/new_edit/link/" title="New link">New link</a>
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
						echo "<tr><td>";
						echo " <a href=\"/admin/new_edit/link/".$link_id."\"><img src=\"/theme/admin/images/icons/pencil.png\"></a>";
						echo " <a href=\"/admin/delete/link/".$link_id."\" onclick=\"return confirm('Do you really want to delete this menu link?')\"><img src=\"/theme/admin/images/icons/delete.png\"></a></td>";
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