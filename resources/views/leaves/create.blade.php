@extends("layouts.app")
@section("content")
	<div class="row justify-content-center">
		<div class="col-md-6">
			<form action="{{ route('leave.store') }}" method="post" class="card card-body">
				@csrf
				<div class="form-group">
					<label for="start" class="form-label">Start date:</label>
					<input type="date" id="start" name="start" required class="form-control" value="{{ Carbon\Carbon::today()->format("Y-m-d") }}">
				</div>

				<div class="form-group mt-2">
					<label for="end" class="form-label">End date:</label>
					<input type="date" id="end" name="end" required class="form-control"value="{{ Carbon\Carbon::tomorrow()->format("Y-m-d") }}">
				</div>

				<div class="form-group mt-2">
					<label for="type" class="form-label">Type:</label>
					<select name="type" id="type" class="form-select" required>
						<option value="paid" selected>{{ __("paid") }}</option>
						<option value="medical">{{ __("medical") }}</option>
					</select>
				</div>

				@if(Auth::user()->isManager())
					<div class="form-group mt-2">
						<label for="user_id" class="form-label">Employee:</label>
						<select name="user_id" id="user_id" class="form-control">
							@foreach($users as $user)
								<option value="{{$user->id}}" @if(Auth::user()->id == $user->id) selected @endif>{{$user->name}}</option>
							@endforeach
						</select>
					</div>
				@endif

				<button class="btn btn-success mt-4" name="submit" id="submit">Save</button>
			</form>
		</div>
	</div>
@endsection