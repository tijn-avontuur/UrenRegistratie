<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectAttachment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreateProject extends Component
{
    use WithFileUploads;

    public $show = true;
    public $title = '';
    public $description = '';
    public $color = '#3b82f6';
    public $start_date = '';
    public $end_date = '';
    public $attachments = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'color' => 'nullable|string|max:7',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'attachments.*' => 'nullable|file|max:10240',
    ];

    public function save()
    {
        $validated = $this->validate();

        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'color' => $validated['color'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
        ]);

        // Upload attachments if any
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $filename = $attachment->getClientOriginalName();
                $filepath = $attachment->store('project-attachments', 'public');

                ProjectAttachment::create([
                    'project_id' => $project->id,
                    'filename' => $filename,
                    'filepath' => $filepath,
                    'uploaded_at' => now(),
                ]);
            }
        }

        $this->show = false;
        $this->dispatch('project-created');
        $this->dispatch('modal-closed');
    }

    public function removeAttachment($index)
    {
        array_splice($this->attachments, $index, 1);
    }

    public function closeModal()
    {
        $this->show = false;
        $this->dispatch('modal-closed');
    }

    public function render()
    {
        return view('livewire.projects.create-project');
    }
}
