<?php

// app/Http/Controllers/CityController.php
namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;

use App\Http\Requests\City\CityRequest;
use App\Http\Resources\City\CityResource;
use App\Services\City\CityService;


class CityController extends Controller
{
    protected $cityService;

    /**
     * Constructor for CityController class.
     *
     * @param CityService $cityService The city service instance
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }
    /**
     * Retrieves a specific city by its ID.
     *
     * @param int $id The ID of the city to retrieve.
     * @throws \Exception When there is an issue during retrieval
     * @return CityResource The resource representing the retrieved city
     */
    public function get($id)
    {
        $cities = $this->cityService->getCityById($id);
        return new CityResource($cities);
    }
    /**
     * Retrieves all cities based on the provided request.
     *
     * @param CityRequest $request The request containing parameters for city retrieval
     * @return CityResource A collection of cities
     */
    public function all(CityRequest $request)
    {
        $cities = $this->cityService->getAllCities($request->is_paginate ?? 0);
        if (isset($request->is_paginate ) && $request->is_paginate  != 0) {
            return CityResource::collection($cities);
        }
        return CityResource::collection($cities);
    }

    /**
     * Creates a new city based on the provided CityRequest.
     *
     * @param CityRequest $request The request containing the city data.
     * @return CityResource The resource representing the newly created city.
     */
    public function create(CityRequest $request)
    {
        $city = $this->cityService->createCity($request);

        return new CityResource($city);
    }


    /**
     * Updates a city based on the provided CityRequest and ID.
     *
     * @param CityRequest $request The request containing the city data.
     * @param mixed $id The ID of the city to update.
     * @return CityResource The resource representing the updated city.
     */
    public function update(CityRequest $request, $id)
    {
        $city =  $this->cityService->updateCity($id, $request);
        return new CityResource($city);
    }

    /**
     * Deletes a city by its ID.
     *
     * @param mixed $id The ID of the city to delete.
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function delete($id)
    {
        $this->cityService->deleteCity($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'City deleted successfully.',
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
         $city = $this->cityService->getSoftDeleted();
        return  CityResource::collection($city);
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
        $this->cityService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
