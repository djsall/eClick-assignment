<?php

namespace Database\Factories;

use App\Models\Leave;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Leave>
 */
class LeaveFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
    {
		return [
			'start'    => Carbon::now(),
			'end'      => Carbon::now()->addDays(rand(3, 8)),
			'accepted' => (bool)rand(0, 1),
			'type'     => ['paid', 'medical'][rand(0, 1)],
		];
	}
}
