<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\Client\ClientResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $this->checkGate('client_access');

        return ClientResource::collection($request->per_page ? Client::paginate($request->per_page) : Client::with(['user'])->get());
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

        return new ClientResource($client->load(['user']));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {

        $client->update($request->all());

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
