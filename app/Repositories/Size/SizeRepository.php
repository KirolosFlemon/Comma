<?php

namespace App\Repositories\Size;

use App\Models\Size;

class SizeRepository
{
    /**
     * Retrieves all sizes.
     *
     * @param bool $is_paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Size::paginate($is_paginate);
        }
        return Size::all();
    }

    /**
     * Creates a new size.
     *
     * @param array $request
     * @return Size
     */
    public function create($request)
    {
        return Size::create($request);
    }

    /**
     * Retrieves a size by its ID.
     *
     * @param int $id
     * @return Size
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($id)
    {
        return Size::findOrFail($id);
    }

    /**
     * Updates a size by its ID.
     *
     * @param int $id
     * @param array $request
     * @return Size
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($id, $request)
    {
        $size = $this->find($id);
        $size->update($request);
        return $size;
    }

    /**
     * Deletes a size by its ID.
     *
     * @param int $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete($id)
    {
        $size = $this->find($id);
        $size->delete();
    }
      /**
     * Retrieves soft deleted records from the size repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated size of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the size repository.
        // Only retrieves 15 records at a time.
        return Size::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted size.
     *
     * @param int $id The ID of the size to restore.
     * @throws ModelNotFoundException if the size with the given ID is not found.
     * @return bool Returns true if the size is successfully restored, false otherwise.
     */
    public function restore($id)
    {
        // Find the size with the given ID
        $size = Size::withTrashed()->findOrFail($id);

        // Restore the size and return the result
        return $size->restore();
    }
}

