<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\TimeEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkedHoursWidget extends Component
{
    public $weekHours = 0;
    public $weekTarget = 40;
    public $weekPercentage = 0;
    public $monthHours = 0;

    protected $listeners = ['timer-stopped' => 'refreshStats'];

    public function mount()
    {
        $this->refreshStats();
    }

    public function refreshStats()
    {
        $userId = Auth::id();

        // Calculate this week's hours
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $this->weekHours = TimeEntry::where('user_id', $userId)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->whereNotNull('end_time')
            ->sum('duration_minutes') / 60;

        $this->weekPercentage = min(100, ($this->weekHours / $this->weekTarget) * 100);

        // Calculate this month's hours
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $this->monthHours = TimeEntry::where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereNotNull('end_time')
            ->sum('duration_minutes') / 60;
    }

    public function render()
    {
        return view('livewire.dashboard.worked-hours-widget');
    }
}
