<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role;

class UserPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function approve(User $user, User $model)
    {
        return $this->notUserRole($user) && $model->hasVerifiedEmail() && !$model->approved_at && !$model->is_blocked;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function premote(User $user, User $model)
    {
        return $this->notSelf($user, $model) && !$this->isSuperUser($model) && $this->checkHigher($user, $model);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function demote(User $user, User $model)
    {
        return $this->notSelf($user, $model) && $this->notUserRole($model) && $this->checkHigher($user, $model);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function suspend(User $user, User $model)
    {
        return $this->notSelf($user, $model) &&  $this->checkHigher($user, $model);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function block(User $user, User $model)
    {
        return $this->notSelf($user, $model) && $this->checkHigher($user, $model);
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function unblock(User $user, User $model)
    {
        return $this->notSelf($user, $model) && $this->isSuperUser($user) && $model->is_blocked;
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    private function checkHigher(User $user, User $model)
    {
        return $user->role->id > $model->role->id && !$model->is_blocked;
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    private function notSelf(User $user, User $model)
    {
        return $user->id !== $model->id;
    }

    /**
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    private function notUserRole(User $user)
    {
        return $user->role->id !== Role::IS_USER;
    }
    

    /**
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    private function isSuperUser(User $user)
    {
        return $user->role->id === Role::IS_SUPERUSER;
    }
}
