<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Categorie\CategorieResource;
use App\Http\Requests\Categorie\StoreCategorieRequest;
use App\Http\Requests\Categorie\SearchCategorieRequest;
use App\Http\Requests\Categorie\UpdateCategorieRequest;

class CategorieController extends Controller
{

    public function index(Request $request)
    {
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        return CategorieResource::collection(Categorie::paginate($per_page));

    }

    public function search(SearchCategorieRequest $request){

        $titre = $request->titre;
        $per_page = ($request->per_page > 100) ? 10 : $request->per_page;

        $categories = Categorie::query()->orderByDesc('created_at');

        if($titre){

            $categories = $categories->where('titre', 'LIKE', '%'.$titre.'%');
        }

        return CategorieResource::collection($categories->paginate($per_page));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieRequest $request)
    {
        $categorie = Categorie::create($request->all());

        return (new CategorieResource($categorie))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        $this->checkGate('categorie_show');

        return new CategorieResource($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        $categorie->update($request->all());

        return (new CategorieResource($categorie))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        $this->checkGate('categorie_delete');

        $categorie->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
