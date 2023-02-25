<?php

namespace App\Helpers;

use Carbon\Carbon;

class AppHelper {
	/**
	 * Returns the distance in days between two dates, excluding weekends
	 * @param $start
	 * @param $end
	 * @return int
	 */
	public static function calculateDays($start, $end): int {
		$start = Carbon::parse($start);
		$end = Carbon::parse($end);

		return $start->diffInDaysFiltered(function (Carbon $date) {
			return !$date->isWeekend();
		}, $end, true);
	}
}