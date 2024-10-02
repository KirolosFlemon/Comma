<?php
// app/Services/FavouriteService.php
namespace App\Services\Favourite;

use App\Repositories\Favourite\FavouriteRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouriteService
{
    protected $favouriteRepository;

    /**
     * Constructor for FavouriteService class.
     *
     * @param FavouriteRepository $favouriteRepository The favourite repository instance
     * @throws \Exception if an error occurs during instantiation
     * @return void
     */
    public function __construct(FavouriteRepository $favouriteRepository)
    {
        $this->favouriteRepository = $favouriteRepository;
    }

    /**
     * Retrieves all favourites based on pagination flag.
     *
     * @param mixed $is_paginate Flag to determine pagination
     * @return mixed Result of retrieving all favourites
     */
    public function getAllFavourites($is_paginate)
    {
        return $this->favouriteRepository->all($is_paginate);
    }

    /**
     * Create a new favourite with the provided request data.
     *
     * @throws \Exception if an error occurs during favourite creation
     * @return Favourite The newly created favourite with images loaded
     */
    public function createFavourite(Request $request)
    {

        try {
            DB::beginTransaction();

            $favourite = $this->favouriteRepository->create($request->all());
    
     

            DB::commit();
            return $favourite->load('user','product');
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a specific favourite by its ID.
     *
     * @param int $id The ID of the favourite to retrieve.
     * @throws ModelNotFoundException if the favourite with the given ID is not found.
     * @return Favourite The favourite object with the specified ID.
     */
    public function getFavouriteById($id)
    {
        return $this->favouriteRepository->find($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function updateFavourite($id, Request $request)
    {
        try {

            DB::beginTransaction();

            $favourite = $this->favouriteRepository->update($id,$request);
      
            // Commit the transaction if all operations are successful
            DB::commit();
            return $favourite;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function deleteFavourite($id)
    {
        $this->favouriteRepository->delete($id);
    }
    
    /**
     * Retrieves soft deleted records from the favourite repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->favouriteRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted favourite by its ID.
     *
     * @param int $id The ID of the favourite to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the favourite repository
        // to restore the soft deleted favourite.
        return $this->favouriteRepository->restore($id);
    }
}
