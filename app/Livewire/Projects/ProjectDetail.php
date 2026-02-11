<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Project Details')]
class ProjectDetail extends Component
{
    public Project $project;
    public $activeTab = 'info';

    public function mount(Project $project)
    {
        $this->project = $project->load(['users', 'timeEntries', 'projectAttachments']);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    #[On('attachment-uploaded')]
    #[On('attachment-deleted')]
    #[On('employee-added')]
    #[On('employee-removed')]
    public function refreshProject()
    {
        $this->project->refresh();
    }

    public function render()
    {
        return view('livewire.projects.project-detail');
    }
}
