<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequest;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller {

	public function __construct() {
		$this->middleware('manager', [
			'only' => [
				'index',
				'destroy',
				'accept',
			]
		]);
	}

	/**
	 * Display an owerview of leave requests.
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index() {

		return view('leaves.index')->with([
			'leaves' => Leave::with('user')->orderByDesc('created_at')->get()
		]);
	}

	/**
	 * Show the form for creating a new leave request.
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function create() {

		return view('leaves.create')->with([
			'users' => User::all(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 * @param StoreLeaveRequest $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(StoreLeaveRequest $request) {
		$leave = new Leave($request->validated());

		/**
		 * If the user is a manager, he can select the leaving user, and it gets automatically accepted
		 */
		if ($request->user()->isManager()) {
			$user = User::find($leave->user_id);
			$leave->accepted = true;
		}
		else {
			$user = $request->user();
			$leave->user_id = $user->id;
			$leave->accepted = false;
		}

		if ($leave->verifyLeave()) {
			$leave->save();
			$msg = [
				'success' => 'Leave request saved successfully.'
			];
		}
		else
			$msg = [
				'error' => view('messages.error.verify-leave')->with(['user' => $user])->render(),
			];

		return redirect(url()->previous())->withInput()->with($msg);
	}

	/**
	 * Display the specified resource.
	 * @param Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function show(Leave $leave) {
		//
	}

	/**
	 * Show the form for editing a Leave request
	 * @param Leave $leave
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit(Leave $leave) {

		return view('leaves.edit')->with([
			'leave' => $leave
		]);
	}

	/**
	 * Update the specified resource in storage.
	 * @param \Illuminate\Http\Request $request
	 * @param Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Leave $leave) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * @param Leave $leave
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(Leave $leave) {
		if ($leave->delete())
			$msg = [
				'success' => view('messages.success.destroy-leave-request')->with(['leave' => $leave])->render()
			];
		else
			$msg = [
				'error' => view('messages.error.destroy-leave-request')->with(['leave' => $leave])->render()
			];
		return redirect(url()->previous())->with($msg);
	}

	/**
	 * Assign accepted to a leave request
	 * @param Leave $leave
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function accept(Leave $leave) {
		$leave->accept();

		return redirect(url()->previous())->with([
			'success' => view('messages.success.accept-leave-request')->with(['leave' => $leave])->render()
		]);
	}
}
