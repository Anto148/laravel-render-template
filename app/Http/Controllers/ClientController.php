<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $this->checkGate('client_access');

        return ClientResource::collection($request->per_page ? Client::paginate($request->per_page) : Client::with(['categorie', 'devise', 'mode_reglement', 'adresse_facturation', 'adresse_livraison', 'user', 'origine', 'mode_facturation'])->get());
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->all());

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Client $client)
    {
        $this->checkGate('client_show');

        return new ClientResource($client->load(['categorie', 'devise', 'mode_reglement', 'adresse_facturation', 'adresse_livraison', 'user', 'origine', 'mode_facturation']));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {

        $client->update($request->all());
        // dd($request->all());

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Client $client)
    {
        $this->checkGate('client_delete');

        $client->delete();

        return response('Suppression effectuee', Response::HTTP_NO_CONTENT);
    }
}
