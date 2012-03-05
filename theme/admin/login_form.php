			<article class="span-24">
				<div class="span-20">
					<form action="<?php echo BASE_PATH;?>/login/login" method="post">
						<label for="username">Username</label><br>
						<input type="text" class="title" id="username" name="username" autofocus required/><br>
						<label for="password">Password</label><br>
						<input type="password" class="title" id="password" name="password" required/><br>
						<span ><a href="/login/lost_password">Forgot password?</a></span>
						<hr class="space"/>
						<div class="buttons">
							<button type="submit" >Login</button>
						</div>
					</form>
				</div>
				<hr class="space" />
			</article>
