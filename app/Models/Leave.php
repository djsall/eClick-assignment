<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Leave extends Model {

	/**
	 * Store the possible reasons for a Leave
	 * @var array|string[]
	 */
	public static array $types = [
		"paid",
		"medical"
	];

	use HasFactory;

	/**
	 * Returns the Employee that is on leave during this time
	 * @return HasOne
	 */
	public function user(): HasOne {
		return $this->hasOne(User::class);
	}

	/**
	 * Returns whether this Leave was granted or not
	 * @return boolean
	 */
	public function isAccepted(): bool {
		return $this->accepted;
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
}
