<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Models\Project;
use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    /**
     * Display a listing of the logged-in user's time entries.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // load projects for dropdown filter
        $projects = Project::orderBy('title')->get();

        $query = TimeEntry::with('project')->where('user_id', $user->id);

        // date range filters (expects YYYY-MM-DD)
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->input('end_date'));
        }

        // project filter
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        $entries = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15)
            ->appends($request->only(['start_date', 'end_date', 'project_id']));

        return view('time_entries.index', compact('entries', 'projects'));
    }
}
