			<article class="span-24">
				<div class="span-20">
					<form action="<?php echo BASE_PATH;?>/admin/<?=$action;?>/link/<?=$link_id;?>" method="post">
						<label for="link_text">Link text</label><br>
						<input type="text" class="title" id="link_text" autofocus required value="<?=$link_text;?>" name="link_text"/><br>
						<label for="link_title">Link title</label><br>
						<input type="text" class="text" id="link_title" required value="<?=$link_title;?>" name="link_title"/><br>
						<label for="link_url">Link url</label><br>
						<input type="text" class="text" id="link_url" required value="<?=$link_url;?>" name="link_url"/><br>
						<label for="link_group">Link group</label><br>
						<input type="text" class="text" id="link_group" required value="<?=$link_group;?>" name="link_group"/><br>
						<label for="link_order">Link order</label><br>
						<input type="text" class="text" id="link_order" required value="<?=$link_order;?>" name="link_order"/><br>
						<hr class="space"/>
						<div class="buttons">
							<button type="submit" class="positive" >Save</button>
							<button type="button" class="negative" onclick="window.location='<?php echo BASE_PATH;?>/admin/links/'">Cancel</button>
						</div>
					</form>
				</div>
				<hr class="space" />
			</article>
