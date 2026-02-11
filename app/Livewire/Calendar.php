<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public function render()
    {
        $projects = Project::whereHas('users', function ($query) {
                $query->where('users.id', Auth::id());
            })
            ->where(function ($query) {
                $query->whereNotNull('start_date')
                    ->orWhereNotNull('end_date');
            })
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'start' => $project->start_date,
                    'end' => $project->end_date ? date('Y-m-d', strtotime($project->end_date . ' +1 day')) : null,
                    'description' => $project->description,
                    'color' => $project->color,
                    'backgroundColor' => $project->color ?: $this->getDefaultColor($project->id),
                    'borderColor' => $project->color ?: $this->getDefaultColor($project->id),
                    'textColor' => $this->getTextColor($project->color),
                    'allDay' => true,
                    'extendedProps' => [
                        'description' => $project->description,
                        'has_end_date' => !is_null($project->end_date),
                    ]
                ];
            });

        return view('livewire.calendar', [
            'projects' => $projects,
        ]);
    }

    private function getDefaultColor($projectId)
    {
        // Generate consistent colors based on project ID
        $colors = [
            '#3b82f6', // blue
            '#10b981', // green
            '#8b5cf6', // violet
            '#f59e0b', // amber
            '#ef4444', // red
            '#06b6d4', // cyan
            '#f97316', // orange
            '#6366f1', // indigo
        ];

        return $colors[$projectId % count($colors)];
    }

    private function getTextColor($backgroundColor)
    {
        // Return white text for dark backgrounds, black for light backgrounds
        if (!$backgroundColor) return '#ffffff';

        // Convert hex to RGB
        $hex = str_replace('#', '', $backgroundColor);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculate luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.5 ? '#000000' : '#ffffff';
    }
}
