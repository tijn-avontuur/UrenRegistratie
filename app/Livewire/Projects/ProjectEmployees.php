<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class ProjectEmployees extends Component
{
    public Project $project;
    public $showAddModal = false;
    public $selectedUserId = '';
    public $availableUsers = [];

    public function mount(Project $project)
    {
        $this->project = $project->load('users');
        $this->loadAvailableUsers();
    }

    public function loadAvailableUsers()
    {
        // Get all users who are NOT already assigned to this project
        $assignedUserIds = $this->project->users->pluck('id')->toArray();

        $this->availableUsers = User::whereNotIn('id', $assignedUserIds)
            ->orderBy('name')
            ->get();
    }

    public function openAddModal()
    {
        $this->loadAvailableUsers();
        $this->showAddModal = true;
    }

    public function addEmployee()
    {
        $this->validate([
            'selectedUserId' => 'required|exists:users,id',
        ], [
            'selectedUserId.required' => 'Selecteer een medewerker.',
            'selectedUserId.exists' => 'De geselecteerde medewerker is ongeldig.',
        ]);

        // Check if user is not already assigned
        if ($this->project->users()->where('user_id', $this->selectedUserId)->exists()) {
            $this->addError('selectedUserId', 'Deze medewerker is al gekoppeld aan dit project.');
            return;
        }

        $this->project->users()->attach($this->selectedUserId);

        $this->showAddModal = false;
        $this->selectedUserId = '';

        $this->project->refresh();
        $this->loadAvailableUsers();

        $this->dispatch('employee-added');
    }

    public function removeEmployee($userId)
    {
        $this->project->users()->detach($userId);

        $this->project->refresh();
        $this->loadAvailableUsers();

        $this->dispatch('employee-removed');
    }

    #[On('employee-added')]
    #[On('employee-removed')]
    public function refreshEmployees()
    {
        $this->project->refresh();
        $this->loadAvailableUsers();
    }

    public function render()
    {
        return view('livewire.projects.project-employees');
    }
}
