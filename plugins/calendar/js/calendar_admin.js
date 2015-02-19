$(document).ready(function() {
	 $('#time').timepicker();
	 var nowTemp = new Date();
	 var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	 $('#date').datepicker({
	 	date: now,
	 	weekStart: 1,
	 	onRender: function(date) {
			return date.valueOf() < now.valueOf() ? 'disabled' : '';
		}
	 });

	$('.calendar-event-container').click(function() {
		location.href = "/admin/call_plugin_func/calendar/edit/" + this.getAttribute("data-id");
	});
	$('.calendar_delete_event').click(function() {
		if(confirm('Do you really want to delete this event?')) {
			location.href = "/admin/call_plugin_func/calendar/delete/" + this.getAttribute("data-event-id");
		}
	});
	$('.calendar_btn_cancel').click(function() {
		location.href = "/admin/call_plugin_func/calendar/cancel/";
	});

});