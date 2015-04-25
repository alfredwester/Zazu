<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1>Plugins</h1>
		</header>
		<!-- <nav> -->
			<?php
			/*if($this->permission_handler->has_permission('upload', 'plugin', null)) {
				echo "<a class=\"btn btn-primary disabled\" href=\"#\" title=\"Upload plugin\">Upload plugin</a>";
			}*/
			?>
		<!-- </nav> -->
		<section>
			<?php
			if(isset($plugins)) {
				?>
			<table class="table table-striped table-hover">
				<caption>All existing plugins</caption>
				<thead>
					<tr>
						<th>Action</th>
						<th>Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
				<?php
				
				foreach($plugins as $plugin) {
					extract($plugin);
					$auth = false;
					$tr_class = "error";
					$on_click = "";
					if($plugin_installed) {
						$tr_class = "clickable success";
						$on_click = "onclick=\"location.href='/admin/plugin/".$plugin_name."'\"";
					}
					echo "<tr class=\"".$tr_class."\" ".$on_click." ><td>";
					// Delete not yet implemented in controller ( remove plugin files and folders)
					/*if($this->permission_handler->has_permission('delete', 'plugin', $plugin_name)) {
						echo " <a href=\"".BASE_PATH."/plugin/delete/".$plugin_name."\" onclick=\"return confirm('Do you really want to delete this plugin?')\" title=\"Delete this plugin\"><i class=\"fa fa-trash-o\"></i></a>";
						$auth = true;
					}*/
					if($plugin_installed && $this->permission_handler->has_permission('uninstall', 'plugin', $plugin_id)) {
						echo " <a href=\"".BASE_PATH."/plugin/uninstall/".$plugin_name."\" onclick=\"return confirm('Do you really want to unistall this plugin?')\" title=\"Unistall this plugin\"><i class=\"fa fa-minus-square\"></i></a>";
						$auth = true;
					}
					if($this->permission_handler->has_permission('install', 'plugin', $plugin_name) && !$plugin_installed) {
						echo " <a href=\"".BASE_PATH."/plugin/install/".$plugin_name."\" title=\"Install this plugin\"><i class=\"fa fa-plus-square\"></i></a>";
						$auth = true;
					}
					if(!$auth) {
						echo "<i class=\"fa fa-lock\" title=\"You have no permissions to manage this plugin\"></i>";
					}
					echo "</td><td>".$plugin_name;
					echo "</td><td>".$plugin_description;
					echo "</tr>";
				}
				echo "</tbody></table>";
			}
			else {
				echo "<strong>No plugins found</strong>";
			}
			?>
		</section>
	</div>
</article>