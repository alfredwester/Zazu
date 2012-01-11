			<article class="span-24">
				<div class="span-20">
					<form action="/admin/<?=$action;?>/region/<?=$region_id;?>" method="post">
						<label for="region_name">Region name</label><br>
						<input type="text" class="title" id="region_name" value="<?=$region_name;?>" name="region_name"/><br>
						<div class="span-20">
							<textarea name="region_text" class="span-20" id="region_text" >
								<?php echo htmlentities($region_text, ENT_QUOTES, 'UTF-8');?>
							</textarea>
						</div>
						<hr class="space"/>
						<div class="buttons">
							<button type="submit" class="positive" >Save</button>
							<button type="button" class="negative" onclick="window.location='/admin/regions/'">Cancel</button>
							<button type="button" onclick="tinymce.execCommand('mceToggleEditor',false,'region_text');" class="">Toggle editor</button>
						</div>
					</form>
				</div>
				<hr class="space" />
			</article>
