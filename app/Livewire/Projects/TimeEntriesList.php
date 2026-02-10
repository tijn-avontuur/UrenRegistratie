<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

class TimeEntriesList extends Component
{
    public $projectId;
    public $timeEntries = [];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingTimeEntry = null;

    public function mount($projectId = null)
    {
        $this->projectId = $projectId;
        $this->loadTimeEntries();
    }

    #[On('time-entry-created')]
    #[On('time-entry-updated')]
    #[On('time-entry-deleted')]
    public function loadTimeEntries()
    {
        $query = TimeEntry::with(['project', 'user'])->latest('date');

        if ($this->projectId) {
            $query->where('project_id', $this->projectId);
        } else {
            $query->where('user_id', auth()->id());
        }

        $this->timeEntries = $query->get();
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function openEditModal($timeEntryId)
    {
        $this->editingTimeEntry = TimeEntry::findOrFail($timeEntryId);
        $this->showEditModal = true;
    }

    public function deleteTimeEntry($timeEntryId)
    {
        $timeEntry = TimeEntry::findOrFail($timeEntryId);
        $timeEntry->delete();

        $this->dispatch('time-entry-deleted');
    }

    public function render()
    {
        return view('livewire.projects.time-entries-list');
    }
}
