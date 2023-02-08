@extends("layouts.app")
@section("content")
	<div class="row justify-content-center">
		<div class="col-md-10 p-4 d-grid gap-2">
			@foreach($leaves as $leave)
				<div class="row bg-white border p-2">
					<div class="col-md-4 text-center">
						<p class="fw-bold">{{ $leave->user->name }}</p>
					</div>
					<div class="col-md-2 text-center">
						{{ $leave->start }}
					</div>
					<div class="col-md-2 text-center">
						{{ $leave->end }}
					</div>
					<div class="col-md-2 text-center">
{{--						TODO: move this to translation file from model--}}
						{{ $leave->getTranslatedType() }}
					</div>
					<div class="col-md-1 text-center">
						<form action="{{ route('leave.accept', $leave->id) }}" method="post">
							@csrf
							<button class="btn btn-success" @if($leave->type == 'medical' || $leave->accepted) disabled @endif>Accept</button>
						</form>
					</div>
					<div class="col-md-1 text-center">
						<form action="{{ route('leaves.destroy', $leave->id) }}" method="post">
							@csrf
							@method('DELETE')
							<button class="btn btn-danger" @if($leave->type == 'medical') disabled @endif>Delete</button>
						</form>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection