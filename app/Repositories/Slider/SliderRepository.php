<?php

// app/Repositories/SliderRepository.php
namespace App\Repositories\Slider;

use App\Models\Slider;

class SliderRepository
{
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Slider::paginate($is_paginate);
        }
        return Slider::all();
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function create($request)
    {

        return Slider::create($request->all());
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function find($id)
    {
        return Slider::findOrFail($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function update($id, $request)
    {
        $slider = $this->find($id);
        $slider->update($request);
        return $slider;
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function delete($id)
    {
        $slider = $this->find($id);
        $slider->delete();
    }

     /**
     * Retrieves soft deleted records from the slider repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated slider of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the slider repository.
        // Only retrieves 15 records at a time.
        return Slider::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted slider.
     *
     * @param int $id The ID of the slider to restore.
     * @throws ModelNotFoundException if the slider with the given ID is not found.
     * @return bool Returns true if the slider is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the slider with the given ID
     $slider = Slider::withTrashed()->findOrFail($id);
    
     // Restore the slider and return the result
     return $slider->restore();
    }
}
