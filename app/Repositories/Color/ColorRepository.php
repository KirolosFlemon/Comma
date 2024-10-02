<?php

// app/Repositories/ColorRepository.php
namespace App\Repositories\Color;

use App\Models\Color;

class ColorRepository
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
            return Color::paginate($is_paginate);
        }
        return Color::all();
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

        return Color::create($request->all());
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
        return Color::findOrFail($id);
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
        $color = $this->find($id);
        $color->update($request);
        return $color;
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
        $color = $this->find($id);
        $color->delete();
    }

     /**
     * Retrieves soft deleted records from the color repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated color of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the color repository.
        // Only retrieves 15 records at a time.
        return Color::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted color.
     *
     * @param int $id The ID of the color to restore.
     * @throws ModelNotFoundException if the color with the given ID is not found.
     * @return bool Returns true if the color is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the color with the given ID
     $color = Color::withTrashed()->findOrFail($id);
    
     // Restore the color and return the result
     return $color->restore();
    }
}
