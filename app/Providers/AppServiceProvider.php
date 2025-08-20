<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::morphMap([
            'User' => \App\Models\User::class,
            'Applicant' => \App\Models\Applicant::class,
        ]);
        require_once app_path('Helpers/helpers.php');

        Blade::if('sadmin', function () {
            return auth()->check() && auth()->user()->role_id == 1;
        });
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role_id == 2;
        });
    }
}
