<?php

namespace App\Observers;

use App\Mail\LeaveAccepted;
use App\Models\Leave;
use Illuminate\Support\Facades\Mail;

class LeaveObserver {
	/**
	 * Handle the Leave "created" event.
	 * if the leave is already accepted, update the remaining leave days, if it is not medical leave

	 * @param \App\Models\Leave $leave
	 * @return void
	 */
	public function created(Leave $leave) {
		if ($leave->type != 'paid')
			return;
		if (!$leave->accepted)
			return;

		$leave->user->subtractLeaveDays($leave->start, $leave->end);
		$leave->update();

		Mail::to($leave->user)->send(new LeaveAccepted($leave));
	}

	/**
	 * Handle the Leave "updated" event.
	 *
	 * @param \App\Models\Leave $leave
	 * @return void
	 */
	public function updated(Leave $leave) {
		if ($leave->type != 'paid')
			return;
		if (!$leave->accepted)
			return;

		$leave->user->subtractLeaveDays($leave->start, $leave->end);

		Mail::to($leave->user)->send(new LeaveAccepted($leave));

	}

	/**
	 * Handle the Leave "deleted" event.
	 *
	 * @param \App\Models\Leave $leave
	 * @return void
	 */
	public function deleted(Leave $leave) {
		if ($leave->accepted && $leave->type == 'paid')
			$leave->user->addLeaveDays($leave);
	}

	/**
	 * Handle the Leave "restored" event.
	 *
	 * @param \App\Models\Leave $leave
	 * @return void
	 */
	public function restored(Leave $leave) {
		//
	}

	/**
	 * Handle the Leave "force deleted" event.
	 *
	 * @param \App\Models\Leave $leave
	 * @return void
	 */
	public function forceDeleted(Leave $leave) {
		//
	}
}
