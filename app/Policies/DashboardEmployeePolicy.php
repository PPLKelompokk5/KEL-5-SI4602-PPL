<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

class DashboardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the User can view any models.
     */
    public function viewAny(Authenticatable $User): bool
    {
        // var_dump($User);
        return $User->can('view_any');
    }

    /**
     * Determine whether the User can view the model.
     */
    public function view(Authenticatable $User, Employee $employee): bool
    {
        return $User->can('view_employee');
    }

    /**
     * Determine whether the User can create models.
     */
    public function create(Authenticatable $User): bool
    {
        return $User->can('create_dashboard');
    }

    /**
     * Determine whether the User can update the model.
     */
    public function update(Authenticatable $User, Employee $employee): bool
    {
        return $User->can('update_dashboard');
    }

    /**
     * Determine whether the User can delete the model.
     */
    public function delete(Authenticatable $User, Employee $employee): bool
    {
        return $User->can('delete_dashboard');
    }

    /**
     * Determine whether the User can bulk delete.
     */
    public function deleteAny(Authenticatable $User): bool
    {
        return $User->can('delete_any_dashboard');
    }

    /**
     * Determine whether the User can permanently delete.
     */
    public function forceDelete(Authenticatable $User, Employee $employee): bool
    {
        return $User->can('force_delete_dashboard');
    }

    /**
     * Determine whether the User can permanently bulk delete.
     */
    public function forceDeleteAny(Authenticatable $User): bool
    {
        return $User->can('force_delete_any_dashboard');
    }

    /**
     * Determine whether the User can restore.
     */
    public function restore(Authenticatable $User, Employee $employee): bool
    {
        return $User->can('restore_dashboard');
    }

    /**
     * Determine whether the User can bulk restore.
     */
    public function restoreAny(Authenticatable $User): bool
    {
        return $User->can('restore_any_dashboard');
    }

    /**
     * Determine whether the User can replicate.
     */
    public function replicate(Authenticatable $User, Employee $employee): bool
    {
        return $User->can('replicate_dashboard');
    }

    /**
     * Determine whether the User can reorder.
     */
    public function reorder(Authenticatable $User): bool
    {
        return $User->can('reorder_dashboard');
    }
}
