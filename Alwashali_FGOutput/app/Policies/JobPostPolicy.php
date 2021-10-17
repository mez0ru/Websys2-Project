<?php

namespace App\Policies;

use App\Roles;
use App\Models\User;
use App\Models\JobPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(?User $user)
    {
        return $user->role === Roles::HIRER;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?User $user, JobPost $jobPost)
    {
        return $user->role === Roles::HIRER;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role === Roles::HIRER;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JobPost $jobPost)
    {
        return $user->role === Roles::HIRER && $user->id === $jobPost->hirer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, JobPost $jobPost)
    {
        return $user->role === Roles::HIRER && $user->id === $jobPost->hirer_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, JobPost $jobPost)
    {
        return $user->role === Roles::HIRER && $user->id === $jobPost->hirer_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, JobPost $jobPost)
    {
        return $user->role === Roles::HIRER && $user->id === $jobPost->hirer_id;
    }
}
