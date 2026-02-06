<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\TimeEntry;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class TimerWidget extends Component
{
    public $isRunning = false;
    public $elapsedTime = 0;
    public $currentEntry = null;
    public $selectedProjectId = null;
    public $projects = [];
    public $showStopModal = false;

    // Modal data
    public $modalStartTime;
    public $modalEndTime;
    public $modalDuration;
    public $modalProjectName;

    public function mount()
    {
        // Load user's projects
        $this->projects = Auth::user()->projects->toArray();

        // Set first project as default if available
        if (count($this->projects) > 0 && !$this->selectedProjectId) {
            $this->selectedProjectId = $this->projects[0]['id'];
        }

        // Check if user has a running timer
        $this->currentEntry = TimeEntry::where('user_id', Auth::id())
            ->whereNull('end_time')
            ->latest()
            ->first();

        if ($this->currentEntry) {
            $this->isRunning = true;
            $this->selectedProjectId = $this->currentEntry->project_id;
            // Calculate seconds elapsed since start (ensure positive number)
            $this->elapsedTime = (int) abs($this->currentEntry->start_time->diffInSeconds(now(), false));
        } else {
            $this->elapsedTime = 0;
        }
    }

    public function toggleTimer()
    {
        if ($this->isRunning) {
            $this->showStopConfirmation();
        } else {
            $this->startTimer();
        }
    }

    public function showStopConfirmation()
    {
        if (!$this->currentEntry) {
            return;
        }

        $endTime = now();
        // Calculate duration in seconds for accuracy (ensure positive)
        $durationSeconds = abs($this->currentEntry->start_time->diffInSeconds($endTime, false));
        $project = Project::find($this->currentEntry->project_id);

        $this->modalStartTime = $this->currentEntry->start_time->format('H:i');
        $this->modalEndTime = $endTime->format('H:i');
        $this->modalDuration = $this->formatDuration($durationSeconds);
        $this->modalProjectName = $project ? $project->title : 'Onbekend project';

        // Update elapsed time before pausing
        $this->elapsedTime = $durationSeconds;
        
        // Pause the timer when modal opens
        $this->isRunning = false;
        $this->showStopModal = true;
    }

    public function confirmStop()
    {
        $this->stopTimer();
        $this->elapsedTime = 0; // Reset display after stopping
        $this->showStopModal = false;
    }

    public function discardTimer()
    {
        // Delete the time entry without saving
        if ($this->currentEntry) {
            $this->currentEntry->delete();
            $this->currentEntry = null;
        }

        $this->isRunning = false;
        $this->elapsedTime = 0; // Reset display
        $this->showStopModal = false;

        // Optionally refresh other widgets
        $this->dispatch('timer-discarded');
    }

    public function cancelStop()
    {
        // Recalculate elapsed time from start to now (not from when we paused)
        if ($this->currentEntry) {
            $this->elapsedTime = (int) abs($this->currentEntry->start_time->diffInSeconds(now(), false));
        }
        
        // Resume the timer when canceling
        $this->isRunning = true;
        $this->showStopModal = false;
    }

    private function formatDuration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        
        if ($hours > 0) {
            return sprintf('%d uur %d minuten', $hours, $minutes);
        } else {
            return sprintf('%d minuten %d seconden', $minutes, $secs);
        }
    }

    public function startTimer()
    {
        // Validate that a project is selected
        if (!$this->selectedProjectId) {
            session()->flash('error', 'Selecteer eerst een project om te starten.');
            return;
        }

        $this->currentEntry = TimeEntry::create([
            'user_id' => Auth::id(),
            'project_id' => $this->selectedProjectId,
            'date' => now()->toDateString(),
            'start_time' => now(),
            'source' => 'timer',
        ]);

        $this->isRunning = true;
        $this->elapsedTime = 0;
    }

    public function stopTimer()
    {
        if ($this->currentEntry) {
            $endTime = now();
            $durationMinutes = $endTime->diffInMinutes($this->currentEntry->start_time);

            $this->currentEntry->update([
                'end_time' => $endTime,
                'duration_minutes' => $durationMinutes,
            ]);

            $this->isRunning = false;
            $this->elapsedTime = 0;
            $this->currentEntry = null;

            // Refresh the dashboard widgets
            $this->dispatch('timer-stopped');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.timer-widget');
    }
}
