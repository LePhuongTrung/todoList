<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Calendar</title>
	<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
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
				dateClick: function(info) {
					var allDays = document.querySelectorAll('.fc-daygrid-day');
					allDays.forEach(function(day) {
						day.classList.remove('fc-day-today');
					});

					var clickedDay = info.dayEl;
					clickedDay.classList.add('fc-day-today');

					calendar.changeView('timeGridDay', info.date);
				},
				viewDidMount: function(info) {
					console.log('Chế độ xem đã thay đổi: ' + info.view.type);
				},
				events: <?php echo json_encode($events); ?>
			});

			calendar.on('datesSet', function(info) {
				console.log('Chế độ xem hiện tại: ' + info.view.type);
			});

			calendar.render();
		});
	</script>

</body>

</html>