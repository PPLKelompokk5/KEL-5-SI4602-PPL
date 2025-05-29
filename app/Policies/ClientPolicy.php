<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employee can view any models.
     */
    public function viewAny(Employee $employee): bool
    {
        return $employee->can('view_any_client');
    }

    /**
     * Determine whether the employee can view the model.
     */
    public function view(Employee $employee, Client $client): bool
    {
        return $employee->can('view_client');
    }

    /**
     * Determine whether the employee can create models.
     */
    public function create(Employee $employee): bool
    {
        return $employee->can('create_client');
    }

    /**
     * Determine whether the employee can update the model.
     */
    public function update(Employee $employee, Client $client): bool
    {
        return $employee->can('update_client');
    }

    /**
     * Determine whether the employee can delete the model.
     */
    public function delete(Employee $employee, Client $client): bool
    {
        return $employee->can('delete_client');
    }

    /**
     * Determine whether the employee can bulk delete.
     */
    public function deleteAny(Employee $employee): bool
    {
        return $employee->can('delete_any_client');
    }

    /**
     * Determine whether the employee can permanently delete.
     */
    public function forceDelete(Employee $employee, Client $client): bool
    {
        return $employee->can('force_delete_client');
    }

    /**
     * Determine whether the employee can permanently bulk delete.
     */
    public function forceDeleteAny(Employee $employee): bool
    {
        return $employee->can('force_delete_any_client');
    }

    /**
     * Determine whether the employee can restore.
     */
    public function restore(Employee $employee, Client $client): bool
    {
        return $employee->can('restore_client');
    }

    /**
     * Determine whether the employee can bulk restore.
     */
    public function restoreAny(Employee $employee): bool
    {
        return $employee->can('restore_any_client');
    }

    /**
     * Determine whether the employee can replicate.
     */
    public function replicate(Employee $employee, Client $client): bool
    {
        return $employee->can('replicate_client');
    }

    /**
     * Determine whether the employee can reorder.
     */
    public function reorder(Employee $employee): bool
    {
        return $employee->can('reorder_client');
    }
}
