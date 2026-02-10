<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Livewire\Component;

class EditTimeEntry extends Component
{
    public TimeEntry $timeEntry;
    public $project_id = '';
    public $date = '';
    public $start_time = '';
    public $end_time = '';
    public $projects = [];

    public function mount(TimeEntry $timeEntry)
    {
        $this->timeEntry = $timeEntry;
        $this->project_id = $timeEntry->project_id;
        $this->date = $timeEntry->date->format('Y-m-d');
        $this->start_time = $timeEntry->start_time->format('H:i');
        $this->end_time = $timeEntry->end_time ? $timeEntry->end_time->format('H:i') : '';

        // Only show projects where the user is assigned
        $this->projects = Project::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id());
        })->orderBy('title')->get();
    }

    protected function rules()
    {
        return [
            'project_id' => [
                'required',
                'exists:projects,id',
                function ($attribute, $value, $fail) {
                    $project = Project::find($value);
                    if ($project && !$project->users()->where('user_id', auth()->id())->exists()) {
                        $fail('Je bent niet gekoppeld aan dit project en kunt er geen uren voor registreren.');
                    }
                },
            ],
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }

    protected function messages()
    {
        return [
            'end_time.after' => 'De eindtijd moet na de begintijd zijn.',
            'project_id.required' => 'Selecteer een project.',
            'project_id.exists' => 'Het geselecteerde project is ongeldig.',
            'date.required' => 'Vul een datum in.',
            'date.date' => 'Vul een geldige datum in.',
            'start_time.required' => 'Vul een begintijd in.',
            'start_time.date_format' => 'Vul een geldige tijd in (HH:MM).',
            'end_time.required' => 'Vul een eindtijd in.',
            'end_time.date_format' => 'Vul een geldige tijd in (HH:MM).',
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        // Combine date with times
        $startDateTime = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
        $endDateTime = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);

        // Calculate duration in minutes
        $durationMinutes = $startDateTime->diffInMinutes($endDateTime);

        $this->timeEntry->update([
            'project_id' => $validated['project_id'],
            'date' => $validated['date'],
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
            'duration_minutes' => $durationMinutes,
        ]);

        $this->dispatch('time-entry-updated');
        $this->dispatch('close');
    }

    public function render()
    {
        return view('livewire.projects.edit-time-entry');
    }
}
