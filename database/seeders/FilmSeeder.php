<?php

namespace Database\Seeders;

use App\Models\Avi;
use App\Models\Film;
use App\Models\User;
use App\Models\Acteur;
use App\Models\Categorie;
use App\Models\Realisateur;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $realisateurs = Realisateur::all();
        $acteurs = Acteur::all();
        $categories = Categorie::all();
        $clients = User::whereHas('roles', function ($query) {
            $query->where('title', 'Client');
        })->get()->pluck('id')->first();

        // if ($realisateurs->isEmpty() || $acteurs->isEmpty() || $categories->isEmpty() || $clients->isEmpty()) {
        //     $this->command->info('Please seed Realisateur, Acteur, Categorie, and User (clients) tables first.');
        //     return;
        // }

        $films = [
            [
                'titre' => 'Spider-Man: Across the Spider-Verse',
                'synopsis' => 'Miles Morales catapulte à travers le Multivers où il rencontre une équipe de Spider-People chargée de protéger son existence.',
                'duree' => '2h20',
                'cover_url' => 'https://static.wikia.nocookie.net/filmguide/images/e/eb/Spider-Man_Across_the_Spider-Verse_Official_Poster.jpg/revision/latest?cb=20230503163509',
                'bande_annonce' => 'https://youtu.be/GtJX3gJInig',
                'date_sortie' => '02-06-2023',
                'limite_age' => 12,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Oppenheimer',
                'synopsis' => 'L’histoire de J. Robert Oppenheimer et de son rôle dans le développement de la bombe atomique pendant la Seconde Guerre mondiale.',
                'duree' => '3h',
                'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/4/4a/Oppenheimer_%28film%29.jpg',
                'bande_annonce' => 'https://youtu.be/CoXtvSRpHgM',
                'date_sortie' => '21-05-2023',
                'limite_age' => 16,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Mission: Impossible - Dead Reckoning Part One',
                'synopsis' => 'Ethan Hunt et son équipe doivent suivre une nouvelle mission périlleuse impliquant une menace globale.',
                'duree' => '2h43',
                'cover_url' => 'https://c8.alamy.com/comp/2R8D1CW/mission-impossible-dead-reckoning-part-one-aka-mission-impossible-7-character-poster-tom-cruise-2023-paramount-pictures-courtesy-everett-collection-2R8D1CW.jpg',
                'bande_annonce' => 'https://youtu.be/AzRdtaXA3VM',
                'date_sortie' => '12-07-2023',
                'limite_age' => 13,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Barbie',
                'synopsis' => 'Une poupée vivant à Barbieland est expulsée pour ne pas être assez parfaite et part à l’aventure dans le monde réel.',
                'duree' => '1h54',
                'cover_url' => 'https://image.tmdb.org/t/p/original/u5kboZR4OMi4QdbOhawCZuzMVWJ.jpg',
                'bande_annonce' => 'https://youtu.be/2oOzWcbVf1c',
                'date_sortie' => '21-07-2023',
                'limite_age' => 7,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Guardiens de la Galaxy Vol. 3',
                'synopsis' => 'Les Gardiens se lancent dans une mission pour sauver leur ami Rocket.',
                'duree' => '2h30',
                'cover_url' => 'https://fr.web.img3.acsta.net/c_310_420/pictures/23/02/13/11/43/2783447.jpg',
                'bande_annonce' => 'https://youtu.be/bT4APPIcGcU',
                'date_sortie' => '05-05-2023',
                'limite_age' => 12,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Fast X',
                'synopsis' => 'Dom Toretto et son équipe affrontent un nouvel ennemi puissant et redoutable.',
                'duree' => '2h21',
                'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f2/Fast_X_poster.jpg',
                'bande_annonce' => 'https://youtu.be/-WjVobqh-oU',
                'date_sortie' => '19-04-2023',
                'limite_age' => 13,
                'audio' => 'VF',
            ],
            [
                'titre' => 'John Wick: Chapter 4',
                'synopsis' => 'John Wick découvre un moyen de vaincre la Table, mais avant de gagner sa liberté, il doit affronter un nouvel ennemi avec des alliances puissantes à travers le monde.',
                'duree' => '2h49',
                'cover_url' => 'https://m.media-amazon.com/images/I/81s6TwmHtTL._AC_UF894,1000_QL80_.jpg',
                'bande_annonce' => 'https://youtu.be/G79ZBcnuluQ',
                'date_sortie' => '24-04-2023',
                'limite_age' => 16,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Dune: Partie 2',
                'synopsis' => 'Paul Atreides s’allie avec les Fremen pour mener une rébellion contre ceux qui ont détruit sa famille.',
                'duree' => '2h45',
                'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/5/52/Dune_Part_Two_poster.jpeg',
                'bande_annonce' => 'https://youtu.be/SUfv36bB5jA',
                'date_sortie' => '28-02-2024',
                'limite_age' => 13,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Indiana Jones et le Cadran de la Destinée',
                'synopsis' => 'Indiana Jones revient pour une dernière aventure en quête d’un mystérieux artefact.',
                'duree' => '2h22',
                'cover_url' => 'https://fr.web.img2.acsta.net/pictures/23/06/07/14/33/5787419.jpg',
                'bande_annonce' => 'https://youtu.be/4tvtYAMPsxI',
                'date_sortie' => '30-06-2023',
                'limite_age' => 12,
                'audio' => 'VF',
            ],
            [
                'titre' => 'Transformers: Rise of the Beasts',
                'synopsis' => 'Une nouvelle aventure Transformers se déroulant dans les années 90 et présentant les Beast Wars.',
                'duree' => '2h07',
                'cover_url' => 'https://wallpapercave.com/wp/wp11971177.jpg',
                'bande_annonce' => 'https://youtu.be/BO9d1C9ZsCs',
                'date_sortie' => '07-06-2023',
                'limite_age' => 12,
                'audio' => 'VF',
            ],
        ];
        $cover_files_path = database_path('seeders/covers/');

        foreach ($films as $filmData) {
            $film = Film::create($filmData);

            $film->realisateurs()->attach($realisateurs->random(rand(1, 3))->pluck('id')->toArray());
            $film->acteurs()->attach($acteurs->random(rand(1, 5))->pluck('id')->toArray());
            $film->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());

            // Ajouter des avis
            $notes = [];
            for ($i = 0; $i < rand(5, 15); $i++) {
                $note = rand(1, 10);
                $notes[] = $note;
                Avi::create([
                    'note' => $note,
                    'commentaire' => 'Commentaire ' . Str::random(10),
                    'film_id' => $film->id,
                    'client_id' => $clients,
                ]);
            }

            // Ajouter des cover
            if(file_exists($cover_files_path.$film['date_sortie'].'.jpg')) {
                $film->addMedia($cover_files_path . '/' . $film['date_sortie'] . '.jpg')->preservingOriginal()->toMediaCollection(Film::COVER_MEDIA_COLLECTION);
            }


            // Calculer la moyenne des notes
            $film->moyenne_note = count($notes) ? array_sum($notes) / count($notes) : null;
            $film->save();
        }

    }
}
