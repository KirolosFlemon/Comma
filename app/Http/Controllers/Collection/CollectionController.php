<?php

// app/Http/Controllers/CollectionController.php
namespace App\Http\Controllers\Collection;

use App\Http\Controllers\Controller;

use App\Http\Requests\Collection\CollectionRequest;
use App\Http\Resources\Collection\CollectionResource;
use App\Services\Collection\CollectionService;


class CollectionController extends Controller
{
    protected $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }
    public function get($id)
    {
        $collections = $this->collectionService->getCollectionById($id);
        return new CollectionResource($collections->load('images'));
    }
    /**
     * A description of the entire PHP function.
     *
     * @param CollectionRequest $request description
     * @throws Some_Exception_Class description of exception
     * @return CollectionResource
     */
    public function all(CollectionRequest $request)
    {
        $collections = $this->collectionService->getAllCollections($request->is_paginate ?? 0);
        if (isset($request->is_paginate ) && $request->is_paginate  != 0) {
            return CollectionResource::collection($collections);
        }
        return CollectionResource::collection($collections);
    }

    public function create(CollectionRequest $request)
    {
        $collection = $this->collectionService->createCollection($request);
        
        return new CollectionResource($collection);
    }


    public function update(CollectionRequest $request, $id)
    {
        $collection =  $this->collectionService->updateCollection($id, $request);
        return new CollectionResource($collection->load('images'));
    }

    /**
     * Deletes a collection by its ID.
     *
     * @param int $id The ID of the collection to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response with a success message and data.
     */
    public function delete($id)
    {
        $this->collectionService->deleteCollection($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Collection deleted successfully.',
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
         $collection = $this->collectionService->getSoftDeleted();
        return  CollectionResource::collection($collection);
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
        $this->collectionService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
