<?php

namespace Database\Seeders;

use App\Models\Acteur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActeurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acteurs = [
            ['nom' => 'DiCaprio', 'prenom' => 'Leonardo'],
            ['nom' => 'Pitt', 'prenom' => 'Brad'],
            ['nom' => 'Streep', 'prenom' => 'Meryl'],
            ['nom' => 'Hanks', 'prenom' => 'Tom'],
            ['nom' => 'Johansson', 'prenom' => 'Scarlett'],
            ['nom' => 'Depp', 'prenom' => 'Johnny'],
            ['nom' => 'Lawrence', 'prenom' => 'Jennifer'],
            ['nom' => 'Downey', 'prenom' => 'Robert'],
            ['nom' => 'Jolie', 'prenom' => 'Angelina'],
            ['nom' => 'Freeman', 'prenom' => 'Morgan']

        ];

        Acteur::insert($acteurs);
    }
}
