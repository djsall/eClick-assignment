<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Http\Requests\StoreLeaveRequest;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
		$data = $request->validated();

		/**
		 * If the user is a manager, he can select the leaving user, and it gets automatically accepted
		 */
		if ($request->user()->isManager()) {
			$user = User::find($data['user_id']);
			$data['accepted'] = true;
		}
		else {
			$user = $request->user();
			$data['user_id'] = $user->id;
			$data['accepted'] = false;
		}

		$leave = new Leave($data);

		/**
		 * If the user has enough days to spare, or if they are notifying us of medical leave, than save our leave request.
		 */
		if ($leave->verifyLeave()) {
			Leave::create($data);
			$msg = [
				'success' => 'Leave request saved successfully.'
			];
		}
		else
			$msg = [
				'error' => view('messages.verify-leave-error-message')->with(['user' => $user])->render(),
			];

		return redirect(url()->previous())->with($msg);
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
				'success' => 'Leave request for <strong>' . $leave->user->name . '</strong> deleted sucessfully.'
			];
		else
			$msg = [
				'error' => 'Leave request could not be deleted.'
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
			'success' => 'Accepted leave for <strong>' . $leave->user->name . '</strong> between <strong>' . $leave->start . '</strong> and <strong>' . $leave->end . '</strong>.'
		]);
	}
}
