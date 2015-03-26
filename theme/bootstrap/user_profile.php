<article class="row">
	<div class="span12">
		<header class="page-header">
			<h1>User profile</h1>
		</header>
		<section>
			<form action="<?php echo BASE_PATH;?>/admin/save_user_profile" method="post" class="form-horizontal">
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
					<label class="control-label"  for="user_password">Password</label>
					<div class="controls">
						<input type="password" class="span3" id="user_password" required value="<?=$user_password;?>" name="user_password"/><span class="help-inline">(Change only if you want to change password)</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"  for="user_email">Email</label>
					<div class="controls">
						<input type="email" class="span3" id="user_email" required value="<?=$user_email;?>" name="user_email"/>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btn-primary" >Save</button>
					</div>
				</div>
			</form>
		</section>
	</div>
</article>
