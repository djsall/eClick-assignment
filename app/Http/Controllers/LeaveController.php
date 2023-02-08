<?php

namespace App\Http\Controllers;

use App\Mail\LeaveAccepted;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index() {

		return view('leaves.index')->with([
			'leaves' => Leave::with('user')->get()
		]);
	}

	/**
	 * Show the form for creating a new leave request.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function create() {

		return view('leaves.create')->with([
			'users' => User::all(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {

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
		 * If the user is a manager, he can select the leaving user, and it gets automatically accepted
		 */
		if ($request->user()->isManager()) {
			$data['accepted'] = true;
			$data['user_id'] = $request['user_id'];
		}
		else {
			$data['user_id'] = $request->user()->id;
			$data['accepted'] = false;
		}

		$diff = self::calculateDays($data['start'], $data['end']);

		/**
		 * If the user has enough days to spare, or if they are notifying us of medical leave
		 */
		if ($request->user()->leaveDays >= $diff || $data['type'] == 'medical') {
			if ($leave = Leave::create($data)) {
				//if the leave is already accepted, update the remaining leave days, if it is not medical leave
				if ($data['accepted'] && $data['type'] == 'paid') {
					$user = $leave->user;
					self::subtractUserDays($user, $data['start'], $data['end']);
					Mail::to($user)->send(new LeaveAccepted($leave));
				}
				$msg = [
					'success' => 'Leave request saved successfully.'
				];
			}
			//TODO: else: log database error?
		}
		else
			$msg = [
				'error' => 'Leave request could not be saved. (Requested days: ' . $diff . ', remaining days: ' . $request->user()->leaveDays . ')',
			];
		return redirect(url()->previous())->with($msg);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function show(Leave $leave) {
		//
	}

	/**
	 * Show the form for editing a Leave request
	 *
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
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Leave $leave
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Leave $leave) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Leave $leave
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(Leave $leave) {
		if ($leave->accepted && $leave->type == 'paid')
			self::addUserDays($leave);
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
		$leave->accepted = true;
		$leave->save();

		self::subtractUserDays($leave->user, $leave->start, $leave->end);

		Mail::to($leave->user)->send(new LeaveAccepted($leave));

		return redirect(url()->previous())->with([
			'success' => 'Accepted leave for <strong>' . $leave->user->name . '</strong> between <strong>' . $leave->start . '</strong> and <strong>' . $leave->end . '</strong>.'
		]);
	}

	/**
	 * Returns the distance in days between two dates
	 * @param $start
	 * @param $end
	 * @return int
	 */
	static function calculateDays($start, $end) {
		$start = Carbon::parse($start);
		$end = Carbon::parse($end);
		return $start->diffInDays($end, true);
	}

	/**
	 * Update the remaining leave days of our user
	 * @param User $user
	 * @param $start
	 * @param $end
	 */
	static function subtractUserDays(User $user, $start, $end) {
		$user->leaveDays -= self::calculateDays($start, $end);
		$user->save();
	}

	/**
	 * Update the remaining leave days of our user
	 * @param Leave $leave
	 */
	static function addUserDays(Leave $leave) {
		$user = $leave->user;
		$user->leaveDays += self::calculateDays($leave->start, $leave->end);
		$user->save();
	}
}
