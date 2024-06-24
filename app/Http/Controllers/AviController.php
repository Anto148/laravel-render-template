<?php

namespace App\Http\Controllers;

use App\Models\Avi;
use Illuminate\Http\Request;
use App\Http\Resources\Avi\AviResource;
use App\Http\Requests\Avi\StoreAviRequest;
use App\Http\Requests\Avi\SearchAviRequest;
use App\Http\Requests\Avi\UpdateAviRequest;
use Symfony\Component\HttpFoundation\Response;

class AviController extends Controller
{

    public function index(Request $request)
    {
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        return AviResource::collection(Avi::paginate($per_page));
    }

    public function search(SearchAviRequest $request)
    {

        $commentaire = $request->commentaire;
        $film_id = $request->film_id;
        $client_id = $request->client_id;
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        $avis = Avi::query()->orderByDesc('created_at');

        if($commentaire){

            $avis = $avis->where('commentaire', 'LIKE', '%'.$commentaire.'%');
        }

        if($film_id){
            $avis = $avis->where('film_id', $film_id);
        }

        if($client_id){
            $avis = $avis->where('client_id', $client_id);
        }

        return AviResource::collection($avis->paginate($per_page));
    }

    public function store(StoreAviRequest $request)
    {
        $avi = Avi::create($request->all());

        return (new AviResource($avi))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);

    }


    public function show(Avi $avi)
    {
        $this->checkGate('avi_show');

        return new AviResource($avi);
    }


    public function update(UpdateAviRequest $request, Avi $avi)
    {
        $avi->update($request->all());

        return (new AviResource($avi))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }


    public function destroy(Avi $avi)
    {
        $this->checkGate('avi_destroy');

        $avi->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
