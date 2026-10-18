<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Intentionally seeds nothing: every user is a full admin, so a seeded account with a known
     * password would be a backdoor. Create staff with `php artisan make:filament-user`.
     */
    public function run(): void
    {
        //
    }
}
