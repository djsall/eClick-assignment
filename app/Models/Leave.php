<?php

namespace App\Models;

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
