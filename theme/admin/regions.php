			<nav class="span-24 buttons">
				<?php
				if($this->permission_handler->has_permission('create', 'region', null)) {
					echo "<a href=\"".BASE_PATH."/admin/new_edit/region/\" title=\"New region\">New Region</a>";
				}
				else {
					echo "<span class=\"quiet\">You don't have permission to create new regions</span>";
				}
				?>
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
						$auth = false;
						echo "<tr><td>";
						if($this->permission_handler->has_permission('update', 'region', $region['region_id'])) {
							echo " <a href=\"".BASE_PATH."/admin/new_edit/region/".$region['region_id']."\"><img src=\"".BASE_PATH."/theme/admin/images/icons/pencil.png\"></a>";
							$auth = true;
						}
						if($this->permission_handler->has_permission('delete', 'region', $region['region_id'])) {
							echo " <a href=\"".BASE_PATH."/admin/delete/region/".$region['region_id']."\" onclick=\"return confirm('Do you really want to delete this region?')\"><img src=\"".BASE_PATH."/theme/admin/images/icons/delete.png\"></a></td>";
							$auth = true;
						}
						if(!$auth) {
							echo "<img src=\"".BASE_PATH."/theme/admin/images/icons/lock.png\" title=\"You have no permissions to manage this region\">";
						}
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