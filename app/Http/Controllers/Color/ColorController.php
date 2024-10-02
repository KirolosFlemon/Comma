<?php

// app/Http/Controllers/ColorController.php
namespace App\Http\Controllers\Color;

use App\Http\Controllers\Controller;

use App\Http\Requests\Color\ColorRequest;
use App\Http\Resources\Color\ColorResource;
use App\Services\Color\ColorService;


class ColorController extends Controller
{
    protected $colorService;

    /**
     * Constructor for ColorController.
     *
     * @param ColorService $colorService The color service instance.
     * @throws None
     * @return None
     */
    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }
    /**
     * Retrieves a color by its ID.
     *
     * @param int $id The ID of the color to retrieve.
     * @throws None
     * @return ColorResource The color resource object.
     */
    public function get($id)
    {
        $colors = $this->colorService->getColorById($id);
        return new ColorResource($colors);
    }
    /**
     * Retrieves all colors using the color service.
     * 
     * @throws None
     * @return ColorResource The color resource object.
     */
    public function all(ColorRequest $request)
    {
        $colors = $this->colorService->getAllColors($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return ColorResource::collection($colors);
        }
        return ColorResource::collection($colors);
    }

    /**
     * Creates a new color using the provided ColorRequest object and returns a new ColorResource object.
     *
     * @param ColorRequest $request The ColorRequest object containing the data for the new color.
     * @throws None
     * @return ColorResource The newly created ColorResource object.
     */
    public function create(ColorRequest $request)
    {
        $color = $this->colorService->createColor($request);

        return new ColorResource($color);
    }


    /**
     * Updates a color using the provided ColorRequest object and returns a new ColorResource object.
     *
     * @param ColorRequest $request The ColorRequest object containing the data for the color update.
     * @param int $id The ID of the color to update.
     * @return ColorResource The updated ColorResource object.
     */
    public function update(ColorRequest $request, $id)
    {
        $color =  $this->colorService->updateColor($id, $request);
        return new ColorResource($color);
    }

    /**
     * Deletes a color by ID.
     *
     * @param int $id The ID of the color to delete.
     * @throws None
     * @return JSON The JSON response indicating the success of the deletion.
     */
    public function delete($id)
    {
        $this->colorService->deleteColor($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Color deleted successfully.',
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
        $color = $this->colorService->getSoftDeleted();
        return  ColorResource::collection($color);
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
        $this->colorService->restore($id);
        return response()->json([
            'data' => 'Color restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
