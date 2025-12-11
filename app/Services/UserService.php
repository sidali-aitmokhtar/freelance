<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Http\Requests\UserFilterRequest;
use App\Http\Resources\UserResource;

class UserService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly UserRepository $userRepository
    ){}

    //index
    public function getUsers(Request $request,UserFilter $fuser){
        $this->logwithcontext('Starting to fetch all users', [
            'operation' => 'getUsers',
            'requested_by' => $request->user()?->id
        ]);
        
        
        $users=$fuser->apply(User::query())->get();
        

        // $users = $this->userRepository->all();
        
        $this->loginfo('Successfully retrieved users', ['count' => $users->count()]);
        return UserResource::collection($users);
    }

    //show
    public function getUser(Request $request,$id){
        $this->logwithcontext('Starting to fetch user', [
            'operation' => 'getUser',
            'user_id' => $id,
            'requested_by' => $request->user()?->id
        ]);
        
        $user = $this->findUser($id);
        $this->validateAccess($request, $id);
        
        $this->loginfo('Successfully retrieved user', ['user_id' => $id]);
        return $user;
    }

    //store
    public function createUser($data){
        $this->logwithcontext('Starting user creation', [
            'operation' => 'createUser',
            'email' => $data['email'] ?? null
        ]);
        
        // Extract role from data before creating user
        $role = $data['role'] ?? null;
        unset($data['role']); // Remove role from user data


        $user = $this->userRepository->create($data);
        $user->assignRole($role);

        $this->loginfo('User created successfully', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);
        
        return $user;
    }

    //update
    public function updateUser(UserRequest $request,$id){
        $this->logwithcontext('Starting user update', [
            'operation' => 'updateUser',
            'user_id' => $id,
            'updated_by' => $request->user()?->id
        ]);
        
        $user = $this->findUser($id);
        $this->validateAccess($request, $id);
        
        $updated = $this->userRepository->update($request->validated(),$id);
        
        if(!$updated){
            $this->logerror('Failed to update user', ['user_id' => $id]);
            throw new Exception('Failed to update user', 500); // 500 signals an unexpected server failure during persistence
        }
        
        $user = $this->userRepository->find($id);
        
        $this->loginfo('User updated successfully', ['user_id' => $id]);
        return $user;
    }

    //destroy
    public function deleteUser($id,Request $request){
        $this->logwithcontext('Starting user deletion', [
            'operation' => 'deleteUser',
            'user_id' => $id,
            'deleted_by' => $request->user()?->id
        ]);

        $user = $this->findUser($id);
        $this->validateAccess($request, $id);
        
        $deleted = $this->userRepository->delete($id);
        
        if(!$deleted){
            $this->logerror('Failed to delete user', ['user_id' => $id]);
            throw new Exception('Failed to delete user', 500); // 500 clarifies that deletion failed because of a server-side issue
        }
        
        $this->loginfo('User deleted successfully', ['user_id' => $id]);
        return true;
    }

    private function findUser($id){
        $user = $this->userRepository->find($id);
        if(!$user){
            $this->logerror('User not found', ['user_id' => $id]);
            throw new Exception('User not found', 404);
        }
        return $user;
    }

    private function validateAccess($request,$id){
        $currentUser = $request->user();
        
        if(!$currentUser){
            $this->logerror('Unauthenticated access attempt', ['user_id' => $id]);
            throw new Exception('Unauthenticated', 401);
        }
        
        //if the user is admin
        if($currentUser->hasRole('admin')){
            $this->loginfo('Access granted: Admin role', ['admin_id' => $currentUser->id]);
            return;
        }
        
        //if the user is a freelancer or a client he can see his own only
        if($currentUser->hasAnyRole('freelancer','client') && $currentUser->id == $id){
            $this->loginfo('Access granted: Own profile', ['user_id' => $currentUser->id]);
            return;    
        }
        
        $this->logerror('Access denied: Insufficient permissions', [
            'user_id' => $currentUser->id,
            'target_user_id' => $id
        ]);
        throw new Exception('Access denied', 403);
    }
}


