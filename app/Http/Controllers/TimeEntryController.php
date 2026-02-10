<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    /**
     * Display a listing of the logged-in user's time entries.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $entries = TimeEntry::with('project')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('time_entries.index', compact('entries'));
    }
}
