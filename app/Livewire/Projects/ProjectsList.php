<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\On;

class ProjectsList extends Component
{
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingProject = null;

    #[On('project-created')]
    #[On('project-updated')]
    #[On('project-deleted')]
    #[On('modal-closed')]
    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->editingProject = null;
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function openEditModal($projectId)
    {
        $this->editingProject = Project::findOrFail($projectId);
        $this->showEditModal = true;
    }

    public function deleteProject($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->delete();

        $this->dispatch('project-deleted');
    }

    public function render()
    {
        $projects = Project::with(['users', 'timeEntries', 'projectAttachments'])
            ->withCount('timeEntries')
            ->latest()
            ->get();

        return view('livewire.projects.projects-list', [
            'projects' => $projects,
        ]);
    }
}
