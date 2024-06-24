<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Avi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AviSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $avis = [
            [
                'note' => 1,
                'commentaire' => 'Commentaire pour film 1 par client 1',
                'film_id' => 1,
                'client_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'note' => 2,
                'commentaire' => 'Commentaire pour film 2 par client 2',
                'film_id' => 2,
                'client_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Ajoutez d'autres avis ici
        ];

        Avi::insert($avis);
    }
}
