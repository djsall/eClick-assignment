<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run(): void
    {
		/**
		 * Create 5 users, that each have one leave request
		 */
		User::factory(5)->has(Leave::factory()->count(1)->state(function (array $attributes, User $user) {
			return ['user_id' => $user->id];
		}))->create();
	}
}
