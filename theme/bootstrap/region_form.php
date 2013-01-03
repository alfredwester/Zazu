<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1><?php echo ucfirst($action);?> region</h1>
		</header>
		<section>
			<form action="<?php echo BASE_PATH;?>/admin/<?php echo $action;?>/region/<?php echo $region_id;?>" method="post"  >
				<div class="control-group">
					<label class="control-label" for="region_name">Region name</label>
					<input type="text" class="span3" id="region_name" autofocus required value="<?php echo $region_name;?>" name="region_name"/>
				</div>
				<div class="control-group">
					<textarea name="region_text" class="span8" rows="10" required  id="region_text" placeHolder="Text goes here..." >
						<?php echo htmlentities($region_text, ENT_QUOTES, 'UTF-8');?>
					</textarea>
				</div>
				<div class="control-group">
					<nav>
						<button type="submit" class="btn btn-success" >Save</button>
						<button type="button" class="btn" onclick="window.location='<?php echo BASE_PATH;?>/admin/regions/'">Cancel</button>
					</nav>
				</div>
			</form>
		</section>
	</div>
</article>
