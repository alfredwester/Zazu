<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1>Categories</h1>
		</header>
		<nav>
			<?php
			if($this->permission_handler->has_permission('create', 'category', null)) {
				echo "<a href=\"".BASE_PATH."/admin/new_edit/category/\" class=\"btn btn-primary\"title=\"New category\">New Category</a>";
			}
			else {
				echo "<span class=\"quiet\">You don't have permission to create new categories</span>";
			}
			?>
		</nav>
		<section>
			<?php
			if(isset($categories)) {
				?>
			<table class="table table-striped">
				<caption>All existing categories</caption>
				<thead>
					<tr>
						<th>Action</th>
						<th>Name</th>
						<th>Url</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($categories as $category_name => $category) {
					$auth = false;
					echo "<tr><td>";
					if($this->permission_handler->has_permission('update', 'category', $category['category_id'])) {
						echo " <a href=\"".BASE_PATH."/admin/new_edit/category/".$category['category_id']."\"><i class=\"fa fa-pencil\"></i></a>";
						$auth = true;
					}
					if($this->permission_handler->has_permission('delete', 'category', $category['category_id'])) {
						echo " <a href=\"".BASE_PATH."/admin/delete/category/".$category['category_id']."\" onclick=\"return confirm('Do you really want to delete this category?')\"><i class=\"fa fa-trash\"></i></a></td>";
						$auth = true;
					}
					if(!$auth) {
						echo "<i class=\"fa fa-lock\" title=\"You have no permissions to edit this category\"></i>";
					}
					echo "<td><strong>".$category_name."</strong></td>";
					echo "<td>".$category['category_url']."</td>";
					echo "</tr>";
				}
				echo "</tbody></table>";
			}
			else {
				echo "<strong>No categories found</strong>";
			}
			?>
		</section>
	</div>
</article>
