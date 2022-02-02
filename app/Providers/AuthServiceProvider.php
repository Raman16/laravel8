<?php
namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy',
        'App\Models\User'=>'App\Policies\UserPolicy'
    ];
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('home.secret', function ($user) {
            return $user->is_admin; //only Admin can access the Gate 
        });
    }
}
