<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	public function __invoke() {
		$events = [];

		$leaves = Leave::with(['user'])->get();

		foreach ($leaves as $leave) {
			$events[] = [
				'title' => $leave->user->name,
				'start' => $leave->start,
				'end'   => $leave->end,
			];
		}

		return view('home', compact('events'));
	}
}
