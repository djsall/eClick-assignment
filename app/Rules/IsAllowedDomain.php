<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsAllowedDomain implements Rule {

	/**
	 * @var string[]
	 * Allowed email domains for users signing up
	 */

	protected array $allowedDomains = [
		'eclick.hu',
	];

	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @return bool
	 */
	public function passes($attribute, $value): bool
    {
		$domain = substr(strrchr($value, "@"), 1);
		if (in_array($domain, $this->allowedDomains))
			return true;
		return false;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message(): string
    {
		return 'This application only allows signing up with @eClick.hu e-mail addresses.';
	}
}
