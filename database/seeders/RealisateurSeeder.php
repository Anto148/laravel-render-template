<?php

namespace Database\Seeders;

use App\Models\Realisateur;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RealisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $realisateurs = [
            ['nom' => 'Spielberg', 'prenom' => 'Steven'],
            ['nom' => 'Nolan', 'prenom' => 'Christopher'],
            ['nom' => 'Scorsese', 'prenom' => 'Martin'],
            ['nom' => 'Tarantino', 'prenom' => 'Quentin'],
            ['nom' => 'Cameron', 'prenom' => 'James'],
            ['nom' => 'Burton', 'prenom' => 'Tim'],
            ['nom' => 'Coen', 'prenom' => 'Joel'],
            ['nom' => 'Coen', 'prenom' => 'Ethan'],
            ['nom' => 'Kubrick', 'prenom' => 'Stanley'],
            ['nom' => 'Scott', 'prenom' => 'Ridley']
        ];

        Realisateur::insert($realisateurs);
    }
}
