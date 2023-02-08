@extends("layouts.app")
@section("content")
	<div class="row justify-content-center">
		<div class="col-md-10 p-4 d-grid gap-2">
			<div class="row bg-white border p-2 d-flex align-items-center">
				<div class="col-md-3">
					<span class="text-muted small">Name</span>
				</div>
				<div class="col-md-3">
					<span class="text-muted small">Post</span>
				</div>
				<div class="col-md-3">
					<span class="text-muted small">E-Mail</span>
				</div>
				<div class="col-md-1">
					<span class="text-muted small">Role</span>
				</div>
				<div class="col-md-2">
					<span class="text-muted small">Leave days</span>
				</div>
			</div>
			@foreach($users as $user)
				<div class="row bg-white border p-2 d-flex align-items-center">
					<div class="col-md-3">
						<a href="{{ route("users.edit", $user->id) }}" class="fw-bold">{{ $user->name }}</a>
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
					<div class="col-md-2">
						{{ $user->leaveDays }} days
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection