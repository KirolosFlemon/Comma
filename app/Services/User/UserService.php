<?php
// app/Services/UserService.php
namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieves all useres with pagination if specified.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection The collection of useres.
     */
    public function getAllUsers($is_paginate)
    {
        return $this->userRepository->all($is_paginate);
    }

    /**
     * A description of the entire PHP function.
     * 
     * @param Request $request 
     * @throws \Exception if an error occurs during user creation
     * @return User The created user object.
     */
    public function createUser(Request $request)
    {
        try {
            DB::beginTransaction();

            $user =  $this->userRepository->create($request);
            // Commit the transaction if all operations are successful
            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $id description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function updateUser($id, $request)
    {
        try {

            DB::beginTransaction();

            $user = $this->userRepository->update($id, $request);

            // Commit the transaction if all operations are successful
            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $id description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function deleteUser($id)
    {
        $this->userRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the user repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->userRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted user by its ID.
     *
     * @param int $id The ID of the user to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the user repository
        // to restore the soft deleted user.
        return $this->userRepository->restore($id);
    }
}
