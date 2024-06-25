<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Projection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Projection\StoreProjectionRequest;
use App\Http\Requests\Projection\UpdateProjectionRequest;
use App\Http\Resources\Projection\ProjectionListResource;
use App\Http\Resources\Projection\ProjectionShowResource;

class ProjectionController extends Controller
{
    public function index(Request $request)
    {
        return ProjectionListResource::collection(
            $request->per_page
                ? Projection::with(['film', 'typeProjection'])->orderByDesc('date_projection')->paginate($request->per_page)
                : Projection::with(['film', 'typeProjection'])->orderByDesc('date_projection')->get()
        );
    }

    public function store(StoreProjectionRequest $request)
    {
        $date = new Carbon($request->date_projection);
        $heure = $request->heure_projection;

        // Vérifier s'il y a une projection prévue à la même date et heure
        if (Projection::where('date_projection', $date->toDateString())->where('heure_projection', $heure)->exists()) {
            return response()->json([
                'message' => 'Une projection a déjà été programmée pour cette heure',
                'errors' => [
                    'heure' => ['Une projection a déjà été programmée pour cette heure']
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $projection = Projection::create($request->all());

        return (new ProjectionShowResource($projection->load(['film', 'typeProjection'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Projection $projection)
    {
        return new ProjectionShowResource($projection->load(['film', 'typeProjection']));
    }

    public function update(UpdateProjectionRequest $request, Projection $projection)
    {
        // $this->checkGate('projection_delete');

        if ($request->date_projection && $request->heure_projection) {
        $date = new Carbon($request->date_projection);
        $heure = $request->heure_projection;

        // Vérifier s'il y a une projection prévue à la même date et heure
        if (Projection::where('date_projection', $date->toDateString())->where('heure_projection', $heure)->exists()) {
            return response()->json([
                'message' => 'Une projection a déjà été programmé pour cette heure',
                'errors' => [
                    'heure' => ['Une projection a déjà été programmé pour cette heure']
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    $projection->update($request->all());

    return (new ProjectionShowResource($projection->load(['film', 'typeProjection'])))
        ->response()
        ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Projection $projection)
    {
        $this->checkGate('projection_delete');

        $projection->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function projectionsDeLaSemaine()
    {
        $today = now();
        $startOfWeek = $today->startOfWeek()->addDays(1); // Commence le mardi
        $endOfWeek = $startOfWeek->copy()->addDays(5); // Se termine le dimanche

        // Fetch projections within the week grouped by day
        $projections = Projection::with(['film', 'salle', 'typeProjection'])
                                 ->whereBetween('date_projection', [$startOfWeek, $endOfWeek])
                                 ->orderBy('date_projection')
                                 ->get()
                                 ->groupBy(function($date) {
                                     return Carbon::parse($date->date_projection)->format('l'); // Group by day of the week
                                 });

        // Check for overlapping projections on the same day
        foreach ($projections as $day => $dayProjections) {
            $dayProjections->each(function ($projection) use ($dayProjections) {
                $overlaps = $dayProjections->filter(function ($otherProjection) use ($projection) {
                    return $projection->id !== $otherProjection->id &&
                           $projection->date_projection === $otherProjection->date_projection &&
                           $projection->heure_projection === $otherProjection->heure_projection;
                });
                if ($overlaps->isNotEmpty()) {
                    return response()->json([
                        'message' => 'Multiple projections scheduled at the same time on ' . $projection->date_projection,
                        'errors' => ['projection' => 'Overlapping projections detected']
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            });
        }

        return response()->json($projections);
    }
}
