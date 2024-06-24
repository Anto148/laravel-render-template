<?php

namespace App\Http\Controllers;

use App\Models\Realisateur;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Realisateur\RealisateurResource;
use App\Http\Requests\Realisateur\StoreRealisateurRequest;
use App\Http\Requests\Realisateur\SearchRealisateurRequest;
use App\Http\Requests\Realisateur\UpdateRealisateurRequest;

class RealisateurController extends Controller
{
    public function index(Request $request)
    {
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        return RealisateurResource::collection(Realisateur::paginate($per_page));
    }

    public function search(SearchRealisateurRequest $request)
    {

        $nom = $request->nom;
        $prenom = $request->prenom;
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        $realisateurs = Realisateur::query()->orderByDesc('created_at');

        if($nom){

            $realisateurs = $realisateurs->where('nom', 'LIKE', '%'.$nom.'%');
        }

        if($prenom){
            $realisateurs = $realisateurs->where('prenom', 'LIKE', '%'.$request->prenom.'%');
        }

        return RealisateurResource::collection($realisateurs->paginate($per_page));
    }

    public function store(StoreRealisateurRequest $request)
    {
        $realisateur = Realisateur::create($request->all());

        return (new RealisateurResource($realisateur))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);

    }


    public function show(Realisateur $realisateur)
    {
        $this->checkGate('realisateur_show');

        return new RealisateurResource($realisateur);
    }


    public function update(UpdateRealisateurRequest $request, Realisateur $realisateur)
    {
        $realisateur->update($request->all());

        return (new RealisateurResource($realisateur))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }


    public function destroy(Realisateur $realisateur)
    {
        $this->checkGate('realisateur_destroy');

        $realisateur->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
