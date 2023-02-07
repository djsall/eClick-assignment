<?php

namespace Database\Factories;

use App\Models\Leave;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory {
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition() {
		return [
			//
			'start'    => Carbon::now(),
			'end'      => Carbon::now()->addDays(rand(2, 7)),
			'accepted' => (bool)rand(0, 1),
			'type'     => Leave::$types[rand(0, 1)],
		];
	}
}
