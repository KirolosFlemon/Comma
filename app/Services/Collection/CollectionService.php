<?php
// app/Services/CollectionService.php
namespace App\Services\Collection;

use App\Repositories\Collection\CollectionRepository;
use App\Traits\HelperFunctions;
use Illuminate\Support\Facades\DB;

class CollectionService
{
    protected $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getAllCollections($is_paginate)
    {
        return $this->collectionRepository->all($is_paginate);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function createCollection($request)
    {
        try {
            DB::beginTransaction();

            $collection =  $this->collectionRepository->create($request->except('images'));
            // Attach images to the collection
            if ($request->images) {
                foreach ($request->images as $image) {
                    $collection->images()->create(['image' => $image]);
                }
            }
            // Commit the transaction if all operations are successful
            DB::commit();
            return $collection->load('images');
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a collection by its ID.
     *
     * @param int $id The ID of the collection to retrieve.
     * @return Collection|null The collection object if found, null otherwise.
     */
    public function getCollectionById($id)
    {
        return $this->collectionRepository->find($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function updateCollection($id, $request)
    {
        try {

            DB::beginTransaction();

            $collection = $this->collectionRepository->update($id, $request->except(['images', 'slug']));
            $collection->images()->delete();

            if ($request->images) {
                foreach ($request->images as $image) {
                    $collection->images()->create(['image' => $image]);
                }
            }
            // Commit the transaction if all operations are successful
            DB::commit();
            return $collection;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Deletes a collection by its ID.
     *
     * @param int $id The ID of the collection to delete.
     * @return Some_Return_Value
     */
    public function deleteCollection($id)
    {
        $this->collectionRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the collection repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->collectionRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted collection by its ID.
     *
     * @param int $id The ID of the collection to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the collection repository
        // to restore the soft deleted collection.
            return $this->collectionRepository->restore($id);
    }
}
