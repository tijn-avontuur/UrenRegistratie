<?php

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAttachment;
use App\Livewire\Projects\ProjectAttachments;
use Livewire\Livewire;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    Storage::fake('public');
});

it('kan bijlagen weergeven voor een project', function () {
    $project = Project::factory()->create();
    ProjectAttachment::factory()->count(3)->create(['project_id' => $project->id]);

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->assertViewHas('attachments', function ($attachments) {
            return $attachments->count() === 3;
        });
});

it('kan een bijlage uploaden', function () {
    $project = Project::factory()->create();
    $file = UploadedFile::fake()->create('document.pdf', 1024);

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->set('attachment', $file)
        ->call('upload')
        ->assertDispatched('attachment-uploaded');

    $this->assertDatabaseHas('project_attachments', [
        'project_id' => $project->id,
        'filename' => 'document.pdf',
    ]);

    Storage::disk('public')->assertExists(ProjectAttachment::first()->filepath);
});

it('valideert dat een bestand verplicht is bij het uploaden', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->call('upload')
        ->assertHasErrors(['attachment' => 'required']);
});

it('valideert de maximale bestandsgrootte', function () {
    $project = Project::factory()->create();
    $file = UploadedFile::fake()->create('large-document.pdf', 11000); // 11MB, max is 10MB

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->set('attachment', $file)
        ->call('upload')
        ->assertHasErrors(['attachment']);
});

it('kan een bijlage verwijderen', function () {
    $project = Project::factory()->create();
    $attachment = ProjectAttachment::factory()->create([
        'project_id' => $project->id,
        'filepath' => 'project-attachments/test.pdf',
    ]);

    Storage::disk('public')->put($attachment->filepath, 'test content');

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->call('delete', $attachment->id)
        ->assertDispatched('attachment-deleted');

    $this->assertDatabaseMissing('project_attachments', [
        'id' => $attachment->id,
    ]);

    Storage::disk('public')->assertMissing($attachment->filepath);
});

it('opent en sluit de upload modal', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->call('openUploadModal')
        ->assertSet('showUploadModal', true)
        ->call('closeUploadModal')
        ->assertSet('showUploadModal', false);
});

it('reset het attachment veld bij het sluiten van de modal', function () {
    $project = Project::factory()->create();
    $file = UploadedFile::fake()->create('document.pdf', 100);

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->set('attachment', $file)
        ->call('closeUploadModal')
        ->assertSet('attachment', null);
});

it('toont het aantal bijlagen correct', function () {
    $project = Project::factory()->create();
    ProjectAttachment::factory()->count(5)->create(['project_id' => $project->id]);

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->assertSee('Bijlagen (5)');
});

it('detecteert images correct', function () {
    $project = Project::factory()->create();

    // Create image attachment
    $imageAttachment = ProjectAttachment::factory()->create([
        'project_id' => $project->id,
        'filename' => 'screenshot.png',
        'filepath' => 'project-attachments/screenshot.png',
    ]);

    // Create PDF attachment
    $pdfAttachment = ProjectAttachment::factory()->create([
        'project_id' => $project->id,
        'filename' => 'document.pdf',
        'filepath' => 'project-attachments/document.pdf',
    ]);

    Livewire::test(ProjectAttachments::class, ['project' => $project])
        ->assertViewHas('attachments', function ($attachments) {
            $imageAttachment = $attachments->firstWhere('filename', 'screenshot.png');
            $pdfAttachment = $attachments->firstWhere('filename', 'document.pdf');

            return $imageAttachment['is_image'] === true && $pdfAttachment['is_image'] === false;
        });
});

