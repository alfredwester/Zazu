<article class="row">
	<div class="span12">
		<header class="page-header">
			<h1>Website settings</h1>
		</header>
		<form action="<?php echo BASE_PATH;?>/admin/save_settings/" method="post" class="form-horizontal">
			<?php
			foreach($config as $key => $val) {
				echo "<div class=\"control-group\"> <label class=\"control-label\" for=\"".$key."\">".ucfirst(str_ireplace('_', ' ', $key))."</label> <div class=\"controls\"> <input type=\"text\" class=\"span3\" id=\"".$key."\" value=\"".$val."\" name=\"".$key."\" /></div></div>";
			}
			?>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-success" >Save</button>
					<button type="button" class="btn" onclick="window.location='<?php echo BASE_PATH;?>/admin/settings/'">Cancel</button>
				</div>
			</div>
		</form>
	</div>
</article>
