<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProjectSeeder::class,
            ProjectUserSeeder::class,
            TimeEntrySeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('Database seeded successfully!');
        $this->command->info('-----------------------------------');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@urenapp.nl / password');
        $this->command->info('Alex De Vries: alex@urenapp.nl / password');
        $this->command->info('All other users: password');
        $this->command->info('-----------------------------------');
    }
}

