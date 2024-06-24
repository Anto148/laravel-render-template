<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
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
        $per_page = $request->per_page ?? 10;

        $films = Film::with(['realisateurs', 'acteurs', 'categories'])->orderByDesc('created_at');

        if($titre){

            $films = $films->where('titre', 'LIKE', '%'.$titre.'%');
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

        return new FilmShowResource($film);
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
