@extends("layouts.app")
@section("content")
	<div class="row justify-content-center">
		<div class="col-md-10 p-4 d-grid gap-2">
			<div class="row border p-2 d-flex align-items-center small text-muted bg-light">
				<div class="col-md-4">
					Name (Post)
				</div>
				<div class="col-md-2 text-center">
					Leave type
				</div>
				<div class="col-md-2 text-center">
					Leave start
				</div>
				<div class="col-md-2 text-center">
					Leave end
				</div>
				<div class="col-md-2 text-center d-flex flex-row justify-content-end">
					Actions
				</div>
			</div>
			@foreach($leaves as $leave)
				<div class="row bg-white border p-2 d-flex align-items-center">
					<div class="col-md-4">
						<span class="@if($leave->type == 'paid' && !$leave->accepted)fw-bold @endif">{{ $leave->user->name }}</span> <span class="small text-muted">({{$leave->user->post}})</span>
					</div>
					<div class="col-md-2 text-center">
						<span class=" @if($leave->type == 'medical') text-info @elseif($leave->accepted) text-success @endif ">
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