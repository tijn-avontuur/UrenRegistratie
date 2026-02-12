<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

#[Layout('layouts.app')]
#[Title('Medewerkers')]
class AdminUsers extends Component
{
    public $startDate = '';
    public $endDate = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function mount()
    {
        // Controleer of de gebruiker een admin is
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Toegang geweigerd. Alleen administrators hebben toegang tot deze pagina.');
        }

        // Default: huidige maand
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetFilters()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->sortBy = 'name';
        $this->sortDirection = 'asc';
    }

    public function setThisMonth()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function setLastMonth()
    {
        $this->startDate = now()->subMonth()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->subMonth()->endOfMonth()->format('Y-m-d');
    }

    public function setThisYear()
    {
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->endOfYear()->format('Y-m-d');
    }

    #[Computed]
    public function employeeStats()
    {
        $users = User::all();

        $stats = $users->map(function ($user) {
            $query = TimeEntry::where('user_id', $user->id);

            if ($this->startDate) {
                $query->where('date', '>=', $this->startDate);
            }

            if ($this->endDate) {
                $query->where('date', '<=', $this->endDate);
            }

            $totalMinutes = $query->sum('duration_minutes');
            $totalHours = round($totalMinutes / 60, 2);
            $entryCount = $query->count();

            return [
                'user' => $user,
                'total_minutes' => $totalMinutes,
                'total_hours' => $totalHours,
                'entry_count' => $entryCount,
            ];
        });

        // Sort the collection
        if ($this->sortBy === 'name') {
            $stats = $this->sortDirection === 'asc'
                ? $stats->sortBy(fn($stat) => $stat['user']->name)
                : $stats->sortByDesc(fn($stat) => $stat['user']->name);
        } elseif ($this->sortBy === 'hours') {
            $stats = $this->sortDirection === 'asc'
                ? $stats->sortBy('total_hours')
                : $stats->sortByDesc('total_hours');
        } elseif ($this->sortBy === 'entries') {
            $stats = $this->sortDirection === 'asc'
                ? $stats->sortBy('entry_count')
                : $stats->sortByDesc('entry_count');
        }

        return $stats->values();
    }

    #[Computed]
    public function totalHours()
    {
        return $this->employeeStats->sum('total_hours');
    }

    #[Computed]
    public function totalEntries()
    {
        return $this->employeeStats->sum('entry_count');
    }

    #[Computed]
    public function averageHoursPerEmployee()
    {
        $count = $this->employeeStats->count();
        return $count > 0 ? round($this->totalHours / $count, 2) : 0;
    }

    public function render()
    {
        return view('livewire.admin-users');
    }
}
