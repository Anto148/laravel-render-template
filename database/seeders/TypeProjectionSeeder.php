<?php

namespace Database\Seeders;

use App\Models\Type_projection;

use Dedoc\Scramble\Support\Generator\Types\Type;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeProjectionSeeder extends Seeder
{
   public function run(): void
   {
    $typeProjections = [
        [
            'nom' => 'Avant-première',
            'prix_enfant' => 7000,
            'prix_adulte' => 7000,
        ],
        [
            'nom' => 'Première',
            'prix_enfant' => 5000,
            'prix_adulte' => 5000,
        ],
        [
            'nom' => 'Standards',
            'prix_enfant' => 1000,
            'prix_adulte' => 2000,
        ],
    ];

    Type_projection::insert($typeProjections);

   }
}
