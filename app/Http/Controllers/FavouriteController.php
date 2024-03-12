<?php

namespace App\Http\Controllers;

use App\Http\Requests\Favourite\StoreFavouriteRequest;
use App\Http\Requests\Favourite\UpdateFavouriteRequest;
use App\Http\Resources\Favourite\FavouriteResource;
use App\Models\Favourite;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    protected $favourite;
    public function __construct(Favourite $favourite)
    {
        $this->favourite = $favourite;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favourite = $this->favourite->paginate(5);
        $favouritesResource = FavouriteResource::collection($favourite)->response()->getData(true);
        return response()->json([
            'data' => $favouritesResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavouriteRequest $request)
    {
        $dataCreate = $request->all();
        $favourite = $this->favourite->create($dataCreate);
        $favouriteResource = new FavouriteResource($favourite);
        return response()->json([
            'data' => $favouriteResource,
        ], HttpResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavouriteRequest $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $favourite = $this->favourite->where('favourite_id', $id)->firstOrFail();
        $favourite->delete();
        $favouriteResource = new FavouriteResource($favourite);
        return response()->json([
            'data' => $favouriteResource,
        ], HttpResponse::HTTP_OK);
    }
}
