			<article class="span-24">
				<div class="span-20">
					<form action="<?php echo BASE_PATH;?>/admin/save_user_profile" method="post">
						<label for="user_username">Username</label><br>
						<input type="text" class="title" id="user_username" autofocus required value="<?=$user_username;?>" name="user_username"/><br>
						<label for="user_realname">Full name</label><br>
						<input type="text" class="title" id="user_realname" required value="<?=$user_realname;?>" name="user_realname"/><br>
						<label for="user_password">Password <span class="quiet">(Showing encrypted password, change only if you want to change password)</span> </label><br>
						<input type="text" class="title" id="user_password" required value="<?=$user_password;?>" name="user_password"/><br>
						<label for="user_email">Email</label><br>
						<input type="email" class="title" id="user_email" required value="<?=$user_email;?>" name="user_email"/><br>
						<hr class="space"/>
						<div class="buttons">
							<button type="submit" class="positive" >Save</button>
						</div>
					</form>
				</div>
				<hr class="space" />
			</article>
