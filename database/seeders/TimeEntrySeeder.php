<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class TimeEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $projects = Project::all();

        // Create time entries for the past 30 days
        foreach ($users as $user) {
            // Get projects this user is assigned to
            $userProjects = $projects->filter(function ($project) use ($user) {
                return $project->users->contains($user);
            });

            if ($userProjects->isEmpty()) {
                // Assign to at least 2 projects if none assigned
                $assignedProjects = $projects->random(min(2, $projects->count()));
                foreach ($assignedProjects as $project) {
                    $project->users()->attach($user->id);
                }
                $userProjects = $assignedProjects;
            }

            // Create time entries for past 30 days
            for ($i = 0; $i < 30; $i++) {
                $date = now()->subDays($i);

                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }

                // 80% chance to have entries for a work day
                if (rand(1, 100) <= 80) {
                    // Create 1-3 time entries per day
                    $entriesCount = rand(1, 3);

                    for ($j = 0; $j < $entriesCount; $j++) {
                        $project = $userProjects->random();

                        // Generate realistic work hours (9:00 - 17:00)
                        $startHour = rand(9, 15);
                        $startMinute = [0, 15, 30, 45][rand(0, 3)];
                        $durationMinutes = [30, 60, 90, 120, 180, 240][rand(0, 5)];

                        $startTime = $date->copy()->setTime($startHour, $startMinute);
                        $endTime = $startTime->copy()->addMinutes($durationMinutes);

                        TimeEntry::factory()->create([
                            'user_id' => $user->id,
                            'project_id' => $project->id,
                            'date' => $date->format('Y-m-d'),
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'duration_minutes' => $durationMinutes,
                            'source' => ['manual', 'timer', 'import'][rand(0, 2)],
                        ]);
                    }
                }
            }
        }

        $this->command->info('Time entries created successfully!');
    }
}
