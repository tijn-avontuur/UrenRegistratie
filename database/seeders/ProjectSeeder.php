<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectsData = [
            [
                'title' => 'Website Redesign',
                'description' => 'Complete redesign van de bedrijfswebsite met moderne UI/UX',
                'color' => '#422AD5',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(1),
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Ontwikkeling van iOS en Android applicatie',
                'color' => '#10B981',
                'start_date' => now()->subMonth(),
                'end_date' => now()->addMonths(4),
            ],
            [
                'title' => 'Database Migration',
                'description' => 'Migratie van legacy database naar nieuwe infrastructuur',
                'color' => '#F59E0B',
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
            ],
            [
                'title' => 'API Integration',
                'description' => 'Integratie met externe API services',
                'color' => '#EF4444',
                'start_date' => now()->addWeek(),
                'end_date' => now()->addMonths(3),
            ],
            [
                'title' => 'Security Audit',
                'description' => 'Beveiligingsaudit en implementatie van verbeteringen',
                'color' => '#8B5CF6',
                'start_date' => now()->subMonths(3),
                'end_date' => now()->subMonth(),
            ],
            [
                'title' => 'Client Portal',
                'description' => 'Ontwikkeling van klantportaal voor self-service',
                'color' => '#06B6D4',
                'start_date' => now()->addMonth(),
                'end_date' => now()->addMonths(5),
            ],
            [
                'title' => 'Internal Training',
                'description' => 'Interne trainingen en kennisoverdracht',
                'color' => '#EC4899',
                'start_date' => now()->subWeeks(2),
                'end_date' => now()->addWeeks(6),
            ],
            [
                'title' => 'DevOps Setup',
                'description' => 'Opzetten van CI/CD pipeline en deployment automation',
                'color' => '#14B8A6',
                'start_date' => now()->addMonths(2),
                'end_date' => now()->addMonths(4),
            ],
        ];

        foreach ($projectsData as $projectData) {
            Project::factory()->create($projectData);
        }

        $this->command->info('Projects created successfully!');
    }
}
