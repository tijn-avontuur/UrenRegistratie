<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectAttachment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProjectAttachments extends Component
{
    use WithFileUploads;

    public Project $project;
    public $attachment;
    public $showUploadModal = false;

    protected $rules = [
        'attachment' => 'required|file|max:10240', // Max 10MB
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function openUploadModal()
    {
        $this->showUploadModal = true;
        $this->reset('attachment');
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->reset('attachment');
    }

    public function upload()
    {
        $this->validate();

        $filename = $this->attachment->getClientOriginalName();
        $filepath = $this->attachment->store('project-attachments', 'public');

        ProjectAttachment::create([
            'project_id' => $this->project->id,
            'filename' => $filename,
            'filepath' => $filepath,
            'uploaded_at' => now(),
        ]);

        $this->closeUploadModal();
        $this->dispatch('attachment-uploaded');
    }

    public function download($attachmentId)
    {
        $attachment = ProjectAttachment::findOrFail($attachmentId);

        return Storage::disk('public')->download($attachment->filepath, $attachment->filename);
    }

    public function delete($attachmentId)
    {
        $attachment = ProjectAttachment::findOrFail($attachmentId);

        // Delete file from storage
        Storage::disk('public')->delete($attachment->filepath);

        // Delete database record
        $attachment->delete();

        $this->dispatch('attachment-deleted');
    }

    public function render()
    {
        $attachments = $this->project->projectAttachments()
            ->latest('uploaded_at')
            ->get()
            ->map(function ($attachment) {
                $extension = strtolower(pathinfo($attachment->filename, PATHINFO_EXTENSION));
                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

                return [
                    'id' => $attachment->id,
                    'filename' => $attachment->filename,
                    'filepath' => $attachment->filepath,
                    'uploaded_at' => $attachment->uploaded_at,
                    'is_image' => in_array($extension, $imageExtensions),
                    'url' => Storage::disk('public')->url($attachment->filepath),
                ];
            });

        return view('livewire.projects.project-attachments', [
            'attachments' => $attachments,
        ]);
    }
}
