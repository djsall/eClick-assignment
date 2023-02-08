@extends("layouts.app")
@section("content")
	<div class="row justify-content-center">
		<div class="col-md-10 p-4 d-grid gap-2">
			<div class="row border p-2 d-flex align-items-center small text-muted bg-light">
				<div class="col-md-3">
					Name
				</div>
				<div class="col-md-3">
					Post
				</div>
				<div class="col-md-3">
					E-Mail
				</div>
				<div class="col-md-1">
					Role
				</div>
				<div class="col-md-1">
					Leave days
				</div>
				<div class="col-md-1">
					Delete?
				</div>
			</div>
			@foreach($users as $user)
				<div class="row bg-white border p-2 d-flex align-items-center">
					<div class="col-md-3">
						<a href="{{ route("user.edit", $user->id) }}" class="fw-bold">{{ $user->name }}</a>
					</div>
					<div class="col-md-3">
						{{ $user->post }}
					</div>
					<div class="col-md-3">
						{{ $user->email }}
					</div>
					<div class="col-md-1">
						{{ $user->role }}
					</div>
					<div class="col-md-1">
						{{ $user->leaveDays }} days
					</div>
					<div class="col-md-1">
						<form action="{{ route('user.destroy', $user->id) }}" method="post">
							@csrf
							@method('DELETE')
							<button class="btn btn-sm btn-outline-danger">❌</button>
						</form>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection