@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Edit user info</div>

					<div class="card-body">
						<form method="POST" action="{{ route('user.update', $user) }}">
							@csrf
							@method('PUT')
							<div class="row mb-3">
								<label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

								<div class="col-md-6">
									<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

									@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="row mb-3">
								<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

								<div class="col-md-6">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

									@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="row mb-3">
								<label for="role" class="col-md-4 col-form-label text-md-end">
									Please select the User type
								</label>
								<div class="col-md-6">
									<select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
										<option value="employee" @if($user->role == 'employee') selected @endif>Employee</option>
										<option value="manager" @if($user->role == 'manager') selected @endif>Manager</option>
									</select>

									@error('role')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="row mb-3">
								<label for="leaveDays" class="col-form-label col-md-4 text-md-end">The number of leave days</label>
								<div class="col-md-6">
									<input type="number" id="leaveDays" name="leaveDays" class="form-control @error('leaveDays') is-invalid @enderror" required value="{{ $user->leaveDays }}">
								</div>

								@error('leaveDays')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>

							<div class="row mb-3">
								<label for="post" class="col-form-label col-md-4 text-md-end">The post of the employee</label>
								<div class="col-md-6">
									<input type="text" id="post" name="post" class="form-control @error('post') is-invalid @enderror" required value="{{$user->post}}">
								</div>

								@error('post')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>

							<div class="row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-success">
										Save
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center mt-4">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Delete user?</div>
					<div class="card-body">
						<form action="{{ route('user.destroy', $user->id) }}" method="post">
							@csrf
							@method('DELETE')
							<div class="row mb-0">
								<label for="delete-btn" class="col-md-4 col-form-label text-md-end">Delete user</label>
								<div class="col-md-6">
									<button id="delete-btn" class="btn btn-sm btn-outline-danger">❌</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
