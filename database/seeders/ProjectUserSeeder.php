<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $projects = Project::all();

        // Assign 3-6 random users to each project
        foreach ($projects as $project) {
            $projectUsers = $users->random(rand(3, min(6, $users->count())));
            $project->users()->attach($projectUsers->pluck('id'));
        }

        $this->command->info('Users assigned to projects successfully!');
    }
}
