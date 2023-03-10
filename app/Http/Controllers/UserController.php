<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

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
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index() {
		//
		return view('user.index')->with([
			'users' => User::all()
		]);
	}

	/**
	 * Show the form for editing the specified resource.
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
	 * @param StoreUserRequest $request
	 * @param User $user
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(StoreUserRequest $request, User $user) {

		if ($user->update($request->validated())) {
			$msg = [
				'success' => 'Successfully updated user.'
			];
		}
		else
			$msg = [
				'error' => 'Error updating user.'
			];

		return redirect(url()->previous())->with($msg);
	}

	/**
	 * Remove the specified resource from storage.
	 * @param User $user
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(User $user) {

		if ($user->leaves()->count() == 0) {
			$user->delete();
			$msg = [
				'success' => 'Successfully deleted user.'
			];
		}
		else {
			$msg = [
				'error' => 'Can not delete user, that has Leave entries.'
			];
		}

		return redirect(url()->previous())->with($msg);
	}
}
