<?php

// app/Http/Controllers/SliderController.php
namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;

use App\Http\Requests\Slider\SliderRequest;
use App\Http\Resources\Slider\SliderResource;
use App\Services\Slider\SliderService;


class SliderController extends Controller
{
    protected $sliderService;

    /**
     * Constructor for SliderController.
     *
     * @param SliderService $sliderService The slider service instance.
     * @throws None
     * @return None
     */
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }
    /**
     * Retrieves a slider by its ID.
     *
     * @param int $id The ID of the slider to retrieve.
     * @throws None
     * @return SliderResource The slider resource object.
     */
    public function get($id)
    {
        $sliders = $this->sliderService->getSliderById($id);
        return new SliderResource($sliders);
    }
    /**
     * Retrieves all sliders using the slider service.
     * 
     * @throws None
     * @return SliderResource The slider resource object.
     */
    public function all(SliderRequest $request)
    {
        $sliders = $this->sliderService->getAllSliders($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return SliderResource::collection($sliders);
        }
        return SliderResource::slider($sliders);
    }

    /**
     * Creates a new slider using the provided SliderRequest object and returns a new SliderResource object.
     *
     * @param SliderRequest $request The SliderRequest object containing the data for the new slider.
     * @throws None
     * @return SliderResource The newly created SliderResource object.
     */
    public function create(SliderRequest $request)
    {
        $slider = $this->sliderService->createSlider($request);

        return new SliderResource($slider);
    }


    /**
     * Updates a slider using the provided SliderRequest object and returns a new SliderResource object.
     *
     * @param SliderRequest $request The SliderRequest object containing the data for the slider update.
     * @param int $id The ID of the slider to update.
     * @return SliderResource The updated SliderResource object.
     */
    public function update(SliderRequest $request, $id)
    {
        $slider =  $this->sliderService->updateSlider($id, $request);
        return new SliderResource($slider);
    }

    /**
     * Deletes a slider by ID.
     *
     * @param int $id The ID of the slider to delete.
     * @throws None
     * @return JSON The JSON response indicating the success of the deletion.
     */
    public function delete($id)
    {
        $this->sliderService->deleteSlider($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Slider deleted successfully.',
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
        $slider = $this->sliderService->getSoftDeleted();
        return  SliderResource::collection($slider);
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
        $this->sliderService->restore($id);
        return response()->json([
            'data' => 'Slider restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
