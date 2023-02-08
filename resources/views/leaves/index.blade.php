@extends("layouts.app")
@section("content")
	<div class="row justify-content-center">
		<div class="col-md-10 p-4 d-grid gap-2">
			@foreach($leaves as $leave)
				<div class="row bg-white border p-2 d-flex align-items-center">
					<div class="col-md-4">
						<span class="fw-bold">{{ $leave->user->name }}</span>
					</div>
					<div class="col-md-2 text-center">
						<span class=" @if($leave->type == 'medical') text-warning @elseif($leave->accepted) text-success @endif ">
							{{ __($leave->type) }}
						</span>
					</div>
					<div class="col-md-2 text-center">
						{{ $leave->start }}
					</div>
					<div class="col-md-2 text-center">
						{{ $leave->end }}
					</div>
					<div class="col-md-2 text-center d-flex flex-row justify-content-end">
						<form action="{{ route('leave.accept', $leave->id) }}" method="post">
							@csrf
							<button class="btn btn-sm btn-outline-success me-2" @if($leave->type == 'medical' || $leave->accepted) hidden @endif>✅</button>
						</form>
						<form action="{{ route('leave.destroy', $leave->id) }}" method="post">
							@csrf
							@method('DELETE')
							<button class="btn btn-sm btn-outline-danger" @if($leave->type == 'medical') disabled @endif>❌</button>
						</form>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection