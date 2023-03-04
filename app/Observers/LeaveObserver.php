<?php

namespace App\Observers;

use App\Jobs\UpdatePaidLeave;
use App\Mail\LeaveAccepted;
use App\Models\Leave;
use Illuminate\Support\Facades\Mail;

class LeaveObserver {
	/**
	 * Handle the Leave "created" event.
	 * if the leave is already accepted, update the remaining leave days, if it is not medical leave
 * @param Leave $leave
	 * @return void
	 */
	public function created(Leave $leave): void
    {
        UpdatePaidLeave::dispatch($leave);
		Mail::to($leave->user)->send(new LeaveAccepted($leave));
	}

	/**
	 * Handle the Leave "updated" event.
	 * @param Leave $leave
	 * @return void
	 */
	public function updated(Leave $leave): void
    {
		UpdatePaidLeave::dispatch($leave);
		Mail::to($leave->user)->send(new LeaveAccepted($leave));
	}

	/**
	 * Handle the Leave "deleted" event.
	 * @param Leave $leave
	 * @return void
	 */
	public function deleted(Leave $leave): void
    {
		if ($leave->accepted && $leave->type == 'paid')
			$leave->user->addLeaveDays($leave);
	}
}
