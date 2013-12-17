<article class="row">
	<div class="span12">
		<header class="page-header">
			<h1><?php echo ucfirst($action);?> category</h1>
		</header>
		<section>
			<form action="<?php echo BASE_PATH;?>/admin/<?=$action;?>/category/<?=$category_id;?>" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="category_name">Category title</label>
					<div class="controls">
						<input type="text" class="span3" id="category_name" required value="<?=$category_name;?>" name="category_name"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="category_url">Category url</label>
					<div class="controls">
						<input type="text" class="span3" id="category_url" required value="<?=$category_url;?>" name="category_url"/>
					</div>
				</div>
				<div class="control-group">
					<nav class="controls">
						<button type="submit" class="btn btn-success">Save</button>
						<button type="button" class="btn" onclick="window.location='<?php echo BASE_PATH;?>/admin/categories/'">Cancel</button>
					</nav>
				</div>
			</form>
		</section>
	</div>
</article>
