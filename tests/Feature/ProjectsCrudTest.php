<?php

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAttachment;
use App\Livewire\Projects\ProjectsList;
use App\Livewire\Projects\CreateProject;
use App\Livewire\Projects\EditProject;
use Livewire\Livewire;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    Storage::fake('public');
});

it('kan de projectenlijst weergeven', function () {
    $projects = Project::factory()->count(3)->create();

    Livewire::test(ProjectsList::class)
        ->assertViewHas('projects', function ($viewProjects) use ($projects) {
            return $viewProjects->count() === 3;
        });
});

it('kan een nieuw project aanmaken', function () {
    Livewire::test(CreateProject::class)
        ->set('title', 'Test Project')
        ->set('description', 'Test beschrijving')
        ->set('color', '#3b82f6')
        ->call('save')
        ->assertDispatched('project-created')
        ->assertDispatched('modal-closed')
        ->assertSet('show', false);

    $this->assertDatabaseHas('projects', [
        'title' => 'Test Project',
        'description' => 'Test beschrijving',
        'color' => '#3b82f6',
    ]);
});

it('valideert verplichte velden bij het aanmaken van een project', function () {
    Livewire::test(CreateProject::class)
        ->set('title', '')
        ->call('save')
        ->assertHasErrors(['title' => 'required']);
});

it('kan een bestaand project bewerken', function () {
    $project = Project::factory()->create([
        'title' => 'Oud Project',
        'description' => 'Oude beschrijving',
    ]);

    Livewire::test(EditProject::class, ['project' => $project])
        ->set('title', 'Bijgewerkt Project')
        ->set('description', 'Bijgewerkte beschrijving')
        ->set('color', '#ff0000')
        ->call('update')
        ->assertDispatched('project-updated')
        ->assertDispatched('modal-closed')
        ->assertSet('show', false);

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'Bijgewerkt Project',
        'description' => 'Bijgewerkte beschrijving',
        'color' => '#ff0000',
    ]);
});

it('kan een project verwijderen', function () {
    $project = Project::factory()->create();

    Livewire::test(ProjectsList::class)
        ->call('deleteProject', $project->id)
        ->assertDispatched('project-deleted');

    $this->assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});

it('laadt projecten opnieuw na een wijziging', function () {
    $initialCount = Project::count();

    $component = Livewire::test(ProjectsList::class)
        ->assertViewHas('projects', function ($projects) use ($initialCount) {
            return $projects->count() === $initialCount;
        });

    Project::factory()->create();

    // Dispatch an event to trigger re-render with fresh data
    $component->dispatch('project-created')
        ->assertViewHas('projects', function ($projects) use ($initialCount) {
            return $projects->count() === $initialCount + 1;
        });
});

it('sluit modals correct af', function () {
    Livewire::test(ProjectsList::class)
        ->call('openCreateModal')
        ->assertSet('showCreateModal', true)
        ->dispatch('modal-closed')
        ->assertSet('showCreateModal', false);
});

it('kan modal annuleren', function () {
    Livewire::test(CreateProject::class)
        ->assertSet('show', true)
        ->call('closeModal')
        ->assertDispatched('modal-closed')
        ->assertSet('show', false);
});

it('kan een project aanmaken met attachments', function () {
    $file1 = UploadedFile::fake()->create('document1.pdf', 1024);
    $file2 = UploadedFile::fake()->create('document2.docx', 512);

    Livewire::test(CreateProject::class)
        ->set('title', 'Test Project')
        ->set('description', 'Test beschrijving')
        ->set('color', '#3b82f6')
        ->set('attachments', [$file1, $file2])
        ->call('save')
        ->assertDispatched('project-created');

    $project = Project::where('title', 'Test Project')->first();

    expect($project->projectAttachments)->toHaveCount(2);

    $this->assertDatabaseHas('project_attachments', [
        'project_id' => $project->id,
        'filename' => 'document1.pdf',
    ]);

    $this->assertDatabaseHas('project_attachments', [
        'project_id' => $project->id,
        'filename' => 'document2.docx',
    ]);
});

it('kan attachments toevoegen bij het bewerken van een project', function () {
    $project = Project::factory()->create();
    $file = UploadedFile::fake()->create('new-document.pdf', 1024);

    Livewire::test(EditProject::class, ['project' => $project])
        ->set('attachments', [$file])
        ->call('update')
        ->assertDispatched('project-updated');

    $this->assertDatabaseHas('project_attachments', [
        'project_id' => $project->id,
        'filename' => 'new-document.pdf',
    ]);
});

it('kan bestaande attachments verwijderen bij het bewerken', function () {
    $project = Project::factory()->create();
    $attachment = ProjectAttachment::factory()->create([
        'project_id' => $project->id,
        'filepath' => 'project-attachments/test.pdf',
    ]);

    Storage::disk('public')->put($attachment->filepath, 'test content');

    Livewire::test(EditProject::class, ['project' => $project])
        ->call('deleteExistingAttachment', $attachment->id);

    $this->assertDatabaseMissing('project_attachments', [
        'id' => $attachment->id,
    ]);

    Storage::disk('public')->assertMissing($attachment->filepath);
});

it('kan nieuwe attachments verwijderen voor opslaan', function () {
    $file1 = UploadedFile::fake()->create('document1.pdf', 1024);
    $file2 = UploadedFile::fake()->create('document2.pdf', 1024);

    Livewire::test(CreateProject::class)
        ->set('attachments', [$file1, $file2])
        ->call('removeAttachment', 0)
        ->assertCount('attachments', 1);
});

it('kan een project aanmaken met start en einddatum', function () {
    Livewire::test(CreateProject::class)
        ->set('title', 'Test Project')
        ->set('description', 'Test beschrijving')
        ->set('color', '#3b82f6')
        ->set('start_date', '2026-02-01')
        ->set('end_date', '2026-06-30')
        ->call('save')
        ->assertDispatched('project-created');

    $project = Project::where('title', 'Test Project')->first();

    expect($project->start_date->format('Y-m-d'))->toBe('2026-02-01');
    expect($project->end_date->format('Y-m-d'))->toBe('2026-06-30');
});

it('valideert dat einddatum na of gelijk aan startdatum moet zijn', function () {
    Livewire::test(CreateProject::class)
        ->set('title', 'Test Project')
        ->set('start_date', '2026-06-30')
        ->set('end_date', '2026-02-01')
        ->call('save')
        ->assertHasErrors(['end_date' => 'after_or_equal']);
});

it('kan datums bijwerken bij het bewerken van een project', function () {
    $project = Project::factory()->create([
        'start_date' => '2026-01-01',
        'end_date' => '2026-03-31',
    ]);

    Livewire::test(EditProject::class, ['project' => $project])
        ->set('start_date', '2026-02-01')
        ->set('end_date', '2026-12-31')
        ->call('update')
        ->assertDispatched('project-updated');

    $project->refresh();

    expect($project->start_date->format('Y-m-d'))->toBe('2026-02-01');
    expect($project->end_date->format('Y-m-d'))->toBe('2026-12-31');
});


