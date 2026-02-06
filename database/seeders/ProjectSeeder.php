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
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Ontwikkeling van iOS en Android applicatie',
                'color' => '#10B981',
            ],
            [
                'title' => 'Database Migration',
                'description' => 'Migratie van legacy database naar nieuwe infrastructuur',
                'color' => '#F59E0B',
            ],
            [
                'title' => 'API Integration',
                'description' => 'Integratie met externe API services',
                'color' => '#EF4444',
            ],
            [
                'title' => 'Security Audit',
                'description' => 'Beveiligingsaudit en implementatie van verbeteringen',
                'color' => '#8B5CF6',
            ],
            [
                'title' => 'Client Portal',
                'description' => 'Ontwikkeling van klantportaal voor self-service',
                'color' => '#06B6D4',
            ],
            [
                'title' => 'Internal Training',
                'description' => 'Interne trainingen en kennisoverdracht',
                'color' => '#EC4899',
            ],
            [
                'title' => 'DevOps Setup',
                'description' => 'Opzetten van CI/CD pipeline en deployment automation',
                'color' => '#14B8A6',
            ],
        ];

        foreach ($projectsData as $projectData) {
            Project::factory()->create($projectData);
        }

        $this->command->info('Projects created successfully!');
    }
}
