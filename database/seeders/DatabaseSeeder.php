<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            UserSeeder::class,
            AppConfigurationSeeder::class,
            CategorieSeeder::class,
            ActeurSeeder::class,
            RealisateurSeeder::class,
            FilmSeeder::class
        ]);
    }
}
