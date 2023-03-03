<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class isManager {
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure(Request): (Response|RedirectResponse) $next
	 * @return Response|RedirectResponse
	 */
	public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
		$user = Auth::user();
		if ($user && $user->isManager())
			return $next($request);
		return redirect(url()->previous())->with([
			'error' => 'The resource you were trying to access, can only be accessed with a manager account.'
		]);
	}
}
