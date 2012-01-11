			<nav class="span-24 buttons">
				<a href="/admin/new_edit/user/" title="New user">New user</a>
			</nav>
			<hr class="space">
			<article class="span-24">
				<?php
				if(isset($users)) {
					?>
				<table>
					<caption>All existing users</caption>
					<thead>
						<tr>
							<th class="span-1">Action</th>
							<th class="span-7">Username</th>
							<th class="span-8">Real name</th>
							<th class="span-8 last">Email</th>
						</tr>
					</thead>
					<?php
					foreach($users as $user) {
						echo "<tr><td>";
						echo " <a href=\"/admin/new_edit/user/".$user['user_id']."\"><img src=\"/theme/admin/images/icons/pencil.png\"></a>";
						echo " <a href=\"/admin/delete/user/".$user['user_id']."\" onclick=\"return confirm('Do you really want to delete this region?')\"><img src=\"/theme/admin/images/icons/delete.png\"></a></td>";
						echo "<td><strong>".$user['user_username']."</strong></td>";
						echo "<td>".$user['user_realname']."</td>";
						echo "<td>".$user['user_email']."</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
				else {
					echo "<strong>No users found</strong>";
				}
				?>
			</article>
