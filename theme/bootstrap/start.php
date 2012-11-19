<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1>Posts</h1>
		</header>
		<nav>
			<?php
			if($this->permission_handler->has_permission('create', 'post', null)) {
				echo "<a class=\"btn btn-primary\" href=\"".BASE_PATH."/admin/new_edit/post/\" title=\"New post\">New Post</a>";
			}
			?>
		</nav>
		<section>
			<?php
			if(isset($posts)) {
				?>
			<table class="table table-striped">
				<caption>All existing posts</caption>
				<thead>
					<tr>
						<th>Action</th>
						<th>Author</th>
						<th>Title</th>
						<th>Summary</th>
					</tr>
				</thead>
				<tbody>
				<?php
				
				foreach($posts as $post) {
					extract($post);
					$auth = false;
					echo "<tr><td>";
					if($this->permission_handler->has_permission('update', 'post', $post_id)) {
						echo " <a href=\"".BASE_PATH."/admin/new_edit/post/".$post_id."\"><i class=\"icon-pencil\"></i></a>";
						$auth = true;
					}
					if($this->permission_handler->has_permission('delete', 'post', $post_id)) {
						echo " <a href=\"".BASE_PATH."/admin/delete/post/".$post_id."\" onclick=\"return confirm('Do you really want to delete this post?')\"><i class=\"icon-trash\"></i></a>";
						$auth = true;
					}
					if(!$auth) {
						echo "<i class=\"icon-lock\" title=\"You have no permissions to edit this post\"></i>";
					}
					echo "</td><td>".$post_author_name;
					echo "</td><td><strong><a href=\"".BASE_PATH."/".$post_url."\" title=\"Go to ".$post_title."\">".$post_title."</a></strong></td>";
					echo "<td>".mb_strcut(strip_tags($post_content), 0, 200)."</td>";
					echo "</tr>";
				}
				echo "</tbody></table>";
			}
			else {
				echo "<strong>No posts found</strong>";
			}
			?>
		</section>
	</div>
</article>
