<?php
$action = BASE_PATH."/admin/call_plugin_func/calendar/add";
$title = "";
$date = date('Y-m-d');
$time = date('G:i');
$description = "";
$deleteBtn = "";
$submitBtnText = "Skapa";
$cancelBtn = "";
$id = 0;
if(isset($event)) {
	$action = BASE_PATH."/admin/call_plugin_func/calendar/update/".$event['event_id'];
	$title = $event['event_name'];
	$date = date('Y-m-d', strtotime($event['event_date']));
	$time = date('G:i', strtotime($event['event_date']));
	$description = $event['event_description'];
	$deleteBtn = "<button type=\"button\" class=\"btn btn-danger calendar_delete_event\" data-event-id=\"".$event['event_id']."\">Radera</button>";
	$cancelBtn = "<button type=\"button\" class=\"btn calendar_btn_cancel\">Avbryt</button>";
	$submitBtnText = "Spara";
	$id = $event['event_id'];
}
?>
<article>
	<div class="row">
		<div class="span12">
			<header class="page-header">
				<h1>Calendar</h1>
			</header>
		</div>
	</div>
	<div class="row">
		<section class="span6">
			<form action="<?php echo $action;?>" method="post" >
				<div class="control-group">
					<label class="control-label" for="title">Namn:</label>
					<div class="controls">
						<input type="text" class="span4" required value="<?php echo $title;?>" name="event_name"/>
					</div>
				</div>
				<div class="row">
					<div class="control-group span2">
						<label class="control-label" for="date">Datum:</label>
						<div class="controls">
							 <div class="input-append date" id="date" data-date="<?php echo $date; ?>" data-date-format="yyyy-mm-dd">
								<input value="<?php echo $date; ?>" type="text" name="event_date" required class="input-small" />
								<span class="add-on"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="control-group span2">
						<label class="control-label" for="time">Tid:</label>
						<div class="controls">
							 <div class="input-append bootstrap-timepicker">
								<input id="time" type="text" name="event_time" class="input-small" value="<?php echo $time;?>" required data-show-meridian="false" data-minute-step="15" />
								<span class="add-on"><i class="fa fa-clock-o"></i></span>
							</div>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="event_description">Beskrivning:</label>
					<div class="controls">
						<textarea id="event_description" name="event_description" class="span6" rows="10" ><?php echo $description;?></textarea>
					</div>
				</div>
				<div class="control-group">
					<button type="submit" class="btn btn-primary"><?php echo $submitBtnText;?></button> <?php echo $cancelBtn;?> <?php echo $deleteBtn;?>
				</div>
			</form>
		</section>
		<aside class="span6">
			<?php
			if(isset($events)) {
				foreach($events as $single_event) { 
					extract($single_event);
					$time = strtotime($event_date);
					$event_date = date('j', $time);
					$event_month = date('M Y', $time);
					$event_time = date('G:i', $time);
					$container_active_class = "";
					$info_active_class = "";
					if($event_id == $id) {
						$container_active_class = "calendar-event-container-active";
						$info_active_class = "calendar-event-info-active";
					}
					?>
					<div class="calendar-event-row">
						<div class="calendar-event-container <?php echo $container_active_class; ?>" data-id="<?php echo $event_id; ?>">
							<div class="calendar-event-date">
								<span class="date"><?php echo $event_date; ?></span>
								<span class="month"><?php echo $event_month; ?></span>
								<span class="time"><?php echo $event_time; ?></span>
							</div>
							<div class="calendar-event-info <?php echo $info_active_class; ?> clearfix">
								<h5><?php echo $event_name; ?></h5>
								<?php echo $event_description;?>
							</div>
						</div>
					</div>
				<?php
				}
			} else {
				echo "<p>Inga händelser hittades</p>";
			}
			?>
		</aside>
	</div>
</article>