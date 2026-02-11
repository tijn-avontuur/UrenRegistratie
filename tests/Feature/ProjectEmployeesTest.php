<?php

use App\Livewire\Projects\CreateTimeEntry;
use App\Livewire\Projects\ProjectEmployees;
use App\Models\Project;
use App\Models\User;
use App\Models\TimeEntry;
use Livewire\Livewire;

test('it kan een employee toevoegen aan een project', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();
    $employee = User::factory()->create(['role' => 'employee']);

    $this->actingAs($user);

    Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->set('selectedUserId', $employee->id)
        ->call('addEmployee')
        ->assertDispatched('employee-added');

    expect($project->fresh()->users)->toHaveCount(1);
    expect($project->fresh()->users->first()->id)->toBe($employee->id);
});

test('it kan een employee verwijderen van een project', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();
    $employee = User::factory()->create(['role' => 'employee']);

    $project->users()->attach($employee->id);

    $this->actingAs($user);

    Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->call('removeEmployee', $employee->id)
        ->assertDispatched('employee-removed');

    expect($project->fresh()->users)->toHaveCount(0);
});

test('it toont de toegewezen employees op de projectdetailpagina', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();
    $employee1 = User::factory()->create(['name' => 'Jan Jansen']);
    $employee2 = User::factory()->create(['name' => 'Piet Pietersen']);

    $project->users()->attach([$employee1->id, $employee2->id]);

    $this->actingAs($user);

    Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->assertSee('Jan Jansen')
        ->assertSee('Piet Pietersen')
        ->assertSee($employee1->email)
        ->assertSee($employee2->email);
});

test('it valideert dat een employee verplicht is bij toevoegen', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();

    $this->actingAs($user);

    Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->set('selectedUserId', '')
        ->call('addEmployee')
        ->assertHasErrors(['selectedUserId' => 'required']);
});

test('it voorkomt dubbele employee toewijzingen', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();
    $employee = User::factory()->create();

    $project->users()->attach($employee->id);

    $this->actingAs($user);

    Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->set('selectedUserId', $employee->id)
        ->call('addEmployee')
        ->assertHasErrors(['selectedUserId']);

    expect($project->fresh()->users)->toHaveCount(1);
});

test('it toont alleen beschikbare employees in de dropdown', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();
    $assignedEmployee = User::factory()->create(['name' => 'Toegewezen Medewerker']);
    $availableEmployee = User::factory()->create(['name' => 'Beschikbare Medewerker']);

    $project->users()->attach($assignedEmployee->id);

    $this->actingAs($user);

    $component = Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->call('openAddModal')
        ->assertSee('Beschikbare Medewerker');

    // Er zijn 3 users totaal (admin + assigned + available), minus 1 assigned = 2 available
    expect($component->get('availableUsers')->count())->toBe(2);
});

test('it kan alleen uren registreren voor projecten waar de user aan gekoppeld is', function () {
    $project = Project::factory()->create();
    $employee = User::factory()->create(['role' => 'employee']);

    // Koppel employee aan project
    $project->users()->attach($employee->id);

    $this->actingAs($employee);

    Livewire::test(CreateTimeEntry::class, ['projectId' => $project->id])
        ->set('project_id', $project->id)
        ->set('date', now()->format('Y-m-d'))
        ->set('start_time', '09:00')
        ->set('end_time', '17:00')
        ->call('save')
        ->assertDispatched('time-entry-created')
        ->assertDispatched('close');

    expect(TimeEntry::where('project_id', $project->id)->where('user_id', $employee->id)->count())->toBe(1);
});

test('it kan geen uren registreren voor projecten waar de user niet aan gekoppeld is', function () {
    $project = Project::factory()->create();
    $employee = User::factory()->create(['role' => 'employee']);

    // Koppel employee NIET aan project

    $this->actingAs($employee);

    Livewire::test(CreateTimeEntry::class, ['projectId' => $project->id])
        ->set('project_id', $project->id)
        ->set('date', now()->format('Y-m-d'))
        ->set('start_time', '09:00')
        ->set('end_time', '17:00')
        ->call('save')
        ->assertHasErrors(['project_id']);

    expect(TimeEntry::where('project_id', $project->id)->where('user_id', $employee->id)->count())->toBe(0);
});

test('it toont alleen projecten waar de user aan gekoppeld is in de projectenlijst', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $assignedProject = Project::factory()->create(['title' => 'Toegewezen Project']);
    $unassignedProject = Project::factory()->create(['title' => 'Niet Toegewezen Project']);

    $assignedProject->users()->attach($employee->id);

    $this->actingAs($employee);

    Livewire::test(CreateTimeEntry::class)
        ->assertSee('Toegewezen Project')
        ->assertDontSee('Niet Toegewezen Project');
});

test('it kan de add employee modal openen en sluiten', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();

    $this->actingAs($user);

    Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->assertSet('showAddModal', false)
        ->call('openAddModal')
        ->assertSet('showAddModal', true)
        ->set('showAddModal', false)
        ->assertSet('showAddModal', false);
});

test('it toont een bericht wanneer er geen beschikbare employees zijn', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();

    // Koppel alle bestaande users aan het project
    $allUsers = User::all();
    $project->users()->attach($allUsers->pluck('id'));

    $this->actingAs($user);

    $component = Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->call('openAddModal')
        ->assertSee('Geen beschikbare medewerkers');

    // Verify availableUsers is empty
    expect($component->get('availableUsers')->count())->toBe(0);
});

test('it toont employee initials correct', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();
    $employee1 = User::factory()->create(['name' => 'Jan Jansen']);
    $employee2 = User::factory()->create(['name' => 'Bob']);

    $project->users()->attach([$employee1->id, $employee2->id]);

    $this->actingAs($user);

    Livewire::test(ProjectEmployees::class, ['project' => $project])
        ->assertSee('JJ') // Jan Jansen
        ->assertSee('BO'); // Bob (eerste 2 letters als er maar 1 naam is)
});

test('it refresht de employee lijst na toevoegen', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $project = Project::factory()->create();
    $employee1 = User::factory()->create(['name' => 'Employee 1']);
    $employee2 = User::factory()->create(['name' => 'Employee 2']);

    $this->actingAs($user);

    $component = Livewire::test(ProjectEmployees::class, ['project' => $project]);

    // Voeg eerste employee toe
    $component
        ->call('openAddModal')
        ->set('selectedUserId', $employee1->id)
        ->call('addEmployee');

    // Verifieer dat employee 1 is toegevoegd
    expect($project->fresh()->users)->toHaveCount(1);
    expect($project->fresh()->users->first()->id)->toBe($employee1->id);

    // Open modal opnieuw en verifieer dat er nu 1 minder beschikbare user is
    $component
        ->call('openAddModal');

    $availableCount = $component->get('availableUsers')->count();
    // Er zijn 3 users (admin + employee1 + employee2), minus 1 toegewezen = 2 beschikbaar
    expect($availableCount)->toBe(2);});
