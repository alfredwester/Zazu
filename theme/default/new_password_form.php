<article class="span-24">
	<div class="span-20">
		<form action="<?php echo BASE_PATH;?>/login/new_password" method="post">
			<label for="pass1">Enter new password</label><br>
			<input type="password" class="title" autofocus required id="pass1" name="pass1"/><br>
			<label for="pass2">Reenter password</label><br>
			<input type="password" class="title" required id="pass2" name="pass2"/><br>
			<input type="hidden" name="email" value="<?php echo $email;?>">
			<input type="hidden" name="magic_link" value="<?php echo $magic_link;?>">
			<hr class="space"/>
			<div class="buttons">
				<button type="submit" >Send</button>
			</div>
		</form>
	</div>
<hr class="space" />
</article>