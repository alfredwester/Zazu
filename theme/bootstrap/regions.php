<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1>Regions</h1>
		</header>
		<nav>
			<?php
			if($this->permission_handler->has_permission('create', 'region', null)) {
				echo "<a href=\"".BASE_PATH."/admin/new_edit/region/\" class=\"btn btn-primary\"title=\"New region\">New Region</a>";
			}
			else {
				echo "<span class=\"quiet\">You don't have permission to create new regions</span>";
			}
			?>
		</nav>
		<section>
			<?php
			if(isset($regions)) {
				?>
			<table class="table table-striped">
				<caption>All existing regions</caption>
				<thead>
					<tr>
						<th>Action</th>
						<th>Title</th>
						<th>Summary</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($regions as $region_name => $region) {
					$auth = false;
					echo "<tr><td>";
					if($this->permission_handler->has_permission('update', 'region', $region['region_id'])) {
						echo " <a href=\"".BASE_PATH."/admin/new_edit/region/".$region['region_id']."\"><i class=\"icon-pencil\"></i></a>";
						$auth = true;
					}
					if($this->permission_handler->has_permission('delete', 'region', $region['region_id'])) {
						echo " <a href=\"".BASE_PATH."/admin/delete/region/".$region['region_id']."\" onclick=\"return confirm('Do you really want to delete this region?')\"><i class=\"icon-trash\"></i></a></td>";
						$auth = true;
					}
					if(!$auth) {
						echo "<i class=\"icon-lock\" title=\"You have no permissions to edit this region\"></i>";
					}
					echo "<td><strong>".$region_name."</strong></td>";
					echo "<td>".mb_strcut(strip_tags($region['region_text']), 0, 200)."</td>";
					echo "</tr>";
				}
				echo "</tbody></table>";
			}
			else {
				echo "<strong>No regions found</strong>";
			}
			?>
		</section>
	</div>
</article>
