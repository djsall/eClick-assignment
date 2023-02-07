@extends("layouts.app")
@section("content")
	<div class="row justify-content-center">
		<div class="col-md-6">
			<form action="{{ route('leaves.store') }}" method="post" class="card card-body">
				@csrf
				<div class="form-group">
					<label for="start" class="form-label">Start date:</label>
					<input type="date" id="start" name="start" required class="form-control">
				</div>

				<div class="form-group mt-2">
					<label for="end" class="form-label">End date:</label>
					<input type="date" id="end" name="end" required class="form-control">
				</div>

				<div class="form-group mt-2">
					<label for="type" class="form-label">Type:</label>
					<select name="type" id="type" class="form-select" required>
						<option value="medical">Medical</option>
						<option value="paid">Paid</option>
					</select>
				</div>

				<button class="btn btn-success mt-4" name="submit" id="submit">Save</button>
			</form>
		</div>
	</div>
@endsection