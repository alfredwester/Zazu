			<nav class="span-24 buttons">
				<a href="/admin/new_edit/region/" title="New region">New Region</a>
			</nav>
			<hr class="space">
			<article class="span-24">
				<?php
				if(isset($regions)) {
					?>
				<table>
					<caption>All existing regions</caption>
					<thead>
						<tr>
							<th class="span-1">Action</th>
							<th class="span-3">Title</th>
							<th class="span-20 last">Summary</th>
						</tr>
					</thead>
					<?php
					foreach($regions as $region_name => $region) {
						echo "<tr><td>";
						echo " <a href=\"/admin/new_edit/region/".$region['region_id']."\"><img src=\"/theme/admin/images/icons/pencil.png\"></a>";
						echo " <a href=\"/admin/delete/region/".$region['region_id']."\" onclick=\"return confirm('Do you really want to delete this region?')\"><img src=\"/theme/admin/images/icons/delete.png\"></a></td>";
						echo "<td><strong>".$region_name."</strong></td>";
						echo "<td>".mb_strcut($region['region_text'], 0, 200)."</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
				else {
					echo "<strong>No regions found</strong>";
				}
				?>
			</article>
