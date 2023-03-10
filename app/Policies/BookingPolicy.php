<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response
     */
    public function viewAny(User $user)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return Response
     */
    public function view(User $user, Booking $booking)
    {
        return $user->id === $booking->author_id || $user->id === $booking->property->author_id
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response
     */
    public function create(User $user)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return Response
     */
    public function update(User $user, Booking $booking)
    {
        return $user->hasRole('admin') || $user->id === $booking->author_id || $user->id === $booking->property->author_id
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return Response
     */
    public function delete(User $user, Booking $booking)
    {
        return $user->hasRole('admin') || $user->id === $booking->author_id || $user->id === $booking->property->author_id
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return Response
     */
    public function restore(User $user, Booking $booking)
    {
        return $user->hasRole('admin') || $user->id === $booking->author_id || $user->id === $booking->property->author_id
            ? Response::allow()
            : Response::deny('private resource');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Booking $booking
     * @return Response
     */
    public function forceDelete(User $user, Booking $booking)
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('private resource');
    }
}
