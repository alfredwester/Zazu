			<article class="span-24">
				<div class="span-20">
					<form action="/admin/<?=$action;?>/user/<?=$user_id;?>" method="post">
						<label for="user_username">Username</label><br>
						<input type="text" class="title" id="user_username" value="<?=$user_username;?>" name="user_username"/><br>
						<label for="user_realname">Real name</label><br>
						<input type="text" class="title" id="user_realname" value="<?=$user_realname;?>" name="user_realname"/><br>
						<label for="user_password">Password</label><br>
						<input type="text" class="title" id="user_password" value="<?=$user_password;?>" name="user_password"/><br>
						<label for="user_email">Email</label><br>
						<input type="text" class="title" id="user_email" value="<?=$user_email;?>" name="user_email"/><br>
						<hr class="space"/>
						<div class="buttons">
							<button type="submit" class="positive" >Save</button>
							<button type="button" class="negative" onclick="window.location='/admin/users/'">Cancel</button>
						</div>
					</form>
				</div>
				<hr class="space" />
			</article>
