<article class="row">
	<div class="span12">
		<header class="page-header">
			<h1><?php echo ucfirst($action);?> user</h1>
		</header>
		<section>
			<form action="<?php echo BASE_PATH;?>/admin/<?=$action;?>/user/<?=$user_id;?>" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="user_username">Username</label>
					<div class="controls">
						<input type="text" class="span3" id="user_username" autofocus required value="<?=$user_username;?>" name="user_username"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="user_realname">Full name</label>
					<div class="controls">
						<input type="text" class="span3" id="user_realname" required value="<?=$user_realname;?>" name="user_realname"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="user_password">Password</label>
					<div class="controls">
						<input type="password" class="span3" id="user_password" required value="<?=$user_password;?>" name="user_password"/> 
						<?php 
						if($action == "edit") {
							echo "<span class=\"help-block\">Showing encrypted password, change only if you want to change password</span>";
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="user_role">Role</label>
					<div class="controls">
						<select class="span3" name="user_role" required>
							<?php
							foreach($roles as $role) {
								extract($role);
								$selected = "";
								if($role_id == $user_role) {
									$selected = "selected=\"selected\"";
								}
								echo "<option span3=\"".$role_description."\" value=\"".$role_id."\" ".$selected.">".$role_name."</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="user_email">Email</label>
					<div class="controls">
						<input type="email" class="span3" id="user_email" required value="<?=$user_email;?>" name="user_email"/>
					</div>
				</div>
				<div class="control-group">
					<nav class="controls">
						<button type="submit" class="btn btn-success" >Save</button>
						<button type="button" class="btn" onclick="window.location='<?php echo BASE_PATH;?>/admin/users/'">Cancel</button>
					</nav>
				</div>
			</form>
		</section>
	</div>
</article>
