<?php

namespace Database\Seeders;

use App\Models\Type_projection;
use Carbon\Carbon;
use App\Models\Film;
use App\Models\Projection;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Récupérer quelques films, salles et types de projection existants pour les utiliser dans les projections
         $films = Film::all();
        //  $salles = Salle::all();
         $typeProjections = Type_projection::all();

         // Définir les jours de projection (mardi à dimanche)
         $days = ['Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

         // Générer 19 projections
         for ($i = 0; $i < 19; $i++) {
             $day = $days[array_rand($days)]; // Sélectionner un jour aléatoire de la semaine
             $date = Carbon::now()->next($day); // Prochain jour spécifié
             $heure = rand(10, 22) . ':00:00'; // Heure aléatoire entre 10h00 et 22h00

             // Sélectionner un film, une salle et un type de projection aléatoires
             $film = $films->random();
            //  $salle = $salles->random();
             $typeProjection = $typeProjections->random();

             Projection::create([
                 'date_projection' => $date->toDateString(),
                 'heure_projection' => $heure,
                 'en_3d' => (bool)rand(0, 1),
                 'film_id' => $film->id,
                //  'salle_id' => $salle->id,
                 'type_projection_id' => $typeProjection->id,
             ]);
         }
    }
}
