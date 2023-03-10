<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Single action controller method for displaying the calendar on the homepage.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        $events = [];

        $leaves = Leave::query()
            ->with('user:id,name')
            ->where('accepted', true)
            ->orWhere('type', 'medical')
            ->get();

        foreach ($leaves as $leave) {
            $events[] = [
                'title' => $leave->user->name,
                'start' => $leave->start,
                'end' => $leave->end,
                'color' => $leave->color(),
            ];
        }

        return view('home', compact('events'));
    }
}
