<?php

namespace App\Policies;

use App\Roles;
use App\Models\User;
use App\Models\JobApplied;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobAppliedPolicy
{
    use HandlesAuthorization;

//     public function before(?User $user, $ability){
// // determine if user is candidate
// return optional($user)->role === Roles::CANDIDATE;
//     }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobApplied  $jobApplied
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, JobApplied $jobApplied)
    {
        return ($user->role === Roles::CANDIDATE && $user->id === $jobApplied->candidate_id)
        || ($user->role === Roles::HIRER && $user->id === $jobApplied->job->hirer_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role === Roles::CANDIDATE;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobApplied  $jobApplied
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JobApplied $jobApplied)
    {
        return ($user->role === Roles::CANDIDATE && $user->id === $jobApplied->candidate_id)
        || ($user->role === Roles::HIRER && $user->id === $jobApplied->job->hirer_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobApplied  $jobApplied
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, JobApplied $jobApplied)
    {
        return $user->role === Roles::CANDIDATE && $user->id === $jobApplied->candidate_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobApplied  $jobApplied
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, JobApplied $jobApplied)
    {
        return $user->role === Roles::CANDIDATE && $user->id === $jobApplied->candidate_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobApplied  $jobApplied
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, JobApplied $jobApplied)
    {
        return $user->role === Roles::CANDIDATE && $user->id === $jobApplied->candidate_id;
    }
}
