<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type_projection;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TypeProjection\TypeProjectionResource;
use App\Http\Requests\TypeProjection\StoreTypeProjectionRequest;
use App\Http\Requests\TypeProjection\SearchTypeProjectionRequest;
use App\Http\Requests\TypeProjection\UpdateTypeProjectionRequest;

class TypeProjectionController extends Controller
{

    public function index(Request $request)
    {
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        return TypeProjectionResource::collection(Type_projection::paginate($per_page));

    }

    public function search(SearchTypeProjectionRequest $request){

        $nom = $request->nom;
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        $type_projections = Type_projection::query()->orderByDesc('created_at');

        if($nom){

            $type_projections = $type_projections->where('nom', 'LIKE', '%'.$nom.'%');
        }

        return TypeProjectionResource::collection($type_projections->paginate($per_page));
    }


    public function store(StoreTypeProjectionRequest $request)
    {
        $type_projection = Type_projection::create($request->all());

        return (new TypeProjectionResource($type_projection))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    public function show(Type_projection $type_projection)
    {
        // $this->checkGate('type_projection_show');

        return new TypeProjectionResource($type_projection);
    }


    public function update(UpdateTypeProjectionRequest $request, Type_projection $type_projection)
    {
        $type_projection->update($request->all());

        return (new TypeProjectionResource($type_projection))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type_projection $type_projection)
    {
        $this->checkGate('type_projection_delete');

        $type_projection->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
