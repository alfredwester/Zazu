<article class="row">
	<div class="span12">
		<header class="page-header">
				<h1>Plugins</h1>
		</header>
		<?php
		if($this->permission_handler->has_permission('upload', 'plugin', null)) {
			?>
			<input type="file" id="plugin-file-input" multiple accept="application/zip" style="display:none" onchange="handleFiles(this.files)">
			<nav id="plugin-dropzone" class="dropzone">
				<p class="dropzone-text lead muted">Drag files here or click to select and upload a new plugin</p>
			</nav>
			<?php
		}
		?>
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
						<th>Version</th>
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
						if($plugin_installed_version != $plugin_version) {
							$tr_class = "clickable warning";
						}
					}
					echo "<tr class=\"".$tr_class."\" ".$on_click." ><td>";
					// Delete not yet implemented in controller ( remove plugin files and folders)
					if(!$plugin_installed) {
						if($this->permission_handler->has_permission('delete', 'plugin', $plugin_name)) {
							echo " <a href=\"".BASE_PATH."/plugin/delete/".$plugin_dir_name."\" onclick=\"return confirm('Do you really want to delete this plugin?')\" title=\"Delete this plugin\"><i class=\"fa fa-trash\"></i></a>";
							$auth = true;
						}
						if($this->permission_handler->has_permission('install', 'plugin', $plugin_name)) {
							echo " <a href=\"".BASE_PATH."/plugin/install/".$plugin_name."\" title=\"Install this plugin\"><i class=\"fa fa-plus-square\"></i></a>";
							$auth = true;
						}
					}
					elseif($plugin_installed) {
						if($this->permission_handler->has_permission('uninstall', 'plugin', $plugin_id)) {
							echo " <a href=\"".BASE_PATH."/plugin/uninstall/".$plugin_name."\" onclick=\"return confirm('Do you really want to unistall this plugin?')\" title=\"Unistall this plugin\"><i class=\"fa fa-minus-square\"></i></a>";
							$auth = true;
						}
						// TODO: update plugin not implemented in controller.
						if($plugin_installed_version != $plugin_version && $this->permission_handler->has_permission('update', 'plugin', $plugin_id)) {
							echo " <a href=\"".BASE_PATH."/plugin/update/".$plugin_name."\" onclick=\"return confirm('Do you really want to update this plugin?')\" title=\"Update this plugin\"><i class=\"fa fa-repeat\"></i></a>";
							$auth = true;
						}
					}
				
					if(!$auth) {
						echo "<i class=\"fa fa-lock\" title=\"You have no permissions to manage this plugin\"></i>";
					}
					echo "</td><td>" . $plugin_name . "</td>";
					if($plugin_installed) {
						if($plugin_installed_version != $plugin_version) {
							echo "<td title='Installed version / file version'>" . $plugin_installed_version . "/" . $plugin_version . "</td>";
						} else {
							echo "<td title='Installed version'>" . $plugin_installed_version . "</td>";
						}
					} else {
						echo "<td title='File version'>" . $plugin_version . "</td>";
					}
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