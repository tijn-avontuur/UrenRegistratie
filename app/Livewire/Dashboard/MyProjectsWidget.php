<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class MyProjectsWidget extends Component
{
    public $projects = [];

    public function mount()
    {
        $this->loadProjects();
    }

    public function loadProjects()
    {
        $this->projects = Auth::user()
            ->projects()
            ->withCount(['timeEntries', 'projectAttachments'])
            ->latest('updated_at')
            ->take(3)
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'color' => $project->color,
                    'status_color' => $this->getStatusColor($project),
                    'time_entries_count' => $project->time_entries_count,
                    'attachments_count' => $project->project_attachments_count,
                ];
            });
    }

    private function getStatusColor($project)
    {
        // Determine status color based on recent activity
        $recentEntries = $project->timeEntries()
            ->where('date', '>=', now()->subDays(7))
            ->count();

        if ($recentEntries > 5) {
            return 'bg-green-500'; // Active
        } elseif ($recentEntries > 0) {
            return 'bg-blue-500'; // In progress
        } else {
            return 'bg-orange-500'; // Inactive
        }
    }

    public function render()
    {
        return view('livewire.dashboard.my-projects-widget');
    }
}
