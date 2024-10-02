<?php

// app/Repositories/MaterialRepository.php
namespace App\Repositories\Material;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialRepository
{
    /**
     * Get all materials or paginate them.
     *
     * @param  mixed  $is_paginate
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Material::paginate($is_paginate);
        }
        return Material::all();
    }

    /**
     * Create a new material.
     *
     * @return \App\Models\Material The created material.
     */
    public function create(Request $request)
    {
        // Create a new material using the request data.
        // The create method returns the newly created material.
        return Material::create($request->all());
    }

    /**
     * Find a material by ID or throw an exception if it doesn't exist.
     *
     * @param  int  $id
     * @return \App\Models\Material
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($id)
    {
        return Material::findOrFail($id);
    }

    /**
     * Update a material by ID.
     *
     * @param  int  $id
     * @param  array  $request
     * @return \App\Models\Material
     */
    public function update($id, $request)
    {
        $material = $this->find($id);
        $material->update($request);
        return $material;
    }

    /**
     * Delete a material by ID.
     *
     * @param  int  $id
     * @return void
     */
    public function delete($id)
    {
        $material = $this->find($id);
        $material->delete();
    }

    /**
     * Retrieves soft deleted records from the material repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated material of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the material repository.
        // Only retrieves 15 records at a time.
        return Material::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted material.
     *
     * @param int $id The ID of the material to restore.
     * @throws ModelNotFoundException if the material with the given ID is not found.
     * @return bool Returns true if the material is successfully restored, false otherwise.
     */
    public function restore($id)
    {
        // Find the material with the given ID
        $material = Material::withTrashed()->findOrFail($id);

        // Restore the material and return the result
        return $material->restore();
    }
}
