<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller {
	/**
	 * Display an owerview of leave requests.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index() {
		//
		return view('leaves.manage')->with([
			'leaves' => Leave::with('user')->where('accepted', '=', false)->get()
		]);
	}

	/**
	 * Show the form for creating a new leave request.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function create() {
		//
		return view('leaves.submit')->with([
			'users'  => User::all(),
		]);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		//
		$data = $request->validate([
			'start'   => [
				'required',
				'date'
			],
			'end'     => [
				'required',
				'date'
			],
			'type'    => [
				'required',
				'in:medical,paid'
			],
			'user_id' => [
				'int'
			]
		]);

		/**
		 * If the user is a manager, he can select the leaving user and it gets automatically accepted
		 */
		if (Auth::user()->isManager()) {
			$data['accepted'] = true;
			$data['user_id'] = $request['user_id'];
		}
		else
			$data['user_id'] = Auth::id();

		if (Leave::create($data)) {
			$msg = [
				"success" => "Leave request saved successfully."
			];
		}
		else
			$msg = [
				"error" => "Leave request could not be saved.",
			];
		return redirect(url()->previous())->with($msg);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function show(Leave $leave) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Leave $leave) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Leave $leave) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Leave $leave) {
		//
	}

	public function accept(Leave $leave) {
		$leave->accepted = true;
		$leave->save();
		return redirect(url()->previous())->with([
			"success" => "Accepted leave for <strong>" . $leave->user->name . "</strong> between <strong>" . $leave->start . "</strong> and <strong>" . $leave->end . "</strong>."
		]);
	}
}
