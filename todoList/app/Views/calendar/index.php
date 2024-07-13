<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Calendar</title>
	<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		body {
			font-family: Verdana, sans-serif;
		}

		.calendar-container {
			max-width: 900px;
			margin: 40px auto;
		}

		.fc-daygrid-day {
			cursor: pointer;
		}

		.fc-daygrid-day.fc-day-today {
			background: #1abc9c;
			color: white !important;
		}
	</style>
</head>

<body>
	<div class="calendar-container">
		<div id="calendar"></div>
	</div>

	<?php include __DIR__ . '/../modal.php'; ?>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				selectable: true,
				dateClick: function(info) {
					var allDays = document.querySelectorAll('.fc-daygrid-day');
					allDays.forEach(function(day) {
						day.classList.remove('fc-day-today');
					});

					var clickedDay = info.dayEl;
					clickedDay.classList.add('fc-day-today');

					calendar.changeView('timeGridDay', info.date);
				},
				select: function(info) {
					if (calendar.view.type === 'timeGridDay') {
						$('#event_entry_modal').modal('show');
					}
				},
				events: <?php echo json_encode($works); ?>,
				eventClick: function(info) {
					var eventId = info.event.id;
					$('#event_entry_modal').modal('show');
					$('#event_entry_modal').data('id', eventId);
				}
			});

			calendar.on('datesSet', function(info) {
				var start = info.startStr;
				var end = info.endStr;

				$.get('/?start=' + start + '&end=' + end, function(data) {
					var newWorks = JSON.parse(data).works;
					calendar.removeAllEvents();
					calendar.addEventSource(newWorks);
				});
			});

			calendar.render();
		});
	</script>

	<script>
		function saveWork() {
			var formData = {
				action: 'save_work',
				work_name: document.getElementById('work_name').value,
				work_start_date: document.getElementById('work_start_date').value,
				work_end_date: document.getElementById('work_end_date').value,
				work_status: document.getElementById('work_status').value
			};

			$.ajax({
				type: 'POST',
				url: '/index.php',
				data: formData,
				success: function(response) {
					var result = JSON.parse(response);
					if (result.status === 'success') {
						alert('Work saved successfully!');
						$('#event_entry_modal').modal('hide');
					} else {
						alert('Failed to save work: ' + result.message);
					}
				},
				error: function() {
					alert('Failed to save work.');
				}
			});
		}
	</script>
</body>

</html>