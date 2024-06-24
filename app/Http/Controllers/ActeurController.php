<?php

namespace App\Http\Controllers;

use App\Models\Acteur;
use Illuminate\Http\Request;
use App\Http\Resources\Acteur\ActeurResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Acteur\StoreActeurRequest;
use App\Http\Requests\Acteur\SearchActeurRequest;
use App\Http\Requests\Acteur\UpdateActeurRequest;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class ActeurController extends Controller
{

    public function index(Request $request)
    {
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        return ActeurResource::collection(Acteur::paginate($per_page));
    }

    public function search(SearchActeurRequest $request)
    {

        $nom = $request->nom;
        $prenom = $request->prenom;
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        $acteurs = Acteur::query()->orderByDesc('created_at');

        if($nom){

            $acteurs = $acteurs->where('nom', 'LIKE', '%'.$nom.'%');
        }

        if($prenom){
            $acteurs = $acteurs->where('prenom', 'LIKE', '%'.$prenom.'%');
        }

        return ActeurResource::collection($acteurs->paginate($per_page));
    }

    public function store(StoreActeurRequest $request)
    {
        $acteur = Acteur::create($request->all());

        return (new ActeurResource($acteur))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);

    }


    public function show(Acteur $acteur)
    {
        $this->checkGate('acteur_show');

        return new ActeurResource($acteur);
    }


    public function update(UpdateActeurRequest $request, Acteur $acteur)
    {
        $acteur->update($request->all());

        return (new ActeurResource($acteur))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }


    public function destroy(Acteur $acteur)
    {
        $this->checkGate('acteur_destroy');

        $acteur->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
