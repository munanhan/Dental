<?php

namespace App\Policies;

use App\Model\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /***
     * Determine whether the user can view the model.
     * @param User $user
     * @param User $model
     */
    public function view(User $user, User $model)
    {
        //
    }

    /***
     * Determine whether the user can create models.
     * @param User $user
     */
    public function create(User $user)
    {
        //
    }


    /***
     * Determine whether the user can update the model.
     * @param User $user
     * @param User $model
     */
    public function update(User $user, User $model)
    {
        //
    }


    /***
     * Determine whether the user can delete the model.
     * @param User $user
     * @param User $model
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /***
     * Determine whether the user can restore the model.
     * @param User $user
     * @param User $model
     */
    public function restore(User $user, User $model)
    {
        //
    }


    /***
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param User $model
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
