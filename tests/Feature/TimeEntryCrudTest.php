<?php

use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\Livewire\Projects\CreateTimeEntry;
use App\Livewire\Projects\EditTimeEntry;
use App\Livewire\Projects\TimeEntriesList;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->project = Project::factory()->create();
});

it('kan een nieuwe tijdsregistratie aanmaken', function () {
    Livewire::test(CreateTimeEntry::class)
        ->set('project_id', $this->project->id)
        ->set('date', '2026-02-10')
        ->set('start_time', '09:00')
        ->set('end_time', '17:00')
        ->call('save')
        ->assertDispatched('time-entry-created')
        ->assertDispatched('close');

    $this->assertDatabaseHas('time_entries', [
        'user_id' => $this->user->id,
        'project_id' => $this->project->id,
        'duration_minutes' => 480, // 8 uur = 480 minuten
        'source' => 'manual',
    ]);

    $timeEntry = TimeEntry::where('user_id', $this->user->id)->first();
    expect($timeEntry->date->format('Y-m-d'))->toBe('2026-02-10');
});

it('valideert dat eindtijd na begintijd moet zijn', function () {
    Livewire::test(CreateTimeEntry::class)
        ->set('project_id', $this->project->id)
        ->set('date', '2026-02-10')
        ->set('start_time', '17:00')
        ->set('end_time', '09:00')
        ->call('save')
        ->assertHasErrors(['end_time' => 'after']);
});

it('valideert verplichte velden bij tijdsregistratie', function () {
    Livewire::test(CreateTimeEntry::class)
        ->set('project_id', '')
        ->set('date', '')
        ->set('start_time', '')
        ->set('end_time', '')
        ->call('save')
        ->assertHasErrors([
            'project_id' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
});

it('berekent de duur correct in minuten', function () {
    Livewire::test(CreateTimeEntry::class)
        ->set('project_id', $this->project->id)
        ->set('date', '2026-02-10')
        ->set('start_time', '09:00')
        ->set('end_time', '12:30')
        ->call('save');

    $this->assertDatabaseHas('time_entries', [
        'user_id' => $this->user->id,
        'duration_minutes' => 210, // 3,5 uur = 210 minuten
    ]);
});

it('kan een bestaande tijdsregistratie bewerken', function () {
    $timeEntry = TimeEntry::factory()->create([
        'user_id' => $this->user->id,
        'project_id' => $this->project->id,
        'date' => '2026-02-10',
        'start_time' => '2026-02-10 09:00:00',
        'end_time' => '2026-02-10 17:00:00',
        'duration_minutes' => 480,
        'source' => 'manual',
    ]);

    Livewire::test(EditTimeEntry::class, ['timeEntry' => $timeEntry])
        ->set('date', '2026-02-11')
        ->set('start_time', '10:00')
        ->set('end_time', '18:00')
        ->call('update')
        ->assertDispatched('time-entry-updated')
        ->assertDispatched('close');

    $this->assertDatabaseHas('time_entries', [
        'id' => $timeEntry->id,
        'duration_minutes' => 480,
    ]);

    $timeEntry->refresh();
    expect($timeEntry->date->format('Y-m-d'))->toBe('2026-02-11');
});

it('kan een tijdsregistratie verwijderen', function () {
    $timeEntry = TimeEntry::factory()->create([
        'user_id' => $this->user->id,
        'project_id' => $this->project->id,
    ]);

    Livewire::test(TimeEntriesList::class)
        ->call('deleteTimeEntry', $timeEntry->id)
        ->assertDispatched('time-entry-deleted');

    $this->assertDatabaseMissing('time_entries', [
        'id' => $timeEntry->id,
    ]);
});

it('toont alleen tijdsregistraties van de ingelogde gebruiker', function () {
    $otherUser = User::factory()->create();

    TimeEntry::factory()->create([
        'user_id' => $this->user->id,
        'project_id' => $this->project->id,
    ]);

    TimeEntry::factory()->create([
        'user_id' => $otherUser->id,
        'project_id' => $this->project->id,
    ]);

    Livewire::test(TimeEntriesList::class)
        ->assertViewHas('timeEntries', function ($timeEntries) {
            return $timeEntries->count() === 1 && $timeEntries->first()->user_id === auth()->id();
        });
});

it('valideert tijdsformaat correct', function () {
    Livewire::test(CreateTimeEntry::class)
        ->set('project_id', $this->project->id)
        ->set('date', '2026-02-10')
        ->set('start_time', 'invalid')
        ->set('end_time', 'invalid')
        ->call('save')
        ->assertHasErrors([
            'start_time' => 'date_format',
            'end_time' => 'date_format',
        ]);
});
