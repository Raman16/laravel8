<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Models\BlogPost;
use App\Observers\BlogPostObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Blade::component('components.badge', 'badge');
        Blade::component('components.tags', 'tags');
        BlogPost::observe(BlogPostObserver::class);
        view()->composer(['posts.index','posts.show'],ActivityComposer::class);

    }
}
