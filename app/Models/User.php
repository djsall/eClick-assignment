<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are allowed to be mass assigned
	 * @var string[]
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'role',
		'leaveDays',
		'post'
	];


	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * Store the possible roles for the user
	 * @var array|string[]
	 */
	public static array $roles = [
		"employee",
		"manager"
	];

	public function isEmployee(): bool {
		return $this->role == "employee";
	}

	public function isManager(): bool {
		return $this->role == "manager";
	}

	/**
	 * Update the remaining leave days of our user
	 * @param Leave $leave
	 */

	public function addLeaveDays(Leave $leave) {
		$this->leaveDays += Apphelper::calculateDays($leave->start, $leave->end);
		$this->update();
	}

	/**
	 * Update the remaining leave days of our user
	 * @param $start
	 * @param $end
	 */
	public function subtractLeaveDays($start, $end) {
		$this->leaveDays -= AppHelper::calculateDays($start, $end);
		$this->update();
	}

	/**
	 * Returns the instances of Leaves connected to the User
	 * @return HasMany
	 */
	public function leaves(): HasMany {
		return $this->hasMany(Leave::class);
	}

	/**
	 * Returns whether the user has enough days remaining for the requested Leave instance.
	 * @param Leave $leave
	 * @return bool
	 */
	public function hasEnoughLeaveDaysFor(Leave $leave): bool {

		return $this->leaveDays >= $leave->length();
	}
}
