@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<h1 class="display-5 fw-bold mb-4">Accepted leave times</h1>
				<div class="card card-body">
					<div id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
	@push('scripts')
		<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.1/index.global.min.js'></script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				var calendarEl = document.getElementById('calendar');
				var calendar = new FullCalendar.Calendar(calendarEl, {
					initialView: 'dayGridMonth',
					themeSystem: 'bootstrap5',
					events: @json($events),
				});
				calendar.render();
			});
		</script>
	@endpush
@endsection
