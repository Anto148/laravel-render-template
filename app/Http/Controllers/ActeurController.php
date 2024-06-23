<?php

namespace App\Http\Controllers;

use App\Models\Acteur;
use Illuminate\Http\Request;
use App\Http\Resources\Acteur\ActeurResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Acteur\StoreActeurRequest;
use App\Http\Requests\Acteur\UpdateActeurRequest;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class ActeurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        return ActeurResource::collection(Acteur::paginate($per_page));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActeurRequest $request)
    {
        $acteur = Acteur::create($request->all());

        return (new ActeurResource($acteur))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Acteur $acteur)
    {
        $this->checkGate('acteur_show');

        return new ActeurResource($acteur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActeurRequest $request, Acteur $acteur)
    {
        $acteur->update($request->all());

        return (new ActeurResource($acteur))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acteur $acteur)
    {
        $this->checkGate('acteur_destroy');

        $acteur->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
