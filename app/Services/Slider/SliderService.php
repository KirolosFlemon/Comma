<?php
// app/Services/SliderService.php
namespace App\Services\Slider;

use App\Repositories\Slider\SliderRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderService
{
    protected $sliderRepository;

    /**
     * Constructs a new SliderService instance.
     *
     * @param SliderRepository $sliderRepository The slider repository to be injected.
     * @throws None
     * @return None
     */
    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * Retrieves all sliders with optional pagination.
     *
     * @param mixed $is_paginate Flag to determine pagination
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getAllSliders($is_paginate)
    {
        return $this->sliderRepository->all($is_paginate);
    }

    /**
     * Creates a new slider using the provided Request object and returns the created slider.
     *
     * @param Request $request The Request object containing the data for the new slider.
     * @throws Exception If an error occurs during slider creation.
     * @return Slider The newly created slider object.
     */
    public function createSlider(Request $request)
    {
        try {
            DB::beginTransaction();
            $slider =  $this->sliderRepository->create($request);
            // Commit the transaction if all operations are successful
            DB::commit();
            return $slider;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a specific collection by its ID.
     *
     * @param int $id The ID of the collection to retrieve.
     * @throws ModelNotFoundException if the collection with the given ID is not found.
     * @return Collection The collection object with the specified ID.
     */
    public function getSliderById($id)
    {
        return $this->sliderRepository->find($id);
    }

    /**
     * Updates a slider with the provided ID and Request object.
     *
     * @param mixed $id The ID of the slider to update.
     * @param Request $request The Request object containing the updated slider data.
     * @throws \Exception If an error occurs during slider update.
     * @return Slider The updated Slider object.
     */
    public function updateSlider($id, Request $request)
    {
        try {

            DB::beginTransaction();

            $slider = $this->sliderRepository->update($id, $request->except('images'));


            // Commit the transaction if all operations are successful
            DB::commit();
            return $slider;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Deletes a slider by ID.
     *
     * @param int $id The ID of the slider to delete.
     * @throws None
     * @return None
     */
    public function deleteSlider($id)
    {
        $this->sliderRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the slider repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->sliderRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted slider by its ID.
     *
     * @param int $id The ID of the slider to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the slider repository
        // to restore the soft deleted slider.
        return $this->sliderRepository->restore($id);
    }
}
