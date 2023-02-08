<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\IsAllowedDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
	public function __construct() {
		$this->middleware('manager', [
			'only' => [
				'index',
				'destroy',
				'update',
				'edit',
			]
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index() {
		//
		return view('user.index')->with([
			'users' => User::all()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param User $user
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param User $user
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit(User $user) {
		return view('user.edit')->with([
			'user' => $user
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param User $user
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, User $user) {
		$data = Validator::make($request->all(), [
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
			]
		])->validated();

		if ($user->update($data)) {
			$msg = [
				'success' => 'Successfully updated user'
			];
		}
		else
			$msg = [
				'error' => 'Error updating user'
			];
		return redirect(url()->previous())->with($msg);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param User $user
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(User $user) {
		if ($user->delete()) {
			$msg = [
				"success" => "Successfully deleted user."
			];
		}
		else
			$msg = [
				"error" => "Could not delete user."
			];
		return redirect(url()->previous())->with($msg);
	}
}
