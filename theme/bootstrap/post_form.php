<article class="row">
	<div class="span12">
		<header class="page-header">
			<h1><?php echo ucfirst($action);?> post</h1>
		</header>
		<section>
			
			<form action="<?php echo BASE_PATH;?>/admin/<?php echo $action;?>/post/<?php echo $post_id;?>" method="post" >
				<div class="control-group">
					<label class="control-label" for="title">Title</label>
					<div class="controls">
						<input type="text" class="span3" id="title" required autofocus value="<?php echo $post_title;?>" name="post_title"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="category">Category</label>
					<div class="controls">
						<select id="category" name="post_category" class="span3" required >
							<?php
							foreach ($categories as $name => $value) {
								$selected = "";
								if($post_category == $value['category_id']) {
									$selected = "selected=\"selected\"";
								}
								echo "<option value=\"".$value['category_id']."\" ".$selected.">".$name."</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="accordion" id="advanced-fields">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" tabindex="-1" data-parent="#advanced-fields" href="#collapseOne">Advanced <i class="fa fa-caret-down"></i></a>
						</div>
						<div id="collapseOne" class="accordion-body collapse">
							<div class="accordion-inner">
								<div class="control-group">
									<label class="control-label" for="url">Url</label>
									<div class="controls">
										<input type="text" class="span3" id="url" tabindex="-1" required value="<?php echo $post_url;?>" name="post_url"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="post_meta_keyword">Meta keyword (used by search engines)</label>
									<div class="controls">
										<input type="text" class="span5" tabindex="-1" value="<?php echo (isset($post_meta_keyword)? $post_meta_keyword : '')?>" name="post_meta_keyword"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="post_meta_content">Meta content (used by search engines)</label>
									<div class="controls">
										<input type="text" class="span5" tabindex="-1" value="<?php echo (isset($post_meta_content)? $post_meta_content : '')?>" name="post_meta_content"/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<textarea name="post_content" class="span12" rows="12" id="post_content" ><?php echo htmlentities($post_content, ENT_QUOTES, "UTF-8");?></textarea>
				</div>
				<div class="control-group">
					<nav>
					<button type="submit" class="btn btn-success" >Save</button>
					<button type="button" class="btn" onclick="window.location='<?php echo BASE_PATH;?>/admin/'">Cancel</button>
					</nav>
				</div>
			</form>
		</section>
	</div>
</article>
