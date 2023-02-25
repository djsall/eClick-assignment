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
				</div>
			</div>
			@foreach($users as $user)
				<div class="row bg-white border p-2 d-flex align-items-center">
					<div class="col-md-3">
						<span class="fw-bold">{{ $user->name }}</span>
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
					<div class="col-md-1 text-end">
						<a href="{{ route("user.edit", $user->id) }}" class="fw-bold">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
											d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
								<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
							</svg>
						</a>

					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection