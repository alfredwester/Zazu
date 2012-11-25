<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1>Users</h1>
		</header>
		<nav>
			<?php
			if($this->permission_handler->has_permission('create', 'region', null)) {
				echo "<a href=\"".BASE_PATH."/admin/new_edit/user/\" class=\"btn btn-primary\" title=\"New user\">New user</a>";
			} else {
				echo "<span class=\"quiet\">You don't have permission to create new users</span>";
			}
			?>
		</nav>
		<section>
			<?php
			if(isset($users)) {
			?>
			<table class="table table-striped">
				<caption>All existing users</caption>
				<thead>
					<tr>
						<th>Action</th>
						<th>Username</th>
						<th>Real name</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($users as $user) {
					extract($user);
					$auth = false;
					echo "<tr><td>";
					if($this->permission_handler->has_permission('update', 'user', $user_id)) {
						echo " <a href=\"".BASE_PATH."/admin/new_edit/user/".$user_id."\"><i class=\"icon-pencil\"></i></a>";
						$auth = true; 
					}
					if($this->permission_handler->has_permission('delete', 'user', $user_id)) {
						echo " <a href=\"".BASE_PATH."/admin/delete/user/".$user_id."\" onclick=\"return confirm('Do you really want to delete this region?')\"><i class=\"icon-trash\"></i></a></td>";
						$auth = true;
					}
					if(!$auth) {
						echo "<i class=\"icon-lock\" title=\"You have no permissions to manage this user\"></i>";
					}
					echo "<td><strong>".$user_username."</strong></td>";
					echo "<td>".$user_realname."</td>";
					echo "<td>".$user_email."</td>";
					echo "</tr>";
				}
				echo "</tbody></table>";
			}
			else {
				echo "<strong>No users found</strong>";
			}
			?>
		</section>
	</div>
</article>
