			<article class="span-24">
				<div class="span-20">
					<form action="<?php echo BASE_PATH;?>/admin/<?=$action;?>/post/<?=$post_id;?>" method="post">
						<label for="title">Title</label><br>
						<input type="text" class="title" id="title" required autofocus value="<?=$post_title;?>" name="post_title"/><br>
						<label for="url">Url</label><br>
						<input type="text" class="text" id="url" required value="<?=$post_url;?>" name="post_url"/><br>
						<div class="span-15">
							<label for="meta_content">Meta keyword</label><br>
							<input type="text" class="text span-15" required value="<?=$post_meta_keyword?>" name="post_meta_keyword"/>
							<label for="meta_content">Meta content</label><br>
							<input type="text" class="text span-15" required value="<?=$post_meta_content?>" name="post_meta_content"/>
						</div>
						<div class="span-20">
							<textarea name="post_content" class="span-20" required id="post_content" ><?php echo htmlentities($post_content, ENT_QUOTES, "UTF-8");?></textarea>
						</div>
						<hr class="space"/>
						<div class="buttons">
							<button type="submit" class="positive" >Save</button>
							<button type="button" class="negative" onclick="window.location='<?php echo BASE_PATH;?>/admin/'">Cancel</button>
							<button type="button" onclick="tinymce.execCommand('mceToggleEditor',false,'post_content');" class="">Toggle editor</button>
						</div>
					</form>
				</div>
				<hr class="space" />
			</article>
