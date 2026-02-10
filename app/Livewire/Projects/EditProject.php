<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectAttachment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditProject extends Component
{
    use WithFileUploads;

    public $show = true;
    public Project $project;
    public $title = '';
    public $description = '';
    public $color = '';
    public $start_date = '';
    public $end_date = '';
    public $attachments = [];
    public $existingAttachments = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'color' => 'nullable|string|max:7',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'attachments.*' => 'nullable|file|max:10240',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->color = $project->color ?? '#3b82f6';
        $this->start_date = $project->start_date ? $project->start_date->format('Y-m-d') : '';
        $this->end_date = $project->end_date ? $project->end_date->format('Y-m-d') : '';
        $this->existingAttachments = $project->projectAttachments;
    }

    public function update()
    {
        $validated = $this->validate();

        $this->project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'color' => $validated['color'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
        ]);

        // Upload new attachments if any
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $filename = $attachment->getClientOriginalName();
                $filepath = $attachment->store('project-attachments', 'public');

                ProjectAttachment::create([
                    'project_id' => $this->project->id,
                    'filename' => $filename,
                    'filepath' => $filepath,
                    'uploaded_at' => now(),
                ]);
            }
        }

        $this->show = false;
        $this->dispatch('project-updated');
        $this->dispatch('modal-closed');
    }

    public function removeAttachment($index)
    {
        array_splice($this->attachments, $index, 1);
    }

    public function deleteExistingAttachment($attachmentId)
    {
        $attachment = ProjectAttachment::findOrFail($attachmentId);

        // Delete file from storage
        Storage::disk('public')->delete($attachment->filepath);

        // Delete database record
        $attachment->delete();

        // Refresh existing attachments
        $this->existingAttachments = $this->project->projectAttachments()->get();
    }

    public function closeModal()
    {
        $this->show = false;
        $this->dispatch('modal-closed');
    }

    public function render()
    {
        return view('livewire.projects.edit-project');
    }
}
