<article class="row">
	<div class="span12">
		<header class="page-header">
			<h1><?php echo ucfirst($action);?> link</h1>
		</header>
		<section>
			<form action="<?php echo BASE_PATH;?>/admin/<?=$action;?>/link/<?=$link_id;?>" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="link_text">Link text</label>
					<div class="controls">
						<input type="text" class="span3" id="link_text" autofocus required value="<?=$link_text;?>" name="link_text"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="link_title">Link title</label>
					<div class="controls">
						<input type="text" class="span3" id="link_title" required value="<?=$link_title;?>" name="link_title"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="link_url">Link url</label>
					<div class="controls">
						<input type="text" class="span3" id="link_url" required value="<?=$link_url;?>" name="link_url"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="link_group">Link group</label>
					<div class="controls">
						<input type="text" class="span3" id="link_group" required value="<?=$link_group;?>" name="link_group"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="link_order">Link order</label>
					<div class="controls">
						<input type="text" class="span3" id="link_order" required value="<?=$link_order;?>" name="link_order"/>
					</div>
				</div>
				<div class="control-group">
					<nav class="controls">
						<button type="submit" class="btn btn-success">Save</button>
						<button type="button" class="btn" onclick="window.location='<?php echo BASE_PATH;?>/admin/links/'">Cancel</button>
					</nav>
				</div>
			</form>
		</section>
	</div>
</article>
