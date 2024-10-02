<?php

namespace App\Http\Controllers\Material;

use App\Http\Controllers\Controller;
use App\Http\Requests\Material\MaterialRequest;
use App\Http\Resources\Material\MaterialResource;
use App\Services\Material\MaterialService;

/**
 * Class MaterialController
 *
 * The controller for handling the materials.
 */
class MaterialController extends Controller
{
    /**
     * @var MaterialService The material service instance.
     */
    protected $materialService;

    /**
     * Constructor function for MaterialController.
     *
     * @param MaterialService $materialService The material service instance.
     */
    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    /**
     * Get a material by ID.
     *
     * @param int $id The ID of the material.
     * @return MaterialResource The material resource.
     */
    public function get($id)
    {
        $material = $this->materialService->getMaterialById($id);
        return new MaterialResource($material);
    }

    /**
     * Get all materials.
     *
     * @return MaterialResource The material resource.
     */
    public function all(MaterialRequest $request)
    {
        $materials = $this->materialService->getAllMaterials($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return MaterialResource::collection($materials);
        }
        return MaterialResource::collection($materials);
    }

    /**
     * Create a new material.
     *
     * @param MaterialRequest $request The material request.
     * @return MaterialResource The material resource.
     */
    public function create(MaterialRequest $request)
    {
        $material = $this->materialService->createMaterial($request);
        return new MaterialResource($material);
    }

    /**
     * Update a material.
     *
     * @param MaterialRequest $request The material request.
     * @param int $id The ID of the material.
     * @return MaterialResource The material resource.
     */
    public function update(MaterialRequest $request, $id)
    {
        $material = $this->materialService->updateMaterial($id, $request);
        return new MaterialResource($material);
    }

    /**
     * Delete a material.
     *
     * @param int $id The ID of the material.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function delete($id)
    {
        $this->materialService->deleteMaterial($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Material deleted successfully.',
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
        $material = $this->materialService->getSoftDeleted();
        return  MaterialResource::collection($material);
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
        $this->materialService->restore($id);
        return response()->json([
            'data' => 'Material restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}

