<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Contract;
use App\Models\Bid;
use Illuminate\Auth\Access\Response;

class ContractPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contract $contract): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user,Project $project,Bid $bid): Response
    {
        //to accept a if you have to

        //1-be the owner of the project
        if($user->id!=$project->client_id){
            return Response::deny('you are not the owner of this project');
        }

        //2-to have at least two bids on it
        if(Bid::where('project_id',$project->id)->count()<2){
            return Response::deny('you have to get at least two bids');
        }

        //3-to have the amount of money in the bid
        if($user->money<$bid->bid){
            return Response::deny('you do not have the amount of money required');
        }



        return Response::allow('nice');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contract $contract): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contract $contract): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contract $contract): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contract $contract): bool
    {
        return false;
    }
}
