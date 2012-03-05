			<article class="span-24">
				<div class="span-20">
					<form action="<?php echo BASE_PATH;?>/admin/save_settings/" method="post">
						<?php
						foreach($config as $key => $val) {
							echo "<label for=\"".$key."\">".ucfirst(str_ireplace('_', ' ', $key))."</label><br><input type=\"text\" required class=\"text\" id=\"".$key."\" value=\"".$val."\" name=\"".$key."\"/><br>";
						}
						?>
						<hr class="space"/>
						<div class="buttons">
							<button type="submit" class="positive" >Save</button>
							<button type="button" class="negative" onclick="window.location='<?php echo BASE_PATH;?>/admin/settings/'">Cancel</button>
						</div>
					</form>
				</div>
				<hr class="space" />
			</article>
