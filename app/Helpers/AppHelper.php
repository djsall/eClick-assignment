<?php

namespace App\Helpers;

use Carbon\Carbon;

class AppHelper {

    public static string $medicalColor = '#dc3545';
    public static string $pendingColor = '##ffc107';
    public static string $acceptedColor = '#198754';


	/**
	 * Returns the distance in days between two dates, excluding weekends
	 * @param $start
	 * @param $end
	 * @return int
	 */
	public static function calculateDays($start, $end): int {
		$start = Carbon::parse($start);
		$end = Carbon::parse($end);

		return $start->diffInWeekdays($end, true);
	}

}
