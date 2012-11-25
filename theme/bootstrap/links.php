<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1>Links</h1>
		</header>
		<nav>
			<?php
			if($this->permission_handler->has_permission('create', 'link', null)) {
				echo "<a href=\"".BASE_PATH."/admin/new_edit/link/\" class=\"btn btn-primary\" title=\"New link\">New link</a>";
			}
			else {
				echo "<span class=\"quiet\">You don't have permission to create new links</span>";
			}
			?>
		</nav>
		<section>
			<?php
			if(isset($links)) {
				?>
			<table class="table table-striped">
				<caption>All existing menu links</caption>
				<thead>
					<tr>
						<th>Action</th>
						<th>Text</th>
						<th>Title</th>
						<th>Url</th>
						<th>Group</th>
						<th>Order</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($links as $link) {
					extract($link);
					$auth = false;
					echo "<tr><td>";
					if($this->permission_handler->has_permission('update', 'link', $link_id)) {
						echo " <a href=\"".BASE_PATH."/admin/new_edit/link/".$link_id."\"  title=\"Edit this link\"><i class=\"icon-pencil\"></i></a>";
						$auth = true;
					}
					if($this->permission_handler->has_permission('delete', 'link', $link_id)) {
						echo " <a href=\"".BASE_PATH."/admin/delete/link/".$link_id."\" title=\"Delete this link\" onclick=\"return confirm('Do you really want to delete this menu link?')\"><i class=\"icon-trash\"></i></a></td>";
						$auth = true;
					}
					if(!$auth) {
						echo "<i class=\"icon-lock\" title=\"You have no permissions to manage this link\"></i>";
					}
					echo "<td><strong>".$link_text."</strong></td>";
					echo "<td>".$link_title."</td>";
					echo "<td>".$link_url."</td>";
					echo "<td>".$link_group."</td>";
					echo "<td>".$link_order."</td>";
					echo "</tr>";
					
				}
				echo "</tbody></table>";
			}
			else {
				echo "<strong>No links found</strong>";
			}
			?>
		</section>
	</div>
</article>
