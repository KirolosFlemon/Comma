<?php

// app/Http/Controllers/SizeController.php
namespace App\Http\Controllers\Size;

use App\Http\Controllers\Controller;

use App\Http\Requests\Size\SizeRequest;
use App\Http\Resources\Size\SizeResource;
use App\Services\Size\SizeService;


class SizeController extends Controller
{
    protected $sizeService;

    /**
     * Constructs a new SizeController instance.
     *
     * @param SizeService $sizeService The size service to use.
     * @return void
     */
    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    /**
     * Retrieves a size by its ID.
     *
     * @param int $id The ID of the size.
     * @return SizeResource The size resource.
     */
    public function get($id)
    {
        $sizes = $this->sizeService->getSizeById($id);
        return new SizeResource($sizes);
    }

    /**
     * Retrieves all sizes.
     *
     * @return SizeResource The size resource.
     */
    public function all(SizeRequest $request)
    {
        $sizes = $this->sizeService->getAllSizes($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return SizeResource::collection($sizes);
        }
        return SizeResource::collection($sizes);
    }

    /**
     * Creates a new size.
     *
     * @param SizeRequest $request The size request.
     * @return SizeResource The size resource.
     */
    public function create(SizeRequest $request)
    {
        $size = $this->sizeService->createSize($request);
        
        return new SizeResource($size);
    }

    /**
     * Updates a size.
     *
     * @param SizeRequest $request The size request.
     * @param int $id The ID of the size.
     * @return SizeResource The size resource.
     */
    public function update(SizeRequest $request, $id)
    {
        $size =  $this->sizeService->updateSize($id, $request);
        return new SizeResource($size);
    }

    /**
     * Deletes a size.
     *
     * @param int $id The ID of the size.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function delete($id)
    {
        $this->sizeService->deleteSize($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Size deleted successfully.',
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
        $size = $this->sizeService->getSoftDeleted();
        return  SizeResource::collection($size);
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
        $this->sizeService->restore($id);
        return response()->json([
            'data' => 'Size restored successfully.',
            'Message' => 'success.',
        ], 200);
    }

}

