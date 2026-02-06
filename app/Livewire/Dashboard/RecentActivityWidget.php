<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\TimeEntry;
use Illuminate\Support\Facades\Auth;

class RecentActivityWidget extends Component
{
    public $activities = [];

    protected $listeners = ['timer-stopped' => 'loadActivities'];

    public function mount()
    {
        $this->loadActivities();
    }

    public function loadActivities()
    {
        $this->activities = TimeEntry::with('project')
            ->where('user_id', Auth::id())
            ->whereNotNull('end_time')
            ->latest('start_time')
            ->take(3)
            ->get()
            ->map(function ($entry) {
                return [
                    'title' => $entry->project ? $entry->project->title : 'Geen project',
                    'start_time' => $entry->start_time->format('H:i'),
                    'end_time' => $entry->end_time->format('H:i'),
                    'project_name' => $entry->project ? $entry->project->title : 'Geen project',
                    'date' => $entry->start_time->format('d M'),
                    'date_short' => $entry->start_time->format('d'),
                    'month_short' => $entry->start_time->locale('nl')->format('M'),
                ];
            });
    }

    public function render()
    {
        return view('livewire.dashboard.recent-activity-widget');
    }
}
