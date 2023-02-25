<?php

namespace App\Http\Requests;

use App\Rules\IsAllowedDomain;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
	/**
	 * Get the validation rules that apply to the request.
	 * @return array<string, mixed>
	 */
	public function rules() {
		return [
			'name'      => [
				'required',
				'string',
				'max:255',
			],
			'email'     => [
				'required',
				'string',
				'email',
				'max:255',
				new IsAllowedDomain
			],
			'password'  => [
				'required',
				'string',
				'min:8',
				'confirmed',
			],
			'role'      => [
				'required',
				'in:employee,manager',
			],
			'leaveDays' => [
				'required',
				'int',
			],
			'post'      => [
				'required',
				'string',
			],
		];
	}
}
