<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function viewAny(User $user)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Auth\Access\Response
     */
    public function view(User $user, Property $property)
    {
        return $user->id === $property->author_id || $user->hasAnyRole('admin', 'master')
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Auth\Access\Response
     */
    public function update(User $user, Property $property)
    {
        return $user->id === $property->author_id || $user->hasAnyRole('admin', 'master')
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Auth\Access\Response
     */
    public function delete(User $user, Property $property)
    {
        return $user->id === $property->author_id || $user->hasAnyRole('admin', 'master')
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Auth\Access\Response
     */
    public function restore(User $user, Property $property)
    {
        return $user->id === $property->author_id || $user->hasAnyRole('admin', 'master')
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Auth\Access\Response
     */
    public function forceDelete(User $user, Property $property)
    {
        return $user->id === $property->author_id || $user->hasAnyRole('admin', 'master')
            ? Response::allow()
            : Response::deny('private resource');
    }
}
