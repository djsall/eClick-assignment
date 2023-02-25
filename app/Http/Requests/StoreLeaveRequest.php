<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules() {
		return [
			'start'   => [
				'required',
				'date'
			],
			'end'     => [
				'required',
				'date'
			],
			'type'    => [
				'required',
				'in:medical,paid'
			],
			'user_id' => [
				'int'
			]
		];
	}
}
