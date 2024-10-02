<?php

// app/Http/Controllers/FavouriteController.php
namespace App\Http\Controllers\Favourite;

use App\Http\Controllers\Controller;

use App\Http\Requests\Favourite\FavouriteRequest;
use App\Http\Resources\Favourite\FavouriteResource;
use App\Services\Favourite\FavouriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavouriteController extends Controller
{
    protected $favouriteService;

    /**
     * A constructor for the FavouriteController class.
     *
     * @param FavouriteService $favouriteService The favourite service instance to be injected.
     * @throws \Exception if an error occurs during instantiation
     * @return void
     */
    public function __construct(FavouriteService $favouriteService)
    {
        $this->favouriteService = $favouriteService;
    }

    /**
     * Retrieves a specific favourite by its ID.
     *
     * @param int $id The ID of the favourite to retrieve.
     * @return FavouriteResource The favourite resource object.
     */
    public function get($id)
    {
        $favourites = $this->favouriteService->getFavouriteById($id);
        return new FavouriteResource($favourites->load('user','product'));
    }
    
    /**
     * Retrieves all favourites using the favourite service.
     *
     * @return FavouriteResource
     */
    public function all(FavouriteRequest $request)
    {
        $favourites = $this->favouriteService->getAllFavourites($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {

            return FavouriteResource::collection($favourites);
        }
        return FavouriteResource::collection($favourites->load('user','product'));
    }

    /**
     * Creates a new favourite using the provided request.
     *
     * @param FavouriteRequest $request The request containing favourite information.
     * @return FavouriteResource The newly created favourite resource.
     */
    public function create(FavouriteRequest $request)
    {
        $favourite = $this->favouriteService->createFavourite($request);
        
        return new FavouriteResource($favourite);
    }


    /**
     * A description of the entire PHP function.
     *
     * @param FavouriteRequest $request description
     * @param $id description
     * @throws Some_Exception_Class description of exception
     * @return FavouriteResource description
     */
    public function update(FavouriteRequest $request, $id)
    {
        $favourite =  $this->favouriteService->updateFavourite($id, $request);
        return new FavouriteResource($favourite->load('images'));
    }

    /**
     * Deletes a favourite by its ID.
     *
     * @param int $id The ID of the favourite to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success.
     */
    public function delete($id)
    {
        $this->favouriteService->deleteFavourite($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Favourite deleted successfully.',
        ], 200);
    }

    
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
         $favourite = $this->favouriteService->getSoftDeleted();
        return  FavouriteResource::collection($favourite);
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function restore($id)
    {
        $this->favouriteService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }

    function test(Request $request) {
        Log::channel('daily')->info('test: ' .$request);
    }
}
