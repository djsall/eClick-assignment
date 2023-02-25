<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model {

	/**
	 * Mass assignable fields of Leave model
	 * @var array
	 */
	protected $fillable = [
		"start",
		"end",
		"user_id",
		"accepted",
		"type",
	];

	use HasFactory;

	/**
	 * Returns the Employee that is on leave during this time
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	/**
	 * Returns if this Leave is medical
	 * @return bool
	 */
	public function isMedical(): bool {
		return $this->type == "medical";
	}

	/**
	 * Returns if this Leave is paid leave
	 * @return boolean
	 */
	public function isPaid(): bool {
		return $this->type == "paid";
	}

	/**
	 * Sets the Leave to accepted status
	 */
	public function accept() {
		$this->accepted = true;
		$this->save();
	}

	public function length(): int {
		$period = CarbonPeriod::create($this->start, $this->end);
		return $period->count();
	}

	/**
	 * Checks whether the leave model passed in isn't overlapping the current instance.
	 */
	public function checkOverlap(Leave $leave): bool {
		$thisPeriod = CarbonPeriod::create($this->start, $this->end);
		$newPeriod = CarbonPeriod::create($leave->start, $leave->end);

		return $thisPeriod->overlaps($newPeriod);
	}

	/**
	 * Returns whether the user has enough days remaining for this Leave instance.
	 * @return bool
	 */
	public function userHasEnoughLeaveDays(): bool {

		return $this->user->leaveDays >= $this->length();
	}

	/**
	 * Checks whether the leave model passed in:
	 * - isn't in the past
	 * - isn't exceeding the users available leave days
	 * - isn't overlapping with past leaves of the user
	 * @return bool
	 */

	public function verifyInputDates(): bool {
		$now = Carbon::now();
		$checkStart = Carbon::parse($this->start)->gte($now);
		$checkEnd = Carbon::parse($this->end)->gte($now);

		if ($this->type == 'paid') {
			if ($this->userHasEnoughLeaveDays()) {
				$match = false;

				foreach (Leave::where('user_id', '=', $this->user_id) as $lv) {
					if ($lv->checkOverlap($this)) {
						$match = true;
						break;
					}
				}
				return $match;
			}
			else
				return false;
		}
		return $checkStart && $checkEnd;
	}
}
