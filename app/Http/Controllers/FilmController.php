<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Film\StoreFilmRequest;
use App\Http\Requests\Film\SearchFilmRequest;
use App\Http\Requests\Film\UpdateFilmRequest;
use App\Http\Resources\Film\FilmListResource;
use App\Http\Resources\Film\FilmShowResource;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends Controller
{

    public function index(Request $request)
    {
        // $this->checkGate('film_access');

        return FilmListResource::collection($request->per_page ? Film::with(['realisateurs', 'acteurs', 'categories'])->orderByDesc('created_at')->paginate($request->per_page) : Film::with(['realisateurs', 'acteurs', 'categories'])->orderByDesc('created_at')->get());

    }

    public function search(SearchFilmRequest $request){

        $titre = $request->titre;
        $acteurs = $request->acteurs;
        $realisateurs = $request->realisateurs;
        $categories = $request->categories;
        $per_page = $request->per_page ?? 10;

        $films = Film::with(['realisateurs', 'acteurs', 'categories'])->orderByDesc('created_at');

        if($titre){

            $films = $films->where('titre', 'LIKE', '%'.$titre.'%');
        }

        if($acteurs){

            $films = $films->whereHas('acteurs', function($q) use ($acteurs){
                $q->where(function($query) use ($acteurs) {
                    foreach ($acteurs as $acteur) {
                        $query->orWhere('nom', $acteur)
                              ->orWhere('prenom', $acteur)
                              ->orWhere(DB::raw("CONCAT(prenom, ' ', nom)"), $acteur);
                    }
                });
            });
        }

        if($realisateurs) {
            $films = $films->whereHas('realisateurs', function($q) use ($realisateurs) {
                $q->where(function($query) use ($realisateurs) {
                    foreach ($realisateurs as $realisateur) {
                        $query->orWhere('nom', $realisateur)
                              ->orWhere('prenom', $realisateur)
                              ->orWhere(DB::raw("CONCAT(prenom, ' ', nom)"), $realisateur);
                    }
                });
            });
        }

        if($categories){

            $films = $films->whereHas('categories', function($q) use ($categories){
                $q->whereIn('titre', $categories);
            });
        }

        return FilmListResource::collection($films->paginate($per_page));

    }


    public function store(StoreFilmRequest $request)
    {
        if(Film::where('title', $request->title)->exists())
        {
            $film = Film::where('title', $request->title)->first();
            $film->update($request->all());
            $film->recalculateMoyenneNote();
            return (new FilmShowResource($film))
                ->response()
                ->setStatusCode(Response::HTTP_ACCEPTED);
        }
        $film = Film::create($request->all());


        if($request->cover)
        {
            $film->clearMediaCollection(Film::COVER_MEDIA_COLLECTION);
            $film->addMedia($request->cover)->toMediaCollection(Film::COVER_MEDIA_COLLECTION);
        }

        $film = Film::create($request->all());


        return (new FilmShowResource($film))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    public function show(Film $film)
    {
        // $this->checkGate('film_show');

        return new FilmShowResource($film->load('realisateurs', 'acteurs', 'categories', 'avis'));
    }


    public function update(UpdateFilmRequest $request, Film $film)
    {
        $film->update($request->all());

        if($request->cover)
        {
            $film->clearMediaCollection(Film::COVER_MEDIA_COLLECTION);
            $film->addMedia($request->cover)->toMediaCollection(Film::COVER_MEDIA_COLLECTION);
        }

        $film = Film::create($request->all());

        return (new FilmShowResource($film))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(film $film)
    {
        $this->checkGate('film_delete');

        $film->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
