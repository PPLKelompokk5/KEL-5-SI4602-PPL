<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the User can view any models.
     */
    public function viewAny(Authenticatable $User): bool
    {
        return $User->can('view_any_client');
    }

    /**
     * Determine whether the User can view the model.
     */
    public function view(Authenticatable $User, Client $client): bool
    {
        return $User->can('view_client');
    }

    /**
     * Determine whether the User can create models.
     */
    public function create(Authenticatable $User): bool
    {
        return $User->can('create_client');
    }

    /**
     * Determine whether the User can update the model.
     */
    public function update(Authenticatable $User, Client $client): bool
    {
        return $User->can('update_client');
    }

    /**
     * Determine whether the User can delete the model.
     */
    public function delete(Authenticatable $User, Client $client): bool
    {
        return $User->can('delete_client');
    }

    /**
     * Determine whether the User can bulk delete.
     */
    public function deleteAny(Authenticatable $User): bool
    {
        return $User->can('delete_any_client');
    }

    /**
     * Determine whether the User can permanently delete.
     */
    public function forceDelete(Authenticatable $User, Client $client): bool
    {
        return $User->can('force_delete_client');
    }

    /**
     * Determine whether the User can permanently bulk delete.
     */
    public function forceDeleteAny(Authenticatable $User): bool
    {
        return $User->can('force_delete_any_client');
    }

    /**
     * Determine whether the User can restore.
     */
    public function restore(Authenticatable $User, Client $client): bool
    {
        return $User->can('restore_client');
    }

    /**
     * Determine whether the User can bulk restore.
     */
    public function restoreAny(Authenticatable $User): bool
    {
        return $User->can('restore_any_client');
    }

    /**
     * Determine whether the User can replicate.
     */
    public function replicate(Authenticatable $User, Client $client): bool
    {
        return $User->can('replicate_client');
    }

    /**
     * Determine whether the User can reorder.
     */
    public function reorder(Authenticatable $User): bool
    {
        return $User->can('reorder_client');
    }
}
