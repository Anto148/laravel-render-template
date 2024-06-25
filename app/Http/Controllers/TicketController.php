<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Projection;
use Illuminate\Http\Request;
use App\Http\Resources\Ticket\TicketResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        return TicketResource::collection(Ticket::with(['user', 'projection'])->paginate($per_page));

    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->all());

        return (new TicketResource($ticket))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket->load(['user', 'projection']));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->all());

        return (new TicketResource($ticket))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function confirmPayment(Request $request)
    {
        $userId = $request->query('user_id');
        $projectionId = $request->query('projection_id');


        // Vérifie si la projection existe
        $projection = Projection::find($projectionId);
        if (!$projection) {
            return response()->json([
                'message' => 'Projection introuvable',
            ], Response::HTTP_NOT_FOUND);
        }

        // Vérifie si l'utilisateur existe
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur introuvable',
            ], Response::HTTP_NOT_FOUND);
        }

        // Crée le ticket
        $ticket = Ticket::create([
            'user_id' => $userId,
            'projection_id' => $projectionId,
        ]);

        // Retourne une page de confirmation
        return view('payment.paiement', ['ticket' => $ticket]);
    }


    public function destroy(Ticket $ticket)
    {
        $this->checkGate('ticket_delete');

        $ticket->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
