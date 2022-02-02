<?php
namespace App\Policies;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
class UserPolicy {
    use HandlesAuthorization;
    public function viewAny(User $user)    {
    }
    public function view(User $user, User $model)  {
        return true;
    }
    public function create(User $user)    {
        return false;

    }
    public function update(User $user, User $model)    {
        return $user->id ==$model->id;
    }
    public function delete(User $user, User $model)    {
        return false;
    }
    public function restore(User $user, User $model)    {
        return false;
    }
    public function forceDelete(User $user, User $model){
        return false;
    }
}
