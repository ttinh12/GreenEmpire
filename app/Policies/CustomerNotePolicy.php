<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CustomerNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerNotePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CustomerNote');
    }

    public function view(AuthUser $authUser, CustomerNote $customerNote): bool
    {
        return $authUser->can('View:CustomerNote');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CustomerNote');
    }

    public function update(AuthUser $authUser, CustomerNote $customerNote): bool
    {
        return $authUser->can('Update:CustomerNote');
    }

    public function delete(AuthUser $authUser, CustomerNote $customerNote): bool
    {
        return $authUser->can('Delete:CustomerNote');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CustomerNote');
    }

    public function restore(AuthUser $authUser, CustomerNote $customerNote): bool
    {
        return $authUser->can('Restore:CustomerNote');
    }

    public function forceDelete(AuthUser $authUser, CustomerNote $customerNote): bool
    {
        return $authUser->can('ForceDelete:CustomerNote');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CustomerNote');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CustomerNote');
    }

    public function replicate(AuthUser $authUser, CustomerNote $customerNote): bool
    {
        return $authUser->can('Replicate:CustomerNote');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CustomerNote');
    }

}