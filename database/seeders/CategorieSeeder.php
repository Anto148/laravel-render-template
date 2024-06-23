<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
           ['titre' => 'Action'],
            ['titre' => 'Comédie'],
            ['titre' => 'Drame'],
            ['titre' => 'Horreur'],
            ['titre' => 'Science-fiction'],
            ['titre' => 'Documentaire'],
            ['titre' => 'Animation'],
            ['titre' => 'Aventure'],
            ['titre' => 'Romance'],
            ['titre' => 'Fantastique'],
        ];

        Categorie::insert($categories);
    }
}
