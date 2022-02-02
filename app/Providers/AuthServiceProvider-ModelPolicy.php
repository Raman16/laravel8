<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
         'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // // Gate::define('posts.update','App\Policies\BlogPostPolicy@update');
        // // Gate::define('posts.delete','App\Policies\BlogPostPolicy@delete');
        // Gate::resource('posts', 'App\Policies\BlogPostPolicy');
    }
}
