<?php
$action = BASE_PATH."/admin/call_plugin_func/contact/add";
$name = "";
$email = "";
$submitBtnText = "Lägg till";
$cancelBtn = "";
$deleteBtn = "";
$id = 0;
if(isset($contact)) {
	$name = $contact['contact_name'];
	$email = $contact['contact_email'];
	$id = $contact['contact_id'];
	$action = BASE_PATH."/admin/call_plugin_func/contact/update/".$id;
	$deleteBtn = "<button type=\"button\" class=\"btn btn-danger contact-btn-delete\" data-id=\"".$id."\">Radera</button>";
	$cancelBtn = "<button type=\"button\" class=\"btn contact-btn-cancel\">Avbryt</button>";
	$submitBtnText = "Spara";
}
?>
<article>
	<div class="row">
		<div class="span12">
			<header class="page-header">
				<h1>Kontakter</h1>
			</header>
		</div>
	</div>
	<div class="row">
		<section class="span6">
			<form action="<?php echo $action;?>" method="post" >
				<div class="control-group">
					<label class="control-label" for="title">Namn:</label>
					<div class="controls">
						<input type="text" class="span4" required value="<?php echo $name;?>" name="contact_name"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="title">E-post:</label>
					<div class="controls">
						<input type="email" class="span4" required value="<?php echo $email;?>" name="contact_email"/>
					</div>
				</div>
				<div class="control-group">
					<button type="submit" class="btn btn-primary" ><?php echo $submitBtnText;?></button> <?php echo $cancelBtn;?> <?php echo $deleteBtn;?>
				</div>
			</form>
		</section>
		<section class="span6">
			<?php
			if(isset($contacts)) {
			?>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($contacts as $single_contact) { 
					extract($single_contact);
					$contact_active_class = "";
					if($contact_id == $id) {
						$contact_active_class = "info";
					}
					echo "<tr class='contact-row ".$contact_active_class."' data-id='".$contact_id."'><td>".$contact_name."</td>";
					echo "<td>".$contact_email."</td></tr>";
				}
				?>
				</tbody>
			</table>
			<?php
			} else {
				echo "<p>Inga kontakter har lagts till</p>";
			}
			?>
		</section>
	</div>
</article>