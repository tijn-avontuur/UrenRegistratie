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

        // Create time entries for the past 90 days (3 months)
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

            // Determine work intensity per user (some work more than others)
            $workIntensity = rand(60, 95); // 60-95% chance to work on a given day

            // Create time entries for past 90 days
            for ($i = 0; $i < 90; $i++) {
                $date = now()->subDays($i);

                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }

                // Variable chance to have entries based on work intensity
                if (rand(1, 100) <= $workIntensity) {
                    // Create 2-4 time entries per day for more realistic workload
                    $entriesCount = rand(2, 4);

                    for ($j = 0; $j < $entriesCount; $j++) {
                        $project = $userProjects->random();

                        // Generate realistic work hours (8:00 - 18:00)
                        $startHour = rand(8, 16);
                        $startMinute = [0, 15, 30, 45][rand(0, 3)];
                        // Varied durations: 30min to 4 hours
                        $durationMinutes = [30, 45, 60, 90, 120, 150, 180, 240][rand(0, 7)];

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
